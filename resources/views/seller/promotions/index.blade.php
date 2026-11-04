@extends('seller.layouts.seller')

@section('title', 'Promotions & Marketing - Seller Dashboard')

@section('styles')
<style>
    /* Metric Cards */
    .promo-kpi-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem 1.4rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    .promo-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    }
    .promo-kpi-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Tabs Bar */
    .promo-nav-tabs {
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        gap: 2rem;
        margin-bottom: 1.75rem;
    }
    .promo-nav-tab {
        padding: 0.75rem 0.25rem;
        font-weight: 600;
        font-size: 0.925rem;
        color: #64748b;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    .promo-nav-tab:hover {
        color: #0066ff;
    }
    .promo-nav-tab.active {
        color: #0066ff;
        border-bottom-color: #0066ff;
    }

    /* Step Selector Cards */
    .selection-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .selection-card:hover {
        border-color: #93c5fd;
        background: #f8fafc;
    }
    .selection-card.selected {
        border-color: #0066ff;
        background: #eff6ff;
        box-shadow: 0 0 0 1px #0066ff;
    }
    .selection-card input[type="radio"] {
        display: none;
    }
    .selection-radio-dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        margin: 0.5rem auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .selection-card.selected .selection-radio-dot {
        border-color: #0066ff;
        background: #0066ff;
    }
    .selection-card.selected .selection-radio-dot::after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #ffffff;
    }

    /* Live Preview Banner Graphic */
    .promo-preview-banner {
        background: linear-gradient(135deg, #4338ca 0%, #312e81 50%, #1e1b4b 100%);
        border-radius: 16px;
        color: #ffffff;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(67, 56, 202, 0.35);
    }
    .promo-preview-banner::after {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(238, 242, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .social-creative-thumb {
        background: #1e1b4b;
        border-radius: 12px;
        padding: 0.75rem;
        text-align: center;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: transform 0.2s;
    }
    .social-creative-thumb:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Promotions</h1>
            <p class="text-secondary small mb-0">Boost your visibility and get more customers. Create offers, discounts and featured promotions for your listings.</p>
        </div>
    </div>

    <!-- 4 KPI Performance Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Active Promotions -->
        <div class="col-xl-3 col-sm-6">
            <div class="promo-kpi-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold">Active Promotions</div>
                    <div class="d-flex align-items-baseline gap-2 mt-1">
                        <h3 class="fw-bold text-dark mb-0">{{ $kpis['active_promotions'] }}</h3>
                        <span class="badge bg-success-subtle text-success small fw-bold">↑ 25%</span>
                    </div>
                    <div class="text-muted small mt-1" style="font-size: 0.725rem;">{{ $kpis['ending_this_week'] }} ending this week</div>
                </div>
                <div class="promo-kpi-icon-wrap" style="background: rgba(0, 102, 255, 0.1); color: #0066ff;">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
            </div>
        </div>

        <!-- 2. Total Views (Promoted) -->
        <div class="col-xl-3 col-sm-6">
            <div class="promo-kpi-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold">Total Views (Promoted)</div>
                    <div class="d-flex align-items-baseline gap-2 mt-1">
                        <h3 class="fw-bold text-dark mb-0">{{ $kpis['total_views'] }}</h3>
                        <span class="badge bg-success-subtle text-success small fw-bold">↑ 68%</span>
                    </div>
                    <div class="text-muted small mt-1" style="font-size: 0.725rem;">{{ $kpis['views_growth'] }}</div>
                </div>
                <div class="promo-kpi-icon-wrap" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fa-regular fa-eye"></i>
                </div>
            </div>
        </div>

        <!-- 3. Sales from Promotions -->
        <div class="col-xl-3 col-sm-6">
            <div class="promo-kpi-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold">Sales from Promotions</div>
                    <div class="d-flex align-items-baseline gap-2 mt-1">
                        <h3 class="fw-bold text-dark mb-0">{{ $kpis['sales_amount'] }}</h3>
                        <span class="badge bg-success-subtle text-success small fw-bold">↑ 42%</span>
                    </div>
                    <div class="text-muted small mt-1" style="font-size: 0.725rem;">{{ $kpis['orders_count'] }} orders this month</div>
                </div>
                <div class="promo-kpi-icon-wrap" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
        </div>

        <!-- 4. New Customers -->
        <div class="col-xl-3 col-sm-6">
            <div class="promo-kpi-card d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold">New Customers</div>
                    <div class="d-flex align-items-baseline gap-2 mt-1">
                        <h3 class="fw-bold text-dark mb-0">{{ $kpis['new_customers'] }}</h3>
                        <span class="badge bg-success-subtle text-success small fw-bold">↑ 32%</span>
                    </div>
                    <div class="text-muted small mt-1" style="font-size: 0.725rem;">From promotional campaigns</div>
                </div>
                <div class="promo-kpi-icon-wrap" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="promo-nav-tabs">
        <a href="{{ route('seller.promotions.index', ['tab' => 'create']) }}" 
           class="promo-nav-tab {{ $currentTab === 'create' ? 'active' : '' }}">
            <i class="fa-solid fa-bullhorn"></i> Create Promotion
        </a>
        <a href="{{ route('seller.promotions.index', ['tab' => 'my-promotions']) }}" 
           class="promo-nav-tab {{ $currentTab === 'my-promotions' ? 'active' : '' }}">
            <i class="fa-regular fa-star"></i> My Promotions
        </a>
        <a href="{{ route('seller.promotions.index', ['tab' => 'coupons']) }}" 
           class="promo-nav-tab {{ $currentTab === 'coupons' ? 'active' : '' }}">
            <i class="fa-solid fa-ticket"></i> Discount Coupons
        </a>
        <a href="{{ route('seller.promotions.index', ['tab' => 'banners']) }}" 
           class="promo-nav-tab {{ $currentTab === 'banners' ? 'active' : '' }}">
            <i class="fa-regular fa-images"></i> Banners & Creatives
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- TAB 1: CREATE PROMOTION WIZARD & LIVE PREVIEW -->
    @if($currentTab === 'create')
    <div class="row g-4">
        <!-- LEFT: 4-Step Promotion Setup Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <form action="{{ route('seller.promotions.store') }}" method="POST" id="promotionForm">
                    @csrf

                    <!-- 1. Select What You Want to Promote -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">1. Select What You Want to Promote</h5>
                        </div>
                        <p class="text-secondary small mb-3">Choose the listing type and content you want to promote.</p>

                        <div class="row g-2">
                            <!-- Course -->
                            <div class="col-6 col-sm-3">
                                <div class="selection-card selected" onclick="selectListingType(this, 'Course')">
                                    <div>
                                        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                                            <i class="fa-solid fa-video"></i>
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Course</div>
                                        <div class="text-muted" style="font-size: 0.7rem; line-height: 1.2;">Promote your online course or batch</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Service -->
                            <div class="col-6 col-sm-3">
                                <div class="selection-card" onclick="selectListingType(this, 'Service')">
                                    <div>
                                        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(0, 102, 255, 0.1); color: #0066ff;">
                                            <i class="fa-solid fa-briefcase"></i>
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Service</div>
                                        <div class="text-muted" style="font-size: 0.7rem; line-height: 1.2;">Promote your freelance service</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Product -->
                            <div class="col-6 col-sm-3">
                                <div class="selection-card" onclick="selectListingType(this, 'Product')">
                                    <div>
                                        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Product</div>
                                        <div class="text-muted" style="font-size: 0.7rem; line-height: 1.2;">Promote your physical product</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Business Listing -->
                            <div class="col-6 col-sm-3">
                                <div class="selection-card" onclick="selectListingType(this, 'Business Listing')">
                                    <div>
                                        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                                            <i class="fa-solid fa-building"></i>
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Business Listing</div>
                                        <div class="text-muted" style="font-size: 0.7rem; line-height: 1.2;">Promote your business profile</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="listing_type" id="hiddenListingType" value="Course">
                    </div>

                    <!-- 2. Choose Promotion Type & Charges (1000, 1500, 2000, 2500) -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">2. Choose Promotion Type</h5>
                        </div>
                        <p class="text-secondary small mb-3">Select how you want to promote your listing across the marketplace.</p>

                        <div class="row g-2">
                            <!-- Featured Listing (1000) -->
                            <div class="col-md-4 col-sm-6">
                                <div class="selection-card" onclick="selectPromoType(this, 'Featured Listing', 1000)">
                                    <div>
                                        <div class="text-warning fs-5 mb-1">👑</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Featured Listing</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Show at top in search & category pages</div>
                                        <div class="badge bg-primary-subtle text-primary mt-2 fw-bold">₹1,000</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Banner Promotion (1500 - DEFAULT) -->
                            <div class="col-md-4 col-sm-6">
                                <div class="selection-card selected" onclick="selectPromoType(this, 'Banner Promotion', 1500)">
                                    <div>
                                        <div class="text-primary fs-5 mb-1">🖼️</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Banner Promotion</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Show on home page top banners</div>
                                        <div class="badge bg-primary text-white mt-2 fw-bold">₹1,500</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Discount Offer (1000) -->
                            <div class="col-md-4 col-sm-6">
                                <div class="selection-card" onclick="selectPromoType(this, 'Discount Offer', 1000)">
                                    <div>
                                        <div class="text-danger fs-5 mb-1">🏷️</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Discount Offer</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Create limited time flash sale push</div>
                                        <div class="badge bg-primary-subtle text-primary mt-2 fw-bold">₹1,000</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Social Media Kit (2000) -->
                            <div class="col-md-6 col-sm-6">
                                <div class="selection-card" onclick="selectPromoType(this, 'Social Media Kit', 2000)">
                                    <div>
                                        <div class="text-info fs-5 mb-1">🔗</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Social Media Kit</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Get ready-to-share post & story creatives for WhatsApp & Instagram</div>
                                        <div class="badge bg-primary-subtle text-primary mt-2 fw-bold">₹2,000</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>

                            <!-- Email Campaign (2500) -->
                            <div class="col-md-6 col-sm-6">
                                <div class="selection-card" onclick="selectPromoType(this, 'Email Campaign', 2500)">
                                    <div>
                                        <div class="text-success fs-5 mb-1">✉️</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Email Campaign</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Featured placement in weekly marketplace newsletter (50,000+ buyers)</div>
                                        <div class="badge bg-primary-subtle text-primary mt-2 fw-bold">₹2,500</div>
                                    </div>
                                    <div class="selection-radio-dot"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="promotion_type" id="hiddenPromoType" value="Banner Promotion">
                        <input type="hidden" name="charge_amount" id="hiddenChargeAmount" value="1500">
                    </div>

                    <!-- 3. Select Your Listing -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">3. Select Your Listing</h5>
                        </div>
                        <p class="text-secondary small mb-2">Choose which course, service, product or business you want to promote.</p>

                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <img src="https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?auto=format&fit=crop&w=60&q=80" 
                                     id="selectedListingThumb" class="rounded" style="width: 28px; height: 28px; object-fit: cover;">
                            </span>
                            <select class="form-select border-start-0 py-2.5" id="listingSelect" onchange="onListingChange(this)">
                                <option value="Complete Digital Marketing Course" data-price="2999" data-type="Course" selected>
                                    Complete Digital Marketing Course — Course (₹2,999)
                                </option>
                                <option value="Python for Beginners & Data Science" data-price="3499" data-type="Course">
                                    Python for Beginners & Data Science — Course (₹3,499)
                                </option>
                                <option value="Website Development Service" data-price="15000" data-type="Service">
                                    Website Development Service — Service (₹15,000)
                                </option>
                                <option value="Logo Design Standard Package" data-price="2500" data-type="Service">
                                    Logo Design Standard Package — Service (₹2,500)
                                </option>
                                <option value="Wireless Mouse Logitech M330" data-price="499" data-type="Product">
                                    Logitech M330 Wireless Mouse — Product (₹499)
                                </option>
                                <option value="VCEC - Vinayak Computer Education Center" data-price="1499" data-type="Business Listing">
                                    VCEC - Vinayak Computer Education Center — Business Listing (₹1,499)
                                </option>
                            </select>
                        </div>
                        <input type="hidden" name="listing_title" id="hiddenListingTitle" value="Complete Digital Marketing Course">
                        <input type="hidden" name="original_price" id="hiddenOriginalPrice" value="2999">
                    </div>

                    <!-- 4. Set Promotion Details -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">4. Set Promotion Details</h5>
                        </div>
                        <p class="text-secondary small mb-3">Configure your promotion duration, offer and budget.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Promotion Duration</label>
                                <select name="duration_days" class="form-select" id="durationSelect" onchange="updateSummary()">
                                    <option value="7">7 Days Campaign</option>
                                    <option value="14" selected>14 Days Campaign (Recommended)</option>
                                    <option value="30">30 Days Campaign (Maximum Visibility)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Discount Offer %</label>
                                <div class="input-group">
                                    <input type="number" name="discount_pct" id="discountInput" class="form-control" 
                                           value="20" min="0" max="90" oninput="updateSummary()">
                                    <span class="input-group-text bg-light">% OFF</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary Card -->
                        <div class="bg-light rounded-3 p-3 mt-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-2 small">
                                <span class="text-secondary">Selected Marketing Package:</span>
                                <span class="fw-bold text-dark" id="summaryPromoType">Banner Promotion</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 small">
                                <span class="text-secondary">Promotional Offer Price:</span>
                                <div>
                                    <span class="text-muted text-decoration-line-through me-1" id="summaryOrigPrice">₹2,999</span>
                                    <span class="fw-bold text-success" id="summaryOfferPrice">₹2,399</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="fw-bold text-dark">Platform Marketing Charge:</span>
                                <span class="h5 fw-bold text-primary mb-0" id="summaryTotalCharge">₹1,500</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" id="submitPromoBtn">
                        <i class="fa-solid fa-rocket"></i>
                        <span>Launch Promotion &bull; Pay ₹1,500</span>
                    </button>
                    <p class="text-center text-muted small mt-2 mb-0" style="font-size: 0.725rem;">
                        Instant activation on marketplace homepage and category streams upon confirmation.
                    </p>
                </form>
            </div>
        </div>

        <!-- RIGHT: Live Banner Preview & Social Media Creatives -->
        <div class="col-lg-5">
            <!-- 1. Preview Promotion Card -->
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0">Preview Promotion</h6>
                    <a href="#" class="small text-primary text-decoration-none fw-semibold" onclick="alert('Template switcher: Choose from Purple Indigo, Modern Dark, or Bright Cyan.'); return false;">Change Template</a>
                </div>

                <!-- Banner Preview Container matching screenshot -->
                <div class="promo-preview-banner">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill" id="previewDiscountBadge">20% OFF</span>
                        <div class="d-flex gap-1" style="font-size: 0.85rem;">
                            <i class="fa-brands fa-google text-warning"></i>
                            <i class="fa-brands fa-meta text-info"></i>
                            <i class="fa-solid fa-magnifying-glass-chart text-success"></i>
                        </div>
                    </div>

                    <h5 class="fw-bold text-white mb-2" id="previewTitle" style="line-height: 1.25;">
                        Complete Digital Marketing Course
                    </h5>

                    <ul class="list-unstyled small mb-3 text-white-50" style="font-size: 0.775rem; line-height: 1.5;">
                        <li><i class="fa-solid fa-check text-success me-1"></i> Live + Recorded Classes</li>
                        <li><i class="fa-solid fa-check text-success me-1"></i> Practical Projects & Case Studies</li>
                        <li><i class="fa-solid fa-check text-success me-1"></i> Certificate Provided</li>
                        <li><i class="fa-solid fa-check text-success me-1"></i> Job Assistance & Mentorship</li>
                    </ul>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-10">
                        <div>
                            <span class="text-white-50 text-decoration-line-through small me-1" id="previewOrigPrice">₹2,999</span>
                            <span class="h5 fw-bold text-warning mb-0" id="previewOfferPrice">₹2,399</span>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm fw-bold px-3 py-1 rounded-pill text-dark shadow-sm">
                            Enroll Now &rarr;
                        </button>
                    </div>
                </div>
            </div>

            <!-- 2. Social Media Creatives -->
            <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0">Social Media Creatives</h6>
                    <a href="#" class="small text-primary text-decoration-none fw-semibold" onclick="alert('Downloading social post pack (Zip: Instagram Post, Story, WhatsApp Status)...'); return false;">Download All</a>
                </div>

                <div class="row g-2">
                    <!-- Instagram Post (1080x1080) -->
                    <div class="col-4">
                        <div class="social-creative-thumb">
                            <div class="badge bg-warning text-dark" style="font-size: 0.6rem;">20% OFF</div>
                            <div class="fw-bold mt-1 text-truncate" style="font-size: 0.7rem;">Digital Marketing</div>
                            <div class="text-warning fw-bold mt-1" style="font-size: 0.65rem;">₹2,399</div>
                            <div class="text-white-50 mt-2" style="font-size: 0.6rem;">Instagram Post<br>1080 × 1080</div>
                        </div>
                    </div>

                    <!-- Instagram Story (1080x1920) -->
                    <div class="col-4">
                        <div class="social-creative-thumb">
                            <div class="badge bg-warning text-dark" style="font-size: 0.6rem;">20% OFF</div>
                            <div class="fw-bold mt-1 text-truncate" style="font-size: 0.7rem;">Story Template</div>
                            <div class="text-info mt-1" style="font-size: 0.65rem;">Swipe Up</div>
                            <div class="text-white-50 mt-2" style="font-size: 0.6rem;">Instagram Story<br>1080 × 1920</div>
                        </div>
                    </div>

                    <!-- WhatsApp Share -->
                    <div class="col-4">
                        <div class="social-creative-thumb">
                            <div class="badge bg-success text-white" style="font-size: 0.6rem;">WhatsApp</div>
                            <div class="fw-bold mt-1 text-truncate" style="font-size: 0.7rem;">Learn Skills</div>
                            <div class="text-warning mt-1" style="font-size: 0.65rem;">From Experts</div>
                            <div class="text-white-50 mt-2" style="font-size: 0.6rem;">WhatsApp Share<br>1080 × 1080</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Estimated Results -->
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-light">
                <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;">Estimated Results for this Campaign</h6>
                <div class="d-flex justify-content-between align-items-center mb-1 small">
                    <span class="text-secondary"><i class="fa-regular fa-eye me-1 text-primary"></i> Estimated Impressions:</span>
                    <span class="fw-bold text-dark">15,000 – 25,000 Views</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1 small">
                    <span class="text-secondary"><i class="fa-solid fa-arrow-pointer me-1 text-success"></i> Expected Clicks:</span>
                    <span class="fw-bold text-dark">800 – 1,400 Clicks</span>
                </div>
                <div class="d-flex justify-content-between align-items-center small">
                    <span class="text-secondary"><i class="fa-solid fa-bag-shopping me-1 text-warning"></i> Projected Sales:</span>
                    <span class="fw-bold text-success">15 – 35 Orders (₹36,000+)</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- TAB 2: MY PROMOTIONS TABLE -->
    @if($currentTab === 'my-promotions')
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">Active & Past Promotions</h5>
            <a href="{{ route('seller.promotions.index', ['tab' => 'create']) }}" class="btn btn-primary btn-sm fw-semibold rounded-pill px-3">
                <i class="fa-solid fa-plus me-1"></i> New Campaign
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-3">Campaign & Item</th>
                        <th>Promotion Type</th>
                        <th>Charge Paid</th>
                        <th>Duration</th>
                        <th>Performance</th>
                        <th>Sales Generated</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions as $promo)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $promo->listing_thumbnail ?: 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?auto=format&fit=crop&w=60&q=80' }}" 
                                         class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $promo->listing_title }}</div>
                                        <div class="text-muted small">
                                            Code: <span class="font-monospace text-primary">{{ $promo->promotion_code }}</span> &bull; {{ $promo->listing_type }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                    {{ $promo->promotion_type }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">₹{{ number_format($promo->charge_amount) }}</div>
                                <div class="text-success small" style="font-size: 0.7rem;">Paid via Wallet</div>
                            </td>
                            <td>
                                <div class="small fw-medium">{{ $promo->duration_days }} Days</div>
                                <div class="text-muted" style="font-size: 0.7rem;">
                                    {{ $promo->start_date->format('M d') }} - {{ $promo->end_date->format('M d, Y') }}
                                </div>
                            </td>
                            <td>
                                <div class="small"><strong>{{ number_format($promo->views_count) }}</strong> views</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ number_format($promo->clicks_count) }} clicks ({{ $promo->views_count > 0 ? round(($promo->clicks_count / $promo->views_count)*100, 1) : 0 }}% CTR)</div>
                            </td>
                            <td>
                                <div class="fw-bold text-success">₹{{ number_format($promo->revenue_generated) }}</div>
                                <div class="text-muted small">{{ $promo->sales_count }} purchases</div>
                            </td>
                            <td>
                                @if($promo->status === 'Active')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">Active</span>
                                @elseif($promo->status === 'Paused')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill">Paused</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 rounded-pill">Completed</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <form action="{{ route('seller.promotions.toggle', $promo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-1 px-2" title="{{ $promo->status === 'Active' ? 'Pause Campaign' : 'Resume Campaign' }}">
                                        <i class="fa-solid {{ $promo->status === 'Active' ? 'fa-pause' : 'fa-play' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-4 text-secondary small">
                                No promotion campaigns launched yet. Click "New Campaign" to promote your listings!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- TAB 3: DISCOUNT COUPONS -->
    @if($currentTab === 'coupons')
    <div class="row g-4">
        <!-- Coupons Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="p-3 border-bottom bg-white">
                    <h5 class="fw-bold text-dark mb-0">Active Discount Coupons</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-3">Coupon Code</th>
                                <th>Discount</th>
                                <th>Min. Order</th>
                                <th>Applicable To</th>
                                <th>Usage</th>
                                <th>Validity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-primary font-monospace bg-primary bg-opacity-10 px-2 py-1 rounded d-inline-block">
                                            {{ $coupon->coupon_code }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">
                                            {{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '% OFF' : '₹' . number_format($coupon->discount_value) . ' FLAT' }}
                                        </span>
                                    </td>
                                    <td>₹{{ number_format($coupon->min_order_amount) }}</td>
                                    <td><span class="badge bg-secondary-subtle text-dark text-capitalize">{{ $coupon->applicable_to }}</span></td>
                                    <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit }}</td>
                                    <td class="small text-muted">{{ $coupon->valid_until->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                            {{ $coupon->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4 text-muted small">No coupons created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Coupon Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-3">Create New Coupon</h5>
                <form action="{{ route('seller.promotions.coupons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Coupon Code</label>
                        <input type="text" name="coupon_code" class="form-control text-uppercase font-monospace fw-bold" placeholder="e.g. FLASH25" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark">Type</label>
                            <select name="discount_type" class="form-select">
                                <option value="percentage">Percentage (%)</option>
                                <option value="flat">Flat Cash (₹)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark">Value</label>
                            <input type="number" name="discount_value" class="form-control" placeholder="20" min="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Minimum Order Amount (₹)</label>
                        <input type="number" name="min_order_amount" class="form-control" value="999">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Applicable To</label>
                        <select name="applicable_to" class="form-select">
                            <option value="all">All Store Items</option>
                            <option value="courses">Courses Only</option>
                            <option value="services">Services Only</option>
                            <option value="products">Products Only</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Valid Until</label>
                        <input type="date" name="valid_until" class="form-control" value="{{ \Carbon\Carbon::today()->addDays(30)->format('Y-m-d') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3">
                        Create Coupon
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- TAB 4: BANNERS & CREATIVES -->
    @if($currentTab === 'banners')
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="promo-preview-banner p-4" style="min-height: 200px;">
                    <span class="badge bg-warning text-dark fw-bold mb-2">20% OFF</span>
                    <h5 class="fw-bold text-white">Complete Digital Marketing Course</h5>
                    <p class="small text-white-50">Master SEO, Ads, & Analytics with Live Mentorship</p>
                    <div class="fw-bold text-warning">₹2,399</div>
                </div>
                <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold small">Homepage Leaderboard Banner</div>
                        <div class="text-muted" style="font-size: 0.7rem;">1200 × 400 Web Ready</div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="alert('Leaderboard banner downloaded.');">
                        <i class="fa-solid fa-download me-1"></i> Download
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #059669, #047857); min-height: 200px;">
                    <div class="badge bg-white text-success fw-bold mb-2">Special Launch Offer</div>
                    <h5 class="fw-bold">Python for Beginners</h5>
                    <p class="small text-white-50">Zero to Hero in Python & Data Science</p>
                    <div class="h5 fw-bold text-warning mb-0">₹2,799</div>
                </div>
                <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold small">Instagram Square Post</div>
                        <div class="text-muted" style="font-size: 0.7rem;">1080 × 1080 Social Ready</div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="alert('Square creative downloaded.');">
                        <i class="fa-solid fa-download me-1"></i> Download
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #dc2626, #991b1b); min-height: 200px;">
                    <div class="badge bg-warning text-dark fw-bold mb-2">Limited Slots</div>
                    <h5 class="fw-bold">VCEC Computer Institute</h5>
                    <p class="small text-white-50">Govt & ISO Certified Computer Training</p>
                    <div class="h5 fw-bold text-white mb-0">Free Demo Class</div>
                </div>
                <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold small">WhatsApp Status Story</div>
                        <div class="text-muted" style="font-size: 0.7rem;">1080 × 1920 Story Ready</div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="alert('WhatsApp status creative downloaded.');">
                        <i class="fa-solid fa-download me-1"></i> Download
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    // Listing Type Selector
    function selectListingType(cardEl, type) {
        document.querySelectorAll('.selection-card').forEach(el => {
            if (el.onclick && el.onclick.toString().includes('selectListingType')) {
                el.classList.remove('selected');
            }
        });
        cardEl.classList.add('selected');
        document.getElementById('hiddenListingType').value = type;
    }

    // Promotion Type & Charge Selector (1000, 1500, 2000, 2500)
    function selectPromoType(cardEl, promoType, charge) {
        document.querySelectorAll('.selection-card').forEach(el => {
            if (el.onclick && el.onclick.toString().includes('selectPromoType')) {
                el.classList.remove('selected');
            }
        });
        cardEl.classList.add('selected');
        document.getElementById('hiddenPromoType').value = promoType;
        document.getElementById('hiddenChargeAmount').value = charge;

        document.getElementById('summaryPromoType').textContent = promoType;
        document.getElementById('summaryTotalCharge').textContent = '₹' + Number(charge).toLocaleString();
        document.getElementById('submitPromoBtn').innerHTML = `<i class="fa-solid fa-rocket"></i><span>Launch Promotion &bull; Pay ₹${Number(charge).toLocaleString()}</span>`;
    }

    // Listing Select Change handler
    function onListingChange(selectEl) {
        const option = selectEl.options[selectEl.selectedIndex];
        const title = option.value;
        const price = Number(option.getAttribute('data-price')) || 2999;

        document.getElementById('hiddenListingTitle').value = title;
        document.getElementById('hiddenOriginalPrice').value = price;
        document.getElementById('previewTitle').textContent = title;

        updateSummary();
    }

    // Live update of calculation and banner preview
    function updateSummary() {
        const origPrice = Number(document.getElementById('hiddenOriginalPrice').value) || 2999;
        const discountPct = Number(document.getElementById('discountInput').value) || 20;

        const offerPrice = Math.round(origPrice * (1 - (discountPct / 100)));

        document.getElementById('summaryOrigPrice').textContent = '₹' + origPrice.toLocaleString();
        document.getElementById('summaryOfferPrice').textContent = '₹' + offerPrice.toLocaleString();

        document.getElementById('previewDiscountBadge').textContent = discountPct + '% OFF';
        document.getElementById('previewOrigPrice').textContent = '₹' + origPrice.toLocaleString();
        document.getElementById('previewOfferPrice').textContent = '₹' + offerPrice.toLocaleString();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSummary();
    });
</script>
@endsection

