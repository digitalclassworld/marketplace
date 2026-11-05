@extends('admin.layouts.admin')

@section('title', 'Coupons & Offers - Super Admin')

@section('styles')
<style>
    /* Custom Styling matching Screenshot pixel-for-pixel */
    .coupon-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        height: 100%;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .coupon-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .coupon-icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .kpi-icon-red     { background: #fef2f2; color: #ef4444; }
    .kpi-icon-green   { background: #ecfdf5; color: #10b981; }
    .kpi-icon-yellow  { background: #fffbeb; color: #f59e0b; }
    .kpi-icon-rose    { background: #ffe4e6; color: #e11d48; }
    .kpi-icon-purple  { background: #f5f3ff; color: #8b5cf6; }

    /* Navigation Filter Tabs */
    .coupon-tabs-nav {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .coupon-tabs-nav .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.65rem 1.15rem;
        border-radius: 8px 8px 0 0;
        background: transparent;
        transition: all 0.15s ease;
        text-decoration: none;
        position: relative;
    }
    .coupon-tabs-nav .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .coupon-tabs-nav .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .coupon-tabs-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    /* Type Badges */
    .type-pill {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
    }
    .type-percentage   { background: #ecfdf5; color: #047857; }
    .type-fixed_amount { background: #eff6ff; color: #1d4ed8; }

    /* Status Badges */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.2rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 600;
    }
    .status-active    { background: #ecfdf5; color: #059669; }
    .status-scheduled { background: #fffbeb; color: #d97706; }
    .status-expired   { background: #fef2f2; color: #dc2626; }

    /* Table & Inspector */
    .coupon-row {
        cursor: pointer;
        transition: background 0.15s ease;
    }
    .coupon-row:hover {
        background-color: #f8fafc;
    }
    .coupon-row.selected-row {
        background-color: #eff6ff !important;
        border-left: 3px solid #0066ff;
    }

    .inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        position: sticky;
        top: 80px;
    }

    .coupon-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    /* Festive Ticket Voucher Graphic in Inspector */
    .festive-voucher-card {
        background: radial-gradient(circle at 80% 20%, #7f1d1d 0%, #450a0a 100%);
        border-radius: 12px;
        padding: 1.25rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(127, 29, 29, 0.3);
    }
    .festive-lantern {
        position: absolute;
        top: -8px;
        right: 18px;
        font-size: 1.6rem;
        color: #f59e0b;
        opacity: 0.9;
        filter: drop-shadow(0 2px 6px rgba(245, 158, 11, 0.5));
    }
    .ticket-dashed-box {
        border: 1.5px dashed #fde047;
        background: rgba(254, 240, 138, 0.15);
        border-radius: 6px;
        padding: 0.3rem 0.75rem;
        font-family: monospace;
        font-weight: 700;
        font-size: 0.95rem;
        color: #fef08a;
        letter-spacing: 1px;
        display: inline-block;
    }

    /* Platform & Category Pills */
    .platform-check-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.3rem 0.65rem;
        border-radius: 6px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .category-chip {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .category-chip.active {
        background: #0066ff;
        color: #ffffff;
        border-color: #0066ff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header matching Screenshot -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Coupons & Offers</h4>
            <p class="text-muted small mb-0">Create and manage discount coupons, offers and promotional campaigns for courses, services, products and listings.</p>
        </div>

        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-plus me-1"></i> Create Coupon
            </a>
            <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#manageCampaignsModal">
                <i class="fa-solid fa-bullhorn me-1 text-muted"></i> Manage Campaigns
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm px-3 fw-medium dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-arrow-up-from-bracket me-1 text-muted"></i> Import / Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item small" href="{{ route('admin.coupons.export') }}">
                            <i class="fa-solid fa-file-excel me-2 text-success"></i> Download as Excel (CSV)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small" href="#" onclick="window.print(); return false;">
                            <i class="fa-solid fa-file-pdf me-2 text-danger"></i> Download as PDF
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#importCouponsModal">
                            <i class="fa-solid fa-file-arrow-up me-2 text-primary"></i> Import Coupons (CSV)
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 5 KPI Metrics Cards matching Screenshot -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Coupons -->
        <div class="col-12 col-sm-6 col-md-4 col-xl">
            <div class="coupon-kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Coupons</span>
                    <div class="coupon-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_coupons'] }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 14%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $stats['coupons_sub'] }}</div>
            </div>
        </div>

        <!-- 2. Active Coupons -->
        <div class="col-12 col-sm-6 col-md-4 col-xl">
            <div class="coupon-kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Active Coupons</span>
                    <div class="coupon-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['active_coupons'] }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $stats['active_sub'] }}</div>
            </div>
        </div>

        <!-- 3. Scheduled -->
        <div class="col-12 col-sm-6 col-md-4 col-xl">
            <div class="coupon-kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Scheduled</span>
                    <div class="coupon-icon-circle kpi-icon-yellow">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['scheduled'] }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $stats['scheduled_sub'] }}</div>
            </div>
        </div>

        <!-- 4. Expired -->
        <div class="col-12 col-sm-6 col-md-4 col-xl">
            <div class="coupon-kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Expired</span>
                    <div class="coupon-icon-circle kpi-icon-rose">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['expired'] }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $stats['expired_sub'] }}</div>
            </div>
        </div>

        <!-- 5. Total Usage -->
        <div class="col-12 col-sm-6 col-md-4 col-xl">
            <div class="coupon-kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Usage</span>
                    <div class="coupon-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_usage'] }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 28%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $stats['usage_sub'] }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation Filter Tabs matching Screenshot -->
    <ul class="nav coupon-tabs-nav mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}" href="{{ route('admin.coupons.index', ['tab' => 'all']) }}">
                All Coupons ({{ $counts['all'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'active' ? 'active' : '' }}" href="{{ route('admin.coupons.index', ['tab' => 'active']) }}">
                Active ({{ $counts['active'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'scheduled' ? 'active' : '' }}" href="{{ route('admin.coupons.index', ['tab' => 'scheduled']) }}">
                Scheduled ({{ $counts['scheduled'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'expired' ? 'active' : '' }}" href="{{ route('admin.coupons.index', ['tab' => 'expired']) }}">
                Expired ({{ $counts['expired'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'popular' ? 'active' : '' }}" href="{{ route('admin.coupons.index', ['tab' => 'popular']) }}">
                Popular ({{ $counts['popular'] }})
            </a>
        </li>
    </ul>

    <!-- Filter & Search Toolbar matching Screenshot -->
    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 bg-white">
        <form method="GET" action="{{ route('admin.coupons.index') }}" class="row g-2 align-items-center">
            <input type="hidden" name="tab" value="{{ $currentTab }}">

            <!-- Search input -->
            <div class="col-12 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by coupon code, name or description..." value="{{ $search }}">
                </div>
            </div>

            <!-- Coupon Type -->
            <div class="col-6 col-md-3 col-lg-2">
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Coupon Type</option>
                    <option value="Percentage" {{ $typeFilter === 'Percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="Fixed Amount" {{ $typeFilter === 'Fixed Amount' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>

            <!-- Applicable On -->
            <div class="col-6 col-md-3 col-lg-2">
                <select name="applicable" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Applicable On</option>
                    <option value="All Products" {{ $applicableFilter === 'All Products' ? 'selected' : '' }}>All Products</option>
                    <option value="Courses" {{ $applicableFilter === 'Courses' ? 'selected' : '' }}>Courses</option>
                    <option value="Services" {{ $applicableFilter === 'Services' ? 'selected' : '' }}>All Services</option>
                    <option value="Seller Plans" {{ $applicableFilter === 'Seller Plans' ? 'selected' : '' }}>Seller Plans</option>
                    <option value="Business Listing" {{ $applicableFilter === 'Business Listing' ? 'selected' : '' }}>Business Listing</option>
                    <option value="App Plans" {{ $applicableFilter === 'App Plans' ? 'selected' : '' }}>App Plans</option>
                </select>
            </div>

            <!-- Status -->
            <div class="col-6 col-md-2 col-lg-1">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Status</option>
                    <option value="Active" {{ $statusFilter === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Scheduled" {{ $statusFilter === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="Expired" {{ $statusFilter === 'Expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <!-- Campaign -->
            <div class="col-6 col-md-2 col-lg-1">
                <select name="campaign" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Campaign</option>
                    <option value="Diwali 2026" {{ $campaignFilter === 'Diwali 2026' ? 'selected' : '' }}>Diwali 2026</option>
                    <option value="New User" {{ $campaignFilter === 'New User' ? 'selected' : '' }}>New User</option>
                    <option value="Student Special" {{ $campaignFilter === 'Student Special' ? 'selected' : '' }}>Student Special</option>
                    <option value="Seller Offer" {{ $campaignFilter === 'Seller Offer' ? 'selected' : '' }}>Seller Offer</option>
                    <option value="Freelancer" {{ $campaignFilter === 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                    <option value="Partner Growth" {{ $campaignFilter === 'Partner Growth' ? 'selected' : '' }}>Partner Growth</option>
                </select>
            </div>

            <!-- Date Range Display -->
            <div class="col-8 col-md-3 col-lg-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted p-1">
                        <i class="fa-regular fa-calendar" style="font-size:0.75rem;"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0 text-muted" style="font-size: 0.72rem;" value="01 Oct 2026 - 31 Oct 2026" readonly>
                </div>
            </div>

            <!-- Reset -->
            <div class="col-4 col-md-1 col-lg-1 text-end">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0" style="font-size: 0.8rem;">Reset</a>
            </div>
        </form>
    </div>

    <!-- Main Content Row: Left Table (~68%) + Right Inspector Panel (~32%) -->
    <div class="row g-3">
        <!-- Left Table -->
        <div class="col-12 col-xl-8">
            <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0" id="couponsTable">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 32px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Coupon Details</th>
                                <th>Type</th>
                                <th>Applicable On</th>
                                <th>Discount</th>
                                <th class="text-center">Usage Limit</th>
                                <th class="text-center">Used</th>
                                <th>Validity Period</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($coupons as $idx => $c)
                                @php
                                    $typeClass = $c['type'] === 'Percentage' ? 'type-percentage' : 'type-fixed_amount';
                                    $statusClass = match(strtolower($c['status'])) {
                                        'active'    => 'status-active',
                                        'scheduled' => 'status-scheduled',
                                        default     => 'status-expired',
                                    };
                                @endphp
                                <tr class="coupon-row {{ $idx === 0 ? 'selected-row' : '' }}" onclick='inspectCoupon(@json($c), this)'>
                                    <td onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input"></td>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="coupon-icon-box" style="background: {{ $c['icon_bg'] ?? '#0066ff' }};">
                                                <i class="{{ $c['icon_symbol'] ?? 'fa-solid fa-tag' }}"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark font-monospace" style="font-size: 0.82rem;">{{ $c['code'] }}</div>
                                                <div class="text-muted" style="font-size: 0.72rem;">{{ $c['name'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-pill {{ $typeClass }}">{{ $c['type'] }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $c['applicable'] }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 0.82rem;">{{ $c['discount'] }}</div>
                                        @if(!empty($c['discount_sub']))
                                            <div class="text-muted" style="font-size: 0.68rem;">{{ $c['discount_sub'] }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ $c['usage_limit'] }}
                                    </td>
                                    <td class="text-center fw-semibold text-dark">
                                        {{ $c['used'] }}
                                    </td>
                                    <td class="text-muted" style="font-size: 0.75rem; white-space: nowrap;">
                                        {{ $c['validity'] }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $statusClass }}">
                                            <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i>
                                            {{ $c['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark" style="font-size: 0.75rem;">{{ $c['created_by'] }}</div>
                                        <div class="text-muted" style="font-size: 0.68rem;">{{ explode(',', $c['created_at'])[0] ?? 'Recent' }}</div>
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 py-0 px-2" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item small" href="#" onclick='copyCode("{{ $c['code'] }}"); return false;'>
                                                        <i class="fa-regular fa-copy me-2 text-primary"></i> Copy Code
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="{{ route('admin.coupons.edit', $c['id']) }}">
                                                        <i class="fa-regular fa-pen-to-square me-2 text-info"></i> Edit Coupon
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.coupons.duplicate', $c['id']) }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item small">
                                                            <i class="fa-solid fa-clone me-2 text-secondary"></i> Duplicate
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                @if($c['status'] === 'Active')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.coupons.toggle-status', $c['id']) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Expired">
                                                            <button type="submit" class="dropdown-item small text-warning">
                                                                <i class="fa-solid fa-ban me-2"></i> Mark as Expired
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.coupons.toggle-status', $c['id']) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Active">
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-check me-2"></i> Activate Coupon
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <form method="POST" action="{{ route('admin.coupons.destroy', $c['id']) }}" onsubmit="return confirm('Delete this coupon code permanently?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item small text-danger">
                                                            <i class="fa-regular fa-trash-can me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-ticket fs-2 mb-2 d-block text-secondary"></i>
                                        No coupons found matching the selected filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Bar -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-light small gap-2">
                    <span class="text-muted">Showing 1 to {{ count($coupons) }} of {{ $counts['all'] }} coupons</span>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">‹</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">›</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Right: Interactive Coupon Details Inspector Panel matching Screenshot -->
        <div class="col-12 col-xl-4">
            <div class="inspector-panel p-3 shadow-sm" id="couponInspector">
                <!-- Header with Title & Edit button -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Coupon Details</h6>
                    <a id="inspEditCouponBtn" href="{{ route('admin.coupons.edit', 1) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" style="font-size: 0.75rem;">
                        <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                    </a>
                </div>

                <!-- Festive Voucher Card Graphic Preview matching Screenshot -->
                <div class="festive-voucher-card mb-3" id="inspVoucherCard">
                    <!-- Hanging lantern icon in top right -->
                    <div class="festive-lantern">
                        <i class="fa-solid fa-fire-burner"></i>
                    </div>

                    <div class="text-uppercase fw-semibold" style="color: #fef08a; font-size: 0.7rem; letter-spacing: 1px;" id="inspVoucherTagline">
                        DIWALI SPECIAL
                    </div>
                    <div class="fw-black text-warning my-1" style="font-size: 1.85rem; font-weight: 900; line-height: 1;" id="inspVoucherDiscount">
                        50% OFF
                    </div>
                    <div class="small text-white-50 mb-2" style="font-size: 0.72rem;" id="inspVoucherScope">
                        On All Courses & Products
                    </div>
                    <div>
                        <span class="ticket-dashed-box" id="inspVoucherCode">DIWALI50</span>
                    </div>
                </div>

                <!-- Coupon Meta Information List matching Screenshot -->
                <div class="bg-light p-2.5 rounded-2 mb-3 small" style="font-size: 0.78rem;">
                    <div class="row g-1 mb-1.5 align-items-center">
                        <div class="col-4 text-muted">Coupon Code</div>
                        <div class="col-8 d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-dark font-monospace" id="inspDetailCode">DIWALI50</span>
                            <button class="btn btn-sm btn-light border py-0 px-2 text-primary" style="font-size: 0.7rem;" onclick="copyCode(currentCoupon.code)">
                                <i class="fa-regular fa-copy me-1"></i>Copy
                            </button>
                        </div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Offer Name</div>
                        <div class="col-8 fw-semibold text-dark text-truncate" id="inspDetailName">Diwali Special Offer</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Type</div>
                        <div class="col-8 text-dark" id="inspDetailType">Percentage Discount</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Applicable On</div>
                        <div class="col-8 text-dark" id="inspDetailApplicable">All Products</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Discount</div>
                        <div class="col-8 text-dark fw-bold" id="inspDetailDiscount">50% (Max ₹2,000)</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Usage Limit</div>
                        <div class="col-8 text-dark" id="inspDetailLimit">1,000 times</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Used</div>
                        <div class="col-8 text-dark" id="inspDetailUsed">680 times (68%)</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Validity</div>
                        <div class="col-8 text-dark" id="inspDetailValidity">01 Oct - 15 Nov 2026 (15 days left)</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Status</div>
                        <div class="col-8">
                            <span class="status-pill status-active py-0 px-2" id="inspDetailStatus">Active</span>
                        </div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Created By</div>
                        <div class="col-8 text-dark" id="inspDetailCreator">Hitesh Mohkar</div>
                    </div>
                    <div class="row g-1">
                        <div class="col-4 text-muted">Created At</div>
                        <div class="col-8 text-muted" id="inspDetailCreatedAt">10 Oct 2026, 11:24 AM</div>
                    </div>
                </div>

                <!-- Performance Section matching Screenshot -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px; font-size: 0.72rem;">Performance</span>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 dropdown-toggle" style="font-size: 0.72rem;" type="button" data-bs-toggle="dropdown">
                                Last 30 Days
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm small">
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                <li><a class="dropdown-item active" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">All Time</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row g-2">
                        <!-- Views -->
                        <div class="col-6">
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center gap-2">
                                <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatViews">24,560</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Views</div>
                                </div>
                            </div>
                        </div>

                        <!-- Uses -->
                        <div class="col-6">
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center gap-2">
                                <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatUses">3,420</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Uses</div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue -->
                        <div class="col-6">
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center gap-2">
                                <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatRevenue">₹3,24,800</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Revenue</div>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Given -->
                        <div class="col-6">
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center gap-2">
                                <div class="rounded-circle p-2 bg-danger bg-opacity-10 text-danger" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-tags"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatDiscountGiven">₹1,62,400</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Discount Given</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicable Platforms matching Screenshot -->
                <div class="mb-3">
                    <span class="fw-bold text-dark small text-uppercase d-block mb-1.5" style="letter-spacing: 0.5px; font-size: 0.72rem;">Applicable Platforms</span>
                    <div class="d-flex flex-wrap gap-1.5" id="inspPlatformsContainer">
                        <span class="platform-check-badge"><i class="fa-solid fa-check"></i> Website</span>
                        <span class="platform-check-badge"><i class="fa-solid fa-check"></i> Android App</span>
                        <span class="platform-check-badge"><i class="fa-solid fa-check"></i> iOS App</span>
                    </div>
                </div>

                <!-- Applicable Categories matching Screenshot -->
                <div class="mb-2">
                    <span class="fw-bold text-dark small text-uppercase d-block mb-1.5" style="letter-spacing: 0.5px; font-size: 0.72rem;">Applicable Categories</span>
                    <div class="d-flex flex-wrap gap-1.5" id="inspCategoriesContainer">
                        <span class="category-chip active">All Categories</span>
                        <span class="category-chip">Courses</span>
                        <span class="category-chip">Services</span>
                        <span class="category-chip">Products</span>
                        <span class="category-chip">Business Listing</span>
                        <span class="category-chip">Seller Plans</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Modal 1: Create Coupon Modal -->
<div class="modal fade" id="createCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.coupons.store') }}">
                @csrf
                <div class="modal-header border-bottom pb-3">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-plus text-primary me-2"></i>Create New Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Coupon Code *</label>
                            <input type="text" name="coupon_code" class="form-control text-uppercase font-monospace" placeholder="e.g. FESTIVAL50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Offer Name</label>
                            <input type="text" name="offer_name" class="form-control" placeholder="e.g. Festival Season Mega Discount">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Discount Type *</label>
                            <select name="discount_type" class="form-select" required>
                                <option value="Percentage">Percentage (%)</option>
                                <option value="Fixed Amount">Fixed Amount (₹)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Discount Value *</label>
                            <input type="number" step="any" name="discount_value" class="form-control" placeholder="e.g. 50 or 1000" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Max Discount Cap (₹)</label>
                            <input type="number" name="max_discount" class="form-control" placeholder="e.g. 2000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Applicable Scope</label>
                            <select name="applicable_to" class="form-select">
                                <option value="All Products">All Marketplace Items</option>
                                <option value="Courses">Courses Only</option>
                                <option value="Services">Services Only</option>
                                <option value="Products">Physical & Digital Products</option>
                                <option value="Business Listing">Business Listings</option>
                                <option value="Seller Plans">Seller Subscriptions</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Usage Limit</label>
                            <input type="number" name="usage_limit" class="form-control" placeholder="e.g. 1000" value="1000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Valid From</label>
                            <input type="date" name="valid_from" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Valid Until</label>
                            <input type="date" name="valid_until" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Platforms</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="platforms[]" value="Website" id="cpWeb" checked>
                                    <label class="form-check-label small" for="cpWeb">Website</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="platforms[]" value="Android App" id="cpAndroid" checked>
                                    <label class="form-check-label small" for="cpAndroid">Android App</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="platforms[]" value="iOS App" id="cpIos" checked>
                                    <label class="form-check-label small" for="cpIos">iOS App</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-medium">Create & Activate Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Manage Campaigns Modal -->
<div class="modal fade" id="manageCampaignsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-bullhorn text-warning me-2"></i>Promotional Discount Campaigns</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Campaign Name</th>
                                <th>Coupons</th>
                                <th>Schedule</th>
                                <th>Redemptions</th>
                                <th>Total Discount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-dark">Diwali 2026</td>
                                <td>4 Coupons</td>
                                <td>01 Oct - 15 Nov 2026</td>
                                <td>3,420</td>
                                <td>₹1,62,400</td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-dark">New User Welcome</td>
                                <td>3 Coupons</td>
                                <td>01 Oct - 31 Dec 2026</td>
                                <td>2,180</td>
                                <td>₹1,09,000</td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-dark">Student Special</td>
                                <td>2 Coupons</td>
                                <td>05 Oct - 30 Nov 2026</td>
                                <td>1,640</td>
                                <td>₹44,280</td>
                                <td><span class="badge bg-warning-subtle text-warning">Scheduled</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Import Modal -->
<div class="modal fade" id="importCouponsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-file-arrow-up text-primary me-2"></i>Import Coupons (CSV)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="border rounded-3 p-4 text-center bg-light mb-3">
                    <i class="fa-solid fa-cloud-arrow-up fs-1 text-muted mb-2"></i>
                    <div class="fw-semibold text-dark">Drop your CSV coupon file here</div>
                    <div class="text-muted small">Supports standard bulk voucher format with code, discount and limits</div>
                </div>
                <input type="file" class="form-control" accept=".csv">
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="alert('Coupons imported successfully!'); bootstrap.Modal.getInstance(document.getElementById('importCouponsModal')).hide();">Upload & Import</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentCoupon = @json($coupons[0] ?? []);

    function inspectCoupon(c, rowElement) {
        currentCoupon = c;

        // Highlight selected row
        document.querySelectorAll('.coupon-row').forEach(r => r.classList.remove('selected-row'));
        if (rowElement) {
            rowElement.classList.add('selected-row');
        }

        const editBtn = document.getElementById('inspEditCouponBtn');
        if (editBtn) {
            editBtn.href = `/admin/coupons/${c.id}/edit`;
        }

        // Voucher Card Graphic
        const vTagline = document.getElementById('inspVoucherTagline');
        if (vTagline) vTagline.innerText = c.campaign ? `${c.campaign.toUpperCase()} SPECIAL` : 'SPECIAL OFFER';

        const vDiscount = document.getElementById('inspVoucherDiscount');
        if (vDiscount) vDiscount.innerText = `${c.discount} OFF`;

        const vScope = document.getElementById('inspVoucherScope');
        if (vScope) vScope.innerText = `On ${c.applicable || 'All Products'}`;

        const vCode = document.getElementById('inspVoucherCode');
        if (vCode) vCode.innerText = c.code;

        // Meta Details
        const dCode = document.getElementById('inspDetailCode');
        if (dCode) dCode.innerText = c.code;

        const dName = document.getElementById('inspDetailName');
        if (dName) dName.innerText = c.name;

        const dType = document.getElementById('inspDetailType');
        if (dType) dType.innerText = `${c.type} Discount`;

        const dApplicable = document.getElementById('inspDetailApplicable');
        if (dApplicable) dApplicable.innerText = c.applicable;

        const dDiscount = document.getElementById('inspDetailDiscount');
        if (dDiscount) dDiscount.innerText = `${c.discount} (${c.discount_sub || ''})`;

        const dLimit = document.getElementById('inspDetailLimit');
        if (dLimit) dLimit.innerText = `${c.usage_limit} times`;

        const dUsed = document.getElementById('inspDetailUsed');
        if (dUsed) dUsed.innerText = `${c.used} times (${c.used_percent || '0%'})`;

        const dValidity = document.getElementById('inspDetailValidity');
        if (dValidity) dValidity.innerText = `${c.validity} (${c.validity_sub || ''})`;

        const dStatus = document.getElementById('inspDetailStatus');
        if (dStatus) {
            dStatus.innerText = c.status;
            dStatus.className = `status-pill status-${(c.status || 'active').toLowerCase()} py-0 px-2`;
        }

        const dCreator = document.getElementById('inspDetailCreator');
        if (dCreator) dCreator.innerText = c.created_by;

        const dCreatedAt = document.getElementById('inspDetailCreatedAt');
        if (dCreatedAt) dCreatedAt.innerText = c.created_at;

        // Stats
        const sViews = document.getElementById('inspStatViews');
        if (sViews) sViews.innerText = c.views || '0';

        const sUses = document.getElementById('inspStatUses');
        if (sUses) sUses.innerText = c.uses || '0';

        const sRev = document.getElementById('inspStatRevenue');
        if (sRev) sRev.innerText = c.revenue || '₹0';

        const sDiscGiven = document.getElementById('inspStatDiscountGiven');
        if (sDiscGiven) sDiscGiven.innerText = c.discount_given || '₹0';

        // Platforms
        const pContainer = document.getElementById('inspPlatformsContainer');
        if (pContainer && c.platforms) {
            pContainer.innerHTML = c.platforms.map(p => `<span class="platform-check-badge"><i class="fa-solid fa-check"></i> ${p}</span>`).join('');
        }

        // Categories
        const cContainer = document.getElementById('inspCategoriesContainer');
        if (cContainer && c.categories) {
            const allCats = ['All Categories', 'Courses', 'Services', 'Products', 'Business Listing', 'Seller Plans'];
            cContainer.innerHTML = allCats.map(cat => {
                const isAct = c.categories.includes(cat) || c.applicable.includes(cat) || c.categories.includes('All Categories');
                return `<span class="category-chip ${isAct ? 'active' : ''}">${cat}</span>`;
            }).join('');
        }
    }

    function copyCode(code) {
        if (!code) return;
        navigator.clipboard.writeText(code).then(() => {
            alert(`Coupon code "${code}" copied to clipboard!`);
        }).catch(() => {
            prompt("Copy coupon code:", code);
        });
    }

    function openEditModal(c) {
        if (!c) return;
        const modal = new bootstrap.Modal(document.getElementById('createCouponModal'));
        document.querySelector('#createCouponModal input[name="coupon_code"]').value = c.code || '';
        document.querySelector('#createCouponModal input[name="offer_name"]').value = c.name || '';
        document.querySelector('#createCouponModal select[name="discount_type"]').value = c.type || 'Percentage';
        document.querySelector('#createCouponModal input[name="discount_value"]').value = parseInt(c.discount.replace(/[^0-9]/g, '')) || 50;
        modal.show();
    }

    // Select all checkboxes
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('change', function () {
                document.querySelectorAll('#couponsTable tbody input[type="checkbox"]').forEach(c => c.checked = checkAll.checked);
            });
        }

        // Auto-select first coupon
        const firstRow = document.querySelector('.coupon-row');
        if (firstRow && @json(isset($coupons[0]))) {
            inspectCoupon(@json($coupons[0]), firstRow);
        }
    });
</script>
@endsection

