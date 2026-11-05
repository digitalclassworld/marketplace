
@extends('layouts.app')

@section('title', 'All Courses - Learn In-Demand Skills on Digital Class')

@section('styles')
<style>
    /* ==========================================================================
       HERO SECTION WITH STUDENT LEARNING BANNER
       ========================================================================== */
    .hero-courses {
        position: relative;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.92) 45%, rgba(255, 255, 255, 0.45) 75%, rgba(255, 255, 255, 0.1) 100%),
                    url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1600&auto=format&fit=crop&q=80') center right / cover no-repeat;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.5rem 0 2rem;
        overflow: hidden;
    }

    .courses-breadcrumb {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }
    .courses-breadcrumb a {
        color: #64748b;
        text-decoration: none;
    }
    .courses-breadcrumb a:hover {
        color: #0066ff;
    }

    .courses-hero-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        line-height: 1.15;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }

    .courses-hero-subtitle {
        font-size: 0.85rem;
        color: #475569;
        max-width: 620px;
        line-height: 1.45;
        margin-bottom: 1.25rem;
    }

    /* Dual Floating Search Box */
    .courses-search-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        padding: 0.35rem;
        max-width: 650px;
    }

    .courses-search-input {
        border: none;
        outline: none;
        font-size: 0.875rem;
        padding: 0.55rem 0.75rem;
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
        padding: 0.55rem 0.75rem;
        color: #334155;
        background: transparent;
        font-weight: 600;
    }

    .btn-courses-search {
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
    .btn-courses-search:hover {
        background-color: #0052cc;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .popular-course-pills {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.85rem;
        font-size: 0.72rem;
    }

    .popular-course-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.2rem 0.65rem;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s;
    }
    .popular-course-pill:hover {
        border-color: #0066ff;
        color: #0066ff;
        background: #eff6ff;
    }

    /* Hero Right Trust Elements */
    .hero-trust-column {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 16px;
        padding: 1.15rem 1.25rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .slogan-chalk-text {
        font-family: 'Outfit', cursive, sans-serif;
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e3a8a;
        line-height: 1.2;
    }

    .trust-bullet-row {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .trust-bullet-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    /* ==========================================================================
       CATEGORY HORIZONTAL BAR
       ========================================================================== */
    .course-category-bar {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.75rem 0;
        position: relative;
    }

    .course-cat-scroll-container {
        display: flex;
        gap: 0.45rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        padding-bottom: 4px;
    }
    .course-cat-scroll-container::-webkit-scrollbar {
        height: 4px;
    }
    .course-cat-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
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
        font-size: 0.75rem;
        font-weight: 600;
        background: #ffffff;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }
    .course-cat-pill i {
        font-size: 0.85rem;
        color: #64748b;
    }
    .course-cat-pill:hover {
        background: #f8fafc;
        border-color: #0066ff;
        color: #0066ff;
    }
    .course-cat-pill:hover i {
        color: #0066ff;
    }
    .course-cat-pill.active {
        background: #0066ff;
        border-color: #0066ff;
        color: #ffffff;
    }
    .course-cat-pill.active i {
        color: #ffffff;
    }

    /* ==========================================================================
       2-COLUMN MAIN CONTENT & CARDS GRID
       ========================================================================== */
    .courses-main-section {
        background: #f8fafc;
        padding: 1.5rem 0 3.5rem;
    }

    .courses-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        font-size: 0.8125rem;
    }

    .filter-sec-header {
        font-size: 0.8rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.55rem;
    }

    .course-check-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.35rem;
        cursor: pointer;
        user-select: none;
    }
    .course-check-item label {
        cursor: pointer;
        margin-bottom: 0;
        color: #475569;
        font-size: 0.78rem;
    }
    .course-check-count {
        color: #94a3b8;
        font-size: 0.72rem;
    }

    /* 5-Column Course Card */
    .course-card-unified {
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
    .course-card-unified:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .course-thumb-box {
        position: relative;
        width: 100%;
        height: 130px;
        background: #0f172a;
        overflow: hidden;
    }
    .course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.25s ease;
    }
    .course-card-unified:hover .course-thumb-box img {
        transform: scale(1.04);
    }

    .badge-course-bestseller {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #f59e0b;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        z-index: 2;
    }

    .btn-course-heart {
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
    .btn-course-heart:hover {
        background: #ffffff;
        transform: scale(1.15);
    }
    .btn-course-heart.active i {
        font-weight: 900;
    }

    .duration-pill-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 0.62rem;
        font-weight: 600;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }

    .course-card-content {
        padding: 0.75rem 0.85rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .course-card-heading {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.35rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.6em;
    }
    .course-card-heading a {
        color: #0f172a;
        text-decoration: none;
    }
    .course-card-heading a:hover {
        color: #0066ff;
    }

    .course-rating-metric {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.72rem;
        margin-bottom: 0.45rem;
    }

    .course-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.4rem;
        margin-bottom: 0.65rem;
    }
    .price-current {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
    }
    .price-mrp {
        font-size: 0.72rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .badge-discount-green {
        font-size: 0.62rem;
        font-weight: 700;
        color: #059669;
        background: #ecfdf5;
        padding: 0.12rem 0.4rem;
        border-radius: 4px;
    }

    .course-instructor-footer {
        padding-top: 0.55rem;
        border-top: 1px solid #f1f5f9;
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }
    .instructor-avatar-xs {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .instructor-name-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.15;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .instructor-cat-label {
        font-size: 0.65rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection

@section('content')

<!-- ============================================================================
     1. HERO SECTION WITH HEADPHONES STUDENT & SEARCH
     ============================================================================ -->
<div class="hero-courses">
    <div class="container-fluid px-lg-4">
        
        <!-- Breadcrumb -->
        <nav class="courses-breadcrumb">
            <a href="{{ route('home') }}">Home</a> &gt; 
            <span class="text-dark fw-semibold">Courses</span>
        </nav>

        <div class="row align-items-center">
            
            <!-- Left Hero Content -->
            <div class="col-lg-7 col-xl-8 mb-4 mb-lg-0">
                <h1 class="courses-hero-title">All Courses</h1>
                
                <p class="courses-hero-subtitle">
                    Learn new skills from expert educators. Explore 10,000+ online and offline courses to grow your career, business and knowledge.
                </p>

                <!-- Dual Search Box -->
                <form action="{{ route('courses') }}" method="GET" class="courses-search-card d-flex align-items-center">
                    <div class="d-flex align-items-center flex-grow-1 px-2">
                        <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                        <input type="text" name="search" value="{{ $searchQuery }}" class="courses-search-input flex-grow-1" placeholder="What do you want to learn?">
                    </div>

                    <div class="d-flex align-items-center">
                        <select name="category" class="courses-cat-select" onchange="this.form.submit()">
                            <option value="All Categories" {{ $selectedCategory === 'All Categories' ? 'selected' : '' }}>All Categories</option>
                            <option value="Computer & IT" {{ $selectedCategory === 'Computer & IT' ? 'selected' : '' }}>Computer & IT</option>
                            <option value="Digital Marketing" {{ $selectedCategory === 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                            <option value="Programming" {{ $selectedCategory === 'Programming' ? 'selected' : '' }}>Programming</option>
                            <option value="Design & Creative" {{ $selectedCategory === 'Design & Creative' ? 'selected' : '' }}>Design & Creative</option>
                            <option value="Business & Finance" {{ $selectedCategory === 'Business & Finance' ? 'selected' : '' }}>Business & Finance</option>
                            <option value="Office Productivity" {{ $selectedCategory === 'Office Productivity' ? 'selected' : '' }}>Office Productivity</option>
                            <option value="Spoken English" {{ $selectedCategory === 'Spoken English' ? 'selected' : '' }}>Spoken English</option>
                            <option value="AI & Tools" {{ $selectedCategory === 'AI & Tools' ? 'selected' : '' }}>AI & Tools</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-courses-search ms-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </form>

                <!-- Popular Searches Pills -->
                <div class="popular-course-pills">
                    <span class="text-muted fw-bold me-1">Popular Searches:</span>
                    <a href="{{ route('courses', ['category' => 'Digital Marketing']) }}" class="popular-course-pill">Digital Marketing</a>
                    <a href="{{ route('courses', ['search' => 'Tally']) }}" class="popular-course-pill">Tally</a>
                    <a href="{{ route('courses', ['search' => 'Python']) }}" class="popular-course-pill">Python</a>
                    <a href="{{ route('courses', ['category' => 'Programming']) }}" class="popular-course-pill">Web Development</a>
                    <a href="{{ route('courses', ['category' => 'Design & Creative']) }}" class="popular-course-pill">Graphic Design</a>
                    <a href="{{ route('courses', ['category' => 'Spoken English']) }}" class="popular-course-pill">Spoken English</a>
                    <a href="{{ route('courses', ['search' => 'MS Office']) }}" class="popular-course-pill">MS Office</a>
                    <a href="{{ route('courses', ['search' => 'Data Science']) }}" class="popular-course-pill">Data Science</a>
                </div>
            </div>

            <!-- Right Hero Trust Column -->
            <div class="col-lg-5 col-xl-4">
                <div class="hero-trust-column">
                    <div class="slogan-chalk-text">
                        Learn &bull; Upgrade &bull; <span style="color: #0066ff;">Grow</span>
                    </div>

                    <div class="trust-bullet-row">
                        <div class="trust-bullet-icon bg-primary-subtle text-primary">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.78rem;">Learn from Experts</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Certified Industry Professionals</div>
                        </div>
                    </div>

                    <div class="trust-bullet-row">
                        <div class="trust-bullet-icon bg-warning-subtle text-warning">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.78rem;">Get Certified</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Boost Your Resume & Career</div>
                        </div>
                    </div>

                    <div class="trust-bullet-row">
                        <div class="trust-bullet-icon bg-success-subtle text-success">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.78rem;">Online & Offline</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Flexible Hybrid Learning Options</div>
                        </div>
                    </div>

                    <div class="trust-bullet-row">
                        <div class="trust-bullet-icon bg-info-subtle text-info">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.78rem;">Learn at Your Pace</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Lifetime Access & Practical Projects</div>
                        </div>
                    </div>
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
        <div class="course-cat-scroll-container">
            @foreach($horizontalCategories as $hc)
                @php
                    $isHcActive = ($selectedCategory === $hc['name'] || ($selectedCategory === 'All Categories' && $hc['name'] === 'All Categories') || ($selectedCategory === $hc['slug']));
                    $hcParam = ($hc['name'] === 'All Categories' || $hc['slug'] === 'all') ? '' : $hc['slug'];
                    $hcQuery = array_merge(request()->query(), ['category' => $hcParam]);
                    if (empty($hcParam)) unset($hcQuery['category']);
                    $hcUrl = route('courses', $hcQuery);
                @endphp
                <a href="{{ $hcUrl }}"
                   class="course-cat-pill {{ $isHcActive ? 'active' : '' }}">
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
        <div class="row g-3">
            
            <!-- ==========================================
                 LEFT SIDEBAR: FILTERS
                 ========================================== -->
            <div class="col-xl-2 col-lg-3 col-md-4">
                <form id="coursesFilterForm" action="{{ route('courses') }}" method="GET" class="courses-filter-card">
                    @if($searchQuery)
                        <input type="hidden" name="search" value="{{ $searchQuery }}">
                    @endif
                    <input type="hidden" name="sort" id="coursesSortInput" value="{{ $sortBy }}">
                    
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-sliders me-1 text-primary"></i> Filters
                        </div>
                        <a href="{{ route('courses') }}" class="text-decoration-none small text-primary fw-semibold">Clear All</a>
                    </div>

                    <!-- Filter Search -->
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Search in filters..." onkeyup="filterCheckboxes(this.value)">
                    </div>

                    <!-- Category Checkboxes -->
                    <div class="mb-3">
                        <div class="filter-sec-header">Category</div>
                        <div id="courseCatContainer">
                            <div class="course-check-item">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="" id="ccat_all"
                                           {{ ($selectedCategory === 'All Categories' || !$selectedCategory) ? 'checked' : '' }}
                                           onchange="document.getElementById('coursesFilterForm').submit()">
                                    <label class="form-check-label" for="ccat_all">
                                        All Categories
                                    </label>
                                </div>
                            </div>
                            @foreach($sidebarCategories as $sc)
                                <div class="course-check-item">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="category" value="{{ $sc['name'] }}" id="cat_{{ Str::slug($sc['name']) }}"
                                               {{ $selectedCategory === $sc['name'] ? 'checked' : '' }}
                                               onchange="document.getElementById('coursesFilterForm').submit()">
                                        <label class="form-check-label" for="cat_{{ Str::slug($sc['name']) }}">
                                            {{ $sc['name'] }}
                                        </label>
                                    </div>
                                    <span class="course-check-count">({{ $sc['count'] }})</span>
                                </div>
                            @endforeach
                            <div class="course-check-item more-course-cat d-none">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="Spoken English" id="cat_spoken"
                                           {{ $selectedCategory === 'Spoken English' ? 'checked' : '' }}
                                           onchange="document.getElementById('coursesFilterForm').submit()">
                                    <label class="form-check-label" for="cat_spoken">Spoken English</label>
                                </div>
                                <span class="course-check-count">(890)</span>
                            </div>
                            <div class="course-check-item more-course-cat d-none">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="AI & Tools" id="cat_ai"
                                           {{ $selectedCategory === 'AI & Tools' ? 'checked' : '' }}
                                           onchange="document.getElementById('coursesFilterForm').submit()">
                                    <label class="form-check-label" for="cat_ai">AI & Tools</label>
                                </div>
                                <span class="course-check-count">(740)</span>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="toggleMoreCourseCats(this)" class="d-inline-block small text-primary text-decoration-none mt-1">Show More ▾</a>
                    </div>

                    <!-- Learning Mode -->
                    <div class="mb-3">
                        <div class="filter-sec-header">Learning Mode</div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="mode[]" value="online" id="mode_online"
                                       {{ in_array('online', (array)$selectedMode) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="mode_online">Online</label>
                            </div>
                            <span class="course-check-count">(7,360)</span>
                        </div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="mode[]" value="offline" id="mode_offline"
                                       {{ in_array('offline', (array)$selectedMode) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="mode_offline">Offline</label>
                            </div>
                            <span class="course-check-count">(2,140)</span>
                        </div>
                    </div>

                    <!-- Price Range Slider -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between filter-sec-header">
                            <span>Price Range</span>
                            <span class="small text-muted" id="priceDisplay">₹0 - ₹{{ number_format($maxPrice ?? 50000) }}</span>
                        </div>
                        <input type="range" class="form-range" min="0" max="50000" step="500" value="{{ $maxPrice ?? 50000 }}" id="priceRangeInput" oninput="updatePrice(this.value)" onchange="document.getElementById('coursesFilterForm').submit()">
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <input type="number" class="form-control form-control-sm text-center" value="0" readonly style="font-size: 0.72rem;">
                            <span class="text-muted small">to</span>
                            <input type="number" name="max_price" class="form-control form-control-sm text-center" id="priceInputMax" value="{{ $maxPrice ?? 50000 }}" style="font-size: 0.72rem;" onchange="document.getElementById('coursesFilterForm').submit()">
                        </div>
                    </div>

                    <!-- Course Level -->
                    <div class="mb-3">
                        <div class="filter-sec-header">Course Level</div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="level[]" value="Beginner" id="lvl_beg"
                                       {{ in_array('Beginner', (array)$selectedLevel) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="lvl_beg">Beginner</label>
                            </div>
                            <span class="course-check-count">(4,120)</span>
                        </div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="level[]" value="Intermediate" id="lvl_int"
                                       {{ in_array('Intermediate', (array)$selectedLevel) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="lvl_int">Intermediate</label>
                            </div>
                            <span class="course-check-count">(3,250)</span>
                        </div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="level[]" value="Advanced" id="lvl_adv"
                                       {{ in_array('Advanced', (array)$selectedLevel) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="lvl_adv">Advanced</label>
                            </div>
                            <span class="course-check-count">(1,980)</span>
                        </div>
                    </div>

                    <!-- Language -->
                    <div>
                        <div class="filter-sec-header">Language</div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="language[]" value="English" id="lang_en"
                                       {{ in_array('English', (array)$selectedLanguage) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="lang_en">English</label>
                            </div>
                            <span class="course-check-count">(5,840)</span>
                        </div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="language[]" value="Hindi" id="lang_hi"
                                       {{ in_array('Hindi', (array)$selectedLanguage) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="lang_hi">Hindi</label>
                            </div>
                            <span class="course-check-count">(2,360)</span>
                        </div>
                        <div class="course-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="language[]" value="Gujarati" id="lang_gu"
                                       {{ in_array('Gujarati', (array)$selectedLanguage) ? 'checked' : '' }}
                                       onchange="document.getElementById('coursesFilterForm').submit()">
                                <label class="form-check-label" for="lang_gu">Gujarati</label>
                            </div>
                            <span class="course-check-count">(780)</span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- ==========================================
                 RIGHT COLUMN: COURSES GRID (5 COLS ON XL)
                 ========================================== -->
            <div class="col-xl-10 col-lg-9 col-md-8">
                
                <!-- Results Bar -->
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h2 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">
                            {{ number_format(count($courses)) }}+ Courses
                        </h2>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Sort by -->
                        <div class="d-flex align-items-center gap-1 small text-muted">
                            <span>Sort by:</span>
                            <select class="form-select form-select-sm" style="font-size: 0.75rem; width: auto;" onchange="submitCoursesSort(this.value)">
                                <option value="popular" {{ $sortBy === 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Recently Added</option>
                                <option value="price_low" {{ $sortBy === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ $sortBy === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                                <option value="popular" {{ $sortBy === 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Recently Added</option>
                                <option value="price_low" {{ $sortBy === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ $sortBy === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>

                        <!-- Grid / List Switcher -->
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-primary btn-sm px-2" title="Grid View">
                                <i class="fa-solid fa-table-cells"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm px-2" title="List View" onclick="alert('List view toggled.')">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div>

                        <!-- Page Indicator & Arrows -->
                        <span class="small text-muted" style="font-size: 0.75rem;">1 of 417 pages</span>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-light border btn-sm py-1 px-2" title="Previous"><i class="fa-solid fa-chevron-left" style="font-size: 0.7rem;"></i></button>
                            <button class="btn btn-light border btn-sm py-1 px-2" title="Next"><i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i></button>
                        </div>
                    </div>
                </div>

                <!-- 5-Column Responsive Cards Grid -->
                <div class="row g-3">
                    @forelse($courses as $c)
                        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6" style="flex: 0 0 20%; max-width: 20%;">
                            <div class="course-card-unified">
                                
                                <!-- Thumbnail Box -->
                                <div class="course-thumb-box">
                                    <a href="{{ route('course.show', $c->slug) }}">
                                        <img src="{{ $c->thumbnail }}" alt="{{ $c->title }}" loading="lazy">
                                    </a>
                                    
                                    @if($c->badge === 'Bestseller')
                                        <span class="badge-course-bestseller">Bestseller</span>
                                    @endif

                                    <button type="button" class="btn-course-heart" onclick="toggleCourseHeart(this, '{{ addslashes($c->title) }}')" title="Save course">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>

                                    <div class="duration-pill-badge">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $c->duration }}
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="course-card-content">
                                    <h4 class="course-card-heading" title="{{ $c->title }}">
                                        <a href="{{ route('course.show', $c->slug) }}">
                                            {{ $c->title }}
                                        </a>
                                    </h4>

                                    <!-- Rating & Students -->
                                    <div class="course-rating-row">
                                        <span class="text-warning fw-bold small">
                                            <i class="fa-solid fa-star"></i> {{ number_format($c->rating, 1) }}
                                        </span>
                                        <span class="text-muted" style="font-size: 0.68rem;">({{ $c->reviews_count }})</span>
                                        <span class="text-muted" style="font-size: 0.65rem;">&bull; {{ $c->students_count }}</span>
                                    </div>

                                    <!-- Price -->
                                    <div class="course-price-row">
                                        <span class="price-current">₹{{ number_format($c->discount_price > 0 ? $c->discount_price : $c->price) }}</span>
                                        @if($c->discount_price > 0 && $c->price > $c->discount_price)
                                            <span class="price-mrp">₹{{ number_format($c->price) }}</span>
                                            <span class="badge-discount-green">{{ $c->discount_percentage }}</span>
                                        @endif
                                    </div>

                                    <!-- Instructor Footer -->
                                    <div class="course-instructor-footer">
                                        <img src="{{ $c->instructor_avatar }}" alt="{{ $c->instructor_name }}" class="instructor-avatar-xs">
                                        <div style="min-width: 0;">
                                            <div class="instructor-name-label" title="{{ $c->instructor_name }}">{{ $c->instructor_name }}</div>
                                            <div class="instructor-cat-label">{{ $c->instructor_category }}</div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-graduation-cap fs-1 text-muted mb-3"></i>
                            <h5 class="fw-bold text-dark">No courses found</h5>
                            <p class="text-muted small">Try broadening your search term or clearing the filters.</p>
                            <a href="{{ route('courses') }}" class="btn btn-primary btn-sm px-4">Reset All Filters</a>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>
    </div>
</div>

<!-- ============================================================================
     COURSE ENROLLMENT / PREVIEW MODAL
     ============================================================================ -->
<div class="modal fade" id="coursePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <span id="modalCourseCat" class="badge bg-primary-subtle text-primary fw-bold"></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <h4 class="fw-bold text-dark mb-2" id="modalCourseTitle"></h4>
                <p class="text-muted small mb-3" id="modalCourseDesc"></p>

                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3 small">
                    <div>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Duration</span>
                        <strong id="modalCourseDuration"></strong>
                    </div>
                    <div>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Level</span>
                        <strong id="modalCourseLevel"></strong>
                    </div>
                    <div>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Language</span>
                        <strong id="modalCourseLanguage"></strong>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-2">
                    <div>
                        <small class="text-muted d-block">Special Offer Price</small>
                        <h3 class="fw-bold text-dark mb-0" id="modalCoursePrice"></h3>
                    </div>
                    <button type="button" class="btn btn-primary px-4 fw-bold" onclick="alert('Proceeding to checkout...');">
                        <i class="fa-solid fa-cart-shopping me-1"></i> Enroll Now
                    </button>
                </div>
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

    function toggleMoreCourseCats(btn) {
        const moreItems = document.querySelectorAll('.more-course-cat');
        let isOpening = false;
        moreItems.forEach(item => {
            if (item.classList.contains('d-none')) {
                item.classList.remove('d-none');
                isOpening = true;
            } else {
                item.classList.add('d-none');
            }
        });
        btn.innerText = isOpening ? 'Show Less ▴' : 'Show More ▾';
    }

    function updatePrice(val) {
        document.getElementById('priceDisplay').innerText = '₹0 - ₹' + Number(val).toLocaleString();
        document.getElementById('priceInputMax').value = val;
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

    function openCoursePreviewModal(data) {
        document.getElementById('modalCourseCat').innerText = data.category;
        document.getElementById('modalCourseTitle').innerText = data.title;
        document.getElementById('modalCourseDesc').innerText = data.desc;
        document.getElementById('modalCourseDuration').innerText = data.duration;
        document.getElementById('modalCourseLevel').innerText = data.level;
        document.getElementById('modalCourseLanguage').innerText = data.language;
        document.getElementById('modalCoursePrice').innerText = '₹' + Number(data.discount_price || data.price).toLocaleString();
        
        const modal = new bootstrap.Modal(document.getElementById('coursePreviewModal'));
        modal.show();
    }

    function filterCheckboxes(keyword) {
        const query = keyword.toLowerCase();
        const items = document.querySelectorAll('#courseCatContainer .course-check-item');
        items.forEach(item => {
            const label = item.querySelector('label').innerText.toLowerCase();
            if (label.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
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

