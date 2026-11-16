<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Digital Class Marketplace - Learn, Hire, Buy, Discover')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans, Outfit & JetBrains Mono (Super Premium Typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --dc-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --dc-font-heading: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            --dc-font-mono: 'JetBrains Mono', monospace;
            --dc-primary: #0066ff;
            --dc-primary-hover: #0052cc;
            --dc-primary-soft: #eff6ff;
            --dc-navy: #0b1424;
            --dc-dark: #0f172a;
            --dc-gray-bg: #f8fafc;
            --dc-border: #e2e8f0;
            --dc-text-muted: #64748b;
            --dc-success: #10b981;
            --dc-warning: #f59e0b;
            --dc-card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --dc-card-hover-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12);
        }

        ::selection {
            background: #dbeafe;
            color: #1d4ed8;
        }

        body {
            font-family: var(--dc-font-sans);
            background-color: var(--dc-gray-bg);
            color: var(--dc-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand, .dc-brand {
            font-family: var(--dc-font-heading);
            letter-spacing: -0.025em;
        }

        .font-monospace, code {
            font-family: var(--dc-font-mono) !important;
            letter-spacing: 0.02em;
        }

        /* Top Notification Bar */
        .dc-top-alert {
            background: linear-gradient(90deg, #070c18 0%, #0f1a30 100%);
            color: #94a3b8;
            font-size: 0.8125rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dc-top-alert a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.15s ease;
        }
        .dc-top-alert a:hover {
            color: #7dd3fc;
            text-decoration: underline;
        }

        .dc-live-dot {
            width: 7px;
            height: 7px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: dcPulse 2s infinite;
        }
        @keyframes dcPulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Navigation */
        .dc-navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }

        .dc-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            transition: transform 0.2s ease;
        }
        .dc-brand:hover {
            transform: scale(1.02);
        }

        .dc-brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0066ff 0%, #00d2ff 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(0, 102, 255, 0.25);
        }

        .dc-brand span.dc-highlight {
            color: var(--dc-primary);
        }

        .dc-brand-subtitle {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--dc-text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: block;
            margin-top: -2px;
        }

        .nav-link.dc-nav-link {
            font-weight: 600;
            font-size: 0.875rem;
            color: #475569;
            padding: 0.45rem 0.9rem !important;
            border-radius: 999px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .nav-link.dc-nav-link:hover {
            color: var(--dc-primary);
            background-color: var(--dc-primary-soft);
        }

        .nav-link.dc-nav-link.active-marketplace-tab {
            color: #0066ff !important;
            background-color: #eff6ff;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 102, 255, 0.1);
        }

        .nav-link.dc-nav-link.active-marketplace-tab::after {
            display: none;
        }

        /* Navbar Search Box */
        .dc-nav-search-wrap {
            position: relative;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            transition: all 0.2s ease;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 2px 3px 2px 14px;
        }
        .dc-nav-search-wrap:focus-within {
            background: #ffffff;
            border-color: #0066ff;
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.12);
        }
        .dc-nav-search-input {
            border: none;
            background: transparent;
            font-size: 0.85rem;
            color: #1e293b;
            outline: none;
            width: 100%;
        }
        .dc-nav-search-input::placeholder {
            color: #94a3b8;
        }
        .dc-nav-search-btn {
            border: none;
            background: #0066ff;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .dc-nav-search-btn:hover {
            background: #0052cc;
            transform: scale(1.05);
        }

        .dc-badge-soon {
            font-size: 0.65rem;
            font-weight: 600;
            background: #f1f5f9;
            color: #64748b;
            padding: 0.15rem 0.45rem;
            border-radius: 999px;
            margin-left: 0.25rem;
            vertical-align: middle;
        }

        .btn-dc-primary {
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
        }

        .btn-dc-primary:hover {
            background: linear-gradient(135deg, #0052cc 0%, #004099 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 102, 255, 0.35);
        }

        .btn-dc-outline {
            background-color: #ffffff;
            border: 1px solid var(--dc-border);
            color: var(--dc-dark);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1.15rem;
            border-radius: 999px;
            transition: all 0.2s ease;
        }

        .btn-dc-outline:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--dc-primary);
        }

        /* Footer */
        .dc-footer {
            background: linear-gradient(180deg, #0b1424 0%, #060b14 100%);
            color: #94a3b8;
            padding: 4.5rem 0 2rem;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .dc-footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dc-footer a:hover {
            color: #38bdf8;
            padding-left: 2px;
        }

        .dc-footer-title {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.06em;
            color: #93c5fd;
        }

        .dc-footer-social-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dc-footer-social-btn:hover {
            background: #0066ff;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.35);
        }

        /* Flash Message Alert */
        .alert-floating {
            position: fixed;
            top: 85px;
            right: 20px;
            z-index: 1090;
            min-width: 320px;
            max-width: 450px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            border-radius: 12px;
            border: none;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="dc-top-alert">
        <div class="container-fluid px-lg-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="dc-live-dot me-2"></span>
                <span class="fw-semibold text-light">Digital Class Marketplace:</span>
                <span class="ms-1 text-secondary">Discover courses, hire experts, shop products & explore local businesses.</span>
            </div>
            <div class="d-none d-md-flex align-items-center gap-3">
                <span class="text-secondary">Are you an educator, agency, or institute?</span>
                <a href="{{ route('seller.register') }}" class="d-inline-flex align-items-center gap-1">
                    <span>Join as a Seller</span>
                    <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar (Matching UI/UX Design) -->
    <nav class="navbar navbar-expand-xl dc-navbar bg-white border-bottom sticky-top py-2">
        <div class="container-fluid px-lg-4">
            <!-- Brand Logo -->
            <a class="dc-brand me-3 d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Digital Class Educational World" class="dc-navbar-logo" style="height: 42px; width: auto; max-height: 44px; object-fit: contain;">
                <span class="visually-hidden">Digital Class</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMarketplace" aria-controls="navbarMarketplace" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars text-dark fs-4"></i>
            </button>

            <!-- Navigation Links & Search -->
            <div class="collapse navbar-collapse" id="navbarMarketplace">
                <ul class="navbar-nav me-3 mb-2 mb-xl-0 align-items-xl-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dc-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Explore
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                            <li><a class="dropdown-item small py-2" href="{{ route('home') }}"><i class="fa-solid fa-table-cells me-2 text-primary"></i> All Categories</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('courses') }}"><i class="fa-solid fa-graduation-cap me-2 text-info"></i> Online Courses</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('seller.register') }}"><i class="fa-solid fa-store me-2 text-success"></i> Become a Seller</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('courses') ? 'active-marketplace-tab' : '' }}" href="{{ route('courses') }}" title="Online Courses">Courses<span class="visually-hidden"> Online Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('services') ? 'active-marketplace-tab' : '' }}" href="{{ route('services') }}" title="Professional Services" data-module="Professional Services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('products') ? 'active-marketplace-tab' : '' }}" href="{{ route('products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link {{ request()->routeIs('home') || request()->routeIs('business.*') ? 'active-marketplace-tab' : '' }}" href="{{ route('home') }}">Businesses</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dc-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            For Institutions
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                            <li><a class="dropdown-item small py-2" href="{{ route('seller.register') }}"><i class="fa-solid fa-school me-2 text-primary"></i> Institute Onboarding</a></li>
                            <li><a class="dropdown-item small py-2" href="{{ route('seller.register') }}"><i class="fa-solid fa-building me-2 text-secondary"></i> Agency Partnership</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Center Search Input with Modern Pill -->
                <form action="{{ route('home') }}" method="GET" class="flex-grow-1 mx-xl-3 my-2 my-xl-0" style="max-width: 460px;">
                    <div class="dc-nav-search-wrap">
                        <i class="fa-solid fa-magnifying-glass text-muted me-2" style="font-size: 0.85rem;"></i>
                        <input type="text" name="search" value="{{ request('search') }}" class="dc-nav-search-input" placeholder="Search courses, businesses, products, services...">
                        <button class="dc-nav-search-btn" type="submit" title="Search">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Side Elements -->
                <div class="d-flex align-items-center gap-2 gap-xl-3 ms-xl-auto mt-2 mt-xl-0 flex-wrap">
                    <!-- Location Selector -->
                    <div class="dropdown d-none d-md-block">
                        <button class="btn btn-sm btn-light border-0 dropdown-toggle small text-muted d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-location-dot text-primary"></i>
                            <span class="text-dark fw-semibold">Ahmedabad</span>
                        </button>
                        <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                            <li><a class="dropdown-item small" href="#">Ahmedabad</a></li>
                            <li><a class="dropdown-item small" href="#">Mumbai</a></li>
                            <li><a class="dropdown-item small" href="#">Delhi NCR</a></li>
                            <li><a class="dropdown-item small" href="#">Bengaluru</a></li>
                        </ul>
                    </div>

                    <!-- Cart Icon with Badge -->
                    <a href="#" class="btn btn-light rounded-circle position-relative p-2" title="Cart">
                        <i class="fa-solid fa-cart-shopping text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            3
                        </span>
                    </a>

                    <!-- Auth Buttons -->
                    @auth
                        @if(Auth::user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="btn btn-primary btn-sm px-3 fw-bold" style="background-color: #0066ff;">
                                <i class="fa-solid fa-gauge-high me-1"></i> Seller Dashboard
                            </a>
                        @elseif(Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm px-3 fw-bold" style="background-color: #0f172a;">
                                <i class="fa-solid fa-shield-halved text-warning me-1"></i> Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('seller.register') }}" class="btn btn-primary btn-sm px-3 fw-bold" style="background-color: #0066ff;">
                                Become a Seller
                            </a>
                        @endif
                    @else
                        <a href="{{ route('seller.login') }}" class="btn btn-outline-secondary btn-sm px-3 fw-semibold">
                            Login
                        </a>
                        <a href="{{ route('seller.register') }}" class="btn btn-primary btn-sm px-3 fw-bold" style="background-color: #0066ff;">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Toast / Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-floating" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Success</h6>
                    <small>{{ session('success') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-floating" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Notice</h6>
                    <small>{{ session('error') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show alert-floating" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-info fs-4 me-3 text-info"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Information</h6>
                    <small>{{ session('info') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Coming Soon Modal for Unbuilt Customer Marketplace Modules -->
    <div class="modal fade" id="comingSoonModal" tabindex="-1" aria-labelledby="comingSoonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 50%; background-color: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-rocket fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="modalModuleName">Coming Soon</h5>
                    <p class="text-muted small mb-4">
                        This customer marketplace feature is scheduled for our upcoming release phase. We are currently onboarding verified educators, service providers, and businesses.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('seller.register') }}" class="btn btn-dc-primary px-4">
                            Register as a Seller
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="dc-footer">
        <div class="container-fluid px-lg-5">
            <!-- Trust Metric Highlights Strip -->
            <div class="row g-3 pb-4 mb-4 border-bottom" style="border-color: rgba(255,255,255,0.08) !important;">
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(0, 102, 255, 0.15); color: #38bdf8; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">100% Verified</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Authentic Sellers & Institutes</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">Direct Contact</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Call or WhatsApp Sellers Instantly</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); color: #fbbf24; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">Genuine Ratings</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Real Community Feedback</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); color: #c084fc; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold small">Zero Commission</div>
                        <div class="text-secondary small" style="font-size: 0.72rem;">Grow Your Business Without Hidden Fees</div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Digital Class" style="height: 42px; width: auto; background: white; padding: 6px 12px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                        <h4 class="visually-hidden">Digital Class</h4>
                    </div>
                    <p class="small text-secondary mb-3" style="line-height: 1.6;">
                        Digital Class Marketplace &mdash; <strong>Learn. Hire. Buy. Discover.</strong> India's leading multi-vendor educational and local business ecosystem connecting students, clients, shoppers, and verified businesses in one trusted platform.
                    </p>
                    
                    <!-- Social Media Links -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="dc-footer-social-btn" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>

                    <div class="d-flex gap-2">
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Digital Class Official</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Secure Cloud Platform</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="dc-footer-title">Marketplace</div>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Local Businesses</a></li>
                        <li><a href="{{ route('courses') }}">Online Courses</a></li>
                        <li><a href="{{ route('products') }}">Shop Products</a></li>
                        <li><a href="{{ route('services') }}">Hire Services</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog & Guides</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="dc-footer-title">Seller Portal</div>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('seller.register') }}" class="text-info fw-semibold"><i class="fa-solid fa-arrow-right me-1 small"></i> Become a Seller</a></li>
                        <li><a href="{{ route('seller.login') }}">Seller Login</a></li>
                        <li>
                            <a href="{{ $superAdminUrl ?? (config('app.super_admin_url') ?: url('/super/admin/login')) }}" target="_blank" rel="noopener noreferrer" class="text-warning-emphasis">
                                <i class="fa-solid fa-shield-halved me-1 text-warning"></i> Super Admin Portal <i class="fa-solid fa-arrow-up-right-from-square ms-1 small" style="font-size: 0.68rem;"></i>
                            </a>
                        </li>
                        @auth
                            @if(Auth::user()->isSeller())
                                <li><a href="{{ route('seller.dashboard') }}">Seller Dashboard</a></li>
                                <li><a href="{{ route('seller.profile') }}">Store Settings</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="dc-footer-title">Get in Touch</div>
                    <p class="small text-secondary mb-3">
                        Have questions about listing your institute, coaching academy, services, or products? Our vendor onboarding advisors are ready to assist.
                    </p>
                    <div class="d-flex align-items-center gap-2 text-secondary small mb-2">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <span>support@digitalclassworld.com</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-secondary small">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <span>+91 98765 43210 &bull; Mon - Sat, 9am - 7pm IST</span>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.08);">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary pt-2 pb-3">
                <div>
                    &copy; {{ date('Y') }} Digital Class Marketplace &bull; All Rights Reserved.
                </div>
                <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
                    <a href="{{ $superAdminUrl ?? (config('app.super_admin_url') ?: url('/super/admin/login')) }}" target="_blank" rel="noopener noreferrer" class="text-secondary text-decoration-none hover-white small">
                        <i class="fa-solid fa-lock me-1"></i> Admin Portal
                    </a>
                    <span>&bull;</span>
                    <span>100% Genuine & Verified Marketplace</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Modal module dynamic title
        const comingSoonModal = document.getElementById('comingSoonModal');
        if (comingSoonModal) {
            comingSoonModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const moduleName = button.getAttribute('data-module') || 'Marketplace Feature';
                const modalTitle = comingSoonModal.querySelector('#modalModuleName');
                modalTitle.textContent = moduleName + ' (Coming Soon)';
            });
        }

        // Auto-dismiss floating alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-floating');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    @yield('scripts')
</body>
</html>

