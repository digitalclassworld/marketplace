@extends('admin.layouts.admin')

@section('title', 'Product Approvals - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="display-heading h3 text-dark mb-1">Products & Tools Verification</h2>
            <p class="text-muted small mb-0">Review submitted digital assets, physical tools, stock, and pricing before publishing.</p>
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
        <a href="{{ route('admin.catalog.products') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-light border' }}">
            All Products ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.catalog.products', ['status' => 'pending']) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-light border' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.catalog.products', ['status' => 'approved']) }}" class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-light border' }}">
            Approved ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.catalog.products', ['status' => 'rejected']) }}" class="btn btn-sm {{ $status === 'rejected' ? 'btn-danger' : 'btn-light border' }}">
            Rejected ({{ $counts['rejected'] }})
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                        <th class="ps-4 py-3">Product Name</th>
                        <th class="py-3">Seller / Store</th>
                        <th class="py-3">Type & Category</th>
                        <th class="py-3">SKU & Stock</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Status</th>
                        <th class="pe-4 py-3 text-end">Verification Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $product->title }}</div>
                                <small class="text-muted">{{ Str::limit($product->description ?? 'No description', 45) }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $product->seller?->businessDetail?->business_name ?? $product->seller?->user?->name }}</div>
                                <span class="badge bg-light text-primary font-mono-code border">{{ $product->seller?->seller_code }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $product->product_type === 'Digital' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-dark' }} border">
                                    {{ $product->product_type }}
                                </span>
                                <span class="badge bg-light text-muted border">{{ $product->category }}</span>
                            </td>
                            <td>
                                <div class="font-mono-code small text-dark">{{ $product->sku }}</div>
                                <small class="text-muted">{{ $product->stock_quantity }} in stock</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark font-mono-code">₹{{ number_format($product->price, 2) }}</div>
                                @if($product->mrp && $product->mrp > $product->price)
                                    <small class="text-muted text-decoration-line-through font-mono-code">₹{{ number_format($product->mrp, 2) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($product->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="fa-solid fa-circle-check me-1"></i> Approved
                                    </span>
                                @elseif($product->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $product->rejection_reason }}">
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
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </button>

                                    @if($product->status !== 'approved')
                                        <form action="{{ route('admin.catalog.products.approve', $product->id) }}" method="POST" onsubmit="return confirm('Approve this product and display on the marketplace?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($product->status !== 'rejected')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $product->id }}">
                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                        </button>
                                    @endif

                                    <!-- ================= VIEW PRODUCT DETAILS MODAL ================= -->
                                    <div class="modal fade" id="viewProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable text-start">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-bottom pb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-3 bg-danger bg-opacity-10 text-danger p-2">
                                                            <i class="fa-solid fa-box-open fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="modal-title fw-bold text-dark mb-0">{{ $product->title }}</h5>
                                                            <small class="text-muted">Submitted on {{ $product->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <!-- Status & Category Grid -->
                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4 p-3 bg-light rounded-3">
                                                        <div>
                                                            <span class="text-muted small d-block">Status:</span>
                                                            @if($product->status === 'approved')
                                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-circle-check me-1"></i> Live in Catalog
                                                                </span>
                                                            @elseif($product->status === 'rejected')
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
                                                            <span class="text-muted small d-block">Type:</span>
                                                            <span class="badge {{ $product->product_type === 'Digital' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-dark' }} border">
                                                                {{ $product->product_type }} Product
                                                            </span>
                                                        </div>
                                                        <div class="ms-md-3">
                                                            <span class="text-muted small d-block">Category:</span>
                                                            <span class="badge bg-white text-dark border">{{ $product->category }}</span>
                                                        </div>
                                                        <div class="ms-md-auto text-md-end">
                                                            <span class="text-muted small d-block">SKU Code:</span>
                                                            <span class="font-mono-code fw-bold text-dark">{{ $product->sku }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Seller & Inventory Pricing Grid -->
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-store text-danger me-2"></i>Vendor Profile</h6>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Business / Store:</span>
                                                                    <strong>{{ $product->seller?->businessDetail?->business_name ?? 'N/A' }}</strong>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Seller Code:</span>
                                                                    <span class="font-mono-code text-primary fw-bold">{{ $product->seller?->seller_code }}</span>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Contact Person:</span>
                                                                    <span>{{ $product->seller?->user?->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="small">
                                                                    <span class="text-muted">Email:</span>
                                                                    <span>{{ $product->seller?->user?->email ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-indian-rupee-sign text-danger me-2"></i>Pricing & Inventory</h6>
                                                                <div class="d-flex align-items-baseline gap-2 mb-2">
                                                                    <span class="fs-4 fw-bold text-dark font-mono-code">₹{{ number_format($product->price, 2) }}</span>
                                                                    @if($product->mrp && $product->mrp > $product->price)
                                                                        <span class="text-muted text-decoration-line-through font-mono-code">₹{{ number_format($product->mrp, 2) }}</span>
                                                                        @php
                                                                            $discountPct = round((($product->mrp - $product->price) / $product->mrp) * 100);
                                                                        @endphp
                                                                        @if($discountPct > 0)
                                                                            <span class="badge bg-danger-subtle text-danger small">{{ $discountPct }}% OFF</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                <div class="small text-muted mb-1">
                                                                    <span class="fw-semibold text-dark">{{ $product->stock_quantity }}</span> units in stock
                                                                </div>
                                                                @if($product->weight_grams)
                                                                    <div class="small text-muted">
                                                                        Item Weight: {{ $product->weight_grams }} grams
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Product Specifications / Description -->
                                                    @if($product->description)
                                                        <div class="mb-4">
                                                            <h6 class="fw-bold text-dark mb-2">Product Description & Specs</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3" style="white-space: pre-line;">
                                                                {{ $product->description }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($product->shipping_details)
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-truck text-secondary me-2"></i>Shipping & Logistics Notes</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3">
                                                                {{ $product->shipping_details }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($product->rejection_reason)
                                                        <div class="alert alert-danger border-0 rounded-3 mb-0 mt-3">
                                                            <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Current Rejection Reason:</strong>
                                                            <small>{{ $product->rejection_reason }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-top bg-light">
                                                    <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Close</button>

                                                    @if($product->status !== 'rejected')
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $product->id }}">
                                                            <i class="fa-solid fa-xmark me-1"></i> Reject Product
                                                        </button>
                                                    @endif

                                                    @if($product->status !== 'approved')
                                                        <form action="{{ route('admin.catalog.products.approve', $product->id) }}" method="POST" onsubmit="return confirm('Approve this product and list in marketplace?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-3">
                                                                <i class="fa-solid fa-check me-1"></i> Approve Product
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog text-start">
                                            <form action="{{ route('admin.catalog.products.reject', $product->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="small text-muted mb-2">Provide a reason for rejection:</p>
                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="e.g. Incomplete product specifications or missing copyright permissions."></textarea>
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fs-2 text-muted mb-2 d-block"></i>
                                No products found in this status.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

