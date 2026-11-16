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

                    <!-- Cart Icon with Live Dynamic Badge -->
                    <button type="button" class="btn btn-light rounded-circle position-relative p-2 border-0 shadow-sm dc-cart-nav-btn" onclick="openCartDrawer()" title="View Shopping Cart" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s;">
                        <i class="fa-solid fa-cart-shopping text-secondary fs-6"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartNavBadge" style="font-size: 0.65rem; display: none;">
                            0
                        </span>
                    </button>

                    <!-- Auth Buttons (Customer vs Seller Awareness) -->
                    @auth
                        @if(Auth::user()->isCustomer())
                            <!-- Customer Account Menu -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-1.5 rounded-pill px-2.5 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 26px; height: 26px; font-size: 0.75rem;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <span class="fw-semibold text-dark small text-truncate" style="max-width: 110px;">{{ Auth::user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-1" style="min-width: 200px;">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold text-dark small">{{ Auth::user()->name }}</div>
                                        <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email }}</div>
                                        <span class="badge bg-primary-subtle text-primary mt-1" style="font-size: 0.65rem;">Customer Account</span>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2" href="{{ route('customer.orders') }}">
                                            <i class="fa-solid fa-bag-shopping me-2 text-primary"></i> My Orders & Purchases
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form method="POST" action="{{ route('customer.logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item small py-2 text-danger">
                                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif(Auth::user()->isSeller())
                            <!-- Logged in as Seller -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center gap-1.5 rounded-pill px-3 py-1.5 fw-semibold" style="background-color: #0066ff;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-store"></i>
                                    <span class="small">Seller: {{ \Illuminate\Support\Str::limit(Auth::user()->name, 12) }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-1" style="min-width: 220px;">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold text-dark small">{{ Auth::user()->name }}</div>
                                        <span class="badge bg-warning-subtle text-warning-emphasis" style="font-size: 0.65rem;">Seller Mode</span>
                                        <div class="text-muted mt-1" style="font-size: 0.7rem; line-height: 1.3;">To make purchases, customer authentication is required.</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2" href="{{ route('seller.dashboard') }}">
                                            <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Seller Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small py-2 text-primary" href="javascript:void(0)" onclick="openCustomerAuthModal('login')">
                                            <i class="fa-solid fa-user-plus me-2"></i> Login as Customer
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form method="POST" action="{{ route('seller.logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item small py-2 text-danger">
                                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout Seller
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif(Auth::user()->isSuperAdmin())
                            <!-- Logged in as Admin -->
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm px-3 fw-bold" style="background-color: #0f172a;">
                                    <i class="fa-solid fa-shield-halved text-warning me-1"></i> Admin Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger p-1.5 rounded-circle" title="Logout">
                                        <i class="fa-solid fa-power-off" style="font-size: 0.75rem;"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <!-- Guest: Customer Login & Sign Up -->
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-semibold" onclick="openCustomerAuthModal('login')">
                            <i class="fa-regular fa-user me-1"></i> Login
                        </button>
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" style="background-color: #0066ff;" onclick="openCustomerAuthModal('register')">
                            Sign Up
                        </button>
                        <a href="{{ route('seller.register') }}" class="small text-muted text-decoration-none d-none d-lg-inline ms-1" style="font-size: 0.75rem;" title="Start selling courses & services">
                            Become a Seller
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

    <!-- ============================================================================
         SHOPPING CART OFFCANVAS DRAWER (100% Workable)
         ============================================================================ -->
    <div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" style="width: 420px; max-width: 100vw; z-index: 1060;">
        <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-cart-shopping fs-6"></i>
                </div>
                <div>
                    <h5 class="offcanvas-title fw-bold text-dark mb-0 fs-6" id="cartOffcanvasLabel">My Shopping Cart</h5>
                    <small class="text-muted" id="cartDrawerCountText" style="font-size: 0.725rem;">0 items in cart</small>
                </div>
            </div>
            <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0 d-flex flex-column" style="background-color: #f8fafc;">
            <!-- Cart Items Container -->
            <div id="cartItemsList" class="flex-grow-1 p-3 overflow-y-auto" style="max-height: calc(100vh - 220px);">
                <!-- Dynamic Items will be rendered here -->
            </div>

            <!-- Empty Cart State -->
            <div id="cartEmptyState" class="text-center py-5 px-4 my-auto" style="display: none;">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm p-4 mb-3 border">
                    <i class="fa-solid fa-basket-shopping fs-1 text-primary opacity-50"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Your cart is empty</h5>
                <p class="text-muted small mb-4" style="max-width: 260px; margin: 0 auto; font-size: 0.8rem;">
                    Looks like you haven't added any courses, services, or products to your cart yet.
                </p>
                <div class="d-flex flex-column gap-2" style="max-width: 240px; margin: 0 auto;">
                    <a href="{{ route('courses') }}" class="btn btn-primary btn-sm fw-semibold py-2 rounded-3" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-graduation-cap me-1.5"></i> Browse Courses
                    </a>
                    <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-sm fw-semibold py-2 rounded-3 bg-white" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-briefcase me-1.5"></i> Browse Services
                    </a>
                    <a href="{{ route('products') }}" class="btn btn-outline-secondary btn-sm fw-semibold py-2 rounded-3 bg-white" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-box-open me-1.5"></i> Browse Products
                    </a>
                </div>
            </div>

            <!-- Cart Footer with Totals and Checkout Button -->
            <div id="cartFooterSection" class="p-3 bg-white border-top shadow-sm mt-auto" style="display: none;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Subtotal</span>
                    <strong class="text-dark" id="cartSubtotalAmount">₹0.00</strong>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 pt-2 border-top">
                    <div>
                        <strong class="text-dark d-block">Total Amount</strong>
                        <small class="text-success" style="font-size: 0.7rem;"><i class="fa-solid fa-shield-halved me-1"></i> 100% Secure Checkout</small>
                    </div>
                    <h4 class="fw-bold text-primary mb-0" id="cartTotalAmount">₹0.00</h4>
                </div>
                <button type="button" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" onclick="openCheckoutModal()">
                    <span>Proceed to Checkout</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                <div class="text-center mt-2">
                    <button type="button" class="btn btn-link text-muted p-0 text-decoration-none" style="font-size: 0.725rem;" onclick="clearCart()">
                        <i class="fa-regular fa-trash-can me-1"></i> Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================================
         CHECKOUT MODAL (Complete Order Flow)
         ============================================================================ -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header py-3 px-4 bg-primary text-white border-0">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-check fs-5"></i>
                        <h5 class="modal-title fw-bold mb-0 fs-6" id="checkoutModalLabel">Instant Marketplace Checkout</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Checkout Form Screen -->
                <div id="checkoutFormScreen" class="modal-body p-4">
                    <form id="marketplaceCheckoutForm" onsubmit="handleCheckoutSubmit(event)">
                        <div class="row g-3">
                            <!-- Left: Customer Details -->
                            <div class="col-lg-7 border-end-lg pe-lg-4">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">
                                    <i class="fa-solid fa-user-circle text-primary me-1.5"></i> Customer Information
                                </h6>

                                <div class="mb-2.5">
                                    <label class="form-label small fw-semibold text-muted mb-1">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm rounded-3 py-2" id="checkoutName" required placeholder="e.g. Rahul Sharma" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                </div>

                                <div class="row g-2 mb-2.5">
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-sm rounded-3 py-2" id="checkoutEmail" required placeholder="name@example.com" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control form-control-sm rounded-3 py-2" id="checkoutPhone" required placeholder="9876543210" value="{{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : '' }}">
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">City</label>
                                        <input type="text" class="form-control form-control-sm rounded-3 py-2" id="checkoutCity" placeholder="Ahmedabad" value="Ahmedabad">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">Address / Landmark</label>
                                        <input type="text" class="form-control form-control-sm rounded-3 py-2" id="checkoutAddress" placeholder="Street / Area">
                                    </div>
                                </div>

                                <h6 class="fw-bold text-dark mb-2.5" style="font-size: 0.9rem;">
                                    <i class="fa-solid fa-credit-card text-success me-1.5"></i> Payment Method
                                </h6>
                                <div class="d-flex flex-column gap-2 mb-2">
                                    <label class="form-check border rounded-3 p-2.5 d-flex align-items-center gap-2.5 cursor-pointer bg-light">
                                        <input class="form-check-input mt-0" type="radio" name="paymentMethod" value="Online UPI / Cards" checked>
                                        <div>
                                            <div class="fw-bold text-dark small">UPI / QR Code / Net Banking</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Instant online confirmation & receipt</small>
                                        </div>
                                        <span class="badge bg-success-subtle text-success ms-auto fw-bold" style="font-size: 0.65rem;">Recommended</span>
                                    </label>
                                    <label class="form-check border rounded-3 p-2.5 d-flex align-items-center gap-2.5 cursor-pointer">
                                        <input class="form-check-input mt-0" type="radio" name="paymentMethod" value="Cash / Pay on Delivery">
                                        <div>
                                            <div class="fw-bold text-dark small">Cash / Pay on Delivery</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Pay directly upon confirmation</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Right: Order Summary Preview -->
                            <div class="col-lg-5 ps-lg-3">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">
                                    <i class="fa-solid fa-receipt text-warning me-1.5"></i> Order Review
                                </h6>

                                <div class="bg-light rounded-3 p-3 border mb-3">
                                    <div id="checkoutItemsPreview" class="d-flex flex-column gap-2 mb-3 overflow-y-auto" style="max-height: 180px;">
                                        <!-- Rendered dynamically -->
                                    </div>
                                    <div class="border-top pt-2">
                                        <div class="d-flex justify-content-between text-muted small mb-1">
                                            <span>Subtotal</span>
                                            <span id="checkoutSubtotal">₹0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-muted small mb-2">
                                            <span>Platform Handling</span>
                                            <span class="text-success fw-bold">FREE</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-dark fw-bold border-top pt-2" style="font-size: 1.05rem;">
                                            <span>Total Due</span>
                                            <span class="text-primary" id="checkoutTotal">₹0.00</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="btnPlaceOrder" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Confirm & Place Order</span>
                                </button>
                                <div class="text-center mt-2">
                                    <small class="text-muted" style="font-size: 0.68rem;">By ordering you agree to Digital Class Terms of Service.</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Checkout Success Screen -->
                <div id="checkoutSuccessScreen" class="modal-body p-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white shadow p-3 mb-3" style="width: 68px; height: 68px;">
                        <i class="fa-solid fa-check fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Order Placed Successfully!</h4>
                    <p class="text-muted small mb-3">Your order has been confirmed and registered with the seller.</p>

                    <div class="bg-light border rounded-3 p-3 mb-4 mx-auto text-start" style="max-width: 380px;">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Order Reference:</span>
                            <strong class="text-primary" id="successOrderRef">#DC-00000</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Amount Paid:</span>
                            <strong class="text-dark" id="successAmount">₹0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Customer:</span>
                            <span class="text-dark" id="successCustomer"></span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Status:</span>
                            <span class="badge bg-success-subtle text-success fw-bold">Confirmed & Active</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-primary px-4 fw-semibold rounded-pill" data-bs-dismiss="modal" onclick="window.location.reload()">
                            Continue Browsing
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================================
         CUSTOMER AUTHENTICATION MODAL (Required for Cart & Orders)
         ============================================================================ -->
    <div class="modal fade" id="customerAuthModal" tabindex="-1" aria-labelledby="customerAuthModalLabel" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Modal Top Brand Header -->
                <div class="bg-primary text-white p-3.5 px-4 position-relative" style="background: linear-gradient(135deg, #0066ff 0%, #004ecc 100%) !important;">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                            <i class="fa-solid fa-user fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white fs-6" id="customerAuthModalLabel">Customer Account Required</h5>
                            <small class="text-white-50" style="font-size: 0.725rem;">Login or sign up as a Customer to add items to cart & order</small>
                        </div>
                    </div>

                    <!-- Custom Tab Nav -->
                    <ul class="nav nav-pills nav-fill bg-white bg-opacity-10 p-1 rounded-3 mt-3" id="customerAuthTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-1.5 fw-semibold text-white small" id="tab-cust-login-btn" data-bs-toggle="pill" data-bs-target="#tabCustLogin" type="button" role="tab">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Customer Login
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-1.5 fw-semibold text-white small" id="tab-cust-reg-btn" data-bs-toggle="pill" data-bs-target="#tabCustReg" type="button" role="tab">
                                <i class="fa-solid fa-user-plus me-1"></i> Create Account
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="modal-body p-4 bg-white">
                    @if(Auth::check() && Auth::user()->isSeller())
                        <div class="alert alert-warning border-0 small rounded-3 mb-3 p-2.5">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-warning mt-0.5 flex-shrink-0"></i>
                                <div>
                                    <strong class="d-block text-dark" style="font-size: 0.78rem;">Currently in Seller Mode</strong>
                                    <span style="font-size: 0.72rem; line-height: 1.3;" class="text-muted d-block mb-1.5">
                                        You are logged in as <strong>{{ Auth::user()->name }}</strong> (Seller). To make purchases or add items to cart, please log in with your customer account.
                                    </span>
                                    <form method="POST" action="{{ route('seller.logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-0.5 px-2 fw-semibold" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Logout Seller & Continue
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="tab-content">
                        <!-- TAB 1: LOGIN -->
                        <div class="tab-pane fade show active" id="tabCustLogin" role="tabpanel">
                            <div id="customerLoginAlert" class="alert alert-danger border-0 small rounded-3 mb-3 p-2 text-center" style="display: none; font-size: 0.78rem;"></div>

                            <form id="customerModalLoginForm" onsubmit="handleCustomerLoginSubmit(event)">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark mb-1">Email or Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted" style="font-size: 0.85rem;"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="text" id="custModalLoginEmail" class="form-control form-control-sm bg-light border-start-0" placeholder="name@example.com or phone" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-semibold text-dark mb-0">Password</label>
                                        <a href="{{ route('customer.login') }}" class="small text-primary text-decoration-none" style="font-size: 0.72rem;">Forgot?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted" style="font-size: 0.85rem;"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" id="custModalLoginPassword" class="form-control form-control-sm bg-light border-start-0" placeholder="Enter password" required>
                                    </div>
                                </div>

                                <button type="submit" id="btnCustModalLogin" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm mb-2.5" style="background-color: #0066ff; font-size: 0.85rem;">
                                    <span>Login as Customer</span>
                                </button>
                            </form>

                            <div class="text-center small text-muted">
                                New student or client? 
                                <a href="javascript:void(0)" onclick="switchCustomerAuthTab('register')" class="text-primary fw-bold text-decoration-none">Create an account</a>
                            </div>
                        </div>

                        <!-- TAB 2: REGISTER -->
                        <div class="tab-pane fade" id="tabCustReg" role="tabpanel">
                            <div id="customerRegisterAlert" class="alert alert-danger border-0 small rounded-3 mb-3 p-2 text-center" style="display: none; font-size: 0.78rem;"></div>

                            <form id="customerModalRegisterForm" onsubmit="handleCustomerRegisterSubmit(event)">
                                <div class="mb-2.5">
                                    <label class="form-label small fw-semibold text-dark mb-1">Full Name</label>
                                    <input type="text" id="custModalRegName" class="form-control form-control-sm bg-light" placeholder="e.g. Priya Patel" required>
                                </div>

                                <div class="mb-2.5">
                                    <label class="form-label small fw-semibold text-dark mb-1">Email Address</label>
                                    <input type="email" id="custModalRegEmail" class="form-control form-control-sm bg-light" placeholder="name@example.com" required>
                                </div>

                                <div class="mb-2.5">
                                    <label class="form-label small fw-semibold text-dark mb-1">Mobile Phone (Optional)</label>
                                    <input type="tel" id="custModalRegPhone" class="form-control form-control-sm bg-light" placeholder="9876543210">
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-semibold text-dark mb-1">Password</label>
                                        <input type="password" id="custModalRegPass" class="form-control form-control-sm bg-light" placeholder="Min. 6 chars" required minlength="6">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-semibold text-dark mb-1">Confirm</label>
                                        <input type="password" id="custModalRegPassConf" class="form-control form-control-sm bg-light" placeholder="Repeat pass" required minlength="6">
                                    </div>
                                </div>

                                <button type="submit" id="btnCustModalReg" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm mb-2.5" style="background-color: #0066ff; font-size: 0.85rem;">
                                    <span>Create Customer Account</span>
                                </button>
                            </form>

                            <div class="text-center small text-muted">
                                Already registered? 
                                <a href="javascript:void(0)" onclick="switchCustomerAuthTab('login')" class="text-primary fw-bold text-decoration-none">Login here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Toast Alert -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div id="cartLiveToast" class="toast align-items-center text-white bg-dark border-0 shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2 py-2 px-3 small">
                    <i class="fa-solid fa-circle-check text-success fs-6"></i>
                    <span id="cartToastMsg">Item added to cart!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ============================================================================
         CART, CHECKOUT & CUSTOMER AUTH ENGINE
         ============================================================================ -->
    <script>
        const CART_STORAGE_KEY = 'dc_marketplace_cart_items';

        // Global Customer Auth State
        window.DC_AUTH = {
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            isCustomer: {{ (Auth::check() && Auth::user()->isCustomer()) ? 'true' : 'false' }},
            isSeller: {{ (Auth::check() && Auth::user()->isSeller()) ? 'true' : 'false' }},
            role: '{{ Auth::check() ? Auth::user()->role : 'guest' }}',
            userName: '{{ Auth::check() ? addslashes(Auth::user()->name) : '' }}',
            userEmail: '{{ Auth::check() ? addslashes(Auth::user()->email) : '' }}',
            userPhone: '{{ Auth::check() ? addslashes(Auth::user()->phone ?? '') : '' }}'
        };

        window.pendingCartItem = null;

        // Open Customer Auth Modal
        function openCustomerAuthModal(tab) {
            const modalEl = document.getElementById('customerAuthModal');
            if (!modalEl) {
                window.location.href = "{{ route('customer.login') }}";
                return;
            }

            if (tab === 'register') {
                switchCustomerAuthTab('register');
            } else {
                switchCustomerAuthTab('login');
            }

            const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
            bsModal.show();
        }

        // Switch Tabs in Customer Modal
        function switchCustomerAuthTab(tab) {
            if (tab === 'register') {
                const btn = document.getElementById('tab-cust-reg-btn');
                if (btn) {
                    const trigger = new bootstrap.Tab(btn);
                    trigger.show();
                }
            } else {
                const btn = document.getElementById('tab-cust-login-btn');
                if (btn) {
                    const trigger = new bootstrap.Tab(btn);
                    trigger.show();
                }
            }
        }

        // Handle Customer AJAX Login
        async function handleCustomerLoginSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('btnCustModalLogin');
            const alertBox = document.getElementById('customerLoginAlert');
            alertBox.style.display = 'none';

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Verifying...';

            const payload = {
                email: document.getElementById('custModalLoginEmail').value,
                password: document.getElementById('custModalLoginPassword').value,
                remember: true
            };

            try {
                const res = await fetch('{{ route("customer.login.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (data.success) {
                    window.DC_AUTH = {
                        isLoggedIn: true,
                        isCustomer: true,
                        isSeller: false,
                        role: 'customer',
                        userName: data.user.name,
                        userEmail: data.user.email,
                        userPhone: data.user.phone || ''
                    };

                    const modalEl = document.getElementById('customerAuthModal');
                    if (modalEl) {
                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                        if (bsModal) bsModal.hide();
                    }

                    showCartToast('Logged in as ' + data.user.name + '!');

                    if (window.pendingCartItem) {
                        const pending = window.pendingCartItem;
                        window.pendingCartItem = null;
                        setTimeout(() => {
                            addToCart(pending);
                        }, 300);
                    } else {
                        setTimeout(() => {
                            window.location.reload();
                        }, 600);
                    }
                } else {
                    alertBox.textContent = data.message || 'Invalid credentials.';
                    alertBox.style.display = 'block';
                    btn.disabled = false;
                    btn.innerHTML = '<span>Login as Customer</span>';
                }
            } catch (err) {
                alertBox.textContent = 'Server error during login. Please try again.';
                alertBox.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<span>Login as Customer</span>';
            }
        }

        // Handle Customer AJAX Registration
        async function handleCustomerRegisterSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('btnCustModalReg');
            const alertBox = document.getElementById('customerRegisterAlert');
            alertBox.style.display = 'none';

            const pass = document.getElementById('custModalRegPass').value;
            const passConf = document.getElementById('custModalRegPassConf').value;
            if (pass !== passConf) {
                alertBox.textContent = 'Passwords do not match.';
                alertBox.style.display = 'block';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creating Account...';

            const payload = {
                name: document.getElementById('custModalRegName').value,
                email: document.getElementById('custModalRegEmail').value,
                phone: document.getElementById('custModalRegPhone').value,
                password: pass,
                password_confirmation: passConf
            };

            try {
                const res = await fetch('{{ route("customer.register.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (data.success) {
                    window.DC_AUTH = {
                        isLoggedIn: true,
                        isCustomer: true,
                        isSeller: false,
                        role: 'customer',
                        userName: data.user.name,
                        userEmail: data.user.email,
                        userPhone: data.user.phone || ''
                    };

                    const modalEl = document.getElementById('customerAuthModal');
                    if (modalEl) {
                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                        if (bsModal) bsModal.hide();
                    }

                    showCartToast('Account created! Welcome, ' + data.user.name);

                    if (window.pendingCartItem) {
                        const pending = window.pendingCartItem;
                        window.pendingCartItem = null;
                        setTimeout(() => {
                            addToCart(pending);
                        }, 300);
                    } else {
                        setTimeout(() => {
                            window.location.reload();
                        }, 600);
                    }
                } else {
                    alertBox.textContent = data.message || 'Unable to create account.';
                    alertBox.style.display = 'block';
                    btn.disabled = false;
                    btn.innerHTML = '<span>Create Customer Account</span>';
                }
            } catch (err) {
                alertBox.textContent = 'Server error during registration. Please try again.';
                alertBox.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<span>Create Customer Account</span>';
            }
        }

        // Load cart items from localStorage
        function getCartItems() {
            try {
                const stored = localStorage.getItem(CART_STORAGE_KEY);
                return stored ? JSON.parse(stored) : [];
            } catch (e) {
                return [];
            }
        }

        // Save cart items to localStorage & update UI
        function saveCartItems(items) {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(items));
            renderCartUI();
        }

        // Add item to cart (Customer Login REQUIRED)
        function addToCart(item) {
            if (!item || !item.id) return;

            // Check Customer Authentication Requirement
            if (!window.DC_AUTH || !window.DC_AUTH.isCustomer) {
                window.pendingCartItem = item;
                openCustomerAuthModal(window.DC_AUTH && window.DC_AUTH.isLoggedIn ? 'switch' : 'login');
                return;
            }

            let items = getCartItems();
            const key = (item.type || 'item').toLowerCase() + '_' + item.id;
            const existingIdx = items.findIndex(i => i.key === key);

            if (existingIdx > -1) {
                items[existingIdx].quantity = (items[existingIdx].quantity || 1) + (item.quantity || 1);
            } else {
                items.push({
                    key: key,
                    id: item.id,
                    type: item.type || 'Course',
                    title: item.title || 'Marketplace Item',
                    price: parseFloat(item.price) || 0,
                    thumbnail: item.thumbnail || 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    seller_id: item.seller_id || 1,
                    quantity: item.quantity || 1
                });
            }

            saveCartItems(items);
            showCartToast('Added to Cart: ' + item.title);
            openCartDrawer();

            // Sync with backend session asynchronously
            try {
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(item)
                }).then(r => r.json()).then(data => {
                    if (data && data.auth_required) {
                        openCustomerAuthModal('login');
                    }
                }).catch(() => {});
            } catch (err) {}
        }

        // Update item quantity in cart
        function updateCartQty(key, delta) {
            let items = getCartItems();
            const idx = items.findIndex(i => i.key === key);
            if (idx > -1) {
                const newQty = (items[idx].quantity || 1) + delta;
                if (newQty <= 0) {
                    items.splice(idx, 1);
                } else {
                    items[idx].quantity = newQty;
                }
                saveCartItems(items);
            }
        }

        // Remove item from cart
        function removeFromCart(key) {
            let items = getCartItems();
            items = items.filter(i => i.key !== key);
            saveCartItems(items);
            showCartToast('Item removed from cart');
        }

        // Clear all items in cart
        function clearCart() {
            saveCartItems([]);
            showCartToast('Cart cleared');
            try {
                fetch('{{ route("cart.clear") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                }).catch(() => {});
            } catch (e) {}
        }

        // Open offcanvas drawer
        function openCartDrawer() {
            renderCartUI();
            const el = document.getElementById('cartOffcanvas');
            if (el) {
                const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(el);
                bsOffcanvas.show();
            }
        }

        // Open Checkout Modal (Customer Login REQUIRED)
        function openCheckoutModal() {
            if (!window.DC_AUTH || !window.DC_AUTH.isCustomer) {
                openCustomerAuthModal('login');
                return;
            }

            const items = getCartItems();
            if (!items.length) {
                alert('Your cart is empty! Please add items before checking out.');
                return;
            }

            // Close offcanvas if open
            const offcanvasEl = document.getElementById('cartOffcanvas');
            if (offcanvasEl) {
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (bsOffcanvas) bsOffcanvas.hide();
            }

            // Pre-fill fields from DC_AUTH
            if (window.DC_AUTH) {
                const nameInput = document.getElementById('checkoutName');
                const emailInput = document.getElementById('checkoutEmail');
                const phoneInput = document.getElementById('checkoutPhone');
                if (nameInput && !nameInput.value && window.DC_AUTH.userName) nameInput.value = window.DC_AUTH.userName;
                if (emailInput && !emailInput.value && window.DC_AUTH.userEmail) emailInput.value = window.DC_AUTH.userEmail;
                if (phoneInput && !phoneInput.value && window.DC_AUTH.userPhone) phoneInput.value = window.DC_AUTH.userPhone;
            }

            // Render items preview in checkout modal
            const previewContainer = document.getElementById('checkoutItemsPreview');
            let subtotal = 0;
            let previewHtml = '';

            items.forEach(item => {
                const itemTotal = (item.price || 0) * (item.quantity || 1);
                subtotal += itemTotal;
                previewHtml += `
                    <div class="d-flex align-items-center gap-2 bg-white p-2 rounded-2 border">
                        <img src="${item.thumbnail}" alt="${item.title}" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px;">
                        <div class="flex-grow-1" style="min-width: 0;">
                            <div class="text-dark small fw-bold text-truncate">${item.title}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">${item.type} &bull; Qty: ${item.quantity}</small>
                        </div>
                        <strong class="text-dark small">₹${itemTotal.toLocaleString('en-IN')}</strong>
                    </div>
                `;
            });

            if (previewContainer) previewContainer.innerHTML = previewHtml;
            const subtotalEl = document.getElementById('checkoutSubtotal');
            const totalEl = document.getElementById('checkoutTotal');
            if (subtotalEl) subtotalEl.textContent = '₹' + subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            if (totalEl) totalEl.textContent = '₹' + subtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });

            // Reset screens
            document.getElementById('checkoutFormScreen').style.display = 'block';
            document.getElementById('checkoutSuccessScreen').style.display = 'none';

            // Show checkout modal
            const modalEl = document.getElementById('checkoutModal');
            if (modalEl) {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                bsModal.show();
            }
        }

        // Handle Checkout Form Submission (Customer Login REQUIRED)
        async function handleCheckoutSubmit(e) {
            e.preventDefault();

            if (!window.DC_AUTH || !window.DC_AUTH.isCustomer) {
                openCustomerAuthModal('login');
                return;
            }

            const btn = document.getElementById('btnPlaceOrder');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing Order...';
            }

            const items = getCartItems();
            const payload = {
                name: document.getElementById('checkoutName').value,
                email: document.getElementById('checkoutEmail').value,
                phone: document.getElementById('checkoutPhone').value,
                city: document.getElementById('checkoutCity').value,
                address: document.getElementById('checkoutAddress').value,
                payment_method: document.querySelector('input[name="paymentMethod"]:checked')?.value || 'Online UPI',
                items: items
            };

            try {
                const res = await fetch('{{ route("cart.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (data.success) {
                    // Clear cart
                    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify([]));
                    renderCartUI();

                    // Show success screen
                    document.getElementById('checkoutFormScreen').style.display = 'none';
                    document.getElementById('checkoutSuccessScreen').style.display = 'block';
                    document.getElementById('successOrderRef').textContent = data.order_id || '#DC-10928';
                    document.getElementById('successAmount').textContent = '₹' + (data.total_amount || '0.00');
                    document.getElementById('successCustomer').textContent = data.customer_name || payload.name;
                } else if (data.auth_required) {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Confirm & Place Order</span>';
                    }
                    openCustomerAuthModal('login');
                } else {
                    alert(data.message || 'Error processing order. Please try again.');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Confirm & Place Order</span>';
                    }
                }
            } catch (err) {
                alert('Connection error during checkout. Please try again.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Confirm & Place Order</span>';
                }
            }
        }

        // Render Cart UI inside offcanvas & navbar badge
        function renderCartUI() {
            const items = getCartItems();
            const badge = document.getElementById('cartNavBadge');
            const drawerCount = document.getElementById('cartDrawerCountText');
            const listContainer = document.getElementById('cartItemsList');
            const emptyState = document.getElementById('cartEmptyState');
            const footer = document.getElementById('cartFooterSection');

            // 1. Badge count
            const totalQty = items.reduce((sum, i) => sum + (i.quantity || 1), 0);
            if (badge) {
                if (totalQty > 0) {
                    badge.textContent = totalQty;
                    badge.style.display = 'inline-block';
                } else {
                    badge.textContent = '0';
                    badge.style.display = 'none';
                }
            }

            if (drawerCount) {
                drawerCount.textContent = totalQty + (totalQty === 1 ? ' item in cart' : ' items in cart');
            }

            // 2. Empty vs Filled state
            if (!items.length) {
                if (listContainer) listContainer.style.display = 'none';
                if (emptyState) emptyState.style.display = 'block';
                if (footer) footer.style.display = 'none';
                return;
            }

            if (listContainer) listContainer.style.display = 'block';
            if (emptyState) emptyState.style.display = 'none';
            if (footer) footer.style.display = 'block';

            // 3. Render items
            let total = 0;
            let html = '';

            items.forEach(item => {
                const itemTotal = (item.price || 0) * (item.quantity || 1);
                total += itemTotal;
                const typeClass = item.type === 'Service' ? 'bg-success-subtle text-success' : (item.type === 'Product' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary');

                html += `
                    <div class="card border border-slate-200 rounded-3 p-2.5 mb-2.5 bg-white shadow-xs">
                        <div class="d-flex align-items-center gap-2.5">
                            <img src="${item.thumbnail}" alt="${item.title}" style="width: 58px; height: 58px; object-fit: cover; border-radius: 8px; flex-shrink: 0;" class="border">
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="badge ${typeClass} fw-bold" style="font-size: 0.6rem; padding: 0.15rem 0.45rem;">${item.type}</span>
                                    <button type="button" class="btn btn-sm text-danger p-0 border-0" onclick="removeFromCart('${item.key}')" title="Remove">
                                        <i class="fa-solid fa-trash-can" style="font-size: 0.8rem;"></i>
                                    </button>
                                </div>
                                <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.825rem;" title="${item.title}">${item.title}</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <strong class="text-primary" style="font-size: 0.88rem;">₹${itemTotal.toLocaleString('en-IN')}</strong>
                                    
                                    <!-- Qty Selector -->
                                    <div class="d-flex align-items-center border rounded-2 bg-light px-1">
                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-1 text-decoration-none" style="font-size: 0.75rem;" onclick="updateCartQty('${item.key}', -1)">&minus;</button>
                                        <span class="px-1.5 fw-bold" style="font-size: 0.75rem;">${item.quantity || 1}</span>
                                        <button type="button" class="btn btn-sm btn-link text-dark p-0 px-1 text-decoration-none" style="font-size: 0.75rem;" onclick="updateCartQty('${item.key}', 1)">&plus;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            if (listContainer) listContainer.innerHTML = html;
            const subtotalEl = document.getElementById('cartSubtotalAmount');
            const totalEl = document.getElementById('cartTotalAmount');
            if (subtotalEl) subtotalEl.textContent = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            if (totalEl) totalEl.textContent = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        }

        // Show live toast message
        function showCartToast(msg) {
            const toastEl = document.getElementById('cartLiveToast');
            const toastMsg = document.getElementById('cartToastMsg');
            if (toastEl && toastMsg) {
                toastMsg.textContent = msg;
                const bsToast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3000 });
                bsToast.show();
            }
        }

        // Initialize Cart UI on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function () {
            renderCartUI();
        });
    </script>
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

