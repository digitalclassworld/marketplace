@extends('admin.layouts.admin')

@section('title', 'Business Directory Approvals - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="display-heading h3 text-dark mb-1">Business Directory Verification</h2>
            <p class="text-muted small mb-0">Review submitted institute profiles, agencies, and training company pages.</p>
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
        <a href="{{ route('admin.catalog.listings') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-light border' }}">
            All Listings ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.catalog.listings', ['status' => 'pending']) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-light border' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.catalog.listings', ['status' => 'approved']) }}" class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-light border' }}">
            Approved ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.catalog.listings', ['status' => 'rejected']) }}" class="btn btn-sm {{ $status === 'rejected' ? 'btn-danger' : 'btn-light border' }}">
            Rejected ({{ $counts['rejected'] }})
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                        <th class="ps-4 py-3">Business / Institute Name</th>
                        <th class="py-3">Seller Account</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Location & Pincode</th>
                        <th class="py-3">Status</th>
                        <th class="pe-4 py-3 text-end">Verification Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $listing)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $listing->business_name }}</div>
                                <small class="text-muted">{{ Str::limit($listing->tagline ?? 'No tagline', 45) }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $listing->seller?->businessDetail?->business_name ?? $listing->seller?->user?->name }}</div>
                                <span class="badge bg-light text-primary font-mono-code border">{{ $listing->seller?->seller_code }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $listing->category }}</span>
                            </td>
                            <td>
                                <div>{{ $listing->city ?? 'N/A' }}, {{ $listing->state ?? '' }}</div>
                                <small class="text-muted font-mono-code">{{ $listing->pincode }}</small>
                            </td>
                            <td>
                                @if($listing->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="fa-solid fa-circle-check me-1"></i> Approved
                                    </span>
                                @elseif($listing->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $listing->rejection_reason }}">
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
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewListingModal{{ $listing->id }}">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </button>

                                    @if($listing->status !== 'approved')
                                        <form action="{{ route('admin.catalog.listings.approve', $listing->id) }}" method="POST" onsubmit="return confirm('Approve this business listing in public directory?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($listing->status !== 'rejected')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $listing->id }}">
                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                        </button>
                                    @endif

                                    <!-- ================= VIEW BUSINESS LISTING DETAILS MODAL ================= -->
                                    <div class="modal fade" id="viewListingModal{{ $listing->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable text-start">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-bottom pb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-3 bg-warning bg-opacity-15 text-warning-emphasis p-2">
                                                            <i class="fa-solid fa-building fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="modal-title fw-bold text-dark mb-0">{{ $listing->business_name }}</h5>
                                                            <small class="text-muted">Submitted on {{ $listing->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <!-- Status & Category Grid -->
                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4 p-3 bg-light rounded-3">
                                                        <div>
                                                            <span class="text-muted small d-block">Status:</span>
                                                            @if($listing->status === 'approved')
                                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-circle-check me-1"></i> Live in Directory
                                                                </span>
                                                            @elseif($listing->status === 'rejected')
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
                                                            <span class="badge bg-white text-dark border">{{ $listing->category }}</span>
                                                        </div>
                                                        <div class="ms-md-auto text-md-end">
                                                            <span class="text-muted small d-block">Tagline:</span>
                                                            <span class="fw-semibold text-dark">{{ $listing->tagline ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Seller & Contact Info Grid -->
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-id-card text-warning me-2"></i>Account Information</h6>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Registered Seller:</span>
                                                                    <strong>{{ $listing->seller?->businessDetail?->business_name ?? 'N/A' }}</strong>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Seller Code:</span>
                                                                    <span class="font-mono-code text-primary fw-bold">{{ $listing->seller?->seller_code }}</span>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Account Owner:</span>
                                                                    <span>{{ $listing->seller?->user?->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="small">
                                                                    <span class="text-muted">User Email:</span>
                                                                    <span>{{ $listing->seller?->user?->email ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-address-book text-warning me-2"></i>Directory Contacts</h6>
                                                                <div class="small mb-1">
                                                                    <i class="fa-solid fa-phone text-muted me-1"></i>
                                                                    <span class="text-muted">Phone:</span>
                                                                    <strong>{{ $listing->phone ?? 'N/A' }}</strong>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <i class="fa-solid fa-envelope text-muted me-1"></i>
                                                                    <span class="text-muted">Official Email:</span>
                                                                    <span>{{ $listing->email ?? 'N/A' }}</span>
                                                                </div>
                                                                @if($listing->website)
                                                                    <div class="small">
                                                                        <i class="fa-solid fa-globe text-muted me-1"></i>
                                                                        <span class="text-muted">Website:</span>
                                                                        <a href="{{ $listing->website }}" target="_blank" class="text-decoration-none">{{ $listing->website }}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Physical Location -->
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-location-dot text-danger me-2"></i>Campus / Office Location</h6>
                                                        <div class="p-3 bg-light rounded-3 small">
                                                            <div>{{ $listing->address ?? 'Address not specified' }}</div>
                                                            <div class="text-muted mt-1">
                                                                {{ $listing->city ?? '' }}, {{ $listing->state ?? '' }} - <span class="font-mono-code fw-bold">{{ $listing->pincode ?? '' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- About / Description -->
                                                    @if($listing->description)
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold text-dark mb-2">About the Business / Institute</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3" style="white-space: pre-line;">
                                                                {{ $listing->description }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($listing->rejection_reason)
                                                        <div class="alert alert-danger border-0 rounded-3 mb-0 mt-3">
                                                            <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Current Rejection Reason:</strong>
                                                            <small>{{ $listing->rejection_reason }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-top bg-light">
                                                    <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Close</button>

                                                    @if($listing->status !== 'rejected')
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $listing->id }}">
                                                            <i class="fa-solid fa-xmark me-1"></i> Reject Listing
                                                        </button>
                                                    @endif

                                                    @if($listing->status !== 'approved')
                                                        <form action="{{ route('admin.catalog.listings.approve', $listing->id) }}" method="POST" onsubmit="return confirm('Approve this business directory listing?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-3">
                                                                <i class="fa-solid fa-check me-1"></i> Approve Listing
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $listing->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog text-start">
                                            <form action="{{ route('admin.catalog.listings.reject', $listing->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Business Listing</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="small text-muted mb-2">Provide a reason for rejection:</p>
                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="e.g. Address or institute registration details could not be validated."></textarea>
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-building fs-2 text-muted mb-2 d-block"></i>
                                No business listings found in this status.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($listings->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $listings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

