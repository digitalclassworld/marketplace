<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    /**
     * Display Reports & Analytics Studio.
     */
    public function index(Request $request): View
    {
        $range = $request->query('range', '30days');

        $query = Order::query()->whereNotIn('status', ['cancelled', 'failed', 'refunded']);

        if ($range === '7days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($range === '30days') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($range === 'this_year') {
            $query->whereYear('created_at', now()->year);
        }

        $grossRevenue = (float) (clone $query)->sum('amount');
        $totalOrdersCount = (clone $query)->count();
        $netCommission = $grossRevenue * 0.15;
        $sellerEarnings = $grossRevenue * 0.85;
        $avgOrderValue = $totalOrdersCount > 0 ? ($grossRevenue / $totalOrdersCount) : 0;

        // Breakdown by order type
        $typeStats = (clone $query)
            ->selectRaw("COALESCE(order_type, 'Course') as type, count(*) as count, sum(amount) as revenue")
            ->groupBy('type')
            ->get();

        // Monthly trends for past 6 months
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $mStart = (clone $date)->startOfMonth();
            $mEnd = (clone $date)->endOfMonth();

            $mSales = (float) Order::whereNotIn('status', ['cancelled', 'failed', 'refunded'])
                ->whereBetween('created_at', [$mStart, $mEnd])
                ->sum('amount');

            $mOrders = Order::whereBetween('created_at', [$mStart, $mEnd])->count();

            $monthlyTrends[] = [
                'month'   => $date->format('M Y'),
                'revenue' => $mSales,
                'orders'  => $mOrders,
            ];
        }

        // Top 5 courses by sales
        $topCourses = Course::whereIn('status', ['approved', 'active'])
            ->latest('views')
            ->take(5)
            ->get();

        // Top 5 sellers
        $topSellers = Seller::with('businessDetail', 'user')
            ->take(5)
            ->get();

        $stats = [
            'gross_revenue'   => '₹' . number_format($grossRevenue, 2),
            'total_orders'    => number_format($totalOrdersCount),
            'net_commission'  => '₹' . number_format($netCommission, 2),
            'seller_earnings' => '₹' . number_format($sellerEarnings, 2),
            'avg_order_value' => '₹' . number_format($avgOrderValue, 2),
            'total_users'     => number_format(User::count()),
            'total_sellers'   => number_format(Seller::count()),
            'range'           => $range,
        ];

        return view('admin.reports.index', [
            'stats'         => $stats,
            'typeStats'     => $typeStats,
            'monthlyTrends' => $monthlyTrends,
            'topCourses'    => $topCourses,
            'topSellers'    => $topSellers,
            'range'         => $range,
        ]);
    }

    /**
     * Export reports to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $orders = Order::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="marketplace-sales-report-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order #', 'Customer Name', 'Customer Email', 'Item', 'Type', 'Amount', 'Status', 'Date']);

            foreach ($orders as $o) {
                fputcsv($handle, [
                    $o->order_number,
                    $o->customer_name,
                    $o->customer_email,
                    $o->item_title,
                    $o->order_type,
                    $o->amount,
                    $o->status,
                    $o->created_at ? $o->created_at->format('Y-m-d H:i') : '',
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
