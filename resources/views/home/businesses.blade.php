@extends('layouts.app')

@section('title', 'Discover Trusted Businesses & Institutes Near You - Digital Class')

@section('styles')
<style>
    /* ==========================================================================
       HERO SECTION WITH CITY PANORAMA
       ========================================================================== */
    .hero-marketplace {
        position: relative;
        background: radial-gradient(circle at 85% 15%, rgba(0, 102, 255, 0.12) 0%, transparent 45%),
                    radial-gradient(circle at 10% 85%, rgba(14, 165, 233, 0.08) 0%, transparent 40%),
                    linear-gradient(90deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.92) 40%, rgba(255, 255, 255, 0.45) 75%, rgba(255, 255, 255, 0.15) 100%),
                    url('https://images.unsplash.com/photo-1596176530529-78163a4f7af2?w=1600&auto=format&fit=crop&q=80') center right / cover no-repeat;
        border-bottom: 1px solid #e2e8f0;
        padding: 3.25rem 0 2.75rem;
        overflow: hidden;
    }

    .hero-tag {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #1d4ed8;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        margin-bottom: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        box-shadow: 0 2px 6px rgba(0, 102, 255, 0.08);
    }

    .hero-title {
        font-size: 2.65rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.15;
        color: #0f172a;
        margin-bottom: 0.65rem;
    }

    .hero-subtitle {
        font-size: 0.925rem;
        color: #475569;
        max-width: 580px;
        line-height: 1.5;
        margin-bottom: 1.45rem;

    }

    /* Floating Hero Search Box (AirBNB / Google Style) */
    .hero-search-box {
        background: #ffffff;
        border: 1px solid rgba(203, 213, 225, 0.8);
        border-radius: 999px;
        box-shadow: 0 16px 36px -4px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(226, 232, 240, 0.8);
        padding: 0.35rem 0.45rem;
        max-width: 660px;
        transition: all 0.2s ease;
    }
    .hero-search-box:focus-within {
        border-color: #0066ff;
        box-shadow: 0 20px 40px -4px rgba(0, 102, 255, 0.16), 0 0 0 3px rgba(0, 102, 255, 0.15);
    }

    .hero-search-input {
        border: none;
        outline: none;
        font-size: 0.875rem;
        padding: 0.65rem 0.85rem;
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
        padding: 0.65rem 0.85rem;
        color: #334155;
        background: transparent;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-hero-search {
        background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.65rem 1.6rem;
        border-radius: 999px;
        border: none;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        box-shadow: 0 4px 14px rgba(0, 102, 255, 0.35);
    }
    .btn-hero-search:hover {
        background: linear-gradient(135deg, #0052cc 0%, #004099 100%);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.45);
    }

    /* Popular Searches Pills */
    .popular-pills {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.35rem;
        margin-top: 1rem;
        font-size: 0.75rem;
    }

    .popular-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.25rem 0.75rem;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .popular-pill:hover {
        border-color: #0066ff;
        color: #0066ff;
        background: #eff6ff;
        transform: translateY(-1px);
    }

    /* Hero Right Trust Callout */
    .hero-trust-box {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 1.35rem 1.45rem;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.5);
    }

    .script-slogan {
        font-family: 'Outfit', cursive, sans-serif;
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.85rem;
        position: relative;
    }
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
       CATEGORY ICONS HORIZONTAL BAR (Matching Pastel Squircle Badges)
       ========================================================================== */
    .category-bar-wrapper {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.15rem 0 0.85rem;
    }

    .category-scroll-container {
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        gap: 0.85rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
        padding-bottom: 6px;
        -webkit-overflow-scrolling: touch;
    }
    .category-scroll-container::-webkit-scrollbar {
        height: 5px;
    }
    .category-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    .cat-pill-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        flex: 1 1 0;
        min-width: 90px;
        max-width: 120px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        text-align: center;
        padding: 0.25rem 0.2rem;
        border-radius: 14px;
        border: none;
        background: transparent;
        box-shadow: none;
        flex-shrink: 0;
    }
    .cat-pill-btn:hover {
        transform: translateY(-3px);
        background: transparent;
        border-color: transparent;
        box-shadow: none;
    }
    .cat-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin-bottom: 0.55rem;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        position: relative;
    }
    .cat-pill-btn:hover .cat-icon-box {
        transform: scale(1.08);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }
    .cat-pill-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.25;
        text-align: center;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
        white-space: normal;
        word-break: break-word;
    }
    .cat-pill-btn:hover .cat-pill-label {
        color: #0066ff;
    }
    .cat-pill-btn.active {
        background: transparent;
        border-color: transparent;
        box-shadow: none;
    }
    .cat-pill-btn.active .cat-icon-box {
        box-shadow: 0 0 0 3px #0066ff, 0 8px 18px rgba(0, 102, 255, 0.25);
        transform: scale(1.06);
    }
    .cat-pill-btn.active .cat-pill-label {
        color: #0066ff;
        font-weight: 800;
    }
    @media (max-width: 991px) {
        .category-bar-wrapper {
            padding: 0.85rem 0 0.65rem;
        }
        .cat-pill-btn {
            min-width: 78px;
        }
        .cat-icon-box {
            width: 46px;
            height: 46px;
            font-size: 1.2rem;
            border-radius: 14px;
        }
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

    /* Luxury Business Card Grid & Cards */
    .business-grid-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    }
    .business-grid-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 42px -10px rgba(245, 158, 11, 0.2), 0 8px 18px -4px rgba(15, 23, 42, 0.06);
        border-color: rgba(245, 158, 11, 0.45);
    }

    .card-thumb-wrapper {
        position: relative;
        width: 100%;
        height: 160px;
        background: #f8fafc;
        overflow: hidden;
    }
    .card-thumb-wrapper::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.04) 0%, transparent 40%, rgba(15, 23, 42, 0.35) 100%);
        pointer-events: none;
    }
    .card-thumb-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .business-grid-card:hover .card-thumb-wrapper img {
        transform: scale(1.08);
    }

    .card-badge-pill {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        letter-spacing: 0.02em;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .card-badge-featured {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.98) 0%, rgba(217, 119, 6, 1) 100%);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35);
    }
    .card-badge-premium {
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.98) 0%, rgba(109, 40, 217, 1) 100%);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(109, 40, 217, 0.35);
    }
    .card-badge-verified {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.98) 0%, rgba(2, 132, 199, 1) 100%);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
    }
    .card-badge-high-support {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.98) 0%, rgba(5, 150, 105, 1) 100%);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.35);
    }

    .card-heart-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    }
    .card-heart-btn:hover {
        background: #ffffff;
        transform: scale(1.15);
        color: #dc2626;
        box-shadow: 0 6px 14px rgba(239, 68, 68, 0.25);
    }
    .card-heart-btn.active i {
        font-weight: 900;
    }

    .card-content-body {
        padding: 1.1rem 1.1rem 0.85rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .business-card-title {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.4rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.7em;
        transition: color 0.2s ease;
    }
    .business-grid-card:hover .business-card-title a {
        color: #d97706 !important;
    }

    .card-rating-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        margin-bottom: 0.45rem;
    }

    .card-location-row {
        font-size: 0.78rem;
        color: #64748b;
        margin-bottom: 0.6rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-tag-pill {
        background: #f8fafc;
        color: #475569;
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        display: inline-block;
        margin-right: 0.3rem;
        margin-bottom: 0.3rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .card-tag-pill:hover {
        border-color: #cbd5e1;
        color: #0f172a;
    }

    /* Action Buttons Row */
    .card-actions-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0.5rem;
        padding: 0.85rem 1.1rem 1.1rem;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
    }

    .btn-card-action {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.5rem 0.35rem;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
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
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.28);
        transform: translateY(-1px);
    }

    .btn-card-wa {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        border: 1px solid #16a34a;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.28);
    }
    .btn-card-wa:hover {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        border-color: #15803d;
        color: #ffffff;
        box-shadow: 0 6px 14px rgba(34, 197, 94, 0.4);
        transform: translateY(-1px);
    }

    .btn-card-view {
        background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
        border: 1px solid #0052cc;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 102, 255, 0.28);
    }
    .btn-card-view:hover {
        background: linear-gradient(135deg, #0052cc 0%, #004099 100%);
        border-color: #004099;
        color: #ffffff;
        box-shadow: 0 6px 14px rgba(0, 102, 255, 0.4);
        transform: translateY(-1px);
    }
        box-shadow: 0 4px 10px rgba(0, 102, 255, 0.25);
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

    .hover-shadow-lg {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
    }

    /* Mobile Responsive Polish */
    @media (max-width: 767px) {
        .hero-marketplace {
            padding: 2rem 0 1.75rem;
        }
        .hero-title {
            font-size: 1.85rem;
        }
        .hero-subtitle {
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
        .hero-search-box {
            border-radius: 14px;
            padding: 0.25rem;
        }
        .card-thumb-wrapper {
            height: 135px;
        }
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
                    <span class="dc-live-dot me-1"></span>
                    <i class="fa-solid fa-building-columns me-1 text-primary"></i> 50,000+ Verified Local Businesses & Institutes
                </span>
                
                <h1 class="hero-title">
                    Discover Trusted<br>
                    <span style="background: linear-gradient(135deg, #0066ff 0%, #00c6ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Businesses Near You</span>
                </h1>
                
                <p class="hero-subtitle">
                    Find schools, coaching institutes, training centers, shops, service centers and verified businesses &mdash; all in one place.
                </p>

                <!-- Search Box -->
                <form action="{{ route('businesses') }}" method="GET" class="hero-search-box d-flex align-items-center">
                    <div class="d-flex align-items-center flex-grow-1 px-2">
                        <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                        <input type="text" name="search" value="{{ $searchQuery }}" class="hero-search-input flex-grow-1" placeholder="Search by business name, category or location">
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-location-dot text-primary ms-2 me-1"></i>
                        <select name="city" class="hero-location-select" id="heroCitySelect" onchange="handleHeroCityChange(this)">
                            <option value="near_me" {{ in_array($selectedCity, ['Near Me', 'near_me']) ? 'selected' : '' }}>📍 Near Me (GPS)</option>
                            <option value="All Locations" {{ ($selectedCity === 'All Locations' || !$selectedCity) ? 'selected' : '' }}>All India</option>
                            <optgroup label="Popular Cities">
                                <option value="Mumbai" {{ $selectedCity === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                                <option value="Delhi NCR" {{ $selectedCity === 'Delhi NCR' ? 'selected' : '' }}>Delhi NCR</option>
                                <option value="Bengaluru" {{ $selectedCity === 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
                                <option value="Ahmedabad" {{ $selectedCity === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                                <option value="Pune" {{ $selectedCity === 'Pune' ? 'selected' : '' }}>Pune</option>
                                <option value="Surat" {{ $selectedCity === 'Surat' ? 'selected' : '' }}>Surat</option>
                                <option value="Vadodara" {{ $selectedCity === 'Vadodara' ? 'selected' : '' }}>Vadodara</option>
                                <option value="Jaipur" {{ $selectedCity === 'Jaipur' ? 'selected' : '' }}>Jaipur</option>
                                <option value="Indore" {{ $selectedCity === 'Indore' ? 'selected' : '' }}>Indore</option>
                                <option value="Rajkot" {{ $selectedCity === 'Rajkot' ? 'selected' : '' }}>Rajkot</option>
                                <option value="Gandhinagar" {{ $selectedCity === 'Gandhinagar' ? 'selected' : '' }}>Gandhinagar</option>
                            </optgroup>
                            <optgroup label="States & Territories">
                                @foreach($sidebarStates as $st)
                                    <option value="{{ $st['name'] }}" {{ ($selectedCity === $st['name'] || ($selectedState ?? '') === $st['name']) ? 'selected' : '' }}>
                                        {{ $st['name'] }} ({{ number_format($st['count']) }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        <input type="hidden" name="lat" id="heroLat" value="{{ request('lat') }}">
                        <input type="hidden" name="lng" id="heroLng" value="{{ request('lng') }}">
                    </div>

                    <button type="submit" class="btn-hero-search ms-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </form>

                <!-- Popular Searches Pills -->
                <div class="popular-pills">
                    <span class="text-muted fw-bold me-1">Popular Searches:</span>
                    <a href="{{ route('businesses', ['search' => 'Computer Classes']) }}" class="popular-pill">Computer Classes</a>
                    <a href="{{ route('businesses', ['category' => 'Coaching Institute']) }}" class="popular-pill">Coaching Institute</a>
                    <a href="{{ route('businesses', ['search' => 'Tuition Classes']) }}" class="popular-pill">Tuition Classes</a>
                    <a href="{{ route('businesses', ['search' => 'Laptop Repair']) }}" class="popular-pill">Laptop Repair</a>
                    <a href="{{ route('businesses', ['category' => 'Gym & Fitness']) }}" class="popular-pill">Gym</a>
                    <a href="{{ route('businesses', ['search' => 'Dance Class']) }}" class="popular-pill">Dance Class</a>
                    <a href="{{ route('businesses', ['category' => 'Play School']) }}" class="popular-pill">Play School</a>
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

                    <div class="trust-badge-item" onclick="detectGlobalNavLocation()" style="cursor: pointer;" title="Click to find businesses near your current GPS location">
                        <div class="trust-icon-pill bg-info-subtle text-info">
                            <i class="fa-solid fa-location-crosshairs"></i>
                        </div>
                        <div>
                            <div class="fw-bold small text-dark d-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                <span>Find Near You</span>
                                <span class="badge bg-primary text-white" style="font-size: 0.6rem;">GPS</span>
                            </div>
                            <div class="text-muted" style="font-size: 0.68rem;">Click for Instant Proximity Search</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================================================
     2. CATEGORY HORIZONTAL BAR (Matching Pastel Squircle Badges)
     ============================================================================ -->
<div class="category-bar-wrapper">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="category-scroll-container">
            @foreach($horizontalCategories as $cat)
                @php
                    $isCatActive = ($selectedCategory === $cat['name'] || ($selectedCategory === 'All Businesses' && $cat['name'] === 'All Businesses') || ($selectedCategory === $cat['slug']));
                    $catParam = ($cat['name'] === 'All Businesses' || $cat['slug'] === 'all') ? '' : $cat['slug'];
                    $catQuery = array_merge(request()->query(), ['category' => $catParam]);
                    if (empty($catParam)) unset($catQuery['category']);
                    $catUrl = route('businesses', $catQuery);
                @endphp
                <a href="{{ $catUrl }}"
                   class="cat-pill-btn {{ $isCatActive ? 'active' : '' }}" title="{{ $cat['name'] }}">
                    <div class="cat-icon-box" style="background-color: {{ $cat['bg'] ?? '#f8fafc' }}; border: 1.5px solid {{ $cat['border'] ?? '#e2e8f0' }}; color: {{ $cat['color'] ?? '#0066ff' }};">
                        <i class="{{ $cat['icon'] }}"></i>
                    </div>
                    <span class="cat-pill-label">{{ $cat['name'] }}</span>
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
                <form id="homeFilterForm" action="{{ route('businesses') }}" method="GET" class="filter-card mb-3">
                    @if($searchQuery)
                        <input type="hidden" name="search" value="{{ $searchQuery }}">
                    @endif
                    <input type="hidden" name="sort" id="filterSortInput" value="{{ $sortBy }}">

                    <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                        <div class="fw-bold text-dark" style="font-size: 0.875rem;">
                            <i class="fa-solid fa-sliders me-1 text-primary"></i> Filters
                        </div>
                        <a href="{{ route('businesses') }}" class="text-decoration-none small text-primary fw-semibold">Clear All</a>
                    </div>

                    <!-- Location Selector -->
                    <div class="mb-3">
                        <div class="filter-section-title">Location & Proximity</div>
                        <button type="button" class="btn btn-sm btn-outline-primary w-100 mb-2 fw-semibold d-flex align-items-center justify-content-center gap-1.5" onclick="detectSidebarLocation()">
                            <i class="fa-solid fa-location-crosshairs"></i> <span id="btnSidebarLocText">Use Current Location</span>
                        </button>
                        <select name="city" id="sidebarCitySelect" class="form-select form-select-sm mb-2" onchange="handleSidebarCityChange(this)">
                            <option value="near_me" {{ in_array($selectedCity, ['Near Me', 'near_me']) ? 'selected' : '' }}>📍 Near Me (GPS)</option>
                            <option value="All Locations" {{ ($selectedCity === 'All Locations' || !$selectedCity) ? 'selected' : '' }}>All India</option>
                            <optgroup label="Popular Cities">
                                <option value="Mumbai" {{ $selectedCity === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                                <option value="Delhi NCR" {{ $selectedCity === 'Delhi NCR' ? 'selected' : '' }}>Delhi NCR</option>
                                <option value="Bengaluru" {{ $selectedCity === 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
                                <option value="Ahmedabad" {{ $selectedCity === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                                <option value="Pune" {{ $selectedCity === 'Pune' ? 'selected' : '' }}>Pune</option>
                                <option value="Surat" {{ $selectedCity === 'Surat' ? 'selected' : '' }}>Surat</option>
                                <option value="Vadodara" {{ $selectedCity === 'Vadodara' ? 'selected' : '' }}>Vadodara</option>
                                <option value="Jaipur" {{ $selectedCity === 'Jaipur' ? 'selected' : '' }}>Jaipur</option>
                                <option value="Indore" {{ $selectedCity === 'Indore' ? 'selected' : '' }}>Indore</option>
                                <option value="Rajkot" {{ $selectedCity === 'Rajkot' ? 'selected' : '' }}>Rajkot</option>
                                <option value="Gandhinagar" {{ $selectedCity === 'Gandhinagar' ? 'selected' : '' }}>Gandhinagar</option>
                            </optgroup>
                            <optgroup label="States & Territories">
                                @foreach($sidebarStates as $st)
                                    <option value="{{ $st['name'] }}" {{ ($selectedCity === $st['name'] || ($selectedState ?? '') === $st['name']) ? 'selected' : '' }}>
                                        {{ $st['name'] }} ({{ number_format($st['count']) }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        <select name="distance" class="form-select form-select-sm text-muted" onchange="document.getElementById('homeFilterForm').submit()">
                            <option value="all" {{ ($selectedDistance ?? 'all') === 'all' ? 'selected' : '' }}>Any Distance</option>
                            <option value="5" {{ ($selectedDistance ?? '') === '5' ? 'selected' : '' }}>Within 5 km</option>
                            <option value="10" {{ ($selectedDistance ?? '') === '10' ? 'selected' : '' }}>Within 10 km</option>
                            <option value="25" {{ ($selectedDistance ?? '') === '25' ? 'selected' : '' }}>Within 25 km</option>
                            <option value="50" {{ ($selectedDistance ?? '') === '50' ? 'selected' : '' }}>Within 50 km</option>
                        </select>
                        <input type="hidden" name="lat" id="sidebarLat" value="{{ request('lat') }}">
                        <input type="hidden" name="lng" id="sidebarLng" value="{{ request('lng') }}">
                    </div>

                    <!-- State Filter (All Indian States with real listing counts) -->
                    <div class="mb-3">
                        <div class="filter-section-title d-flex align-items-center justify-content-between">
                            <span>State</span>
                            @if(!empty($selectedState))
                                <a href="javascript:void(0)" onclick="clearStateFilter()" class="text-primary small text-decoration-none" style="font-size: 0.72rem;">Clear</a>
                            @endif
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" id="stateFilterSearch" class="form-control" placeholder="Search states..." onkeyup="filterStateCheckboxes(this.value)">
                        </div>
                        <div id="stateCheckboxesContainer" style="max-height: 220px; overflow-y: auto; padding-right: 4px;">
                            <div class="filter-check-item">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="state" value="" id="state_all"
                                           {{ empty($selectedState) ? 'checked' : '' }}
                                           onchange="document.getElementById('homeFilterForm').submit()">
                                    <label class="form-check-label" for="state_all">
                                        All States
                                    </label>
                                </div>
                            </div>
                            @foreach($sidebarStates as $st)
                                <div class="filter-check-item state-check-row">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="state" value="{{ $st['name'] }}" id="state_{{ Str::slug($st['name']) }}"
                                               {{ ($selectedState === $st['name']) ? 'checked' : '' }}
                                               onchange="document.getElementById('homeFilterForm').submit()">
                                        <label class="form-check-label" for="state_{{ Str::slug($st['name']) }}">
                                            {{ $st['name'] }}
                                        </label>
                                    </div>
                                    @if(!empty($st['count']))
                                        <span class="filter-count">({{ number_format($st['count']) }})</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Business Category -->
                    <div class="mb-3">
                        <div class="filter-section-title">Business Category</div>
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" id="categoryFilterSearch" class="form-control" placeholder="Search categories..." onkeyup="filterCategoryCheckboxes(this.value)">
                        </div>
                        <div id="categoryCheckboxesContainer">
                            <div class="filter-check-item">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="" id="cat_all"
                                           {{ ($selectedCategory === 'All Businesses' || !$selectedCategory) ? 'checked' : '' }}
                                           onchange="document.getElementById('homeFilterForm').submit()">
                                    <label class="form-check-label" for="cat_all">
                                        All Businesses
                                    </label>
                                </div>
                            </div>
                            @foreach($sidebarCategories as $sc)
                                <div class="filter-check-item">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="category" value="{{ $sc['name'] }}" id="cat_{{ Str::slug($sc['name']) }}"
                                               {{ $selectedCategory === $sc['name'] ? 'checked' : '' }}
                                               onchange="document.getElementById('homeFilterForm').submit()">
                                        <label class="form-check-label" for="cat_{{ Str::slug($sc['name']) }}">
                                            {{ $sc['name'] }}
                                        </label>
                                    </div>
                                    @if(!empty($sc['count']) && (int)$sc['count'] > 0)
                                        <span class="filter-count">({{ $sc['count'] }})</span>
                                    @endif
                                </div>
                            @endforeach
                            <div class="filter-check-item more-category-item d-none">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="Retail Shops" id="cat_retail"
                                           {{ $selectedCategory === 'Retail Shops' ? 'checked' : '' }}
                                           onchange="document.getElementById('homeFilterForm').submit()">
                                    <label class="form-check-label" for="cat_retail">Retail Shops</label>
                                </div>
                            </div>
                            <div class="filter-check-item more-category-item d-none">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="Automotive" id="cat_auto"
                                           {{ $selectedCategory === 'Automotive' ? 'checked' : '' }}
                                           onchange="document.getElementById('homeFilterForm').submit()">
                                    <label class="form-check-label" for="cat_auto">Automotive</label>
                                </div>
                            </div>
                            <div class="filter-check-item more-category-item d-none">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="category" value="Electronics & Repair" id="cat_elec"
                                           {{ $selectedCategory === 'Electronics & Repair' ? 'checked' : '' }}
                                           onchange="document.getElementById('homeFilterForm').submit()">
                                    <label class="form-check-label" for="cat_elec">Electronics & Repair</label>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="toggleMoreCategories(this)" class="d-inline-block small text-primary text-decoration-none mt-1">Show More ▾</a>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-3">
                        <div class="filter-section-title">Rating</div>
                        @php
                            $ratingOptions = [
                                ['min' => '4.5', 'stars' => 5, 'label' => '4.5 & Above'],
                                ['min' => '4.0', 'stars' => 4, 'label' => '4.0 & Above'],
                                ['min' => '3.5', 'stars' => 3, 'label' => '3.5 & Above'],
                                ['min' => '3.0', 'stars' => 3, 'label' => '3.0 & Above'],
                            ];
                        @endphp
                        @foreach($ratingOptions as $ro)
                            <div class="filter-check-item">
                                <div class="form-check mb-0 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="radio" name="rating" id="rating_{{ $ro['min'] }}" value="{{ $ro['min'] }}"
                                           {{ $selectedRating == $ro['min'] ? 'checked' : '' }}
                                           onclick="handleRatingClick(this)"
                                           onchange="document.getElementById('homeFilterForm').submit()">
                                    <label class="form-check-label d-flex align-items-center" for="rating_{{ $ro['min'] }}">
                                        <span class="text-warning me-1">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fa-{{ $i <= $ro['stars'] ? 'solid' : 'regular' }} fa-star" style="font-size: 0.65rem;"></i>
                                            @endfor
                                        </span>
                                        <span style="font-size: 0.72rem;">{{ $ro['label'] }}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Facilities -->
                    <div class="mb-3">
                        <div class="filter-section-title">Facilities</div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="facility[]" value="Parking Available" id="fac_parking"
                                       {{ in_array('Parking Available', $selectedFacilities) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="fac_parking">Parking Available</label>
                            </div>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="facility[]" value="Online Classes" id="fac_online"
                                       {{ in_array('Online Classes', $selectedFacilities) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="fac_online">Online Classes</label>
                            </div>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="facility[]" value="Home Visit" id="fac_home"
                                       {{ in_array('Home Visit', $selectedFacilities) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="fac_home">Home Visit</label>
                            </div>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="facility[]" value="EMI Available" id="fac_emi"
                                       {{ in_array('EMI Available', $selectedFacilities) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="fac_emi">EMI Available</label>
                            </div>
                        </div>
                    </div>

                    <!-- Business Type -->
                    <div>
                        <div class="filter-section-title">Business Type</div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="business_type[]" value="Individual Business" id="type_individual"
                                       {{ in_array('Individual Business', $selectedBusinessTypes) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="type_individual">Individual Business</label>
                            </div>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="business_type[]" value="Franchise" id="type_franchise"
                                       {{ in_array('Franchise', $selectedBusinessTypes) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="type_franchise">Franchise</label>
                            </div>
                        </div>
                        <div class="filter-check-item">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="business_type[]" value="Verified Partner" id="type_partner"
                                       {{ in_array('Verified Partner', $selectedBusinessTypes) ? 'checked' : '' }}
                                       onchange="document.getElementById('homeFilterForm').submit()">
                                <label class="form-check-label" for="type_partner">Verified Partner</label>
                            </div>
                        </div>
                    </div>

                </form>
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
                                <a href="{{ route('businesses', ['category' => 'Coaching Institute']) }}" class="badge bg-white text-dark text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-school text-primary me-1"></i> Institutes
                                </a>
                                <a href="{{ route('businesses', ['category' => 'Retail Shops']) }}" class="badge bg-white text-dark text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-bag-shopping text-warning me-1"></i> Shops
                                </a>
                                <a href="{{ route('businesses', ['category' => 'Computer Training']) }}" class="badge bg-white text-dark text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
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
                            {{ count($businesses) }} {{ count($businesses) === 1 ? 'Business' : 'Businesses' }} in {{ $selectedCity }}
                        </h2>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Sort Dropdown -->
                        <div class="d-flex align-items-center gap-1 small text-muted">
                            <span>Sort by:</span>
                            <select class="form-select form-select-sm" style="font-size: 0.75rem; width: auto;" onchange="submitWithSort(this.value)">
                                <option value="suggested" {{ ($sortBy === 'suggested' || $sortBy === 'popular' || empty($sortBy)) ? 'selected' : '' }}>Suggested First (High Support)</option>
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
                                    <img src="{{ $b->display_image }}" alt="{{ $b->business_name }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80';">
                                    
                                    <div class="d-flex flex-column gap-1 position-absolute" style="top: 10px; left: 10px; z-index: 2;">
                                        @if($b->badge === 'Featured')
                                            <span class="card-badge-pill card-badge-featured position-static"><i class="fa-solid fa-crown me-1 text-warning"></i>Featured</span>
                                        @elseif($b->badge === 'Premium')
                                            <span class="card-badge-pill card-badge-premium position-static"><i class="fa-solid fa-gem me-1"></i>Premium</span>
                                        @elseif($b->badge === 'Verified')
                                            <span class="card-badge-pill card-badge-verified position-static"><i class="fa-solid fa-circle-check me-1"></i>Verified</span>
                                        @endif

                                        @if($b->hasHighSupport())
                                            <span class="card-badge-pill card-badge-high-support position-static" title="Dedicated High Priority Customer Support"><i class="fa-solid fa-headset me-1"></i>High Support</span>
                                        @endif
                                    </div>

                                    <button class="card-heart-btn" onclick="toggleFavorite(this, '{{ addslashes($b->business_name) }}')" title="Save to favorites">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>

                                <!-- Card Body -->
                                <div class="card-content-body">
                                    <div class="d-flex align-items-start gap-2 mb-1">
                                        <img src="{{ $b->logo }}" alt="Logo" class="rounded-circle border" style="width: 24px; height: 24px; object-fit: cover; flex-shrink: 0; margin-top: 1px;" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=200&auto=format&fit=crop&q=80';">
                                        <h4 class="business-card-title mb-0" title="{{ $b->business_name }}">
                                            <a href="{{ $b->url }}" class="text-dark text-decoration-none">
                                                {{ $b->business_name }}
                                            </a>
                                        </h4>
                                    </div>

                                    <!-- Rating -->
                                    <div class="card-rating-row">
                                        @if($b->rating > 0 && (int)$b->reviews_count > 0)
                                            <span class="badge bg-warning text-dark px-1 py-0 fw-bold" style="font-size: 0.65rem;">
                                                <i class="fa-solid fa-star text-white"></i> {{ number_format($b->rating, 1) }}
                                            </span>
                                            <span class="text-muted" style="font-size: 0.68rem;">({{ $b->reviews_count }})</span>
                                        @else
                                            <span class="badge bg-light text-muted border px-1.5 py-0.5" style="font-size: 0.65rem;">
                                                New Listing
                                            </span>
                                        @endif
                                    </div>

                                    <!-- High Support & Top Suggestion Badges -->
                                    @if($b->hasHighSupport())
                                        <div class="d-flex align-items-center gap-1.5 my-1 flex-wrap">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-1.5 py-0.5 fw-bold" style="font-size: 0.65rem;" title="Premium Business with High Support">
                                                <i class="fa-solid fa-headset me-0.5"></i> High Support
                                            </span>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-1.5 py-0.5 fw-bold" style="font-size: 0.65rem;" title="Suggested First in Search & Directory">
                                                <i class="fa-solid fa-bolt me-0.5"></i> Top Suggestion
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Location & Distance -->
                                    <div class="card-location-row d-flex align-items-center justify-content-between">
                                        <span class="text-truncate" title="{{ $b->area_text }}">
                                            <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $b->area_text }}
                                        </span>
                                        @if(isset($b->distance_km))
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-1 px-1.5 py-0.5" style="font-size: 0.65rem; font-weight: 700; white-space: nowrap;" title="{{ $b->distance_km }} km away from your selected location">
                                                <i class="fa-solid fa-location-arrow me-0.5"></i> {{ $b->distance_km }} km
                                            </span>
                                        @endif
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
                                    <a href="{{ $b->url }}" class="btn-card-action btn-card-view">
                                        View
                                    </a>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-magnifying-glass fs-1 text-muted mb-3"></i>
                            <h5 class="fw-bold text-dark">No businesses found matching your criteria</h5>
                            <p class="text-muted small">Try broadening your search term or clearing the filters.</p>
                            <a href="{{ route('businesses') }}" class="btn btn-primary btn-sm px-4">Reset All Filters</a>
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
                <h4 class="fw-bold mb-1" id="contactModalPhone">+91 91738 60404</h4>
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
        document.getElementById('contactModalPhone').innerText = phone || '+91 91738 60404';
        document.getElementById('contactModalCallBtn').href = 'tel:' + (phone || '9173860404');
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

    // Submit form with sort
    function submitWithSort(val) {
        const sortInput = document.getElementById('filterSortInput');
        if (sortInput) sortInput.value = val;
        const form = document.getElementById('homeFilterForm');
        if (form) form.submit();
    }

    // Toggle more categories in sidebar
    function toggleMoreCategories(btn) {
        const moreItems = document.querySelectorAll('.more-category-item');
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

    // Handle rating radio toggle (allow clicking again to deselect)
    let lastCheckedRating = '{{ $selectedRating }}';
    function handleRatingClick(radio) {
        if (radio.value === lastCheckedRating) {
            radio.checked = false;
            lastCheckedRating = '';
            document.getElementById('homeFilterForm').submit();
        } else {
            lastCheckedRating = radio.value;
        }
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

    // Hero location handler (GPS vs City)
    function handleHeroCityChange(selectEl) {
        if (selectEl.value === 'near_me') {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }
            navigator.geolocation.getCurrentPosition(function(pos) {
                document.getElementById('heroLat').value = pos.coords.latitude;
                document.getElementById('heroLng').value = pos.coords.longitude;
                selectEl.form.submit();
            }, function(err) {
                alert('Unable to retrieve location: ' + err.message);
                selectEl.value = 'Ahmedabad';
            }, { timeout: 10000, enableHighAccuracy: true });
        } else {
            document.getElementById('heroLat').value = '';
            document.getElementById('heroLng').value = '';
            selectEl.form.submit();
        }
    }

    // Sidebar location handler
    function handleSidebarCityChange(selectEl) {
        if (selectEl.value === 'near_me') {
            detectSidebarLocation();
        } else {
            document.getElementById('sidebarLat').value = '';
            document.getElementById('sidebarLng').value = '';
            document.getElementById('homeFilterForm').submit();
        }
    }

    // Detect sidebar current location
    function detectSidebarLocation() {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }
        const btnText = document.getElementById('btnSidebarLocText');
        const orig = btnText ? btnText.textContent : '';
        if (btnText) btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Locating...';

        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('sidebarLat').value = pos.coords.latitude;
            document.getElementById('sidebarLng').value = pos.coords.longitude;
            const select = document.getElementById('sidebarCitySelect');
            if (select) select.value = 'near_me';
            document.getElementById('homeFilterForm').submit();
        }, function(err) {
            alert('Unable to retrieve location: ' + err.message + '. Please ensure location permissions are enabled.');
            if (btnText) btnText.textContent = orig;
        }, { timeout: 10000, enableHighAccuracy: true });
    }

    // State filter search inside sidebar
    function filterStateCheckboxes(query) {
        const q = (query || '').toLowerCase().trim();
        document.querySelectorAll('.state-check-row').forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    }

    // Clear state filter
    function clearStateFilter() {
        const checked = document.querySelector('input[name="state"]:checked');
        if (checked) checked.checked = false;
        const allRadio = document.getElementById('state_all');
        if (allRadio) allRadio.checked = true;
        document.getElementById('homeFilterForm').submit();
    }
</script>

@endsection
