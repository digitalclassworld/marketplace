@extends('admin.layouts.admin')

@section('title', 'Refunds & Disputes - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                Refunds & Disputes Management
            </h2>
            <p class="text-secondary small mb-0">Review customer refund claims, chargeback requests, and dispute resolutions.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.financial.payments') }}" class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5 rounded-pill shadow-xs">
                <i class="fa-solid fa-receipt"></i>
                <span>Payments Ledger</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5 rounded-pill shadow-sm" style="background-color: #0066ff;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>All Orders</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2.5 mb-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 4 Summary KPI Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Refunded -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 1.2rem;">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Refunded</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['total_refunded'] }}</h4>
                        <small class="text-secondary" style="font-size: 0.72rem;">{{ $stats['refund_count'] }} transactions processed</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Cancelled Orders -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 1.2rem;">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Cancelled Orders</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['cancelled_count'] }}</h4>
                        <small class="text-secondary" style="font-size: 0.72rem;">Buyer or seller cancelled</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Total Dispute Cases -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 1.2rem;">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Disputes</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['disputes_count'] }}</h4>
                        <small class="text-secondary" style="font-size: 0.72rem;">Claims & reversals</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Resolution Rate -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 1.2rem;">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Resolution Rate</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['resolution_rate'] }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">Within 24h SLA</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
        <form method="GET" action="{{ route('admin.financial.refunds') }}" class="row g-2 align-items-center">
            <div class="col-md-5 col-12">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search by Order #, Customer, or Item..." value="{{ $searchQuery }}">
                </div>
            </div>
            <div class="col-md-3 col-6">
                <select name="status" class="form-select form-select-sm bg-light border-0" onchange="this.form.submit()">
                    <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="refunded" {{ $statusFilter === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="disputes" {{ $statusFilter === 'disputes' ? 'selected' : '' }}>Disputes / Failed</option>
                </select>
            </div>
            <div class="col-md-4 col-6 text-end">
                <button type="submit" class="btn btn-sm btn-primary px-3 rounded-pill" style="background-color: #0066ff;">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.financial.refunds') }}" class="btn btn-sm btn-light border px-2.5 rounded-pill text-muted">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Refunds & Disputes Ledger Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                <thead class="bg-light text-muted small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-3 py-3">Order / Case</th>
                        <th class="py-3">Customer Details</th>
                        <th class="py-3">Store / Seller</th>
                        <th class="py-3">Amount</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Date</th>
                        <th class="pe-3 py-3 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($refunds as $order)
                        <tr>
                            <td class="ps-3 py-3">
                                <span class="fw-bold text-dark font-monospace">{{ $order->order_number }}</span>
                                <div class="text-muted" style="font-size: 0.72rem;">{{ $order->item_title ?: 'Marketplace Item' }}</div>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($order->customer_name ?: 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $order->customer_name ?: 'Customer' }}</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">{{ $order->customer_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="text-dark fw-medium">{{ $order->seller?->businessDetail?->business_name ?? ($order->seller?->user?->name ?? 'Direct Seller') }}</span>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-danger">₹{{ number_format((float)$order->amount, 2) }}</span>
                            </td>
                            <td class="py-3">
                                @if($order->status === 'refunded')
                                    <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-arrow-rotate-left me-1"></i> Refunded
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-warning-subtle text-warning px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-ban me-1"></i> Cancelled
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-muted" style="font-size: 0.78rem;">
                                {{ $order->placed_at ? $order->placed_at->format('d M Y, h:i A') : $order->created_at->format('d M Y') }}
                            </td>
                            <td class="pe-3 py-3 text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm" title="View Full Order">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    @if($order->status !== 'refunded')
                                        <form method="POST" action="{{ route('admin.financial.refunds.approve', $order->id) }}" class="d-inline" onsubmit="return confirm('Approve refund for Order {{ $order->order_number }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Mark as Refunded">
                                                <i class="fa-solid fa-check"></i> Refund
                                            </button>
                                        </form>
                                    @else
                                        <span class="btn btn-sm btn-light text-success disabled border-0">
                                            <i class="fa-solid fa-circle-check"></i> Settled
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-scale-balanced fs-2 text-secondary opacity-50 mb-2 d-block"></i>
                                <span class="fw-semibold">No refund claims or dispute tickets found</span>
                                <p class="small text-muted mb-0">Customer refund requests and dispute cases will automatically appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($refunds->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $refunds->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
