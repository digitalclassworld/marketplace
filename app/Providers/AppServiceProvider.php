<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Ensure all essential storage directories exist with write permissions
        // (Critical on Coolify when a persistent volume is newly mounted over /app/storage)
        $storageDirs = [
            storage_path('framework'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/cache'),
            storage_path('framework/cache/data'),
            storage_path('logs'),
            storage_path('app'),
            storage_path('app/public'),
        ];
        foreach ($storageDirs as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
        }

        // 2. Ensure SQLite database file exists in storage if SQLite connection is used
        try {
            $storageDb = storage_path('database.sqlite');
            $defaultDb = database_path('database.sqlite');
            if (!file_exists($storageDb) || filesize($storageDb) === 0) {
                if (file_exists($defaultDb) && filesize($defaultDb) > 0) {
                    @copy($defaultDb, $storageDb);
                } else {
                    @touch($storageDb);
                }
            }
        } catch (\Throwable $e) {
            // Ignore during setup
        }

        // 3. Force HTTPS scheme on production or when behind reverse proxies (Coolify Traefik / SSL)
        if (
            app()->environment('production') ||
            str_starts_with((string) config('app.url'), 'https://') ||
            request()->header('X-Forwarded-Proto') === 'https' ||
            request()->isSecure()
        ) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // 4. Share Super Admin URL safely across all views on view composition
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $superAdminUrl = config('app.super_admin_url') ?: url('/super/admin/login');
            $view->with('superAdminUrl', $superAdminUrl);
        });

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                if (!\Illuminate\Support\Facades\Cache::has('superadmin_verified_boot')) {
                    \App\Models\User::updateOrCreate(
                        ['email' => 'superadmin@gmail.com'],
                        [
                            'name'              => 'Super Admin',
                            'phone'             => '9876543210',
                            'password'          => \Illuminate\Support\Facades\Hash::make('Admin@123'),
                            'role'              => 'superadmin',
                            'email_verified_at' => now(),
                        ]
                    );
                    \Illuminate\Support\Facades\Cache::put('superadmin_verified_boot', true, 300);
                }

                // Auto-provision sample pending approval items if database has none
                if (\Illuminate\Support\Facades\Schema::hasTable('sellers')) {
                    if (\App\Models\Seller::where('seller_status', \App\Models\Seller::STATUS_PENDING_APPROVAL)->count() === 0) {
                        $pUser = \App\Models\User::firstOrCreate(
                            ['email' => 'techskills.academy@gmail.com'],
                            [
                                'name' => 'Tech Skills Academy',
                                'phone' => '9876543219',
                                'password' => \Illuminate\Support\Facades\Hash::make('Seller@123'),
                                'role' => 'seller',
                                'email_verified_at' => now(),
                            ]
                        );
                        $pSeller = \App\Models\Seller::firstOrCreate(
                            ['user_id' => $pUser->id],
                            [
                                'seller_code' => 'DC-SELL-000088',
                                'account_type' => \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE,
                                'seller_status' => \App\Models\Seller::STATUS_PENDING_APPROVAL,
                                'verification_status' => \App\Models\Seller::VERIFICATION_PENDING,
                                'registration_date' => now(),
                            ]
                        );
                        \App\Models\SellerBusinessDetail::firstOrCreate(
                            ['seller_id' => $pSeller->id],
                            [
                                'business_name' => 'Tech Skills Academy',
                                'business_category' => 'Technology & Education',
                                'city' => 'Surat',
                            ]
                        );

                        if (\Illuminate\Support\Facades\Schema::hasTable('courses')) {
                            \App\Models\Course::firstOrCreate(
                                ['title' => 'Full Stack Web Development Bootcamp'],
                                [
                                    'seller_id' => $pSeller->id,
                                    'slug' => 'full-stack-web-development-bootcamp',
                                    'category' => 'Programming',
                                    'language' => 'Hindi',
                                    'level' => 'Beginner',
                                    'short_description' => 'Complete full stack web development from scratch with HTML, CSS, JavaScript, and Laravel.',
                                    'price' => 4999.00,
                                    'discount_price' => 2499.00,
                                    'status' => 'pending',
                                ]
                            );
                        }

                        if (\Illuminate\Support\Facades\Schema::hasTable('business_listings')) {
                            \App\Models\BusinessListing::firstOrCreate(
                                ['business_name' => 'Apex Computer Education Institute'],
                                [
                                    'seller_id' => $pSeller->id,
                                    'slug' => 'apex-computer-education-institute',
                                    'category' => 'Coaching Institute',
                                    'sub_category' => 'Computer Training, Tally, CCC',
                                    'city' => 'Ahmedabad',
                                    'address' => 'Navrangpura, Ahmedabad',
                                    'phone' => '9876543219',
                                    'status' => 'pending',
                                    'plan_name' => 'Featured Plan',
                                    'plan_price' => 999.00,
                                ]
                            );
                        }

                        if (\Illuminate\Support\Facades\Schema::hasTable('services')) {
                            \App\Models\Service::firstOrCreate(
                                ['title' => 'Custom Website & Web Application Development'],
                                [
                                    'seller_id' => $pSeller->id,
                                    'slug' => 'custom-website-and-web-application-development',
                                    'category' => 'Web Development',
                                    'short_description' => 'Professional custom web development with modern technologies and responsive design.',
                                    'price' => 14999.00,
                                    'delivery_days' => 7,
                                    'package_name' => 'Standard Package',
                                    'status' => 'pending',
                                ]
                            );
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Ignore during early migrations or db failures
        }
    }
}
