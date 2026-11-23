@extends('layouts.app')

@section('title', 'All Online Courses - Learn In-Demand Tech, Business & Creative Skills | Digital Class')
@section('meta_description', 'Explore 1,084 authentic online courses on Digital Class. Learn Web Development, Python, Digital Marketing, Shopify, Graphic Design, Spoken English, and Competitive Exam prep with verified certifications.')
@section('meta_keywords', 'online courses India, learn coding online, digital marketing course, shopify sales machine, python programming, certification courses, edtech marketplace')

@section('styles')
<style>
    /* ==========================================================================
       HERO HEADER & SEARCH SECTION
       ========================================================================== */
    .hero-courses {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.5rem 0 2rem;
    }

    .courses-breadcrumb {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }
    .courses-breadcrumb a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.15s;
    }
    .courses-breadcrumb a:hover {
        color: #6d28d9;
    }

    .courses-hero-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        line-height: 1.15;
        color: #0f172a;
    }

    .courses-count-pill {
        font-size: 0.88rem;
        font-weight: 600;
        color: #475569;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 0.4rem 0.95rem;
        border-radius: 999px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Dual Floating Search Box */
    .courses-search-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
        padding: 0.3rem 0.45rem;
        max-width: 680px;
        transition: all 0.2s ease;
    }
    .courses-search-card:focus-within {
        border-color: #7c3aed;
        box-shadow: 0 12px 30px -4px rgba(124, 58, 237, 0.18), 0 0 0 3px rgba(124, 58, 237, 0.12);
    }

    .courses-search-input {
        border: none;
        outline: none;
        font-size: 0.875rem;
        padding: 0.65rem 0.85rem;
        color: #1e293b;
        background: transparent;
    }
    .courses-search-input::placeholder {
        color: #94a3b8;
    }

    .courses-cat-select {
        border: none;
        border-left: 1px solid #e2e8f0;
        outline: none;
        font-size: 0.85rem;
        padding: 0.65rem 0.85rem;
        color: #334155;
        background: transparent;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-courses-search {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.65rem 1.6rem;
        border-radius: 999px;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        box-shadow: 0 4px 14px rgba(109, 40, 217, 0.3);
    }
    .btn-courses-search:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #6d28d9 100%);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(109, 40, 217, 0.4);
    }

    /* Popular Searches Pills */
    .popular-course-pills {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.85rem;
        font-size: 0.75rem;
    }
    .popular-course-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.25rem 0.75rem;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s;
    }
    .popular-course-pill:hover {
        border-color: #7c3aed;
        color: #6d28d9;
        background: #f5f3ff;
    }

    /* ==========================================================================
       CATEGORY HORIZONTAL BAR
       ========================================================================== */
    .course-category-bar {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.75rem 0;
    }
    .course-cat-scroll-container {
        display: flex;
        gap: 0.45rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        padding-bottom: 4px;
    }
    .course-cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.85rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        color: #475569;
        text-decoration: none;
        font-size: 0.78rem;
        font-weight: 600;
        background: #ffffff;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }
    .course-cat-pill:hover {
        background: #f8fafc;
        border-color: #7c3aed;
        color: #6d28d9;
    }
    .course-cat-pill.active {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
        border-color: #6d28d9;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.25);
    }
    .course-cat-pill.active i {
        color: #ffffff;
    }

    /* ==========================================================================
       MAIN MARKETPLACE SECTION & SIDEBAR FILTERS
       ========================================================================== */
    .courses-main-section {
        background: #f8fafc;
        padding: 1.75rem 0 4rem;
    }

    .courses-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.15rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    .filter-sec-box {
        margin-bottom: 1.35rem;
        padding-bottom: 1.15rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .filter-sec-box:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .filter-sec-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .course-filter-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.4rem;
        cursor: pointer;
        user-select: none;
    }
    .course-filter-option label {
        cursor: pointer;
        margin-bottom: 0;
        color: #475569;
        font-size: 0.8rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .course-filter-option input[type="radio"],
    .course-filter-option input[type="checkbox"] {
        accent-color: #6d28d9;
        cursor: pointer;
    }
    .course-filter-option:hover label {
        color: #0f172a;
    }
    .course-filter-count {
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* ==========================================================================
       COURSE CARD (MATCHING SCREENSHOT WITH LUXURY THEME)
       ========================================================================== */
    .course-card-unified {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .course-card-unified:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 32px -6px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(109, 40, 217, 0.25);
        border-color: rgba(109, 40, 217, 0.3);
    }

    .course-thumb-box {
        position: relative;
        width: 100%;
        height: 165px;
        background: #0f172a;
        overflow: hidden;
    }
    .course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .course-card-unified:hover .course-thumb-box img {
        transform: scale(1.06);
    }

    .badge-course-featured {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        color: #0284c7;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        border: 1px solid rgba(224, 242, 254, 0.8);
        z-index: 2;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .btn-course-heart {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn-course-heart:hover {
        background: #ffffff;
        transform: scale(1.15);
    }

    .course-card-content {
        padding: 0.95rem 1rem 1.05rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .course-card-heading {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.45rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.7em;
    }
    .course-card-heading a {
        color: #0f172a;
        text-decoration: none;
        transition: color 0.15s;
    }
    .course-card-heading a:hover {
        color: #6d28d9;
    }

    .course-instructor-row {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.55rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .course-instructor-row i {
        color: #8b5cf6;
    }

    .course-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.45rem;
        margin-bottom: 0.75rem;
    }
    .price-current {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }
    .price-mrp {
        font-size: 0.78rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .badge-discount-orange {
        font-size: 0.68rem;
        font-weight: 700;
        color: #ea580c;
        background: #fff7ed;
        border: 1px solid #ffedd5;
        padding: 0.12rem 0.45rem;
        border-radius: 4px;
    }

    /* Luxury Add to Cart Button (Spans full width, no green, no plain blue) */
    .btn-cart-luxury {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.25);
        cursor: pointer;
        width: 100%;
        text-decoration: none;
    }
    .btn-cart-luxury:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #6d28d9 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(109, 40, 217, 0.4);
    }
    .btn-cart-luxury:active {
        transform: translateY(0);
    }

    /* Pagination Styles */
    .pagination {
        gap: 0.35rem;
    }
    .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-weight: 600;
        padding: 0.5rem 0.85rem;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .page-item .page-link:hover {
        background: #f5f3ff;
        border-color: #c4b5fd;
        color: #6d28d9;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
        border-color: #6d28d9;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(109, 40, 217, 0.3);
    }
</style>
@endsection

@section('content')

<!-- ============================================================================
     1. HERO SECTION WITH SEARCH & HEADER
     ============================================================================ -->
<div class="hero-courses">
    <div class="container-fluid px-lg-4">
        
        <!-- Breadcrumb -->
        <nav class="courses-breadcrumb">
            <a href="{{ route('home') }}">Home</a> &gt; 
            <span class="text-dark fw-semibold">Courses</span>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-7 col-xl-8 mb-3 mb-lg-0">
                <h1 class="courses-hero-title mb-2">Courses for you</h1>
                <p class="text-muted small mb-3" style="max-width: 620px;">
                    Explore 1,084 authentic courses taught by expert educators with verified certificates and hands-on projects.
                </p>

                <!-- Dual Search Box -->
                <form action="{{ route('courses') }}" method="GET" class="courses-search-card d-flex align-items-center">
                    <div class="d-flex align-items-center flex-grow-1 px-2">
                        <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                        <input type="text" name="search" value="{{ $searchQuery }}" class="courses-search-input flex-grow-1" placeholder="Search by course name, topic, or keyword...">
                    </div>

                    <div class="d-flex align-items-center">
                        <select name="category" class="courses-cat-select" onchange="this.form.submit()">
                            <option value="All Courses" {{ ($selectedCategory === 'All Courses' || !$selectedCategory) ? 'selected' : '' }}>All Categories</option>
                            @foreach($sidebarCategories as $sc)
                                <option value="{{ $sc['name'] }}" {{ $selectedCategory === $sc['name'] ? 'selected' : '' }}>{{ $sc['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-courses-search ms-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </form>

                <!-- Popular Searches Pills -->
                <div class="popular-course-pills">
                    <span class="text-muted fw-bold me-1">Popular:</span>
                    <a href="{{ route('courses', ['search' => 'Shopify']) }}" class="popular-course-pill">Shopify</a>
                    <a href="{{ route('courses', ['search' => 'Python']) }}" class="popular-course-pill">Python</a>
                    <a href="{{ route('courses', ['search' => 'Java']) }}" class="popular-course-pill">Java</a>
                    <a href="{{ route('courses', ['category' => 'Accounts & Finance']) }}" class="popular-course-pill">Accounts & Finance</a>
                    <a href="{{ route('courses', ['category' => 'Digital Marketing']) }}" class="popular-course-pill">Digital Marketing</a>
                    <a href="{{ route('courses', ['category' => 'IT & Software Development']) }}" class="popular-course-pill">IT & Software</a>
                    <a href="{{ route('courses', ['price_type' => 'free']) }}" class="popular-course-pill">Free Courses</a>
                </div>
            </div>

            <div class="col-lg-5 col-xl-4 text-lg-end">
                <div class="courses-count-pill">
                    <i class="fa-solid fa-graduation-cap text-primary"></i>
                    <span>Showing <strong>{{ $courses instanceof \Illuminate\Pagination\LengthAwarePaginator ? number_format($courses->total()) : count($courses) }}</strong> result</span>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ============================================================================
     2. HORIZONTAL CATEGORY SCROLL BAR
     ============================================================================ -->
<div class="course-category-bar">
    <div class="container-fluid px-lg-4">
        <div class="course-cat-scroll-container no-scrollbar">
            @foreach($horizontalCategories as $hc)
                @php
                    $isHcActive = ($selectedCategory === $hc['name'] || ($selectedCategory === 'All Courses' && $hc['name'] === 'All Courses') || ($selectedCategory === $hc['slug']));
                    $hcParam = ($hc['name'] === 'All Courses' || $hc['slug'] === 'all') ? '' : $hc['slug'];
                    $hcQuery = array_merge(request()->query(), ['category' => $hcParam]);
                    if (empty($hcParam)) unset($hcQuery['category']);
                    $hcUrl = route('courses', $hcQuery);
                @endphp
                <a href="{{ $hcUrl }}" class="course-cat-pill {{ $isHcActive ? 'active' : '' }}">
                    <i class="{{ $hc['icon'] }}"></i>
                    <span>{{ $hc['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- ============================================================================
     3. TWO-COLUMN MAIN MARKETPLACE SECTION
     ============================================================================ -->
<div class="courses-main-section">
    <div class="container-fluid px-lg-4">
        <div class="row g-4">
            
            <!-- ==========================================
                 LEFT SIDEBAR: WORKABLE FILTERS
                 ========================================== -->
            <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
                <form id="coursesFilterForm" action="{{ route('courses') }}" method="GET" class="courses-filter-card">
                    @if($searchQuery)
                        <input type="hidden" name="search" value="{{ $searchQuery }}">
                    @endif
                    <input type="hidden" name="sort" id="coursesSortInput" value="{{ $sortBy }}">
                    
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-sliders me-1" style="color: #6d28d9;"></i> Filters
                        </div>
                        <a href="{{ route('courses') }}" class="text-decoration-none small fw-semibold" style="color: #6d28d9;">Reset All</a>
                    </div>

                    <!-- 1. CATEGORY FILTER -->
                    <div class="filter-sec-box">
                        <div class="filter-sec-title">
                            <span>Category</span>
                        </div>
                        <div id="courseCatContainer">
                            <div class="course-filter-option">
                                <label for="cat_all">
                                    <input type="radio" name="category" value="" id="cat_all"
                                           {{ ($selectedCategory === 'All Courses' || !$selectedCategory) ? 'checked' : '' }}
                                           onchange="document.getElementById('coursesFilterForm').submit()">
                                    <span>All Categories</span>
                                </label>
                                <span class="course-filter-count">({{ $courses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $courses->total() : 1084 }})</span>
                            </div>

                            @foreach($sidebarCategories as $index => $sc)
                                <div class="course-filter-option {{ $index >= 6 ? 'more-cat-item d-none' : '' }}">
                                    <label for="cat_{{ Str::slug($sc['name']) }}">
                                        <input type="radio" name="category" value="{{ $sc['name'] }}" id="cat_{{ Str::slug($sc['name']) }}"
                                               {{ $selectedCategory === $sc['name'] ? 'checked' : '' }}
                                               onchange="document.getElementById('coursesFilterForm').submit()">
                                        <span>{{ Str::limit($sc['name'], 20) }}</span>
                                    </label>
                                    <span class="course-filter-count">({{ $sc['count'] }})</span>
                                </div>
                            @endforeach
                        </div>
                        @if(count($sidebarCategories) > 6)
                            <a href="javascript:void(0)" onclick="toggleMoreCategories(this)" class="d-inline-block small fw-bold text-decoration-none mt-2" style="color: #6d28d9;">
                                See more ▾
                            </a>
                        @endif
                    </div>

                    <!-- 2. PRICING FILTER (FREE / PAID) -->
                    <div class="filter-sec-box">
                        <div class="filter-sec-title">
                            <span>Pricing</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="price_all">
                                <input type="radio" name="price_type" value="all" id="price_all"
                                       {{ ($selectedPriceType === 'all' || !$selectedPriceType) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>All Courses</span>
                            </label>
                            <span class="course-filter-count">({{ ($paidCount ?? 1066) + ($freeCount ?? 18) }})</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="price_paid">
                                <input type="radio" name="price_type" value="paid" id="price_paid"
                                       {{ $selectedPriceType === 'paid' ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>Paid</span>
                            </label>
                            <span class="course-filter-count">({{ $paidCount ?? 1066 }})</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="price_free">
                                <input type="radio" name="price_type" value="free" id="price_free"
                                       {{ $selectedPriceType === 'free' ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>Free</span>
                            </label>
                            <span class="course-filter-count">({{ $freeCount ?? 18 }})</span>
                        </div>
                    </div>

                    <!-- 3. CERTIFICATION FILTER -->
                    <div class="filter-sec-box">
                        <div class="filter-sec-title">
                            <span>Certification</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="cert_all">
                                <input type="radio" name="certification" value="" id="cert_all"
                                       {{ (!$selectedCertification) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>All</span>
                            </label>
                            <span class="course-filter-count">({{ ($certYesCount ?? 306) + ($certNoCount ?? 765) }})</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="cert_yes">
                                <input type="radio" name="certification" value="yes" id="cert_yes"
                                       {{ $selectedCertification === 'yes' ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>Yes</span>
                            </label>
                            <span class="course-filter-count">({{ $certYesCount ?? 306 }})</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="cert_no">
                                <input type="radio" name="certification" value="no" id="cert_no"
                                       {{ $selectedCertification === 'no' ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>No</span>
                            </label>
                            <span class="course-filter-count">({{ $certNoCount ?? 765 }})</span>
                        </div>
                    </div>

                    <!-- 4. DISCOUNT FILTER -->
                    <div class="filter-sec-box">
                        <div class="filter-sec-title">
                            <span>Discount</span>
                        </div>
                        <div class="course-filter-option">
                            <label for="disc_all">
                                <input type="radio" name="discount" value="" id="disc_all"
                                       {{ (!$selectedDiscount) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>All</span>
                            </label>
                        </div>
                        <div class="course-filter-option">
                            <label for="disc_30">
                                <input type="radio" name="discount" value="30" id="disc_30"
                                       {{ $selectedDiscount === '30' ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>30% or More</span>
                            </label>
                        </div>
                        <div class="course-filter-option">
                            <label for="disc_50">
                                <input type="radio" name="discount" value="50" id="disc_50"
                                       {{ $selectedDiscount === '50' ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <span>50% or More</span>
                            </label>
                        </div>
                    </div>

                </form>
            </div>

            <!-- ==========================================
                 RIGHT COLUMN: COURSES GRID (MATCHING DESIGN)
                 ========================================== -->
            <div class="col-xl-9 col-lg-9 col-md-8 col-12">
                
                <!-- Top Results & Sort Header -->
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h2 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">
                            Courses for you
                        </h2>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1 small text-muted">
                            <span>Sort by:</span>
                            <select class="form-select form-select-sm" style="font-size: 0.78rem; width: auto;" onchange="submitCoursesSort(this.value)">
                                <option value="popular" {{ $sortBy === 'popular' ? 'selected' : '' }}>Featured</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Recently Added</option>
                                <option value="price_low" {{ $sortBy === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ $sortBy === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Responsive Cards Grid (3 cards per row on desktop, matching screenshot) -->
                <div class="row g-3">
                    @forelse($courses as $c)
                        @php
                            $sellPrice = (float)($c->price ?? 0);
                            $mrpPrice = (float)($c->original_price ?? 0);
                            if ($mrpPrice == 0 && isset($c->course_price) && (float)$c->course_price > $sellPrice) {
                                $mrpPrice = (float)$c->course_price;
                            }
                            $discText = $c->discount_text ?? $c->discount_percentage ?? '';
                            if (empty($discText) && $mrpPrice > $sellPrice && $sellPrice > 0) {
                                $discText = round((($mrpPrice - $sellPrice) / $mrpPrice) * 100) . '% off';
                            }
                            $courseUrl = !empty($c->url) ? $c->url : route('course.show', $c->slug);
                        @endphp
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="course-card-unified">
                                
                                <!-- Thumbnail Box -->
                                <div class="course-thumb-box">
                                    <a href="{{ $courseUrl }}">
                                        <img src="{{ $c->thumbnail_url ?: ($c->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80') }}"
                                             alt="{{ $c->title }}"
                                             loading="lazy"
                                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';">
                                    </a>
                                    
                                    <span class="badge-course-featured">Featured</span>

                                    <button type="button" class="btn-course-heart" onclick="toggleCourseHeart(this, '{{ addslashes($c->title) }}')" title="Save course">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>

                                <!-- Card Body -->
                                <div class="course-card-content">
                                    <h4 class="course-card-heading" title="{{ $c->title }}">
                                        <a href="{{ $courseUrl }}">
                                            {{ $c->title }}
                                        </a>
                                    </h4>

                                    <!-- Instructor / Tutor Name -->
                                    <div class="course-instructor-row" title="{{ $c->instructor_name }}">
                                        <i class="fa-regular fa-user me-1"></i> {{ $c->instructor_name }}
                                    </div>

                                    <!-- Price Row -->
                                    <div class="course-price-row mt-auto">
                                        @if($sellPrice > 0)
                                            <span class="price-current">₹ {{ number_format($sellPrice) }}</span>
                                            @if($mrpPrice > $sellPrice)
                                                <span class="price-mrp">₹ {{ number_format($mrpPrice) }}</span>
                                                <span class="badge-discount-orange">{{ $discText ?: '50% off' }}</span>
                                            @endif
                                        @else
                                            <span class="price-current text-success">Free</span>
                                            <span class="badge-discount-orange">Free</span>
                                        @endif
                                    </div>

                                    <!-- Luxury Add To Cart Button -->
                                    <button type="button" class="btn-cart-luxury"
                                            onclick="addToCart({ id: '{{ $c->id }}', type: 'Course', title: '{{ addslashes($c->title) }}', price: {{ (float)$sellPrice }}, thumbnail: '{{ $c->thumbnail_url ?: ($c->thumbnail ?: '') }}', seller_id: {{ $c->seller_id ?? 1 }} })">
                                        <i class="fa-solid fa-cart-shopping me-1"></i> Add To Cart
                                    </button>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-graduation-cap fs-1 text-muted mb-3"></i>
                            <h5 class="fw-bold text-dark">No courses found matching your criteria</h5>
                            <p class="text-muted small">Try selecting another category or resetting the filters.</p>
                            <a href="{{ route('courses') }}" class="btn btn-sm text-white px-4 py-2 rounded-pill fw-bold" style="background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);">
                                Reset All Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Real Pagination for 1,084 Courses -->
                @if($courses instanceof \Illuminate\Pagination\LengthAwarePaginator && $courses->hasPages())
                    <div class="d-flex justify-content-center mt-5 mb-4">
                        {{ $courses->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

<!-- JavaScript Logic -->
<script>
    function submitCoursesSort(val) {
        const sortInput = document.getElementById('coursesSortInput');
        if (sortInput) sortInput.value = val;
        const form = document.getElementById('coursesFilterForm');
        if (form) form.submit();
    }

    function toggleMoreCategories(btn) {
        const moreItems = document.querySelectorAll('.more-cat-item');
        let isOpening = false;
        moreItems.forEach(item => {
            if (item.classList.contains('d-none')) {
                item.classList.remove('d-none');
                isOpening = true;
            } else {
                item.classList.add('d-none');
            }
        });
        btn.innerText = isOpening ? 'See less ▴' : 'See more ▾';
    }

    function toggleCourseHeart(btn, title) {
        btn.classList.toggle('active');
        const icon = btn.querySelector('i');
        if (btn.classList.contains('active')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            showToast('Saved!', title + ' added to your wishlist.');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            showToast('Removed', title + ' removed from wishlist.');
        }
    }

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
