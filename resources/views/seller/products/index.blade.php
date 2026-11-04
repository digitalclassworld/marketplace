@extends('seller.layouts.seller')

@section('title', 'My Products - Digital Class Seller')

@section('page-title')
    <div class="d-flex align-items-center gap-2">
        <h1 class="h4 mb-0 fw-bold text-dark">My Products</h1>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1 small">
            {{ $products->total() }} Products
        </span>
    </div>
@endsection

@section('header-actions')
    <a href="{{ route('seller.products.create') }}" class="btn btn-danger btn-sm px-3 shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> Add New Product
    </a>
@endsection

@section('content')
<div class="container-fluid px-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2 align-items-center justify-content-between">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Search products by title, SKU, or category..." id="productSearch">
                    </div>
                </div>
                <div class="col-md-7 d-flex justify-content-md-end gap-2">
                    <span class="badge bg-light text-muted border d-flex align-items-center px-3 py-2">
                        Status: All ({{ $products->total() }})
                    </span>
                    <a href="{{ route('seller.products.create') }}" class="btn btn-danger btn-sm px-3">
                        <i class="fa-solid fa-plus me-1"></i> Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products List -->
    @if($products->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                            <th class="ps-4 py-3">Product Info</th>
                            <th class="py-3">Type & Category</th>
                            <th class="py-3">SKU & Stock</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                            <i class="fa-solid fa-box-open fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $product->title }}</div>
                                            <small class="text-muted">{{ Str::limit($product->description ?? 'No description provided', 55) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $product->product_type === 'Digital' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-dark' }} border">
                                        {{ $product->product_type }}
                                    </span>
                                    <span class="badge bg-light text-muted border">{{ $product->category }}</span>
                                </td>
                                <td>
                                    <div class="font-mono-code small text-dark">{{ $product->sku }}</div>
                                    <small class="text-muted">{{ $product->stock_quantity }} units in stock</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark font-mono-code">₹{{ number_format($product->price, 2) }}</div>
                                    @if($product->mrp && $product->mrp > $product->price)
                                        <small class="text-muted text-decoration-line-through font-mono-code">₹{{ number_format($product->mrp, 2) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($product->status === 'approved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="fa-solid fa-circle-check me-1"></i> Live
                                        </span>
                                    @elseif($product->status === 'rejected')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $product->rejection_reason }}">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="fa-solid fa-clock me-1"></i> Pending Approval
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <span class="text-muted small">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State matching Screenshot -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body py-5">
                <div class="rounded-circle bg-danger bg-opacity-10 text-danger mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-box-open fs-1"></i>
                </div>
                <h4 class="display-heading text-dark mb-2">No products added yet</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 480px;">
                    Sell digital assets, source codes, study materials, physical books, or merchandise across the marketplace.
                </p>
                <a href="{{ route('seller.products.create') }}" class="btn btn-danger px-4 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Add Your First Product
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

