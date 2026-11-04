<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Digital Class Marketplace - Learn, Hire, Buy, Discover')</title>

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
            --dc-primary-soft: #eaf2ff;
            --dc-navy: #0e1726;
            --dc-dark: #0f172a;
            --dc-gray-bg: #f8fafc;
            --dc-border: #e2e8f0;
            --dc-text-muted: #64748b;
            --dc-success: #10b981;
            --dc-warning: #f59e0b;
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
            flex-direction: column;
        }

        /* Top Notification Bar */
        .dc-top-alert {
            background-color: #0b1424;
            color: #94a3b8;
            font-size: 0.8125rem;
            padding: 0.45rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dc-top-alert a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
        }

        /* Navigation */
        .dc-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--dc-border);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .dc-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--dc-navy);
            letter-spacing: -0.02em;
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
            font-weight: 500;
            font-size: 0.925rem;
            color: #475569;
            padding: 0.5rem 0.85rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link.dc-nav-link:hover,
        .nav-link.dc-nav-link.active {
            color: var(--dc-primary);
            background-color: var(--dc-primary-soft);
        }

        .nav-link.dc-nav-link.active-marketplace-tab {
            color: #0066ff !important;
            font-weight: 700;
            position: relative;
        }

        .nav-link.dc-nav-link.active-marketplace-tab::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 12px;
            right: 12px;
            height: 3px;
            background: #0066ff;
            border-radius: 999px;
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
            background-color: var(--dc-primary);
            border-color: var(--dc-primary);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.925rem;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 102, 255, 0.2);
        }

        .btn-dc-primary:hover {
            background-color: var(--dc-primary-hover);
            border-color: var(--dc-primary-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.28);
        }

        .btn-dc-outline {
            background-color: transparent;
            border: 1px solid var(--dc-border);
            color: var(--dc-dark);
            font-weight: 600;
            font-size: 0.925rem;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-dc-outline:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--dc-primary);
        }

        /* Footer */
        .dc-footer {
            background-color: #0b1424;
            color: #94a3b8;
            padding: 4rem 0 2rem;
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .dc-footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .dc-footer a:hover {
            color: #38bdf8;
        }

        .dc-footer-title {
            color: #ffffff;
            font-size: 0.975rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            letter-spacing: -0.01em;
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
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-bolt text-warning me-1"></i>
                <span>Phase 1 Development: Seller Onboarding & Dashboard is now live!</span>
            </div>
            <div class="d-none d-md-block">
                <span>Are you an educator, agency, or institute? </span>
                <a href="{{ route('seller.register') }}">Join as a Seller &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar (Matching UI/UX Design) -->
    <nav class="navbar navbar-expand-xl dc-navbar bg-white border-bottom sticky-top py-2">
        <div class="container-fluid px-lg-4">
            <!-- Brand Logo -->
            <a class="dc-brand me-3" href="{{ route('home') }}">
                <div class="dc-brand-icon" style="background: linear-gradient(135deg, #0066ff 0%, #00d2ff 100%);">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 800; line-height: 1;">Digital<span class="dc-highlight" style="color: #0066ff;">Class</span></div>
                    <span class="dc-brand-subtitle" style="font-size: 0.65rem; color: #64748b; letter-spacing: 0.05em; font-weight: 600;">Educational World</span>
                </div>
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
                        <a class="nav-link dc-nav-link" href="#" data-bs-toggle="modal" data-bs-target="#comingSoonModal" data-module="Professional Services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dc-nav-link" href="#" data-bs-toggle="modal" data-bs-target="#comingSoonModal" data-module="Digital & Physical Products">Products</a>
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

                <!-- Center Search Input with Blue Button -->
                <form action="{{ route('home') }}" method="GET" class="flex-grow-1 mx-xl-3 my-2 my-xl-0" style="max-width: 480px;">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-end-0 bg-light" placeholder="Search businesses, shops, institutes, service centers..." style="font-size: 0.85rem; border-color: #e2e8f0;">
                        <button class="btn btn-primary px-3" type="submit" style="background-color: #0066ff;">
                            <i class="fa-solid fa-magnifying-glass"></i>
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
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="dc-brand-icon">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <h4 class="text-white fw-bold mb-0">Digital Class</h4>
                    </div>
                    <p class="small text-secondary mb-3">
                        Digital Class Marketplace &mdash; <strong>Learn. Hire. Buy. Discover.</strong> India's multi-vendor educational and business platform connecting learners, professionals, businesses, and customers in one unified ecosystem.
                    </p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Phase 1: Seller Onboarding</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Laravel 12 + MySQL</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="dc-footer-title">Navigation</div>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#comingSoonModal" data-module="Explore">Explore</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#comingSoonModal" data-module="Courses">Courses</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#comingSoonModal" data-module="Services">Services</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="dc-footer-title">Seller Portal</div>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                        <li><a href="{{ route('seller.register') }}">Become a Seller</a></li>
                        <li><a href="{{ route('seller.login') }}">Seller Login</a></li>
                        @auth
                            @if(Auth::user()->isSeller())
                                <li><a href="{{ route('seller.dashboard') }}">Seller Dashboard</a></li>
                                <li><a href="{{ route('seller.profile') }}">Seller Profile</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="dc-footer-title">Seller Support</div>
                    <p class="small text-secondary mb-3">
                        Have questions about opening your store or listing courses, services, and products? Contact our onboarding team.
                    </p>
                    <div class="d-flex align-items-center gap-2 text-secondary small">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <span>support@digitalclassworld.com</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-secondary small mt-2">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <span>+91 98765 43210</span>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.08);">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary pt-2">
                <div>
                    &copy; {{ date('Y') }} Digital Class Marketplace. All rights reserved.
                </div>
                <div class="d-flex gap-3 mt-2 mt-md-0">
                    <span>Designed based on Digital Class UI/UX Specifications</span>
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

