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
            }
        } catch (\Throwable $e) {
            // Ignore during early migrations or db failures
        }
    }
}
