@extends('admin.layouts.admin')

@section('title', 'Super Admin Overview - Digital Class Marketplace')

@section('styles')
<style>
    .admin-stat-card {
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        padding: 1.35rem 1.45rem;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .admin-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }
    .admin-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .admin-stat-card.highlight {
        border-color: #fde68a;
        background: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%);
    }

    .status-badge {
        font-size: 0.725rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .status-badge.pending {
        background-color: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .status-badge.active {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .status-badge.suspended {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .status-badge.rejected {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Top Welcome Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                Welcome Back, {{ Auth::user()->name }} 👋
            </h3>
            <p class="text-muted small mb-0">
                Here's what's happening on Digital Class Marketplace today. Monitor sellers, verify applications, and oversee platform health.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.sellers.pending') }}" class="btn btn-warning btn-sm fw-bold px-3 py-2 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Pending Approvals ({{ $stats['pending_sellers'] }})</span>
            </a>
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-primary btn-sm fw-semibold px-3 py-2 d-flex align-items-center gap-2">
                <i class="fa-solid fa-store"></i>
                <span>All Sellers</span>
            </a>
        </div>
    </div>

    <!-- ================= 8 DATABASE STATISTIC CARDS ================= -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Sellers -->
        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <small class="text-muted fw-bold">Total Sellers</small>
                    <div class="admin-stat-icon" style="background-color: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-store"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['total_sellers'] }}</h3>
                <small class="text-muted" style="font-size: 0.75rem;">Registered marketplace vendors</small>
            </div>
        </div>

        <!-- 2. Pending Approvals (Highlighted) -->
        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-card highlight">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <small class="text-warning-emphasis fw-bold">Pending Approvals</small>
                    <div class="admin-stat-icon" style="background-color: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['pending_sellers'] }}</h3>
                <small class="text-warning-emphasis fw-semibold" style="font-size: 0.75rem;">Requires Super Admin review</small>
            </div>
        </div>

        <!-- 3. Active Sellers -->
        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <small class="text-muted fw-bold">Active Sellers</small>
                    <div class="admin-stat-icon" style="background-color: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['active_sellers'] }}</h3>
                <small class="text-muted" style="font-size: 0.75rem;">Authorized to sell & publish</small>
            </div>
        </div>

        <!-- 4. Rejected / Suspended Sellers -->
        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <small class="text-muted fw-bold">Rejected / Suspended</small>
                    <div class="admin-stat-icon" style="background-color: #fef2f2; color: #ef4444;">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['rejected_and_suspended'] }}</h3>
                <small class="text-muted" style="font-size: 0.75rem;">
                    {{ $stats['suspended_sellers'] }} suspended, {{ $stats['rejected_sellers'] }} rejected
                </small>
            </div>
        </div>

        <!-- 5. Total Users -->
        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <small class="text-muted fw-bold">Total Platform Users</small>
                    <div class="admin-stat-icon" style="background-color: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['total_users'] }}</h3>
                <small class="text-muted" style="font-size: 0.75rem;">Sellers, admins & accounts</small>
            </div>
        </div>

        <!-- 6. Total Courses -->
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.catalog.courses') }}" class="text-decoration-none">
                <div class="admin-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">Online Courses</small>
                        <div class="admin-stat-icon" style="background-color: #eff6ff; color: #3b82f6;">
                            <i class="fa-solid fa-video"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['total_courses'] }}</h3>
                        @if($stats['pending_courses'] > 0)
                            <span class="badge bg-warning text-dark small">{{ $stats['pending_courses'] }} pending</span>
                        @endif
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Click to manage course approvals &rarr;</small>
                </div>
            </a>
        </div>

        <!-- 7. Total Services -->
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.catalog.services') }}" class="text-decoration-none">
                <div class="admin-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">Freelance Services</small>
                        <div class="admin-stat-icon" style="background-color: #f0fdf4; color: #16a34a;">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['total_services'] }}</h3>
                        @if($stats['pending_services'] > 0)
                            <span class="badge bg-warning text-dark small">{{ $stats['pending_services'] }} pending</span>
                        @endif
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Click to review service gigs &rarr;</small>
                </div>
            </a>
        </div>

        <!-- 8. Total Products -->
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.catalog.products') }}" class="text-decoration-none">
                <div class="admin-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">Marketplace Products</small>
                        <div class="admin-stat-icon" style="background-color: #fff7ed; color: #ea580c;">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['total_products'] }}</h3>
                        @if($stats['pending_products'] > 0)
                            <span class="badge bg-warning text-dark small">{{ $stats['pending_products'] }} pending</span>
                        @endif
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Click to review products & tools &rarr;</small>
                </div>
            </a>
        </div>

        <!-- 9. Business Listings -->
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.catalog.listings') }}" class="text-decoration-none">
                <div class="admin-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">Business Directory</small>
                        <div class="admin-stat-icon" style="background-color: #fef9c3; color: #ca8a04;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bold text-dark mb-1 font-monospace">{{ $stats['total_listings'] }}</h3>
                        @if($stats['pending_listings'] > 0)
                            <span class="badge bg-warning text-dark small">{{ $stats['pending_listings'] }} pending</span>
                        @endif
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Click to verify institute listings &rarr;</small>
                </div>
            </a>
        </div>
    </div>

    <!-- ================= PENDING APPROVALS QUEUE (CORE ACTION SECTION) ================= -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-user-clock text-warning me-2"></i>Sellers Awaiting Approval
                </h5>
                <small class="text-muted">Review business verification details and grant listing permissions</small>
            </div>
            <a href="{{ route('admin.sellers.pending') }}" class="btn btn-outline-primary btn-sm">
                View All Pending ({{ $stats['pending_sellers'] }}) &rarr;
            </a>
        </div>

        @if($pendingList->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-muted text-uppercase">
                        <tr>
                            <th>Seller / Store</th>
                            <th>Seller ID</th>
                            <th>Account Type</th>
                            <th>Category & City</th>
                            <th>Applied On</th>
                            <th class="text-end">Verification Actions</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($pendingList as $seller)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-light border text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                            {{ strtoupper(substr($seller->businessDetail?->business_name ?? $seller->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $seller->businessDetail?->business_name ?? $seller->user->name }}</div>
                                            <small class="text-muted">{{ $seller->user->email }} | {{ $seller->user->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary border font-monospace px-2 py-1">
                                        {{ $seller->seller_code }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $seller->account_type }}</span>
                                </td>
                                <td>
                                    <div>{{ $seller->businessDetail?->business_category ?? 'General' }}</div>
                                    <small class="text-muted">{{ $seller->businessDetail?->city ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $seller->registration_date ? $seller->registration_date->diffForHumans() : 'Recently' }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <!-- Review Details -->
                                        <a href="{{ route('admin.sellers.show', $seller->id) }}" class="btn btn-sm btn-outline-secondary" title="Review Details">
                                            <i class="fa-solid fa-eye me-1"></i> Review
                                        </a>

                                        <!-- Direct Approve -->
                                        <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve Seller {{ $seller->seller_code }}? This will grant full listing and selling permissions.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-3">
                                                <i class="fa-solid fa-check me-1"></i> Approve
                                            </button>
                                        </form>

                                        <!-- Direct Reject -->
                                        <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject Seller {{ $seller->seller_code }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 bg-light rounded-3 border">
                <i class="fa-solid fa-circle-check text-success fs-2 mb-2"></i>
                <h6 class="fw-bold text-dark mb-1">Queue Clear!</h6>
                <p class="text-muted small mb-0">No new seller accounts are currently pending review.</p>
            </div>
        @endif
    </div>

    <!-- ================= RECENT SELLERS OVERVIEW ================= -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-0">Recent Registered Sellers</h5>
                <small class="text-muted">Master log of all onboarded seller accounts in the database</small>
            </div>
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-link text-decoration-none small">
                Manage All Sellers &rarr;
            </a>
        </div>

        @if($recentSellers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light text-muted text-uppercase" style="font-size: 0.75rem;">
                        <tr>
                            <th>Store / Owner</th>
                            <th>Seller ID</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Verification</th>
                            <th>Joined On</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSellers as $s)
                            @php
                                $badgeClass = 'pending';
                                if ($s->isActive()) $badgeClass = 'active';
                                elseif ($s->isSuspended()) $badgeClass = 'suspended';
                                elseif ($s->isRejected()) $badgeClass = 'rejected';
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $s->businessDetail?->business_name ?? $s->user->name }}</div>
                                    <small class="text-muted">{{ $s->user->name }} &bull; {{ $s->user->email }}</small>
                                </td>
                                <td>
                                    <span class="font-monospace text-primary fw-semibold">{{ $s->seller_code }}</span>
                                </td>
                                <td>{{ $s->account_type }}</td>
                                <td>
                                    <span class="status-badge {{ $badgeClass }}">
                                        @if($s->isActive())
                                            <i class="fa-solid fa-circle-check"></i>
                                        @elseif($s->isSuspended())
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        @elseif($s->isRejected())
                                            <i class="fa-solid fa-ban"></i>
                                        @else
                                            <i class="fa-solid fa-clock"></i>
                                        @endif
                                        {{ $s->seller_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        {{ $s->verification_status }}
                                    </span>
                                </td>
                                <td>{{ $s->created_at ? $s->created_at->format('d M, Y') : 'N/A' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.sellers.show', $s->id) }}" class="btn btn-sm btn-light border">
                                        View Dossier &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 bg-light rounded-3">
                <p class="text-muted mb-0 small">No sellers registered yet in the database.</p>
            </div>
        @endif
    </div>
</div>
@endsection

