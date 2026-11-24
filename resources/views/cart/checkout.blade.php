@extends('layouts.app')

@section('title', 'Marketplace Checkout - Digital Class')

@section('styles')
@push('styles')
<style>
    .checkout-page-container {
        max-width: 1140px;
        margin: 0 auto;
    }
    .checkout-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        border: 1px solid #e2e8f0;
    }
    .checkout-header-bar {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 20px 20px 0 0;
        padding: 1.25rem 2rem;
        color: #ffffff;
    }
    .section-label {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.2px;
    }
    .section-icon-bubble {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f3e8ff;
        color: #7c3aed;
        font-size: 0.85rem;
    }
    .form-control-luxury {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        background: #ffffff;
        color: #0f172a;
    }
    .form-control-luxury:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
        outline: none;
        background: #ffffff;
    }
    .payment-option-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.9rem 1.15rem;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        background: #ffffff;
        position: relative;
    }
    .payment-option-card:hover {
        border-color: #a855f7;
        background: #fbf8ff;
    }
    .payment-option-card.selected {
        border-color: #7c3aed;
        background: #faf5ff;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.08);
    }
    .payment-option-card .form-check-input:checked {
        background-color: #7c3aed;
        border-color: #7c3aed;
    }

    /* Luxury Order Review Card (Right Column) */
    .order-summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        padding: 1.5rem;
        position: sticky;
        top: 90px;
    }

    /* Item Card */
    .checkout-item-card {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 12px;
        padding: 10px 12px;
        transition: all 0.15s ease;
    }
    .checkout-item-card:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
    }
    .checkout-item-thumb {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .checkout-item-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.25;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .checkout-item-badge {
        font-size: 0.6rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .checkout-qty-stepper {
        display: inline-flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 1px 3px;
        gap: 4px;
    }
    .stepper-btn {
        width: 18px;
        height: 18px;
        border: none;
        background: #f1f5f9;
        color: #475569;
        border-radius: 4px;
        font-size: 0.72rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.1s;
    }
    .stepper-btn:hover {
        background: #7c3aed;
        color: #ffffff;
    }
    .stepper-val {
        font-size: 0.75rem;
        font-weight: 700;
        color: #0f172a;
        min-width: 14px;
        text-align: center;
    }
    .checkout-item-price {
        font-size: 0.9rem;
        font-weight: 800;
        color: #0f172a;
        display: block;
    }
    .checkout-item-mrp {
        font-size: 0.68rem;
        color: #94a3b8;
        text-decoration: line-through;
        display: block;
    }
    .checkout-item-remove {
        border: none;
        background: transparent;
        color: #94a3b8;
        font-size: 0.8rem;
        padding: 2px;
        border-radius: 4px;
        cursor: pointer;
        transition: color 0.15s;
    }
    .checkout-item-remove:hover {
        color: #ef4444;
    }

    /* Clean, Modern Coupon Module */
    .coupon-module-box {
        background: #faf5ff;
        border: 1px solid #e9d5ff;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.25rem;
    }
    .coupon-input-group {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1.5px solid #d8b4fe;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .coupon-input-group:focus-within {
        border-color: #7c3aed;
        box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.12);
    }
    .coupon-input-group input {
        border: none;
        outline: none;
        padding: 0.45rem 0.75rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex-grow: 1;
        color: #0f172a;
    }
    .coupon-input-group button {
        border: none;
        background: #7c3aed;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 0.45rem 1rem;
        cursor: pointer;
        transition: background 0.15s;
    }
    .coupon-input-group button:hover {
        background: #6d28d9;
    }

    /* Single Luxury Applied Coupon Card */
    .coupon-applied-card {
        background: #ffffff;
        border: 1.5px solid #10b981;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
    }
    .coupon-applied-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #d1fae5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    .coupon-applied-code {
        font-size: 0.85rem;
        font-weight: 800;
        color: #065f46;
        letter-spacing: 0.5px;
    }
    .coupon-applied-badge {
        font-size: 0.62rem;
        font-weight: 700;
        background: #059669;
        color: #ffffff;
        padding: 0.12rem 0.45rem;
        border-radius: 4px;
        letter-spacing: 0.3px;
    }
    .coupon-applied-savings {
        font-size: 0.7rem;
        color: #047857;
        font-weight: 600;
    }
    .coupon-applied-remove-btn {
        border: none;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s;
        flex-shrink: 0;
    }
    .coupon-applied-remove-btn:hover {
        background: #fca5a5;
        color: #7f1d1d;
    }

    /* Quick Offer Chips */
    .offer-pill {
        border: 1px solid #e9d5ff;
        background: #ffffff;
        color: #7c3aed;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.22rem 0.65rem;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .offer-pill:hover {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
        transform: translateY(-1px);
    }
    .offer-pill-badge {
        font-size: 0.62rem;
        background: #f3e8ff;
        color: #7c3aed;
        padding: 0.05rem 0.35rem;
        border-radius: 9999px;
    }
    .offer-pill:hover .offer-pill-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    /* Pricing Breakdown Rows */
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.35rem 0;
        font-size: 0.82rem;
        color: #64748b;
    }
    .price-row-total {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding-top: 0.75rem;
        margin-top: 0.5rem;
        border-top: 1.5px solid #e2e8f0;
    }

    /* Main CTA Button */
    .btn-place-order-luxury {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 0.85rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 800;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.25);
        transition: all 0.2s ease;
        letter-spacing: -0.2px;
    }
    .btn-place-order-luxury:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(124, 58, 237, 0.35);
        color: #ffffff;
    }

    /* Bank Details Dropdown */
    .bank-details-box {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        margin-top: 0.65rem;
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

        <!-- Main Checkout Card -->
        <div class="checkout-card overflow-hidden">
            
            <!-- Modern Header Bar -->
            <div class="checkout-header-bar d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                        <i class="fa-solid fa-shield-halved fs-6 text-primary"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white fs-5">Instant Marketplace Checkout</h4>
                        <small class="text-white-50" style="font-size: 0.75rem;">100% Secure 256-Bit SSL Encrypted &bull; Instant Enrollment</small>
                    </div>
                </div>
                <div class="d-none d-md-flex align-items-center gap-2 text-white-50 small" style="font-size: 0.78rem;">
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <span>Verified Buyer Protection</span>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4 p-lg-5">

                <!-- Success Screen (Shown after successful order placement) -->
                <div id="checkoutPageSuccessScreen" class="py-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white shadow-lg p-3 mb-3" style="width: 76px; height: 76px;">
                        <i class="fa-solid fa-check fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Order Placed Successfully!</h3>
                    <p class="text-muted small mb-4" style="max-width: 440px; margin: 0 auto;">
                        Thank you for your order! Your purchase has been confirmed. You will receive an email confirmation and instant enrollment details shortly.
                    </p>

                    <div class="bg-light border rounded-3 p-4 mb-4 mx-auto text-start shadow-xs" style="max-width: 460px;">
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

                <!-- Empty Cart State Screen -->
                <div id="checkoutPageEmptyScreen" class="py-5 text-center" style="display: none;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-4 mb-3 border shadow-xs">
                        <i class="fa-solid fa-cart-shopping fs-1 text-primary opacity-75"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Your cart is currently empty</h4>
                    <p class="text-muted small mb-4" style="max-width: 360px; margin: 0 auto;">
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
                                        <div class="section-icon-bubble">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h5 class="section-label mb-0">Customer Information</h5>
                                        @if(Auth::check() && Auth::user()->isCustomer())
                                            <span class="badge bg-success-subtle text-success ms-auto fw-semibold" style="font-size: 0.72rem;">
                                                <i class="fa-solid fa-circle-check me-1"></i> Logged In as {{ Auth::user()->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted mb-1">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-luxury" id="pageCheckoutName" required placeholder="e.g. Vaibhavi Shah" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control form-control-luxury" id="pageCheckoutEmail" required placeholder="e.g. vaibhavi@gmail.com" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-muted mb-1">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control form-control-luxury" id="pageCheckoutPhone" required placeholder="e.g. 5874142536" value="{{ Auth::check() ? (Auth::user()->phone ?? '') : '' }}">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-semibold text-muted mb-1">City</label>
                                            <input type="text" class="form-control form-control-luxury" id="pageCheckoutCity" placeholder="e.g. Ahmedabad" value="{{ Auth::check() ? (Auth::user()->city ?? 'Ahmedabad') : 'Ahmedabad' }}">
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label small fw-semibold text-muted mb-1">Address / Landmark</label>
                                            <input type="text" class="form-control form-control-luxury" id="pageCheckoutAddress" placeholder="Street / Area / Landmark" value="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Secure Payment Method -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="section-icon-bubble">
                                                <i class="fa-solid fa-credit-card"></i>
                                            </div>
                                            <h5 class="section-label mb-0">Payment Method</h5>
                                        </div>
                                        <span class="badge bg-success-subtle text-success small fw-semibold">
                                            <i class="fa-solid fa-shield-check me-1"></i> 100% Safe &amp; Verified
                                        </span>
                                    </div>

                                    <div class="d-flex flex-column gap-2.5">
                                        
                                        <!-- Option 1: Razorpay Secure Checkout -->
                                        <label class="payment-option-card selected d-flex align-items-start gap-3" id="payOptionRazorpay">
                                            <input class="form-check-input mt-1" type="radio" name="pagePaymentMethod" value="Razorpay / UPI / Net Banking" checked onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <strong class="text-dark small" style="font-size: 0.88rem;">Razorpay Secure Checkout</strong>
                                                        <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.62rem;">Recommended</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted small mb-1.5 mt-0.5" style="font-size: 0.74rem;">
                                                    UPI (GPay, PhonePe, Paytm), Debit/Credit Cards (Visa, Mastercard, RuPay), or Net Banking.
                                                </p>
                                                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                                    <span class="badge bg-light text-dark border px-2 py-0.5" style="font-size: 0.65rem;">GPay</span>
                                                    <span class="badge bg-light text-dark border px-2 py-0.5" style="font-size: 0.65rem;">PhonePe</span>
                                                    <span class="badge bg-light text-dark border px-2 py-0.5" style="font-size: 0.65rem;">Paytm</span>
                                                    <span class="badge bg-light text-dark border px-2 py-0.5" style="font-size: 0.65rem;">Cards / 50+ Banks</span>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Option 2: Direct Bank Transfer (Future Bank / Corporate Account) -->
                                        <label class="payment-option-card d-flex align-items-start gap-3" id="payOptionBank">
                                            <input class="form-check-input mt-1" type="radio" name="pagePaymentMethod" value="Direct Bank Transfer / NEFT / IMPS" onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <strong class="text-dark small" style="font-size: 0.88rem;">Direct Bank Transfer / NEFT / IMPS</strong>
                                                        <span class="badge bg-info-subtle text-info fw-bold" style="font-size: 0.62rem;">High-Value / Corporate</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted small mb-0 mt-0.5" style="font-size: 0.74rem;">
                                                    Transfer directly to Digital Class official HDFC current account. Ideal for ₹3,000+ orders & institutions.
                                                </p>

                                                <!-- Collapsible Bank Details -->
                                                <div class="bank-details-box d-none" id="bankDetailsAccordion">
                                                    <div class="d-flex align-items-center gap-1.5 mb-2 text-primary fw-bold small" style="font-size: 0.75rem;">
                                                        <i class="fa-solid fa-building-columns"></i> Official Bank Account Details
                                                    </div>
                                                    <div class="row g-1.5 small text-muted" style="font-size: 0.72rem;">
                                                        <div class="col-sm-6">Account Name: <strong class="text-dark d-block">Digital Class Educational World</strong></div>
                                                        <div class="col-sm-6">Bank Name: <strong class="text-dark d-block">HDFC Bank Ltd</strong></div>
                                                        <div class="col-sm-6">Account Number: <strong class="text-dark font-monospace d-block">50200084729103</strong></div>
                                                        <div class="col-sm-6">IFSC Code: <strong class="text-dark font-monospace d-block">HDFC0001024</strong></div>
                                                        <div class="col-12">Branch: <strong class="text-dark d-block">C.G. Road Branch, Ahmedabad, Gujarat</strong></div>
                                                    </div>
                                                    <div class="mt-2 pt-2 border-top">
                                                        <label class="form-label text-muted small fw-semibold mb-1" style="font-size: 0.7rem;">UTR / Transaction Reference (Optional after transfer):</label>
                                                        <input type="text" class="form-control form-control-sm rounded-2 font-monospace" id="pageBankUtrRef" placeholder="e.g. 432109876543" style="font-size: 0.75rem;">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Option 3: Cash / Pay on Delivery / Batch Enrollment -->
                                        <label class="payment-option-card d-flex align-items-start gap-3" id="payOptionCod">
                                            <input class="form-check-input mt-1" type="radio" name="pagePaymentMethod" value="Cash / Pay on Delivery" onchange="handlePaymentChange(this)">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <strong class="text-dark small" style="font-size: 0.88rem;">Cash / Pay on Delivery</strong>
                                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold" style="font-size: 0.62rem;">Offline Center</span>
                                                </div>
                                                <p class="text-muted small mb-0 mt-0.5" style="font-size: 0.74rem;">
                                                    Pay directly upon offline confirmation or at authorized local study center batch enrollment.
                                                </p>
                                            </div>
                                            <i class="fa-solid fa-hand-holding-dollar fs-5 text-muted opacity-50 mt-1"></i>
                                        </label>

                                    </div>
                                </div>

                                <!-- Trust & Security Badges -->
                                <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-around text-muted small text-center flex-wrap gap-2">
                                    <div>
                                        <i class="fa-solid fa-shield-halved text-primary d-block mb-0.5 fs-5"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.72rem;">PCI-DSS Certified</span>
                                        <small class="text-muted" style="font-size: 0.65rem;">Bank-grade safety</small>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-lock text-success d-block mb-0.5 fs-5"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.72rem;">256-Bit SSL</span>
                                        <small class="text-muted" style="font-size: 0.65rem;">End-to-end encrypted</small>
                                    </div>
                                    <div class="border-start ps-3">
                                        <i class="fa-solid fa-bolt text-warning d-block mb-0.5 fs-5"></i>
                                        <span class="fw-semibold text-dark d-block" style="font-size: 0.72rem;">Instant Access</span>
                                        <small class="text-muted" style="font-size: 0.65rem;">Immediate enrollment</small>
                                    </div>
                                </div>

                            </div>

                            <!-- RIGHT COLUMN: Order Review & Clean Coupons -->
                            <div class="col-lg-5">
                                <div class="order-summary-card">
                                    
                                    <!-- Header -->
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="section-icon-bubble" style="background: #fef3c7; color: #d97706;">
                                                <i class="fa-solid fa-receipt"></i>
                                            </div>
                                            <h5 class="section-label mb-0">Order Review</h5>
                                        </div>
                                        <span class="badge bg-light text-primary border fw-bold px-2.5 py-1" id="pageOrderItemsCountBadge" style="font-size: 0.72rem;">
                                            {{ $cartCount ?? 0 }} {{ ($cartCount ?? 0) === 1 ? 'Item' : 'Items' }}
                                        </span>
                                    </div>

                                    <!-- Selected Items Preview Container -->
                                    <div id="pageCheckoutItemsList" class="d-flex flex-column gap-2 mb-3 overflow-y-auto" style="max-height: 220px;">
                                        <!-- Rendered dynamically -->
                                    </div>

                                    <!-- CLEAN & ATTRACTIVE COUPON MODULE -->
                                    <div class="coupon-module-box">
                                        
                                        <!-- State A: Input & Popular Chips (Shown when NO coupon is active) -->
                                        <div id="couponInputSection">
                                            <div class="d-flex align-items-center justify-content-between mb-1.5">
                                                <span class="small fw-bold text-dark" style="font-size: 0.78rem;">
                                                    <i class="fa-solid fa-tag text-primary me-1"></i> Have a Coupon Code?
                                                </span>
                                                <span class="badge bg-white text-primary border fw-semibold" style="font-size: 0.62rem;">Save Extra</span>
                                            </div>

                                            <!-- Clean Single Input Group -->
                                            <div class="coupon-input-group mb-2">
                                                <input type="text" id="pageCouponInput" placeholder="ENTER COUPON CODE" autocomplete="off">
                                                <button type="button" id="btnApplyPageCoupon" onclick="applyPageCouponAction()">Apply</button>
                                            </div>

                                            <!-- Popular Quick Chips -->
                                            <div class="d-flex align-items-center gap-1.5 flex-wrap pt-1 border-top border-light">
                                                <span class="text-muted" style="font-size: 0.68rem; font-weight: 600;">Offers:</span>
                                                <button type="button" class="offer-pill" onclick="applyQuickPageCoupon('WELCOME10')">
                                                    WELCOME10 <span class="offer-pill-badge">10% OFF</span>
                                                </button>
                                                <button type="button" class="offer-pill" onclick="applyQuickPageCoupon('DIGITAL20')">
                                                    DIGITAL20 <span class="offer-pill-badge">20% OFF</span>
                                                </button>
                                                <button type="button" class="offer-pill" onclick="applyQuickPageCoupon('DIWALI50')">
                                                    DIWALI50 <span class="offer-pill-badge">50% OFF</span>
                                                </button>
                                            </div>

                                            <!-- Feedback Alert for invalid coupon -->
                                            <div id="pageCouponFeedbackAlert" class="small mt-1.5 py-1 px-2 rounded text-danger bg-danger-subtle" style="font-size: 0.72rem; display: none;"></div>
                                        </div>

                                        <!-- State B: Single Luxury Applied Badge (Shown when coupon IS active) -->
                                        <div id="couponAppliedSection" class="coupon-applied-card d-none">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="coupon-applied-icon">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <span class="coupon-applied-code" id="pageAppliedCouponCodeText">WELCOME10</span>
                                                        <span class="coupon-applied-badge">APPLIED</span>
                                                    </div>
                                                    <div class="coupon-applied-savings" id="pageAppliedCouponDiscountText">You saved ₹0.00!</div>
                                                </div>
                                            </div>
                                            <button type="button" class="coupon-applied-remove-btn" onclick="removePageCouponAction()" title="Remove coupon">
                                                <i class="fa-solid fa-xmark me-0.5"></i> Remove
                                            </button>
                                        </div>

                                    </div>

                                    <!-- Price Calculation Breakdown -->
                                    <div class="border-top pt-2 mb-3">
                                        <div class="price-row">
                                            <span>Subtotal</span>
                                            <strong class="text-dark" id="pageCheckoutSubtotal">₹0.00</strong>
                                        </div>

                                        <div class="price-row text-success d-none" id="pageCheckoutDiscountRow">
                                            <span>
                                                <i class="fa-solid fa-tag me-1"></i> Coupon Discount (<span id="pageCheckoutDiscountCodeLabel"></span>)
                                            </span>
                                            <strong class="text-success" id="pageCheckoutDiscountAmountLabel">-₹0.00</strong>
                                        </div>

                                        <div class="price-row">
                                            <span>Platform Handling &amp; Taxes</span>
                                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.65rem;">FREE</span>
                                        </div>

                                        <div class="price-row-total">
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.95rem;">Total Due</div>
                                                <small class="text-muted" style="font-size: 0.68rem;">Includes all taxes &amp; instant access</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="text-primary fs-3 fw-bolder" id="pageCheckoutTotalDue">₹0.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Place Order Button -->
                                    <button type="submit" id="btnConfirmPlaceOrder" class="btn-place-order-luxury">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>Confirm &amp; Place Order</span>
                                    </button>

                                    <div class="text-center mt-2.5">
                                        <small class="text-muted" style="font-size: 0.68rem;">
                                            <i class="fa-solid fa-shield-check text-success me-0.5"></i> 256-Bit SSL Encrypted &bull; Instant Access
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
    // Server session cart fallback
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
        let localItems = (typeof getCartItems === 'function') ? getCartItems() : [];

        // If local storage is empty, populate from server cart
        if ((!localItems || !localItems.length) && window.SERVER_CART && window.SERVER_CART.length) {
            localItems = window.SERVER_CART;
            if (typeof saveCartItems === 'function') {
                saveCartItems(localItems);
            }
        }

        checkoutItems = localItems || [];

        // Sanitize items: ensure item.price is selling price and item.original_price is MRP
        checkoutItems.forEach(item => {
            let p = parseFloat(item.price) || 0;
            let op = parseFloat(item.original_price) || 0;
            if (op > 0 && p > op) {
                item.price = op;
                item.original_price = p;
            }
        });

        if (!checkoutItems || !checkoutItems.length) {
            document.getElementById('checkoutPageFormScreen').style.display = 'none';
            document.getElementById('checkoutPageEmptyScreen').style.display = 'block';
            return;
        }

        document.getElementById('checkoutPageEmptyScreen').style.display = 'none';
        document.getElementById('checkoutPageFormScreen').style.display = 'block';

        checkoutItems.forEach(item => {
            if (item.coupon_code && !checkoutActiveCoupon) {
                checkoutActiveCoupon = item.coupon_code;
            }
        });

        renderCheckoutPageItems();

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
            let unitPrice = parseFloat(item.price) || 0;
            let originalPrice = parseFloat(item.original_price || item.price) || 0;
            if (originalPrice > 0 && unitPrice > originalPrice) {
                const tmp = unitPrice;
                unitPrice = originalPrice;
                originalPrice = tmp;
            }
            const qty = parseInt(item.quantity) || 1;
            const itemTotal = unitPrice * qty;
            const originalTotal = originalPrice * qty;

            // Subtotal is strictly based on the discounted selling price (itemTotal)
            checkoutSubtotal += itemTotal;
            const thumbUrl = item.thumbnail || 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80';
            const badgeBg = item.type === 'Product' ? 'bg-danger-subtle text-danger' : (item.type === 'Service' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary');

            html += `
                <div class="checkout-item-card">
                    <img src="${thumbUrl}" alt="${item.title}" class="checkout-item-thumb">
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class="d-flex align-items-center justify-content-between gap-1 mb-0.5">
                            <span class="checkout-item-badge ${badgeBg}">${item.type || 'Course'}</span>
                            <button type="button" class="checkout-item-remove" onclick="removeCheckoutItem(${idx})" title="Remove item">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <h6 class="checkout-item-title" title="${item.title}">${item.title}</h6>
                        <div class="d-flex align-items-center justify-content-between mt-1.5">
                            <div class="checkout-qty-stepper">
                                <button type="button" class="stepper-btn" onclick="updateItemQuantity(${idx}, -1)">−</button>
                                <span class="stepper-val">${qty}</span>
                                <button type="button" class="stepper-btn" onclick="updateItemQuantity(${idx}, 1)">+</button>
                            </div>
                            <div class="text-end">
                                <span class="checkout-item-price">₹${itemTotal.toLocaleString('en-IN')}</span>
                                ${originalPrice > unitPrice ? `<span class="checkout-item-mrp">₹${originalTotal.toLocaleString('en-IN')}</span>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        if (container) container.innerHTML = html;
        updateTotalsDisplay();
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

                // Seamless transition to single Luxury Applied Card
                document.getElementById('couponInputSection').classList.add('d-none');
                const appliedSec = document.getElementById('couponAppliedSection');
                appliedSec.classList.remove('d-none');

                document.getElementById('pageAppliedCouponCodeText').textContent = data.code;
                document.getElementById('pageAppliedCouponDiscountText').textContent = 'You saved ₹' + checkoutTotalDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2 }) + '!';

                if (alertEl) alertEl.style.display = 'none';

                updateTotalsDisplay();
            } else {
                checkoutActiveCoupon = null;
                checkoutTotalDiscount = 0;
                updateTotalsDisplay();

                if (!silent && alertEl) {
                    alertEl.textContent = data.message || 'Invalid coupon code';
                    alertEl.style.display = 'block';
                }
            }
        } catch (e) {
            if (!silent && alertEl) {
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

        // Switch back to clean input section
        document.getElementById('couponAppliedSection').classList.add('d-none');
        document.getElementById('couponInputSection').classList.remove('d-none');

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
                if (typeof saveCartItems === 'function') saveCartItems([]);

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
                    btn.innerHTML = '<i class="fa-solid fa-lock"></i> <span>Confirm &amp; Place Order</span>';
                }
            }
        } catch (err) {
            console.error('Checkout error:', err);
            alert('A network error occurred while placing your order. Please check your connection and try again.');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock"></i> <span>Confirm &amp; Place Order</span>';
            }
        }
    }
</script>
@endpush
@endsection
