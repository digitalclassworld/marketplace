<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Dashboard - Digital Class Marketplace')</title>

    <!-- Google Fonts: Plus Jakarta Sans / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.php" rel="stylesheet" onerror="this.onerror=null;this.href='https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css';">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- FontAwesome 6 Pro/Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --dc-primary: #0066ff;
            --dc-primary-hover: #0052cc;
            --dc-sidebar-bg: #ffffff;
            --dc-sidebar-width: 250px;
            --dc-topbar-height: 70px;
            --dc-body-bg: #f8fafc;
            --dc-text-dark: #0f172a;
            --dc-text-muted: #64748b;
            --dc-border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--dc-body-bg);
            color: var(--dc-text-dark);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Layout Structure */
        .dc-student-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .dc-student-sidebar {
            width: var(--dc-sidebar-width);
            background: var(--dc-sidebar-bg);
            border-right: 1px solid var(--dc-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            scrollbar-width: thin;
        }
        .dc-student-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .dc-student-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        /* Sidebar Brand */
        .dc-sidebar-header {
            padding: 1.25rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .dc-brand-logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0066ff 0%, #00d2ff 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
            flex-shrink: 0;
        }
        .dc-brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.15;
            letter-spacing: -0.02em;
        }
        .dc-brand-subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Sidebar Menu Items */
        .dc-sidebar-nav {
            padding: 1rem 0.85rem;
            list-style: none;
            margin: 0;
            flex-grow: 1;
        }
        .dc-nav-item {
            margin-bottom: 0.25rem;
        }
        .dc-nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.65rem 1rem;
            border-radius: 12px;
            color: #475569;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        .dc-nav-link i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
            color: #64748b;
            transition: color 0.2s ease;
        }
        .dc-nav-link:hover {
            color: var(--dc-primary);
            background-color: #f1f7ff;
        }
        .dc-nav-link:hover i {
            color: var(--dc-primary);
        }
        .dc-nav-link.active {
            background-color: var(--dc-primary);
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(0, 102, 255, 0.28);
        }
        .dc-nav-link.active i {
            color: #ffffff !important;
        }
        .dc-nav-badge {
            margin-left: auto;
            background-color: #ef4444;
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.2rem 0.5rem;
            border-radius: 999px;
            line-height: 1;
        }

        /* Sidebar Footer / Widgets */
        .dc-sidebar-footer {
            padding: 1rem 1rem 1.5rem;
            border-top: 1px solid #f1f5f9;
        }

        /* Refer & Earn Card */
        .refer-earn-card {
            background: linear-gradient(135deg, #fff1f2 0%, #fee2e2 100%);
            border: 1px solid #fecdd3;
            border-radius: 14px;
            padding: 1rem;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        .refer-icon-wrap {
            width: 32px;
            height: 32px;
            background: #ef4444;
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }
        .refer-earn-title {
            font-size: 0.88rem;
            font-weight: 800;
            color: #991b1b;
            margin-bottom: 0.2rem;
        }
        .refer-earn-desc {
            font-size: 0.73rem;
            color: #7f1d1d;
            line-height: 1.3;
            margin-bottom: 0.65rem;
        }
        .refer-earn-btn {
            background: var(--dc-primary);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.4rem 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: all 0.2s ease;
        }
        .refer-earn-btn:hover {
            background: var(--dc-primary-hover);
            color: #ffffff;
        }

        /* Need Help Widget */
        .need-help-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.85rem;
        }
        .need-help-title {
            font-size: 0.8rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .need-help-link {
            display: block;
            font-size: 0.74rem;
            color: #475569;
            text-decoration: none;
            padding: 0.2rem 0;
            transition: color 0.2s ease;
        }
        .need-help-link:hover {
            color: var(--dc-primary);
        }

        /* Main Content Area */
        .dc-student-main {
            margin-left: var(--dc-sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* Top Header Navigation */
        .dc-student-topbar {
            height: var(--dc-topbar-height);
            background: #ffffff;
            border-bottom: 1px solid var(--dc-border);
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        /* Search Bar in Topbar */
        .topbar-search-form {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            max-width: 620px;
            transition: all 0.2s ease;
        }
        .topbar-search-form:focus-within {
            border-color: var(--dc-primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }
        .topbar-search-input {
            border: none;
            background: transparent;
            padding: 0.55rem 1rem;
            font-size: 0.85rem;
            flex-grow: 1;
            color: #1e293b;
            outline: none;
        }
        .topbar-category-select {
            border: none;
            background: transparent;
            border-left: 1px solid #cbd5e1;
            padding: 0.55rem 0.85rem;
            font-size: 0.82rem;
            color: #475569;
            outline: none;
            cursor: pointer;
            font-weight: 500;
        }
        .topbar-search-btn {
            background: var(--dc-primary);
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.1rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .topbar-search-btn:hover {
            background: var(--dc-primary-hover);
        }

        /* Topbar Right Actions */
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1.1rem;
        }
        .topbar-icon-btn {
            position: relative;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.05rem;
            transition: all 0.2s ease;
        }
        .topbar-icon-btn:hover {
            background: #f1f5f9;
            color: var(--dc-primary);
            border-color: #cbd5e1;
        }
        .topbar-badge-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: #ffffff;
            font-size: 0.65rem;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            line-height: 1;
        }

        /* User Profile Dropdown Pill */
        .topbar-user-pill {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.35rem 0.6rem 0.35rem 0.35rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .topbar-user-pill:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        .topbar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background: #0066ff;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .topbar-user-info {
            text-align: left;
            line-height: 1.15;
            padding-right: 0.25rem;
        }
        .topbar-user-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: #0f172a;
        }
        .topbar-user-role {
            font-size: 0.68rem;
            font-weight: 600;
            color: #64748b;
        }

        /* Mobile Drawer Toggle */
        .dc-sidebar-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 1.35rem;
            color: #0f172a;
            padding: 0.25rem;
            cursor: pointer;
            margin-right: 0.75rem;
        }
        .dc-sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1035;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .dc-student-sidebar {
                transform: translateX(-100%);
            }
            .dc-student-sidebar.show {
                transform: translateX(0);
            }
            .dc-sidebar-backdrop.show {
                display: block;
            }
            .dc-student-main {
                margin-left: 0;
            }
            .dc-sidebar-toggle {
                display: inline-flex;
            }
            .topbar-search-form {
                max-width: 320px;
            }
            .topbar-category-select {
                display: none;
            }
        }
        @media (max-width: 576px) {
            .dc-student-topbar {
                padding: 0 1rem;
            }
            .topbar-search-form {
                display: none;
            }
            .topbar-user-info {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="dc-student-wrapper">

    <!-- Mobile Drawer Backdrop -->
    <div class="dc-sidebar-backdrop" id="sidebarBackdrop" onclick="toggleStudentSidebar()"></div>

    <!-- =========================================================================
         LEFT SIDEBAR NAVIGATION (Matching PDF Design)
         ========================================================================= -->
    <aside class="dc-student-sidebar" id="studentSidebar">
        <div>
            <!-- Sidebar Header Brand -->
            <div class="dc-sidebar-header">
                <a href="{{ route('customer.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="dc-brand-logo-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="dc-brand-title">Digital Class</div>
                        <div class="dc-brand-subtitle">Marketplace</div>
                    </div>
                </a>
            </div>

            <!-- Sidebar Navigation Links -->
            <ul class="dc-sidebar-nav">
                <li class="dc-nav-item">
                    <a href="{{ route('customer.dashboard') }}" class="dc-nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.my-courses') }}" class="dc-nav-link {{ (request()->routeIs('customer.my-courses') || request()->routeIs('customer.learning') || request()->routeIs('customer.course.*')) ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>My Learning</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.orders') }}" class="dc-nav-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>My Orders</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.services') }}" class="dc-nav-link {{ request()->routeIs('customer.services') ? 'active' : '' }}">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>My Services</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.businesses') }}" class="dc-nav-link {{ request()->routeIs('customer.businesses') ? 'active' : '' }}">
                        <i class="fa-solid fa-building-columns"></i>
                        <span>My Business Inquiries</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.wishlist') }}" class="dc-nav-link {{ request()->routeIs('customer.wishlist') ? 'active' : '' }}">
                        <i class="fa-regular fa-heart"></i>
                        <span>Wishlist</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.messages') }}" class="dc-nav-link {{ request()->routeIs('customer.messages') ? 'active' : '' }}">
                        <i class="fa-regular fa-message"></i>
                        <span>Messages</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.dashboard') }}#recommended" class="dc-nav-link">
                        <i class="fa-regular fa-star"></i>
                        <span>Reviews &amp; Ratings</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('businesses') }}" class="dc-nav-link">
                        <i class="fa-regular fa-bookmark"></i>
                        <span>Saved Businesses</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.orders') }}" class="dc-nav-link">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Purchase History</span>
                    </a>
                </li>

                <li class="dc-nav-item">
                    <a href="{{ route('customer.profile') }}" class="dc-nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                        <i class="fa-regular fa-user"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Bottom: Refer & Earn + Need Help -->
        <div class="dc-sidebar-footer">
            <!-- Refer & Earn Card -->
            <div class="refer-earn-card">
                <div class="refer-icon-wrap">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div class="refer-earn-title">Refer &amp; Earn</div>
                <div class="refer-earn-desc">Refer friends and earn up to &#8377;500 credit!</div>
                <a href="javascript:void(0)" class="refer-earn-btn" onclick="openReferModal()">
                    Refer Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Need Help Box -->
            <div class="need-help-box">
                <div class="need-help-title">
                    <i class="fa-regular fa-circle-question text-primary"></i>
                    <span>Need Help?</span>
                </div>
                <a href="mailto:support@digitalclassworld.in" class="need-help-link"><i class="fa-solid fa-circle-info me-1 text-muted"></i> Help Center</a>
                <a href="mailto:support@digitalclassworld.in" class="need-help-link"><i class="fa-solid fa-envelope me-1 text-muted"></i> Contact Support</a>
                <a href="javascript:void(0)" onclick="openLiveChat()" class="need-help-link"><i class="fa-solid fa-comments me-1 text-muted"></i> Live Chat</a>
            </div>
        </div>
    </aside>

    <!-- =========================================================================
         MAIN CONTENT AREA
         ========================================================================= -->
    <div class="dc-student-main">

        <!-- Top Header Navigation Bar -->
        <header class="dc-student-topbar">
            <div class="d-flex align-items-center">
                <button type="button" class="dc-sidebar-toggle" onclick="toggleStudentSidebar()" title="Toggle Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Global Search with Category Selector -->
                <form action="{{ route('courses') }}" method="GET" class="topbar-search-form" id="topbarSearchForm">
                    <input type="text" name="search" class="topbar-search-input" placeholder="Search for courses, services, products or businesses..." value="{{ request('search') }}">
                    <select class="topbar-category-select" id="topbarCatSelect" onchange="switchSearchTarget(this.value)">
                        <option value="courses" selected>All Categories</option>
                        <option value="courses">Courses</option>
                        <option value="services">Services</option>
                        <option value="products">Products</option>
                        <option value="businesses">Businesses</option>
                    </select>
                    <button type="submit" class="topbar-search-btn" title="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <!-- Topbar Right Actions -->
            <div class="topbar-actions">
                <!-- Wishlist Icon -->
                @php $currentWishlistCount = count(session('wishlist', [])); @endphp
                <a href="{{ route('customer.wishlist') }}" class="topbar-icon-btn" title="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                    @if($currentWishlistCount > 0)
                        <span class="topbar-badge-count">{{ $currentWishlistCount }}</span>
                    @endif
                </a>

                <!-- Cart Icon -->
                <a href="{{ route('checkout') }}" class="topbar-icon-btn" title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="topbar-badge-count">{{ count(session('cart', [])) }}</span>
                </a>

                <!-- Notifications Bell -->
                <div class="dropdown">
                    <a href="javascript:void(0)" class="topbar-icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                        <i class="fa-regular fa-bell"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="width: 290px; font-size: 0.82rem;">
                        <li class="dropdown-header fw-bold text-dark px-2">Notifications</li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.my-courses') }}"><i class="fa-solid fa-circle-check text-success me-2"></i> Lesson completed in Digital Marketing</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.orders') }}"><i class="fa-solid fa-truck text-primary me-2"></i> Order #ORD-2026 Delivered</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.my-courses') }}"><i class="fa-solid fa-award text-warning me-2"></i> New Certificate Available</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.dashboard') }}"><i class="fa-solid fa-tag text-danger me-2"></i> Festival Offer: Extra 50% OFF</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.messages') }}"><i class="fa-solid fa-headset text-info me-2"></i> Digital Class Support Desk</a></li>
                    </ul>
                </div>

                <!-- User Profile Dropdown Pill -->
                @php
                    $loggedUser = Auth::guard('web')->user() ?: (object)[
                        'name' => 'Hitesh Mohkar',
                        'email' => 'student@digitalclassworld.in',
                        'profession' => 'Student',
                        'avatar' => null,
                    ];
                    $displayName = $loggedUser->name ?? 'Student';
                    $initials = strtoupper(substr($displayName, 0, 1));
                @endphp
                <div class="dropdown">
                    <div class="topbar-user-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(!empty($loggedUser->avatar) && file_exists(public_path($loggedUser->avatar)))
                            <img src="{{ asset($loggedUser->avatar) }}" alt="{{ $displayName }}" class="topbar-user-avatar">
                        @else
                            <div class="topbar-user-avatar">{{ $initials }}</div>
                        @endif
                        <div class="topbar-user-info">
                            <div class="topbar-user-name">{{ Str::limit($displayName, 14) }}</div>
                            <div class="topbar-user-role">{{ $loggedUser->profession ?: 'Student' }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-muted small ms-1" style="font-size: 0.65rem;"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 mt-2" style="font-size: 0.85rem; min-width: 210px;">
                        <li class="px-2 py-1">
                            <div class="fw-bold text-dark">{{ $displayName }}</div>
                            <div class="text-muted small">{{ $loggedUser->email ?? 'student@digitalclass.com' }}</div>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.dashboard') }}"><i class="fa-solid fa-house me-2 text-primary"></i> Dashboard</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.my-courses') }}"><i class="fa-solid fa-graduation-cap me-2 text-info"></i> My Learning</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.orders') }}"><i class="fa-solid fa-bag-shopping me-2 text-success"></i> My Orders</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('customer.profile') }}"><i class="fa-regular fa-user me-2 text-secondary"></i> Profile Settings</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('home') }}"><i class="fa-solid fa-store me-2 text-warning"></i> Explore Marketplace</a></li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <form action="{{ route('customer.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-2 py-2 text-danger">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Specific Body Content -->
        <main class="flex-grow-1">
            @yield('content')
        </main>
    </div>
</div>

<!-- =========================================================================
     INTERACTIVE MODALS: REFER & EARN, LIVE CHAT, WISHLIST
     ========================================================================= -->
<!-- Refer & Earn Modal -->
<div class="modal fade" id="referEarnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #0066ff 0%, #00d2ff 100%); color: #ffffff;">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-gift me-2"></i> Refer Friends &amp; Earn &#8377;500</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-secondary small">Invite your friends to Digital Class. When they enroll in their first course or hire an agency, both of you earn &#8377;500 wallet credits!</p>
                <label class="form-label fw-bold small text-dark">Your Unique Referral Link</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control bg-light" id="referralLinkInput" value="https://web.digitalclassworld.in/register?ref={{ Auth::check() ? Auth::user()->id : 101 }}" readonly>
                    <button class="btn btn-primary fw-semibold px-3" type="button" onclick="copyReferralLink()"><i class="fa-solid fa-copy me-1"></i> Copy</button>
                </div>
                <div class="alert alert-success d-none py-2 px-3 small" id="copySuccessAlert">Referral link copied to clipboard!</div>
            </div>
        </div>
    </div>
</div>

<!-- Live Chat Toast Widget -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
    <div id="liveChatToast" class="toast border-0 shadow-lg rounded-4 overflow-hidden" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="toast-header bg-primary text-white py-2 px-3">
            <i class="fa-solid fa-headset me-2"></i>
            <strong class="me-auto">Digital Class Support</strong>
            <small class="text-white-50">Online</small>
            <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body p-3 bg-white" style="font-size: 0.84rem;">
            <p class="mb-2 text-dark">Hello {{ Auth::check() ? Auth::user()->name : 'Student' }}! How can we assist with your courses or orders today?</p>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Type your message...">
                <button class="btn btn-sm btn-primary" onclick="alert('Message sent to Digital Class support advisor!')"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleStudentSidebar() {
        const sidebar = document.getElementById('studentSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar && backdrop) {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }
    }

    function switchSearchTarget(cat) {
        const form = document.getElementById('topbarSearchForm');
        if (!form) return;
        if (cat === 'services') {
            form.action = "{{ route('services') }}";
        } else if (cat === 'businesses') {
            form.action = "{{ route('businesses') }}";
        } else if (cat === 'products') {
            form.action = "{{ route('products') }}";
        } else {
            form.action = "{{ route('courses') }}";
        }
    }

    function openReferModal() {
        const modal = new bootstrap.Modal(document.getElementById('referEarnModal'));
        modal.show();
    }

    function copyReferralLink() {
        const input = document.getElementById('referralLinkInput');
        if (input) {
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value);
            const alertBox = document.getElementById('copySuccessAlert');
            if (alertBox) {
                alertBox.classList.remove('d-none');
                setTimeout(() => alertBox.classList.add('d-none'), 3000);
            }
        }
    }

    function openLiveChat() {
        const toastEl = document.getElementById('liveChatToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    }
</script>

@yield('scripts')
</body>
</html>
