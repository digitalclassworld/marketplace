@extends('layouts.app')

@section('title', 'Services - Hire Verified Experts & Agencies | Digital Class Marketplace')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<style>
    /* Hero Section */
    .services-hero-banner {
        background: linear-gradient(135deg, #091b33 0%, #0d284f 55%, #143d73 100%);
        color: #ffffff;
        position: relative;
        overflow: hidden;
        padding: 3rem 0 2.5rem;
    }

    .services-hero-banner::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 350px;
        height: 350px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0, 102, 255, 0.25) 0%, rgba(0, 102, 255, 0) 70%);
        pointer-events: none;
    }

    .hero-eyebrow {
        color: #38bdf8;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .hero-heading {
        font-size: 2.35rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.025em;
        color: #ffffff;
        margin-bottom: 0.75rem;
    }

    .hero-subheading {
        font-size: 0.98rem;
        color: #cbd5e1;
        line-height: 1.55;
        max-width: 580px;
        margin-bottom: 1.5rem;
    }

    /* Search Input in Hero */
    .hero-search-wrapper {
        background: #ffffff;
        border-radius: 12px;
        padding: 0.35rem 0.35rem 0.35rem 1rem;
        display: flex;
        align-items: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        max-width: 600px;
    }

    .hero-search-wrapper input {
        border: none;
        outline: none;
        box-shadow: none;
        font-size: 0.95rem;
        width: 100%;
        color: #0f172a;
    }

    .hero-search-wrapper input::placeholder {
        color: #94a3b8;
    }

    .btn-hero-search {
        background-color: #0066ff;
        color: #ffffff;
        font-weight: 600;
        border-radius: 9px;
        padding: 0.65rem 1.4rem;
        font-size: 0.92rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn-hero-search:hover {
        background-color: #0052cc;
        color: #ffffff;
    }

    /* Quick Tags */
    .quick-tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 1rem;
        align-items: center;
    }

    .quick-tag-pill {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #e2e8f0;
        font-size: 0.78rem;
        font-weight: 500;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .quick-tag-pill:hover,
    .quick-tag-pill.active {
        background: #0066ff;
        color: #ffffff;
        border-color: #0066ff;
    }

    /* Trust Badges in Hero */
    .trust-badges-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.75rem;
    }

    .trust-badge-card {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border-radius: 10px;
        padding: 0.55rem 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .trust-badge-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .trust-badge-icon.green { background: rgba(16, 185, 129, 0.2); color: #34d399; }
    .trust-badge-icon.yellow { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
    .trust-badge-icon.blue { background: rgba(56, 189, 248, 0.2); color: #38bdf8; }

    .trust-badge-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.1;
    }

    .trust-badge-sub {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    /* Hero Center Consultant & Handwritten Tagline */
    .hero-center-visual {
        position: relative;
        text-align: center;
    }

    .consultant-photo {
        max-width: 100%;
        height: 280px;
        object-fit: contain;
        border-radius: 16px;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.35));
    }

    .handwritten-tagline {
        font-family: 'Caveat', cursive, sans-serif;
        font-size: 1.85rem;
        color: #ffffff;
        font-weight: 700;
        line-height: 1;
        position: absolute;
        top: 15px;
        right: -30px;
        transform: rotate(4deg);
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    .handwritten-tagline span {
        color: #38bdf8;
    }

    .tagline-underline {
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #f59e0b);
        border-radius: 4px;
        margin-top: 3px;
        margin-left: auto;
    }

    /* 5-Step Process Card in Hero */
    .process-card-hero {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem 1.4rem;
        color: #0f172a;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .process-card-hero h6 {
        font-weight: 700;
        font-size: 0.95rem;
        color: #0f172a;
        margin-bottom: 0.85rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .process-step-row {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.55rem 0;
        border-bottom: 1px dashed #f1f5f9;
    }

    .process-step-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .process-step-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .step-ico-1 { background: #ffedd5; color: #ea580c; }
    .step-ico-2 { background: #dcfce7; color: #16a34a; }
    .step-ico-3 { background: #f3e8ff; color: #9333ea; }
    .step-ico-4 { background: #e0f2fe; color: #0284c7; }
    .step-ico-5 { background: #ecfdf5; color: #059669; }

    .step-main-text {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }

    .step-sub-text {
        font-size: 0.72rem;
        color: #64748b;
    }

    /* Horizontal Category Cards Bar */
    .category-cards-section {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 0;
    }

    .category-scroll-container {
        display: flex;
        gap: 0.85rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    .category-scroll-container::-webkit-scrollbar {
        height: 5px;
    }
    .category-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    .category-card-item {
        flex: 0 0 135px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.65rem 0.55rem;
        text-align: center;
        text-decoration: none;
        color: #0f172a;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .category-card-item:hover,
    .category-card-item.active {
        background: #ffffff;
        border-color: #0066ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.12);
    }

    .category-card-item.active {
        border-color: #0066ff;
        background: #eff6ff;
    }

    .category-card-thumb {
        width: 100%;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 0.5rem;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-card-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.25;
        margin-bottom: 0.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 32px;
    }

    .category-card-experts {
        font-size: 0.7rem;
        color: #0066ff;
        font-weight: 600;
    }

    /* Top Service Providers Carousel / Row */
    .providers-section {
        background: #f8fafc;
        padding: 1.75rem 0 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .section-title-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .section-view-all {
        font-size: 0.85rem;
        font-weight: 600;
        color: #0066ff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .section-view-all:hover {
        text-decoration: underline;
    }

    .provider-cards-row {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scrollbar-width: thin;
    }

    .provider-card {
        flex: 0 0 230px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .provider-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }

    .provider-banner-thumb {
        height: 75px;
        position: relative;
        background: #e2e8f0;
        overflow: hidden;
    }

    .provider-banner-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-top-rated-tag {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #f97316;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .provider-content-box {
        padding: 0.75rem 0.85rem;
        position: relative;
    }

    .provider-avatar-circle {
        position: absolute;
        top: -22px;
        left: 12px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #ffffff;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.82rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .provider-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 14px;
        margin-bottom: 0.2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .provider-meta-row {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        margin-bottom: 0.3rem;
    }

    .provider-meta-row .rating {
        color: #f59e0b;
        font-weight: 700;
    }

    .provider-location-specialty {
        font-size: 0.72rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Main Content Area */
    .services-main-area {
        padding: 2rem 0 3.5rem;
        background-color: #f8fafc;
    }

    /* Left Sidebar Filters */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .filter-head-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1rem;
    }

    .filter-head-wrap h6 {
        font-weight: 700;
        font-size: 0.95rem;
        color: #0f172a;
        margin: 0;
    }

    .clear-all-link {
        font-size: 0.78rem;
        font-weight: 600;
        color: #0066ff;
        text-decoration: none;
    }

    .filter-group {
        margin-bottom: 1.25rem;
        padding-bottom: 1.15rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.65rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-check-label {
        font-size: 0.82rem;
        color: #475569;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #0066ff;
        border-color: #0066ff;
    }

    /* Sort and Top Nav in Listing */
    .listing-header-wrap {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .available-count-heading {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .view-toggle-btns .btn {
        padding: 0.35rem 0.65rem;
        color: #64748b;
        border-color: #e2e8f0;
        background: #ffffff;
    }

    .view-toggle-btns .btn.active {
        color: #0066ff;
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .sort-pills-row {
        display: flex;
        gap: 0.45rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }

    .sort-pill {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .sort-pill:hover,
    .sort-pill.active {
        background: #0066ff;
        color: #ffffff;
        border-color: #0066ff;
    }

    /* Wide Horizontal Service Row Card */
    .service-row-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem;
        margin-bottom: 1rem;
        display: grid;
        grid-template-columns: 210px 1fr 200px;
        gap: 1.25rem;
        align-items: center;
        transition: all 0.2s ease;
        position: relative;
    }

    .service-row-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .service-card-thumb-col {
        position: relative;
        height: 140px;
        border-radius: 10px;
        overflow: hidden;
        background: #e2e8f0;
    }

    .service-card-thumb-col img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-projects-badge {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .service-card-info-col {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .service-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.35rem;
        line-height: 1.35;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .service-title:hover {
        color: #0066ff;
    }

    .service-desc {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.45;
        margin-bottom: 0.65rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .service-tags-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        margin-bottom: 0.75rem;
    }

    .service-tag-chip {
        font-size: 0.72rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        padding: 0.15rem 0.55rem;
        border-radius: 6px;
    }

    .provider-inline-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.65rem;
        font-size: 0.78rem;
    }

    .provider-mini-avatar {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        object-fit: cover;
    }

    .provider-inline-name {
        font-weight: 700;
        color: #1e293b;
    }

    .badge-seller-level {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
    }

    .badge-orange { background: #ffedd5; color: #ea580c; }
    .badge-blue { background: #dbeafe; color: #1d4ed8; }
    .badge-green { background: #dcfce7; color: #15803d; }

    .provider-inline-rating {
        color: #f59e0b;
        font-weight: 700;
    }

    .provider-inline-meta {
        color: #64748b;
    }

    /* Price and Action Right Column */
    .service-card-action-col {
        border-left: 1px solid #f1f5f9;
        padding-left: 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: right;
    }

    .wishlist-heart-btn {
        position: absolute;
        top: 14px;
        right: 14px;
        border: none;
        background: transparent;
        color: #94a3b8;
        font-size: 1.15rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .wishlist-heart-btn:hover,
    .wishlist-heart-btn.active {
        color: #ef4444;
        transform: scale(1.15);
    }

    .service-price-block {
        margin-bottom: 0.65rem;
    }

    .service-price-current {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .service-price-mrp {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 0.35rem;
    }

    .service-discount-badge {
        font-size: 0.68rem;
        font-weight: 700;
        color: #16a34a;
        background: #dcfce7;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        margin-left: 0.35rem;
    }

    .service-delivery-info {
        font-size: 0.74rem;
        color: #64748b;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.35rem;
    }

    .service-revisions-info {
        font-size: 0.74rem;
        color: #64748b;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.35rem;
    }

    .btn-view-service {
        background-color: #0066ff;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.88rem;
        border-radius: 8px;
        padding: 0.55rem 1rem;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
        text-decoration: none;
        width: 100%;
    }

    .btn-view-service:hover {
        background-color: #0052cc;
        color: #ffffff;
    }

    /* Right Sidebar Cards */
    .post-requirement-card {
        background: #fff8f1;
        border: 1px solid #fed7aa;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.05);
    }

    .post-req-header {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .post-req-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #ffedd5;
        color: #ea580c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .post-req-title {
        font-size: 0.98rem;
        font-weight: 800;
        color: #9a3412;
        margin: 0 0 0.2rem;
    }

    .post-req-sub {
        font-size: 0.78rem;
        color: #7c2d12;
        line-height: 1.4;
        margin-bottom: 0.85rem;
    }

    .post-req-checks {
        list-style: none;
        padding: 0;
        margin: 0 0 1rem;
    }

    .post-req-checks li {
        font-size: 0.78rem;
        font-weight: 600;
        color: #431407;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .post-req-checks li i {
        color: #16a34a;
        font-size: 0.85rem;
    }

    .btn-post-requirement {
        background-color: #ea580c;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 8px;
        padding: 0.65rem 1rem;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        text-decoration: none;
        width: 100%;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(234, 88, 12, 0.25);
    }

    .btn-post-requirement:hover {
        background-color: #c2410c;
        color: #ffffff;
    }

    /* Why Choose Our Services Card */
    .why-choose-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .why-choose-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .why-item-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.95rem;
    }

    .why-item-row:last-child {
        margin-bottom: 0;
    }

    .why-item-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .why-ico-blue { background: #eff6ff; color: #2563eb; }
    .why-ico-purple { background: #faf5ff; color: #9333ea; }
    .why-ico-amber { background: #fffbeb; color: #d97706; }
    .why-ico-green { background: #f0fdf4; color: #16a34a; }
    .why-ico-pink { background: #fdf2f8; color: #db2777; }

    .why-item-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.1rem;
    }

    .why-item-desc {
        font-size: 0.72rem;
        color: #64748b;
        line-height: 1.35;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .service-row-card {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .service-card-action-col {
            border-left: none;
            padding-left: 0;
            border-top: 1px solid #f1f5f9;
            padding-top: 1rem;
            text-align: left;
        }
        .service-delivery-info,
        .service-revisions-info {
            justify-content: flex-start;
        }
        .hero-heading {
            font-size: 1.85rem;
        }
        .handwritten-tagline {
            display: none;
        }
    }
</style>
@endsection

@section('content')

<!-- ========================================== -->
<!-- 1. HERO BANNER (Matches Screenshot 1)      -->
<!-- ========================================== -->
<section class="services-hero-banner">
    <div class="container-fluid px-lg-4">
        <div class="row align-items-center g-4">
            <!-- Left: Hero Headline, Subtitle, Search, Tags, Trust Badges -->
            <div class="col-lg-6 col-xl-5">
                <span class="hero-eyebrow">Professional Services</span>
                <h1 class="hero-heading">Get Expert Services<br>For Your Growth</h1>
                <p class="hero-subheading">
                    Hire verified professionals, freelancers and agencies for websites, marketing, design, software, content, accounting and more.
                </p>

                <!-- Search Box -->
                <form action="{{ route('services') }}" method="GET" class="hero-search-wrapper mb-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <i class="fa-solid fa-magnifying-glass text-muted me-2 fs-6"></i>
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="What service do you need?" aria-label="Search services">
                    <button type="submit" class="btn-hero-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Search Service</span>
                    </button>
                </form>

                <!-- Quick Tags -->
                <div class="quick-tags-container">
                    <a href="{{ route('services', ['search' => 'Website']) }}" class="quick-tag-pill {{ $searchQuery === 'Website' ? 'active' : '' }}">
                        <i class="fa-solid fa-globe text-info"></i> Website
                    </a>
                    <a href="{{ route('services', ['search' => 'Social Media']) }}" class="quick-tag-pill {{ $searchQuery === 'Social Media' ? 'active' : '' }}">
                        <i class="fa-solid fa-share-nodes text-warning"></i> Social Media
                    </a>
                    <a href="{{ route('services', ['search' => 'Logo Design']) }}" class="quick-tag-pill {{ $searchQuery === 'Logo Design' ? 'active' : '' }}">
                        <i class="fa-solid fa-pen-ruler text-danger"></i> Logo Design
                    </a>
                    <a href="{{ route('services', ['search' => 'SEO']) }}" class="quick-tag-pill {{ $searchQuery === 'SEO' ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line text-success"></i> SEO
                    </a>
                    <a href="{{ route('services', ['search' => 'App Development']) }}" class="quick-tag-pill {{ $searchQuery === 'App Development' ? 'active' : '' }}">
                        <i class="fa-solid fa-mobile-screen text-primary"></i> App Development
                    </a>
                    <a href="{{ route('services', ['search' => 'Accounting']) }}" class="quick-tag-pill {{ $searchQuery === 'Accounting' ? 'active' : '' }}">
                        <i class="fa-solid fa-calculator text-info"></i> Accounting
                    </a>
                    <a href="{{ route('services', ['search' => 'Content Writing']) }}" class="quick-tag-pill {{ $searchQuery === 'Content Writing' ? 'active' : '' }}">
                        <i class="fa-solid fa-feather text-light"></i> Content Writing
                    </a>
                </div>

                <!-- 3 Trust Badges -->
                <div class="trust-badges-row">
                    <div class="trust-badge-card">
                        <div class="trust-badge-icon green">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div class="trust-badge-title">Verified Experts</div>
                            <div class="trust-badge-sub">Background Checked</div>
                        </div>
                    </div>

                    <div class="trust-badge-card">
                        <div class="trust-badge-icon yellow">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <div class="trust-badge-title">Quality Work</div>
                            <div class="trust-badge-sub">On-Time Delivery</div>
                        </div>
                    </div>

                    <div class="trust-badge-card">
                        <div class="trust-badge-icon blue">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="trust-badge-title">Secure Payments</div>
                            <div class="trust-badge-sub">100% Safe & Secure</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center: Consultant Photo & Handwritten Tagline -->
            <div class="col-lg-3 col-xl-4 d-none d-lg-block text-center position-relative">
                <div class="hero-center-visual">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&auto=format&fit=crop&q=80" alt="Verified Professional Expert" class="consultant-photo shadow-lg">
                    <div class="handwritten-tagline">
                        Your Projects<br>
                        <span>Our Experts</span>
                        <div class="tagline-underline"></div>
                    </div>
                </div>
            </div>

            <!-- Right: 5-Step Process Card -->
            <div class="col-lg-3 col-xl-3">
                <div class="process-card-hero">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0">How It Works</h6>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 0.65rem;">5 Simple Steps</span>
                    </div>

                    <div class="process-step-row">
                        <div class="process-step-icon step-ico-1">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div>
                            <div class="step-main-text">Post Your Requirement</div>
                            <div class="step-sub-text">Get free quotes</div>
                        </div>
                    </div>

                    <div class="process-step-row">
                        <div class="process-step-icon step-ico-2">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <div>
                            <div class="step-main-text">Compare Experts</div>
                            <div class="step-sub-text">Choose best fit</div>
                        </div>
                    </div>

                    <div class="process-step-row">
                        <div class="process-step-icon step-ico-3">
                            <i class="fa-regular fa-comments"></i>
                        </div>
                        <div>
                            <div class="step-main-text">Discuss & Finalize</div>
                            <div class="step-sub-text">Chat, call or meet</div>
                        </div>
                    </div>

                    <div class="process-step-row">
                        <div class="process-step-icon step-ico-4">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="step-main-text">Track Progress</div>
                            <div class="step-sub-text">Stay updated</div>
                        </div>
                    </div>

                    <div class="process-step-row">
                        <div class="process-step-icon step-ico-5">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <div class="step-main-text">Release Payment</div>
                            <div class="step-sub-text">Only when satisfied</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 2. HORIZONTAL CATEGORY CARDS (11 Items)    -->
<!-- ========================================== -->
<section class="category-cards-section">
    <div class="container-fluid px-lg-4">
        <div class="category-scroll-container">
            @foreach($categories as $cat)
                @php
                    $isActive = ($selectedCategory === $cat['name']) || ($selectedCategory === 'all' && $cat['name'] === 'More Services');
                @endphp
                <a href="{{ route('services', array_merge(request()->query(), ['category' => $cat['name'] === 'More Services' ? 'all' : $cat['name']])) }}" 
                   class="category-card-item {{ $isActive ? 'active' : '' }}">
                    <div class="category-card-thumb">
                        @if($cat['image'])
                            <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" loading="lazy">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary-subtle text-primary">
                                <i class="{{ $cat['icon'] }} fs-4"></i>
                            </div>
                        @endif
                    </div>
                    <div class="category-card-title">{{ $cat['name'] }}</div>
                    <div class="category-card-experts">{{ $cat['experts'] }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 3. TOP SERVICE PROVIDERS (Carousel/Cards)  -->
<!-- ========================================== -->
<section class="providers-section">
    <div class="container-fluid px-lg-4">
        <div class="section-title-wrap">
            <h2 class="section-title">Top Service Providers</h2>
            <a href="{{ route('services') }}" class="section-view-all">View All <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>

        <div class="provider-cards-row">
            @foreach($topProviders as $tp)
                <div class="provider-card">
                    <div class="provider-banner-thumb">
                        <img src="{{ $tp['image'] }}" alt="{{ $tp['name'] }}" loading="lazy">
                        <span class="badge-top-rated-tag">{{ $tp['badge'] }}</span>
                    </div>
                    <div class="provider-content-box">
                        <div class="provider-avatar-circle" style="background-color: {{ $tp['bg_color'] }};">
                            {{ $tp['initials'] }}
                        </div>
                        <div class="provider-name" title="{{ $tp['name'] }}">{{ $tp['name'] }}</div>
                        <div class="provider-meta-row">
                            <span class="rating"><i class="fa-solid fa-star"></i> {{ number_format($tp['rating'], 1) }}</span>
                            <span class="text-muted">({{ $tp['reviews_count'] }})</span>
                        </div>
                        <div class="provider-location-specialty">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $tp['city'] }}
                            <span class="mx-1">•</span>
                            <i class="fa-solid fa-layer-group text-primary me-1"></i> {{ $tp['specialty'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 4. MAIN CONTENT: FILTERS, LISTING, SIDEBAR -->
<!-- ========================================== -->
<section class="services-main-area">
    <div class="container-fluid px-lg-4">
        <div class="row g-4">

            <!-- -------------------------------------- -->
            <!-- LEFT COLUMN: FILTERS                   -->
            <!-- -------------------------------------- -->
            <div class="col-lg-3 col-xl-2">
                <form action="{{ route('services') }}" method="GET" id="servicesFilterForm" class="filter-card">
                    @if($searchQuery)
                        <input type="hidden" name="search" value="{{ $searchQuery }}">
                    @endif
                    @if($selectedCategory && $selectedCategory !== 'all')
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    @if($sortBy)
                        <input type="hidden" name="sort" value="{{ $sortBy }}">
                    @endif

                    <!-- Header -->
                    <div class="filter-head-wrap">
                        <h6>Filters</h6>
                        <a href="{{ route('services') }}" class="clear-all-link">Clear All</a>
                    </div>

                    <!-- Location Filter -->
                    <div class="filter-group">
                        <div class="filter-label">Location <i class="fa-solid fa-chevron-down text-muted small"></i></div>
                        <div class="mb-2">
                            <select name="city" class="form-select form-select-sm" onchange="document.getElementById('servicesFilterForm').submit()">
                                <option value="Ahmedabad" {{ $selectedCity === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                                <option value="Surat" {{ $selectedCity === 'Surat' ? 'selected' : '' }}>Surat</option>
                                <option value="Mumbai" {{ $selectedCity === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                                <option value="Delhi" {{ $selectedCity === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                <option value="Bangalore" {{ $selectedCity === 'Bangalore' ? 'selected' : '' }}>Bangalore</option>
                                <option value="All Cities" {{ $selectedCity === 'All Cities' ? 'selected' : '' }}>All Cities</option>
                            </select>
                        </div>
                        <div>
                            <select name="radius" class="form-select form-select-sm" onchange="document.getElementById('servicesFilterForm').submit()">
                                <option value="50" {{ $selectedRadius == '50' ? 'selected' : '' }}>Within 50 km</option>
                                <option value="25" {{ $selectedRadius == '25' ? 'selected' : '' }}>Within 25 km</option>
                                <option value="10" {{ $selectedRadius == '10' ? 'selected' : '' }}>Within 10 km</option>
                                <option value="any" {{ $selectedRadius == 'any' ? 'selected' : '' }}>Any Distance</option>
                            </select>
                        </div>
                    </div>

                    <!-- Service Type Filter -->
                    <div class="filter-group">
                        <div class="filter-label">Service Type <i class="fa-solid fa-chevron-down text-muted small"></i></div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" name="service_type[]" value="Individual Freelancer" id="st_freelancer"
                                {{ in_array('Individual Freelancer', $selectedServiceTypes) ? 'checked' : '' }} onchange="document.getElementById('servicesFilterForm').submit()">
                            <label class="form-check-label" for="st_freelancer">Individual Freelancer</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" name="service_type[]" value="Agency / Company" id="st_agency"
                                {{ in_array('Agency / Company', $selectedServiceTypes) ? 'checked' : '' }} onchange="document.getElementById('servicesFilterForm').submit()">
                            <label class="form-check-label" for="st_agency">Agency / Company</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_type[]" value="Both" id="st_both"
                                {{ in_array('Both', $selectedServiceTypes) ? 'checked' : '' }} onchange="document.getElementById('servicesFilterForm').submit()">
                            <label class="form-check-label" for="st_both">Both</label>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-group">
                        <div class="filter-label">Price Range <i class="fa-solid fa-chevron-down text-muted small"></i></div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-semibold text-muted">₹0</span>
                            <span class="small fw-semibold text-primary" id="maxPriceDisplay">₹{{ number_format($maxPrice) }}+</span>
                        </div>
                        <input type="range" class="form-range" min="1000" max="50000" step="1000" id="priceRangeInput"
                               name="max_price" value="{{ $maxPrice }}"
                               oninput="document.getElementById('maxPriceDisplay').innerText = '₹' + parseInt(this.value).toLocaleString() + '+'"
                               onchange="document.getElementById('servicesFilterForm').submit()">
                    </div>

                    <!-- Delivery Time Filter -->
                    <div class="filter-group">
                        <div class="filter-label">Delivery Time <i class="fa-solid fa-chevron-down text-muted small"></i></div>
                        @foreach(['Within 24 Hours', '2 - 3 Days', '4 - 7 Days', 'More than 7 Days'] as $dt)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" name="delivery_time[]" value="{{ $dt }}" id="dt_{{ Str::slug($dt) }}"
                                    {{ in_array($dt, $selectedDeliveryTimes) ? 'checked' : '' }} onchange="document.getElementById('servicesFilterForm').submit()">
                                <label class="form-check-label" for="dt_{{ Str::slug($dt) }}">{{ $dt }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Ratings Filter -->
                    <div class="filter-group">
                        <div class="filter-label">Ratings <i class="fa-solid fa-chevron-down text-muted small"></i></div>
                        @foreach(['4.5', '4.0', '3.5', '3.0'] as $rt)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" name="rating[]" value="{{ $rt }}" id="rt_{{ str_replace('.', '', $rt) }}"
                                    {{ in_array($rt, $selectedRatings) ? 'checked' : '' }} onchange="document.getElementById('servicesFilterForm').submit()">
                                <label class="form-check-label text-warning" for="rt_{{ str_replace('.', '', $rt) }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor((float)$rt))
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="text-dark small ms-1">{{ $rt }} & Above</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Languages Filter -->
                    <div class="filter-group">
                        <div class="filter-label">Languages <i class="fa-solid fa-chevron-down text-muted small"></i></div>
                        @foreach(['English', 'Hindi', 'Gujarati'] as $lang)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" name="language[]" value="{{ $lang }}" id="lang_{{ Str::slug($lang) }}"
                                    {{ in_array($lang, $selectedLanguages) ? 'checked' : '' }} onchange="document.getElementById('servicesFilterForm').submit()">
                                <label class="form-check-label" for="lang_{{ Str::slug($lang) }}">{{ $lang }}</label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>

            <!-- -------------------------------------- -->
            <!-- CENTER COLUMN: MAIN SERVICES LISTING   -->
            <!-- -------------------------------------- -->
            <div class="col-lg-6 col-xl-7">

                <!-- Header with Available Count & Toggle Icons -->
                <div class="listing-header-wrap">
                    <h2 class="available-count-heading">
                        {{ count($services) > 0 ? number_format(count($services) * 150) . '+ Services Available' : 'Services Available' }}
                    </h2>
                    <div class="btn-group view-toggle-btns" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Grid View">
                            <i class="fa-solid fa-table-cells-large"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary active" title="List View">
                            <i class="fa-solid fa-list-ul"></i>
                        </button>
                    </div>
                </div>

                <!-- Sorting Pills Row -->
                <div class="sort-pills-row">
                    @php
                        $sortOptions = [
                            'popular'    => 'Most Popular',
                            'near_me'    => 'Near Me',
                            'top_rated'  => 'Top Rated',
                            'latest'     => 'Latest',
                            'price_low'  => 'Price Low to High',
                            'price_high' => 'Price High to Low',
                        ];
                    @endphp
                    @foreach($sortOptions as $key => $label)
                        <a href="{{ route('services', array_merge(request()->query(), ['sort' => $key])) }}" 
                           class="sort-pill {{ $sortBy === $key ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <!-- Service List Cards -->
                @forelse($services as $svc)
                    <div class="service-row-card">
                        <!-- Wishlist Heart Button -->
                        <button type="button" class="wishlist-heart-btn" title="Add to Wishlist" onclick="this.classList.toggle('active'); this.querySelector('i').classList.toggle('fa-solid'); this.querySelector('i').classList.toggle('fa-regular')">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                        <!-- Thumbnail with Projects badge -->
                        <div class="service-card-thumb-col">
                            <img src="{{ $svc->thumbnail }}" alt="{{ $svc->title }}" loading="lazy">
                            <div class="video-projects-badge">
                                <i class="fa-solid fa-play fs-7"></i>
                                <span>{{ $svc->video_badge ?? '10+ Projects' }}</span>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="service-card-info-col">
                            <a href="{{ route('service.show', $svc->slug) }}" class="service-title">
                                {{ $svc->title }}
                            </a>
                            <p class="service-desc">{{ $svc->short_description }}</p>

                            <!-- Tags -->
                            <div class="service-tags-wrap">
                                @foreach($svc->tags as $t)
                                    <span class="service-tag-chip">{{ $t }}</span>
                                @endforeach
                            </div>

                            <!-- Provider Meta Row -->
                            <div class="provider-inline-row">
                                <img src="{{ $svc->provider_avatar }}" alt="{{ $svc->provider_name }}" class="provider-mini-avatar">
                                <span class="provider-inline-name">{{ $svc->provider_name }}</span>
                                <span class="badge-seller-level {{ $svc->provider_badge_class ?? 'badge-orange' }}">
                                    {{ $svc->provider_badge }}
                                </span>
                                <span class="provider-inline-rating">
                                    <i class="fa-solid fa-star"></i> {{ number_format($svc->rating, 1) }}
                                    <span class="text-muted fw-normal">({{ $svc->reviews_count }})</span>
                                </span>
                                <span class="provider-inline-meta">
                                    <i class="fa-solid fa-location-dot text-danger"></i> {{ $svc->provider_city }}
                                </span>
                                <span class="provider-inline-meta">•</span>
                                <span class="provider-inline-meta">{{ $svc->projects_count }}</span>
                            </div>
                        </div>

                        <!-- Price and Action Col -->
                        <div class="service-card-action-col">
                            <div class="service-price-block">
                                <span class="service-price-current">₹{{ number_format($svc->price) }}</span>
                                @if(isset($svc->mrp) && $svc->mrp > $svc->price)
                                    <span class="service-price-mrp">₹{{ number_format($svc->mrp) }}</span>
                                    <span class="service-discount-badge">{{ $svc->discount_percent }}% OFF</span>
                                @endif
                            </div>

                            <div class="service-delivery-info">
                                <i class="fa-solid fa-rotate-left text-primary"></i>
                                <span>{{ $svc->delivery_text }}</span>
                            </div>

                            <div class="service-revisions-info">
                                <i class="fa-solid fa-arrows-rotate text-success"></i>
                                <span>{{ $svc->revision_text }}</span>
                            </div>

                            <a href="{{ route('service.show', $svc->slug) }}" class="btn-view-service">
                                <span>View Details</span>
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border rounded-4 p-5 text-center">
                        <div class="mb-3 text-muted">
                            <i class="fa-solid fa-magnifying-glass fs-1 text-primary-subtle"></i>
                        </div>
                        <h5 class="fw-bold text-dark">No Services Found</h5>
                        <p class="text-muted small mb-3">Try adjusting your search criteria or resetting filters to see more results.</p>
                        <a href="{{ route('services') }}" class="btn btn-primary btn-sm px-4">Reset All Filters</a>
                    </div>
                @endforelse
            </div>

            <!-- -------------------------------------- -->
            <!-- RIGHT COLUMN: SIDEBAR CARDS            -->
            <!-- -------------------------------------- -->
            <div class="col-lg-3 col-xl-3">
                <!-- 1. Post Your Service Requirement (Orange Card) -->
                <div class="post-requirement-card">
                    <div class="post-req-header">
                        <div class="post-req-icon">
                            <i class="fa-solid fa-clipboard-question"></i>
                        </div>
                        <div>
                            <h3 class="post-req-title">Post Your Service Requirement</h3>
                        </div>
                    </div>
                    <p class="post-req-sub">
                        Tell us what you need and receive free quotes from verified experts.
                    </p>
                    <ul class="post-req-checks">
                        <li><i class="fa-solid fa-circle-check"></i> Get Multiple Quotes</li>
                        <li><i class="fa-solid fa-circle-check"></i> Compare &amp; Choose</li>
                        <li><i class="fa-solid fa-circle-check"></i> No Obligation</li>
                        <li><i class="fa-solid fa-circle-check"></i> 100% Free to Post</li>
                    </ul>
                    <button type="button" class="btn-post-requirement" data-bs-toggle="modal" data-bs-target="#postRequirementModal">
                        <span>Post Requirement</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

                <!-- 2. Why Choose Our Services? -->
                <div class="why-choose-card">
                    <h4 class="why-choose-title">Why Choose Our Services?</h4>

                    <div class="why-item-row">
                        <div class="why-item-icon why-ico-blue">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="why-item-title">Verified &amp; Trusted Experts</div>
                            <div class="why-item-desc">Background checked professionals</div>
                        </div>
                    </div>

                    <div class="why-item-row">
                        <div class="why-item-icon why-ico-purple">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <div>
                            <div class="why-item-title">Quality Assurance</div>
                            <div class="why-item-desc">Get best quality work</div>
                        </div>
                    </div>

                    <div class="why-item-row">
                        <div class="why-item-icon why-ico-amber">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div class="why-item-title">On-Time Delivery</div>
                            <div class="why-item-desc">Never miss a deadline</div>
                        </div>
                    </div>

                    <div class="why-item-row">
                        <div class="why-item-icon why-ico-green">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <div class="why-item-title">Secure Payments</div>
                            <div class="why-item-desc">100% safe &amp; secure</div>
                        </div>
                    </div>

                    <div class="why-item-row">
                        <div class="why-item-icon why-ico-pink">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <div>
                            <div class="why-item-title">Support &amp; Revisions</div>
                            <div class="why-item-desc">Get help even after delivery</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 5. MODALS: POST REQUIREMENT & SERVICE SHOW -->
<!-- ========================================== -->

<!-- Post Requirement Modal -->
<div class="modal fade" id="postRequirementModal" tabindex="-1" aria-labelledby="postRequirementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-3 px-4">
                <h5 class="modal-title fw-bold fs-6" id="postRequirementModalLabel">
                    <i class="fa-solid fa-paper-plane me-2"></i> Post Your Service Requirement
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="postReqForm" onsubmit="handlePostReqSubmit(event)">
                <div class="modal-body p-4">
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="fa-solid fa-circle-info me-1"></i> Receive custom proposals and quotes from verified agencies within 2 hours.
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Service Category *</label>
                        <select class="form-select form-select-sm" required id="reqCategory">
                            <option value="Website Development">Website Development</option>
                            <option value="Mobile App Development">Mobile App Development</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="Logo & Branding">Logo &amp; Branding</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="SEO Services">SEO Services</option>
                            <option value="Content Writing">Content Writing</option>
                            <option value="Accounting & Finance">Accounting &amp; Finance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Project Title / Summary *</label>
                        <input type="text" class="form-control form-control-sm" id="reqTitle" placeholder="e.g. Need institute website with admission portal" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Detailed Requirements *</label>
                        <textarea class="form-control form-control-sm" id="reqDetails" rows="3" placeholder="Describe your expectations, features needed, timeline..." required></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Your Budget (₹)</label>
                            <input type="number" class="form-control form-control-sm" id="reqBudget" placeholder="e.g. 10000">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Phone / WhatsApp *</label>
                            <input type="tel" class="form-control form-control-sm" id="reqPhone" placeholder="+91 98765 43210" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold">Submit Requirement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Service Detail & Hire Modal -->
<div class="modal fade" id="serviceDetailModal" tabindex="-1" aria-labelledby="serviceDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-bottom p-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary fw-bold" id="modalServiceCategory">Website</span>
                    <span class="badge bg-warning-subtle text-warning fw-bold" id="modalServiceRating"><i class="fa-solid fa-star"></i> 4.8</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-5">
                        <img id="modalServiceThumb" src="" alt="Service preview" class="w-100 rounded-3 shadow-sm mb-3" style="height: 180px; object-fit: cover;">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img id="modalProviderAvatar" src="" class="rounded-circle" style="width: 34px; height: 34px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 fw-bold fs-7 text-dark" id="modalProviderName">Tech Solutions</h6>
                                    <small class="text-muted" id="modalProviderCity">Ahmedabad</small>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between text-muted small mb-1">
                                <span>Delivery Time:</span>
                                <strong class="text-dark" id="modalDelivery">3 Days</strong>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mb-1">
                                <span>Revisions:</span>
                                <strong class="text-dark" id="modalRevisions">Unlimited</strong>
                            </div>
                            <div class="d-flex justify-content-between text-muted small">
                                <span>Support:</span>
                                <strong class="text-success">Dedicated Manager</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 class="fw-bold text-dark fs-5 mb-2" id="modalServiceTitle">Professional Website Development</h4>
                        <p class="text-muted small mb-3" id="modalServiceDesc">Complete responsive web application.</p>
                        
                        <div class="mb-3">
                            <label class="small fw-bold text-muted text-uppercase mb-1">Key Features Included:</label>
                            <div id="modalServiceTags" class="d-flex flex-wrap gap-1"></div>
                        </div>

                        <div class="p-3 rounded-3 mb-3" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small d-block">All-Inclusive Package Price:</span>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <h3 class="fw-bold text-primary mb-0" id="modalServicePrice">₹5,999</h3>
                                        <span class="text-muted text-decoration-line-through small" id="modalServiceMrp">₹12,000</span>
                                        <span class="badge bg-success-subtle text-success small">Verified Offer</span>
                                    </div>
                                </div>
                                <a href="https://wa.me/919876543210?text=Hello,%20I%20am%20interested%20in%20your%20service" target="_blank" class="btn btn-success btn-sm px-3 fw-bold">
                                    <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        </div>

                        <form onsubmit="handleHireSubmit(event)">
                            <div class="mb-2">
                                <input type="tel" class="form-control form-control-sm" placeholder="Enter your contact number for callback" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                <i class="fa-solid fa-paper-plane me-1"></i> Request Immediate Callback &amp; Demo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openServiceDetailModal(svc) {
        document.getElementById('modalServiceCategory').innerText = svc.category || 'Service';
        document.getElementById('modalServiceRating').innerHTML = '<i class="fa-solid fa-star"></i> ' + (svc.rating || 4.8);
        document.getElementById('modalServiceThumb').src = svc.thumbnail;
        document.getElementById('modalProviderAvatar').src = svc.provider_avatar;
        document.getElementById('modalProviderName').innerText = svc.provider_name;
        document.getElementById('modalProviderCity').innerText = svc.provider_city || 'India';
        document.getElementById('modalDelivery').innerText = svc.delivery_text || '3-5 Days';
        document.getElementById('modalRevisions').innerText = svc.revision_text || 'Unlimited';
        document.getElementById('modalServiceTitle').innerText = svc.title;
        document.getElementById('modalServiceDesc').innerText = svc.short_description;
        document.getElementById('modalServicePrice').innerText = '₹' + parseInt(svc.price).toLocaleString();
        if (svc.mrp) {
            document.getElementById('modalServiceMrp').innerText = '₹' + parseInt(svc.mrp).toLocaleString();
        }

        const tagsContainer = document.getElementById('modalServiceTags');
        tagsContainer.innerHTML = '';
        if (svc.tags && Array.isArray(svc.tags)) {
            svc.tags.forEach(t => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-light text-dark border';
                badge.innerText = t;
                tagsContainer.appendChild(badge);
            });
        }

        const modal = new bootstrap.Modal(document.getElementById('serviceDetailModal'));
        modal.show();
    }

    function handlePostReqSubmit(e) {
        e.preventDefault();
        const modalEl = document.getElementById('postRequirementModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
        alert('Thank you! Your requirement has been posted successfully. Verified experts will contact you shortly.');
        document.getElementById('postReqForm').reset();
    }

    function handleHireSubmit(e) {
        e.preventDefault();
        const modalEl = document.getElementById('serviceDetailModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
        alert('Thank you! Your inquiry has been sent directly to the service provider. You will receive a call/message within 30 minutes.');
    }
</script>
@endsection

