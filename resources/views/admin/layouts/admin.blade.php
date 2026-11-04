<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin Dashboard - Digital Class Marketplace')</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --admin-navy: #0b1424;
            --admin-sidebar-bg: #0b1424;
            --admin-sidebar-hover: #16233b;
            --admin-sidebar-active: #1e3a8a;
            --admin-sidebar-text: #94a3b8;
            --admin-sidebar-heading: #475569;
            --admin-primary: #2563eb;
            --admin-accent: #0284c7;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-bg: #f8fafc;
            --admin-border: #e2e8f0;
            --admin-card: #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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

        /* Sidebar (PDF Page 10 & 23 Reference) */
        .admin-sidebar {
            width: 270px;
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

        .admin-sidebar-brand {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .admin-brand-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.15rem;
            line-height: 1.2;
        }
        .admin-brand-title span {
            color: #38bdf8;
        }
        .admin-brand-badge {
            font-size: 0.65rem;
            font-weight: 700;
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            display: inline-block;
            margin-top: 2px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            text-transform: uppercase;
        }

        /* Sidebar Section Header */
        .admin-menu-section {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 1rem 1rem 0.35rem;
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
            padding: 0.55rem 0.85rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }

        .admin-nav-link i.menu-icon {
            width: 20px;
            font-size: 0.95rem;
            margin-right: 0.75rem;
            color: #64748b;
            transition: color 0.2s;
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
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%);
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
        }
        .admin-nav-link.active i.menu-icon {
            color: #ffffff;
        }

        .admin-nav-badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 999px;
        }

        /* Main Content */
        .admin-main-wrapper {
            margin-left: 270px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left 0.3s ease;
        }

        /* Top Header (PDF Page 10 Reference) */
        .admin-top-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--admin-border);
            padding: 0.85rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .admin-search-box {
            position: relative;
            max-width: 480px;
            width: 100%;
        }

        .admin-search-box input {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.55rem 1rem 0.55rem 2.4rem;
            font-size: 0.875rem;
            width: 100%;
        }
        .admin-search-box input:focus {
            background-color: #ffffff;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
            outline: none;
        }
        .admin-search-box i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .admin-page-content {
            padding: 1.75rem 1.75rem 3rem;
            flex-grow: 1;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main-wrapper {
                margin-left: 0;
            }
            .admin-search-box {
                max-width: 250px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="admin-layout-wrapper">
    <!-- ================= SUPER ADMIN SIDEBAR ================= -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand -->
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand">
            <div class="admin-brand-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <div class="admin-brand-title">Digital<span>Class</span></div>
                <span class="admin-brand-badge">Super Admin</span>
            </div>
        </a>

        <!-- Navigation Modules (PDF Page 10 & 23 Structure) -->
        <div class="flex-grow-1 pb-4">
            <!-- Dashboard -->
            <div class="admin-menu-section">Main</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie menu-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- User Management -->
            <div class="admin-menu-section">User Management</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'users') }}" class="admin-nav-link {{ request()->is('admin/module/users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users menu-icon"></i>
                        <span>Users & Members</span>
                    </a>
                </li>
                <!-- Sellers Management (Core Phase 2 Module) -->
                <li class="admin-nav-item">
                    <a href="{{ route('admin.sellers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.sellers.index') && !request()->routeIs('admin.sellers.pending') ? 'active' : '' }}">
                        <i class="fa-solid fa-store menu-icon"></i>
                        <span>Sellers Management</span>
                    </a>
                </li>
                <!-- Dedicated Pending Approvals Link -->
                <li class="admin-nav-item">
                    <a href="{{ route('admin.sellers.pending') }}" class="admin-nav-link {{ request()->routeIs('admin.sellers.pending') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-clock menu-icon text-warning"></i>
                        <span>Pending Approvals</span>
                        @php
                            $pendingBadgeCount = \App\Models\Seller::whereIn('seller_status', [\App\Models\Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending'])->count();
                        @endphp
                        @if($pendingBadgeCount > 0)
                            <span class="admin-nav-badge bg-warning text-dark">{{ $pendingBadgeCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <!-- Marketplace Management -->
            <div class="admin-menu-section">Marketplace Catalog Approvals</div>
            <ul class="admin-nav-list">
                @php
                    $pendingCoursesCount = \App\Models\Course::where('status', 'pending')->count();
                    $pendingServicesCount = \App\Models\Service::where('status', 'pending')->count();
                    $pendingProductsCount = \App\Models\Product::where('status', 'pending')->count();
                    $pendingListingsCount = \App\Models\BusinessListing::where('status', 'pending')->count();
                @endphp
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.courses') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.courses*') ? 'active' : '' }}">
                        <i class="fa-solid fa-video menu-icon text-primary"></i>
                        <span>Courses</span>
                        @if($pendingCoursesCount > 0)
                            <span class="admin-nav-badge bg-warning text-dark">{{ $pendingCoursesCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.services') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.services*') ? 'active' : '' }}">
                        <i class="fa-solid fa-handshake-angle menu-icon text-success"></i>
                        <span>Services</span>
                        @if($pendingServicesCount > 0)
                            <span class="admin-nav-badge bg-warning text-dark">{{ $pendingServicesCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.products') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.products*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box-open menu-icon text-danger"></i>
                        <span>Products</span>
                        @if($pendingProductsCount > 0)
                            <span class="admin-nav-badge bg-warning text-dark">{{ $pendingProductsCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.catalog.listings') }}" class="admin-nav-link {{ request()->routeIs('admin.catalog.listings*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building menu-icon text-warning"></i>
                        <span>Business Listings</span>
                        @if($pendingListingsCount > 0)
                            <span class="admin-nav-badge bg-warning text-dark">{{ $pendingListingsCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'orders') }}" class="admin-nav-link {{ request()->is('admin/module/orders*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping menu-icon"></i>
                        <span>Orders & Bookings</span>
                        <span class="admin-nav-badge bg-secondary-subtle text-light" style="font-size:0.6rem;">Soon</span>
                    </a>
                </li>
            </ul>

            <!-- Growth & Promotion -->
            <div class="admin-menu-section">Growth & Marketing</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.promotions.index') }}" class="admin-nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullhorn menu-icon text-warning"></i>
                        <span>Seller Promotions</span>
                        @php
                            $activePromosCount = \App\Models\Promotion::where('status', 'Active')->count();
                        @endphp
                        @if($activePromosCount > 0)
                            <span class="admin-nav-badge bg-warning text-dark">{{ $activePromosCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'coupons') }}" class="admin-nav-link {{ request()->is('admin/module/coupons*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket menu-icon"></i>
                        <span>Coupons</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'reviews') }}" class="admin-nav-link {{ request()->is('admin/module/reviews*') ? 'active' : '' }}">
                        <i class="fa-solid fa-star menu-icon"></i>
                        <span>Reviews / Ratings</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-comments menu-icon text-info"></i>
                        <span>Customer-Seller Chats</span>
                        @php
                            $totalChatsCount = \App\Models\Conversation::count();
                        @endphp
                        @if($totalChatsCount > 0)
                            <span class="admin-nav-badge bg-primary text-white">{{ $totalChatsCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'leads') }}" class="admin-nav-link {{ request()->is('admin/module/leads*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullseye menu-icon"></i>
                        <span>Leads</span>
                    </a>
                </li>
            </ul>

            <!-- Platform & Content -->
            <div class="admin-menu-section">Platform & Settings</div>
            <ul class="admin-nav-list">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'blog') }}" class="admin-nav-link {{ request()->is('admin/module/blog*') ? 'active' : '' }}">
                        <i class="fa-solid fa-newspaper menu-icon"></i>
                        <span>Blog / CMS</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'notifications') }}" class="admin-nav-link {{ request()->is('admin/module/notifications*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bell menu-icon"></i>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'app') }}" class="admin-nav-link {{ request()->is('admin/module/app*') ? 'active' : '' }}">
                        <i class="fa-solid fa-mobile-screen menu-icon"></i>
                        <span>App Management</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'website') }}" class="admin-nav-link {{ request()->is('admin/module/website*') ? 'active' : '' }}">
                        <i class="fa-solid fa-globe menu-icon"></i>
                        <span>Website Management</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'seo') }}" class="admin-nav-link {{ request()->is('admin/module/seo*') ? 'active' : '' }}">
                        <i class="fa-solid fa-magnifying-glass-chart menu-icon"></i>
                        <span>SEO Management</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.coming-soon', 'settings') }}" class="admin-nav-link {{ request()->is('admin/module/settings*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear menu-icon"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <!-- Logout -->
                <li class="admin-nav-item mt-3 pt-2 border-top border-secondary-subtle">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="admin-nav-link text-danger bg-transparent border-0 w-100 text-start">
                            <i class="fa-solid fa-right-from-bracket menu-icon text-danger"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT WRAPPER ================= -->
    <div class="admin-main-wrapper">
        <!-- Top Header -->
        <header class="admin-top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none border p-2" type="button" onclick="toggleAdminSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Global Search -->
                <div class="admin-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search sellers, users, courses, services, orders...">
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- View Public Marketplace Button -->
                <a href="{{ route('home') }}" class="btn btn-light border btn-sm d-none d-sm-inline-flex align-items-center gap-2" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Marketplace Home</span>
                </a>

                <!-- Super Admin Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border d-flex align-items-center gap-2 p-1 pe-2 rounded-pill shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="admin-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'SA', 0, 1)) }}
                        </div>
                        <div class="d-none d-sm-block text-start me-1">
                            <div class="fw-bold text-dark" style="font-size: 0.8125rem; line-height: 1.1;">
                                {{ Auth::user()->name ?? 'Super Admin' }}
                            </div>
                            <small class="text-danger fw-bold" style="font-size: 0.675rem; text-transform: uppercase;">
                                Super Admin
                            </small>
                        </div>
                        <i class="fa-solid fa-chevron-down text-muted" style="font-size: 0.75rem;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2 mt-2">
                        <li class="p-2 border-bottom mb-2">
                            <div class="fw-bold small">{{ Auth::user()->name }}</div>
                            <div class="text-muted small">{{ Auth::user()->email }}</div>
                            <span class="badge bg-danger text-white mt-1">Super Admin Role</span>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 small" href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-chart-pie me-2 text-primary"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 small" href="{{ route('admin.sellers.index') }}">
                                <i class="fa-solid fa-store me-2 text-info"></i> Sellers Management
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-2 py-2 small text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3 mb-0 rounded-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
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
        <main class="admin-page-content">
            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        sidebar.classList.toggle('show');
    }
</script>
@yield('scripts')
</body>
</html>

