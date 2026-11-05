@extends('admin.layouts.admin')

@section('title', 'Banners & Promotions - Super Admin')

@section('styles')
<style>
    /* Custom Styling matching Screenshots 1 & 2 pixel-for-pixel */
    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        height: 100%;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .kpi-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .kpi-icon-purple  { background: #f5f3ff; color: #8b5cf6; }
    .kpi-icon-green   { background: #ecfdf5; color: #10b981; }
    .kpi-icon-yellow  { background: #fffbeb; color: #f59e0b; }
    .kpi-icon-red     { background: #fef2f2; color: #ef4444; }
    .kpi-icon-pink    { background: #fdf2f8; color: #ec4899; }
    .kpi-icon-blue    { background: #eff6ff; color: #3b82f6; }
    .kpi-icon-orange  { background: #fff7ed; color: #f97316; }

    /* Filter Tabs */
    .banner-tabs-nav {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .banner-tabs-nav .nav-link {
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
    .banner-tabs-nav .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .banner-tabs-nav .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .banner-tabs-nav .nav-link.active::after {
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
    .type-homepage   { background: #eff6ff; color: #2563eb; }
    .type-category   { background: #f5f3ff; color: #7c3aed; }
    .type-services   { background: #fef9c3; color: #854d0e; }
    .type-products   { background: #ffedd5; color: #c2410c; }
    .type-popup      { background: #fce7f3; color: #be185d; }
    .type-app_banner { background: #e0f2fe; color: #0284c7; }
    .type-sidebar    { background: #e0e7ff; color: #4338ca; }

    /* Platform Badges */
    .platform-pill {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        background: #f1f5f9;
        color: #475569;
    }
    .platform-web { background: #eff6ff; color: #1d4ed8; }
    .platform-app { background: #ecfdf5; color: #047857; }

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
    .status-inactive  { background: #fef2f2; color: #dc2626; }

    /* Table & Inspector */
    .banner-row {
        cursor: pointer;
        transition: background 0.15s ease;
    }
    .banner-row:hover {
        background-color: #f8fafc;
    }
    .banner-row.selected-row {
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

    .banner-thumb-img {
        width: 86px;
        height: 38px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        background: #0f172a;
    }

    /* Device Mockups */
    .laptop-frame {
        background: #0f172a;
        border-radius: 8px 8px 0 0;
        padding: 6px 6px 0 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .laptop-screen {
        background: #ffffff;
        border-radius: 4px 4px 0 0;
        overflow: hidden;
        font-size: 0.65rem;
    }
    .laptop-base {
        height: 6px;
        background: #cbd5e1;
        border-radius: 0 0 10px 10px;
        position: relative;
    }
    .laptop-base::after {
        content: '';
        position: absolute;
        top: 0;
        left: 45%;
        width: 10%;
        height: 3px;
        background: #94a3b8;
        border-radius: 0 0 3px 3px;
    }

    .phone-frame {
        background: #0f172a;
        border-radius: 14px;
        padding: 5px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        max-width: 120px;
    }
    .phone-screen {
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        font-size: 0.6rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header matching Screenshot 1 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Banners & Promotions</h4>
            <p class="text-muted small mb-0">Manage homepage banners, category banners, popup promotions and special campaigns across website and app.</p>
        </div>

        <div class="d-flex align-items-center flex-wrap gap-2">
            <button type="button" class="btn btn-primary btn-sm px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#createBannerModal">
                <i class="fa-solid fa-plus me-1"></i> Create Banner
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#manageCampaignsModal">
                <i class="fa-solid fa-bullhorn me-1 text-muted"></i> Manage Campaigns
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#bannerTemplatesModal">
                <i class="fa-solid fa-shapes me-1 text-muted"></i> Banner Templates
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm px-3 fw-medium dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-arrow-up-from-bracket me-1 text-muted"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item small" href="{{ route('admin.promotions.export', ['format' => 'csv']) }}">
                            <i class="fa-solid fa-file-excel me-2 text-success"></i> Download as Excel (CSV)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small" href="{{ route('admin.promotions.export', ['format' => 'pdf']) }}" onclick="window.print(); return false;">
                            <i class="fa-solid fa-file-pdf me-2 text-danger"></i> Download as PDF
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item small" href="{{ route('admin.promotions.export') }}">
                            <i class="fa-solid fa-filter me-2 text-primary"></i> Download Filtered Data
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 7 KPI Metrics Cards matching Screenshot 1 -->
    <div class="row g-2 mb-4">
        <!-- 1. Total Banners -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Banners</span>
                    <div class="kpi-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_banners'] }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.68rem;">↑ 18%</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['banners_sub'] }}</div>
            </div>
        </div>

        <!-- 2. Active Banners -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Active Banners</span>
                    <div class="kpi-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['active_banners'] }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['active_sub'] }}</div>
            </div>
        </div>

        <!-- 3. Scheduled -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Scheduled</span>
                    <div class="kpi-icon-circle kpi-icon-yellow">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['scheduled'] }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['scheduled_sub'] }}</div>
            </div>
        </div>

        <!-- 4. Inactive -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Inactive</span>
                    <div class="kpi-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-pause"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['inactive'] }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['inactive_sub'] }}</div>
            </div>
        </div>

        <!-- 5. Total Campaigns -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Campaigns</span>
                    <div class="kpi-icon-circle kpi-icon-pink">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_campaigns'] }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.68rem;">↑ 33%</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['campaigns_sub'] }}</div>
            </div>
        </div>

        <!-- 6. Total Views -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Views</span>
                    <div class="kpi-icon-circle kpi-icon-blue">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_views'] }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.68rem;">↑ 28%</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['views_sub'] }}</div>
            </div>
        </div>

        <!-- 7. Total Clicks -->
        <div class="col-12 col-sm-6 col-md-4 col-xl" style="min-width: 140px;">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Clicks</span>
                    <div class="kpi-icon-circle kpi-icon-orange">
                        <i class="fa-solid fa-arrow-pointer"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_clicks'] }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.68rem;">↑ 22%</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $stats['clicks_sub'] }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation Filter Tabs matching Screenshot 1 -->
    <ul class="nav banner-tabs-nav mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'all']) }}">
                All Banners ({{ $counts['all'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'homepage' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'homepage']) }}">
                Homepage ({{ $counts['homepage'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'category' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'category']) }}">
                Category ({{ $counts['category'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'popup' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'popup']) }}">
                Popup ({{ $counts['popup'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'app_banner' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'app_banner']) }}">
                App Banner ({{ $counts['app_banner'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'sidebar' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'sidebar']) }}">
                Sidebar ({{ $counts['sidebar'] }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'campaign_wise' ? 'active' : '' }}" href="{{ route('admin.promotions.index', ['tab' => 'campaign_wise']) }}">
                Campaign Wise ({{ $counts['campaign_wise'] }})
            </a>
        </li>
    </ul>

    <!-- Filter & Search Toolbar matching Screenshot 1 -->
    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 bg-white">
        <form method="GET" action="{{ route('admin.promotions.index') }}" class="row g-2 align-items-center">
            <input type="hidden" name="tab" value="{{ $currentTab }}">

            <!-- Search input -->
            <div class="col-12 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by title, campaign or link..." value="{{ $search }}">
                </div>
            </div>

            <!-- Banner Type -->
            <div class="col-6 col-md-3 col-lg-2">
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Banner Type</option>
                    <option value="Homepage" {{ $typeFilter === 'Homepage' ? 'selected' : '' }}>Homepage</option>
                    <option value="Category" {{ $typeFilter === 'Category' ? 'selected' : '' }}>Category</option>
                    <option value="Services" {{ $typeFilter === 'Services' ? 'selected' : '' }}>Services</option>
                    <option value="Products" {{ $typeFilter === 'Products' ? 'selected' : '' }}>Products</option>
                    <option value="Popup" {{ $typeFilter === 'Popup' ? 'selected' : '' }}>Popup</option>
                    <option value="App Banner" {{ $typeFilter === 'App Banner' ? 'selected' : '' }}>App Banner</option>
                    <option value="Sidebar" {{ $typeFilter === 'Sidebar' ? 'selected' : '' }}>Sidebar</option>
                </select>
            </div>

            <!-- Campaign -->
            <div class="col-6 col-md-3 col-lg-1">
                <select name="campaign" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Campaign</option>
                    <option value="Diwali 2026" {{ $campaignFilter === 'Diwali 2026' ? 'selected' : '' }}>Diwali 2026</option>
                    <option value="Career Boost" {{ $campaignFilter === 'Career Boost' ? 'selected' : '' }}>Career Boost</option>
                    <option value="Partner Growth" {{ $campaignFilter === 'Partner Growth' ? 'selected' : '' }}>Partner Growth</option>
                    <option value="Freelancer" {{ $campaignFilter === 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                    <option value="Tech Deals" {{ $campaignFilter === 'Tech Deals' ? 'selected' : '' }}>Tech Deals</option>
                    <option value="Educator Drive" {{ $campaignFilter === 'Educator Drive' ? 'selected' : '' }}>Educator Drive</option>
                    <option value="Student Month" {{ $campaignFilter === 'Student Month' ? 'selected' : '' }}>Student Month</option>
                    <option value="Bootcamp" {{ $campaignFilter === 'Bootcamp' ? 'selected' : '' }}>Bootcamp</option>
                    <option value="SaaS Promotion" {{ $campaignFilter === 'SaaS Promotion' ? 'selected' : '' }}>SaaS Promotion</option>
                    <option value="Travel" {{ $campaignFilter === 'Travel' ? 'selected' : '' }}>Travel</option>
                </select>
            </div>

            <!-- Status -->
            <div class="col-6 col-md-2 col-lg-1">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Status</option>
                    <option value="Active" {{ $statusFilter === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Scheduled" {{ $statusFilter === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="Inactive" {{ $statusFilter === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Platform -->
            <div class="col-6 col-md-2 col-lg-1">
                <select name="platform" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Platform</option>
                    <option value="Web" {{ $platformFilter === 'Web' ? 'selected' : '' }}>Web</option>
                    <option value="App" {{ $platformFilter === 'App' ? 'selected' : '' }}>App</option>
                </select>
            </div>

            <!-- Device View -->
            <div class="col-6 col-md-2 col-lg-1">
                <select name="device" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">Device View</option>
                    <option value="desktop">Desktop</option>
                    <option value="mobile">Mobile</option>
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
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0" style="font-size: 0.8rem;">Reset</a>
            </div>
        </form>
    </div>

    <!-- Main Content Row: Left Table (~68%) + Right Inspector Panel (~32%) -->
    <div class="row g-3">
        <!-- Left Table -->
        <div class="col-12 col-xl-8">
            <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0" id="bannersTable">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 32px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Banner Preview</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Campaign</th>
                                <th>Platform</th>
                                <th>Date Range</th>
                                <th>Status</th>
                                <th class="text-end">Views</th>
                                <th class="text-end">Clicks</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($banners as $idx => $b)
                                @php
                                    $typeClass = match(strtolower($b['type'])) {
                                        'homepage' => 'type-homepage',
                                        'category' => 'type-category',
                                        'services' => 'type-services',
                                        'products' => 'type-products',
                                        'popup'    => 'type-popup',
                                        'app banner' => 'type-app_banner',
                                        'sidebar'  => 'type-sidebar',
                                        default    => 'type-homepage',
                                    };
                                    $statusClass = match(strtolower($b['status'])) {
                                        'active'    => 'status-active',
                                        'scheduled' => 'status-scheduled',
                                        default     => 'status-inactive',
                                    };
                                @endphp
                                <tr class="banner-row {{ $idx === 0 ? 'selected-row' : '' }}" onclick='inspectBanner(@json($b), this)'>
                                    <td onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input"></td>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="position-relative overflow-hidden rounded border" style="width: 86px; height: 38px; background: {{ $b['banner_bg'] ?? '#0f172a' }};">
                                            @if(!empty($b['person_img']))
                                                <img src="{{ $b['person_img'] }}" alt="" style="position: absolute; right: 2px; bottom: 0; width: 28px; height: 34px; object-fit: contain;">
                                            @endif
                                            <div class="p-1 text-white" style="font-size: 0.55rem; line-height: 1.1; font-weight: 700; max-width: 58px;">
                                                <div style="font-size: 0.5rem; opacity: 0.9;">{{ Str::limit($b['tagline'] ?? $b['title'], 16) }}</div>
                                                <div style="color: #fbbf24; font-size: 0.6rem;">{{ $b['discount'] ?? 'OFFER' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark text-truncate" style="max-width: 140px;" title="{{ $b['title'] }}">
                                            {{ $b['title'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-pill {{ $typeClass }}">{{ $b['type'] }}</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary small">{{ $b['campaign'] }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            @foreach($b['platforms'] as $plt)
                                                <span class="platform-pill {{ $plt === 'Web' ? 'platform-web' : 'platform-app' }}">{{ $plt }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-muted" style="font-size: 0.75rem; white-space: nowrap;">
                                        {{ $b['date_range'] }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $statusClass }}">
                                            <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i>
                                            {{ $b['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-semibold text-dark">
                                        {{ $b['views'] }}
                                    </td>
                                    <td class="text-end fw-semibold text-dark">
                                        {{ $b['clicks'] }}
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 py-0 px-2" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item small" href="#" onclick='openEditModal(@json($b)); return false;'>
                                                        <i class="fa-regular fa-pen-to-square me-2 text-primary"></i> Edit Banner
                                                    </a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.promotions.duplicate', $b['id']) }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item small">
                                                            <i class="fa-regular fa-copy me-2 text-info"></i> Duplicate
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                @if($b['status'] === 'Active')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.promotions.toggle-status', $b['id']) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Inactive">
                                                            <button type="submit" class="dropdown-item small text-warning">
                                                                <i class="fa-solid fa-pause me-2"></i> Pause Banner
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.promotions.toggle-status', $b['id']) }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Active">
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-play me-2"></i> Activate Banner
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <form method="POST" action="{{ route('admin.promotions.destroy', $b['id']) }}" onsubmit="return confirm('Are you sure you want to delete this banner?');">
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
                                        <i class="fa-solid fa-images fs-2 mb-2 d-block text-secondary"></i>
                                        No banners found matching the selected filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Bar matching Screenshot 2 -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-light small gap-2">
                    <span class="text-muted">Showing 1 to {{ count($banners) }} of {{ $counts['all'] }} banners</span>
                    <div class="d-flex align-items-center gap-3">
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
                        <div class="d-flex align-items-center gap-1 text-muted">
                            <span>Show</span>
                            <select class="form-select form-select-sm py-0 px-2" style="width: 70px;">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span>per page</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Interactive Banner Details Inspector Panel matching Screenshots 1 & 2 -->
        <div class="col-12 col-xl-4">
            <div class="inspector-panel p-3 shadow-sm" id="bannerInspector">
                <!-- Header with Title & Edit button -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Banner Details</h6>
                    <button class="btn btn-sm btn-outline-secondary py-0.5 px-2" style="font-size: 0.75rem;" onclick="openEditModal(currentBanner)">
                        <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                    </button>
                </div>

                <!-- Large Graphical Banner Preview matching Screenshot 1 -->
                <div class="position-relative overflow-hidden rounded-3 mb-3 p-3 text-white shadow-sm" id="inspBannerGraphic" style="background: radial-gradient(circle at 70% 30%, #7f1d1d 0%, #450a0a 100%); min-height: 120px;">
                    <!-- Decorative elements / background glow -->
                    <div class="position-absolute" style="top: -20px; right: 20px; width: 100px; height: 100px; background: rgba(251, 191, 36, 0.15); filter: blur(20px); border-radius: 50%;"></div>
                    
                    <div class="row align-items-center position-relative">
                        <div class="col-7">
                            <div class="text-uppercase fw-semibold" style="color: #fde047; font-size: 0.65rem; letter-spacing: 0.5px;" id="inspGraphicTagline">
                                Special Diwali Offer
                            </div>
                            <div class="fw-bold text-white mb-1" style="font-size: 1.45rem; line-height: 1.1;" id="inspGraphicDiscount">
                                50% <span style="font-size: 0.95rem;">OFF</span>
                            </div>
                            <div class="badge bg-warning text-dark fw-bold px-2 py-1 rounded" style="font-size: 0.65rem;" id="inspGraphicCta">
                                Enroll Now
                            </div>
                        </div>
                        <div class="col-5 text-end">
                            <img id="inspGraphicPerson" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&auto=format&fit=crop&q=80" alt="Banner Graphic" class="img-fluid rounded" style="max-height: 90px; object-fit: contain;">
                        </div>
                    </div>
                </div>

                <!-- Banner Meta List matching Screenshot 1 -->
                <div class="bg-light p-2.5 rounded-2 mb-3 small" style="font-size: 0.78rem;">
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Title</div>
                        <div class="col-8 fw-semibold text-dark text-truncate" id="inspDetailTitle">Diwali Offer 2026</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Type</div>
                        <div class="col-8 text-dark" id="inspDetailType">Homepage Banner</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Campaign</div>
                        <div class="col-8 text-dark" id="inspDetailCampaign">Diwali 2026</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Platform</div>
                        <div class="col-8 text-dark" id="inspDetailPlatform">Website & App</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Link</div>
                        <div class="col-8 text-truncate">
                            <a id="inspDetailLink" href="https://digitalclass.in/diwali-offer" target="_blank" class="text-primary text-decoration-none">https://digitalclass.in/diwali-offer</a>
                        </div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Target</div>
                        <div class="col-8 text-dark" id="inspDetailTarget">All Users</div>
                    </div>
                    <div class="row g-1 mb-1.5">
                        <div class="col-4 text-muted">Date Range</div>
                        <div class="col-8 text-dark" id="inspDetailDateRange">20 Oct 2026 - 15 Nov 2026</div>
                    </div>
                    <div class="row g-1">
                        <div class="col-4 text-muted">Status</div>
                        <div class="col-8">
                            <span class="status-pill status-active py-0 px-2" id="inspDetailStatus">Active</span>
                        </div>
                    </div>
                </div>

                <!-- 3 Performance Metrics Pills matching Screenshot 1 -->
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="border rounded-2 p-2 text-center bg-white">
                            <div class="text-primary mb-1"><i class="fa-regular fa-eye"></i></div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatViews">24,560</div>
                            <div class="text-muted" style="font-size: 0.65rem;">Views</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded-2 p-2 text-center bg-white">
                            <div class="text-success mb-1"><i class="fa-solid fa-arrow-pointer"></i></div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatClicks">3,420</div>
                            <div class="text-muted" style="font-size: 0.65rem;">Clicks</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded-2 p-2 text-center bg-white">
                            <div class="text-purple mb-1" style="color: #8b5cf6;"><i class="fa-solid fa-chart-line"></i></div>
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;" id="inspStatCtr">13.9%</div>
                            <div class="text-muted" style="font-size: 0.65rem;">CTR</div>
                        </div>
                    </div>
                </div>

                <!-- Device View Tabs: Web View | App View matching Screenshot 1 -->
                <ul class="nav nav-pills mb-2 small" id="devicePreviewTabs" style="font-size: 0.75rem;">
                    <li class="nav-item">
                        <a class="nav-link active py-1 px-3 fw-semibold" href="#tabWebPreview" data-bs-toggle="pill" onclick="setDeviceMode('web')">Web View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-3 fw-semibold text-muted" href="#tabAppPreview" data-bs-toggle="pill" onclick="setDeviceMode('app')">App View</a>
                    </li>
                </ul>

                <!-- Device Mockup Screen matching Screenshot 1 & 2 -->
                <div class="border rounded-3 p-3 bg-light mb-3">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <!-- Laptop Mockup (Web View) -->
                        <div class="flex-grow-1" id="laptopMockupContainer" style="max-width: 240px;">
                            <div class="laptop-frame">
                                <div class="laptop-screen p-1">
                                    <!-- Mini browser bar -->
                                    <div class="d-flex align-items-center gap-1 border-bottom pb-1 mb-1 text-muted" style="font-size: 0.5rem;">
                                        <i class="fa-solid fa-circle text-danger" style="font-size: 0.35rem;"></i>
                                        <i class="fa-solid fa-circle text-warning" style="font-size: 0.35rem;"></i>
                                        <i class="fa-solid fa-circle text-success" style="font-size: 0.35rem;"></i>
                                        <span class="bg-light px-1 rounded flex-grow-1 text-truncate">digitalclass.in</span>
                                    </div>
                                    <!-- Mini Web Header -->
                                    <div class="d-flex justify-content-between align-items-center px-1 mb-1" style="font-size: 0.5rem;">
                                        <span class="fw-bold text-primary">DigitalClass</span>
                                        <span class="text-muted">Courses • Services</span>
                                    </div>
                                    <!-- Mini Banner in Laptop Screen -->
                                    <div class="rounded p-1.5 text-white position-relative overflow-hidden" id="mockupWebBanner" style="background: radial-gradient(circle at 70% 30%, #7f1d1d 0%, #450a0a 100%); min-height: 48px;">
                                        <div style="font-size: 0.5rem; font-weight: 700; color: #fde047;" id="mockWebTagline">Special Diwali Offer</div>
                                        <div style="font-size: 0.75rem; font-weight: 800; line-height: 1;" id="mockWebDiscount">50% OFF</div>
                                        <span class="badge bg-warning text-dark py-0 px-1 mt-1" style="font-size: 0.45rem;">Enroll Now</span>
                                    </div>
                                </div>
                            </div>
                            <div class="laptop-base"></div>
                        </div>

                        <!-- Phone Mockup (App View) -->
                        <div class="phone-frame" id="phoneMockupContainer">
                            <div class="phone-screen p-1 text-center">
                                <!-- Status bar -->
                                <div class="d-flex justify-content-between align-items-center text-muted mb-1 px-1" style="font-size: 0.45rem;">
                                    <span>9:41</span>
                                    <div class="d-flex gap-0.5">
                                        <i class="fa-solid fa-signal" style="font-size: 0.4rem;"></i>
                                        <i class="fa-solid fa-battery-full" style="font-size: 0.4rem;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold text-primary mb-1" style="font-size: 0.55rem;">DigitalClass App</div>
                                <!-- Mini Banner in Phone Screen -->
                                <div class="rounded p-1 text-white text-start position-relative overflow-hidden" id="mockupAppBanner" style="background: radial-gradient(circle at 70% 30%, #7f1d1d 0%, #450a0a 100%); min-height: 54px;">
                                    <div style="font-size: 0.45rem; font-weight: 700; color: #fde047;" id="mockAppTagline">Diwali Offer</div>
                                    <div style="font-size: 0.7rem; font-weight: 800; line-height: 1;" id="mockAppDiscount">50% OFF</div>
                                    <span class="badge bg-warning text-dark py-0 px-1 mt-0.5" style="font-size: 0.4rem;">Enroll</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Bar matching Screenshot 2 -->
                <div class="mb-1">
                    <span class="fw-bold text-dark small text-uppercase d-block mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Quick Actions</span>
                    <div class="d-flex flex-wrap gap-1.5">
                        <form method="POST" action="{{ route('admin.promotions.toggle-status', 1) }}" id="inspActivateForm" class="flex-fill">
                            @csrf
                            <input type="hidden" name="status" value="Active">
                            <button type="submit" class="btn btn-success btn-sm w-100 fw-medium" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-check me-1"></i> Activate
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.promotions.toggle-status', 1) }}" id="inspDeactivateForm" class="flex-fill">
                            @csrf
                            <input type="hidden" name="status" value="Inactive">
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-medium" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-pause me-1"></i> Deactivate
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.promotions.duplicate', 1) }}" id="inspDuplicateForm" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm w-100 fw-medium" style="font-size: 0.75rem;">
                                <i class="fa-regular fa-copy me-1"></i> Duplicate
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.promotions.destroy', 1) }}" id="inspDeleteForm" onsubmit="return confirm('Delete this banner permanently?');" class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-medium" style="font-size: 0.75rem;">
                                <i class="fa-regular fa-trash-can me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Modal 1: Create Banner Modal -->
<div class="modal fade" id="createBannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.promotions.store') }}">
                @csrf
                <div class="modal-header border-bottom pb-3">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-plus text-primary me-2"></i>Create New Banner</h5>
                    <button type="button" class="btn-close" data-bs-toggle="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Banner Title *</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. New Year Learning Festival 2027" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Banner Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="Homepage">Homepage Slider</option>
                                <option value="Category">Category Header</option>
                                <option value="Services">Services Promotion</option>
                                <option value="Products">Products Deal</option>
                                <option value="Popup">Promotional Popup</option>
                                <option value="App Banner">Mobile App Banner</option>
                                <option value="Sidebar">Sidebar Widget</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Campaign Name</label>
                            <input type="text" name="campaign" class="form-control" placeholder="e.g. Diwali 2026, Career Boost">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Target Audience</label>
                            <input type="text" name="target" class="form-control" placeholder="e.g. All Users, Students & Professionals">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Destination URL / Deep Link</label>
                            <input type="url" name="link" class="form-control" placeholder="https://digitalclass.in/courses/offer">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Target Platforms</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="platforms[]" value="Web" id="pltWeb" checked>
                                    <label class="form-check-label small" for="pltWeb">Website (Desktop & Tablet)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="platforms[]" value="App" id="pltApp" checked>
                                    <label class="form-check-label small" for="pltApp">Mobile App (Android & iOS)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-medium">Save & Publish Banner</button>
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
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-bullhorn text-warning me-2"></i>Manage Campaigns</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Campaign Name</th>
                                <th>Active Banners</th>
                                <th>Date Schedule</th>
                                <th>Total Views</th>
                                <th>Total Clicks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-dark">Diwali 2026</td>
                                <td>3 Banners</td>
                                <td>20 Oct - 15 Nov 2026</td>
                                <td>48,920</td>
                                <td>6,840</td>
                                <td><span class="badge bg-success-subtle text-success">Running</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-dark">Career Boost</td>
                                <td>2 Banners</td>
                                <td>01 Oct - 31 Oct 2026</td>
                                <td>32,450</td>
                                <td>3,910</td>
                                <td><span class="badge bg-success-subtle text-success">Running</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-dark">Partner Growth</td>
                                <td>2 Banners</td>
                                <td>05 Sep - 31 Oct 2026</td>
                                <td>28,120</td>
                                <td>3,140</td>
                                <td><span class="badge bg-success-subtle text-success">Running</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-dark">Student Month</td>
                                <td>2 Banners</td>
                                <td>01 Oct - 31 Oct 2026</td>
                                <td>19,760</td>
                                <td>2,240</td>
                                <td><span class="badge bg-success-subtle text-success">Running</span></td>
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

<!-- Modal 3: Banner Templates Modal -->
<div class="modal fade" id="bannerTemplatesModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-shapes text-primary me-2"></i>Official Banner Size Specifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="fw-bold text-dark mb-1">Homepage Slider Banner</div>
                            <div class="text-primary fw-semibold fs-5">1920 × 600 px</div>
                            <div class="text-muted small mt-1">Aspect Ratio 16:5. Rendered on the homepage carousel across all web and tablet viewports.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="fw-bold text-dark mb-1">Category & Subcategory Header</div>
                            <div class="text-primary fw-semibold fs-5">1200 × 300 px</div>
                            <div class="text-muted small mt-1">Aspect Ratio 4:1. Shown at the top of category filters (Courses, Services, Products).</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="fw-bold text-dark mb-1">Mobile App Carousel Banner</div>
                            <div class="text-primary fw-semibold fs-5">1080 × 450 px</div>
                            <div class="text-muted small mt-1">Aspect Ratio 12:5. Optimized for mobile app displays with clean centered CTA buttons.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="fw-bold text-dark mb-1">Promotional Modal Popup</div>
                            <div class="text-primary fw-semibold fs-5">600 × 600 px</div>
                            <div class="text-muted small mt-1">Aspect Ratio 1:1 Square. Used for time-sensitive festive discounts and flash deals.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top pt-3">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentBanner = @json($banners[0] ?? []);

    function inspectBanner(b, rowElement) {
        currentBanner = b;

        // Highlight selected row
        document.querySelectorAll('.banner-row').forEach(r => r.classList.remove('selected-row'));
        if (rowElement) {
            rowElement.classList.add('selected-row');
        }

        // Update Graphic Card
        const gBox = document.getElementById('inspBannerGraphic');
        if (gBox) {
            gBox.style.background = b.banner_bg || 'radial-gradient(circle at 70% 30%, #7f1d1d 0%, #450a0a 100%)';
        }

        const gTagline = document.getElementById('inspGraphicTagline');
        if (gTagline) gTagline.innerText = b.tagline || b.title;

        const gDiscount = document.getElementById('inspGraphicDiscount');
        if (gDiscount) gDiscount.innerHTML = `${b.discount || 'SPECIAL OFFER'}`;

        const gCta = document.getElementById('inspGraphicCta');
        if (gCta) gCta.innerText = b.cta_text || 'Learn More';

        const gPerson = document.getElementById('inspGraphicPerson');
        if (gPerson) {
            gPerson.src = b.person_img || b.preview_img || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&auto=format&fit=crop&q=80';
        }

        // Update Meta Info
        const dTitle = document.getElementById('inspDetailTitle');
        if (dTitle) dTitle.innerText = b.title;

        const dType = document.getElementById('inspDetailType');
        if (dType) dType.innerText = `${b.type} Banner`;

        const dCampaign = document.getElementById('inspDetailCampaign');
        if (dCampaign) dCampaign.innerText = b.campaign;

        const dPlatform = document.getElementById('inspDetailPlatform');
        if (dPlatform) dPlatform.innerText = b.platforms ? b.platforms.join(' & ') : 'Website & App';

        const dLink = document.getElementById('inspDetailLink');
        if (dLink) {
            dLink.href = b.link || '#';
            dLink.innerText = b.link || 'https://digitalclass.in';
        }

        const dTarget = document.getElementById('inspDetailTarget');
        if (dTarget) dTarget.innerText = b.target || 'All Users';

        const dDates = document.getElementById('inspDetailDateRange');
        if (dDates) dDates.innerText = b.date_range;

        const dStatus = document.getElementById('inspDetailStatus');
        if (dStatus) {
            dStatus.innerText = b.status;
            dStatus.className = `status-pill status-${(b.status || 'active').toLowerCase()} py-0 px-2`;
        }

        // Update Stats
        const sViews = document.getElementById('inspStatViews');
        if (sViews) sViews.innerText = b.views || '0';

        const sClicks = document.getElementById('inspStatClicks');
        if (sClicks) sClicks.innerText = b.clicks || '0';

        const sCtr = document.getElementById('inspStatCtr');
        if (sCtr) sCtr.innerText = b.ctr || '0.0%';

        // Update Device Mockup
        const mWebBanner = document.getElementById('mockupWebBanner');
        if (mWebBanner) mWebBanner.style.background = b.banner_bg || '#1e3a8a';

        const mWebTag = document.getElementById('mockWebTagline');
        if (mWebTag) mWebTag.innerText = b.tagline || b.title;

        const mWebDisc = document.getElementById('mockWebDiscount');
        if (mWebDisc) mWebDisc.innerText = b.discount || 'OFFER';

        const mAppBanner = document.getElementById('mockupAppBanner');
        if (mAppBanner) mAppBanner.style.background = b.banner_bg || '#1e3a8a';

        const mAppTag = document.getElementById('mockAppTagline');
        if (mAppTag) mAppTag.innerText = b.tagline || b.title;

        const mAppDisc = document.getElementById('mockAppDiscount');
        if (mAppDisc) mAppDisc.innerText = b.discount || 'OFFER';

        // Update Actions
        const actForm = document.getElementById('inspActivateForm');
        if (actForm) actForm.action = `/admin/promotions/${b.id}/toggle-status`;

        const deactForm = document.getElementById('inspDeactivateForm');
        if (deactForm) deactForm.action = `/admin/promotions/${b.id}/toggle-status`;

        const dupForm = document.getElementById('inspDuplicateForm');
        if (dupForm) dupForm.action = `/admin/promotions/${b.id}/duplicate`;

        const delForm = document.getElementById('inspDeleteForm');
        if (delForm) delForm.action = `/admin/promotions/${b.id}`;
    }

    function setDeviceMode(mode) {
        const laptop = document.getElementById('laptopMockupContainer');
        const phone = document.getElementById('phoneMockupContainer');
        if (mode === 'web') {
            if (laptop) laptop.style.opacity = '1';
            if (phone) phone.style.opacity = '0.6';
        } else {
            if (laptop) laptop.style.opacity = '0.6';
            if (phone) phone.style.opacity = '1';
        }
    }

    function openEditModal(b) {
        if (!b) return;
        const modal = new bootstrap.Modal(document.getElementById('createBannerModal'));
        document.querySelector('#createBannerModal input[name="title"]').value = b.title || '';
        document.querySelector('#createBannerModal select[name="type"]').value = b.type || 'Homepage';
        document.querySelector('#createBannerModal input[name="campaign"]').value = b.campaign || '';
        document.querySelector('#createBannerModal input[name="link"]').value = b.link || '';
        modal.show();
    }

    // Select all checkboxes
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('change', function () {
                document.querySelectorAll('#bannersTable tbody input[type="checkbox"]').forEach(c => c.checked = checkAll.checked);
            });
        }

        // Initialize first banner
        const firstRow = document.querySelector('.banner-row');
        if (firstRow && @json(isset($banners[0]))) {
            inspectBanner(@json($banners[0]), firstRow);
        }
    });
</script>
@endsection
