@extends('admin.layouts.admin')

@section('title', ($isEdit ? 'Edit Coupon: ' . ($coupon['code'] ?? '') : 'Create Coupon / Offer') . ' - Super Admin')

@section('styles')
<style>
    /* Styling matching Screenshots 1 & 2 pixel-for-pixel */
    .form-section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
    }
    .form-section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.15rem;
    }

    /* Selectable Coupon Type Cards */
    .coupon-type-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        cursor: pointer;
        transition: all 0.15s ease;
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 0.65rem;
    }
    .coupon-type-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .coupon-type-card.active {
        border: 2px solid #0066ff !important;
        background: #eff6ff !important;
    }
    .type-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .type-icon-blue  { background: #dbeafe; color: #2563eb; }
    .type-icon-green { background: #dcfce7; color: #16a34a; }
    .type-icon-red   { background: #fee2e2; color: #dc2626; }

    /* Category Chips */
    .cat-pill-chip {
        display: inline-block;
        padding: 0.35rem 0.85rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: all 0.15s ease;
        user-select: none;
    }
    .cat-pill-chip:hover {
        background: #e2e8f0;
    }
    .cat-pill-chip.active {
        background: #0066ff !important;
        color: #ffffff !important;
        border-color: #0066ff !important;
    }

    /* Live Voucher Ticket Preview matching Screenshot 1 */
    .preview-voucher-ticket {
        display: flex;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        position: relative;
    }
    .ticket-left {
        flex: 1;
        background: radial-gradient(circle at 80% 30%, #991b1b 0%, #450a0a 100%);
        padding: 1.25rem 1.5rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }
    .ticket-right {
        width: 140px;
        background: #fbbf24;
        padding: 1.25rem 1rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        border-left: 2px dashed #92400e;
    }
    .ticket-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 80px;
        height: 80px;
        background: rgba(251, 191, 36, 0.2);
        filter: blur(25px);
        border-radius: 50%;
    }

    /* Scallop Cutouts on Ticket */
    .ticket-left::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        background: #ffffff;
        border-radius: 50%;
        z-index: 2;
    }
    .ticket-right::after {
        content: '';
        position: absolute;
        right: -8px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        background: #ffffff;
        border-radius: 50%;
        z-index: 2;
    }

    /* Switches */
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.3em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #0066ff;
        border-color: #0066ff;
    }

    /* Image Upload Box */
    .coupon-image-thumb {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        max-width: 160px;
        position: relative;
    }
    .coupon-image-thumb img {
        width: 100%;
        height: 65px;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <form method="POST" action="{{ $isEdit ? route('admin.coupons.update', $coupon['id'] ?? 1) : route('admin.coupons.store') }}" id="couponForm">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <!-- Top Breadcrumb & Action Toolbar matching Screenshot 1 -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <a href="{{ route('admin.coupons.index') }}" class="text-decoration-none text-muted small fw-medium">
                        <i class="fa-solid fa-arrow-left me-1"></i> Coupons & Offers
                    </a>
                    <span class="text-muted small">›</span>
                    <span class="text-dark small fw-semibold">{{ $isEdit ? 'Edit Coupon' : 'Create Coupon' }}</span>
                </div>
                <h4 class="fw-bold text-dark mb-0">{{ $isEdit ? 'Edit Coupon / Offer' : 'Create Coupon / Offer' }}</h4>
                <p class="text-muted small mb-0">Create discount coupons, offers and promotional campaigns for courses, services, products or business listings.</p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-medium">
                    <i class="fa-solid fa-plus me-1"></i> {{ $isEdit ? 'Save Changes' : 'Save Coupon' }}
                </button>
            </div>
        </div>

        <!-- 2-Column Form Layout: Left Column (~60%) + Right Column (~40%) -->
        <div class="row g-4">

            <!-- ================= LEFT COLUMN ================= -->
            <div class="col-12 col-xl-7">

                <!-- 1. Basic Information Card matching Screenshot 1 -->
                <div class="form-section-card">
                    <div class="form-section-title">Basic Information</div>

                    <div class="row g-3">
                        <!-- Left Sub-column: Code, Name, Description -->
                        <div class="col-md-7">
                            <!-- Coupon Code -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark mb-1">Coupon Code *</label>
                                <input type="text" name="coupon_code" id="fldCouponCode" class="form-control form-control-sm text-uppercase font-monospace fw-bold" placeholder="DIWALI50" value="{{ old('coupon_code', $coupon['code'] ?? 'DIWALI50') }}" required oninput="onCodeInput(this.value)">
                                <div class="text-muted" style="font-size: 0.725rem;">Unique code (e.g. DIWALI50). Use uppercase letters.</div>
                            </div>

                            <!-- Offer Name -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark mb-1">Offer Name *</label>
                                <input type="text" name="offer_name" id="fldOfferName" class="form-control form-control-sm" placeholder="Diwali Special Offer" value="{{ old('offer_name', $coupon['name'] ?? 'Diwali Special Offer') }}" required oninput="onNameInput(this.value)">
                                <div class="text-muted" style="font-size: 0.725rem;">Internal name to identify this offer.</div>
                            </div>

                            <!-- Description -->
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-semibold text-dark mb-0">Description</label>
                                    <span class="text-muted" style="font-size: 0.7rem;" id="descCounter">72/200</span>
                                </div>
                                <textarea name="description" id="fldDescription" rows="3" class="form-control form-control-sm" maxlength="200" oninput="document.getElementById('descCounter').innerText = this.value.length + '/200';">{{ old('description', $coupon['description'] ?? 'Get 50% off on all courses and products this Diwali. Limited period offer!') }}</textarea>
                            </div>
                        </div>

                        <!-- Right Sub-column: Coupon Type & Discount Value -->
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold text-dark mb-1">Coupon Type</label>
                            <input type="hidden" name="discount_type" id="fldDiscountType" value="{{ old('discount_type', $coupon['type'] ?? 'Percentage') }}">

                            <!-- 3 Selectable Type Cards matching Screenshot 1 -->
                            <div class="coupon-type-card {{ ($coupon['type'] ?? 'Percentage') === 'Percentage' ? 'active' : '' }}" onclick="selectCouponType('Percentage', this)">
                                <div class="type-icon-box type-icon-blue">
                                    <i class="fa-solid fa-percent"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">Discount Percentage</div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Give discount in percentage</div>
                                </div>
                            </div>

                            <div class="coupon-type-card {{ ($coupon['type'] ?? '') === 'Fixed Amount' ? 'active' : '' }}" onclick="selectCouponType('Fixed Amount', this)">
                                <div class="type-icon-box type-icon-green">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">Fixed Amount Discount</div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Give fixed amount off</div>
                                </div>
                            </div>

                            <div class="coupon-type-card {{ ($coupon['type'] ?? '') === 'Free Shipping' ? 'active' : '' }}" onclick="selectCouponType('Free Shipping', this)">
                                <div class="type-icon-box type-icon-red">
                                    <i class="fa-solid fa-gift"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">Free Shipping / Extra Benefit</div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Special offer (e.g. free shipping)</div>
                                </div>
                            </div>

                            <!-- Discount Value -->
                            <div class="mt-2">
                                <label class="form-label small fw-semibold text-dark mb-1">Discount Value *</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="any" name="discount_value" id="fldDiscountValue" class="form-control" placeholder="50" value="{{ old('discount_value', $coupon['discount'] ?? '50') }}" required oninput="onDiscountInput(this.value)">
                                    <span class="input-group-text bg-light text-muted fw-bold" id="discountAddon">%</span>
                                </div>
                                <div class="text-muted" style="font-size: 0.725rem;">Enter discount percentage (e.g. 10, 20, 50)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Applicable Settings Card matching Screenshot 1 -->
                <div class="form-section-card">
                    <div class="form-section-title">Applicable Settings</div>

                    <div class="row g-3">
                        <!-- Left: Applicable On (Platforms Radio Buttons) -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-2">Applicable On *</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="applicable_on" id="appOnAll" value="All Platforms" {{ ($coupon['applicable_on'] ?? 'All Platforms') === 'All Platforms' ? 'checked' : '' }} onchange="onPlatformChange(this.value)">
                                    <label class="form-check-label small text-dark" for="appOnAll">
                                        All Platforms (Website + Android App + iOS App)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="applicable_on" id="appOnWeb" value="Website Only" {{ ($coupon['applicable_on'] ?? '') === 'Website Only' ? 'checked' : '' }} onchange="onPlatformChange(this.value)">
                                    <label class="form-check-label small text-dark" for="appOnWeb">
                                        Website Only
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="applicable_on" id="appOnAndroid" value="Android App Only" {{ ($coupon['applicable_on'] ?? '') === 'Android App Only' ? 'checked' : '' }} onchange="onPlatformChange(this.value)">
                                    <label class="form-check-label small text-dark" for="appOnAndroid">
                                        Android App Only
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="applicable_on" id="appOnIos" value="iOS App Only" {{ ($coupon['applicable_on'] ?? '') === 'iOS App Only' ? 'checked' : '' }} onchange="onPlatformChange(this.value)">
                                    <label class="form-check-label small text-dark" for="appOnIos">
                                        iOS App Only
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Applicable Categories (Chips) + Specific Items -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-2">Applicable Categories *</label>
                            <input type="hidden" name="categories" id="fldCategories" value="All">
                            <div class="d-flex flex-wrap gap-1.5 mb-3" id="categoriesChipsGroup">
                                <span class="cat-pill-chip active" onclick="toggleCategoryChip('All', this)">All</span>
                                <span class="cat-pill-chip" onclick="toggleCategoryChip('Courses', this)">Courses</span>
                                <span class="cat-pill-chip" onclick="toggleCategoryChip('Services', this)">Services</span>
                                <span class="cat-pill-chip" onclick="toggleCategoryChip('Products', this)">Products</span>
                                <span class="cat-pill-chip" onclick="toggleCategoryChip('Business Listings', this)">Business Listings</span>
                            </div>

                            <!-- Specific Items Search + Browse -->
                            <div>
                                <label class="form-label small fw-semibold text-dark mb-1">Specific Items (Optional)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" name="specific_items" class="form-control border-start-0 ps-0" placeholder="Search and select specific items...">
                                    <button class="btn btn-outline-secondary px-3" type="button" onclick="alert('Item selector browser popup opened.');">Browse</button>
                                </div>
                                <div class="text-muted mt-1" style="font-size: 0.725rem;">Leave empty to apply on all items in selected categories.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Usage & Limits Card matching Screenshot 2 -->
                <div class="form-section-card">
                    <div class="form-section-title">Usage & Limits</div>

                    <div class="row g-3 mb-3">
                        <!-- Usage Limit -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Usage Limit <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="number" name="usage_limit" id="fldUsageLimit" class="form-control form-control-sm" placeholder="1000" value="{{ old('usage_limit', $coupon['usage_limit'] ?? 1000) }}">
                            <div class="text-muted" style="font-size: 0.725rem;">Total number of times this coupon can be used.</div>
                        </div>

                        <!-- Per User Limit -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Per User Limit <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="number" name="per_user_limit" class="form-control form-control-sm" placeholder="1" value="{{ old('per_user_limit', $coupon['per_user_limit'] ?? 1) }}">
                            <div class="text-muted" style="font-size: 0.725rem;">How many times a single user can use this coupon.</div>
                        </div>

                        <!-- Minimum Order Value -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Minimum Order Value <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted">₹</span>
                                <input type="number" name="min_order_value" class="form-control" placeholder="500" value="{{ old('min_order_value', $coupon['min_order'] ?? 500) }}">
                            </div>
                            <div class="text-muted" style="font-size: 0.725rem;">Minimum cart value to apply this coupon.</div>
                        </div>

                        <!-- Maximum Discount -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Maximum Discount <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted">₹</span>
                                <input type="number" name="max_discount" class="form-control" placeholder="2000" value="{{ old('max_discount', $coupon['max_discount'] ?? 2000) }}">
                            </div>
                            <div class="text-muted" style="font-size: 0.725rem;">Maximum discount amount per order.</div>
                        </div>
                    </div>

                    <!-- Terms & Conditions Textarea -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Terms & Conditions <span class="text-muted fw-normal">(Optional)</span></label>
                            <span class="text-muted" style="font-size: 0.7rem;" id="termsCounter">258/500</span>
                        </div>
                        <textarea name="terms_conditions" id="fldTerms" rows="6" class="form-control form-control-sm font-monospace" style="font-size: 0.75rem;" maxlength="500" oninput="document.getElementById('termsCounter').innerText = this.value.length + '/500';">{{ old('terms_conditions', $coupon['terms'] ?? "• This offer is valid from 1 Oct to 15 Nov 2026.\n• Applicable on all courses and products.\n• Minimum order value ₹500.\n• Maximum discount ₹2,000.\n• Cannot be combined with other offers.\n• Digital Class reserves the right to modify or cancel this offer at any time.") }}</textarea>
                    </div>
                </div>

            </div>

            <!-- ================= RIGHT COLUMN ================= -->
            <div class="col-12 col-xl-5">

                <!-- 1. Coupon Preview Card matching Screenshot 1 -->
                <div class="form-section-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-section-title mb-0">Coupon Preview</div>
                        <a href="#" class="small text-primary text-decoration-none fw-semibold" style="font-size: 0.75rem;" onclick="cycleTemplate(); return false;">
                            <i class="fa-solid fa-shapes me-1"></i> Change Template
                        </a>
                    </div>

                    <!-- Landscape Ticket Voucher Preview matching Screenshot 1 -->
                    <div class="preview-voucher-ticket mb-3" id="liveVoucherTicket">
                        <!-- Left Festive Red Gradient Section -->
                        <div class="ticket-left">
                            <div class="ticket-glow"></div>
                            <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 1;">
                                <!-- Diya Lamp / Festive Icon -->
                                <div class="text-warning fs-1" style="filter: drop-shadow(0 2px 8px rgba(245, 158, 11, 0.6));">
                                    <i class="fa-solid fa-fire-burner"></i>
                                </div>
                                <div>
                                    <span class="badge bg-warning text-dark fw-bold px-2 py-0.5 rounded-pill mb-1" style="font-size: 0.62rem;" id="prvTagline">
                                        SPECIAL OFFER
                                    </span>
                                    <div class="fw-bold font-monospace text-white" style="font-size: 1.35rem; line-height: 1.1; letter-spacing: 0.5px;" id="prvCode">
                                        DIWALI50
                                    </div>
                                    <div class="fw-bold" style="color: #fde047; font-size: 0.85rem;" id="prvOfferHead">
                                        Get 50% OFF
                                    </div>
                                    <div class="text-white-50" style="font-size: 0.65rem;" id="prvScope">
                                        on All Courses & Products
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Gold Section with Code Pill -->
                        <div class="ticket-right">
                            <div class="fw-black text-dark" style="font-size: 1.6rem; font-weight: 900; line-height: 0.95;" id="prvRightDiscount">
                                50%
                            </div>
                            <div class="fw-bold text-dark mb-1.5" style="font-size: 0.75rem;">OFF</div>
                            <div class="text-muted" style="font-size: 0.55rem; text-transform: uppercase;">Use Code</div>
                            <div class="bg-dark text-warning font-monospace fw-bold px-2 py-0.5 rounded-pill text-truncate" style="font-size: 0.65rem; max-width: 100px;" id="prvRightCode">
                                DIWALI50
                            </div>
                        </div>
                    </div>

                    <!-- Short Link Input with Copy button matching Screenshot 1 -->
                    <div>
                        <label class="form-label text-muted small mb-1" style="font-size: 0.75rem;">Short Link</label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="shortLinkInput" class="form-control text-muted" value="https://digitalclass.in/coupon/DIWALI50" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyShortLink()">
                                <i class="fa-regular fa-copy me-1"></i> Copy
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. Campaign & Schedule Card matching Screenshot 1 -->
                <div class="form-section-card">
                    <div class="form-section-title">Campaign & Schedule</div>

                    <!-- Campaign Dropdown + Create New -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Campaign <span class="text-muted fw-normal">(Optional)</span></label>
                        <div class="d-flex align-items-center gap-2">
                            <select name="campaign" class="form-select form-select-sm">
                                <option value="Diwali 2026" {{ ($coupon['campaign'] ?? '') === 'Diwali 2026' ? 'selected' : '' }}>Diwali 2026</option>
                                <option value="New User Welcome">New User Welcome</option>
                                <option value="Student Special">Student Special</option>
                                <option value="Seller Offer">Seller Offer</option>
                                <option value="Freelancer">Freelancer</option>
                                <option value="Mega Festival">Mega Festival</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none fw-semibold p-0" style="white-space: nowrap; font-size: 0.75rem;" onclick="prompt('Enter new campaign name:');">
                                + Create New
                            </button>
                        </div>
                    </div>

                    <!-- Dates & Times + Toggles Layout matching Screenshot 1 & 2 -->
                    <div class="row g-3">
                        <!-- Dates Column -->
                        <div class="col-md-7">
                            <!-- Start Date & Time -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark mb-1">Start Date & Time *</label>
                                <div class="row g-1">
                                    <div class="col-7">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-transparent border-end-0 text-muted p-1"><i class="fa-regular fa-calendar" style="font-size:0.75rem;"></i></span>
                                            <input type="date" name="start_date" class="form-control border-start-0 ps-0" value="{{ $coupon['start_date'] ?? '2026-10-01' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-transparent border-end-0 text-muted p-1"><i class="fa-regular fa-clock" style="font-size:0.75rem;"></i></span>
                                            <input type="time" name="start_time" class="form-control border-start-0 ps-0" value="{{ $coupon['start_time'] ?? '00:00' }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Date & Time -->
                            <div>
                                <label class="form-label small fw-semibold text-dark mb-1">End Date & Time *</label>
                                <div class="row g-1">
                                    <div class="col-7">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-transparent border-end-0 text-muted p-1"><i class="fa-regular fa-calendar" style="font-size:0.75rem;"></i></span>
                                            <input type="date" name="end_date" class="form-control border-start-0 ps-0" value="{{ $coupon['end_date'] ?? '2026-11-15' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-transparent border-end-0 text-muted p-1"><i class="fa-regular fa-clock" style="font-size:0.75rem;"></i></span>
                                            <input type="time" name="end_time" class="form-control border-start-0 ps-0" value="{{ $coupon['end_time'] ?? '23:59' }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3 Toggles Column matching Screenshot 1 & 2 -->
                        <div class="col-md-5 d-flex flex-column justify-content-between">
                            <!-- Toggle 1: Schedule for Later -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div>
                                    <div class="small fw-semibold text-dark" style="font-size: 0.78rem;">
                                        <i class="fa-regular fa-clock text-primary me-1"></i> Schedule for Later
                                    </div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="schedule_later" id="switchSchedule" {{ !empty($coupon['schedule_later']) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Toggle 2: Show in Public -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div>
                                    <div class="small fw-semibold text-dark" style="font-size: 0.78rem;">
                                        <i class="fa-regular fa-eye text-primary me-1"></i> Show in Public
                                    </div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Visible on website & app</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="show_in_public" id="switchPublic" {{ !empty($coupon['show_public']) ? 'checked' : '' }} checked>
                                </div>
                            </div>

                            <!-- Toggle 3: Featured Offer -->
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="small fw-semibold text-dark" style="font-size: 0.78rem;">
                                        <i class="fa-regular fa-star text-primary me-1"></i> Featured Offer
                                    </div>
                                    <div class="text-muted" style="font-size: 0.65rem;">Show in banner section</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="switchFeatured" {{ !empty($coupon['featured']) ? 'checked' : '' }} checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Additional Options Card matching Screenshot 2 -->
                <div class="form-section-card">
                    <div class="form-section-title">Additional Options</div>

                    <div class="row g-3">
                        <!-- Left Checkboxes -->
                        <div class="col-md-7">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="allow_with_others" id="optAllowOthers">
                                <label class="form-check-label small text-dark" for="optAllowOthers">
                                    <span class="fw-semibold">Allow with other coupons</span>
                                    <div class="text-muted" style="font-size: 0.68rem;">Can be combined with other coupons.</div>
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="for_new_users_only" id="optNewUsers" {{ !empty($coupon['for_new_users']) ? 'checked' : '' }} checked>
                                <label class="form-check-label small text-dark" for="optNewUsers">
                                    <span class="fw-semibold">For new users only</span>
                                    <div class="text-muted" style="font-size: 0.68rem;">Applicable only for new customers.</div>
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="auto_apply" id="optAutoApply">
                                <label class="form-check-label small text-dark" for="optAutoApply">
                                    <span class="fw-semibold">Auto apply this coupon</span>
                                    <div class="text-muted" style="font-size: 0.68rem;">Automatically apply on eligible orders.</div>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_notifications" id="optSendNotif" {{ !empty($coupon['send_notif']) ? 'checked' : '' }} checked>
                                <label class="form-check-label small text-dark" for="optSendNotif">
                                    <span class="fw-semibold">Send notification to users</span>
                                    <div class="text-muted" style="font-size: 0.68rem;">Send email/app notification about this offer.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Right: Coupon Image Upload -->
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold text-dark mb-1">Coupon Image <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="coupon-image-thumb mb-1">
                                <img id="couponImgPreview" src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&auto=format&fit=crop&q=80" alt="Coupon banner">
                            </div>
                            <div class="text-muted mb-2" style="font-size: 0.68rem;">Recommended size: 1200 x 400 px</div>
                            <button type="button" class="btn btn-outline-secondary btn-sm w-100" style="font-size: 0.75rem;" onclick="document.getElementById('hiddenFileInput').click();">
                                <i class="fa-solid fa-arrow-up-from-bracket me-1"></i> Upload Image
                            </button>
                            <input type="file" id="hiddenFileInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection

@section('scripts')
<script>
    let currentDiscountType = '{{ $coupon['type'] ?? 'Percentage' }}';
    let currentTemplateIndex = 0;

    const templates = [
        {
            leftBg: 'radial-gradient(circle at 80% 30%, #991b1b 0%, #450a0a 100%)',
            rightBg: '#fbbf24',
            dashed: '#92400e',
            textColor: '#fde047',
        },
        {
            leftBg: 'linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%)',
            rightBg: '#38bdf8',
            dashed: '#0369a1',
            textColor: '#38bdf8',
        },
        {
            leftBg: 'linear-gradient(135deg, #065f46 0%, #022c22 100%)',
            rightBg: '#34d399',
            dashed: '#047857',
            textColor: '#6ee7b7',
        },
        {
            leftBg: 'linear-gradient(135deg, #701a75 0%, #2e1065 100%)',
            rightBg: '#f472b6',
            dashed: '#be185d',
            textColor: '#fbcfe8',
        }
    ];

    function selectCouponType(type, cardElement) {
        currentDiscountType = type;
        document.getElementById('fldDiscountType').value = type;

        // Highlight selected card
        document.querySelectorAll('.coupon-type-card').forEach(c => c.classList.remove('active'));
        if (cardElement) {
            cardElement.classList.add('active');
        }

        // Update Addon text
        const addon = document.getElementById('discountAddon');
        const val = document.getElementById('fldDiscountValue').value || '50';
        if (type === 'Percentage') {
            addon.innerText = '%';
            document.getElementById('prvRightDiscount').innerText = `${val}%`;
            document.getElementById('prvOfferHead').innerText = `Get ${val}% OFF`;
        } else if (type === 'Fixed Amount') {
            addon.innerText = '₹';
            document.getElementById('prvRightDiscount').innerText = `₹${val}`;
            document.getElementById('prvOfferHead').innerText = `Flat ₹${val} OFF`;
        } else {
            addon.innerText = 'FREE';
            document.getElementById('prvRightDiscount').innerText = `FREE`;
            document.getElementById('prvOfferHead').innerText = `Free Shipping Benefit`;
        }
    }

    function onCodeInput(val) {
        val = (val || 'DIWALI50').toUpperCase();
        document.getElementById('prvCode').innerText = val;
        document.getElementById('prvRightCode').innerText = val;
        document.getElementById('shortLinkInput').value = `https://digitalclass.in/coupon/${val}`;
    }

    function onNameInput(val) {
        val = val || 'Special Offer';
        document.getElementById('prvTagline').innerText = val.toUpperCase();
    }

    function onDiscountInput(val) {
        val = val || '0';
        if (currentDiscountType === 'Percentage') {
            document.getElementById('prvRightDiscount').innerText = `${val}%`;
            document.getElementById('prvOfferHead').innerText = `Get ${val}% OFF`;
        } else {
            document.getElementById('prvRightDiscount').innerText = `₹${val}`;
            document.getElementById('prvOfferHead').innerText = `Flat ₹${val} OFF`;
        }
    }

    function toggleCategoryChip(category, chipElement) {
        const chips = document.querySelectorAll('#categoriesChipsGroup .cat-pill-chip');
        if (category === 'All') {
            chips.forEach(c => c.classList.remove('active'));
            chipElement.classList.add('active');
            document.getElementById('fldCategories').value = 'All';
            document.getElementById('prvScope').innerText = 'on All Courses & Products';
            return;
        }

        document.querySelector('#categoriesChipsGroup .cat-pill-chip:first-child').classList.remove('active');
        chipElement.classList.toggle('active');

        const activeChips = Array.from(chips).filter(c => c.classList.contains('active')).map(c => c.innerText);
        if (activeChips.length === 0) {
            chips[0].classList.add('active');
            document.getElementById('fldCategories').value = 'All';
            document.getElementById('prvScope').innerText = 'on All Courses & Products';
        } else {
            document.getElementById('fldCategories').value = activeChips.join(',');
            document.getElementById('prvScope').innerText = `on ${activeChips.join(', ')}`;
        }
    }

    function onPlatformChange(val) {
        // updates platform preview if necessary
    }

    function copyShortLink() {
        const link = document.getElementById('shortLinkInput').value;
        navigator.clipboard.writeText(link).then(() => {
            alert('Short link copied to clipboard: ' + link);
        }).catch(() => {
            prompt('Copy link:', link);
        });
    }

    function cycleTemplate() {
        currentTemplateIndex = (currentTemplateIndex + 1) % templates.length;
        const t = templates[currentTemplateIndex];
        const tLeft = document.querySelector('.ticket-left');
        const tRight = document.querySelector('.ticket-right');
        if (tLeft) tLeft.style.background = t.leftBg;
        if (tRight) {
            tRight.style.background = t.rightBg;
            tRight.style.borderLeftColor = t.dashed;
        }
        document.getElementById('prvOfferHead').style.color = t.textColor;
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('couponImgPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
