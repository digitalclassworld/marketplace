<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerBusinessDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    /**
     * Display the initial seller dashboard.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $seller = $user->seller?->load(['businessDetail', 'user']);

        // Fallback for Super Admin viewing the seller dashboard
        if (!$seller && $user->isSuperAdmin()) {
            $seller = Seller::with(['businessDetail', 'user'])->first();
        }

        // Real Database Metric Aggregations (defaults to 0 for new sellers)
        $ordersCount = $seller ? $seller->orders()->count() : 0;
        $totalEarnings = $seller ? (float) $seller->orders()->where('status', '!=', 'cancelled')->sum('amount') : 0.0;

        $thisMonthOrders = $seller ? $seller->orders()->where('placed_at', '>=', now()->startOfMonth())->count() : 0;
        $thisMonthEarnings = $seller ? (float) $seller->orders()->where('placed_at', '>=', now()->startOfMonth())->where('status', '!=', 'cancelled')->sum('amount') : 0.0;

        $totalCustomers = $seller ? $seller->orders()->distinct('customer_email')->count('customer_email') : 0;
        $thisMonthCustomers = $seller ? $seller->orders()->where('placed_at', '>=', now()->startOfMonth())->distinct('customer_email')->count('customer_email') : 0;

        $coursesCount = $seller ? $seller->courses()->count() : 0;
        $servicesCount = $seller ? $seller->services()->count() : 0;
        $productsCount = $seller ? $seller->products()->count() : 0;
        $listingsCount = $seller ? $seller->businessListings()->count() : 0;

        // Real Category Earnings
        $courseRevenue = $seller ? (float) $seller->orders()->where('order_type', 'Course')->where('status', '!=', 'cancelled')->sum('amount') : 0.0;
        $serviceRevenue = $seller ? (float) $seller->orders()->where('order_type', 'Service')->where('status', '!=', 'cancelled')->sum('amount') : 0.0;
        $productRevenue = $seller ? (float) $seller->orders()->where('order_type', 'Product')->where('status', '!=', 'cancelled')->sum('amount') : 0.0;
        $listingRevenue = $seller ? (float) $seller->orders()->where('order_type', 'Business')->where('status', '!=', 'cancelled')->sum('amount') : 0.0;

        $categoryStats = [
            'courses' => [
                'amount'  => $courseRevenue,
                'percent' => $totalEarnings > 0 ? round(($courseRevenue / $totalEarnings) * 100) : 0,
            ],
            'services' => [
                'amount'  => $serviceRevenue,
                'percent' => $totalEarnings > 0 ? round(($serviceRevenue / $totalEarnings) * 100) : 0,
            ],
            'products' => [
                'amount'  => $productRevenue,
                'percent' => $totalEarnings > 0 ? round(($productRevenue / $totalEarnings) * 100) : 0,
            ],
            'listings' => [
                'amount'  => $listingRevenue,
                'percent' => $totalEarnings > 0 ? round(($listingRevenue / $totalEarnings) * 100) : 0,
            ],
        ];

        // 7-day sales timeline for chart
        $chartLabels = [];
        $chartCourses = [];
        $chartServices = [];
        $chartProducts = [];
        $chartListings = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $chartLabels[] = $day->format('M d');

            if ($seller && $ordersCount > 0) {
                $chartCourses[]  = (float) $seller->orders()->where('order_type', 'Course')->whereDate('placed_at', $day->toDateString())->where('status', '!=', 'cancelled')->sum('amount');
                $chartServices[] = (float) $seller->orders()->where('order_type', 'Service')->whereDate('placed_at', $day->toDateString())->where('status', '!=', 'cancelled')->sum('amount');
                $chartProducts[] = (float) $seller->orders()->where('order_type', 'Product')->whereDate('placed_at', $day->toDateString())->where('status', '!=', 'cancelled')->sum('amount');
                $chartListings[] = (float) $seller->orders()->where('order_type', 'Business')->whereDate('placed_at', $day->toDateString())->where('status', '!=', 'cancelled')->sum('amount');
            } else {
                $chartCourses[]  = 0;
                $chartServices[] = 0;
                $chartProducts[] = 0;
                $chartListings[] = 0;
            }
        }

        $chartData = [
            'labels'   => $chartLabels,
            'courses'  => $chartCourses,
            'services' => $chartServices,
            'products' => $chartProducts,
            'listings' => $chartListings,
        ];

        $stats = [
            'total_orders'     => $ordersCount,
            'orders_growth'    => $ordersCount > 0 ? '+0%' : '0%',
            'orders_sub'       => $thisMonthOrders . ' this month',
            'total_earnings'   => $totalEarnings,
            'earnings_growth'  => $totalEarnings > 0 ? '+0%' : '0%',
            'earnings_sub'     => '₹' . number_format($thisMonthEarnings) . ' this month',
            'total_views'      => 0,
            'views_growth'     => '0%',
            'views_sub'        => '0 this month',
            'total_customers'  => $totalCustomers,
            'customers_growth' => $totalCustomers > 0 ? '+0%' : '0%',
            'customers_sub'    => $thisMonthCustomers . ' this month',
            'courses_count'    => $coursesCount,
            'courses_pending'  => $seller ? $seller->courses()->where('status', 'pending')->count() : 0,
            'services_count'   => $servicesCount,
            'services_pending' => $seller ? $seller->services()->where('status', 'pending')->count() : 0,
            'products_count'   => $productsCount,
            'products_pending' => $seller ? $seller->products()->where('status', 'pending')->count() : 0,
            'listings_count'   => $listingsCount,
            'listings_pending' => $seller ? $seller->businessListings()->where('status', 'pending')->count() : 0,
        ];

        return view('seller.dashboard', [
            'seller'        => $seller,
            'user'          => $user,
            'stats'         => $stats,
            'categoryStats' => $categoryStats,
            'chartData'     => $chartData,
        ]);
    }

    /**
     * Protected selling operations - Protected by EnsureSellerApproved middleware
     */
    public function createCourse(): View
    {
        return view('seller.listings-placeholder', [
            'type'  => 'Course',
            'title' => 'Create & Upload Online Course',
        ]);
    }

    public function createService(): View
    {
        return view('seller.listings-placeholder', [
            'type'  => 'Service',
            'title' => 'List Professional Service',
        ]);
    }

    public function createProduct(): View
    {
        return view('seller.listings-placeholder', [
            'type'  => 'Product',
            'title' => 'Add Marketplace Product',
        ]);
    }

    public function createListing(): View
    {
        return view('seller.listings-placeholder', [
            'type'  => 'Business Listing',
            'title' => 'Publish Business Listing',
        ]);
    }
}
