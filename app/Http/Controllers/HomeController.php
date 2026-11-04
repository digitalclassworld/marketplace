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
}
