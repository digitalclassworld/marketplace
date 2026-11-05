@extends('admin.layouts.admin')

@section('title', 'Reviews & Ratings Management - Super Admin')

@section('styles')
<style>
    /* Custom Styling matching Screenshot pixel-for-pixel */
    .review-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        height: 100%;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .review-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .review-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .kpi-icon-amber   { background: #fef3c7; color: #d97706; }
    .kpi-icon-blue    { background: #eff6ff; color: #2563eb; }
    .kpi-icon-green   { background: #ecfdf5; color: #059669; }
    .kpi-icon-orange  { background: #fff7ed; color: #ea580c; }
    .kpi-icon-red     { background: #fef2f2; color: #dc2626; }

    /* Navigation Filter Tabs */
    .review-tabs-nav {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .review-tabs-nav .nav-link {
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
    .review-tabs-nav .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .review-tabs-nav .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .review-tabs-nav .nav-link.active::after {
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
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        display: inline-block;
    }
    .type-course   { background: #f3e8ff; color: #7e22ce; }
    .type-service  { background: #ccfbf1; color: #0f766e; }
    .type-product  { background: #ffedd5; color: #c2410c; }
    .type-business { background: #e0f2fe; color: #0369a1; }

    /* Status Badges */
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        display: inline-block;
    }
    .status-approved { background: #dcfce7; color: #15803d; }
    .status-pending  { background: #fef3c7; color: #b45309; }
    .status-rejected { background: #fee2e2; color: #b91c1c; }
    .status-flagged  { background: #ffe4e6; color: #be123c; }

    /* Stars */
    .star-rating-gold {
        color: #f59e0b;
        font-size: 0.82rem;
        letter-spacing: 1px;
    }

    /* Table Row Hover & Selected */
    .review-table-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .review-table-row:hover {
        background-color: #f8fafc !important;
    }
    .review-table-row.selected-row {
        background-color: #f0f7ff !important;
        outline: 1.5px solid #3b82f6;
    }

    /* Attached image preview */
    .thumb-stack {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 5px;
    }
    .thumb-stack img {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }
    .thumb-stack .more-count {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #e2e8f0;
        color: #475569;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Right Side Inspector */
    .review-inspector-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        position: sticky;
        top: 80px;
    }

    .gallery-preview-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }
    .gallery-preview-grid img {
        width: 100%;
        height: 54px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        transition: transform 0.15s ease;
    }
    .gallery-preview-grid img:hover {
        transform: scale(1.05);
    }

    .meta-key-val {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        padding: 0.25rem 0;
        border-bottom: 1px dashed #f1f5f9;
    }
    .meta-key-val:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Top Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Reviews & Ratings Management</h1>
            <p class="text-muted small mb-0">Manage and moderate reviews, ratings and feedback across courses, services, products and business listings.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Export Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-white border bg-white text-secondary dropdown-toggle px-3 py-2 fw-medium shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-arrow-down-to-bracket me-1.5 text-muted"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item py-2" href="{{ route('admin.reviews.export', ['format' => 'excel']) }}"><i class="fa-regular fa-file-excel text-success me-2"></i> Download as Excel</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.reviews.export', ['format' => 'pdf']) }}"><i class="fa-regular fa-file-pdf text-danger me-2"></i> Download as PDF</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.reviews.export', ['format' => 'filtered']) }}"><i class="fa-solid fa-filter text-primary me-2"></i> Download Filtered Data</a></li>
                </ul>
            </div>

            {{-- Import Reviews Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" onclick="alert('Import reviews wizard will open here.')">
                <i class="fa-solid fa-file-import me-1.5 text-muted"></i> Import Reviews
            </button>

            {{-- Moderation Settings Button --}}
            <button class="btn btn-primary px-3 py-2 fw-medium shadow-sm" style="background-color: #0066ff; border-color: #0066ff;" onclick="alert('Moderation auto-filter rules: Profanity filter is ACTIVE, Auto-approve verified buyers is ACTIVE.')">
                <i class="fa-solid fa-gear me-1.5"></i> Moderation Settings
            </button>
        </div>
    </div>

    {{-- 5 KPI Metric Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl col-md-4 col-sm-6">
            <div class="review-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Total Reviews</span>
                    <div class="review-icon-circle kpi-icon-amber">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_reviews'] ?? '3,420' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.72rem;">↑ {{ $stats['reviews_growth'] ?? '18%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['reviews_sub'] ?? '+520 this month' }}</span>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="review-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Average Rating</span>
                    <div class="review-icon-circle kpi-icon-blue">
                        <i class="fa-solid fa-award"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['average_rating'] ?? '4.6 / 5' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['rating_sub'] ?? '+0.3 from last month' }}</span>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="review-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Approved</span>
                    <div class="review-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['approved'] ?? '3,180' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['approved_sub'] ?? '93% of total' }}</span>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="review-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Pending</span>
                    <div class="review-icon-circle kpi-icon-orange">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['pending'] ?? '160' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['pending_sub'] ?? '5% of total' }}</span>
            </div>
        </div>

        <div class="col-xl col-md-4 col-sm-6">
            <div class="review-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Rejected</span>
                    <div class="review-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['rejected'] ?? '80' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['rejected_sub'] ?? '2% of total' }}</span>
            </div>
        </div>
    </div>

    {{-- Tabs Row --}}
    <div class="d-flex review-tabs-nav mb-3 overflow-auto">
        <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['tab' => 'all'])) }}" class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}">
            All Reviews ({{ number_format($counts['all'] ?? 3420) }})
        </a>
        <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['tab' => 'pending'])) }}" class="nav-link {{ $currentTab === 'pending' ? 'active' : '' }}">
            Pending ({{ number_format($counts['pending'] ?? 160) }})
        </a>
        <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['tab' => 'approved'])) }}" class="nav-link {{ $currentTab === 'approved' ? 'active' : '' }}">
            Approved ({{ number_format($counts['approved'] ?? 3180) }})
        </a>
        <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['tab' => 'rejected'])) }}" class="nav-link {{ $currentTab === 'rejected' ? 'active' : '' }}">
            Rejected ({{ number_format($counts['rejected'] ?? 80) }})
        </a>
        <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['tab' => 'flagged'])) }}" class="nav-link {{ $currentTab === 'flagged' ? 'active' : '' }}">
            Flagged ({{ number_format($counts['flagged'] ?? 24) }})
        </a>
    </div>

    {{-- Filter Bar (2 Rows) --}}
    <form action="{{ route('admin.reviews.index') }}" method="GET" class="card border-0 shadow-sm p-3 mb-4 rounded-3 bg-white">
        <input type="hidden" name="tab" value="{{ $currentTab }}">

        {{-- Row 1 --}}
        <div class="row g-2 align-items-center mb-2">
            <div class="col-lg-3 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3 pe-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-1" placeholder="Search by customer name, review text..." value="{{ $searchQuery ?? '' }}">
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <select name="type" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="Course" {{ ($typeFilter ?? '') === 'Course' ? 'selected' : '' }}>Courses</option>
                    <option value="Service" {{ ($typeFilter ?? '') === 'Service' ? 'selected' : '' }}>Services</option>
                    <option value="Product" {{ ($typeFilter ?? '') === 'Product' ? 'selected' : '' }}>Products</option>
                    <option value="Business" {{ ($typeFilter ?? '') === 'Business' ? 'selected' : '' }}>Business Listings</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <select name="rating" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Ratings</option>
                    <option value="5" {{ ($ratingFilter ?? '') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ ($ratingFilter ?? '') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ ($ratingFilter ?? '') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ ($ratingFilter ?? '') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ ($ratingFilter ?? '') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <select name="status" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="Approved" {{ ($statusFilter ?? '') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Pending" {{ ($statusFilter ?? '') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Rejected" {{ ($statusFilter ?? '') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="Flagged" {{ ($statusFilter ?? '') === 'Flagged' ? 'selected' : '' }}>Flagged</option>
                </select>
            </div>

            <div class="col-lg-1 col-md-3 col-6">
                <select name="platform" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Platforms</option>
                    <option value="Website" {{ ($platformFilter ?? '') === 'Website' ? 'selected' : '' }}>Website</option>
                    <option value="Android" {{ ($platformFilter ?? '') === 'Android' ? 'selected' : '' }}>Android App</option>
                    <option value="iOS" {{ ($platformFilter ?? '') === 'iOS' ? 'selected' : '' }}>iOS App</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-6 col-12 d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                    <input type="text" class="form-control border-start-0" value="01 Oct 2026 - 31 Oct 2026" readonly style="font-size: 0.8rem; background-color: #ffffff;">
                </div>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="row g-2 align-items-center">
            <div class="col-lg-3 col-md-6">
                <select name="category" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Digital Marketing" {{ ($categoryFilter ?? '') === 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                    <option value="Development" {{ ($categoryFilter ?? '') === 'Development' ? 'selected' : '' }}>Development</option>
                    <option value="Computers" {{ ($categoryFilter ?? '') === 'Computers' ? 'selected' : '' }}>Computers</option>
                    <option value="Education" {{ ($categoryFilter ?? '') === 'Education' ? 'selected' : '' }}>Education</option>
                    <option value="Legal & Finance" {{ ($categoryFilter ?? '') === 'Legal & Finance' ? 'selected' : '' }}>Legal & Finance</option>
                    <option value="AI & Tools" {{ ($categoryFilter ?? '') === 'AI & Tools' ? 'selected' : '' }}>AI & Tools</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-6">
                <select name="seller" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Items/Sellers</option>
                    <option value="Tech Skills Academy">Tech Skills Academy</option>
                    <option value="Design Studio Pro">Design Studio Pro</option>
                    <option value="Tech World">Tech World</option>
                    <option value="Creative Minds">Creative Minds</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <select name="location" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Locations</option>
                    <option value="Ahmedabad">Ahmedabad</option>
                    <option value="Surat">Surat</option>
                    <option value="Vadodara">Vadodara</option>
                    <option value="Rajkot">Rajkot</option>
                    <option value="Mumbai">Mumbai</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <select name="with_photos" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">With Photos</option>
                    <option value="yes" {{ ($withPhotos ?? '') === 'yes' ? 'selected' : '' }}>Yes (Photos Only)</option>
                    <option value="no" {{ ($withPhotos ?? '') === 'no' ? 'selected' : '' }}>No Photos</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-4 col-12">
                <select name="flagged_only" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">Flagged Only</option>
                    <option value="1" {{ ($flaggedOnly ?? '') === '1' ? 'selected' : '' }}>Flagged Only</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Main Workspace: Table (Left/Center) + Inspector Panel (Right) --}}
    <div class="row g-3">
        {{-- Reviews Table Column --}}
        <div class="col-xxl-8 col-xl-7 col-lg-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="reviewsTable">
                        <thead class="table-light text-uppercase fw-bold text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-3" style="width: 30px;"><input type="checkbox" class="form-check-input" id="selectAllReviews"></th>
                                <th style="width: 35px;">#</th>
                                <th style="min-width: 150px;">User</th>
                                <th style="min-width: 105px;">Rating</th>
                                <th style="min-width: 200px;">Review Details</th>
                                <th style="min-width: 80px;">Type</th>
                                <th style="min-width: 170px;">Item/Seller</th>
                                <th style="min-width: 110px;">Date</th>
                                <th style="min-width: 85px;">Status</th>
                                <th class="text-end pe-3" style="width: 45px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.82rem;">
                            @forelse($reviews as $idx => $r)
                                <tr class="review-table-row {{ $idx === 0 ? 'selected-row' : '' }}"
                                    data-review="{{ json_encode($r) }}"
                                    onclick="inspectReview(this)">
                                    <td class="ps-3" onclick="event.stopPropagation();">
                                        <input type="checkbox" class="form-check-input review-checkbox">
                                    </td>
                                    <td class="text-muted fw-semibold">{{ $r['id'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $r['user_avatar'] }}" alt="{{ $r['user_name'] }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $r['user_name'] }}</div>
                                                <div class="text-muted" style="font-size: 0.72rem;">{{ $r['user_city'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="star-rating-gold">
                                                @for($s = 1; $s <= 5; $s++)
                                                    @if($s <= floor($r['rating']))
                                                        <i class="fa-solid fa-star"></i>
                                                    @elseif($s - $r['rating'] < 1)
                                                        <i class="fa-solid fa-star-half-stroke"></i>
                                                    @else
                                                        <i class="fa-regular fa-star text-muted" style="opacity: 0.4;"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                            <span class="fw-bold text-dark ms-1">{{ number_format($r['rating'], 1) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark review-snippet" style="max-width: 230px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $r['review_text'] }}
                                        </div>
                                        @if(!empty($r['photos']) && count($r['photos']) > 0)
                                            <div class="thumb-stack">
                                                @foreach(array_slice($r['photos'], 0, 3) as $photo)
                                                    <img src="{{ $photo }}" alt="attachment">
                                                @endforeach
                                                @if(count($r['photos']) > 3)
                                                    <div class="more-count">+{{ count($r['photos']) - 3 }}</div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="type-pill type-{{ strtolower($r['review_type']) }}">
                                            {{ $r['review_type'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $r['item_thumbnail'] }}" alt="{{ $r['item_title'] }}" class="rounded border" style="width: 36px; height: 36px; object-fit: cover;">
                                            <div style="max-width: 130px;">
                                                <div class="fw-bold text-dark text-truncate">{{ $r['item_title'] }}</div>
                                                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $r['seller_name'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $r['date_formatted'] }}</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">{{ $r['time_formatted'] }}</div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($r['status']) }}">
                                            {{ $r['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 px-2 text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                                                <li>
                                                    <button class="dropdown-item py-1.5" onclick="inspectReviewById({{ $r['id'] }})">
                                                        <i class="fa-regular fa-eye me-2 text-primary"></i> View Details
                                                    </button>
                                                </li>
                                                @if($r['status'] !== 'Approved')
                                                    <li>
                                                        <form action="{{ route('admin.reviews.approve', $r['id']) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item py-1.5 text-success">
                                                                <i class="fa-solid fa-check me-2"></i> Approve Review
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($r['status'] !== 'Rejected')
                                                    <li>
                                                        <form action="{{ route('admin.reviews.reject', $r['id']) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item py-1.5 text-danger">
                                                                <i class="fa-solid fa-xmark me-2"></i> Reject Review
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <form action="{{ route('admin.reviews.feature', $r['id']) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item py-1.5 text-info">
                                                            <i class="fa-regular fa-star me-2"></i> {{ !empty($r['is_featured']) ? 'Unfeature Review' : 'Feature on Marketplace' }}
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.reviews.destroy', $r['id']) }}" method="POST" onsubmit="return confirm('Permanently delete this review?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-1.5 text-danger">
                                                            <i class="fa-regular fa-trash-can me-2"></i> Delete Review
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-star-half-stroke fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                                        <h6>No Reviews Found</h6>
                                        <p class="small mb-0">Try adjusting your filters or search query.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer & Pagination --}}
                <div class="card-footer bg-white border-0 px-3 py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
                        Showing <strong>1 to {{ count($reviews) }}</strong> of <strong>{{ number_format($counts['all'] ?? 3420) }}</strong> reviews
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <nav aria-label="Review pagination">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                <li class="page-item"><a class="page-link" href="#">342</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>

                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <span>Show</span>
                            <select class="form-select form-select-sm" style="width: 70px;">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span>per page</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Inspector Panel Column --}}
        @php
            $firstReview = $reviews->first() ?? null;
        @endphp
        <div class="col-xxl-4 col-xl-5 col-lg-12">
            <div class="review-inspector-card p-3" id="reviewInspector">
                {{-- Inspector Header --}}
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 fs-6">Review Details</h5>
                    <button type="button" class="btn btn-sm btn-light rounded-circle text-muted" onclick="dismissInspector()" title="Close Inspector">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Empty State when no review --}}
                <div id="inspectorEmptyState" class="text-center py-5 text-muted" style="{{ $firstReview ? 'display: none;' : '' }}">
                    <i class="fa-regular fa-star fs-1 mb-2 opacity-50"></i>
                    <p class="small mb-0">Select a review from the table to view details and moderation options.</p>
                </div>

                <div id="inspectorContent" style="{{ $firstReview ? '' : 'display: none;' }}">
                    {{-- User Profile Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2.5">
                            <img id="inspUserAvatar" src="{{ $firstReview['user_avatar'] ?? '' }}" alt="Avatar" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                            <div>
                                <div class="fw-bold text-dark" id="inspUserName">{{ $firstReview['user_name'] ?? '' }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;" id="inspUserCity">{{ $firstReview['user_city'] ?? '' }}</div>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm px-2.5 py-1" style="font-size: 0.75rem;" onclick="alert('Opening customer profile for ' + document.getElementById('inspUserName').innerText)">
                            View Profile
                        </button>
                    </div>

                    {{-- Rating and Status Row --}}
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="star-rating-gold" id="inspStars">
                                @if($firstReview)
                                    @for($s = 1; $s <= 5; $s++)
                                        @if($s <= floor($firstReview['rating']))
                                            <i class="fa-solid fa-star"></i>
                                        @elseif($s - $firstReview['rating'] < 1)
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        @else
                                            <i class="fa-regular fa-star text-muted" style="opacity: 0.4;"></i>
                                        @endif
                                    @endfor
                                @endif
                            </span>
                            <span class="fw-bold text-dark" id="inspRating">{{ $firstReview ? number_format($firstReview['rating'], 1) : '' }}</span>
                        </div>
                        <span class="status-badge status-{{ $firstReview ? strtolower($firstReview['status']) : 'approved' }}" id="inspStatus">{{ $firstReview['status'] ?? 'Approved' }}</span>
                    </div>

                    <div class="text-muted mb-2.5" style="font-size: 0.75rem;" id="inspDateTime">
                        {{ $firstReview ? ($firstReview['date_formatted'] . ', ' . $firstReview['time_formatted']) : '' }}
                    </div>

                    {{-- Full Review Text --}}
                    <div class="p-2.5 bg-light rounded-3 mb-3 text-secondary" style="font-size: 0.8rem; line-height: 1.5;" id="inspReviewText">
                        {{ $firstReview['review_text'] ?? '' }}
                    </div>

                    {{-- Review Attached Photos Gallery --}}
                    <div id="inspPhotosWrapper" class="mb-3" style="{{ !empty($firstReview['photos']) ? '' : 'display: none;' }}">
                        <div class="d-flex justify-content-between align-items-center mb-1.5">
                            <span class="text-muted fw-semibold" style="font-size: 0.75rem;">Attached Photos</span>
                            <a href="javascript:void(0)" class="text-primary text-decoration-none" style="font-size: 0.75rem;" id="inspPhotosCountLink">
                                View All ({{ !empty($firstReview['photos']) ? count($firstReview['photos']) : 0 }})
                            </a>
                        </div>
                        <div class="gallery-preview-grid" id="inspPhotosGrid">
                            @if(!empty($firstReview['photos']))
                                @foreach(array_slice($firstReview['photos'], 0, 4) as $photo)
                                    <img src="{{ $photo }}" alt="Photo">
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- "Review For" Card --}}
                    <div class="border rounded-3 p-2.5 mb-3 bg-white">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="fw-bold text-dark" style="font-size: 0.8rem;">Review For</span>
                            <a href="javascript:void(0)" class="text-primary text-decoration-none" style="font-size: 0.75rem;" id="inspViewItemLink" onclick="alert('Viewing marketplace item: ' + document.getElementById('inspItemTitle').innerText)">View Item</a>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                            <img id="inspItemThumbnail" src="{{ $firstReview['item_thumbnail'] ?? '' }}" alt="Item" class="rounded border" style="width: 44px; height: 44px; object-fit: cover;">
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark text-truncate" style="font-size: 0.82rem;" id="inspItemTitle">{{ $firstReview['item_title'] ?? '' }}</div>
                                <span class="type-pill type-{{ $firstReview ? strtolower($firstReview['review_type']) : 'course' }} py-0 px-1.5" style="font-size: 0.68rem;" id="inspItemTypePill">{{ $firstReview['review_type'] ?? '' }}</span>
                                <span class="text-muted ms-1 text-truncate" style="font-size: 0.72rem;" id="inspSellerName">{{ $firstReview['seller_name'] ?? '' }}</span>
                            </div>
                        </div>

                        {{-- Metadata Key-Values --}}
                        <div class="meta-key-val">
                            <span class="text-muted">Type</span>
                            <span class="fw-semibold text-dark" id="inspMetaType">{{ $firstReview['review_type'] ?? '' }}</span>
                        </div>
                        <div class="meta-key-val">
                            <span class="text-muted">Category</span>
                            <span class="fw-semibold text-dark" id="inspMetaCategory">{{ $firstReview['category'] ?? '' }}</span>
                        </div>
                        <div class="meta-key-val">
                            <span class="text-muted">Seller</span>
                            <span class="fw-semibold text-dark" id="inspMetaSeller">{{ $firstReview['seller_name'] ?? '' }}</span>
                        </div>
                        <div class="meta-key-val">
                            <span class="text-muted">Order ID</span>
                            <span class="font-monospace fw-semibold text-primary" id="inspMetaOrderId">{{ $firstReview['order_id'] ?? '' }}</span>
                        </div>
                        <div class="meta-key-val">
                            <span class="text-muted">Enrolled On</span>
                            <span class="fw-semibold text-dark" id="inspMetaEnrolled">{{ $firstReview['enrolled_on'] ?? '' }}</span>
                        </div>
                        <div class="meta-key-val">
                            <span class="text-muted">Completed On</span>
                            <span class="fw-semibold text-dark" id="inspMetaCompleted">{{ $firstReview['completed_on'] ?? '' }}</span>
                        </div>
                    </div>

                    {{-- Helpful Votes & Report --}}
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded-3 mb-3" style="font-size: 0.78rem;">
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted fw-semibold">Helpful Votes</span>
                            <span class="text-success fw-bold"><i class="fa-regular fa-thumbs-up me-1"></i> <span id="inspUpvotes">{{ $firstReview['helpful_upvotes'] ?? 0 }}</span></span>
                            <span class="text-danger fw-bold"><i class="fa-regular fa-thumbs-down me-1"></i> <span id="inspDownvotes">{{ $firstReview['helpful_downvotes'] ?? 0 }}</span></span>
                        </div>
                        <button class="btn btn-sm btn-link text-danger text-decoration-none p-0" onclick="alert('Moderation report created for Review #' + activeReviewId)">
                            <i class="fa-regular fa-flag me-1"></i> Report
                        </button>
                    </div>

                    {{-- Admin Notes --}}
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Admin Notes</label>
                        <form id="inspNoteForm" method="POST" action="{{ $firstReview ? ('/admin/reviews/' . $firstReview['id'] . '/note') : '' }}">
                            @csrf
                            <textarea name="admin_notes" id="inspNotes" rows="2" class="form-control mb-1.5" style="font-size: 0.78rem;" placeholder="Add internal notes about this review...">{{ $firstReview['admin_notes'] ?? '' }}</textarea>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm px-3" style="font-size: 0.75rem; background-color: #0066ff; border-color: #0066ff;">
                                    Save Note
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Bottom Actions Grid matching screenshot --}}
                    <div class="pt-2 border-top">
                        <div class="row g-2">
                            <div class="col-6">
                                <form id="inspApproveForm" method="POST" action="{{ $firstReview ? ('/admin/reviews/' . $firstReview['id'] . '/approve') : '' }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm w-100 fw-semibold" style="font-size: 0.78rem; background-color: #10b981; border-color: #10b981;">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>
                            </div>
                            <div class="col-6">
                                <form id="inspRejectForm" method="POST" action="{{ $firstReview ? ('/admin/reviews/' . $firstReview['id'] . '/reject') : '' }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold" style="font-size: 0.78rem;">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </form>
                            </div>
                            <div class="col-6">
                                <form id="inspFeatureForm" method="POST" action="{{ $firstReview ? ('/admin/reviews/' . $firstReview['id'] . '/feature') : '' }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100 fw-semibold" style="font-size: 0.78rem;">
                                        <i class="fa-regular fa-star me-1"></i> Feature
                                    </button>
                                </form>
                            </div>
                            <div class="col-6">
                                <form id="inspDeleteForm" method="POST" action="{{ $firstReview ? ('/admin/reviews/' . $firstReview['id']) : '' }}" onsubmit="return confirm('Delete this review permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold" style="font-size: 0.78rem;">
                                        <i class="fa-regular fa-trash-can me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    let activeReviewId = null;

    function renderStars(rating) {
        let html = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(rating)) {
                html += '<i class="fa-solid fa-star"></i> ';
            } else if (i - rating < 1) {
                html += '<i class="fa-solid fa-star-half-stroke"></i> ';
            } else {
                html += '<i class="fa-regular fa-star text-muted" style="opacity: 0.4;"></i> ';
            }
        }
        return html;
    }

    function inspectReview(rowEl) {
        // Highlight row
        document.querySelectorAll('.review-table-row').forEach(r => r.classList.remove('selected-row'));
        rowEl.classList.add('selected-row');

        const data = JSON.parse(rowEl.getAttribute('data-review'));
        populateInspector(data);
    }

    function inspectReviewById(id) {
        const rows = document.querySelectorAll('.review-table-row');
        for (let r of rows) {
            const data = JSON.parse(r.getAttribute('data-review'));
            if (data.id === id) {
                inspectReview(r);
                break;
            }
        }
    }

    function populateInspector(data) {
        activeReviewId = data.id;

        document.getElementById('inspectorContent').style.display = 'block';
        const emptyState = document.getElementById('inspectorEmptyState');
        if (emptyState) emptyState.style.display = 'none';

        // User info
        document.getElementById('inspUserAvatar').src = data.user_avatar;
        document.getElementById('inspUserName').innerText = data.user_name;
        document.getElementById('inspUserCity').innerText = data.user_city;

        // Rating & Status
        document.getElementById('inspStars').innerHTML = renderStars(data.rating);
        document.getElementById('inspRating').innerText = parseFloat(data.rating).toFixed(1);

        const statusEl = document.getElementById('inspStatus');
        statusEl.innerText = data.status;
        statusEl.className = 'status-badge status-' + data.status.toLowerCase();

        document.getElementById('inspDateTime').innerText = (data.date_formatted || '') + ', ' + (data.time_formatted || '');
        document.getElementById('inspReviewText').innerText = data.review_text;

        // Photos
        const photosGrid = document.getElementById('inspPhotosGrid');
        const photosWrapper = document.getElementById('inspPhotosWrapper');
        photosGrid.innerHTML = '';
        if (data.photos && data.photos.length > 0) {
            photosWrapper.style.display = 'block';
            document.getElementById('inspPhotosCountLink').innerText = 'View All (' + data.photos.length + ')';
            data.photos.slice(0, 4).forEach(url => {
                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Photo';
                photosGrid.appendChild(img);
            });
        } else {
            photosWrapper.style.display = 'none';
        }

        // Review For item
        document.getElementById('inspItemThumbnail').src = data.item_thumbnail;
        document.getElementById('inspItemTitle').innerText = data.item_title;
        document.getElementById('inspSellerName').innerText = data.seller_name;

        const typePill = document.getElementById('inspItemTypePill');
        typePill.innerText = data.review_type;
        typePill.className = 'type-pill type-' + (data.review_type ? data.review_type.toLowerCase() : 'course') + ' py-0 px-1.5';

        document.getElementById('inspMetaType').innerText = data.review_type;
        document.getElementById('inspMetaCategory').innerText = data.category || 'General';
        document.getElementById('inspMetaSeller').innerText = data.seller_name;
        document.getElementById('inspMetaOrderId').innerText = data.order_id || 'ORD00' + (1240 + data.id);
        document.getElementById('inspMetaEnrolled').innerText = data.enrolled_on || '20 Oct 2026';
        document.getElementById('inspMetaCompleted').innerText = data.completed_on || '25 Oct 2026';

        // Upvotes & Downvotes
        document.getElementById('inspUpvotes').innerText = data.helpful_upvotes ?? 0;
        document.getElementById('inspDownvotes').innerText = data.helpful_downvotes ?? 0;

        // Admin notes
        document.getElementById('inspNotes').value = data.admin_notes || '';

        // Form action URLs
        document.getElementById('inspNoteForm').action = '/admin/reviews/' + data.id + '/note';
        document.getElementById('inspApproveForm').action = '/admin/reviews/' + data.id + '/approve';
        document.getElementById('inspRejectForm').action = '/admin/reviews/' + data.id + '/reject';
        document.getElementById('inspFeatureForm').action = '/admin/reviews/' + data.id + '/feature';
        document.getElementById('inspDeleteForm').action = '/admin/reviews/' + data.id;
    }

    function dismissInspector() {
        const inspector = document.getElementById('reviewInspector');
        if (inspector) {
            inspector.closest('.col-xxl-4').style.display = 'none';
            const tableCol = document.querySelector('.col-xxl-8');
            if (tableCol) {
                tableCol.className = 'col-12';
            }
        }
    }

    // Select all checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllReviews');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.review-checkbox').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
            });
        }

        // Initialize first review in inspector if present
        const firstRow = document.querySelector('.review-table-row');
        if (firstRow) {
            const data = JSON.parse(firstRow.getAttribute('data-review'));
            populateInspector(data);
        }
    });
</script>
@endpush
@endsection
