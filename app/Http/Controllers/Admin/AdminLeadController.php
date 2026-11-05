<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLeadController extends Controller
{
    /**
     * Display Marketing & Leads management matching screenshot pixel-for-pixel.
     */
    public function index(Request $request): View|JsonResponse
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search');
        $sourceFilter = $request->query('source');
        $campaignFilter = $request->query('campaign');
        $statusFilter = $request->query('status');
        $assignedFilter = $request->query('assigned_to');
        $activeLeadId = $request->query('lead_id');

        $showDummy = config('marketplace.show_dummy_data', app()->environment('local', 'testing'));

        $query = Lead::latest();

        // Tab Filter
        if ($tab === 'new') {
            $query->where('status', 'New');
        } elseif ($tab === 'contacted') {
            $query->where('status', 'Contacted');
        } elseif ($tab === 'qualified') {
            $query->where('status', 'Qualified');
        } elseif ($tab === 'demo_scheduled') {
            $query->where('status', 'Demo Scheduled');
        } elseif ($tab === 'converted') {
            $query->where('status', 'Converted');
        } elseif ($tab === 'not_interested') {
            $query->where('status', 'Not Interested');
        } elseif ($tab === 'follow_up') {
            $query->where('status', 'Follow Up');
        }

        // Search Filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('campaign', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }

        // Dropdown Filters
        if (!empty($sourceFilter)) {
            $query->where('source', $sourceFilter);
        }
        if (!empty($campaignFilter)) {
            $query->where('campaign', $campaignFilter);
        }
        if (!empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }
        if (!empty($assignedFilter)) {
            $query->where('assigned_to', $assignedFilter);
        }

        $dbLeads = $query->get();

        if ($showDummy && Lead::count() === 0) {
            (new \Database\Seeders\LeadSeeder())->run();
            $dbLeads = $query->get();
        }

        if (!$showDummy && Lead::count() === 0) {
            $leads = collect();
        } else {
            $leads = $dbLeads;
        }

        // Stats & Counts calculation
        if ($showDummy) {
            $stats = [
                'total_leads'         => '624',
                'leads_growth'        => '↑ 28%',
                'leads_sub'           => '+136 this month',
                'qualified_leads'     => '312',
                'qualified_sub'       => '50% of total',
                'demo_scheduled'      => '186',
                'demo_sub'            => '30% of total',
                'converted'           => '68',
                'converted_sub'       => '11% of total',
                'not_interested'      => '58',
                'not_interested_sub'  => '9% of total',
            ];

            $counts = [
                'all'            => 624,
                'new'            => 144,
                'contacted'      => 206,
                'qualified'      => 312,
                'demo_scheduled' => 186,
                'converted'      => 68,
                'not_interested' => 58,
                'follow_up'      => 92,
            ];

            $sourceBreakdown = [
                ['name' => 'Meta Ads',   'count' => 280, 'percent' => 45, 'color' => '#2563eb'],
                ['name' => 'Google Ads', 'count' => 120, 'percent' => 19, 'color' => '#06b6d4'],
                ['name' => 'Website',    'count' => 86,  'percent' => 14, 'color' => '#8b5cf6'],
                ['name' => 'Referral',   'count' => 52,  'percent' => 8,  'color' => '#ec4899'],
                ['name' => 'WhatsApp',   'count' => 48,  'percent' => 8,  'color' => '#10b981'],
                ['name' => 'Others',     'count' => 38,  'percent' => 6,  'color' => '#f59e0b'],
            ];

            $funnel = [
                ['stage' => 'Total Leads',    'count' => 624, 'percent' => 100, 'color' => '#0066ff'],
                ['stage' => 'Contacted',      'count' => 520, 'percent' => 83,  'color' => '#38bdf8'],
                ['stage' => 'Qualified',      'count' => 312, 'percent' => 50,  'color' => '#10b981'],
                ['stage' => 'Demo Scheduled', 'count' => 186, 'percent' => 30,  'color' => '#f59e0b'],
                ['stage' => 'Proposal Sent',  'count' => 112, 'percent' => 18,  'color' => '#f43f5e'],
                ['stage' => 'Converted',      'count' => 68,  'percent' => 11,  'color' => '#8b5cf6'],
            ];
        } else {
            $totalCount = Lead::count();
            $qualCount  = Lead::where('status', 'Qualified')->count();
            $demoCount  = Lead::where('status', 'Demo Scheduled')->count();
            $convCount  = Lead::where('status', 'Converted')->count();
            $notIntCount= Lead::where('status', 'Not Interested')->count();

            $stats = [
                'total_leads'         => number_format($totalCount),
                'leads_growth'        => '↑ 0%',
                'leads_sub'           => '+' . Lead::where('created_at', '>=', now()->startOfMonth())->count() . ' this month',
                'qualified_leads'     => number_format($qualCount),
                'qualified_sub'       => $totalCount > 0 ? round(($qualCount / $totalCount) * 100) . '% of total' : '0% of total',
                'demo_scheduled'      => number_format($demoCount),
                'demo_sub'            => $totalCount > 0 ? round(($demoCount / $totalCount) * 100) . '% of total' : '0% of total',
                'converted'           => number_format($convCount),
                'converted_sub'       => $totalCount > 0 ? round(($convCount / $totalCount) * 100) . '% of total' : '0% of total',
                'not_interested'      => number_format($notIntCount),
                'not_interested_sub'  => $totalCount > 0 ? round(($notIntCount / $totalCount) * 100) . '% of total' : '0% of total',
            ];

            $counts = [
                'all'            => $totalCount,
                'new'            => Lead::where('status', 'New')->count(),
                'contacted'      => Lead::where('status', 'Contacted')->count(),
                'qualified'      => $qualCount,
                'demo_scheduled' => $demoCount,
                'converted'      => $convCount,
                'not_interested' => $notIntCount,
                'follow_up'      => Lead::where('status', 'Follow Up')->count(),
            ];

            $sourceBreakdown = [
                ['name' => 'Meta Ads',   'count' => Lead::where('source', 'Meta Ads')->count(),   'percent' => 45, 'color' => '#2563eb'],
                ['name' => 'Google Ads', 'count' => Lead::where('source', 'Google Ads')->count(), 'percent' => 19, 'color' => '#06b6d4'],
                ['name' => 'Website',    'count' => Lead::where('source', 'Website')->count(),    'percent' => 14, 'color' => '#8b5cf6'],
                ['name' => 'Referral',   'count' => Lead::where('source', 'Referral')->count(),   'percent' => 8,  'color' => '#ec4899'],
                ['name' => 'WhatsApp',   'count' => Lead::where('source', 'WhatsApp')->count(),   'percent' => 8,  'color' => '#10b981'],
                ['name' => 'Others',     'count' => Lead::where('source', 'Others')->count(),     'percent' => 6,  'color' => '#f59e0b'],
            ];

            $funnel = [
                ['stage' => 'Total Leads',    'count' => $totalCount, 'percent' => 100, 'color' => '#0066ff'],
                ['stage' => 'Contacted',      'count' => Lead::whereIn('status', ['Contacted', 'Qualified', 'Demo Scheduled', 'Converted'])->count(), 'percent' => 83, 'color' => '#38bdf8'],
                ['stage' => 'Qualified',      'count' => $qualCount, 'percent' => 50, 'color' => '#10b981'],
                ['stage' => 'Demo Scheduled', 'count' => $demoCount, 'percent' => 30, 'color' => '#f59e0b'],
                ['stage' => 'Proposal Sent',  'count' => 112,        'percent' => 18, 'color' => '#f43f5e'],
                ['stage' => 'Converted',      'count' => $convCount, 'percent' => 11, 'color' => '#8b5cf6'],
            ];
        }

        // Active Lead for Inspector
        $activeLead = null;
        if ($activeLeadId) {
            $activeLead = $leads->firstWhere('id', (int) $activeLeadId) ?? Lead::find($activeLeadId);
        }
        if (!$activeLead && $leads->count() > 0) {
            $activeLead = $leads->first();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'leads'           => $leads,
                'activeLead'      => $activeLead,
                'stats'           => $stats,
                'counts'          => $counts,
                'sourceBreakdown' => $sourceBreakdown,
                'funnel'          => $funnel,
            ]);
        }

        return view('admin.leads.index', [
            'leads'           => $leads,
            'activeLead'      => $activeLead,
            'stats'           => $stats,
            'counts'          => $counts,
            'sourceBreakdown' => $sourceBreakdown,
            'funnel'          => $funnel,
            'currentTab'      => $tab,
            'search'          => $search,
            'sourceFilter'    => $sourceFilter,
            'campaignFilter'  => $campaignFilter,
            'statusFilter'    => $statusFilter,
            'assignedFilter'  => $assignedFilter,
        ]);
    }

    /**
     * Store new lead or campaign inquiry.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'phone'    => 'required|string|max:25',
            'source'   => 'required|string',
            'campaign' => 'required|string',
        ]);

        $lead = Lead::create([
            'name'           => $request->input('name'),
            'phone'          => $request->input('phone'),
            'email'          => $request->input('email'),
            'city'           => $request->input('city', 'Ahmedabad, Gujarat'),
            'avatar'         => 'https://ui-avatars.com/api/?name=' . urlencode($request->input('name')) . '&background=0066ff&color=fff',
            'source'         => $request->input('source'),
            'campaign'       => $request->input('campaign'),
            'platform'       => $request->input('platform', 'Website'),
            'status'         => 'New',
            'assigned_to'    => $request->input('assigned_to', 'Manish'),
            'next_follow_up' => $request->input('next_follow_up', now()->addDays(2)->format('Y-m-d')),
            'interested_in'  => $request->input('interested_in', 'General Inquiry'),
            'budget'         => $request->input('budget', '₹10,000 - ₹20,000'),
            'remarks'        => $request->input('remarks'),
            'activities'     => [
                ['action' => 'Lead created manually by admin', 'time' => now()->format('d M Y, h:i A'), 'icon' => 'fa-user-plus', 'color' => 'success'],
            ],
            'notes'          => [],
        ]);

        return back()->with('success', "Lead {$lead->name} created successfully.");
    }

    /**
     * Update lead status (e.g. Qualified, Demo Scheduled, Converted).
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|in:New,Contacted,Qualified,Demo Scheduled,Converted,Not Interested,Follow Up',
        ]);

        $lead = Lead::findOrFail($id);
        $newStatus = $request->input('status');

        $activities = $lead->activities ?? [];
        $activities[] = [
            'action' => "Status changed to {$newStatus}",
            'time'   => now()->format('d M Y, h:i A'),
            'icon'   => $newStatus === 'Qualified' ? 'fa-check' : ($newStatus === 'Converted' ? 'fa-circle-check' : 'fa-arrows-rotate'),
            'color'  => $newStatus === 'Qualified' || $newStatus === 'Converted' ? 'success' : 'primary',
        ];

        $lead->update([
            'status'     => $newStatus,
            'activities' => $activities,
        ]);

        return back()->with('success', "Lead {$lead->name} marked as {$newStatus}.");
    }

    /**
     * Schedule demo for lead.
     */
    public function scheduleDemo(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'demo_date' => 'required|string',
            'demo_time' => 'required|string',
        ]);

        $lead = Lead::findOrFail($id);
        $demoDateTime = $request->input('demo_date') . ' ' . $request->input('demo_time');

        $activities = $lead->activities ?? [];
        $activities[] = [
            'action' => "Demo scheduled for {$demoDateTime}",
            'time'   => now()->format('d M Y, h:i A'),
            'icon'   => 'fa-calendar-check',
            'color'  => 'warning',
        ];

        $lead->update([
            'status'     => 'Demo Scheduled',
            'activities' => $activities,
        ]);

        return back()->with('success', "Demo scheduled for {$lead->name} on {$demoDateTime}.");
    }

    /**
     * Add internal team note for lead.
     */
    public function addNote(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $lead = Lead::findOrFail($id);
        $notes = $lead->notes ?? [];

        $notes[] = [
            'author'  => auth()->user()?->name ?? 'Hitesh Mohkar',
            'avatar'  => auth()->user()?->avatar ?? 'https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff',
            'time'    => now()->format('d M Y, h:i A'),
            'content' => $request->input('content'),
        ];

        $lead->update(['notes' => $notes]);

        return back()->with('success', "Note added for {$lead->name}.");
    }

    /**
     * Delete a lead.
     */
    public function destroy($id): RedirectResponse
    {
        $lead = Lead::findOrFail($id);
        $name = $lead->name;
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', "Lead {$name} deleted successfully.");
    }

    /**
     * Export leads as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $leads = Lead::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"leads-export-" . date('Y-m-d') . ".csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($leads) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Phone', 'Email', 'Source', 'Campaign', 'Status', 'Assigned To', 'Next Follow Up', 'Budget', 'Remarks']);

            foreach ($leads as $l) {
                fputcsv($handle, [
                    $l->id,
                    $l->name,
                    $l->phone,
                    $l->email,
                    $l->source,
                    $l->campaign,
                    $l->status,
                    $l->assigned_to,
                    $l->next_follow_up ? $l->next_follow_up->format('d M Y') : '-',
                    $l->budget,
                    $l->remarks,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}

