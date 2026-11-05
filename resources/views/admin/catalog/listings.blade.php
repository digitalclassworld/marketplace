@extends('admin.layouts.admin')

@section('title', 'Business Listings Management - Super Admin')

@section('styles')
<style>
    .listing-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .listing-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
    .kpi-icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .kpi-icon-yellow { background: #fefce8; color: #ca8a04; }
    .kpi-icon-green  { background: #ecfdf5; color: #059669; }
    .kpi-icon-amber  { background: #fffbeb; color: #d97706; }
    .kpi-icon-red    { background: #fef2f2; color: #dc2626; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .kpi-icon-blue   { background: #eff6ff; color: #2563eb; }

    .nav-tabs-listings {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .nav-tabs-listings .nav-link {
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
    .nav-tabs-listings .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .nav-tabs-listings .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-listings .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    .listing-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .listing-row:hover {
        background-color: #f8fafc;
    }
    .listing-row.selected-row {
        background-color: #eff6ff;
    }

    .status-pill {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.65rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .status-pill.active   { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .status-pill.pending  { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-pill.rejected { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    .plan-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
    }
    .plan-badge.premium  { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
    .plan-badge.standard { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .plan-badge.free     { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    .cat-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
    }
    .cat-education     { background: #eff6ff; color: #1d4ed8; }
    .cat-fitness       { background: #fdf2f8; color: #db2777; }
    .cat-healthcare    { background: #ecfeff; color: #0891b2; }
    .cat-design        { background: #f5f3ff; color: #7c3aed; }
    .cat-automotive    { background: #fff7ed; color: #ea580c; }
    .cat-homegarden    { background: #f0fdf4; color: #16a34a; }
    .cat-electronics   { background: #e0e7ff; color: #4338ca; }
    .cat-foodbeverage  { background: #fefce8; color: #ca8a04; }

    .inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        position: sticky;
        top: 80px;
    }
    .inspector-cover {
        height: 140px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        position: relative;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header matching Screenshot 2 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Business Listings Management</h4>
            <p class="text-muted small mb-0">Manage all businesses listed on Digital Class. Approve, edit, feature and track performance.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.coming-soon', 'import-listings') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-file-import me-1 text-muted"></i> Import Listings
            </a>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm px-3 fw-medium dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-arrow-up-from-bracket me-1 text-muted"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><a class="dropdown-item small" href="#"><i class="fa-regular fa-file-excel text-success me-2"></i> Download as Excel</a></li>
                    <li><a class="dropdown-item small" href="#"><i class="fa-regular fa-file-pdf text-danger me-2"></i> Download as PDF</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-filter text-primary me-2"></i> Download Filtered Data</a></li>
                </ul>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-primary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-plus me-1"></i> Add Business
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div class="fw-medium small">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 6 KPI Metrics Cards matching Screenshot 2 -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Listings -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="listing-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Listings</span>
                    <div class="kpi-icon-circle kpi-icon-yellow">
                        <i class="fa-solid fa-building"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total'] ?? '6,320' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 14%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">+780 this month</div>
            </div>
        </div>

        <!-- Card 2: Active Listings -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="listing-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Active Listings</span>
                    <div class="kpi-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['active'] ?? '5,120' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 18%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">81% of total</div>
            </div>
        </div>

        <!-- Card 3: Pending Approval -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="listing-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Pending Approval</span>
                    <div class="kpi-icon-circle kpi-icon-amber">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['pending'] ?? '720' }}</span>
                    <span class="badge bg-danger-subtle text-danger small fw-semibold">↓ 12%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Needs review</div>
            </div>
        </div>

        <!-- Card 4: Rejected Listings -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="listing-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Rejected Listings</span>
                    <div class="kpi-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['rejected'] ?? '260' }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">4% of total</div>
            </div>
        </div>

        <!-- Card 5: Featured Listings -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="listing-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Featured Listings</span>
                    <div class="kpi-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['featured'] ?? '380' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 26%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">6% of total</div>
            </div>
        </div>

        <!-- Card 6: Top Performing -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="listing-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Top Performing</span>
                    <div class="kpi-icon-circle kpi-icon-yellow">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['top_performing'] ?? '420' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 32%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Based on views & inquiries</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs matching Screenshot 2 -->
    <div class="mb-3">
        <nav class="nav nav-tabs-listings">
            <a href="{{ route('admin.catalog.listings') }}" class="nav-link {{ (!request('status') || request('status') === 'all') && !request('tab') ? 'active' : '' }}">
                All Listings ({{ number_format($counts['all'] ?? 6320) }})
            </a>
            <a href="{{ route('admin.catalog.listings', ['status' => 'active']) }}" class="nav-link {{ request('status') === 'active' || request('tab') === 'active' || request('status') === 'approved' ? 'active' : '' }}">
                Active ({{ number_format($counts['active'] ?? 5120) }})
            </a>
            <a href="{{ route('admin.catalog.listings', ['status' => 'pending']) }}" class="nav-link {{ request('status') === 'pending' || request('tab') === 'pending' ? 'active' : '' }}">
                Pending ({{ number_format($counts['pending'] ?? 720) }})
            </a>
            <a href="{{ route('admin.catalog.listings', ['status' => 'rejected']) }}" class="nav-link {{ request('status') === 'rejected' || request('tab') === 'rejected' ? 'active' : '' }}">
                Rejected ({{ number_format($counts['rejected'] ?? 260) }})
            </a>
            <a href="{{ route('admin.catalog.listings', ['status' => 'featured']) }}" class="nav-link {{ request('status') === 'featured' || request('tab') === 'featured' ? 'active' : '' }}">
                Featured ({{ number_format($counts['featured'] ?? 380) }})
            </a>
            <a href="{{ route('admin.catalog.listings', ['status' => 'popular']) }}" class="nav-link {{ request('status') === 'popular' || request('tab') === 'popular' ? 'active' : '' }}">
                Popular ({{ number_format($counts['popular'] ?? 100) }})
            </a>
            <a href="{{ route('admin.catalog.listings', ['status' => 'new']) }}" class="nav-link {{ request('status') === 'new' || request('tab') === 'new' ? 'active' : '' }}">
                New ({{ number_format($counts['new'] ?? 420) }})
            </a>
        </nav>
    </div>

    <!-- 2-Row Filter & Search Toolbar matching Screenshot 2 -->
    <div class="bg-white p-3 rounded-3 border mb-3">
        <form method="GET" action="{{ route('admin.catalog.listings') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Row 1 -->
            <div class="row g-2 align-items-center mb-2">
                <div class="col-12 col-lg-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 ps-0" placeholder="Search by business name, owner, or ID...">
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">All Categories</option>
                        <option value="Education" {{ request('category') === 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Fitness" {{ request('category') === 'Fitness' ? 'selected' : '' }}>Fitness</option>
                        <option value="Healthcare" {{ request('category') === 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Design" {{ request('category') === 'Design' ? 'selected' : '' }}>Design</option>
                        <option value="Automotive" {{ request('category') === 'Automotive' ? 'selected' : '' }}>Automotive</option>
                        <option value="Home & Garden" {{ request('category') === 'Home & Garden' ? 'selected' : '' }}>Home & Garden</option>
                        <option value="Electronics" {{ request('category') === 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Food & Beverage" {{ request('category') === 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select class="form-select form-select-sm text-muted">
                        <option>All Sub Categories</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="city" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">All Cities</option>
                        <option value="Ahmedabad" {{ request('city') === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                        <option value="Surat" {{ request('city') === 'Surat' ? 'selected' : '' }}>Surat</option>
                        <option value="Vadodara" {{ request('city') === 'Vadodara' ? 'selected' : '' }}>Vadodara</option>
                        <option value="Rajkot" {{ request('city') === 'Rajkot' ? 'selected' : '' }}>Rajkot</option>
                        <option value="Mumbai" {{ request('city') === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="verification" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Verification Status</option>
                        <option value="verified">Verified</option>
                        <option value="unverified">Unverified</option>
                    </select>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row g-2 align-items-center">
                <div class="col-6 col-lg-2">
                    <select class="form-select form-select-sm text-muted">
                        <option>Listing Type</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="plan" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Plan Type</option>
                        <option value="Premium" {{ request('plan') === 'Premium' ? 'selected' : '' }}>Premium</option>
                        <option value="Standard" {{ request('plan') === 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Free" {{ request('plan') === 'Free' ? 'selected' : '' }}>Free</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="featured_status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Featured Status</option>
                        <option value="featured">Featured</option>
                        <option value="not_featured">Non-Featured</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select class="form-select form-select-sm text-muted">
                        <option>Join Date</option>
                    </select>
                </div>

                <div class="col-8 col-lg-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0 text-muted p-1">
                            <i class="fa-regular fa-calendar" style="font-size:0.75rem;"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" style="font-size: 0.7rem;" value="01 Oct 2026 - 31 Oct 2026" readonly>
                    </div>
                </div>

                <div class="col-4 col-lg-2 text-end">
                    <a href="{{ route('admin.catalog.listings') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Content Area: Table + Right Inspector Panel -->
    <div class="row g-3">
        <!-- Left: Business Listings Table -->
        <div class="col-12 col-xl-8">
            <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0" id="listingsTable">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 32px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Business Details</th>
                                <th>Owner</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Plan</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Inquiries</th>
                                <th>Status</th>
                                <th class="text-center">Featured</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($listings as $idx => $l)
                                @php
                                    $id = $l['id'];
                                    $code = $l['code'];
                                    $name = $l['business_name'];
                                    $fullName = $l['full_name'];
                                    $slug = $l['slug'];
                                    $ownerName = $l['owner_name'];
                                    $category = $l['category'];
                                    $location = $l['location'];
                                    $plan = $l['plan'];
                                    $views = $l['views'];
                                    $inquiries = $l['inquiries'];
                                    $statusText = $l['status'];
                                    $isFeatured = !empty($l['is_featured']);
                                    $logo = $l['logo'];

                                    $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $category));
                                    $statusClass = match(strtolower($statusText)) {
                                        'active' => 'active',
                                        'pending' => 'pending',
                                        default => 'rejected',
                                    };
                                    $planClass = match(strtolower($plan)) {
                                        'premium' => 'premium',
                                        'standard' => 'standard',
                                        default => 'free',
                                    };
                                @endphp
                                <tr class="listing-row {{ $idx === 0 ? 'selected-row' : '' }}" onclick='inspectListing(@json($l), this)'>
                                    <td onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input"></td>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $logo }}" alt="{{ $name }}" class="rounded border p-1" style="width: 38px; height: 38px; object-fit: contain; background: #fff;">
                                            <div>
                                                <div class="fw-semibold text-dark text-truncate" style="max-width: 150px;">{{ $name }}</div>
                                                <div class="text-muted font-monospace" style="font-size: 0.68rem;">ID: {{ $code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium">{{ $ownerName }}</span>
                                    </td>
                                    <td>
                                        <span class="cat-badge cat-{{ $catSlug }}">{{ $category }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $location }}</span>
                                    </td>
                                    <td>
                                        <span class="plan-badge {{ $planClass }}">{{ $plan }}</span>
                                    </td>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ number_format($views) }}
                                    </td>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ number_format($inquiries) }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $statusClass }}">
                                            <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i>
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        <form method="POST" action="{{ route('admin.catalog.listings.toggle-featured', $id) }}" class="d-inline">
                                            @csrf
                                            <div class="form-check form-switch d-inline-block p-0 m-0">
                                                <input class="form-check-input ms-0" type="checkbox" role="switch" {{ $isFeatured ? 'checked' : '' }} onchange="this.form.submit()">
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 py-0 px-2" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item small" href="{{ url('/business/' . $slug) }}" target="_blank">
                                                        <i class="fa-solid fa-arrow-up-right-from-square me-2 text-primary"></i> View Public Listing
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                @if(strtolower($statusText) !== 'active')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.catalog.listings.approve', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-check me-2"></i> Approve Listing
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if(strtolower($statusText) !== 'rejected')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.catalog.listings.reject', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-danger">
                                                                <i class="fa-solid fa-xmark me-2"></i> Reject Listing
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item small" href="{{ url('/business/' . $slug) }}" target="_blank">
                                                        <i class="fa-regular fa-pen-to-square me-2 text-muted"></i> Edit Listing
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-building fs-1 mb-2 text-muted"></i>
                                        <p class="mb-0">No business directory listings found matching the criteria.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Bar -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light small">
                    <span class="text-muted">Showing 1 to {{ count($listings) }} of {{ number_format($counts['all'] ?? 6320) }} listings</span>
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

        <!-- Right: Interactive Business Listing Inspector Panel matching Screenshot 2 -->
        <div class="col-12 col-xl-4">
            <div class="inspector-panel p-3 shadow-sm" id="listingInspector">
                <!-- Cover Photo Banner with Overlay Logo & Edit Button -->
                <div class="inspector-cover mb-3 shadow-sm" id="inspCover" style="background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=800&auto=format&fit=crop&q=80');">
                    <div class="d-flex justify-content-between p-2">
                        <span class="status-pill active" id="inspStatus">Active</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-dark bg-opacity-75 border-0 text-white py-0 px-2" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-pen-to-square me-1"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-light border-0 text-muted p-1" onclick="document.getElementById('listingInspector').classList.toggle('d-none')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-2 bg-white rounded p-1 shadow-sm d-flex align-items-center gap-1">
                        <img id="inspLogo" src="https://ui-avatars.com/api/?name=VCEC&background=0066ff&color=fff" alt="Logo" style="width: 38px; height: 38px; object-fit: contain;">
                        <span class="fw-bold text-dark font-monospace small px-1" id="inspLogoText">VCEC</span>
                    </div>
                </div>

                <!-- Business Name & Info Header -->
                <div class="mb-2">
                    <h5 class="fw-bold text-dark mb-1" id="inspTitle">VCEC - Vinayak Computer Education Center</h5>
                    <div class="text-muted small">
                        <span class="font-monospace" id="inspCode">ID: BL00125</span> · Listed on: <span class="fw-medium text-dark" id="inspListedOn">12 Jan 2024</span> · <i class="fa-solid fa-star text-warning"></i> <span class="fw-semibold text-dark" id="inspRating">4.8 (320 reviews)</span>
                    </div>
                </div>

                <!-- Action Buttons: View Listing | Edit Listing | ... -->
                <div class="d-flex gap-2 mb-3">
                    <a id="inspViewListingBtn" href="{{ url('/business/vcec') }}" target="_blank" class="btn btn-primary btn-sm flex-fill fw-medium">
                        View Listing
                    </a>
                    <a id="inspEditListingBtn" href="{{ url('/business/vcec') }}" class="btn btn-outline-secondary btn-sm flex-fill fw-medium">
                        Edit Listing
                    </a>
                    <button class="btn btn-outline-secondary btn-sm px-2">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                </div>

                <!-- Navigation Tabs: Overview | Gallery (12) | Reviews (320) | Inquiries (320) -->
                <ul class="nav nav-pills nav-fill mb-3 border-bottom pb-2 small" id="inspectorTabs">
                    <li class="nav-item">
                        <a class="nav-link active py-1 px-2 fw-semibold" style="font-size: 0.78rem;" href="#tabOverview" data-bs-toggle="pill">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabGallery" data-bs-toggle="pill">Gallery (12)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabReviews" data-bs-toggle="pill" id="inspReviewsTab">Reviews (320)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabInquiries" data-bs-toggle="pill" id="inspInquiriesTab">Inquiries (320)</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Overview -->
                    <div class="tab-pane fade show active" id="tabOverview">
                        <!-- Business Information Section matching Screenshot 2 -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Business Information</span>
                                <a href="#" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                                </a>
                            </div>
                            <div class="bg-light p-2 rounded-2 small" style="font-size: 0.78rem;">
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Business Name</div>
                                    <div class="col-8 fw-semibold text-dark text-truncate" id="inspDetailName">VCEC - Vinayak Computer</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Category</div>
                                    <div class="col-8 text-dark" id="inspDetailCategory">Education</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Sub Category</div>
                                    <div class="col-8 text-dark text-truncate" id="inspDetailSubCat">Computer Training Institute</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Owner Name</div>
                                    <div class="col-8 text-dark fw-medium" id="inspDetailOwner">Hitesh Mohkar</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Contact</div>
                                    <div class="col-8 text-dark" id="inspDetailContact">+91 98765 43210</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Email</div>
                                    <div class="col-8 text-dark text-truncate" id="inspDetailEmail">info@vcec.in</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Address</div>
                                    <div class="col-8 text-dark text-truncate" id="inspDetailAddress">Nikol, Ahmedabad, Gujarat</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Plan Type</div>
                                    <div class="col-8 text-dark" id="inspDetailPlan">Premium (Valid till 12 Jan 2027)</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Views</div>
                                    <div class="col-8 text-dark fw-semibold" id="inspDetailViews">12,450</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Inquiries</div>
                                    <div class="col-8 text-dark fw-semibold" id="inspDetailInquiries">320</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Status</div>
                                    <div class="col-8 text-dark" id="inspDetailStatus">Active</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Featured</div>
                                    <div class="col-8 text-dark" id="inspDetailFeatured">Yes</div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-4 text-muted">Verification</div>
                                    <div class="col-8 text-primary fw-semibold" id="inspDetailVerification">
                                        <i class="fa-solid fa-circle-check"></i> Verified
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Owner Information Section matching Screenshot 2 -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Owner Information</span>
                                <a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">View Profile</a>
                            </div>
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <img id="inspOwnerAvatar" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Owner" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark small" id="inspOwnerName">Hitesh Mohkar</div>
                                        <div class="text-muted font-monospace" style="font-size: 0.68rem;" id="inspOwnerId">ID: UDC00125</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-phone text-muted" style="font-size: 0.65rem;"></i> <span id="inspOwnerPhone">+91 98765 43210</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.7rem;" id="inspOwnerEmail">hitesh@digitalclass.in</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions matching Screenshot 2 -->
                        <div class="pt-2 border-top">
                            <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Quick Actions</div>
                            <div class="d-flex flex-wrap gap-2">
                                <form id="inspApproveForm" method="POST" action="{{ route('admin.catalog.listings.approve', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <form id="inspRejectForm" method="POST" action="{{ route('admin.catalog.listings.reject', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </form>
                                <form id="inspFeatureForm" method="POST" action="{{ route('admin.catalog.listings.toggle-featured', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-star me-1"></i> Feature Toggle
                                    </button>
                                </form>
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm flex-fill" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-comment-dots me-1"></i> Message
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Gallery -->
                    <div class="tab-pane fade" id="tabGallery">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-images fs-4 mb-2 text-primary"></i>
                            <p class="mb-0">12 storefront and interior photos uploaded.</p>
                        </div>
                    </div>

                    <!-- Tab 3: Reviews -->
                    <div class="tab-pane fade" id="tabReviews">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-star fs-4 mb-2 text-warning"></i>
                            <p class="mb-0 fw-bold text-dark">4.8 out of 5.0 (320 reviews)</p>
                        </div>
                    </div>

                    <!-- Tab 4: Inquiries -->
                    <div class="tab-pane fade" id="tabInquiries">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-envelope fs-4 mb-2 text-success"></i>
                            <p class="mb-0 fw-bold text-dark">320 Leads & Inquiries Received</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Master checkbox select-all
    document.getElementById('checkAll')?.addEventListener('change', function () {
        document.querySelectorAll('#listingsTable tbody input[type="checkbox"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // Interactive Right Inspector Panel Updater
    function inspectListing(l, rowElem) {
        if (!l) return;

        // Highlight selected row
        document.querySelectorAll('.listing-row').forEach(r => r.classList.remove('selected-row'));
        if (rowElem) {
            rowElem.classList.add('selected-row');
        }

        // Make sure inspector is visible
        const inspector = document.getElementById('listingInspector');
        if (inspector) inspector.classList.remove('d-none');

        // Cover & Logo update
        const cover = document.getElementById('inspCover');
        if (cover && l.cover_image) {
            cover.style.backgroundImage = `url('${l.cover_image}')`;
        }

        const logo = document.getElementById('inspLogo');
        if (logo) logo.src = l.logo || `https://ui-avatars.com/api/?name=${encodeURIComponent(l.business_name)}&background=0066ff&color=fff`;

        const logoText = document.getElementById('inspLogoText');
        if (logoText) logoText.innerText = l.business_name.substring(0, 4).toUpperCase();

        // Header update
        const title = document.getElementById('inspTitle');
        if (title) title.innerText = l.full_name || l.business_name;

        const code = document.getElementById('inspCode');
        if (code) code.innerText = `ID: ${l.code || ('BL' + String(l.id).padStart(5, '0'))}`;

        const listedOn = document.getElementById('inspListedOn');
        if (listedOn) listedOn.innerText = l.listed_on || '12 Jan 2024';

        const rating = document.getElementById('inspRating');
        if (rating) rating.innerText = `${l.rating || 4.8} (${l.reviews_count || 320} reviews)`;

        const statusPill = document.getElementById('inspStatus');
        if (statusPill) {
            statusPill.innerText = l.status || 'Active';
            statusPill.className = `status-pill ${String(l.status || 'active').toLowerCase()}`;
        }

        // Action buttons
        const viewListingBtn = document.getElementById('inspViewListingBtn');
        if (viewListingBtn) viewListingBtn.href = `/business/${l.slug || ''}`;

        const editListingBtn = document.getElementById('inspEditListingBtn');
        if (editListingBtn) editListingBtn.href = `/business/${l.slug || ''}`;

        // Tabs counts
        const rvTab = document.getElementById('inspReviewsTab');
        if (rvTab) rvTab.innerText = `Reviews (${l.reviews_count || 320})`;

        const inqTab = document.getElementById('inspInquiriesTab');
        if (inqTab) inqTab.innerText = `Inquiries (${(l.inquiries || 320).toLocaleString()})`;

        // Basic Information
        const dName = document.getElementById('inspDetailName');
        if (dName) dName.innerText = l.business_name;

        const dCat = document.getElementById('inspDetailCategory');
        if (dCat) dCat.innerText = l.category || 'Education';

        const dSubCat = document.getElementById('inspDetailSubCat');
        if (dSubCat) dSubCat.innerText = l.sub_category || 'Computer Training Institute';

        const dOwner = document.getElementById('inspDetailOwner');
        if (dOwner) dOwner.innerText = l.owner_name || 'Hitesh Mohkar';

        const dContact = document.getElementById('inspDetailContact');
        if (dContact) dContact.innerText = l.owner_phone || '+91 98765 43210';

        const dEmail = document.getElementById('inspDetailEmail');
        if (dEmail) dEmail.innerText = l.owner_email || 'info@vcec.in';

        const dAddr = document.getElementById('inspDetailAddress');
        if (dAddr) dAddr.innerText = l.address || 'Nikol, Ahmedabad, Gujarat';

        const dPlan = document.getElementById('inspDetailPlan');
        if (dPlan) dPlan.innerText = l.plan_detail || `${l.plan || 'Premium'} (Active)`;

        const dViews = document.getElementById('inspDetailViews');
        if (dViews) dViews.innerText = (l.views || 12450).toLocaleString();

        const dInquiries = document.getElementById('inspDetailInquiries');
        if (dInquiries) dInquiries.innerText = (l.inquiries || 320).toLocaleString();

        const dStatus = document.getElementById('inspDetailStatus');
        if (dStatus) dStatus.innerText = l.status || 'Active';

        const dFeatured = document.getElementById('inspDetailFeatured');
        if (dFeatured) dFeatured.innerText = l.is_featured ? 'Yes' : 'No';

        const dVerif = document.getElementById('inspDetailVerification');
        if (dVerif) {
            dVerif.innerHTML = l.is_verified ? '<i class="fa-solid fa-circle-check"></i> Verified' : '<span class="text-muted">Unverified</span>';
        }

        // Owner Information Box
        const oName = document.getElementById('inspOwnerName');
        if (oName) oName.innerText = l.owner_name || 'Hitesh Mohkar';

        const oId = document.getElementById('inspOwnerId');
        if (oId) oId.innerText = `ID: ${l.owner_id || 'UDC00125'}`;

        const oPhone = document.getElementById('inspOwnerPhone');
        if (oPhone) oPhone.innerText = l.owner_phone || '+91 98765 43210';

        const oEmail = document.getElementById('inspOwnerEmail');
        if (oEmail) oEmail.innerText = l.owner_email || 'hitesh@digitalclass.in';

        // Action Forms
        const approveForm = document.getElementById('inspApproveForm');
        if (approveForm) approveForm.action = `/admin/catalog/listings/${l.id}/approve`;

        const rejectForm = document.getElementById('inspRejectForm');
        if (rejectForm) rejectForm.action = `/admin/catalog/listings/${l.id}/reject`;

        const featureForm = document.getElementById('inspFeatureForm');
        if (featureForm) featureForm.action = `/admin/catalog/listings/${l.id}/toggle-featured`;
    }

    // Auto-inspect first listing on load
    document.addEventListener('DOMContentLoaded', function () {
        const firstRow = document.querySelector('.listing-row');
        if (firstRow) {
            firstRow.click();
        }
    });
</script>
@endsection
