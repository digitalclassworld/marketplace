<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerServiceController extends Controller
{
    private function getSeller(): ?Seller
    {
        return Auth::user()->seller;
    }

    public function index(): View
    {
        $seller = $this->getSeller();
        $services = $seller->services()->latest()->paginate(10);

        return view('seller.services.index', compact('seller', 'services'));
    }

    public function create(): View
    {
        $seller = $this->getSeller();
        return view('seller.services.create', compact('seller'));
    }

    public function store(Request $request): RedirectResponse
    {
        $seller = $this->getSeller();

        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'category'           => ['required', 'string', 'max:100'],
            'short_description'  => ['nullable', 'string', 'max:500'],
            'description'        => ['nullable', 'string'],
            'tags'               => ['nullable', 'string', 'max:255'],
            'delivery_days'      => ['required', 'integer', 'min:1'],
            'package_name'       => ['required', 'string', 'max:100'],
            'price'              => ['required', 'numeric', 'min:0'],
            'package_features'   => ['nullable', 'string'],
            'buyer_requirements' => ['nullable', 'string'],
            'thumbnail'          => ['nullable', 'string', 'max:255'],
        ]);

        $seller->services()->create([
            'title'              => $validated['title'],
            'slug'               => Str::slug($validated['title']) . '-' . Str::random(5),
            'category'           => $validated['category'],
            'short_description'  => $validated['short_description'] ?? null,
            'description'        => $validated['description'] ?? null,
            'tags'               => $validated['tags'] ?? null,
            'delivery_days'      => (int) $validated['delivery_days'],
            'package_name'       => $validated['package_name'],
            'price'              => (float) $validated['price'],
            'package_features'   => $validated['package_features'] ?? null,
            'buyer_requirements' => $validated['buyer_requirements'] ?? null,
            'thumbnail'          => $validated['thumbnail'] ?? null,
            'status'             => 'pending',
        ]);

        return redirect()->route('seller.services.index')->with('success', 'Service gig submitted successfully! It is now pending Super Admin review.');
    }
}

