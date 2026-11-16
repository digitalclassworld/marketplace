@extends('admin.layouts.admin')

@section('title', 'Payments & Transactions - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                Payments & Wallet Ledger
            </h2>
            <p class="text-secondary small mb-0">Platform transaction flow, online checkout collections, and platform commission ledger.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.financial.payouts') }}" class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5 rounded-pill shadow-xs">
                <i class="fa-solid fa-wallet"></i>
                <span>Seller Payouts</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5 rounded-pill shadow-sm" style="background-color: #0066ff;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Orders View</span>
            </a>
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Gross Volume -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 1.2rem;">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Gross Revenue</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['gross_volume'] }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">All valid transactions</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Platform Commission -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(0, 102, 255, 0.1); color: #0066ff; font-size: 1.2rem;">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Platform Commission (15%)</div>
                        <h4 class="fw-bold text-primary mb-0">{{ $stats['platform_commission'] }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">Digital Class fee</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Seller Net Share -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 1.2rem;">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Seller Net Share (85%)</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['seller_payouts'] }}</h4>
                        <small class="text-warning-emphasis fw-semibold" style="font-size: 0.72rem;">Disbursable to providers</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Total Transactions -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(99, 102, 241, 0.1); color: #6366f1; font-size: 1.2rem;">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Payments</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['total_transactions']) }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">Checkout logs</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Ledger Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light flex-wrap gap-2">
            <h6 class="fw-bold text-dark mb-0 fs-7">Real-time Platform Payments Flow</h6>
            <span class="badge bg-white text-secondary border small">Live Stream</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light small text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-3 py-3">Order / Txn ID</th>
                        <th>Customer</th>
                        <th>Seller / Provider</th>
                        <th>Gross Collected</th>
                        <th>Platform Cut (15%)</th>
                        <th>Seller Net (85%)</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th class="pe-3">Date</th>
                    </tr>
                </thead>
                <tbody class="small" style="font-size: 0.8125rem;">
                    @forelse($payments as $p)
                        @php
                            $gross = (float) $p->amount;
                            $cut = $gross * 0.15;
                            $net = $gross * 0.85;

                            $storeName = $p->seller?->businessDetail?->business_name ?: ($p->seller?->user?->name ?: 'Digital Class Store');
                        @endphp
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="fw-bold text-dark fs-7">{{ $p->order_number }}</div>
                                <span class="badge bg-light text-secondary border fs-8">{{ $p->order_type }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-7">{{ $p->customer_name }}</div>
                                <div class="text-muted fs-8">{{ $p->customer_email }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark fs-7">{{ $storeName }}</div>
                                <div class="text-muted fs-8">Seller ID: {{ $p->seller_id }}</div>
                            </td>
                            <td>
                                <strong class="text-dark fs-7">₹{{ number_format($gross, 2) }}</strong>
                            </td>
                            <td>
                                <span class="text-primary fw-semibold fs-7">+₹{{ number_format($cut, 2) }}</span>
                            </td>
                            <td>
                                <span class="text-success fw-semibold fs-7">₹{{ number_format($net, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-credit-card me-1 text-primary"></i> Online UPI / PG</span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Completed</span>
                            </td>
                            <td class="pe-3">
                                <div class="text-dark fs-7">{{ $p->placed_at ? $p->placed_at->format('d M Y') : ($p->created_at ? $p->created_at->format('d M Y') : 'Recent') }}</div>
                                <div class="text-muted fs-8">{{ $p->placed_at ? $p->placed_at->format('h:i A') : ($p->created_at ? $p->created_at->format('h:i A') : '') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-receipt fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <h6 class="fw-bold text-dark">No payment records found</h6>
                                <p class="small text-muted mb-0">Transactions will automatically log here as customers checkout on the marketplace.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                <span class="small text-muted">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} transactions</span>
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>
@endsection
