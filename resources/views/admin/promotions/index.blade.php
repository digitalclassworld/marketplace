@extends('admin.layouts.admin')

@section('title', 'Marketplace Promotions & Campaigns - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                <i class="fa-solid fa-bullhorn text-warning me-2"></i>Seller Marketing & Promotions Oversight
            </h1>
            <p class="text-secondary small mb-0">
                Manage promotional banners, featured listings, and platform marketing revenues collected from sellers.
            </p>
        </div>
        <div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                <i class="fa-solid fa-sack-dollar me-1"></i> Marketing Revenue: ₹{{ number_format($stats['platform_revenue']) }}
            </span>
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Total Campaigns</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_campaigns'] }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-bullhorn fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Active Campaigns</div>
                        <h3 class="fw-bold text-success mb-0 mt-1">{{ $stats['active_campaigns'] }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-circle-play fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Total Impressions</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ number_format($stats['total_impressions']) }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info">
                        <i class="fa-regular fa-eye fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Marketing Revenue</div>
                        <h3 class="fw-bold text-primary mb-0 mt-1">₹{{ number_format($stats['platform_revenue']) }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-coins fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm rounded-3 p-3 mb-4">
        <form action="{{ route('admin.promotions.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="seller_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Sellers</option>
                    @foreach($sellers as $s)
                        <option value="{{ $s->id }}" {{ $sellerFilter == $s->id ? 'selected' : '' }}>
                            {{ $s->store_name }} ({{ $s->user->name ?? 'Seller' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $typeFilter === 'all' ? 'selected' : '' }}>All Promotion Types</option>
                    <option value="Featured Listing" {{ $typeFilter === 'Featured Listing' ? 'selected' : '' }}>Featured Listing (₹1,000)</option>
                    <option value="Banner Promotion" {{ $typeFilter === 'Banner Promotion' ? 'selected' : '' }}>Banner Promotion (₹1,500)</option>
                    <option value="Discount Offer" {{ $typeFilter === 'Discount Offer' ? 'selected' : '' }}>Discount Offer (₹1,000)</option>
                    <option value="Social Media Kit" {{ $typeFilter === 'Social Media Kit' ? 'selected' : '' }}>Social Media Kit (₹2,000)</option>
                    <option value="Email Campaign" {{ $typeFilter === 'Email Campaign' ? 'selected' : '' }}>Email Campaign (₹2,500)</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="Active" {{ $statusFilter === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Paused" {{ $statusFilter === 'Paused' ? 'selected' : '' }}>Paused</option>
                    <option value="Completed" {{ $statusFilter === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">Filter</button>
                @if($sellerFilter || ($typeFilter && $typeFilter !== 'all') || ($statusFilter && $statusFilter !== 'all'))
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Promotions Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-3">Campaign & Seller</th>
                        <th>Type & Tier</th>
                        <th>Charge Collected</th>
                        <th>Duration</th>
                        <th>Impressions & Clicks</th>
                        <th>Sales Generated</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Moderation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions as $promo)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $promo->listing_thumbnail ?: 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?auto=format&fit=crop&w=60&q=80' }}" 
                                         class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $promo->listing_title }}</div>
                                        <div class="small text-muted">
                                            🏪 {{ $promo->seller->store_name ?? 'Seller' }} &bull; <span class="text-primary font-monospace">{{ $promo->promotion_code }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                    {{ $promo->promotion_type }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">₹{{ number_format($promo->charge_amount) }}</div>
                                <span class="badge bg-success-subtle text-success small" style="font-size: 0.65rem;">Platform Revenue</span>
                            </td>
                            <td>
                                <div class="small fw-medium">{{ $promo->duration_days }} Days</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ $promo->start_date->format('M d') }} - {{ $promo->end_date->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="small"><strong>{{ number_format($promo->views_count) }}</strong> views</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ number_format($promo->clicks_count) }} clicks</div>
                            </td>
                            <td>
                                <div class="fw-bold text-success">₹{{ number_format($promo->revenue_generated) }}</div>
                                <div class="text-muted small" style="font-size: 0.7rem;">{{ $promo->sales_count }} purchases</div>
                            </td>
                            <td>
                                @if($promo->status === 'Active')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">Active</span>
                                @elseif($promo->status === 'Paused')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill">Paused</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 rounded-pill">Completed</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.promotions.status', $promo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                        <option value="Active" {{ $promo->status === 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Paused" {{ $promo->status === 'Paused' ? 'selected' : '' }}>Paused</option>
                                        <option value="Completed" {{ $promo->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-4 text-muted small">No promotions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($promotions->hasPages())
            <div class="p-3 border-top bg-light">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

