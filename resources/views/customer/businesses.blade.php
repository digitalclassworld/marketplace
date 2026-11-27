@extends('customer.layouts.customer')

@section('title', 'My Business Inquiries - Digital Class World')

@section('content')
<div class="py-4 bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1">My Business Inquiries</h3>
                <p class="text-muted small mb-0">Track your admission queries, prospectus requests, and messages to verified institutes &amp; businesses</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="{{ route('businesses') }}" class="btn btn-primary btn-sm fw-semibold rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-building-columns me-1"></i> Explore Businesses
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($inquiries->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-4 py-3">Institute / Business</th>
                                <th class="py-3">Subject / Interest</th>
                                <th class="py-3">Message</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Inquiry Date</th>
                                <th class="pe-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inquiries as $inq)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 1rem;">
                                                <i class="fa-solid fa-school"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $inq->business_name }}</div>
                                                <small class="text-muted"><i class="fa-solid fa-certificate text-primary me-1"></i> Verified Listing</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $inq->category }}</span>
                                    </td>
                                    <td>
                                        <div class="text-muted small" style="max-width: 280px;">{{ Str::limit($inq->message, 80) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">{{ $inq->status }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $inq->date }}</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('businesses') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            View Directory
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Promotion banner -->
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white d-flex flex-row align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle text-success p-3 fs-4">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Looking for coaching classes or colleges nearby?</h6>
                        <p class="text-muted small mb-0">Discover verified training institutes, computer centers, and play schools across India with free demo classes.</p>
                    </div>
                </div>
                <a href="{{ route('businesses') }}" class="btn btn-primary rounded-pill px-4 fw-semibold">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Explore More Businesses
                </a>
            </div>
        @else
            <!-- Clean Empty State with Explore Button -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 px-3 mb-4 bg-white">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 85px; height: 85px; background: #ecfdf5; color: #059669; font-size: 2.2rem; box-shadow: 0 8px 20px rgba(5, 150, 105, 0.12);">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark mb-2">No Business Inquiries Submitted Yet</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 0.92rem; line-height: 1.55;">
                    Connect directly with 10,000+ verified computer education centers, competitive exam coaching institutes, schools, colleges, and local service providers across India.
                </p>
                <div class="mb-4">
                    <a href="{{ route('businesses') }}" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #059669; border-color: #059669;">
                        <i class="fa-solid fa-building-columns me-2"></i> Explore Verified Businesses &amp; Institutes
                    </a>
                </div>

                <!-- Popular Directory Quick Categories -->
                <div class="pt-3 border-top mx-auto" style="max-width: 650px;">
                    <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Popular Business Categories</div>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('businesses', ['category' => 'Computer Institute']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-desktop text-primary me-1"></i> Computer Institutes
                        </a>
                        <a href="{{ route('businesses', ['category' => 'Coaching Institute']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-book-open-reader text-success me-1"></i> Coaching Centers
                        </a>
                        <a href="{{ route('businesses', ['category' => 'Training Institute']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-laptop-code text-info me-1"></i> Training Academies
                        </a>
                        <a href="{{ route('businesses', ['category' => 'Play School']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-shapes text-warning me-1"></i> Play Schools
                        </a>
                        <a href="{{ route('businesses', ['category' => 'College / University']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-graduation-cap text-danger me-1"></i> Colleges &amp; Universities
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
