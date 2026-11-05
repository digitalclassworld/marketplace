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
                'thumbnail' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=500&auto=format&fit=crop&q=80',
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

        // 4. Populate Services matching the screenshot design
        if ($primarySeller) {
            $services = [
                ['title' => 'Website Development for School, Institute & Business', 'category' => 'Development', 'price' => 4999, 'thumb' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Social Media Marketing', 'category' => 'Digital Marketing', 'price' => 2999, 'thumb' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'GST Registration Service', 'category' => 'Legal & Finance', 'price' => 1499, 'thumb' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Graphic Design Service', 'category' => 'Design', 'price' => 999, 'thumb' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'App Development', 'category' => 'Development', 'price' => 9999, 'thumb' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Content Writing', 'category' => 'Content', 'price' => 799, 'thumb' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'AI Chatbot Integration', 'category' => 'AI & Automation', 'price' => 3999, 'thumb' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Tally Support & Training', 'category' => 'Accounting', 'price' => 1999, 'thumb' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Video Editing Service', 'category' => 'Multimedia', 'price' => 1499, 'thumb' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Resume Making Service', 'category' => 'Career Support', 'price' => 599, 'thumb' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400&auto=format&fit=crop&q=80'],
            ];

            foreach ($services as $s) {
                Service::firstOrCreate(
                    ['title' => $s['title']],
                    [
                        'seller_id' => $primarySeller->id,
                        'slug' => Str::slug($s['title']),
                        'category' => $s['category'],
                        'short_description' => 'Professional service delivered on time with revision guarantees and dedicated support.',
                        'delivery_days' => 5,
                        'package_name' => 'Standard Professional Plan',
                        'price' => $s['price'],
                        'thumbnail' => $s['thumb'],
                        'status' => 'approved',
                        'approved_at' => now(),
                    ]
                );
            }
        }

        // 5. Populate Products matching the screenshot design
        if ($primarySeller) {
            $productsList = [
                ['title' => 'HP 15s Laptop', 'category' => 'Laptops & Computers', 'price' => 42999, 'mrp' => 52999, 'specs' => '(Intel Core i5, 16GB, 512GB SSD)', 'thumb' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Logitech Wireless Mouse', 'category' => 'Accessories', 'price' => 499, 'mrp' => 799, 'specs' => 'M331', 'thumb' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Canon G3010 All-in-One Ink Tank Printer', 'category' => 'Printers & Scanners', 'price' => 12499, 'mrp' => 14999, 'specs' => 'Ink Tank Multi-function', 'thumb' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Webcam Full HD 1080p with Mic', 'category' => 'Accessories', 'price' => 2499, 'mrp' => 3499, 'specs' => 'Full HD 1080p', 'thumb' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Tally Prime with GST', 'category' => 'Software & Licenses', 'price' => 20999, 'mrp' => 25999, 'specs' => '(Original License)', 'thumb' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Classroom LED Display', 'category' => 'Projectors & Displays', 'price' => 124999, 'mrp' => 149999, 'specs' => '65 Inch 4K', 'thumb' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Lenovo Tab M10', 'category' => 'Mobiles & Tablets', 'price' => 14999, 'mrp' => 18999, 'specs' => '(4GB, 64GB, WiFi)', 'thumb' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Study Material Combo', 'category' => 'Books & Study Material', 'price' => 1299, 'mrp' => 1799, 'specs' => '(10th & 12th)', 'thumb' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Classroom Projector', 'category' => 'Projectors & Displays', 'price' => 39999, 'mrp' => 49999, 'specs' => '(Epson EB-E01)', 'thumb' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'Office Chair Ergonomic', 'category' => 'Furniture', 'price' => 6499, 'mrp' => 8999, 'specs' => 'Adjustable Mesh Lumbar', 'thumb' => 'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=400&auto=format&fit=crop&q=80'],
                ['title' => 'WiFi Router TP-Link Dual Band', 'category' => 'Networking', 'price' => 2199, 'mrp' => 3499, 'specs' => 'Gigabit Dual Band', 'thumb' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=400&auto=format&fit=crop&q=80'],
                ['title' => '32GB Pen Drive', 'category' => 'Storage Devices', 'price' => 599, 'mrp' => 999, 'specs' => 'SanDisk USB 3.0', 'thumb' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=400&auto=format&fit=crop&q=80'],
            ];

            foreach ($productsList as $p) {
                Product::firstOrCreate(
                    ['title' => $p['title']],
                    [
                        'seller_id' => $primarySeller->id,
                        'slug' => Str::slug($p['title']),
                        'category' => $p['category'],
                        'product_type' => 'Physical',
                        'description' => 'Genuine high quality product with full warranty and fast shipping.',
                        'sku' => 'SKU-' . rand(10000, 99999),
                        'mrp' => $p['mrp'],
                        'price' => $p['price'],
                        'stock_quantity' => 50,
                        'shipping_details' => $p['specs'],
                        'thumbnail' => $p['thumb'],
                        'status' => 'approved',
                        'approved_at' => now(),
                    ]
                );
            }
        }

        // 6. Populate Business Listings
        $targetBusinesses = [
            [
                'name' => 'VCEC - Vinayak Computer Education Center',
                'category' => 'Computer Training',
                'sub_category' => 'Computer Training, CCC, Tally',
                'city' => 'Ahmedabad',
                'area' => 'Nikol',
                'rating' => 4.8,
                'reviews_count' => 124,
                'badge' => 'Featured',
                'cover_image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43210',
                'whatsapp' => '919876543210',
                'tags' => ['Computer Training', 'CCC', 'Tally'],
                'facilities' => ['Parking Available', 'Online Classes', 'EMI Available'],
                'business_type' => 'Verified Partner',
            ],
            [
                'name' => 'Shree Coaching Classes',
                'category' => 'Coaching Institute',
                'sub_category' => '10th, 12th, JEE, NEET',
                'city' => 'Ahmedabad',
                'area' => 'Naroda',
                'rating' => 4.7,
                'reviews_count' => 96,
                'badge' => 'Verified',
                'cover_image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43211',
                'whatsapp' => '919876543211',
                'tags' => ['10th', '12th', 'JEE', 'NEET'],
                'facilities' => ['Parking Available', 'Online Classes'],
                'business_type' => 'Individual Business',
            ],
            [
                'name' => 'Kids Planet Play School',
                'category' => 'Play School',
                'sub_category' => 'Play School, Nursery, LKG, UKG',
                'city' => 'Ahmedabad',
                'area' => 'Nikol',
                'rating' => 4.6,
                'reviews_count' => 88,
                'badge' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43212',
                'whatsapp' => '919876543212',
                'tags' => ['Play School', 'Nursery', 'LKG', 'UKG'],
                'facilities' => ['Parking Available', 'Home Visit'],
                'business_type' => 'Individual Business',
            ],
            [
                'name' => 'FitZone Gym & Fitness',
                'category' => 'Gym & Fitness',
                'sub_category' => 'Gym, Personal Training, Weight Loss',
                'city' => 'Ahmedabad',
                'area' => 'Naroda',
                'rating' => 4.5,
                'reviews_count' => 210,
                'badge' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43213',
                'whatsapp' => '919876543213',
                'tags' => ['Gym', 'Personal Training', 'Weight Loss'],
                'facilities' => ['Parking Available', 'EMI Available'],
                'business_type' => 'Franchise',
            ],
            [
                'name' => 'Digital World Laptop Repair',
                'category' => 'Electronics & Repair',
                'sub_category' => 'Laptop Repair, MacBook, Printer',
                'city' => 'Ahmedabad',
                'area' => 'Sardar Chowk',
                'rating' => 4.6,
                'reviews_count' => 180,
                'badge' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1588702547919-26089e690ecc?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43214',
                'whatsapp' => '919876543214',
                'tags' => ['Laptop Repair', 'MacBook', 'Printer'],
                'facilities' => ['Home Visit', 'EMI Available'],
                'business_type' => 'Individual Business',
            ],
            [
                'name' => 'Tasty Bites Restaurant',
                'category' => 'Restaurant & Food',
                'sub_category' => 'Fast Food, Chinese, South Indian',
                'city' => 'Ahmedabad',
                'area' => 'Nikol',
                'rating' => 4.4,
                'reviews_count' => 320,
                'badge' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43215',
                'whatsapp' => '919876543215',
                'tags' => ['Fast Food', 'Chinese', 'South Indian'],
                'facilities' => ['Parking Available', 'Home Visit'],
                'business_type' => 'Individual Business',
            ],
            [
                'name' => 'Style Salon & Beauty Care',
                'category' => 'Beauty & Salon',
                'sub_category' => 'Hair Cut, Facial, Bridal, Makeup',
                'city' => 'Ahmedabad',
                'area' => 'Naroda',
                'rating' => 4.7,
                'reviews_count' => 150,
                'badge' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43216',
                'whatsapp' => '919876543216',
                'tags' => ['Hair Cut', 'Facial', 'Bridal', 'Makeup'],
                'facilities' => ['Parking Available'],
                'business_type' => 'Individual Business',
            ],
            [
                'name' => 'AutoCare Service Center',
                'category' => 'Automotive',
                'sub_category' => 'Car Service, Denting & Painting, Oil Change',
                'city' => 'Ahmedabad',
                'area' => 'GIDC',
                'rating' => 4.5,
                'reviews_count' => 96,
                'badge' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?w=600&auto=format&fit=crop&q=80',
                'logo' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=100&auto=format&fit=crop&q=80',
                'phone' => '+91 98765 43217',
                'whatsapp' => '919876543217',
                'tags' => ['Car Service', 'Denting & Painting', 'Oil Change'],
                'facilities' => ['Parking Available', 'EMI Available'],
                'business_type' => 'Verified Partner',
            ],
        ];

        if ($primarySeller) {
            foreach ($targetBusinesses as $tb) {
                BusinessListing::updateOrCreate(
                    ['business_name' => $tb['name']],
                    [
                        'seller_id' => $primarySeller->id,
                        'slug' => Str::slug($tb['name']),
                        'category' => $tb['category'],
                        'listing_type' => $tb['badge'] ?: 'Standard',
                        'sub_category' => $tb['sub_category'],
                        'city' => $tb['city'],
                        'state' => 'Gujarat',
                        'phone' => $tb['phone'],
                        'whatsapp_number' => $tb['whatsapp'],
                        'email' => 'contact@' . Str::slug($tb['name']) . '.com',
                        'logo' => $tb['logo'],
                        'cover_image' => $tb['cover_image'],
                        'plan_name' => 'Premium Verified Listing',
                        'plan_price' => 1499,
                        'status' => 'approved',
                        'approved_at' => now(),
                        'features' => [
                            'rating' => $tb['rating'],
                            'reviews_count' => $tb['reviews_count'],
                            'area' => $tb['area'],
                            'badge' => $tb['badge'],
                            'tags' => $tb['tags'],
                            'facilities' => $tb['facilities'],
                            'business_type' => $tb['business_type'],
                        ],
                    ]
                );
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

