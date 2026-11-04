@extends('admin.layouts.admin')

@section('title', 'Service Approvals - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="display-heading h3 text-dark mb-1">Freelance Services Verification</h2>
            <p class="text-muted small mb-0">Review submitted freelance gigs, packages, deliverables, and approve or reject.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
                <i class="fa-solid fa-clock me-1"></i> {{ $counts['pending'] }} Pending Review
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Status Filter Pills -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('admin.catalog.services') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-light border' }}">
            All Services ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.catalog.services', ['status' => 'pending']) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-light border' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.catalog.services', ['status' => 'approved']) }}" class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-light border' }}">
            Approved ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.catalog.services', ['status' => 'rejected']) }}" class="btn btn-sm {{ $status === 'rejected' ? 'btn-danger' : 'btn-light border' }}">
            Rejected ({{ $counts['rejected'] }})
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                        <th class="ps-4 py-3">Gig / Service</th>
                        <th class="py-3">Seller / Store</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Package & Price</th>
                        <th class="py-3">Delivery</th>
                        <th class="py-3">Status</th>
                        <th class="pe-4 py-3 text-end">Verification Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $service->title }}</div>
                                <small class="text-muted">{{ Str::limit($service->short_description ?? 'No pitch provided', 45) }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $service->seller?->businessDetail?->business_name ?? $service->seller?->user?->name }}</div>
                                <span class="badge bg-light text-primary font-mono-code border">{{ $service->seller?->seller_code }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $service->category }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark font-mono-code">₹{{ number_format($service->price, 2) }}</div>
                                <small class="text-muted">{{ $service->package_name }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $service->delivery_days }} Days
                                </span>
                            </td>
                            <td>
                                @if($service->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="fa-solid fa-circle-check me-1"></i> Approved
                                    </span>
                                @elseif($service->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $service->rejection_reason }}">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <!-- View Details Button -->
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewServiceModal{{ $service->id }}">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </button>

                                    @if($service->status !== 'approved')
                                        <form action="{{ route('admin.catalog.services.approve', $service->id) }}" method="POST" onsubmit="return confirm('Approve this freelance service gig?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($service->status !== 'rejected')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $service->id }}">
                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                        </button>
                                    @endif

                                    <!-- ================= VIEW SERVICE DETAILS MODAL ================= -->
                                    <div class="modal fade" id="viewServiceModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable text-start">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-bottom pb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-3 bg-success bg-opacity-10 text-success p-2">
                                                            <i class="fa-solid fa-handshake-angle fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="modal-title fw-bold text-dark mb-0">{{ $service->title }}</h5>
                                                            <small class="text-muted">Submitted on {{ $service->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <!-- Status & Category Grid -->
                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4 p-3 bg-light rounded-3">
                                                        <div>
                                                            <span class="text-muted small d-block">Status:</span>
                                                            @if($service->status === 'approved')
                                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-circle-check me-1"></i> Live in Marketplace
                                                                </span>
                                                            @elseif($service->status === 'rejected')
                                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                                                </span>
                                                            @else
                                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-clock me-1"></i> Pending Verification
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="ms-md-3">
                                                            <span class="text-muted small d-block">Category:</span>
                                                            <span class="badge bg-white text-dark border">{{ $service->category }}</span>
                                                        </div>
                                                        <div class="ms-md-3">
                                                            <span class="text-muted small d-block">Delivery Time:</span>
                                                            <span class="badge bg-white text-secondary border">
                                                                <i class="fa-regular fa-clock me-1"></i> {{ $service->delivery_days }} Days Delivery
                                                            </span>
                                                        </div>
                                                        <div class="ms-md-auto text-md-end">
                                                            <span class="text-muted small d-block">Package Tier:</span>
                                                            <span class="fw-semibold text-dark">{{ $service->package_name }} Package</span>
                                                        </div>
                                                    </div>

                                                    <!-- Seller & Package Price Grid -->
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-user text-success me-2"></i>Freelancer Profile</h6>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Agency / Name:</span>
                                                                    <strong>{{ $service->seller?->businessDetail?->business_name ?? 'N/A' }}</strong>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Seller Code:</span>
                                                                    <span class="font-mono-code text-primary fw-bold">{{ $service->seller?->seller_code }}</span>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Account Owner:</span>
                                                                    <span>{{ $service->seller?->user?->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="small">
                                                                    <span class="text-muted">Email:</span>
                                                                    <span>{{ $service->seller?->user?->email ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-indian-rupee-sign text-success me-2"></i>Gig Pricing</h6>
                                                                <div class="fs-4 fw-bold text-dark font-mono-code mb-2">
                                                                    ₹{{ number_format($service->price, 2) }}
                                                                </div>
                                                                @if($service->tags)
                                                                    <div class="small text-muted mb-1">Gig Tags:</div>
                                                                    <div>
                                                                        @foreach(explode(',', $service->tags) as $tag)
                                                                            <span class="badge bg-white text-muted border me-1">{{ trim($tag) }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- What's Included / Package Features -->
                                                    @if($service->package_features)
                                                        <div class="mb-4">
                                                            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-box-check text-success me-2"></i>What's Included in Package</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3" style="white-space: pre-line;">
                                                                {{ $service->package_features }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Buyer Requirements -->
                                                    @if($service->buyer_requirements)
                                                        <div class="mb-4">
                                                            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-clipboard-question text-primary me-2"></i>Buyer Requirements</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3" style="white-space: pre-line;">
                                                                {{ $service->buyer_requirements }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Full Description -->
                                                    @if($service->description)
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold text-dark mb-2">Detailed Gig Overview</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3" style="white-space: pre-line;">
                                                                {{ $service->description }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($service->rejection_reason)
                                                        <div class="alert alert-danger border-0 rounded-3 mb-0 mt-3">
                                                            <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Current Rejection Reason:</strong>
                                                            <small>{{ $service->rejection_reason }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-top bg-light">
                                                    <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Close</button>

                                                    @if($service->status !== 'rejected')
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $service->id }}">
                                                            <i class="fa-solid fa-xmark me-1"></i> Reject Gig
                                                        </button>
                                                    @endif

                                                    @if($service->status !== 'approved')
                                                        <form action="{{ route('admin.catalog.services.approve', $service->id) }}" method="POST" onsubmit="return confirm('Approve this service gig?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-3">
                                                                <i class="fa-solid fa-check me-1"></i> Approve Gig
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog text-start">
                                            <form action="{{ route('admin.catalog.services.reject', $service->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Service Gig</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="small text-muted mb-2">Provide a reason for rejection:</p>
                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="e.g. Terms violate service policies or deliverable description is unclear."></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">Confirm Rejection</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-handshake-angle fs-2 text-muted mb-2 d-block"></i>
                                No services found in this status.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($services->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $services->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

