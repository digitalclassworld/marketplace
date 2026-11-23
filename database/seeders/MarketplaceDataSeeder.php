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

        // 3. Populate Courses (Matching the Courses Directory Screenshot)
        $targetCourses = [
            [
                'title' => 'Digital Marketing Complete Course 2026',
                'category' => 'Digital Marketing',
                'language' => 'Hindi',
                'level' => 'Beginner',
                'price' => 5999,
                'discount_price' => 2999,
                'thumbnail' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Python for Beginners',
                'category' => 'Programming',
                'language' => 'English',
                'level' => 'Beginner',
                'price' => 6999,
                'discount_price' => 3499,
                'thumbnail' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Tally Prime with GST',
                'category' => 'Business & Finance',
                'language' => 'Hindi',
                'level' => 'Beginner',
                'price' => 3999,
                'discount_price' => 1999,
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Web Development Bootcamp',
                'category' => 'Programming',
                'language' => 'English',
                'level' => 'Intermediate',
                'price' => 9999,
                'discount_price' => 4999,
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Graphic Design Mastery',
                'category' => 'Design & Creative',
                'language' => 'Hindi',
                'level' => 'Beginner',
                'price' => 4999,
                'discount_price' => 2499,
                'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Spoken English for Beginners',
                'category' => 'Spoken English',
                'language' => 'English',
                'level' => 'Beginner',
                'price' => 2999,
                'discount_price' => 1499,
                'thumbnail' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'MS Office Complete Course',
                'category' => 'Office Productivity',
                'language' => 'Hindi',
                'level' => 'Beginner',
                'price' => 3999,
                'discount_price' => 1999,
                'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'AI Tools for Beginners',
                'category' => 'AI & Tools',
                'language' => 'Hindi',
                'level' => 'All Levels',
                'price' => 4999,
                'discount_price' => 2499,
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Website Development with WordPress',
                'category' => 'Programming',
                'language' => 'English',
                'level' => 'Beginner',
                'price' => 5999,
                'discount_price' => 2999,
                'thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Personal Finance & Investment',
                'category' => 'Business & Finance',
                'language' => 'Hindi',
                'level' => 'Intermediate',
                'price' => 3999,
                'discount_price' => 1999,
                'thumbnail' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?w=500&auto=format&fit=crop&q=80',
            ],
        ];

        if ($primarySeller) {
            foreach ($targetCourses as $tc) {
                Course::updateOrCreate(
                    ['title' => $tc['title']],
                    [
                        'seller_id' => $primarySeller->id,
                        'slug' => Str::slug($tc['title']),
                        'category' => $tc['category'],
                        'language' => $tc['language'],
                        'level' => $tc['level'],
                        'short_description' => 'Comprehensive masterclass with live projects, certification, and lifetime access.',
                        'description' => 'Master essential industry skills through structured video lessons, hands-on assignments, and dedicated instructor support.',
                        'price' => $tc['price'],
                        'discount_price' => $tc['discount_price'],
                        'thumbnail' => $tc['thumbnail'],
                        'access_type' => 'Lifetime Access',
                        'certificate_included' => true,
                        'qa_enabled' => true,
                        'status' => 'approved',
                        'approved_at' => now(),
                    ]
                );
            }
        }

        // 4. Populate Services - Seeded dummy services disabled to prevent polluting marketplace.
        // Real services are created dynamically by verified sellers.

        // 5. Populate Products - Seeded dummy products disabled to prevent polluting marketplace.
        // Real products are created dynamically by verified sellers.

        // 6. Business Listings - Only real seller businesses are retained.
        // Seeded dummy businesses disabled to prevent polluting marketplace.

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

