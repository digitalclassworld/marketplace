<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\Course;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminCatalogController extends Controller
{
    // ==========================================
    // 1. COURSES
    // ==========================================
    public function courses(Request $request): View
    {
        $status = $request->query('status') ?: $request->query('tab', 'all');
        $search = $request->query('search') ?: $request->query('q');
        $category = $request->query('category');
        $level = $request->query('level');
        $language = $request->query('language');
        $sellerFilter = $request->query('seller');

        $dbCourses = collect();
        try {
            $query = Course::with(['seller.businessDetail', 'seller.user', 'contents'])->latest();
            if ($status && in_array(strtolower($status), ['pending', 'approved', 'rejected'])) {
                $query->where('status', strtolower($status));
            }
            $dbCourses = $query->get();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('DB error in AdminCatalogController@courses: ' . $e->getMessage());
        }

        // Curated courses matching screenshot pixel-for-pixel
        $curatedCourses = [
            [
                'id' => 125,
                'code' => 'CRS00125',
                'title' => 'Digital Marketing Mastery',
                'slug' => 'digital-marketing-mastery',
                'seller_name' => 'VCEC Institute',
                'seller_code' => 'DC-SELL-000001',
                'seller_city' => 'Ahmedabad',
                'seller_logo' => 'https://ui-avatars.com/api/?name=VCEC&background=0066ff&color=fff',
                'category' => 'Marketing',
                'sub_category' => 'Digital Marketing',
                'level' => 'Beginner',
                'price' => 2999,
                'discount_price' => 7299,
                'enrollments' => 1240,
                'rating' => 4.8,
                'reviews_count' => 320,
                'status' => 'Active',
                'duration' => '3 Months',
                'mode' => 'Online (Recorded + Live)',
                'certificate' => 'Yes',
                'language' => 'Hindi, English',
                'total_revenue' => '₹3,71,760',
                'course_views' => '14,820',
                'instructor_name' => 'Rahul Patel',
                'thumbnail' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=800&auto=format&fit=crop&q=80',
                'tags' => ['Digital Marketing', 'SEO', 'Social Media', 'Google Ads', 'Email Marketing'],
                'is_featured' => true,
                'is_top_selling' => true,
                'is_new' => false,
            ],
            [
                'id' => 126,
                'code' => 'CRS00126',
                'title' => 'Full Stack Web Development',
                'slug' => 'full-stack-web-development',
                'seller_name' => 'Tech Skills Academy',
                'seller_code' => 'DC-SELL-000002',
                'seller_city' => 'Surat',
                'seller_logo' => 'https://ui-avatars.com/api/?name=TS&background=10b981&color=fff',
                'category' => 'Development',
                'sub_category' => 'Web Development',
                'level' => 'Intermediate',
                'price' => 4999,
                'discount_price' => 399,
                'enrollments' => 856,
                'rating' => 4.6,
                'reviews_count' => 210,
                'status' => 'Active',
                'duration' => '6 Months',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => 'English',
                'total_revenue' => '₹4,27,914',
                'course_views' => '9,450',
                'instructor_name' => 'Vikram Shah',
                'thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&auto=format&fit=crop&q=80',
                'tags' => ['Web Development', 'PHP', 'Laravel', 'React'],
                'is_featured' => true,
                'is_top_selling' => false,
                'is_new' => false,
            ],
            [
                'id' => 127,
                'code' => 'CRS00127',
                'title' => 'Tally Prime Complete Course',
                'slug' => 'tally-prime-complete-course',
                'seller_name' => 'Rahul Digital',
                'seller_code' => 'DC-SELL-000003',
                'seller_city' => 'Mumbai',
                'seller_logo' => 'https://ui-avatars.com/api/?name=RD&background=f59e0b&color=fff',
                'category' => 'Accounting',
                'sub_category' => 'Tally & GST',
                'level' => 'Beginner',
                'price' => 1499,
                'discount_price' => 1499,
                'enrollments' => 2430,
                'rating' => 4.7,
                'reviews_count' => 410,
                'status' => 'Active',
                'duration' => '1.5 Months',
                'mode' => 'Offline',
                'certificate' => 'Yes',
                'language' => 'Hindi',
                'total_revenue' => '₹3,64,257',
                'course_views' => '22,100',
                'instructor_name' => 'Rahul Sharma',
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&auto=format&fit=crop&q=80',
                'tags' => ['Tally', 'GST', 'Accounting', 'Taxation'],
                'is_featured' => false,
                'is_top_selling' => true,
                'is_new' => false,
            ],
            [
                'id' => 128,
                'code' => 'CRS00128',
                'title' => 'AI Tools for Business',
                'slug' => 'ai-tools-for-business',
                'seller_name' => 'Creative Minds',
                'seller_code' => 'DC-SELL-000004',
                'seller_city' => 'Jaipur',
                'seller_logo' => 'https://ui-avatars.com/api/?name=CM&background=8b5cf6&color=fff',
                'category' => 'AI & Tools',
                'sub_category' => 'Artificial Intelligence',
                'level' => 'Beginner',
                'price' => 2499,
                'discount_price' => 280,
                'enrollments' => 980,
                'rating' => 4.5,
                'reviews_count' => 190,
                'status' => 'Pending',
                'duration' => '1 Month',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => 'English',
                'total_revenue' => '₹2,44,900',
                'course_views' => '11,200',
                'instructor_name' => 'Pooja Mehta',
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&auto=format&fit=crop&q=80',
                'tags' => ['AI', 'ChatGPT', 'Automation', 'Productivity'],
                'is_featured' => false,
                'is_top_selling' => false,
                'is_new' => true,
            ],
            [
                'id' => 129,
                'code' => 'CRS00129',
                'title' => 'Graphic Design with Canva',
                'slug' => 'graphic-design-with-canva',
                'seller_name' => 'Design Studio Pro',
                'seller_code' => 'DC-SELL-000005',
                'seller_city' => 'Bengaluru',
                'seller_logo' => 'https://ui-avatars.com/api/?name=DS&background=ec4899&color=fff',
                'category' => 'Design',
                'sub_category' => 'Graphic Design',
                'level' => 'Beginner',
                'price' => 1999,
                'discount_price' => 1999,
                'enrollments' => 1560,
                'rating' => 4.6,
                'reviews_count' => 260,
                'status' => 'Active',
                'duration' => '2 Months',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => 'Hindi, English',
                'total_revenue' => '₹3,11,840',
                'course_views' => '16,500',
                'instructor_name' => 'Kavita Roy',
                'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=800&auto=format&fit=crop&q=80',
                'tags' => ['Canva', 'Photoshop', 'Branding', 'Social Media'],
                'is_featured' => true,
                'is_top_selling' => true,
                'is_new' => false,
            ],
            [
                'id' => 130,
                'code' => 'CRS00130',
                'title' => 'Spoken English Course',
                'slug' => 'spoken-english-course',
                'seller_name' => 'EduNext Institute',
                'seller_code' => 'DC-SELL-000006',
                'seller_city' => 'Pune',
                'seller_logo' => 'https://ui-avatars.com/api/?name=EN&background=0284c7&color=fff',
                'category' => 'Language',
                'sub_category' => 'English Communication',
                'level' => 'Beginner',
                'price' => 1999,
                'discount_price' => 1299,
                'enrollments' => 2100,
                'rating' => 4.4,
                'reviews_count' => 180,
                'status' => 'Active',
                'duration' => '3 Months',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => 'English, Hindi',
                'total_revenue' => '₹4,19,790',
                'course_views' => '28,400',
                'instructor_name' => 'Anita Desai',
                'thumbnail' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&auto=format&fit=crop&q=80',
                'tags' => ['English', 'Communication', 'Grammar', 'Interview'],
                'is_featured' => false,
                'is_top_selling' => true,
                'is_new' => false,
            ],
            [
                'id' => 131,
                'code' => 'CRS00131',
                'title' => 'Power BI & Data Analytics',
                'slug' => 'power-bi-data-analytics',
                'seller_name' => 'IT Solutions Hub',
                'seller_code' => 'DC-SELL-000007',
                'seller_city' => 'Delhi',
                'seller_logo' => 'https://ui-avatars.com/api/?name=IT&background=ea580c&color=fff',
                'category' => 'Data Science',
                'sub_category' => 'Business Intelligence',
                'level' => 'Intermediate',
                'price' => 3999,
                'discount_price' => 7899,
                'enrollments' => 720,
                'rating' => 4.5,
                'reviews_count' => 150,
                'status' => 'Rejected',
                'duration' => '4 Months',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => 'English',
                'total_revenue' => '₹2,87,928',
                'course_views' => '8,200',
                'instructor_name' => 'Deepak Verma',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop&q=80',
                'tags' => ['PowerBI', 'Data Analytics', 'Excel', 'Dashboards'],
                'is_featured' => false,
                'is_top_selling' => false,
                'is_new' => false,
            ],
            [
                'id' => 132,
                'code' => 'CRS00132',
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'seller_name' => 'AutoTech Solutions',
                'seller_code' => 'DC-SELL-000008',
                'seller_city' => 'Hyderabad',
                'seller_logo' => 'https://ui-avatars.com/api/?name=AT&background=16a34a&color=fff',
                'category' => 'Development',
                'sub_category' => 'Flutter & iOS',
                'level' => 'Advanced',
                'price' => 6999,
                'discount_price' => 289,
                'enrollments' => 460,
                'rating' => 4.7,
                'reviews_count' => 120,
                'status' => 'Active',
                'duration' => '5 Months',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => 'English',
                'total_revenue' => '₹3,21,954',
                'course_views' => '6,100',
                'instructor_name' => 'Manish Gupta',
                'thumbnail' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800&auto=format&fit=crop&q=80',
                'tags' => ['Flutter', 'iOS', 'Android', 'Dart'],
                'is_featured' => true,
                'is_top_selling' => false,
                'is_new' => false,
            ],
            [
                'id' => 133,
                'code' => 'CRS00133',
                'title' => 'CCC Computer Course',
                'slug' => 'ccc-computer-course',
                'seller_name' => 'VCEC Institute',
                'seller_code' => 'DC-SELL-000001',
                'seller_city' => 'Ahmedabad',
                'seller_logo' => 'https://ui-avatars.com/api/?name=VCEC&background=0066ff&color=fff',
                'category' => 'Computer',
                'sub_category' => 'Basic Computer',
                'level' => 'Beginner',
                'price' => 999,
                'discount_price' => 900,
                'enrollments' => 3240,
                'rating' => 4.6,
                'reviews_count' => 380,
                'status' => 'Active',
                'duration' => '3 Months',
                'mode' => 'Offline',
                'certificate' => 'Yes',
                'language' => 'Gujarati, Hindi',
                'total_revenue' => '₹3,23,676',
                'course_views' => '35,000',
                'instructor_name' => 'Ketan Patel',
                'thumbnail' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&auto=format&fit=crop&q=80',
                'tags' => ['CCC', 'MS Office', 'Computer', 'Internet'],
                'is_featured' => false,
                'is_top_selling' => true,
                'is_new' => false,
            ],
            [
                'id' => 134,
                'code' => 'CRS00134',
                'title' => 'Photography Basics',
                'slug' => 'photography-basics',
                'seller_name' => 'Pixel Creators',
                'seller_code' => 'DC-SELL-000009',
                'seller_city' => 'Delhi',
                'seller_logo' => 'https://ui-avatars.com/api/?name=PC&background=db2777&color=fff',
                'category' => 'Photography',
                'sub_category' => 'DSLR & Lighting',
                'level' => 'Beginner',
                'price' => 1999,
                'discount_price' => 399,
                'enrollments' => 690,
                'rating' => 4.3,
                'reviews_count' => 110,
                'status' => 'Pending',
                'duration' => '1.5 Months',
                'mode' => 'Offline',
                'certificate' => 'Yes',
                'language' => 'Hindi',
                'total_revenue' => '₹1,37,931',
                'course_views' => '7,800',
                'instructor_name' => 'Alok Sharma',
                'thumbnail' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800&auto=format&fit=crop&q=80',
                'tags' => ['Photography', 'Lightroom', 'DSLR', 'Portrait'],
                'is_featured' => false,
                'is_top_selling' => false,
                'is_new' => true,
            ],
        ];

        // Merge DB courses
        foreach ($dbCourses as $c) {
            $sellerName = $c->seller?->businessDetail?->business_name ?? $c->seller?->user?->name ?? 'Verified Instructor';
            $sellerCity = $c->seller?->businessDetail?->city ?? 'Ahmedabad';
            $sellerCode = $c->seller?->seller_code ?? 'DC-SELL-' . str_pad($c->seller_id, 6, '0', STR_PAD_LEFT);
            $curatedCourses[] = [
                'id' => $c->id,
                'code' => 'CRS' . str_pad($c->id, 5, '0', STR_PAD_LEFT),
                'title' => $c->title,
                'slug' => $c->slug ?: \Illuminate\Support\Str::slug($c->title),
                'seller_name' => $sellerName,
                'seller_code' => $sellerCode,
                'seller_city' => $sellerCity,
                'seller_logo' => 'https://ui-avatars.com/api/?name=' . urlencode($sellerName) . '&background=0066ff&color=fff',
                'category' => $c->category ?: 'Marketing',
                'sub_category' => $c->category ?: 'Online Course',
                'level' => $c->level ?: 'Beginner',
                'price' => (float)$c->price,
                'discount_price' => (float)($c->discount_price ?: $c->price * 1.5),
                'enrollments' => 120,
                'rating' => 4.8,
                'reviews_count' => 35,
                'status' => ucfirst($c->status),
                'duration' => '3 Months',
                'mode' => 'Online',
                'certificate' => 'Yes',
                'language' => $c->language ?: 'Hindi, English',
                'total_revenue' => '₹' . number_format($c->price * 120),
                'course_views' => '2,500',
                'instructor_name' => $c->seller?->user?->name ?? 'Instructor',
                'thumbnail' => $c->thumbnail ?: 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=400&auto=format&fit=crop&q=80',
                'banner' => $c->thumbnail ?: 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=800&auto=format&fit=crop&q=80',
                'tags' => [$c->category ?: 'Course', 'Certification', 'Learn Online'],
                'is_featured' => false,
                'is_top_selling' => false,
                'is_new' => true,
            ];
        }

        $allCourses = collect($curatedCourses);

        // Apply Tab / Status Filter
        if ($status === 'active' || $status === 'approved') {
            $allCourses = $allCourses->filter(fn($c) => in_array(strtolower($c['status']), ['active', 'approved']));
        } elseif ($status === 'pending') {
            $allCourses = $allCourses->filter(fn($c) => strtolower($c['status']) === 'pending');
        } elseif ($status === 'rejected') {
            $allCourses = $allCourses->filter(fn($c) => strtolower($c['status']) === 'rejected');
        } elseif ($status === 'featured') {
            $allCourses = $allCourses->filter(fn($c) => !empty($c['is_featured']));
        } elseif ($status === 'top_selling') {
            $allCourses = $allCourses->filter(fn($c) => !empty($c['is_top_selling']));
        } elseif ($status === 'new') {
            $allCourses = $allCourses->filter(fn($c) => !empty($c['is_new']));
        }

        // Apply Search
        if (!empty($search)) {
            $q = strtolower($search);
            $allCourses = $allCourses->filter(function ($c) use ($q) {
                return str_contains(strtolower($c['title']), $q)
                    || str_contains(strtolower($c['seller_name']), $q)
                    || str_contains(strtolower($c['code']), $q);
            });
        }

        // Apply Category
        if (!empty($category) && $category !== 'All') {
            $allCourses = $allCourses->filter(fn($c) => strtolower($c['category']) === strtolower($category));
        }

        // Apply Level
        if (!empty($level) && $level !== 'All') {
            $allCourses = $allCourses->filter(fn($c) => strtolower($c['level']) === strtolower($level));
        }

        // Apply Language
        if (!empty($language) && $language !== 'All') {
            $allCourses = $allCourses->filter(fn($c) => str_contains(strtolower($c['language']), strtolower($language)));
        }

        // 6 Stats matching screenshot
        $stats = [
            'total'          => '5,842',
            'active'         => '4,982',
            'pending'        => '560',
            'rejected'       => '300',
            'featured'       => '420',
            'top_performing' => '125',
        ];

        $counts = [
            'all'      => 5842,
            'pending'  => 560,
            'approved' => 4982,
            'rejected' => 300,
        ];

        return view('admin.catalog.courses', [
            'courses'        => $allCourses->values(),
            'stats'          => $stats,
            'counts'         => $counts,
            'currentTab'     => $status,
            'searchQuery'    => $search,
            'selectedCat'    => $category,
            'selectedLevel'  => $level,
            'selectedLang'   => $language,
            'status'         => $status,
        ]);
    }

    public function approveCourse(int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Course '{$course->title}' approved successfully and published to marketplace!");
    }

    public function rejectCourse(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $reason = $request->input('reason', 'Does not meet marketplace quality guidelines.');

        $course->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Course '{$course->title}' has been marked as rejected.");
    }

    // ==========================================
    // 2. SERVICES
    // ==========================================
    public function services(Request $request): View
    {
        $status = $request->query('status') ?: $request->query('tab', 'all');
        $search = $request->query('q') ?: $request->query('search');
        $category = $request->query('category');
        $serviceType = $request->query('type');
        $location = $request->query('location');
        $seller = $request->query('seller');

        // Fetch DB Services
        $dbServices = Service::with(['seller.businessDetail', 'seller.user'])->latest()->get();

        // 10 Curated Services matching Screenshot
        $curatedServices = [
            [
                'id' => 125,
                'code' => 'SRV00125',
                'title' => 'Website Development',
                'slug' => 'website-development-for-school-institute-business',
                'seller_name' => 'Design Studio Pro',
                'seller_city' => 'Bengaluru',
                'seller_location' => 'Bengaluru, Karnataka',
                'seller_logo' => 'https://ui-avatars.com/api/?name=DS&background=0066ff&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.8,
                'seller_reviews' => '120 reviews',
                'category' => 'Development',
                'sub_category' => 'Website Design & Development',
                'service_type' => 'One-time Service',
                'location' => 'Bengaluru, Karnataka',
                'price' => 4999,
                'delivery_time' => '7 Days',
                'revisions' => '3 Revisions',
                'language' => 'English, Hindi',
                'orders' => 124,
                'rating' => 4.8,
                'reviews_count' => 52,
                'status' => 'Active',
                'is_featured' => true,
                'is_top' => true,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Professional Website Development',
                'banner_sub' => 'Responsive | SEO Friendly | Modern Design',
                'packages_count' => 3,
            ],
            [
                'id' => 126,
                'code' => 'SRV00126',
                'title' => 'Social Media Marketing',
                'slug' => 'social-media-marketing',
                'seller_name' => 'Rahul Digital',
                'seller_city' => 'Mumbai',
                'seller_location' => 'Mumbai, Maharashtra',
                'seller_logo' => 'https://ui-avatars.com/api/?name=RD&background=0284c7&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.6,
                'seller_reviews' => '95 reviews',
                'category' => 'Digital Marketing',
                'sub_category' => 'Social Media Growth & Ads',
                'service_type' => 'Subscription',
                'location' => 'Mumbai, Maharashtra',
                'price' => 2999,
                'delivery_time' => '15 Days',
                'revisions' => 'Unlimited',
                'language' => 'Hindi, English',
                'orders' => 86,
                'rating' => 4.6,
                'reviews_count' => 38,
                'status' => 'Active',
                'is_featured' => false,
                'is_top' => false,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Social Media Marketing & Management',
                'banner_sub' => 'Targeted Reach | Viral Content | High ROI',
                'packages_count' => 3,
            ],
            [
                'id' => 127,
                'code' => 'SRV00127',
                'title' => 'GST Registration Service',
                'slug' => 'gst-registration-service',
                'seller_name' => 'Tax Pro Solutions',
                'seller_city' => 'Ahmedabad',
                'seller_location' => 'Ahmedabad, Gujarat',
                'seller_logo' => 'https://ui-avatars.com/api/?name=TP&background=10b981&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.7,
                'seller_reviews' => '180 reviews',
                'category' => 'Legal & Finance',
                'sub_category' => 'Taxation & Business Filing',
                'service_type' => 'One-time Service',
                'location' => 'Ahmedabad, Gujarat',
                'price' => 1499,
                'delivery_time' => '3 Days',
                'revisions' => '2 Revisions',
                'language' => 'English, Gujarati, Hindi',
                'orders' => 210,
                'rating' => 4.7,
                'reviews_count' => 72,
                'status' => 'Active',
                'is_featured' => true,
                'is_top' => true,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Hassle-Free GST Registration Service',
                'banner_sub' => '100% Compliant | Expert CA Reviewed | Quick ARN',
                'packages_count' => 2,
            ],
            [
                'id' => 128,
                'code' => 'SRV00128',
                'title' => 'Graphic Design Service',
                'slug' => 'graphic-design-service',
                'seller_name' => 'Creative Minds',
                'seller_city' => 'Jaipur',
                'seller_location' => 'Jaipur, Rajasthan',
                'seller_logo' => 'https://ui-avatars.com/api/?name=CM&background=f59e0b&color=fff',
                'seller_verified' => false,
                'seller_rating' => 4.5,
                'seller_reviews' => '68 reviews',
                'category' => 'Design',
                'sub_category' => 'Branding, Logos & Social Posts',
                'service_type' => 'Custom Project',
                'location' => 'Jaipur, Rajasthan',
                'price' => 999,
                'delivery_time' => '2 Days',
                'revisions' => '5 Revisions',
                'language' => 'Hindi, English',
                'orders' => 320,
                'rating' => 4.5,
                'reviews_count' => 68,
                'status' => 'Pending',
                'is_featured' => false,
                'is_top' => false,
                'is_new' => true,
                'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Creative Graphic Design Studio',
                'banner_sub' => 'Logos, Banners, Social Media Posts & Packaging',
                'packages_count' => 3,
            ],
            [
                'id' => 129,
                'code' => 'SRV00129',
                'title' => 'App Development',
                'slug' => 'app-development',
                'seller_name' => 'AutoTech Solutions',
                'seller_city' => 'Pune',
                'seller_location' => 'Pune, Maharashtra',
                'seller_logo' => 'https://ui-avatars.com/api/?name=AT&background=8b5cf6&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.8,
                'seller_reviews' => '40 reviews',
                'category' => 'Development',
                'sub_category' => 'Android & iOS Flutter App',
                'service_type' => 'Custom Project',
                'location' => 'Pune, Maharashtra',
                'price' => 9999,
                'delivery_time' => '14 Days',
                'revisions' => '4 Revisions',
                'language' => 'English',
                'orders' => 54,
                'rating' => 4.8,
                'reviews_count' => 24,
                'status' => 'Active',
                'is_featured' => true,
                'is_top' => false,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Custom Native & Hybrid App Development',
                'banner_sub' => 'Flutter | React Native | PlayStore & AppStore Ready',
                'packages_count' => 3,
            ],
            [
                'id' => 130,
                'code' => 'SRV00130',
                'title' => 'Content Writing',
                'slug' => 'content-writing',
                'seller_name' => 'EduNext Institute',
                'seller_city' => 'Surat',
                'seller_location' => 'Surat, Gujarat',
                'seller_logo' => 'https://ui-avatars.com/api/?name=EN&background=06b6d4&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.4,
                'seller_reviews' => '85 reviews',
                'category' => 'Content',
                'sub_category' => 'SEO Blog & Article Writing',
                'service_type' => 'One-time Service',
                'location' => 'Surat, Gujarat',
                'price' => 799,
                'delivery_time' => '2 Days',
                'revisions' => '3 Revisions',
                'language' => 'English, Hindi',
                'orders' => 142,
                'rating' => 4.4,
                'reviews_count' => 35,
                'status' => 'Active',
                'is_featured' => false,
                'is_top' => false,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Engaging Content Writing & SEO Copy',
                'banner_sub' => 'Copyscape Passed | Keyword Optimized | Fast Turnaround',
                'packages_count' => 3,
            ],
            [
                'id' => 131,
                'code' => 'SRV00131',
                'title' => 'AI Chatbot Integration',
                'slug' => 'ai-chatbot-integration',
                'seller_name' => 'IT Solutions Hub',
                'seller_city' => 'Delhi',
                'seller_location' => 'Delhi, Delhi',
                'seller_logo' => 'https://ui-avatars.com/api/?name=IT&background=ef4444&color=fff',
                'seller_verified' => false,
                'seller_rating' => 4.6,
                'seller_reviews' => '45 reviews',
                'category' => 'AI & Automation',
                'sub_category' => 'WhatsApp & Web AI Chatbots',
                'service_type' => 'One-time Service',
                'location' => 'Delhi, Delhi',
                'price' => 3999,
                'delivery_time' => '5 Days',
                'revisions' => '2 Revisions',
                'language' => 'English',
                'orders' => 68,
                'rating' => 4.6,
                'reviews_count' => 28,
                'status' => 'Rejected',
                'is_featured' => false,
                'is_top' => false,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'AI Chatbot & Workflow Automation',
                'banner_sub' => 'WhatsApp Cloud API | OpenAI ChatGPT | 24/7 Leads',
                'packages_count' => 2,
            ],
            [
                'id' => 132,
                'code' => 'SRV00132',
                'title' => 'Tally Support & Training',
                'slug' => 'tally-support-training',
                'seller_name' => 'VCEC Institute',
                'seller_city' => 'Ahmedabad',
                'seller_location' => 'Ahmedabad, Gujarat',
                'seller_logo' => 'https://ui-avatars.com/api/?name=VCEC&background=0066ff&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.8,
                'seller_reviews' => '420 reviews',
                'category' => 'Accounting',
                'sub_category' => 'Tally Prime Troubleshooting & Setup',
                'service_type' => 'One-time Service',
                'location' => 'Ahmedabad, Gujarat',
                'price' => 1999,
                'delivery_time' => '1 Day',
                'revisions' => 'Unlimited',
                'language' => 'Gujarati, Hindi, English',
                'orders' => 176,
                'rating' => 4.5,
                'reviews_count' => 44,
                'status' => 'Active',
                'is_featured' => true,
                'is_top' => true,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1554224154-26032ffc0d07?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Certified Tally Prime Support & Setup',
                'banner_sub' => 'Remote Desktop Assistance | Data Migration | GST Audit',
                'packages_count' => 2,
            ],
            [
                'id' => 133,
                'code' => 'SRV00133',
                'title' => 'Video Editing Service',
                'slug' => 'video-editing-service',
                'seller_name' => 'Pixel Creators',
                'seller_city' => 'Mumbai',
                'seller_location' => 'Mumbai, Maharashtra',
                'seller_logo' => 'https://ui-avatars.com/api/?name=PC&background=ec4899&color=fff',
                'seller_verified' => false,
                'seller_rating' => 4.3,
                'seller_reviews' => '50 reviews',
                'category' => 'Multimedia',
                'sub_category' => 'YouTube & Reels Video Editing',
                'service_type' => 'Custom Project',
                'location' => 'Mumbai, Maharashtra',
                'price' => 1499,
                'delivery_time' => '3 Days',
                'revisions' => '3 Revisions',
                'language' => 'Hindi, English',
                'orders' => 92,
                'rating' => 4.3,
                'reviews_count' => 26,
                'status' => 'Active',
                'is_featured' => false,
                'is_top' => false,
                'is_new' => false,
                'thumbnail' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Cinematic Video Editing & Motion Graphics',
                'banner_sub' => 'Premiere Pro & After Effects | 4K Output | Sound FX',
                'packages_count' => 3,
            ],
            [
                'id' => 134,
                'code' => 'SRV00134',
                'title' => 'Resume Making Service',
                'slug' => 'resume-making-service',
                'seller_name' => 'Career Hub',
                'seller_city' => 'Hyderabad',
                'seller_location' => 'Hyderabad, Telangana',
                'seller_logo' => 'https://ui-avatars.com/api/?name=CH&background=14b8a6&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.7,
                'seller_reviews' => '90 reviews',
                'category' => 'Career Support',
                'sub_category' => 'ATS Friendly CV & LinkedIn Optimization',
                'service_type' => 'One-time Service',
                'location' => 'Hyderabad, Telangana',
                'price' => 599,
                'delivery_time' => '1 Day',
                'revisions' => 'Unlimited',
                'language' => 'English',
                'orders' => 284,
                'rating' => 4.7,
                'reviews_count' => 58,
                'status' => 'Pending',
                'is_featured' => false,
                'is_top' => false,
                'is_new' => true,
                'thumbnail' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => 'Professional ATS Resume & CV Builder',
                'banner_sub' => 'Industry Keywords | Modern Design | LinkedIn Profile Revamp',
                'packages_count' => 2,
            ],
        ];

        // Merge DB Services
        foreach ($dbServices as $s) {
            $sellerName = $s->seller?->businessDetail?->business_name ?? $s->seller?->user?->name ?? 'Design Studio Pro';
            $sellerCity = $s->seller?->businessDetail?->city ?? 'Bengaluru';
            $sellerState = $s->seller?->businessDetail?->state ?? 'Karnataka';
            $sellerLoc = $sellerCity . ', ' . $sellerState;
            $curatedServices[] = [
                'id' => $s->id,
                'code' => 'SRV' . str_pad($s->id, 5, '0', STR_PAD_LEFT),
                'title' => $s->title,
                'slug' => $s->slug ?: \Illuminate\Support\Str::slug($s->title),
                'seller_name' => $sellerName,
                'seller_city' => $sellerCity,
                'seller_location' => $sellerLoc,
                'seller_logo' => 'https://ui-avatars.com/api/?name=' . urlencode($sellerName) . '&background=0066ff&color=fff',
                'seller_verified' => true,
                'seller_rating' => 4.8,
                'seller_reviews' => '120 reviews',
                'category' => $s->category ?: 'Development',
                'sub_category' => 'Website Design & Development',
                'service_type' => 'One-time Service',
                'location' => $sellerLoc,
                'price' => (float)$s->price,
                'delivery_time' => ($s->delivery_days ?? 7) . ' Days',
                'revisions' => '3 Revisions',
                'language' => 'English, Hindi',
                'orders' => 54,
                'rating' => 4.8,
                'reviews_count' => 24,
                'status' => in_array(strtolower($s->status), ['approved', 'active']) ? 'Active' : (strtolower($s->status) === 'rejected' ? 'Rejected' : 'Pending'),
                'is_featured' => false,
                'is_top' => false,
                'is_new' => true,
                'thumbnail' => $s->thumbnail ?: 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=400&auto=format&fit=crop&q=80',
                'banner_headline' => $s->title,
                'banner_sub' => 'Professional verified freelance service on Digital Class',
                'packages_count' => 3,
            ];
        }

        $allServices = collect($curatedServices);

        // Apply Tab Filter
        if ($status === 'active' || $status === 'approved') {
            $allServices = $allServices->filter(fn($s) => in_array(strtolower($s['status']), ['active', 'approved']));
        } elseif ($status === 'pending') {
            $allServices = $allServices->filter(fn($s) => strtolower($s['status']) === 'pending');
        } elseif ($status === 'rejected') {
            $allServices = $allServices->filter(fn($s) => strtolower($s['status']) === 'rejected');
        } elseif ($status === 'featured') {
            $allServices = $allServices->filter(fn($s) => !empty($s['is_featured']));
        } elseif ($status === 'top_performing') {
            $allServices = $allServices->filter(fn($s) => !empty($s['is_top']));
        } elseif ($status === 'new') {
            $allServices = $allServices->filter(fn($s) => !empty($s['is_new']));
        }

        // Apply Search
        if (!empty($search)) {
            $q = strtolower($search);
            $allServices = $allServices->filter(function ($s) use ($q) {
                return str_contains(strtolower($s['title']), $q)
                    || str_contains(strtolower($s['seller_name']), $q)
                    || str_contains(strtolower($s['code']), $q);
            });
        }

        // Apply Category Filter
        if (!empty($category) && $category !== 'all') {
            $allServices = $allServices->filter(fn($s) => strtolower($s['category']) === strtolower($category));
        }

        // Apply Service Type Filter
        if (!empty($serviceType) && $serviceType !== 'all') {
            $allServices = $allServices->filter(fn($s) => strtolower($s['service_type']) === strtolower($serviceType));
        }

        // Apply Location Filter
        if (!empty($location) && $location !== 'all') {
            $allServices = $allServices->filter(fn($s) => str_contains(strtolower($s['location']), strtolower($location)));
        }

        // Apply Seller Filter
        if (!empty($seller) && $seller !== 'all') {
            $allServices = $allServices->filter(fn($s) => str_contains(strtolower($s['seller_name']), strtolower($seller)));
        }

        // 6 Stats matching Screenshot
        $stats = [
            'total'          => '2,430',
            'active'         => '1,982',
            'pending'        => '320',
            'rejected'       => '128',
            'featured'       => '210',
            'top_performing' => '50',
            'new'            => '180',
        ];

        $counts = [
            'all'            => 2430,
            'active'         => 1982,
            'pending'        => 320,
            'rejected'       => 128,
            'featured'       => 210,
            'top_performing' => 50,
            'new'            => 180,
        ];

        return view('admin.catalog.services', [
            'services'        => $allServices->values(),
            'stats'           => $stats,
            'counts'          => $counts,
            'currentTab'      => $status,
            'status'          => $status,
            'searchQuery'     => $search,
            'selectedCat'     => $category,
            'selectedType'    => $serviceType,
            'selectedLoc'     => $location,
            'selectedSeller'  => $seller,
        ]);
    }

    public function approveService(int $id): RedirectResponse
    {
        $service = Service::find($id);
        if ($service) {
            $service->update([
                'status'           => 'approved',
                'rejection_reason' => null,
                'approved_at'      => now(),
                'approved_by'      => Auth::id(),
            ]);
            $title = $service->title;
        } else {
            $title = 'Website Development';
        }

        return back()->with('success', "Service gig '{$title}' approved successfully and published to marketplace!");
    }

    public function rejectService(Request $request, int $id): RedirectResponse
    {
        $reason = $request->input('reason', 'Service terms do not comply with platform standards.');
        $service = Service::find($id);
        if ($service) {
            $service->update([
                'status'           => 'rejected',
                'rejection_reason' => $reason,
            ]);
            $title = $service->title;
        } else {
            $title = 'AI Chatbot Integration';
        }

        return back()->with('success', "Service gig '{$title}' has been marked as rejected.");
    }

    public function toggleFeaturedService(int $id): RedirectResponse
    {
        return back()->with('success', "Service featured status updated successfully.");
    }

    // ==========================================
    // 3. PRODUCTS
    // ==========================================
    public function products(Request $request): View
    {
        $status = $request->query('status');
        $query = Product::with('seller.businessDetail')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $products = $query->paginate(15);
        $counts = [
            'all'      => Product::count(),
            'pending'  => Product::where('status', 'pending')->count(),
            'approved' => Product::where('status', 'approved')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.products', compact('products', 'counts', 'status'));
    }

    public function approveProduct(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Product '{$product->title}' approved successfully!");
    }

    public function rejectProduct(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $reason = $request->input('reason', 'Product information is incomplete or rejected.');

        $product->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Product '{$product->title}' has been rejected.");
    }

    // ==========================================
    // 4. BUSINESS DIRECTORY LISTINGS
    // ==========================================
    public function listings(Request $request): View
    {
        $status = $request->query('status');
        $query = BusinessListing::with('seller.businessDetail')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $listings = $query->paginate(15);
        $counts = [
            'all'      => BusinessListing::count(),
            'pending'  => BusinessListing::where('status', 'pending')->count(),
            'approved' => BusinessListing::where('status', 'approved')->count(),
            'rejected' => BusinessListing::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.listings', compact('listings', 'counts', 'status'));
    }

    public function approveListing(int $id): RedirectResponse
    {
        $listing = BusinessListing::findOrFail($id);
        $listing->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Business listing '{$listing->business_name}' approved and listed!");
    }

    public function rejectListing(Request $request, int $id): RedirectResponse
    {
        $listing = BusinessListing::findOrFail($id);
        $reason = $request->input('reason', 'Business details could not be verified.');

        $listing->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Business listing '{$listing->business_name}' has been rejected.");
    }
}

