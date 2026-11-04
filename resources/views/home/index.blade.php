@extends('layouts.app')

@section('title', 'Digital Class Marketplace - Learn. Hire. Buy. Discover. All in One Place.')

@section('styles')
<style>
    /* Hero Section */
    .dc-hero {
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        padding: 5rem 0 4.5rem;
        border-bottom: 1px solid var(--dc-border);
        position: relative;
        overflow: hidden;
    }

    .dc-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 0.8125rem;
        font-weight: 600;
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        margin-bottom: 1.5rem;
    }

    .dc-hero h1 {
        font-size: 3.25rem;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.03em;
        color: var(--dc-navy);
        margin-bottom: 1.25rem;
    }

    .dc-hero p.lead {
        font-size: 1.15rem;
        color: #475569;
        max-width: 650px;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .dc-hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .btn-hero-primary {
        background-color: var(--dc-primary);
        color: white;
        font-size: 1.05rem;
        font-weight: 700;
        padding: 0.85rem 1.85rem;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(0, 102, 255, 0.3);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }
    .btn-hero-primary:hover {
        background-color: var(--dc-primary-hover);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.4);
    }

    .btn-hero-secondary {
        background-color: #ffffff;
        color: var(--dc-navy);
        border: 1px solid #cbd5e1;
        font-size: 1.05rem;
        font-weight: 600;
        padding: 0.85rem 1.85rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }
    .btn-hero-secondary:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: var(--dc-primary);
    }

    /* Category Cards */
    .dc-section-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--dc-navy);
    }

    .dc-cat-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        padding: 2rem 1.75rem;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .dc-cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .dc-cat-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .dc-promo-banner {
        background: linear-gradient(135deg, #0b1424 0%, #1e293b 100%);
        border-radius: 24px;
        padding: 3.5rem 3rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dc-promo-pattern {
        position: absolute;
        right: -30px;
        bottom: -30px;
        opacity: 0.07;
        font-size: 15rem;
        pointer-events: none;
    }

    /* Info Cards */
    .dc-info-card {
        background: #ffffff;
        border: 1px solid var(--dc-border);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: left;
        height: 100%;
    }

    .dc-info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--dc-primary-soft);
        color: var(--dc-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1.25rem;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="dc-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="dc-hero-badge">
                        <i class="fa-solid fa-sparkles text-primary"></i>
                        <span>Phase 1: Multi-Vendor Seller Foundation</span>
                    </div>

                    <h1>Learn. Hire. Buy. Discover.<br><span style="color: var(--dc-primary);">All in One Place.</span></h1>

                    <p class="lead">
                        Welcome to <strong>Digital Class Marketplace</strong> — a platform connecting learners, professionals, businesses, and customers in one place.
                    </p>

                    <div class="dc-hero-buttons">
                        <a href="{{ route('seller.register') }}" class="btn-hero-primary">
                            <i class="fa-solid fa-store"></i>
                            <span>Become a Seller</span>
                        </a>

                        @auth
                            @if(Auth::user()->isSeller())
                                <a href="{{ route('seller.dashboard') }}" class="btn-hero-secondary">
                                    <i class="fa-solid fa-gauge-high"></i>
                                    <span>Go to Dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('seller.login') }}" class="btn-hero-secondary">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    <span>Seller Login</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('seller.login') }}" class="btn-hero-secondary">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                <span>Seller Login</span>
                            </a>
                        @endauth
                    </div>

                    <div class="d-flex align-items-center gap-4 text-muted small pt-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span>Free Registration</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span>Instant Seller ID</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span>Dedicated Dashboard</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden p-3 bg-white">
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Seller Portal Preview</span>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Awaiting Approval</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px; font-size: 1.1rem;">
                                    DC
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Rahul's Learning Academy</h6>
                                    <span class="text-primary small fw-semibold">Seller ID: DC-SELL-000001</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="p-2 border rounded-3 bg-white text-center">
                                    <small class="text-muted d-block">Account Type</small>
                                    <span class="fw-bold small text-dark">Institute / Company</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded-3 bg-white text-center">
                                    <small class="text-muted d-block">Verification</small>
                                    <span class="fw-bold small text-secondary">Pending</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded-3" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fa-solid fa-bullhorn text-primary"></i>
                                <span class="small fw-bold">Ready to start selling?</span>
                            </div>
                            <p class="small text-muted mb-2">
                                Complete your 4-step seller registration today and get your permanent Seller ID generated instantly.
                            </p>
                            <a href="{{ route('seller.register') }}" class="btn btn-dc-primary btn-sm w-100">
                                Open Your Seller Account &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Marketplace Categories (Coming Soon) -->
    <section class="py-5">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold mb-2">Marketplace Categories</span>
                <h2 class="dc-section-title">Explore What You Can Offer or Discover</h2>
                <p class="text-muted">
                    Our platform architecture is designed to support 4 core multi-vendor marketplace divisions. Customer modules launch in Phase 2.
                </p>
            </div>

            <div class="row g-4">
                <!-- Card 1: Online Courses -->
                <div class="col-lg-3 col-md-6">
                    <div class="dc-cat-card">
                        <div class="dc-cat-icon" style="background-color: #eff6ff; color: #2563eb;">
                            <i class="fa-solid fa-play"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold mb-0">Online Courses</h5>
                            <span class="badge bg-secondary-subtle text-secondary border">Coming Soon</span>
                        </div>
                        <p class="text-muted small flex-grow-1">
                            Upload and sell recorded video lectures, live classes, study notes, and certification programs.
                        </p>
                        <div class="pt-3 border-top mt-auto">
                            <span class="text-primary small fw-semibold">
                                <i class="fa-solid fa-lock me-1"></i> Customer Buying Coming Soon
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Professional Services -->
                <div class="col-lg-3 col-md-6">
                    <div class="dc-cat-card">
                        <div class="dc-cat-icon" style="background-color: #f0fdf4; color: #16a34a;">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold mb-0">Professional Services</h5>
                            <span class="badge bg-secondary-subtle text-secondary border">Coming Soon</span>
                        </div>
                        <p class="text-muted small flex-grow-1">
                            List freelance services, graphic design, web development, digital marketing, and consultations.
                        </p>
                        <div class="pt-3 border-top mt-auto">
                            <span class="text-primary small fw-semibold">
                                <i class="fa-solid fa-lock me-1"></i> Customer Booking Coming Soon
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Products -->
                <div class="col-lg-3 col-md-6">
                    <div class="dc-cat-card">
                        <div class="dc-cat-icon" style="background-color: #fef2f2; color: #dc2626;">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold mb-0">Products</h5>
                            <span class="badge bg-secondary-subtle text-secondary border">Coming Soon</span>
                        </div>
                        <p class="text-muted small flex-grow-1">
                            Sell physical electronics, educational kits, books, hardware, and digital software downloads.
                        </p>
                        <div class="pt-3 border-top mt-auto">
                            <span class="text-primary small fw-semibold">
                                <i class="fa-solid fa-lock me-1"></i> E-commerce Store Coming Soon
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Business Listings -->
                <div class="col-lg-3 col-md-6">
                    <div class="dc-cat-card">
                        <div class="dc-cat-icon" style="background-color: #fdf4ff; color: #9333ea;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold mb-0">Business Listings</h5>
                            <span class="badge bg-secondary-subtle text-secondary border">Coming Soon</span>
                        </div>
                        <p class="text-muted small flex-grow-1">
                            Showcase institutes, coaching centers, studios, agencies, and regional businesses across India.
                        </p>
                        <div class="pt-3 border-top mt-auto">
                            <span class="text-primary small fw-semibold">
                                <i class="fa-solid fa-lock me-1"></i> Public Directory Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Become a Seller Promotional Section -->
    <section class="py-4">
        <div class="container">
            <div class="dc-promo-banner shadow-lg">
                <i class="fa-solid fa-store dc-promo-pattern"></i>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold mb-3">
                            <i class="fa-solid fa-bullhorn me-1"></i> Seller Onboarding Open
                        </span>
                        <h2 class="text-white fw-bold mb-3" style="font-size: 2.25rem;">
                            Grow Your Business with Digital Class
                        </h2>
                        <p class="text-slate-300 mb-4" style="color: #cbd5e1; font-size: 1.1rem; line-height: 1.6;">
                            Register as a seller, showcase your courses, products, services and business, and connect with customers through Digital Class Marketplace.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('seller.register') }}" class="btn btn-dc-primary btn-lg px-4">
                                <i class="fa-solid fa-user-plus me-1"></i> Become a Seller Now
                            </a>
                            <a href="{{ route('seller.login') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Already Registered? Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join Digital Class? (4 Informational Cards) -->
    <section class="py-5">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold mb-2">Seller Advantages</span>
                <h2 class="dc-section-title">Why Join Digital Class?</h2>
                <p class="text-muted">
                    Built for independent educators, institutes, service agencies, and sellers across India.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="dc-info-card">
                        <div class="dc-info-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Reach More Customers</h5>
                        <p class="text-muted small mb-0">
                            Connect with thousands of students, professionals, and institutions looking for your offerings across India.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="dc-info-card">
                        <div class="dc-info-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Manage Your Business</h5>
                        <p class="text-muted small mb-0">
                            Track orders, view real-time performance analytics, manage inquiries, and handle store configurations effortlessly.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="dc-info-card">
                        <div class="dc-info-icon">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Showcase Your Services</h5>
                        <p class="text-muted small mb-0">
                            Create rich listings for courses, freelance services, physical products, and institute branch profiles.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="dc-info-card">
                        <div class="dc-info-icon">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Grow Your Online Presence</h5>
                        <p class="text-muted small mb-0">
                            Build a verified brand presence with customer ratings, reviews, and a unique permanent Seller ID.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

