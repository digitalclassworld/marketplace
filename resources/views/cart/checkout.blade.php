@extends('layouts.app')

@section('title', 'Marketplace Checkout - Digital Class')

@section('styles')
@push('styles')
<style>
    .checkout-page-container {
        max-width: 1180px;
        margin: 0 auto;
    }
    .checkout-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, 0.06);
        border: 1px solid #e2e8f0;
    }
    .checkout-header-bar {
        background: linear-gradient(135deg, #0066ff 0%, #0047b3 100%);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem 2rem;
        color: #ffffff;
    }
    .payment-option-card {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        background: #ffffff;
        position: relative;
    }
    .payment-option-card:hover {
        border-color: #3b82f6;
        background: #f8fafc;
        transform: translateY(-1px);
    }
    .payment-option-card.selected {
        border-color: #0066ff;
        background: #f0f7ff;
        box-shadow: 0 4px 14px rgba(0, 102, 255, 0.12);
    }
    .payment-option-card .form-check-input:checked {
        background-color: #0066ff;
        border-color: #0066ff;
    }
    .coupon-box-wrap {
        background: #faf5ff;
        border: 1.5px dashed #c084fc;
        border-radius: 14px;
    }
    .direct-coupon-card {
        border: 1.5px solid #e9d5ff;
        background: #ffffff;
        border-radius: 12px;
        padding: 0.75rem 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .direct-coupon-card:hover {
        border-color: #7c3aed;
        background: #faf5ff;
        transform: translateY(-1px);
    }
    .direct-coupon-card.applied {
        border-color: #10b981;
        background: #f0fdf4;
        box-shadow: 0 3px 10px rgba(16, 185, 129, 0.12);
    }
    .item-qty-btn {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.15s;
    }
    .item-qty-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .bank-details-box {
        background: #ffffff;
        border: 1.5px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-top: 0.75rem;
    }
</style>
@endpush
@endsection

@section('content')
<div class="bg-light py-4 min-vh-100">
    <div class="container checkout-page-container">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courses') }}" class="text-decoration-none text-muted">Courses</a></li>
                <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">Instant Checkout</li>
            </ol>
        </nav>

        <!-- Checkout Card -->
        <div class="checkout-card overflow-hidden">
            
            <!-- Blue Header -->
            <div class="checkout-header-bar d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow" style="width: 44px; height: 44px;">
                        <i class="fa-solid fa-shield-halved fs-5"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.35rem;">Instant Marketplace Checkout</h4>
                        <div class="text-white-50 d-flex align-items-center gap-2 mt-0.5" style="font-size: 0.8rem;">
                            <span><i class="fa-solid fa-lock me-1"></i> 256-Bit SSL Encrypted</span>
                            <span>&bull;</span>
                            <span><i class="fa-solid fa-bolt me-1"></i> Instant Batch & Course Access</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-none d-md-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1.5 rounded-pill text-white small">
                        <i class="fa-solid fa-circle-check text-success"></i>
                        <span>Verified Buyer Protection</span>
                    </div>
                </div>
            </div>

            <!-- Main Checkout Body -->
            <div class="p-4 p-lg-5">

                <!-- Success Screen (Shown after successful order placement) -->
                <div id="checkoutPageSuccessScreen" class="py-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white shadow-lg p-3 mb-3" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-check fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Order Placed Successfully!</h3>
                    <p class="text-muted small mb-4" style="max-width: 460px; margin: 0 auto;">
                        Thank you for your order! Your purchase has been confirmed. You will receive an email confirmation and instant enrollment details shortly.
                    </p>

                    <div class="bg-light border rounded-4 p-4 mb-4 mx-auto text-start shadow-xs" style="max-width: 480px;">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Order Reference Number:</span>
                            <strong class="text-primary font-monospace fs-6" id="pageSuccessOrderRef">#DC-00000</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Total Amount Paid:</span>
                            <strong class="text-dark fs-5" id="pageSuccessAmount">₹0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Payment Method:</span>
                            <span class="badge bg-primary-subtle text-primary fw-bold" id="pageSuccessPaymentMethod">Razorpay / UPI</span>
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

                <!-- Empty Cart State Screen (Shown if cart has 0 items) -->
                <div id="checkoutPageEmptyScreen" class="py-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-4 mb-3 border shadow-xs">
                        <i class="fa-solid fa-cart-shopping fs-1 text-primary opacity-75"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Your cart is currently empty</h4>
                    <p class="text-muted small mb-4" style="max-width: 380px; margin: 0 auto;">
                        You have not selected any courses, services, or products yet. Browse our verified marketplace catalog to get started.
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
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <i class="fa-solid fa-user small"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-0 fs-6">Customer Information</h5>
                                        @if(Auth::check() && Auth::user()->isCustomer())
                                            <span class="badge bg-success-subtle text-success ms-auto fw-semibold" style="font-size: 0.72rem;">
                                                <i class="fa-solid fa-circle-check me-1"></i> Logged In as {{ Auth::user()->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted mb-1">Full Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" class="form-control rounded-end-3 py-2 border-start-0 ps-0" id="pageCheckoutName" required placeholder="e.g. Vaibhavi Shah" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Email Address <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-regular fa-envelope"></i></span>
                                                <input type="email" class="form-control rounded-end-3 py-2 border-start-0 ps-0" id="pageCheckoutEmail" required placeholder="e.g. vaibhavi@gmail.com" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Mobile Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-phone"></i></span>
                                                <input type="tel" class="form-control rounded-end-3 py-2 border-start-0 ps-0" id="pageCheckoutPhone" required placeholder="e.g. 5874142536" value="{{ Auth::check() ? (Auth::user()->phone ?? '') : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-semibold text-muted mb-1">City</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-location-dot"></i></span>
                                                <input type="text" class="form-control rounded-end-3 py-2 border-start-0 ps-0" id="pageCheckoutCity" placeholder="e.g. Ahmedabad" value="{{ Auth::check() ? (Auth::user()->city ?? 'Ahmedabad') : 'Ahmedabad' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label small fw-semibold text-muted mb-1">Address / Landmark</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-regular fa-building"></i></span>
                                                <input type="text" class="form-control rounded-end-3 py-2 border-start-0 ps-0" id="pageCheckoutAddress" placeholder="Street / Area / Landmark" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Secure Payment Method -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                <i class="fa-solid fa-credit-card small"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-0 fs-6">Payment Method</h5>
                                        </div>
                                        <span class="badge bg-success-subtle text-success small fw-semibold">
                                            <i class="fa-solid fa-shield-check me-1"></i> 100% Safe &amp; Verified
                                        </span>
                                    </div>

                                    <div class="d-flex flex-column gap-3">
                                        
                                        <!-- Option 1: Razorpay Secure Checkout -->
                                        <label class="payment-option-card selected d-flex align-items-start gap-3" id="payOptionRazorpay">
                                            <input class="form-check-input mt-1" type="radio" name="pagePaymentMethod" value="Razorpay / UPI / Net Banking" checked onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <strong class="text-dark fs-6">Razorpay Secure Checkout</strong>
                                                        <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.65rem;">Recommended</span>
                                                        <span class="badge bg-primary-subtle text-primary fw-semibold" style="font-size: 0.65rem;">Instant Access</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted small mb-2 mt-1" style="font-size: 0.76rem;">
                                                    Pay securely via UPI (Google Pay, PhonePe, Paytm, BHIM), Credit/Debit Cards (Visa, Mastercard, RuPay), or Net Banking (SBI, HDFC, ICICI, Axis).
                                                </p>
                                                <div class="d-flex align-items-center gap-2 flex-wrap pt-1 border-top border-light">
                                                    <span class="badge bg-white border text-dark fw-bold px-2 py-1" style="font-size: 0.68rem;"><i class="fa-brands fa-google-pay fs-6 me-1"></i> GPay</span>
                                                    <span class="badge bg-white border text-dark fw-bold px-2 py-1" style="font-size: 0.68rem;"><i class="fa-solid fa-mobile-screen-button me-1"></i> PhonePe</span>
                                                    <span class="badge bg-white border text-dark fw-bold px-2 py-1" style="font-size: 0.68rem;"><i class="fa-solid fa-qrcode me-1"></i> Paytm UPI</span>
                                                    <span class="badge bg-white border text-dark fw-bold px-2 py-1" style="font-size: 0.68rem;"><i class="fa-regular fa-credit-card me-1"></i> Cards / Net Banking</span>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Option 2: Direct Bank Transfer (Future Bank / Corporate Account) -->
                                        <label class="payment-option-card d-flex align-items-start gap-3" id="payOptionBank">
                                            <input class="form-check-input mt-1" type="radio" name="pagePaymentMethod" value="Direct Bank Transfer / NEFT / IMPS" onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <strong class="text-dark fs-6">Direct Bank Transfer / NEFT / IMPS</strong>
                                                        <span class="badge bg-info-subtle text-info fw-bold" style="font-size: 0.65rem;">For ₹3,000+ Orders</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted small mb-2 mt-1" style="font-size: 0.76rem;">
                                                    Transfer directly to Digital Class official current account. Ideal for high-value orders, institutes, agencies, and direct corporate billing.
                                                </p>

                                                <!-- Bank Details Dropdown (Smooth expansion) -->
                                                <div class="bank-details-box d-none" id="bankDetailsAccordion">
                                                    <div class="d-flex align-items-center gap-2 mb-2 text-primary fw-bold small">
                                                        <i class="fa-solid fa-building-columns"></i> Official Bank Account Details
                                                    </div>
                                                    <div class="row g-2 small">
                                                        <div class="col-sm-6 text-muted">Account Name: <strong class="text-dark d-block">Digital Class Educational World</strong></div>
                                                        <div class="col-sm-6 text-muted">Bank Name: <strong class="text-dark d-block">HDFC Bank Ltd</strong></div>
                                                        <div class="col-sm-6 text-muted">Account Number: <strong class="text-dark font-monospace d-block">50200084729103</strong></div>
                                                        <div class="col-sm-6 text-muted">IFSC Code: <strong class="text-dark font-monospace d-block">HDFC0001024</strong></div>
                                                        <div class="col-12 text-muted">Branch: <strong class="text-dark d-block">C.G. Road Branch, Ahmedabad, Gujarat</strong></div>
                                                    </div>
                                                    <div class="mt-2.5 pt-2 border-top">
                                                        <label class="form-label text-muted small fw-semibold mb-1" style="font-size: 0.72rem;">UTR / Transaction Reference (Optional after transfer):</label>
                                                        <input type="text" class="form-control form-control-sm rounded-2 font-monospace" id="pageBankUtrRef" placeholder="e.g. 432109876543">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Option 3: Cash / Pay on Delivery / Batch Enrollment -->
                                        <label class="payment-option-card d-flex align-items-start gap-3" id="payOptionCod">
                                            <input class="form-check-input mt-1" type="radio" name="pagePaymentMethod" value="Cash / Pay on Delivery" onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <strong class="text-dark fs-6">Cash / Pay on Delivery</strong>
                                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold" style="font-size: 0.65rem;">Offline Center</span>
                                                </div>
                                                <p class="text-muted small mb-0 mt-1" style="font-size: 0.76rem;">
                                                    Pay directly upon offline confirmation or at authorized local study center batch enrollment.
                                                </p>
                                            </div>
                                            <i class="fa-solid fa-hand-holding-dollar fs-4 text-muted opacity-50 mt-1"></i>
                                        </label>

                                    </div>
                                </div>

                                <!-- Trust & Security Badges -->
                                <div class="p-3.5 rounded-4 bg-light border d-flex align-items-center justify-content-around text-muted small text-center flex-wrap gap-3">
                                    <div>
                                        <i class="fa-solid fa-shield-halved text-primary d-block mb-1 fs-4"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.74rem;">PCI-DSS Certified</span>
                                        <small class="text-muted" style="font-size: 0.68rem;">Bank-grade safety</small>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-lock text-success d-block mb-1 fs-4"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.74rem;">256-Bit SSL</span>
                                        <small class="text-muted" style="font-size: 0.68rem;">End-to-end encrypted</small>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-bolt text-warning d-block mb-1 fs-4"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.74rem;">Instant Access</span>
                                        <small class="text-muted" style="font-size: 0.68rem;">Immediate enrollment</small>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-award text-info d-block mb-1 fs-4"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.74rem;">ISO 9001:2015</span>
                                        <small class="text-muted" style="font-size: 0.68rem;">Quality education</small>
                                    </div>
                                </div>

                            </div>

                            <!-- RIGHT COLUMN: Order Review & Direct Select Coupons -->
                            <div class="col-lg-5">
                                <div class="bg-light p-4 rounded-4 border shadow-sm position-sticky" style="top: 90px;">
                                    
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-receipt fs-6"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-0 fs-6">Order Review</h5>
                                        </div>
                                        <span class="badge bg-white text-primary border shadow-xs fw-bold px-2.5 py-1" id="pageOrderItemsCountBadge" style="font-size: 0.75rem;">
                                            {{ $cartCount ?? 0 }} {{ ($cartCount ?? 0) === 1 ? 'Item' : 'Items' }}
                                        </span>
                                    </div>

                                    <!-- Selected Items Preview Container -->
                                    <div id="pageCheckoutItemsList" class="d-flex flex-column gap-2 mb-3 overflow-y-auto" style="max-height: 240px;">
                                        <!-- Rendered dynamically from localStorage & session -->
                                    </div>

                                    <!-- DIRECT SELECT COUPON OPTIONS ("direct select coupn options") -->
                                    <div class="coupon-box-wrap p-3.5 mb-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-1.5">
                                                <i class="fa-solid fa-tags text-primary"></i>
                                                <strong class="text-dark small" style="font-size: 0.82rem;">Have a Coupon Code? / Select Offer</strong>
                                            </div>
                                            <span class="badge fw-semibold" style="font-size: 0.65rem; background: #eedafc; color: #7c3aed;">Instant Discount</span>
                                        </div>

                                        <!-- Available Direct Select Coupon Cards -->
                                        <div class="d-flex flex-column gap-2 mb-2.5" id="directCouponsContainer">
                                            
                                            <!-- WELCOME10 -->
                                            <div class="direct-coupon-card d-flex align-items-center justify-content-between" id="couponCard_WELCOME10" onclick="selectDirectCoupon('WELCOME10', 10, 'percent')">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input mt-0 cursor-pointer" type="radio" name="selectedCouponRadio" id="radio_WELCOME10">
                                                    <div>
                                                        <div class="d-flex align-items-center gap-1.5">
                                                            <strong class="text-dark font-monospace" style="font-size: 0.82rem;">WELCOME10</strong>
                                                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.62rem;">10% OFF</span>
                                                        </div>
                                                        <small class="text-muted d-block" style="font-size: 0.68rem;" id="savingText_WELCOME10">Save 10% on your entire order</small>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2.5 rounded-pill fw-semibold" style="font-size: 0.72rem;" id="btnApply_WELCOME10">
                                                    Apply
                                                </button>
                                            </div>

                                            <!-- DIGITAL20 -->
                                            <div class="direct-coupon-card d-flex align-items-center justify-content-between" id="couponCard_DIGITAL20" onclick="selectDirectCoupon('DIGITAL20', 20, 'percent')">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input mt-0 cursor-pointer" type="radio" name="selectedCouponRadio" id="radio_DIGITAL20">
                                                    <div>
                                                        <div class="d-flex align-items-center gap-1.5">
                                                            <strong class="text-dark font-monospace" style="font-size: 0.82rem;">DIGITAL20</strong>
                                                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.62rem;">20% OFF</span>
                                                            <span class="badge bg-danger-subtle text-danger fw-bold" style="font-size: 0.6rem;">HOT</span>
                                                        </div>
                                                        <small class="text-muted d-block" style="font-size: 0.68rem;" id="savingText_DIGITAL20">Special 20% Marketplace Discount</small>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2.5 rounded-pill fw-semibold" style="font-size: 0.72rem;" id="btnApply_DIGITAL20">
                                                    Apply
                                                </button>
                                            </div>

                                            <!-- DIWALI50 -->
                                            <div class="direct-coupon-card d-flex align-items-center justify-content-between" id="couponCard_DIWALI50" onclick="selectDirectCoupon('DIWALI50', 50, 'percent')">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input class="form-check-input mt-0 cursor-pointer" type="radio" name="selectedCouponRadio" id="radio_DIWALI50">
                                                    <div>
                                                        <div class="d-flex align-items-center gap-1.5">
                                                            <strong class="text-dark font-monospace" style="font-size: 0.82rem;">DIWALI50</strong>
                                                            <span class="badge bg-warning-subtle text-warning-emphasis fw-bold" style="font-size: 0.62rem;">50% OFF</span>
                                                            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 0.6rem;">MEGA</span>
                                                        </div>
                                                        <small class="text-muted d-block" style="font-size: 0.68rem;" id="savingText_DIWALI50">Flat 50% Festive Super Discount</small>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2.5 rounded-pill fw-semibold" style="font-size: 0.72rem;" id="btnApply_DIWALI50">
                                                    Apply
                                                </button>
                                            </div>

                                        </div>

                                        <!-- Custom Coupon Code Input Row -->
                                        <div class="input-group input-group-sm mb-1.5" id="pageCouponInputGroup">
                                            <input type="text" id="pageCouponInput" class="form-control text-uppercase fw-bold shadow-none" placeholder="Have other promo code?" style="font-size: 0.78rem; letter-spacing: 0.5px; border-color: #d8b4fe;">
                                            <button class="btn text-white fw-bold px-3 shadow-none" type="button" id="btnApplyPageCoupon" onclick="applyPageCouponAction()" style="background: #7c3aed; font-size: 0.75rem;">
                                                Apply
                                            </button>
                                        </div>

                                        <!-- Active Applied Coupon Banner -->
                                        <div id="pageAppliedCouponBanner" class="d-none align-items-center justify-content-between bg-white px-3 py-2 rounded-3 border border-success mb-1.5 shadow-xs">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                                <div>
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <strong class="text-success text-uppercase" id="pageAppliedCouponCodeText" style="font-size: 0.82rem;"></strong>
                                                        <span class="badge bg-success text-white fw-bold" style="font-size: 0.62rem;">APPLIED</span>
                                                    </div>
                                                    <div class="text-muted" id="pageAppliedCouponDiscountText" style="font-size: 0.7rem;"></div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none fw-semibold" onclick="removePageCouponAction()" style="font-size: 0.74rem;">
                                                <i class="fa-solid fa-xmark me-0.5"></i> Remove
                                            </button>
                                        </div>

                                        <!-- Feedback Alert -->
                                        <div id="pageCouponFeedbackAlert" class="small mb-1 py-1.5 px-2.5 rounded-2" style="font-size: 0.74rem; display: none;"></div>

                                    </div>

                                    <!-- Price Calculation Breakdown -->
                                    <div class="border-top pt-2.5 mb-3">
                                        <div class="d-flex justify-content-between text-muted small mb-1.5">
                                            <span>Subtotal</span>
                                            <strong class="text-dark" id="pageCheckoutSubtotal">₹0.00</strong>
                                        </div>

                                        <div class="d-flex justify-content-between text-success small mb-1.5 d-none" id="pageCheckoutDiscountRow">
                                            <span class="fw-semibold">
                                                <i class="fa-solid fa-tag me-1"></i> Coupon Discount (<span id="pageCheckoutDiscountCodeLabel"></span>)
                                            </span>
                                            <strong class="text-success fs-6" id="pageCheckoutDiscountAmountLabel">-₹0.00</strong>
                                        </div>

                                        <div class="d-flex justify-content-between text-muted small mb-2">
                                            <span>Platform Handling &amp; Taxes</span>
                                            <span class="text-success fw-bold">FREE</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-baseline text-dark fw-bold border-top pt-2.5" style="font-size: 1.15rem;">
                                            <span>Total Due</span>
                                            <span class="text-primary fs-3 fw-bolder" id="pageCheckoutTotalDue">₹0.00</span>
                                        </div>
                                    </div>

                                    <!-- Place Order Button -->
                                    <button type="submit" id="btnConfirmPlaceOrder" class="btn btn-primary w-100 fw-bold py-3 rounded-3 shadow d-flex align-items-center justify-content-center gap-2" style="font-size: 1rem; background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);">
                                        <i class="fa-solid fa-lock fs-6"></i>
                                        <span>Confirm &amp; Place Order</span>
                                    </button>

                                    <div class="text-center mt-2.5">
                                        <small class="text-muted" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-shield-halved text-success me-1"></i> By ordering you agree to Digital Class Terms of Service.
                                        </small>
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

@section('scripts')
@push('scripts')
<script>
    // Injected server cart fallback (guarantees session cart is visible even if localStorage was cleared)
    window.SERVER_CART = {!! json_encode(array_values($cart ?? [])) !!};

    let checkoutItems = [];
    let checkoutSubtotal = 0;
    let checkoutTotalDiscount = 0;
    let checkoutActiveCoupon = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadCheckoutPageData();
    });

    function handlePaymentChange(radio) {
        document.getElementById('payOptionRazorpay').classList.toggle('selected', radio.value.includes('Razorpay'));
        document.getElementById('payOptionBank').classList.toggle('selected', radio.value.includes('Bank Transfer'));
        document.getElementById('payOptionCod').classList.toggle('selected', radio.value.includes('Cash'));

        // Toggle bank accordion
        const bankBox = document.getElementById('bankDetailsAccordion');
        if (bankBox) {
            if (radio.value.includes('Bank Transfer')) {
                bankBox.classList.remove('d-none');
            } else {
                bankBox.classList.add('d-none');
            }
        }
    }

    function loadCheckoutPageData() {
        // 1. First get items from localStorage
        let localItems = (typeof getCartItems === 'function') ? getCartItems() : [];

        // 2. If localStorage is empty, fallback to server session cart
        if ((!localItems || !localItems.length) && window.SERVER_CART && window.SERVER_CART.length) {
            localItems = window.SERVER_CART;
            if (typeof saveCartItems === 'function') {
                saveCartItems(localItems);
            }
        }

        // 3. Conversely, if localStorage has items but server has none, sync them
        checkoutItems = localItems || [];

        if (!checkoutItems || !checkoutItems.length) {
            document.getElementById('checkoutPageFormScreen').style.display = 'none';
            document.getElementById('checkoutPageEmptyScreen').style.display = 'block';
            return;
        }

        document.getElementById('checkoutPageEmptyScreen').style.display = 'none';
        document.getElementById('checkoutPageFormScreen').style.display = 'block';

        // Check if any item already brought an active coupon
        checkoutItems.forEach(item => {
            if (item.coupon_code && !checkoutActiveCoupon) {
                checkoutActiveCoupon = item.coupon_code;
            }
        });

        renderCheckoutPageItems();

        // If coupon was active, auto-apply and highlight
        if (checkoutActiveCoupon) {
            applyQuickPageCoupon(checkoutActiveCoupon, true);
        }
    }

    function renderCheckoutPageItems() {
        const container = document.getElementById('pageCheckoutItemsList');
        const badge = document.getElementById('pageOrderItemsCountBadge');
        if (badge) badge.textContent = checkoutItems.length + (checkoutItems.length === 1 ? ' Item' : ' Items');

        checkoutSubtotal = 0;
        let html = '';

        checkoutItems.forEach((item, idx) => {
            const unitPrice = parseFloat(item.price) || 0;
            const originalPrice = parseFloat(item.original_price || item.price) || 0;
            const qty = parseInt(item.quantity) || 1;
            const itemTotal = unitPrice * qty;
            const originalTotal = originalPrice * qty;

            checkoutSubtotal += (item.original_price ? originalTotal : itemTotal);
            const thumbUrl = item.thumbnail || 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80';

            html += `
                <div class="d-flex align-items-center gap-2.5 bg-white p-2.5 rounded-3 border shadow-xs position-relative">
                    <img src="${thumbUrl}" alt="${item.title}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; flex-shrink: 0;" class="border">
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class="d-flex align-items-center justify-content-between mb-0.5">
                            <span class="badge ${item.type === 'Product' ? 'bg-danger-subtle text-danger' : (item.type === 'Service' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary')} fw-bold" style="font-size: 0.6rem;">${item.type || 'Course'}</span>
                            <button type="button" class="btn btn-link text-muted p-0 text-decoration-none" onclick="removeCheckoutItem(${idx})" title="Remove item" style="font-size: 0.8rem; line-height: 1;">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="text-dark small fw-bold text-truncate" title="${item.title}">${item.title}</div>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <div class="d-flex align-items-center gap-1.5">
                                <button type="button" class="item-qty-btn" onclick="updateItemQuantity(${idx}, -1)" title="Decrease">-</button>
                                <span class="fw-bold small px-1">${qty}</span>
                                <button type="button" class="item-qty-btn" onclick="updateItemQuantity(${idx}, 1)" title="Increase">+</button>
                            </div>
                            <div class="text-end">
                                <strong class="text-dark small d-block">₹${itemTotal.toLocaleString('en-IN')}</strong>
                                ${originalPrice > unitPrice ? '<small class="text-muted text-decoration-line-through" style="font-size: 0.65rem;">₹' + originalTotal.toLocaleString('en-IN') + '</small>' : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        if (container) container.innerHTML = html;
        updateTotalsDisplay();
        updateCouponSavingsEstimates();
    }

    function updateItemQuantity(idx, delta) {
        if (!checkoutItems[idx]) return;
        const newQty = (checkoutItems[idx].quantity || 1) + delta;
        if (newQty <= 0) {
            removeCheckoutItem(idx);
            return;
        }
        checkoutItems[idx].quantity = newQty;
        if (typeof saveCartItems === 'function') saveCartItems(checkoutItems);
        renderCheckoutPageItems();
        if (checkoutActiveCoupon) {
            applyPageCouponAction(true);
        }
    }

    function removeCheckoutItem(idx) {
        if (!checkoutItems[idx]) return;
        checkoutItems.splice(idx, 1);
        if (typeof saveCartItems === 'function') saveCartItems(checkoutItems);
        if (!checkoutItems.length) {
            document.getElementById('checkoutPageFormScreen').style.display = 'none';
            document.getElementById('checkoutPageEmptyScreen').style.display = 'block';
            return;
        }
        renderCheckoutPageItems();
        if (checkoutActiveCoupon) {
            applyPageCouponAction(true);
        }
    }

    function updateCouponSavingsEstimates() {
        // Dynamically compute exact savings for direct selectable coupons
        const w10Saving = (checkoutSubtotal * 0.10);
        const d20Saving = (checkoutSubtotal * 0.20);
        const d50Saving = (checkoutSubtotal * 0.50);

        const w10El = document.getElementById('savingText_WELCOME10');
        const d20El = document.getElementById('savingText_DIGITAL20');
        const d50El = document.getElementById('savingText_DIWALI50');

        if (w10El) w10El.textContent = 'Save ₹' + w10Saving.toLocaleString('en-IN', {minimumFractionDigits: 2}) + ' on your order';
        if (d20El) d20El.textContent = 'Save ₹' + d20Saving.toLocaleString('en-IN', {minimumFractionDigits: 2}) + ' (Special Marketplace Deal)';
        if (d50El) d50El.textContent = 'Save ₹' + d50Saving.toLocaleString('en-IN', {minimumFractionDigits: 2}) + ' (Flat 50% Mega Discount)';
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

    // Direct Select Coupon handler ("direct select coupn options")
    function selectDirectCoupon(code, value, type) {
        const input = document.getElementById('pageCouponInput');
        if (input) input.value = code;
        applyPageCouponAction();
    }

    function highlightSelectedCouponCard(code) {
        ['WELCOME10', 'DIGITAL20', 'DIWALI50'].forEach(c => {
            const card = document.getElementById('couponCard_' + c);
            const radio = document.getElementById('radio_' + c);
            const btn = document.getElementById('btnApply_' + c);
            if (card && radio && btn) {
                if (c === code) {
                    card.classList.add('applied');
                    radio.checked = true;
                    btn.className = 'btn btn-sm btn-success py-0.5 px-2.5 rounded-pill fw-bold text-white';
                    btn.innerHTML = '<i class="fa-solid fa-check me-1"></i> Applied';
                } else {
                    card.classList.remove('applied');
                    radio.checked = false;
                    btn.className = 'btn btn-sm btn-outline-primary py-0.5 px-2.5 rounded-pill fw-semibold';
                    btn.textContent = 'Apply';
                }
            }
        });
    }

    function applyQuickPageCoupon(code, silent = false) {
        const input = document.getElementById('pageCouponInput');
        if (input) {
            input.value = code;
            applyPageCouponAction(silent);
        }
    }

    async function applyPageCouponAction(silent = false) {
        const input = document.getElementById('pageCouponInput');
        const btn = document.getElementById('btnApplyPageCoupon');
        const alertEl = document.getElementById('pageCouponFeedbackAlert');
        const code = (input ? input.value : '').trim().toUpperCase();

        if (!code) {
            if (!silent && alertEl) {
                alertEl.className = 'small mb-1 py-1.5 px-2.5 rounded-2 text-danger bg-danger-subtle';
                alertEl.textContent = 'Please enter or select a coupon code';
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

                // Highlight direct card if matching
                highlightSelectedCouponCard(data.code);

                // Show active banner
                const banner = document.getElementById('pageAppliedCouponBanner');
                if (banner) {
                    banner.classList.remove('d-none');
                    banner.classList.add('d-flex');
                }
                const codeText = document.getElementById('pageAppliedCouponCodeText');
                if (codeText) codeText.textContent = data.code;
                const discText = document.getElementById('pageAppliedCouponDiscountText');
                if (discText) discText.textContent = 'You saved ₹' + checkoutTotalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 });

                if (alertEl) {
                    alertEl.className = 'small mb-1 py-1.5 px-2.5 rounded-2 text-success bg-success-subtle fw-semibold';
                    alertEl.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> Coupon ' + data.code + ' applied successfully! You saved ₹' + checkoutTotalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                    alertEl.style.display = 'block';
                }

                updateTotalsDisplay();
            } else {
                checkoutActiveCoupon = null;
                checkoutTotalDiscount = 0;
                highlightSelectedCouponCard(null);
                updateTotalsDisplay();

                if (!silent && alertEl) {
                    alertEl.className = 'small mb-1 py-1.5 px-2.5 rounded-2 text-danger bg-danger-subtle';
                    alertEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ' + (data.message || 'Invalid coupon code');
                    alertEl.style.display = 'block';
                }
            }
        } catch (e) {
            if (!silent && alertEl) {
                alertEl.className = 'small mb-1 py-1.5 px-2.5 rounded-2 text-danger bg-danger-subtle';
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
        highlightSelectedCouponCard(null);

        const banner = document.getElementById('pageAppliedCouponBanner');
        if (banner) {
            banner.classList.remove('d-flex');
            banner.classList.add('d-none');
        }
        const input = document.getElementById('pageCouponInput');
        if (input) input.value = '';

        const alertEl = document.getElementById('pageCouponFeedbackAlert');
        if (alertEl) alertEl.style.display = 'none';

        updateTotalsDisplay();
    }

    async function handlePageCheckoutSubmit(e) {
        e.preventDefault();

        const btn = document.getElementById('btnConfirmPlaceOrder');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Securing Order & Processing...';
        }

        const name = document.getElementById('pageCheckoutName').value.trim();
        const email = document.getElementById('pageCheckoutEmail').value.trim();
        const phone = document.getElementById('pageCheckoutPhone').value.trim();
        const city = document.getElementById('pageCheckoutCity').value.trim();
        const address = document.getElementById('pageCheckoutAddress').value.trim();
        const paymentMethod = document.querySelector('input[name="pagePaymentMethod"]:checked')?.value || 'Razorpay / UPI / Net Banking';
        const bankUtr = document.getElementById('pageBankUtrRef')?.value.trim();

        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const payload = {
            _token: csrfToken,
            name: name,
            email: email,
            phone: phone,
            city: city,
            address: address,
            payment_method: paymentMethod + (bankUtr ? ' (UTR: ' + bankUtr + ')' : ''),
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
                if (typeof saveCartItems === 'function') saveCartItems([]);

                // Show success view
                document.getElementById('checkoutPageFormScreen').style.display = 'none';
                document.getElementById('checkoutPageSuccessScreen').style.display = 'block';

                document.getElementById('pageSuccessOrderRef').textContent = data.order_number || ('#DC-' + Math.floor(10000 + Math.random() * 90000));
                document.getElementById('pageSuccessAmount').textContent = '₹' + (data.total_amount ? (typeof data.total_amount === 'number' ? data.total_amount.toLocaleString('en-IN', {minimumFractionDigits: 2}) : data.total_amount) : Math.max(0, checkoutSubtotal - checkoutTotalDiscount).toLocaleString('en-IN', {minimumFractionDigits: 2}));
                document.getElementById('pageSuccessPaymentMethod').textContent = paymentMethod;
                document.getElementById('pageSuccessCustomer').textContent = name;
                document.getElementById('pageSuccessEmail').textContent = email;

                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                alert(data.message || 'Unable to place order. Please check your information and try again.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock fs-6"></i> <span>Confirm &amp; Place Order</span>';
                }
            }
        } catch (err) {
            console.error('Checkout error:', err);
            alert('A network error occurred while placing your order. Please check your connection and try again.');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock fs-6"></i> <span>Confirm &amp; Place Order</span>';
            }
        }
    }
</script>
@endpush
@endsection
