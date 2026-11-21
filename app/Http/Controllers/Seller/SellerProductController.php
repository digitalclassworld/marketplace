<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Traits\HandlesSellerMediaUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    use HandlesSellerMediaUploads;

    private function getSeller(): ?Seller
    {
        return Auth::user()->seller;
    }

    public function index(): View
    {
        $seller = $this->getSeller();
        $products = $seller->products()->latest()->paginate(10);

        return view('seller.products.index', compact('seller', 'products'));
    }

    public function create(): View
    {
        $seller = $this->getSeller();
        return view('seller.products.create', compact('seller'));
    }

    public function store(Request $request): RedirectResponse
    {
        $seller = $this->getSeller();

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'category'         => ['required', 'string', 'max:100'],
            'product_type'     => ['required', 'string', 'in:Digital,Physical'],
            'description'      => ['nullable', 'string'],
            'sku'              => ['nullable', 'string', 'max:50'],
            'mrp'              => ['nullable', 'numeric', 'min:0'],
            'price'            => ['required', 'numeric', 'min:0'],
            'stock_quantity'   => ['required', 'integer', 'min:0'],
            'weight_grams'     => ['nullable', 'integer', 'min:0'],
            'shipping_details' => ['nullable', 'string', 'max:255'],
            'thumbnail'        => ['nullable', 'string', 'max:255'],
        ]);

        $media = $this->processMediaUploads($request, 'product');

        $seller->products()->create([
            'title'            => $validated['title'],
            'slug'             => Product::generateUniqueSlug($validated['title']),
            'category'         => $validated['category'],
            'product_type'     => $validated['product_type'],
            'description'      => $validated['description'] ?? null,
            'sku'              => $validated['sku'] ?? 'SKU-' . strtoupper(Str::random(6)),
            'mrp'              => $validated['mrp'] ?? $validated['price'],
            'price'            => (float) $validated['price'],
            'stock_quantity'   => (int) $validated['stock_quantity'],
            'weight_grams'     => $validated['weight_grams'] ?? null,
            'shipping_details' => $validated['shipping_details'] ?? null,
            'thumbnail'        => $media['thumbnail'],
            'cover_image'      => $media['cover_image'],
            'video_url'        => $media['video_url'],
            'gallery'          => $media['gallery'],
            'status'           => 'pending',
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product submitted successfully! It has been submitted for admin approval and will appear on the marketplace once approved.');
    }
}

