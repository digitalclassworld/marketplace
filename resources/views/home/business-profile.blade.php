@extends('layouts.app')

@section('title', ($business->business_name ?? 'VCEC - Vinayak Computer Education Center') . ' - Digital Class')

@section('styles')
<style>
    :root {
        --dc-blue: #0066cc;
        --dc-blue-hover: #0052a3;
        --dc-text-dark: #0f172a;
        --dc-text-muted: #64748b;
        --dc-border: #e2e8f0;
        --dc-green: #16a34a;
        --dc-bg-light: #f8fafc;
    }

    body {
        background-color: #f8fafc;
        color: var(--dc-text-dark);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    /* Breadcrumbs */
    .profile-breadcrumbs {
        padding: 0.75rem 0;
        font-size: 0.82rem;
        color: #64748b;
    }
    .profile-breadcrumbs a {
        color: #475569;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .profile-breadcrumbs a:hover {
        color: var(--dc-blue);
    }
    .profile-breadcrumbs span.separator {
        margin: 0 0.4rem;
        color: #94a3b8;
    }
    .profile-breadcrumbs span.current {
        color: #0f172a;
        font-weight: 500;
    }

    /* TOP PANORAMIC HERO BANNER */
    .store-hero-banner {
        background: linear-gradient(135deg, #0a192f 0%, #172a45 40%, #0d213f 100%);
        border-radius: 12px;
        overflow: hidden;
        color: #ffffff;
        position: relative;
        padding: 1.5rem 2rem;
        margin-bottom: 1.25rem;
        border: 1px solid #1e293b;
        box-shadow: 0 10px 25px rgba(10, 25, 47, 0.15);
    }
    .hero-banner-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
    }
    .hero-left-content {
        flex: 1.2;
    }
    .hero-main-title {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.15;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        color: #ffffff;
    }
    .hero-subtitle {
        font-size: 0.85rem;
        color: #93c5fd;
        margin-bottom: 1rem;
        font-weight: 500;
        line-height: 1.4;
    }
    .hero-highlights-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        font-size: 0.78rem;
        color: #e2e8f0;
    }
    .hero-hl-item {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }
    .hero-hl-item i {
        color: #38bdf8;
    }

    .hero-center-photo {
        flex: 1;
        max-width: 320px;
        height: 140px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .hero-center-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-right-brand {
        flex: 0.9;
        text-align: right;
        border-left: 1px solid rgba(255, 255, 255, 0.15);
        padding-left: 1.5rem;
    }
    .hero-brand-name {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: 0.05em;
        line-height: 1;
        color: #ffffff;
    }
    .hero-brand-sub {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        color: #94a3b8;
        margin-bottom: 0.25rem;
    }
    .hero-brand-tagline {
        font-size: 0.82rem;
        color: #38bdf8;
        font-style: italic;
        margin-bottom: 0.85rem;
    }
    .hero-stats-row {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        font-size: 0.75rem;
    }
    .hero-stat-box {
        text-align: center;
        background: rgba(255, 255, 255, 0.08);
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .hero-stat-number {
        font-weight: 800;
        font-size: 0.9rem;
        color: #38bdf8;
        display: block;
    }
    .hero-stat-label {
        font-size: 0.68rem;
        color: #cbd5e1;
    }

    /* STORE PROFILE HEADER */
    .store-profile-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .store-profile-flex {
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }
    .store-avatar-box {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        border: 2px solid #0066cc;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 0.35rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.08);
    }
    .store-avatar-box i {
        font-size: 1.75rem;
        color: #0066cc;
    }
    .store-avatar-title {
        font-size: 1rem;
        font-weight: 900;
        color: #0066cc;
        line-height: 1;
        margin-top: 0.2rem;
    }
    .store-avatar-sub {
        font-size: 0.45rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .store-info-content {
        flex: 1;
    }
    .store-title-row {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
        margin-bottom: 0.35rem;
    }
    .store-name-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .badge-verified-seller {
        background: #0284c7;
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-top-rated {
        background: #f59e0b;
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
    }

    .store-metrics-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.78rem;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    .store-rating-span {
        color: #f59e0b;
        font-weight: 700;
    }
    .store-desc-para {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.45;
        margin: 0;
        max-width: 780px;
    }

    /* Store Actions */
    .store-actions-col {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.65rem;
        flex-shrink: 0;
    }
    .action-btns-group {
        display: flex;
        gap: 0.5rem;
    }
    .btn-store-action {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        color: #334155;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.45rem 0.85rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-store-action:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-contact-seller {
        background: var(--dc-blue);
        color: #ffffff;
        border: 1px solid var(--dc-blue);
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.45rem 1rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-contact-seller:hover {
        background: var(--dc-blue-hover);
        color: #ffffff;
    }

    /* 4 Trust Highlights Below Actions */
    .store-trust-badges-row {
        display: flex;
        gap: 1.25rem;
        font-size: 0.72rem;
        color: #334155;
        font-weight: 600;
        padding-top: 0.85rem;
        border-top: 1px solid #f1f5f9;
        margin-top: 0.85rem;
    }
    .trust-badge-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .trust-badge-item i {
        color: #10b981;
    }

    /* STORE NAVIGATION TABS */
    .store-nav-tabs-bar {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 8px;
        padding: 0 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 2rem;
        overflow-x: auto;
    }
    .store-tab-link {
        padding: 0.75rem 0.25rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        position: relative;
        white-space: nowrap;
        cursor: pointer;
    }
    .store-tab-link:hover {
        color: var(--dc-blue);
    }
    .store-tab-link.active {
        color: var(--dc-blue);
    }
    .store-tab-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2.5px;
        background: var(--dc-blue);
        border-radius: 2px 2px 0 0;
    }

    /* 3-COLUMN LAYOUT */
    .storefront-grid {
        display: grid;
        grid-template-columns: 240px 1fr 310px;
        gap: 1.25rem;
        align-items: flex-start;
    }

    /* LEFT SIDEBAR */
    .sidebar-search-box {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 8px;
        padding: 0.45rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .sidebar-search-box input {
        border: none;
        outline: none;
        font-size: 0.8rem;
        width: 100%;
        color: #1e293b;
    }
    .sidebar-panel-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .sidebar-card-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.75rem;
    }
    .category-radio-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .category-radio-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.35rem 0;
        font-size: 0.78rem;
        color: #475569;
        cursor: pointer;
        transition: color 0.15s;
    }
    .category-radio-item:hover, .category-radio-item.active {
        color: var(--dc-blue);
        font-weight: 600;
    }
    .category-radio-item input[type="radio"] {
        margin-right: 0.5rem;
    }
    .category-count-badge {
        color: #94a3b8;
        font-size: 0.72rem;
    }

    /* CENTER AREA: SLIDER BANNER */
    .middle-slider-banner {
        background: linear-gradient(135deg, #0e1e38 0%, #172a45 100%);
        border-radius: 12px;
        overflow: hidden;
        color: #ffffff;
        position: relative;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
        min-height: 190px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .slider-content-left {
        max-width: 58%;
        z-index: 2;
    }
    .slider-title {
        font-size: 1.45rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: -0.01em;
        line-height: 1.15;
        margin-bottom: 0.35rem;
        color: #ffffff;
    }
    .slider-subtitle {
        font-size: 0.78rem;
        color: #cbd5e1;
        margin-bottom: 0.75rem;
    }
    .slider-icons-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.85rem;
        font-size: 0.7rem;
        color: #93c5fd;
        margin-bottom: 0.85rem;
    }
    .slider-btn-explore {
        background: #f97316;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.45rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: background 0.2s;
    }
    .slider-btn-explore:hover {
        background: #ea580c;
        color: #ffffff;
    }
    .slider-photo-right {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 42%;
        overflow: hidden;
    }
    .slider-photo-right img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
    }
    .slider-arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.85);
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
        border: none;
        z-index: 3;
    }
    .slider-arrow-prev { left: 8px; }
    .slider-arrow-next { right: 8px; }

    /* FEATURED COURSES & SERVICES HEADINGS */
    .section-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
    }
    .section-main-heading {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .view-all-link {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--dc-blue);
        text-decoration: none;
    }
    .view-all-link:hover {
        text-decoration: underline;
    }

    /* 4 COURSES GRID */
    .courses-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 2rem;
    }
    .course-store-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }
    .course-store-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        color: inherit;
    }
    .course-card-thumb-wrap {
        position: relative;
        height: 110px;
        background: #0f172a;
        overflow: hidden;
    }
    .course-card-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-card-heart {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        cursor: pointer;
        border: none;
        font-size: 0.7rem;
    }
    .course-card-body {
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .course-card-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 0.35rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 32px;
    }
    .course-rating-row {
        font-size: 0.7rem;
        color: #f59e0b;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .course-meta-text {
        font-size: 0.68rem;
        color: #64748b;
        margin-bottom: 0.45rem;
    }
    .course-price-row {
        margin-top: auto;
        display: flex;
        align-items: baseline;
        gap: 0.35rem;
        flex-wrap: wrap;
    }
    .course-current-price {
        font-size: 0.92rem;
        font-weight: 800;
        color: #0f172a;
    }
    .course-mrp-price {
        font-size: 0.72rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .course-discount-pill {
        background: #dcfce7;
        color: #15803d;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
        margin-left: auto;
    }

    /* 4 SERVICES GRID */
    .services-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 2rem;
    }
    .service-store-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .service-store-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        color: inherit;
    }
    .service-card-thumb-wrap {
        height: 105px;
        background: #f1f5f9;
        overflow: hidden;
        position: relative;
    }
    .service-card-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .service-card-body {
        padding: 0.75rem;
    }
    .service-card-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.35rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .service-price-start {
        font-size: 0.7rem;
        color: #64748b;
    }
    .service-price-amount {
        font-size: 0.88rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* RIGHT SIDEBAR */
    .right-sidebar-box {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .right-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .right-box-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .open-status-pill {
        background: #dcfce7;
        color: #15803d;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        margin-bottom: 0.65rem;
    }
    .contact-info-list {
        list-style: none;
        padding: 0;
        margin: 0 0 0.75rem 0;
    }
    .contact-info-item {
        font-size: 0.75rem;
        color: #334155;
        margin-bottom: 0.45rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .contact-info-item i {
        color: var(--dc-blue);
        margin-top: 2px;
    }
    .contact-info-item.whatsapp i {
        color: #25d366;
    }
    .contact-info-item.whatsapp a {
        color: #16a34a;
        font-weight: 700;
        text-decoration: none;
    }

    /* Mini Map */
    .minimap-preview-wrap {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--dc-border);
        position: relative;
        height: 105px;
        background: #e2e8f0;
        margin-bottom: 0.5rem;
    }
    .minimap-preview-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .minimap-pin {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -100%);
        color: #ef4444;
        font-size: 1.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }
    .btn-directions-map {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        color: var(--dc-blue);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: background 0.15s;
    }
    .btn-directions-map:hover {
        background: #eff6ff;
    }

    /* Branches List */
    .branches-list-wrap {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .branch-list-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.75rem;
    }
    .branch-list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .branch-name-title {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.1rem;
    }
    .branch-phone-text {
        font-size: 0.68rem;
        color: #64748b;
    }
    .branch-open-badge {
        background: #dcfce7;
        color: #15803d;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
    }

    /* Custom Training Orange Card */
    .custom-training-card {
        background: #fff7ed;
        border: 1px solid #ffedd5;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
    }
    .custom-training-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #fdba74;
        color: #c2410c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }
    .custom-training-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: #9a3412;
        margin-bottom: 0.25rem;
    }
    .custom-training-desc {
        font-size: 0.72rem;
        color: #c2410c;
        line-height: 1.35;
        margin-bottom: 0.75rem;
    }
    .btn-custom-quote {
        background: #ea580c;
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.45rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.15s;
    }
    .btn-custom-quote:hover {
        background: #c2410c;
        color: #ffffff;
    }

    /* Responsive */
    @media (max-width: 1199px) {
        .storefront-grid {
            grid-template-columns: 220px 1fr;
        }
        .right-sidebar-box {
            grid-column: span 2;
        }
        .courses-grid-4, .services-grid-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 991px) {
        .hero-banner-row {
            flex-direction: column;
            text-align: center;
        }
        .hero-right-brand {
            border-left: none;
            padding-left: 0;
            text-align: center;
        }
        .hero-stats-row {
            justify-content: center;
        }
        .store-profile-flex {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .store-title-row {
            justify-content: center;
        }
        .store-metrics-row {
            justify-content: center;
        }
        .store-actions-col {
            align-items: center;
            width: 100%;
        }
        .store-trust-badges-row {
            justify-content: center;
            flex-wrap: wrap;
        }
        .storefront-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-3">
    <!-- Breadcrumbs -->
    <div class="profile-breadcrumbs">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
        <span class="separator">&gt;</span>
        <a href="{{ route('courses') }}">Sellers</a>
        <span class="separator">&gt;</span>
        <span class="current">{{ $business->business_name ?? 'VCEC - Vinayak Computer Education Center' }}</span>
    </div>

    <!-- 1. TOP PANORAMIC HERO BANNER -->
    <div class="store-hero-banner">
        <div class="hero-banner-row">
            <!-- Left Header -->
            <div class="hero-left-content">
                <h1 class="hero-main-title">Skills for a Brighter Tomorrow</h1>
                <div class="hero-subtitle">
                    Computer Courses | Digital Marketing | Tally | Programming | AI Tools | Web Development | Career Guidance
                </div>
                <div class="hero-highlights-row">
                    <span class="hero-hl-item"><i class="fa-solid fa-desktop"></i> Live Classes</span>
                    <span class="hero-hl-item"><i class="fa-solid fa-certificate"></i> Certified Courses</span>
                    <span class="hero-hl-item"><i class="fa-solid fa-laptop-code"></i> Practical Training</span>
                    <span class="hero-hl-item"><i class="fa-solid fa-handshake"></i> Placement Support</span>
                </div>
            </div>

            <!-- Center Photo -->
            <div class="hero-center-photo">
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&auto=format&fit=crop&q=80" alt="VCEC Institute Lab Training">
            </div>

            <!-- Right Brand -->
            <div class="hero-right-brand">
                <div class="hero-brand-name">VCEC</div>
                <div class="hero-brand-sub">COMPUTER EDUCATION</div>
                <div class="hero-brand-tagline">Learn | Practice | Grow</div>
                <div class="hero-stats-row">
                    <div class="hero-stat-box">
                        <span class="hero-stat-number"><i class="fa-solid fa-users fa-xs me-1"></i>10000+</span>
                        <span class="hero-stat-label">Students Trained</span>
                    </div>
                    <div class="hero-stat-box">
                        <span class="hero-stat-number"><i class="fa-solid fa-building fa-xs me-1"></i>3</span>
                        <span class="hero-stat-label">Branches</span>
                    </div>
                    <div class="hero-stat-box">
                        <span class="hero-stat-number"><i class="fa-solid fa-award fa-xs me-1"></i>15+</span>
                        <span class="hero-stat-label">Certified Courses</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. STORE PROFILE HEADER -->
    <div class="store-profile-card">
        <div class="store-profile-flex">
            <!-- Left Logo -->
            <div class="store-avatar-box">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="store-avatar-title">VCEC</span>
                <span class="store-avatar-sub">COMPUTER EDUCATION</span>
            </div>

            <!-- Center Info -->
            <div class="store-info-content">
                <div class="store-title-row">
                    <h2 class="store-name-title">{{ $business->business_name ?? 'VCEC – Vinayak Computer Education Center' }}</h2>
                    <span class="badge-verified-seller"><i class="fa-solid fa-circle-check"></i> Verified Seller</span>
                    <span class="badge-top-rated"><i class="fa-solid fa-star me-1"></i>Top Rated</span>
                </div>

                <div class="store-metrics-row">
                    <span class="store-rating-span">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span class="ms-1 text-dark">4.8</span>
                    </span>
                    <span>(420 reviews)</span>
                    <span>&bull;</span>
                    <span><i class="fa-solid fa-user-graduate text-primary me-1"></i> 10,000+ Students Trained</span>
                    <span>&bull;</span>
                    <span><i class="fa-solid fa-code-branch text-primary me-1"></i> 3 Branches</span>
                    <span>&bull;</span>
                    <span><i class="fa-solid fa-location-dot text-danger me-1"></i> Ahmedabad, Gujarat</span>
                    <span>&bull;</span>
                    <span><i class="fa-solid fa-calendar-check text-muted me-1"></i> Since 2012</span>
                </div>

                <p class="store-desc-para">
                    {{ $business->description ?? 'VCEC is an ISO 21001:2018 certified computer education institute offering practical and job-oriented training in computer courses, coding, digital marketing, tally, programming, AI and more.' }}
                </p>
            </div>

            <!-- Right Actions -->
            <div class="store-actions-col">
                <div class="action-btns-group">
                    <button type="button" class="btn-store-action" onclick="toggleFollowStore(this)">
                        <i class="fa-regular fa-heart text-danger"></i> Follow Store
                    </button>
                    <button type="button" class="btn-store-action" onclick="shareStoreProfile()">
                        <i class="fa-solid fa-share-nodes"></i> Share
                    </button>
                    <button type="button" class="btn-contact-seller" onclick="openContactModal()">
                        <i class="fa-solid fa-comment-dots"></i> Contact Seller
                    </button>
                </div>
            </div>
        </div>

        <!-- 4 Quality Trust Badges -->
        <div class="store-trust-badges-row">
            <span class="trust-badge-item"><i class="fa-solid fa-shield-halved"></i> High Quality Training</span>
            <span class="trust-badge-item"><i class="fa-solid fa-chalkboard-user"></i> Expert Faculty</span>
            <span class="trust-badge-item"><i class="fa-solid fa-laptop-code"></i> Practical Approach</span>
            <span class="trust-badge-item"><i class="fa-solid fa-certificate"></i> Certificate Provided</span>
        </div>
    </div>

    <!-- 3. STORE NAVIGATION TABS -->
    <div class="store-nav-tabs-bar">
        <a href="#home" class="store-tab-link active">Home</a>
        <a href="#all" class="store-tab-link">All</a>
        <a href="#courses" class="store-tab-link">Courses (12)</a>
        <a href="#services" class="store-tab-link">Our Services (5)</a>
        <a href="#products" class="store-tab-link">Products (8)</a>
        <a href="#about" class="store-tab-link">About VCEC</a>
        <a href="#reviews" class="store-tab-link">Student Reviews (420)</a>
    </div>

    <!-- 4. LOWER 3-COLUMN CONTENT GRID -->
    <div class="storefront-grid">
        <!-- A. LEFT SIDEBAR: SEARCH & CATEGORIES -->
        <div class="store-sidebar-col">
            <!-- Search Inside Store -->
            <div class="sidebar-search-box">
                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                <input type="text" id="storeSearchInput" placeholder="Search in this store..." onkeyup="filterStoreItems(this.value)">
            </div>

            <!-- Browse by Category -->
            <div class="sidebar-panel-card">
                <div class="sidebar-card-title">Browse by Category</div>
                <div class="category-radio-list">
                    @foreach($sidebarCategories as $cat)
                        <label class="category-radio-item {{ $cat['active'] ? 'active' : '' }}">
                            <span>
                                <input type="radio" name="store_cat" value="{{ $cat['name'] }}" {{ $cat['active'] ? 'checked' : '' }} onchange="selectStoreCategory('{{ $cat['name'] }}')">
                                {{ $cat['name'] }}
                            </span>
                            <span class="category-count-badge">{{ $cat['count'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Custom Filter -->
            <div class="sidebar-panel-card">
                <div class="sidebar-card-title">Custom Filter</div>
                <div class="small fw-bold text-dark mb-2">Type</div>
                @foreach($filterTypes as $fType)
                    <div class="d-flex align-items-center justify-content-between small text-muted mb-1">
                        <label class="d-flex align-items-center gap-2 m-0 cursor-pointer">
                            <input type="checkbox" class="form-check-input m-0"> {{ $fType['name'] }}
                        </label>
                        <span class="category-count-badge">({{ $fType['count'] }})</span>
                    </div>
                @endforeach

                <div class="small fw-bold text-dark mt-3 mb-2">Mode</div>
                @foreach($filterModes as $fMode)
                    <div class="d-flex align-items-center justify-content-between small text-muted mb-1">
                        <label class="d-flex align-items-center gap-2 m-0 cursor-pointer">
                            <input type="checkbox" class="form-check-input m-0"> {{ $fMode['name'] }}
                        </label>
                        <span class="category-count-badge">({{ $fMode['count'] }})</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- B. CENTER AREA: SLIDER BANNER & CARDS -->
        <div class="store-center-col">
            <!-- Middle Banner Slider -->
            <div class="middle-slider-banner">
                <button type="button" class="slider-arrow-btn slider-arrow-prev" onclick="prevBannerSlide()"><i class="fa-solid fa-chevron-left"></i></button>
                <button type="button" class="slider-arrow-btn slider-arrow-next" onclick="nextBannerSlide()"><i class="fa-solid fa-chevron-right"></i></button>

                <div class="slider-content-left">
                    <h3 class="slider-title">Learn Today<br>Build Your Tomorrow</h3>
                    <div class="slider-subtitle">Practical Courses | Expert Faculty | Live Projects | Certification</div>
                    
                    <div class="slider-icons-list">
                        <span><i class="fa-solid fa-desktop me-1"></i> Computer Courses</span>
                        <span><i class="fa-solid fa-bullhorn me-1"></i> Digital Marketing</span>
                        <span><i class="fa-solid fa-calculator me-1"></i> Tally & Accounting</span>
                        <span><i class="fa-solid fa-code me-1"></i> Web & App Development</span>
                        <span><i class="fa-solid fa-brain me-1"></i> AI Tools</span>
                        <span><i class="fa-solid fa-compass me-1"></i> Career Guidance</span>
                    </div>

                    <a href="#courses" class="slider-btn-explore">Explore Our Courses &rarr;</a>
                </div>

                <div class="slider-photo-right">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&auto=format&fit=crop&q=80" alt="VCEC Student Success">
                </div>
            </div>

            <!-- FEATURED COURSES SECTION -->
            <div class="mb-4" id="courses">
                <div class="section-header-row">
                    <h3 class="section-main-heading">Featured & Popular Courses</h3>
                    <a href="{{ route('courses') }}" class="view-all-link">View All &rarr;</a>
                </div>

                <div class="courses-grid-4">
                    @foreach($courses as $c)
                        <a href="{{ route('course.show', $c['slug'] ?? 'digital-marketing-complete-course-2026') }}" class="course-store-card">
                            <div class="course-card-thumb-wrap">
                                <img src="{{ $c['thumbnail'] }}" alt="{{ $c['title'] }}">
                                <button type="button" class="btn-card-heart" onclick="event.preventDefault(); toggleCourseHeart(this);">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                            <div class="course-card-body">
                                <div class="course-card-title">{{ $c['title'] }}</div>
                                <div class="course-rating-row">
                                    <i class="fa-solid fa-star"></i> {{ $c['rating'] }} <span class="text-muted fw-normal">({{ $c['reviews_count'] }})</span>
                                </div>
                                <div class="course-meta-text">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $c['duration'] }} &bull; {{ $c['mode'] }}
                                </div>
                                <div class="course-price-row">
                                    <span class="course-current-price">₹{{ number_format($c['price']) }}</span>
                                    <span class="course-mrp-price">₹{{ number_format($c['original_price']) }}</span>
                                    <span class="course-discount-pill">{{ $c['discount'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- OUR SERVICES SECTION -->
            <div class="mb-4" id="services">
                <div class="section-header-row">
                    <h3 class="section-main-heading">Our Services</h3>
                    <a href="javascript:void(0)" onclick="openContactModal()" class="view-all-link">View All &rarr;</a>
                </div>

                <div class="services-grid-4">
                    @foreach($services as $srv)
                        <div class="service-store-card" onclick="openServiceInquiry('{{ addslashes($srv['title']) }}')" style="cursor: pointer;">
                            <div class="service-card-thumb-wrap">
                                <img src="{{ $srv['thumbnail'] }}" alt="{{ $srv['title'] }}">
                                <button type="button" class="btn-card-heart" onclick="event.stopPropagation(); toggleCourseHeart(this);">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                            <div class="service-card-body">
                                <div class="service-card-title" title="{{ $srv['title'] }}">{{ $srv['title'] }}</div>
                                <div class="service-price-start">Starting from</div>
                                <div class="service-price-amount">₹{{ number_format($srv['starting_price']) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- C. RIGHT SIDEBAR: CONTACT, BRANCHES, CUSTOM TRAINING -->
        <div class="store-right-col">
            <!-- Get In Touch Box -->
            <div class="right-sidebar-box">
                <div class="right-box-header">
                    <h4 class="right-box-title">Get in Touch</h4>
                    <a href="javascript:void(0)" onclick="openContactModal()" class="view-all-link">View All &rarr;</a>
                </div>

                <div class="open-status-pill">
                    <i class="fa-solid fa-circle fa-2xs"></i> Open Now &nbsp;9:00 AM - 8:00 PM (Mon - Sun)
                </div>

                <ul class="contact-info-list">
                    <li class="contact-info-item">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:+919876543210" class="text-decoration-none text-dark fw-semibold">+91 98765 43210</a>
                    </li>
                    <li class="contact-info-item whatsapp">
                        <i class="fa-brands fa-whatsapp"></i>
                        <a href="https://wa.me/919876543210?text=Hi%20VCEC,%20I%20am%20interested%20in%20courses." target="_blank">Chat on WhatsApp</a>
                    </li>
                    <li class="contact-info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:info@vcec.in" class="text-decoration-none text-dark">info@vcec.in</a>
                    </li>
                    <li class="contact-info-item">
                        <i class="fa-solid fa-location-dot text-danger"></i>
                        <span>201, Shreeji Complex, Nikol Main Road, Nikol, Ahmedabad - 382350, Gujarat</span>
                    </li>
                </ul>

                <!-- Map Thumbnail -->
                <div class="minimap-preview-wrap">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=400&auto=format&fit=crop&q=80" alt="Nikol Ahmedabad Map Preview">
                    <i class="fa-solid fa-location-dot minimap-pin"></i>
                </div>
                <button type="button" class="btn-directions-map w-100" onclick="openDirectionsMap()">
                    <i class="fa-solid fa-diamond-turn-right me-1"></i> Get Directions
                </button>
            </div>

            <!-- Our Branches Box -->
            <div class="right-sidebar-box">
                <div class="right-box-header">
                    <h4 class="right-box-title">Our Branches (Visit Our Branch)</h4>
                    <a href="javascript:void(0)" onclick="openBranchesModal()" class="view-all-link">View All &rarr;</a>
                </div>

                <div class="branches-list-wrap">
                    @foreach($branches as $b)
                        <div class="branch-list-item">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-location-dot {{ $b['is_head'] ? 'text-danger' : 'text-primary' }}"></i>
                                <div>
                                    <div class="branch-name-title">{{ $b['name'] }}</div>
                                    <div class="branch-phone-text">{{ $b['phone'] }}</div>
                                </div>
                            </div>
                            <span class="branch-open-badge">{{ $b['status'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Need a Custom Training? Card -->
            <div class="custom-training-card">
                <div class="custom-training-icon">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="custom-training-title">Need a Custom Training?</div>
                <div class="custom-training-desc">
                    Get customized courses for your institute, company or team.
                </div>
                <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn-custom-quote border-0" onclick="openCustomTrainingModal()">
                        Request a Quote &rarr;
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold" onclick="openContactModal()" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Book a Free Demo Class
                    </button>
                </div>
            </div>
                    Request a Quote &rarr;
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CONTACT SELLER MODAL -->
<div class="modal fade" id="contactSellerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fa-solid fa-comment-dots text-primary me-2"></i> Contact VCEC Instructor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">Send a direct inquiry to the VCEC admissions and instructor desk.</p>
                <form onsubmit="handleInquirySubmit(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Your Name</label>
                        <input type="text" class="form-control" required placeholder="Full Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mobile Number</label>
                        <input type="tel" class="form-control" required placeholder="+91 98765 43210">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Interested Course / Service</label>
                        <select class="form-select" id="inquiryCourseSelect">
                            <option>Digital Marketing Complete Course</option>
                            <option>Tally Prime with GST</option>
                            <option>Web Development Course</option>
                            <option>AI Tools & ChatGPT</option>
                            <option>Website Development for Institute</option>
                            <option>Other Custom Training</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Message / Questions</label>
                        <textarea class="form-control" rows="3" placeholder="Tell us what you would like to learn..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="background: var(--dc-blue); border: none;">
                        Send Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CUSTOM TRAINING QUOTE MODAL -->
<div class="modal fade" id="trainingQuoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fa-solid fa-graduation-cap text-warning me-2"></i> Custom Institute / Corporate Training
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">Get tailored batch training programs designed for schools, colleges or corporate companies.</p>
                <form onsubmit="handleQuoteSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Organization / Institute Name</label>
                        <input type="text" class="form-control" required placeholder="e.g. ABC Institute / Tech Corp">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Contact Person</label>
                            <input type="text" class="form-control" required placeholder="Full Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone</label>
                            <input type="tel" class="form-control" required placeholder="+91 98765 43210">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Estimated Students / Participants</label>
                        <input type="number" min="5" value="25" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="background: #ea580c; border: none;">
                        Submit Quotation Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT INTERACTIONS -->
<script>
    function toggleFollowStore(btn) {
        const icon = btn.querySelector('i');
        if (icon.classList.contains('fa-regular')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            btn.innerHTML = '<i class="fa-solid fa-heart text-danger"></i> Following';
            showLiveStoreToast('Following VCEC', 'You will receive notifications for new courses and offers!');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            btn.innerHTML = '<i class="fa-regular fa-heart text-danger"></i> Follow Store';
            showLiveStoreToast('Unfollowed', 'Store unfollowed.');
        }
    }

    function shareStoreProfile() {
        if (navigator.share) {
            navigator.share({
                title: 'VCEC - Vinayak Computer Education Center',
                url: window.location.href,
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href);
            showLiveStoreToast('Link Copied', 'Store profile link copied to clipboard!');
        }
    }

    function toggleCourseHeart(btn) {
        const icon = btn.querySelector('i');
        if (icon.classList.contains('fa-regular')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            icon.style.color = '#ef4444';
            showLiveStoreToast('Saved to Wishlist', 'Course added to your wishlist!');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            icon.style.color = '';
            showLiveStoreToast('Removed', 'Course removed from wishlist.');
        }
    }

    function openContactModal() {
        const modal = new bootstrap.Modal(document.getElementById('contactSellerModal'));
        modal.show();
    }

    function openCustomTrainingModal() {
        const modal = new bootstrap.Modal(document.getElementById('trainingQuoteModal'));
        modal.show();
    }

    function openServiceInquiry(serviceTitle) {
        const select = document.getElementById('inquiryCourseSelect');
        if (select) {
            select.value = serviceTitle;
        }
        openContactModal();
    }

    function openDirectionsMap() {
        window.open('https://maps.google.com/?q=Nikol+Ahmedabad+Gujarat', '_blank');
    }

    function openBranchesModal() {
        openContactModal();
    }

    function handleInquirySubmit(e) {
        e.preventDefault();
        const modal = bootstrap.Modal.getInstance(document.getElementById('contactSellerModal'));
        if (modal) modal.hide();
        showLiveStoreToast('Inquiry Sent', 'Thank you! VCEC counselor will contact you shortly.');
    }

    function handleQuoteSubmit(e) {
        e.preventDefault();
        const modal = bootstrap.Modal.getInstance(document.getElementById('trainingQuoteModal'));
        if (modal) modal.hide();
        showLiveStoreToast('Quotation Request Received', 'Our institutional team will send the syllabus and pricing.');
    }

    function filterStoreItems(query) {
        query = query.toLowerCase().trim();
        const cards = document.querySelectorAll('.course-store-card, .service-store-card');
        cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            if (query === '' || text.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function selectStoreCategory(catName) {
        const input = document.getElementById('storeSearchInput');
        if (catName === 'All') {
            filterStoreItems('');
        } else {
            filterStoreItems(catName);
        }
    }

    function prevBannerSlide() {
        showLiveStoreToast('Slide Changed', 'Previous course highlight displayed.');
    }

    function nextBannerSlide() {
        showLiveStoreToast('Slide Changed', 'Next course highlight displayed.');
    }

    function showLiveStoreToast(title, message) {
        let toastEl = document.getElementById('storefrontToast');
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.id = 'storefrontToast';
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
        toastEl.innerHTML = `<strong>${title}</strong>: ${message}`;
        toastEl.style.opacity = '1';
        toastEl.style.transform = 'translateY(0)';
        setTimeout(() => {
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateY(10px)';
        }, 2800);
    }
</script>
@endsection
