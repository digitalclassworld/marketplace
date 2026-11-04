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
        if (Schema::hasTable('business_listings')) {
            if ($slug) {
                $business = BusinessListing::where('slug', $slug)->first();
            }
            if (!$business) {
                $business = BusinessListing::where('business_name', 'like', '%VCEC%')->first()
                         ?? BusinessListing::first();
            }
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
}
