@extends('seller.layouts.seller')

@section('title', 'My Services - Digital Class Seller')

@section('page-title')
    <div class="d-flex align-items-center gap-2">
        <h1 class="h4 mb-0 fw-bold text-dark">My Services</h1>
        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small">
            {{ $services->total() }} Services
        </span>
    </div>
@endsection

@section('header-actions')
    <a href="{{ route('seller.services.create') }}" class="btn btn-success btn-sm px-3 shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> Add New Service
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
                        <input type="text" class="form-control bg-light border-0" placeholder="Search services by gig title or skill tag..." id="serviceSearch">
                    </div>
                </div>
                <div class="col-md-7 d-flex justify-content-md-end gap-2">
                    <span class="badge bg-light text-muted border d-flex align-items-center px-3 py-2">
                        Status: All ({{ $services->total() }})
                    </span>
                    <a href="{{ route('seller.services.create') }}" class="btn btn-success btn-sm px-3">
                        <i class="fa-solid fa-plus me-1"></i> Add New Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Services List -->
    @if($services->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                            <th class="ps-4 py-3">Gig / Service Details</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Package & Price</th>
                            <th class="py-3">Delivery Time</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                            <i class="fa-solid fa-handshake-angle fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $service->title }}</div>
                                            <small class="text-muted">{{ Str::limit($service->short_description ?? 'Freelance service package', 55) }}</small>
                                            @if($service->tags)
                                                <div class="mt-1">
                                                    @foreach(explode(',', $service->tags) as $tag)
                                                        <span class="badge bg-light text-muted border me-1" style="font-size: 0.7rem;">{{ trim($tag) }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $service->category }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">₹{{ number_format($service->price, 2) }}</div>
                                    <small class="text-muted">{{ $service->package_name }} Tier</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $service->delivery_days }} Days Delivery
                                    </span>
                                </td>
                                <td>
                                    @if($service->status === 'approved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="fa-solid fa-circle-check me-1"></i> Live
                                        </span>
                                    @elseif($service->status === 'rejected')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $service->rejection_reason }}">
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
                                        {{ $service->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($services->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State matching Screenshot -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body py-5">
                <div class="rounded-circle bg-success bg-opacity-10 text-success mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-handshake-angle fs-1"></i>
                </div>
                <h4 class="display-heading text-dark mb-2">No services listed yet</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 480px;">
                    Offer your freelance skills, design services, website development, or consultation gigs to buyers across Digital Class.
                </p>
                <a href="{{ route('seller.services.create') }}" class="btn btn-success px-4 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Add Your First Service
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

