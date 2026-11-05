<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\Promotion;
use App\Models\DiscountCoupon;
use Carbon\Carbon;

class PromotionsSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = Seller::all();
        if ($sellers->isEmpty()) {
            return;
        }

        foreach ($sellers as $seller) {
            Promotion::where('seller_id', $seller->id)->delete();
            DiscountCoupon::where('seller_id', $seller->id)->delete();

            $today = Carbon::parse('2026-11-04');

            // 1. Complete Digital Marketing Course (Banner Promotion - ₹1,500)
            Promotion::create([
                'seller_id'           => $seller->id,
                'promotion_code'      => 'PRM-' . ($seller->id * 1000 + 101),
                'listing_type'        => 'Course',
                'listing_title'       => 'Complete Digital Marketing Course',
                'listing_thumbnail'   => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?auto=format&fit=crop&w=300&q=80',
                'original_price'      => 2999,
                'offer_price'         => 2399,
                'discount_percentage' => 20,
                'promotion_type'      => 'Banner Promotion',
                'charge_amount'       => 1500, // ₹1,500
                'duration_days'       => 14,
                'start_date'          => $today->copy()->subDays(5),
                'end_date'            => $today->copy()->addDays(9),
                'status'              => 'Active',
                'views_count'         => 4280,
                'clicks_count'        => 640,
                'sales_count'         => 26,
                'revenue_generated'   => 18720,
                'banner_template'     => 'purple_gradient',
                'target_audience'     => 'Marketing Students & Entrepreneurs',
                'payment_status'      => 'Paid',
            ]);

            // 2. Python for Beginners (Featured Listing - ₹1,000)
            Promotion::create([
                'seller_id'           => $seller->id,
                'promotion_code'      => 'PRM-' . ($seller->id * 1000 + 102),
                'listing_type'        => 'Course',
                'listing_title'       => 'Python for Beginners & Data Science',
                'listing_thumbnail'   => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=300&q=80',
                'original_price'      => 3499,
                'offer_price'         => 2799,
                'discount_percentage' => 20,
                'promotion_type'      => 'Featured Listing',
                'charge_amount'       => 1000, // ₹1,000
                'duration_days'       => 14,
                'start_date'          => $today->copy()->subDays(10),
                'end_date'            => $today->copy()->addDays(4),
                'status'              => 'Active',
                'views_count'         => 3150,
                'clicks_count'        => 480,
                'sales_count'         => 18,
                'revenue_generated'   => 14400,
                'banner_template'     => 'blue_tech',
                'target_audience'     => 'Coding Aspirants',
                'payment_status'      => 'Paid',
            ]);

            // 3. Logo Design Standard Package (Social Media Kit - ₹2,000)
            Promotion::create([
                'seller_id'           => $seller->id,
                'promotion_code'      => 'PRM-' . ($seller->id * 1000 + 103),
                'listing_type'        => 'Service',
                'listing_title'       => 'Logo Design & Brand Identity Package',
                'listing_thumbnail'   => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=300&q=80',
                'original_price'      => 2500,
                'offer_price'         => 1999,
                'discount_percentage' => 20,
                'promotion_type'      => 'Social Media Kit',
                'charge_amount'       => 2000, // ₹2,000
                'duration_days'       => 14,
                'start_date'          => $today->copy()->subDays(12),
                'end_date'            => $today->copy()->addDays(2), // ending this week
                'status'              => 'Active',
                'views_count'         => 2120,
                'clicks_count'        => 290,
                'sales_count'         => 9,
                'revenue_generated'   => 7999,
                'banner_template'     => 'modern_minimal',
                'target_audience'     => 'Startups & Business Owners',
                'payment_status'      => 'Paid',
            ]);

            // 4. VCEC Education Center (Email Campaign - ₹2,500)
            Promotion::create([
                'seller_id'           => $seller->id,
                'promotion_code'      => 'PRM-' . ($seller->id * 1000 + 104),
                'listing_type'        => 'Business Listing',
                'listing_title'       => 'VCEC - Vinayak Computer Education Center',
                'listing_thumbnail'   => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=300&q=80',
                'original_price'      => 1499,
                'offer_price'         => 1199,
                'discount_percentage' => 20,
                'promotion_type'      => 'Email Campaign',
                'charge_amount'       => 2500, // ₹2,500
                'duration_days'       => 7,
                'start_date'          => $today->copy()->subDays(6),
                'end_date'            => $today->copy()->addDays(1), // ending this week
                'status'              => 'Active',
                'views_count'         => 1850,
                'clicks_count'        => 210,
                'sales_count'         => 7,
                'revenue_generated'   => 4200,
                'banner_template'     => 'gradient_orange',
                'target_audience'     => 'Local Gujarat Students',
                'payment_status'      => 'Paid',
            ]);

            // 5. Wireless Mouse Logitech M330 (Discount Offer - ₹1,000)
            Promotion::create([
                'seller_id'           => $seller->id,
                'promotion_code'      => 'PRM-' . ($seller->id * 1000 + 105),
                'listing_type'        => 'Product',
                'listing_title'       => 'Logitech M330 Silent Wireless Mouse',
                'listing_thumbnail'   => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=300&q=80',
                'original_price'      => 499,
                'offer_price'         => 399,
                'discount_percentage' => 20,
                'promotion_type'      => 'Discount Offer',
                'charge_amount'       => 1000, // ₹1,000
                'duration_days'       => 10,
                'start_date'          => $today->copy()->subDays(3),
                'end_date'            => $today->copy()->addDays(7),
                'status'              => 'Active',
                'views_count'         => 1050,
                'clicks_count'        => 160,
                'sales_count'         => 5,
                'revenue_generated'   => 3001,
                'banner_template'     => 'product_card',
                'target_audience'     => 'Students & Tech Enthusiasts',
                'payment_status'      => 'Paid',
            ]);

            // Seed Discount Coupons matching screenshot
            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'DIWALI50',
                'discount_type'    => 'percentage',
                'discount_value'   => 50,
                'min_order_amount' => 500,
                'applicable_to'    => 'all',
                'usage_limit'      => 1000,
                'used_count'       => 680,
                'valid_from'       => $today->copy()->subDays(15),
                'valid_until'      => $today->copy()->addDays(15),
                'status'           => 'Active',
            ]);

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'FIRST1000',
                'discount_type'    => 'flat',
                'discount_value'   => 1000,
                'min_order_amount' => 2000,
                'applicable_to'    => 'courses',
                'usage_limit'      => 500,
                'used_count'       => 320,
                'valid_from'       => $today->copy()->subDays(10),
                'valid_until'      => $today->copy()->addDays(50),
                'status'           => 'Active',
            ]);

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'WELCOME20',
                'discount_type'    => 'percentage',
                'discount_value'   => 20,
                'min_order_amount' => 500,
                'applicable_to'    => 'services',
                'usage_limit'      => 2000,
                'used_count'       => 1420,
                'valid_from'       => $today->copy()->subDays(30),
                'valid_until'      => $today->copy()->addDays(30),
                'status'           => 'Active',
            ]);

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'STUDENT30',
                'discount_type'    => 'percentage',
                'discount_value'   => 30,
                'min_order_amount' => 999,
                'applicable_to'    => 'courses',
                'usage_limit'      => 1000,
                'used_count'       => 240,
                'valid_from'       => $today->copy()->addDays(5),
                'valid_until'      => $today->copy()->addDays(30),
                'status'           => 'Scheduled',
            ]);

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'DIGITAL20',
                'discount_type'    => 'percentage',
                'discount_value'   => 20,
                'min_order_amount' => 1999,
                'applicable_to'    => 'courses',
                'usage_limit'      => 100,
                'used_count'       => 42,
                'valid_from'       => $today->copy()->subDays(15),
                'valid_until'      => $today->copy()->addDays(30),
                'status'           => 'Active',
            ]);

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'FESTIVE500',
                'discount_type'    => 'flat',
                'discount_value'   => 500,
                'min_order_amount' => 2499,
                'applicable_to'    => 'all',
                'usage_limit'      => 50,
                'used_count'       => 19,
                'valid_from'       => $today->copy()->subDays(10),
                'valid_until'      => $today->copy()->addDays(20),
                'status'           => 'Active',
            ]);

            DiscountCoupon::create([
                'seller_id'        => $seller->id,
                'coupon_code'      => 'WELCOME10',
                'discount_type'    => 'percentage',
                'discount_value'   => 10,
                'min_order_amount' => 499,
                'applicable_to'    => 'all',
                'usage_limit'      => 200,
                'used_count'       => 78,
                'valid_from'       => $today->copy()->subDays(30),
                'valid_until'      => $today->copy()->addDays(60),
                'status'           => 'Active',
            ]);
        }
    }
}

