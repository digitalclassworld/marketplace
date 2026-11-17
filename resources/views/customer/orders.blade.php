@extends('layouts.app')

@section('title', 'My Orders - Digital Class World')

@section('content')
<div class="py-4 bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container">
        
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1">My Orders & Purchases</h3>
                <p class="text-muted small mb-0">Track your courses, services, and product orders in real-time</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.profile') }}" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                    <i class="fa-regular fa-user me-1"></i> My Account
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm fw-semibold rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-4 py-3">Order Details</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Item</th>
                                <th class="py-3">Amount</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Placed Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $ord)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold font-monospace text-primary">{{ $ord->order_number }}</div>
                                        <small class="text-muted">{{ $ord->customer_email }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $typeBadge = match(strtolower($ord->order_type)) {
                                                'service' => 'bg-success-subtle text-success',
                                                'product' => 'bg-danger-subtle text-danger',
                                                default   => 'bg-primary-subtle text-primary',
                                            };
                                        @endphp
                                        <span class="badge {{ $typeBadge }} fw-semibold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">
                                            {{ ucfirst($ord->order_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2.5">
                                            @if($ord->item_thumbnail)
                                                <img src="{{ $ord->item_thumbnail }}" alt="{{ $ord->item_title }}" class="rounded-2 border" style="width: 44px; height: 44px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 280px;" title="{{ $ord->item_title }}">
                                                    {{ $ord->item_title }}
                                                </div>
                                                <small class="text-muted">{{ $ord->item_subtext }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-dark">₹{{ number_format($ord->amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $statusBadge = match(strtolower($ord->status)) {
                                                'confirmed', 'completed' => 'bg-success text-white',
                                                'in_progress', 'processing' => 'bg-info text-dark',
                                                'cancelled' => 'bg-danger text-white',
                                                default => 'bg-secondary text-white',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusBadge }} px-2 py-1 rounded-pill" style="font-size: 0.7rem;">
                                            {{ ucfirst($ord->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $ord->placed_at ? $ord->placed_at->format('M d, Y h:i A') : $ord->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-3 text-muted" style="width: 64px; height: 64px;">
                    <i class="fa-solid fa-bag-shopping fs-2 text-primary opacity-50"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">No Orders Found</h5>
                <p class="text-muted small mb-4" style="max-width: 320px; margin: 0 auto;">
                    You haven't placed any orders with this customer account yet. Explore our courses, services, and digital products!
                </p>
                <div>
                    <a href="{{ route('courses') }}" class="btn btn-primary btn-sm px-4 py-2 rounded-pill fw-semibold me-2">
                        Browse Courses
                    </a>
                    <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-sm px-4 py-2 rounded-pill fw-semibold">
                        Browse Services
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

