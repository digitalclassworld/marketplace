@extends('admin.layouts.admin')

@section('title', 'Reports & Analytics Studio - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                Reports & Analytics Studio
            </h2>
            <p class="text-secondary small mb-0">Platform-wide sales analytics, order performance, category metrics, and growth indicators.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Date Filter Pills -->
            <div class="btn-group btn-group-sm bg-white p-1 rounded-pill shadow-xs border">
                <a href="{{ route('admin.reports.index', ['range' => '7days']) }}" class="btn rounded-pill px-3 py-1 fw-semibold {{ $range === '7days' ? 'btn-primary' : 'btn-light border-0 text-secondary' }}">7 Days</a>
                <a href="{{ route('admin.reports.index', ['range' => '30days']) }}" class="btn rounded-pill px-3 py-1 fw-semibold {{ $range === '30days' ? 'btn-primary' : 'btn-light border-0 text-secondary' }}">30 Days</a>
                <a href="{{ route('admin.reports.index', ['range' => 'this_year']) }}" class="btn rounded-pill px-3 py-1 fw-semibold {{ $range === 'this_year' ? 'btn-primary' : 'btn-light border-0 text-secondary' }}">This Year</a>
            </div>
            <a href="{{ route('admin.reports.export') }}" class="btn btn-outline-secondary btn-sm px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5 rounded-pill shadow-xs">
                <i class="fa-solid fa-file-csv text-success"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- 4 Key Financial Metrics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(0, 102, 255, 0.1); color: #0066ff; font-size: 1.25rem;">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Gross Sales (GMV)</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['gross_revenue'] }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">{{ $stats['total_orders'] }} orders completed</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 1.25rem;">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Platform Cut (15%)</div>
                        <h4 class="fw-bold text-success mb-0">{{ $stats['net_commission'] }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">Net platform revenue</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 1.25rem;">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Seller Share (85%)</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['seller_earnings'] }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">To {{ $stats['total_sellers'] }} sellers</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 1.25rem;">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Avg Order Value (AOV)</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['avg_order_value'] }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">Per successful checkout</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Sales Trend Chart / Visualizer -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">Monthly Revenue Performance</h5>
                <p class="text-muted small mb-0">Platform transaction volume across the last 6 months.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill">Past 6 Months</span>
        </div>

        <div class="row g-3 align-items-end pt-3">
            @php
                $maxRev = max(1, ...array_map(fn($m) => $m['revenue'], $monthlyTrends));
            @endphp
            @foreach($monthlyTrends as $trend)
                @php
                    $pct = max(8, min(100, round(($trend['revenue'] / $maxRev) * 100)));
                @endphp
                <div class="col text-center">
                    <div class="d-flex flex-column align-items-center justify-content-end" style="height: 180px;">
                        <span class="small fw-bold text-dark mb-1" style="font-size: 0.75rem;">₹{{ number_format($trend['revenue'], 0) }}</span>
                        <div class="w-100 rounded-3" style="height: {{ $pct }}%; background: linear-gradient(180deg, #0066ff 0%, #3b82f6 100%); max-width: 48px; min-height: 14px; transition: height 0.3s ease;"></div>
                    </div>
                    <div class="fw-semibold text-muted small mt-2" style="font-size: 0.75rem;">{{ $trend['month'] }}</div>
                    <span class="badge bg-light text-secondary rounded-pill" style="font-size: 0.65rem;">{{ $trend['orders'] }} orders</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 2 Column Breakdown: Category Distribution + Top Sellers -->
    <div class="row g-4 mb-4">
        <!-- 1. Category Revenue Share -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-1">Sales by Marketplace Category</h5>
                <p class="text-muted small mb-3">Breakdown of orders across courses, services, and digital products.</p>

                <div class="d-flex flex-column gap-3 pt-2">
                    @forelse($typeStats as $ts)
                        @php
                            $rev = (float)$ts->revenue;
                            $gross = (float)$stats['gross_revenue'];
                            $typePct = $gross > 0 ? round(($rev / $gross) * 100, 1) : 0;
                        @endphp
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-dark small">
                                    <i class="fa-solid fa-circle-dot text-primary me-1.5"></i> {{ ucfirst($ts->type) }}
                                </span>
                                <span class="fw-bold text-dark small">₹{{ number_format($rev, 2) }} ({{ $ts->count }} orders)</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $typePct }}%;" aria-valuenow="{{ $typePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-chart-pie fs-3 text-secondary opacity-50 mb-2"></i>
                            <p class="small mb-0">No order category distribution data available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 2. Top Performing Sellers -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Top Performing Partners</h5>
                        <p class="text-muted small mb-0">Sellers & institutes leading in student enrollments.</p>
                    </div>
                    <a href="{{ route('admin.sellers.index') }}" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-semibold">View All &rarr;</a>
                </div>

                <div class="list-group list-group-flush">
                    @forelse($topSellers as $seller)
                        <div class="list-group-item px-0 py-2.5 border-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($seller->businessDetail?->business_name ?: ($seller->user?->name ?: 'S'), 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small mb-0">{{ $seller->businessDetail?->business_name ?: ($seller->user?->name ?: 'Seller #' . $seller->id) }}</div>
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ $seller->user?->email ?: 'N/A' }}</div>
                                </div>
                            </div>
                            <span class="badge bg-success-subtle text-success fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                Active Partner
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <p class="small mb-0">No seller performance metrics yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
