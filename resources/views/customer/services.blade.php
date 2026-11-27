@extends('customer.layouts.customer')

@section('title', 'My Services - Digital Class World')

@section('content')
<div class="py-4 bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1">My Hired Services</h3>
                <p class="text-muted small mb-0">Track your booked services, milestone deliverables, and agency partners</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="{{ route('services') }}" class="btn btn-primary btn-sm fw-semibold rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-compass me-1"></i> Explore More Services
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($services->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-4 py-3">Service Details</th>
                                <th class="py-3">Order #</th>
                                <th class="py-3">Amount</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Booked Date</th>
                                <th class="pe-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $svc)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($svc->item_thumbnail)
                                                <img src="{{ $svc->item_thumbnail }}" alt="{{ $svc->item_title }}" class="rounded-3 shadow-sm" style="width: 52px; height: 42px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 52px; height: 42px; font-size: 1.2rem;">
                                                    <i class="fa-solid fa-briefcase"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $svc->item_title }}</div>
                                                <small class="text-muted">{{ Str::limit($svc->item_subtext ?: 'Professional Verified Service', 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-monospace text-primary fw-bold">{{ $svc->order_number ?: ('#SRV-' . $svc->id) }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">&#8377;{{ number_format($svc->amount ?: 0) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $st = strtolower($svc->status);
                                            $badgeClass = match($st) {
                                                'completed', 'delivered' => 'bg-success-subtle text-success',
                                                'in_progress', 'processing' => 'bg-warning-subtle text-warning-emphasis',
                                                'confirmed' => 'bg-info-subtle text-info-emphasis',
                                                default => 'bg-secondary-subtle text-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-pill px-3 py-1">{{ ucfirst($svc->status ?: 'Active') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $svc->placed_at ? \Carbon\Carbon::parse($svc->placed_at)->format('M d, Y') : ($svc->created_at ? $svc->created_at->format('M d, Y') : 'Recent') }}</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            View Order
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Promotion banner to explore more -->
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white d-flex flex-row align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle text-primary p-3 fs-4">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Need help with an ongoing project?</h6>
                        <p class="text-muted small mb-0">Our dedicated project managers are available 24/7 to ensure timely delivery.</p>
                    </div>
                </div>
                <a href="{{ route('services') }}" class="btn btn-primary rounded-pill px-4 fw-semibold">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Hire Another Expert
                </a>
            </div>
        @else
            <!-- Clean Empty State with Explore Button -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 px-3 mb-4 bg-white">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 85px; height: 85px; background: #eff6ff; color: #0066ff; font-size: 2.2rem; box-shadow: 0 8px 20px rgba(0, 102, 255, 0.12);">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark mb-2">No Services Booked Yet</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 0.92rem; line-height: 1.55;">
                    Need a professional website, mobile application, marketing campaign, logo design, or accounting expert? Hire background-checked agencies and top freelancers with 100% money-back guarantee.
                </p>
                <div class="mb-4">
                    <a href="{{ route('services') }}" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm" style="font-size: 0.95rem;">
                        <i class="fa-solid fa-compass me-2"></i> Explore &amp; Hire Services
                    </a>
                </div>

                <!-- Popular Service Quick Categories -->
                <div class="pt-3 border-top mx-auto" style="max-width: 650px;">
                    <div class="text-muted small fw-semibold text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Popular Service Categories</div>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('services', ['category' => 'Website Development']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-code text-primary me-1"></i> Website Development
                        </a>
                        <a href="{{ route('services', ['category' => 'Mobile App Development']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-mobile-screen text-info me-1"></i> Mobile App
                        </a>
                        <a href="{{ route('services', ['category' => 'Digital Marketing']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-chart-line text-success me-1"></i> Digital Marketing
                        </a>
                        <a href="{{ route('services', ['category' => 'Logo & Branding']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-palette text-warning me-1"></i> Logo &amp; Branding
                        </a>
                        <a href="{{ route('services', ['category' => 'SEO Services']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fa-solid fa-magnifying-glass-chart text-danger me-1"></i> SEO Services
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
