@extends('customer.layouts.customer')

@section('title', 'Student Dashboard - Digital Class Marketplace')

@section('styles')
<style>
    /* Hero Banner */
    .student-hero-banner {
        background: linear-gradient(135deg, #091e3a 0%, #112855 50%, #1e3a8a 100%);
        border-radius: 20px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.75rem;
        box-shadow: 0 10px 30px rgba(9, 30, 58, 0.12);
    }
    .student-hero-banner::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(0, 210, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-main-title {
        font-size: 1.95rem;
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -0.02em;
        margin-bottom: 0.65rem;
    }
    .hero-category-nav {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 1.25rem;
    }
    .hero-category-nav span {
        opacity: 0.4;
    }
    .hero-category-nav a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .hero-category-nav a:hover {
        color: #00d2ff;
    }
    .hero-inner-search {
        background: #ffffff;
        border-radius: 12px;
        padding: 0.35rem 0.4rem 0.35rem 1rem;
        display: flex;
        align-items: center;
        max-width: 520px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        margin-bottom: 1.15rem;
    }
    .hero-inner-search input {
        border: none;
        background: transparent;
        font-size: 0.85rem;
        flex-grow: 1;
        outline: none;
        color: #0f172a;
    }
    .hero-inner-search button {
        background: #0066ff;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 0.45rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .hero-inner-search button:hover {
        background: #0052cc;
    }
    .hero-popular-tags {
        font-size: 0.76rem;
        color: rgba(255, 255, 255, 0.75);
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.45rem;
    }
    .hero-popular-tag {
        color: rgba(255, 255, 255, 0.9);
        background: rgba(255, 255, 255, 0.12);
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .hero-popular-tag:hover {
        background: #ffffff;
        color: #091e3a;
    }

    /* Hero Right Visual */
    .hero-right-visual {
        position: relative;
        text-align: right;
    }
    .hero-student-photo {
        width: 100%;
        max-width: 320px;
        height: 220px;
        object-fit: cover;
        border-radius: 18px;
        border: 3px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
    }
    .hero-floating-quote {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(9, 30, 58, 0.75);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 10px;
        padding: 0.5rem 0.85rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #ffffff;
        text-align: left;
        line-height: 1.25;
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }

    /* 4 Category Showcase Cards */
    .category-showcase-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.15rem;
        margin-bottom: 2rem;
    }
    .category-showcase-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        padding: 1.15rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        transition: all 0.25s ease;
    }
    .category-showcase-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.1);
        border-color: #0066ff;
    }
    .showcase-text-wrap {
        flex: 1;
        min-width: 0;
    }
    .showcase-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.2rem;
    }
    .showcase-sub {
        font-size: 0.74rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    .showcase-count {
        font-size: 0.78rem;
        font-weight: 700;
        color: #0066ff;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .showcase-img-wrap {
        width: 68px;
        height: 68px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .showcase-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Section Headers */
    .panel-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.15rem;
    }
    .panel-section-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .panel-view-all {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0066ff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: transform 0.2s ease;
    }
    .panel-view-all:hover {
        transform: translateX(2px);
        color: #0052cc;
    }

    /* Continue Learning Grid */
    .continue-learning-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2.25rem;
    }
    .learning-course-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s ease;
    }
    .learning-course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 102, 255, 0.12);
        border-color: #0066ff;
    }
    .course-thumb-box {
        height: 115px;
        position: relative;
        overflow: hidden;
    }
    .course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .learning-course-card:hover .course-thumb-box img {
        transform: scale(1.06);
    }
    .course-fav-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 26px;
        height: 26px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: #ef4444;
        cursor: pointer;
    }
    .course-body-box {
        padding: 0.9rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .course-progress-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 0.35rem;
    }
    .course-progress-bar {
        height: 6px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 0.65rem;
    }
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #0066ff 0%, #00d2ff 100%);
        border-radius: 999px;
    }
    .course-card-title {
        font-size: 0.86rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 35px;
    }
    .course-card-author {
        font-size: 0.73rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }
    .continue-learn-btn {
        background: #f1f7ff;
        color: #0066ff;
        border: 1px solid #cce3ff;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 700;
        padding: 0.45rem;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: all 0.2s ease;
    }
    .continue-learn-btn:hover {
        background: #0066ff;
        color: #ffffff;
        border-color: #0066ff;
    }

    /* Right Column: My Orders List */
    .orders-panel-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        padding: 1.1rem;
        margin-bottom: 1.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .order-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }
    .order-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0.2rem;
    }
    .order-item-row:hover {
        transform: translateX(3px);
    }
    .order-ico-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
        margin-right: 0.75rem;
    }
    .order-meta-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.15rem;
    }
    .order-meta-sub {
        font-size: 0.72rem;
        color: #64748b;
    }
    .order-status-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        margin-left: 0.35rem;
    }
    .order-chevron {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-left: 0.5rem;
    }

    /* Right Column: Popular Categories List */
    .popular-categories-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        padding: 1.1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .popular-cat-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }
    .popular-cat-item:last-child {
        border-bottom: none;
        padding-bottom: 0.2rem;
    }
    .popular-cat-item:hover {
        transform: translateX(3px);
    }
    .popular-cat-ico {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
        margin-right: 0.75rem;
    }
    .popular-cat-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.1rem;
    }
    .popular-cat-count {
        font-size: 0.7rem;
        color: #64748b;
    }

    /* Recommended For You Section */
    .rec-nav-pills {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .rec-pill-btn {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid transparent;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .rec-pill-btn.active {
        background: #0066ff;
        color: #ffffff;
    }
    .rec-items-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }
    .rec-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s ease;
    }
    .rec-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
        border-color: #0066ff;
    }
    .rec-thumb-box {
        height: 120px;
        position: relative;
    }
    .rec-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .badge-bestseller {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #f59e0b;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .badge-duration {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(15, 23, 42, 0.75);
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }
    .rec-card-body {
        padding: 0.9rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .rec-card-title {
        font-size: 0.86rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 35px;
    }
    .rec-card-rating {
        font-size: 0.74rem;
        color: #f59e0b;
        margin-bottom: 0.45rem;
    }
    .rec-card-pricing {
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }
    .rec-price {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
    }
    .rec-mrp {
        font-size: 0.75rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .rec-discount {
        font-size: 0.7rem;
        font-weight: 800;
        color: #16a34a;
        background: #dcfce7;
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .category-showcase-row {
            grid-template-columns: repeat(2, 1fr);
        }
        .continue-learning-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .rec-items-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .category-showcase-row {
            grid-template-columns: 1fr;
        }
        .continue-learning-grid {
            grid-template-columns: 1fr;
        }
        .rec-items-grid {
            grid-template-columns: 1fr;
        }
        .hero-right-visual {
            display: none;
        }
        .student-hero-banner {
            padding: 1.5rem;
        }
        .hero-main-title {
            font-size: 1.45rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    <!-- =========================================================================
         1. STUDENT HERO PROMOTIONAL BANNER (Matching PDF Top Header Section)
         ========================================================================= -->
    <div class="student-hero-banner">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="hero-main-title">
                    Learn, Hire, Buy &amp; Discover<br>Everything in One Place
                </h1>

                <div class="hero-category-nav">
                    <a href="{{ route('courses') }}">Courses</a>
                    <span>&bull;</span>
                    <a href="{{ route('services') }}">Services</a>
                    <span>&bull;</span>
                    <a href="{{ route('products') }}">Products</a>
                    <span>&bull;</span>
                    <a href="{{ route('businesses') }}">Businesses</a>
                </div>

                <!-- Hero Search Bar -->
                <form action="{{ route('courses') }}" method="GET" class="hero-inner-search">
                    <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                    <input type="text" name="search" placeholder="Search for courses, services, products or businesses...">
                    <button type="submit">Search</button>
                </form>

                <!-- Popular Tags -->
                <div class="hero-popular-tags">
                    <span class="fw-bold text-white">Popular:</span>
                    <a href="{{ route('courses', ['category' => 'Digital Marketing']) }}" class="hero-popular-tag">Digital Marketing</a>
                    <a href="{{ route('services', ['category' => 'Website Development']) }}" class="hero-popular-tag">Website Development</a>
                    <a href="{{ route('courses', ['category' => 'Accounts & Finance']) }}" class="hero-popular-tag">Tally Course</a>
                    <a href="{{ route('services', ['category' => 'Graphic Design']) }}" class="hero-popular-tag">Graphic Design</a>
                    <a href="{{ route('products', ['search' => 'Laptop']) }}" class="hero-popular-tag">Laptops</a>
                    <a href="{{ route('businesses', ['category' => 'Coaching Institute']) }}" class="hero-popular-tag">Coaching Institute</a>
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-block">
                <div class="hero-right-visual">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&auto=format&fit=crop&q=80" alt="Upgrade Your Skills" class="hero-student-photo">
                    <div class="hero-floating-quote">
                        Upgrade Your Skills<br>
                        <span class="text-info">Your Business</span><br>
                        Your Life
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         2. 4 CATEGORY SHOWCASE CARDS (Online Courses, Services, Products, Business)
         ========================================================================= -->
    <div class="category-showcase-row">
        <!-- 1. Online Courses -->
        <a href="{{ route('courses') }}" class="category-showcase-card">
            <div class="showcase-text-wrap">
                <div class="showcase-title">Online Courses</div>
                <div class="showcase-sub">Learn from expert educators</div>
                <div class="showcase-count">3,000+ Courses <i class="fa-solid fa-arrow-right"></i></div>
            </div>
            <div class="showcase-img-wrap">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=200&auto=format&fit=crop&q=80" alt="Online Courses">
            </div>
        </a>

        <!-- 2. Professional Services -->
        <a href="{{ route('services') }}" class="category-showcase-card">
            <div class="showcase-text-wrap">
                <div class="showcase-title">Professional Services</div>
                <div class="showcase-sub">Hire verified freelancers</div>
                <div class="showcase-count text-danger">5,000+ Services <i class="fa-solid fa-arrow-right"></i></div>
            </div>
            <div class="showcase-img-wrap">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=200&auto=format&fit=crop&q=80" alt="Professional Services">
            </div>
        </a>

        <!-- 3. Products -->
        <a href="{{ route('products') }}" class="category-showcase-card">
            <div class="showcase-text-wrap">
                <div class="showcase-title">Products</div>
                <div class="showcase-sub">Buy quality products</div>
                <div class="showcase-count text-success">10,000+ Products <i class="fa-solid fa-arrow-right"></i></div>
            </div>
            <div class="showcase-img-wrap">
                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&auto=format&fit=crop&q=80" alt="Products">
            </div>
        </a>

        <!-- 4. Business Directory -->
        <a href="{{ route('businesses') }}" class="category-showcase-card">
            <div class="showcase-text-wrap">
                <div class="showcase-title">Business Directory</div>
                <div class="showcase-sub">Find trusted businesses</div>
                <div class="showcase-count text-warning">8,000+ Businesses <i class="fa-solid fa-arrow-right"></i></div>
            </div>
            <div class="showcase-img-wrap">
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=200&auto=format&fit=crop&q=80" alt="Business Directory">
            </div>
        </a>
    </div>

    <!-- =========================================================================
         3. MAIN 2-COLUMN SECTION: CONTINUE LEARNING & RIGHT PANELS
         ========================================================================= -->
    <div class="row g-4">

        <!-- LEFT COLUMN (70% WIDTH): Continue Learning + Recommended For You -->
        <div class="col-lg-8">

            <!-- A. CONTINUE LEARNING -->
            <div class="panel-section-header">
                <h2 class="panel-section-title">Continue Learning</h2>
                <a href="{{ route('customer.my-courses') }}" class="panel-view-all">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="continue-learning-grid">
                @foreach($enrolledCourses as $c)
                    <div class="learning-course-card">
                        <div>
                            <div class="course-thumb-box">
                                <img src="{{ $c->thumbnail }}" alt="{{ $c->title }}">
                                <button type="button" class="course-fav-btn" title="Saved"><i class="fa-solid fa-heart"></i></button>
                            </div>
                            <div class="course-body-box pb-0">
                                <div class="course-progress-row">
                                    <span>Progress</span>
                                    <span>{{ $c->progress_percent }}%</span>
                                </div>
                                <div class="course-progress-bar">
                                    <div class="progress-bar-fill" style="width: {{ $c->progress_percent }}%;"></div>
                                </div>
                                <div class="course-card-title" title="{{ $c->title }}">{{ $c->title }}</div>
                                <div class="course-card-author">{{ $c->instructor }}</div>
                            </div>
                        </div>
                        <div class="p-3 pt-0">
                            <a href="{{ $c->learn_url }}" class="continue-learn-btn">
                                Continue Learning
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- B. RECOMMENDED FOR YOU (With Interactive Tabs: Courses, Services, Products, Businesses) -->
            <div class="panel-section-header align-items-center">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <h2 class="panel-section-title">Recommended for You</h2>
                    <div class="rec-nav-pills" id="recommended">
                        <button type="button" class="rec-pill-btn active" onclick="switchRecommendedTab('courses', this)">Courses</button>
                        <button type="button" class="rec-pill-btn" onclick="switchRecommendedTab('services', this)">Services</button>
                        <button type="button" class="rec-pill-btn" onclick="switchRecommendedTab('products', this)">Products</button>
                        <button type="button" class="rec-pill-btn" onclick="switchRecommendedTab('businesses', this)">Businesses</button>
                    </div>
                </div>
                <a href="{{ route('courses') }}" class="panel-view-all" id="recViewAllLink">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Tab 1: Recommended Courses -->
            <div class="rec-tab-content" id="recTabCourses">
                <div class="rec-items-grid">
                    @forelse($recommendedCourses as $rc)
                        @php
                            $rTitle = $rc->title ?? $rc->course_name;
                            $rThumb = $rc->thumbnail ?? $rc->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80';
                            $rPrice = $rc->discount_price ?? $rc->price ?? 2999;
                            $rMrp = $rc->regular_price ?? ($rPrice * 2);
                        @endphp
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="{{ $rThumb }}" alt="{{ $rTitle }}">
                                <span class="badge-bestseller">Best Seller</span>
                                <span class="badge-duration"><i class="fa-regular fa-clock me-1"></i> 12h 30m</span>
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title" title="{{ $rTitle }}">{{ $rTitle }}</div>
                                <div class="rec-card-rating">
                                    <i class="fa-solid fa-star"></i> 4.8 <span class="text-muted">(1.2K)</span>
                                </div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;{{ number_format($rPrice) }}</span>
                                    <span class="rec-mrp">&#8377;{{ number_format($rMrp) }}</span>
                                    <span class="rec-discount">50% OFF</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('course.show', $rc->id) }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <!-- Showcase default course 1 -->
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=80" alt="Advanced Digital Marketing">
                                <span class="badge-bestseller">Best Seller</span>
                                <span class="badge-duration">12h 30m</span>
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">Advanced Digital Marketing Course 2026</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.8 (1.2K)</div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;2,999</span>
                                    <span class="rec-mrp">&#8377;5,999</span>
                                    <span class="rec-discount">50% OFF</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">Enroll Now</a>
                            </div>
                        </div>

                        <!-- Showcase default course 2 -->
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=500&auto=format&fit=crop&q=80" alt="Website Development for Business">
                                <span class="badge-duration">8h 20m</span>
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">Website Development for Business</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.6 (860)</div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;3,499</span>
                                    <span class="rec-mrp">&#8377;6,999</span>
                                    <span class="rec-discount">50% OFF</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">Enroll Now</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab 2: Recommended Services -->
            <div class="rec-tab-content d-none" id="recTabServices">
                <div class="rec-items-grid">
                    @forelse($recommendedServices as $rs)
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="{{ $rs->thumbnail_image ?: 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=500&auto=format&fit=crop&q=80' }}" alt="{{ $rs->title }}">
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">{{ $rs->title }}</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.9 (320)</div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;{{ number_format($rs->price) }}</span>
                                    <span class="text-muted small">Starting</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('services') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">Hire Expert</a>
                            </div>
                        </div>
                    @empty
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=500&auto=format&fit=crop&q=80" alt="Graphic Design Service">
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">Graphic Design &amp; Brand Identity Service</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.9 (320)</div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;1,500</span>
                                    <span class="text-muted small">Starting</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('services') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">Hire Expert</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab 3: Recommended Products -->
            <div class="rec-tab-content d-none" id="recTabProducts">
                <div class="rec-items-grid">
                    @forelse($recommendedProducts as $rp)
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="{{ $rp->featured_image ?: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80' }}" alt="{{ $rp->title }}">
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">{{ $rp->title }}</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.7 (560)</div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;{{ number_format($rp->price) }}</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('products') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">Buy Now</a>
                            </div>
                        </div>
                    @empty
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="HP Laptop 15s">
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">HP Laptop 15s (Core i5 12th Gen, 16GB RAM)</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.7 (560)</div>
                                <div class="rec-card-pricing">
                                    <span class="rec-price">&#8377;42,999</span>
                                    <span class="rec-mrp">&#8377;52,999</span>
                                    <span class="rec-discount">19% OFF</span>
                                </div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('products') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">Buy Now</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab 4: Recommended Businesses -->
            <div class="rec-tab-content d-none" id="recTabBusinesses">
                <div class="rec-items-grid">
                    @forelse($recommendedBusinesses as $rb)
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="{{ $rb->logo ?: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=500&auto=format&fit=crop&q=80' }}" alt="{{ $rb->business_name }}">
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">{{ $rb->business_name }}</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.8 (124)</div>
                                <div class="text-muted small"><i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $rb->city ?: 'Ahmedabad' }}, {{ $rb->state ?: 'Gujarat' }}</div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('business.show.single', $rb->slug ?: $rb->id) }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">View Profile</a>
                            </div>
                        </div>
                    @empty
                        <div class="rec-card">
                            <div class="rec-thumb-box">
                                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&auto=format&fit=crop&q=80" alt="VCEC Education Center">
                            </div>
                            <div class="rec-card-body">
                                <div class="rec-card-title">VCEC - Vinayak Computer Education Center</div>
                                <div class="rec-card-rating"><i class="fa-solid fa-star"></i> 4.8 (124)</div>
                                <div class="text-muted small"><i class="fa-solid fa-location-dot me-1 text-danger"></i> Ahmedabad, Gujarat</div>
                            </div>
                            <div class="p-3 pt-0">
                                <a href="{{ route('businesses') }}" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">View Profile</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (30% WIDTH): My Orders & Popular Categories -->
        <div class="col-lg-4">

            <!-- A. MY ORDERS CARD -->
            <div class="panel-section-header">
                <h2 class="panel-section-title">My Orders</h2>
                <a href="{{ route('customer.orders') }}" class="panel-view-all">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="orders-panel-card">
                @foreach($myOrders as $ord)
                    <a href="{{ route('customer.orders') }}" class="order-item-row">
                        <div class="d-flex align-items-center">
                            <div class="order-ico-box">
                                <i class="{{ $ord->icon ?? 'fa-solid fa-box' }}"></i>
                            </div>
                            <div>
                                <div class="order-meta-title">{{ $ord->title ?? ($ord->item_name ?: 'Order #' . $ord->order_number) }}</div>
                                <div class="order-meta-sub">
                                    <span class="fw-bold text-dark">&#8377;{{ number_format($ord->amount ?? $ord->total_amount) }}</span>
                                    <span class="order-status-badge {{ $ord->status_class ?? 'bg-success-subtle text-success' }}">{{ $ord->status ?? $ord->order_status }}</span>
                                    <span class="mx-1">&bull;</span>
                                    <span>{{ $ord->date ?? ($ord->placed_at ? \Illuminate\Support\Carbon::parse($ord->placed_at)->format('M d, Y') : 'Recent') }}</span>
                                </div>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right order-chevron"></i>
                    </a>
                @endforeach
            </div>

            <!-- B. POPULAR CATEGORIES CARD -->
            <div class="panel-section-header">
                <h2 class="panel-section-title">Popular Categories</h2>
                <a href="{{ route('courses') }}" class="panel-view-all">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="popular-categories-card">
                @foreach($popularCategories as $pc)
                    <a href="{{ $pc['url'] }}" class="popular-cat-item">
                        <div class="d-flex align-items-center">
                            <div class="popular-cat-ico" style="background-color: {{ $pc['bg'] }};">
                                <i class="{{ $pc['icon'] }}"></i>
                            </div>
                            <div>
                                <div class="popular-cat-title">{{ $pc['title'] }}</div>
                                <div class="popular-cat-count">{{ $pc['count'] }}</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right order-chevron"></i>
                    </a>
                @endforeach
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function switchRecommendedTab(tab, btn) {
        document.querySelectorAll('.rec-pill-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.rec-tab-content').forEach(c => c.classList.add('d-none'));

        const target = document.getElementById('recTab' + tab.charAt(0).toUpperCase() + tab.slice(1));
        if (target) {
            target.classList.remove('d-none');
        }

        const link = document.getElementById('recViewAllLink');
        if (link) {
            if (tab === 'services') link.href = "{{ route('services') }}";
            else if (tab === 'products') link.href = "{{ route('products') }}";
            else if (tab === 'businesses') link.href = "{{ route('businesses') }}";
            else link.href = "{{ route('courses') }}";
        }
    }
</script>
@endsection
