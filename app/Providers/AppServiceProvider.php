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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                if (!\App\Models\User::where('role', 'superadmin')->exists()) {
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
