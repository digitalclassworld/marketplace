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
                @mkdir($dir, 0777, true);
            }
            @chmod($dir, 0777);
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

                // Restore Meshwa Patel's account if it was wiped before persistent storage was mounted
                if (\App\Models\User::where('email', 'meshva@gmail.com')->doesntExist() && \Illuminate\Support\Facades\Schema::hasTable('sellers')) {
                    $mUser = \App\Models\User::create([
                        'name'              => 'Meshwa Patel',
                        'email'             => 'meshva@gmail.com',
                        'phone'             => '9876543210',
                        'password'          => \Illuminate\Support\Facades\Hash::make('Seller@123'),
                        'role'              => 'seller',
                        'email_verified_at' => now(),
                    ]);

                    $mSeller = \App\Models\Seller::create([
                        'user_id'             => $mUser->id,
                        'seller_code'         => 'DC-SELL-000001',
                        'account_type'        => \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL,
                        'seller_status'       => \App\Models\Seller::STATUS_ACTIVE,
                        'verification_status' => \App\Models\Seller::VERIFICATION_VERIFIED,
                        'registration_date'   => now()->subHours(2),
                        'approved_at'         => now(),
                        'approved_by'         => 1,
                    ]);

                    if (\Illuminate\Support\Facades\Schema::hasTable('seller_business_details')) {
                        \App\Models\SellerBusinessDetail::create([
                            'seller_id'      => $mSeller->id,
                            'business_name'  => "Meshwa Patel's Store",
                            'business_email' => 'meshva@gmail.com',
                            'business_phone' => '9876543210',
                            'city'           => 'Ahmedabad',
                            'state'          => 'Gujarat',
                        ]);
                    }
                }

                // Purge seeded dummy business listings so only real user-uploaded businesses appear
                if (\Illuminate\Support\Facades\Schema::hasTable('business_listings')) {
                    \App\Models\BusinessListing::whereIn('business_name', [
                        'VCEC - Vinayak Computer Education Center',
                        'VCEC Computer Education',
                        'Shree Coaching Classes',
                        'TechZone Coaching Institute',
                        'Kids Planet Play School',
                        'Little Angels Play School',
                        'FitZone Gym & Fitness',
                        'Digital World Laptop Repair',
                        'Tasty Bites Restaurant',
                        'Style Salon & Beauty Care',
                        'AutoCare Service Center',
                    ])->delete();
                }
            }
        } catch (\Throwable $e) {
            // Ignore during early migrations or db failures
        }
    }
}
