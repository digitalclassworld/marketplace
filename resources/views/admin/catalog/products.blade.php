@extends('admin.layouts.admin')

@section('title', 'Products Management - Super Admin')

@section('styles')
<style>
    .product-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        position: relative;
    }
    .product-kpi-card:hover {
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
    .kpi-icon-rose   { background: #fff1f2; color: #e11d48; }
    .kpi-icon-green  { background: #ecfdf5; color: #059669; }
    .kpi-icon-amber  { background: #fffbeb; color: #d97706; }
    .kpi-icon-red    { background: #fef2f2; color: #dc2626; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .kpi-icon-yellow { background: #fefce8; color: #ca8a04; }

    .nav-tabs-products {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .nav-tabs-products .nav-link {
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
    .nav-tabs-products .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .nav-tabs-products .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-products .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    .product-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .product-row:hover {
        background-color: #f8fafc;
    }
    .product-row.selected-row {
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
    .cat-computers    { background: #eff6ff; color: #1d4ed8; }
    .cat-accessories  { background: #ecfeff; color: #0891b2; }
    .cat-furniture    { background: #fef2f2; color: #dc2626; }
    .cat-designtools  { background: #f5f3ff; color: #7c3aed; }
    .cat-software     { background: #eff6ff; color: #2563eb; }
    .cat-camera       { background: #fff7ed; color: #ea580c; }

    .inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        position: sticky;
        top: 80px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header matching Screenshot 1 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Products Management</h4>
            <p class="text-muted small mb-0">Manage all physical and digital products listed on Digital Class. Approve, edit, feature and track performance.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.coming-soon', 'import-products') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-file-import me-1 text-muted"></i> Import Products
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
            <a href="{{ route('products') }}" target="_blank" class="btn btn-primary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-plus me-1"></i> Add Product
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

    <!-- 6 KPI Metrics Cards matching Screenshot 1 -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Products -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="product-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Total Products</span>
                    <div class="kpi-icon-circle kpi-icon-rose">
                        <i class="fa-solid fa-box"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['total'] ?? '3,980' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 20%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">+680 this month</div>
            </div>
        </div>

        <!-- Card 2: Active Products -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="product-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Active Products</span>
                    <div class="kpi-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['active'] ?? '3,120' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 18%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">78% of total</div>
            </div>
        </div>

        <!-- Card 3: Pending Approval -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="product-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Pending Approval</span>
                    <div class="kpi-icon-circle kpi-icon-amber">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['pending'] ?? '420' }}</span>
                    <span class="badge bg-danger-subtle text-danger small fw-semibold">↓ 12%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Needs review</div>
            </div>
        </div>

        <!-- Card 4: Rejected Products -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="product-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Rejected Products</span>
                    <div class="kpi-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['rejected'] ?? '180' }}</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">5% of total</div>
            </div>
        </div>

        <!-- Card 5: Featured Products -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="product-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Featured Products</span>
                    <div class="kpi-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['featured'] ?? '310' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 28%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">8% of total</div>
            </div>
        </div>

        <!-- Card 6: Top Selling -->
        <div class="col-12 col-sm-6 col-xl-2">
            <div class="product-kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">Top Selling</span>
                    <div class="kpi-icon-circle kpi-icon-yellow">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-dark">{{ $stats['top_selling'] ?? '56' }}</span>
                    <span class="badge bg-success-subtle text-success small fw-semibold">↑ 35%</span>
                </div>
                <div class="text-muted" style="font-size: 0.75rem;">Based on orders & revenue</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs matching Screenshot 1 -->
    <div class="mb-3">
        <nav class="nav nav-tabs-products">
            <a href="{{ route('admin.catalog.products') }}" class="nav-link {{ (!request('status') || request('status') === 'all') && !request('tab') ? 'active' : '' }}">
                All Products ({{ number_format($counts['all'] ?? 3980) }})
            </a>
            <a href="{{ route('admin.catalog.products', ['status' => 'active']) }}" class="nav-link {{ request('status') === 'active' || request('tab') === 'active' || request('status') === 'approved' ? 'active' : '' }}">
                Active ({{ number_format($counts['active'] ?? 3120) }})
            </a>
            <a href="{{ route('admin.catalog.products', ['status' => 'pending']) }}" class="nav-link {{ request('status') === 'pending' || request('tab') === 'pending' ? 'active' : '' }}">
                Pending ({{ number_format($counts['pending'] ?? 420) }})
            </a>
            <a href="{{ route('admin.catalog.products', ['status' => 'rejected']) }}" class="nav-link {{ request('status') === 'rejected' || request('tab') === 'rejected' ? 'active' : '' }}">
                Rejected ({{ number_format($counts['rejected'] ?? 180) }})
            </a>
            <a href="{{ route('admin.catalog.products', ['status' => 'featured']) }}" class="nav-link {{ request('status') === 'featured' || request('tab') === 'featured' ? 'active' : '' }}">
                Featured ({{ number_format($counts['featured'] ?? 310) }})
            </a>
            <a href="{{ route('admin.catalog.products', ['status' => 'top_selling']) }}" class="nav-link {{ request('status') === 'top_selling' || request('tab') === 'top_selling' ? 'active' : '' }}">
                Top Selling ({{ number_format($counts['top_selling'] ?? 56) }})
            </a>
            <a href="{{ route('admin.catalog.products', ['status' => 'low_stock']) }}" class="nav-link {{ request('status') === 'low_stock' || request('tab') === 'low_stock' ? 'active' : '' }}">
                Low Stock ({{ number_format($counts['low_stock'] ?? 210) }})
            </a>
        </nav>
    </div>

    <!-- 2-Row Filter & Search Toolbar matching Screenshot 1 -->
    <div class="bg-white p-3 rounded-3 border mb-3">
        <form method="GET" action="{{ route('admin.catalog.products') }}">
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
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 ps-0" placeholder="Search by product name, seller, SKU...">
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">All Categories</option>
                        <option value="Computers" {{ request('category') === 'Computers' ? 'selected' : '' }}>Computers</option>
                        <option value="Accessories" {{ request('category') === 'Accessories' ? 'selected' : '' }}>Accessories</option>
                        <option value="Furniture" {{ request('category') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                        <option value="Design Tools" {{ request('category') === 'Design Tools' ? 'selected' : '' }}>Design Tools</option>
                        <option value="Software" {{ request('category') === 'Software' ? 'selected' : '' }}>Software</option>
                        <option value="Camera" {{ request('category') === 'Camera' ? 'selected' : '' }}>Camera</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Product Type</option>
                        <option value="Physical" {{ request('type') === 'Physical' ? 'selected' : '' }}>Physical</option>
                        <option value="Digital" {{ request('type') === 'Digital' ? 'selected' : '' }}>Digital</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="seller" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">All Sellers</option>
                        <option value="Tech World" {{ request('seller') === 'Tech World' ? 'selected' : '' }}>Tech World</option>
                        <option value="Gadget Hub" {{ request('seller') === 'Gadget Hub' ? 'selected' : '' }}>Gadget Hub</option>
                        <option value="HomeOffice" {{ request('seller') === 'HomeOffice' ? 'selected' : '' }}>HomeOffice</option>
                        <option value="Design Store" {{ request('seller') === 'Design Store' ? 'selected' : '' }}>Design Store</option>
                        <option value="VCEC Store" {{ request('seller') === 'VCEC Store' ? 'selected' : '' }}>VCEC Store</option>
                        <option value="Creative Minds" {{ request('seller') === 'Creative Minds' ? 'selected' : '' }}>Creative Minds</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="stock_status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Stock Status</option>
                        <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock (< 10)</option>
                    </select>
                </div>

                <div class="col-12 col-lg-1">
                    <select class="form-select form-select-sm text-muted">
                        <option>Price Range</option>
                    </select>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row g-2 align-items-center">
                <div class="col-6 col-lg-2">
                    <select name="location" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">All Locations</option>
                        <option value="Surat" {{ request('location') === 'Surat' ? 'selected' : '' }}>Surat</option>
                        <option value="Mumbai" {{ request('location') === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                        <option value="Ahmedabad" {{ request('location') === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                        <option value="Bengaluru" {{ request('location') === 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
                        <option value="Jaipur" {{ request('location') === 'Jaipur' ? 'selected' : '' }}>Jaipur</option>
                        <option value="Delhi" {{ request('location') === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="featured_status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Featured Status</option>
                        <option value="featured">Featured Only</option>
                        <option value="not_featured">Non-Featured</option>
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <select name="approval_status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Approval Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
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

                <div class="col-4 col-lg-4 text-end">
                    <a href="{{ route('admin.catalog.products') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Content Area: Table + Right Inspector Panel -->
    <div class="row g-3">
        <!-- Left: Products Table -->
        <div class="col-12 col-xl-8">
            <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0" id="productsTable">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 32px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Product Details</th>
                                <th>Seller</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Orders</th>
                                <th>Status</th>
                                <th class="text-center">Featured</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse($products as $idx => $p)
                                @php
                                    $id = $p['id'];
                                    $sku = $p['sku'];
                                    $name = $p['name'];
                                    $slug = $p['slug'];
                                    $sellerName = $p['seller_name'];
                                    $sellerCity = $p['seller_city'];
                                    $sellerLogo = $p['seller_logo'];
                                    $category = $p['category'];
                                    $type = $p['product_type'];
                                    $price = (float)$p['price'];
                                    $stock = $p['stock'];
                                    $orders = $p['orders'];
                                    $statusText = $p['status'];
                                    $isFeatured = !empty($p['is_featured']);
                                    $thumbnail = $p['thumbnail'];

                                    $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $category));
                                    $statusClass = match(strtolower($statusText)) {
                                        'active' => 'active',
                                        'pending' => 'pending',
                                        default => 'rejected',
                                    };
                                @endphp
                                <tr class="product-row {{ $idx === 0 ? 'selected-row' : '' }}" onclick='inspectProduct(@json($p), this)'>
                                    <td onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input"></td>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $thumbnail }}" alt="{{ $name }}" class="rounded border p-1" style="width: 44px; height: 38px; object-fit: contain; background: #fff;">
                                            <div>
                                                <div class="fw-semibold text-dark text-truncate" style="max-width: 160px;">{{ $name }}</div>
                                                <div class="text-muted font-monospace" style="font-size: 0.68rem;">SKU: {{ $sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $sellerLogo }}" alt="{{ $sellerName }}" class="rounded-circle border" style="width: 24px; height: 24px;">
                                            <div>
                                                <div class="fw-medium text-dark text-truncate" style="max-width: 110px;">{{ $sellerName }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $sellerCity }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cat-badge cat-{{ $catSlug }}">{{ $category }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-muted border fw-normal" style="font-size: 0.7rem;">{{ $type }}</span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        ₹{{ number_format($price) }}
                                    </td>
                                    <td class="text-center fw-medium {{ $stock < 10 && is_numeric($stock) ? 'text-danger' : 'text-dark' }}">
                                        {{ $stock }}
                                    </td>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ $orders }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $statusClass }}">
                                            <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i>
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        <form method="POST" action="{{ route('admin.catalog.products.toggle-featured', $id) }}" class="d-inline">
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
                                                    <a class="dropdown-item small" href="{{ url('/product/' . $slug) }}" target="_blank">
                                                        <i class="fa-solid fa-arrow-up-right-from-square me-2 text-primary"></i> View Public Product
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                @if(strtolower($statusText) !== 'active')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.catalog.products.approve', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-success">
                                                                <i class="fa-solid fa-check me-2"></i> Approve Product
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if(strtolower($statusText) !== 'rejected')
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.catalog.products.reject', $id) }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item small text-danger">
                                                                <i class="fa-solid fa-xmark me-2"></i> Reject Product
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item small" href="{{ url('/products') }}" target="_blank">
                                                        <i class="fa-regular fa-pen-to-square me-2 text-muted"></i> Edit Product
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fs-1 mb-2 text-muted"></i>
                                        <p class="mb-0">No products found matching the selected criteria.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Bar -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light small">
                    <span class="text-muted">Showing 1 to {{ count($products) }} of {{ number_format($counts['all'] ?? 3980) }} products</span>
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

        <!-- Right: Interactive Product Inspector Panel matching Screenshot 1 -->
        <div class="col-12 col-xl-4">
            <div class="inspector-panel p-3 shadow-sm" id="productInspector">
                <!-- Top Big Image Preview with Status Badge & More button -->
                <div class="position-relative bg-light rounded-3 p-3 text-center mb-2 border">
                    <span class="status-pill active position-absolute top-0 start-0 m-2" id="inspStatus">Active</span>
                    <button class="btn btn-sm btn-light border-0 position-absolute top-0 end-0 m-2 text-muted" onclick="document.getElementById('productInspector').classList.toggle('d-none')">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <img id="inspMainImg" src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600&auto=format&fit=crop&q=80" alt="Product" class="img-fluid" style="max-height: 160px; object-fit: contain;">
                </div>

                <!-- Small Thumbnails Strip below main preview -->
                <div class="d-flex gap-2 mb-3">
                    <img id="inspThumb1" src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=100&auto=format&fit=crop&q=80" class="rounded border p-1" style="width: 48px; height: 38px; object-fit: contain; cursor: pointer;">
                    <img id="inspThumb2" src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=100&auto=format&fit=crop&q=80" class="rounded border p-1" style="width: 48px; height: 38px; object-fit: contain; cursor: pointer;">
                    <img id="inspThumb3" src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=100&auto=format&fit=crop&q=80" class="rounded border p-1" style="width: 48px; height: 38px; object-fit: contain; cursor: pointer;">
                    <div class="rounded border d-flex align-items-center justify-content-center text-muted fw-bold small bg-light" style="width: 48px; height: 38px; font-size: 0.72rem;">
                        +3
                    </div>
                </div>

                <!-- Product Title & View on Store button -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0" id="inspTitle">HP Laptop 15s</h5>
                        <div class="text-muted small">
                            <span class="font-monospace" id="inspSku">SKU: PRD00125</span> · Listed by: <span class="fw-medium text-dark" id="inspSellerName">Tech World</span>
                        </div>
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <i class="fa-solid fa-star text-warning" style="font-size: 0.75rem;"></i>
                            <span class="small fw-semibold text-dark" id="inspRating">4.8 (125 reviews)</span>
                        </div>
                    </div>
                    <a id="inspStoreBtn" href="{{ url('/product/hp-15s-laptop') }}" target="_blank" class="btn btn-outline-primary btn-sm px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                        View on Store
                    </a>
                </div>

                <!-- Action Buttons: Overview | Images | Variants (3) | Reviews (125) | Orders (28) -->
                <ul class="nav nav-pills nav-fill mb-3 border-bottom pb-2 small" id="inspectorTabs">
                    <li class="nav-item">
                        <a class="nav-link active py-1 px-2 fw-semibold" style="font-size: 0.78rem;" href="#tabOverview" data-bs-toggle="pill">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabImages" data-bs-toggle="pill">Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabVariants" data-bs-toggle="pill">Variants (3)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabReviews" data-bs-toggle="pill" id="inspReviewsTab">Reviews (125)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-1 px-2 fw-semibold text-muted" style="font-size: 0.78rem;" href="#tabOrders" data-bs-toggle="pill" id="inspOrdersTab">Orders (28)</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Overview -->
                    <div class="tab-pane fade show active" id="tabOverview">
                        <!-- Product Information Section matching Screenshot 1 -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Product Information</span>
                                <a href="{{ url('/products') }}" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>Edit
                                </a>
                            </div>
                            <div class="bg-light p-2 rounded-2 small" style="font-size: 0.78rem;">
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Product Name</div>
                                    <div class="col-8 fw-semibold text-dark text-truncate" id="inspDetailName">HP Laptop 15s</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Category</div>
                                    <div class="col-8 text-dark" id="inspDetailCategory">Computers</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Sub Category</div>
                                    <div class="col-8 text-dark" id="inspDetailSubCat">Laptops</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Product Type</div>
                                    <div class="col-8 text-dark" id="inspDetailType">Physical Product</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Brand</div>
                                    <div class="col-8 text-dark" id="inspDetailBrand">HP</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Regular Price</div>
                                    <div class="col-8 fw-bold text-dark" id="inspDetailRegPrice">₹42,999</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Discount Price</div>
                                    <div class="col-8 text-success fw-bold" id="inspDetailDiscPrice">₹39,999</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">Stock Quantity</div>
                                    <div class="col-8 text-dark" id="inspDetailStock">12</div>
                                </div>
                                <div class="row g-1 mb-1">
                                    <div class="col-4 text-muted">SKU</div>
                                    <div class="col-8 text-dark font-monospace" id="inspDetailSku">PRD00125</div>
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
                                    <div class="col-4 text-muted">Created On</div>
                                    <div class="col-8 text-dark" id="inspDetailCreated">12 Oct 2026, 10:30 AM</div>
                                </div>
                            </div>
                        </div>

                        <!-- Seller Information matching Screenshot 1 -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Seller Information</span>
                                <a id="inspSellerProfileLink" href="{{ route('admin.sellers.show', 102) }}" class="text-primary text-decoration-none small fw-semibold" style="font-size: 0.75rem;">View Profile</a>
                            </div>
                            <div class="border rounded-2 p-2 bg-white d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-dark text-white fw-bold d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-size: 0.85rem;" id="inspSellerBoxAvatar">
                                        TW
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="fw-bold text-dark small" id="inspSellerBoxName">Tech World</span>
                                            <i class="fa-solid fa-circle-check text-primary" style="font-size: 0.75rem;" title="Verified"></i>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-star text-warning"></i> <span id="inspSellerBoxRating">4.7 (320 reviews)</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.7rem;" id="inspSellerBoxLocation">Surat, Gujarat</div>
                                    </div>
                                </div>
                                <a id="inspSellerContactBtn" href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm px-2 py-1" style="font-size: 0.75rem;">
                                    Contact
                                </a>
                            </div>
                        </div>

                        <!-- Quick Actions matching Screenshot 1 -->
                        <div class="pt-2 border-top">
                            <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Quick Actions</div>
                            <div class="d-flex flex-wrap gap-2">
                                <form id="inspApproveForm" method="POST" action="{{ route('admin.catalog.products.approve', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <form id="inspRejectForm" method="POST" action="{{ route('admin.catalog.products.reject', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </form>
                                <form id="inspFeatureForm" method="POST" action="{{ route('admin.catalog.products.toggle-featured', 125) }}" class="d-inline flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-star me-1"></i> Feature Toggle
                                    </button>
                                </form>
                                <a href="{{ url('/products') }}" target="_blank" class="btn btn-outline-secondary btn-sm flex-fill" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Images -->
                    <div class="tab-pane fade" id="tabImages">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-images fs-4 mb-2 text-primary"></i>
                            <p class="mb-0">Product photo library and 3D angle views.</p>
                        </div>
                    </div>

                    <!-- Tab 3: Variants -->
                    <div class="tab-pane fade" id="tabVariants">
                        <div class="p-2 small">
                            <div class="border rounded p-2 mb-2 bg-light">
                                <div class="fw-semibold">16GB RAM / 512GB SSD</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Default variant - In Stock</div>
                            </div>
                            <div class="border rounded p-2 mb-2 bg-light">
                                <div class="fw-semibold">8GB RAM / 512GB SSD</div>
                                <div class="text-muted" style="font-size: 0.72rem;">₹38,999 - In Stock</div>
                            </div>
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold">16GB RAM / 1TB SSD</div>
                                <div class="text-muted" style="font-size: 0.72rem;">₹46,999 - 4 units left</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Reviews -->
                    <div class="tab-pane fade" id="tabReviews">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-star fs-4 mb-2 text-warning"></i>
                            <p class="mb-0 fw-bold text-dark">4.8 out of 5.0 (125 reviews)</p>
                        </div>
                    </div>

                    <!-- Tab 5: Orders -->
                    <div class="tab-pane fade" id="tabOrders">
                        <div class="p-2 text-center text-muted small">
                            <i class="fa-solid fa-cart-shopping fs-4 mb-2 text-success"></i>
                            <p class="mb-0 fw-bold text-dark">28 Orders Fulfilled</p>
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
        document.querySelectorAll('#productsTable tbody input[type="checkbox"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // Interactive Right Inspector Panel Updater
    function inspectProduct(p, rowElem) {
        if (!p) return;

        // Highlight selected row
        document.querySelectorAll('.product-row').forEach(r => r.classList.remove('selected-row'));
        if (rowElem) {
            rowElem.classList.add('selected-row');
        }

        // Make sure inspector is visible
        const inspector = document.getElementById('productInspector');
        if (inspector) inspector.classList.remove('d-none');

        // Main image preview
        const mainImg = document.getElementById('inspMainImg');
        if (mainImg) mainImg.src = p.thumbnail || (p.gallery && p.gallery[0]) || '';

        const thumb1 = document.getElementById('inspThumb1');
        if (thumb1) thumb1.src = p.thumbnail || '';

        const thumb2 = document.getElementById('inspThumb2');
        if (thumb2 && p.gallery && p.gallery[1]) thumb2.src = p.gallery[1];

        const thumb3 = document.getElementById('inspThumb3');
        if (thumb3 && p.gallery && p.gallery[2]) thumb3.src = p.gallery[2];

        // Header update
        const title = document.getElementById('inspTitle');
        if (title) title.innerText = p.name;

        const sku = document.getElementById('inspSku');
        if (sku) sku.innerText = `SKU: ${p.sku || ('PRD' + String(p.id).padStart(5, '0'))}`;

        const sellerName = document.getElementById('inspSellerName');
        if (sellerName) sellerName.innerText = p.seller_name;

        const rating = document.getElementById('inspRating');
        if (rating) rating.innerText = `${p.rating || 4.8} (${p.reviews_count || 125} reviews)`;

        const statusPill = document.getElementById('inspStatus');
        if (statusPill) {
            statusPill.innerText = p.status || 'Active';
            statusPill.className = `status-pill ${String(p.status || 'active').toLowerCase()} position-absolute top-0 start-0 m-2`;
        }

        // Action Buttons
        const storeBtn = document.getElementById('inspStoreBtn');
        if (storeBtn) storeBtn.href = `/product/${p.slug || ''}`;

        // Tabs counts
        const rvTab = document.getElementById('inspReviewsTab');
        if (rvTab) rvTab.innerText = `Reviews (${p.reviews_count || 125})`;

        const ordTab = document.getElementById('inspOrdersTab');
        if (ordTab) ordTab.innerText = `Orders (${(p.orders || 28).toLocaleString()})`;

        // Basic Information
        const dName = document.getElementById('inspDetailName');
        if (dName) dName.innerText = p.name;

        const dCat = document.getElementById('inspDetailCategory');
        if (dCat) dCat.innerText = p.category || 'Computers';

        const dSubCat = document.getElementById('inspDetailSubCat');
        if (dSubCat) dSubCat.innerText = p.sub_category || 'Laptops';

        const dType = document.getElementById('inspDetailType');
        if (dType) dType.innerText = `${p.product_type || 'Physical'} Product`;

        const dBrand = document.getElementById('inspDetailBrand');
        if (dBrand) dBrand.innerText = p.brand || 'HP';

        const dRegPrice = document.getElementById('inspDetailRegPrice');
        if (dRegPrice) dRegPrice.innerText = `₹${Number(p.regular_price || p.price || 0).toLocaleString()}`;

        const dDiscPrice = document.getElementById('inspDetailDiscPrice');
        if (dDiscPrice) dDiscPrice.innerText = `₹${Number(p.discount_price || p.price || 0).toLocaleString()}`;

        const dStock = document.getElementById('inspDetailStock');
        if (dStock) dStock.innerText = p.stock || 12;

        const dSku = document.getElementById('inspDetailSku');
        if (dSku) dSku.innerText = p.sku || 'PRD00125';

        const dStatus = document.getElementById('inspDetailStatus');
        if (dStatus) dStatus.innerText = p.status || 'Active';

        const dFeatured = document.getElementById('inspDetailFeatured');
        if (dFeatured) dFeatured.innerText = p.is_featured ? 'Yes' : 'No';

        const dCreated = document.getElementById('inspDetailCreated');
        if (dCreated) dCreated.innerText = p.created_on || '12 Oct 2026, 10:30 AM';

        // Seller Information Box
        const sBoxName = document.getElementById('inspSellerBoxName');
        if (sBoxName) sBoxName.innerText = p.seller_name;

        const sBoxAvatar = document.getElementById('inspSellerBoxAvatar');
        if (sBoxAvatar) sBoxAvatar.innerText = p.seller_name.substring(0, 2).toUpperCase();

        const sBoxRating = document.getElementById('inspSellerBoxRating');
        if (sBoxRating) sBoxRating.innerText = `${p.seller_rating || 4.7} (${p.seller_reviews || '320 reviews'})`;

        const sBoxLoc = document.getElementById('inspSellerBoxLocation');
        if (sBoxLoc) sBoxLoc.innerText = p.seller_location || p.seller_city || 'Surat, Gujarat';

        const sProfileLink = document.getElementById('inspSellerProfileLink');
        if (sProfileLink) sProfileLink.href = p.seller_id ? `/admin/sellers/${p.seller_id}` : `/admin/sellers/${encodeURIComponent(p.seller_name.toLowerCase().replace(/[^a-z0-9]/g, '-'))}`;

        // Action Forms
        const approveForm = document.getElementById('inspApproveForm');
        if (approveForm) approveForm.action = `/admin/catalog/products/${p.id}/approve`;

        const rejectForm = document.getElementById('inspRejectForm');
        if (rejectForm) rejectForm.action = `/admin/catalog/products/${p.id}/reject`;

        const featureForm = document.getElementById('inspFeatureForm');
        if (featureForm) featureForm.action = `/admin/catalog/products/${p.id}/toggle-featured`;
    }

    // Auto-inspect first product on load
    document.addEventListener('DOMContentLoaded', function () {
        const firstRow = document.querySelector('.product-row');
        if (firstRow) {
            firstRow.click();
        }
    });
</script>
@endsection
