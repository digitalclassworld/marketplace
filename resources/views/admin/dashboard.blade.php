@extends('admin.layouts.admin')

@section('title', 'Super Admin Overview - Digital Class Educational World')

@section('styles')
<style>
    /* Metric Cards (12 Cards in 6-column layout) */
    .metric-grid-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        transition: transform 0.15s, box-shadow 0.15s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .metric-grid-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    .metric-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .kpi-title {
        font-size: 0.725rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 2px;
        white-space: nowrap;
    }

    .kpi-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .kpi-growth-pill {
        font-size: 0.65rem;
        font-weight: 700;
        border-radius: 999px;
        padding: 0.15rem 0.45rem;
        display: inline-flex;
        align-items: center;
        margin-left: 0.35rem;
    }

    .kpi-subtext {
        font-size: 0.68rem;
        color: #94a3b8;
        margin-top: 4px;
        white-space: nowrap;
    }

    /* Quick Action Button Tile */
    .quick-action-tile {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.35rem;
        text-align: center;
        text-decoration: none;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
        height: 100%;
    }
    .quick-action-tile:hover {
        background: #ffffff;
        border-color: #0066ff;
        color: #0066ff;
        box-shadow: 0 2px 8px rgba(0, 102, 255, 0.15);
        transform: translateY(-2px);
    }
    .quick-action-tile i {
        font-size: 1.15rem;
    }
    .quick-action-tile span {
        font-size: 0.68rem;
        font-weight: 600;
        line-height: 1.2;
        color: inherit;
    }

    /* Grow Platform Promo Box */
    .grow-platform-box {
        background: radial-gradient(circle at 100% 0%, #e0e7ff 0%, #ede9fe 60%, #ffffff 100%);
        border: 1px solid #c7d2fe;
        border-radius: 14px;
        padding: 1.15rem;
        position: relative;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Greeting Section with Pending Approvals CTA Button -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.65rem; letter-spacing: -0.02em;">
                Welcome Back, {{ explode(' ', Auth::user()->name ?? 'Super Admin')[0] }} 👋
            </h2>
            <p class="text-secondary small mb-0">Here's what's happening on Digital Class Marketplace today.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- PENDING REQUESTS BUTTON -->
            <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2 shadow-sm d-flex align-items-center gap-2 position-relative" data-bs-toggle="modal" data-bs-target="#pendingRequestsModal" style="border-radius: 10px; border: 1px solid #f59e0b; background: linear-gradient(135deg, #fef08a 0%, #fde047 100%);">
                <i class="fa-solid fa-clock-rotate-left fs-6 text-dark"></i>
                <span style="font-size: 0.85rem;">Pending Requests</span>
                <span class="badge bg-danger text-white rounded-pill px-2 py-1" style="font-size: 0.72rem;">
                    {{ $totalPendingCount }}
                </span>
            </button>
        </div>
    </div>

    <!-- ================= 12 KPI METRICS (2 ROWS OF 6 CARDS) ================= -->
    <!-- Row 1: Users, Sellers, Courses, Services, Products, Business Listings -->
    <div class="row g-2 mb-2">
        <!-- 1. Total Users -->
        <div class="col-xl-2 col-md-4 col-6">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none d-block">
                <div class="metric-grid-card">
                    <div class="d-flex align-items-center gap-2">
                        <div class="metric-icon-box" style="background: rgba(0, 102, 255, 0.1); color: #0066ff;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <div class="kpi-title">Total Users</div>
                            <div class="d-flex align-items-center">
                                <span class="kpi-value">{{ $kpis['total_users'] }}</span>
                                <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['users_growth'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-subtext">{{ $kpis['users_sub'] }}</div>
                </div>
            </a>
        </div>

        <!-- 2. Total Sellers -->
        <div class="col-xl-2 col-md-4 col-6">
            <a href="{{ route('admin.sellers.index') }}" class="text-decoration-none d-block">
                <div class="metric-grid-card">
                    <div class="d-flex align-items-center gap-2">
                        <div class="metric-icon-box" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div>
                            <div class="kpi-title">Total Sellers</div>
                            <div class="d-flex align-items-center">
                                <span class="kpi-value">{{ $kpis['total_sellers'] }}</span>
                                <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['sellers_growth'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-subtext">{{ $kpis['sellers_sub'] }}</div>
                </div>
            </a>
        </div>

        <!-- 3. Total Courses -->
        <div class="col-xl-2 col-md-4 col-6">
            <a href="{{ route('admin.catalog.courses') }}" class="text-decoration-none d-block">
                <div class="metric-grid-card">
                    <div class="d-flex align-items-center gap-2">
                        <div class="metric-icon-box" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="kpi-title">Total Courses</div>
                            <div class="d-flex align-items-center">
                                <span class="kpi-value">{{ $kpis['total_courses'] }}</span>
                                <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['courses_growth'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-subtext">{{ $kpis['courses_sub'] }}</div>
                </div>
            </a>
        </div>

        <!-- 4. Total Services -->
        <div class="col-xl-2 col-md-4 col-6">
            <a href="{{ route('admin.catalog.services') }}" class="text-decoration-none d-block">
                <div class="metric-grid-card">
                    <div class="d-flex align-items-center gap-2">
                        <div class="metric-icon-box" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <div class="kpi-title">Total Services</div>
                            <div class="d-flex align-items-center">
                                <span class="kpi-value">{{ $kpis['total_services'] }}</span>
                                <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['services_growth'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-subtext">{{ $kpis['services_sub'] }}</div>
                </div>
            </a>
        </div>

        <!-- 5. Total Products -->
        <div class="col-xl-2 col-md-4 col-6">
            <a href="{{ route('admin.catalog.products') }}" class="text-decoration-none d-block">
                <div class="metric-grid-card">
                    <div class="d-flex align-items-center gap-2">
                        <div class="metric-icon-box" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <div class="kpi-title">Total Products</div>
                            <div class="d-flex align-items-center">
                                <span class="kpi-value">{{ $kpis['total_products'] }}</span>
                                <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['products_growth'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-subtext">{{ $kpis['products_sub'] }}</div>
                </div>
            </a>
        </div>

        <!-- 6. Business Listings -->
        <div class="col-xl-2 col-md-4 col-6">
            <a href="{{ route('admin.catalog.listings') }}" class="text-decoration-none d-block">
                <div class="metric-grid-card">
                    <div class="d-flex align-items-center gap-2">
                        <div class="metric-icon-box" style="background: rgba(234, 179, 8, 0.1); color: #eab308;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div>
                            <div class="kpi-title">Business Listings</div>
                            <div class="d-flex align-items-center">
                                <span class="kpi-value">{{ $kpis['business_listings'] }}</span>
                                <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['listings_growth'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="kpi-subtext">{{ $kpis['listings_sub'] }}</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Row 2: Total Orders, Revenue, Payout Due, New Leads, App Downloads, Rating -->
    <div class="row g-2 mb-4">
        <!-- 7. Total Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="metric-grid-card">
                <div class="d-flex align-items-center gap-2">
                    <div class="metric-icon-box" style="background: rgba(0, 102, 255, 0.1); color: #0066ff;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <div class="kpi-title">Total Orders</div>
                        <div class="d-flex align-items-center">
                            <span class="kpi-value">{{ $kpis['total_orders'] }}</span>
                            <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['orders_growth'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="kpi-subtext">{{ $kpis['orders_sub'] }}</div>
            </div>
        </div>

        <!-- 8. Total Revenue -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="metric-grid-card">
                <div class="d-flex align-items-center gap-2">
                    <div class="metric-icon-box" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <div>
                        <div class="kpi-title">Total Revenue</div>
                        <div class="d-flex align-items-center">
                            <span class="kpi-value">{{ $kpis['total_revenue'] }}</span>
                            <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['revenue_growth'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="kpi-subtext">{{ $kpis['revenue_sub'] }}</div>
            </div>
        </div>

        <!-- 9. Payout Due to Sellers -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="metric-grid-card">
                <div class="d-flex align-items-center gap-2">
                    <div class="metric-icon-box" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="kpi-title">Payout Due to Sellers</div>
                        <div class="d-flex align-items-center">
                            <span class="kpi-value">{{ $kpis['payout_due'] }}</span>
                            <span class="kpi-growth-pill bg-danger-subtle text-danger">{{ $kpis['payout_growth'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="kpi-subtext">{{ $kpis['payout_sub'] }}</div>
            </div>
        </div>

        <!-- 10. New Leads -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="metric-grid-card">
                <div class="d-flex align-items-center gap-2">
                    <div class="metric-icon-box" style="background: rgba(0, 102, 255, 0.1); color: #0066ff;">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div>
                        <div class="kpi-title">New Leads</div>
                        <div class="d-flex align-items-center">
                            <span class="kpi-value">{{ $kpis['new_leads'] }}</span>
                            <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['leads_growth'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="kpi-subtext">{{ $kpis['leads_sub'] }}</div>
            </div>
        </div>

        <!-- 11. App Downloads -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="metric-grid-card">
                <div class="d-flex align-items-center gap-2">
                    <div class="metric-icon-box" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div>
                        <div class="kpi-title">App Downloads</div>
                        <div class="d-flex align-items-center">
                            <span class="kpi-value">{{ $kpis['app_downloads'] }}</span>
                            <span class="kpi-growth-pill bg-success-subtle text-success">{{ $kpis['downloads_growth'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="kpi-subtext">{{ $kpis['downloads_sub'] }}</div>
            </div>
        </div>

        <!-- 12. Average Rating -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="metric-grid-card">
                <div class="d-flex align-items-center gap-2">
                    <div class="metric-icon-box" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <div class="kpi-title">Average Rating</div>
                        <div class="d-flex align-items-center">
                            <span class="kpi-value">{{ $kpis['average_rating'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="kpi-subtext">{{ $kpis['rating_sub'] }}</div>
            </div>
        </div>
    </div>

    <!-- ================= MIDDLE ROW: REVENUE CHART, GROWTH CHART, QUICK ACTIONS ================= -->
    <div class="row g-3 mb-4">
        <!-- 1. Revenue Overview (Stacked Bar + Commission Line) -->
        <div class="col-xl-5 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Revenue Overview</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border py-1 px-2 text-secondary small dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Last 12 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end small">
                            <li><a class="dropdown-item active" href="#">Last 12 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">This Year (2026)</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Legends matching screenshot -->
                <div class="d-flex align-items-center gap-3 mb-2 small" style="font-size: 0.75rem;">
                    <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background: #0066ff;"></span> Courses</span>
                    <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background: #10b981;"></span> Services</span>
                    <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background: #f59e0b;"></span> Products</span>
                    <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background: #8b5cf6;"></span> Commission</span>
                </div>

                <div class="flex-grow-1 position-relative" style="min-height: 230px;">
                    <canvas id="revenueOverviewChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 2. Users & Sellers Growth (Dual Line Chart) -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Users & Sellers Growth</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border py-1 px-2 text-secondary small dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Last 6 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end small">
                            <li><a class="dropdown-item active" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Legends matching screenshot -->
                <div class="d-flex align-items-center gap-3 mb-2 small" style="font-size: 0.75rem;">
                    <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background: #0066ff;"></span> Users</span>
                    <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background: #10b981;"></span> Sellers</span>
                </div>

                <div class="flex-grow-1 position-relative" style="min-height: 230px;">
                    <canvas id="growthLineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 3. Quick Actions & Grow Platform Widget -->
        <div class="col-xl-3 col-lg-12">
            <div class="d-flex flex-column gap-3 h-100">
                <!-- Quick Actions Grid (8 items in 4x2) -->
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Quick Actions</h6>
                        <a href="{{ route('admin.sellers.index') }}" class="small text-primary text-decoration-none fw-semibold">Manage</a>
                    </div>
                    <div class="row g-2">
                        <!-- Add Seller -->
                        <div class="col-3">
                            <a href="{{ route('admin.sellers.pending') }}" class="quick-action-tile">
                                <i class="fa-solid fa-store text-primary"></i>
                                <span>Add Seller</span>
                            </a>
                        </div>
                        <!-- Add Course -->
                        <div class="col-3">
                            <a href="{{ route('admin.catalog.courses') }}" class="quick-action-tile">
                                <i class="fa-solid fa-graduation-cap text-purple" style="color: #8b5cf6;"></i>
                                <span>Add Course</span>
                            </a>
                        </div>
                        <!-- Add Service -->
                        <div class="col-3">
                            <a href="{{ route('admin.catalog.services') }}" class="quick-action-tile">
                                <i class="fa-solid fa-briefcase text-warning"></i>
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
                                <i class="fa-solid fa-building text-warning"></i>
                                <span>Add Business</span>
                            </a>
                        </div>
                        <!-- Send Notification -->
                        <div class="col-3">
                            <a href="#" class="quick-action-tile" onclick="alert('Notification composer opened.'); return false;">
                                <i class="fa-solid fa-bell text-success"></i>
                                <span>Send Notification</span>
                            </a>
                        </div>
                        <!-- Create Banner -->
                        <div class="col-3">
                            <a href="{{ route('admin.promotions.index') }}" class="quick-action-tile">
                                <i class="fa-solid fa-image text-info"></i>
                                <span>Create Banner</span>
                            </a>
                        </div>
                        <!-- Generate Report -->
                        <div class="col-3">
                            <a href="#" class="quick-action-tile" onclick="alert('Generating comprehensive platform report...'); return false;">
                                <i class="fa-solid fa-chart-simple text-success"></i>
                                <span>Generate Report</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Grow Your Platform Card (Matching Screenshot Rocket) -->
                <div class="grow-platform-box flex-grow-1 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <h6 class="fw-bold text-dark mb-0">Grow Your Platform</h6>
                            <span class="fs-4">🚀</span>
                        </div>
                        <p class="text-secondary small mb-3" style="font-size: 0.75rem; line-height: 1.35;">
                            Run promotions, launch campaigns and get more sellers & users on Digital Class.
                        </p>
                    </div>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-dark btn-sm rounded-3 fw-bold w-100 py-1.5" style="background: #0f172a;">
                        Create Campaign &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= BOTTOM ROW: RECENT ORDERS, RECENT SELLERS, RECENT ACTIVITIES ================= -->
    <div class="row g-3">
        <!-- 1. Recent Orders -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Recent Orders</h6>
                    <a href="{{ route('admin.coming-soon', 'orders') }}" class="small text-primary text-decoration-none fw-semibold">View All &rarr;</a>
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
                            @foreach($recentOrders as $order)
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
                            @endforeach
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
                                <th>Joined On</th>
                                <th class="text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSellers as $seller)
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
                            @endforeach
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
                    <a href="#" class="small text-primary text-decoration-none fw-semibold" onclick="alert('All system logs: 12,850 events logged.'); return false;">View All &rarr;</a>
                </div>
                <div class="d-flex flex-column gap-3">
                    @foreach($recentActivities as $act)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         PENDING APPROVALS CENTRAL MODAL (Pop-Up)
         ========================================================================= -->
    <div class="modal fade" id="pendingRequestsModal" tabindex="-1" aria-labelledby="pendingRequestsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom py-3 px-4" style="background: #f8fafc;">
                    <div>
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2 mb-1" id="pendingRequestsModalLabel">
                            <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                            Pending Approvals Central
                            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                {{ $totalPendingCount }} Pending Requests
                            </span>
                        </h5>
                        <p class="text-muted small mb-0">Review and approve or reject incoming sellers, courses, services, businesses, and products before publication.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Nav Pills Tabs -->
                    <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="pendingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold small px-3 py-2 d-flex align-items-center gap-2" id="sellers-tab" data-bs-toggle="pill" data-bs-target="#tab-sellers" type="button" role="tab">
                                <i class="fa-solid fa-store text-primary"></i>
                                <span>Sellers</span>
                                <span class="badge {{ $pendingSellers->count() > 0 ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                    {{ $pendingSellers->count() }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold small px-3 py-2 d-flex align-items-center gap-2" id="courses-tab" data-bs-toggle="pill" data-bs-target="#tab-courses" type="button" role="tab">
                                <i class="fa-solid fa-graduation-cap text-purple"></i>
                                <span>Courses</span>
                                <span class="badge {{ $pendingCourses->count() > 0 ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                    {{ $pendingCourses->count() }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold small px-3 py-2 d-flex align-items-center gap-2" id="services-tab" data-bs-toggle="pill" data-bs-target="#tab-services" type="button" role="tab">
                                <i class="fa-solid fa-briefcase text-warning"></i>
                                <span>Services</span>
                                <span class="badge {{ $pendingServices->count() > 0 ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                    {{ $pendingServices->count() }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold small px-3 py-2 d-flex align-items-center gap-2" id="listings-tab" data-bs-toggle="pill" data-bs-target="#tab-listings" type="button" role="tab">
                                <i class="fa-solid fa-building text-info"></i>
                                <span>Business Listings</span>
                                <span class="badge {{ $pendingListings->count() > 0 ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                    {{ $pendingListings->count() }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold small px-3 py-2 d-flex align-items-center gap-2" id="products-tab" data-bs-toggle="pill" data-bs-target="#tab-products" type="button" role="tab">
                                <i class="fa-solid fa-box-open text-success"></i>
                                <span>Products</span>
                                <span class="badge {{ $pendingProducts->count() > 0 ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                    {{ $pendingProducts->count() }}
                                </span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Contents -->
                    <div class="tab-content" id="pendingTabsContent">
                        
                        <!-- ================= 1. SELLERS ================= -->
                        <div class="tab-pane fade show active" id="tab-sellers" role="tabpanel">
                            @if($pendingSellers->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fa-solid fa-circle-check text-success fs-1 mb-2"></i>
                                    <h6 class="fw-bold text-dark">No Pending Seller Applications</h6>
                                    <p class="text-muted small">All seller registrations have been approved and activated.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Seller / Applicant</th>
                                                <th>Business Name</th>
                                                <th>Contact Details</th>
                                                <th>Account Type</th>
                                                <th>Applied On</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingSellers as $ps)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="{{ $ps->user?->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($ps->user?->name ?? 'Seller') }}" 
                                                                 class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                            <div>
                                                                <div class="fw-bold text-dark">{{ $ps->user?->name ?? 'Seller #' . $ps->id }}</div>
                                                                <small class="text-muted font-monospace">{{ $ps->seller_code }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold text-dark">{{ $ps->businessDetail?->business_name ?? '—' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="text-dark">{{ $ps->user?->email }}</div>
                                                        <small class="text-muted">{{ $ps->user?->phone ?? '—' }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">{{ $ps->account_type }}</span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $ps->created_at ? $ps->created_at->format('d M Y, h:i A') : 'Recent' }}</small>
                                                    </td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.sellers.approve', $ps->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold" title="Approve Seller">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.sellers.reject', $ps->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this seller application?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Reject Seller">
                                                                <i class="fa-solid fa-xmark me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('admin.sellers.show', $ps->id) }}" class="btn btn-light border btn-sm px-2 py-1 ms-1" title="View Profile">
                                                            <i class="fa-regular fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <!-- ================= 2. COURSES ================= -->
                        <div class="tab-pane fade" id="tab-courses" role="tabpanel">
                            @if($pendingCourses->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fa-solid fa-circle-check text-success fs-1 mb-2"></i>
                                    <h6 class="fw-bold text-dark">No Pending Courses</h6>
                                    <p class="text-muted small">All courses are currently reviewed and published.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Instructor / Seller</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Submitted</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingCourses as $pc)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="{{ $pc->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=80&auto=format&fit=crop&q=80' }}" 
                                                                 class="rounded border" style="width: 44px; height: 32px; object-fit: cover;">
                                                            <div>
                                                                <div class="fw-bold text-dark">{{ $pc->title }}</div>
                                                                <small class="text-muted">{{ $pc->level }} &bull; {{ $pc->language }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-dark fw-semibold">{{ $pc->seller?->businessDetail?->business_name ?? $pc->seller?->user?->name ?? 'Seller' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-primary border">{{ $pc->category }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-dark">₹{{ number_format($pc->price) }}</span>
                                                        @if($pc->discount_price)
                                                            <small class="text-muted text-decoration-line-through d-block">₹{{ number_format($pc->discount_price) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $pc->created_at ? $pc->created_at->format('d M Y') : 'Recent' }}</small>
                                                    </td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.courses.approve', $pc->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold" title="Approve & Publish">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.courses.reject', $pc->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this course?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Reject Course">
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

                        <!-- ================= 3. SERVICES ================= -->
                        <div class="tab-pane fade" id="tab-services" role="tabpanel">
                            @if($pendingServices->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fa-solid fa-circle-check text-success fs-1 mb-2"></i>
                                    <h6 class="fw-bold text-dark">No Pending Services</h6>
                                    <p class="text-muted small">All services have been reviewed.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Service Title</th>
                                                <th>Provider / Seller</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Delivery</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingServices as $psv)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">{{ $psv->title }}</div>
                                                        <small class="text-muted">{{ Str::limit($psv->short_description, 50) }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="text-dark fw-semibold">{{ $psv->seller?->businessDetail?->business_name ?? $psv->seller?->user?->name ?? 'Provider' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-warning border">{{ $psv->category }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-dark">₹{{ number_format($psv->price) }}</span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $psv->delivery_days }} days</small>
                                                    </td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.services.approve', $psv->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold" title="Approve Service">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.services.reject', $psv->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this service?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Reject Service">
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

                        <!-- ================= 4. BUSINESS LISTINGS ================= -->
                        <div class="tab-pane fade" id="tab-listings" role="tabpanel">
                            @if($pendingListings->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fa-solid fa-circle-check text-success fs-1 mb-2"></i>
                                    <h6 class="fw-bold text-dark">No Pending Business Listings</h6>
                                    <p class="text-muted small">All business directory listings have been approved.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Business Name</th>
                                                <th>Category</th>
                                                <th>City & Location</th>
                                                <th>Contact</th>
                                                <th>Plan</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingListings as $pl)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if($pl->logo)
                                                                <img src="{{ $pl->logo }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;">
                                                            @endif
                                                            <div>
                                                                <div class="fw-bold text-dark">{{ $pl->business_name }}</div>
                                                                <small class="text-muted">{{ $pl->sub_category ?: $pl->category }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">{{ $pl->category }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-dark">{{ $pl->city ?? 'Ahmedabad' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="text-dark small">{{ $pl->phone }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary-subtle text-primary">{{ $pl->plan_name ?: 'Free' }}</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.listings.approve', $pl->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold" title="Approve Listing">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.listings.reject', $pl->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this business listing?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Reject Listing">
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

                        <!-- ================= 5. PRODUCTS ================= -->
                        <div class="tab-pane fade" id="tab-products" role="tabpanel">
                            @if($pendingProducts->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fa-solid fa-circle-check text-success fs-1 mb-2"></i>
                                    <h6 class="fw-bold text-dark">No Pending Products</h6>
                                    <p class="text-muted small">All products have been reviewed and published.</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product Title</th>
                                                <th>Seller</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingProducts as $pp)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">{{ $pp->title }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="text-dark">{{ $pp->seller?->businessDetail?->business_name ?? $pp->seller?->user?->name ?? 'Seller' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-success border">{{ $pp->category }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-dark">₹{{ number_format($pp->price) }}</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <form action="{{ route('admin.catalog.products.approve', $pp->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 fw-bold" title="Approve Product">
                                                                <i class="fa-solid fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.catalog.products.reject', $pp->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Reject this product?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Reject Product">
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
    // 1. Revenue Overview Chart (Stacked Bar + Commission Spline Line)
    const ctxRevenue = document.getElementById('revenueOverviewChart');
    if (ctxRevenue) {
        new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Courses',
                        data: {!! json_encode($chartCourses) !!},
                        backgroundColor: '#0066ff',
                        borderRadius: 4,
                        stack: 'combined',
                    },
                    {
                        label: 'Services',
                        data: {!! json_encode($chartServices) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 4,
                        stack: 'combined',
                    },
                    {
                        label: 'Products',
                        data: {!! json_encode($chartProducts) !!},
                        backgroundColor: '#f59e0b',
                        borderRadius: 4,
                        stack: 'combined',
                    },
                    {
                        label: 'Commission',
                        data: {!! json_encode($chartCommission) !!},
                        type: 'line',
                        borderColor: '#8b5cf6',
                        backgroundColor: '#8b5cf6',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        tension: 0.35,
                        fill: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ₹' + (context.parsed.y * 100000).toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        max: 10,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { size: 10 },
                            color: '#94a3b8',
                            callback: function(val) {
                                return '₹' + val + 'L';
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Users & Sellers Growth Line Chart
    const ctxGrowth = document.getElementById('growthLineChart');
    if (ctxGrowth) {
        new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [
                    {
                        label: 'Users',
                        data: {!! json_encode($usersGrowthPoints) !!},
                        borderColor: '#0066ff',
                        backgroundColor: 'rgba(0, 102, 255, 0.05)',
                        borderWidth: 2.5,
                        pointRadius: 3.5,
                        pointBackgroundColor: '#0066ff',
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
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        max: 150000,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { size: 10 },
                            color: '#94a3b8',
                            callback: function(val) {
                                if (val >= 1000) return (val / 1000) + 'K';
                                return val;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
