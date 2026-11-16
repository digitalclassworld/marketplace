@extends('admin.layouts.admin')

@section('title', 'Orders & Bookings Management - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                Orders & Bookings
            </h2>
            <p class="text-secondary small mb-0">Platform-wide real-time transactions, fulfillment tracker, and customer order management.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5 rounded-pill shadow-xs" data-bs-toggle="modal" data-bs-target="#simulateOrderModal">
                <i class="fa-solid fa-plus"></i>
                <span>Add / Test Order</span>
            </button>
            <a href="{{ route('admin.orders.export') }}" class="btn btn-primary btn-sm px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5 rounded-pill shadow-sm" style="background-color: #0066ff;">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span>Export CSV</span>
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
        <!-- 1. Total Orders -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(0, 102, 255, 0.1); color: #0066ff; font-size: 1.2rem;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Orders</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['total_orders']) }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;"><i class="fa-solid fa-arrow-trend-up me-0.5"></i> Live Real-time</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Gross Platform Volume -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 1.2rem;">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Gross Volume</div>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['total_gross'] }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">All confirmed purchases</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Pending / Active -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 1.2rem;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Active & Processing</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['pending_count']) }}</h4>
                        <small class="text-warning-emphasis fw-semibold" style="font-size: 0.72rem;">Pending fulfillment</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Completed -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(99, 102, 241, 0.1); color: #6366f1; font-size: 1.2rem;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Delivered / Completed</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($stats['completed_count']) }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">Fulfilled & Verified</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Orders Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        
        <!-- Category Tabs -->
        <div class="border-bottom px-3 pt-2 d-flex align-items-center gap-2 overflow-x-auto flex-nowrap" style="background: #f8fafc;">
            <a href="{{ route('admin.orders.index', ['tab' => 'all', 'status' => $statusFilter, 'type' => $typeFilter, 'search' => $searchQuery]) }}" class="text-decoration-none py-2.5 px-3 fw-bold small border-bottom border-2 {{ $currentTab === 'all' ? 'text-primary border-primary' : 'text-secondary border-transparent' }}" style="font-size: 0.825rem; white-space: nowrap;">
                All Orders <span class="badge bg-light text-secondary border ms-1">{{ $stats['count_all'] }}</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'courses', 'status' => $statusFilter, 'type' => $typeFilter, 'search' => $searchQuery]) }}" class="text-decoration-none py-2.5 px-3 fw-bold small border-bottom border-2 {{ $currentTab === 'courses' ? 'text-primary border-primary' : 'text-secondary border-transparent' }}" style="font-size: 0.825rem; white-space: nowrap;">
                <i class="fa-solid fa-graduation-cap me-1"></i> Courses <span class="badge bg-light text-secondary border ms-1">{{ $stats['count_courses'] }}</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'products', 'status' => $statusFilter, 'type' => $typeFilter, 'search' => $searchQuery]) }}" class="text-decoration-none py-2.5 px-3 fw-bold small border-bottom border-2 {{ $currentTab === 'products' ? 'text-primary border-primary' : 'text-secondary border-transparent' }}" style="font-size: 0.825rem; white-space: nowrap;">
                <i class="fa-solid fa-box-open me-1"></i> Products <span class="badge bg-light text-secondary border ms-1">{{ $stats['count_products'] }}</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'services', 'status' => $statusFilter, 'type' => $typeFilter, 'search' => $searchQuery]) }}" class="text-decoration-none py-2.5 px-3 fw-bold small border-bottom border-2 {{ $currentTab === 'services' ? 'text-primary border-primary' : 'text-secondary border-transparent' }}" style="font-size: 0.825rem; white-space: nowrap;">
                <i class="fa-solid fa-briefcase me-1"></i> Services <span class="badge bg-light text-secondary border ms-1">{{ $stats['count_services'] }}</span>
            </a>
            <a href="{{ route('admin.orders.index', ['tab' => 'business', 'status' => $statusFilter, 'type' => $typeFilter, 'search' => $searchQuery]) }}" class="text-decoration-none py-2.5 px-3 fw-bold small border-bottom border-2 {{ $currentTab === 'business' ? 'text-primary border-primary' : 'text-secondary border-transparent' }}" style="font-size: 0.825rem; white-space: nowrap;">
                <i class="fa-solid fa-building me-1"></i> Business <span class="badge bg-light text-secondary border ms-1">{{ $stats['count_business'] }}</span>
            </a>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="p-3 border-bottom bg-white">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-center">
                <input type="hidden" name="tab" value="{{ $currentTab }}">
                
                <div class="col-md-5 col-12">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ $searchQuery }}" class="form-control border-start-0 bg-light" placeholder="Search order #, customer, item title...">
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="confirmed" {{ $statusFilter === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $statusFilter === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $statusFilter === 'completed' ? 'selected' : '' }}>Completed / Delivered</option>
                        <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-2 col-6">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all" {{ $typeFilter === 'all' ? 'selected' : '' }}>All Types</option>
                        <option value="Course" {{ $typeFilter === 'Course' ? 'selected' : '' }}>Course</option>
                        <option value="Product" {{ $typeFilter === 'Product' ? 'selected' : '' }}>Product</option>
                        <option value="Service" {{ $typeFilter === 'Service' ? 'selected' : '' }}>Service</option>
                        <option value="Business" {{ $typeFilter === 'Business' ? 'selected' : '' }}>Business</option>
                    </select>
                </div>

                <div class="col-md-2 col-12 d-flex gap-1 justify-content-md-end">
                    <button type="submit" class="btn btn-sm btn-primary px-3 fw-bold">Filter</button>
                    @if(!empty($searchQuery) || $statusFilter !== 'all' || $typeFilter !== 'all')
                        <a href="{{ route('admin.orders.index', ['tab' => $currentTab]) }}" class="btn btn-sm btn-light border px-2.5" title="Reset Filters"><i class="fa-solid fa-rotate-left"></i></a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light small text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-3 py-3">Order Details</th>
                        <th>Customer</th>
                        <th>Item Ordered</th>
                        <th>Seller / Institute</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th class="pe-3 text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="small" style="font-size: 0.8125rem;">
                    @forelse($orders as $o)
                        @php
                            $statusBadgeClass = match(strtolower($o->status)) {
                                'completed', 'delivered', 'paid' => 'bg-success-subtle text-success',
                                'confirmed', 'processing', 'in_progress' => 'bg-primary-subtle text-primary',
                                'cancelled', 'failed', 'refunded' => 'bg-danger-subtle text-danger',
                                default => 'bg-warning-subtle text-warning-emphasis'
                            };

                            $typeColor = match(strtolower($o->order_type)) {
                                'course' => 'text-primary bg-primary-subtle',
                                'service' => 'text-success bg-success-subtle',
                                'product' => 'text-danger bg-danger-subtle',
                                default => 'text-secondary bg-secondary-subtle'
                            };

                            $sellerStore = $o->seller?->businessDetail?->business_name ?: ($o->seller?->user?->name ?: 'Digital Class Store');
                        @endphp
                        <tr>
                            <!-- Order Details -->
                            <td class="ps-3 py-3">
                                <div class="fw-bold text-dark fs-7">{{ $o->order_number }}</div>
                                <span class="badge {{ $typeColor }} fw-bold" style="font-size: 0.65rem;">{{ $o->order_type }}</span>
                            </td>

                            <!-- Customer -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $o->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($o->customer_name) . '&background=0066ff&color=fff' }}" alt="{{ $o->customer_name }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark fs-7">{{ $o->customer_name }}</div>
                                        <div class="text-muted fs-8">{{ $o->customer_email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Item Ordered -->
                            <td>
                                <div class="d-flex align-items-center gap-2" style="max-width: 260px;">
                                    <img src="{{ $o->item_thumbnail }}" alt="{{ $o->item_title }}" class="rounded-2 border" style="width: 36px; height: 36px; object-fit: cover; flex-shrink: 0;" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80'">
                                    <div class="text-truncate">
                                        <div class="fw-semibold text-dark text-truncate fs-7" title="{{ $o->item_title }}">{{ $o->item_title }}</div>
                                        <div class="text-muted fs-8">{{ $o->item_subtext ?: 'Standard Fulfillment' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Seller -->
                            <td>
                                <div class="fw-semibold text-dark fs-7">{{ $sellerStore }}</div>
                                <div class="text-muted fs-8">ID: {{ $o->seller?->seller_code ?: 'DC-SELL-' . $o->seller_id }}</div>
                            </td>

                            <!-- Amount -->
                            <td>
                                <div class="fw-bold text-dark fs-7">₹{{ number_format((float)$o->amount, 2) }}</div>
                                <span class="text-success fs-8 fw-semibold">Net Paid</span>
                            </td>

                            <!-- Status Badge -->
                            <td>
                                <span class="badge {{ $statusBadgeClass }} px-2.5 py-1 rounded-pill fw-semibold">{{ ucfirst($o->status) }}</span>
                            </td>

                            <!-- Date -->
                            <td>
                                <div class="text-dark fs-7">{{ $o->placed_at ? $o->placed_at->format('d M Y') : ($o->created_at ? $o->created_at->format('d M Y') : 'Recent') }}</div>
                                <div class="text-muted fs-8">{{ $o->placed_at ? $o->placed_at->format('h:i A') : ($o->created_at ? $o->created_at->format('h:i A') : '') }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="pe-3 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border py-1 px-2.5 small dropdown-toggle fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Status
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                                        <li class="dropdown-header small text-muted">Change Fulfillment Status</li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $o->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="dropdown-item py-1.5"><i class="fa-solid fa-circle-check text-primary me-2"></i> Mark Confirmed</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $o->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="dropdown-item py-1.5"><i class="fa-solid fa-spinner text-warning me-2"></i> Mark Processing</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $o->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item py-1.5"><i class="fa-solid fa-badge-check text-success me-2"></i> Mark Completed / Delivered</button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $o->id) }}" method="POST" onsubmit="return confirm('Cancel this order?');">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item py-1.5 text-danger"><i class="fa-solid fa-ban text-danger me-2"></i> Cancel Order</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-cart-shopping fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <h6 class="fw-bold text-dark">No orders found</h6>
                                <p class="small text-muted mb-3">No marketplace transactions match the current filter criteria.</p>
                                <button type="button" class="btn btn-sm btn-primary px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#simulateOrderModal">
                                    <i class="fa-solid fa-plus me-1"></i> Add / Test Order
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                <span class="small text-muted">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders</span>
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>

<!-- SIMULATE / ADD TEST ORDER MODAL -->
<div class="modal fade" id="simulateOrderModal" tabindex="-1" aria-labelledby="simulateOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-3 px-4">
                <h5 class="modal-title fw-bold fs-6" id="simulateOrderModalLabel">
                    <i class="fa-solid fa-cart-plus me-2"></i> Simulate Real Paid Order
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.simulate') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Order Type</label>
                        <select name="type" class="form-select form-select-sm" required>
                            <option value="Course" selected>Course / Training</option>
                            <option value="Product">Physical / Digital Product</option>
                            <option value="Service">Professional Service</option>
                            <option value="Business">Business Listing</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Item Title</label>
                        <input type="text" name="title" class="form-control form-control-sm" required value="Full Stack Web Development & AI Bootcamp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Order Amount (₹)</label>
                        <input type="number" step="0.01" name="amount" class="form-control form-control-sm" required value="1499.00">
                        <small class="text-muted" style="font-size: 0.72rem;">Sets the real transaction gross value for revenue and seller payouts.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
