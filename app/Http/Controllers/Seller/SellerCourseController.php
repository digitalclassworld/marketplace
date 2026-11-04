<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerCourseController extends Controller
{
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
        ]);

        $isFree = $request->boolean('is_free');
        $price = $isFree ? 0.00 : (float) ($validated['price'] ?? 0.00);

        $course = $seller->courses()->create([
            'title'                => $validated['title'],
            'slug'                 => Str::slug($validated['title']) . '-' . Str::random(5),
            'category'             => $validated['category'],
            'language'             => $validated['language'],
            'level'                => $validated['level'],
            'short_description'    => $validated['short_description'] ?? null,
            'description'          => $validated['description'] ?? null,
            'thumbnail'            => $validated['thumbnail'] ?? null,
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

        return redirect()->route('seller.courses.index')->with('success', 'Course submitted successfully! It is now pending Super Admin review.');
    }
}

