<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SellerMessageController extends Controller
{
    /**
     * Get the active seller for this session.
     */
    protected function getEffectiveSeller(): ?Seller
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        if ($user->seller) {
            return $user->seller;
        }

        // Fallback for Super Admin viewing seller area
        return Seller::first();
    }

    /**
     * Display seller messages interface.
     */
    public function index(Request $request): View|JsonResponse
    {
        $seller = $this->getEffectiveSeller();
        if (!$seller) {
            abort(403, 'Seller profile not found.');
        }

        // Auto-seed if this seller has no conversations
        if (Conversation::where('seller_id', $seller->id)->count() === 0) {
            (new \Database\Seeders\ChatMessagesSeeder())->run();
        }

        $tab = $request->query('tab', 'all');
        $search = $request->query('search');

        $counts = [
            'all' => Conversation::where('seller_id', $seller->id)->count(),
            'orders' => Conversation::where('seller_id', $seller->id)->where('category', 'orders')->count(),
            'inquiries' => Conversation::where('seller_id', $seller->id)->where('category', 'inquiries')->count(),
            'support' => Conversation::where('seller_id', $seller->id)->where('category', 'support')->count(),
            'unread' => Conversation::where('seller_id', $seller->id)->sum('unread_count'),
        ];

        $query = Conversation::where('seller_id', $seller->id);

        if ($tab === 'orders') {
            $query->where('category', 'orders');
        } elseif ($tab === 'inquiries') {
            $query->where('category', 'inquiries');
        } elseif ($tab === 'support') {
            $query->where('category', 'support');
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('subject_title', 'like', "%{$search}%")
                  ->orWhere('last_message', 'like', "%{$search}%");
            });
        }

        // Rimsha Khan first by default, then latest messages
        $conversations = $query->orderByRaw("CASE WHEN customer_name LIKE '%Rimsha%' THEN 0 ELSE 1 END")
                               ->orderByDesc('last_message_at')
                               ->get();

        $activeConversationId = $request->query('conversation_id');
        if ($activeConversationId) {
            $activeConversation = Conversation::where('seller_id', $seller->id)
                ->where('id', $activeConversationId)
                ->first();
        } else {
            $activeConversation = $conversations->first() ?? Conversation::where('seller_id', $seller->id)->first();
        }

        $messages = $activeConversation ? $activeConversation->messages : collect();

        if ($request->wantsJson()) {
            return response()->json([
                'conversations' => $conversations,
                'activeConversation' => $activeConversation,
                'messages' => $messages,
                'counts' => $counts,
            ]);
        }

        return view('seller.messages.index', [
            'seller' => $seller,
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'messages' => $messages,
            'currentTab' => $tab,
            'counts' => $counts,
            'search' => $search,
        ]);
    }

    /**
     * Send a new message in a conversation.
     */
    public function send(Request $request, Conversation $conversation): RedirectResponse|JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $seller = $this->getEffectiveSeller();
        if (!$seller || $conversation->seller_id !== $seller->id) {
            abort(403, 'Unauthorized conversation action.');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'seller',
            'sender_id' => $seller->id,
            'sender_name' => $seller->store_name,
            'message' => $request->message,
            'is_read' => true,
        ]);

        $conversation->update([
            'last_message' => $request->message,
            'last_message_at' => now(),
            'total_messages' => $conversation->messages()->count(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'conversation' => $conversation->fresh(),
            ]);
        }

        return redirect()->route('seller.messages.index', [
            'conversation_id' => $conversation->id,
            'tab' => $request->input('tab', 'all'),
        ])->with('success', 'Message sent successfully.');
    }

    /**
     * Trigger a quick action (Send Brochure, Share Coupon, etc.).
     */
    public function quickAction(Request $request, Conversation $conversation): JsonResponse|RedirectResponse
    {
        $request->validate([
            'action' => 'required|string|in:brochure,coupon,custom_offer,order_status',
        ]);

        $seller = $this->getEffectiveSeller();
        if (!$seller || $conversation->seller_id !== $seller->id) {
            abort(403, 'Unauthorized quick action.');
        }

        $action = $request->action;
        $content = '';
        $attachmentUrl = null;
        $attachmentType = null;

        switch ($action) {
            case 'brochure':
                $content = "📄 **Course Brochure & Syllabus Shared**\nHere is the complete syllabus and curriculum guide for **" . $conversation->subject_title . "**.\nIncludes syllabus, batch schedules, certification details, and faculty background.";
                $attachmentUrl = '/assets/brochures/course-syllabus.pdf';
                $attachmentType = 'pdf';
                break;
            case 'coupon':
                $content = "🏷️ **Special Discount Coupon!**\nUse coupon code **DIGITAL10** to get an instant **10% OFF** during checkout on **" . $conversation->subject_title . "**.\nValid for the next 48 hours only!";
                $attachmentType = 'coupon';
                break;
            case 'custom_offer':
                $content = "🎁 **Custom Offer Created!**\nSpecial bundle package for **" . $conversation->subject_title . "** + 1-on-1 mentorship session for ₹2,699 (Regular ₹2,999).\nClick to accept and proceed to secure checkout.";
                $attachmentType = 'offer';
                break;
            case 'order_status':
                $content = "📦 **Order Status Update**\nYour order for **" . $conversation->subject_title . "** is active and in progress. Access keys and download links are ready in your account.";
                $attachmentType = 'order';
                break;
        }

        $msg = Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'seller',
            'sender_id' => $seller->id,
            'sender_name' => $seller->store_name,
            'message' => $content,
            'attachment_url' => $attachmentUrl,
            'attachment_type' => $attachmentType,
            'is_read' => true,
        ]);

        $conversation->update([
            'last_message' => $content,
            'last_message_at' => now(),
            'total_messages' => $conversation->messages()->count(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return back()->with('success', 'Action completed.');
    }
}

