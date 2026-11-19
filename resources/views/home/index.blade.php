@extends('layouts.app')

@section('title', 'Digital Class Marketplace - Learn, Hire, Buy & Discover in One Place')

@section('meta_description', 'India\'s trusted marketplace for online courses, professional services, products, and verified coaching institutes and businesses.')

@section('styles')
<style>
    /* ==========================================================================
       HERO SECTION WITH MODERN MARKETPLACE CALLOUTS
       ========================================================================== */
    .hero-marketplace-v2 {
        background: radial-gradient(circle at 85% 20%, rgba(37, 99, 235, 0.08) 0%, transparent 50%),
                    linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .hero-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #ffffff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);
        margin-bottom: 1.15rem;
    }

    .hero-main-title {
        font-size: 3.1rem;
        font-weight: 800;
        line-height: 1.14;
        letter-spacing: -0.03em;
        color: #0f172a;
        margin-bottom: 1rem;
    }
    .hero-main-title .highlight-blue {
        color: #0066ff;
    }

    .hero-main-desc {
        font-size: 1.05rem;
        line-height: 1.6;
        color: #475569;
        max-width: 620px;
        margin-bottom: 1.75rem;
    }

    /* Master Search Bar Card */
    .hero-master-search {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        padding: 0.4rem 0.5rem;
        box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.8);
        max-width: 660px;
        transition: all 0.2s ease;
    }
    .hero-master-search:focus-within {
        border-color: #0066ff;
        box-shadow: 0 16px 36px -4px rgba(0, 102, 255, 0.16), 0 0 0 3px rgba(0, 102, 255, 0.15);
    }
    .hero-search-input {
        border: none;
        outline: none;
        font-size: 0.92rem;
        padding: 0.65rem 0.85rem;
        color: #1e293b;
        background: transparent;
        width: 100%;
    }
    .hero-search-input::placeholder {
        color: #94a3b8;
    }
    .hero-category-select {
        border: none;
        border-left: 1px solid #e2e8f0;
        outline: none;
        font-size: 0.85rem;
        padding: 0.65rem 1rem;
        color: #334155;
        background: transparent;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-hero-search-action {
        background: #0066ff;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.65rem 1.65rem;
        border-radius: 999px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }
    .btn-hero-search-action:hover {
        background: #0052cc;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 102, 255, 0.4);
    }

    /* Popular Keyword Tags */
    .hero-popular-tags {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.4rem;
        margin-top: 1.15rem;
        font-size: 0.8rem;
    }
    .hero-popular-tags .pop-label {
        font-weight: 700;
        color: #64748b;
        margin-right: 0.25rem;
    }
    .pop-tag-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.78rem;
        transition: all 0.15s ease;
    }
    .pop-tag-pill:hover {
        border-color: #0066ff;
        color: #0066ff;
        background: #eff6ff;
    }

    /* 4 Metric Counter Badges */
    .hero-metrics-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        margin-top: 2rem;
        max-width: 640px;
    }
    .hero-metric-item {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 0.65rem 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }
    .hero-metric-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .hero-metric-text .val {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .hero-metric-text .lbl {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 500;
    }

    /* Hero Right Visual & Floating Cards */
    .hero-visual-wrap {
        position: relative;
        text-align: center;
        padding: 1.5rem 0;
    }
    .hero-visual-img {
        max-width: 100%;
        max-height: 480px;
        object-fit: contain;
        position: relative;
        z-index: 2;
        border-radius: 24px;
    }
    .floating-card-item {
        position: absolute;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid #ffffff;
        box-shadow: 0 14px 30px -4px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(226, 232, 240, 0.6);
        border-radius: 14px;
        padding: 0.65rem 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        z-index: 3;
        transition: transform 0.25s ease;
        text-align: left;
    }
    .floating-card-item:hover {
        transform: translateY(-3px);
    }
    .floating-card-item.card-top-left {
        top: 8%;
        left: -4%;
    }
    .floating-card-item.card-top-right {
        top: 2%;
        right: 4%;
    }
    .floating-card-item.card-bottom-left {
        bottom: 12%;
        left: -8%;
    }
    .floating-card-item.card-bottom-right {
        bottom: 8%;
        right: -2%;
    }
    .fc-icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .fc-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .fc-desc {
        font-size: 0.68rem;
        color: #64748b;
    }
    .hero-script-tag {
        position: absolute;
        top: -10px;
        right: 15px;
        font-family: 'Segoe Script', 'Brush Script MT', cursive, sans-serif;
        color: #0f172a;
        font-size: 1.1rem;
        line-height: 1.25;
        font-weight: 700;
        text-align: right;
        transform: rotate(3deg);
        z-index: 4;
    }

    /* ==========================================================================
       CATEGORY HORIZONTAL BAR
       ========================================================================== */
    .category-strip-wrap {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.85rem 0;
    }
    .category-strip-scroll {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 2px;
        scrollbar-width: none;
    }
    .category-strip-scroll::-webkit-scrollbar {
        display: none;
    }
    .cat-strip-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 1rem;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }
    .cat-strip-btn i {
        color: #64748b;
        font-size: 0.85rem;
        transition: color 0.15s;
    }
    .cat-strip-btn:hover {
        background: #eff6ff;
        border-color: #0066ff;
        color: #0066ff;
    }
    .cat-strip-btn:hover i {
        color: #0066ff;
    }

    /* ==========================================================================
       3 PROMOTIONAL BANNERS ROW
       ========================================================================== */
    .promo-banner-card {
        border-radius: 16px;
        padding: 1.4rem 1.5rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        min-height: 155px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.1);
        text-decoration: none;
    }
    .promo-banner-card:hover {
        transform: translateY(-3px);
        color: #ffffff;
        box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.16);
    }
    .promo-banner-1 {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    }
    .promo-banner-2 {
        background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%);
    }
    .promo-banner-3 {
        background: linear-gradient(135deg, #065f46 0%, #059669 100%);
    }
    .promo-tag-pill {
        display: inline-block;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }
    .promo-title {
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 0.25rem;
        max-width: 260px;
    }
    .promo-subtitle {
        font-size: 0.78rem;
        opacity: 0.9;
        margin-bottom: 0.75rem;
    }
    .promo-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.82rem;
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
    }
    .promo-corner-free {
        position: absolute;
        top: 12px;
        right: 14px;
        background: #facc15;
        color: #0f172a;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        text-transform: uppercase;
    }

    /* ==========================================================================
       MAIN MARKETPLACE SECTION (LEFT CONTENT + RIGHT SIDEBAR)
       ========================================================================== */
    .marketplace-feed-section {
        background: #f8fafc;
        padding: 2.25rem 0 3.5rem;
    }

    /* Section Headers */
    .feed-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.15rem;
    }
    .feed-section-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin: 0;
    }
    .feed-view-all {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0066ff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .feed-view-all:hover {
        color: #0052cc;
        text-decoration: underline;
    }

    /* 5-Column Grid */
    .grid-5-col {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 2.25rem;
    }
    @media (max-width: 1399px) {
        .grid-5-col {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    @media (max-width: 1199px) {
        .grid-5-col {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 767px) {
        .grid-5-col {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
    }
    @media (max-width: 480px) {
        .grid-5-col {
            grid-template-columns: 1fr;
        }
    }

    /* Standard Marketplace Card */
    .feed-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        color: inherit;
        position: relative;
    }
    .feed-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
        color: inherit;
    }
    .feed-card-thumb-wrap {
        position: relative;
        width: 100%;
        padding-top: 60%;
        background: #f1f5f9;
        overflow: hidden;
    }
    .feed-card-thumb {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .feed-card-badge-top {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        z-index: 2;
    }
    .feed-card-wish-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        z-index: 2;
        transition: all 0.15s ease;
    }
    .feed-card-wish-btn:hover {
        color: #ef4444;
        background: #ffffff;
    }
    .feed-card-body {
        padding: 0.85rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }
    .feed-card-title {
        font-size: 0.86rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 0.45rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .feed-rating-row {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        margin-bottom: 0.45rem;
    }
    .feed-rating-val {
        font-weight: 700;
        color: #0f172a;
    }
    .feed-rating-count {
        color: #64748b;
    }
    .feed-price-row {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.45rem;
        flex-wrap: wrap;
    }
    .feed-price-current {
        font-size: 0.98rem;
        font-weight: 800;
        color: #0f172a;
    }
    .feed-price-strike {
        font-size: 0.75rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .feed-price-discount {
        font-size: 0.68rem;
        font-weight: 700;
        color: #16a34a;
        background: #dcfce7;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
    }
    .feed-card-seller-info {
        font-size: 0.72rem;
        color: #64748b;
        border-top: 1px solid #f1f5f9;
        padding-top: 0.45rem;
        margin-top: 0.35rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Right Sidebar Widgets */
    .sidebar-widget-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
    }
    .sidebar-widget-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1rem;
        letter-spacing: -0.01em;
    }
    .why-us-list {
        display: flex;
        flex-direction: column;
        gap: 0.95rem;
    }
    .why-us-item {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }
    .why-us-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: #eff6ff;
        color: #0066ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .why-us-heading {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .why-us-desc {
        font-size: 0.72rem;
        color: #64748b;
        margin-top: 2px;
    }

    /* Join Sellers Blue Card */
    .join-sellers-box {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        border-radius: 14px;
        padding: 1.35rem;
        color: #ffffff;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .join-sellers-title {
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 1rem;
    }
    .btn-join-sellers {
        background: #ffffff;
        color: #1d4ed8;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 0.6rem 1.15rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.15s ease;
    }
    .btn-join-sellers:hover {
        background: #f8fafc;
        color: #1e40af;
        transform: translateY(-1px);
    }

    /* List Business Light Card */
    .list-biz-box {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .list-biz-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #92400e;
        margin-bottom: 0.35rem;
    }
    .list-biz-desc {
        font-size: 0.78rem;
        color: #b45309;
        margin-bottom: 0.95rem;
    }
    .btn-list-biz {
        background: #d97706;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .btn-list-biz:hover {
        background: #b45309;
        color: #ffffff;
    }

    /* ==========================================================================
       BOTTOM STATS & TRUST STRIP
       ========================================================================== */
    .bottom-stats-strip {
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        padding: 2.25rem 0;
    }
    .stat-metric-col {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.85rem;
        padding: 0.5rem 1rem;
    }
    .stat-metric-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }
    .stat-metric-number {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
    }
    .stat-metric-label {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<!-- 1. HERO SECTION -->
<section class="hero-marketplace-v2">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <!-- Hero Left: Content & Search -->
            <div class="col-lg-7 col-xl-7 mb-4 mb-lg-0">
                <div class="hero-pill-badge">
                    <i class="fa-solid fa-circle-check text-primary"></i>
                    <span>India's Trusted Marketplace for Learning, Services, Products & Businesses</span>
                </div>

                <h1 class="hero-main-title">
                    Learn. Hire. Buy. Discover.<br>
                    <span class="highlight-blue">All in One Place.</span>
                </h1>

                <p class="hero-main-desc">
                    Courses, professional services, products and trusted businesses — everything you need to grow your skills, business and career.
                </p>

                <!-- Master Search Form -->
                <form action="{{ route('home') }}" method="GET" id="heroMasterSearchForm" class="hero-master-search d-flex align-items-center">
                    <div class="d-flex align-items-center flex-grow-1 ps-2">
                        <i class="fa-solid fa-magnifying-glass text-muted me-1" style="font-size: 0.9rem;"></i>
                        <input type="text" name="search" id="heroSearchQuery" class="hero-search-input" placeholder="What are you looking for?" value="{{ request('search') }}">
                    </div>
                    <select name="category" id="heroCategorySelect" class="hero-category-select">
                        <option value="">All Categories</option>
                        <option value="courses">Online Courses</option>
                        <option value="services">Professional Services</option>
                        <option value="products">Products</option>
                        <option value="businesses">Businesses</option>
                    </select>
                    <button type="submit" class="btn-hero-search-action">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Search</span>
                    </button>
                </form>

                <!-- Popular Search Pills -->
                <div class="hero-popular-tags">
                    <span class="pop-label">Popular:</span>
                    <a href="{{ route('courses', ['search' => 'Digital Marketing']) }}" class="pop-tag-pill">Digital Marketing</a>
                    <a href="{{ route('services', ['search' => 'Website Development']) }}" class="pop-tag-pill">Website Development</a>
                    <a href="{{ route('courses', ['search' => 'Tally']) }}" class="pop-tag-pill">Tally Course</a>
                    <a href="{{ route('services', ['search' => 'Graphic Design']) }}" class="pop-tag-pill">Graphic Design</a>
                    <a href="{{ route('products', ['search' => 'Laptop']) }}" class="pop-tag-pill">Laptops</a>
                    <a href="{{ route('home', ['category' => 'Coaching Institute']) }}" class="pop-tag-pill">Coaching Institute</a>
                </div>

                <!-- 4 Metrics Under Search -->
                <div class="hero-metrics-strip">
                    <div class="hero-metric-item">
                        <div class="hero-metric-icon bg-primary-subtle text-primary">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div class="hero-metric-text">
                            <div class="val">10,000+</div>
                            <div class="lbl">Courses</div>
                        </div>
                    </div>
                    <div class="hero-metric-item">
                        <div class="hero-metric-icon bg-success-subtle text-success">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div class="hero-metric-text">
                            <div class="val">5,000+</div>
                            <div class="lbl">Services</div>
                        </div>
                    </div>
                    <div class="hero-metric-item">
                        <div class="hero-metric-icon bg-info-subtle text-info">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div class="hero-metric-text">
                            <div class="val">10,000+</div>
                            <div class="lbl">Products</div>
                        </div>
                    </div>
                    <div class="hero-metric-item">
                        <div class="hero-metric-icon bg-warning-subtle text-warning">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div class="hero-metric-text">
                            <div class="val">8,000+</div>
                            <div class="lbl">Businesses</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Right: Visual & Floating Badges -->
            <div class="col-lg-5 col-xl-5">
                <div class="hero-visual-wrap">
                    <!-- Handwritten Slogan -->
                    <div class="hero-script-tag">
                        <span>Your Skills</span><br>
                        <span>Your Growth</span><br>
                        <span style="color: #0066ff;">Our Marketplace</span>
                    </div>

                    <!-- Main Student / Professional Image -->
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&auto=format&fit=crop&q=80" alt="Learn, Hire, Buy & Discover on Digital Class" class="hero-visual-img shadow">

                    <!-- Floating Card 1: Hire Experts -->
                    <a href="{{ route('services') }}" class="floating-card-item card-top-left text-decoration-none">
                        <div class="fc-icon-wrap bg-primary-subtle text-primary">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="fc-title">Hire Experts</div>
                            <div class="fc-desc">Professional Services</div>
                        </div>
                    </a>

                    <!-- Floating Card 2: Buy Quality Products -->
                    <a href="{{ route('products') }}" class="floating-card-item card-bottom-left text-decoration-none">
                        <div class="fc-icon-wrap bg-info-subtle text-info">
                            <i class="fa-solid fa-laptop"></i>
                        </div>
                        <div>
                            <div class="fc-title">Buy Quality Products</div>
                            <div class="fc-desc">Laptops, Accessories & More</div>
                        </div>
                    </a>

                    <!-- Floating Card 3: Learn New Skills -->
                    <a href="{{ route('courses') }}" class="floating-card-item card-top-right text-decoration-none">
                        <div class="fc-icon-wrap bg-success-subtle text-success">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="fc-title">Learn New Skills</div>
                            <div class="fc-desc">Online Courses</div>
                        </div>
                    </a>

                    <!-- Floating Card 4: Find Trusted Businesses -->
                    <a href="{{ route('home') }}" class="floating-card-item card-bottom-right text-decoration-none">
                        <div class="fc-icon-wrap bg-warning-subtle text-warning">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div>
                            <div class="fc-title">Find Trusted Businesses</div>
                            <div class="fc-desc">Institutes, Shops & More</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. CATEGORY HORIZONTAL BAR -->
<section class="category-strip-wrap">
    <div class="container-fluid px-lg-5">
        <div class="category-strip-scroll">
            <a href="{{ route('courses') }}" class="cat-strip-btn">
                <i class="fa-solid fa-graduation-cap text-primary"></i>
                <span>Online Courses</span>
            </a>
            <a href="{{ route('services') }}" class="cat-strip-btn">
                <i class="fa-solid fa-briefcase text-success"></i>
                <span>Professional Services</span>
            </a>
            <a href="{{ route('products') }}" class="cat-strip-btn">
                <i class="fa-solid fa-bag-shopping text-info"></i>
                <span>Products</span>
            </a>
            <a href="{{ route('home') }}" class="cat-strip-btn">
                <i class="fa-solid fa-building text-warning"></i>
                <span>Businesses</span>
            </a>
            <a href="{{ route('courses', ['category' => 'Digital Marketing']) }}" class="cat-strip-btn">
                <i class="fa-solid fa-bullhorn text-danger"></i>
                <span>Digital Marketing</span>
            </a>
            <a href="{{ route('courses', ['category' => 'IT & Software']) }}" class="cat-strip-btn">
                <i class="fa-solid fa-code text-indigo"></i>
                <span>IT & Software</span>
            </a>
            <a href="{{ route('services', ['category' => 'Graphic Design']) }}" class="cat-strip-btn">
                <i class="fa-solid fa-palette text-purple"></i>
                <span>Design & Creative</span>
            </a>
            <a href="{{ route('courses', ['search' => 'Tally']) }}" class="cat-strip-btn">
                <i class="fa-solid fa-calculator text-teal"></i>
                <span>Tally & Accounting</span>
            </a>
            <a href="{{ route('home', ['category' => 'Coaching Institute']) }}" class="cat-strip-btn">
                <i class="fa-solid fa-chalkboard-user text-orange"></i>
                <span>Coaching Institute</span>
            </a>
            <a href="{{ route('home', ['category' => 'Gym & Fitness']) }}" class="cat-strip-btn">
                <i class="fa-solid fa-heart-pulse text-pink"></i>
                <span>Health & Wellness</span>
            </a>
            <a href="{{ route('home') }}" class="cat-strip-btn">
                <i class="fa-solid fa-ellipsis"></i>
                <span>More</span>
            </a>
        </div>
    </div>
</section>

<!-- 3. PROMOTIONAL BANNERS ROW -->
<section class="py-4 bg-white">
    <div class="container-fluid px-lg-5">
        <div class="row g-3">
            <!-- Promo 1: Festival Offer -->
            <div class="col-md-4">
                <a href="{{ route('courses') }}" class="promo-banner-card promo-banner-1">
                    <div>
                        <span class="promo-tag-pill">Festival Offer</span>
                        <div class="promo-title">Extra 50% OFF on Selected Courses</div>
                    </div>
                    <div class="promo-action-btn">
                        <span>Grab Offer</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <!-- Promo 2: Grow Your Business -->
            <div class="col-md-4">
                <a href="{{ route('seller.register') }}" class="promo-banner-card promo-banner-2">
                    <span class="promo-corner-free">FREE</span>
                    <div>
                        <span class="promo-tag-pill">Grow Your Business</span>
                        <div class="promo-title">List Your Business for Free</div>
                        <div class="promo-subtitle">Get more customers online</div>
                    </div>
                    <div class="promo-action-btn">
                        <span>Add Your Business</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <!-- Promo 3: Become a Seller -->
            <div class="col-md-4">
                <a href="{{ route('sell-courses.landing') }}" class="promo-banner-card promo-banner-3">
                    <div>
                        <span class="promo-tag-pill">Become a Seller</span>
                        <div class="promo-title">Sell Courses, Services, Products or List Your Business</div>
                    </div>
                    <div class="promo-action-btn">
                        <span>Start Selling</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 4. MAIN MARKETPLACE CONTENT FEED + SIDEBAR -->
<section class="marketplace-feed-section">
    <div class="container-fluid px-lg-5">
        <div class="row g-4">
            <!-- Left Main Content: Catalog Sections -->
            <div class="col-lg-9 col-xl-9">
                <!-- SECTION 1: ONLINE COURSES -->
                <div class="feed-section-header">
                    <h2 class="feed-section-title">Online Courses</h2>
                    <a href="{{ route('courses') }}" class="feed-view-all">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid-5-col">
                    @forelse($featuredCourses as $course)
                        @php
                            $coursePrice = (float)($course->price ?? 0);
                            $discountPrice = (float)($course->discount_price ?? 0);
                            $finalPrice = $discountPrice > 0 ? $discountPrice : $coursePrice;
                            $hasDiscount = $discountPrice > 0 && $coursePrice > $discountPrice;
                            $pct = $hasDiscount ? round((($coursePrice - $discountPrice) / $coursePrice) * 100) : 0;
                            $sellerName = $course->seller->businessDetail->company_name ?? ($course->seller->user->name ?? 'Verified Educator');
                            $courseThumb = $course->thumbnail ? asset($course->thumbnail) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80';
                        @endphp
                        <a href="{{ route('course.show', $course->slug ?? $course->id) }}" class="feed-card">
                            <div class="feed-card-thumb-wrap">
                                <span class="feed-card-badge-top">Bestseller</span>
                                <button type="button" class="feed-card-wish-btn" onclick="event.preventDefault();" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                                <img src="{{ $courseThumb }}" alt="{{ $course->title }}" class="feed-card-thumb" loading="lazy">
                            </div>
                            <div class="feed-card-body">
                                <div>
                                    <div class="feed-card-title" title="{{ $course->title }}">{{ $course->title }}</div>
                                    <div class="feed-rating-row">
                                        <i class="fa-solid fa-star text-warning" style="font-size: 0.7rem;"></i>
                                        <span class="feed-rating-val">4.8</span>
                                        <span class="feed-rating-count">(1.2k)</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="feed-price-row">
                                        <span class="feed-price-current">₹{{ number_format($finalPrice) }}</span>
                                        @if($hasDiscount)
                                            <span class="feed-price-strike">₹{{ number_format($coursePrice) }}</span>
                                            <span class="feed-price-discount">{{ $pct }}% OFF</span>
                                        @endif
                                    </div>
                                    <div class="feed-card-seller-info">
                                        <i class="fa-regular fa-circle-user me-1"></i> {{ $sellerName }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-12 py-3 text-muted text-center bg-white rounded-3 border">
                            No courses available right now.
                        </div>
                    @endforelse
                </div>

                <!-- SECTION 2: PROFESSIONAL SERVICES -->
                <div class="feed-section-header">
                    <h2 class="feed-section-title">Professional Services</h2>
                    <a href="{{ route('services') }}" class="feed-view-all">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid-5-col">
                    @forelse($featuredServices as $service)
                        @php
                            $svcPrice = (float)($service->price ?? 0);
                            $sellerName = $service->seller->businessDetail->company_name ?? ($service->seller->user->name ?? 'Tech Solutions');
                            $svcThumb = $service->thumbnail ? asset($service->thumbnail) : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=80';
                        @endphp
                        <a href="{{ route('service.show', $service->slug ?? $service->id) }}" class="feed-card">
                            <div class="feed-card-thumb-wrap">
                                <button type="button" class="feed-card-wish-btn" onclick="event.preventDefault();" title="Bookmark">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                                <img src="{{ $svcThumb }}" alt="{{ $service->title }}" class="feed-card-thumb" loading="lazy">
                            </div>
                            <div class="feed-card-body">
                                <div>
                                    <div class="feed-card-title" title="{{ $service->title }}">{{ $service->title }}</div>
                                    <div class="feed-price-row">
                                        <span class="feed-price-current text-primary" style="font-size: 0.85rem;">Starting at ₹{{ number_format($svcPrice) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="feed-rating-row">
                                        <i class="fa-solid fa-star text-warning" style="font-size: 0.7rem;"></i>
                                        <span class="feed-rating-val">4.8</span>
                                        <span class="feed-rating-count">(120)</span>
                                    </div>
                                    <div class="feed-card-seller-info">
                                        By {{ $sellerName }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-12 py-3 text-muted text-center bg-white rounded-3 border">
                            No professional services published yet.
                        </div>
                    @endforelse
                </div>

                <!-- SECTION 3: FEATURED PRODUCTS -->
                <div class="feed-section-header">
                    <h2 class="feed-section-title">Featured Products</h2>
                    <a href="{{ route('products') }}" class="feed-view-all">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid-5-col">
                    @forelse($featuredProducts as $product)
                        @php
                            $prodPrice = (float)($product->price ?? 0);
                            $prodMrp = (float)($product->mrp ?? $prodPrice);
                            $hasDisc = $prodMrp > $prodPrice;
                            $discPct = $hasDisc ? round((($prodMrp - $prodPrice) / $prodMrp) * 100) : 0;
                            $prodThumb = $product->thumbnail ? asset($product->thumbnail) : 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&auto=format&fit=crop&q=80';
                        @endphp
                        <a href="{{ route('product.show', $product->slug ?? $product->id) }}" class="feed-card">
                            <div class="feed-card-thumb-wrap">
                                <button type="button" class="feed-card-wish-btn" onclick="event.preventDefault();" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                                <img src="{{ $prodThumb }}" alt="{{ $product->title }}" class="feed-card-thumb" loading="lazy">
                            </div>
                            <div class="feed-card-body">
                                <div>
                                    <div class="feed-card-title" title="{{ $product->title }}">{{ $product->title }}</div>
                                </div>
                                <div>
                                    <div class="feed-price-row">
                                        <span class="feed-price-current">₹{{ number_format($prodPrice) }}</span>
                                        @if($hasDisc)
                                            <span class="feed-price-strike">₹{{ number_format($prodMrp) }}</span>
                                            <span class="feed-price-discount">{{ $discPct }}% OFF</span>
                                        @endif
                                    </div>
                                    <div class="feed-card-seller-info text-success">
                                        <i class="fa-solid fa-check-circle me-1"></i> In Stock
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-12 py-3 text-muted text-center bg-white rounded-3 border">
                            No products featured yet.
                        </div>
                    @endforelse
                </div>

                <!-- SECTION 4: POPULAR BUSINESSES -->
                <div class="feed-section-header">
                    <h2 class="feed-section-title">Popular Businesses</h2>
                    <a href="{{ route('home') }}" class="feed-view-all">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid-5-col">
                    @forelse($businesses as $biz)
                        @php
                            $bizRating = (float)($biz->rating ?? 4.7);
                            $bizLocation = trim(($biz->city ?? '') . ($biz->state ? ', ' . $biz->state : ''));
                            if (empty($bizLocation)) $bizLocation = 'India';
                            $bizImage = $biz->cover_image ? asset($biz->cover_image) : ($biz->logo ? asset($biz->logo) : 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=500&auto=format&fit=crop&q=80');
                        @endphp
                        <a href="{{ route('business.show', $biz->slug ?? $biz->id) }}" class="feed-card">
                            <div class="feed-card-thumb-wrap">
                                <img src="{{ $bizImage }}" alt="{{ $biz->business_name }}" class="feed-card-thumb" loading="lazy">
                            </div>
                            <div class="feed-card-body">
                                <div>
                                    <div class="feed-card-title" title="{{ $biz->business_name }}">{{ $biz->business_name }}</div>
                                    <div class="small text-muted mb-2 text-truncate">
                                        <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $bizLocation }}
                                    </div>
                                </div>
                                <div>
                                    <div class="feed-rating-row">
                                        <i class="fa-solid fa-star text-warning" style="font-size: 0.7rem;"></i>
                                        <span class="feed-rating-val">{{ number_format($bizRating, 1) }}</span>
                                        <span class="feed-rating-count">(96)</span>
                                    </div>
                                    <div class="feed-card-seller-info text-primary">
                                        <i class="fa-solid fa-shield-check me-1"></i> Verified Business
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-12 py-3 text-muted text-center bg-white rounded-3 border">
                            No business listings to display.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Sidebar: Conversion & Trust Widgets -->
            <div class="col-lg-3 col-xl-3">
                <!-- Widget 1: Why Choose Digital Class -->
                <div class="sidebar-widget-card">
                    <h3 class="sidebar-widget-title">Why Choose Digital Class?</h3>
                    <div class="why-us-list">
                        <div class="why-us-item">
                            <div class="why-us-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <div class="why-us-heading">Trusted & Verified Sellers</div>
                                <div class="why-us-desc">Quality content and services</div>
                            </div>
                        </div>

                        <div class="why-us-item">
                            <div class="why-us-icon">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <div>
                                <div class="why-us-heading">Wide Range of Categories</div>
                                <div class="why-us-desc">Courses, services, products & businesses</div>
                            </div>
                        </div>

                        <div class="why-us-item">
                            <div class="why-us-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <div class="why-us-heading">Secure Payments</div>
                                <div class="why-us-desc">100% safe and secure</div>
                            </div>
                        </div>

                        <div class="why-us-item">
                            <div class="why-us-icon">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <div class="why-us-heading">Real Reviews & Ratings</div>
                                <div class="why-us-desc">Make better decisions</div>
                            </div>
                        </div>

                        <div class="why-us-item">
                            <div class="why-us-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div>
                                <div class="why-us-heading">Support When You Need It</div>
                                <div class="why-us-desc">Our team is always here to help</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget 2: Join 10,000+ Sellers -->
                <div class="join-sellers-box">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <i class="fa-solid fa-chart-line fs-3"></i>
                        <span class="badge bg-white text-primary fw-bold">Seller Hub</span>
                    </div>
                    <div class="join-sellers-title">Join 10,000+ Sellers and Grow Your Business</div>
                    <a href="{{ route('sell-courses.landing') }}" class="btn-join-sellers">
                        <span>Start Selling Now</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Widget 3: List Your Business -->
                <div class="list-biz-box">
                    <div class="list-biz-title">
                        <i class="fa-solid fa-store me-1"></i> List Your Business
                    </div>
                    <div class="list-biz-desc">Get discovered by thousands of customers</div>
                    <a href="{{ route('seller.register') }}" class="btn-list-biz">
                        <span>Add Business for Free</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. BOTTOM STATS & TRUST STRIP -->
<section class="bottom-stats-strip">
    <div class="container-fluid px-lg-5">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-metric-col">
                    <div class="stat-metric-icon bg-primary-subtle text-primary">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="text-start">
                        <div class="stat-metric-number">3M+</div>
                        <div class="stat-metric-label">Monthly Visitors</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-metric-col">
                    <div class="stat-metric-icon bg-success-subtle text-success">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="text-start">
                        <div class="stat-metric-number">10K+</div>
                        <div class="stat-metric-label">Courses</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-metric-col">
                    <div class="stat-metric-icon bg-info-subtle text-info">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div class="text-start">
                        <div class="stat-metric-number">5K+</div>
                        <div class="stat-metric-label">Services</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-metric-col">
                    <div class="stat-metric-icon bg-purple-subtle text-purple" style="background-color: #f3e8ff; color: #9333ea;">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="text-start">
                        <div class="stat-metric-number">10K+</div>
                        <div class="stat-metric-label">Products</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-metric-col">
                    <div class="stat-metric-icon bg-warning-subtle text-warning">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="text-start">
                        <div class="stat-metric-number">8K+</div>
                        <div class="stat-metric-label">Businesses</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-metric-col">
                    <div class="stat-metric-icon bg-amber-subtle text-warning" style="background-color: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="text-start">
                        <div class="stat-metric-number">4.8/5</div>
                        <div class="stat-metric-label">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Search Form Smart Router
    document.getElementById('heroMasterSearchForm').addEventListener('submit', function(e) {
        const cat = document.getElementById('heroCategorySelect').value;
        const q = document.getElementById('heroSearchQuery').value.trim();
        
        if (cat === 'courses') {
            e.preventDefault();
            window.location.href = "{{ route('courses') }}?search=" + encodeURIComponent(q);
        } else if (cat === 'services') {
            e.preventDefault();
            window.location.href = "{{ route('services') }}?search=" + encodeURIComponent(q);
        } else if (cat === 'products') {
            e.preventDefault();
            window.location.href = "{{ route('products') }}?search=" + encodeURIComponent(q);
        } else if (cat === 'businesses') {
            e.preventDefault();
            window.location.href = "{{ route('home') }}?search=" + encodeURIComponent(q);
        }
    });
</script>
@endpush
@endsection
