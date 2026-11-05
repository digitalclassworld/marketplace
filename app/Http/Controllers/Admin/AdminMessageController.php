<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Seller;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMessageController extends Controller
{
    /**
     * Display Messages & Support hub matching screenshot pixel-for-pixel.
     */
    public function index(Request $request): View|JsonResponse
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search');
        $category = $request->query('category');
        $source = $request->query('source');
        $priority = $request->query('priority');
        $assignedTo = $request->query('assigned_to');
        $unreadOnly = $request->query('unread') === '1';
        $activeTicketId = $request->query('ticket_id');

        $showDummy = config('marketplace.show_dummy_data', app()->environment('local', 'testing'));

        $query = SupportTicket::with('messages')->latest('last_message_at');

        // Apply Tab Filter
        if ($tab === 'open') {
            $query->where('status', 'Open');
        } elseif ($tab === 'in_progress') {
            $query->where('status', 'In Progress');
        } elseif ($tab === 'waiting') {
            $query->where('status', 'Waiting');
        } elseif ($tab === 'resolved') {
            $query->where('status', 'Resolved');
        } elseif ($tab === 'spam') {
            $query->where('status', 'Spam');
        }

        // Search Filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('ticket_number', 'like', "%{$search}%")
                  ->orWhere('last_message', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if (!empty($category)) {
            $query->where('category', $category);
        }

        // Source Filter
        if (!empty($source)) {
            $query->where('source', $source);
        }

        // Priority Filter
        if (!empty($priority)) {
            $query->where('priority', $priority);
        }

        // Assigned To Filter
        if (!empty($assignedTo)) {
            $query->where('assigned_to', $assignedTo);
        }

        // Unread Only Filter
        if ($unreadOnly) {
            $query->where('is_unread', true);
        }

        $dbTickets = $query->get();

        // If local/testing and DB is empty, auto-seed or supply curated tickets
        if ($showDummy && SupportTicket::count() === 0) {
            (new \Database\Seeders\SupportTicketSeeder())->run();
            $dbTickets = $query->get();
        }

        // Fallback for non-dummy empty mode on production
        if (!$showDummy && SupportTicket::count() === 0) {
            $tickets = collect();
        } else {
            $tickets = $dbTickets;
        }

        // Counts calculation
        if ($showDummy) {
            $totalCount      = 1240;
            $openCount       = 180;
            $inProgressCount = 320;
            $waitingCount    = 160;
            $resolvedCount   = 540;
            $spamCount       = 40;
            $unreadCount     = 32;

            $stats = [
                'total_conversations' => '1,240',
                'conversations_growth'=> '+18%',
                'conversations_sub'   => '+210 this month',
                'open_tickets'        => '180',
                'open_sub'            => '15% of total',
                'in_progress'         => '320',
                'in_progress_sub'     => '26% of total',
                'waiting'             => '160',
                'waiting_sub'         => '13% of total',
                'resolved'            => '540',
                'resolved_sub'        => '44% of total',
                'avg_response_time'   => '2.4 hrs',
                'response_growth'     => '+35%',
                'response_sub'        => 'Last 30 days',
            ];
        } else {
            $totalCount      = SupportTicket::count();
            $openCount       = SupportTicket::where('status', 'Open')->count();
            $inProgressCount = SupportTicket::where('status', 'In Progress')->count();
            $waitingCount    = SupportTicket::where('status', 'Waiting')->count();
            $resolvedCount   = SupportTicket::where('status', 'Resolved')->count();
            $spamCount       = SupportTicket::where('status', 'Spam')->count();
            $unreadCount     = SupportTicket::where('is_unread', true)->count();

            $stats = [
                'total_conversations' => number_format($totalCount),
                'conversations_growth'=> '+0%',
                'conversations_sub'   => '+' . SupportTicket::where('created_at', '>=', now()->startOfMonth())->count() . ' this month',
                'open_tickets'        => number_format($openCount),
                'open_sub'            => $totalCount > 0 ? round(($openCount / $totalCount) * 100) . '% of total' : '0% of total',
                'in_progress'         => number_format($inProgressCount),
                'in_progress_sub'     => $totalCount > 0 ? round(($inProgressCount / $totalCount) * 100) . '% of total' : '0% of total',
                'waiting'             => number_format($waitingCount),
                'waiting_sub'         => $totalCount > 0 ? round(($waitingCount / $totalCount) * 100) . '% of total' : '0% of total',
                'resolved'            => number_format($resolvedCount),
                'resolved_sub'        => $totalCount > 0 ? round(($resolvedCount / $totalCount) * 100) . '% of total' : '0% of total',
                'avg_response_time'   => '1.5 hrs',
                'response_growth'     => '+10%',
                'response_sub'        => 'Last 30 days',
            ];
        }

        $counts = [
            'all'         => $totalCount,
            'open'        => $openCount,
            'in_progress' => $inProgressCount,
            'waiting'     => $waitingCount,
            'resolved'    => $resolvedCount,
            'spam'        => $spamCount,
            'unread'      => $unreadCount,
        ];

        // Active ticket
        $activeTicket = null;
        if ($activeTicketId) {
            $activeTicket = $tickets->firstWhere('id', (int) $activeTicketId) ?? SupportTicket::with('messages')->find($activeTicketId);
        }
        if (!$activeTicket && $tickets->count() > 0) {
            $activeTicket = $tickets->first();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'tickets'      => $tickets,
                'activeTicket' => $activeTicket,
                'stats'        => $stats,
                'counts'       => $counts,
            ]);
        }

        return view('admin.messages.index', [
            'tickets'        => $tickets,
            'activeTicket'   => $activeTicket,
            'stats'          => $stats,
            'counts'         => $counts,
            'currentTab'     => $tab,
            'search'         => $search,
            'categoryFilter' => $category,
            'sourceFilter'   => $source,
            'priorityFilter' => $priority,
            'assignedFilter' => $assignedTo,
            'unreadOnly'     => $unreadOnly,
        ]);
    }

    /**
     * Send a reply message or post an internal note.
     */
    public function sendMessage(Request $request, $id): RedirectResponse|JsonResponse
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $isInternalNote = $request->boolean('is_internal_note');

        $msg = $ticket->messages()->create([
            'sender_type'      => 'admin',
            'sender_name'      => auth()->user()?->name ?? 'Hitesh Mohkar',
            'sender_avatar'    => auth()->user()?->avatar ?? 'https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff',
            'message'          => $request->input('message'),
            'is_internal_note' => $isInternalNote,
        ]);

        if (!$isInternalNote) {
            $activities = $ticket->activities ?? [];
            $activities[] = [
                'action' => 'Reply sent',
                'time'   => now()->format('d M Y, h:i A'),
                'color'  => 'purple',
            ];

            $ticket->update([
                'last_message'    => $request->input('message'),
                'last_reply_at'   => now(),
                'last_message_at' => now(),
                'activities'      => $activities,
            ]);
        } else {
            $ticket->update([
                'internal_notes'  => $request->input('message'),
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $isInternalNote ? 'Internal note added.' : 'Reply sent successfully.');
    }

    /**
     * Update ticket status (e.g. Mark as Resolved, Close, Open).
     */
    public function updateStatus(Request $request, $id): RedirectResponse|JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:Open,In Progress,Waiting,Resolved,Spam',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $newStatus = $request->input('status');

        $activities = $ticket->activities ?? [];
        $activities[] = [
            'action' => "Status changed to {$newStatus}",
            'time'   => now()->format('d M Y, h:i A'),
            'color'  => $newStatus === 'Resolved' ? 'success' : 'primary',
        ];

        $ticket->update([
            'status'     => $newStatus,
            'activities' => $activities,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'ticket' => $ticket]);
        }

        return back()->with('success', "Ticket #{$ticket->ticket_number} marked as {$newStatus}.");
    }

    /**
     * Assign ticket to an admin or team.
     */
    public function assign(Request $request, $id): RedirectResponse|JsonResponse
    {
        $request->validate([
            'assigned_to' => 'required|string',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $assignedTo = $request->input('assigned_to');

        $activities = $ticket->activities ?? [];
        $activities[] = [
            'action' => "Assigned to {$assignedTo}",
            'time'   => now()->format('d M Y, h:i A'),
            'color'  => 'primary',
        ];

        $ticket->update([
            'assigned_to' => $assignedTo,
            'activities'  => $activities,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'ticket' => $ticket]);
        }

        return back()->with('success', "Ticket #{$ticket->ticket_number} assigned to {$assignedTo}.");
    }

    /**
     * Store a newly created ticket.
     */
    public function storeTicket(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_name'  => 'required|string|max:150',
            'customer_email' => 'required|email|max:150',
            'category'       => 'required|string',
            'priority'       => 'required|string',
            'message'        => 'required|string',
        ]);

        $ticketNumber = 'TKT' . str_pad((string) (SupportTicket::max('id') + 1246), 6, '0', STR_PAD_LEFT);

        $ticket = SupportTicket::create([
            'ticket_number'   => $ticketNumber,
            'customer_name'   => $request->input('customer_name'),
            'customer_email'  => $request->input('customer_email'),
            'customer_phone'  => $request->input('customer_phone', '+91 98765 00000'),
            'customer_city'   => $request->input('customer_city', 'Ahmedabad, Gujarat'),
            'customer_avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->input('customer_name')) . '&background=0066ff&color=fff',
            'category'        => $request->input('category'),
            'sub_category'    => $request->input('sub_category', 'General Support'),
            'source'          => $request->input('source', 'Website'),
            'priority'        => $request->input('priority', 'Medium'),
            'status'          => 'Open',
            'assigned_to'     => auth()->user()?->name ?? 'Hitesh',
            'last_message'    => $request->input('message'),
            'last_message_at' => now(),
            'is_unread'       => true,
            'activities'      => [
                ['action' => 'Ticket created manually by admin', 'time' => now()->format('d M Y, h:i A'), 'color' => 'success'],
            ],
        ]);

        $ticket->messages()->create([
            'sender_type'   => 'customer',
            'sender_name'   => $ticket->customer_name,
            'sender_avatar' => $ticket->customer_avatar,
            'message'       => $request->input('message'),
        ]);

        return back()->with('success', "Ticket #{$ticketNumber} created successfully.");
    }

    /**
     * Delete a support ticket.
     */
    public function destroy($id): RedirectResponse
    {
        $ticket = SupportTicket::findOrFail($id);
        $number = $ticket->ticket_number;
        $ticket->delete();

        return redirect()->route('admin.messages.index')->with('success', "Ticket #{$number} deleted successfully.");
    }

    /**
     * Export support tickets to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $tickets = SupportTicket::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"tickets-export-" . date('Y-m-d') . ".csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($tickets) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Ticket Number', 'Customer Name', 'Email', 'Phone', 'Category', 'Source', 'Priority', 'Status', 'Assigned To', 'Last Message']);

            foreach ($tickets as $t) {
                fputcsv($handle, [
                    $t->ticket_number,
                    $t->customer_name,
                    $t->customer_email,
                    $t->customer_phone,
                    $t->category,
                    $t->source,
                    $t->priority,
                    $t->status,
                    $t->assigned_to,
                    $t->last_message,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Legacy conversation show method for compatibility.
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

        return redirect()->route('admin.messages.index');
    }

    /**
     * Legacy moderation note method for compatibility.
     */
    public function postModerationNote(Request $request, Conversation $conversation): RedirectResponse
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        $conversation->messages()->create([
            'sender_type' => 'admin',
            'sender_name' => auth()->user()?->name ?? 'Marketplace Moderator',
            'message' => '[ADMIN NOTE] ' . $request->input('note'),
            'is_read' => true,
        ]);

        return back()->with('success', 'Moderation note added to conversation.');
    }
}
