<?php

namespace App\Http\Controllers;

use App\Models\BusinessListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the dynamic public homepage matching the Local Businesses & Institutes design.
     */
    public function index(Request $request): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        $searchQuery = $request->input('search');
        $selectedCategory = $request->input('category');
        $selectedCity = $request->input('city', 'Ahmedabad');
        $selectedRating = $request->input('rating');
        $selectedFacilities = (array) $request->input('facility', []);
        $selectedBusinessTypes = (array) $request->input('business_type', []);
        $sortBy = $request->input('sort', 'popular');

        $businesses = collect();

        // Safely check if database table exists
        try {
            if (Schema::hasTable('business_listings')) {
                $query = BusinessListing::query()->where('status', 'approved');

                if (!empty($searchQuery)) {
                    $query->where(function ($q) use ($searchQuery) {
                        $q->where('business_name', 'like', "%{$searchQuery}%")
                          ->orWhere('category', 'like', "%{$searchQuery}%")
                          ->orWhere('sub_category', 'like', "%{$searchQuery}%")
                          ->orWhere('city', 'like', "%{$searchQuery}%");
                    });
                }

                if (!empty($selectedCategory) && $selectedCategory !== 'All Businesses') {
                    $query->where(function ($q) use ($selectedCategory) {
                        $q->where('category', 'like', "%{$selectedCategory}%")
                          ->orWhere('sub_category', 'like', "%{$selectedCategory}%");
                    });
                }

                if (!empty($selectedCity) && $selectedCity !== 'All Locations') {
                    $query->where('city', $selectedCity);
                }

                // Apply sorting
                if ($sortBy === 'rating') {
                    $query->orderByDesc('plan_price');
                } elseif ($sortBy === 'newest') {
                    $query->orderByDesc('created_at');
                } else {
                    $query->orderByRaw("CASE WHEN listing_type = 'Featured' THEN 1 WHEN listing_type = 'Verified' THEN 2 ELSE 3 END")
                          ->orderBy('id', 'asc');
                }

                $businesses = $query->get();

                // Client-side JSON attribute filters
                if (!empty($selectedRating)) {
                    $minRating = (float) $selectedRating;
                    $businesses = $businesses->filter(function ($b) use ($minRating) {
                        return $b->rating >= $minRating;
                    });
                }

                if (!empty($selectedFacilities)) {
                    $businesses = $businesses->filter(function ($b) use ($selectedFacilities) {
                        $fac = $b->features['facilities'] ?? [];
                        foreach ($selectedFacilities as $sf) {
                            if (in_array($sf, $fac)) return true;
                        }
                        return false;
                    });
                }

                if (!empty($selectedBusinessTypes)) {
                    $businesses = $businesses->filter(function ($b) use ($selectedBusinessTypes) {
                        $bType = $b->features['business_type'] ?? 'Individual Business';
                        return in_array($bType, $selectedBusinessTypes);
                    });
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Database connection failed on homepage: ' . $e->getMessage());
            $businesses = collect();
        }

        // Top horizontal categories with icons
        $horizontalCategories = [
            ['name' => 'All Businesses',      'icon' => 'fa-solid fa-store',            'slug' => 'all'],
            ['name' => 'Education',           'icon' => 'fa-solid fa-graduation-cap',   'slug' => 'Education'],
            ['name' => 'Coaching Institutes', 'icon' => 'fa-solid fa-chalkboard-user',  'slug' => 'Coaching Institute'],
            ['name' => 'Training Centers',    'icon' => 'fa-solid fa-award',            'slug' => 'Computer Training'],
            ['name' => 'Health & Wellness',   'icon' => 'fa-solid fa-heart-pulse',      'slug' => 'Gym & Fitness'],
            ['name' => 'Beauty & Fashion',    'icon' => 'fa-solid fa-wand-magic-sparkles', 'slug' => 'Beauty & Salon'],
            ['name' => 'Food & Restaurants',  'icon' => 'fa-solid fa-utensils',         'slug' => 'Restaurant & Food'],
            ['name' => 'Retail Shops',        'icon' => 'fa-solid fa-bag-shopping',     'slug' => 'Retail Shops'],
            ['name' => 'Automotive',          'icon' => 'fa-solid fa-car',              'slug' => 'Automotive'],
            ['name' => 'Electronics & Repair','icon' => 'fa-solid fa-screwdriver-wrench','slug' => 'Electronics & Repair'],
            ['name' => 'Home Services',       'icon' => 'fa-solid fa-couch',            'slug' => 'Home Services'],
            ['name' => 'Real Estate',         'icon' => 'fa-solid fa-building',         'slug' => 'Real Estate'],
            ['name' => 'Event & Photography', 'icon' => 'fa-solid fa-camera',           'slug' => 'Event & Photography'],
            ['name' => 'Sports & Fitness',    'icon' => 'fa-solid fa-person-running',   'slug' => 'Gym & Fitness'],
            ['name' => 'More',                'icon' => 'fa-solid fa-ellipsis',         'slug' => 'more'],
        ];

        // Sidebar categories with matching counts from the screenshot
        $sidebarCategories = [
            ['name' => 'Coaching Institute', 'count' => 420],
            ['name' => 'Computer Training',  'count' => 320],
            ['name' => 'Play School',        'count' => 180],
            ['name' => 'Gym & Fitness',      'count' => 140],
            ['name' => 'Beauty & Salon',     'count' => 210],
            ['name' => 'Restaurant & Food',  'count' => 260],
        ];

        return view('home.index', [
            'seller'                => $seller,
            'businesses'            => $businesses,
            'horizontalCategories'  => $horizontalCategories,
            'sidebarCategories'     => $sidebarCategories,
            'searchQuery'           => $searchQuery,
            'selectedCategory'      => $selectedCategory ?: 'All Businesses',
            'selectedCity'          => $selectedCity,
            'selectedRating'        => $selectedRating,
            'selectedFacilities'    => $selectedFacilities,
            'selectedBusinessTypes' => $selectedBusinessTypes,
            'sortBy'                => $sortBy,
        ]);
    }

    /**
     * Display the public Business Profile page matching the VCEC UI design.
     */
    public function businessProfile(Request $request, $slug = null): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        $business = null;
        try {
            if (Schema::hasTable('business_listings')) {
                if ($slug) {
                    $business = BusinessListing::where('slug', $slug)->first();
                }
                if (!$business) {
                    $business = BusinessListing::where('business_name', 'like', '%VCEC%')->first()
                             ?? BusinessListing::first();
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Database connection failed on businessProfile: ' . $e->getMessage());
        }

        // Curated courses matching the exact instructor storefront screenshot
        $courses = [
            [
                'id' => 1,
                'title' => 'Digital Marketing Complete Course',
                'slug' => 'digital-marketing-complete-course-2026',
                'duration' => '2 Months',
                'mode' => 'Online/Offline',
                'rating' => 4.8,
                'reviews_count' => 320,
                'price' => 12999,
                'original_price' => 18999,
                'discount' => '31% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 2,
                'title' => 'Tally Prime with GST',
                'slug' => 'tally-prime-with-gst',
                'duration' => '1.5 Months',
                'mode' => 'Offline',
                'rating' => 4.7,
                'reviews_count' => 180,
                'price' => 4999,
                'original_price' => 6999,
                'discount' => '29% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 3,
                'title' => 'Web Development Course',
                'slug' => 'web-development-course',
                'duration' => '3 Months',
                'mode' => 'Online/Offline',
                'rating' => 4.6,
                'reviews_count' => 150,
                'price' => 14999,
                'original_price' => 22999,
                'discount' => '33% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 4,
                'title' => 'AI Tools & ChatGPT',
                'slug' => 'ai-tools-and-chatgpt',
                'duration' => '1.5 Months',
                'mode' => 'Online',
                'rating' => 4.8,
                'reviews_count' => 210,
                'price' => 5999,
                'original_price' => 8999,
                'discount' => '33% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        // Curated services matching the screenshot
        $services = [
            [
                'title' => 'Website Development for Institute',
                'starting_price' => 4999,
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Social Media Management',
                'starting_price' => 2499,
                'thumbnail' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Graphics & Banner Design',
                'starting_price' => 999,
                'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Resume Making',
                'starting_price' => 499,
                'thumbnail' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        // Sidebar categories with exact counts from screenshot
        $sidebarCategories = [
            ['name' => 'All',                        'count' => 24, 'active' => true],
            ['name' => 'Computer Courses',           'count' => 24, 'active' => false],
            ['name' => 'Digital Marketing',          'count' => 8,  'active' => false],
            ['name' => 'Programming & Development',  'count' => 6,  'active' => false],
            ['name' => 'Tally & Accounting',         'count' => 5,  'active' => false],
            ['name' => 'Designing Courses',          'count' => 4,  'active' => false],
            ['name' => 'AI Tools & Productivity',    'count' => 6,  'active' => false],
            ['name' => 'Combo Packages',             'count' => 3,  'active' => false],
            ['name' => 'Books & Study Material',     'count' => 5,  'active' => false],
            ['name' => 'Services',                   'count' => 5,  'active' => false],
        ];

        // Filter type & mode counts
        $filterTypes = [
            ['name' => 'Courses',  'count' => 12],
            ['name' => 'Services', 'count' => 5],
            ['name' => 'Products', 'count' => 8],
        ];

        $filterModes = [
            ['name' => 'Online',  'count' => 10],
            ['name' => 'Offline', 'count' => 8],
        ];

        // Curated student reviews matching the screenshot
        $reviews = [
            [
                'author' => 'Priya Shah',
                'time_ago' => '2 weeks ago',
                'rating' => 5,
                'text' => 'Very practical training. Faculty is very supportive. Highly recommended! 👍',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&auto=format&fit=crop&q=80',
            ],
            [
                'author' => 'Karan Patel',
                'time_ago' => '1 month ago',
                'rating' => 5,
                'text' => 'Best computer institute in Nikol. Got a job after completing digital marketing.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&auto=format&fit=crop&q=80',
            ],
            [
                'author' => 'Neha Joshi',
                'time_ago' => '1 month ago',
                'rating' => 5,
                'text' => 'Great learning environment and hands-on practice. Value for money!',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&auto=format&fit=crop&q=80',
            ],
        ];

        // Branches
        $branches = [
            [
                'name' => 'Nikol (Head Office)',
                'address' => '201, Shreeji Complex, Nikol Main Road, Nikol, Ahmedabad - 382350, Gujarat',
                'phone' => '+91 98765 43210',
                'status' => 'Open',
                'is_head' => true,
            ],
            [
                'name' => 'Naroda Branch',
                'address' => 'Shop 104, Galaxy Complex, Naroda, Ahmedabad - 382330, Gujarat',
                'phone' => '+91 98765 43211',
                'status' => 'Open',
                'is_head' => false,
            ],
            [
                'name' => 'Sardar Chowk Branch',
                'address' => '2nd Floor, City Center, Sardar Chowk, Ahmedabad - 382340, Gujarat',
                'phone' => '+91 98765 43212',
                'status' => 'Open',
                'is_head' => false,
            ],
        ];

        return view('home.business-profile', [
            'seller'            => $seller,
            'business'          => $business,
            'courses'           => $courses,
            'services'          => $services,
            'reviews'           => $reviews,
            'branches'          => $branches,
            'sidebarCategories' => $sidebarCategories,
            'filterTypes'       => $filterTypes,
            'filterModes'       => $filterModes,
        ]);
    }

    /**
     * Submit an enquiry from the business profile.
     */
    public function submitEnquiry(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:20',
            'course' => 'nullable|string|max:120',
            'message' => 'nullable|string|max:500',
        ]);

        return back()->with('success', 'Thank you! Your enquiry has been received. Our counselor will contact you shortly.');
    }

    /**
     * Book a free demo class.
     */
    public function bookDemo(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:20',
            'course' => 'required|string|max:120',
            'preferred_branch' => 'required|string|max:120',
        ]);

        return back()->with('success', 'Demo class booked successfully! We have reserved your seat.');
    }

    /**
     * Submit a student review.
     */
    public function submitReview(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'author' => 'required|string|max:120',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:600',
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible after brief moderation.');
    }

    /**
     * Display the public Courses directory page matching the UI design.
     */
    public function courses(Request $request): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        $searchQuery = $request->input('search');
        $selectedCategory = $request->input('category');
        $selectedLevel = (array) $request->input('level', []);
        $selectedLanguage = (array) $request->input('language', []);
        $selectedMode = (array) $request->input('mode', []);
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 50000);
        $sortBy = $request->input('sort', 'popular');

        $courses = collect();

        try {
            if (Schema::hasTable('courses')) {
                $query = \App\Models\Course::query()->where('status', 'approved');

                if (!empty($searchQuery)) {
                    $query->where(function ($q) use ($searchQuery) {
                        $q->where('title', 'like', "%{$searchQuery}%")
                          ->orWhere('category', 'like', "%{$searchQuery}%")
                          ->orWhere('short_description', 'like', "%{$searchQuery}%");
                    });
                }

                if (!empty($selectedCategory) && $selectedCategory !== 'All Categories') {
                    $query->where(function ($q) use ($selectedCategory) {
                        $q->where('category', 'like', "%{$selectedCategory}%");
                    });
                }

                if (!empty($selectedLevel)) {
                    $query->whereIn('level', $selectedLevel);
                }

                if (!empty($selectedLanguage)) {
                    $query->whereIn('language', $selectedLanguage);
                }

                if (!empty($minPrice) && (float)$minPrice > 0) {
                    $query->where('price', '>=', (float) $minPrice);
                }

                if (!empty($maxPrice) && (float)$maxPrice < 50000) {
                    $query->where('price', '<=', (float) $maxPrice);
                }

                if ($sortBy === 'price_low') {
                    $query->orderBy('price', 'asc');
                } elseif ($sortBy === 'price_high') {
                    $query->orderBy('price', 'desc');
                } elseif ($sortBy === 'newest') {
                    $query->orderByDesc('created_at');
                } else {
                    $query->orderBy('id', 'asc');
                }

                $courses = $query->with('seller.businessDetail', 'seller.user')->get();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Database connection failed on courses directory: ' . $e->getMessage());
            $courses = collect();
        }

        // Horizontal category pills matching the screenshot
        $horizontalCategories = [
            ['name' => 'All Categories',     'icon' => 'fa-solid fa-table-cells',       'slug' => 'all'],
            ['name' => 'Computer & IT',      'icon' => 'fa-solid fa-laptop-code',        'slug' => 'Computer & IT'],
            ['name' => 'Digital Marketing',  'icon' => 'fa-solid fa-chart-line',         'slug' => 'Digital Marketing'],
            ['name' => 'Programming',        'icon' => 'fa-solid fa-code',               'slug' => 'Programming'],
            ['name' => 'Design & Creative',  'icon' => 'fa-solid fa-palette',            'slug' => 'Design & Creative'],
            ['name' => 'Business & Finance', 'icon' => 'fa-solid fa-briefcase',          'slug' => 'Business & Finance'],
            ['name' => 'Office Productivity','icon' => 'fa-solid fa-file-excel',         'slug' => 'Office Productivity'],
            ['name' => 'Spoken English',     'icon' => 'fa-solid fa-comments',           'slug' => 'Spoken English'],
            ['name' => 'Academic Courses',   'icon' => 'fa-solid fa-graduation-cap',     'slug' => 'Academic Courses'],
            ['name' => 'AI & Tools',         'icon' => 'fa-solid fa-robot',              'slug' => 'AI & Tools'],
            ['name' => 'Tally & Accounting', 'icon' => 'fa-solid fa-calculator',         'slug' => 'Tally & Accounting'],
            ['name' => 'Language',           'icon' => 'fa-solid fa-language',           'slug' => 'Language'],
            ['name' => 'Personal Development','icon'=> 'fa-solid fa-user-astronaut',     'slug' => 'Personal Development'],
            ['name' => 'School & College',   'icon' => 'fa-solid fa-building-columns',  'slug' => 'School & College'],
            ['name' => 'Competitive Exams',  'icon' => 'fa-solid fa-trophy',            'slug' => 'Competitive Exams'],
        ];

        // Sidebar categories with matching counts from screenshot
        $sidebarCategories = [
            ['name' => 'Computer & IT',      'count' => '2,450'],
            ['name' => 'Digital Marketing',  'count' => '1,820'],
            ['name' => 'Programming',        'count' => '1,650'],
            ['name' => 'Design & Creative',  'count' => '1,230'],
            ['name' => 'Business & Finance', 'count' => '1,180'],
            ['name' => 'Office Productivity','count' => '980'],
        ];

        return view('home.courses', [
            'seller'                => $seller,
            'courses'               => $courses,
            'horizontalCategories'  => $horizontalCategories,
            'sidebarCategories'     => $sidebarCategories,
            'searchQuery'           => $searchQuery,
            'selectedCategory'      => $selectedCategory ?: 'All Categories',
            'selectedLevel'         => $selectedLevel,
            'selectedLanguage'      => $selectedLanguage,
            'selectedMode'          => $selectedMode,
            'minPrice'              => $minPrice,
            'maxPrice'              => $maxPrice,
            'sortBy'                => $sortBy,
        ]);
    }

    /**
     * Display the public Products directory page matching the UI design.
     */
    public function products(Request $request): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        $searchQuery = $request->input('search');
        $selectedCategory = $request->input('category');
        $selectedBrands = (array) $request->input('brand', []);
        $selectedCondition = (array) $request->input('condition', []);
        $selectedAvailability = (array) $request->input('availability', []);
        $selectedSellerType = (array) $request->input('seller_type', []);
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 100000);
        $sortBy = $request->input('sort', 'popular');

        $products = collect();

        try {
            if (Schema::hasTable('products')) {
                $query = \App\Models\Product::query()->where('status', 'approved');

                if (!empty($searchQuery)) {
                    $query->where(function ($q) use ($searchQuery) {
                        $q->where('title', 'like', "%{$searchQuery}%")
                          ->orWhere('category', 'like', "%{$searchQuery}%")
                          ->orWhere('description', 'like', "%{$searchQuery}%");
                    });
                }

                if (!empty($selectedCategory) && $selectedCategory !== 'All Products' && $selectedCategory !== 'all') {
                    $query->where('category', 'like', "%{$selectedCategory}%");
                }

                if (!empty($minPrice) && (float)$minPrice > 0) {
                    $query->where('price', '>=', (float) $minPrice);
                }

                if (!empty($maxPrice) && (float)$maxPrice < 100000) {
                    $query->where('price', '<=', (float) $maxPrice);
                }

                if ($sortBy === 'price_low') {
                    $query->orderBy('price', 'asc');
                } elseif ($sortBy === 'price_high') {
                    $query->orderBy('price', 'desc');
                } elseif ($sortBy === 'newest') {
                    $query->orderByDesc('created_at');
                } else {
                    $query->orderBy('id', 'asc');
                }

                $products = $query->with('seller.businessDetail', 'seller.user')->get();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Database connection failed on products directory: ' . $e->getMessage());
            $products = collect();
        }

        // Curated products matching the exact screenshot (12 products in grid)
        $curatedProducts = [
            [
                'id' => 1,
                'title' => 'HP 15s Laptop',
                'specs' => '(Intel Core i5, 16GB, 512GB SSD)',
                'badge' => 'Best Seller',
                'category' => 'Laptops & Computers',
                'brand' => 'HP',
                'rating' => 4.6,
                'reviews_count' => '1.2K',
                'price' => 42999,
                'mrp' => 52999,
                'discount' => '19% OFF',
                'seller_name' => 'Digital Class Store',
                'thumbnail' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 2,
                'title' => 'Logitech Wireless Mouse',
                'specs' => 'M331',
                'badge' => null,
                'category' => 'Accessories',
                'brand' => 'Logitech',
                'rating' => 4.5,
                'reviews_count' => '980',
                'price' => 499,
                'mrp' => 799,
                'discount' => '38% OFF',
                'seller_name' => 'TechWorld',
                'thumbnail' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 3,
                'title' => 'Canon G3010 All-in-One Ink Tank Printer',
                'specs' => null,
                'badge' => null,
                'category' => 'Printers & Scanners',
                'brand' => 'Canon',
                'rating' => 4.6,
                'reviews_count' => '620',
                'price' => 12499,
                'mrp' => 14999,
                'discount' => '17% OFF',
                'seller_name' => 'Print Solutions',
                'thumbnail' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 4,
                'title' => 'Webcam Full HD 1080p with Mic',
                'specs' => null,
                'badge' => null,
                'category' => 'Accessories',
                'brand' => null,
                'rating' => 4.4,
                'reviews_count' => '450',
                'price' => 2499,
                'mrp' => 3499,
                'discount' => '29% OFF',
                'seller_name' => 'Digital Class Store',
                'thumbnail' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 5,
                'title' => 'Tally Prime with GST',
                'specs' => '(Original License)',
                'badge' => null,
                'category' => 'Software & Licenses',
                'brand' => 'Tally',
                'rating' => 4.8,
                'reviews_count' => '320',
                'price' => 20999,
                'mrp' => 25999,
                'discount' => '19% OFF',
                'seller_name' => 'Software Hub',
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 6,
                'title' => 'Classroom LED Display',
                'specs' => '65 Inch 4K',
                'badge' => null,
                'category' => 'Projectors & Displays',
                'brand' => null,
                'rating' => 4.6,
                'reviews_count' => '150',
                'price' => 124999,
                'mrp' => 149999,
                'discount' => '17% OFF',
                'seller_name' => 'EduTech Solutions',
                'thumbnail' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 7,
                'title' => 'Lenovo Tab M10',
                'specs' => '(4GB, 64GB, WiFi)',
                'badge' => null,
                'category' => 'Mobiles & Tablets',
                'brand' => 'Lenovo',
                'rating' => 4.5,
                'reviews_count' => '410',
                'price' => 14999,
                'mrp' => 18999,
                'discount' => '21% OFF',
                'seller_name' => 'Digital Class Store',
                'thumbnail' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 8,
                'title' => 'Study Material Combo',
                'specs' => '(10th & 12th)',
                'badge' => null,
                'category' => 'Books & Study Material',
                'brand' => null,
                'rating' => 4.7,
                'reviews_count' => '890',
                'price' => 1299,
                'mrp' => 1799,
                'discount' => '28% OFF',
                'seller_name' => 'BookKart',
                'thumbnail' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 9,
                'title' => 'Classroom Projector',
                'specs' => '(Epson EB-E01)',
                'badge' => null,
                'category' => 'Projectors & Displays',
                'brand' => 'Epson',
                'rating' => 4.6,
                'reviews_count' => '210',
                'price' => 39999,
                'mrp' => 49999,
                'discount' => '20% OFF',
                'seller_name' => 'Vision Tech',
                'thumbnail' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 10,
                'title' => 'Office Chair Ergonomic',
                'specs' => null,
                'badge' => null,
                'category' => 'Furniture',
                'brand' => null,
                'rating' => 4.4,
                'reviews_count' => '320',
                'price' => 6499,
                'mrp' => 8999,
                'discount' => '28% OFF',
                'seller_name' => 'Furniture World',
                'thumbnail' => 'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 11,
                'title' => 'WiFi Router TP-Link Dual Band',
                'specs' => null,
                'badge' => null,
                'category' => 'Networking',
                'brand' => 'TP-Link',
                'rating' => 4.5,
                'reviews_count' => '680',
                'price' => 2199,
                'mrp' => 3499,
                'discount' => '37% OFF',
                'seller_name' => 'NetGear Solutions',
                'thumbnail' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'id' => 12,
                'title' => '32GB Pen Drive',
                'specs' => 'SanDisk USB 3.0',
                'badge' => null,
                'category' => 'Storage Devices',
                'brand' => 'SanDisk',
                'rating' => 4.6,
                'reviews_count' => '1.1K',
                'price' => 599,
                'mrp' => 999,
                'discount' => '40% OFF',
                'seller_name' => 'Trusted Seller',
                'thumbnail' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        // Horizontal category pills matching the screenshot
        $horizontalCategories = [
            ['name' => 'All Products',          'icon' => 'fa-solid fa-table-cells',        'slug' => 'all'],
            ['name' => 'Laptops & Computers',   'icon' => 'fa-solid fa-laptop',             'slug' => 'Laptops & Computers'],
            ['name' => 'Mobiles & Tablets',     'icon' => 'fa-solid fa-mobile-screen',      'slug' => 'Mobiles & Tablets'],
            ['name' => 'Accessories',           'icon' => 'fa-solid fa-headphones',         'slug' => 'Accessories'],
            ['name' => 'Software & Licenses',   'icon' => 'fa-solid fa-compact-disc',       'slug' => 'Software & Licenses'],
            ['name' => 'Books & Study Material','icon' => 'fa-solid fa-book-open',          'slug' => 'Books & Study Material'],
            ['name' => 'Office & Stationery',   'icon' => 'fa-solid fa-paperclip',          'slug' => 'Office & Stationery'],
            ['name' => 'Classroom Equipment',   'icon' => 'fa-solid fa-chalkboard-user',    'slug' => 'Classroom Equipment'],
            ['name' => 'Furniture',             'icon' => 'fa-solid fa-chair',              'slug' => 'Furniture'],
            ['name' => 'CCTV & Security',       'icon' => 'fa-solid fa-video',              'slug' => 'CCTV & Security'],
            ['name' => 'Networking',            'icon' => 'fa-solid fa-wifi',               'slug' => 'Networking'],
            ['name' => 'Projectors & Displays', 'icon' => 'fa-solid fa-desktop',            'slug' => 'Projectors & Displays'],
            ['name' => 'Printers & Scanners',   'icon' => 'fa-solid fa-print',              'slug' => 'Printers & Scanners'],
            ['name' => 'Storage Devices',       'icon' => 'fa-solid fa-hard-drive',         'slug' => 'Storage Devices'],
            ['name' => 'More',                  'icon' => 'fa-solid fa-ellipsis',           'slug' => 'more'],
        ];

        // Sidebar categories with matching counts from screenshot
        $sidebarCategories = [
            ['name' => 'Laptops & Computers',    'count' => '1,240'],
            ['name' => 'Mobiles & Tablets',      'count' => '890'],
            ['name' => 'Accessories',            'count' => '1,560'],
            ['name' => 'Software & Licenses',    'count' => '720'],
            ['name' => 'Books & Study Material', 'count' => '1,980'],
        ];

        // Sidebar brands with matching counts from screenshot
        $sidebarBrands = [
            ['name' => 'HP',      'count' => '320'],
            ['name' => 'Dell',    'count' => '280'],
            ['name' => 'Lenovo',  'count' => '260'],
            ['name' => 'Apple',   'count' => '180'],
            ['name' => 'Samsung', 'count' => '310'],
        ];

        // Deal of the Day
        $dealOfTheDay = [
            'title' => 'boAt Airdopes 141 Wireless Earbuds',
            'rating' => 4.4,
            'reviews_count' => 320,
            'price' => 999,
            'mrp' => 1999,
            'discount' => '50% OFF',
            'hours' => '12',
            'minutes' => '34',
            'seconds' => '56',
            'thumbnail' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=300&auto=format&fit=crop&q=80',
        ];

        return view('home.products', [
            'seller'                => $seller,
            'products'              => $products->isNotEmpty() ? $products : $curatedProducts,
            'curatedProducts'       => $curatedProducts,
            'horizontalCategories'  => $horizontalCategories,
            'sidebarCategories'     => $sidebarCategories,
            'sidebarBrands'         => $sidebarBrands,
            'dealOfTheDay'          => $dealOfTheDay,
            'searchQuery'           => $searchQuery,
            'selectedCategory'      => $selectedCategory ?: 'All Products',
            'selectedBrands'        => $selectedBrands,
            'selectedCondition'     => $selectedCondition,
            'selectedAvailability'  => $selectedAvailability,
            'selectedSellerType'    => $selectedSellerType,
            'minPrice'              => $minPrice,
            'maxPrice'              => $maxPrice,
            'sortBy'                => $sortBy,
        ]);
    }

    /**
     * Display the Course Info / Detail page matching the UI design with full SEO.
     */
    public function courseShow(Request $request, $slug): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        $course = null;
        try {
            if (Schema::hasTable('courses')) {
                $course = \App\Models\Course::with(['seller.businessDetail', 'seller.user', 'contents'])
                    ->where('slug', $slug)
                    ->first();

                if (!$course) {
                    $course = \App\Models\Course::with(['seller.businessDetail', 'seller.user', 'contents'])
                        ->where('title', 'like', "%{$slug}%")
                        ->first();
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Database connection failed on courseShow: ' . $e->getMessage());
        }

        if (!$course) {
            abort(404, 'Course not found');
        }

        // Related courses for "You May Also Like"
        $relatedCourses = collect();
        try {
            if (Schema::hasTable('courses')) {
                $relatedCourses = \App\Models\Course::where('id', '!=', $course?->id ?? 0)
                    ->where('status', 'approved')
                    ->take(4)
                    ->get();
            }
        } catch (\Throwable $e) {
            $relatedCourses = collect();
        }

        // Default curriculum modules matching the screenshot
        $curriculum = [
            ['section' => '1. Introduction to Digital Marketing', 'lectures' => '4 Lectures', 'duration' => '1h 45m', 'items' => [
                ['title' => 'Welcome to Digital Marketing Masterclass', 'duration' => '12:45', 'preview' => true],
                ['title' => 'Digital Marketing Ecosystem & Strategy', 'duration' => '22:15', 'preview' => false],
                ['title' => 'Understanding Customer Personas', 'duration' => '35:20', 'preview' => false],
                ['title' => 'Setting Up Your Marketing Toolkit', 'duration' => '34:40', 'preview' => false],
            ]],
            ['section' => '2. Website & Blogging', 'lectures' => '8 Lectures', 'duration' => '4h 10m', 'items' => [
                ['title' => 'WordPress Domain & Hosting Setup', 'duration' => '28:10', 'preview' => true],
                ['title' => 'Creating High-Converting Landing Pages', 'duration' => '42:30', 'preview' => false],
                ['title' => 'Blogging Architecture & Pillar Content', 'duration' => '38:15', 'preview' => false],
            ]],
            ['section' => '3. Search Engine Optimization (SEO)', 'lectures' => '10 Lectures', 'duration' => '6h 20m', 'items' => [
                ['title' => 'Keyword Research with Semrush & Ahrefs', 'duration' => '45:00', 'preview' => true],
                ['title' => 'On-Page SEO & Content Optimization', 'duration' => '52:10', 'preview' => false],
                ['title' => 'Technical SEO & Core Web Vitals', 'duration' => '48:30', 'preview' => false],
                ['title' => 'Link Building & Authority Generation', 'duration' => '40:20', 'preview' => false],
            ]],
            ['section' => '4. Social Media Marketing', 'lectures' => '10 Lectures', 'duration' => '6h 15m', 'items' => [
                ['title' => 'Instagram Growth & Viral Reels Strategy', 'duration' => '35:45', 'preview' => true],
                ['title' => 'Facebook Business Manager & Meta Ads', 'duration' => '58:20', 'preview' => false],
                ['title' => 'LinkedIn B2B Lead Generation', 'duration' => '44:10', 'preview' => false],
            ]],
            ['section' => '5. Google Ads (Search & Display)', 'lectures' => '8 Lectures', 'duration' => '5h 40m', 'items' => [
                ['title' => 'Google Search Campaign Setup & Quality Score', 'duration' => '42:15', 'preview' => true],
                ['title' => 'Display, Remarketing & Performance Max', 'duration' => '50:30', 'preview' => false],
            ]],
            ['section' => '6. Content Marketing & Email Marketing', 'lectures' => '8 Lectures', 'duration' => '4h 20m', 'items' => [
                ['title' => 'Automated Email Drip Sequences & Mailchimp', 'duration' => '38:40', 'preview' => true],
                ['title' => 'Copywriting Frameworks That Convert', 'duration' => '46:10', 'preview' => false],
            ]],
            ['section' => '7. AI Tools for Digital Marketing', 'lectures' => '8 Lectures', 'duration' => '4h 10m', 'items' => [
                ['title' => 'ChatGPT Prompt Engineering for Marketers', 'duration' => '35:10', 'preview' => true],
                ['title' => 'Midjourney & Canva AI Creative Workflows', 'duration' => '42:25', 'preview' => false],
            ]],
            ['section' => '8. Live Projects & Case Studies', 'lectures' => '5 Lectures', 'duration' => '3h 20m', 'items' => [
                ['title' => 'End-to-End E-Commerce Marketing Campaign', 'duration' => '55:00', 'preview' => true],
                ['title' => 'Real-Time ROI & Conversion Tracking', 'duration' => '45:30', 'preview' => false],
            ]],
        ];

        // If the course has custom contents in database, adapt
        if ($course && $course->contents->isNotEmpty()) {
            $dbCurriculum = [];
            foreach ($course->contents->groupBy('section_title') as $secTitle => $lectures) {
                $dbCurriculum[] = [
                    'section' => $secTitle,
                    'lectures' => $lectures->count() . ' Lectures',
                    'duration' => ($lectures->count() * 12) . 'm',
                    'items' => $lectures->map(fn($l) => [
                        'title' => $l->lecture_title,
                        'duration' => $l->duration ?: '10:00',
                        'preview' => (bool)$l->video_url,
                    ])->toArray(),
                ];
            }
            $curriculum = $dbCurriculum;
        }

        // Learning points matching the screenshot
        $learningPoints = [
            'Complete Digital Marketing from Basics to Advanced',
            'SEO (On-Page & Off-Page)',
            'Social Media Marketing (Facebook, Instagram, YouTube, LinkedIn)',
            'Google Ads (Search, Display, YouTube Ads)',
            'Content Marketing & Blogging',
            'Email Marketing & Automation',
            'AI Tools for Digital Marketing',
            'Lead Generation & Funnel Building',
            'Live Projects & Case Studies',
            'Get Industry Recognized Certificate',
        ];

        // Target audience matching the screenshot
        $targetAudience = [
            'Students looking for high-demand skills',
            'Working professionals',
            'Business owners & entrepreneurs',
            'Freelancers',
            'Anyone who wants to start a career in digital marketing',
        ];

        // Requirements matching the screenshot
        $requirements = [
            'Basic computer knowledge',
            'Internet connection',
            'No prior marketing experience required',
            'Passion to learn and grow',
        ];

        // Reviews matching the screenshot
        $reviews = [
            [
                'author' => 'Priya Shah',
                'time_ago' => '2 weeks ago',
                'rating' => 5,
                'text' => 'Very practical and easy to understand. Live projects are amazing! Highly recommended!',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&auto=format&fit=crop&q=80',
            ],
            [
                'author' => 'Rahul Mehta',
                'time_ago' => '1 month ago',
                'rating' => 5,
                'text' => 'Best digital marketing course in India. Learned a lot of new strategies.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&auto=format&fit=crop&q=80',
            ],
            [
                'author' => 'Karan Patel',
                'time_ago' => '1 month ago',
                'rating' => 5,
                'text' => 'Content is up to date and very well explained. Certificate is also valuable.',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&auto=format&fit=crop&q=80',
            ],
        ];

        return view('home.course-show', [
            'seller'          => $seller,
            'course'          => $course,
            'relatedCourses'  => $relatedCourses,
            'curriculum'      => $curriculum,
            'learningPoints'  => $learningPoints,
            'targetAudience'  => $targetAudience,
            'requirements'    => $requirements,
            'reviews'         => $reviews,
        ]);
    }

    /**
     * Enroll in a course.
     */
    public function courseEnroll(Request $request, $slug): \Illuminate\Http\RedirectResponse
    {
        return back()->with('success', 'Course added to your learning dashboard! Check your email for instant access.');
    }

    /**
     * Submit a review for a course.
     */
    public function courseReview(Request $request, $slug): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'author' => 'required|string|max:120',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:600',
        ]);

        return back()->with('success', 'Thank you! Your course review has been submitted successfully.');
    }

    /**
     * Display the dynamic Product Description page matching the HP 15s UI design.
     */
    public function productShow(Request $request, $slug): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        $product = null;
        try {
            if (Schema::hasTable('products')) {
                $product = \App\Models\Product::with(['seller.businessDetail', 'seller.user'])
                    ->where('slug', $slug)
                    ->first();

                if (!$product) {
                    $normalized = str_replace('-', ' ', $slug);
                    $product = \App\Models\Product::with(['seller.businessDetail', 'seller.user'])
                        ->where('title', 'like', "%{$normalized}%")
                        ->orWhere('slug', 'like', "%{$slug}%")
                        ->first();
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Database connection failed on productShow: ' . $e->getMessage());
        }

        $catalogData = $this->resolveProductCatalogDetails($slug, $product);
        $catalogData['seller'] = $seller;

        return view('home.product-show', $catalogData);
    }

    /**
     * Resolve rich catalog specs, gallery, highlights, and bundles for any product slug.
     */
    private function resolveProductCatalogDetails(string $slug, ?\App\Models\Product $product): array
    {
        $cleanSlug = strtolower(trim($slug));

        // Registry of curated catalog definitions matching the products directory
        $registry = [
            'mouse' => [
                'match' => ['mouse', 'logitech-wireless-mouse', 'm331', 'm330'],
                'title' => 'Logitech Wireless Mouse M331 Silent Plus (2.4GHz, 1000 DPI, 24M Battery)',
                'category' => 'Accessories',
                'brand' => 'Logitech',
                'brandLogo' => 'logi',
                'series' => 'M331 Silent',
                'productCode' => 'LOGI-M331-WL',
                'price' => 499,
                'mrp' => 799,
                'discount' => 38,
                'description' => 'Enjoy the sound of silence. M331 Silent Plus delivers the same click feel without the click noise, reducing over 90% of sound. Advanced optical tracking and contoured ergonomic grip for long work hours.',
                'thumbnail' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1598550476439-6847785fcea6?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1563297007-0686b7003af7?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '1000 DPI Optical', 'icon' => 'fa-solid fa-crosshairs', 'sub' => 'Tracking Sensor'],
                    ['label' => '2.4 GHz Wireless', 'icon' => 'fa-solid fa-wifi', 'sub' => 'Nano Receiver'],
                    ['label' => '24-Month Battery', 'icon' => 'fa-solid fa-battery-full', 'sub' => 'Single AA Cell'],
                    ['label' => 'Silent Click 90% Sound Red.', 'icon' => 'fa-solid fa-volume-xmark', 'sub' => 'SilentTouch Tech'],
                    ['label' => '10m Range', 'icon' => 'fa-solid fa-arrows-to-dot', 'sub' => 'Operating Distance'],
                    ['label' => '90g Lightweight', 'icon' => 'fa-solid fa-feather-pointed', 'sub' => 'Ergonomic Body'],
                ],
                'features' => [
                    ['title' => 'Over 90% Noise Reduction', 'sub' => '(Same click feel without distraction)', 'icon' => 'fa-solid fa-volume-xmark'],
                    ['title' => '24-Month Long Battery Life', 'sub' => '(Auto-sleep power saving mode)', 'icon' => 'fa-solid fa-battery-full'],
                    ['title' => 'Plug-and-Forget Nano Receiver', 'sub' => '(Reliable 2.4GHz wireless connection)', 'icon' => 'fa-solid fa-usb'],
                    ['title' => 'Ergonomic Right-Hand Design', 'sub' => '(Soft curved rubber grips for palm)', 'icon' => 'fa-solid fa-hand'],
                    ['title' => 'Advanced Optical Tracking', 'sub' => '(Precision movements on any desk surface)', 'icon' => 'fa-solid fa-crosshairs'],
                    ['title' => 'Universal OS Compatibility', 'sub' => '(Windows, macOS, Linux, ChromeOS)', 'icon' => 'fa-brands fa-windows'],
                ],
                'highlights' => [
                    ['title' => 'Silent Clicks for Study', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Ergonomic Palm Rest', 'img' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=400&auto=format&fit=crop&q=80'],
                    ['title' => '2-Year Battery Life', 'img' => 'https://images.unsplash.com/photo-1598550476439-6847785fcea6?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'High Precision 1000 DPI', 'img' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Portable & Compact', 'img' => 'https://images.unsplash.com/photo-1563297007-0686b7003af7?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Plug & Play USB Nano', 'img' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Matte Black', 'hex' => '#1e293b'],
                    ['name' => 'Charcoal Grey', 'hex' => '#64748b'],
                    ['name' => 'Ice Blue', 'hex' => '#0284c7'],
                ],
                'bundles' => [
                    ['title' => 'Logitech Wireless Mouse', 'price' => 499, 'thumb' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Ergonomic Gel Mouse Pad', 'price' => 249, 'thumb' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Duracell AA Batteries (4-Pack)', 'price' => 199, 'thumb' => 'https://images.unsplash.com/photo-1598550476439-6847785fcea6?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'printer' => [
                'match' => ['printer', 'canon', 'g3010', 'ink-tank'],
                'title' => 'Canon PIXMA G3010 All-in-One Wireless Ink Tank Color Printer (Print, Scan, Copy)',
                'category' => 'Printers & Scanners',
                'brand' => 'Canon',
                'brandLogo' => 'Canon',
                'series' => 'PIXMA G-Series',
                'productCode' => 'CAN-G3010-INK',
                'price' => 12499,
                'mrp' => 14999,
                'discount' => 17,
                'description' => 'Designed for high volume printing at ultra-low running cost. Canon PIXMA G3010 offers wireless printing, copying and scanning with integrated spill-resistant transparent ink tanks.',
                'thumbnail' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1589330694653-dad6d3240e2b?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1544816155-12df9643f363?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => 'Integrated Ink Tank', 'icon' => 'fa-solid fa-fill-drip', 'sub' => '7,000 Page Yield'],
                    ['label' => 'Print / Scan / Copy', 'icon' => 'fa-solid fa-copy', 'sub' => '3-in-1 Multi-function'],
                    ['label' => 'Wi-Fi & USB 2.0', 'icon' => 'fa-solid fa-wifi', 'sub' => 'Direct Phone Print'],
                    ['label' => '8.8 ipm Black / 5.0 Color', 'icon' => 'fa-solid fa-gauge-high', 'sub' => 'Fast Speed'],
                    ['label' => 'Borderless Photo', 'icon' => 'fa-solid fa-image', 'sub' => 'Up to A4 Size'],
                    ['label' => '100-Sheet Rear Tray', 'icon' => 'fa-solid fa-layer-group', 'sub' => 'Paper Capacity'],
                ],
                'features' => [
                    ['title' => 'High Page Yield Ink Bottles', 'sub' => '(Up to 7,000 black & 6,000 color pages)', 'icon' => 'fa-solid fa-fill-drip'],
                    ['title' => 'Direct Mobile Wireless Printing', 'sub' => '(Canon PRINT Inkjet app & Apple AirPrint)', 'icon' => 'fa-solid fa-mobile-screen'],
                    ['title' => 'Flatbed Document Scanner', 'sub' => '(600 x 1200 dpi optical resolution)', 'icon' => 'fa-solid fa-print'],
                    ['title' => 'Spill-Resistant Bottle Design', 'sub' => '(Easy mess-free refilling tanks)', 'icon' => 'fa-solid fa-bottle-droplet'],
                    ['title' => 'Borderless Photo Printing', 'sub' => '(Create vivid photos up to A4 size)', 'icon' => 'fa-solid fa-image'],
                    ['title' => 'Compact Space-Saving Body', 'sub' => '(Fits comfortably on desks and shelves)', 'icon' => 'fa-solid fa-maximize'],
                ],
                'highlights' => [
                    ['title' => 'Ultra-Low Cost Per Page', 'img' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Seamless Wi-Fi Printing', 'img' => 'https://images.unsplash.com/photo-1589330694653-dad6d3240e2b?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Crisp Document Scans', 'img' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Spill-Free Refill Bottles', 'img' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'High Capacity Paper Tray', 'img' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Ideal for School & Office', 'img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Classic Black', 'hex' => '#0f172a'],
                ],
                'bundles' => [
                    ['title' => 'Canon G3010 Printer', 'price' => 12499, 'thumb' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'A4 Copier Paper (500 Sheets)', 'price' => 349, 'thumb' => 'https://images.unsplash.com/photo-1589330694653-dad6d3240e2b?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Canon GI-790 Black Ink Bottle', 'price' => 499, 'thumb' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'webcam' => [
                'match' => ['webcam', 'webcam-full-hd-1080p-with-mic', 'camera', '1080p'],
                'title' => 'Webcam Full HD 1080p with Dual Noise-Cancelling Microphone & Privacy Shutter',
                'category' => 'Accessories',
                'brand' => 'Digital Class',
                'brandLogo' => 'dc',
                'series' => 'ProCam 1080',
                'productCode' => 'DC-CAM-1080P',
                'price' => 2499,
                'mrp' => 3499,
                'discount' => 29,
                'description' => 'Crisp Full HD 1080p video streaming at 30fps. Features dual built-in stereo noise-cancelling microphones, automatic low-light correction, and a built-in privacy cover for secure online classes and meetings.',
                'thumbnail' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '1080p FHD 30 FPS', 'icon' => 'fa-solid fa-video', 'sub' => 'Sharp Resolution'],
                    ['label' => 'Dual Noise-Cancel Mic', 'icon' => 'fa-solid fa-microphone', 'sub' => 'Stereo Audio'],
                    ['label' => '90° Wide Angle Lens', 'icon' => 'fa-solid fa-expand', 'sub' => 'Field of View'],
                    ['label' => 'Auto Light Correction', 'icon' => 'fa-solid fa-sun', 'sub' => 'Dim Light Optimization'],
                    ['label' => 'Privacy Shutter Cover', 'icon' => 'fa-solid fa-shield-halved', 'sub' => 'Security Guard'],
                    ['label' => 'Plug & Play USB', 'icon' => 'fa-solid fa-usb', 'sub' => 'Driver-free Setup'],
                ],
                'features' => [
                    ['title' => 'Full HD 1080p Video Clarity', 'sub' => '(Smooth 30 frames-per-second streaming)', 'icon' => 'fa-solid fa-video'],
                    ['title' => 'Built-In Dual Stereo Microphones', 'sub' => '(Captures natural sound and filters ambient noise)', 'icon' => 'fa-solid fa-microphone'],
                    ['title' => 'Integrated Privacy Shutter', 'sub' => '(Slide closed to ensure complete privacy)', 'icon' => 'fa-solid fa-shield'],
                    ['title' => 'Automatic Low Light Balancing', 'sub' => '(Look bright and clear in dim room lighting)', 'icon' => 'fa-solid fa-sun'],
                    ['title' => 'Universal Tripod Ready Mount', 'sub' => '(Clips securely on monitors or stands on desks)', 'icon' => 'fa-solid fa-laptop'],
                    ['title' => 'Driver-Free Plug & Play', 'sub' => '(Works instantly with Zoom, Teams & Google Meet)', 'icon' => 'fa-solid fa-bolt'],
                ],
                'highlights' => [
                    ['title' => 'Online Teaching & Lectures', 'img' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Crisp 1080p Video Calls', 'img' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Dual Mic Noise Reduction', 'img' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Privacy Cover Security', 'img' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Flexible 360° Rotation', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'USB Plug & Play', 'img' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Obsidian Black', 'hex' => '#0f172a'],
                ],
                'bundles' => [
                    ['title' => 'HD 1080p Webcam', 'price' => 2499, 'thumb' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Adjustable Mini Tripod', 'price' => 399, 'thumb' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'USB Extension Cable 2m', 'price' => 199, 'thumb' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'software' => [
                'match' => ['software', 'tally', 'license', 'tally-prime'],
                'title' => 'Tally Prime with GST (Original Single User Silver License - Lifetime Validity)',
                'category' => 'Software & Licenses',
                'brand' => 'Tally',
                'brandLogo' => 'Tally',
                'series' => 'Prime 4.0',
                'productCode' => 'TALLY-PRIME-SILV',
                'price' => 20999,
                'mrp' => 25999,
                'discount' => 19,
                'description' => 'Original genuine license of Tally Prime with complete GST readiness, e-Invoicing, e-Way bill generation, multi-company accounting, inventory control and statutory financial reporting.',
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => 'Single User Silver', 'icon' => 'fa-solid fa-key', 'sub' => 'Original License'],
                    ['label' => 'Lifetime Validity', 'icon' => 'fa-solid fa-infinity', 'sub' => 'Perpetual Access'],
                    ['label' => 'Full GST & E-Invoice', 'icon' => 'fa-solid fa-file-invoice-dollar', 'sub' => 'Compliant Filing'],
                    ['label' => 'Multi-Company Support', 'icon' => 'fa-solid fa-building', 'sub' => 'Branch Accounts'],
                    ['label' => 'Bank Auto-Reconciliation', 'icon' => 'fa-solid fa-building-columns', 'sub' => 'All Major Banks'],
                    ['label' => '1 Year Free TSS Upgrade', 'icon' => 'fa-solid fa-headset', 'sub' => 'Cloud & Support'],
                ],
                'features' => [
                    ['title' => 'Complete GST Filing & E-Way Bill', 'sub' => '(Direct GSTR-1, 3B and e-Invoice upload)', 'icon' => 'fa-solid fa-file-invoice'],
                    ['title' => 'Real-Time Financial Reporting', 'sub' => '(P&L, Balance Sheet, Cash Flow & Trial Balance)', 'icon' => 'fa-solid fa-chart-line'],
                    ['title' => 'Smart Inventory & Batch Management', 'sub' => '(Track expiry dates, lots, barcodes and stock)', 'icon' => 'fa-solid fa-warehouse'],
                    ['title' => 'Seamless Bank Reconciliation', 'sub' => '(Auto-detect uncleared cheques and statements)', 'icon' => 'fa-solid fa-building-columns'],
                    ['title' => 'Multi-Currency & Multi-Lingual', 'sub' => '(Transact in local currencies and Indian languages)', 'icon' => 'fa-solid fa-globe'],
                    ['title' => 'Instant Digital Key Delivery', 'sub' => '(Serial number and activation key sent via email/SMS)', 'icon' => 'fa-solid fa-bolt'],
                ],
                'highlights' => [
                    ['title' => 'Simplified GST Accounting', 'img' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Executive Dashboards', 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Instant Audit & Balance Sheet', 'img' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Automated E-Invoicing', 'img' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Bank Reconciliation', 'img' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Instant Setup & Support', 'img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => null,
                'bundles' => [
                    ['title' => 'Tally Prime Silver License', 'price' => 20999, 'thumb' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'GST Practice Handbook 2026', 'price' => 499, 'thumb' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'USB Backup Security Key', 'price' => 799, 'thumb' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'display' => [
                'match' => ['display', 'classroom-led-display', 'led', 'interactive-panel', '65'],
                'title' => 'Classroom Interactive Flat Panel LED Display 65 Inch 4K UHD (20-Point Multi-Touch, Android & Windows)',
                'category' => 'Projectors & Displays',
                'brand' => 'Digital Class',
                'brandLogo' => 'dc',
                'series' => 'TouchPro 65',
                'productCode' => 'DC-DISP-65-4K',
                'price' => 124999,
                'mrp' => 149999,
                'discount' => 17,
                'description' => '65-inch 4K Ultra HD interactive digital smart board designed for modern classrooms and conference rooms. Features 20-point multi-touch, dual OS (Android + Windows OPS slot), anti-glare toughened glass, and wireless screen sharing.',
                'thumbnail' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '65" 4K UHD (3840x2160)', 'icon' => 'fa-solid fa-tv', 'sub' => 'Anti-Glare Panel'],
                    ['label' => '20-Point Multi-Touch', 'icon' => 'fa-solid fa-hand-pointer', 'sub' => 'High Precision IR'],
                    ['label' => 'Android 12 + 4GB/32GB', 'icon' => 'fa-brands fa-android', 'sub' => 'Built-in Smart OS'],
                    ['label' => '4mm Toughened Glass', 'icon' => 'fa-solid fa-shield', 'sub' => '7H Hardness Safety'],
                    ['label' => 'Dual 15W Speakers', 'icon' => 'fa-solid fa-volume-high', 'sub' => 'Room-Filling Audio'],
                    ['label' => 'Wireless Screen Share', 'icon' => 'fa-solid fa-satellite-dish', 'sub' => 'Up to 4 Screens'],
                ],
                'features' => [
                    ['title' => 'Ultra HD 4K Vivid Clarity', 'sub' => '(3840x2160 pixels with 178° viewing angle)', 'icon' => 'fa-solid fa-tv'],
                    ['title' => '20-Point Zero-Gap Infrared Touch', 'sub' => '(Smooth writing with fingers or dual stylus pens)', 'icon' => 'fa-solid fa-pen'],
                    ['title' => 'Interactive Digital Whiteboard', 'sub' => '(Teaching tools for geometry, graphs and PDFs)', 'icon' => 'fa-solid fa-chalkboard-user'],
                    ['title' => 'Wireless 4-Screen Projection', 'sub' => '(Mirror laptops, tablets and phones wirelessly)', 'icon' => 'fa-solid fa-share-nodes'],
                    ['title' => 'Toughened 7H Anti-Scratch Glass', 'sub' => '(Durable explosion-proof protective screen)', 'icon' => 'fa-solid fa-shield'],
                    ['title' => 'Dual OS Support (Android + Windows)', 'sub' => '(Plug-in modular OPS PC compatible)', 'icon' => 'fa-brands fa-windows'],
                ],
                'highlights' => [
                    ['title' => 'Smart Classroom Teaching', 'img' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=400&auto=format&fit=crop&q=80'],
                    ['title' => '4K Ultra HD Resolution', 'img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Smooth Multi-Touch Writing', 'img' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Wireless Screen Mirroring', 'img' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Toughened Safety Glass', 'img' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Institute Installation Included', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Obsidian Black', 'hex' => '#0f172a'],
                ],
                'bundles' => [
                    ['title' => '65" Interactive Panel', 'price' => 124999, 'thumb' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Mobile Heavy-Duty Floor Trolley', 'price' => 7999, 'thumb' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Dual Magnetic Touch Stylus', 'price' => 1299, 'thumb' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'tablet' => [
                'match' => ['tab', 'tablet', 'lenovo-tab-m10', 'm10'],
                'title' => 'Lenovo Tab M10 FHD Plus (10.3" FHD, 4GB RAM, 64GB ROM, Wi-Fi, Android 12, Octa-Core)',
                'category' => 'Mobiles & Tablets',
                'brand' => 'Lenovo',
                'brandLogo' => 'Lenovo',
                'series' => 'Tab M10 Plus',
                'productCode' => 'LEN-TAB-M10',
                'price' => 14999,
                'mrp' => 18999,
                'discount' => 21,
                'description' => 'Fast and sleek educational tablet for students. Features a brilliant 10.3-inch Full HD IPS screen, dual speakers with Dolby Atmos, fast octa-core processor, and eye-protection reading mode.',
                'thumbnail' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '10.3" FHD IPS Touch', 'icon' => 'fa-solid fa-tablet-screen-button', 'sub' => '1920x1200 Display'],
                    ['label' => '4GB RAM + 64GB ROM', 'icon' => 'fa-solid fa-memory', 'sub' => 'Expandable 256GB'],
                    ['label' => 'MediaTek Octa-Core', 'icon' => 'fa-solid fa-microchip', 'sub' => '2.3 GHz Processor'],
                    ['label' => '5000 mAh Battery', 'icon' => 'fa-solid fa-battery-three-quarters', 'sub' => 'All-Day Learning'],
                    ['label' => 'Dual Dolby Atmos Speakers', 'icon' => 'fa-solid fa-volume-high', 'sub' => 'Surround Sound'],
                    ['label' => 'TUV Eye Protection', 'icon' => 'fa-solid fa-eye', 'sub' => 'Low Blue Light'],
                ],
                'features' => [
                    ['title' => '10.3-inch Full HD IPS Display', 'sub' => '(Wide viewing angles with slim 4.6mm bezels)', 'icon' => 'fa-solid fa-tablet-screen-button'],
                    ['title' => 'Dual Speakers with Dolby Atmos', 'sub' => '(Clear vocal audio for online classes and videos)', 'icon' => 'fa-solid fa-volume-high'],
                    ['title' => 'Full Metal Aluminum Body', 'sub' => '(Premium modern finish with 87% screen ratio)', 'icon' => 'fa-solid fa-shield'],
                    ['title' => 'TUV Certified Eye Care Mode', 'sub' => '(Reduces eye strain during long reading hours)', 'icon' => 'fa-solid fa-eye'],
                    ['title' => 'Fast Facial Recognition Unlock', 'sub' => '(Log in instantly with 5MP front camera)', 'icon' => 'fa-solid fa-user-lock'],
                    ['title' => 'Dedicated Google Kids Space', 'sub' => '(Teacher-approved educational games and books)', 'icon' => 'fa-solid fa-graduation-cap'],
                ],
                'highlights' => [
                    ['title' => 'Ideal for Student E-Learning', 'img' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Vivid FHD IPS Display', 'img' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Cinematic Dolby Audio', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'All-Day Battery Life', 'img' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Slim Metal Design', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Eye Care Reading Mode', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Iron Grey', 'hex' => '#475569'],
                    ['name' => 'Platinum Silver', 'hex' => '#cbd5e1'],
                ],
                'bundles' => [
                    ['title' => 'Lenovo Tab M10', 'price' => 14999, 'thumb' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Magnetic Folio Stand Cover', 'price' => 699, 'thumb' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=200&auto=format&fit=crop&q=80'],
                    ['title' => '9H Tempered Glass Guard', 'price' => 299, 'thumb' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'books' => [
                'match' => ['study-material-combo', 'books', 'book', 'combo', 'study'],
                'title' => 'Complete Study Material Combo (10th & 12th Board Exam Guides, 10-Year Solved Papers & Revision Notes)',
                'category' => 'Books & Study Material',
                'brand' => 'Digital Class',
                'brandLogo' => 'dc',
                'series' => 'Board Master 2026',
                'productCode' => 'DC-BOOK-COMBO',
                'price' => 1299,
                'mrp' => 1799,
                'discount' => 28,
                'description' => 'Comprehensive preparation master set covering Science, Maths, Social Studies and English. Includes 10-year solved previous question papers, chapter mind maps, and mock practice exams aligned with latest board patterns.',
                'thumbnail' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '10th & 12th Board', 'icon' => 'fa-solid fa-book-open', 'sub' => 'Complete Syllabus'],
                    ['label' => '6 Books Master Set', 'icon' => 'fa-solid fa-layer-group', 'sub' => 'All Major Subjects'],
                    ['label' => '10-Year Solved Papers', 'icon' => 'fa-solid fa-clipboard-check', 'sub' => 'Real Exam PYQs'],
                    ['label' => 'NCERT & CBSE Pattern', 'icon' => 'fa-solid fa-certificate', 'sub' => '2025-2026 Edition'],
                    ['label' => 'Quick Revision Maps', 'icon' => 'fa-solid fa-map', 'sub' => 'Formula Charts'],
                    ['label' => 'Free Video Solutions', 'icon' => 'fa-solid fa-video', 'sub' => 'QR Code Enabled'],
                ],
                'features' => [
                    ['title' => 'Updated 2025-2026 Exam Pattern', 'sub' => '(Strictly adheres to latest board marking scheme)', 'icon' => 'fa-solid fa-book-open'],
                    ['title' => '10 Previous Years Solved Papers', 'sub' => '(Step-by-step model answers by top educators)', 'icon' => 'fa-solid fa-clipboard-check'],
                    ['title' => 'Rapid Revision Mind Maps', 'sub' => '(Summarize full chapters in 15 minutes)', 'icon' => 'fa-solid fa-map'],
                    ['title' => '10 Full-Length Mock Sample Tests', 'sub' => '(Test speed and time management before exam day)', 'icon' => 'fa-solid fa-clock'],
                    ['title' => 'QR Code Video Explanations', 'sub' => '(Scan tricky questions for instant video solutions)', 'icon' => 'fa-solid fa-qrcode'],
                    ['title' => 'High Quality Glare-Free Paper', 'sub' => '(Durable thread binding made for rigorous study)', 'icon' => 'fa-solid fa-feather'],
                ],
                'highlights' => [
                    ['title' => '100% Board Exam Aligned', 'img' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Solved Previous 10 Years', 'img' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Quick Formula Mind Maps', 'img' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Practice Mock Test Papers', 'img' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Step-by-Step Solutions', 'img' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Free Home Delivery', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => null,
                'bundles' => [
                    ['title' => 'Study Material Combo', 'price' => 1299, 'thumb' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Fluorescent Highlighters Set', 'price' => 149, 'thumb' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Exam Hardboard Clipboard', 'price' => 199, 'thumb' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'projector' => [
                'match' => ['projector', 'classroom-projector', 'epson', 'eb-e01'],
                'title' => 'Epson EB-E01 3LCD Classroom & Office Projector (3,600 Lumens, XGA, 300" Screen, 12,000h Lamp)',
                'category' => 'Projectors & Displays',
                'brand' => 'Epson',
                'brandLogo' => 'Epson',
                'series' => 'EB-Series 3LCD',
                'productCode' => 'EPS-PRJ-E01',
                'price' => 39999,
                'mrp' => 49999,
                'discount' => 20,
                'description' => '3LCD technology delivers 3x brighter colors and no rainbow distortion. Boasts 3,600 ANSI lumens brightness, massive 300-inch projection capability, and a long lamp life of up to 12,000 hours in Eco mode.',
                'thumbnail' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '3,600 ANSI Lumens', 'icon' => 'fa-solid fa-lightbulb', 'sub' => 'Daylight Visible'],
                    ['label' => '300" Max Screen Size', 'icon' => 'fa-solid fa-expand', 'sub' => 'Huge Projection'],
                    ['label' => '3LCD Color Tech', 'icon' => 'fa-solid fa-palette', 'sub' => 'True-to-Life Colors'],
                    ['label' => '12,000 Hours Lamp Life', 'icon' => 'fa-solid fa-clock', 'sub' => 'Eco Mode Durability'],
                    ['label' => 'HDMI, VGA & USB Ports', 'icon' => 'fa-solid fa-network-wired', 'sub' => 'Universal Connect'],
                    ['label' => 'Auto Keystone Correct', 'icon' => 'fa-solid fa-crop-simple', 'sub' => 'Instant Image Alignment'],
                ],
                'features' => [
                    ['title' => '3,600 ANSI Lumens Daylight Brightness', 'sub' => '(Clear teaching visuals without turning off lights)', 'icon' => 'fa-solid fa-sun'],
                    ['title' => 'Epson 3LCD True Color Technology', 'sub' => '(Equal white and color brightness, no rainbow effect)', 'icon' => 'fa-solid fa-palette'],
                    ['title' => 'Scalable Display up to 300 Inches', 'sub' => '(Ensures every student in large hall sees clearly)', 'icon' => 'fa-solid fa-expand'],
                    ['title' => 'Ultra Long 12,000-Hour Lamp Life', 'sub' => '(Equates to up to 18 years of classroom lessons)', 'icon' => 'fa-solid fa-clock'],
                    ['title' => 'Automatic Keystone Image Alignment', 'sub' => '(Corrects crooked screen angles in seconds)', 'icon' => 'fa-solid fa-crop-simple'],
                    ['title' => 'HDMI, VGA and USB Connectivity', 'sub' => '(Instant plug-and-play with laptops, streaming sticks & PCs)', 'icon' => 'fa-solid fa-bolt'],
                ],
                'highlights' => [
                    ['title' => 'Bright Daylight Projection', 'img' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Vivid 3LCD Color Tech', 'img' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Up to 300" Mega Display', 'img' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Long 12,000 Hr Lamp', 'img' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Easy Keystone Alignment', 'img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'HDMI Instant Plug & Play', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Polar White', 'hex' => '#f8fafc'],
                ],
                'bundles' => [
                    ['title' => 'Epson EB-E01 Projector', 'price' => 39999, 'thumb' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=200&auto=format&fit=crop&q=80'],
                    ['title' => '100" Wall/Ceiling Screen', 'price' => 2499, 'thumb' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Ceiling Mount Universal Kit', 'price' => 899, 'thumb' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'chair' => [
                'match' => ['chair', 'office-chair-ergonomic', 'furniture'],
                'title' => 'Ergonomic High-Back Office & Study Chair with Adjustable Lumbar Support & Recline Lock',
                'category' => 'Furniture',
                'brand' => 'Digital Class',
                'brandLogo' => 'dc',
                'series' => 'ErgoComfort Max',
                'productCode' => 'DC-CHR-ERGO',
                'price' => 6499,
                'mrp' => 8999,
                'discount' => 28,
                'description' => 'Engineered for healthy spinal posture during long studying and working sessions. Features breathable high-density mesh, adjustable lumbar support, 135° recline with tilt lock, and class-4 gas lift.',
                'thumbnail' => 'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1505797149-43b0069ec26b?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => 'Breathable Mesh Back', 'icon' => 'fa-solid fa-wind', 'sub' => 'High-Density Cool Airflow'],
                    ['label' => 'Adjustable Lumbar Support', 'icon' => 'fa-solid fa-person-walking', 'sub' => 'Spine Contoured'],
                    ['label' => '135° Recline with Lock', 'icon' => 'fa-solid fa-bed', 'sub' => 'Rest & Work Modes'],
                    ['label' => 'Class-4 Hydraulic Lift', 'icon' => 'fa-solid fa-arrow-up-from-bracket', 'sub' => 'SGS Certified Piston'],
                    ['label' => '120 kg Load Capacity', 'icon' => 'fa-solid fa-weight-hanging', 'sub' => 'Heavy-Duty Steel Base'],
                    ['label' => '360° Smooth Casters', 'icon' => 'fa-solid fa-arrows-spin', 'sub' => 'Floor-Safe Nylon Wheels'],
                ],
                'features' => [
                    ['title' => 'S-Curve Ergonomic Spine Support', 'sub' => '(Aligns natural spine curvature to relieve back fatigue)', 'icon' => 'fa-solid fa-person'],
                    ['title' => 'Breathable High-Elastic Mesh', 'sub' => '(Allows continuous air circulation for sweat-free comfort)', 'icon' => 'fa-solid fa-wind'],
                    ['title' => '135° Synchronized Recline & Tilt Lock', 'sub' => '(Easily recline to take relaxing study breaks)', 'icon' => 'fa-solid fa-bed'],
                    ['title' => 'High-Density Molded Foam Seat', 'sub' => '(Waterfall cushion edge promotes healthy leg blood circulation)', 'icon' => 'fa-solid fa-chair'],
                    ['title' => 'Heavy-Duty BIFMA Certified Gas Lift', 'sub' => '(Effortless height adjustments supporting up to 120kg)', 'icon' => 'fa-solid fa-shield'],
                    ['title' => 'Quiet 360-Degree Swivel Casters', 'sub' => '(Smooth movement without scratching hardwood or tiles)', 'icon' => 'fa-solid fa-arrows-spin'],
                ],
                'highlights' => [
                    ['title' => 'All-Day Spinal Posture Support', 'img' => 'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Cool Breathable Mesh Fabric', 'img' => 'https://images.unsplash.com/photo-1505797149-43b0069ec26b?w=400&auto=format&fit=crop&q=80'],
                    ['title' => '135° Relaxing Tilt Recline', 'img' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Heavy Duty 120kg Capacity', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Smooth Silent Swivel Casters', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Simple 15-Minute DIY Setup', 'img' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Jet Black', 'hex' => '#0f172a'],
                    ['name' => 'Slate Grey', 'hex' => '#64748b'],
                ],
                'bundles' => [
                    ['title' => 'Ergonomic Mesh Chair', 'price' => 6499, 'thumb' => 'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Memory Foam Footrest Cushion', 'price' => 699, 'thumb' => 'https://images.unsplash.com/photo-1505797149-43b0069ec26b?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Under-Desk Floor Mat', 'price' => 499, 'thumb' => 'https://images.unsplash.com/photo-1580481077195-c22f03f7495b?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'router' => [
                'match' => ['router', 'wifi-router-tp-link-dual-band', 'tp-link', 'networking', 'wifi'],
                'title' => 'TP-Link Archer C6 AC1200 Dual Band Gigabit Wi-Fi Router (867 Mbps + 300 Mbps, 4 Antennas)',
                'category' => 'Networking',
                'brand' => 'TP-Link',
                'brandLogo' => 'TP',
                'series' => 'Archer C6 Gigabit',
                'productCode' => 'TPL-RTR-AC1200',
                'price' => 2199,
                'mrp' => 3499,
                'discount' => 37,
                'description' => 'Lightning-fast AC1200 dual-band Wi-Fi delivering 867 Mbps on 5GHz and 300 Mbps on 2.4GHz. 4 high-gain omni antennas with Beamforming ensure whole-home coverage and lag-free online education.',
                'thumbnail' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => 'AC1200 Dual Band', 'icon' => 'fa-solid fa-wifi', 'sub' => '867 Mbps + 300 Mbps'],
                    ['label' => '4 External Omni Antennas', 'icon' => 'fa-solid fa-tower-broadcast', 'sub' => 'High-Gain 5dBi'],
                    ['label' => 'Full Gigabit Ethernet', 'icon' => 'fa-solid fa-network-wired', 'sub' => '10x Faster LAN Ports'],
                    ['label' => 'Beamforming Tech', 'icon' => 'fa-solid fa-bullseye', 'sub' => 'Targeted Signal Focus'],
                    ['label' => 'MU-MIMO 2x2', 'icon' => 'fa-solid fa-users', 'sub' => 'Multi-Device Streaming'],
                    ['label' => 'WPA3 Advanced Security', 'icon' => 'fa-solid fa-shield-halved', 'sub' => 'Latest Encryption'],
                ],
                'features' => [
                    ['title' => 'Lag-Free AC1200 Dual-Band Speeds', 'sub' => '(867 Mbps on 5GHz for streaming, 300 Mbps for web)', 'icon' => 'fa-solid fa-bolt'],
                    ['title' => '4 High-Gain Omni Antennas', 'sub' => '(Blankets bedrooms, study areas and offices with signal)', 'icon' => 'fa-solid fa-tower-broadcast'],
                    ['title' => 'Beamforming Signal Focusing', 'sub' => '(Concentrates wireless signals directly to your laptop/phone)', 'icon' => 'fa-solid fa-bullseye'],
                    ['title' => 'MU-MIMO Simultaneous Transmission', 'sub' => '(Connect multiple phones, tablets and TVs without slowdown)', 'icon' => 'fa-solid fa-users'],
                    ['title' => 'Full Gigabit WAN/LAN Ports', 'sub' => '(Harness maximum internet speeds from your fiber connection)', 'icon' => 'fa-solid fa-network-wired'],
                    ['title' => 'Easy Setup with TP-Link Tether App', 'sub' => '(Set up network in minutes and control parental settings)', 'icon' => 'fa-solid fa-mobile-screen'],
                ],
                'highlights' => [
                    ['title' => 'Buffer-Free Video Lectures', 'img' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'High Speed 1200 Mbps Wi-Fi', 'img' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Extensive Room-to-Room Range', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Multiple Device MU-MIMO', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Easy Smartphone App Control', 'img' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Parental Controls & Guest Wi-Fi', 'img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Sleek Black', 'hex' => '#0f172a'],
                ],
                'bundles' => [
                    ['title' => 'TP-Link AC1200 Router', 'price' => 2199, 'thumb' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'CAT6 Gigabit Cable (10m)', 'price' => 249, 'thumb' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Wi-Fi Range Extender N300', 'price' => 1199, 'thumb' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'storage' => [
                'match' => ['storage', '32gb-pen-drive', 'pen-drive', 'sandisk', 'usb'],
                'title' => 'SanDisk Ultra Flair 32GB USB 3.0 Pen Drive (High-Speed up to 150MB/s, Sleek Metal Casing)',
                'category' => 'Storage Devices',
                'brand' => 'SanDisk',
                'brandLogo' => 'SanDisk',
                'series' => 'Ultra Flair USB 3.0',
                'productCode' => 'SNDK-32GB-U3',
                'price' => 599,
                'mrp' => 999,
                'discount' => 40,
                'description' => 'Transfer files up to 15x faster than standard USB 2.0 drives with read speeds up to 150MB/s. Encased in a durable brushed aluminum casing with built-in password protection software.',
                'thumbnail' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => '32GB Capacity', 'icon' => 'fa-solid fa-hard-drive', 'sub' => 'High Storage Space'],
                    ['label' => 'USB 3.0 High-Speed', 'icon' => 'fa-solid fa-gauge-high', 'sub' => 'Up to 150 MB/s Read'],
                    ['label' => 'Sleek Metal Casing', 'icon' => 'fa-solid fa-shield', 'sub' => 'Durable Brushed Metal'],
                    ['label' => 'Password Protection', 'icon' => 'fa-solid fa-lock', 'sub' => '128-Bit AES Security'],
                    ['label' => 'Keyring Loop', 'icon' => 'fa-solid fa-key', 'sub' => 'Easy Clip On Bags'],
                    ['label' => '5-Year Warranty', 'icon' => 'fa-solid fa-award', 'sub' => 'SanDisk Guarantee'],
                ],
                'features' => [
                    ['title' => 'High-Speed USB 3.0 Performance', 'sub' => '(Transfer a full-length movie in under 30 seconds)', 'icon' => 'fa-solid fa-bolt'],
                    ['title' => 'Sleek and Durable Metal Casing', 'sub' => '(Protects your important study notes from accidental knocks)', 'icon' => 'fa-solid fa-shield'],
                    ['title' => 'SanDisk SecureAccess 128-Bit Security', 'sub' => '(Create a private password-protected folder on the drive)', 'icon' => 'fa-solid fa-lock'],
                    ['title' => 'Universal USB 2.0 Backward Compatible', 'sub' => '(Works on smart TVs, older laptops, desktop PCs and projectors)', 'icon' => 'fa-solid fa-usb'],
                    ['title' => 'Convenient Keyring Loop Design', 'sub' => '(Keep your lectures and homework safely attached to your keys)', 'icon' => 'fa-solid fa-key'],
                    ['title' => 'SanDisk 5-Year Limited Warranty', 'sub' => '(Guaranteed reliability from the world leader in flash storage)', 'icon' => 'fa-solid fa-award'],
                ],
                'highlights' => [
                    ['title' => 'Blazing 150MB/s Read Speed', 'img' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Rugged Aluminum Metal Finish', 'img' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Secure Password Vault', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Keyring Travel Portability', 'img' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Instant Plug & Play', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80'],
                    ['title' => '5-Year Manufacturer Warranty', 'img' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Brushed Silver', 'hex' => '#cbd5e1'],
                ],
                'bundles' => [
                    ['title' => '32GB USB 3.0 Pen Drive', 'price' => 599, 'thumb' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'USB-A to Type-C OTG Adapter', 'price' => 149, 'thumb' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Pen Drive Protective Lanyard', 'price' => 99, 'thumb' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=200&auto=format&fit=crop&q=80'],
                ],
            ],

            'laptop' => [
                'match' => ['hp-15s', 'laptop', 'dell', 'lenovo', 'asus'],
                'title' => 'HP 15s Laptop (Intel Core i5 13th Gen, 16GB RAM, 512GB SSD, 15.6" FHD, Windows 11)',
                'category' => 'Laptops & Computers',
                'brand' => 'HP',
                'brandLogo' => 'hp',
                'series' => '15s',
                'productCode' => 'HP15S-i5-512-SL',
                'price' => 42999,
                'mrp' => 63999,
                'discount' => 33,
                'description' => 'Powerful and stylish laptop for students, professionals and business users. Perfect for online classes, office work, content creation and everyday use.',
                'thumbnail' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&auto=format&fit=crop&q=80',
                ],
                'specs' => [
                    ['label' => 'Intel Core i5 13th Gen', 'icon' => 'fa-solid fa-microchip', 'sub' => 'Processor'],
                    ['label' => '16GB RAM', 'icon' => 'fa-solid fa-memory', 'sub' => 'RAM Memory'],
                    ['label' => '512GB SSD', 'icon' => 'fa-solid fa-hard-drive', 'sub' => 'Storage'],
                    ['label' => '15.6" FHD Display', 'icon' => 'fa-solid fa-desktop', 'sub' => 'Display'],
                    ['label' => 'Windows 11 Home', 'icon' => 'fa-brands fa-windows', 'sub' => 'Operating System'],
                    ['label' => '1.69 kg Lightweight', 'icon' => 'fa-solid fa-weight-hanging', 'sub' => 'Weight'],
                ],
                'features' => [
                    ['title' => 'Intel Core i5 13th Gen Processor', 'sub' => '(10 Cores, 12 Threads)', 'icon' => 'fa-solid fa-microchip'],
                    ['title' => '16GB DDR4 RAM', 'sub' => '(Expandable up to 32GB)', 'icon' => 'fa-solid fa-memory'],
                    ['title' => '512GB SSD Storage', 'sub' => '(Faster Performance)', 'icon' => 'fa-solid fa-database'],
                    ['title' => '15.6-inch Full HD Display', 'sub' => '(1920 x 1080)', 'icon' => 'fa-solid fa-tv'],
                    ['title' => 'Windows 11 Home', 'sub' => '(Pre-installed)', 'icon' => 'fa-brands fa-windows'],
                    ['title' => 'Lightweight & Portable', 'sub' => '(1.69 kg)', 'icon' => 'fa-solid fa-feather-pointed'],
                ],
                'highlights' => [
                    ['title' => 'Perfect for Students', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Great for Office Work', 'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Ideal for Online Classes', 'img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Fast & Reliable Performance', 'img' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'Slim & Stylish Design', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop&q=80'],
                    ['title' => 'All-Day Productivity', 'img' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=400&auto=format&fit=crop&q=80'],
                ],
                'colors' => [
                    ['name' => 'Natural Silver', 'hex' => '#cbd5e1'],
                    ['name' => 'Navy Blue', 'hex' => '#1e3a8a'],
                    ['name' => 'Warm Gold', 'hex' => '#fef08a'],
                ],
                'bundles' => [
                    ['title' => 'HP 15s Laptop', 'price' => 42999, 'thumb' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Logitech Wireless Mouse', 'price' => 499, 'thumb' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Laptop Backpack', 'price' => 1299, 'thumb' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=200&auto=format&fit=crop&q=80'],
                    ['title' => 'Laptop Cooling Pad', 'price' => 899, 'thumb' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&auto=format&fit=crop&q=80'],
                ],
            ],
        ];

        // Find matching definition
        $def = null;
        $titleLower = strtolower($product->title ?? '');

        foreach ($registry as $key => $item) {
            foreach ($item['match'] as $m) {
                if (str_contains($cleanSlug, $m) || str_contains($titleLower, $m)) {
                    $def = $item;
                    break 2;
                }
            }
        }

        // If no curated match, fallback to default laptop definition
        if (!$def) {
            $def = $registry['laptop'];
        }

        // Create or merge product model
        if (!$product) {
            $product = new \App\Models\Product([
                'title'            => $def['title'],
                'slug'             => $slug,
                'category'         => $def['category'],
                'price'            => $def['price'],
                'mrp'              => $def['mrp'],
                'stock_quantity'   => 45,
                'shipping_details' => $def['specs'][0]['label'] ?? '',
                'description'      => $def['description'],
                'thumbnail'        => $def['thumbnail'],
                'status'           => 'approved',
            ]);
        }

        // Determine brand and logo
        $brand = $def['brand'];
        $brandLogo = $def['brandLogo'];
        if ($product && !empty($product->title)) {
            $t = $product->title;
            if (stripos($t, 'HP') !== false) { $brand = 'HP'; $brandLogo = 'hp'; }
            elseif (stripos($t, 'Logitech') !== false) { $brand = 'Logitech'; $brandLogo = 'logi'; }
            elseif (stripos($t, 'Canon') !== false) { $brand = 'Canon'; $brandLogo = 'Canon'; }
            elseif (stripos($t, 'Epson') !== false) { $brand = 'Epson'; $brandLogo = 'Epson'; }
            elseif (stripos($t, 'Lenovo') !== false) { $brand = 'Lenovo'; $brandLogo = 'Lenovo'; }
            elseif (stripos($t, 'Tally') !== false) { $brand = 'Tally'; $brandLogo = 'Tally'; }
            elseif (stripos($t, 'TP-Link') !== false) { $brand = 'TP-Link'; $brandLogo = 'TP'; }
            elseif (stripos($t, 'SanDisk') !== false) { $brand = 'SanDisk'; $brandLogo = 'SanDisk'; }
            elseif (stripos($t, 'Dell') !== false) { $brand = 'Dell'; $brandLogo = 'Dell'; }
            elseif (stripos($t, 'ASUS') !== false) { $brand = 'ASUS'; $brandLogo = 'ASUS'; }
        }

        $series = $def['series'];
        $productCode = $def['productCode'];

        // Gallery images: use product thumbnail first
        $galleryImages = $def['gallery'];
        if (!empty($product->display_thumbnail)) {
            $galleryImages[0] = $product->display_thumbnail;
        }

        // Universal Offers & Discounts
        $offers = [
            ['type' => 'Bank Offer', 'desc' => 'Get up to ₹3,000 instant discount on HDFC Bank Cards', 'icon' => 'fa-solid fa-credit-card', 'color' => '#dc2626'],
            ['type' => 'No Cost EMI', 'desc' => 'Starting from ₹' . number_format(round($product->price / 12)) . '/month on major credit cards', 'icon' => 'fa-solid fa-receipt', 'color' => '#d97706'],
            ['type' => 'Exchange Offer', 'desc' => 'Get extra discount on exchange of your old device/books', 'icon' => 'fa-solid fa-rotate', 'color' => '#059669'],
            ['type' => 'GST Invoice', 'desc' => 'Available for businesses & institutes with 18% tax credit', 'icon' => 'fa-solid fa-file-invoice-dollar', 'color' => '#2563eb'],
            ['type' => 'Partner Offer', 'desc' => 'Exclusive accessory bundle vouchers included', 'icon' => 'fa-solid fa-gift', 'color' => '#e11d48'],
        ];

        // Bundle items
        $bundleItems = [];
        $bundleList = $def['bundles'] ?? [];
        foreach ($bundleList as $bIdx => $b) {
            $isMain = ($bIdx === 0);
            $bundleItems[] = [
                'id' => $bIdx + 1,
                'title' => $isMain ? $product->title : $b['title'],
                'price' => $isMain ? (float)$product->price : (float)$b['price'],
                'thumb' => $isMain ? $product->display_thumbnail : $b['thumb'],
                'checked' => true,
                'is_main' => $isMain,
            ];
        }

        // Similar products
        $similarProducts = collect();
        try {
            if (Schema::hasTable('products')) {
                $similarProducts = \App\Models\Product::where('id', '!=', $product->id ?? 0)
                    ->where('category', $product->category)
                    ->where('status', 'approved')
                    ->take(3)
                    ->get();

                if ($similarProducts->isEmpty()) {
                    $similarProducts = \App\Models\Product::where('id', '!=', $product->id ?? 0)
                        ->where('status', 'approved')
                        ->take(3)
                        ->get();
                }
            }
        } catch (\Throwable $e) {
            $similarProducts = collect();
        }

        if ($similarProducts->isEmpty()) {
            if ($def['category'] === 'Accessories') {
                $similarProducts = [
                    ['title' => 'HP Wireless Optical Mouse', 'price' => 399, 'rating' => 4.4, 'reviews' => '650', 'thumb' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'Dell Optical Mouse MS116', 'price' => 349, 'rating' => 4.5, 'reviews' => '1.1K', 'thumb' => 'https://images.unsplash.com/photo-1598550476439-6847785fcea6?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'Zebronics Zeb-Comfort Wired', 'price' => 299, 'rating' => 4.3, 'reviews' => '420', 'thumb' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=300&auto=format&fit=crop&q=80'],
                ];
            } elseif ($def['category'] === 'Printers & Scanners') {
                $similarProducts = [
                    ['title' => 'Epson EcoTank L3210 All-in-One', 'price' => 11999, 'rating' => 4.6, 'reviews' => '1.4K', 'thumb' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'HP Smart Tank 580 Wi-Fi', 'price' => 13499, 'rating' => 4.5, 'reviews' => '890', 'thumb' => 'https://images.unsplash.com/photo-1589330694653-dad6d3240e2b?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'Brother DCP-T420W Color Inkjet', 'price' => 12999, 'rating' => 4.4, 'reviews' => '510', 'thumb' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=300&auto=format&fit=crop&q=80'],
                ];
            } elseif ($def['category'] === 'Projectors & Displays') {
                $similarProducts = [
                    ['title' => 'BenQ MX560 XGA Classroom Projector', 'price' => 37999, 'rating' => 4.5, 'reviews' => '430', 'thumb' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'ViewSonic PA503W 3800 Lumens', 'price' => 34999, 'rating' => 4.4, 'reviews' => '320', 'thumb' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'LG Ultra-Short Throw Laser Projector', 'price' => 54999, 'rating' => 4.7, 'reviews' => '210', 'thumb' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=300&auto=format&fit=crop&q=80'],
                ];
            } else {
                $similarProducts = [
                    ['title' => 'Lenovo IdeaPad Slim 3', 'price' => 39999, 'rating' => 4.5, 'reviews' => '980', 'thumb' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'Dell Inspiron 3520', 'price' => 45999, 'rating' => 4.6, 'reviews' => '1.2K', 'thumb' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=300&auto=format&fit=crop&q=80'],
                    ['title' => 'ASUS Vivobook 15', 'price' => 41999, 'rating' => 4.4, 'reviews' => '860', 'thumb' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=300&auto=format&fit=crop&q=80'],
                ];
            }
        }

        return [
            'product'         => $product,
            'brand'           => $brand,
            'brandLogo'       => $brandLogo,
            'series'          => $series,
            'productCode'     => $productCode,
            'galleryImages'   => $galleryImages,
            'specHighlights'  => $def['specs'],
            'keyFeatures'     => $def['features'],
            'highlights'      => $def['highlights'],
            'colorOptions'    => $def['colors'] ?? null,
            'offers'          => $offers,
            'bundleItems'     => $bundleItems,
            'similarProducts' => $similarProducts,
        ];
    }
}
