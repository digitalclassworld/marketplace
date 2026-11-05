<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seller Dashboard - Digital Class Marketplace')</title>

    <!-- Google Fonts: Plus Jakarta Sans, Outfit & JetBrains Mono (Super Premium Typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Chart.js for future analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --dc-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --dc-font-heading: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            --dc-font-mono: 'JetBrains Mono', monospace;
            --dc-primary: #0066ff;
            --dc-primary-hover: #0052cc;
            --dc-primary-soft: #eff6ff;
            --dc-navy: #0e1726;
            --dc-sidebar-bg: #0b1424;
            --dc-sidebar-hover: #162238;
            --dc-sidebar-active: #1e2e4a;
            --dc-sidebar-text: #94a3b8;
            --dc-sidebar-text-active: #ffffff;
            --dc-content-bg: #f8fafc;
            --dc-card-bg: #ffffff;
            --dc-border: #e2e8f0;
            --dc-text: #0f172a;
            --dc-text-muted: #64748b;
        }

        body {
            font-family: var(--dc-font-sans);
            background-color: var(--dc-content-bg);
            color: var(--dc-text);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6, .display-font, .dc-sidebar-brand {
            font-family: var(--dc-font-heading);
            letter-spacing: -0.025em;
        }

        .font-monospace, code {
            font-family: var(--dc-font-mono) !important;
            letter-spacing: 0.02em;
        }

        /* Layout Structure */
        .dc-layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling (Page 4 Reference) */
        .dc-sidebar {
            width: 260px;
            background-color: var(--dc-sidebar-bg);
            color: var(--dc-sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: transform 0.3s ease;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dc-sidebar-brand {
            padding: 1.25rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-decoration: none;
        }

        .dc-sidebar-brand .dc-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0066ff 0%, #00d2ff 100%);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .dc-sidebar-brand .dc-brand-text {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.15rem;
            line-height: 1.2;
        }
        .dc-sidebar-brand .dc-brand-text span {
            color: #38bdf8;
        }
        .dc-sidebar-brand .dc-brand-sub {
            font-size: 0.65rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: block;
        }

        /* Sidebar User Mini-Card */
        .dc-sidebar-user {
            padding: 1rem 1.25rem;
            margin: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dc-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
            position: relative;
        }

        .dc-user-avatar::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background-color: #10b981;
            border: 2px solid var(--dc-sidebar-bg);
            border-radius: 50%;
        }

        .dc-sidebar-menu {
            list-style: none;
            padding: 0.5rem 0.75rem;
            margin: 0;
            flex-grow: 1;
        }

        .dc-menu-section-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            font-weight: 700;
            padding: 0.75rem 0.75rem 0.25rem;
        }

        .dc-menu-item {
            margin-bottom: 2px;
        }

        .dc-menu-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.85rem;
            color: var(--dc-sidebar-text);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dc-menu-link i.menu-icon {
            width: 22px;
            font-size: 1rem;
            margin-right: 0.75rem;
            color: #64748b;
            transition: color 0.2s;
        }

        .dc-menu-link:hover {
            color: var(--dc-sidebar-text-active);
            background-color: var(--dc-sidebar-hover);
        }
        .dc-menu-link:hover i.menu-icon {
            color: #38bdf8;
        }

        .dc-menu-link.active {
            color: #ffffff;
            background-color: #0066ff;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0, 102, 255, 0.35);
        }
        .dc-menu-link.active i.menu-icon {
            color: #ffffff;
        }

        .dc-menu-badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.45rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #94a3b8;
        }

        /* Main Content Container */
        .dc-main-content {
            margin-left: 260px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left 0.3s ease;
        }

        /* Top Header (Page 4 Reference) */
        .dc-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--dc-border);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .dc-header-search {
            position: relative;
            max-width: 420px;
            width: 100%;
        }

        .dc-header-search input {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.55rem 1rem 0.55rem 2.4rem;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.2s ease;
        }
        .dc-header-search input:focus {
            background-color: #ffffff;
            border-color: var(--dc-primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
            outline: none;
        }
        .dc-header-search i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .btn-visit-store {
            background-color: #ffffff;
            border: 1px solid var(--dc-border);
            color: #334155;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.45rem 0.95rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }
        .btn-visit-store:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: var(--dc-primary);
        }

        /* Prominent Account Status Banner */
        .dc-status-bar {
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid var(--dc-border);
            font-size: 0.875rem;
        }

        .dc-status-bar.pending {
            background-color: #fffbeb;
            border-color: #fef3c7;
            color: #92400e;
        }
        .dc-status-bar.active {
            background-color: #ecfdf5;
            border-color: #d1fae5;
            color: #065f46;
        }
        .dc-status-bar.suspended {
            background-color: #fef2f2;
            border-color: #fee2e2;
            color: #991b1b;
        }

        /* Page Content Padding */
        .dc-page-body {
            padding: 1.75rem 1.5rem;
            flex-grow: 1;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .dc-sidebar {
                transform: translateX(-100%);
            }
            .dc-sidebar.show {
                transform: translateX(0);
            }
            .dc-main-content {
                margin-left: 0;
            }
            .dc-header-search {
                max-width: 250px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="dc-layout-wrapper">
    <!-- ================= SELLER SIDEBAR (Page 4 Reference) ================= -->
    <aside class="dc-sidebar" id="sellerSidebar">
        <!-- Brand -->
        <a href="{{ route('seller.dashboard') }}" class="dc-sidebar-brand d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Digital Class" style="height: 34px; width: auto; background: white; padding: 4px 8px; border-radius: 8px;">
            <span class="badge bg-primary text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">Seller</span>
            <span class="visually-hidden">Digital Class</span>
        </a>

        <!-- Logged-in Seller Mini Profile -->
        <div class="dc-sidebar-user">
            <div class="position-relative" style="width: 38px; height: 38px; flex-shrink: 0;">
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid rgba(255,255,255,0.15);" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0066ff&color=fff';">
                <span class="position-absolute bottom-0 end-0 rounded-circle bg-success" style="width: 10px; height: 10px; border: 2px solid var(--dc-sidebar-bg);"></span>
            </div>
            <div class="overflow-hidden">
                <div class="text-white fw-bold text-truncate" style="font-size: 0.875rem;">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-primary fw-semibold font-monospace text-truncate" style="font-size: 0.725rem;">
                    {{ Auth::user()->seller?->seller_code ?? 'SELLER' }}
                </div>
            </div>
        </div>

        <!-- Menu Navigation (Page 4 Design Match) -->
        <ul class="dc-sidebar-menu">
            <!-- 1. Dashboard (Active Blue Pill) -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.dashboard') }}" class="dc-menu-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high menu-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- 2. My Store -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.profile') }}" class="dc-menu-link {{ request()->routeIs('seller.profile') ? 'active' : '' }}">
                    <i class="fa-solid fa-store menu-icon"></i>
                    <span>My Store</span>
                </a>
            </li>

            <!-- 3. Courses ▾ -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.courses.index') }}" class="dc-menu-link {{ request()->routeIs('seller.courses.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-video menu-icon"></i>
                        <span>Courses</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-secondary" style="font-size: 0.65rem;"></i>
                </a>
            </li>

            <!-- 4. Services ▾ -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.services.index') }}" class="dc-menu-link {{ request()->routeIs('seller.services.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-handshake-angle menu-icon"></i>
                        <span>Services</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-secondary" style="font-size: 0.65rem;"></i>
                </a>
            </li>

            <!-- 5. Products ▾ -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.products.index') }}" class="dc-menu-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-box-open menu-icon"></i>
                        <span>Products</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-secondary" style="font-size: 0.65rem;"></i>
                </a>
            </li>

            <!-- 6. Business Listing ▾ (Expandable matching screenshot) -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.listings.index') }}" class="dc-menu-link {{ request()->routeIs('seller.listings.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-building menu-icon"></i>
                        <span>Business Listing</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-secondary" style="font-size: 0.65rem;"></i>
                </a>
                @if(request()->routeIs('seller.listings.*'))
                    <ul class="list-unstyled ps-4 pe-2 pt-1 pb-1 mb-1" style="background: rgba(0, 0, 0, 0.2); border-radius: 8px;">
                        <li class="py-1">
                            <a href="{{ route('seller.listings.index') }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ request()->routeIs('seller.listings.index') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> All Listings
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.listings.create') }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ request()->routeIs('seller.listings.create') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Add New Listing
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="#" class="text-decoration-none d-flex align-items-center gap-2 small text-secondary" style="font-size: 0.775rem;" onclick="notifyComingSoon('My Inquiries'); return false;">
                                <span style="font-size: 0.7rem;">•</span> My Inquiries
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="#" class="text-decoration-none d-flex align-items-center gap-2 small text-secondary" style="font-size: 0.775rem;" onclick="notifyComingSoon('Listing Reviews'); return false;">
                                <span style="font-size: 0.7rem;">•</span> Reviews
                            </a>
                        </li>
                    </ul>
                @endif
            </li>

            <!-- 7. Orders (Active & Expandable matching screenshot) -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.orders.index') }}" class="dc-menu-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-cart-shopping menu-icon"></i>
                        <span>Orders</span>
                    </div>
                    <span class="badge rounded-pill fw-bold" style="background: {{ request()->routeIs('seller.orders.*') ? 'rgba(255,255,255,0.25)' : '#0066ff' }}; color: #ffffff; font-size: 0.65rem; padding: 0.2rem 0.5rem;">24</span>
                </a>
                @if(request()->routeIs('seller.orders.*'))
                    <ul class="list-unstyled ps-4 pe-2 pt-1 pb-1 mb-1" style="background: rgba(0, 0, 0, 0.2); border-radius: 8px;">
                        <li class="py-1">
                            <a href="{{ route('seller.orders.index', ['tab' => 'all']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab', 'all') === 'all') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> All Orders
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.orders.index', ['tab' => 'courses']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'courses') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Course Orders
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.orders.index', ['tab' => 'services']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'services') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Service Orders
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.orders.index', ['tab' => 'products']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'products') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Product Orders
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.orders.index', ['tab' => 'business']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'business') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Business Inquiries
                            </a>
                        </li>
                    </ul>
                @endif
            </li>

            <!-- 8. Earnings & Payouts -->
            <li class="dc-menu-item">
                <a href="#" class="dc-menu-link" onclick="notifyComingSoon('Earnings & Payouts'); return false;">
                    <i class="fa-solid fa-wallet menu-icon"></i>
                    <span>Earnings & Payouts</span>
                </a>
            </li>

            <!-- 9. Messages (Page 41 Chat & Communications) -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.messages.index') }}" class="dc-menu-link {{ request()->routeIs('seller.messages.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-comments menu-icon"></i>
                        <span>Messages</span>
                    </div>
                    @php
                        $unreadMsgCount = 3;
                        if (Auth::check() && Auth::user()->seller) {
                            $actualUnread = \App\Models\Conversation::where('seller_id', Auth::user()->seller->id)->sum('unread_count');
                            if ($actualUnread > 0) {
                                $unreadMsgCount = $actualUnread;
                            }
                        }
                    @endphp
                    <span class="badge rounded-pill fw-bold" style="background: {{ request()->routeIs('seller.messages.*') ? 'rgba(255,255,255,0.25)' : '#0066ff' }}; color: #ffffff; font-size: 0.65rem; padding: 0.2rem 0.5rem;">{{ $unreadMsgCount }}</span>
                </a>
            </li>

            <!-- 10. Customers -->
            <li class="dc-menu-item">
                <a href="#" class="dc-menu-link" onclick="notifyComingSoon('Customer Management'); return false;">
                    <i class="fa-solid fa-users menu-icon"></i>
                    <span>Customers</span>
                </a>
            </li>

            <!-- 10. Reviews & Ratings -->
            <li class="dc-menu-item">
                <a href="#" class="dc-menu-link" onclick="notifyComingSoon('Customer Reviews'); return false;">
                    <i class="fa-solid fa-star menu-icon"></i>
                    <span>Reviews & Ratings</span>
                </a>
            </li>

            <!-- 11. Promotions (Expandable matching screenshot) -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.promotions.index') }}" class="dc-menu-link {{ request()->routeIs('seller.promotions.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-bullhorn menu-icon"></i>
                        <span>Promotions</span>
                    </div>
                    <i class="fa-solid {{ request()->routeIs('seller.promotions.*') ? 'fa-chevron-up' : 'fa-chevron-down' }} text-secondary" style="font-size: 0.65rem;"></i>
                </a>
                @if(request()->routeIs('seller.promotions.*'))
                    <ul class="list-unstyled ps-4 pe-2 pt-1 pb-1 mb-1" style="background: rgba(0, 0, 0, 0.2); border-radius: 8px;">
                        <li class="py-1">
                            <a href="{{ route('seller.promotions.index', ['tab' => 'create']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab', 'create') === 'create') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Create Promotion
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.promotions.index', ['tab' => 'my-promotions']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'my-promotions') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> My Promotions
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.promotions.index', ['tab' => 'coupons']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'coupons') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Discount Coupons
                            </a>
                        </li>
                        <li class="py-1">
                            <a href="{{ route('seller.promotions.index', ['tab' => 'banners']) }}" class="text-decoration-none d-flex align-items-center gap-2 small {{ (request('tab') === 'banners') ? 'text-white fw-bold' : 'text-secondary' }}" style="font-size: 0.775rem;">
                                <span style="font-size: 0.7rem;">•</span> Banners & Creatives
                            </a>
                        </li>
                    </ul>
                @endif
            </li>

            <!-- 12. Analytics -->
            <li class="dc-menu-item">
                <a href="#" class="dc-menu-link" onclick="notifyComingSoon('Store Analytics'); return false;">
                    <i class="fa-solid fa-chart-line menu-icon"></i>
                    <span>Analytics</span>
                </a>
            </li>

            <!-- 13. Store Settings -->
            <li class="dc-menu-item">
                <a href="{{ route('seller.profile') }}" class="dc-menu-link">
                    <i class="fa-solid fa-gear menu-icon"></i>
                    <span>Store Settings</span>
                </a>
            </li>

            <!-- 14. Logout -->
            <li class="dc-menu-item mt-2 pt-2 border-top border-secondary-subtle">
                <form action="{{ route('seller.logout') }}" method="POST" id="sidebarLogoutForm">
                    @csrf
                    <button type="submit" class="dc-menu-link bg-transparent border-0 w-100 text-start text-danger">
                        <i class="fa-solid fa-arrow-right-from-bracket menu-icon text-danger"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>

        <!-- Upgrade to Pro Widget (Page 4 Gold Crown) -->
        <div class="p-3 mt-auto">
            <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width: 30px; height: 30px; background: rgba(245, 158, 11, 0.2); color: #f59e0b; border-radius: 8px;" class="d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-crown text-warning"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold" style="font-size: 0.85rem;">Upgrade to Pro</div>
                    </div>
                </div>
                <p class="mb-3 text-secondary" style="font-size: 0.72rem; line-height: 1.35; color: #94a3b8 !important;">Get more visibility and higher sales</p>
                <button type="button" class="btn btn-light btn-sm w-100 fw-bold py-1 text-dark" style="font-size: 0.775rem; border-radius: 20px;" onclick="notifyComingSoon('Pro Subscription Plans')">View Plans</button>
            </div>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT AREA ================= -->
    <div class="dc-main-content">
        <!-- Top Header -->
        <header class="dc-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none p-2 border" type="button" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="dc-header-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search orders, courses, services, products...">
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 gap-md-3">
                <!-- Visit Store Button -->
                <a href="{{ route('home') }}" class="btn-visit-store" target="_blank" title="Preview Marketplace">
                    <span>Visit Marketplace</span>
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>

                <!-- Notification Bell -->
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-2 border position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-bell text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2" style="width: 280px;">
                        <li class="dropdown-header fw-bold text-dark">Notifications</li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="p-2 small text-muted">
                            <i class="fa-solid fa-circle-info text-primary me-1"></i>
                            Your account is currently under administrative verification.
                        </li>
                    </ul>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border d-flex align-items-center gap-2 p-1 pe-2 rounded-pill shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0066ff&color=fff';">
                        <div class="d-none d-sm-block text-start me-1">
                            <div class="fw-bold text-dark" style="font-size: 0.8125rem; line-height: 1.1;">
                                {{ Auth::user()->name }}
                            </div>
                            <small class="text-primary fw-semibold font-monospace" style="font-size: 0.675rem;">
                                {{ Auth::user()->seller?->seller_code }}
                            </small>
                        </div>
                        <i class="fa-solid fa-chevron-down text-muted" style="font-size: 0.75rem;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2 mt-2">
                        <li class="p-2 border-bottom mb-2">
                            <div class="fw-bold small">{{ Auth::user()->name }}</div>
                            <div class="text-muted small font-monospace">{{ Auth::user()->seller?->seller_code }}</div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle mt-1">
                                {{ Auth::user()->seller?->seller_status ?? 'Active' }}
                            </span>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 small" href="{{ route('seller.profile') }}">
                                <i class="fa-solid fa-id-card me-2 text-primary"></i> Edit Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 small" href="{{ route('home') }}">
                                <i class="fa-solid fa-house me-2 text-secondary"></i> Marketplace Home
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 small text-danger fw-semibold" href="{{ route('seller.logout') }}">
                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>


        
        <!-- Prominent Account Status Banner -->
        @php
            $sellerStatus = Auth::user()->seller?->seller_status ?? 'Pending Approval';
            $statusClass = 'pending';
            if ($sellerStatus === 'Active') $statusClass = 'active';
            elseif ($sellerStatus === 'Suspended' || $sellerStatus === 'Rejected') $statusClass = 'suspended';
        @endphp


        @if(Auth::check() && Auth::user()->isSuperAdmin())
            <div class="bg-dark text-white py-1 px-3 d-flex align-items-center justify-content-between small">
                <div>
                    <i class="fa-solid fa-shield-halved text-warning me-1"></i>
                    <strong>Super Admin Mode:</strong> You are viewing the Seller Portal with full administrative access.
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm py-0 px-2 fw-bold text-dark" style="font-size: 0.72rem;">
                    &larr; Return to Super Admin Dashboard
                </a>
            </div>
        @endif

        <div class="dc-status-bar {{ $statusClass }}">
            <div class="container-fluid px-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    @if($sellerStatus === 'Active')
                        <i class="fa-solid fa-circle-check fs-5 text-success"></i>
                        <span><strong>Account Status: Active</strong> — Your seller account is approved and ready for marketplace listings.</span>
                    @elseif($sellerStatus === 'Suspended')
                        <i class="fa-solid fa-triangle-exclamation fs-5 text-danger"></i>
                        <span><strong>Account Status: Suspended</strong> — Your account has been suspended. Please contact platform administration.</span>
                    @elseif($sellerStatus === 'Rejected')
                        <i class="fa-solid fa-circle-xmark fs-5 text-danger"></i>
                        <span><strong>Account Status: Not Approved</strong> — Sorry! Your store application was not approved. Review feedback in your dashboard.</span>
                    @else
                        <i class="fa-solid fa-clock-rotate-left fs-5 text-warning"></i>
                        <span><strong>Account Status: Under Process</strong> — Your seller account is under review by Super Admin. Listing publishing will unlock upon approval.</span>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Seller ID:</span>
                    <span class="badge bg-white text-dark border font-monospace px-2 py-1">
                        {{ Auth::user()->seller?->seller_code }}
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary border">
                        Verification: {{ Auth::user()->seller?->verification_status ?? 'Not Verified' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Global Toast / Alerts inside Seller Dashboard -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-info me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Body -->
        <main class="dc-page-body">
            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sellerSidebar');
        sidebar.classList.toggle('show');
    }

    function notifyComingSoon(moduleName) {
        alert(moduleName + " module is scheduled for Phase 2 development. Today's phase implements the Temporary Homepage, Seller Registration, Unique Seller ID Generation, Authentication, Seller Profile, and Initial Dashboard.");
    }
</script>
@yield('scripts')
</body>
</html>

