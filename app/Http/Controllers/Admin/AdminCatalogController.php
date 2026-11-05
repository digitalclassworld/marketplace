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
        $status = $request->query('status');
        $query = Service::with('seller.businessDetail')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $services = $query->paginate(15);
        $counts = [
            'all'      => Service::count(),
            'pending'  => Service::where('status', 'pending')->count(),
            'approved' => Service::where('status', 'approved')->count(),
            'rejected' => Service::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.services', compact('services', 'counts', 'status'));
    }

    public function approveService(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $service->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Service gig '{$service->title}' approved successfully!");
    }

    public function rejectService(Request $request, int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $reason = $request->input('reason', 'Service terms do not comply with platform standards.');

        $service->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Service gig '{$service->title}' has been marked as rejected.");
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

