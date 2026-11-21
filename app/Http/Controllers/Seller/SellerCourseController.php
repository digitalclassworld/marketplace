<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Seller;
use App\Traits\HandlesSellerMediaUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerCourseController extends Controller
{
    use HandlesSellerMediaUploads;

    private function getSeller(): ?Seller
    {
        return Auth::user()->seller;
    }

    public function index(): View
    {
        $seller = $this->getSeller();
        $courses = $seller->courses()->withCount('contents')->latest()->paginate(10);

        return view('seller.courses.index', compact('seller', 'courses'));
    }

    public function create(): View
    {
        $seller = $this->getSeller();
        return view('seller.courses.create', compact('seller'));
    }

    public function store(Request $request): RedirectResponse
    {
        $seller = $this->getSeller();

        $validated = $request->validate([
            'title'                => ['required', 'string', 'max:255'],
            'category'             => ['required', 'string', 'max:100'],
            'language'             => ['required', 'string', 'max:50'],
            'level'                => ['required', 'string', 'max:50'],
            'short_description'    => ['nullable', 'string', 'max:500'],
            'description'          => ['nullable', 'string'],
            'thumbnail'            => ['nullable', 'string', 'max:255'],
            'is_free'              => ['nullable', 'boolean'],
            'price'                => ['nullable', 'numeric', 'min:0'],
            'discount_price'       => ['nullable', 'numeric', 'min:0'],
            'access_type'          => ['required', 'string', 'max:50'],
            'certificate_included' => ['nullable', 'boolean'],
            'qa_enabled'           => ['nullable', 'boolean'],
            'sections'             => ['nullable', 'array'],
            // Contact & Campus Location fields
            'business_name'        => ['nullable', 'string', 'max:255'],
            'phone'                => ['nullable', 'string', 'max:30'],
            'whatsapp_number'      => ['nullable', 'string', 'max:30'],
            'email'                => ['nullable', 'string', 'max:100'],
            'website'              => ['nullable', 'string', 'max:255'],
            'address'              => ['nullable', 'string', 'max:500'],
            'area'                 => ['nullable', 'string', 'max:150'],
            'landmark'             => ['nullable', 'string', 'max:255'],
            'city'                 => ['nullable', 'string', 'max:100'],
            'state'                => ['nullable', 'string', 'max:100'],
            'pincode'              => ['nullable', 'string', 'max:20'],
        ]);

        $isFree = $request->boolean('is_free');
        $price = $isFree ? 0.00 : (float) ($validated['price'] ?? 0.00);

        // Process media uploads (badge/thumbnail, cover banner, promo video, gallery)
        $media = $this->processMediaUploads($request, 'course');

        $course = $seller->courses()->create([
            'title'                => $validated['title'],
            'slug'                 => Str::slug($validated['title']) . '-' . Str::random(5),
            'category'             => $validated['category'],
            'language'             => $validated['language'],
            'level'                => $validated['level'],
            'short_description'    => $validated['short_description'] ?? null,
            'description'          => $validated['description'] ?? null,
            'thumbnail'            => $media['thumbnail'],
            'cover_image'          => $media['cover_image'],
            'video_url'            => $media['video_url'],
            'gallery'              => $media['gallery'],
            'is_free'              => $isFree,
            'price'                => $price,
            'discount_price'       => $validated['discount_price'] ?? null,
            'access_type'          => $validated['access_type'],
            'certificate_included' => $request->boolean('certificate_included', true),
            'qa_enabled'           => $request->boolean('qa_enabled', true),
            'status'               => 'pending',
        ]);

        // Save sections / lectures if provided
        if (!empty($validated['sections']) && is_array($validated['sections'])) {
            $order = 1;
            foreach ($validated['sections'] as $item) {
                if (!empty($item['lecture_title'])) {
                    CourseContent::create([
                        'course_id'     => $course->id,
                        'section_title' => $item['section_title'] ?? '1. Introduction',
                        'lecture_title' => $item['lecture_title'],
                        'duration'      => $item['duration'] ?? '10:00',
                        'video_url'     => $item['video_url'] ?? null,
                        'sort_order'    => $order++,
                    ]);
                }
            }
        }

        // Sync Instructor Campus Location to Seller's Business Profile & Directory Listing
        try {
            if ($seller && ($request->filled('business_name') || $request->filled('address') || $request->filled('city') || $request->filled('phone') || $request->filled('area'))) {
                $bName = trim($request->input('business_name')) ?: ($seller->businessDetail?->business_name ?: ($seller->user?->name . ' Academy'));

                $detailData = [
                    'business_name'   => $bName,
                    'business_phone'  => $request->input('phone', $seller->businessDetail?->business_phone),
                    'business_email'  => $request->input('email', $seller->businessDetail?->business_email),
                    'website'         => $request->input('website', $seller->businessDetail?->website),
                    'address'         => $request->input('address', $seller->businessDetail?->address),
                    'city'            => $request->input('city', $seller->businessDetail?->city),
                    'state'           => $request->input('state', $seller->businessDetail?->state),
                    'pincode'         => $request->input('pincode', $seller->businessDetail?->pincode),
                ];
                if (\Illuminate\Support\Facades\Schema::hasColumn('seller_business_details', 'area')) {
                    $detailData['area'] = $request->input('area', $seller->businessDetail?->area);
                }
                if (\Illuminate\Support\Facades\Schema::hasColumn('seller_business_details', 'landmark')) {
                    $detailData['landmark'] = $request->input('landmark', $seller->businessDetail?->landmark);
                }

                $seller->businessDetail()->updateOrCreate(
                    ['seller_id' => $seller->id],
                    $detailData
                );

                // Update or create active business listing for this seller
                $listing = $seller->businessListings()->first();
                $listingData = [
                    'business_name'   => $bName,
                    'phone'           => $request->input('phone', $listing?->phone),
                    'whatsapp_number' => $request->input('whatsapp_number', $listing?->whatsapp_number),
                    'email'           => $request->input('email', $listing?->email),
                    'website'         => $request->input('website', $listing?->website),
                    'address'         => $request->input('address', $listing?->address),
                    'city'            => $request->input('city', $listing?->city),
                    'state'           => $request->input('state', $listing?->state),
                    'pincode'         => $request->input('pincode', $listing?->pincode),
                    'status'          => 'approved',
                ];

                if (\Illuminate\Support\Facades\Schema::hasColumn('business_listings', 'area')) {
                    $listingData['area'] = $request->input('area', $listing?->area);
                }
                if (\Illuminate\Support\Facades\Schema::hasColumn('business_listings', 'landmark')) {
                    $listingData['landmark'] = $request->input('landmark', $listing?->landmark);
                }

                if (\Illuminate\Support\Facades\Schema::hasColumn('business_listings', 'latitude')) {
                    $listingData['latitude'] = $request->input('latitude', $listing?->latitude);
                }
                if (\Illuminate\Support\Facades\Schema::hasColumn('business_listings', 'longitude')) {
                    $listingData['longitude'] = $request->input('longitude', $listing?->longitude);
                }

                if ($listing) {
                    $listing->update($listingData);
                } else {
                    $listingData['slug'] = Str::slug($bName) . '-' . Str::random(5);
                    $listingData['category'] = 'Educational Institute';
                    $listingData['listing_type'] = 'Coaching & Academy';
                    $listingData['tagline'] = 'Certified coaching & courses institute';
                    $listingData['description'] = 'Offering practical offline and online education courses.';
                    $seller->businessListings()->create($listingData);
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Course business location sync skipped: ' . $e->getMessage());
        }

        return redirect()->route('seller.courses.index')->with('success', 'Course submitted successfully! It has been submitted for admin approval and will appear on the marketplace once approved.');
    }
}

