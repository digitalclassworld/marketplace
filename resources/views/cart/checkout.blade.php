@extends('layouts.app')

@section('title', 'Marketplace Checkout - Digital Class')

@push('styles')
<style>
    .checkout-page-container {
        max-width: 1140px;
        margin: 0 auto;
    }
    .checkout-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }
    .checkout-header-bar {
        background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
        border-radius: 16px 16px 0 0;
        padding: 1.25rem 1.75rem;
        color: #ffffff;
    }
    .payment-option-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .payment-option-card:hover {
        border-color: #0066ff;
        background: #f8fafc;
    }
    .payment-option-card.selected {
        border-color: #0066ff;
        background: #eff6ff;
    }
    .coupon-box-wrap {
        background: #faf5ff;
        border: 1.5px dashed #d8b4fe;
        border-radius: 12px;
    }
    .quick-coupon-pill {
        background: #f3e8ff;
        color: #7c3aed;
        border: 1px solid #e9d5ff;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .quick-coupon-pill:hover {
        background: #7c3aed;
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="bg-light py-4 min-vh-100">
    <div class="container checkout-page-container">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courses') }}" class="text-decoration-none text-muted">Courses</a></li>
                <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <!-- Checkout Card -->
        <div class="checkout-card overflow-hidden">
            
            <!-- Blue Header -->
            <div class="checkout-header-bar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                        <i class="fa-solid fa-shield-halved fs-5"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.25rem;">Instant Marketplace Checkout</h4>
                        <small class="text-white-50" style="font-size: 0.78rem;">100% Secure 256-Bit SSL Encrypted &bull; Instant Enrollment</small>
                    </div>
                </div>
                <div class="d-none d-md-flex align-items-center gap-2 text-white-50 small">
                    <i class="fa-solid fa-lock"></i>
                    <span>Verified Checkout</span>
                </div>
            </div>

            <!-- Main Checkout Body -->
            <div class="p-4 p-md-5">

                <!-- Success Screen (Hidden by default) -->
                <div id="checkoutPageSuccessScreen" class="py-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white shadow-lg p-3 mb-3" style="width: 76px; height: 76px;">
                        <i class="fa-solid fa-check fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Order Placed Successfully!</h3>
                    <p class="text-muted small mb-4" style="max-width: 440px; margin: 0 auto;">
                        Your purchase has been confirmed. You will receive an email confirmation with instant access details shortly.
                    </p>

                    <div class="bg-light border rounded-3 p-4 mb-4 mx-auto text-start shadow-xs" style="max-width: 460px;">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Order Reference Number:</span>
                            <strong class="text-primary font-monospace" id="pageSuccessOrderRef">#DC-00000</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Amount Paid:</span>
                            <strong class="text-dark fs-6" id="pageSuccessAmount">₹0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Customer Name:</span>
                            <span class="text-dark fw-semibold" id="pageSuccessCustomer"></span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Email Address:</span>
                            <span class="text-dark" id="pageSuccessEmail"></span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('customer.orders') }}" class="btn btn-primary px-4 py-2.5 rounded-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-graduation-cap me-1.5"></i> View My Orders & Courses
                        </a>
                        <a href="{{ route('courses') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-3 fw-semibold">
                            Explore More Courses
                        </a>
                    </div>
                </div>

                <!-- Empty Cart State Screen (Hidden if cart has items) -->
                <div id="checkoutPageEmptyScreen" class="py-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-4 mb-3 border">
                        <i class="fa-solid fa-cart-shopping fs-1 text-muted opacity-50"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Your cart is currently empty</h4>
                    <p class="text-muted small mb-4" style="max-width: 360px; margin: 0 auto;">
                        Select a course, product, or service to continue with your purchase.
                    </p>
                    <a href="{{ route('courses') }}" class="btn btn-primary px-4 py-2.5 rounded-3 fw-bold shadow-sm">
                        <i class="fa-solid fa-book-open me-1.5"></i> Browse Courses Catalog
                    </a>
                </div>

                <!-- Form Screen -->
                <div id="checkoutPageFormScreen">
                    <form id="pageCheckoutForm" onsubmit="handlePageCheckoutSubmit(event)">
                        <div class="row g-4 g-lg-5">

                            <!-- LEFT COLUMN: Customer Information & Payment Method -->
                            <div class="col-lg-7">
                                
                                <!-- Section 1: Customer Information -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                            <i class="fa-solid fa-user small"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-0 fs-6">Customer Information</h5>
                                        @if(Auth::check() && Auth::user()->isCustomer())
                                            <span class="badge bg-success-subtle text-success ms-auto fw-semibold" style="font-size: 0.68rem;">
                                                <i class="fa-solid fa-circle-check me-1"></i> Logged In as {{ Auth::user()->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted mb-1">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-3 py-2" id="pageCheckoutName" required placeholder="e.g. Vaibhavi Shah" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control rounded-3 py-2" id="pageCheckoutEmail" required placeholder="e.g. vaibhavi@gmail.com" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control rounded-3 py-2" id="pageCheckoutPhone" required placeholder="e.g. 9876543210" value="{{ Auth::check() ? (Auth::user()->phone ?? '') : '' }}">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-semibold text-muted mb-1">City</label>
                                            <input type="text" class="form-control rounded-3 py-2" id="pageCheckoutCity" placeholder="e.g. Ahmedabad" value="{{ Auth::check() ? (Auth::user()->city ?? 'Ahmedabad') : 'Ahmedabad' }}">
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label small fw-semibold text-muted mb-1">Address / Landmark</label>
                                            <input type="text" class="form-control rounded-3 py-2" id="pageCheckoutAddress" placeholder="e.g. Street / Area / Landmark" value="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Payment Method -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                            <i class="fa-solid fa-credit-card small"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-0 fs-6">Payment Method</h5>
                                    </div>

                                    <div class="d-flex flex-column gap-2.5">
                                        <label class="payment-option-card selected d-flex align-items-center gap-3" id="payOptionUpi">
                                            <input class="form-check-input mt-0" type="radio" name="pagePaymentMethod" value="UPI / QR Code / Net Banking" checked onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <strong class="text-dark small">UPI / QR Code / Net Banking</strong>
                                                    <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.65rem;">Recommended</span>
                                                </div>
                                                <small class="text-muted d-block" style="font-size: 0.72rem;">Instant online confirmation, invoice & access receipt</small>
                                            </div>
                                            <div class="d-flex align-items-center gap-1.5 opacity-75">
                                                <i class="fa-brands fa-google-pay fs-4 text-dark"></i>
                                                <i class="fa-solid fa-qrcode fs-5 text-dark"></i>
                                            </div>
                                        </label>

                                        <label class="payment-option-card d-flex align-items-center gap-3" id="payOptionCod">
                                            <input class="form-check-input mt-0" type="radio" name="pagePaymentMethod" value="Cash / Pay on Delivery" onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <strong class="text-dark small d-block">Cash / Pay on Delivery</strong>
                                                <small class="text-muted d-block" style="font-size: 0.72rem;">Pay directly upon confirmation / batch enrollment</small>
                                            </div>
                                            <i class="fa-solid fa-hand-holding-dollar fs-5 text-muted opacity-75"></i>
                                        </label>
                                    </div>
                                </div>

                                <!-- Trust Features -->
                                <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-around text-muted small text-center">
                                    <div>
                                        <i class="fa-solid fa-bolt text-warning d-block mb-1 fs-5"></i>
                                        <span style="font-size: 0.72rem;">Instant Access</span>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-lock text-success d-block mb-1 fs-5"></i>
                                        <span style="font-size: 0.72rem;">SSL Secure</span>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-shield-heart text-primary d-block mb-1 fs-5"></i>
                                        <span style="font-size: 0.72rem;">Satisfaction Guarantee</span>
                                    </div>
                                </div>

                            </div>

                            <!-- RIGHT COLUMN: Order Review & Coupon -->
                            <div class="col-lg-5">
                                <div class="bg-light p-4 rounded-4 border shadow-xs position-sticky" style="top: 100px;">
                                    
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                                <i class="fa-solid fa-receipt small"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-0 fs-6">Order Review</h5>
                                        </div>
                                        <span class="badge bg-white text-dark border fw-bold" id="pageOrderItemsCountBadge" style="font-size: 0.7rem;">0 Items</span>
                                    </div>

                                    <!-- Selected Items Preview Container -->
                                    <div id="pageCheckoutItemsList" class="d-flex flex-column gap-2 mb-3 overflow-y-auto" style="max-height: 220px;">
                                        <!-- Rendered dynamically -->
                                    </div>

                                    <!-- Coupon Code Box (Here in Order Review before Total Due) -->
                                    <div class="coupon-box-wrap p-3 mb-3">
                                        <div class="d-flex align-items-center justify-content-between mb-1.5">
                                            <small class="fw-bold text-dark d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                                <i class="fa-solid fa-tags text-primary"></i> Have a Coupon Code?
                                            </small>
                                            <span class="badge fw-semibold" style="font-size: 0.65rem; background: #f3e8ff; color: #7c3aed;">Save Extra</span>
                                        </div>

                                        <!-- Coupon Input Row -->
                                        <div class="input-group input-group-sm mb-1.5" id="pageCouponInputGroup">
                                            <input type="text" id="pageCouponInput" class="form-control text-uppercase fw-bold shadow-none" placeholder="Enter coupon code" style="font-size: 0.78rem; letter-spacing: 0.5px; border-color: #d8b4fe;">
                                            <button class="btn text-white fw-bold px-3 shadow-none" type="button" id="btnApplyPageCoupon" onclick="applyPageCouponAction()" style="background: #7c3aed; font-size: 0.75rem;">
                                                Apply
                                            </button>
                                        </div>

                                        <!-- Applied Coupon Banner -->
                                        <div id="pageAppliedCouponBanner" class="d-none align-items-center justify-content-between bg-white px-2.5 py-1.5 rounded-2 border border-success mb-1.5 shadow-xs">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-circle-check text-success fs-6"></i>
                                                <div>
                                                    <strong class="text-success text-uppercase" id="pageAppliedCouponCodeText" style="font-size: 0.78rem;"></strong>
                                                    <div class="text-muted" id="pageAppliedCouponDiscountText" style="font-size: 0.68rem;"></div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none fw-semibold" onclick="removePageCouponAction()" style="font-size: 0.72rem;">
                                                Remove
                                            </button>
                                        </div>

                                        <!-- Feedback Alert -->
                                        <div id="pageCouponFeedbackAlert" class="small mb-1 py-1 px-2 rounded-2" style="font-size: 0.72rem; display: none;"></div>

                                        <!-- Quick Available Offer Chips -->
                                        <div class="d-flex align-items-center gap-1.5 flex-wrap pt-1 border-top" style="border-color: #edd5ff !important;">
                                            <span class="text-muted" style="font-size: 0.68rem;">Available Offers:</span>
                                            <button type="button" class="quick-coupon-pill border-0" onclick="applyQuickPageCoupon('WELCOME10')">WELCOME10 (10% OFF)</button>
                                            <button type="button" class="quick-coupon-pill border-0" onclick="applyQuickPageCoupon('DIGITAL20')">DIGITAL20 (20% OFF)</button>
                                            <button type="button" class="quick-coupon-pill border-0" onclick="applyQuickPageCoupon('DIWALI50')">DIWALI50 (50% OFF)</button>
                                        </div>
                                    </div>

                                    <!-- Price Calculation Breakdown -->
                                    <div class="border-top pt-2.5 mb-3">
                                        <div class="d-flex justify-content-between text-muted small mb-1.5">
                                            <span>Subtotal</span>
                                            <strong class="text-dark" id="pageCheckoutSubtotal">₹0.00</strong>
                                        </div>

                                        <div class="d-flex justify-content-between text-success small mb-1.5 d-none" id="pageCheckoutDiscountRow">
                                            <span class="fw-semibold"><i class="fa-solid fa-tag me-1"></i> Coupon Discount (<span id="pageCheckoutDiscountCodeLabel"></span>)</span>
                                            <strong class="text-success" id="pageCheckoutDiscountAmountLabel">-₹0.00</strong>
                                        </div>

                                        <div class="d-flex justify-content-between text-muted small mb-2">
                                            <span>Platform Handling & Taxes</span>
                                            <span class="text-success fw-bold">FREE</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-baseline text-dark fw-bold border-top pt-2.5" style="font-size: 1.15rem;">
                                            <span>Total Due</span>
                                            <span class="text-primary fs-4" id="pageCheckoutTotalDue">₹0.00</span>
                                        </div>
                                    </div>

                                    <!-- Place Order Button -->
                                    <button type="submit" id="btnConfirmPlaceOrder" class="btn btn-primary w-100 fw-bold py-3 rounded-3 shadow d-flex align-items-center justify-content-center gap-2" style="font-size: 0.95rem;">
                                        <i class="fa-solid fa-circle-check fs-6"></i>
                                        <span>Confirm &amp; Place Order</span>
                                    </button>

                                    <div class="text-center mt-2.5">
                                        <small class="text-muted" style="font-size: 0.68rem;">By ordering you agree to Digital Class Terms of Service.</small>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let checkoutItems = [];
    let checkoutSubtotal = 0;
    let checkoutTotalDiscount = 0;
    let checkoutActiveCoupon = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadCheckoutPageData();
    });

    function handlePaymentChange(radio) {
        document.getElementById('payOptionUpi').classList.toggle('selected', radio.value.includes('UPI'));
        document.getElementById('payOptionCod').classList.toggle('selected', radio.value.includes('Cash'));
    }

    function loadCheckoutPageData() {
        // Read items from localStorage or session
        checkoutItems = getCartItems();

        if (!checkoutItems || !checkoutItems.length) {
            document.getElementById('checkoutPageFormScreen').style.display = 'none';
            document.getElementById('checkoutPageEmptyScreen').style.display = 'block';
            return;
        }

        document.getElementById('checkoutPageEmptyScreen').style.display = 'none';
        document.getElementById('checkoutPageFormScreen').style.display = 'block';

        // Check if any item already brought a coupon code
        checkoutItems.forEach(item => {
            if (item.coupon_code && !checkoutActiveCoupon) {
                checkoutActiveCoupon = item.coupon_code;
            }
        });

        renderCheckoutPageItems();

        // If coupon was active, auto-validate or populate
        if (checkoutActiveCoupon) {
            document.getElementById('pageCouponInput').value = checkoutActiveCoupon;
            applyPageCouponAction(true);
        }
    }

    function renderCheckoutPageItems() {
        const container = document.getElementById('pageCheckoutItemsList');
        const badge = document.getElementById('pageOrderItemsCountBadge');
        if (badge) badge.textContent = checkoutItems.length + (checkoutItems.length === 1 ? ' Item' : ' Items');

        checkoutSubtotal = 0;
        let html = '';

        checkoutItems.forEach(item => {
            const unitPrice = parseFloat(item.price) || 0;
            const originalPrice = parseFloat(item.original_price || item.price) || 0;
            const qty = parseInt(item.quantity) || 1;
            const itemTotal = unitPrice * qty;
            const originalTotal = originalPrice * qty;

            checkoutSubtotal += (item.original_price ? originalTotal : itemTotal);

            html += `
                <div class="d-flex align-items-center gap-2.5 bg-white p-2.5 rounded-3 border shadow-2xs">
                    <img src="${item.thumbnail}" alt="${item.title}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px; flex-shrink: 0;" class="border">
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class="text-dark small fw-bold text-truncate" title="${item.title}">${item.title}</div>
                        <div class="d-flex align-items-center gap-2 mt-0.5">
                            <span class="text-muted" style="font-size: 0.7rem;">${item.type || 'Course'} &bull; Qty: ${qty}</span>
                            ${item.coupon_code ? '<span class="badge bg-purple-subtle text-primary" style="font-size: 0.6rem; background: #f3e8ff; color: #7c3aed;"><i class="fa-solid fa-tag me-0.5"></i>' + item.coupon_code + '</span>' : ''}
                        </div>
                    </div>
                    <div class="text-end">
                        <strong class="text-dark small d-block">₹${itemTotal.toLocaleString('en-IN')}</strong>
                        ${originalPrice > unitPrice ? '<small class="text-muted text-decoration-line-through" style="font-size: 0.65rem;">₹' + originalTotal.toLocaleString('en-IN') + '</small>' : ''}
                    </div>
                </div>
            `;
        });

        if (container) container.innerHTML = html;
        updateTotalsDisplay();
    }

    function updateTotalsDisplay() {
        const subtotalEl = document.getElementById('pageCheckoutSubtotal');
        const discountRow = document.getElementById('pageCheckoutDiscountRow');
        const discountCodeLabel = document.getElementById('pageCheckoutDiscountCodeLabel');
        const discountAmountLabel = document.getElementById('pageCheckoutDiscountAmountLabel');
        const totalDueEl = document.getElementById('pageCheckoutTotalDue');

        if (subtotalEl) subtotalEl.textContent = '₹' + checkoutSubtotal.toLocaleString('en-IN', { minimumFractionDigits: 2 });

        if (discountRow) {
            if (checkoutTotalDiscount > 0) {
                discountRow.classList.remove('d-none');
                if (discountCodeLabel) discountCodeLabel.textContent = checkoutActiveCoupon || 'APPLIED';
                if (discountAmountLabel) discountAmountLabel.textContent = '-₹' + checkoutTotalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            } else {
                discountRow.classList.add('d-none');
            }
        }

        const finalDue = Math.max(0, checkoutSubtotal - checkoutTotalDiscount);
        if (totalDueEl) totalDueEl.textContent = '₹' + finalDue.toLocaleString('en-IN', { minimumFractionDigits: 2 });
    }

    function applyQuickPageCoupon(code) {
        const input = document.getElementById('pageCouponInput');
        if (input) {
            input.value = code;
            applyPageCouponAction();
        }
    }

    async function applyPageCouponAction(silent = false) {
        const input = document.getElementById('pageCouponInput');
        const btn = document.getElementById('btnApplyPageCoupon');
        const alertEl = document.getElementById('pageCouponFeedbackAlert');
        const code = (input ? input.value : '').trim().toUpperCase();

        if (!code) {
            if (!silent && alertEl) {
                alertEl.className = 'small mb-1 py-1 px-2 rounded-2 text-danger bg-danger-subtle';
                alertEl.textContent = 'Please enter a coupon code';
                alertEl.style.display = 'block';
            }
            return;
        }

        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        }

        try {
            const res = await fetch('{{ route("coupons.validate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    code: code,
                    total: checkoutSubtotal,
                    context: 'all'
                })
            });

            const data = await res.json();

            if (res.ok && data.success) {
                checkoutActiveCoupon = data.code;
                checkoutTotalDiscount = parseFloat(data.discount_amount) || 0;

                // Update UI state
                document.getElementById('pageCouponInputGroup').classList.add('d-none');
                const banner = document.getElementById('pageAppliedCouponBanner');
                banner.classList.remove('d-none');
                banner.classList.add('d-flex');
                document.getElementById('pageAppliedCouponCodeText').textContent = data.code;
                document.getElementById('pageAppliedCouponDiscountText').textContent = 'Saved ₹' + checkoutTotalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 });

                if (alertEl) {
                    alertEl.className = 'small mb-1 py-1 px-2 rounded-2 text-success bg-success-subtle';
                    alertEl.textContent = data.message || 'Coupon applied successfully!';
                    alertEl.style.display = 'block';
                }

                updateTotalsDisplay();
            } else {
                checkoutActiveCoupon = null;
                checkoutTotalDiscount = 0;
                updateTotalsDisplay();

                if (!silent && alertEl) {
                    alertEl.className = 'small mb-1 py-1 px-2 rounded-2 text-danger bg-danger-subtle';
                    alertEl.textContent = data.message || 'Invalid coupon code';
                    alertEl.style.display = 'block';
                }
            }
        } catch (e) {
            if (!silent && alertEl) {
                alertEl.className = 'small mb-1 py-1 px-2 rounded-2 text-danger bg-danger-subtle';
                alertEl.textContent = 'Unable to validate coupon code at this time.';
                alertEl.style.display = 'block';
            }
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'Apply';
            }
        }
    }

    function removePageCouponAction() {
        checkoutActiveCoupon = null;
        checkoutTotalDiscount = 0;

        document.getElementById('pageAppliedCouponBanner').classList.remove('d-flex');
        document.getElementById('pageAppliedCouponBanner').classList.add('d-none');
        document.getElementById('pageCouponInputGroup').classList.remove('d-none');
        document.getElementById('pageCouponInput').value = '';

        const alertEl = document.getElementById('pageCouponFeedbackAlert');
        if (alertEl) alertEl.style.display = 'none';

        updateTotalsDisplay();
    }

    async function handlePageCheckoutSubmit(e) {
        e.preventDefault();

        const btn = document.getElementById('btnConfirmPlaceOrder');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing Order...';
        }

        const name = document.getElementById('pageCheckoutName').value.trim();
        const email = document.getElementById('pageCheckoutEmail').value.trim();
        const phone = document.getElementById('pageCheckoutPhone').value.trim();
        const city = document.getElementById('pageCheckoutCity').value.trim();
        const address = document.getElementById('pageCheckoutAddress').value.trim();
        const paymentMethod = document.querySelector('input[name="pagePaymentMethod"]:checked')?.value || 'UPI / QR Code / Net Banking';

        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const payload = {
            _token: csrfToken,
            name: name,
            email: email,
            phone: phone,
            city: city,
            address: address,
            payment_method: paymentMethod,
            coupon_code: checkoutActiveCoupon,
            discount: checkoutTotalDiscount,
            items: checkoutItems
        };

        try {
            let res = await fetch('{{ route("cart.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            if (res.status === 419) {
                const refreshRes = await fetch('{{ route("refresh-csrf") }}');
                const refreshData = await refreshRes.json();
                if (refreshData && refreshData.token) {
                    csrfToken = refreshData.token;
                    payload._token = csrfToken;
                    res = await fetch('{{ route("cart.checkout") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    });
                }
            }

            const data = await res.json();

            if (res.ok && data.success) {
                // Clear cart from storage
                saveCartItems([]);

                // Show success view
                document.getElementById('checkoutPageFormScreen').style.display = 'none';
                document.getElementById('checkoutPageSuccessScreen').style.display = 'block';

                document.getElementById('pageSuccessOrderRef').textContent = data.order_number || '#DC-' + Math.floor(10000 + Math.random() * 90000);
                document.getElementById('pageSuccessAmount').textContent = '₹' + (data.total_amount ? (typeof data.total_amount === 'number' ? data.total_amount.toLocaleString('en-IN', {minimumFractionDigits: 2}) : data.total_amount) : Math.max(0, checkoutSubtotal - checkoutTotalDiscount).toLocaleString('en-IN', {minimumFractionDigits: 2}));
                document.getElementById('pageSuccessCustomer').textContent = name;
                document.getElementById('pageSuccessEmail').textContent = email;

                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                alert(data.message || 'Unable to place order. Please check your information and try again.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-circle-check fs-6"></i> <span>Confirm &amp; Place Order</span>';
                }
            }
        } catch (err) {
            console.error('Checkout error:', err);
            alert('A network error occurred while placing your order. Please check your connection and try again.');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-circle-check fs-6"></i> <span>Confirm &amp; Place Order</span>';
            }
        }
    }
</script>
@endpush

