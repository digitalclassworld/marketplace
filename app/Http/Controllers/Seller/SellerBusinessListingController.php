<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerBusinessListingController extends Controller
{
    private function getSeller(): ?Seller
    {
        return Auth::user()->seller;
    }

    public function index(): View
    {
        $seller = $this->getSeller();
        $listings = $seller->businessListings()->latest()->paginate(10);

        return view('seller.listings.index', compact('seller', 'listings'));
    }

    public function create(): View
    {
        $seller = $this->getSeller();
        return view('seller.listings.create', compact('seller'));
    }

    public function store(Request $request): RedirectResponse
    {
        $seller = $this->getSeller();

        $validated = $request->validate([
            'business_name'    => ['required', 'string', 'max:255'],
            'category'         => ['required', 'string', 'max:100'],
            'listing_type'     => ['nullable', 'string', 'max:100'],
            'sub_category'     => ['nullable', 'string', 'max:100'],
            'established_year' => ['nullable', 'string', 'max:20'],
            'employees_count'  => ['nullable', 'string', 'max:50'],
            'tagline'          => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'features'         => ['nullable'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'whatsapp_number'  => ['nullable', 'string', 'max:20'],
            'email'            => ['nullable', 'email', 'max:100'],
            'website'          => ['nullable', 'url', 'max:255'],
            'address'          => ['nullable', 'string'],
            'city'             => ['nullable', 'string', 'max:100'],
            'state'            => ['nullable', 'string', 'max:100'],
            'pincode'          => ['nullable', 'string', 'max:10'],
            'map_location'     => ['nullable', 'string', 'max:255'],
            'logo'             => ['nullable', 'string', 'max:255'],
            'cover_image'      => ['nullable', 'string', 'max:255'],
            'video_url'        => ['nullable', 'string', 'max:255'],
            'plan_name'        => ['nullable', 'string', 'max:50'],
            'plan_price'       => ['nullable', 'numeric'],
            'add_ons'          => ['nullable'],
        ]);

        $features = is_array($request->features) ? $request->features : (is_string($request->features) ? json_decode($request->features, true) : null);
        $addOns = is_array($request->add_ons) ? $request->add_ons : (is_string($request->add_ons) ? json_decode($request->add_ons, true) : null);

        $seller->businessListings()->create([
            'business_name'    => $validated['business_name'],
            'slug'             => Str::slug($validated['business_name']) . '-' . Str::random(5),
            'category'         => $validated['category'],
            'listing_type'     => $validated['listing_type'] ?? 'Business Profile',
            'sub_category'     => $validated['sub_category'] ?? 'Computer Training Institute',
            'established_year' => $validated['established_year'] ?? '2015',
            'employees_count'  => $validated['employees_count'] ?? '5 - 10',
            'tagline'          => $validated['tagline'] ?? null,
            'description'      => $validated['description'] ?? null,
            'features'         => $features,
            'phone'            => $validated['phone'] ?? null,
            'whatsapp_number'  => $validated['whatsapp_number'] ?? null,
            'email'            => $validated['email'] ?? null,
            'website'          => $validated['website'] ?? null,
            'address'          => $validated['address'] ?? null,
            'city'             => $validated['city'] ?? null,
            'state'            => $validated['state'] ?? null,
            'pincode'          => $validated['pincode'] ?? null,
            'map_location'     => $validated['map_location'] ?? null,
            'logo'             => $validated['logo'] ?? null,
            'cover_image'      => $validated['cover_image'] ?? null,
            'video_url'        => $validated['video_url'] ?? null,
            'plan_name'        => $validated['plan_name'] ?? 'Premium Listing',
            'plan_price'       => $validated['plan_price'] ?? 1499.00,
            'add_ons'          => $addOns,
            'status'           => 'pending',
        ]);

        return redirect()->route('seller.listings.index')->with('success', 'Business Directory listing submitted successfully! It is now pending Super Admin review.');
    }
}

