<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin Dashboard - Digital Class Educational World')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Chart.js (Local first, CDN fallbacks) -->
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>
    <script>
        if (typeof Chart === 'undefined') {
            document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"><\/script>');
        }
    </script>
    <script>
        if (typeof Chart === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"><\/script>');
        }
    </script>

    <style>
        :root {
            --admin-sidebar-bg: #0b1329;
            --admin-sidebar-hover: #162444;
            --admin-sidebar-text: #94a3b8;
            --admin-sidebar-active: #0066ff;
            --admin-primary: #0066ff;
            --admin-bg: #f8fafc;
            --admin-border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--admin-bg);
            color: #1e293b;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .admin-layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Structure */
        .admin-sidebar {
            width: 255px;
            background-color: var(--admin-sidebar-bg);
            color: var(--admin-sidebar-text);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        /* Sidebar Brand */
        .admin-sidebar-brand {
            padding: 1.15rem 1.25rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .admin-brand-main {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .admin-brand-sub {
            font-size: 0.625rem;
            color: #94a3b8;
            text-transform: capitalize;
            letter-spacing: 0.02em;
            display: block;
            margin-top: 1px;
        }

        /* Sidebar Section Header */
        .admin-menu-section {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            padding: 0.85rem 1.15rem 0.25rem;
        }

        .admin-nav-list {
            list-style: none;
            padding: 0 0.65rem;
            margin: 0;
        }

        .admin-nav-item {
            margin-bottom: 2px;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 0.85rem;
            color: var(--admin-sidebar-text);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.825rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .admin-nav-link .nav-left {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .admin-nav-link i.menu-icon {
            width: 18px;
            font-size: 0.875rem;
            color: #64748b;
            text-align: center;
        }

        .admin-nav-link i.chevron-icon {
            font-size: 0.65rem;
            color: #475569;
        }

        .admin-nav-link:hover {
            color: #ffffff;
            background-color: var(--admin-sidebar-hover);
        }
        .admin-nav-link:hover i.menu-icon {
            color: #38bdf8;
        }

        .admin-nav-link.active {
            color: #ffffff;
            background-color: var(--admin-primary);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.35);
        }
        .admin-nav-link.active i.menu-icon {
            color: #ffffff;
        }

        /* Top Bar */
        .admin-main-wrapper {
            margin-left: 255px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left 0.3s ease;
        }

        .admin-top-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--admin-border);
            padding: 0.65rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .admin-search-input {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.45rem 1rem 0.45rem 2.25rem;
            font-size: 0.85rem;
            width: 380px;
            outline: none;
            transition: all 0.2s;
        }
        .admin-search-input:focus {
            background-color: #ffffff;
            border-color: #0066ff;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .admin-top-filter-btn {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.45rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
            cursor: pointer;
        }

        .admin-user-pill {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            cursor: pointer;
        }

        .admin-user-photo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        .admin-page-content {
            padding: 1.5rem 1.5rem 3rem;
            flex-grow: 1;
        }

        .admin-sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(2px);
            z-index: 1035;
        }
        .admin-sidebar-backdrop.show {
            display: block;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main-wrapper {
                margin-left: 0;
            }
            .admin-search-input {
                width: 180px;
            }
            .admin-top-header {
                padding: 0.65rem 0.85rem;
            }
            .admin-page-content {
                padding: 1rem 0.75rem 2.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .admin-search-input {
                width: 130px;
                font-size: 0.78rem;
                padding-left: 1.8rem;
            }
            .admin-top-header {
                padding: 0.5rem 0.65rem;
                gap: 0.5rem;
            }
            .admin-user-photo {
                width: 32px;
                height: 32px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="admin-layout-wrapper">
    <!-- ================= SUPER ADMIN SIDEBAR ================= -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand (Matching Screenshot) -->
        <div class="d-flex align-items-center justify-content-between border-bottom border-secondary border-opacity-25 pe-2">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand d-flex align-items-center gap-2 border-0 flex-grow-1">
                <img src="{{ asset('images/logo.png') }}" alt="Digital Class" style="height: 36px; width: auto; background: white; padding: 4px 8px; border-radius: 8px;">
                <span class="badge bg-danger text-uppercase" style="font-size: 0.65rem;">Super Admin</span>
            </a>
            <button type="button" class="btn btn-sm text-secondary border-0 d-lg-none p-2" onclick="toggleAdminSidebar()" title="Close Sidebar">
                <i class="fa-solid fa-xmark fs-5"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-grow-1 pb-4 pt-2">
            <!-- 1. Main Dashboard -->
            <ul class="admin-nav-list mb-2">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-house menu-icon"></i>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- 2. USER MANAGEMENT -->
            <div class="admin-menu-section">USER MANAGEMENT</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-regular fa-user menu-icon"></i>
                            <span>Users & Members</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.sellers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-store menu-icon"></i>
                            <span>Sellers Management</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
            </ul>

            <!-- 3. MARKETPLACE MANAGEMENT -->
            <div class="admin-menu-section">MARKETPLACE MANAGEMENT</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.courses') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.courses*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-graduation-cap menu-icon"></i>
                            <span>Courses Management</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.services') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.services*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-briefcase menu-icon"></i>
                            <span>Services Management</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.products') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.products*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-box-open menu-icon"></i>
                            <span>Products Management</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.listings') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.listings*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-building menu-icon"></i>
                            <span>Business Listings</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-cart-shopping menu-icon"></i>
                            <span>Orders & Bookings</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- 4. FINANCIAL MANAGEMENT -->
            <div class="admin-menu-section">FINANCIAL MANAGEMENT</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.financial.payments') }}" class="admin-nav-link {{ request()->routeIs('admin.financial.payments*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-credit-card menu-icon"></i>
                            <span>Payments & Wallet</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.financial.payouts') }}" class="admin-nav-link {{ request()->routeIs('admin.financial.payouts*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-hand-holding-dollar menu-icon"></i>
                            <span>Payouts & Commission</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'refunds') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-arrow-rotate-left menu-icon"></i>
                            <span>Refunds & Disputes</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
            </ul>

            <!-- 5. GROWTH & MARKETING -->
            <div class="admin-menu-section">GROWTH & MARKETING</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.promotions.index') }}" class="admin-nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-bullhorn menu-icon"></i>
                            <span>Banners & Promotions</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coupons.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-ticket menu-icon"></i>
                            <span>Coupons & Offers</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.reviews.index') }}" class="admin-nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-star menu-icon"></i>
                            <span>Reviews & Ratings</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-comments menu-icon"></i>
                            <span>Messages & Support</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.leads.index') }}" class="admin-nav-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-bullseye menu-icon"></i>
                            <span>Marketing & Leads</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
            </ul>

            <!-- 6. CONTENT MANAGEMENT -->
            <div class="admin-menu-section">CONTENT MANAGEMENT</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.cms.index') }}" class="admin-nav-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-newspaper menu-icon"></i>
                            <span>Blog & CMS</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.notifications.index') }}" class="admin-nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-bell menu-icon"></i>
                            <span>Notifications</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- 6.5. SEO & TRAFFIC -->
            <div class="admin-menu-section">SEO & TRAFFIC</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.seo.index') }}" class="admin-nav-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-magnifying-glass-chart menu-icon"></i>
                            <span>SEO Management</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
            </ul>

            <!-- 7. APP & PLATFORM MANAGEMENT -->
            <div class="admin-menu-section">APP & PLATFORM MANAGEMENT</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.app.index') }}" class="admin-nav-link {{ request()->routeIs('admin.app.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-mobile-screen menu-icon"></i>
                            <span>App Management</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.website.index') }}" class="admin-nav-link {{ request()->routeIs('admin.website.*') ? 'active' : '' }}">
                        <div class="nav-left">
                            <i class="fa-solid fa-globe menu-icon"></i>
                            <span>Website Management</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'modules') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-sliders menu-icon"></i>
                            <span>Modules & Features</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'api') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-plug menu-icon"></i>
                            <span>API & Integrations</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- 8. REPORTS & SYSTEM -->
            <div class="admin-menu-section">REPORTS & SYSTEM</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'reports') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-chart-line menu-icon"></i>
                            <span>Reports & Analytics</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron-icon"></i>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'settings') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-gear menu-icon"></i>
                            <span>General Settings</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'roles') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-shield-halved menu-icon"></i>
                            <span>Roles & Permissions</span>
                        </div>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'activity') }}" class="admin-nav-link">
                        <div class="nav-left">
                            <i class="fa-solid fa-list-check menu-icon"></i>
                            <span>Activity Logs</span>
                        </div>
                    </a>
                </li>

                <!-- Logout -->
                <li class="admin-nav-item mt-3 pt-2 border-top border-secondary-subtle">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="admin-nav-link text-danger bg-transparent border-0 w-100 text-start">
                            <div class="nav-left">
                                <i class="fa-solid fa-right-from-bracket menu-icon text-danger"></i>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT WRAPPER ================= -->
    <div class="admin-main-wrapper">
        <!-- Top Header (Matching Screenshot) -->
        <header class="admin-top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light border-0 p-2" type="button" onclick="toggleAdminSidebar()" title="Toggle Sidebar">
                    <i class="fa-solid fa-bars fs-5 text-secondary"></i>
                </button>

                <!-- Global Search Form -->
                <form method="GET" action="{{ request()->routeIs('admin.users.*') ? route('admin.users.index') : (request()->routeIs('admin.sellers.*') ? route('admin.sellers.index') : (request()->routeIs('admin.catalog.courses*') ? route('admin.catalog.courses') : (request()->routeIs('admin.catalog.products*') ? route('admin.catalog.products') : (request()->routeIs('admin.catalog.services*') ? route('admin.catalog.services') : route('admin.catalog.listings'))))) }}" class="m-0">
                    <div class="position-relative">
                        <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                        <input type="text" name="q" value="{{ request('q') ?: request('search') }}" class="admin-search-input" placeholder="Search users, sellers, courses, services, products, orders...">
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- All Users Filter -->
                <div class="dropdown d-none d-md-block">
                    <button class="admin-top-filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <span>{{ request('tab') ? ucfirst(request('tab')) : 'All Users' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                        <li><a class="dropdown-item {{ !request('tab') || request('tab') === 'all' ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users me-2 text-primary"></i> All Users</a></li>
                        <li><a class="dropdown-item {{ request('tab') === 'students' ? 'active' : '' }}" href="{{ route('admin.users.index', ['tab' => 'students']) }}"><i class="fa-solid fa-graduation-cap me-2 text-info"></i> Students</a></li>
                        <li><a class="dropdown-item {{ request('tab') === 'professionals' ? 'active' : '' }}" href="{{ route('admin.users.index', ['tab' => 'professionals']) }}"><i class="fa-solid fa-briefcase me-2 text-warning"></i> Professionals</a></li>
                        <li><a class="dropdown-item {{ request('tab') === 'institutes' ? 'active' : '' }}" href="{{ route('admin.users.index', ['tab' => 'institutes']) }}"><i class="fa-solid fa-school me-2 text-primary"></i> Institutes</a></li>
                        <li><a class="dropdown-item {{ request('tab') === 'sellers' ? 'active' : '' }}" href="{{ route('admin.users.index', ['tab' => 'sellers']) }}"><i class="fa-solid fa-store me-2 text-success"></i> Sellers</a></li>
                    </ul>
                </div>

                <!-- All Locations Filter -->
                <div class="dropdown d-none d-md-block">
                    <button class="admin-top-filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        <span>{{ request('city') && request('city') !== 'all' ? request('city') : 'All Locations' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                        <li><a class="dropdown-item {{ !request('city') || request('city') === 'all' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['city' => null]) }}"><i class="fa-solid fa-globe me-2 text-muted"></i> All Locations</a></li>
                        <li><a class="dropdown-item {{ request('city') === 'Ahmedabad' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['city' => 'Ahmedabad']) }}"><i class="fa-solid fa-city me-2 text-primary"></i> Ahmedabad, Gujarat</a></li>
                        <li><a class="dropdown-item {{ request('city') === 'Surat' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['city' => 'Surat']) }}"><i class="fa-solid fa-city me-2 text-primary"></i> Surat, Gujarat</a></li>
                        <li><a class="dropdown-item {{ request('city') === 'Vadodara' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['city' => 'Vadodara']) }}"><i class="fa-solid fa-city me-2 text-primary"></i> Vadodara, Gujarat</a></li>
                        <li><a class="dropdown-item {{ request('city') === 'Rajkot' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['city' => 'Rajkot']) }}"><i class="fa-solid fa-city me-2 text-primary"></i> Rajkot, Gujarat</a></li>
                        <li><a class="dropdown-item {{ request('city') === 'Mumbai' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['city' => 'Mumbai']) }}"><i class="fa-solid fa-city me-2 text-primary"></i> Mumbai, Maharashtra</a></li>
                    </ul>
                </div>

                <!-- Quick Pending Requests Shortcut Link -->
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning text-dark fw-bold d-flex align-items-center gap-1.5 px-2.5 py-1.5 rounded-pill shadow-xs" title="View Pending Approvals on Dashboard" style="font-size: 0.76rem; border-color: #f59e0b; background: #fffbeb;">
                    <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                    <span class="d-none d-lg-inline">Pending Requests</span>
                </a>

                <!-- Notification Bell with Red Badge 3 -->
                <div class="position-relative">
                    <button class="btn btn-light border-0 rounded-circle p-2" type="button" title="Notifications">
                        <i class="fa-regular fa-bell fs-5 text-secondary"></i>
                        <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.45em;">
                            3
                        </span>
                    </button>
                </div>

                <!-- Super Admin Profile Dropdown -->
                <div class="dropdown">
                    <div class="admin-user-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <img src="{{ Auth::user()->avatar_url }}" 
                             alt="{{ Auth::user()->name }}" class="admin-user-photo" 
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0066ff&color=fff';">
                        <div class="text-start d-none d-sm-block">
                            <div class="fw-bold text-dark" style="font-size: 0.85rem; line-height: 1.1;">
                                {{ Auth::user()->name ?? 'Super Admin' }}
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                Super Admin
                            </small>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small" style="min-width: 220px;">
                        <li class="p-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ Auth::user()->avatar_url }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-muted text-truncate" style="font-size: 0.725rem;">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#adminPhotoModal">
                                <i class="fa-solid fa-camera me-2 text-primary"></i> Change Profile Picture
                            </button>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.sellers.index') }}"><i class="fa-solid fa-users-gear me-2 text-primary"></i> Manage Sellers</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square me-2 text-success"></i> Visit Marketplace</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="admin-page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 py-2 px-3 small mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Admin Profile Photo Modal -->
<div class="modal fade" id="adminPhotoModal" tabindex="-1" aria-labelledby="adminPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="adminPhotoModalLabel">Update Super Admin Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-center py-4">
                    <div class="position-relative d-inline-block mb-3">
                        <img id="adminAvatarPreview" src="{{ Auth::user()->avatar_url }}" alt="Preview" 
                             class="rounded-circle shadow" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #0066ff;">
                    </div>
                    <p class="text-muted small mb-3">Choose a round profile photo or paste an image URL.</p>

                    <div class="text-start mb-3">
                        <label class="form-label small fw-bold text-dark">Upload Image File (JPG, PNG, WebP)</label>
                        <input type="file" name="avatar" id="adminAvatarInput" class="form-control" accept="image/*" onchange="previewAdminAvatar(this)">
                    </div>

                    <div class="text-start">
                        <label class="form-label small fw-bold text-dark">Or Image URL</label>
                        <input type="url" name="avatar_url" class="form-control" placeholder="https://example.com/avatar.jpg" value="{{ str_starts_with(Auth::user()->avatar ?? '', 'http') ? Auth::user()->avatar : '' }}">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="fa-solid fa-cloud-arrow-up me-1"></i> Save Picture
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Backdrop Overlay -->
<div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" onclick="toggleAdminSidebar()"></div>

<script>
function previewAdminAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('adminAvatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('adminSidebarBackdrop');
        if (sidebar) sidebar.classList.toggle('show');
        if (backdrop) backdrop.classList.toggle('show');
    }
</script>

@yield('scripts')
</body>
</html>
