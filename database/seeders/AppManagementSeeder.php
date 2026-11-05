<?php

namespace Database\Seeders;

use App\Models\AppFeature;
use App\Models\AppSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppManagementSeeder extends Seeder
{
    public function run(): void
    {
        AppSetting::truncate();
        AppFeature::truncate();

        // 3 Platforms
        AppSetting::create([
            'platform'          => 'android',
            'app_name'          => 'Digital Class',
            'package_name'      => 'com.digitalclass.app',
            'bundle_id'         => 'com.digitalclass.app',
            'description'       => 'Your complete educational ecosystem - Courses, Services, Marketplace and Institute Management.',
            'short_description' => 'Learn. Teach. Grow. All in one app - Digital Class.',
            'current_version'   => 'v2.4.0',
            'status'            => 'Live',
            'total_downloads'   => 90540,
            'active_users'      => 12840,
            'rating'            => 4.6,
            'crash_rate'        => 0.8,
            'last_released_at'  => Carbon::parse('2026-10-12 10:30:00'),
            'icon_url'          => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=200&q=80',
            'splash_url'        => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=300&q=80',
            'login_screen_url'  => 'https://images.unsplash.com/photo-1555421689-491a97ff2040?auto=format&fit=crop&w=300&q=80',
            'home_screen_url'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=300&q=80',
        ]);

        AppSetting::create([
            'platform'          => 'ios',
            'app_name'          => 'Digital Class',
            'package_name'      => 'com.digitalclass.app',
            'bundle_id'         => 'com.digitalclass.app',
            'description'       => 'Your complete educational ecosystem - Courses, Services, Marketplace and Institute Management.',
            'short_description' => 'Learn. Teach. Grow. All in one app - Digital Class.',
            'current_version'   => 'v2.4.0',
            'status'            => 'Live',
            'total_downloads'   => 45200,
            'active_users'      => 8120,
            'rating'            => 4.7,
            'crash_rate'        => 0.6,
            'last_released_at'  => Carbon::parse('2026-10-12 10:30:00'),
        ]);

        AppSetting::create([
            'platform'          => 'pwa',
            'app_name'          => 'Digital Class Web',
            'package_name'      => 'com.digitalclass.pwa',
            'bundle_id'         => 'com.digitalclass.pwa',
            'description'       => 'Progressive Web App for Digital Class Educational World.',
            'short_description' => 'Fast and lightweight marketplace app in your browser.',
            'current_version'   => 'v1.8.0',
            'status'            => 'Beta',
            'total_downloads'   => 21400,
            'active_users'      => 3420,
            'rating'            => 4.5,
            'crash_rate'        => 0.4,
            'last_released_at'  => Carbon::parse('2026-10-10 09:00:00'),
        ]);

        // 13 App Features
        $features = [
            [
                'key'         => 'home_dashboard',
                'name'        => 'Home Dashboard',
                'description' => 'Overview & quick actions',
                'icon'        => 'fa-house',
                'color'       => '#10b981',
                'is_enabled'  => true,
                'order_index' => 1,
            ],
            [
                'key'         => 'courses',
                'name'        => 'Courses',
                'description' => 'Browse, buy and learn courses',
                'icon'        => 'fa-graduation-cap',
                'color'       => '#ef4444',
                'is_enabled'  => true,
                'order_index' => 2,
            ],
            [
                'key'         => 'services',
                'name'        => 'Services',
                'description' => 'View and book services',
                'icon'        => 'fa-briefcase',
                'color'       => '#3b82f6',
                'is_enabled'  => true,
                'order_index' => 3,
            ],
            [
                'key'         => 'products',
                'name'        => 'Products',
                'description' => 'Browse and purchase products',
                'icon'        => 'fa-box-open',
                'color'       => '#f59e0b',
                'is_enabled'  => true,
                'order_index' => 4,
            ],
            [
                'key'         => 'business_listings',
                'name'        => 'Business Listings',
                'description' => 'Explore institutes and businesses',
                'icon'        => 'fa-building',
                'color'       => '#8b5cf6',
                'is_enabled'  => true,
                'order_index' => 5,
            ],
            [
                'key'         => 'cart_checkout',
                'name'        => 'Cart & Checkout',
                'description' => 'Unified cart and secure payment',
                'icon'        => 'fa-cart-shopping',
                'color'       => '#10b981',
                'is_enabled'  => true,
                'order_index' => 6,
            ],
            [
                'key'         => 'user_profile',
                'name'        => 'User Profile',
                'description' => 'Manage profile, orders and certificates',
                'icon'        => 'fa-user',
                'color'       => '#3b82f6',
                'is_enabled'  => true,
                'order_index' => 7,
            ],
            [
                'key'         => 'notifications',
                'name'        => 'Notifications',
                'description' => 'Push notifications and in-app alerts',
                'icon'        => 'fa-bell',
                'color'       => '#ef4444',
                'is_enabled'  => true,
                'order_index' => 8,
            ],
            [
                'key'         => 'messages',
                'name'        => 'Messages',
                'description' => 'Chat with institutes and service providers',
                'icon'        => 'fa-comments',
                'color'       => '#06b6d4',
                'is_enabled'  => true,
                'order_index' => 9,
            ],
            [
                'key'         => 'reviews_ratings',
                'name'        => 'Reviews & Ratings',
                'description' => 'Give and manage reviews',
                'icon'        => 'fa-star',
                'color'       => '#f59e0b',
                'is_enabled'  => true,
                'order_index' => 10,
            ],
            [
                'key'         => 'my_learning',
                'name'        => 'My Learning',
                'description' => 'Access purchased courses',
                'icon'        => 'fa-book-open',
                'color'       => '#10b981',
                'is_enabled'  => true,
                'order_index' => 11,
            ],
            [
                'key'         => 'wallet',
                'name'        => 'Wallet',
                'description' => 'Manage refunds and wallet balance',
                'icon'        => 'fa-wallet',
                'color'       => '#6b7280',
                'is_enabled'  => false,
                'order_index' => 12,
            ],
            [
                'key'         => 'multi_language',
                'name'        => 'Multi-language',
                'description' => 'Support for multiple languages',
                'icon'        => 'fa-language',
                'color'       => '#3b82f6',
                'is_enabled'  => true,
                'order_index' => 13,
            ],
        ];

        foreach ($features as $f) {
            AppFeature::create($f);
        }
    }
}

