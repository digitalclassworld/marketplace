@extends('admin.layouts.admin')

@section('title', 'Super Admin Overview - Digital Class Educational World')

@section('styles')
<style>
    /* =========================================================================
       SUPER ADMIN DASHBOARD - MODERN EXECUTIVE SAAS DESIGN
       ========================================================================= */

    /* Hero KPI Cards */
    .hero-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem 1.35rem;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 140px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .hero-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }
    .hero-kpi-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: transparent;
        transition: background 0.2s ease;
    }
    .hero-kpi-card.card-blue:hover::after { background: #2563eb; }
    .hero-kpi-card.card-emerald:hover::after { background: #10b981; }
    .hero-kpi-card.card-purple:hover::after { background: #8b5cf6; }
    .hero-kpi-card.card-amber:hover::after { background: #f59e0b; }

    .hero-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .hero-kpi-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.01em;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }

    .hero-kpi-value {
        font-size: 1.65rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .hero-growth-badge {
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 999px;
        padding: 0.2rem 0.55rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .hero-kpi-subtext {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.65rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    /* Secondary Quick-Metric Strip */
    .metric-strip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.85rem 1.25rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }
    .metric-strip-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.15s ease;
    }
    .metric-strip-item:hover {
        background: #f1f5f9;
        color: #0066ff;
    }
    .metric-strip-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .metric-strip-label {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 1px;
    }
    .metric-strip-val {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* Chart Containers */
    .chart-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .chart-canvas-wrapper {
        position: relative;
        width: 100%;
        height: 250px;
    }

    /* Quick Action Button Tile */
    .quick-action-tile {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 0.4rem;
        text-align: center;
        text-decoration: none;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        height: 100%;
    }
    .quick-action-tile:hover {
        background: #ffffff;
        border-color: #2563eb;
        color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
        transform: translateY(-2px);
    }
    .quick-action-tile i {
        font-size: 1.2rem;
    }
    .quick-action-tile span {
        font-size: 0.72rem;
        font-weight: 600;
        line-height: 1.2;
        color: inherit;
    }

    /* Grow Platform Promo Box */
    .grow-platform-box {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4338ca 100%);
        color: #ffffff;
        border-radius: 14px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .grow-platform-box h6 {
        color: #ffffff;
        font-weight: 700;
    }
    .grow-platform-box p {
        color: #c7d2fe;
        font-size: 0.78rem;
    }

    /* Legend Pills */
    .chart-legend-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
    }
    .chart-legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Top Greeting Section & Pending Requests Button -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.7rem; letter-spacing: -0.02em;">
                Welcome Back, {{ explode(' ', Auth::user()->name ?? 'Super Admin')[0] }} 👋
            </h2>
            <p class="text-secondary small mb-0">Here's your live marketplace performance and database usage overview.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- PENDING REQUESTS BUTTON -->
            <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2 shadow-sm d-flex align-items-center gap-2 position-relative" data-bs-toggle="modal" data-bs-target="#pendingRequestsModal" style="border-radius: 12px; border: 1px solid #f59e0b; background: linear-gradient(135deg, #fef08a 0%, #fde047 100%);">
                <i class="fa-solid fa-clock-rotate-left fs-6 text-dark"></i>
                <span style="font-size: 0.88rem;">Pending Approvals</span>
                <span class="badge bg-danger text-white rounded-pill px-2 py-1" style="font-size: 0.72rem;">
                    {{ $totalPendingCount }}
                </span>
            </button>
        </div>
    </div>

    <!-- =========================================================================
         TIER 1: 4 HERO EXECUTIVE KPI CARDS (SPACIOUS 4-COLUMN GRID)
         ========================================================================= -->
    <div class="row g-3 mb-3">
        <!-- 1. Total Revenue -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.financial.payments') }}" class="text-decoration-none d-block">
                <div class="hero-kpi-card card-emerald">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="hero-kpi-label">Total Revenue</div>
                            <div class="hero-kpi-value text-success">{{ $kpis['total_revenue'] }}</div>
                        </div>
                        <div class="hero-icon-box" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>
                    </div>
                    <div class="hero-kpi-subtext">
                        <span class="hero-growth-badge bg-success-subtle text-success">
                            <i class="fa-solid fa-arrow-trend-up"></i> {{ $kpis['revenue_growth'] }}
                        </span>
                        <span>{{ $kpis['revenue_sub'] }}</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. Active Users & Community -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none d-block">
                <div class="hero-kpi-card card-blue">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="hero-kpi-label">Total Users</div>
                            <div class="hero-kpi-value">{{ $kpis['total_users'] }}</div>
                        </div>
                        <div class="hero-icon-box" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div class="hero-kpi-subtext">
                        <span class="hero-growth-badge bg-primary-subtle text-primary">
                            <i class="fa-solid fa-user-plus"></i> {{ $kpis['users_growth'] }}
                        </span>
                        <span>{{ $kpis['users_sub'] }}</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. Seller Network -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.sellers.index') }}" class="text-decoration-none d-block">
                <div class="hero-kpi-card card-purple">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="hero-kpi-label">Total Sellers</div>
                            <div class="hero-kpi-value">{{ $kpis['total_sellers'] }}</div>
                        </div>
                        <div class="hero-icon-box" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
                            <i class="fa-solid fa-store"></i>
                        </div>
                    </div>
                    <div class="hero-kpi-subtext">
                        <span class="hero-growth-badge bg-purple-subtle text-purple" style="background: #f3e8ff; color: #7c3aed;">
                            <i class="fa-solid fa-shop"></i> {{ $kpis['sellers_growth'] }}
                        </span>
                        <span>{{ $kpis['sellers_sub'] }}</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. Marketplace Catalog & Offerings -->
        <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('admin.catalog.listings') }}" class="text-decoration-none d-block">
                <div class="hero-kpi-card card-amber">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="hero-kpi-label">Business Listings</div>
                            <div class="hero-kpi-value">{{ $kpis['business_listings'] }}</div>
                        </div>
                        <div class="hero-icon-box" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    </div>
                    <div class="hero-kpi-subtext">
                        <span class="hero-growth-badge bg-warning-subtle text-warning-emphasis">
                            ★ {{ $kpis['average_rating'] }} Rating
                        </span>
                        <span>{{ $kpis['listings_sub'] }}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- =========================================================================
         TIER 2: SECONDARY QUICK-METRIC STRIP (DETAILED BREAKDOWN AT A GLANCE)
         ========================================================================= -->
    <div class="metric-strip mb-4">
        <div class="row g-2 align-items-center">
            <!-- Courses -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1">
                <a href="{{ route('admin.catalog.courses') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">Courses</div>
                        <div class="metric-strip-val">{{ $kpis['total_courses'] }}</div>
                    </div>
                </a>
            </div>

            <!-- Services -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1 border-start-md">
                <a href="{{ route('admin.catalog.services') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">Services</div>
                        <div class="metric-strip-val">{{ $kpis['total_services'] }}</div>
                    </div>
                </a>
            </div>

            <!-- Products -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1 border-start-md">
                <a href="{{ route('admin.catalog.products') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">Products</div>
                        <div class="metric-strip-val">{{ $kpis['total_products'] }}</div>
                    </div>
                </a>
            </div>

            <!-- Orders -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1 border-start-md">
                <a href="{{ route('admin.orders.index') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">Orders</div>
                        <div class="metric-strip-val">{{ $kpis['total_orders'] }}</div>
                    </div>
                </a>
            </div>

            <!-- Leads -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1 border-start-md">
                <a href="{{ route('admin.leads.index') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">Leads</div>
                        <div class="metric-strip-val">{{ $kpis['new_leads'] }}</div>
                    </div>
                </a>
            </div>

            <!-- Payout Due -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1 border-start-md">
                <a href="{{ route('admin.financial.payouts') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">Payout Due</div>
                        <div class="metric-strip-val">{{ $kpis['payout_due'] }}</div>
                    </div>
                </a>
            </div>

            <!-- App Installs -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-grow-1 border-start-md">
                <a href="{{ route('admin.app.index') }}" class="metric-strip-item">
                    <div class="metric-strip-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <div>
                        <div class="metric-strip-label">App Installs</div>
                        <div class="metric-strip-val">{{ $kpis['app_downloads'] }}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         MIDDLE ROW: REVENUE OVERVIEW CHART, GROWTH CHART, QUICK ACTIONS
         ========================================================================= -->
    <div class="row g-3 mb-4">
        <!-- 1. Revenue Overview Chart (Stacked Bar + Commission Spline) -->
        <div class="col-xl-5 col-lg-6">
            <div class="chart-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 1rem;">Revenue Overview</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Courses, Services, Products &amp; Platform Commission</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border py-1 px-2.5 text-secondary small dropdown-toggle fw-semibold rounded-3" type="button" data-bs-toggle="dropdown">
                            Last 12 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end small shadow-sm">
                            <li><a class="dropdown-item active" href="#">Last 12 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">This Year (2026)</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Clean Color Legends -->
                <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                    <span class="chart-legend-pill">
                        <span class="chart-legend-dot" style="background: #2563eb;"></span> Courses
                    </span>
                    <span class="chart-legend-pill">
                        <span class="chart-legend-dot" style="background: #10b981;"></span> Services
                    </span>
                    <span class="chart-legend-pill">
                        <span class="chart-legend-dot" style="background: #f59e0b;"></span> Products
                    </span>
                    <span class="chart-legend-pill">
                        <span class="chart-legend-dot" style="background: #8b5cf6;"></span> Commission (15%)
                    </span>
                </div>

                <!-- Canvas with proper height & fallback -->
                <div class="chart-canvas-wrapper">
                    <canvas id="revenueOverviewChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 2. Users & Sellers Growth (Dual Curve Line Chart) -->
        <div class="col-xl-4 col-lg-6">
            <div class="chart-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 1rem;">Users &amp; Sellers Growth</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Total registered community trajectory</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border py-1 px-2.5 text-secondary small dropdown-toggle fw-semibold rounded-3" type="button" data-bs-toggle="dropdown">
                            Last 6 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end small shadow-sm">
                            <li><a class="dropdown-item active" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Clean Legends -->
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="chart-legend-pill">
                        <span class="chart-legend-dot" style="background: #2563eb;"></span> Users ({{ $kpis['total_users'] }})
                    </span>
                    <span class="chart-legend-pill">
                        <span class="chart-legend-dot" style="background: #10b981;"></span> Sellers ({{ $kpis['total_sellers'] }})
                    </span>
                </div>

                <!-- Canvas with proper height & fallback -->
                <div class="chart-canvas-wrapper">
                    <canvas id="growthLineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 3. Quick Actions & Growth Promo -->
        <div class="col-xl-3 col-lg-12">
            <div class="d-flex flex-column gap-3 h-100">
                <!-- Quick Actions Grid (8 items in 4x2) -->
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Quick Actions</h6>
                        <a href="{{ route('admin.sellers.index') }}" class="small text-primary text-decoration-none fw-semibold">Manage</a>
                    </div>
                    <div class="row g-2">
                        <!-- Add Seller -->
                        <div class="col-3">
                            <a href="{{ route('admin.sellers.pending') }}" class="quick-action-tile">
                                <i class="fa-solid fa-store" style="color: #2563eb;"></i>
                                <span>Add Seller</span>
                            </a>
                        </div>
                        <!-- Add Course -->
                        <div class="col-3">
                            <a href="{{ route('admin.catalog.courses') }}" class="quick-action-tile">
                                <i class="fa-solid fa-graduation-cap" style="color: #8b5cf6;"></i>
                                <span>Add Course</span>
                            </a>
                        </div>
                        <!-- Add Service -->
                        <div class="col-3">
                            <a href="{{ route('admin.catalog.services') }}" class="quick-action-tile">
                                <i class="fa-solid fa-briefcase" style="color: #f59e0b;"></i>
                                <span>Add Service</span>
                            </a>
                        </div>
                        <!-- Add Product -->
                        <div class="col-3">
                            <a href="{{ route('admin.catalog.products') }}" class="quick-action-tile">
                                <i class="fa-solid fa-box-open" style="color: #ec4899;"></i>
                                <span>Add Product</span>
                            </a>
                        </div>
                        <!-- Add Business -->
                        <div class="col-3">
                            <a href="{{ route('admin.catalog.listings') }}" class="quick-action-tile">
                                <i class="fa-solid fa-building" style="color: #0ea5e9;"></i>
                                <span>Add Business</span>
                            </a>
                        </div>
                        <!-- Send Notification -->
                        <div class="col-3">
                            <a href="#" class="quick-action-tile" onclick="alert('Notification composer opened.'); return false;">
                                <i class="fa-solid fa-bell" style="color: #10b981;"></i>
                                <span>Notify</span>
                            </a>
                        </div>
                        <!-- Create Banner -->
                        <div class="col-3">
                            <a href="{{ route('admin.promotions.index') }}" class="quick-action-tile">
                                <i class="fa-solid fa-image" style="color: #6366f1;"></i>
                                <span>Banner</span>
                            </a>
                        </div>
                        <!-- Generate Report -->
                        <div class="col-3">
                            <a href="#" class="quick-action-tile" onclick="alert('Exporting system report...'); return false;">
                                <i class="fa-solid fa-chart-pie" style="color: #14b8a6;"></i>
                                <span>Report</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Grow Platform Promo Card -->
                <div class="grow-platform-box flex-grow-1 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="mb-0">Grow Your Platform</h6>
                            <span class="fs-4">🚀</span>
                        </div>
                        <p class="mb-3">
                            Launch seasonal promotions, banners and marketing campaigns to boost user engagement and transactions.
                        </p>
                    </div>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-light btn-sm rounded-3 fw-bold w-100 py-2 text-dark shadow-sm">
                        Create Promotion &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         RECENT PLATFORM REGISTRATIONS (REAL DATABASE RECORDS, INSTANT RENDER)
         ========================================================================= -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 pb-3 border-bottom mb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size: 1.15rem;">
                        <i class="fa-solid fa-users text-primary"></i>
                        Recent Platform Registrations
                    </h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.75rem;">
                        {{ $kpis['total_users'] }} Total Registered
                    </span>
                </div>
                <p class="text-muted small mb-0">
                    Showing latest registered platform members across all roles.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm rounded-pill fw-bold px-3 py-1.5 shadow-sm">
                    <i class="fa-solid fa-up-right-from-square me-1"></i> View All {{ $kpis['total_users'] }} Users &rarr;
                </a>
            </div>
        </div>

        <!-- Filter Pills & Quick Search -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2 mb-3">
            <div class="d-flex flex-wrap gap-1.5" id="userFilterButtons">
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold active user-filter-btn" data-filter="all">
                    All Recent
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1 text-secondary fw-semibold user-filter-btn" data-filter="active">
                    <i class="fa-solid fa-circle-check text-success me-1"></i> Active
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1 text-secondary fw-semibold user-filter-btn" data-filter="pending">
                    <i class="fa-solid fa-clock text-warning me-1"></i> Pending
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1 text-secondary fw-semibold user-filter-btn" data-filter="sellers">
                    <i class="fa-solid fa-store text-info me-1"></i> Sellers/Institutes
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1 text-secondary fw-semibold user-filter-btn" data-filter="students">
                    <i class="fa-solid fa-graduation-cap text-purple me-1"></i> Students
                </button>
            </div>
            <div style="min-width: 260px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="dashboardUserSearchInput" class="form-control border-start-0 ps-0" placeholder="Filter by name, email, phone...">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dashboardUsersTable" style="font-size: 0.825rem;">
                <thead class="bg-light text-muted" style="border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>User Identity</th>
                        <th>Contact Phone</th>
                        <th>Role / Account Type</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allPlatformUsers as $userItem)
                        @php
                            $searchHaystack = strtolower($userItem['name'] . ' ' . $userItem['email'] . ' ' . $userItem['phone'] . ' ' . $userItem['type'] . ' ' . $userItem['status'] . ' ' . $userItem['location'] . ' ' . ($userItem['seller_code'] ?? ''));
                            $filterCategory = 'other';
                            if ($userItem['status'] === 'Active') $filterCategory .= ' active';
                            if ($userItem['status'] === 'Inactive') $filterCategory .= ' inactive';
                            if ($userItem['status'] === 'Pending Approval') $filterCategory .= ' pending';
                            if (in_array($userItem['type'], ['Seller', 'Institute'])) $filterCategory .= ' sellers';
                            if ($userItem['type'] === 'Student') $filterCategory .= ' students';
                        @endphp
                        <tr class="dashboard-user-row" data-category="{{ $filterCategory }}" data-search="{{ $searchHaystack }}">
                            <td class="text-muted fw-bold">#{{ $userItem['id'] }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $userItem['avatar'] }}" alt="{{ $userItem['name'] }}" class="rounded-circle shadow-sm" style="width: 34px; height: 34px; object-fit: cover;">
                                    <div class="overflow-hidden">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 180px;">{{ $userItem['name'] }}</div>
                                        <small class="text-muted text-truncate d-block" style="font-size: 0.725rem; max-width: 180px;">{{ $userItem['email'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary font-monospace" style="font-size: 0.78rem;">
                                {{ $userItem['phone'] }}
                            </td>
                            <td>
                                <span class="badge {{ $userItem['badge_class'] }} px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                    {{ $userItem['type'] }}
                                </span>
                                @if(!empty($userItem['seller_code']))
                                    <small class="text-muted d-block font-monospace" style="font-size: 0.68rem;">{{ $userItem['seller_code'] }}</small>
                                @endif
                            </td>
                            <td class="text-secondary">
                                <i class="fa-solid fa-location-dot text-danger me-1 small"></i>
                                {{ $userItem['location'] }}
                            </td>
                            <td>
                                <span class="badge {{ $userItem['status_class'] }} px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                    @if($userItem['status'] === 'Active')
                                        <i class="fa-solid fa-circle-check me-1"></i> Active
                                    @elseif($userItem['status'] === 'Inactive')
                                        <i class="fa-solid fa-circle-xmark me-1"></i> Inactive
                                    @else
                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                    @endif
                                </span>
                            </td>
                            <td class="text-muted" style="font-size: 0.75rem;">
                                {{ $userItem['joined_on'] }}
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    @if(!empty($userItem['seller_id']))
                                        <a href="{{ route('admin.sellers.show', $userItem['seller_id']) }}" class="btn btn-sm btn-light border py-1 px-2 fw-semibold text-primary" title="View Seller Store">
                                            <i class="fa-solid fa-store me-1"></i> Store
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.users.index', ['search' => $userItem['email']]) }}" class="btn btn-sm btn-light border py-1 px-2 fw-semibold text-dark" title="Inspect User">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users fs-3 text-secondary opacity-50 mb-2 d-block"></i>
                                <strong>No users found in database.</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- =========================================================================
         BOTTOM ROW: RECENT ORDERS, RECENT SELLERS, RECENT ACTIVITIES
         ========================================================================= -->
    <div class="row g-3">
        <!-- 1. Recent Orders -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Recent Orders</h6>
                    <a href="{{ route('admin.orders.index') }}" class="small text-primary text-decoration-none fw-semibold">View All &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle table-borderless mb-0" style="font-size: 0.775rem;">
                        <thead class="text-muted" style="border-bottom: 1px solid #f1f5f9;">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr style="border-bottom: 1px solid #f8fafc;">
                                    <td class="text-muted fw-bold">{{ $order['id'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <img src="{{ $order['item_thumb'] }}" class="rounded" style="width: 24px; height: 24px; object-fit: cover;">
                                            <span class="fw-semibold text-dark text-truncate" style="max-width: 105px;" title="{{ $order['item'] }}">{{ $order['item'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary text-truncate" style="max-width: 80px;">{{ $order['customer'] }}</td>
                                    <td class="fw-bold text-dark">{{ $order['amount'] }}</td>
                                    <td>
                                        @if($order['status'] === 'Paid')
                                            <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">Paid</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-muted">{{ $order['date'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted">No recent orders.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 2. Recent Sellers -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Recent Sellers</h6>
                    <a href="{{ route('admin.sellers.index') }}" class="small text-primary text-decoration-none fw-semibold">View All &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle table-borderless mb-0" style="font-size: 0.775rem;">
                        <thead class="text-muted" style="border-bottom: 1px solid #f1f5f9;">
                            <tr>
                                <th>#</th>
                                <th>Store Name</th>
                                <th>Type</th>
                                <th>Joined</th>
                                <th class="text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSellers as $seller)
                                @php $sellerShowUrl = route('admin.sellers.show', $seller['seller_id'] ?? $seller['id']); @endphp
                                <tr style="border-bottom: 1px solid #f8fafc; cursor: pointer; transition: background 0.15s ease;" onclick="window.location='{{ $sellerShowUrl }}'" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                    <td class="text-muted fw-bold">{{ $seller['id'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <img src="{{ $seller['store_thumb'] }}" class="rounded-circle" style="width: 24px; height: 24px; object-fit: cover;">
                                            <a href="{{ $sellerShowUrl }}" class="fw-semibold text-dark text-decoration-none text-truncate" style="max-width: 110px;" title="{{ $seller['store_name'] }}">
                                                {{ $seller['store_name'] }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">{{ $seller['type'] }}</span>
                                    </td>
                                    <td class="text-muted">{{ $seller['joined_on'] }}</td>
                                    <td class="text-end">
                                        @if($seller['status'] === 'Active')
                                            <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">Active</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">No recent sellers.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 3. Recent Activities Feed -->
        <div class="col-xl-4 col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Recent Activities</h6>
                    <a href="#" class="small text-primary text-decoration-none fw-semibold" onclick="alert('Viewing recent system activity stream.'); return false;">Activity Log</a>
                </div>
                <div class="d-flex flex-column gap-3">
                    @forelse($recentActivities as $act)
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: {{ $act['bg'] }}; color: {{ $act['color'] }}; font-size: 0.85rem; flex-shrink: 0;">
                                    <i class="{{ $act['icon'] }}"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem; line-height: 1.2;">{{ $act['title'] }}</div>
                                    <div class="text-secondary small text-truncate" style="font-size: 0.725rem;">{{ $act['desc'] }}</div>
                                </div>
                            </div>
                            <span class="text-muted small" style="font-size: 0.7rem; white-space: nowrap;">{{ $act['time'] }}</span>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted small">No recent activity.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         PENDING APPROVALS CENTRAL MODAL
         ========================================================================= -->
    <div class="modal fade" id="pendingRequestsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="pendingRequestsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom py-3 px-4" style="background: #f8fafc;">
                    <div>
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2 mb-1" id="pendingRequestsModalLabel">
                            <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                            Pending Approvals Central
                            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                {{ $totalPendingCount }} Pending
                            </span>
                        </h5>
                        <p class="text-muted small mb-0">Review and approve or reject incoming sellers, courses, services, businesses, and products.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div id="pendingModalFeedback" class="d-none"></div>

                    <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="pendingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-3 py-1.5 fw-bold" id="sellers-tab" data-bs-toggle="pill" data-bs-target="#tab-sellers" type="button" role="tab">
                                <i class="fa-solid fa-store me-1"></i> Sellers ({{ $pendingSellersCount ?? $pendingSellers->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-3 py-1.5 fw-bold" id="courses-tab" data-bs-toggle="pill" data-bs-target="#tab-courses" type="button" role="tab">
                                <i class="fa-solid fa-graduation-cap me-1"></i> Courses ({{ $pendingCoursesCount ?? $pendingCourses->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-3 py-1.5 fw-bold" id="services-tab" data-bs-toggle="pill" data-bs-target="#tab-services" type="button" role="tab">
                                <i class="fa-solid fa-briefcase me-1"></i> Services ({{ $pendingServicesCount ?? $pendingServices->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-3 py-1.5 fw-bold" id="listings-tab" data-bs-toggle="pill" data-bs-target="#tab-listings" type="button" role="tab">
                                <i class="fa-solid fa-building me-1"></i> Businesses ({{ $pendingListingsCount ?? $pendingListings->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-3 py-1.5 fw-bold" id="products-tab" data-bs-toggle="pill" data-bs-target="#tab-products" type="button" role="tab">
                                <i class="fa-solid fa-box-open me-1"></i> Products ({{ $pendingProductsCount ?? $pendingProducts->count() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pendingTabsContent">
                        <!-- Sellers Tab -->
                        <div class="tab-pane fade show active" id="tab-sellers" role="tabpanel">
                            @if($pendingSellers->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i>
                                    <strong>No pending seller applications!</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Applicant</th>
                                                <th>Business Name</th>
                                                <th>Type</th>
                                                <th>Applied Date</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingSellers as $ps)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $ps->user?->name ?? 'Unknown' }}</div>
                                                        <small class="text-muted">{{ $ps->user?->email }}</small>
                                                    </td>
                                                    <td>{{ $ps->businessDetail?->business_name ?? 'N/A' }}</td>
                                                    <td><span class="badge bg-light text-dark border">{{ $ps->account_type }}</span></td>
                                                    <td class="text-muted small">{{ $ps->created_at ? $ps->created_at->format('d M Y') : 'Recent' }}</td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.sellers.approve', $ps->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.sellers.reject', $ps->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this seller?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                                                                <i class="fa-solid fa-xmark me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(($pendingSellersCount ?? 0) > $pendingSellers->count())
                                    <div class="text-center py-2 border-top mt-2">
                                        <a href="{{ route('admin.sellers.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                            View All {{ $pendingSellersCount }} Pending Sellers in Management &rarr;
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Courses Tab -->
                        <div class="tab-pane fade" id="tab-courses" role="tabpanel">
                            @if($pendingCourses->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i>
                                    <strong>No pending courses to review!</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Instructor</th>
                                                <th>Price</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingCourses as $pc)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $pc->title }}</div>
                                                        <small class="text-muted">{{ $pc->category }}</small>
                                                    </td>
                                                    <td>{{ $pc->seller?->businessDetail?->business_name ?? $pc->seller?->user?->name ?? 'Seller' }}</td>
                                                    <td class="fw-bold">₹{{ number_format($pc->price) }}</td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.courses.approve', $pc->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.courses.reject', $pc->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this course?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                                                                <i class="fa-solid fa-xmark me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(($pendingCoursesCount ?? 0) > $pendingCourses->count())
                                    <div class="text-center py-2 border-top mt-2">
                                        <a href="{{ route('admin.catalog.courses', ['tab' => 'pending']) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                            View All {{ $pendingCoursesCount }} Pending Courses in Catalog &rarr;
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Services Tab -->
                        <div class="tab-pane fade" id="tab-services" role="tabpanel">
                            @if($pendingServices->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i>
                                    <strong>No pending services to review!</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Service</th>
                                                <th>Provider</th>
                                                <th>Pricing</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingServices as $psv)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $psv->title }}</div>
                                                        <small class="text-muted">{{ $psv->category }}</small>
                                                    </td>
                                                    <td>{{ $psv->seller?->businessDetail?->business_name ?? $psv->seller?->user?->name ?? 'Seller' }}</td>
                                                    <td class="fw-bold">₹{{ number_format($psv->price) }}</td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.services.approve', $psv->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.services.reject', $psv->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this service?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                                                                <i class="fa-solid fa-xmark me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <!-- Businesses Tab -->
                        <div class="tab-pane fade" id="tab-listings" role="tabpanel">
                            @if($pendingListings->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i>
                                    <strong>No pending business listings!</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Business Name</th>
                                                <th>Owner</th>
                                                <th>City</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingListings as $pl)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $pl->business_name }}</div>
                                                        <small class="text-muted">{{ $pl->category }}</small>
                                                    </td>
                                                    <td>{{ $pl->seller?->user?->name ?? 'Owner' }}</td>
                                                    <td>{{ $pl->city ?? 'N/A' }}</td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.listings.approve', $pl->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.listings.reject', $pl->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this business listing?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                                                                <i class="fa-solid fa-xmark me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(($pendingListingsCount ?? 0) > $pendingListings->count())
                                    <div class="text-center py-2 border-top mt-2">
                                        <a href="{{ route('admin.catalog.listings', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                            View All {{ $pendingListingsCount }} Pending Business Listings in Catalog &rarr;
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Products Tab -->
                        <div class="tab-pane fade" id="tab-products" role="tabpanel">
                            @if($pendingProducts->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i>
                                    <strong>No pending physical/digital products!</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Seller</th>
                                                <th>Price</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingProducts as $pp)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $pp->title }}</div>
                                                        <small class="text-muted">{{ $pp->category }}</small>
                                                    </td>
                                                    <td>{{ $pp->seller?->businessDetail?->business_name ?? $pp->seller?->user?->name ?? 'Seller' }}</td>
                                                    <td class="fw-bold">₹{{ number_format($pp->price) }}</td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.products.approve', $pp->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.products.reject', $pp->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this product?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                                                                <i class="fa-solid fa-xmark me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(($pendingProductsCount ?? 0) > $pendingProducts->count())
                                    <div class="text-center py-2 border-top mt-2">
                                        <a href="{{ route('admin.catalog.products', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                            View All {{ $pendingProductsCount }} Pending Products in Catalog &rarr;
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between">
                    <span class="text-muted small">
                        <i class="fa-solid fa-shield-halved text-primary me-1"></i>
                        Approvals take effect immediately across the marketplace.
                    </span>
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Helper: Format Rupee Currency
    function formatRupee(val) {
        if (val >= 100000) {
            return '₹' + (val / 100000).toFixed(1) + 'L';
        } else if (val >= 1000) {
            return '₹' + (val / 1000).toFixed(0) + 'k';
        }
        return '₹' + val;
    }

    // Ensure Chart.js is loaded
    function renderDashboardCharts() {
        if (typeof Chart === 'undefined') {
            console.warn('Chart.js library not ready yet, retrying in 200ms...');
            setTimeout(renderDashboardCharts, 200);
            return;
        }

        // =========================================================================
        // 1. REVENUE OVERVIEW CHART (Stacked Bars for Offerings + Smooth Line for Commission)
        // =========================================================================
        try {
            const ctxRev = document.getElementById('revenueOverviewChart');
            if (ctxRev) {
                new Chart(ctxRev, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            {
                                label: 'Courses',
                                data: {!! json_encode($chartCourses) !!},
                                backgroundColor: '#2563eb',
                                borderRadius: 4,
                                stack: 'offerings',
                            },
                            {
                                label: 'Services',
                                data: {!! json_encode($chartServices) !!},
                                backgroundColor: '#10b981',
                                borderRadius: 4,
                                stack: 'offerings',
                            },
                            {
                                label: 'Products',
                                data: {!! json_encode($chartProducts) !!},
                                backgroundColor: '#f59e0b',
                                borderRadius: 4,
                                stack: 'offerings',
                            },
                            {
                                label: 'Commission (15%)',
                                data: {!! json_encode($chartCommission) !!},
                                type: 'line',
                                borderColor: '#8b5cf6',
                                backgroundColor: '#8b5cf6',
                                borderWidth: 2.5,
                                pointRadius: 3,
                                pointHoverRadius: 6,
                                tension: 0.35,
                                fill: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 11 },
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.dataset.label + ': ₹' + Number(context.parsed.y).toLocaleString('en-IN');
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                grid: { display: false },
                                ticks: { font: { size: 10, family: 'Plus Jakarta Sans' }, color: '#94a3b8' }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9', borderDash: [3, 3] },
                                ticks: {
                                    font: { size: 10, family: 'Plus Jakarta Sans' },
                                    color: '#94a3b8',
                                    callback: function(val) {
                                        return formatRupee(val);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        } catch (errRev) {
            console.error('Failed to initialize Revenue Overview chart:', errRev);
        }

        // =========================================================================
        // 2. USERS & SELLERS GROWTH (Smooth Dual Curves with Soft Area Fill)
        // =========================================================================
        try {
            const ctxGrowth = document.getElementById('growthLineChart');
            if (ctxGrowth) {
                new Chart(ctxGrowth, {
                    type: 'line',
                    data: {
                        labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                        datasets: [
                            {
                                label: 'Users',
                                data: {!! json_encode($usersGrowthPoints) !!},
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                                borderWidth: 2.5,
                                pointRadius: 3.5,
                                pointBackgroundColor: '#2563eb',
                                tension: 0.35,
                                fill: true,
                            },
                            {
                                label: 'Sellers',
                                data: {!! json_encode($sellersGrowthPoints) !!},
                                borderColor: '#10b981',
                                backgroundColor: 'transparent',
                                borderWidth: 2.5,
                                pointRadius: 3.5,
                                pointBackgroundColor: '#10b981',
                                tension: 0.35,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 11 },
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.dataset.label + ': ' + Number(context.parsed.y).toLocaleString('en-IN');
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 10, family: 'Plus Jakarta Sans' }, color: '#94a3b8' }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9', borderDash: [3, 3] },
                                ticks: {
                                    font: { size: 10, family: 'Plus Jakarta Sans' },
                                    color: '#94a3b8',
                                    callback: function(val) {
                                        if (val >= 1000) return (val / 1000).toFixed(0) + 'k';
                                        return val;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        } catch (errGrowth) {
            console.error('Failed to initialize Growth Line chart:', errGrowth);
        }
    }

    // Launch chart rendering
    renderDashboardCharts();

    // =========================================================================
    // 3. RECENT USERS FILTER & SEARCH INTERACTIVITY
    // =========================================================================
    const userSearchInput = document.getElementById('dashboardUserSearchInput');
    const filterButtons = document.querySelectorAll('.user-filter-btn');
    const userRows = document.querySelectorAll('.dashboard-user-row');

    let currentFilter = 'all';

    function applyUserFiltering() {
        const query = (userSearchInput ? userSearchInput.value : '').toLowerCase().trim();

        userRows.forEach(row => {
            const categories = (row.getAttribute('data-category') || '').split(' ');
            const searchData = (row.getAttribute('data-search') || '').toLowerCase();

            const matchesCategory = (currentFilter === 'all') || categories.includes(currentFilter);
            const matchesSearch = !query || searchData.includes(query);

            if (matchesCategory && matchesSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (userSearchInput) {
        userSearchInput.addEventListener('input', applyUserFiltering);
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-light', 'text-secondary');
            });
            this.classList.remove('btn-light', 'text-secondary');
            this.classList.add('btn-primary', 'active');

            currentFilter = this.getAttribute('data-filter') || 'all';
            applyUserFiltering();
        });
    });

    // =========================================================================
    // 4. PENDING APPROVALS CENTRAL: KEEP MODAL OPEN ON APPROVE/REJECT
    //    The modal only closes when the admin explicitly clicks Close or X!
    // =========================================================================
    const pendingModalEl = document.getElementById('pendingRequestsModal');
    if (pendingModalEl) {
        pendingModalEl.addEventListener('submit', async function(e) {
            const form = e.target.closest('form');
            if (!form) return;

            e.preventDefault();

            const isApprove = form.action.includes('approve');
            const submitBtn = form.querySelector('button[type="submit"]') || e.submitter;
            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
            const row = form.closest('tr');
            const tabPane = form.closest('.tab-pane');
            const tabId = tabPane ? tabPane.id : null;

            // Disable buttons in this row to prevent duplicate clicks
            if (row) {
                row.querySelectorAll('button').forEach(btn => btn.disabled = true);
            }
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            }

            try {
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token') || '';

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    let result = null;
                    try {
                        result = await response.json();
                    } catch (parseErr) {
                        result = { success: true };
                    }

                    // Visual badge in action column
                    if (row) {
                        const actionCol = row.querySelector('td:last-child');
                        if (actionCol) {
                            actionCol.innerHTML = isApprove
                                ? '<span class="badge bg-success-subtle text-success py-1.5 px-2.5 rounded-pill fw-bold" style="font-size: 0.75rem;"><i class="fa-solid fa-check me-1"></i> Approved</span>'
                                : '<span class="badge bg-danger-subtle text-danger py-1.5 px-2.5 rounded-pill fw-bold" style="font-size: 0.75rem;"><i class="fa-solid fa-xmark me-1"></i> Rejected</span>';
                        }

                        // Smoothly fade out and remove row
                        row.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        setTimeout(() => {
                            row.style.opacity = '0';
                            row.style.transform = 'scale(0.96)';
                            setTimeout(() => {
                                row.remove();
                                if (tabPane) {
                                    const remainingRows = tabPane.querySelectorAll('tbody tr');
                                    if (remainingRows.length === 0) {
                                        const tableWrap = tabPane.querySelector('.table-responsive');
                                        if (tableWrap) {
                                            tableWrap.innerHTML = '<div class="text-center py-5 text-muted"><i class="fa-regular fa-circle-check fs-2 text-success mb-2 d-block"></i><strong>All pending items in this section reviewed!</strong></div>';
                                        }
                                    }
                                }
                            }, 350);
                        }, 600);
                    }

                    // Decrement current Tab count (e.g. Sellers (393) -> Sellers (392))
                    if (tabId) {
                        const tabBtn = document.querySelector(`[data-bs-target="#${tabId}"]`);
                        if (tabBtn) {
                            const countMatch = tabBtn.innerHTML.match(/\((\d+)\)/);
                            if (countMatch) {
                                const currentCount = parseInt(countMatch[1]);
                                const newCount = Math.max(0, currentCount - 1);
                                tabBtn.innerHTML = tabBtn.innerHTML.replace(/\(\d+\)/, `(${newCount})`);
                            }
                        }
                    }

                    // Decrement Modal Title Total Pending Badge (e.g. 840 Pending -> 839 Pending)
                    const modalTotalBadge = pendingModalEl.querySelector('.modal-title .badge');
                    if (modalTotalBadge) {
                        const totalMatch = modalTotalBadge.textContent.match(/(\d+)/);
                        if (totalMatch) {
                            const newTotal = Math.max(0, parseInt(totalMatch[1]) - 1);
                            modalTotalBadge.textContent = `${newTotal} Pending`;
                        }
                    }

                    // Decrement Top Navbar Pending Requests Badge
                    const navBadges = document.querySelectorAll('#navPendingApprovalsBadge, [title*="Pending Approvals"] .badge, [title*="Pending Requests"] .badge');
                    navBadges.forEach(nb => {
                        const val = parseInt(nb.textContent.trim());
                        if (!isNaN(val)) {
                            nb.textContent = Math.max(0, val - 1);
                        }
                    });

                    // In-modal non-intrusive feedback alert
                    const feedbackEl = document.getElementById('pendingModalFeedback');
                    if (feedbackEl) {
                        feedbackEl.className = `alert alert-${isApprove ? 'success' : 'warning'} alert-dismissible fade show py-2 px-3 small mb-3 rounded-3 d-flex align-items-center justify-content-between`;
                        feedbackEl.innerHTML = `
                            <div>
                                <i class="fa-solid fa-${isApprove ? 'circle-check text-success' : 'circle-exclamation text-warning'} me-2"></i>
                                <span>${result && result.message ? result.message : (isApprove ? 'Item approved successfully!' : 'Item rejected.')}</span>
                            </div>
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        feedbackEl.classList.remove('d-none');
                        setTimeout(() => {
                            if (feedbackEl) feedbackEl.classList.add('d-none');
                        }, 4000);
                    }

                } else {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHtml;
                    }
                    if (row) {
                        row.querySelectorAll('button').forEach(btn => btn.disabled = false);
                    }
                    alert('Action could not be completed. Please try again.');
                }
            } catch (err) {
                console.error('Pending action submission failed:', err);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                }
                if (row) {
                    row.querySelectorAll('button').forEach(btn => btn.disabled = false);
                }
            }
        });
    }

    if (window.location.hash === '#pendingRequestsModal') {
        const modalEl = document.getElementById('pendingRequestsModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
});
</script>
@endsection
