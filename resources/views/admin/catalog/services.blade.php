@extends('admin.layouts.admin')

@section('title', 'Services Management - Super Admin')

@section('styles')
<style>
    .service-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .service-kpi-card:hover {
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
    .kpi-icon-orange { background: #fff7ed; color: #ea580c; }
    .kpi-icon-green  { background: #ecfdf5; color: #059669; }
    .kpi-icon-amber  { background: #fffbeb; color: #d97706; }
    .kpi-icon-red    { background: #fef2f2; color: #dc2626; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .kpi-icon-yellow { background: #fefce8; color: #ca8a04; }

    .nav-tabs-services {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .nav-tabs-services .nav-link {
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
    .nav-tabs-services .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .nav-tabs-services .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-services .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    .service-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .service-row:hover {
        background-color: #f8fafc;
    }
    .service-row.selected-row {
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

    .cat-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
    }
    .cat-development     { background: #eff6ff; color: #1d4ed8; }
    .cat-digitalmarketing{ background: #ecfeff; color: #0891b2; }
    .cat-legalfinance    { background: #f5f3ff; color: #7c3aed; }
    .cat-design          { background: #fdf2f8; color: #db2777; }
    .cat-content         { background: #fffbeb; color: #d97706; }
    .cat-aiautomation    { background: #e0e7ff; color: #4338ca; }
    .cat-accounting      { background: #fff7ed; color: #ea580c; }
    .cat-multimedia      { background: #fae8ff; color: #a21caf; }
    .cat-careersupport   { background: #f0fdf4; color: #15803d; }

    .inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        position: sticky;
        top: 80px;
    }
    .inspector-banner {
        border-radius: 8px;
        background: linear-gradient(135deg, #091a3e 0%, #17326b 100%);
        color: #ffffff;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header matching Screenshot -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Services Management</h4>
            <p class="text-muted small mb-0">Manage all services listed on Digital Class. Approve, edit, feature and track performance.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.coming-soon', 'import-services') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-file-import me-1 text-muted"></i> Import Services
            </a>
            <a href="{{ route('admin.coming-soon', 'export-services') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-arrow-up-from-bracket me-1 text-muted"></i> Export
            </a>
            <a href="{{ route('services') }}" target="_blank" class="btn btn-primary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-plus me-1"></i> Add Service
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

    <!-- 6 KPI Metrics Cards matching Screenshot -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Services -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="service-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Services</span>
                    <div class="kpi-icon-circle kpi-icon-orange">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total'] ?? '2,430' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 18%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">+372 this month</div>
            </div>
        </div>

        <!-- Card 2: Active Services -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="service-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Active Services</span>
                    <div class="kpi-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['active'] ?? '1,982' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 18%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">81% of total</div>
            </div>
        </div>

        <!-- Card 3: Pending Approval -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="service-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Pending Approval</span>
                    <div class="kpi-icon-circle kpi-icon-amber">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['pending'] ?? '320' }}</span>
                    <span class="badge bg-danger-subtle text-danger small fw-semibold">↓ 12%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Needs review</div>
            </div>
        </div>

        <!-- Card 4: Rejected -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="service-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Rejected</span>
                    <div class="kpi-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['rejected'] ?? '128' }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">5% of total</div>
            </div>
        </div>

        <!-- Card 5: Featured Services -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="service-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Featured Services</span>
                    <div class="kpi-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['featured'] ?? '210' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 28%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">9% of total</div>
            </div>
        </div>

        <!-- Card 6: Top Performing -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="service-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Top Performing</span>
                    <div class="kpi-icon-circle kpi-icon-yellow">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['top_performing'] ?? '50' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 35%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Based on orders & revenue</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs matching Screenshot -->
    <div class="mb-3">
        <nav class="nav nav-tabs-services">
            <a href="{{ route('admin.catalog.services') }}" class="nav-link {{ (!request('status') || request('status') === 'all') && !request('tab') ? 'active' : '' }}">
                All Services ({{ number_format($counts['all'] ?? 2430) }})
            </a>
            <a href="{{ route('admin.catalog.services', ['status' => 'active']) }}" class="nav-link {{ request('status') === 'active' || request('tab') === 'active' || request('status') === 'approved' ? 'active' : '' }}">
                Active ({{ number_format($counts['active'] ?? 1982) }})
            </a>
            <a href="{{ route('admin.catalog.services', ['status' => 'pending']) }}" class="nav-link {{ request('status') === 'pending' || request('tab') === 'pending' ? 'active' : '' }}">
                Pending ({{ number_format($counts['pending'] ?? 320) }})
            </a>
            <a href="{{ route('admin.catalog.services', ['status' => 'rejected']) }}" class="nav-link {{ request('status') === 'rejected' || request('tab') === 'rejected' ? 'active' : '' }}">
                Rejected ({{ number_format($counts['rejected'] ?? 128) }})
            </a>
            <a href="{{ route('admin.catalog.services', ['status' => 'featured']) }}" class="nav-link {{ request('status') === 'featured' || request('tab') === 'featured' ? 'active' : '' }}">
                Featured ({{ number_format($counts['featured'] ?? 210) }})
            </a>
            <a href="{{ route('admin.catalog.services', ['status' => 'top_performing']) }}" class="nav-link {{ request('status') === 'top_performing' || request('tab') === 'top_performing' ? 'active' : '' }}">
                Top Performing ({{ number_format($counts['top_performing'] ?? 50) }})
            </a>
            <a href="{{ route('admin.catalog.services', ['status' => 'new']) }}" class="nav-link {{ request('status') === 'new' || request('tab') === 'new' ? 'active' : '' }}">
                New ({{ number_format($counts['new'] ?? 180) }})
            </a>
        </nav>
    </div>

    <!-- Filter & Search Toolbar matching Screenshot -->
    <div class="bg-white p-3 rounded-3 border mb-3">
        <form method="GET" action="{{ route('admin.catalog.services') }}" class="row g-2 align-items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Search box -->
            <div class="col-12 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 ps-0" placeholder="Search by service title, seller, ID...">
                </div>
            </div>

            <!-- Categories -->
            <div class="col-6 col-lg-2">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    <option value="Development" {{ request('category') === 'Development' ? 'selected' : '' }}>Development</option>
                    <option value="Digital Marketing" {{ request('category') === 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                    <option value="Legal & Finance" {{ request('category') === 'Legal & Finance' ? 'selected' : '' }}>Legal & Finance</option>
                    <option value="Design" {{ request('category') === 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Content" {{ request('category') === 'Content' ? 'selected' : '' }}>Content</option>
                    <option value="AI & Automation" {{ request('category') === 'AI & Automation' ? 'selected' : '' }}>AI & Automation</option>
                    <option value="Accounting" {{ request('category') === 'Accounting' ? 'selected' : '' }}>Accounting</option>
                    <option value="Multimedia" {{ request('category') === 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                    <option value="Career Support" {{ request('category') === 'Career Support' ? 'selected' : '' }}>Career Support</option>
                </select>
            </div>

            <!-- Service Types -->
            <div class="col-6 col-lg-2">
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Service Types</option>
                    <option value="One-time Service" {{ request('type') === 'One-time Service' ? 'selected' : '' }}>One-time Service</option>
                    <option value="Subscription" {{ request('type') === 'Subscription' ? 'selected' : '' }}>Subscription</option>
                    <option value="Custom Project" {{ request('type') === 'Custom Project' ? 'selected' : '' }}>Custom Project</option>
                </select>
            </div>

            <!-- Locations -->
            <div class="col-6 col-lg-2">
                <select name="location" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Locations</option>
                    <option value="Bengaluru" {{ request('location') === 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
                    <option value="Mumbai" {{ request('location') === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                    <option value="Ahmedabad" {{ request('location') === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                    <option value="Jaipur" {{ request('location') === 'Jaipur' ? 'selected' : '' }}>Jaipur</option>
                    <option value="Pune" {{ request('location') === 'Pune' ? 'selected' : '' }}>Pune</option>
                    <option value="Surat" {{ request('location') === 'Surat' ? 'selected' : '' }}>Surat</option>
                    <option value="Delhi" {{ request('location') === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    <option value="Hyderabad" {{ request('location') === 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                </select>
            </div>

            <!-- Sellers -->
            <div class="col-6 col-lg-1">
                <select name="seller" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all">All Sellers</option>
                    <option value="Design Studio Pro" {{ request('seller') === 'Design Studio Pro' ? 'selected' : '' }}>Design Studio</option>
                    <option value="Rahul Digital" {{ request('seller') === 'Rahul Digital' ? 'selected' : '' }}>Rahul Digital</option>
                    <option value="Tax Pro Solutions" {{ request('seller') === 'Tax Pro Solutions' ? 'selected' : '' }}>Tax Pro</option>
                    <option value="Creative Minds" {{ request('seller') === 'Creative Minds' ? 'selected' : '' }}>Creative Minds</option>
                    <option value="VCEC" {{ request('seller') === 'VCEC' ? 'selected' : '' }}>VCEC</option>
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
                <a href="{{ route('admin.catalog.services') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0">Reset</a>
            </div>
        </form>
    </div>

    <!-- Main Content Area: Table + Right Inspector Panel -->
    <div class="row g-3">
        <!-- Left: Services Table -->
        <div class="col-12 col-xl-8">
            <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0" id="servicesTable">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 32px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Service Details</th>
                                <th>Seller</th>
                                <th>Category</th>
                                <th>Price (From)</th>
                                <th class="text-center">Orders</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th class="text-center">Featured</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($services as $idx => $s)
                                @php
                                    $id = $s['id'];
                                    $code = $s['code'];
                                    $title = $s['title'];
                                    $slug = $s['slug'];
                                    $sellerName = $s['seller_name'];
                                    $sellerCity = $s['seller_city'];
                                    $sellerLogo = $s['seller_logo'];
                                    $category = $s['category'];
                                    $price = (float)$s['price'];
                                    $orders = $s['orders'];
                                    $rating = $s['rating'];
                                    $reviewsCount = $s['reviews_count'];
                                    $statusText = $s['status'];
                                    $isFeatured = !empty($s['is_featured']);
                                    $thumbnail = $s['thumbnail'];

                                    $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $category));
                                    $statusClass = match(strtolower($statusText)) {
                                        'active' => 'active',
                                        'pending' => 'pending',
                                        default => 'rejected',
                                    };
                                @endphp
                                <tr class="service-row {{ $idx === 0 ? 'selected-row' : '' }}" onclick='inspectService(@json($s), this)'>
                                    <td onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input"></td>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $thumbnail }}" alt="{{ $title }}" class="rounded border" style="width: 44px; height: 38px; object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold text-dark text-truncate" style="max-width: 170px;">{{ $title }}</div>
                                                <div class="text-muted font-monospace" style="font-size: 0.68rem;">ID: {{ $code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $sellerLogo }}" alt="{{ $sellerName }}" class="rounded-circle border" style="width: 24px; height: 24px;">
                                            <div>
                                                <div class="fw-medium text-dark text-truncate" style="max-width: 120px;">{{ $sellerName }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $sellerCity }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cat-badge cat-{{ $catSlug }}">{{ $category }}</span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        ₹{{ number_format($price) }}
                                    </td>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ $orders }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="fa-solid fa-star text-warning" style="font-size: 0.75rem;"></i>
                                            <span class="fw-bold text-dark">{{ $rating }}</span>
                                            <span class="text-muted" style="font-size: 0.7rem;">({{ $reviewsCount }})</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $statusClass }}">
                                            <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i>
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        <form method="POST" action="{{ route('admin.catalog.services.toggle-featured', $id) }}" class="d-inline">
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
                                                    <a class="dropdown-item small" href="{{ url('/service/' . $slug) }}" target="_blank">
                                                        <i class="fa-solid fa-arrow-up-right-from-square me-2 text-primary"></i> View Public Service
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                @if(strtolower($statusText) !== 'active')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.catalog.services.approve', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-check me-2"></i> Approve Service
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if(strtolower($statusText) !== 'rejected')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.catalog.services.reject', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-danger">
                                                                <i class="fa-solid fa-xmark me-2"></i> Reject Service
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item small" href="{{ url('/services') }}" target="_blank">
                                                        <i class="fa-regular fa-pen-to-square me-2 text-muted"></i> Edit Service
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-briefcase fs-1 mb-2 text-muted"></i>
                                        <p class="mb-0">No services found matching the criteria.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Bar -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light small">
                    <span class="text-muted">Showing 1 to {{ count($services) }} of {{ number_format($counts['all'] ?? 2430) }} services</span>
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

        <!-- Right: Interactive Service Inspector Panel matching Screenshot -->
        <div class="col-12 col-xl-4">
            <div class="inspector-panel p-3 shadow-sm" id="serviceInspector">
                <!-- Top Hero Banner matching Screenshot -->
                <div class="inspector-banner mb-3" id="inspBanner">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="max-width: 65%;">
                            <h6 class="fw-bold mb-1" id="inspBannerHeadline">Professional Website Development</h6>
                            <p class="small text-white-50 mb-3" style="font-size: 0.72rem;" id="inspBannerSub">Responsive | SEO Friendly | Modern Design</p>
                            <a id="inspStoreBtn" href="{{ url('/service/website-development-for-school-institute-business') }}" target="_blank" class="btn btn-light btn-sm fw-semibold text-dark px-3 py-1" style="font-size: 0.75rem;">
                                View on Store
                            </a>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-sm btn-dark bg-opacity-50 border-0 text-white py-1 px-2" style="font-size: 0.7rem;">
                                <i class="fa-regular fa-pen-to-square me-1"></i> Edit
                            </button>
                            <div class="mt-2">
                                <img id="inspBannerMockup" src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=200&auto=format&fit=crop&q=80" alt="Mockup" class="rounded shadow-sm" style="width: 75px; height: 50px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header: Title, Status, ID, Seller -->
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="fw-bold text-dark mb-0" id="inspTitle">Website Development</h5>
                            <span class="status-pill active py-0 px-2" id="inspStatus">Active</span>
                        </div>
                        <div class="text-muted small">
                            <span class="font-monospace" id="inspCode">ID: SRV00125</span> · Listed by: <span class="fw-medium text-dark" id="inspSellerName">Design Studio Pro</span>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-light border-0 text-muted p-1" onclick="document.getElementById('serviceInspector').classList.toggle('d-none')">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Action Buttons: View Service | Edit Service | ... -->
                <div class="d-flex gap-2 mb-3">
                    <a id="inspViewServiceBtn" href="{{ url('/service/website-development-for-school-institute-business') }}" target="_blank" class="btn btn-primary btn-sm flex-fill fw-medium">
                        View Service
                    </a>
                    <a id="inspEditServiceBtn" href="{{ url('/services') }}" class="btn btn-outline-secondary btn-sm flex-fill fw-medium">
                        Edit Service
                    </a>
                    <button class="btn btn-outline-secondary btn-sm px-2">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                </div>

                <!-- Navigation Tabs: Overview | Packages (3) | Reviews (52) | Orders (124) -->
                <ul class="nav nav-pills nav-fill mb-3 border-bottom pb-2 small" id="inspectorTabs">
                    <li class="nav-item">
                        <a class="nav-link active py-1 px-2 fw-semibold" style="font-size: 0.78rem;" href="#tabOverview" data-bs-toggle="pill">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabPackages" data-bs-toggle="pill" id="inspPackagesTab">Packages (3)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabReviews" data-bs-toggle="pill" id="inspReviewsTab">Reviews (52)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabOrders" data-bs-toggle="pill" id="inspOrdersTab">Orders (124)</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Overview -->
                    <div class="tab-pane fade show active" id="tabOverview">
                        <!-- Basic Information Section matching Screenshot -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Basic Information</span>
                                <a href="{{ url('/services') }}" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                                </a>
                            </div>
                            <div class="bg-light p-2 rounded-2 small" style="font-size: 0.78rem;">
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Title</div>
                                    <div class="col-8 fw-semibold text-dark text-truncate" id="inspDetailTitle">Website Development</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Category</div>
                                    <div class="col-8 text-dark" id="inspDetailCategory">Development</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Sub Category</div>
                                    <div class="col-8 text-dark text-truncate" id="inspDetailSubCat">Website Design & Development</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Service Type</div>
                                    <div class="col-8 text-dark" id="inspDetailType">One-time Service</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Location</div>
                                    <div class="col-8 text-dark" id="inspDetailLocation">Bengaluru, Karnataka</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Starting Price</div>
                                    <div class="col-8 fw-bold text-dark" id="inspDetailPrice">₹4,999</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Delivery Time</div>
                                    <div class="col-8 text-dark" id="inspDetailDelivery">7 Days</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Revisions</div>
                                    <div class="col-8 text-dark" id="inspDetailRevisions">3 Revisions</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Language</div>
                                    <div class="col-8 text-dark" id="inspDetailLanguage">English, Hindi</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Status</div>
                                    <div class="col-8 text-dark" id="inspDetailStatus">Active</div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-4 text-muted">Featured</div>
                                    <div class="col-8 text-dark" id="inspDetailFeatured">Yes</div>
                                </div>
                            </div>
                        </div>

                        <!-- Seller Information matching Screenshot -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Seller Information</span>
                                <a id="inspSellerProfileLink" href="{{ route('admin.sellers.show', 104) }}" class="text-primary text-decoration-none small fw-semibold" style="font-size: 0.75rem;">View Profile</a>
                            </div>
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <img id="inspSellerBoxLogo" src="https://ui-avatars.com/api/?name=DS&background=0066ff&color=fff" alt="Seller" class="rounded border" style="width: 42px; height: 42px;">
                                    <div>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="fw-bold text-dark small" id="inspSellerBoxName">Design Studio Pro</span>
                                            <i class="fa-solid fa-circle-check text-primary" style="font-size: 0.75rem;" title="Verified"></i>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-star text-warning"></i> <span id="inspSellerBoxRating">4.8 (120 reviews)</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.7rem;" id="inspSellerBoxLocation">Bengaluru, Karnataka</div>
                                    </div>
                                </div>
                                <a id="inspSellerContactBtn" href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm px-2 py-1" style="font-size: 0.75rem;">
                                    Contact
                                </a>
                            </div>
                        </div>

                        <!-- Quick Actions matching Screenshot -->
                        <div class="pt-2 border-top">
                            <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Quick Actions</div>
                            <div class="d-flex flex-wrap gap-2">
                                <form id="inspApproveForm" method="POST" action="{{ route('admin.catalog.services.approve', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <form id="inspRejectForm" method="POST" action="{{ route('admin.catalog.services.reject', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </form>
                                <form id="inspFeatureForm" method="POST" action="{{ route('admin.catalog.services.toggle-featured', 125) }}" class="d-inline flex-fill">
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

                    <!-- Tab 2: Packages -->
                    <div class="tab-pane fade" id="tabPackages">
                        <div class="p-2 small">
                            <div class="card p-2 mb-2 border shadow-none bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark">Basic Tier</span>
                                    <span class="badge bg-primary">₹4,999</span>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 0.72rem;">Responsive single page website with domain & basic SEO.</p>
                            </div>
                            <div class="card p-2 mb-2 border shadow-none bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark">Standard Tier</span>
                                    <span class="badge bg-primary">₹9,999</span>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 0.72rem;">5 pages website + admin panel + mobile responsive + WhatsApp integration.</p>
                            </div>
                            <div class="card p-2 border shadow-none bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark">Premium Tier</span>
                                    <span class="badge bg-primary">₹18,999</span>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 0.72rem;">Complete institutional web app with admission forms & payment gateway.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Reviews -->
                    <div class="tab-pane fade" id="tabReviews">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-star fs-4 mb-2 text-warning"></i>
                            <p class="mb-1 fw-bold text-dark fs-6" id="inspTabReviewsRating">4.8 out of 5.0</p>
                            <p class="text-muted mb-2" id="inspTabReviewsCount">Based on 52 verified client reviews.</p>
                            <a href="{{ url('/services') }}" target="_blank" class="btn btn-outline-secondary btn-sm">Read All Reviews</a>
                        </div>
                    </div>

                    <!-- Tab 4: Orders -->
                    <div class="tab-pane fade" id="tabOrders">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-cart-shopping fs-4 mb-2 text-success"></i>
                            <p class="mb-1 fw-bold text-dark fs-6" id="inspTabOrdersCount">124 Total Bookings</p>
                            <p class="text-muted mb-2">₹6,19,876 gross volume fulfilled for clients.</p>
                            <a href="{{ route('admin.coming-soon', 'orders') }}" class="btn btn-outline-primary btn-sm">View Orders Log</a>
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
        document.querySelectorAll('#servicesTable tbody input[type="checkbox"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // Interactive Right Inspector Panel Updater
    function inspectService(s, rowElem) {
        if (!s) return;

        // Highlight selected row
        document.querySelectorAll('.service-row').forEach(r => r.classList.remove('selected-row'));
        if (rowElem) {
            rowElem.classList.add('selected-row');
        }

        // Make sure inspector is visible
        const inspector = document.getElementById('serviceInspector');
        if (inspector) inspector.classList.remove('d-none');

        // Banner update
        const bHeadline = document.getElementById('inspBannerHeadline');
        if (bHeadline) bHeadline.innerText = s.banner_headline || s.title;

        const bSub = document.getElementById('inspBannerSub');
        if (bSub) bSub.innerText = s.banner_sub || 'Responsive | SEO Friendly | Modern Design';

        const bMockup = document.getElementById('inspBannerMockup');
        if (bMockup) bMockup.src = s.thumbnail || 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=200&auto=format&fit=crop&q=80';

        const bStoreBtn = document.getElementById('inspStoreBtn');
        if (bStoreBtn) bStoreBtn.href = `/service/${s.slug || ''}`;

        // Header update
        const title = document.getElementById('inspTitle');
        if (title) title.innerText = s.title;

        const code = document.getElementById('inspCode');
        if (code) code.innerText = `ID: ${s.code || ('SRV' + String(s.id).padStart(5, '0'))}`;

        const sellerName = document.getElementById('inspSellerName');
        if (sellerName) sellerName.innerText = s.seller_name;

        const statusPill = document.getElementById('inspStatus');
        if (statusPill) {
            statusPill.innerText = s.status || 'Active';
            statusPill.className = `status-pill ${String(s.status || 'active').toLowerCase()} py-0 px-2`;
        }

        // Action buttons
        const viewServiceBtn = document.getElementById('inspViewServiceBtn');
        if (viewServiceBtn) viewServiceBtn.href = `/service/${s.slug || ''}`;

        // Tabs counts
        const pkTab = document.getElementById('inspPackagesTab');
        if (pkTab) pkTab.innerText = `Packages (${s.packages_count || 3})`;

        const rvTab = document.getElementById('inspReviewsTab');
        if (rvTab) rvTab.innerText = `Reviews (${s.reviews_count || 52})`;

        const ordTab = document.getElementById('inspOrdersTab');
        if (ordTab) ordTab.innerText = `Orders (${(s.orders || 124).toLocaleString()})`;

        // Basic Information
        const dTitle = document.getElementById('inspDetailTitle');
        if (dTitle) dTitle.innerText = s.title;

        const dCat = document.getElementById('inspDetailCategory');
        if (dCat) dCat.innerText = s.category || 'Development';

        const dSubCat = document.getElementById('inspDetailSubCat');
        if (dSubCat) dSubCat.innerText = s.sub_category || 'Website Design & Development';

        const dType = document.getElementById('inspDetailType');
        if (dType) dType.innerText = s.service_type || 'One-time Service';

        const dLoc = document.getElementById('inspDetailLocation');
        if (dLoc) dLoc.innerText = s.location || 'Bengaluru, Karnataka';

        const dPrice = document.getElementById('inspDetailPrice');
        if (dPrice) dPrice.innerText = `₹${Number(s.price || 0).toLocaleString()}`;

        const dDelivery = document.getElementById('inspDetailDelivery');
        if (dDelivery) dDelivery.innerText = s.delivery_time || '7 Days';

        const dRevisions = document.getElementById('inspDetailRevisions');
        if (dRevisions) dRevisions.innerText = s.revisions || '3 Revisions';

        const dLang = document.getElementById('inspDetailLanguage');
        if (dLang) dLang.innerText = s.language || 'English, Hindi';

        const dStatus = document.getElementById('inspDetailStatus');
        if (dStatus) dStatus.innerText = s.status || 'Active';

        const dFeatured = document.getElementById('inspDetailFeatured');
        if (dFeatured) dFeatured.innerText = s.is_featured ? 'Yes' : 'No';

        // Seller Information Box
        const sBoxName = document.getElementById('inspSellerBoxName');
        if (sBoxName) sBoxName.innerText = s.seller_name;

        const sBoxLogo = document.getElementById('inspSellerBoxLogo');
        if (sBoxLogo) sBoxLogo.src = s.seller_logo || `https://ui-avatars.com/api/?name=${encodeURIComponent(s.seller_name)}&background=0066ff&color=fff`;

        const sBoxRating = document.getElementById('inspSellerBoxRating');
        if (sBoxRating) sBoxRating.innerText = `${s.rating || 4.8} (${s.seller_reviews || '120 reviews'})`;

        const sBoxLoc = document.getElementById('inspSellerBoxLocation');
        if (sBoxLoc) sBoxLoc.innerText = s.seller_location || s.location || 'Bengaluru, Karnataka';

        const sProfileLink = document.getElementById('inspSellerProfileLink');
        if (sProfileLink) sProfileLink.href = s.seller_id ? `/admin/sellers/${s.seller_id}` : `/admin/sellers/${encodeURIComponent(s.seller_name.toLowerCase().replace(/[^a-z0-9]/g, '-'))}`;

        // Quick Action Forms
        const approveForm = document.getElementById('inspApproveForm');
        if (approveForm) approveForm.action = `/admin/catalog/services/${s.id}/approve`;

        const rejectForm = document.getElementById('inspRejectForm');
        if (rejectForm) rejectForm.action = `/admin/catalog/services/${s.id}/reject`;

        const featureForm = document.getElementById('inspFeatureForm');
        if (featureForm) featureForm.action = `/admin/catalog/services/${s.id}/toggle-featured`;

        // Tab detail stats
        const rvStat = document.getElementById('inspTabReviewsRating');
        if (rvStat) rvStat.innerText = `${s.rating || 4.8} out of 5.0`;

        const rvCount = document.getElementById('inspTabReviewsCount');
        if (rvCount) rvCount.innerText = `Based on ${s.reviews_count || 52} verified client reviews.`;

        const ordStat = document.getElementById('inspTabOrdersCount');
        if (ordStat) ordStat.innerText = `${(s.orders || 124).toLocaleString()} Total Bookings`;
    }

    // Auto-inspect first service on load
    document.addEventListener('DOMContentLoaded', function () {
        const firstRow = document.querySelector('.service-row');
        if (firstRow) {
            firstRow.click();
        }
    });
</script>
@endsection
