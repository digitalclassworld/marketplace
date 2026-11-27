@extends('layouts.app')

@section('title', 'Digital Class Marketplace - Learn. Hire. Buy. Discover. All in One Place.')

@section('styles')
<style>
    /* ==========================================================================
       HERO MARKETPLACE STYLES
       ========================================================================== */
    .marketplace-hero {
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f5f9ff 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #0066ff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        margin-bottom: 1rem;
    }
    .hero-main-title {
        font-size: 2.75rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.18;
        letter-spacing: -0.025em;
        margin-bottom: 0.85rem;
    }
    .hero-main-title span {
        color: #0066ff;
    }
    .hero-main-sub {
        font-size: 1rem;
        color: #475569;
        line-height: 1.5;
        max-width: 620px;
        margin-bottom: 1.75rem;
    }

    /* Big Unified Search Box */
    .hero-search-wrapper {
        background: #ffffff;
        border: 2px solid #0066ff;
        border-radius: 12px;
        padding: 0.35rem 0.45rem;
        box-shadow: 0 12px 32px rgba(0, 102, 255, 0.12);
        max-width: 760px;
        margin-bottom: 1.25rem;
    }
    .hero-search-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .hero-search-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        color: #0f172a;
        background: transparent;
    }
    .hero-search-input::placeholder {
        color: #94a3b8;
    }
    .hero-search-select {
        border: none;
        border-left: 1px solid #e2e8f0;
        outline: none;
        padding: 0.75rem 1rem;
        font-size: 0.88rem;
        color: #334155;
        font-weight: 600;
        background: transparent;
        cursor: pointer;
    }
    .btn-hero-search {
        background: #0066ff;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.6rem;
        font-weight: 700;
        font-size: 0.92rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }
    .btn-hero-search:hover {
        background: #0052cc;
        color: #ffffff;
    }

    /* Popular search tags */
    .hero-popular-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 1.75rem;
    }
    .popular-tag-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        color: #334155;
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500;
    }
    .popular-tag-item:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #0066ff;
    }

    /* Hero 4 Stats Badges */
    .hero-stats-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    .hero-stat-pill {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 0.45rem 0.85rem;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }
    .stat-pill-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .stat-pill-num {
        font-weight: 800;
        font-size: 0.95rem;
        color: #0f172a;
        line-height: 1.1;
    }
    .stat-pill-label {
        font-size: 0.72rem;
        color: #64748b;
        line-height: 1.1;
    }

    /* Hero Thematic Visual Showcase with Floating Glass Badges */
    .hero-thematic-showcase {
        position: relative;
        border-radius: 24px;
        overflow: visible;
        padding: 10px;
    }
    .hero-thematic-img-wrap {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 25px 60px -15px rgba(0, 102, 255, 0.22), 0 0 0 1px rgba(226, 232, 240, 0.8);
        height: 420px;
        background: #0f172a;
    }
    .hero-thematic-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .hero-thematic-showcase:hover .hero-thematic-img-wrap img {
        transform: scale(1.04);
    }
    .hero-img-gradient-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 0%, rgba(15, 23, 42, 0.45) 100%);
        pointer-events: none;
    }

    /* Floating Badges */
    .hero-floating-badge {
        position: absolute;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        padding: 0.65rem 0.95rem;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        z-index: 5;
        transition: transform 0.25s ease;
    }
    .hero-floating-badge:hover {
        transform: translateY(-3px) scale(1.02);
    }
    .hero-badge-top-left {
        top: -12px;
        left: -16px;
    }
    .hero-badge-bottom-left {
        bottom: 24px;
        left: -20px;
    }
    .hero-badge-bottom-right {
        bottom: -14px;
        right: 16px;
    }
    .hero-badge-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* ==========================================================================
       CATEGORY ICON NAVIGATION STRIP (Full-Width Seamless Strip - No Boxed Container)
       ========================================================================== */
    .home-categories-section {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        padding: 1.75rem 0 1.35rem;
        margin: 0;
        position: relative;
        z-index: 10;
        width: 100%;
    }
    .home-categories-grid {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.5rem;
        overflow-x: auto;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE/Edge */
        padding: 0.35rem 0;
    }
    .home-categories-grid::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }
    .home-cat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        flex: 1 1 0;
        min-width: 82px;
        max-width: 105px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        text-align: center;
        padding: 0.25rem 0.15rem;
        border-radius: 12px;
    }
    .home-cat-item:hover {
        transform: translateY(-4px);
    }
    .home-cat-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin-bottom: 0.65rem;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .home-cat-item:hover .home-cat-icon-box {
        transform: scale(1.08);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    .home-cat-label {
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
    }
    .home-cat-item:hover .home-cat-label {
        color: #0066ff;
    }
    @media (max-width: 991px) {
        .home-categories-section {
            padding: 1rem 0;
        }
        .home-cat-item {
            min-width: 76px;
        }
        .home-cat-icon-box {
            width: 46px;
            height: 46px;
            font-size: 1.25rem;
            border-radius: 14px;
        }
    }

    /* ==========================================================================
       3 PROMOTIONAL BANNERS
       ========================================================================== */
    .promo-banners-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin: 2.25rem 0;
    }
    .promo-banner-card {
        border-radius: 16px;
        padding: 1.35rem 1.4rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        min-height: 165px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .promo-banner-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.14);
    }
    .promo-card-1 {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 60%, #9f1239 100%);
    }
    .promo-card-2 {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 60%, #075985 100%);
    }
    .promo-card-3 {
        background: linear-gradient(135deg, #059669 0%, #047857 60%, #065f46 100%);
    }
    .promo-card-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 2;
    }
    .promo-text-side {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .promo-img-side {
        flex-shrink: 0;
    }
    .promo-img-frame {
        width: 105px;
        height: 108px;
        border-radius: 14px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.24);
        background: rgba(255, 255, 255, 0.12);
        transition: transform 0.3s ease;
    }
    .promo-banner-card:hover .promo-img-frame {
        transform: scale(1.06) rotate(1.5deg);
    }
    .promo-img-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .promo-tag {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: rgba(255, 255, 255, 0.22);
        backdrop-filter: blur(4px);
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 0.5rem;
        width: fit-content;
    }
    .promo-title {
        font-size: 1.18rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 0.35rem;
    }
    .promo-desc {
        font-size: 0.78rem;
        opacity: 0.92;
        margin-bottom: 0.85rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .promo-btn {
        font-size: 0.82rem;
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: rgba(0, 0, 0, 0.22);
        backdrop-filter: blur(4px);
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        width: fit-content;
        transition: all 0.2s ease;
    }
    .promo-btn:hover {
        background: rgba(0, 0, 0, 0.4);
        color: #ffffff;
        transform: translateX(2px);
    }
    @media (max-width: 1199px) and (min-width: 992px) {
        .promo-img-frame {
            width: 88px;
            height: 92px;
        }
        .promo-title {
            font-size: 1.05rem;
        }
    }
    @media (max-width: 576px) {
        .promo-img-frame {
            width: 82px;
            height: 86px;
        }
        .promo-title {
            font-size: 1.1rem;
        }
    }

    /* ==========================================================================
       SECTION HEADERS (Title + View All Link)
       ========================================================================== */
    .section-header-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .section-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .section-sub {
        font-size: 0.82rem;
        color: #64748b;
        margin: 0.2rem 0 0;
    }
    .btn-view-all {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0066ff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-view-all:hover {
        background: #0066ff;
        color: #ffffff;
        border-color: #0066ff;
    }

    /* ==========================================================================
       PRODUCT & SERVICE & COURSE CARDS
       ========================================================================== */
    /* Course Card */
    .course-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .course-thumb-box {
        position: relative;
        height: 160px;
        background: #0f172a;
        overflow: hidden;
    }
    .course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .course-card:hover .course-thumb-box img {
        transform: scale(1.04);
    }
    .course-badge-overlay {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }
    .trending-course-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .trending-course-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 42px -10px rgba(0, 102, 255, 0.18), 0 8px 18px -4px rgba(15, 23, 42, 0.06);
        border-color: rgba(0, 102, 255, 0.4);
    }
    .trending-course-thumb-box {
        position: relative;
        width: 100%;
        height: 175px;
        overflow: hidden;
        background: #f1f5f9;
    }
    .trending-course-thumb-box::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 0%, transparent 40%, rgba(15, 23, 42, 0.3) 100%);
        pointer-events: none;
        transition: opacity 0.3s;
    }
    .trending-course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .trending-course-card:hover .trending-course-thumb-box img {
        transform: scale(1.08);
    }
    .trending-crown-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
        font-size: 13px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        z-index: 2;
        transition: transform 0.3s ease;
    }
    .trending-course-card:hover .trending-crown-badge {
        transform: scale(1.1) rotate(5deg);
    }
    .level-pill-badge {
        background: #eff6ff;
        color: #0066ff;
        border: 1px solid #dbeafe;
        border-radius: 999px;
        padding: 3px 10px;
        font-size: 0.72rem;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 8px;
        letter-spacing: 0.02em;
    }
    .course-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.7em;
        transition: color 0.2s ease;
    }
    .trending-course-card:hover .course-card-title a {
        color: #0066ff !important;
    }
    .course-tutor-link {
        font-size: 0.78rem;
        color: #64748b;
        text-decoration: none;
        display: block;
        margin-bottom: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.15s;
    }
    .course-tutor-link:hover {
        color: #0066ff;
    }
    .price-row-wrap {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 12px;
    }
    .price-current {
        font-size: 1.22rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .price-original {
        font-size: 0.84rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .badge-discount-orange {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        font-size: 0.68rem;
        padding: 3px 8px;
        border-radius: 999px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    .btn-add-to-cart-green {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 700;
        font-size: 0.88rem;
        text-align: center;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(109, 40, 217, 0.28);
    }
    .btn-add-to-cart-green:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #6d28d9 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(109, 40, 217, 0.42);
    }
    .course-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .course-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 0.4rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.6em;
    }
    .course-rating-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        margin-bottom: 0.6rem;
    }
    .course-rating-row .fa-star {
        color: #f59e0b;
    }
    .course-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        margin-top: auto;
        padding-top: 0.6rem;
        border-top: 1px solid #f1f5f9;
    }
    .curr-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
    }
    .old-price {
        font-size: 0.8rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .discount-badge {
        font-size: 0.7rem;
        font-weight: 800;
        color: #059669;
        background: #ecfdf5;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        margin-left: auto;
    }
    .course-seller-meta {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Luxury Service Card */
    .service-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .service-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 42px -10px rgba(6, 182, 212, 0.2), 0 8px 18px -4px rgba(15, 23, 42, 0.06);
        border-color: rgba(6, 182, 212, 0.45);
    }
    .service-thumb {
        position: relative;
        height: 165px;
        background: #f1f5f9;
        overflow: hidden;
    }
    .service-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.04) 0%, transparent 40%, rgba(15, 23, 42, 0.28) 100%);
        pointer-events: none;
    }
    .service-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .service-card:hover .service-thumb img {
        transform: scale(1.08);
    }
    .service-body {
        padding: 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .service-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.45rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.7em;
        transition: color 0.2s ease;
    }
    .service-card:hover .service-title {
        color: #0284c7;
    }
    .service-price-tag {
        font-size: 0.88rem;
        color: #0284c7;
        font-weight: 800;
        margin-top: auto;
        padding-top: 0.6rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Luxury Product Card */
    .product-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 42px -10px rgba(16, 185, 129, 0.2), 0 8px 18px -4px rgba(15, 23, 42, 0.06);
        border-color: rgba(16, 185, 129, 0.45);
    }
    .product-thumb {
        position: relative;
        height: 165px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 12px;
    }
    .product-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.03) 0%, transparent 50%, rgba(15, 23, 42, 0.1) 100%);
        pointer-events: none;
    }
    .product-thumb img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-card:hover .product-thumb img {
        transform: scale(1.08);
    }
    .product-body {
        padding: 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .product-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.45rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.7em;
        transition: color 0.2s ease;
    }
    .product-card:hover .product-title {
        color: #059669;
    }
    .product-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        margin-top: auto;
        padding-top: 0.6rem;
        border-top: 1px solid #f1f5f9;
    }

    /* Luxury Business Card */
    .business-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .business-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 42px -10px rgba(245, 158, 11, 0.2), 0 8px 18px -4px rgba(15, 23, 42, 0.06);
        border-color: rgba(245, 158, 11, 0.5);
    }
    .business-thumb {
        position: relative;
        height: 165px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .business-thumb img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .business-card:hover .business-thumb img {
        transform: scale(1.08);
    }
    .business-body {
        padding: 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .business-name {
        font-size: 0.98rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.3rem;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .business-card:hover .business-name {
        color: #d97706;
    }
    .business-loc {
        font-size: 0.78rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    /* ==========================================================================
       SIDEBAR VALUE PROP & ONBOARDING CARDS
       ========================================================================== */
    .why-choose-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.4rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .why-choose-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.1rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .why-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .why-item:last-child {
        margin-bottom: 0;
    }
    .why-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .why-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.1rem;
    }
    .why-desc {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.35;
    }

    .cta-seller-card {
        background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
        border-radius: 14px;
        padding: 1.4rem;
        color: #ffffff;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 24px rgba(0, 102, 255, 0.25);
    }
    .cta-seller-card h5 {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 0.4rem;
    }
    .cta-seller-card p {
        font-size: 0.8rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }
    .btn-seller-cta {
        background: #ffffff;
        color: #0066ff;
        font-weight: 800;
        font-size: 0.85rem;
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
    }
    .btn-seller-cta:hover {
        background: #f8fafc;
        color: #0052cc;
        transform: translateY(-1px);
    }

    .cta-business-card {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 1.4rem;
        text-align: center;
        margin-bottom: 1.25rem;
    }
    .cta-business-card h5 {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }
    .cta-business-card p {
        font-size: 0.78rem;
        color: #64748b;
        margin-bottom: 1rem;
    }
    .btn-business-cta {
        background: #10b981;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 0.45rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
    }
    .btn-business-cta:hover {
        background: #059669;
        color: #ffffff;
    }

    /* ==========================================================================
       STATS & TRUST FOOTER RIBBON
       ========================================================================== */
    .marketplace-stats-ribbon {
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        padding: 2.25rem 0;
        margin-top: 3.5rem;
    }
    .ribbon-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 1.5rem;
        text-align: center;
    }
    .ribbon-item {
        border-right: 1px solid #f1f5f9;
        padding: 0 0.5rem;
    }
    .ribbon-item:last-child {
        border-right: none;
    }
    .ribbon-num {
        font-size: 1.6rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.15;
    }
    .ribbon-num i {
        color: #0066ff;
        font-size: 1.2rem;
        margin-right: 0.25rem;
    }
    .ribbon-label {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
        margin-top: 0.25rem;
    }

    @media (max-width: 991px) {
        .promo-banners-row {
            grid-template-columns: 1fr;
        }
        .ribbon-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        .ribbon-item:nth-child(3) {
            border-right: none;
        }
    }
    @media (max-width: 767px) {
        .marketplace-hero {
            padding: 2rem 0 1.5rem;
        }
        .hero-main-title {
            font-size: 1.85rem;
            line-height: 1.2;
        }
        .hero-main-sub {
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
        .hero-search-wrapper {
            border-radius: 12px;
            padding: 0.35rem;
        }
        .hero-search-form {
            flex-direction: column;
            align-items: stretch;
            gap: 0.35rem;
        }
        .hero-search-input {
            padding: 0.55rem 0.75rem;
        }
        .hero-search-select {
            border-left: none;
            border-top: 1px solid #e2e8f0;
            padding: 0.55rem 0.75rem;
        }
        .hero-stats-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
        .hero-stat-pill {
            padding: 0.4rem 0.65rem;
        }
        .ribbon-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .trending-course-thumb-box {
            height: 140px;
        }
    }
</style>
@endsection

@section('content')

<!-- ============================================================================
     1. HERO MARKETPLACE SECTION
     ============================================================================ -->
<section class="marketplace-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="row align-items-center g-4">

            <!-- Left: Hero Headline & Search Box -->
            <div class="col-lg-7 col-xl-7">
                <div class="hero-badge-pill">
                    <i class="fa-solid fa-shield-check"></i>
                    <span>India's Trusted Marketplace for Learning, Services, Products & Businesses</span>
                </div>

                <h1 class="hero-main-title">
                    Learn. Hire. Buy. Discover.<br>
                    <span>All in One Place.</span>
                </h1>

                <p class="hero-main-sub">
                    Courses, professional services, products and trusted businesses &mdash; everything you need to grow your skills, business and career.
                </p>

                <!-- Unified Search Box -->
                <div class="hero-search-wrapper">
                    <form action="{{ route('courses') }}" method="GET" class="hero-search-form" id="marketplaceSearchForm">
                        <i class="fa-solid fa-magnifying-glass text-muted ms-2 ps-1"></i>
                        <input type="text"
                               name="search"
                               class="hero-search-input"
                               placeholder="What are you looking for? (e.g. Digital Marketing, Web Development, HP Laptop, Coaching...)"
                               id="mainSearchInput">

                        <select class="hero-search-select" id="searchTypeSelect" onchange="updateSearchAction(this.value)">
                            <option value="courses">All Categories</option>
                            <option value="courses">Online Courses</option>
                            <option value="services">Professional Services</option>
                            <option value="products">Shop Products</option>
                            <option value="businesses">Local Businesses</option>
                        </select>

                        <button type="submit" class="btn-hero-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Search</span>
                        </button>
                    </form>
                </div>

                <!-- Popular Search Tags -->
                <div class="hero-popular-row">
                    <span class="fw-bold text-dark">Popular:</span>
                    <a href="{{ route('courses', ['search' => 'Digital Marketing']) }}" class="popular-tag-item">Digital Marketing</a>
                    <a href="{{ route('services', ['search' => 'Website Development']) }}" class="popular-tag-item">Website Development</a>
                    <a href="{{ route('courses', ['search' => 'Tally']) }}" class="popular-tag-item">Tally Course</a>
                    <a href="{{ route('services', ['search' => 'Graphic Design']) }}" class="popular-tag-item">Graphic Design</a>
                    <a href="{{ route('products', ['search' => 'Laptop']) }}" class="popular-tag-item">Laptops</a>
                    <a href="{{ route('businesses', ['search' => 'Coaching']) }}" class="popular-tag-item">Coaching Institute</a>
                </div>

                <!-- 4 Quick Stats Badges -->
                <div class="hero-stats-row">
                    <a href="{{ route('courses') }}" class="hero-stat-pill text-decoration-none">
                        <div class="stat-pill-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="stat-pill-num">{{ number_format($totalCourses > 0 ? $totalCourses : 1084) }}+</div>
                            <div class="stat-pill-label">Courses</div>
                        </div>
                    </a>

                    <a href="{{ route('services') }}" class="hero-stat-pill text-decoration-none">
                        <div class="stat-pill-icon bg-info bg-opacity-10 text-info">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <div class="stat-pill-num">{{ number_format($totalServices > 0 ? $totalServices : 5000) }}+</div>
                            <div class="stat-pill-label">Services</div>
                        </div>
                    </a>

                    <a href="{{ route('products') }}" class="hero-stat-pill text-decoration-none">
                        <div class="stat-pill-icon bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <div class="stat-pill-num">{{ number_format($totalProducts > 0 ? $totalProducts : 10000) }}+</div>
                            <div class="stat-pill-label">Products</div>
                        </div>
                    </a>

                    <a href="{{ route('businesses') }}" class="hero-stat-pill text-decoration-none">
                        <div class="stat-pill-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <div class="stat-pill-num">{{ number_format($totalBusinesses > 0 ? $totalBusinesses : 8000) }}+</div>
                            <div class="stat-pill-label">Businesses</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Right: Hero Thematic Visual Showcase with Floating Glass Badges -->
            <div class="col-lg-5 col-xl-5 d-none d-lg-block">
                <div class="hero-thematic-showcase">
                    
                    <!-- Floating Badge: Top-Left (Verified Learners & Educators) -->
                    <div class="hero-floating-badge hero-badge-top-left">
                        <div class="hero-badge-icon-wrap bg-primary bg-opacity-15 text-primary">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small" style="font-size: 0.82rem; line-height: 1.2;">100% Verified</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Educators &amp; Businesses</div>
                        </div>
                    </div>

                    <!-- Main Hero Visual Image -->
                    <div class="hero-thematic-img-wrap">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=900&auto=format&fit=crop&q=80" 
                             alt="Digital Class Learning & Skills Marketplace" 
                             loading="eager">
                        <div class="hero-img-gradient-overlay"></div>
                    </div>

                    <!-- Floating Badge: Bottom-Left (11,000+ Institutes) -->
                    <div class="hero-floating-badge hero-badge-bottom-left">
                        <div class="hero-badge-icon-wrap bg-primary bg-opacity-15 text-primary">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small" style="font-size: 0.82rem; line-height: 1.2;">11,000+ Institutes</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Verified Coaching Directory</div>
                        </div>
                    </div>

                    <!-- Floating Badge: Bottom-Right (Verified Freelancers & Services) -->
                    <div class="hero-floating-badge hero-badge-bottom-right">
                        <div class="hero-badge-icon-wrap bg-success bg-opacity-15 text-success">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small" style="font-size: 0.82rem; line-height: 1.2;">Verified Experts</div>
                            <div class="text-muted" style="font-size: 0.68rem;">100% Escrow Protection</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================================
     2. CATEGORY ICON NAVIGATION STRIP (Full-Width Seamless Strip - No Boxed Card)
     ============================================================================ -->
<div class="home-categories-section">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="home-categories-grid">
            @foreach($categoryPills as $cp)
                <a href="{{ $cp['url'] }}" class="home-cat-item" title="{{ $cp['name'] }}">
                    <div class="home-cat-icon-box" style="background-color: {{ $cp['bg'] ?? '#f8fafc' }}; border: 1.5px solid {{ $cp['border'] ?? '#e2e8f0' }}; color: {{ $cp['color'] ?? '#0066ff' }};">
                        <i class="{{ $cp['icon'] }}"></i>
                    </div>
                    <span class="home-cat-label">{{ $cp['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- ============================================================================
     MAIN MARKETPLACE CONTENT
     ============================================================================ -->
<div class="container-fluid px-3 px-md-4 px-xl-5 py-4">

    <!-- 3 Promotional Banners (Dynamically uploaded by Admin or curated defaults) -->
    <div class="promo-banners-row">
        @if(isset($promotionalBanners) && $promotionalBanners->count() > 0)
            @foreach($promotionalBanners as $idx => $banner)
                @php
                    $meta = is_string($banner->banner_template) ? json_decode($banner->banner_template, true) : null;
                    $bg = $meta['banner_bg'] ?? (['promo-card-1', 'promo-card-2', 'promo-card-3'][$idx % 3]);
                    $link = $meta['link'] ?? ($banner->target_audience && str_starts_with($banner->target_audience, 'http') ? $banner->target_audience : route('courses'));
                    $tagline = $meta['tagline'] ?? ($banner->target_audience ?: 'Special Offer');
                    $btnText = $meta['button_text'] ?? 'Explore Offer';
                    $hasImg = !empty($banner->listing_thumbnail);
                    $style = '';
                    if ($hasImg) {
                        $style = "background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('{$banner->listing_thumbnail}'); background-size: cover; background-position: center;";
                    } elseif (str_starts_with($bg, 'linear-gradient') || str_starts_with($bg, 'radial-gradient')) {
                        $style = "background: {$bg};";
                    }
                @endphp
                <div class="promo-banner-card {{ !$style ? $bg : '' }}" style="{{ $style }}">
                    <div class="promo-card-content">
                        <div class="promo-text-side">
                            <span class="promo-tag">{{ $tagline }}</span>
                            <div class="promo-title">{!! nl2br(e($banner->listing_title)) !!}</div>
                            @if(!empty($meta['campaign']))
                                <div class="promo-desc">{{ $meta['campaign'] }}</div>
                            @endif
                            <a href="{{ $link }}" class="promo-btn">
                                {{ $btnText }} <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        @if($hasImg)
                            <div class="promo-img-side">
                                <div class="promo-img-frame">
                                    <img src="{{ $banner->listing_thumbnail }}" alt="{{ $banner->listing_title }}" loading="lazy">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <!-- Banner 1: Festival Offer -->
            <div class="promo-banner-card promo-card-1">
                <div class="promo-card-content">
                    <div class="promo-text-side">
                        <span class="promo-tag"><i class="fa-solid fa-gift me-1"></i> Festival Offer</span>
                        <div class="promo-title">Extra 50% OFF<br>on Selected Courses</div>
                        <div class="promo-desc">Learn top IT, Design & Management skills today</div>
                        <a href="{{ route('courses') }}" class="promo-btn">
                            Grab Offer <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="promo-img-side">
                        <div class="promo-img-frame">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&auto=format&fit=crop&q=80" alt="Selected Courses" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 2: Grow Your Business -->
            <div class="promo-banner-card promo-card-2">
                <div class="promo-card-content">
                    <div class="promo-text-side">
                        <span class="promo-tag"><i class="fa-solid fa-chart-line me-1"></i> Grow Your Business</span>
                        <div class="promo-title">List Your Business<br>for Free</div>
                        <div class="promo-desc">Get discovered by thousands of active students & clients</div>
                        <a href="{{ route('businesses') }}" class="promo-btn">
                            Add Your Business <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="promo-img-side">
                        <div class="promo-img-frame">
                            <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=500&auto=format&fit=crop&q=80" alt="List Your Business" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 3: Become a Seller -->
            <div class="promo-banner-card promo-card-3">
                <div class="promo-card-content">
                    <div class="promo-text-side">
                        <span class="promo-tag"><i class="fa-solid fa-store me-1"></i> Become a Seller</span>
                        <div class="promo-title">Sell Courses, Services<br>& Products</div>
                        <div class="promo-desc">Join 10,000+ educators & service providers nationwide</div>
                        <a href="{{ route('seller.register') }}" class="promo-btn">
                            Start Selling <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="promo-img-side">
                        <div class="promo-img-frame">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&auto=format&fit=crop&q=80" alt="Sell Courses & Services" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- ========================================================================
         SEQUENCE 1: TRENDING COURSES (Legacy authentic courses from dc_elearn_course)
         ======================================================================== -->
    <div class="mb-5">
        <div class="section-header-row align-items-end mb-3">
            <div>
                <h2 class="section-title fw-bold text-dark mb-1" style="font-size: 2rem; letter-spacing: -0.02em;">
                    Trending <span style="position: relative; display: inline-block;">Courses<svg style="position: absolute; bottom: -4px; left: 0; width: 100%; height: 10px;" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M5,15 Q50,0 95,15" stroke="#f59e0b" stroke-width="4" fill="none"/></svg></span>
                </h2>
                <p class="text-secondary small mb-0">Find courses that are best for your profession</p>
            </div>
            <a href="{{ route('courses') }}" class="btn-view-all">
                View All <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-3 g-xl-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            @forelse($featuredCourses as $course)
                <div class="col">
                    <div class="trending-course-card">
                        <div class="trending-course-thumb-box">
                            <a href="{{ !empty($course->url) ? $course->url : route('course.show', $course->slug) }}" class="d-block w-100 h-100">
                                <img src="{{ $course->thumbnail_url ?: ($course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80') }}"
                                     alt="{{ $course->title }}"
                                     loading="lazy"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';">
                            </a>
                            <div class="trending-crown-badge">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div>
                                <span class="level-pill-badge">{{ $course->level }}</span>
                                <h5 class="course-card-title" title="{{ $course->title }}">
                                    <a href="{{ !empty($course->url) ? $course->url : route('course.show', $course->slug) }}" class="text-dark text-decoration-none">
                                        {{ $course->short_title ?? $course->title }}
                                    </a>
                                </h5>

                                @if(!empty($course->tutor))
                                    <a href="{{ $course->tutor->url }}" class="course-tutor-link" title="{{ $course->tutor->name }}">
                                        <i class="fa-regular fa-user text-primary me-1"></i> {{ $course->tutor->name }}
                                    </a>
                                @elseif(!empty($course->seller))
                                    <div class="course-tutor-link">
                                        <i class="fa-regular fa-user text-primary me-1"></i> {{ $course->seller?->businessDetail?->business_name ?? $course->seller?->user?->name }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                @php
                                    $sellPrice = (float)($course->selling_price ?? 0);
                                    $mrpPrice = (float)($course->original_price ?? 0);
                                    if ($sellPrice == 0) {
                                        if (isset($course->discount_price) && $course->discount_price > 0 && $course->price > $course->discount_price) {
                                            $sellPrice = (float)$course->discount_price;
                                            $mrpPrice = (float)$course->price;
                                        } else {
                                            $sellPrice = (float)($course->price ?? 0);
                                        }
                                    }
                                    if ($mrpPrice == 0 && isset($course->price) && $course->price > $sellPrice) {
                                        $mrpPrice = (float)$course->price;
                                    }
                                @endphp
                                <div class="price-row-wrap">
                                    <span class="price-current">₹{{ number_format($sellPrice, 0) }}</span>
                                    @if($mrpPrice > $sellPrice && $sellPrice > 0)
                                        <span class="price-original">₹{{ number_format($mrpPrice, 0) }}</span>
                                        <span class="badge-discount-orange">{{ $course->discount_text ?? $course->discount_percentage ?? round((($mrpPrice - $sellPrice)/$mrpPrice)*100) . '% off' }}</span>
                                    @elseif($sellPrice == 0)
                                        <span class="price-original">₹0</span>
                                        <span class="badge-discount-orange">0% off</span>
                                    @endif
                                </div>

                                <button type="button" class="btn-add-to-cart-green w-100" onclick='addToCart({!! htmlspecialchars(json_encode([
                                    "id" => $course->id,
                                    "type" => "Course",
                                    "title" => $course->title,
                                    "price" => (float)$sellPrice,
                                    "original_price" => (float)$mrpPrice,
                                    "thumbnail" => $course->thumbnail_url ?: ($course->thumbnail ?? ""),
                                    "seller_id" => $course->seller_id ?? 1
                                ]), ENT_QUOTES, "UTF-8") !!})'>
                                    <i class="fa-solid fa-cart-shopping me-1"></i> Add To Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-4 text-center text-muted">
                    <p>Courses are being loaded. Click View All to browse our complete catalog.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ========================================================================
         2-COLUMN GRID: (SERVICES, PRODUCTS, BUSINESSES) + SIDEBAR
         ======================================================================== -->
    <div class="row g-4 align-items-start">

        <!-- Left Column: Services -> Products -> Businesses -->
        <div class="col-lg-8 col-xl-9">

            <!-- ====================================================================
                 SEQUENCE 2: PROFESSIONAL SERVICES (with View All ->)
                 ==================================================================== -->
            <div class="mb-5">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">
                            <i class="fa-solid fa-briefcase text-info"></i>
                            <span>Professional Services</span>
                        </h2>
                        <p class="section-sub">Hire verified agencies and freelance specialists with escrow safety</p>
                    </div>
                    <a href="{{ route('services') }}" class="btn-view-all">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="row g-3 g-xl-4 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4">
                    @forelse($featuredServices as $service)
                        <div class="col">
                            <a href="{{ route('service.show', $service->slug) }}" class="text-decoration-none">
                                <div class="service-card">
                                    <div class="service-thumb">
                                        <img src="{{ $service->thumbnail ?: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=80' }}"
                                             alt="{{ $service->title }}"
                                             loading="lazy"
                                             onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=80';">
                                    </div>
                                    <div class="service-body">
                                        <div class="service-title" title="{{ $service->title }}">{{ $service->title }}</div>
                                        <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                                            @if(isset($service->rating) && (float)$service->rating > 0 && (int)($service->reviews_count ?? 0) > 0)
                                                <i class="fa-solid fa-star text-warning"></i>
                                                <span class="fw-bold text-dark">{{ number_format($service->rating, 1) }}</span>
                                            @endif
                                            <span class="text-truncate">&bull; {{ $service->seller?->businessDetail?->business_name ?? 'Certified Agency' }}</span>
                                        </div>
                                        <div class="service-price-tag">
                                            Starting at ₹{{ number_format($service->price, 0) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 py-3 text-center text-muted">
                            <p>Services catalog loading. Click View All to explore.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ====================================================================
                 SEQUENCE 3: FEATURED PRODUCTS (with View All ->)
                 ==================================================================== -->
            <div class="mb-5">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">
                            <i class="fa-solid fa-box-open text-success"></i>
                            <span>Featured Products</span>
                        </h2>
                        <p class="section-sub">Study notes, books, software tools and educational electronics</p>
                    </div>
                    <a href="{{ route('products') }}" class="btn-view-all">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="row g-3 g-xl-4 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4">
                    @forelse($featuredProducts as $product)
                        <div class="col">
                            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                                <div class="product-card">
                                    <div class="product-thumb">
                                        <img src="{{ $product->thumbnail ?: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80' }}"
                                             alt="{{ $product->title }}"
                                             loading="lazy"
                                             onerror="this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80';">
                                    </div>
                                    <div class="product-body">
                                        <div class="product-title" title="{{ $product->title }}">{{ $product->title }}</div>
                                        <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                                            @if(isset($product->rating) && (float)$product->rating > 0 && (int)($product->reviews_count ?? 0) > 0)
                                                <i class="fa-solid fa-star text-warning"></i>
                                                <span class="fw-bold text-dark">{{ number_format($product->rating, 1) }}</span>
                                            @endif
                                            <span class="text-truncate">&bull; {{ $product->seller?->businessDetail?->business_name ?? 'Verified Merchant' }}</span>
                                        </div>
                                        <div class="product-price-row">
                                            <span class="curr-price">₹{{ number_format($product->price, 0) }}</span>
                                            @if($product->mrp && $product->mrp > $product->price)
                                                <span class="old-price">₹{{ number_format($product->mrp, 0) }}</span>
                                                <span class="discount-badge">{{ round((($product->mrp - $product->price) / $product->mrp) * 100) }}% OFF</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 py-3 text-center text-muted">
                            <p>Products catalog loading. Click View All to explore.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ====================================================================
                 SEQUENCE 4: POPULAR BUSINESSES (with View All ->)
                 ==================================================================== -->
            <div class="mb-4">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">
                            <i class="fa-solid fa-building-columns text-warning"></i>
                            <span>Popular Businesses</span>
                        </h2>
                        <p class="section-sub">Verified coaching institutes, schools and local educational centers</p>
                    </div>
                    <a href="{{ route('businesses') }}" class="btn-view-all">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="row g-3 g-xl-4 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4">
                    @forelse($popularBusinesses as $b)
                        <div class="col">
                            <a href="{{ $b->url }}" class="text-decoration-none">
                                <div class="business-card">
                                    <div class="business-thumb position-relative">
                                        <img src="{{ $b->display_image }}"
                                             alt="{{ $b->business_name }}"
                                             loading="lazy"
                                             onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&auto=format&fit=crop&q=80';">
                                        @if($b->badge === 'Featured')
                                            <span class="position-absolute top-0 start-0 m-2 badge rounded-pill text-white shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706); font-size: 0.68rem; padding: 0.35rem 0.65rem;">
                                                <i class="fa-solid fa-crown me-1"></i>Featured
                                            </span>
                                        @elseif($b->badge === 'Premium')
                                            <span class="position-absolute top-0 start-0 m-2 badge rounded-pill text-white shadow-sm" style="background: linear-gradient(135deg, #7c3aed, #6d28d9); font-size: 0.68rem; padding: 0.35rem 0.65rem;">
                                                <i class="fa-solid fa-gem me-1"></i>Premium
                                            </span>
                                        @elseif($b->badge === 'Verified')
                                            <span class="position-absolute top-0 start-0 m-2 badge rounded-pill text-white shadow-sm" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); font-size: 0.68rem; padding: 0.35rem 0.65rem;">
                                                <i class="fa-solid fa-circle-check me-1"></i>Verified
                                            </span>
                                        @endif
                                    </div>
                                    <div class="business-body">
                                        <div class="business-name" title="{{ $b->business_name }}">{{ $b->business_name }}</div>
                                        <div class="business-loc">
                                            <i class="fa-solid fa-location-dot me-1" style="color: #6d28d9;"></i>
                                            {{ $b->city ?: 'India' }}{{ $b->state ? ', ' . $b->state : '' }}
                                        </div>
                                        <div class="d-flex align-items-center gap-1 small text-muted mt-auto pt-2 border-top">
                                            @if($b->rating > 0 && (int)$b->reviews_count > 0)
                                                <i class="fa-solid fa-star text-warning"></i>
                                                <span class="fw-bold text-dark">{{ number_format($b->rating, 1) }}</span>
                                                <span>({{ $b->reviews_count }})</span>
                                            @else
                                                <span class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $b->category ?? 'Verified Business' }}</span>
                                            @endif
                                            @if($b->badge === 'Featured')
                                                <span class="badge rounded-pill ms-auto" style="background: #fef3c7; color: #b45309; font-size: 0.65rem;"><i class="fa-solid fa-crown me-0.5"></i>Featured</span>
                                            @elseif($b->badge === 'Premium')
                                                <span class="badge rounded-pill ms-auto" style="background: #f3e8ff; color: #6d28d9; font-size: 0.65rem;"><i class="fa-solid fa-gem me-0.5"></i>Premium</span>
                                            @else
                                                <span class="badge rounded-pill ms-auto" style="background: #e0f2fe; color: #0369a1; font-size: 0.65rem;"><i class="fa-solid fa-circle-check me-0.5"></i>Verified</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 py-3 text-center text-muted">
                            <p>Businesses directory loading. Click View All to explore all 11,000+ businesses.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column: Sidebar Value Props & Onboarding Cards -->
        <div class="col-lg-4 col-xl-3">

            <!-- Card 1: Why Choose Digital Class? -->
            <div class="why-choose-card">
                <h4 class="why-choose-title">Why Choose Digital Class?</h4>

                <div class="why-item">
                    <div class="why-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <div class="why-title">Trusted &amp; Verified Sellers</div>
                        <div class="why-desc">Quality content, authentic educators and verified organizations.</div>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon bg-info bg-opacity-10 text-info">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="why-title">Wide Range of Categories</div>
                        <div class="why-desc">Courses, freelance services, products &amp; businesses in one place.</div>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <div class="why-title">Secure Payments</div>
                        <div class="why-desc">100% safe &amp; secure escrow checkout with buyer protection.</div>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <div class="why-title">Real Reviews &amp; Ratings</div>
                        <div class="why-desc">Transparent feedback from genuine students and clients.</div>
                    </div>
                </div>

                <div class="why-item">
                    <div class="why-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <div class="why-title">Support When You Need It</div>
                        <div class="why-desc">Our dedicated marketplace team is always here to help.</div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Join 10,000+ Sellers -->
            <div class="cta-seller-card">
                <h5>Join 10,000+ Sellers and Grow Your Business</h5>
                <p>Start selling your courses, services, and educational products to learners nationwide.</p>
                <a href="{{ route('seller.register') }}" class="btn-seller-cta">
                    Start Selling Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Card 3: List Your Business -->
            <div class="cta-business-card">
                <h5>List Your Business</h5>
                <p>Get discovered by thousands of customers seeking local coaching and institutes.</p>
                <a href="{{ route('businesses') }}" class="btn-business-cta">
                    Add Business for Free <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

        </div>

    </div>

</div>

<!-- ============================================================================
     5. STATS & TRUST FOOTER RIBBON
     ============================================================================ -->
<div class="marketplace-stats-ribbon">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="ribbon-grid">
            <div class="ribbon-item">
                <div class="ribbon-num"><i class="fa-solid fa-users"></i> 3M+</div>
                <div class="ribbon-label">Monthly Visitors</div>
            </div>
            <div class="ribbon-item">
                <div class="ribbon-num"><i class="fa-solid fa-graduation-cap"></i> {{ number_format($totalCourses > 0 ? $totalCourses : 1084) }}+</div>
                <div class="ribbon-label">Online Courses</div>
            </div>
            <div class="ribbon-item">
                <div class="ribbon-num"><i class="fa-solid fa-briefcase"></i> {{ number_format($totalServices > 0 ? $totalServices : 5000) }}+</div>
                <div class="ribbon-label">Verified Services</div>
            </div>
            <div class="ribbon-item">
                <div class="ribbon-num"><i class="fa-solid fa-box-open"></i> {{ number_format($totalProducts > 0 ? $totalProducts : 10000) }}+</div>
                <div class="ribbon-label">Products &amp; Notes</div>
            </div>
            <div class="ribbon-item">
                <div class="ribbon-num"><i class="fa-solid fa-building-columns"></i> {{ number_format($totalBusinesses > 0 ? $totalBusinesses : 8000) }}+</div>
                <div class="ribbon-label">Local Businesses</div>
            </div>
            <div class="ribbon-item">
                <div class="ribbon-num"><i class="fa-solid fa-star text-warning"></i> 4.8 / 5</div>
                <div class="ribbon-label">Average Rating</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function updateSearchAction(type) {
        const form = document.getElementById('marketplaceSearchForm');
        if (!form) return;

        if (type === 'courses') {
            form.action = "{{ route('courses') }}";
        } else if (type === 'services') {
            form.action = "{{ route('services') }}";
        } else if (type === 'products') {
            form.action = "{{ route('products') }}";
        } else if (type === 'businesses') {
            form.action = "{{ route('businesses') }}";
        }
    }
</script>
@endsection
