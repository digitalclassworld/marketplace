@extends('admin.layouts.admin')

@section('title', 'Seller Payouts & Commission - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                Seller Payouts & Commission
            </h2>
            <p class="text-secondary small mb-0">Disbursement management, provider settlements, and automatic commission distribution.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.financial.payments') }}" class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5 rounded-pill shadow-xs">
                <i class="fa-solid fa-receipt"></i>
                <span>Payments Ledger</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5 rounded-pill shadow-sm" style="background-color: #0066ff;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Orders Overview</span>
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

    <!-- 3 Summary KPI Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Disbursable Payout Due -->
        <div class="col-xl-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 1.2rem;">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Payout Due (85% Net)</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['total_pending'] }}</h4>
                        <small class="text-warning-emphasis fw-semibold" style="font-size: 0.72rem;">Pending settlement to sellers</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Active Accounts with Pending Balances -->
        <div class="col-xl-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(0, 102, 255, 0.1); color: #0066ff; font-size: 1.2rem;">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Sellers with Payable Balances</div>
                        <h4 class="fw-bold text-primary mb-0">{{ $stats['active_payouts'] }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">Out of {{ $stats['sellers_count'] }} registered sellers</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Standard Settlement Model -->
        <div class="col-xl-4 col-sm-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 1.2rem;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Platform Fee Structure</div>
                        <h5 class="fw-bold text-dark mb-0">15% Platform / 85% Seller</h5>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">Automated commission split</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payouts Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light flex-wrap gap-2">
            <h6 class="fw-bold text-dark mb-0 fs-7">Provider Accounts Payout Ledger</h6>
            <span class="badge bg-white text-secondary border small">{{ count($payoutRows) }} Sellers</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light small text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-3 py-3">Seller Store</th>
                        <th>Owner & Contact</th>
                        <th>Orders Count</th>
                        <th>Gross Sales</th>
                        <th>Platform Cut (15%)</th>
                        <th>Net Payable (85%)</th>
                        <th>Payout Status</th>
                        <th class="pe-3 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="small" style="font-size: 0.8125rem;">
                    @forelse($payoutRows as $r)
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="fw-bold text-dark fs-7">{{ $r['store_name'] }}</div>
                                <div class="text-muted fs-8">Code: {{ $r['seller_code'] }} &bull; {{ $r['account_type'] }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark fs-7">{{ $r['owner_name'] }}</div>
                                <div class="text-muted fs-8">{{ $r['owner_email'] }} &bull; {{ $r['owner_phone'] }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $r['total_orders'] }} Orders</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-7">{{ $r['gross_sales'] }}</div>
                            </td>
                            <td>
                                <span class="text-primary fw-semibold fs-7">{{ $r['commission'] }}</span>
                            </td>
                            <td>
                                <strong class="text-success fs-7">{{ $r['net_payable'] }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $r['status_badge'] }}-subtle text-{{ $r['status_badge'] }} px-2.5 py-1 rounded-pill fw-semibold">{{ $r['status'] }}</span>
                            </td>
                            <td class="pe-3 text-end">
                                @if($r['raw_payable'] > 0)
                                    <form action="{{ route('admin.financial.payouts.release', $r['seller_id']) }}" method="POST" onsubmit="return confirm('Release payout of {{ $r['net_payable'] }} to {{ $r['store_name'] }}?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success px-3 fw-bold rounded-pill">
                                            <i class="fa-solid fa-check me-1"></i> Release Payout
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small fs-8"><i class="fa-solid fa-circle-check text-success me-1"></i> All Settled</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-wallet fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <h6 class="fw-bold text-dark">No seller payout records found</h6>
                                <p class="small text-muted mb-0">Sellers will populate here as store orders are generated and completed.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

