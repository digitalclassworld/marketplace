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

        // Curated courses matching the screenshot
        $courses = [
            [
                'title' => 'Digital Marketing Complete Course',
                'duration' => '3 Months',
                'mode' => 'Offline / Online',
                'price' => 12999,
                'original_price' => 18999,
                'discount' => '31% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Tally Prime with GST',
                'duration' => '2 Months',
                'mode' => 'Offline',
                'price' => 4999,
                'original_price' => 6999,
                'discount' => '29% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'AI Tools & ChatGPT',
                'duration' => '1.5 Months',
                'mode' => 'Offline / Online',
                'price' => 5999,
                'original_price' => 8999,
                'discount' => '33% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'CCC (Basic Computer)',
                'duration' => '1 Month',
                'mode' => 'Offline',
                'price' => 2999,
                'original_price' => 4500,
                'discount' => '33% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Web Development',
                'duration' => '3 Months',
                'mode' => 'Offline / Online',
                'price' => 14999,
                'original_price' => 22999,
                'discount' => '33% OFF',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        // Curated services matching the screenshot
        $services = [
            ['title' => 'Resume Making',              'price' => '₹499',   'icon' => 'fa-solid fa-file-lines',   'color' => '#ec4899', 'bg' => '#fdf2f8'],
            ['title' => 'Graphics Design',            'price' => '₹999',   'icon' => 'fa-solid fa-palette',      'color' => '#0284c7', 'bg' => '#f0f9ff'],
            ['title' => 'Website Development',        'price' => '₹4,999', 'icon' => 'fa-solid fa-code',         'color' => '#2563eb', 'bg' => '#eff6ff'],
            ['title' => 'Social Media Management',    'price' => '₹2,499', 'icon' => 'fa-solid fa-share-nodes',  'color' => '#8b5cf6', 'bg' => '#f5f3ff'],
            ['title' => 'Career Guidance & Counseling','price' => '₹499',   'icon' => 'fa-solid fa-user-graduate','color' => '#0d9488', 'bg' => '#f0fdfa'],
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
                'name' => 'Nikol Branch (Head Office)',
                'address' => '201, Shreeji Complex, Nikol Main Road, Ahmedabad - 382350, Gujarat',
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
            'seller'   => $seller,
            'business' => $business,
            'courses'  => $courses,
            'services' => $services,
            'reviews'  => $reviews,
            'branches' => $branches,
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
}
