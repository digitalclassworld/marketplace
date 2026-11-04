@extends('seller.layouts.seller')

@section('title', 'Orders Management - Seller Dashboard')

@section('styles')
<style>
    .display-heading {
        font-family: var(--dc-font-heading);
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    /* Metric Cards */
    .dc-order-stat-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 1.25rem 1.4rem;
        transition: all 0.2s ease;
    }
    .dc-order-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -10px rgba(0, 0, 0, 0.08);
    }
    .dc-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Tabs Styling */
    .dc-tab-btn {
        padding: 0.75rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }
    .dc-tab-btn:hover {
        color: #0066ff;
    }
    .dc-tab-btn.active {
        color: #0066ff;
        border-bottom-color: #0066ff;
    }

    /* Status Pill Badges */
    .badge-status {
        font-size: 0.725rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
    }
    .badge-status-completed {
        background-color: #dcfce7;
        color: #16a34a;
    }
    .badge-status-in_progress {
        background-color: #fef3c7;
        color: #d97706;
    }
    .badge-status-shipped {
        background-color: #e0f2fe;
        color: #0284c7;
    }
    .badge-status-processing {
        background-color: #f3e8ff;
        color: #9333ea;
    }
    .badge-status-cancelled {
        background-color: #ffe4e6;
        color: #e11d48;
    }
    .badge-status-delivered {
        background-color: #ccfbf1;
        color: #0d9488;
    }

    /* Type Pill Badges */
    .badge-type-course {
        background-color: #ffe4e6;
        color: #e11d48;
    }
    .badge-type-service {
        background-color: #e0f2fe;
        color: #0284c7;
    }
    .badge-type-product {
        background-color: #dcfce7;
        color: #16a34a;
    }
    .badge-type-business {
        background-color: #f3e8ff;
        color: #9333ea;
    }

    /* Orders Table */
    .dc-table th {
        font-size: 0.725rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 700;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #edf2f7;
        background-color: #f8fafc;
    }
    .dc-table td {
        padding: 0.95rem 1rem;
        font-size: 0.85rem;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .dc-table tr:hover td {
        background-color: #fcfdfe;
    }
    .dc-table tr.selected-row td {
        background-color: #f0f7ff;
    }

    /* Right Order Details Drawer Panel */
    .dc-order-drawer {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 20px;
        padding: 1.5rem;
        height: 100%;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 85px;
    }

    /* Timeline Stepper */
    .dc-timeline {
        position: relative;
        padding-left: 1.75rem;
    }
    .dc-timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background-color: #22c55e;
    }
    .dc-timeline-step {
        position: relative;
        margin-bottom: 1.15rem;
    }
    .dc-timeline-step:last-child {
        margin-bottom: 0;
    }
    .dc-timeline-dot {
        position: absolute;
        left: -1.75rem;
        top: 0;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #22c55e;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
    }

    .font-mono-code {
        font-family: var(--dc-font-mono) !important;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Header & Download Report -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="display-heading fw-bold text-dark mb-1" style="font-size: 1.65rem;">
                Orders
            </h2>
            <p class="text-muted mb-0 small" style="font-size: 0.875rem;">
                Manage all your course, service, product and business orders in one place.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Simulate Customer Purchase Button -->
            <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2 fw-semibold px-3 py-2 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#simulateOrderModal" style="font-size: 0.85rem;">
                <i class="fa-solid fa-bolt-lightning text-warning"></i>
                <span>Simulate Customer Purchase</span>
            </button>
            <a href="{{ route('seller.orders.export') }}" class="btn btn-primary d-flex align-items-center gap-2 fw-semibold px-3 py-2 shadow-sm rounded-3" style="background-color: #0066ff; border-color: #0066ff; font-size: 0.85rem;">
                <i class="fa-solid fa-download"></i>
                <span>Download Report</span>
            </a>
        </div>
    </div>

    <!-- ================= 4 METRIC STAT CARDS ================= -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Orders -->
        <div class="col-xl-3 col-sm-6">
            <div class="dc-order-stat-card h-100">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dc-stat-icon" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Total Orders</span>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                        {{ $stats['total_orders'] }}
                    </h3>
                    <span class="badge rounded-pill fw-semibold" style="background: #dcfce7; color: #16a34a; font-size: 0.725rem;">
                        <i class="fa-solid fa-arrow-up me-1"></i>18%
                    </span>
                </div>
                <span class="text-muted small" style="font-size: 0.75rem;">Last 30 days</span>
            </div>
        </div>

        <!-- 2. Total Revenue -->
        <div class="col-xl-3 col-sm-6">
            <div class="dc-order-stat-card h-100">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dc-stat-icon" style="background: #dcfce7; color: #16a34a;">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <div>
                        <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Total Revenue</span>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                        ₹{{ number_format($stats['total_revenue']) }}
                    </h3>
                    <span class="badge rounded-pill fw-semibold" style="background: #dcfce7; color: #16a34a; font-size: 0.725rem;">
                        <i class="fa-solid fa-arrow-up me-1"></i>26%
                    </span>
                </div>
                <span class="text-muted small" style="font-size: 0.75rem;">Last 30 days</span>
            </div>
        </div>

        <!-- 3. Pending Orders -->
        <div class="col-xl-3 col-sm-6">
            <div class="dc-order-stat-card h-100">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dc-stat-icon" style="background: #ffedd5; color: #ea580c;">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Pending Orders</span>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                        {{ $stats['pending_orders'] }}
                    </h3>
                </div>
                <span class="text-muted small" style="font-size: 0.75rem;">Last 30 days</span>
            </div>
        </div>

        <!-- 4. Completed Orders -->
        <div class="col-xl-3 col-sm-6">
            <div class="dc-order-stat-card h-100">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dc-stat-icon" style="background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Completed Orders</span>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                        {{ $stats['completed_orders'] }}
                    </h3>
                    <span class="badge rounded-pill fw-semibold" style="background: #dcfce7; color: #16a34a; font-size: 0.725rem;">
                        <i class="fa-solid fa-arrow-up me-1"></i>32%
                    </span>
                </div>
                <span class="text-muted small" style="font-size: 0.75rem;">Last 30 days</span>
            </div>
        </div>
    </div>

    <!-- ================= MAIN TWO-COLUMN LAYOUT ================= -->
    <div class="row g-4">
        <!-- LEFT COLUMN: Orders Table & Filters (~68%) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <!-- Category Tabs Bar -->
                <div class="d-flex align-items-center border-bottom px-3 pt-2 overflow-auto text-nowrap">
                    <a href="{{ route('seller.orders.index', ['tab' => 'all']) }}" class="dc-tab-btn {{ $currentTab === 'all' ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping me-1"></i> All Orders ({{ $stats['tab_all'] }})
                    </a>
                    <a href="{{ route('seller.orders.index', ['tab' => 'courses']) }}" class="dc-tab-btn {{ $currentTab === 'courses' ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap me-1"></i> Courses ({{ $stats['tab_courses'] }})
                    </a>
                    <a href="{{ route('seller.orders.index', ['tab' => 'services']) }}" class="dc-tab-btn {{ $currentTab === 'services' ? 'active' : '' }}">
                        <i class="fa-solid fa-briefcase me-1"></i> Services ({{ $stats['tab_services'] }})
                    </a>
                    <a href="{{ route('seller.orders.index', ['tab' => 'products']) }}" class="dc-tab-btn {{ $currentTab === 'products' ? 'active' : '' }}">
                        <i class="fa-solid fa-box-open me-1"></i> Products ({{ $stats['tab_products'] }})
                    </a>
                    <a href="{{ route('seller.orders.index', ['tab' => 'business']) }}" class="dc-tab-btn {{ $currentTab === 'business' ? 'active' : '' }}">
                        <i class="fa-solid fa-building me-1"></i> Business Inquiries ({{ $stats['tab_business'] }})
                    </a>
                </div>

                <!-- Search & Filters Toolbar -->
                <form method="GET" action="{{ route('seller.orders.index') }}" class="p-3 border-bottom bg-light bg-opacity-25">
                    <input type="hidden" name="tab" value="{{ $currentTab }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Search by order ID, customer name..." onkeydown="if(event.key === 'Enter') this.form.submit();">
                            </div>
                        </div>

                        <div class="col-md-2 col-6">
                            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="all">All Types</option>
                                <option value="Course" {{ request('type') === 'Course' ? 'selected' : '' }}>Courses</option>
                                <option value="Service" {{ request('type') === 'Service' ? 'selected' : '' }}>Services</option>
                                <option value="Product" {{ request('type') === 'Product' ? 'selected' : '' }}>Products</option>
                                <option value="Business" {{ request('type') === 'Business' ? 'selected' : '' }}>Business</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-6">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="all">All Status</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-12 text-md-end">
                            <div class="btn btn-sm btn-white bg-white border text-secondary px-3 py-1 rounded-2 fw-medium d-inline-flex align-items-center gap-2" style="font-size: 0.775rem;">
                                <i class="fa-regular fa-calendar text-muted"></i>
                                <span>Oct 1, 2026 - Oct 31, 2026</span>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table dc-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 35px;">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Item Details</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    $typeClass = match(strtolower($order->order_type)) {
                                        'course'   => 'badge-type-course',
                                        'service'  => 'badge-type-service',
                                        'product'  => 'badge-type-product',
                                        'business' => 'badge-type-business',
                                        default    => 'bg-light text-dark',
                                    };

                                    $statusClass = match(strtolower($order->status)) {
                                        'completed'   => 'badge-status-completed',
                                        'in_progress' => 'badge-status-in_progress',
                                        'shipped'     => 'badge-status-shipped',
                                        'processing'  => 'badge-status-processing',
                                        'delivered'   => 'badge-status-delivered',
                                        'cancelled'   => 'badge-status-cancelled',
                                        default       => 'bg-secondary text-white',
                                    };

                                    $statusLabel = match(strtolower($order->status)) {
                                        'completed'   => 'Completed',
                                        'in_progress' => 'In Progress',
                                        'shipped'     => 'Shipped',
                                        'processing'  => 'Processing',
                                        'delivered'   => 'Delivered',
                                        'cancelled'   => 'Cancelled',
                                        default       => ucfirst($order->status),
                                    };

                                    $defaultThumb = match(strtolower($order->order_type)) {
                                        'course'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=100&auto=format&fit=crop&q=80',
                                        'service'  => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=100&auto=format&fit=crop&q=80',
                                        'product'  => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=100&auto=format&fit=crop&q=80',
                                        'business' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=80',
                                        default    => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=80',
                                    };
                                @endphp
                                <tr id="order-row-{{ $order->id }}" class="{{ $loop->first ? 'selected-row' : '' }}" style="cursor: pointer;" onclick="selectOrder({{ json_encode($order) }}, this)">
                                    <td onclick="event.stopPropagation();">
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <span class="font-mono-code text-dark fw-bold" style="font-size: 0.8rem;">
                                            {{ $order->order_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($order->customer_avatar)
                                                <img src="{{ $order->customer_avatar }}" alt="{{ $order->customer_name }}" class="rounded-circle object-fit-cover flex-shrink-0" style="width: 28px; height: 28px;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 28px; height: 28px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); font-size: 0.675rem;">
                                                    {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark text-nowrap" style="font-size: 0.825rem;">
                                                    {{ $order->customer_name }}
                                                </div>
                                                <small class="text-muted text-nowrap" style="font-size: 0.7rem;">
                                                    {{ $order->customer_city ?? 'India' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill fw-semibold {{ $typeClass }}" style="font-size: 0.7rem; padding: 0.2rem 0.6rem;">
                                            {{ $order->order_type }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-2 overflow-hidden flex-shrink-0 border" style="width: 32px; height: 32px;">
                                                <img src="{{ $order->item_thumbnail ?: $defaultThumb }}" alt="{{ $order->item_title }}" class="w-100 h-100 object-fit-cover">
                                            </div>
                                            <div class="overflow-hidden" style="max-width: 170px;">
                                                <div class="fw-bold text-dark text-truncate" style="font-size: 0.8rem;">
                                                    {{ $order->item_title }}
                                                </div>
                                                <small class="text-muted text-truncate d-block" style="font-size: 0.685rem;">
                                                    {{ $order->item_subtext ?? '1 Access' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark font-mono-code" style="font-size: 0.825rem;">
                                            ₹{{ number_format($order->amount) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-status {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-nowrap" style="font-size: 0.75rem;">
                                            <span class="fw-medium text-dark d-block">{{ $order->placed_at ? $order->placed_at->format('M d, Y') : now()->format('M d, Y') }}</span>
                                            <small class="text-muted">{{ $order->placed_at ? $order->placed_at->format('h:i A') : '10:00 AM' }}</small>
                                        </div>
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="d-flex align-items-center justify-content-end gap-1">
                                            <button type="button" class="btn btn-outline-secondary btn-sm py-1 px-2 fw-semibold" style="font-size: 0.75rem; border-radius: 6px;" onclick="selectOrder({{ json_encode($order) }}, document.getElementById('order-row-{{ $order->id }}'))">
                                                View
                                            </button>
                                            <button type="button" class="btn btn-link text-secondary p-1" style="font-size: 0.85rem;">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa-solid fa-cart-shopping fs-2 mb-2 text-secondary opacity-50"></i>
                                            <h6>No orders found matching your criteria.</h6>
                                            <p class="small mb-0">Try clearing your filters or check back later.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Matching Design Mockup -->
                <div class="p-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <small class="text-muted" style="font-size: 0.8rem;">
                        Showing 1 to 10 of {{ $stats['total_orders'] }} orders
                    </small>

                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left" style="font-size: 0.65rem;"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#" style="background-color: #0066ff; border-color: #0066ff;">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            <li class="page-item"><a class="page-link" href="#">25</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i></a></li>
                        </ul>
                    </nav>

                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select form-select-sm" style="width: 110px; font-size: 0.775rem;">
                            <option value="10" selected>10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Order Details Slide Panel (~32%) -->
        <div class="col-xl-4 col-lg-5">
            <div class="dc-order-drawer" id="orderDrawer">
                @if($selectedOrder)
                    <!-- Drawer Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="display-heading fw-bold text-dark mb-0 font-mono-code" id="drawerOrderNumber" style="font-size: 1.15rem;">
                                    Order {{ $selectedOrder->order_number }}
                                </h5>
                                <span class="badge badge-status badge-status-{{ strtolower($selectedOrder->status) }}" id="drawerOrderStatus">
                                    {{ ucfirst(str_replace('_', ' ', $selectedOrder->status)) }}
                                </span>
                            </div>
                            <small class="text-muted" id="drawerOrderPlacedDate">
                                Placed on {{ $selectedOrder->placed_at ? $selectedOrder->placed_at->format('M d, Y \a\t h:i A') : 'Oct 30, 2026 at 10:24 AM' }}
                            </small>
                        </div>
                        <button type="button" class="btn-close text-secondary" style="font-size: 0.75rem;" onclick="document.getElementById('orderDrawer').style.display='none';"></button>
                    </div>

                    <!-- Item Preview Box -->
                    <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <div class="rounded-3 overflow-hidden flex-shrink-0 border" style="width: 52px; height: 52px;">
                                <img src="{{ $selectedOrder->item_thumbnail ?: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=100' }}" alt="Item" id="drawerItemImg" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="overflow-hidden flex-grow-1">
                                <h6 class="fw-bold text-dark mb-0 text-truncate" id="drawerItemTitle" style="font-size: 0.95rem;">
                                    {{ $selectedOrder->item_title }}
                                </h6>
                                <span class="text-muted small d-block" id="drawerItemType" style="font-size: 0.75rem;">
                                    {{ $selectedOrder->order_type }}
                                </span>
                                <small class="text-muted" id="drawerItemSubtext" style="font-size: 0.725rem;">
                                    {{ $selectedOrder->item_subtext ?? '1 Course Access' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-dark font-mono-code fs-6" id="drawerItemPrice">
                                    ₹{{ number_format($selectedOrder->amount) }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm flex-fill fw-semibold py-1" id="drawerBtnView" style="font-size: 0.775rem;">
                                View {{ $selectedOrder->order_type }}
                            </button>
                            <button type="button" class="btn btn-primary btn-sm flex-fill fw-semibold py-1" style="background-color: #0066ff; font-size: 0.775rem;">
                                Contact Buyer
                            </button>
                        </div>
                    </div>

                    <!-- BUYER INFORMATION -->
                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.685rem; letter-spacing: 0.06em;">
                            BUYER INFORMATION
                        </span>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $selectedOrder->customer_avatar ?: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100' }}" alt="Buyer" id="drawerBuyerAvatar" class="rounded-circle object-fit-cover" style="width: 36px; height: 36px;">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0" id="drawerBuyerName" style="font-size: 0.875rem;">
                                        {{ $selectedOrder->customer_name }}
                                    </h6>
                                    <small class="text-muted" id="drawerBuyerCity" style="font-size: 0.725rem;">
                                        📍 {{ $selectedOrder->customer_city ?? 'Ahmedabad, Gujarat' }}
                                    </small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm py-1 px-2 fw-semibold rounded-pill" style="font-size: 0.725rem;">
                                View Profile
                            </button>
                        </div>

                        <div class="d-flex flex-column gap-1 small ps-1" style="font-size: 0.775rem;">
                            <div class="text-secondary">
                                <i class="fa-regular fa-envelope text-muted me-1"></i>
                                <span id="drawerBuyerEmail">{{ $selectedOrder->customer_email ?? 'priya.patel@email.com' }}</span>
                            </div>
                            <div class="text-secondary">
                                <i class="fa-solid fa-phone text-muted me-1"></i>
                                <span id="drawerBuyerPhone">{{ $selectedOrder->customer_phone ?? '+91 98765 43210' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- ORDER SUMMARY -->
                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.685rem; letter-spacing: 0.06em;">
                            ORDER SUMMARY
                        </span>
                        <div class="d-flex justify-content-between py-1 small" style="font-size: 0.8rem;">
                            <span class="text-muted">Order ID:</span>
                            <span class="fw-semibold text-dark font-mono-code" id="drawerSummaryId">{{ str_replace('#', '', $selectedOrder->order_number) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 small" style="font-size: 0.8rem;">
                            <span class="text-muted">Order Type:</span>
                            <span class="badge badge-type-course" id="drawerSummaryType">{{ $selectedOrder->order_type }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 small" style="font-size: 0.8rem;">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-semibold text-dark font-mono-code" id="drawerSummarySubtotal">₹{{ number_format($selectedOrder->amount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 small" style="font-size: 0.8rem;">
                            <span class="text-muted">Discount:</span>
                            <span class="text-success font-mono-code">- ₹0</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top mt-1" style="font-size: 0.95rem;">
                            <span class="fw-bold text-dark">Total Amount:</span>
                            <span class="fw-bold text-dark font-mono-code fs-6" id="drawerSummaryTotal">₹{{ number_format($selectedOrder->amount) }}</span>
                        </div>
                    </div>

                    <!-- ORDER TIMELINE -->
                    <div class="mb-4">
                        <span class="text-muted text-uppercase fw-bold d-block mb-3" style="font-size: 0.685rem; letter-spacing: 0.06em;">
                            ORDER TIMELINE
                        </span>

                        <div class="dc-timeline" id="drawerTimeline">
                            <div class="dc-timeline-step">
                                <div class="dc-timeline-dot"><i class="fa-solid fa-check"></i></div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.825rem;">Order Placed</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Oct 30, 2026, 10:24 AM</small>
                            </div>

                            <div class="dc-timeline-step">
                                <div class="dc-timeline-dot"><i class="fa-solid fa-check"></i></div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.825rem;">Payment Completed</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Oct 30, 2026, 10:25 AM</small>
                            </div>

                            <div class="dc-timeline-step">
                                <div class="dc-timeline-dot"><i class="fa-solid fa-check"></i></div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.825rem;">Access Granted</h6>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Oct 30, 2026, 10:26 AM</small>
                                <span class="text-secondary" style="font-size: 0.7rem;">Course access has been provided to the buyer.</span>
                            </div>

                            <div class="dc-timeline-step">
                                <div class="dc-timeline-dot"><i class="fa-solid fa-check"></i></div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.825rem;">Order Completed</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Oct 30, 2026, 10:26 AM</small>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Footer -->
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-outline-secondary btn-sm flex-fill fw-semibold py-2">
                            <i class="fa-regular fa-envelope me-1"></i> Send Message
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm flex-fill fw-semibold py-2">
                            <i class="fa-regular fa-file-lines me-1"></i> View Invoice
                        </button>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-file-invoice fs-2 mb-2"></i>
                        <h6>Select an order to view full details</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- ================= SIMULATE CUSTOMER PURCHASE MODAL ================= -->
<div class="modal fade" id="simulateOrderModal" tabindex="-1" aria-labelledby="simulateOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="simulateOrderModalLabel">
                        <i class="fa-solid fa-bolt-lightning text-warning me-2"></i>Simulate Customer Purchase
                    </h5>
                    <p class="text-muted small mb-0">Test how incoming customer orders appear when a customer buys on the marketplace.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('seller.orders.simulate') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Order Category / Type</label>
                        <select name="order_type" class="form-select" id="simOrderType" required onchange="updateSimDefaults(this.value)">
                            <option value="Course" selected>Course Purchase (Online Video Batch)</option>
                            <option value="Service">Service Gig Order (Custom Development)</option>
                            <option value="Product">Product Order (Digital Download / Hardware)</option>
                            <option value="Business">Business Directory Inquiry & Upgrade</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Item / Offering Title</label>
                        <input type="text" name="item_title" id="simItemTitle" class="form-control" value="Complete Digital Marketing & AI Masterclass 2026" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">Order Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" step="0.01" name="amount" id="simAmount" class="form-control font-mono-code fw-bold" value="1499" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">Initial Order Status</label>
                            <select name="status" class="form-select">
                                <option value="completed" selected>Completed (Paid & Granted)</option>
                                <option value="in_progress">In Progress</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-2">
                        <span class="fw-bold text-dark small d-block mb-2">Buyer Simulation Details</span>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="customer_name" class="form-control form-control-sm" placeholder="Buyer Name" value="Kavita Joshi">
                            </div>
                            <div class="col-6">
                                <input type="text" name="customer_city" class="form-control form-control-sm" placeholder="City" value="Ahmedabad, Gujarat">
                            </div>
                            <div class="col-6">
                                <input type="email" name="customer_email" class="form-control form-control-sm" placeholder="Email" value="kavita.joshi@example.com">
                            </div>
                            <div class="col-6">
                                <input type="text" name="customer_phone" class="form-control form-control-sm" placeholder="Phone" value="+91 98250 11223">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #0066ff;">
                        Confirm & Place Order &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectOrder(order, rowElement) {
        // Highlight clicked row
        document.querySelectorAll('.dc-table tr').forEach(r => r.classList.remove('selected-row'));
        if (rowElement) {
            rowElement.classList.add('selected-row');
        }

        const drawer = document.getElementById('orderDrawer');
        if (drawer) {
            drawer.style.display = 'block';
        }

        // Update Drawer Content
        const orderNum = document.getElementById('drawerOrderNumber');
        if (orderNum) orderNum.textContent = 'Order ' + order.order_number;

        const orderStatus = document.getElementById('drawerOrderStatus');
        if (orderStatus) {
            orderStatus.className = 'badge badge-status badge-status-' + order.status.toLowerCase();
            orderStatus.textContent = order.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        const datePlaced = document.getElementById('drawerOrderPlacedDate');
        if (datePlaced) {
            datePlaced.textContent = 'Placed on ' + (order.placed_at ? new Date(order.placed_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'Oct 30, 2026 at 10:24 AM');
        }

        const itemTitle = document.getElementById('drawerItemTitle');
        if (itemTitle) itemTitle.textContent = order.item_title;

        const itemType = document.getElementById('drawerItemType');
        if (itemType) itemType.textContent = order.order_type;

        const itemSubtext = document.getElementById('drawerItemSubtext');
        if (itemSubtext) itemSubtext.textContent = order.item_subtext || '';

        const itemPrice = document.getElementById('drawerItemPrice');
        if (itemPrice) itemPrice.textContent = '₹' + Number(order.amount).toLocaleString();

        const itemImg = document.getElementById('drawerItemImg');
        if (itemImg && order.item_thumbnail) itemImg.src = order.item_thumbnail;

        const btnView = document.getElementById('drawerBtnView');
        if (btnView) btnView.textContent = 'View ' + order.order_type;

        const buyerAvatar = document.getElementById('drawerBuyerAvatar');
        if (buyerAvatar && order.customer_avatar) {
            buyerAvatar.src = order.customer_avatar;
        }

        const buyerName = document.getElementById('drawerBuyerName');
        if (buyerName) buyerName.textContent = order.customer_name;

        const buyerCity = document.getElementById('drawerBuyerCity');
        if (buyerCity) buyerCity.textContent = '📍 ' + (order.customer_city || 'Ahmedabad, Gujarat');

        const buyerEmail = document.getElementById('drawerBuyerEmail');
        if (buyerEmail) buyerEmail.textContent = order.customer_email || 'customer@example.com';

        const buyerPhone = document.getElementById('drawerBuyerPhone');
        if (buyerPhone) buyerPhone.textContent = order.customer_phone || '+91 98765 43210';

        const summaryId = document.getElementById('drawerSummaryId');
        if (summaryId) summaryId.textContent = order.order_number.replace('#', '');

        const summaryType = document.getElementById('drawerSummaryType');
        if (summaryType) {
            summaryType.className = 'badge badge-type-' + order.order_type.toLowerCase();
            summaryType.textContent = order.order_type;
        }

        const summarySubtotal = document.getElementById('drawerSummarySubtotal');
        if (summarySubtotal) summarySubtotal.textContent = '₹' + Number(order.amount).toLocaleString();

        const summaryTotal = document.getElementById('drawerSummaryTotal');
        if (summaryTotal) summaryTotal.textContent = '₹' + Number(order.amount).toLocaleString();
    }

    function updateSimDefaults(type) {
        const titleInput = document.getElementById('simItemTitle');
        const amountInput = document.getElementById('simAmount');

        if (type === 'Course') {
            titleInput.value = 'Complete Digital Marketing & AI Masterclass 2026';
            amountInput.value = '1499';
        } else if (type === 'Service') {
            titleInput.value = 'Full-Stack Custom Web Application & API Development';
            amountInput.value = '14999';
        } else if (type === 'Product') {
            titleInput.value = 'SaaS Multi-Vendor Marketplace UI Kit & Full-Stack Starter';
            amountInput.value = '1499';
        } else if (type === 'Business') {
            titleInput.value = 'VCEC - Vinayak Computer Education Center Directory Listing';
            amountInput.value = '1499';
        }
    }
</script>
@endsection
