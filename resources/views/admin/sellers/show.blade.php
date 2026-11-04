@extends('admin.layouts.admin')

@section('title', 'Seller Review: ' . $seller->seller_code . ' - Super Admin')

@section('styles')
<style>
    .seller-header-card {
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 20px;
        padding: 2rem;
    }
    .seller-avatar-large {
        width: 72px;
        height: 72px;
        border-radius: 16px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.85rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .detail-card {
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        padding: 1.5rem;
        height: 100%;
    }

    .status-badge-lg {
        font-size: 0.85rem;
        font-weight: 700;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Top Breadcrumb & Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Sellers
            </a>
        </div>
        <div>
            <span class="badge bg-light text-primary border font-monospace fs-6 px-3 py-2">
                {{ $seller->seller_code }}
            </span>
        </div>
    </div>

    <!-- Seller Header Card (PDF Page 27 Reference) -->
    <div class="seller-header-card mb-4 shadow-sm">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-start gap-3">
                    <div class="seller-avatar-large">
                        {{ strtoupper(substr($seller->businessDetail?->business_name ?? $seller->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h4 class="fw-bold text-dark mb-0">
                                {{ $seller->businessDetail?->business_name ?? $seller->user->name }}
                            </h4>

                            @if($seller->isActive())
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="fa-solid fa-circle-check me-1"></i> Active Seller
                                </span>
                            @elseif($seller->isPendingApproval())
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Awaiting Approval
                                </span>
                            @elseif($seller->isSuspended())
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Suspended
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    <i class="fa-solid fa-ban me-1"></i> Rejected
                                </span>
                            @endif

                            <span class="badge bg-light text-dark border">
                                {{ $seller->account_type }}
                            </span>
                        </div>

                        <p class="text-muted small mb-2">
                            Owner: <strong>{{ $seller->user->name }}</strong> &bull; 
                            Email: <a href="mailto:{{ $seller->user->email }}" class="text-decoration-none">{{ $seller->user->email }}</a> &bull; 
                            Phone: {{ $seller->user->phone }}
                        </p>

                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            <div>
                                <i class="fa-solid fa-calendar me-1 text-secondary"></i>
                                Registered: {{ $seller->created_at ? $seller->created_at->format('d M, Y H:i A') : 'N/A' }}
                            </div>
                            <div>
                                <i class="fa-solid fa-location-dot me-1 text-secondary"></i>
                                {{ $seller->businessDetail?->city ?? 'Location N/A' }}{{ $seller->businessDetail?->state ? ', ' . $seller->businessDetail?->state : '' }}
                            </div>
                            @if($seller->businessDetail?->website)
                                <div>
                                    <i class="fa-solid fa-globe me-1 text-secondary"></i>
                                    <a href="{{ $seller->businessDetail->website }}" target="_blank" class="text-decoration-none">
                                        {{ $seller->businessDetail->website }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Controls -->
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                    @if($seller->isPendingApproval())
                        <!-- Approve Button -->
                        <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" onsubmit="return confirm('Approve this seller? This will immediately unlock their ability to create and publish listings.');">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm px-3 fw-bold w-100">
                                <i class="fa-solid fa-circle-check me-1"></i> Approve Seller
                            </button>
                        </form>

                        <!-- Reject Button -->
                        <button type="button" class="btn btn-outline-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fa-solid fa-ban me-1"></i> Reject Application
                        </button>
                    @elseif($seller->isActive())
                        <!-- Suspend Button -->
                        <button type="button" class="btn btn-warning btn-sm px-3 text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#suspendModal">
                            <i class="fa-solid fa-pause me-1"></i> Suspend Seller
                        </button>
                    @elseif($seller->isSuspended() || $seller->isRejected())
                        <!-- Reactivate Button -->
                        <form action="{{ route('admin.sellers.reactivate', $seller->id) }}" method="POST" onsubmit="return confirm('Reactivate this seller to Active status?');">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm px-3 fw-bold">
                                <i class="fa-solid fa-rotate-left me-1"></i> Reactivate to Active
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="row g-4">
        <!-- 1. Basic User Information -->
        <div class="col-md-6">
            <div class="detail-card shadow-sm">
                <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-user text-primary me-2"></i>Owner & User Account Details
                </h6>

                <div class="small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">User Account ID:</span>
                        <strong class="text-dark">#{{ $seller->user->id }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Full Name:</span>
                        <span class="fw-semibold text-dark">{{ $seller->user->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Login Email:</span>
                        <span class="text-dark">{{ $seller->user->email }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Mobile Number:</span>
                        <span class="text-dark">{{ $seller->user->phone }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Role:</span>
                        <span class="badge bg-light text-primary border">{{ $seller->user->role }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">User Joined:</span>
                        <span class="text-dark">{{ $seller->user->created_at ? $seller->user->created_at->format('d M, Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Business Details -->
        <div class="col-md-6">
            <div class="detail-card shadow-sm">
                <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-briefcase text-info me-2"></i>Business & Store Information
                </h6>

                <div class="small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Business / Store Name:</span>
                        <strong class="text-dark">{{ $seller->businessDetail?->business_name ?? 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Business Category:</span>
                        <span class="fw-semibold text-dark">{{ $seller->businessDetail?->business_category ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Business Email:</span>
                        <span class="text-dark">{{ $seller->businessDetail?->business_email ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Business Phone:</span>
                        <span class="text-dark">{{ $seller->businessDetail?->business_phone ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Address:</span>
                        <span class="text-dark text-end" style="max-width: 60%;">
                            {{ $seller->businessDetail?->address ?? 'N/A' }}, {{ $seller->businessDetail?->city ?? '' }}, {{ $seller->businessDetail?->state ?? '' }} - {{ $seller->businessDetail?->pincode ?? '' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Description:</span>
                        <span class="text-muted text-end" style="max-width: 60%;">
                            {{ $seller->businessDetail?->business_description ?? 'No description provided.' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Administrative Audit Trail -->
        <div class="col-md-6">
            <div class="detail-card shadow-sm">
                <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-shield-halved text-danger me-2"></i>Administrative Audit & History
                </h6>

                <div class="small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Current Status:</span>
                        <span class="fw-bold text-dark">{{ $seller->seller_status }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Verification Status:</span>
                        <span class="badge bg-light text-secondary border">{{ $seller->verification_status }}</span>
                    </div>

                    @if($seller->approved_at)
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Approved At:</span>
                            <span class="text-dark">{{ $seller->approved_at->format('d M, Y H:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Approved By:</span>
                            <span class="text-success fw-bold">{{ $seller->approvedBy?->name ?? 'Administrator' }}</span>
                        </div>
                    @endif

                    @if($seller->rejected_at)
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Rejected At:</span>
                            <span class="text-danger">{{ $seller->rejected_at->format('d M, Y H:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Rejected By:</span>
                            <span class="text-dark">{{ $seller->rejectedBy?->name ?? 'Administrator' }}</span>
                        </div>
                        <div class="py-2 border-bottom">
                            <span class="text-muted d-block mb-1">Rejection Reason:</span>
                            <div class="p-2 bg-light rounded text-danger small">
                                {{ $seller->rejection_reason }}
                            </div>
                        </div>
                    @endif

                    @if($seller->suspended_at)
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Suspended At:</span>
                            <span class="text-warning-emphasis">{{ $seller->suspended_at->format('d M, Y H:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Suspended By:</span>
                            <span class="text-dark">{{ $seller->suspendedBy?->name ?? 'Administrator' }}</span>
                        </div>
                        <div class="py-2">
                            <span class="text-muted d-block mb-1">Suspension Note:</span>
                            <div class="p-2 bg-light rounded text-dark small">
                                {{ $seller->rejection_reason }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 4. Selling & Listing Permissions Check -->
        <div class="col-md-6">
            <div class="detail-card shadow-sm">
                <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-lock text-warning me-2"></i>Platform Permissions Check
                </h6>

                <div class="small">
                    <div class="p-3 rounded-3 mb-3 {{ $seller->canSell() ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}">
                        <div class="fw-bold mb-1">
                            @if($seller->canSell())
                                <i class="fa-solid fa-circle-check me-1"></i> Selling Permissions: UNLOCKED
                            @else
                                <i class="fa-solid fa-ban me-1"></i> Selling Permissions: LOCKED
                            @endif
                        </div>
                        <small>
                            @if($seller->canSell())
                                Seller is Active. All listing creation, course uploads, product sales, and service listings are authorized.
                            @elseif($seller->isPendingApproval())
                                Awaiting Super Admin approval. Seller is prevented from creating or publishing listings.
                            @elseif($seller->isSuspended())
                                Seller is suspended. All publishing and selling operations are blocked.
                            @else
                                Seller application rejected. Access to selling portal is restricted.
                            @endif
                        </small>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Courses Upload Permission:</span>
                            <span class="badge {{ $seller->canSell() ? 'bg-success' : 'bg-secondary' }}">
                                {{ $seller->canSell() ? 'Allowed' : 'Blocked' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Services Listing Permission:</span>
                            <span class="badge {{ $seller->canSell() ? 'bg-success' : 'bg-secondary' }}">
                                {{ $seller->canSell() ? 'Allowed' : 'Blocked' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Products Publishing Permission:</span>
                            <span class="badge {{ $seller->canSell() ? 'bg-success' : 'bg-secondary' }}">
                                {{ $seller->canSell() ? 'Allowed' : 'Blocked' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span>Directory Listing Permission:</span>
                            <span class="badge {{ $seller->canSell() ? 'bg-success' : 'bg-secondary' }}">
                                {{ $seller->canSell() ? 'Allowed' : 'Blocked' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
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
                        Rejecting <strong>{{ $seller->businessDetail?->business_name ?? $seller->user->name }}</strong> (<code>{{ $seller->seller_code }}</code>) blocks their store registration.
                    </p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Reason for Rejection</label>
                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Provide audit reason for rejection..." required></textarea>
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
<div class="modal fade" id="suspendModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.sellers.suspend', $seller->id) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h6 class="modal-title fw-bold text-warning-emphasis">
                        <i class="fa-solid fa-pause me-1"></i> Suspend Seller Account
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Suspending this seller blocks all publishing functionality. Existing database records will be preserved.
                    </p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Reason for Suspension</label>
                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Compliance or policy violation reason..." required></textarea>
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
@endsection

