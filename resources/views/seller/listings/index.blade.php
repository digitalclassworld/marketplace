@extends('seller.layouts.seller')

@section('title', 'Business Directory Listings - Digital Class Seller')

@section('page-title')
    <div class="d-flex align-items-center gap-2">
        <h1 class="h4 mb-0 fw-bold text-dark">Business Directory</h1>
        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1 small">
            {{ $listings->total() }} Listings
        </span>
    </div>
@endsection

@section('header-actions')
    <a href="{{ route('seller.listings.create') }}" class="btn btn-warning text-dark fw-semibold btn-sm px-3 shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> Add Business Listing
    </a>
@endsection

@section('content')
<div class="container-fluid px-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2 align-items-center justify-content-between">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Search business directory by name or city..." id="listingSearch">
                    </div>
                </div>
                <div class="col-md-7 d-flex justify-content-md-end gap-2">
                    <span class="badge bg-light text-muted border d-flex align-items-center px-3 py-2">
                        Status: All ({{ $listings->total() }})
                    </span>
                    <a href="{{ route('seller.listings.create') }}" class="btn btn-warning text-dark fw-semibold btn-sm px-3">
                        <i class="fa-solid fa-plus me-1"></i> Add Business Listing
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Listings List -->
    @if($listings->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                            <th class="ps-4 py-3">Business Profile</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Location</th>
                            <th class="py-3">Contact</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listings as $listing)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-warning bg-opacity-15 text-warning-emphasis d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                            <i class="fa-solid fa-building fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $listing->business_name }}</div>
                                            <small class="text-muted">{{ Str::limit($listing->tagline ?? 'Directory Listing', 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $listing->category }}</span>
                                </td>
                                <td>
                                    <div>{{ $listing->city ?? 'N/A' }}, {{ $listing->state ?? '' }}</div>
                                    <small class="text-muted font-mono-code">{{ $listing->pincode }}</small>
                                </td>
                                <td>
                                    <div class="small"><i class="fa-solid fa-phone text-muted me-1"></i> {{ $listing->phone ?? 'N/A' }}</div>
                                    @if($listing->email)
                                        <div class="small text-muted"><i class="fa-solid fa-envelope text-muted me-1"></i> {{ $listing->email }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($listing->status === 'approved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="fa-solid fa-circle-check me-1"></i> Listed
                                        </span>
                                    @elseif($listing->status === 'rejected')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $listing->rejection_reason }}">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="fa-solid fa-clock me-1"></i> Pending Approval
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <span class="text-muted small">
                                        {{ $listing->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($listings->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State matching Screenshot -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body py-5">
                <div class="rounded-circle bg-warning bg-opacity-15 text-warning-emphasis mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-building fs-1"></i>
                </div>
                <h4 class="display-heading text-dark mb-2">No business pages listed yet</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 480px;">
                    Promote your educational institute, software agency, or tutoring academy to thousands of daily students and clients.
                </p>
                <a href="{{ route('seller.listings.create') }}" class="btn btn-warning text-dark fw-semibold px-4 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Add Your Business Page
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

