@extends('admin.layouts.admin')

@section('title', ($isPendingTab ? 'Pending Seller Approvals' : 'Sellers Management') . ' - Super Admin')

@section('styles')
<style>
    .admin-stat-pill-card {
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        transition: all 0.2s ease;
    }
    .admin-stat-pill-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .nav-tabs-admin {
        border-bottom: 2px solid var(--admin-border);
        gap: 0.5rem;
    }
    .nav-tabs-admin .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.75rem 1.25rem;
        border-radius: 8px 8px 0 0;
        position: relative;
        text-decoration: none;
    }
    .nav-tabs-admin .nav-link:hover {
        color: var(--admin-primary);
        background-color: #f1f5f9;
    }
    .nav-tabs-admin .nav-link.active {
        color: var(--admin-primary);
        background-color: transparent;
        border-bottom: 3px solid var(--admin-primary);
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
    <!-- Page Header (PDF Page 23 Reference) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                {{ $isPendingTab ? 'Pending Seller Approvals' : 'Sellers Management' }}
            </h3>
            <p class="text-muted small mb-0">
                Manage all sellers, store applications, approval audits, verifications and status controls.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if($isPendingTab)
                <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-list me-1"></i> View All Sellers
                </a>
            @else
                <a href="{{ route('admin.sellers.pending') }}" class="btn btn-warning btn-sm text-dark fw-bold position-relative">
                    <i class="fa-solid fa-user-clock me-1"></i> Pending Approvals
                    @if($counts['pending'] > 0)
                        <span class="badge bg-danger rounded-pill ms-1">{{ $counts['pending'] }}</span>
                    @endif
                </a>
            @endif
        </div>
    </div>

    <!-- 4 Metric Cards (PDF Page 23) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-pill-card">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted fw-bold">Total Sellers</small>
                    <i class="fa-solid fa-users text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark mb-0 font-monospace">{{ $counts['all'] }}</h4>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-pill-card" style="border-left: 4px solid #10b981;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted fw-bold">Active Sellers</small>
                    <i class="fa-solid fa-circle-check text-success"></i>
                </div>
                <h4 class="fw-bold text-success mb-0 font-monospace">{{ $counts['active'] }}</h4>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-pill-card" style="border-left: 4px solid #f59e0b;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted fw-bold">Pending Approval</small>
                    <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                </div>
                <h4 class="fw-bold text-warning mb-0 font-monospace">{{ $counts['pending'] }}</h4>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="admin-stat-pill-card" style="border-left: 4px solid #ef4444;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted fw-bold">Suspended / Rejected</small>
                    <i class="fa-solid fa-ban text-danger"></i>
                </div>
                <h4 class="fw-bold text-danger mb-0 font-monospace">{{ $counts['suspended'] + $counts['rejected'] }}</h4>
            </div>
        </div>
    </div>

    <!-- Master Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <!-- Status Tabs Bar (PDF Page 23) -->
        <div class="px-4 pt-3 border-bottom bg-light">
            <nav class="nav nav-tabs-admin">
                <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ !$status && !$isPendingTab ? 'active' : '' }}">
                    All Sellers <span class="badge bg-secondary-subtle text-secondary rounded-pill ms-1">{{ $counts['all'] }}</span>
                </a>
                <a href="{{ route('admin.sellers.pending') }}" class="nav-link {{ $isPendingTab || $status === 'Pending' ? 'active text-warning-emphasis' : '' }}">
                    <i class="fa-solid fa-clock me-1 text-warning"></i> Pending Approvals 
                    <span class="badge bg-warning text-dark rounded-pill ms-1">{{ $counts['pending'] }}</span>
                </a>
                <a href="{{ route('admin.sellers.index', ['status' => 'Active']) }}" class="nav-link {{ $status === 'Active' ? 'active' : '' }}">
                    Active <span class="badge bg-success-subtle text-success rounded-pill ms-1">{{ $counts['active'] }}</span>
                </a>
                <a href="{{ route('admin.sellers.index', ['status' => 'Suspended']) }}" class="nav-link {{ $status === 'Suspended' ? 'active' : '' }}">
                    Suspended <span class="badge bg-danger-subtle text-danger rounded-pill ms-1">{{ $counts['suspended'] }}</span>
                </a>
                <a href="{{ route('admin.sellers.index', ['status' => 'Rejected']) }}" class="nav-link {{ $status === 'Rejected' ? 'active' : '' }}">
                    Rejected <span class="badge bg-light text-muted rounded-pill ms-1">{{ $counts['rejected'] }}</span>
                </a>
            </nav>
        </div>

        <!-- Search and Filters Form -->
        <div class="p-3 border-bottom bg-white">
            <form action="{{ $isPendingTab ? route('admin.sellers.pending') : route('admin.sellers.index') }}" method="GET" class="row g-2 align-items-center">
                @if(!$isPendingTab && $status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif

                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Search by name, email, phone, or Seller ID (DC-SELL-...)" value="{{ $search }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">All Account Types</option>
                        <option value="{{ \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL }}" {{ $accountType == \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL ? 'selected' : '' }}>Individual / Freelancer</option>
                        <option value="{{ \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE }}" {{ $accountType == \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE ? 'selected' : '' }}>Institute / Company</option>
                        <option value="{{ \App\Models\Seller::ACCOUNT_TYPE_AGENCY }}" {{ $accountType == \App\Models\Seller::ACCOUNT_TYPE_AGENCY ? 'selected' : '' }}>Agency</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="fa-solid fa-filter me-1"></i> Apply Filter
                    </button>
                    @if($search || $accountType || ($status && !$isPendingTab))
                        <a href="{{ $isPendingTab ? route('admin.sellers.pending') : route('admin.sellers.index') }}" class="btn btn-light btn-sm border">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Sellers Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light text-muted text-uppercase" style="font-size: 0.75rem;">
                    <tr>
                        <th>Seller / Business</th>
                        <th>Seller ID</th>
                        <th>Account Type</th>
                        <th>Category & City</th>
                        <th>Status</th>
                        <th>Verification</th>
                        <th>Joined On</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        @php
                            $badgeClass = 'pending';
                            if ($seller->isActive()) $badgeClass = 'active';
                            elseif ($seller->isSuspended()) $badgeClass = 'suspended';
                            elseif ($seller->isRejected()) $badgeClass = 'rejected';
                        @endphp
                        <tr>
                            <!-- Seller / Business Name & Avatar -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-light border text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                        {{ strtoupper(substr($seller->businessDetail?->business_name ?? $seller->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">
                                            {{ $seller->businessDetail?->business_name ?? $seller->user->name }}
                                        </div>
                                        <small class="text-muted d-block">
                                            Owner: {{ $seller->user->name }} &bull; {{ $seller->user->email }}
                                        </small>
                                        <small class="text-muted">{{ $seller->user->phone }}</small>
                                    </div>
                                </div>
                            </td>

                            <!-- Seller ID -->
                            <td>
                                <span class="badge bg-light text-primary border font-monospace px-2 py-1">
                                    {{ $seller->seller_code }}
                                </span>
                            </td>

                            <!-- Account Type -->
                            <td>
                                <span class="fw-semibold text-dark">{{ $seller->account_type }}</span>
                            </td>

                            <!-- Category & City -->
                            <td>
                                <div>{{ $seller->businessDetail?->business_category ?? 'General' }}</div>
                                <small class="text-muted">
                                    <i class="fa-solid fa-location-dot me-1"></i>{{ $seller->businessDetail?->city ?? 'N/A' }}
                                </small>
                            </td>

                            <!-- Status Badge -->
                            <td>
                                <span class="status-badge {{ $badgeClass }}">
                                    @if($seller->isActive())
                                        <i class="fa-solid fa-circle-check"></i>
                                    @elseif($seller->isSuspended())
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    @elseif($seller->isRejected())
                                        <i class="fa-solid fa-ban"></i>
                                    @else
                                        <i class="fa-solid fa-clock"></i>
                                    @endif
                                    {{ $seller->seller_status }}
                                </span>
                            </td>

                            <!-- Verification Status -->
                            <td>
                                <span class="badge bg-light text-secondary border">
                                    {{ $seller->verification_status }}
                                </span>
                            </td>

                            <!-- Joined On -->
                            <td>
                                <span class="text-muted">{{ $seller->created_at ? $seller->created_at->format('d M, Y') : 'N/A' }}</span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <!-- View Details -->
                                    <a href="{{ route('admin.sellers.show', $seller->id) }}" class="btn btn-sm btn-outline-secondary" title="View Full Seller Dossier">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    @if($seller->isPendingApproval())
                                        <!-- Quick Approve -->
                                        <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" onsubmit="return confirm('Approve Seller {{ $seller->seller_code }}? This unlocks selling and listing permissions.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-2" title="Approve Seller">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                        <!-- Quick Reject -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $seller->id }}" title="Reject Application">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @elseif($seller->isActive())
                                        <!-- Suspend Seller -->
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#suspendModal{{ $seller->id }}" title="Suspend Seller">
                                            <i class="fa-solid fa-pause"></i>
                                        </button>
                                    @elseif($seller->isSuspended() || $seller->isRejected())
                                        <!-- Reactivate -->
                                        <form action="{{ route('admin.sellers.reactivate', $seller->id) }}" method="POST" onsubmit="return confirm('Reactivate Seller {{ $seller->seller_code }} back to Active status?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Reactivate Seller">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade text-start" id="rejectModal{{ $seller->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-bottom">
                                                    <h6 class="modal-title fw-bold text-danger">
                                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Reject Seller Application
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="small text-muted mb-3">
                                                        Rejecting <strong>{{ $seller->businessDetail?->business_name ?? $seller->user->name }}</strong> (<code>{{ $seller->seller_code }}</code>) will block them from selling and publishing listings.
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Rejection Reason</label>
                                                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Explain reason for rejection..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top">
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger btn-sm px-3">Confirm Rejection</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Suspend Modal -->
                                <div class="modal fade text-start" id="suspendModal{{ $seller->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <form action="{{ route('admin.sellers.suspend', $seller->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-bottom">
                                                    <h6 class="modal-title fw-bold text-warning-emphasis">
                                                        <i class="fa-solid fa-pause me-1"></i> Suspend Active Seller
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="small text-muted mb-3">
                                                        Suspending <strong>{{ $seller->businessDetail?->business_name ?? $seller->user->name }}</strong> (<code>{{ $seller->seller_code }}</code>) blocks their store publishing. Existing data will be safely preserved.
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Suspension Note</label>
                                                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Reason for account suspension..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top">
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-warning btn-sm px-3">Confirm Suspension</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fs-2 mb-2 d-block"></i>
                                <h6>No sellers found matching the criteria.</h6>
                                <p class="small mb-0">Try clearing filters or search parameters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sellers->hasPages())
            <div class="p-3 border-top d-flex justify-content-end">
                {{ $sellers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

