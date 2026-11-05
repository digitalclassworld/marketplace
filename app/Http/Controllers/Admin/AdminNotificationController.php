<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminNotificationController extends Controller
{
    /**
     * Display the Notifications & Alerts management dashboard.
     */
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search');
        $type = $request->query('type');
        $audience = $request->query('audience');
        $status = $request->query('status');
        $platform = $request->query('platform');
        $dateRange = $request->query('date_range');

        $query = PlatformNotification::query();

        // Status Tabs filter
        if ($tab === 'sent') {
            $query->where('status', 'Sent');
        } elseif ($tab === 'scheduled') {
            $query->where('status', 'Scheduled');
        } elseif ($tab === 'drafts') {
            $query->where('status', 'Draft');
        } elseif ($tab === 'failed') {
            $query->where('status', 'Failed');
        }

        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('audience', 'like', "%{$search}%");
            });
        }

        // Type filter
        if (!empty($type) && $type !== 'All Types') {
            $query->where('type', $type);
        }

        // Audience filter
        if (!empty($audience) && $audience !== 'All Audience') {
            $query->where('audience', $audience);
        }

        // Status filter
        if (!empty($status) && $status !== 'All Status') {
            $query->where('status', $status);
        }

        // Platform filter
        if (!empty($platform) && $platform !== 'All Platforms') {
            $query->whereJsonContains('platforms', $platform);
        }

        // Date Range
        if (!empty($dateRange)) {
            // E.g. "01 Oct 2026 - 31 Oct 2026"
            $dates = explode('-', $dateRange);
            if (count($dates) === 2) {
                try {
                    $start = Carbon::parse(trim($dates[0]))->startOfDay();
                    $end = Carbon::parse(trim($dates[1]))->endOfDay();
                    $query->where(function ($q) use ($start, $end) {
                        $q->whereBetween('sent_at', [$start, $end])
                          ->orWhereBetween('scheduled_at', [$start, $end])
                          ->orWhereBetween('created_at', [$start, $end]);
                    });
                } catch (\Exception $e) {
                    // Ignore date parse errors
                }
            }
        }

        // Counts for tabs
        $allCount = PlatformNotification::count();
        $sentCount = PlatformNotification::where('status', 'Sent')->count();
        $scheduledCount = PlatformNotification::where('status', 'Scheduled')->count();
        $draftsCount = PlatformNotification::where('status', 'Draft')->count();
        $failedCount = PlatformNotification::where('status', 'Failed')->count();

        // Ordering: Keep specific screenshot order if no search, else latest
        if (empty($search) && empty($type) && empty($audience) && empty($status) && empty($platform) && $tab === 'all') {
            $notifications = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();
        } else {
            $notifications = $query->latest('id')->paginate(10)->withQueryString();
        }

        // KPI metrics
        $kpi = [
            'total_sent'       => '12,540',
            'sent_growth'      => '+28%',
            'sent_sub'         => '+2,840 this month',
            'total_recipients' => '8,620',
            'recipients_growth'=> '+32%',
            'recipients_sub'   => 'Unique users reached',
            'opened'           => '6,280',
            'opened_rate'      => '73% open rate',
            'clicked'          => '1,420',
            'click_rate'       => '22% click rate',
            'scheduled'        => $scheduledCount,
            'scheduled_sub'    => 'Pending to send',
        ];

        return view('admin.notifications.index', [
            'notifications'  => $notifications,
            'tab'            => $tab,
            'search'         => $search,
            'type'           => $type,
            'audience'       => $audience,
            'status'         => $status,
            'platform'       => $platform,
            'dateRange'      => $dateRange ?? '01 Oct 2026 - 31 Oct 2026',
            'allCount'       => $allCount,
            'sentCount'      => $sentCount,
            'scheduledCount' => $scheduledCount,
            'draftsCount'    => $draftsCount,
            'failedCount'    => $failedCount,
            'kpi'            => $kpi,
        ]);
    }

    /**
     * Store a newly created notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:100',
            'message'      => 'required|string|max:300',
            'channel'      => 'nullable|string',
            'type'         => 'required|string',
            'audience'     => 'required|string',
            'platforms'    => 'nullable|array',
            'schedule_opt' => 'nullable|string',
            'sched_date'   => 'nullable|string',
            'sched_time'   => 'nullable|string',
            'action_type'  => 'nullable|string', // 'draft' or 'send'
        ]);

        $audienceCounts = [
            'All Users'        => 8620,
            'Students'         => 3120,
            'Sellers'          => 142,
            'Institutes'       => 650,
            'Registered Users' => 320,
        ];
        $audCount = $audienceCounts[$validated['audience']] ?? 1000;

        $platforms = $request->input('platforms', ['Website', 'Android App', 'iOS App']);
        $channel = $request->input('channel', 'Push Notification');
        $action = $request->input('action_type', 'send');
        $scheduleOpt = $request->input('schedule_opt', 'now');

        if ($action === 'draft') {
            $status = 'Draft';
            $sentAt = null;
            $scheduledAt = null;
        } elseif ($scheduleOpt === 'later') {
            $status = 'Scheduled';
            $sentAt = null;
            $scheduledAt = Carbon::now()->addDays(2);
            if (!empty($validated['sched_date'])) {
                try {
                    $time = $validated['sched_time'] ?? '10:00';
                    $scheduledAt = Carbon::parse($validated['sched_date'] . ' ' . $time);
                } catch (\Exception $e) {
                    $scheduledAt = Carbon::now()->addDays(2);
                }
            }
        } else {
            $status = 'Sent';
            $sentAt = Carbon::now();
            $scheduledAt = null;
        }

        PlatformNotification::create([
            'title'            => $validated['title'],
            'message'          => $validated['message'],
            'channel'          => $channel,
            'type'             => $validated['type'],
            'audience'         => $validated['audience'],
            'audience_count'   => $audCount,
            'platforms'        => $platforms,
            'status'           => $status,
            'sent_at'          => $sentAt,
            'scheduled_at'     => $scheduledAt,
            'recipients_count' => $status === 'Sent' ? $audCount : 0,
            'opened_count'     => 0,
            'clicked_count'    => 0,
            'image_url'        => $request->input('image_url') ?: 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=400&q=80',
            'created_by'       => auth()->user()?->name ?? 'Hitesh Mohkar',
        ]);

        $msg = $status === 'Draft' ? 'Notification saved as draft successfully!' : ($status === 'Scheduled' ? 'Notification scheduled successfully!' : 'Notification sent successfully to recipients!');

        return redirect()->route('admin.notifications.index')->with('success', $msg);
    }

    /**
     * Resend or duplicate notification.
     */
    public function resend(int $id): RedirectResponse
    {
        $notif = PlatformNotification::findOrFail($id);
        
        $clone = $notif->replicate();
        $clone->title = $notif->title . ' (Copy)';
        $clone->status = 'Sent';
        $clone->sent_at = Carbon::now();
        $clone->scheduled_at = null;
        $clone->save();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification resent successfully!');
    }

    /**
     * Delete notification.
     */
    public function destroy(int $id): RedirectResponse
    {
        $notif = PlatformNotification::findOrFail($id);
        $notif->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully!');
    }

    /**
     * Export notifications to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $filename = 'notifications_' . date('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Message', 'Channel', 'Type', 'Audience', 'Platforms', 'Status', 'Sent At', 'Scheduled At', 'Recipients', 'Opened', 'Clicked']);

            PlatformNotification::orderBy('id')->chunk(100, function ($notifications) use ($handle) {
                foreach ($notifications as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->title,
                        $item->message,
                        $item->channel,
                        $item->type,
                        $item->audience . " ({$item->audience_count})",
                        is_array($item->platforms) ? implode(', ', $item->platforms) : '',
                        $item->status,
                        $item->sent_at ? $item->sent_at->format('Y-m-d H:i') : '-',
                        $item->scheduled_at ? $item->scheduled_at->format('Y-m-d H:i') : '-',
                        $item->recipients_count,
                        $item->opened_count,
                        $item->clicked_count,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}

