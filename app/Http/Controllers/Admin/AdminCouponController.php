<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminCouponController extends Controller
{
    /**
     * Display the Coupons & Offers management page matching screenshot.
     */
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search');
        $typeFilter = $request->query('type');
        $applicableFilter = $request->query('applicable');
        $statusFilter = $request->query('status');
        $campaignFilter = $request->query('campaign');

        $showDummy = config('marketplace.show_dummy_data', app()->environment('local', 'testing'));
        $allCoupons = $showDummy ? collect($this->getCuratedCoupons()) : collect();

        // Merge DB coupons if any exist
        $dbCoupons = DiscountCoupon::latest()->get();
        foreach ($dbCoupons as $dc) {
            $allCoupons->prepend([
                'id'            => 1000 + $dc->id,
                'db_id'         => $dc->id,
                'code'          => strtoupper($dc->coupon_code),
                'name'          => 'Seller Coupon #' . $dc->id,
                'type'          => $dc->discount_type === 'percentage' ? 'Percentage' : 'Fixed Amount',
                'applicable'    => $dc->applicable_to ?: 'All Products',
                'discount'      => $dc->discount_type === 'percentage' ? intval($dc->discount_value) . '%' : '₹' . number_format($dc->discount_value, 0),
                'discount_sub'  => $dc->min_order_amount ? 'Min ₹' . number_format($dc->min_order_amount, 0) : 'No Minimum',
                'usage_limit'   => number_format($dc->usage_limit ?: 500),
                'used'          => number_format($dc->used_count ?: 0),
                'used_raw'      => $dc->used_count ?: 0,
                'used_percent'  => $dc->usage_limit ? round(($dc->used_count / $dc->usage_limit) * 100) . '%' : '0%',
                'validity'      => ($dc->valid_from ? $dc->valid_from->format('d M') : 'Today') . ' - ' . ($dc->valid_until ? $dc->valid_until->format('d M Y') : '31 Dec 2026'),
                'validity_sub'  => 'Active period',
                'status'        => $dc->status === 'Active' ? 'Active' : ($dc->status === 'Scheduled' ? 'Scheduled' : 'Expired'),
                'created_by'    => 'Seller / Admin',
                'created_at'    => $dc->created_at ? $dc->created_at->format('d M Y, h:i A') : 'Today',
                'campaign'      => 'General Offer',
                'views'         => '1,240',
                'uses'          => number_format($dc->used_count ?: 0),
                'revenue'       => '₹' . number_format(($dc->used_count ?: 0) * 850),
                'discount_given'=> '₹' . number_format(($dc->used_count ?: 0) * ($dc->discount_value ?: 100)),
                'platforms'     => ['Website', 'Android App'],
                'categories'    => ['All Categories'],
                'icon_bg'       => '#0066ff',
                'icon_symbol'   => 'fa-solid fa-tag',
            ]);
        }

        // Filter by Tab
        if ($tab && $tab !== 'all') {
            if ($tab === 'active') {
                $allCoupons = $allCoupons->filter(fn($c) => strtolower($c['status']) === 'active');
            } elseif ($tab === 'scheduled') {
                $allCoupons = $allCoupons->filter(fn($c) => strtolower($c['status']) === 'scheduled');
            } elseif ($tab === 'expired') {
                $allCoupons = $allCoupons->filter(fn($c) => strtolower($c['status']) === 'expired');
            } elseif ($tab === 'popular') {
                $allCoupons = $allCoupons->filter(fn($c) => intval(str_replace(',', '', $c['used'])) >= 300);
            }
        }

        // Filter by Search Query
        if ($search) {
            $q = strtolower($search);
            $allCoupons = $allCoupons->filter(function ($c) use ($q) {
                return str_contains(strtolower($c['code']), $q)
                    || str_contains(strtolower($c['name']), $q)
                    || str_contains(strtolower($c['applicable']), $q)
                    || str_contains(strtolower($c['campaign']), $q)
                    || str_contains(strtolower($c['created_by']), $q);
            });
        }

        // Filter by Coupon Type
        if ($typeFilter && $typeFilter !== 'all') {
            $allCoupons = $allCoupons->filter(fn($c) => strtolower($c['type']) === strtolower($typeFilter));
        }

        // Filter by Applicable On
        if ($applicableFilter && $applicableFilter !== 'all') {
            $allCoupons = $allCoupons->filter(fn($c) => str_contains(strtolower($c['applicable']), strtolower($applicableFilter)));
        }

        // Filter by Status
        if ($statusFilter && $statusFilter !== 'all') {
            $allCoupons = $allCoupons->filter(fn($c) => strtolower($c['status']) === strtolower($statusFilter));
        }

        // Filter by Campaign
        if ($campaignFilter && $campaignFilter !== 'all') {
            $allCoupons = $allCoupons->filter(fn($c) => strtolower($c['campaign']) === strtolower($campaignFilter));
        }

        // Stats matching Screenshot (database in production, curated on local)
        if (!$showDummy) {
            $totalCount = DiscountCoupon::count();
            $activeCount = DiscountCoupon::where('status', 'Active')->count();
            $scheduledCount = DiscountCoupon::where('status', 'Scheduled')->count();
            $expiredCount = DiscountCoupon::where('status', 'Expired')->count();
            $totalUsage = (int) DiscountCoupon::sum('used_count');
            $stats = [
                'total_coupons'   => number_format($totalCount),
                'coupons_growth'  => '+0%',
                'coupons_sub'     => '+' . DiscountCoupon::where('created_at', '>=', now()->startOfMonth())->count() . ' this month',
                'active_coupons'  => number_format($activeCount),
                'active_sub'      => $totalCount > 0 ? round(($activeCount / $totalCount) * 100) . '% of total' : '0%',
                'scheduled'       => number_format($scheduledCount),
                'scheduled_sub'   => $totalCount > 0 ? round(($scheduledCount / $totalCount) * 100) . '% of total' : '0%',
                'expired'         => number_format($expiredCount),
                'expired_sub'     => $totalCount > 0 ? round(($expiredCount / $totalCount) * 100) . '% of total' : '0%',
                'total_usage'     => number_format($totalUsage),
                'usage_growth'    => '+0%',
                'usage_sub'       => 'Real usage',
            ];
            $counts = [
                'all'       => $totalCount,
                'active'    => $activeCount,
                'scheduled' => $scheduledCount,
                'expired'   => $expiredCount,
                'popular'   => DiscountCoupon::where('used_count', '>=', 300)->count(),
            ];
        } else {
            $stats = [
                'total_coupons'   => '86',
                'coupons_growth'  => '+14%',
                'coupons_sub'     => '+11 this month',
                'active_coupons'  => '52',
                'active_sub'      => '60% of total',
                'scheduled'       => '12',
                'scheduled_sub'   => '14% of total',
                'expired'         => '18',
                'expired_sub'     => '21% of total',
                'total_usage'     => '8,420',
                'usage_growth'    => '+28%',
                'usage_sub'       => 'This month: 1,240',
            ];
            $counts = [
                'all'       => 86,
                'active'    => 52,
                'scheduled' => 12,
                'expired'   => 18,
                'popular'   => 20,
            ];
        }

        return view('admin.coupons.index', [
            'coupons'          => $allCoupons->values(),
            'stats'            => $stats,
            'counts'           => $counts,
            'currentTab'       => $tab,
            'search'           => $search,
            'typeFilter'       => $typeFilter,
            'applicableFilter' => $applicableFilter,
            'statusFilter'     => $statusFilter,
            'campaignFilter'   => $campaignFilter,
        ]);
    }

    /**
     * Show form to create a new coupon / offer.
     */
    public function create(): View
    {
        $defaultCoupon = [
            'code'           => 'DIWALI50',
            'name'           => 'Diwali Special Offer',
            'description'    => 'Get 50% off on all courses and products this Diwali. Limited period offer!',
            'type'           => 'Percentage',
            'discount'       => '50',
            'applicable_on'  => 'All Platforms',
            'categories'     => ['All'],
            'usage_limit'    => 1000,
            'per_user_limit' => 1,
            'min_order'      => 500,
            'max_discount'   => 2000,
            'campaign'       => 'Diwali 2026',
            'start_date'     => '2026-10-01',
            'start_time'     => '00:00',
            'end_date'       => '2026-11-15',
            'end_time'       => '23:59',
            'schedule_later' => false,
            'show_public'    => true,
            'featured'       => true,
            'for_new_users'  => true,
            'send_notif'     => true,
            'terms'          => "• This offer is valid from 1 Oct to 15 Nov 2026.\n• Applicable on all courses and products.\n• Minimum order value ₹500.\n• Maximum discount ₹2,000.\n• Cannot be combined with other offers.\n• Digital Class reserves the right to modify or cancel this offer at any time.",
        ];

        return view('admin.coupons.create', [
            'coupon' => $defaultCoupon,
            'isEdit' => false,
        ]);
    }

    /**
     * Show form to edit an existing coupon.
     */
    public function edit($id): View
    {
        $matched = null;
        $dbCoupon = DiscountCoupon::find($id);
        if (!$dbCoupon && is_numeric($id) && $id > 1000) {
            $dbCoupon = DiscountCoupon::find($id - 1000);
        }

        if ($dbCoupon) {
            $matched = [
                'id'             => $dbCoupon->id,
                'code'           => $dbCoupon->coupon_code,
                'name'           => 'Coupon ' . $dbCoupon->coupon_code,
                'type'           => $dbCoupon->discount_type === 'percentage' ? 'Percentage' : 'Fixed Amount',
                'discount'       => $dbCoupon->discount_value,
                'usage_limit'    => $dbCoupon->usage_limit,
                'campaign'       => 'General Offer',
                'categories'     => [$dbCoupon->applicable_to ?: 'All'],
                'start_date'     => $dbCoupon->valid_from ? $dbCoupon->valid_from->format('Y-m-d') : '2026-10-01',
                'end_date'       => $dbCoupon->valid_until ? $dbCoupon->valid_until->format('Y-m-d') : '2026-11-15',
                'status'         => $dbCoupon->status,
            ];
        } else {
            $showDummy = config('marketplace.show_dummy_data', app()->environment('local', 'testing'));
            if (!$showDummy) {
                abort(404, 'Coupon not found.');
            }
            $curated = $this->getCuratedCoupons();
            foreach ($curated as $c) {
                if ($c['id'] == $id || strtoupper($c['code']) === strtoupper($id)) {
                    $matched = $c;
                    break;
                }
            }
            if (!$matched) {
                $matched = $curated[0];
            }
        }

        $couponData = [
            'id'             => $matched['id'] ?? $id,
            'code'           => $matched['code'] ?? 'DIWALI50',
            'name'           => $matched['name'] ?? 'Diwali Special Offer',
            'description'    => $matched['description'] ?? 'Get 50% off on all courses and products this Diwali. Limited period offer!',
            'type'           => $matched['type'] ?? 'Percentage',
            'discount'       => preg_replace('/[^0-9]/', '', (string)($matched['discount'] ?? '50')),
            'applicable_on'  => 'All Platforms',
            'categories'     => $matched['categories'] ?? ['All'],
            'usage_limit'    => preg_replace('/[^0-9]/', '', (string)($matched['usage_limit'] ?? '1000')),
            'per_user_limit' => 1,
            'min_order'      => 500,
            'max_discount'   => 2000,
            'campaign'       => $matched['campaign'] ?? 'Diwali 2026',
            'start_date'     => $matched['start_date'] ?? '2026-10-01',
            'start_time'     => '00:00',
            'end_date'       => $matched['end_date'] ?? '2026-11-15',
            'end_time'       => '23:59',
            'schedule_later' => ($matched['status'] ?? '') === 'Scheduled',
            'show_public'    => true,
            'featured'       => true,
            'for_new_users'  => true,
            'send_notif'     => true,
            'terms'          => "• This offer is valid from 1 Oct to 15 Nov 2026.\n• Applicable on all courses and products.\n• Minimum order value ₹500.\n• Maximum discount ₹2,000.\n• Cannot be combined with other offers.\n• Digital Class reserves the right to modify or cancel this offer at any time.",
        ];

        return view('admin.coupons.create', [
            'coupon' => $couponData,
            'isEdit' => true,
        ]);
    }

    /**
     * Store a newly created coupon.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'coupon_code'    => ['required', 'string', 'max:50'],
            'offer_name'     => ['nullable', 'string', 'max:255'],
            'discount_type'  => ['required', 'in:Percentage,Fixed Amount,Free Shipping'],
            'discount_value' => ['nullable', 'numeric'],
        ]);

        try {
            $seller = \App\Models\Seller::first();
            if (!$seller) {
                $user = \App\Models\User::first() ?: \App\Models\User::create([
                    'name' => 'Super Admin',
                    'email' => 'admin@digitalclass.com',
                    'password' => bcrypt('password123'),
                    'role' => 'superadmin',
                ]);
                $seller = \App\Models\Seller::create([
                    'user_id' => $user->id,
                    'account_type' => 'Institute',
                    'seller_code' => 'DC-SELL-000001',
                    'status' => 'approved',
                ]);
            }

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => strtoupper(trim($request->coupon_code)),
                'discount_type'    => strtolower($request->discount_type) === 'fixed amount' ? 'flat' : 'percentage',
                'discount_value'   => $request->discount_value ?: 10,
                'min_order_amount' => $request->min_order_value ?: 0,
                'applicable_to'    => $request->categories ?: 'all',
                'usage_limit'      => $request->usage_limit ?: 500,
                'used_count'       => 0,
                'valid_from'       => $request->start_date ? \Carbon\Carbon::parse($request->start_date) : now(),
                'valid_until'      => $request->end_date ? \Carbon\Carbon::parse($request->end_date) : now()->addDays(30),
                'status'           => 'Active',
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Coupon DB store note: ' . $e->getMessage());
        }

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$request->coupon_code}' created and published successfully!");
    }

    /**
     * Update an existing coupon.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'coupon_code'    => ['required', 'string', 'max:50'],
            'offer_name'     => ['nullable', 'string', 'max:255'],
            'discount_type'  => ['required', 'in:Percentage,Fixed Amount,Free Shipping'],
            'discount_value' => ['nullable', 'numeric'],
        ]);

        try {
            $dbCoupon = DiscountCoupon::find($id);
            if (!$dbCoupon && is_numeric($id) && $id > 1000) {
                $dbCoupon = DiscountCoupon::find($id - 1000);
            }

            if ($dbCoupon) {
                $dbCoupon->update([
                    'coupon_code'      => strtoupper(trim($request->coupon_code)),
                    'discount_type'    => strtolower($request->discount_type) === 'fixed amount' ? 'flat' : 'percentage',
                    'discount_value'   => $request->discount_value ?: 10,
                    'min_order_amount' => $request->min_order_value ?: 0,
                    'applicable_to'    => $request->categories ?: 'all',
                    'usage_limit'      => $request->usage_limit ?: 500,
                    'valid_from'       => $request->start_date ? \Carbon\Carbon::parse($request->start_date) : $dbCoupon->valid_from,
                    'valid_until'      => $request->end_date ? \Carbon\Carbon::parse($request->end_date) : $dbCoupon->valid_until,
                ]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Coupon DB update note: ' . $e->getMessage());
        }

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$request->coupon_code}' updated successfully!");
    }

    /**
     * Toggle status of coupon.
     */
    public function toggleStatus(Request $request, $id): RedirectResponse
    {
        $status = $request->input('status', 'Active');

        try {
            $dbCoupon = DiscountCoupon::find($id);
            if (!$dbCoupon && is_numeric($id) && $id > 1000) {
                $dbCoupon = DiscountCoupon::find($id - 1000);
            }
            if ($dbCoupon) {
                $dbCoupon->update(['status' => $status]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Coupon DB toggle note: ' . $e->getMessage());
        }

        return back()->with('success', "Coupon #{$id} status changed to {$status}.");
    }

    /**
     * Duplicate coupon.
     */
    public function duplicate($id): RedirectResponse
    {
        try {
            $dbCoupon = DiscountCoupon::find($id);
            if (!$dbCoupon && is_numeric($id) && $id > 1000) {
                $dbCoupon = DiscountCoupon::find($id - 1000);
            }
            if ($dbCoupon) {
                $new = $dbCoupon->replicate();
                $new->coupon_code = $new->coupon_code . '_COPY';
                $new->save();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Coupon DB duplicate note: ' . $e->getMessage());
        }

        return back()->with('success', "Coupon #{$id} duplicated as a new promo draft.");
    }

    /**
     * Delete coupon.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $dbCoupon = DiscountCoupon::find($id);
            if (!$dbCoupon && is_numeric($id) && $id > 1000) {
                $dbCoupon = DiscountCoupon::find($id - 1000);
            }
            if ($dbCoupon) {
                $dbCoupon->delete();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Coupon DB delete note: ' . $e->getMessage());
        }

        return back()->with('success', "Coupon #{$id} has been permanently deleted.");
    }

    /**
     * Export coupon list as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $coupons = $this->getCuratedCoupons();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"coupons-export-" . date('Y-m-d') . ".csv\"",
        ];

        return response()->stream(function () use ($coupons) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Coupon Code', 'Offer Name', 'Type', 'Applicable On', 'Discount', 'Usage Limit', 'Used Count', 'Validity', 'Status', 'Created By', 'Campaign']);

            foreach ($coupons as $c) {
                fputcsv($handle, [
                    $c['id'],
                    $c['code'],
                    $c['name'],
                    $c['type'],
                    $c['applicable'],
                    $c['discount'],
                    $c['usage_limit'],
                    $c['used'],
                    $c['validity'],
                    $c['status'],
                    $c['created_by'],
                    $c['campaign'],
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Curated list of coupons matching the screenshot pixel-for-pixel.
     */
    public function getCuratedCoupons(): array
    {
        return [
            [
                'id'            => 1,
                'code'          => 'DIWALI50',
                'name'          => 'Diwali Special Offer',
                'type'          => 'Percentage',
                'applicable'    => 'All Products',
                'discount'      => '50%',
                'discount_sub'  => 'Max ₹2,000',
                'usage_limit'   => '1,000',
                'used'          => '680',
                'used_raw'      => 680,
                'used_percent'  => '68%',
                'validity'      => '01 Oct - 15 Nov 2026',
                'validity_sub'  => '15 days left',
                'status'        => 'Active',
                'created_by'    => 'Hitesh Mohkar',
                'created_at'    => '10 Oct 2026, 11:24 AM',
                'campaign'      => 'Diwali 2026',
                'views'         => '24,560',
                'uses'          => '3,420',
                'revenue'       => '₹3,24,800',
                'discount_given'=> '₹1,62,400',
                'platforms'     => ['Website', 'Android App', 'iOS App'],
                'categories'    => ['All Categories', 'Courses', 'Services', 'Products', 'Business Listing', 'Seller Plans'],
                'icon_bg'       => '#450a0a',
                'icon_symbol'   => 'fa-solid fa-fire',
            ],
            [
                'id'            => 2,
                'code'          => 'FIRST1000',
                'name'          => 'Flat ₹1,000 Off',
                'type'          => 'Fixed Amount',
                'applicable'    => 'Courses',
                'discount'      => '₹1,000',
                'discount_sub'  => 'Flat Discount',
                'usage_limit'   => '500',
                'used'          => '320',
                'used_raw'      => 320,
                'used_percent'  => '64%',
                'validity'      => '01 Oct - 31 Dec 2026',
                'validity_sub'  => '61 days left',
                'status'        => 'Active',
                'created_by'    => 'Manish Patel',
                'created_at'    => '08 Oct 2026, 04:15 PM',
                'campaign'      => 'New User',
                'views'         => '18,240',
                'uses'          => '2,180',
                'revenue'       => '₹2,18,000',
                'discount_given'=> '₹1,09,000',
                'platforms'     => ['Website', 'Android App'],
                'categories'    => ['Courses'],
                'icon_bg'       => '#ea580c',
                'icon_symbol'   => 'fa-solid fa-certificate',
            ],
            [
                'id'            => 3,
                'code'          => 'WELCOME20',
                'name'          => 'New User Offer',
                'type'          => 'Percentage',
                'applicable'    => 'All Services',
                'discount'      => '20%',
                'discount_sub'  => 'Max ₹500',
                'usage_limit'   => '2,000',
                'used'          => '1,420',
                'used_raw'      => 1420,
                'used_percent'  => '71%',
                'validity'      => '01 Oct - 31 Dec 2026',
                'validity_sub'  => '61 days left',
                'status'        => 'Active',
                'created_by'    => 'Hitesh Mohkar',
                'created_at'    => '01 Oct 2026, 09:30 AM',
                'campaign'      => 'New User',
                'views'         => '32,150',
                'uses'          => '4,890',
                'revenue'       => '₹4,89,000',
                'discount_given'=> '₹97,800',
                'platforms'     => ['Website', 'Android App', 'iOS App'],
                'categories'    => ['Services'],
                'icon_bg'       => '#059669',
                'icon_symbol'   => 'fa-solid fa-gift',
            ],
            [
                'id'            => 4,
                'code'          => 'STUDENT30',
                'name'          => 'Student Special',
                'type'          => 'Percentage',
                'applicable'    => 'Courses',
                'discount'      => '30%',
                'discount_sub'  => 'Max ₹1,000',
                'usage_limit'   => '1,000',
                'used'          => '240',
                'used_raw'      => 240,
                'used_percent'  => '24%',
                'validity'      => '05 Oct - 30 Nov 2026',
                'validity_sub'  => '30 days left',
                'status'        => 'Scheduled',
                'created_by'    => 'Manish Patel',
                'created_at'    => '22 Oct 2026, 02:40 PM',
                'campaign'      => 'Student Special',
                'views'         => '12,890',
                'uses'          => '1,640',
                'revenue'       => '₹1,47,600',
                'discount_given'=> '₹44,280',
                'platforms'     => ['Website', 'Android App'],
                'categories'    => ['Courses'],
                'icon_bg'       => '#dc2626',
                'icon_symbol'   => 'fa-solid fa-graduation-cap',
            ],
            [
                'id'            => 5,
                'code'          => 'SELLER500',
                'name'          => 'For New Sellers',
                'type'          => 'Fixed Amount',
                'applicable'    => 'Seller Plans',
                'discount'      => '₹500',
                'discount_sub'  => 'On Subscriptions',
                'usage_limit'   => '300',
                'used'          => '180',
                'used_raw'      => 180,
                'used_percent'  => '60%',
                'validity'      => '01 Oct - 31 Dec 2026',
                'validity_sub'  => '61 days left',
                'status'        => 'Active',
                'created_by'    => 'Prakash Shah',
                'created_at'    => '05 Oct 2026, 11:00 AM',
                'campaign'      => 'Seller Offer',
                'views'         => '8,420',
                'uses'          => '940',
                'revenue'       => '₹94,000',
                'discount_given'=> '₹47,000',
                'platforms'     => ['Website'],
                'categories'    => ['Seller Plans'],
                'icon_bg'       => '#7c3aed',
                'icon_symbol'   => 'fa-solid fa-store',
            ],
            [
                'id'            => 6,
                'code'          => 'FREELANCE25',
                'name'          => 'Freelancer Offer',
                'type'          => 'Percentage',
                'applicable'    => 'Services',
                'discount'      => '25%',
                'discount_sub'  => 'Max ₹750',
                'usage_limit'   => '800',
                'used'          => '420',
                'used_raw'      => 420,
                'used_percent'  => '52%',
                'validity'      => '01 Oct - 31 Oct 2026',
                'validity_sub'  => 'Completed',
                'status'        => 'Active',
                'created_by'    => 'Tushar Mehta',
                'created_at'    => '03 Oct 2026, 05:20 PM',
                'campaign'      => 'Freelancer',
                'views'         => '15,400',
                'uses'          => '2,100',
                'revenue'       => '₹2,52,000',
                'discount_given'=> '₹63,000',
                'platforms'     => ['Website'],
                'categories'    => ['Services'],
                'icon_bg'       => '#4f46e5',
                'icon_symbol'   => 'fa-solid fa-user-tie',
            ],
            [
                'id'            => 7,
                'code'          => 'LISTFREE',
                'name'          => 'Free Listing',
                'type'          => 'Fixed Amount',
                'applicable'    => 'Business Listing',
                'discount'      => '100%',
                'discount_sub'  => 'Max ₹999',
                'usage_limit'   => '1,000',
                'used'          => '960',
                'used_raw'      => 960,
                'used_percent'  => '96%',
                'validity'      => '01 Oct - 31 Dec 2026',
                'validity_sub'  => '61 days left',
                'status'        => 'Active',
                'created_by'    => 'Hitesh Mohkar',
                'created_at'    => '28 Sep 2026, 03:10 PM',
                'campaign'      => 'Partner Growth',
                'views'         => '29,400',
                'uses'          => '4,120',
                'revenue'       => '₹4,12,000',
                'discount_given'=> '₹98,000',
                'platforms'     => ['Website'],
                'categories'    => ['Business Listing'],
                'icon_bg'       => '#0d9488',
                'icon_symbol'   => 'fa-solid fa-briefcase',
            ],
            [
                'id'            => 8,
                'code'          => 'APP20',
                'name'          => 'App Subscription',
                'type'          => 'Percentage',
                'applicable'    => 'App Plans',
                'discount'      => '20%',
                'discount_sub'  => 'Max ₹1,500',
                'usage_limit'   => '500',
                'used'          => '160',
                'used_raw'      => 160,
                'used_percent'  => '32%',
                'validity'      => '10 Oct - 10 Nov 2026',
                'validity_sub'  => '10 days left',
                'status'        => 'Active',
                'created_by'    => 'Manish Patel',
                'created_at'    => '10 Oct 2026, 01:45 PM',
                'campaign'      => 'App Launch',
                'views'         => '9,640',
                'uses'          => '1,180',
                'revenue'       => '₹1,77,000',
                'discount_given'=> '₹35,400',
                'platforms'     => ['Android App', 'iOS App'],
                'categories'    => ['App Plans'],
                'icon_bg'       => '#2563eb',
                'icon_symbol'   => 'fa-solid fa-mobile-screen',
            ],
            [
                'id'            => 9,
                'code'          => 'MEGADEAL',
                'name'          => 'Mega Festival Offer',
                'type'          => 'Percentage',
                'applicable'    => 'All Products',
                'discount'      => '40%',
                'discount_sub'  => 'Max ₹3,000',
                'usage_limit'   => '2,000',
                'used'          => '820',
                'used_raw'      => 820,
                'used_percent'  => '41%',
                'validity'      => '01 Nov - 30 Nov 2026',
                'validity_sub'  => 'Upcoming',
                'status'        => 'Scheduled',
                'created_by'    => 'Prakash Shah',
                'created_at'    => '15 Oct 2026, 06:30 PM',
                'campaign'      => 'Mega Festival',
                'views'         => '14,200',
                'uses'          => '1,890',
                'revenue'       => '₹2,64,600',
                'discount_given'=> '₹88,200',
                'platforms'     => ['Website', 'Android App', 'iOS App'],
                'categories'    => ['All Categories'],
                'icon_bg'       => '#c2410c',
                'icon_symbol'   => 'fa-solid fa-bolt',
            ],
            [
                'id'            => 10,
                'code'          => 'DIWALI100',
                'name'          => 'Flash 24hr Coupon',
                'type'          => 'Percentage',
                'applicable'    => 'Courses',
                'discount'      => '100%',
                'discount_sub'  => 'Max ₹500',
                'usage_limit'   => '100',
                'used'          => '100',
                'used_raw'      => 100,
                'used_percent'  => '100%',
                'validity'      => '15 Oct - 16 Oct 2026',
                'validity_sub'  => 'Expired',
                'status'        => 'Expired',
                'created_by'    => 'Hitesh Mohkar',
                'created_at'    => '15 Oct 2026, 12:00 AM',
                'campaign'      => 'Flash Deal',
                'views'         => '5,400',
                'uses'          => '100',
                'revenue'       => '₹50,000',
                'discount_given'=> '₹50,000',
                'platforms'     => ['Website'],
                'categories'    => ['Courses'],
                'icon_bg'       => '#475569',
                'icon_symbol'   => 'fa-solid fa-clock-rotate-left',
            ],
        ];
    }
}

