@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Activity Logs & Audit Trail</h2>
            <p class="text-muted small mb-0">Track real-time security events, administrator changes, customer actions, and financial transactions.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.activity.export') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Export Audit Log (CSV)
            </a>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise"></i> Refresh Stream
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase">Logged Events</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ number_format($stats['total_events']) }}</h3>
                        <span class="text-success small fw-medium"><i class="bi bi-shield-check"></i> System Audited</span>
                    </div>
                    <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase">Orders Today</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ number_format($stats['orders_today']) }}</h3>
                        <span class="text-primary small fw-medium"><i class="bi bi-cart-check"></i> Transaction Activity</span>
                    </div>
                    <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-bag-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase">New Users Today</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ number_format($stats['users_today']) }}</h3>
                        <span class="text-info small fw-medium"><i class="bi bi-person-check"></i> Platform Registrations</span>
                    </div>
                    <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase">Security Health</span>
                        <h3 class="fw-bold text-success mt-1 mb-0">Normal</h3>
                        <span class="text-muted small fw-medium"><i class="bi bi-circle-fill text-success" style="font-size: 8px;"></i> 0 Breaches Detected</span>
                    </div>
                    <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-shield-shaded fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.activity.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search event, actor, or description..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <select name="type" class="form-select bg-light border-0" onchange="this.form.submit()">
                        <option value="all" {{ $currentType == 'all' ? 'selected' : '' }}>All Audit Events</option>
                        <option value="orders" {{ $currentType == 'orders' ? 'selected' : '' }}>Orders & Payments</option>
                        <option value="users" {{ $currentType == 'users' ? 'selected' : '' }}>User Registrations & Auth</option>
                        <option value="reviews" {{ $currentType == 'reviews' ? 'selected' : '' }}>Reviews & Catalog</option>
                        <option value="system" {{ $currentType == 'system' ? 'selected' : '' }}>System & Security</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                @if($search || $currentType !== 'all')
                    <div class="col-12 col-md-2">
                        <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Activity Stream Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark">Live Audit Trail ({{ $activities->count() }} Events)</h5>
            <span class="badge bg-light text-muted border">Real-time Logging Active</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Event ID</th>
                        <th>Category</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Actor</th>
                        <th>IP Address</th>
                        <th class="pe-4 text-end">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $act)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-dark font-monospace border">{{ $act['id'] }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $act['color'] }} bg-opacity-10 text-{{ $act['color'] }} px-2 py-1 rounded-pill">
                                    <i class="bi {{ $act['icon'] }} me-1"></i> {{ $act['category'] }}
                                </span>
                            </td>
                            <td class="fw-semibold text-dark">{{ $act['action'] }}</td>
                            <td class="text-muted" style="max-width: 320px;">
                                <div class="text-truncate" title="{{ $act['description'] }}">
                                    {{ $act['description'] }}
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium text-dark d-block">{{ $act['actor'] }}</span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 11px;">{{ $act['actor_role'] }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="font-monospace small text-muted">{{ $act['ip_address'] }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="small text-dark fw-medium">
                                    {{ is_string($act['created_at']) ? \Illuminate\Support\Carbon::parse($act['created_at'])->diffForHumans() : $act['created_at']->diffForHumans() }}
                                </div>
                                <div class="text-muted" style="font-size: 11px;">
                                    {{ is_string($act['created_at']) ? \Illuminate\Support\Carbon::parse($act['created_at'])->format('d M, H:i') : $act['created_at']->format('d M, H:i') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox text-muted fs-1 d-block mb-2"></i>
                                <h6 class="fw-bold text-dark">No Activity Found</h6>
                                <p class="text-muted small mb-0">No events matched your selected filter criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
