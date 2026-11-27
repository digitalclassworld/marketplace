@extends('customer.layouts.customer')

@section('title', 'My Wishlist - Digital Class World')

@section('content')
<div class="py-4 bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="fa-solid fa-heart text-danger me-2"></i> My Wishlist
                    <span class="badge bg-danger-subtle text-danger fs-6 rounded-pill align-middle ms-1">{{ $wishlistItems->count() }}</span>
                </h3>
                <p class="text-muted small mb-0">Courses and services saved for later enrollment</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if($wishlistItems->count() > 0)
                    <form action="{{ route('customer.wishlist.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove all items from your wishlist?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold rounded-pill px-3">
                            <i class="fa-regular fa-trash-can me-1"></i> Clear All
                        </button>
                    </form>
                @endif
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="{{ route('courses') }}" class="btn btn-primary btn-sm fw-semibold rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-graduation-cap me-1"></i> Browse More Courses
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <div class="row g-4 mb-4">
                @foreach($wishlistItems as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden d-flex flex-column bg-white transition-hover">
                            <!-- Card Thumbnail -->
                            <div class="position-relative" style="height: 170px; background: #e2e8f0;">
                                <img src="{{ $item['thumbnail'] }}" alt="{{ $item['title'] }}" class="w-100 h-100" style="object-fit: cover;">
                                <span class="position-absolute top-0 start-0 m-3 badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-1">
                                    {{ $item['type'] }}
                                </span>
                                <!-- Quick Remove from Wishlist Form -->
                                <form action="{{ route('customer.wishlist.remove', $item['id']) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-white bg-white text-danger shadow-sm rounded-pill px-2 py-1 fw-bold d-flex align-items-center gap-1 border-0" title="Remove from wishlist" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-trash-can"></i> <span>Remove</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                <div class="text-muted small mb-1">
                                    <i class="fa-solid fa-chalkboard-user text-primary me-1"></i> {{ $item['provider'] }}
                                </div>
                                <h6 class="fw-bold text-dark mb-2 text-truncate-2" style="min-height: 2.6rem; line-height: 1.35;">
                                    {{ $item['title'] }}
                                </h6>

                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-warning-subtle text-warning-emphasis">
                                        <i class="fa-solid fa-star text-warning"></i> {{ $item['rating'] ?? 4.9 }}
                                    </span>
                                    <span class="text-muted small">({{ $item['reviews'] ?? 50 }} reviews)</span>
                                </div>

                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex align-items-baseline justify-content-between mb-2">
                                        <span class="text-muted small">Price:</span>
                                        <div>
                                            <span class="fw-bold fs-5 text-primary">&#8377;{{ number_format($item['price']) }}</span>
                                            @if(!empty($item['mrp']) && $item['mrp'] > $item['price'])
                                                <span class="text-muted text-decoration-line-through small ms-1">&#8377;{{ number_format($item['mrp']) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('customer.wishlist.remove', $item['id']) }}" method="POST" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-semibold py-1">
                                                <i class="fa-solid fa-trash-can me-1"></i> Remove
                                            </button>
                                        </form>
                                        <a href="{{ $item['url'] ?? route('courses') }}" class="btn btn-primary btn-sm flex-fill rounded-pill fw-semibold py-1 shadow-sm text-center">
                                            {{ $item['type'] === 'Service' ? 'Hire Expert' : 'Enroll Now' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Promotion banner to explore more -->
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white d-flex flex-row align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger-subtle text-danger p-3 fs-4">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Want to save more courses or services?</h6>
                        <p class="text-muted small mb-0">Browse over 2,000+ verified computer courses, IT bootcamps, and business solutions.</p>
                    </div>
                </div>
                <a href="{{ route('courses') }}" class="btn btn-primary rounded-pill px-4 fw-semibold">
                    <i class="fa-solid fa-compass me-1"></i> Browse Marketplace
                </a>
            </div>
        @else
            <!-- Clean Empty State with Explore Button -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 px-3 mb-4 bg-white">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 85px; height: 85px; background: #fef2f2; color: #ef4444; font-size: 2.2rem; box-shadow: 0 8px 20px rgba(239, 68, 68, 0.12);">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark mb-2">Your Wishlist is Empty</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 0.92rem; line-height: 1.55;">
                    Explore our top trending online courses, certification programs, and professional services to save your favorites here for easy access.
                </p>
                <div class="mb-4">
                    <a href="{{ route('courses') }}" class="btn btn-danger btn-lg rounded-pill px-4 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #ef4444; border-color: #ef4444;">
                        <i class="fa-solid fa-graduation-cap me-2"></i> Explore Online Courses
                    </a>
                </div>

                <!-- Popular Course Categories -->
                <div class="pt-3 border-top mx-auto" style="max-width: 650px;">
                    <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Popular Course Topics</div>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('courses', ['search' => 'Python']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-brands fa-python text-warning me-1"></i> Python &amp; Data
                        </a>
                        <a href="{{ route('courses', ['search' => 'Web Development']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-code text-primary me-1"></i> Web Development
                        </a>
                        <a href="{{ route('courses', ['search' => 'Digital Marketing']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-chart-line text-success me-1"></i> Digital Marketing
                        </a>
                        <a href="{{ route('courses', ['search' => 'Tally']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-calculator text-info me-1"></i> Tally Prime &amp; GST
                        </a>
                        <a href="{{ route('courses', ['search' => 'Graphic Design']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-palette text-danger me-1"></i> Graphic Design
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
