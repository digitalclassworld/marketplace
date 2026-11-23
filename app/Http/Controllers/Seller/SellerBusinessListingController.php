<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\DiscountCoupon;
use App\Models\Seller;
use App\Traits\HandlesSellerMediaUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerBusinessListingController extends Controller
{
    use HandlesSellerMediaUploads;

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
        $availableCoupons = DiscountCoupon::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now()->startOfDay());
            })
            ->latest('id')
            ->get();

        return view('seller.listings.create', compact('seller', 'availableCoupons'));
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
            'area'             => ['nullable', 'string', 'max:150'],
            'landmark'         => ['nullable', 'string', 'max:255'],
            'city'             => ['nullable', 'string', 'max:100'],
            'state'            => ['nullable', 'string', 'max:100'],
            'pincode'          => ['nullable', 'string', 'max:20'],
            'map_location'     => ['nullable', 'string', 'max:255'],
            'latitude'         => ['nullable', 'numeric'],
            'longitude'        => ['nullable', 'numeric'],
            'logo'             => ['nullable', 'string', 'max:255'],
            'cover_image'      => ['nullable', 'string', 'max:255'],
            'video_url'        => ['nullable', 'string', 'max:255'],
            'plan_name'        => ['nullable', 'string', 'max:50'],
            'plan_price'       => ['nullable', 'numeric'],
            'coupon_code'      => ['nullable', 'string', 'max:50'],
            'discount_amount'  => ['nullable', 'numeric'],
            'add_ons'          => ['nullable'],
        ]);

        $features = is_array($request->features) ? $request->features : (is_string($request->features) ? json_decode($request->features, true) : null);
        $addOns = is_array($request->add_ons) ? $request->add_ons : (is_string($request->add_ons) ? json_decode($request->add_ons, true) : []);
        $addOns = is_array($addOns) ? $addOns : [];

        $rawPrice = floatval($validated['plan_price'] ?? 1499.00);
        $couponCode = strtoupper(trim($request->input('coupon_code') ?: ($request->input('applied_coupon_code') ?: '')));
        $discountAmount = 0.00;

        if ($couponCode) {
            $coupon = DiscountCoupon::where('coupon_code', $couponCode)->first();
            if ($coupon && strtolower($coupon->status) === 'active') {
                $minOrder = floatval($coupon->min_order_amount ?? 0);
                if ($rawPrice >= $minOrder) {
                    if (strtolower($coupon->discount_type) === 'percentage') {
                        $discountAmount = round(($rawPrice * floatval($coupon->discount_value)) / 100, 2);
                    } else {
                        $discountAmount = min($rawPrice, floatval($coupon->discount_value));
                    }
                    $coupon->increment('used_count');
                }
            } else {
                $discountAmount = floatval($request->input('discount_amount', 0));
            }
        }

        $finalPrice = max(0, round($rawPrice - $discountAmount, 2));

        if ($couponCode && $discountAmount > 0) {
            $addOns['coupon_details'] = [
                'code'            => $couponCode,
                'discount_amount' => $discountAmount,
                'original_price'  => $rawPrice,
                'final_price'     => $finalPrice,
            ];
        }

        $media = $this->processMediaUploads($request, 'listing');

        $planName = $validated['plan_name'] ?? 'Premium Listing';
        $listingType = $validated['listing_type'] ?? 'Business Profile';

        // Map listing_type and badges based on paid plan selected
        if (str_contains(strtolower($planName), 'featured') || $rawPrice >= 2999) {
            $listingType = 'Featured';
        } elseif (str_contains(strtolower($planName), 'premium') || $rawPrice >= 1499) {
            $listingType = 'Premium';
        }

        if (!is_array($features)) {
            $features = [];
        }
        if ($listingType === 'Featured') {
            $features['badge'] = 'Featured';
            $features['high_support'] = true;
            $features['suggestion_first'] = true;
        } elseif ($listingType === 'Premium') {
            $features['badge'] = 'Premium';
            $features['high_support'] = true;
            $features['suggestion_first'] = true;
        }

        $seller->businessListings()->create([
            'business_name'    => $validated['business_name'],
            'slug'             => Str::slug($validated['business_name']) . '-' . Str::random(5),
            'category'         => $validated['category'],
            'listing_type'     => $listingType,
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
            'area'             => $validated['area'] ?? null,
            'landmark'         => $validated['landmark'] ?? null,
            'city'             => $validated['city'] ?? null,
            'state'            => $validated['state'] ?? null,
            'pincode'          => $validated['pincode'] ?? null,
            'map_location'     => $validated['map_location'] ?? null,
            'latitude'         => $request->input('latitude') ?: (BusinessListing::$cityCoordinates[strtolower(trim($validated['city'] ?? ''))]['lat'] ?? null),
            'longitude'        => $request->input('longitude') ?: (BusinessListing::$cityCoordinates[strtolower(trim($validated['city'] ?? ''))]['lng'] ?? null),
            'logo'             => $media['logo'] ?: ($media['thumbnail'] ?: ($validated['logo'] ?? null)),
            'cover_image'      => $media['cover_image'] ?: ($validated['cover_image'] ?? null),
            'video_url'        => $media['video_url'] ?: ($validated['video_url'] ?? null),
            'gallery'          => $media['gallery'],
            'plan_name'        => $planName,
            'plan_price'       => $finalPrice,
            'add_ons'          => $addOns,
            'status'           => 'pending',
        ]);

        try {
            $sellerDetailData = [
                'business_name'   => $validated['business_name'],
                'business_phone'  => $validated['phone'] ?? $seller->businessDetail?->business_phone,
                'business_email'  => $validated['email'] ?? $seller->businessDetail?->business_email,
                'website'         => $validated['website'] ?? $seller->businessDetail?->website,
                'address'         => $validated['address'] ?? $seller->businessDetail?->address,
                'city'            => $validated['city'] ?? $seller->businessDetail?->city,
                'state'           => $validated['state'] ?? $seller->businessDetail?->state,
                'pincode'         => $validated['pincode'] ?? $seller->businessDetail?->pincode,
            ];
            if (\Illuminate\Support\Facades\Schema::hasColumn('seller_business_details', 'area')) {
                $sellerDetailData['area'] = $validated['area'] ?? $seller->businessDetail?->area;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('seller_business_details', 'landmark')) {
                $sellerDetailData['landmark'] = $validated['landmark'] ?? $seller->businessDetail?->landmark;
            }
            $seller->businessDetail()->updateOrCreate(['seller_id' => $seller->id], $sellerDetailData);
        } catch (\Throwable $e) {
            // Ignore if business detail table doesn't match
        }

        return redirect()->route('seller.listings.index')->with('success', 'Business Directory listing submitted successfully! It has been submitted for admin approval and will appear on the marketplace once approved.');
    }
}

