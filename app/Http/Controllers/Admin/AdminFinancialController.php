<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminFinancialController extends Controller
{
    /**
     * Display Payments & Wallet Transactions ledger.
     */
    public function payments(Request $request): View
    {
        $statusFilter = $request->query('status', 'all');
        $search = $request->query('search');

        $query = Order::query()->with('seller.businessDetail', 'seller.user')->latest('placed_at')->latest('id');

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if (!empty($search)) {
            $q = $search;
            $query->where(function ($sq) use ($q) {
                $sq->where('order_number', 'like', "%{$q}%")
                   ->orWhere('customer_name', 'like', "%{$q}%")
                   ->orWhere('customer_email', 'like', "%{$q}%")
                   ->orWhere('item_title', 'like', "%{$q}%");
            });
        }

        $payments = $query->paginate(15)->withQueryString();

        // Calculate financial statistics
        $grossVolume = (float) Order::whereNotIn('status', ['cancelled', 'failed', 'refunded'])->sum('amount');
        $platformCommission = $grossVolume * 0.15; // 15% platform cut
        $sellerNetPayouts = $grossVolume * 0.85;   // 85% seller share
        $totalTransactions = Order::count();

        $stats = [
            'gross_volume'        => '₹' . number_format($grossVolume, 2),
            'platform_commission' => '₹' . number_format($platformCommission, 2),
            'seller_payouts'      => '₹' . number_format($sellerNetPayouts, 2),
            'total_transactions'  => $totalTransactions,
        ];

        return view('admin.financial.payments', [
            'payments'     => $payments,
            'stats'        => $stats,
            'statusFilter' => $statusFilter,
            'searchQuery'  => $search,
        ]);
    }

    /**
     * Display Seller Payouts & Commission console.
     */
    public function payouts(Request $request): View
    {
        $sellers = Seller::with(['user', 'businessDetail'])->get();

        $payoutRows = [];
        $totalPendingPayout = 0;
        $totalReleasedPayout = 0;

        foreach ($sellers as $s) {
            $orders = $s->orders()->whereNotIn('status', ['cancelled', 'failed', 'refunded'])->get();
            $grossSales = (float) $orders->sum('amount');
            $commission = $grossSales * 0.15;
            $netPayable = $grossSales * 0.85;

            // Check if seller has completed/delivered orders
            $completedOrders = $orders->whereIn('status', ['completed', 'delivered']);
            $deliveredSales = (float) $completedOrders->sum('amount') * 0.85;

            $totalPendingPayout += $netPayable;

            $storeName = $s->businessDetail?->business_name ?: ($s->user?->name ?: 'Seller #' . $s->id);
            $payoutRows[] = [
                'seller_id'       => $s->id,
                'seller_code'     => $s->seller_code ?: ('DC-SELL-' . $s->id),
                'store_name'      => $storeName,
                'owner_name'      => $s->user?->name ?: 'Seller',
                'owner_email'     => $s->user?->email ?: 'seller@digitalclassworld.in',
                'owner_phone'     => $s->user?->phone ?: 'N/A',
                'account_type'    => $s->account_type ?: 'Individual',
                'total_orders'    => $orders->count(),
                'gross_sales'     => '₹' . number_format($grossSales, 2),
                'commission'      => '₹' . number_format($commission, 2),
                'net_payable'     => '₹' . number_format($netPayable, 2),
                'raw_payable'     => $netPayable,
                'status'          => $netPayable > 0 ? 'Pending Payout' : 'Settled',
                'status_badge'    => $netPayable > 0 ? 'warning' : 'success',
            ];
        }

        $stats = [
            'total_pending'   => '₹' . number_format($totalPendingPayout, 2),
            'sellers_count'   => count($sellers),
            'active_payouts'  => count(array_filter($payoutRows, fn($r) => $r['raw_payable'] > 0)),
        ];

        return view('admin.financial.payouts', [
            'payoutRows' => $payoutRows,
            'stats'      => $stats,
        ]);
    }

    /**
     * Release / Settle payout for a seller.
     */
    public function releasePayout(Request $request, int $sellerId): JsonResponse|RedirectResponse
    {
        $seller = Seller::with('businessDetail', 'user')->findOrFail($sellerId);
        $storeName = $seller->businessDetail?->business_name ?: ($seller->user?->name ?: 'Seller #' . $sellerId);

        // Mark completed orders as settled/paid
        $seller->orders()->whereIn('status', ['confirmed', 'processing', 'completed', 'delivered'])->update([
            'status' => 'completed',
        ]);

        $msg = "Payout batch for {$storeName} marked as Processed & Released successfully.";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
    }
}
