@extends('admin.layouts.admin')

@section('title', ($isPendingTab ? 'Pending Seller Approvals' : 'Sellers Management') . ' - Super Admin')

@section('styles')
<style>
    .seller-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .seller-kpi-card:hover {
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
    .kpi-icon-blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon-green { background: #ecfdf5; color: #059669; }
    .kpi-icon-amber { background: #fffbeb; color: #d97706; }
    .kpi-icon-rose { background: #fff1f2; color: #e11d48; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .kpi-icon-sky { background: #f0f9ff; color: #0284c7; }

    .nav-tabs-sellers {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .nav-tabs-sellers .nav-link {
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
    .nav-tabs-sellers .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .nav-tabs-sellers .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-sellers .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
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
    .status-pill.active { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .status-pill.pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-pill.suspended { background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; }
    .status-pill.rejected { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    .type-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        background: #f1f5f9;
        color: #334155;
    }
    .type-badge.institute { background: #eff6ff; color: #1d4ed8; }
    .type-badge.individual { background: #fdf2f8; color: #be185d; }
    .type-badge.agency { background: #f0fdf4; color: #15803d; }
    .type-badge.company { background: #fff7ed; color: #c2410c; }

    .seller-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .seller-row:hover {
        background-color: #f8fafc;
    }
    .seller-row.selected-row {
        background-color: #eff6ff;
    }

    .inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        position: sticky;
        top: 80px;
    }
    .stat-metric-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header matching Screenshot 2 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Sellers Management</h4>
            <p class="text-muted small mb-0">Manage all sellers, stores, approvals, verifications and performance.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.coming-soon', 'export-sellers') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-arrow-up-from-bracket me-1 text-muted"></i> Export
            </a>
            <a href="{{ route('seller.register') }}" target="_blank" class="btn btn-primary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-plus me-1"></i> Add Seller
            </a>
        </div>
    </div>

    <!-- 6 KPI Metrics Cards matching Screenshot 2 -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Sellers -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="seller-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Sellers</span>
                    <div class="kpi-icon-circle kpi-icon-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total'] ?? '1,248' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 12%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">+132 this month</div>
            </div>
        </div>

        <!-- Card 2: Active Sellers -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="seller-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Active Sellers</span>
                    <div class="kpi-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['active'] ?? '982' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 15%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">78% of total</div>
            </div>
        </div>

        <!-- Card 3: Pending Approval -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="seller-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Pending Approval</span>
                    <div class="kpi-icon-circle kpi-icon-amber">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['pending'] ?? '86' }}</span>
                    <span class="badge bg-warning-subtle text-warning small fw-semibold">↑ 20%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Needs review</div>
            </div>
        </div>

        <!-- Card 4: Suspended -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="seller-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Suspended</span>
                    <div class="kpi-icon-circle kpi-icon-rose">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['suspended'] ?? '34' }}</span>
                    <span class="text-muted small">-</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Policy violation</div>
            </div>
        </div>

        <!-- Card 5: Total Revenue -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="seller-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Revenue</span>
                    <div class="kpi-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total_revenue'] ?? '₹18,72,450' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 28%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">This month</div>
            </div>
        </div>

        <!-- Card 6: Payout Due -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="seller-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Payout Due</span>
                    <div class="kpi-icon-circle kpi-icon-sky">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['payout_due'] ?? '₹4,32,120' }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">67 sellers</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs matching Screenshot 2 -->
    <div class="mb-3">
        <nav class="nav nav-tabs-sellers">
            <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ (!request('status') || request('status') === 'all') && !request('tab') ? 'active' : '' }}">
                All Sellers ({{ number_format($counts['all'] ?? 1248) }})
            </a>
            <a href="{{ route('admin.sellers.index', ['status' => 'pending']) }}" class="nav-link {{ request('status') === 'pending' || request('tab') === 'pending' ? 'active' : '' }}">
                Pending ({{ number_format($counts['pending'] ?? 86) }})
            </a>
            <a href="{{ route('admin.sellers.index', ['status' => 'active']) }}" class="nav-link {{ request('status') === 'active' || request('tab') === 'active' ? 'active' : '' }}">
                Active ({{ number_format($counts['active'] ?? 982) }})
            </a>
            <a href="{{ route('admin.sellers.index', ['status' => 'suspended']) }}" class="nav-link {{ request('status') === 'suspended' || request('tab') === 'suspended' ? 'active' : '' }}">
                Suspended ({{ number_format($counts['suspended'] ?? 34) }})
            </a>
            <a href="{{ route('admin.sellers.index', ['status' => 'top_sellers']) }}" class="nav-link {{ request('status') === 'top_sellers' ? 'active' : '' }}">
                Top Sellers (50)
            </a>
            <a href="{{ route('admin.sellers.index', ['status' => 'new_sellers']) }}" class="nav-link {{ request('status') === 'new_sellers' ? 'active' : '' }}">
                New Sellers (120)
            </a>
        </nav>
    </div>

    <!-- Filter & Search Toolbar matching Screenshot 2 -->
    <div class="bg-white p-3 rounded-3 border mb-3">
        <form method="GET" action="{{ route('admin.sellers.index') }}" class="row g-2 align-items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Search box -->
            <div class="col-12 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 ps-0" placeholder="Search by name, email, mobile or store...">
                </div>
            </div>

            <!-- Category -->
            <div class="col-6 col-lg-2">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    <option value="Courses" {{ request('category') === 'Courses' ? 'selected' : '' }}>Courses</option>
                    <option value="Services" {{ request('category') === 'Services' ? 'selected' : '' }}>Services</option>
                    <option value="Products" {{ request('category') === 'Products' ? 'selected' : '' }}>Products</option>
                </select>
            </div>

            <!-- Type -->
            <div class="col-6 col-lg-2">
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Types</option>
                    <option value="Institute" {{ request('type') === 'Institute' ? 'selected' : '' }}>Institute</option>
                    <option value="Individual" {{ request('type') === 'Individual' ? 'selected' : '' }}>Individual</option>
                    <option value="Agency" {{ request('type') === 'Agency' ? 'selected' : '' }}>Agency</option>
                    <option value="Company" {{ request('type') === 'Company' ? 'selected' : '' }}>Company</option>
                </select>
            </div>

            <!-- Status Dropdown -->
            <div class="col-6 col-lg-1">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <!-- Location Dropdown -->
            <div class="col-6 col-lg-2">
                <select name="location" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Locations</option>
                    <option value="Ahmedabad" {{ request('location') === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                    <option value="Surat" {{ request('location') === 'Surat' ? 'selected' : '' }}>Surat</option>
                    <option value="Mumbai" {{ request('location') === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                    <option value="Bengaluru" {{ request('location') === 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
                    <option value="Pune" {{ request('location') === 'Pune' ? 'selected' : '' }}>Pune</option>
                    <option value="Delhi" {{ request('location') === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    <option value="Hyderabad" {{ request('location') === 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                    <option value="Indore" {{ request('location') === 'Indore' ? 'selected' : '' }}>Indore</option>
                </select>
            </div>

            <!-- Date Range Display -->
            <div class="col-8 col-lg-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted p-1">
                        <i class="fa-regular fa-calendar" style="font-size:0.75rem;"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0 text-muted" style="font-size: 0.7rem;" value="01 Oct - 31 Oct" readonly>
                </div>
            </div>

            <!-- Reset -->
            <div class="col-4 col-lg-1 text-end">
                <a href="{{ route('admin.sellers.index') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0">Reset</a>
            </div>
        </form>
    </div>

    <!-- Main Content Area: Table + Right Inspector Panel -->
    <div class="row g-3">
        <!-- Left: Sellers Table -->
        <div class="col-12 col-xl-8">
            <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0" id="sellersTable">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 32px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Seller / Store</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th class="text-center">Products</th>
                                <th>Status</th>
                                <th>Joined On</th>
                                <th>Revenue</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($sellers as $idx => $s)
                                @php
                                    $id = is_array($s) ? ($s['id'] ?? $idx + 1) : $s->id;
                                    $name = is_array($s) ? ($s['name'] ?? 'Store') : ($s->businessDetail?->business_name ?? $s->user?->name ?? 'Store');
                                    $sellerCode = is_array($s) ? ($s['seller_code'] ?? 'DC-SELL-' . str_pad($id, 6, '0', STR_PAD_LEFT)) : ($s->seller_code ?? 'DC-SELL-' . str_pad($id, 6, '0', STR_PAD_LEFT));
                                    $email = is_array($s) ? ($s['email'] ?? '') : ($s->user?->email ?? ($s->businessDetail?->business_email ?? ''));
                                    $mobile = is_array($s) ? ($s['mobile'] ?? '+91 98765 00000') : ($s->user?->phone ?? '+91 98765 00000');
                                    $type = is_array($s) ? ($s['type'] ?? 'Institute') : ucfirst($s->account_type ?? 'Institute');
                                    $category = is_array($s) ? ($s['category'] ?? 'Courses, Services') : 'Courses, Services';
                                    $location = is_array($s) ? ($s['location'] ?? 'Ahmedabad, Gujarat') : (($s->businessDetail?->city ?? 'Ahmedabad') . ', ' . ($s->businessDetail?->state ?? 'Gujarat'));
                                    $productsCount = is_array($s) ? ($s['products_count'] ?? 10) : 5;
                                    $rawStatus = is_array($s) ? ($s['status'] ?? 'Active') : ($s->seller_status ?? 'Pending');
                                    $statusText = in_array(strtolower($rawStatus), ['active']) ? 'Active' : (in_array(strtolower($rawStatus), ['suspended']) ? 'Suspended' : 'Pending');
                                    $joinedOn = is_array($s) ? ($s['joined_on'] ?? 'Recent') : ($s->created_at ? $s->created_at->format('d M Y') : 'Recent');
                                    $revenue = is_array($s) ? ($s['revenue'] ?? '₹45,000') : '₹45,000';
                                    $totalOrders = is_array($s) ? ($s['total_orders'] ?? 120) : 120;
                                    $rating = is_array($s) ? ($s['rating'] ?? 4.8) : 4.8;
                                    $reviewsCount = is_array($s) ? ($s['reviews_count'] ?? 420) : 35;
                                    $branchesCount = is_array($s) ? ($s['branches_count'] ?? 1) : 1;
                                    $address = is_array($s) ? ($s['address'] ?? ($location)) : ($s->businessDetail?->address ?? $location);
                                    $logo = is_array($s) ? ($s['logo'] ?? '') : '';
                                    if (!$logo) {
                                        $logo = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0066ff&color=fff';
                                    }
                                    $storeSlug = is_array($s) ? ($s['store_slug'] ?? \Illuminate\Support\Str::slug($name)) : \Illuminate\Support\Str::slug($name);
                                    $isVerified = is_array($s) ? !empty($s['is_verified']) : ($s->verification_status === \App\Models\Seller::VERIFICATION_VERIFIED);

                                    $typeClass = match(strtolower($type)) {
                                        'institute' => 'institute',
                                        'individual' => 'individual',
                                        'agency' => 'agency',
                                        'company' => 'company',
                                        default => '',
                                    };
                                    $statusClass = match(strtolower($statusText)) {
                                        'active' => 'active',
                                        'pending' => 'pending',
                                        'suspended' => 'suspended',
                                        default => 'rejected',
                                    };

                                    $sellerPayload = [
                                        'id' => $id,
                                        'name' => $name,
                                        'seller_code' => $sellerCode,
                                        'email' => $email,
                                        'mobile' => $mobile,
                                        'type' => $type,
                                        'category' => $category,
                                        'location' => $location,
                                        'products_count' => $productsCount,
                                        'status' => $statusText,
                                        'joined_on' => $joinedOn,
                                        'revenue' => $revenue,
                                        'total_orders' => $totalOrders,
                                        'rating' => $rating,
                                        'reviews_count' => $reviewsCount,
                                        'branches_count' => $branchesCount,
                                        'address' => $address,
                                        'logo' => $logo,
                                        'store_slug' => $storeSlug,
                                        'is_verified' => $isVerified,
                                    ];
                                @endphp
                                <tr class="seller-row {{ $idx === 0 ? 'selected-row' : '' }}" onclick='inspectSeller(@json($sellerPayload), this)' ondblclick="window.location='{{ route('admin.sellers.show', $id) }}'" title="Click to inspect, double-click for full dossier">
                                    <td onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input"></td>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $logo }}" alt="{{ $name }}" class="rounded border" style="width: 38px; height: 38px; object-fit: contain; background: #f8fafc;">
                                            <div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('admin.sellers.show', $id) }}" class="fw-semibold text-dark text-decoration-none hover-primary" title="Open Full Seller Dossier">{{ $name }}</a>
                                                    @if($isVerified)
                                                        <i class="fa-solid fa-circle-check text-primary" style="font-size: 0.8rem;" title="Verified Seller"></i>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-light text-muted border py-0 px-1 font-monospace" style="font-size: 0.65rem;">{{ $sellerCode }}</span>
                                                    <span class="text-muted" style="font-size: 0.75rem;">{{ $email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-badge {{ $typeClass }}">{{ $type }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $category }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $location }}</span>
                                    </td>
                                    <td class="text-center fw-semibold">
                                        {{ $productsCount }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $statusClass }}">
                                            <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i>
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="text-muted" style="font-size: 0.78rem;">
                                        {{ $joinedOn }}
                                    </td>
                                    <td class="fw-bold text-dark">
                                        {{ $revenue }}
                                    </td>
                                    <td class="text-end" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 py-0 px-2" type="button" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item small" href="{{ url('/sellers/' . $storeSlug) }}" target="_blank">
                                                        <i class="fa-solid fa-arrow-up-right-from-square me-2 text-primary"></i> View Public Store
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="{{ route('admin.sellers.show', $id) }}">
                                                        <i class="fa-regular fa-id-card me-2 text-info"></i> Full Seller Dossier
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                @if(strtolower($statusText) === 'pending')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.sellers.approve', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-check me-2"></i> Approve Seller
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.sellers.reject', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-danger">
                                                                <i class="fa-solid fa-xmark me-2"></i> Reject Application
                                                            </button>
                                                        </form>
                                                    </li>
                                                @elseif(strtolower($statusText) === 'active')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.sellers.suspend', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-danger">
                                                                <i class="fa-solid fa-ban me-2"></i> Suspend Seller
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.sellers.reactivate', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-rotate-left me-2"></i> Reactivate Seller
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-store fs-1 mb-2 text-muted"></i>
                                        <p class="mb-0">No sellers found matching the selected filter criteria.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Bar -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light small">
                    <span class="text-muted">Showing 1 to {{ count($sellers) }} of {{ number_format($counts['all'] ?? 1248) }} sellers</span>
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

        <!-- Right: Interactive Seller Inspector Panel matching Screenshot 2 -->
        <div class="col-12 col-xl-4">
            <div class="inspector-panel p-3 shadow-sm" id="sellerInspector">
                <!-- Header with Logo, Name, Badge, Close -->
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <img id="inspLogo" src="https://ui-avatars.com/api/?name=VCEC&background=0066ff&color=fff" alt="Logo" class="rounded border p-1" style="width: 50px; height: 50px; object-fit: contain;">
                        <div>
                            <div class="d-flex align-items-center gap-1">
                                <h6 class="fw-bold text-dark mb-0" id="inspName">VCEC - Vinayak Computer Education</h6>
                                <i id="inspVerifiedBadge" class="fa-solid fa-circle-check text-primary" style="font-size: 0.85rem;" title="Verified"></i>
                            </div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="badge bg-light text-muted border font-monospace py-0 px-1" id="inspCode" style="font-size: 0.65rem;">DC-SELL-000001</span>
                                <span class="status-pill active py-0 px-2" id="inspStatus" style="font-size: 0.68rem;">Active</span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-light border-0 text-muted p-1" onclick="document.getElementById('sellerInspector').classList.toggle('d-none')">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Action Buttons: View Store ↗ | View Seller Details -->
                <div class="d-flex gap-2 mb-3">
                    <a id="inspViewStoreBtn" href="{{ url('/sellers/vcec') }}" target="_blank" class="btn btn-outline-secondary btn-sm flex-fill fw-medium">
                        View Store <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 0.75rem;"></i>
                    </a>
                    <a id="inspDossierBtn" href="{{ route('admin.sellers.show', 101) }}" class="btn btn-primary btn-sm flex-fill fw-medium">
                        <i class="fa-solid fa-id-card me-1"></i> Seller Details
                    </a>
                </div>

                <!-- Tabs: Overview | Products (12) | Orders (1,248) | Payouts -->
                <ul class="nav nav-pills nav-fill mb-3 border-bottom pb-2 small" id="inspectorTabs">
                    <li class="nav-item">
                        <a class="nav-link active py-1 px-2 fw-semibold" style="font-size: 0.78rem;" href="#tabOverview" data-bs-toggle="pill">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabProducts" data-bs-toggle="pill" id="inspProductsTab">Products (12)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabOrders" data-bs-toggle="pill" id="inspOrdersTab">Orders (1,248)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabPayouts" data-bs-toggle="pill">Payouts</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Overview -->
                    <div class="tab-pane fade show active" id="tabOverview">
                        <!-- Basic Information Section -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Basic Information</span>
                                <a id="inspEditLink" href="{{ route('admin.sellers.show', 1) }}" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                                </a>
                            </div>
                            <div class="bg-light p-2 rounded-2 small" style="font-size: 0.78rem;">
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Name</div>
                                    <div class="col-8 fw-semibold text-dark text-truncate" id="inspDetailName">VCEC - Vinayak Computer Education</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Email</div>
                                    <div class="col-8 text-dark text-truncate" id="inspDetailEmail">info@vcec.in</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Mobile</div>
                                    <div class="col-8 text-dark d-flex align-items-center gap-1">
                                        <span id="inspDetailMobile">+91 98765 43210</span>
                                        <i class="fa-brands fa-whatsapp text-success" title="WhatsApp available"></i>
                                    </div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Type</div>
                                    <div class="col-8">
                                        <span class="type-badge institute" id="inspDetailType">Institute</span>
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-4 text-muted">Joined On</div>
                                    <div class="col-8 text-dark" id="inspDetailJoined">12 Jan 2022 (4.8 yrs)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Details Section -->
                        <div class="mb-3">
                            <div class="fw-bold text-dark small text-uppercase mb-2" style="letter-spacing: 0.5px;">Business Details</div>
                            <div class="bg-light p-2 rounded-2 small" style="font-size: 0.78rem;">
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Categories</div>
                                    <div class="col-8 fw-semibold text-dark" id="inspDetailCategory">Courses, Services</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Location</div>
                                    <div class="col-8 text-dark" id="inspDetailLocation">Ahmedabad, Gujarat</div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-4 text-muted">Address</div>
                                    <div class="col-8 text-dark" id="inspDetailAddress">201, Shreeji Complex, Nikol Main Road, Ahmedabad - 382350, Gujarat</div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats 6-grid matching Screenshot 2 -->
                        <div class="mb-3">
                            <div class="fw-bold text-dark small text-uppercase mb-2" style="letter-spacing: 0.5px;">Stats</div>
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="stat-metric-box text-center">
                                        <div class="fw-bold fs-6 text-dark mb-0" id="inspStatProducts">12</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">Products/Courses</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-metric-box text-center">
                                        <div class="fw-bold fs-6 text-dark mb-0" id="inspStatOrders">1,248</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">Total Orders</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-metric-box text-center">
                                        <div class="fw-bold fs-6 text-dark mb-0" id="inspStatRevenue">₹6,24,890</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">Total Revenue</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-metric-box text-center">
                                        <div class="fw-bold fs-6 text-dark mb-0" id="inspStatRating">4.8</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">Average Rating</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-metric-box text-center">
                                        <div class="fw-bold fs-6 text-dark mb-0" id="inspStatReviews">420</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">Total Reviews</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-metric-box text-center">
                                        <div class="fw-bold fs-6 text-dark mb-0" id="inspStatBranches">3</div>
                                        <div class="text-muted" style="font-size: 0.65rem;">Branches</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions matching Screenshot 2 -->
                        <div class="pt-2 border-top">
                            <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Quick Actions</div>
                            <div class="d-flex flex-wrap gap-2">
                                <a id="inspMsgBtn" href="{{ route('admin.messages.index') }}" class="btn btn-outline-success btn-sm flex-fill" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-comment-dots me-1"></i> Message
                                </a>
                                <form id="inspApproveForm" method="POST" action="{{ route('admin.sellers.approve', 1) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <form id="inspSuspendForm" method="POST" action="{{ route('admin.sellers.suspend', 1) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-ban me-1"></i> Suspend
                                    </button>
                                </form>
                                <a id="inspKycBtn" href="{{ route('admin.sellers.show', 1) }}" class="btn btn-outline-secondary btn-sm flex-fill" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-file-shield me-1"></i> View KYC
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Products -->
                    <div class="tab-pane fade" id="tabProducts">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-boxes-stacked fs-4 mb-2 text-primary"></i>
                            <p class="mb-2">View & manage all published courses and services from this seller.</p>
                            <a href="{{ route('admin.catalog.courses') }}" class="btn btn-primary btn-sm">Explore In Catalog</a>
                        </div>
                    </div>

                    <!-- Tab 3: Orders -->
                    <div class="tab-pane fade" id="tabOrders">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-cart-shopping fs-4 mb-2 text-success"></i>
                            <p class="mb-2">1,248 orders placed across all store offerings.</p>
                            <a href="{{ route('admin.coming-soon', 'orders') }}" class="btn btn-outline-secondary btn-sm">View Orders Log</a>
                        </div>
                    </div>

                    <!-- Tab 4: Payouts -->
                    <div class="tab-pane fade" id="tabPayouts">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-wallet fs-4 mb-2 text-info"></i>
                            <p class="mb-2">Payout history and pending release approvals.</p>
                            <a href="{{ route('admin.coming-soon', 'payouts') }}" class="btn btn-outline-primary btn-sm">Payouts Center</a>
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
        document.querySelectorAll('#sellersTable tbody input[type="checkbox"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // Interactive Right Inspector Panel Updater
    function inspectSeller(s, rowElem) {
        if (!s) return;

        // Highlight selected row
        document.querySelectorAll('.seller-row').forEach(r => r.classList.remove('selected-row'));
        if (rowElem) {
            rowElem.classList.add('selected-row');
        }

        // Make sure inspector is visible
        const inspector = document.getElementById('sellerInspector');
        if (inspector) inspector.classList.remove('d-none');

        // Update Header
        const logo = document.getElementById('inspLogo');
        if (logo) logo.src = s.logo || `https://ui-avatars.com/api/?name=${encodeURIComponent(s.name)}&background=0066ff&color=fff`;

        const name = document.getElementById('inspName');
        if (name) name.innerText = s.name;

        const code = document.getElementById('inspCode');
        if (code) code.innerText = s.seller_code || `DC-SELL-${String(s.id).padStart(6, '0')}`;

        const verifiedBadge = document.getElementById('inspVerifiedBadge');
        if (verifiedBadge) {
            verifiedBadge.style.display = s.is_verified ? 'inline-block' : 'none';
        }

        const statusPill = document.getElementById('inspStatus');
        if (statusPill) {
            statusPill.innerText = s.status || 'Active';
            statusPill.className = `status-pill ${String(s.status || 'active').toLowerCase()} py-0 px-2`;
        }

        // Action Buttons
        const viewStoreBtn = document.getElementById('inspViewStoreBtn');
        if (viewStoreBtn) {
            viewStoreBtn.href = `/sellers/${s.store_slug || s.id}`;
        }

        const dossierBtn = document.getElementById('inspDossierBtn');
        if (dossierBtn) {
            dossierBtn.href = `/admin/sellers/${s.id}`;
        }

        const editSellerBtn = document.getElementById('inspEditSellerBtn');
        if (editSellerBtn) {
            editSellerBtn.href = `/admin/sellers/${s.id}`;
        }

        const editLink = document.getElementById('inspEditLink');
        if (editLink) {
            editLink.href = `/admin/sellers/${s.id}`;
        }

        // Tabs counts
        const prodTab = document.getElementById('inspProductsTab');
        if (prodTab) prodTab.innerText = `Products (${s.products_count || 0})`;

        const ordTab = document.getElementById('inspOrdersTab');
        if (ordTab) ordTab.innerText = `Orders (${(s.total_orders || 0).toLocaleString()})`;

        // Basic Info
        const dName = document.getElementById('inspDetailName');
        if (dName) dName.innerText = s.name;

        const dEmail = document.getElementById('inspDetailEmail');
        if (dEmail) dEmail.innerText = s.email;

        const dMobile = document.getElementById('inspDetailMobile');
        if (dMobile) dMobile.innerText = s.mobile || '+91 98765 00000';

        const dType = document.getElementById('inspDetailType');
        if (dType) {
            dType.innerText = s.type || 'Institute';
            dType.className = `type-badge ${(s.type || 'institute').toLowerCase()}`;
        }

        const dJoined = document.getElementById('inspDetailJoined');
        if (dJoined) dJoined.innerText = s.joined_on || 'Recent';

        // Business Details
        const dCat = document.getElementById('inspDetailCategory');
        if (dCat) dCat.innerText = s.category || 'Courses, Services';

        const dLoc = document.getElementById('inspDetailLocation');
        if (dLoc) dLoc.innerText = s.location || 'Ahmedabad, Gujarat';

        const dAddr = document.getElementById('inspDetailAddress');
        if (dAddr) dAddr.innerText = s.address || s.location || 'Ahmedabad, Gujarat';

        // Stats
        const sProd = document.getElementById('inspStatProducts');
        if (sProd) sProd.innerText = s.products_count || 0;

        const sOrd = document.getElementById('inspStatOrders');
        if (sOrd) sOrd.innerText = (s.total_orders || 0).toLocaleString();

        const sRev = document.getElementById('inspStatRevenue');
        if (sRev) sRev.innerText = s.revenue || '₹0';

        const sRat = document.getElementById('inspStatRating');
        if (sRat) sRat.innerText = s.rating || '4.8';

        const sRevCount = document.getElementById('inspStatReviews');
        if (sRevCount) sRevCount.innerText = s.reviews_count || 0;

        const sBranch = document.getElementById('inspStatBranches');
        if (sBranch) sBranch.innerText = s.branches_count || 1;

        // Forms & Quick Actions
        const approveForm = document.getElementById('inspApproveForm');
        if (approveForm) approveForm.action = `/admin/sellers/${s.id}/approve`;

        const suspendForm = document.getElementById('inspSuspendForm');
        if (suspendForm) suspendForm.action = `/admin/sellers/${s.id}/suspend`;

        const kycBtn = document.getElementById('inspKycBtn');
        if (kycBtn) kycBtn.href = `/admin/sellers/${s.id}`;
    }

    // Auto-inspect first seller on load
    document.addEventListener('DOMContentLoaded', function () {
        const firstRow = document.querySelector('.seller-row');
        if (firstRow) {
            firstRow.click();
        }
    });
</script>
@endsection
