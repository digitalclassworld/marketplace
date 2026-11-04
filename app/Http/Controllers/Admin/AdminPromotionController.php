<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use App\Models\Promotion;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPromotionController extends Controller
{
    /**
     * Super Admin overview of all marketplace promotions and marketing revenues.
     */
    public function index(Request $request): View
    {
        $sellerFilter = $request->query('seller_id');
        $typeFilter = $request->query('type');
        $statusFilter = $request->query('status');

        $query = Promotion::with('seller.user')->latest();

        if ($sellerFilter) {
            $query->where('seller_id', $sellerFilter);
        }
        if ($typeFilter && $typeFilter !== 'all') {
            $query->where('promotion_type', $typeFilter);
        }
        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $promotions = $query->paginate(15)->withQueryString();
        $sellers = Seller::with('user')->get();

        $stats = [
            'total_campaigns' => Promotion::count(),
            'active_campaigns'=> Promotion::where('status', 'Active')->count(),
            'platform_revenue'=> Promotion::sum('charge_amount'),
            'total_impressions'=> Promotion::sum('views_count'),
            'total_sales_generated'=> Promotion::sum('revenue_generated'),
        ];

        return view('admin.promotions.index', [
            'promotions'   => $promotions,
            'sellers'      => $sellers,
            'stats'        => $stats,
            'sellerFilter' => $sellerFilter,
            'typeFilter'   => $typeFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Update promotion status (Approve, Pause, Cancel).
     */
    public function updateStatus(Request $request, Promotion $promotion): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:Active,Paused,Completed',
        ]);

        $promotion->update(['status' => $request->status]);

        return back()->with('success', "Promotion #{$promotion->promotion_code} updated to {$request->status}.");
    }
}

