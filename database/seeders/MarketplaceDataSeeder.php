<?php

namespace Database\Seeders;

use App\Models\BusinessListing;
use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SellerBusinessDetail;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Update or create Super Admin 'Hitesh Mohkar'
        $superAdmin = User::where('role', 'superadmin')->first();
        if ($superAdmin) {
            $superAdmin->update([
                'name' => 'Hitesh Mohkar',
                'avatar' => $superAdmin->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
            ]);
        }

        // 2. Realistic Sellers from Dashboard Screenshot
        $sellersData = [
            [
                'name' => 'Vinayak Joshi',
                'email' => 'vinayak@vcec.in',
                'store_name' => 'VCEC - Vinayak',
                'avatar' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=150&auto=format&fit=crop&q=80',
                'account_type' => Seller::ACCOUNT_TYPE_INSTITUTE,
                'status' => Seller::STATUS_ACTIVE,
                'city' => 'Ahmedabad',
                'category' => 'Technology & IT Institute',
            ],
            [
                'name' => 'Tech Skills Academy',
                'email' => 'contact@techskills.edu',
                'store_name' => 'Tech Skills Academy',
                'avatar' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=150&auto=format&fit=crop&q=80',
                'account_type' => Seller::ACCOUNT_TYPE_INSTITUTE,
                'status' => Seller::STATUS_PENDING_APPROVAL,
                'city' => 'Surat',
                'category' => 'Professional Education',
            ],
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul@rahuldigital.com',
                'store_name' => 'Rahul Digital',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',
                'account_type' => Seller::ACCOUNT_TYPE_INDIVIDUAL,
                'status' => Seller::STATUS_ACTIVE,
                'city' => 'Vadodara',
                'category' => 'Digital Marketing',
            ],
            [
                'name' => 'Design Studio Pro',
                'email' => 'hello@designstudiopro.com',
                'store_name' => 'Design Studio Pro',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'account_type' => Seller::ACCOUNT_TYPE_AGENCY,
                'status' => Seller::STATUS_ACTIVE,
                'city' => 'Mumbai',
                'category' => 'Creative & UI/UX Design',
            ],
            [
                'name' => 'EduNext Institute',
                'email' => 'info@edunext.org',
                'store_name' => 'EduNext Institute',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
                'account_type' => Seller::ACCOUNT_TYPE_INSTITUTE,
                'status' => Seller::STATUS_PENDING_APPROVAL,
                'city' => 'Pune',
                'category' => 'Online Certifications',
            ],
        ];

        $createdSellers = [];

        foreach ($sellersData as $index => $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone' => '98765' . str_pad($index + 10, 5, '0', STR_PAD_LEFT),
                    'password' => Hash::make('Seller@123'),
                    'role' => 'seller',
                    'avatar' => $data['avatar'],
                    'email_verified_at' => now(),
                ]
            );

            $code = 'DC-SELL-' . str_pad($user->id + 100, 6, '0', STR_PAD_LEFT);
            $seller = Seller::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'seller_code' => $code,
                    'account_type' => $data['account_type'],
                    'seller_status' => $data['status'],
                    'verification_status' => $data['status'] === Seller::STATUS_ACTIVE ? Seller::VERIFICATION_VERIFIED : Seller::VERIFICATION_PENDING,
                    'registration_date' => now()->subDays(5 - $index),
                    'approved_at' => $data['status'] === Seller::STATUS_ACTIVE ? now()->subDays(4 - $index) : null,
                ]
            );

            SellerBusinessDetail::updateOrCreate(
                ['seller_id' => $seller->id],
                [
                    'business_name' => $data['store_name'],
                    'business_email' => $data['email'],
                    'business_phone' => $user->phone,
                    'business_category' => $data['category'],
                    'city' => $data['city'],
                    'state' => 'Gujarat',
                    'logo' => $data['avatar'],
                ]
            );

            $createdSellers[] = $seller;
        }

        $primarySeller = $createdSellers[0] ?? Seller::first();

        // 3. Populate Courses if empty
        if (Course::count() === 0 && $primarySeller) {
            $courses = [
                ['title' => 'Digital Marketing Mastery', 'category' => 'Marketing', 'price' => 4999, 'thumb' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'Tally Prime Complete Course', 'category' => 'Finance & Accounting', 'price' => 2999, 'thumb' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'Python for Beginners & Data Science', 'category' => 'Programming', 'price' => 3499, 'thumb' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'AI Tools & ChatGPT for Business', 'category' => 'Artificial Intelligence', 'price' => 1999, 'thumb' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'Full Stack Web Development (MERN)', 'category' => 'Web Development', 'price' => 7999, 'thumb' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&auto=format&fit=crop&q=80'],
            ];

            foreach ($courses as $c) {
                Course::create([
                    'seller_id' => $primarySeller->id,
                    'title' => $c['title'],
                    'slug' => Str::slug($c['title']) . '-' . rand(100, 999),
                    'category' => $c['category'],
                    'language' => 'English / Hindi',
                    'level' => 'All Levels',
                    'short_description' => 'Comprehensive masterclass with live projects, certification, and lifetime access.',
                    'price' => $c['price'],
                    'discount_price' => $c['price'] * 0.8,
                    'thumbnail' => $c['thumb'],
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
            }
        }

        // 4. Populate Services if empty
        if (Service::count() === 0 && $primarySeller) {
            $services = [
                ['title' => 'Custom Website Development', 'category' => 'Development', 'price' => 14999, 'thumb' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'Professional Logo & Brand Identity', 'category' => 'Design', 'price' => 2500, 'thumb' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'Social Media Growth Management', 'category' => 'Marketing', 'price' => 5000, 'thumb' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'SEO Audit & Technical Ranking', 'category' => 'SEO', 'price' => 3999, 'thumb' => 'https://images.unsplash.com/photo-1571721795195-a2ca2d3370a9?w=300&auto=format&fit=crop&q=80'],
            ];

            foreach ($services as $s) {
                Service::create([
                    'seller_id' => $primarySeller->id,
                    'title' => $s['title'],
                    'slug' => Str::slug($s['title']) . '-' . rand(100, 999),
                    'category' => $s['category'],
                    'short_description' => 'Professional service delivered on time with revision guarantees.',
                    'delivery_days' => 5,
                    'package_name' => 'Standard Professional Plan',
                    'price' => $s['price'],
                    'thumbnail' => $s['thumb'],
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
            }
        }

        // 5. Populate Products if empty
        if (Product::count() === 0 && $primarySeller) {
            $products = [
                ['title' => 'Wireless Mouse Logitech M330 Silent', 'category' => 'Electronics', 'price' => 499, 'mrp' => 899, 'thumb' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'Laptop Stand Adjustable Aluminum Ergonomic', 'category' => 'Accessories', 'price' => 1299, 'mrp' => 1999, 'thumb' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'USB-C Hub 7-in-1 Multiport Adapter', 'category' => 'Electronics', 'price' => 899, 'mrp' => 1499, 'thumb' => 'https://images.unsplash.com/photo-1600080972464-8e5f35f63d08?w=300&auto=format&fit=crop&q=80'],
                ['title' => 'HP 15s Ryzen 5 8GB / 512GB SSD Laptop', 'category' => 'Computers', 'price' => 42999, 'mrp' => 49999, 'thumb' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&auto=format&fit=crop&q=80'],
            ];

            foreach ($products as $p) {
                Product::create([
                    'seller_id' => $primarySeller->id,
                    'title' => $p['title'],
                    'slug' => Str::slug($p['title']) . '-' . rand(100, 999),
                    'category' => $p['category'],
                    'product_type' => 'Physical',
                    'description' => 'Genuine high quality product with full warranty and fast shipping.',
                    'sku' => 'SKU-' . rand(10000, 99999),
                    'mrp' => $p['mrp'],
                    'price' => $p['price'],
                    'stock_quantity' => 50,
                    'thumbnail' => $p['thumb'],
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
            }
        }

        // 6. Populate Business Listings if empty
        if (BusinessListing::count() === 0 && $primarySeller) {
            $listings = [
                ['name' => 'VCEC Computer Education Center', 'category' => 'Computer Institute', 'city' => 'Ahmedabad', 'logo' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=150&auto=format&fit=crop&q=80'],
                ['name' => 'Tech Skills Academy Hub', 'category' => 'IT Training Hub', 'city' => 'Surat', 'logo' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=150&auto=format&fit=crop&q=80'],
                ['name' => 'Design Studio Pro Creative Agency', 'category' => 'Creative Agency', 'city' => 'Mumbai', 'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80'],
                ['name' => 'EduNext Professional Coaching', 'category' => 'Coaching & Mentorship', 'city' => 'Pune', 'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80'],
            ];

            foreach ($listings as $l) {
                BusinessListing::create([
                    'seller_id' => $primarySeller->id,
                    'business_name' => $l['name'],
                    'slug' => Str::slug($l['name']) . '-' . rand(100, 999),
                    'category' => $l['category'],
                    'listing_type' => 'Featured Institution',
                    'city' => $l['city'],
                    'state' => 'Gujarat',
                    'phone' => '9876543210',
                    'email' => 'contact@' . Str::slug($l['name']) . '.com',
                    'logo' => $l['logo'],
                    'plan_name' => 'Premium Verified Listing',
                    'plan_price' => 1499,
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
            }
        }

        // 7. Populate Core Orders if empty
        if (Order::count() === 0 && $primarySeller) {
            $orders = [
                [
                    'seller_id' => $primarySeller->id,
                    'order_number' => '#DC12568',
                    'customer_name' => 'Priya Patel',
                    'customer_city' => 'Ahmedabad, GJ',
                    'customer_email' => 'priya.patel@email.com',
                    'customer_phone' => '+91 98765 43210',
                    'customer_avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
                    'order_type' => 'Course',
                    'item_title' => 'Digital Marketing Mastery',
                    'item_subtext' => '1 Course Access',
                    'item_thumbnail' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=100&auto=format&fit=crop&q=80',
                    'amount' => 2999.00,
                    'subtotal' => 2999.00,
                    'discount' => 0.00,
                    'status' => 'completed',
                    'placed_at' => now()->subDays(3)->setTime(10, 24),
                    'timeline' => [
                        ['title' => 'Order Placed', 'time' => 'Oct 30, 2026, 10:24 AM', 'desc' => 'Order placed.'],
                        ['title' => 'Payment Completed', 'time' => 'Oct 30, 2026, 10:25 AM', 'desc' => 'Payment received.'],
                        ['title' => 'Access Granted', 'time' => 'Oct 30, 2026, 10:26 AM', 'desc' => 'Course access enabled.'],
                        ['title' => 'Order Completed', 'time' => 'Oct 30, 2026, 10:26 AM', 'desc' => 'Successfully completed.'],
                    ],
                ],
                [
                    'seller_id' => $primarySeller->id,
                    'order_number' => '#DC12567',
                    'customer_name' => 'Amit Shah',
                    'customer_city' => 'Surat, GJ',
                    'customer_email' => 'amit.shah@email.com',
                    'customer_phone' => '+91 98251 23456',
                    'customer_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                    'order_type' => 'Service',
                    'item_title' => 'Website Development',
                    'item_subtext' => 'Custom Website (Business)',
                    'item_thumbnail' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=100&auto=format&fit=crop&q=80',
                    'amount' => 15000.00,
                    'subtotal' => 15000.00,
                    'discount' => 0.00,
                    'status' => 'in_progress',
                    'placed_at' => now()->subDays(4)->setTime(16, 15),
                    'timeline' => [
                        ['title' => 'Order Placed', 'time' => 'Oct 29, 2026, 04:15 PM', 'desc' => 'Order placed.'],
                        ['title' => 'Payment Completed', 'time' => 'Oct 29, 2026, 04:16 PM', 'desc' => 'Payment received.'],
                        ['title' => 'Work in Progress', 'time' => 'Oct 29, 2026, 05:00 PM', 'desc' => 'Development ongoing.'],
                    ],
                ],
                [
                    'seller_id' => $primarySeller->id,
                    'order_number' => '#DC12566',
                    'customer_name' => 'Neha Desai',
                    'customer_city' => 'Vadodara, GJ',
                    'customer_email' => 'neha.desai@email.com',
                    'customer_phone' => '+91 99042 87654',
                    'customer_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80',
                    'order_type' => 'Product',
                    'item_title' => 'Wireless Mouse Logitech M330',
                    'item_subtext' => 'Logitech M330',
                    'item_thumbnail' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=100&auto=format&fit=crop&q=80',
                    'amount' => 499.00,
                    'subtotal' => 499.00,
                    'discount' => 0.00,
                    'status' => 'shipped',
                    'placed_at' => now()->subDays(5)->setTime(14, 30),
                    'timeline' => [
                        ['title' => 'Order Placed', 'time' => 'Oct 28, 2026, 02:30 PM', 'desc' => 'Order received.'],
                        ['title' => 'Dispatched', 'time' => 'Oct 29, 2026, 10:00 AM', 'desc' => 'Shipped via BlueDart.'],
                    ],
                ],
                [
                    'seller_id' => $primarySeller->id,
                    'order_number' => '#DC12565',
                    'customer_name' => 'Rohit Verma',
                    'customer_city' => 'Rajkot, GJ',
                    'customer_email' => 'rohit.verma@email.com',
                    'customer_phone' => '+91 97234 56789',
                    'customer_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                    'order_type' => 'Business',
                    'item_title' => 'Business Listing',
                    'item_subtext' => 'Premium Listing (1 Year)',
                    'item_thumbnail' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=100&auto=format&fit=crop&q=80',
                    'amount' => 1499.00,
                    'subtotal' => 1499.00,
                    'discount' => 0.00,
                    'status' => 'completed',
                    'placed_at' => now()->subDays(5)->setTime(11, 10),
                    'timeline' => [
                        ['title' => 'Listing Purchased', 'time' => 'Oct 28, 2026, 11:10 AM', 'desc' => 'Annual plan active.'],
                    ],
                ],
                [
                    'seller_id' => $primarySeller->id,
                    'order_number' => '#DC12564',
                    'customer_name' => 'Sunita Sharma',
                    'customer_city' => 'Mumbai, MH',
                    'customer_email' => 'sunita.sharma@email.com',
                    'customer_phone' => '+91 98111 22334',
                    'customer_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80',
                    'order_type' => 'Course',
                    'item_title' => 'Python for Beginners & Data Science',
                    'item_subtext' => '1 Course Access',
                    'item_thumbnail' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=100&auto=format&fit=crop&q=80',
                    'amount' => 3499.00,
                    'subtotal' => 3499.00,
                    'discount' => 0.00,
                    'status' => 'completed',
                    'placed_at' => now()->subDays(6)->setTime(18, 45),
                    'timeline' => [
                        ['title' => 'Access Granted', 'time' => 'Oct 27, 2026, 06:45 PM', 'desc' => 'Instant access.'],
                    ],
                ],
            ];

            foreach ($orders as $o) {
                Order::create($o);
            }
        }
    }
}

