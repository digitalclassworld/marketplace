<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMessageController extends Controller
{
    /**
     * Display all customer-seller conversations for Super Admin monitoring.
     */
    public function index(Request $request): View|JsonResponse
    {
        $sellerFilter = $request->query('seller_id');
        $categoryFilter = $request->query('category');
        $search = $request->query('search');

        $sellers = Seller::with(['user', 'businessDetail'])->orderBy('id')->get();

        $query = Conversation::with(['seller.user', 'seller.businessDetail', 'messages'])
            ->orderByDesc('last_message_at');

        if ($sellerFilter) {
            $query->where('seller_id', $sellerFilter);
        }

        if ($categoryFilter && $categoryFilter !== 'all') {
            $query->where('category', $categoryFilter);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('subject_title', 'like', "%{$search}%")
                  ->orWhere('last_message', 'like', "%{$search}%")
                  ->orWhereHas('seller.user', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('seller.businessDetail', function ($sq) use ($search) {
                      $sq->where('business_name', 'like', "%{$search}%");
                  });
            });
        }

        $conversations = $query->paginate(20)->withQueryString();

        $activeConversationId = $request->query('conversation_id');
        if ($activeConversationId) {
            $activeConversation = Conversation::with(['seller.user', 'messages'])->find($activeConversationId);
        } else {
            $activeConversation = $conversations->first();
        }

        $stats = [
            'total_conversations' => Conversation::count(),
            'total_messages'      => Message::count(),
            'active_sellers'      => Conversation::distinct('seller_id')->count('seller_id'),
            'inquiries_count'     => Conversation::where('category', 'inquiries')->count(),
            'orders_count'        => Conversation::where('category', 'orders')->count(),
            'support_count'       => Conversation::where('category', 'support')->count(),
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'conversations' => $conversations,
                'activeConversation' => $activeConversation,
                'stats' => $stats,
            ]);
        }

        return view('admin.messages.index', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'sellers' => $sellers,
            'stats' => $stats,
            'selectedSellerId' => $sellerFilter,
            'selectedCategory' => $categoryFilter ?? 'all',
            'search' => $search,
        ]);
    }

    /**
     * Show a single conversation's messages and metadata.
     */
    public function show(Conversation $conversation): View|JsonResponse
    {
        $conversation->load(['seller.user', 'messages']);

        if (request()->wantsJson()) {
            return response()->json([
                'conversation' => $conversation,
                'messages' => $conversation->messages,
            ]);
        }

        return redirect()->route('admin.messages.index', ['conversation_id' => $conversation->id]);
    }

    /**
     * Post a Super Admin Moderation Notice to the conversation.
     */
    public function postModerationNote(Request $request, Conversation $conversation): RedirectResponse
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'admin',
            'sender_name' => 'Marketplace Super Admin',
            'message' => '🛡️ [Super Admin Moderator Notice]: ' . $request->note,
            'is_read' => true,
        ]);

        $conversation->update([
            'last_message' => '🛡️ Admin Note: ' . $request->note,
            'last_message_at' => now(),
            'total_messages' => $conversation->messages()->count(),
        ]);

        return back()->with('success', 'Moderation notice posted to conversation.');
    }
}
