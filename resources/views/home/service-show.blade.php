@extends('layouts.app')

@section('title', $title . ' - Digital Class Services')

@section('styles')
<style>
    /* Service Detail Page Styles */
    .service-show-container {
        padding: 1.5rem 0 3.5rem;
        background-color: #f8fafc;
    }

    .service-breadcrumb {
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 1.25rem;
    }

    .service-breadcrumb a {
        color: #475569;
        text-decoration: none;
    }

    .service-breadcrumb a:hover {
        color: #0066ff;
    }

    /* Main Header Box */
    .service-header-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .badge-top-service {
        background-color: #ffedd5;
        color: #ea580c;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
    }

    .service-main-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.65rem;
    }

    .service-summary-text {
        font-size: 0.95rem;
        color: #475569;
        line-height: 1.55;
        margin-bottom: 1.25rem;
    }

    /* Seller Mini Row */
    .seller-mini-box {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
    }

    .seller-mini-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
    }

    .seller-mini-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .seller-mini-meta {
        font-size: 0.78rem;
        color: #64748b;
    }

    /* Hero Mockup Visual */
    .hero-mockup-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .mockup-header-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.2rem;
    }

    .mockup-header-title span {
        color: #ea580c;
    }

    .mockup-header-sub {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 1.25rem;
    }

    .mockup-center-screen {
        position: relative;
        text-align: center;
        margin: 0 auto;
        max-width: 620px;
    }

    .mockup-screen-img {
        width: 100%;
        height: 310px;
        object-fit: cover;
        border-radius: 12px;
        border: 6px solid #1e293b;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
    }

    .video-play-overlay-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 58px;
        height: 58px;
        background: rgba(15, 23, 42, 0.85);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        color: #ffffff;
        font-size: 1.35rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .video-play-overlay-btn:hover {
        transform: translate(-50%, -50%) scale(1.1);
        background: #0066ff;
        border-color: #0066ff;
    }

    .feature-tag-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Gallery Thumbnails */
    .service-gallery-row {
        display: flex;
        gap: 0.65rem;
        margin-bottom: 1.5rem;
        overflow-x: auto;
    }

    .gallery-thumb-item {
        flex: 0 0 80px;
        height: 54px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .gallery-thumb-item.active,
    .gallery-thumb-item:hover {
        border-color: #0066ff;
        transform: translateY(-2px);
    }

    .gallery-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-more-badge {
        flex: 0 0 80px;
        height: 54px;
        border-radius: 8px;
        background: #0f172a;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* 4 Trust Badges Row */
    .trust-badges-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        text-align: center;
        margin-bottom: 1.75rem;
    }

    .trust-bar-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: #334155;
    }

    /* Content Tabs */
    .service-content-tabs {
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1.5rem;
    }

    .service-nav-tab {
        padding: 0.65rem 0.25rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        position: relative;
        transition: all 0.2s;
    }

    .service-nav-tab.active,
    .service-nav-tab:hover {
        color: #0066ff;
    }

    .service-nav-tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: #0066ff;
        border-radius: 999px;
    }

    /* Feature Cards */
    .feature-icons-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.75rem;
        margin: 1.25rem 0 1.75rem;
    }

    .feature-icon-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem 0.5rem;
        text-align: center;
        transition: all 0.2s ease;
    }

    .feature-icon-card:hover {
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }

    .feature-icon-card i {
        font-size: 1.5rem;
        color: #0066ff;
        margin-bottom: 0.5rem;
    }

    .feature-icon-card span {
        font-size: 0.78rem;
        font-weight: 700;
        color: #1e293b;
        display: block;
        line-height: 1.25;
    }

    /* Why Choose Checkmarks */
    .why-choose-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.65rem 1.5rem;
        margin-top: 0.85rem;
    }

    .why-check-item {
        font-size: 0.84rem;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .why-check-item i {
        color: #16a34a;
        font-size: 0.95rem;
    }

    /* Live Website Example Card */
    .live-example-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        margin-top: 1.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .live-example-header {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .live-example-img {
        width: 100%;
        height: 260px;
        object-fit: cover;
    }

    /* Bottom Seller & Review Cards */
    .about-seller-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        margin-top: 1.75rem;
    }

    .seller-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        text-align: center;
        margin: 1.25rem 0;
    }

    .seller-stat-num {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
    }

    .seller-stat-lbl {
        font-size: 0.72rem;
        color: #64748b;
    }

    /* Client Reviews */
    .client-reviews-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        margin-top: 1.75rem;
    }

    .review-score-banner {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .review-big-num {
        font-size: 2.25rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .single-review-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    /* Right Sticky Package Box */
    .sticky-packages-card {
        position: sticky;
        top: 85px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.25rem;
    }

    .package-tabs-header {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .pkg-tab-btn {
        padding: 0.85rem 0.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: none;
        border-right: 1px solid #e2e8f0;
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pkg-tab-btn:last-child {
        border-right: none;
    }

    .pkg-tab-btn.active {
        background: #ffffff;
        color: #0066ff;
    }

    .popular-pill-badge {
        position: absolute;
        top: -9px;
        left: 50%;
        transform: translateX(-50%);
        background: #0066ff;
        color: #ffffff;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .package-body-content {
        padding: 1.5rem;
    }

    .pkg-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .pkg-price-val {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
    }

    .pkg-mrp-val {
        font-size: 1rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .pkg-discount-val {
        font-size: 0.75rem;
        font-weight: 700;
        color: #16a34a;
        background: #dcfce7;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
    }

    .pkg-title-label {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }

    .pkg-features-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem;
    }

    .pkg-features-list li {
        font-size: 0.82rem;
        color: #475569;
        margin-bottom: 0.55rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .pkg-features-list li i {
        color: #16a34a;
        font-size: 0.9rem;
        margin-top: 2px;
    }

    .btn-book-service {
        background: #0066ff;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: none;
        width: 100%;
        margin-bottom: 0.65rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-book-service:hover {
        background: #0052cc;
        color: #ffffff;
    }

    .btn-cart-service {
        background: transparent;
        color: #0f172a;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-cart-service:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    /* Small Sidebar Info Cards */
    .sidebar-widget-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem;
        margin-bottom: 1.15rem;
    }

    @media (max-width: 991px) {
        .trust-badges-bar {
            grid-template-columns: 1fr 1fr;
        }
        .feature-icons-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .why-choose-list {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="service-show-container">
    <div class="container-fluid px-lg-4">

        <!-- Breadcrumb -->
        <nav class="service-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('services') }}">Services</a>
            <span class="mx-2">/</span>
            <a href="{{ route('services', ['category' => $category]) }}">{{ $category }}</a>
            <span class="mx-2">/</span>
            <span class="text-dark fw-semibold">{{ $title }}</span>
        </nav>

        <div class="row g-4">
            <!-- ============================================== -->
            <!-- LEFT MAIN CONTENT                              -->
            <!-- ============================================== -->
            <div class="col-lg-8">

                <!-- Header Meta -->
                <div class="service-header-meta">
                    <span class="badge-top-service">{{ $badge }}</span>
                    <span class="text-warning fw-bold fs-7">
                        <i class="fa-solid fa-star"></i> {{ number_format($rating, 1) }}
                        <span class="text-muted fw-normal">({{ $reviews_count }} reviews)</span>
                    </span>
                    <span class="text-muted fs-7">
                        <i class="fa-solid fa-bag-shopping text-primary me-1"></i> {{ $orders_count }}
                    </span>
                </div>

                <h1 class="service-main-title">{{ $title }}</h1>
                <p class="service-summary-text">{{ $summary }}</p>

                <!-- Seller Mini Row -->
                <div class="seller-mini-box">
                    <img src="{{ $provider['avatar'] }}" alt="{{ $provider['name'] }}" class="seller-mini-avatar">
                    <div>
                        <div class="seller-mini-name">
                            {{ $provider['name'] }}
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle py-1 px-2" style="font-size: 0.68rem;">
                                <i class="fa-solid fa-circle-check"></i> Verified Seller
                            </span>
                        </div>
                        <div class="seller-mini-meta">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $provider['location'] }}
                            <span class="mx-2">|</span>
                            <i class="fa-regular fa-clock text-primary me-1"></i> {{ $provider['experience'] }}
                        </div>
                    </div>
                </div>

                <!-- Hero Visual / Laptop Mockup -->
                <div class="hero-mockup-wrapper">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="mockup-header-title">
                                {{ $hero_visual['title'] }}
                            </div>
                            <div class="mockup-header-sub">
                                {{ $hero_visual['subtitle'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Laptop Screen with Play Overlay -->
                    <div class="mockup-center-screen position-relative">
                        <img id="mainDisplayScreen" src="{{ $hero_visual['image'] }}" alt="{{ $title }}" class="mockup-screen-img">
                        <div class="video-play-overlay-btn" title="Watch Demo Video" onclick="alert('Playing interactive live demo video for {{ $title }}')">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </div>

                    <!-- Overlay Feature Pills -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                        @foreach($hero_visual['overlay_tags'] as $ot)
                            <span class="feature-tag-pill">
                                <i class="fa-solid fa-check text-success"></i> {{ $ot }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Gallery Thumbnails -->
                <div class="service-gallery-row">
                    @foreach($gallery as $idx => $gImg)
                        <div class="gallery-thumb-item {{ $idx === 0 ? 'active' : '' }}" onclick="changeMainScreen('{{ $gImg }}', this)">
                            <img src="{{ $gImg }}" alt="Screen {{ $idx + 1 }}">
                        </div>
                    @endforeach
                    <div class="gallery-more-badge" onclick="alert('Viewing full 12+ high-resolution portfolio screens.')">
                        <span>+8</span>
                        <span>More Screens</span>
                    </div>
                </div>

                <!-- 4 Trust Badges Row -->
                <div class="trust-badges-bar">
                    @foreach($trust_badges as $tb)
                        <div class="trust-bar-item">
                            <i class="{{ $tb['icon'] }} {{ $tb['color'] }} fs-5"></i>
                            <span>{{ $tb['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Tabs -->
                <div class="service-content-tabs">
                    <a href="#tabOverview" class="service-nav-tab active">Overview</a>
                    <a href="#tabPackages" class="service-nav-tab">Packages</a>
                    <a href="#tabPortfolio" class="service-nav-tab">Portfolio</a>
                    <a href="#tabReviews" class="service-nav-tab">Reviews ({{ $reviews_count }})</a>
                    <a href="#tabFaqs" class="service-nav-tab">FAQs</a>
                </div>

                <!-- TAB: Overview -->
                <div id="tabOverview">
                    <h4 class="fw-bold fs-5 text-dark mb-2">About This Service</h4>
                    <p class="text-secondary small leading-relaxed">{{ $about_service }}</p>

                    <!-- 5 Feature Cards -->
                    <div class="feature-icons-grid">
                        @foreach($feature_boxes as $fb)
                            <div class="feature-icon-card">
                                <i class="{{ $fb['icon'] }}"></i>
                                <span>{{ $fb['title'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Why Choose Our Service -->
                    <div class="bg-white border rounded-4 p-4 mb-4">
                        <h5 class="fw-bold fs-6 text-dark mb-3">Why Choose Our Service?</h5>
                        <div class="why-choose-list">
                            @foreach($why_choose_us as $wcu)
                                <div class="why-check-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>{{ $wcu }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Live Website Example -->
                    <div class="live-example-card" id="tabPortfolio">
                        <div class="live-example-header">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Live Website Example</h6>
                                <small class="text-muted">{{ $live_example['title'] }}</small>
                            </div>
                            <a href="{{ $live_example['live_url'] }}" target="_blank" class="btn btn-outline-primary btn-sm px-3 fw-bold">
                                View Live <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                        <img src="{{ $live_example['image'] }}" alt="{{ $live_example['title'] }}" class="live-example-img">
                        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
                            <span class="small text-secondary">{{ $live_example['tagline'] }}</span>
                            <span class="badge bg-primary-subtle text-primary">+8 More Examples</span>
                        </div>
                    </div>

                    <!-- About the Seller -->
                    <div class="about-seller-card">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $provider['avatar'] }}" alt="{{ $provider['name'] }}" class="rounded-circle shadow-sm" style="width: 58px; height: 58px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">
                                    {{ $provider['name'] }}
                                    <span class="badge bg-primary text-white fs-8 ms-1">
                                        <i class="fa-solid fa-check"></i> Verified Seller
                                    </span>
                                </h5>
                                <p class="text-secondary small mb-1">{{ $provider['specialty_desc'] }}</p>
                                <div class="small text-muted">
                                    <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $provider['location'] }}
                                    <span class="mx-2">•</span>
                                    <i class="fa-regular fa-calendar text-primary me-1"></i> {{ $provider['member_since'] }}
                                </div>
                            </div>
                        </div>

                        <!-- 4 Stats -->
                        <div class="seller-stats-row">
                            <div>
                                <div class="seller-stat-num">{{ $provider['orders_completed'] }}</div>
                                <div class="seller-stat-lbl">Orders Completed</div>
                            </div>
                            <div>
                                <div class="seller-stat-num text-warning">
                                    <i class="fa-solid fa-star"></i> {{ number_format($provider['rating'], 1) }}
                                </div>
                                <div class="seller-stat-lbl">Average Rating</div>
                            </div>
                            <div>
                                <div class="seller-stat-num text-success">{{ $provider['on_time_delivery'] }}</div>
                                <div class="seller-stat-lbl">On-Time Delivery</div>
                            </div>
                            <div>
                                <div class="seller-stat-num">{{ $provider['reviews_count'] }}</div>
                                <div class="seller-stat-lbl">Reviews</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('business.show', 'vcec') }}" class="btn btn-outline-secondary btn-sm px-3 fw-bold">View Profile</a>
                            <button type="button" class="btn btn-primary btn-sm px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#contactSellerModal">
                                Contact Seller
                            </button>
                        </div>
                    </div>

                    <!-- Client Reviews -->
                    <div class="client-reviews-card" id="tabReviews">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">Client Reviews</h5>
                            <button type="button" class="btn btn-outline-primary btn-sm px-3 fw-bold" onclick="alert('Review submission form will open.')">
                                Write a Review
                            </button>
                        </div>

                        <div class="review-score-banner">
                            <div class="review-big-num">{{ number_format($rating, 1) }}</div>
                            <div>
                                <div class="text-warning fs-5">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="small text-muted">{{ $reviews_count }} verified reviews</div>
                            </div>
                        </div>

                        @foreach($reviews as $rv)
                            <div class="single-review-item">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $rv['avatar'] }}" alt="{{ $rv['name'] }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark fs-7">{{ $rv['name'] }}</div>
                                        <div class="d-flex align-items-center gap-1 small">
                                            <span class="text-warning">
                                                @for($i = 0; $i < $rv['rating']; $i++) <i class="fa-solid fa-star fs-8"></i> @endfor
                                            </span>
                                            <span class="text-muted ms-1 fs-8">{{ $rv['time'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="small text-secondary mb-0">{{ $rv['comment'] }}</p>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- ============================================== -->
            <!-- RIGHT STICKY SIDEBAR: PRICING & QUOTES         -->
            <!-- ============================================== -->
            <div class="col-lg-4">
                <div class="sticky-packages-card" id="tabPackages">
                    <!-- 3 Package Switcher Tabs -->
                    <div class="package-tabs-header">
                        @foreach(['basic' => 'Basic', 'standard' => 'Standard', 'premium' => 'Premium'] as $pKey => $pLabel)
                            <button type="button" class="pkg-tab-btn {{ $pKey === 'standard' ? 'active' : '' }}" 
                                    id="pkgBtn_{{ $pKey }}" onclick="switchPackage('{{ $pKey }}')">
                                @if($pKey === 'standard')
                                    <span class="popular-pill-badge">Most Popular</span>
                                @endif
                                {{ $pLabel }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Package Dynamic Content -->
                    <div class="package-body-content">
                        <div class="pkg-price-row">
                            <span class="pkg-price-val" id="pkgPriceVal">₹{{ number_format($packages['standard']['price']) }}</span>
                            <span class="pkg-mrp-val" id="pkgMrpVal">₹{{ number_format($packages['standard']['mrp']) }}</span>
                            <span class="pkg-discount-val" id="pkgDiscountVal">{{ $packages['standard']['discount'] }}% OFF</span>
                        </div>

                        <div class="pkg-title-label" id="pkgTitleVal">{{ $packages['standard']['package_title'] }}</div>

                        <!-- Feature Checklist -->
                        <ul class="pkg-features-list" id="pkgFeaturesList">
                            @foreach($packages['standard']['features'] as $feat)
                                <li>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>{{ $feat }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <form action="{{ route('service.book', $slug) }}" method="POST">
                            @csrf
                            <input type="hidden" name="package" id="selectedPackageInput" value="standard">
                            <button type="submit" class="btn-book-service">
                                <span>Book This Service</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>

                        <button type="button" class="btn-cart-service" onclick="alert('Service added to your cart!')">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Add to Cart</span>
                        </button>

                        <div class="text-center mt-3">
                            <a href="javascript:void(0)" class="small text-muted text-decoration-none" data-bs-toggle="modal" data-bs-target="#contactSellerModal">
                                <i class="fa-regular fa-comments text-primary me-1"></i>
                                Need Custom Requirements? <strong class="text-primary">Contact Seller</strong>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Need Something Custom? Widget -->
                <div class="sidebar-widget-card bg-light">
                    <div class="d-flex align-items-start gap-3 mb-2">
                        <div class="bg-success-subtle text-success p-2 rounded-3 fs-5">
                            <i class="fa-solid fa-file-pen"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Need Something Custom?</h6>
                            <p class="small text-muted mb-0">Tell us your requirements and get a custom quote for your project.</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-dark btn-sm w-100 fw-bold py-2 mt-2" data-bs-toggle="modal" data-bs-target="#customQuoteModal">
                        Get a Custom Quote <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                </div>

                <!-- Delivery Time Widget -->
                <div class="sidebar-widget-card">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-warning-subtle text-warning p-2 rounded-3 fs-5">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Delivery Time</h6>
                            <div class="small text-secondary mb-1">
                                Standard delivery: <strong>{{ $packages['standard']['delivery'] }}</strong>
                            </div>
                            <div class="small text-muted">
                                Express delivery: <strong>3 Days</strong> (Extra charges)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Services Widget -->
                @if(!empty($related_services))
                    <div class="sidebar-widget-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">Related Services</h6>
                            <a href="{{ route('services') }}" class="small text-primary fw-bold text-decoration-none">View All &rarr;</a>
                        </div>

                        @foreach($related_services as $rs)
                            <a href="{{ route('service.show', $rs['slug']) }}" class="text-decoration-none text-dark d-flex gap-3 mb-3 pb-3 border-bottom">
                                <img src="{{ $rs['thumbnail'] }}" alt="{{ $rs['title'] }}" class="rounded-3" style="width: 72px; height: 55px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold fs-7 mb-1 text-truncate" style="max-width: 180px;">{{ $rs['title'] }}</div>
                                    <div class="small text-warning mb-1">
                                        <i class="fa-solid fa-star"></i> {{ number_format($rs['rating'], 1) }}
                                        <span class="text-muted">({{ $rs['reviews_count'] }})</span>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-1">
                                        <span class="fw-bold text-dark">₹{{ number_format($rs['price']) }}</span>
                                        <span class="text-muted text-decoration-line-through fs-8">₹{{ number_format($rs['mrp']) }}</span>
                                        <span class="badge bg-success-subtle text-success fs-8">{{ $rs['discount'] }}% OFF</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

<!-- Contact Seller Modal -->
<div class="modal fade" id="contactSellerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-3 px-4">
                <h5 class="modal-title fw-bold fs-6">
                    <i class="fa-solid fa-message me-2"></i> Contact {{ $provider['name'] }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form onsubmit="event.preventDefault(); alert('Your message has been sent to {{ $provider['name'] }}. They will reply within 30 minutes.'); bootstrap.Modal.getInstance(document.getElementById('contactSellerModal')).hide();">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Your Name *</label>
                        <input type="text" class="form-control form-control-sm" required placeholder="Enter full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Mobile / WhatsApp *</label>
                        <input type="tel" class="form-control form-control-sm" required placeholder="+91 98765 43210">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Message / Questions *</label>
                        <textarea class="form-control form-control-sm" rows="3" required placeholder="Ask about timeline, custom features, demo access..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Quote Modal -->
<div class="modal fade" id="customQuoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white p-3 px-4">
                <h5 class="modal-title fw-bold fs-6">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i> Request Custom Quote
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('service.quote', $slug) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Project Title *</label>
                        <input type="text" name="title" class="form-control form-control-sm" required value="Custom {{ $title }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Describe Your Scope &amp; Needs *</label>
                        <textarea name="details" class="form-control form-control-sm" rows="3" required placeholder="Describe any extra features, integrations, or specific timelines..."></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Expected Budget (₹)</label>
                            <input type="number" name="budget" class="form-control form-control-sm" placeholder="e.g. 15000">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Contact Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" required placeholder="+91 98765 43210">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold">Request Quote</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const packageData = @json($packages);

    function switchPackage(pkgKey) {
        // Toggle active button
        document.querySelectorAll('.pkg-tab-btn').forEach(b => b.classList.remove('active'));
        const activeBtn = document.getElementById('pkgBtn_' + pkgKey);
        if (activeBtn) activeBtn.classList.add('active');

        const pkg = packageData[pkgKey];
        if (!pkg) return;

        document.getElementById('selectedPackageInput').value = pkgKey;
        document.getElementById('pkgPriceVal').innerText = '₹' + parseInt(pkg.price).toLocaleString();
        document.getElementById('pkgMrpVal').innerText = '₹' + parseInt(pkg.mrp).toLocaleString();
        document.getElementById('pkgDiscountVal').innerText = pkg.discount + '% OFF';
        document.getElementById('pkgTitleVal').innerText = pkg.package_title;

        const listEl = document.getElementById('pkgFeaturesList');
        listEl.innerHTML = '';
        pkg.features.forEach(f => {
            const li = document.createElement('li');
            li.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>' + f + '</span>';
            listEl.appendChild(li);
        });
    }

    function changeMainScreen(imgSrc, element) {
        document.getElementById('mainDisplayScreen').src = imgSrc;
        document.querySelectorAll('.gallery-thumb-item').forEach(el => el.classList.remove('active'));
        if (element) element.classList.add('active');
    }
</script>
@endsection
