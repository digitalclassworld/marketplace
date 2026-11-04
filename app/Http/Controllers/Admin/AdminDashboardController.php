<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\Course;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the Super Admin Dashboard with real database-based metrics.
     */
    public function index(): View
    {
        // Real database statistics
        $totalSellers     = Seller::count();
        $pendingSellers   = Seller::whereIn('seller_status', [Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending'])->count();
        $activeSellers    = Seller::whereIn('seller_status', [Seller::STATUS_ACTIVE, 'Active', 'active'])->count();
        $rejectedSellers  = Seller::whereIn('seller_status', [Seller::STATUS_REJECTED, 'Rejected', 'rejected'])->count();
        $suspendedSellers = Seller::whereIn('seller_status', [Seller::STATUS_SUSPENDED, 'Suspended', 'suspended'])->count();
        $totalUsers       = User::count();

        // Catalog statistics from real database tables
        $totalCourses     = Course::count();
        $pendingCourses   = Course::where('status', 'pending')->count();
        $totalProducts    = Product::count();
        $pendingProducts  = Product::where('status', 'pending')->count();
        $totalServices    = Service::count();
        $pendingServices  = Service::where('status', 'pending')->count();
        $totalListings    = BusinessListing::count();
        $pendingListings  = BusinessListing::where('status', 'pending')->count();

        // Recent sellers for review table
        $recentSellers = Seller::with(['user', 'businessDetail'])
            ->latest()
            ->take(8)
            ->get();

        // Pending sellers awaiting approval
        $pendingList = Seller::with(['user', 'businessDetail'])
            ->whereIn('seller_status', [Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                'total_sellers'          => $totalSellers,
                'pending_sellers'        => $pendingSellers,
                'active_sellers'         => $activeSellers,
                'rejected_sellers'       => $rejectedSellers,
                'suspended_sellers'      => $suspendedSellers,
                'rejected_and_suspended' => $rejectedSellers + $suspendedSellers,
                'total_users'            => $totalUsers,
                'total_courses'          => $totalCourses,
                'pending_courses'        => $pendingCourses,
                'total_products'         => $totalProducts,
                'pending_products'       => $pendingProducts,
                'total_services'         => $totalServices,
                'pending_services'       => $pendingServices,
                'total_listings'         => $totalListings,
                'pending_listings'       => $pendingListings,
            ],
            'recentSellers' => $recentSellers,
            'pendingList'   => $pendingList,
        ]);
    }

    /**
     * Reusable placeholder for modules scheduled for upcoming phases.
     */
    public function comingSoon(Request $request, string $module): View
    {
        $titles = [
            'users'         => 'Users & Members Management',
            'courses'       => 'Courses Management',
            'services'      => 'Services Management',
            'products'      => 'Products Management',
            'listings'      => 'Business Listings Management',
            'orders'        => 'Orders & Bookings Management',
            'banners'       => 'Banners & Promotions Management',
            'coupons'       => 'Coupons & Offers Management',
            'reviews'       => 'Reviews & Ratings Management',
            'messages'      => 'Support Messages & Live Chat',
            'leads'         => 'Marketing & Leads Management',
            'blog'          => 'Blog & CMS Management',
            'notifications' => 'Push & Email Notifications',
            'app'           => 'App Management (Android / iOS)',
            'website'       => 'Website & Page Management',
            'seo'           => 'SEO & Meta Tag Management',
            'settings'      => 'General Platform Settings',
        ];

        $title = $titles[$module] ?? ucwords(str_replace('-', ' ', $module)) . ' Management';

        return view('admin.coming-soon', [
            'moduleTitle' => $title,
            'moduleSlug'  => $module,
        ]);
    }
}

