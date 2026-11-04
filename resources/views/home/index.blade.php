@extends('layouts.app')

@section('title', 'Discover Trusted Businesses & Institutes Near You - Digital Class')

@section('styles')
<style>
    /* ==========================================================================
       HERO SECTION WITH CITY PANORAMA
       ========================================================================== */
    .hero-marketplace {
        position: relative;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.96) 0%, rgba(255, 255, 255, 0.88) 40%, rgba(255, 255, 255, 0.35) 75%, rgba(255, 255, 255, 0.1) 100%),
                    url('https://images.unsplash.com/photo-1596176530529-78163a4f7af2?w=1600&auto=format&fit=crop&q=80') center right / cover no-repeat;
        border-bottom: 1px solid #e2e8f0;
        padding: 2.75rem 0 2.25rem;
        overflow: hidden;
    }

    .hero-tag {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #1e3a8a;
        margin-bottom: 0.35rem;
        display: inline-block;
    }

    .hero-title {
        font-size: 2.35rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        line-height: 1.15;
        color: #0f172a;
        margin-bottom: 0.45rem;
    }

    .hero-subtitle {
        font-size: 0.875rem;
        color: #475569;
        max-width: 580px;
        line-height: 1.45;
        margin-bottom: 1.35rem;
    }

    /* Floating Hero Search Box */
    .hero-search-box {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        padding: 0.35rem;
        max-width: 650px;
    }

    .hero-search-input {
        border: none;
        outline: none;
        font-size: 0.875rem;
        padding: 0.55rem 0.75rem;
        color: #1e293b;
        background: transparent;
    }

    .hero-search-input::placeholder {
        color: #94a3b8;
    }

    .hero-location-select {
        border: none;
        border-left: 1px solid #e2e8f0;
        outline: none;
        font-size: 0.85rem;
        padding: 0.55rem 0.75rem;
        color: #334155;
        background: transparent;
        font-weight: 600;
    }

    .btn-hero-search {
        background-color: #0066ff;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.6rem 1.4rem;
        border-radius: 8px;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }
    .btn-hero-search:hover {
        background-color: #0052cc;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    /* Popular Searches Pills */
    .popular-pills {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.85rem;
        font-size: 0.75rem;
    }

    .popular-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.2rem 0.65rem;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s;
    }
    .popular-pill:hover {
        border-color: #0066ff;
        color: #0066ff;
        background: #eff6ff;
    }

    /* Hero Right Trust Callout */
    .hero-trust-box {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 16px;
        padding: 1.15rem 1.25rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .script-slogan {
        font-family: 'Outfit', cursive, sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e3a8a;
        line-height: 1.25;
        margin-bottom: 0.85rem;
        position: relative;
    }

    .tricolor-stripe {
        height: 3px;
        width: 48px;
        background: linear-gradient(90deg, #ff9933 33.3%, #ffffff 33.3% 66.6%, #138808 66.6%);
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 2px;
        margin-top: 4px;
        margin-bottom: 0.85rem;
    }

    .trust-badge-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.65rem;
    }
    .trust-badge-item:last-child {
        margin-bottom: 0;
    }

    .trust-icon-pill {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    /* ==========================================================================
       CATEGORY ICONS HORIZONTAL BAR
       ========================================================================== */
    .category-bar-wrapper {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.75rem 0;
    }

    .category-scroll-container {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 4px;
        scrollbar-width: thin;
    }
    .category-scroll-container::-webkit-scrollbar {
        height: 4px;
    }
    .category-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .cat-pill-btn {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        padding: 0.45rem 0.55rem;
        border-radius: 10px;
        border: 1px solid transparent;
        color: #475569;
        text-decoration: none;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.15s ease;
        background: transparent;
        text-align: center;
        gap: 0.25rem;
    }
    .cat-pill-btn i {
        font-size: 0.95rem;
        color: #64748b;
        transition: color 0.15s;
    }
    .cat-pill-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0066ff;
    }
    .cat-pill-btn:hover i {
        color: #0066ff;
    }
    .cat-pill-btn.active {
        background: #eff6ff;
        border-color: #0066ff;
        color: #0066ff;
    }
    .cat-pill-btn.active i {
        color: #0066ff;
    }

    /* ==========================================================================
       MAIN CONTENT 3-COLUMN LAYOUT
       ========================================================================== */
    .marketplace-main-section {
        background: #f8fafc;
        padding: 1.5rem 0 3.5rem;
    }

    /* Left Sidebar: Filter Panel */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        font-size: 0.8125rem;
    }

    .filter-section-title {
        font-size: 0.825rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.55rem;
    }

    .filter-check-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.4rem;
        cursor: pointer;
        user-select: none;
    }
    .filter-check-item label {
        cursor: pointer;
        margin-bottom: 0;
        color: #475569;
        font-size: 0.8rem;
    }
    .filter-count {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    /* Promo Banners */
    .promo-banner-free {
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
        border: 1px solid #fed7aa;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .promo-banner-city {
        background: linear-gradient(rgba(15, 23, 42, 0.45), rgba(15, 23, 42, 0.65)),
                    url('https://images.unsplash.com/photo-1596176530529-78163a4f7af2?w=800&auto=format&fit=crop&q=80') center/cover no-repeat;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        color: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Business Card Grid & Cards */
    .business-grid-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .business-grid-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .card-thumb-wrapper {
        position: relative;
        width: 100%;
        height: 135px;
        background: #f1f5f9;
        overflow: hidden;
    }
    .card-thumb-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.25s ease;
    }
    .business-grid-card:hover .card-thumb-wrapper img {
        transform: scale(1.04);
    }

    .card-badge-pill {
        position: absolute;
        top: 8px;
        left: 8px;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        letter-spacing: 0.02em;
        z-index: 2;
    }
    .card-badge-featured {
        background-color: #f59e0b;
        color: #ffffff;
    }
    .card-badge-verified {
        background-color: #0066ff;
        color: #ffffff;
    }

    .card-heart-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 26px;
        height: 26px;
        background: rgba(255, 255, 255, 0.85);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.15s;
        z-index: 2;
    }
    .card-heart-btn:hover {
        background: #ffffff;
        transform: scale(1.15);
    }
    .card-heart-btn.active i {
        font-weight: 900;
    }

    .card-content-body {
        padding: 0.75rem 0.85rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .business-card-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
        line-height: 1.25;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.5em;
    }

    .card-rating-row {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        margin-bottom: 0.3rem;
    }

    .card-location-row {
        font-size: 0.72rem;
        color: #64748b;
        margin-bottom: 0.45rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-tag-pill {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.65rem;
        font-weight: 500;
        padding: 0.12rem 0.45rem;
        border-radius: 4px;
        display: inline-block;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
    }

    /* Action Buttons Row */
    .card-actions-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0.35rem;
        padding: 0.65rem 0.85rem 0.75rem;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
    }

    .btn-card-action {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.35rem 0.35rem;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        transition: all 0.15s;
    }

    .btn-card-call {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #1e293b;
    }
    .btn-card-call:hover {
        background: #0066ff;
        border-color: #0066ff;
        color: #ffffff;
    }

    .btn-card-wa {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
    }
    .btn-card-wa:hover {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
    }

    .btn-card-view {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
    }
    .btn-card-view:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* Right Sidebar Widgets */
    .map-preview-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem;
        position: relative;
        overflow: hidden;
    }

    .stylized-city-map {
        height: 140px;
        border-radius: 8px;
        background: radial-gradient(circle at 50% 50%, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .map-radar-dot {
        width: 14px;
        height: 14px;
        background: #0066ff;
        border-radius: 50%;
        position: relative;
        box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.2);
    }
    .map-radar-dot::after {
        content: '';
        position: absolute;
        width: 38px;
        height: 38px;
        border: 2px solid #0066ff;
        border-radius: 50%;
        top: -12px;
        left: -12px;
        animation: mapPulse 2s infinite ease-out;
    }
    @keyframes mapPulse {
        0% { transform: scale(0.6); opacity: 1; }
        100% { transform: scale(1.6); opacity: 0; }
    }

    .map-pin-indicator {
        position: absolute;
        font-size: 0.9rem;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .map-pin-indicator:hover {
        transform: scale(1.3);
    }

    .add-business-sidebar-cta {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.15rem 1rem;
        text-align: center;
    }

    .why-list-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')

<!-- ============================================================================
     1. HERO SECTION WITH SABARMATI RIVERFRONT PANORAMA
     ============================================================================ -->
<div class="hero-marketplace">
    <div class="container-fluid px-lg-4">
        <div class="row align-items-center">
            
            <!-- Left Hero Content -->
            <div class="col-lg-7 col-xl-8 mb-4 mb-lg-0">
                <span class="hero-tag">
                    <i class="fa-solid fa-building-columns me-1 text-primary"></i> Local Businesses & Institutes
                </span>
                
                <h1 class="hero-title">
                    Discover Trusted<br>
                    <span style="color: #0066ff;">Businesses Near You</span>
                </h1>
                
                <p class="hero-subtitle">
                    Find schools, coaching institutes, training centers, shops, service centers and verified businesses &mdash; all in one place.
                </p>

                <!-- Search Box -->
                <form action="{{ route('home') }}" method="GET" class="hero-search-box d-flex align-items-center">
                    <div class="d-flex align-items-center flex-grow-1 px-2">
                        <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                        <input type="text" name="search" value="{{ $searchQuery }}" class="hero-search-input flex-grow-1" placeholder="Search by business name, category or location">
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-location-dot text-primary ms-2 me-1"></i>
                        <select name="city" class="hero-location-select" onchange="this.form.submit()">
                            <option value="Ahmedabad" {{ $selectedCity === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                            <option value="Surat" {{ $selectedCity === 'Surat' ? 'selected' : '' }}>Surat</option>
                            <option value="Vadodara" {{ $selectedCity === 'Vadodara' ? 'selected' : '' }}>Vadodara</option>
                            <option value="Rajkot" {{ $selectedCity === 'Rajkot' ? 'selected' : '' }}>Rajkot</option>
                            <option value="Gandhinagar" {{ $selectedCity === 'Gandhinagar' ? 'selected' : '' }}>Gandhinagar</option>
                            <option value="All Locations" {{ $selectedCity === 'All Locations' ? 'selected' : '' }}>All Locations</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-hero-search ms-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </form>

                <!-- Popular Searches Pills -->
                <div class="popular-pills">
                    <span class="text-muted fw-bold me-1">Popular Searches:</span>
                    <a href="{{ route('home', ['search' => 'Computer Classes']) }}" class="popular-pill">Computer Classes</a>
                    <a href="{{ route('home', ['category' => 'Coaching Institute']) }}" class="popular-pill">Coaching Institute</a>
                    <a href="{{ route('home', ['search' => 'Tuition Classes']) }}" class="popular-pill">Tuition Classes</a>
                    <a href="{{ route('home', ['search' => 'Laptop Repair']) }}" class="popular-pill">Laptop Repair</a>
                    <a href="{{ route('home', ['category' => 'Gym & Fitness']) }}" class="popular-pill">Gym</a>
                    <a href="{{ route('home', ['search' => 'Dance Class']) }}" class="popular-pill">Dance Class</a>
                    <a href="{{ route('home', ['category' => 'Play School']) }}" class="popular-pill">Play School</a>
                </div>
            </div>

            <!-- Right Hero Trust Box -->
            <div class="col-lg-5 col-xl-4">
                <div class="hero-trust-box">
                    <div class="script-slogan">
                        Support Local Businesses<br>
                        <span style="color: #0066ff;">Build Stronger Communities</span>
                    </div>
                    <div class="tricolor-stripe"></div>

                    <div class="trust-badge-item">
                        <div class="trust-icon-pill bg-primary-subtle text-primary">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark" style="font-size: 0.78rem;">Verified Businesses</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Trusted & Genuine Listings</div>
                        </div>
                    </div>

                    <div class="trust-badge-item">
                        <div class="trust-icon-pill bg-warning-subtle text-warning">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark" style="font-size: 0.78rem;">Real Reviews & Ratings</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Direct Feedback From Customers</div>
                        </div>
                    </div>

                    <div class="trust-badge-item">
                        <div class="trust-icon-pill bg-success-subtle text-success">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark" style="font-size: 0.78rem;">Easy Contact</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Call, WhatsApp or Visit in Person</div>
                        </div>
                    </div>

                    <div class="trust-badge-item">
                        <div class="trust-icon-pill bg-info-subtle text-info">
                            <i class="fa-solid fa-location-crosshairs"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark" style="font-size: 0.78rem;">Find Near You</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Location-Based Proximity Search</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================================================
     2. CATEGORY HORIZONTAL BAR
     ============================================================================ -->
<div class="category-bar-wrapper">
    <div class="container-fluid px-lg-4">
        <div class="category-scroll-container">
            @foreach($horizontalCategories as $cat)
                <a href="{{ route('home', ['category' => $cat['name'] === 'All Businesses' ? '' : $cat['slug']]) }}"
                   class="cat-pill-btn {{ ($selectedCategory === $cat['name'] || ($selectedCategory === 'All Businesses' && $cat['name'] === 'All Businesses')) ? 'active' : '' }}">
                    <i class="{{ $cat['icon'] }}"></i>
                    <span>{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- ============================================================================
     3. MAIN THREE-COLUMN MARKETPLACE CONTENT
     ============================================================================ -->
<div class="marketplace-main-section">
    <div class="container-fluid px-lg-4">
        <div class="row g-3">

            <!-- ==========================================
                 LEFT COLUMN: FILTERS SIDEBAR
                 ========================================== -->
            <div class="col-xl-2 col-lg-3 col-md-4">
                <div class="filter-card mb-3">
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                        <div class="fw-bold text-dark" style="font-size: 0.875rem;">
                            <i class="fa-solid fa-sliders me-1 text-primary"></i> Filters
                        </div>
                        <a href="{{ route('home') }}" class="text-decoration-none small text-primary fw-semibold">Clear All</a>
                    </div>

                    <!-- Location Selector -->
                    <div class="mb-3">
                        <div class="filter-section-title">Location</div>
                        <select class="form-select form-select-sm mb-2" onchange="window.location.href='{{ route('home') }}?city=' + this.value">
                            <option value="Ahmedabad" {{ $selectedCity === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                            <option value="Surat" {{ $selectedCity === 'Surat' ? 'selected' : '' }}>Surat</option>
                            <option value="Vadodara" {{ $selectedCity === 'Vadodara' ? 'selected' : '' }}>Vadodara</option>
                        </select>
                        <select class="form-select form-select-sm text-muted">
                            <option>Within 10 km</option>
                            <option>Within 5 km</option>
                            <option>Within 25 km</option>
                        </select>
                    </div>

                    <!-- Business Category -->
                    <div class="mb-3">
                        <div class="filter-section-title">Business Category</div>
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" id="categoryFilterSearch" class="form-control" placeholder="Search categories..." onkeyup="filterCategoryCheckboxes(this.value)">
                        </div>
                        <div id="categoryCheckboxesContainer">
                            @foreach($sidebarCategories as $sc)
                                <div class="filter-check-item">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="cat_{{ Str::slug($sc['name']) }}"
                                               {{ $selectedCategory === $sc['name'] ? 'checked' : '' }}
                                               onchange="window.location.href='{{ route('home', ['category' => $sc['name']]) }}'">
                                        <label class="form-check-label" for="cat_{{ Str::slug($sc['name']) }}">
                                            {{ $sc['name'] }}
                                        </label>
                                    </div>
                                    <span class="filter-count">({{ $sc['count'] }})</span>
                                </div>
                            @endforeach
                        </div>
                        <a href="#" class="d-inline-block small text-primary text-decoration-none mt-1">Show More ▾</a>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-3">
                        <div class="filter-section-title">Rating</div>
                        @php
                            $ratingOptions = [
                                ['min' => '4.5', 'stars' => 5, 'label' => '4.5 & Above', 'count' => '1,240'],
                                ['min' => '4.0', 'stars' => 4, 'label' => '4.0 & Above', 'count' => '2,860'],
                                ['min' => '3.5', 'stars' => 3, 'label' => '3.5 & Above', 'count' => '3,920'],
                                ['min' => '3.0', 'stars' => 3, 'label' => '3.0 & Above', 'count' => '4,580'],
                            ];
                        @endphp
                        @foreach($ratingOptions as $ro)
                            <div class="filter-check-item">
                                <div class="form-check mb-0 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="rating_{{ $ro['min'] }}"
                                           {{ $selectedRating == $ro['min'] ? 'checked' : '' }}
                                           onchange="window.location.href='{{ route('home', array_merge(request()->all(), ['rating' => $ro['min']])) }}'">
                                    <label class="form-check-label d-flex align-items-center" for="rating_{{ $ro['min'] }}">
                                        <span class="text-warning me-1">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fa-{{ $i <= $ro['stars'] ? 'solid' : 'regular' }} fa-star" style="font-size: 0.65rem;"></i>
                                            @endfor
                                        </span>
                                        <span style="font-size: 0.72rem;">{{ $ro['label'] }}</span>
                                    </label>
                                </div>
                                <span class="filter-count">({{ $ro['count'] }})</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Facilities -->
                    <div class="mb-3">
                        <div class="filter-section-title">Facilities</div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="fac_parking">
                                <label class="form-check-label" for="fac_parking">Parking Available</label>
                            </div>
                            <span class="filter-count">(1,820)</span>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="fac_online">
                                <label class="form-check-label" for="fac_online">Online Classes</label>
                            </div>
                            <span class="filter-count">(980)</span>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="fac_home">
                                <label class="form-check-label" for="fac_home">Home Visit</label>
                            </div>
                            <span class="filter-count">(640)</span>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="fac_emi">
                                <label class="form-check-label" for="fac_emi">EMI Available</label>
                            </div>
                            <span class="filter-count">(420)</span>
                        </div>
                    </div>

                    <!-- Business Type -->
                    <div>
                        <div class="filter-section-title">Business Type</div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="type_individual">
                                <label class="form-check-label" for="type_individual">Individual Business</label>
                            </div>
                            <span class="filter-count">(3,120)</span>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="type_franchise">
                                <label class="form-check-label" for="type_franchise">Franchise</label>
                            </div>
                            <span class="filter-count">(680)</span>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="type_partner">
                                <label class="form-check-label" for="type_partner">Verified Partner</label>
                            </div>
                            <span class="filter-count">(1,240)</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ==========================================
                 MIDDLE COLUMN: BANNERS + BUSINESS CARDS GRID
                 ========================================== -->
            <div class="col-xl-8 col-lg-6 col-md-8">

                <!-- 2 Top Banner Cards -->
                <div class="row g-3 mb-3">
                    
                    <!-- Banner 1: List Your Business Free -->
                    <div class="col-lg-7">
                        <div class="promo-banner-free d-flex align-items-center justify-content-between">
                            <div style="max-width: 62%;">
                                <h3 class="fw-bold mb-1" style="font-size: 1.05rem; color: #9a3412;">
                                    List Your <span style="color: #ea580c;">Business for Free</span>
                                </h3>
                                <p class="text-muted small mb-2" style="font-size: 0.725rem; line-height: 1.35;">
                                    Get more customers, increase visibility and grow your business with Digital Class.
                                </p>
                                <a href="{{ route('seller.register') }}" class="btn btn-warning btn-sm fw-bold px-3 py-1 text-white" style="background-color: #ea580c; border: none; font-size: 0.72rem; border-radius: 6px;">
                                    Add Your Business &rarr;
                                </a>

                                <div class="row g-1 mt-2 text-dark" style="font-size: 0.65rem; font-weight: 600;">
                                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Free Listing</div>
                                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Show on Map</div>
                                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Get Reviews</div>
                                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Reach Local Customers</div>
                                </div>
                            </div>
                            <div>
                                <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?w=240&auto=format&fit=crop&q=80" 
                                     alt="Shopkeeper" 
                                     class="rounded-3 shadow-sm" 
                                     style="width: 110px; height: 115px; object-fit: cover; border: 2px solid #ffffff;">
                            </div>
                        </div>
                    </div>

                    <!-- Banner 2: Featured in Ahmedabad -->
                    <div class="col-lg-5">
                        <div class="promo-banner-city">
                            <div>
                                <h4 class="fw-bold text-white mb-1" style="font-size: 1.05rem;">
                                    Featured in {{ $selectedCity }}
                                </h4>
                                <p class="text-light small mb-2" style="font-size: 0.725rem; opacity: 0.9;">
                                    Explore top-rated businesses near you.
                                </p>
                            </div>
                            <div class="d-flex flex-wrap gap-1">
                                <a href="{{ route('home', ['category' => 'Coaching Institute']) }}" class="badge bg-white text-dark text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-school text-primary me-1"></i> Institutes
                                </a>
                                <a href="{{ route('home', ['category' => 'Retail Shops']) }}" class="badge bg-white text-dark text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-bag-shopping text-warning me-1"></i> Shops
                                </a>
                                <a href="{{ route('home', ['category' => 'Computer Training']) }}" class="badge bg-white text-dark text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-laptop text-info me-1"></i> Training Centers
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Section Header with Count, Sort and Grid/Map View -->
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h2 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">
                            {{ number_format(count($businesses)) }}+ Businesses in {{ $selectedCity }}
                        </h2>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Sort Dropdown -->
                        <div class="d-flex align-items-center gap-1 small text-muted">
                            <span>Sort by:</span>
                            <select class="form-select form-select-sm" style="font-size: 0.75rem; width: auto;" onchange="window.location.href='{{ route('home') }}?sort=' + this.value">
                                <option value="popular" {{ $sortBy === 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="rating" {{ $sortBy === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Recently Added</option>
                            </select>
                        </div>

                        <!-- Grid / Map Toggle -->
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-primary btn-sm px-2" id="btnToggleGrid" onclick="switchView('grid')" title="Grid View">
                                <i class="fa-solid fa-table-cells"></i> Grid
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm px-2" id="btnToggleMap" onclick="switchView('map')" title="Map View">
                                <i class="fa-solid fa-map-location-dot"></i> Map
                            </button>
                        </div>

                        <!-- Pagination Arrows -->
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-light border btn-sm py-1 px-2" title="Previous"><i class="fa-solid fa-chevron-left" style="font-size: 0.7rem;"></i></button>
                            <button class="btn btn-light border btn-sm py-1 px-2" title="Next"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i></button>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     CARDS GRID (4 Cards per row on xl)
                     ========================================== -->
                <div id="businessesGridContainer" class="row g-3">
                    @forelse($businesses as $b)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 business-card-item">
                            <div class="business-grid-card">
                                
                                <!-- Card Thumbnail & Badges -->
                                <div class="card-thumb-wrapper">
                                    <img src="{{ $b->display_image }}" alt="{{ $b->business_name }}" loading="lazy">
                                    
                                    @if($b->badge === 'Featured')
                                        <span class="card-badge-pill card-badge-featured">Featured</span>
                                    @elseif($b->badge === 'Verified')
                                        <span class="card-badge-pill card-badge-verified">Verified</span>
                                    @endif

                                    <button class="card-heart-btn" onclick="toggleFavorite(this, '{{ addslashes($b->business_name) }}')" title="Save to favorites">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>

                                <!-- Card Body -->
                                <div class="card-content-body">
                                    <div class="d-flex align-items-start gap-2 mb-1">
                                        @if($b->logo)
                                            <img src="{{ $b->logo }}" alt="Logo" class="rounded-circle border" style="width: 22px; height: 22px; object-fit: cover; flex-shrink: 0; margin-top: 1px;">
                                        @endif
                                        <h4 class="business-card-title mb-0" title="{{ $b->business_name }}">
                                            {{ $b->business_name }}
                                        </h4>
                                    </div>

                                    <!-- Rating -->
                                    <div class="card-rating-row">
                                        <span class="badge bg-warning text-dark px-1 py-0 fw-bold" style="font-size: 0.65rem;">
                                            <i class="fa-solid fa-star text-white"></i> {{ number_format($b->rating, 1) }}
                                        </span>
                                        <span class="text-muted" style="font-size: 0.68rem;">({{ $b->reviews_count }})</span>
                                    </div>

                                    <!-- Location -->
                                    <div class="card-location-row">
                                        <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $b->area_text }}
                                    </div>

                                    <!-- Tags -->
                                    <div class="mt-auto">
                                        @foreach(array_slice($b->tags_list, 0, 3) as $tag)
                                            <span class="card-tag-pill">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Action Buttons Row -->
                                <div class="card-actions-row">
                                    <button type="button" class="btn-card-action btn-card-call" onclick="openContactModal('{{ addslashes($b->business_name) }}', '{{ $b->phone }}')">
                                        <i class="fa-solid fa-phone"></i> Call
                                    </button>
                                    <a href="https://wa.me/{{ $b->whatsapp_number ?? '919876543210' }}?text={{ urlencode('Hello, I found your listing ' . $b->business_name . ' on Digital Class. I would like more information.') }}" 
                                       target="_blank" 
                                       class="btn-card-action btn-card-wa">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <button type="button" class="btn-card-action btn-card-view" onclick="openDetailModal({{ json_encode([
                                        'name' => $b->business_name,
                                        'category' => $b->category,
                                        'image' => $b->display_image,
                                        'rating' => $b->rating,
                                        'reviews' => $b->reviews_count,
                                        'location' => $b->area_text,
                                        'phone' => $b->phone,
                                        'tags' => $b->tags_list,
                                        'desc' => $b->description ?? 'Premier verified establishment providing top-tier professional services, training, and certified programs.',
                                    ]) }})">
                                        View
                                    </button>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-magnifying-glass fs-1 text-muted mb-3"></i>
                            <h5 class="fw-bold text-dark">No businesses found matching your criteria</h5>
                            <p class="text-muted small">Try broadening your search term or clearing the filters.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm px-4">Reset All Filters</a>
                        </div>
                    @endforelse
                </div>

                <!-- Hidden Map View (Toggled on button click) -->
                <div id="businessesMapContainer" class="d-none">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body p-0">
                            <div style="height: 520px; width: 100%; position: relative; background: #e5e7eb;">
                                <iframe 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    loading="lazy" 
                                    allowfullscreen 
                                    referrerpolicy="no-referrer-when-downgrade"
                                    src="https://maps.google.com/maps?q={{ urlencode($selectedCity . ', Gujarat') }}&t=&z=13&ie=UTF8&iwloc=&output=embed">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ==========================================
                 RIGHT COLUMN: MAP WIDGET & SIDEBAR CTA
                 ========================================== -->
            <div class="col-xl-2 col-lg-3 col-md-12">
                
                <!-- Map Widget Box -->
                <div class="map-preview-card mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-bold text-dark small" style="font-size: 0.8rem;">
                            Businesses Near You
                        </div>
                        <a href="javascript:void(0)" onclick="switchView('map')" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.7rem;">
                            View on Map &rarr;
                        </a>
                    </div>

                    <div class="stylized-city-map">
                        <div class="map-radar-dot"></div>
                        <span class="badge bg-white text-primary border shadow-sm position-absolute" style="top: 15px; font-size: 0.65rem; font-weight: 700;">
                            📍 {{ $selectedCity }}
                        </span>

                        <!-- Decorative Location Pins matching Ahmedabad locations -->
                        <i class="fa-solid fa-location-dot text-danger map-pin-indicator" style="top: 25px; left: 28px;" title="Nikol"></i>
                        <i class="fa-solid fa-location-dot text-warning map-pin-indicator" style="top: 35px; right: 35px;" title="Naroda"></i>
                        <i class="fa-solid fa-location-dot text-primary map-pin-indicator" style="bottom: 25px; left: 45px;" title="Sardar Chowk"></i>
                        <i class="fa-solid fa-location-dot text-success map-pin-indicator" style="bottom: 30px; right: 30px;" title="GIDC"></i>
                    </div>
                </div>

                <!-- Add Business Card CTA -->
                <div class="add-business-sidebar-cta mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle mb-2" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        <i class="fa-solid fa-store" style="color: #ea580c;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 0.925rem;">Add Your Business</h5>
                    <p class="text-muted small mb-3" style="font-size: 0.72rem; line-height: 1.35;">
                        Reach thousands of customers in your city. It's free and easy!
                    </p>
                    <a href="{{ route('seller.register') }}" class="btn btn-warning w-100 fw-bold text-white py-2" style="background-color: #ea580c; border: none; font-size: 0.8rem; border-radius: 8px;">
                        List Your Business &rarr;
                    </a>
                </div>

                <!-- Why List on Digital Class Benefits -->
                <div class="why-list-box">
                    <div class="fw-bold text-dark mb-2 pb-1 border-bottom" style="font-size: 0.8rem;">
                        Why List on Digital Class?
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-bullhorn text-success" style="font-size: 0.85rem; width: 16px;"></i>
                        <span style="font-size: 0.72rem; color: #334155; font-weight: 500;">Increase Local Visibility</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-users text-primary" style="font-size: 0.85rem; width: 16px;"></i>
                        <span style="font-size: 0.72rem; color: #334155; font-weight: 500;">Get More Customers</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-star text-warning" style="font-size: 0.85rem; width: 16px;"></i>
                        <span style="font-size: 0.72rem; color: #334155; font-weight: 500;">Build Trust with Reviews</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-mobile-screen-button text-info" style="font-size: 0.85rem; width: 16px;"></i>
                        <span style="font-size: 0.72rem; color: #334155; font-weight: 500;">Mobile + Web Listing</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-gift text-danger" style="font-size: 0.85rem; width: 16px;"></i>
                        <span style="font-size: 0.72rem; color: #334155; font-weight: 500;">Completely Free to Start</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- ============================================================================
     MODALS: BUSINESS DETAIL & CONTACT MODAL
     ============================================================================ -->
<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="contactModalTitle">Contact Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="d-inline-flex p-3 rounded-circle bg-primary-subtle text-primary mb-3">
                    <i class="fa-solid fa-phone fs-2"></i>
                </div>
                <h4 class="fw-bold mb-1" id="contactModalPhone">+91 98765 43210</h4>
                <p class="text-muted small mb-4">Click below to connect directly with this business</p>
                <div class="d-flex justify-content-center gap-2">
                    <a id="contactModalCallBtn" href="#" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-phone me-1"></i> Call Now
                    </a>
                    <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Business Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow overflow-hidden">
            <div style="height: 200px; width: 100%; position: relative;">
                <img id="detailModalImg" src="" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span id="detailModalCategory" class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1"></span>
                    <div class="d-flex align-items-center gap-1 small text-warning fw-bold">
                        <i class="fa-solid fa-star"></i> <span id="detailModalRating"></span> (<span id="detailModalReviews"></span> reviews)
                    </div>
                </div>

                <h3 class="fw-bold text-dark mb-1" id="detailModalTitle"></h3>
                <p class="text-muted small mb-3">
                    <i class="fa-solid fa-location-dot text-danger me-1"></i> <span id="detailModalLocation"></span>
                </p>

                <p class="text-secondary small mb-3" id="detailModalDesc"></p>

                <div class="mb-4" id="detailModalTags"></div>

                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                    <div>
                        <small class="text-muted d-block">Direct Contact</small>
                        <span class="fw-bold text-dark" id="detailModalPhone"></span>
                    </div>
                    <div class="d-flex gap-2">
                        <a id="detailModalCallLink" href="#" class="btn btn-primary btn-sm px-3 fw-bold">
                            <i class="fa-solid fa-phone me-1"></i> Call Now
                        </a>
                        <button type="button" class="btn btn-light btn-sm px-3 border" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     JAVASCRIPT LOGIC
     ============================================================================ -->
<script>
    // Toggle Heart / Favorite
    function toggleFavorite(btn, name) {
        btn.classList.toggle('active');
        const icon = btn.querySelector('i');
        if (btn.classList.contains('active')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            showToast('Saved!', name + ' added to your saved businesses.');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            showToast('Removed', name + ' removed from your saved businesses.');
        }
    }

    // Switch between Grid and Map view
    function switchView(view) {
        const gridCont = document.getElementById('businessesGridContainer');
        const mapCont = document.getElementById('businessesMapContainer');
        const btnGrid = document.getElementById('btnToggleGrid');
        const btnMap = document.getElementById('btnToggleMap');

        if (view === 'map') {
            gridCont.classList.add('d-none');
            mapCont.classList.remove('d-none');
            btnGrid.classList.remove('btn-primary');
            btnGrid.classList.add('btn-outline-secondary');
            btnMap.classList.remove('btn-outline-secondary');
            btnMap.classList.add('btn-primary');
        } else {
            mapCont.classList.add('d-none');
            gridCont.classList.remove('d-none');
            btnMap.classList.remove('btn-primary');
            btnMap.classList.add('btn-outline-secondary');
            btnGrid.classList.remove('btn-outline-secondary');
            btnGrid.classList.add('btn-primary');
        }
    }

    // Open Contact Modal
    function openContactModal(name, phone) {
        document.getElementById('contactModalTitle').innerText = name;
        document.getElementById('contactModalPhone').innerText = phone || '+91 98765 43210';
        document.getElementById('contactModalCallBtn').href = 'tel:' + (phone || '9876543210');
        const modal = new bootstrap.Modal(document.getElementById('contactModal'));
        modal.show();
    }

    // Open Detail Modal
    function openDetailModal(data) {
        document.getElementById('detailModalTitle').innerText = data.name;
        document.getElementById('detailModalCategory').innerText = data.category;
        document.getElementById('detailModalImg').src = data.image;
        document.getElementById('detailModalRating').innerText = data.rating;
        document.getElementById('detailModalReviews').innerText = data.reviews;
        document.getElementById('detailModalLocation').innerText = data.location;
        document.getElementById('detailModalDesc').innerText = data.desc;
        document.getElementById('detailModalPhone').innerText = data.phone;
        document.getElementById('detailModalCallLink').href = 'tel:' + data.phone;

        const tagsCont = document.getElementById('detailModalTags');
        tagsCont.innerHTML = '';
        if (data.tags && data.tags.length > 0) {
            data.tags.forEach(t => {
                const span = document.createElement('span');
                span.className = 'badge bg-light text-dark border me-1 mb-1';
                span.innerText = t;
                tagsCont.appendChild(span);
            });
        }

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }

    // Filter category checkboxes in sidebar
    function filterCategoryCheckboxes(keyword) {
        const query = keyword.toLowerCase();
        const items = document.querySelectorAll('#categoryCheckboxesContainer .filter-check-item');
        items.forEach(item => {
            const label = item.querySelector('label').innerText.toLowerCase();
            if (label.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Simple floating toast helper
    function showToast(title, message) {
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
