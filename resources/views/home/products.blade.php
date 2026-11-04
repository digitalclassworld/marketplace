@extends('layouts.app')

@section('title', 'Products - Digital Class Educational World')

@section('styles')
<style>
    /* Products Page Styling */
    .products-hero-wrapper {
        background: linear-gradient(135deg, #f0f7ff 0%, #e6f0fa 50%, #fdfefe 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 2.25rem 0 2rem 0;
        position: relative;
    }

    .hero-tag-badge {
        font-size: 0.75rem;
        font-weight: 700;
        color: #2563eb;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.35rem;
    }

    .hero-title-main {
        font-size: 2.25rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -0.025em;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle-text {
        font-size: 0.95rem;
        color: #475569;
        max-width: 620px;
        line-height: 1.5;
        margin-bottom: 1.25rem;
    }

    /* Trust Feature Pills */
    .hero-trust-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.35rem 0.85rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #1e293b;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .hero-trust-pill i {
        color: #2563eb;
    }

    /* Hero Big Search Box */
    .hero-search-bar {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 0.35rem 0.5rem 0.35rem 1rem;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.08);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .hero-search-bar input {
        border: none;
        outline: none;
        font-size: 0.925rem;
        width: 100%;
        color: #0f172a;
    }
    .hero-search-bar .category-select {
        border: none;
        border-left: 1px solid #e2e8f0;
        padding: 0.35rem 0.75rem;
        font-size: 0.85rem;
        color: #475569;
        font-weight: 500;
        outline: none;
        background: transparent;
        cursor: pointer;
    }

    /* Hero Right Visual Banner */
    .hero-visual-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        position: relative;
    }
    .hero-desk-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    /* Side Trust List */
    .side-trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    }
    .side-trust-item:last-child {
        border-bottom: none;
    }
    .side-trust-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Horizontal Category Carousel */
    .categories-pill-scroll {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        overflow-x: auto;
        padding: 1rem 0;
        scrollbar-width: thin;
    }
    .category-pill-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        min-width: 95px;
        padding: 0.65rem 0.5rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        text-decoration: none;
        color: #334155;
        font-size: 0.72rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .category-pill-card:hover {
        border-color: #2563eb;
        color: #2563eb;
        transform: translateY(-2px);
    }
    .category-pill-card.active {
        background: #eff6ff;
        border-color: #2563eb;
        color: #2563eb;
        font-weight: 700;
    }
    .category-pill-card i {
        font-size: 1.15rem;
    }

    /* Promotional Banners */
    .promo-banner-orange {
        background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        border: 1px solid #fed7aa;
        border-radius: 14px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .promo-banner-blue {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
        border-radius: 14px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    /* Deal of the Day Card */
    .deal-day-card {
        background: #ffffff;
        border: 1px solid #fecaca;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.08);
    }
    .deal-day-header {
        background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
        color: #ffffff;
        padding: 0.65rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        font-weight: 700;
    }
    .timer-pill {
        background: rgba(0, 0, 0, 0.25);
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
    }

    /* Product Cards Grid */
    .product-grid-container {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.75rem;
    }
    @media (max-width: 1400px) {
        .product-grid-container { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 992px) {
        .product-grid-container { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .product-grid-container { grid-template-columns: repeat(2, 1fr); }
    }

    .product-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
        position: relative;
    }
    .product-card:hover {
        border-color: #2563eb;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    .product-card-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #f97316;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        z-index: 2;
    }
    .product-card-heart {
        position: absolute;
        top: 8px;
        right: 8px;
        color: #ef4444;
        background: #ffffff;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        cursor: pointer;
        font-size: 0.75rem;
        z-index: 2;
        border: none;
    }

    .product-card-thumb-wrap {
        height: 130px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 0.5rem;
        background: #f8fafc;
        border-radius: 8px;
    }
    .product-card-thumb {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-card-thumb {
        transform: scale(1.05);
    }

    .product-card-title {
        font-size: 0.825rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.1rem;
    }
    .product-card-specs {
        font-size: 0.68rem;
        color: #64748b;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-rating-row {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        margin-bottom: 0.35rem;
    }

    .product-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.4rem;
        flex-wrap: wrap;
        margin-bottom: 0.25rem;
    }
    .product-price {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
    }
    .product-mrp {
        font-size: 0.72rem;
        text-decoration: line-through;
        color: #94a3b8;
    }
    .product-discount-pill {
        font-size: 0.625rem;
        font-weight: 700;
        color: #16a34a;
        background: #dcfce7;
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
    }

    .product-seller-text {
        font-size: 0.68rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .btn-add-cart {
        background: #ffffff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.5rem;
        border-radius: 8px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
    }
    .btn-add-cart:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    /* Sidebar Filters */
    .filter-section-title {
        font-size: 0.825rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.65rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .filter-checkbox-item {
        font-size: 0.78rem;
        color: #334155;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Circular Brand Badges */
    .brand-circle-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.6rem;
    }
    .brand-circle-item {
        width: 48px;
        height: 48px;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        color: #1e293b;
        background: #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .brand-circle-item:hover {
        border-color: #2563eb;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }

    /* Bulk Order Institute Card */
    .bulk-order-card {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 14px;
        padding: 1.25rem 1rem;
        text-align: center;
    }
</style>
@endsection

@section('content')

<!-- =========================================================================
     1. HERO SECTION: EVERYTHING YOU NEED TO LEARN, TEACH & GROW
     ========================================================================= -->
<section class="products-hero-wrapper">
    <div class="container-fluid px-lg-4">
        <!-- Breadcrumbs -->
        <nav class="mb-2" style="font-size: 0.75rem; color: #64748b;">
            <a href="{{ route('home') }}" class="text-secondary text-decoration-none">Home</a> &gt;
            <span class="text-dark fw-semibold">Products</span>
        </nav>

        <div class="row align-items-center g-4">
            <!-- Left Hero Info & Search Bar -->
            <div class="col-xl-6 col-lg-7">
                <div class="hero-tag-badge">EDUCATION &amp; BUSINESS PRODUCTS</div>
                <h1 class="hero-title-main">Everything You Need<br>to Learn, Teach &amp; Grow</h1>
                <p class="hero-subtitle-text">
                    Laptops, accessories, software, books, classroom equipment, office essentials and more &mdash; from trusted sellers.
                </p>

                <!-- 4 Trust Badges Pills -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="hero-trust-pill">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span><strong>Trusted Sellers</strong> | Verified Stores</span>
                    </span>
                    <span class="hero-trust-pill">
                        <i class="fa-solid fa-lock"></i>
                        <span><strong>Secure Payments</strong> | 100% Safe &amp; Secure</span>
                    </span>
                    <span class="hero-trust-pill">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span><strong>Easy Returns</strong> | Hassle Free</span>
                    </span>
                    <span class="hero-trust-pill">
                        <i class="fa-solid fa-tags"></i>
                        <span><strong>Wide Range</strong> | 10,000+ Products</span>
                    </span>
                </div>

                <!-- Big Search Box -->
                <form action="{{ route('products') }}" method="GET" class="hero-search-bar">
                    <i class="fa-solid fa-magnifying-glass text-muted ms-1"></i>
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="What product are you looking for?">
                    <select name="category" class="category-select">
                        <option value="All Products">All Categories</option>
                        @foreach($sidebarCategories as $sc)
                            <option value="{{ $sc['name'] }}" {{ $selectedCategory == $sc['name'] ? 'selected' : '' }}>{{ $sc['name'] }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Search</span>
                    </button>
                </form>
            </div>

            <!-- Right Hero Visual Collage -->
            <div class="col-xl-4 col-lg-5 col-md-8">
                <div class="hero-visual-card position-relative">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80" alt="Tech setup" class="hero-desk-image">
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-dark bg-opacity-75 text-white d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold" style="font-size: 0.95rem;">Better Tools Brighter Learning</div>
                            <div class="small text-white-50" style="font-size: 0.75rem;">Premium tech &amp; educational gear</div>
                        </div>
                        <span class="badge bg-warning text-dark px-2 py-1">Top Rated</span>
                    </div>
                </div>
            </div>

            <!-- Far Right Side Badges (Top Brands, Verified Sellers, etc.) -->
            <div class="col-xl-2 col-lg-12">
                <div class="bg-white p-3 rounded-3 border border-light-subtle shadow-sm">
                    <div class="side-trust-item">
                        <div class="side-trust-icon bg-warning-subtle text-warning">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.8rem;">Top Brands</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Best Quality Products</div>
                        </div>
                    </div>
                    <div class="side-trust-item">
                        <div class="side-trust-icon bg-primary-subtle text-primary">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.8rem;">Verified Sellers</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Trusted &amp; Reliable</div>
                        </div>
                    </div>
                    <div class="side-trust-item">
                        <div class="side-trust-icon bg-success-subtle text-success">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.8rem;">Best Prices</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Great Deals Everyday</div>
                        </div>
                    </div>
                    <div class="side-trust-item">
                        <div class="side-trust-icon bg-info-subtle text-info">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.8rem;">Bulk Orders</div>
                            <div class="text-muted" style="font-size: 0.7rem;">For Institutes &amp; Businesses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     2. HORIZONTAL CATEGORIES CAROUSEL / PILLS (15 Categories)
     ========================================================================= -->
<section class="bg-white border-bottom">
    <div class="container-fluid px-lg-4">
        <div class="categories-pill-scroll">
            @foreach($horizontalCategories as $cat)
                <a href="{{ route('products', ['category' => $cat['name'] == 'All Products' ? null : $cat['name']]) }}"
                   class="category-pill-card {{ ($selectedCategory == $cat['name'] || ($cat['name'] == 'All Products' && $selectedCategory == 'All Products')) ? 'active' : '' }}">
                    <i class="{{ $cat['icon'] }}"></i>
                    <span>{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- =========================================================================
     3. PROMOTIONAL BANNERS + DEAL OF THE DAY ROW
     ========================================================================= -->
<section class="py-3 bg-light">
    <div class="container-fluid px-lg-4">
        <div class="row g-3">
            <!-- Left Banner: Laptops for Students & Educators -->
            <div class="col-lg-5 col-md-6">
                <div class="promo-banner-orange d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">
                            Laptops for<br><span style="color: #ea580c;">Students &amp; Educators</span>
                        </h3>
                        <p class="text-secondary small mb-3" style="font-size: 0.78rem;">
                            Best performance. Best prices. Perfect for learning.
                        </p>
                        <a href="{{ route('products', ['category' => 'Laptops & Computers']) }}" class="btn btn-sm text-white fw-bold px-3 py-1 rounded-3" style="background: #ea580c;">
                            Shop Now &rarr;
                        </a>
                    </div>
                    <div class="text-end d-none d-sm-block">
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=240&auto=format&fit=crop&q=80" alt="Laptops" style="max-height: 110px; border-radius: 8px;">
                        <div class="d-flex justify-content-end gap-1 mt-2 text-secondary" style="font-size: 0.65rem;">
                            <span>HP</span> &bull; <span>Dell</span> &bull; <span>Lenovo</span> &bull; <span>Apple</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Banner: Software & Licenses -->
            <div class="col-lg-4 col-md-6">
                <div class="promo-banner-blue d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">
                            Software &amp; Licenses
                        </h3>
                        <p class="text-secondary small mb-3" style="font-size: 0.78rem;">
                            Genuine Software for Institute, Office &amp; Business
                        </p>
                        <a href="{{ route('products', ['category' => 'Software & Licenses']) }}" class="btn btn-sm btn-outline-primary fw-bold px-3 py-1 rounded-3">
                            View Products &rarr;
                        </a>
                    </div>
                    <div class="text-end d-none d-sm-block">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=220&auto=format&fit=crop&q=80" alt="Software" style="max-height: 105px; border-radius: 8px;">
                    </div>
                </div>
            </div>

            <!-- Right: Deal of the Day -->
            <div class="col-lg-3 col-md-12">
                <div class="deal-day-card">
                    <div class="deal-day-header">
                        <div class="d-flex align-items-center gap-1">
                            <i class="fa-solid fa-bolt"></i>
                            <span>Deal of the Day</span>
                        </div>
                        <div class="timer-pill" id="dealCountdown">
                            <span id="dealHours">12</span>h <span id="dealMins">34</span>m <span id="dealSecs">56</span>s
                        </div>
                    </div>
                    <div class="p-2 d-flex align-items-center gap-2">
                        <img src="{{ $dealOfTheDay['thumbnail'] }}" alt="{{ $dealOfTheDay['title'] }}" style="width: 70px; height: 70px; object-fit: contain; border-radius: 8px; background: #f8fafc; padding: 4px;">
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark" style="font-size: 0.8rem; line-height: 1.2;">{{ $dealOfTheDay['title'] }}</div>
                            <div class="small text-warning" style="font-size: 0.7rem;">
                                ★ {{ $dealOfTheDay['rating'] }} <span class="text-muted">({{ $dealOfTheDay['reviews_count'] }})</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">₹{{ number_format($dealOfTheDay['price']) }}</span>
                                <span class="small text-muted text-decoration-line-through" style="font-size: 0.7rem;">₹{{ number_format($dealOfTheDay['mrp']) }}</span>
                                <span class="badge bg-success-subtle text-success" style="font-size: 0.6rem;">{{ $dealOfTheDay['discount'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 pt-0">
                        <button type="button" class="btn btn-primary btn-sm w-100 py-1 fw-bold" onclick="showLiveToast('Deal Claimed!', 'boAt Airdopes 141 added to cart at 50% OFF!')">
                            Grab Deal &rarr;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     4. MAIN DIRECTORY LAYOUT: SIDEBAR FILTERS + 10,000+ PRODUCTS GRID + RIGHT SIDEBAR
     ========================================================================= -->
<section class="py-4">
    <div class="container-fluid px-lg-4">
        <div class="row g-3">

            <!-- LEFT SIDEBAR: FILTERS -->
            <div class="col-xl-2 col-lg-3 col-md-4">
                <div class="bg-white p-3 rounded-3 border border-light-subtle shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Filters</h4>
                        <a href="{{ route('products') }}" class="text-primary text-decoration-none small fw-semibold" style="font-size: 0.75rem;">Clear All</a>
                    </div>

                    <!-- Filter by Category -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="filter-section-title">
                            <span>Category</span>
                            <i class="fa-solid fa-chevron-up text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        @foreach($sidebarCategories as $sc)
                            <div class="filter-checkbox-item">
                                <label class="form-check-label d-flex align-items-center gap-2">
                                    <input type="checkbox" class="form-check-input" {{ $selectedCategory == $sc['name'] ? 'checked' : '' }} onchange="window.location='{{ route('products', ['category' => $sc['name']]) }}'">
                                    <span>{{ $sc['name'] }}</span>
                                </label>
                                <span class="text-muted" style="font-size: 0.7rem;">({{ $sc['count'] }})</span>
                            </div>
                        @endforeach
                        <a href="#" class="text-primary small text-decoration-none mt-1 d-inline-block" style="font-size: 0.75rem;">Show More ▾</a>
                    </div>

                    <!-- Filter by Brand -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="filter-section-title">
                            <span>Brand</span>
                            <i class="fa-solid fa-chevron-up text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        @foreach($sidebarBrands as $sb)
                            <div class="filter-checkbox-item">
                                <label class="form-check-label d-flex align-items-center gap-2">
                                    <input type="checkbox" class="form-check-input" {{ in_array($sb['name'], $selectedBrands) ? 'checked' : '' }}>
                                    <span>{{ $sb['name'] }}</span>
                                </label>
                                <span class="text-muted" style="font-size: 0.7rem;">({{ $sb['count'] }})</span>
                            </div>
                        @endforeach
                        <a href="#" class="text-primary small text-decoration-none mt-1 d-inline-block" style="font-size: 0.75rem;">Show More ▾</a>
                    </div>

                    <!-- Filter by Price Range -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="filter-section-title">
                            <span>Price Range</span>
                            <i class="fa-solid fa-chevron-up text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        <input type="range" class="form-range" min="0" max="100000" step="1000" id="priceRangeSlider" value="{{ $maxPrice }}">
                        <div class="d-flex align-items-center justify-content-between gap-2 mt-2">
                            <input type="text" class="form-control form-control-sm text-center bg-light" value="₹ 0" readonly style="font-size: 0.75rem;">
                            <span class="text-muted">&mdash;</span>
                            <input type="text" class="form-control form-control-sm text-center bg-light" value="₹ 1,00,000" readonly style="font-size: 0.75rem;">
                        </div>
                    </div>

                    <!-- Condition -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="filter-section-title">
                            <span>Condition</span>
                            <i class="fa-solid fa-chevron-up text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        <div class="filter-checkbox-item">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" class="form-check-input" checked>
                                <span>New</span>
                            </label>
                            <span class="text-muted" style="font-size: 0.7rem;">(8,920)</span>
                        </div>
                        <div class="filter-checkbox-item">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" class="form-check-input">
                                <span>Refurbished</span>
                            </label>
                            <span class="text-muted" style="font-size: 0.7rem;">(620)</span>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="filter-section-title">
                            <span>Availability</span>
                            <i class="fa-solid fa-chevron-up text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        <div class="filter-checkbox-item">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" class="form-check-input" checked>
                                <span>In Stock</span>
                            </label>
                            <span class="text-muted" style="font-size: 0.7rem;">(9,120)</span>
                        </div>
                        <div class="filter-checkbox-item">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" class="form-check-input">
                                <span>Fast Delivery</span>
                            </label>
                            <span class="text-muted" style="font-size: 0.7rem;">(6,450)</span>
                        </div>
                    </div>

                    <!-- Seller Type -->
                    <div>
                        <div class="filter-section-title">
                            <span>Seller Type</span>
                            <i class="fa-solid fa-chevron-up text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        <div class="filter-checkbox-item">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" class="form-check-input" checked>
                                <span>Digital Class Verified</span>
                            </label>
                            <span class="text-muted" style="font-size: 0.7rem;">(4,320)</span>
                        </div>
                        <div class="filter-checkbox-item">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" class="form-check-input">
                                <span>All Sellers</span>
                            </label>
                            <span class="text-muted" style="font-size: 0.7rem;">(10,240)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CENTER & MAIN CONTENT: 10,000+ PRODUCTS GRID -->
            <div class="col-xl-8 col-lg-9 col-md-8">
                <!-- Top Bar: Count, Sort, Grid View & Pagination -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h2 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">
                        10,000+ Products
                    </h2>

                    <div class="d-flex align-items-center gap-3">
                        <!-- Sort Dropdown -->
                        <div class="d-flex align-items-center gap-1 small text-muted">
                            <span>Sort by:</span>
                            <select class="form-select form-select-sm border-light-subtle shadow-none py-1 ps-2 pe-4" style="font-size: 0.75rem;" onchange="window.location='{{ route('products') }}?sort=' + this.value">
                                <option value="popular" {{ $sortBy == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="price_low" {{ $sortBy == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ $sortBy == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Newest First</option>
                            </select>
                        </div>

                        <!-- Grid/List View Icons -->
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active py-1 px-2"><i class="fa-solid fa-table-cells"></i></button>
                            <button type="button" class="btn btn-outline-secondary py-1 px-2"><i class="fa-solid fa-list"></i></button>
                        </div>

                        <!-- Pagination Indicator -->
                        <div class="d-flex align-items-center gap-2 small text-muted" style="font-size: 0.75rem;">
                            <span>1 of 240 pages</span>
                            <button class="btn btn-sm btn-light border py-0 px-2" disabled>&lt;</button>
                            <button class="btn btn-sm btn-light border py-0 px-2">&gt;</button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid (6 Columns Layout) -->
                <div class="product-grid-container mb-4">
                    @foreach($products as $p)
                        @php
                            $title = is_array($p) ? $p['title'] : $p->title;
                            $specs = is_array($p) ? ($p['specs'] ?? '') : ($p->shipping_details ?? '');
                            $badge = is_array($p) ? ($p['badge'] ?? null) : ($p->id == 1 ? 'Best Seller' : null);
                            $price = is_array($p) ? $p['price'] : $p->price;
                            $mrp = is_array($p) ? $p['mrp'] : $p->mrp;
                            $discount = is_array($p) ? $p['discount'] : ($p->discount_percentage . '% OFF');
                            $rating = is_array($p) ? $p['rating'] : 4.6;
                            $reviewsCount = is_array($p) ? $p['reviews_count'] : '1.2K';
                            $sellerName = is_array($p) ? $p['seller_name'] : $p->seller_name;
                            $thumb = is_array($p) ? $p['thumbnail'] : $p->display_thumbnail;
                        @endphp

                        <div class="product-card">
                            <!-- Badge -->
                            @if($badge)
                                <span class="product-card-badge">{{ $badge }}</span>
                            @endif

                            <!-- Heart Wishlist -->
                            <button type="button" class="product-card-heart" onclick="toggleWishlist(this)" title="Save to wishlist">
                                <i class="fa-regular fa-heart"></i>
                            </button>

                            <!-- Thumbnail -->
                            <div class="product-card-thumb-wrap">
                                <img src="{{ $thumb }}" alt="{{ $title }}" class="product-card-thumb">
                            </div>

                            <!-- Product Info -->
                            <div>
                                <h3 class="product-card-title" title="{{ $title }}">{{ $title }}</h3>
                                @if($specs)
                                    <div class="product-card-specs" title="{{ $specs }}">{{ $specs }}</div>
                                @else
                                    <div class="product-card-specs">&nbsp;</div>
                                @endif

                                <!-- Rating -->
                                <div class="product-rating-row">
                                    <span class="text-warning">★ {{ $rating }}</span>
                                    <span class="text-muted">({{ $reviewsCount }})</span>
                                </div>

                                <!-- Price -->
                                <div class="product-price-row">
                                    <span class="product-price">₹{{ number_format((float)$price) }}</span>
                                    @if($mrp > $price)
                                        <span class="product-mrp">₹{{ number_format((float)$mrp) }}</span>
                                        <span class="product-discount-pill">{{ $discount }}</span>
                                    @endif
                                </div>

                                <!-- Seller Byline -->
                                <div class="product-seller-text">
                                    By {{ $sellerName }}
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="button" class="btn-add-cart" onclick="showLiveToast('Added to Cart', '{{ addslashes($title) }} has been added to your cart!')">
                                <span>Add to Cart</span>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- FAR RIGHT SIDEBAR: TOP BRANDS & BULK ORDERS -->
            <div class="col-xl-2 col-lg-12">
                <div class="d-flex flex-column gap-3">
                    <!-- Top Brands Widget -->
                    <div class="bg-white p-3 rounded-3 border border-light-subtle shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Top Brands</h4>
                            <a href="#" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">View All &rarr;</a>
                        </div>
                        <div class="brand-circle-grid">
                            <a href="{{ route('products', ['brand' => ['HP']]) }}" class="brand-circle-item" title="HP">hp</a>
                            <a href="{{ route('products', ['brand' => ['Dell']]) }}" class="brand-circle-item" title="Dell">DELL</a>
                            <a href="{{ route('products', ['brand' => ['Apple']]) }}" class="brand-circle-item" title="Apple"><i class="fa-brands fa-apple fs-6"></i></a>
                            <a href="{{ route('products', ['brand' => ['Lenovo']]) }}" class="brand-circle-item" title="Lenovo" style="font-size: 0.6rem;">Lenovo</a>
                            <a href="{{ route('products', ['brand' => ['Samsung']]) }}" class="brand-circle-item" title="Samsung" style="font-size: 0.55rem;">SAMSUNG</a>
                            <a href="{{ route('products', ['brand' => ['Canon']]) }}" class="brand-circle-item" title="Canon" style="font-size: 0.6rem;">Canon</a>
                            <a href="{{ route('products', ['brand' => ['Logitech']]) }}" class="brand-circle-item" title="Logitech" style="font-size: 0.55rem;">logitech</a>
                            <a href="{{ route('products', ['brand' => ['Epson']]) }}" class="brand-circle-item" title="Epson" style="font-size: 0.6rem;">EPSON</a>
                        </div>
                    </div>

                    <!-- Buy in Bulk for Your Institute -->
                    <div class="bulk-order-card shadow-sm">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-3 p-2 mb-2" style="font-size: 1.25rem;">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Buy in Bulk for Your Institute</h4>
                        <p class="text-secondary small mb-3" style="font-size: 0.75rem; line-height: 1.35;">
                            Special pricing for schools, colleges and training centers.
                        </p>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-3 py-1 rounded-3 w-100" data-bs-toggle="modal" data-bs-target="#bulkQuoteModal">
                            Request a Quote &rarr;
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Bulk Quote Modal -->
<div class="modal fade" id="bulkQuoteModal" tabindex="-1" aria-labelledby="bulkQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title fw-bold text-dark" id="bulkQuoteModalLabel">
                    <i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Request Institute Bulk Quote
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('home') }}" method="GET" onsubmit="event.preventDefault(); bootstrap.Modal.getInstance(document.getElementById('bulkQuoteModal')).hide(); showLiveToast('Quote Requested!', 'Our team will contact you within 24 hours with institute wholesale pricing.');">
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3">Get educational institute discounts on laptops, displays, projectors, lab mice, keyboards and licenses.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Institute / Business Name</label>
                        <input type="text" class="form-control form-control-sm" placeholder="e.g. VCEC Computer Center" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark">Contact Person</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Your Name" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark">Phone Number</label>
                            <input type="tel" class="form-control form-control-sm" placeholder="+91 98765 43210" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Required Items &amp; Quantities</label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="e.g. 20 Laptops, 30 Wireless Mice, 2 Projectors..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-3">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Live Countdown for Deal of the Day
    let countdownHours = 12;
    let countdownMins = 34;
    let countdownSecs = 56;
    setInterval(function() {
        countdownSecs--;
        if (countdownSecs < 0) {
            countdownSecs = 59;
            countdownMins--;
            if (countdownMins < 0) {
                countdownMins = 59;
                countdownHours--;
                if (countdownHours < 0) countdownHours = 23;
            }
        }
        document.getElementById('dealHours').textContent = String(countdownHours).padStart(2, '0');
        document.getElementById('dealMins').textContent = String(countdownMins).padStart(2, '0');
        document.getElementById('dealSecs').textContent = String(countdownSecs).padStart(2, '0');
    }, 1000);

    // Wishlist Heart Toggle
    function toggleWishlist(btn) {
        const icon = btn.querySelector('i');
        if (icon.classList.contains('fa-regular')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            showLiveToast('Saved to Wishlist', 'Item saved to your favorites.');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
        }
    }

    // Dynamic Live Toast Alert
    function showLiveToast(title, message) {
        let toastEl = document.getElementById('dcLiveToast');
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.id = 'dcLiveToast';
            toastEl.style.position = 'fixed';
            toastEl.style.bottom = '24px';
            toastEl.style.right = '24px';
            toastEl.style.zIndex = '9999';
            toastEl.style.background = '#0f172a';
            toastEl.style.color = '#ffffff';
            toastEl.style.padding = '0.75rem 1.25rem';
            toastEl.style.borderRadius = '10px';
            toastEl.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
            toastEl.style.fontSize = '0.85rem';
            toastEl.style.transition = 'all 0.3s ease';
            document.body.appendChild(toastEl);
        }
        toastEl.innerHTML = '<strong>' + title + '</strong>: ' + message;
        toastEl.style.opacity = '1';
        toastEl.style.transform = 'translateY(0)';
        setTimeout(() => {
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateY(10px)';
        }, 2500);
    }
</script>

@endsection
