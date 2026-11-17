@extends('seller.layouts.seller')

@section('title', 'Add Product - Digital Class Seller')

@section('styles')
<style>
    .display-heading {
        font-family: var(--dc-font-heading);
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    /* Step Navigation Header */
    .wizard-steps-container {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.65rem 0.85rem;
        margin-bottom: 1.5rem;
        overflow-x: auto;
        white-space: nowrap;
        gap: 0.5rem;
    }
    .wizard-step-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        flex-shrink: 0;
    }
    .wizard-step-item:hover {
        background-color: #f1f5f9;
    }
    .wizard-step-item.active {
        background-color: #eff6ff;
        color: #0066ff;
        font-weight: 700;
    }
    .wizard-step-item.completed {
        color: #0f766e;
    }
    .wizard-step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 800;
        color: #0f172a;
        flex-shrink: 0;
    }
    .wizard-step-item.active .wizard-step-num {
        background: #0066ff;
        color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 102, 255, 0.25);
    }
    .wizard-step-item.completed .wizard-step-num {
        background: #10b981;
        color: #ffffff;
    }
    .wizard-step-title {
        font-size: 0.925rem;
        font-weight: 700;
        line-height: 1.25;
        color: #0f172a;
        display: block;
    }
    .wizard-step-item.active .wizard-step-title {
        color: #0066ff;
    }
    .wizard-step-item.completed .wizard-step-title {
        color: #0f766e;
    }
    .wizard-step-sub {
        font-size: 0.775rem;
        color: #475569;
        display: block;
        font-weight: 500;
        line-height: 1.2;
    }
    .wizard-step-item.active .wizard-step-sub {
        color: #0284c7;
        font-weight: 600;
    }
    .wizard-step-item.completed .wizard-step-sub {
        color: #059669;
    }

    /* Option Selection Cards (Step 1) */
    .type-select-card {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.85rem;
    }
    .type-select-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .type-select-card.selected {
        border-color: #0066ff;
        background: #f0f7ff;
    }
    .type-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Pricing Plan Cards (Step 6) */
    .pricing-plan-card {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem 1.25rem;
        background: #ffffff;
        position: relative;
        transition: all 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }
    .pricing-plan-card:hover {
        border-color: #cbd5e1;
    }
    .pricing-plan-card.selected {
        border-color: #0066ff;
        background: #f8faff;
        box-shadow: 0 8px 24px -8px rgba(0, 102, 255, 0.2);
    }

    .pricing-plan-card .btn-plan-action {
        width: 100%;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.55rem 1rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        border: 1.5px solid #0066ff !important;
        background-color: transparent !important;
        color: #0066ff !important;
    }
    .pricing-plan-card .btn-plan-action:hover {
        background-color: #eff6ff !important;
        color: #0052cc !important;
    }
    .pricing-plan-card.selected .btn-plan-action {
        background-color: #0066ff !important;
        color: #ffffff !important;
        border-color: #0066ff !important;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
    }
    .pricing-plan-card.selected .btn-plan-action:hover {
        background-color: #0052cc !important;
        color: #ffffff !important;
    }

    .plan-feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.25rem 0;
        flex-grow: 1;
    }
    .plan-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        font-size: 0.84rem;
        color: #334155;
        font-weight: 500;
        margin-bottom: 0.65rem;
        line-height: 1.4;
    }
    .plan-feature-check {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #059669;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .font-mono-code {
        font-family: var(--dc-font-mono) !important;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .pricing-model-card {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        position: relative;
    }
    .pricing-model-card:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
    }
    .pricing-model-card.selected {
        border-color: #0066ff;
        background-color: #f0f7ff;
        box-shadow: 0 4px 14px -2px rgba(0, 102, 255, 0.15);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.5rem;">
                Product Add Process
            </h2>
            <p class="text-muted small mb-0">List your products and showcase them to thousands of potential customers</p>
        </div>
        <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    <!-- Multi-Step Stepper Navigation (1 to 7) -->
    <div class="wizard-steps-container">
        <div class="wizard-step-item active" id="step-nav-1" onclick="goToStep(1)">
            <div class="wizard-step-num">1</div>
            <div>
                <span class="wizard-step-title">Choose Product Type</span>
                <span class="wizard-step-sub">Select type of product</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-2" onclick="goToStep(2)">
            <div class="wizard-step-num">2</div>
            <div>
                <span class="wizard-step-title">Basic Information</span>
                <span class="wizard-step-sub">Product basic details</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-3" onclick="goToStep(3)">
            <div class="wizard-step-num">3</div>
            <div>
                <span class="wizard-step-title">Product Details</span>
                <span class="wizard-step-sub">Specs & highlights</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-4" onclick="goToStep(4)">
            <div class="wizard-step-num">4</div>
            <div>
                <span class="wizard-step-title">Media & Gallery</span>
                <span class="wizard-step-sub">Images, logo & videos</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-5" onclick="goToStep(5)">
            <div class="wizard-step-num">5</div>
            <div>
                <span class="wizard-step-title">Contact & Location</span>
                <span class="wizard-step-sub">Store & warehouse</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-6" onclick="goToStep(6)">
            <div class="wizard-step-num">6</div>
            <div>
                <span class="wizard-step-title">Product Price</span>
                <span class="wizard-step-sub">Pricing, MRP & stock</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-7" onclick="goToStep(7)">
            <div class="wizard-step-num">7</div>
            <div>
                <span class="wizard-step-title">Pricing & Plan</span>
                <span class="wizard-step-sub">Listing plan & add-ons</span>
            </div>
            <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem; color: #94a3b8;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-8" onclick="goToStep(8)">
            <div class="wizard-step-num">8</div>
            <div>
                <span class="wizard-step-title">Preview & Submit</span>
                <span class="wizard-step-sub">Submit for admin review</span>
            </div>
        </div>
    </div>

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Please fix the errors below:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Wizard Form -->
    <form action="{{ route('seller.products.store') }}" method="POST" id="productWizardForm" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- ================= STEP 1: CHOOSE PRODUCT TYPE ================= -->
        <div class="wizard-step-content" id="step-content-1">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Choose Product Type</h5>
                    <p class="text-muted small mb-0">Select the type that best describes your product</p>
                </div>

                <input type="hidden" name="product_type" id="inputProductType" value="Digital">

                <!-- 1. Digital Download -->
                <div class="type-select-card selected" onclick="selectProductType('Digital', this)">
                    <input type="radio" name="product_type_radio" class="form-check-input flex-shrink-0" checked>
                    <div class="type-icon-box" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-file-zipper"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Digital Download & Source Code</h6>
                        <small class="text-muted">Instant download ZIP, scripts, Figma UI kits, software tools and e-books.</small>
                    </div>
                </div>

                <!-- 2. Physical Shipped Goods -->
                <div class="type-select-card" onclick="selectProductType('Physical', this)">
                    <input type="radio" name="product_type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Physical Goods & Hardware</h6>
                        <small class="text-muted">Shipped physical products, computer peripherals, study kits and printed material.</small>
                    </div>
                </div>

                <!-- 3. Software License -->
                <div class="type-select-card" onclick="selectProductType('Digital', this)">
                    <input type="radio" name="product_type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #ede9fe; color: #7c3aed;">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Software License & Web Scripts</h6>
                        <small class="text-muted">Single/extended commercial licenses, SaaS scripts, API connectors and modules.</small>
                    </div>
                </div>

                <!-- 4. Study Notes & E-Books -->
                <div class="type-select-card" onclick="selectProductType('Digital', this)">
                    <input type="radio" name="product_type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #dcfce7; color: #16a34a;">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Study Notes & E-Books</h6>
                        <small class="text-muted">Exam preparation guides, study materials, worksheets and PDF documents.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(2)">
                        Continue &rarr;
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 2: BASIC INFORMATION ================= -->
        <div class="wizard-step-content d-none" id="step-content-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Basic Information</h5>
                    <p class="text-muted small mb-0">Add your product basic details</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="inputProductTitle" class="form-control" placeholder="e.g. SaaS Multi-Vendor Marketplace UI Kit & Full-Stack Starter Template" value="{{ old('title', 'SaaS Multi-Vendor Marketplace UI Kit & Full-Stack Starter Template') }}" required>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">Short Description <span class="text-danger">*</span></label>
                        <small class="text-muted" id="shortDescCounter">135/300</small>
                    </div>
                    <textarea name="tagline" class="form-control" rows="3" maxlength="300" placeholder="Brief summary of the product..." oninput="document.getElementById('shortDescCounter').textContent = this.value.length + '/300'">{{ old('tagline', 'Professional computer education, software scripts, digital templates, and multi-vendor marketplace full-stack source code kit.') }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Product Category <span class="text-danger">*</span></label>
                        <select name="category" id="inputProductCategory" class="form-select" required>
                            <option value="Software & Source Code" {{ old('category', 'Software & Source Code') == 'Software & Source Code' ? 'selected' : '' }}>Software & Source Code</option>
                            <option value="Digital Assets & Tools">Digital Assets & UI Kits</option>
                            <option value="E-Books & Notes">E-Books & Study Material</option>
                            <option value="Electronics & Accessories">Electronics & Hardware</option>
                            <option value="Stationery & Print">Education & Training</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Sub Category <span class="text-danger">*</span></label>
                        <select name="sub_category" id="inputProductSubCategory" class="form-select">
                            <option value="Computer Training Institute" selected>Computer Training Institute</option>
                            <option value="Full-Stack Web Scripts">Full-Stack Web Scripts</option>
                            <option value="Figma Design Kits">Figma Design Kits</option>
                            <option value="Mobile App Templates">Mobile App Templates</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">SKU Code</label>
                        <input type="text" name="sku" id="inputProductSku" class="form-control font-mono-code" placeholder="e.g. DC-PROD-SAAS26" value="{{ old('sku', 'DC-PROD-SAAS26') }}">
                        <div class="form-text small text-muted">Unique inventory identifier for this product</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Inventory Tracking</label>
                        <select class="form-select">
                            <option value="track" selected>Track Stock Units (Configured in Step 6)</option>
                            <option value="digital">Digital Unlimited Download</option>
                            <option value="custom">Made to Order</option>
                        </select>
                        <div class="form-text small text-muted">Stock units, price & shipping details configured in Step 6</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(1)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(3)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 3: PRODUCT DETAILS ================= -->
        <div class="wizard-step-content d-none" id="step-content-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Product Details</h5>
                    <p class="text-muted small mb-0">Add complete specifications and features about your product</p>
                </div>

                <!-- Sub-tabs -->
                <ul class="nav nav-pills mb-3 border-bottom pb-2">
                    <li class="nav-item">
                        <button class="nav-link active py-1 px-3 small fw-semibold" type="button">Overview</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1 px-3 small fw-semibold" type="button">Services</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1 px-3 small fw-semibold" type="button">Highlights</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1 px-3 small fw-semibold" type="button">Awards</button>
                    </li>
                </ul>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">Detailed Description</label>
                        <small class="text-muted" id="descCounter">220/1000</small>
                    </div>

                    <!-- Mini rich text toolbar -->
                    <div class="d-flex gap-1 p-1 bg-light border border-bottom-0 rounded-top" style="font-size: 0.8rem;">
                        <button type="button" class="btn btn-sm btn-white border px-2 py-0 fw-bold">B</button>
                        <button type="button" class="btn btn-sm btn-white border px-2 py-0 fst-italic">I</button>
                        <button type="button" class="btn btn-sm btn-white border px-2 py-0 text-decoration-underline">U</button>
                        <button type="button" class="btn btn-sm btn-white border px-2 py-0"><i class="fa-solid fa-list-ul"></i></button>
                        <button type="button" class="btn btn-sm btn-white border px-2 py-0"><i class="fa-solid fa-list-ol"></i></button>
                    </div>
                    <textarea name="description" id="inputProductDesc" class="form-control rounded-top-0" rows="5" maxlength="1000" placeholder="Provide complete information about your product, features, specifications and licensing..." oninput="document.getElementById('descCounter').textContent = this.value.length + '/1000'">{{ old('description', 'VCEC is a trusted computer education center providing industry-relevant courses for students, professionals and business owners. Our mission is to make everyone digitally skilled and job-ready with practical training.') }}</textarea>
                </div>

                <!-- Key Features / Highlights -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small mb-2">Key Features / Highlights</label>
                    <div id="productHighlightsContainer" class="d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="ISO 21001:2018 Certified Institute">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Experienced Faculty">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Practical & Job-Oriented Training">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Flexible Batch Timings">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Placement Assistance">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 fw-semibold" onclick="addProductHighlightRow()">
                        <i class="fa-solid fa-plus me-1"></i> Add Another Highlight
                    </button>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(2)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(4)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 4: MEDIA & GALLERY ================= -->
        <div class="wizard-step-content d-none" id="step-content-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Media & Gallery</h5>
                    <p class="text-muted small mb-0">Add images, logo, banner and videos</p>
                </div>

                <!-- Product Logo -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Product Logo / Emblem <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <div id="badgePreviewContainer" class="rounded-3 border d-flex flex-column align-items-center justify-content-center p-2 bg-light flex-shrink-0 position-relative overflow-hidden" style="width: 80px; height: 80px;">
                            <img id="badgePreviewImg" src="" class="w-100 h-100 object-fit-cover rounded-2 d-none" alt="Product Image">
                            <div id="badgeDefaultPlaceholder" class="text-center">
                                <span class="fw-bold text-primary display-heading fs-4">V</span>
                                <small class="fw-bold text-dark d-block" style="font-size: 0.65rem;">VCEC</small>
                            </div>
                        </div>
                        <div class="p-3 border border-dashed rounded-3 flex-grow-1 text-center bg-light bg-opacity-25" 
                             style="border-style: dashed !important; cursor: pointer; transition: all 0.2s;"
                             onclick="document.getElementById('inputThumbnailFile').click()">
                            <i class="fa-solid fa-cloud-arrow-up text-primary fs-4 mb-1" id="badgeUploadIcon"></i>
                            <div class="fw-bold small text-dark" id="badgeUploadText">Upload Product Image</div>
                            <small class="text-muted d-block" id="badgeUploadSubtext">PNG, JPG, WEBP (Max 10MB) &bull; Click to Browse</small>
                            <input type="file" id="inputThumbnailFile" name="thumbnail_file" accept="image/*" class="d-none" onchange="handleThumbnailSelect(this)">
                            <input type="hidden" name="thumbnail" id="inputThumbnailUrl" value="{{ old('thumbnail', '') }}">
                        </div>
                    </div>
                </div>

                <!-- Cover Image / Banner -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">Cover Image / Banner</label>
                        <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-semibold" onclick="document.getElementById('inputCoverFile').click()">
                            <i class="fa-solid fa-camera me-1"></i> Change Banner
                        </button>
                    </div>
                    <div id="bannerPreviewBox" class="p-4 rounded-3 text-center text-white mb-3 position-relative overflow-hidden d-flex flex-column justify-content-center align-items-center" 
                         style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800') center/cover; min-height: 140px; cursor: pointer;"
                         onclick="document.getElementById('inputCoverFile').click()">
                        <span id="bannerClearBtn" class="badge bg-dark bg-opacity-75 position-absolute top-0 end-0 m-2" style="cursor: pointer;" onclick="event.stopPropagation(); clearBannerImage();" title="Remove custom banner"><i class="fa-solid fa-xmark"></i></span>
                        <h5 class="display-heading fw-bold mb-0 text-white" id="bannerHeadingText">SKILL TODAY BETTER TOMORROW</h5>
                        <small class="text-white-50" id="bannerSubtext">Cover Banner Preview &bull; Click anywhere to upload</small>
                    </div>
                    <input type="file" id="inputCoverFile" name="cover_file" accept="image/*" class="d-none" onchange="handleCoverSelect(this)">
                    <input type="hidden" name="cover_image" id="inputCoverUrl" value="{{ old('cover_image', '') }}">

                    <!-- Gallery Thumbnails -->
                    <div>
                        <label class="form-label fw-semibold text-secondary small mb-2">Gallery Images (Optional)</label>
                        <div class="d-flex flex-wrap gap-2" id="galleryContainer">
                            <div class="rounded-2 border border-dashed d-flex flex-column align-items-center justify-content-center text-muted bg-light" 
                                 style="width: 70px; height: 50px; cursor: pointer; font-size: 0.65rem;"
                                 onclick="document.getElementById('inputGalleryFiles').click()"
                                 title="Add image to gallery">
                                <i class="fa-solid fa-plus fs-6 text-primary mb-1"></i>
                                <span>Add More</span>
                            </div>
                        </div>
                        <input type="file" id="inputGalleryFiles" name="gallery_files[]" multiple accept="image/*" class="d-none" onchange="handleGallerySelect(this)">
                        <input type="hidden" name="gallery" id="inputGalleryJson" value="[]">
                    </div>
                </div>

                <!-- Intro Video (Optional) -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Product Demo Video (Optional)</label>
                    <div class="d-flex align-items-center gap-3">
                        <div id="videoPreviewContainer" class="rounded-3 border overflow-hidden position-relative flex-shrink-0 bg-dark d-flex align-items-center justify-content-center" style="width: 90px; height: 60px;">
                            <video id="videoPreviewPlayer" class="w-100 h-100 object-fit-cover d-none" controls playsinline></video>
                            <div id="videoPreviewPlaceholder" class="text-center text-white">
                                <i class="fa-solid fa-circle-play fs-4 text-primary"></i>
                            </div>
                        </div>
                        <div class="p-3 border border-dashed rounded-3 flex-grow-1 text-center bg-light bg-opacity-25" 
                             style="border-style: dashed !important; cursor: pointer; transition: all 0.2s;"
                             onclick="document.getElementById('inputVideoFile').click()">
                            <i class="fa-solid fa-video text-primary fs-4 mb-1" id="videoUploadIcon"></i>
                            <div class="fw-bold small text-dark" id="videoUploadText">Upload Video</div>
                            <small class="text-muted d-block" id="videoUploadSubtext">MP4, WEBM, MOV (Max 150MB) &bull; Click to Browse</small>
                            <input type="file" id="inputVideoFile" name="video_file" accept="video/mp4,video/webm,video/quicktime,video/ogg,.mp4,.mov,.webm" class="d-none" onchange="handleVideoSelect(this)">
                            <input type="hidden" name="video_url" id="inputVideoUrl" value="{{ old('video_url', '') }}">
                        </div>
                    </div>

                    <!-- Direct Video URL Alternative -->
                    <div class="mt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white text-muted"><i class="fa-brands fa-youtube me-1 text-danger"></i> Or Video URL</span>
                            <input type="url" class="form-control" id="inputVideoUrlField" placeholder="https://www.youtube.com/watch?v=... or https://vimeo.com/..." 
                                   oninput="document.getElementById('inputVideoUrl').value = this.value">
                        </div>
                        <small class="text-muted" style="font-size: 0.7rem;">Enter YouTube, Vimeo, or hosted MP4 URL if you prefer not uploading directly</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(3)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(5)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 5: CONTACT & LOCATION ================= -->
        <div class="wizard-step-content d-none" id="step-content-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Contact & Location</h5>
                    <p class="text-muted small mb-0">Add contact details and location</p>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Business Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="text" name="phone" id="inputProductPhone" class="form-control" placeholder="Enter 10-digit mobile number" value="{{ old('phone', '9876543210') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold text-dark small mb-0">WhatsApp Number</label>
                            <div class="form-check form-check-inline me-0">
                                <input class="form-check-input" type="checkbox" id="samePhoneProduct" checked onchange="document.getElementById('inputProductWhatsapp').value = this.checked ? document.getElementById('inputProductPhone').value : ''">
                                <label class="form-check-label small text-muted" for="samePhoneProduct" style="font-size: 0.725rem;">Same as business phone</label>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="text" name="whatsapp_number" id="inputProductWhatsapp" class="form-control" placeholder="Enter WhatsApp number" value="{{ old('whatsapp_number', '9876543210') }}">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Business Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="inputProductEmail" class="form-control" placeholder="contact@yourbusiness.com" value="{{ old('email', 'info@vcec.in') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Website (Optional)</label>
                        <input type="url" name="website" id="inputProductWebsite" class="form-control" placeholder="https://www.yourbusiness.com" value="{{ old('website', 'https://www.vcec.in') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="inputProductAddress" class="form-control" placeholder="Floor, Building, Street, Landmark" value="{{ old('address', '3rd Floor, Shreeji Complex, Nikol, Ahmedabad - 382350') }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" id="inputProductCity" class="form-control" placeholder="Ahmedabad" value="{{ old('city', 'Ahmedabad') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" id="inputProductState" class="form-control" placeholder="Gujarat" value="{{ old('state', 'Gujarat') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" id="inputProductPincode" class="form-control font-mono-code" placeholder="382350" value="{{ old('pincode', '382350') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Google Maps Location</label>
                    <div class="input-group mb-2">
                        <input type="text" name="map_location" id="inputProductMap" class="form-control" placeholder="Google Maps link" value="{{ old('map_location', 'https://maps.google.com/?q=VCEC+Nikol') }}">
                        <button class="btn btn-outline-primary fw-semibold" type="button">Get Location</button>
                    </div>
                    <div class="border rounded-3 p-2 bg-light d-flex align-items-center justify-content-between" style="max-width: 280px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-location-dot text-danger fs-5"></i>
                            <div>
                                <div class="fw-bold small text-dark" style="font-size: 0.8rem;">VCEC - Nikol</div>
                                <a href="https://maps.google.com/?q=VCEC+Nikol" target="_blank" class="text-primary small text-decoration-none" style="font-size: 0.7rem;">View larger map</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(4)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(6)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 6: PRODUCT PRICE & INVENTORY ================= -->
        <div class="wizard-step-content d-none" id="step-content-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Product Price & Inventory</h5>
                    <p class="text-muted small mb-0">Set regular MRP, selling price, available stock units, and shipping details</p>
                </div>

                <!-- Hidden Input for Product Pricing Model -->
                <input type="hidden" name="is_free_product" id="inputIsFreeProduct" value="0">

                <!-- Pricing Model Selector (Paid vs Free Resource) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="pricing-model-card selected" id="cardProductPaid" onclick="setProductPricingModel('paid')">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" name="product_pricing_model_radio" id="radioProductPaid" class="form-check-input" checked>
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-tag me-1"></i> Paid Product
                                    </span>
                                </div>
                                <span class="badge bg-success rounded-pill px-2 py-0.5 small fw-semibold">Recommended</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Standard Paid Item</h6>
                            <p class="text-muted small mb-0">Monetize your physical or digital item with direct buyer orders.</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="pricing-model-card" id="cardProductFree" onclick="setProductPricingModel('free')">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" name="product_pricing_model_radio" id="radioProductFree" class="form-check-input">
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-gift me-1"></i> Free Download / Sample
                                    </span>
                                </div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-0.5 small fw-semibold">Lead Magnet</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">100% Free For All Buyers</h6>
                            <p class="text-muted small mb-0">Give away sample templates, source code or study kits freely.</p>
                        </div>
                    </div>
                </div>

                <!-- Product Pricing & MRP Section -->
                <div id="productPricingFieldsSection" class="p-3.5 rounded-4 bg-light border mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Regular Price (MRP) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white fw-bold text-secondary">₹</span>
                                <input type="number" step="0.01" min="0" name="mrp" id="inputProductMrp" class="form-control font-mono-code fw-bold" placeholder="3999.00" value="{{ old('mrp', '3999.00') }}" oninput="calculateProductDiscount()">
                            </div>
                            <div class="form-text small text-muted">Original list price shown as crossed-out original price</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Offer / Selling Price <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white fw-bold text-primary">₹</span>
                                <input type="number" step="0.01" min="0" name="price" id="inputProductPrice" class="form-control font-mono-code fw-bold text-primary" placeholder="1499.00" value="{{ old('price', '1499.00') }}" required oninput="calculateProductDiscount()">
                            </div>
                            <div class="form-text small text-muted">The actual final amount the customer pays to purchase</div>
                        </div>

                        <!-- Live Calculation & Savings Badge -->
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-white border">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-danger rounded-pill px-2.5 py-1 fw-bold fs-7" id="liveProductDiscountBadge">62% OFF</span>
                                    <span class="small text-secondary" id="liveProductSavingsText">Customers save <strong>₹2,500.00</strong> on this product!</span>
                                </div>
                                <div class="small fw-semibold text-success d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> High Conversion Pricing
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock, Weight & Shipping Details -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">
                            Available Stock Units <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-boxes-stacked"></i></span>
                            <input type="number" min="0" name="stock_quantity" id="inputStockQuantity" class="form-control font-mono-code fw-bold" placeholder="250" value="{{ old('stock_quantity', '250') }}" required oninput="updateLiveProductPill()">
                            <span class="input-group-text bg-white text-muted">Units</span>
                        </div>
                        <div class="form-text small text-muted">Current inventory available for ordering</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">
                            Item Weight (Grams)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-weight-scale"></i></span>
                            <input type="number" min="0" name="weight_grams" id="inputWeightGrams" class="form-control font-mono-code fw-semibold" placeholder="0" value="{{ old('weight_grams', '0') }}">
                            <span class="input-group-text bg-white text-muted">g</span>
                        </div>
                        <div class="form-text small text-muted">Leave 0 for digital files or software kits</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small mb-1">
                            Shipping / Delivery Method
                        </label>
                        <input type="text" name="shipping_details" id="inputShippingDetails" class="form-control fw-semibold" placeholder="e.g. Instant Digital Download" value="{{ old('shipping_details', 'Instant Digital Download (ZIP package containing full source code and Figma file)') }}" oninput="updateLiveProductPill()">
                        <div class="form-text small text-muted">Fulfillment instructions shown to buyers</div>
                    </div>
                </div>

                <!-- Product Guarantees & Features -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark small mb-1">Trust & Buyer Guarantees</label>
                        <div class="d-flex flex-wrap gap-4 pt-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="switchProductGenuine" checked>
                                <label class="form-check-label small fw-semibold text-dark" for="switchProductGenuine">
                                    100% Genuine & Verified
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="switchProductReplacement" checked>
                                <label class="form-check-label small fw-semibold text-dark" for="switchProductReplacement">
                                    7-Day Replacement Guarantee
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="switchProductFreeShipping" checked>
                                <label class="form-check-label small fw-semibold text-dark" for="switchProductFreeShipping">
                                    Free Delivery / Instant Access
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Client Pricing Pill -->
                <div class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-box-open fs-5"></i>
                        </div>
                        <div>
                            <div class="small text-secondary fw-semibold">Live Marketplace Price Tag</div>
                            <div class="fw-bold text-dark" id="liveProductSummaryText">
                                Instant Digital Download • 250 Units Available
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted text-decoration-line-through font-mono-code" id="liveProductMrpDisplay">₹3,999.00</div>
                        <div class="fs-4 fw-bolder text-primary font-mono-code" id="liveProductPriceDisplay">₹1,499.00</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(5)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(7)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 7: PLAN & PUBLISH ================= -->
        <div class="wizard-step-content d-none" id="step-content-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Pricing & Plan</h5>
                    <p class="text-muted small mb-0">Choose a listing plan and publish your product</p>
                </div>

                <input type="hidden" name="plan_name" id="inputProductPlanName" value="Premium Listing">
                <input type="hidden" name="listing_plan_price" id="inputListingPlanPrice" value="1499.00">

                <div class="row g-3 mb-4">
                    <!-- Plan 1: Free Listing -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card" id="cardProductFree" onclick="selectProductPlan('Free Listing', 0, this)">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="product_plan_radio" class="form-check-input" style="cursor: pointer;">
                                <h6 class="fw-bold text-dark mb-0 fs-6">Free Listing</h6>
                            </div>
                            <div class="d-flex align-items-baseline mb-3">
                                <span class="fs-3 fw-bolder text-dark font-mono-code">₹0</span>
                                <span class="text-secondary small ms-2 fw-medium">/ lifetime</span>
                            </div>
                            <ul class="plan-feature-list">
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Basic product profile</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>3 images</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Appear in search results</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Get customer inquiries</span>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-plan-action">Select Plan</button>
                        </div>
                    </div>

                    <!-- Plan 2: Premium Listing (Most Popular) -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card selected" id="cardProductPremium" onclick="selectProductPlan('Premium Listing', 1499, this)">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-3 rounded-pill px-2.5 py-1 fw-bold shadow-sm" style="font-size: 0.7rem; letter-spacing: 0.02em;">Most Popular</span>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="product_plan_radio" class="form-check-input" style="cursor: pointer;" checked>
                                <h6 class="fw-bold text-dark mb-0 fs-6">Premium Listing</h6>
                            </div>
                            <div class="d-flex align-items-baseline mb-3">
                                <span class="fs-3 fw-bolder text-dark font-mono-code">₹1,499</span>
                                <span class="text-muted small ms-2 text-decoration-line-through fw-medium">₹2,999</span>
                                <span class="text-secondary small ms-2 fw-medium">/ year</span>
                            </div>
                            <ul class="plan-feature-list">
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Product profile with banner</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>10 images + 1 video</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Featured in search results</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Show contact details</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Get verified badge</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Priority in listings</span>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-plan-action">Selected ✓</button>
                        </div>
                    </div>

                    <!-- Plan 3: Featured Listing -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card" id="cardProductFeatured" onclick="selectProductPlan('Featured Listing', 2999, this)">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="product_plan_radio" class="form-check-input" style="cursor: pointer;">
                                <h6 class="fw-bold text-dark mb-0 fs-6">Featured Listing</h6>
                            </div>
                            <div class="d-flex align-items-baseline mb-3">
                                <span class="fs-3 fw-bolder text-dark font-mono-code">₹2,999</span>
                                <span class="text-muted small ms-2 text-decoration-line-through fw-medium">₹4,999</span>
                                <span class="text-secondary small ms-2 fw-medium">/ year</span>
                            </div>
                            <ul class="plan-feature-list">
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>All Premium features</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Top position in category</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Homepage featured</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Special highlight badge</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>More visibility & leads</span>
                                </li>
                                <li class="plan-feature-item">
                                    <span class="plan-feature-check"><i class="fa-solid fa-check"></i></span>
                                    <span>Dedicated support</span>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-plan-action">Select Plan</button>
                        </div>
                    </div>
                </div>

                <!-- Add-on Features & Order Summary Box -->
                <div class="row g-3 align-items-start">
                    <div class="col-md-7">
                        <label class="form-label fw-bold text-dark small mb-2">Add-on Features (Optional)</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="p-3 border rounded-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="add_ons[]" value="Verified Business Badge" id="productAddon1" checked onchange="updateProductSummary()">
                                    <label class="form-check-label small fw-semibold text-dark" for="productAddon1">
                                        Verified Business Badge
                                    </label>
                                </div>
                                <span class="fw-bold text-dark font-mono-code small">₹499 / year</span>
                            </div>

                            <div class="p-3 border rounded-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="add_ons[]" value="Additional Gallery Images" id="productAddon2" onchange="updateProductSummary()">
                                    <label class="form-check-label small fw-semibold text-dark" for="productAddon2">
                                        Additional Gallery Images (up to 20)
                                    </label>
                                </div>
                                <span class="fw-bold text-dark font-mono-code small">₹299 / year</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="p-3 rounded-3 bg-light border">
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;">Order Summary</h6>
                            <div class="d-flex justify-content-between py-1 small">
                                <span class="text-muted" id="summaryProductPlanText">Premium Listing (1 Year)</span>
                                <span class="fw-semibold font-mono-code" id="summaryProductPlanPrice">₹1,499</span>
                            </div>
                            <div class="d-flex justify-content-between py-1 small" id="summaryProductBadgeRow">
                                <span class="text-muted">Verified Business Badge</span>
                                <span class="fw-semibold font-mono-code">₹499</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top mt-2 fw-bold text-dark">
                                <span>Total:</span>
                                <span class="font-mono-code text-primary fs-6" id="summaryProductTotalPrice">₹1,998</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(6)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(8)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 8: PREVIEW & PUBLISH ================= -->
        <div class="wizard-step-content d-none" id="step-content-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="display-heading fw-bold text-dark mb-1">Preview & Submit</h5>
                        <p class="text-muted small mb-0">Review your product details and submit for admin approval</p>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary fw-semibold px-3" style="background-color: #0066ff;">Desktop View</button>
                        <button type="button" class="btn btn-outline-secondary fw-semibold px-3">Mobile View</button>
                    </div>
                </div>

                <!-- Full Product Directory Live Card Preview (Matching Page 40) -->
                <div class="border rounded-4 overflow-hidden mb-4 shadow-sm">
                    <!-- Banner -->
                    <div class="text-white text-center d-flex align-items-center justify-content-center p-4 position-relative" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800') center/cover; min-height: 160px;">
                        <h4 class="display-heading fw-bold mb-0 text-white" style="letter-spacing: 0.04em;">SKILL TODAY BETTER TOMORROW</h4>
                    </div>

                    <!-- Header Content -->
                    <div class="p-3 bg-white border-bottom">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 border d-flex flex-column align-items-center justify-content-center p-2 bg-light flex-shrink-0" style="width: 60px; height: 60px;">
                                    <span class="fw-bold text-primary display-heading fs-5" id="previewProductLogoChar">V</span>
                                    <small class="fw-bold text-dark" style="font-size: 0.6rem;" id="previewProductLogoSub">VCEC</small>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <h5 class="display-heading fw-bold text-dark mb-0" id="previewProductTitle">
                                            VCEC - Vinayak Computer Education Center
                                        </h5>
                                        <span class="badge bg-primary rounded-pill small px-2 py-1"><i class="fa-solid fa-circle-check me-1"></i> Verified</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 small mt-1">
                                        <div class="text-warning">
                                            <i class="fa-solid fa-star"></i>
                                            <strong class="text-dark ms-1">4.8</strong>
                                        </div>
                                        <span class="text-muted">(124 reviews)</span>
                                        <span class="text-muted">•</span>
                                        <span class="text-muted" id="previewProductCategory">Computer Training Institute • Education & Training</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-success btn-sm px-3 fw-semibold"><i class="fa-solid fa-phone me-1"></i> Contact</button>
                                <button type="button" class="btn btn-outline-success btn-sm px-3 fw-semibold"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</button>
                                <button type="button" class="btn btn-outline-primary btn-sm px-3 fw-semibold"><i class="fa-solid fa-globe me-1"></i> Website</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm px-2 fw-semibold"><i class="fa-solid fa-share-nodes"></i></button>
                            </div>
                        </div>

                        <!-- Info Chips Row -->
                        <div class="d-flex flex-wrap gap-3 mt-3 pt-3 border-top small text-secondary">
                            <div><i class="fa-regular fa-calendar text-muted me-1"></i> Year <strong class="text-dark">2015</strong></div>
                            <div><i class="fa-solid fa-users text-muted me-1"></i> Employees <strong class="text-dark">5 - 10</strong></div>
                            <div><i class="fa-solid fa-location-dot text-danger me-1"></i> Location <strong class="text-dark" id="previewProductLocation">Ahmedabad, Gujarat</strong></div>
                            <div><i class="fa-solid fa-chart-line text-primary me-1"></i> Inquiries <strong class="text-dark">250+</strong></div>
                        </div>
                    </div>

                    <!-- Inner Nav Tabs & Content -->
                    <div class="p-3 bg-light bg-opacity-50">
                        <ul class="nav nav-pills mb-3">
                            <li class="nav-item"><a class="nav-link active py-1 px-3 small fw-semibold" href="#">About</a></li>
                            <li class="nav-item"><a class="nav-link text-secondary py-1 px-3 small fw-semibold" href="#">Services</a></li>
                            <li class="nav-item"><a class="nav-link text-secondary py-1 px-3 small fw-semibold" href="#">Photos</a></li>
                            <li class="nav-item"><a class="nav-link text-secondary py-1 px-3 small fw-semibold" href="#">Reviews</a></li>
                            <li class="nav-item"><a class="nav-link text-secondary py-1 px-3 small fw-semibold" href="#">Location</a></li>
                        </ul>

                        <div class="p-3 bg-white rounded-3 border">
                            <h6 class="fw-bold text-dark mb-2" id="previewProductAboutHeading">About VCEC - Vinayak Computer Education Center</h6>
                            <p class="text-muted small mb-0" id="previewProductAbout">
                                VCEC is a trusted computer education center providing industry-relevant courses for students, professionals and business owners. Our mission is to make everyone digitally skilled and job-ready with practical training.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(7)">&larr; Back</button>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-5 fw-bold btn-lg shadow-sm">
                            <i class="fa-solid fa-paper-plane me-2"></i> Submit for Admin Review
                        </button>
                        <div class="text-muted small mt-1">
                            <i class="fa-solid fa-shield-halved text-primary me-1"></i> Requires admin approval before going live on the marketplace
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
    let currentStep = 1;

    function goToStep(step) {
        currentStep = step;

        for (let i = 1; i <= 8; i++) {
            const content = document.getElementById('step-content-' + i);
            const nav = document.getElementById('step-nav-' + i);
            if (content) content.classList.add('d-none');
            if (nav) {
                nav.classList.remove('active');
                if (i < step) {
                    nav.classList.add('completed');
                } else {
                    nav.classList.remove('completed');
                }
            }
        }

        const activeContent = document.getElementById('step-content-' + step);
        const activeNav = document.getElementById('step-nav-' + step);
        if (activeContent) activeContent.classList.remove('d-none');
        if (activeNav) activeNav.classList.add('active');

        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (step === 8) {
            const title = document.getElementById('inputProductTitle')?.value;
            const cat = document.getElementById('inputProductCategory')?.value;
            const sub = document.getElementById('inputProductSubCategory')?.value;
            const city = document.getElementById('inputProductCity')?.value;
            const state = document.getElementById('inputProductState')?.value;
            const desc = document.getElementById('inputProductDesc')?.value;

            if (title) {
                document.getElementById('previewProductTitle').textContent = title;
                document.getElementById('previewProductAboutHeading').textContent = 'About ' + title;
                document.getElementById('previewProductLogoChar').textContent = title.charAt(0).toUpperCase();
                document.getElementById('previewProductLogoSub').textContent = title.split(' ')[0].substring(0, 4).toUpperCase();
            }
            if (cat && sub) document.getElementById('previewProductCategory').textContent = sub + ' • ' + cat;
            if (city && state) document.getElementById('previewProductLocation').textContent = city + ', ' + state;
            if (desc) document.getElementById('previewProductAbout').textContent = desc;
        }
    }

    function setProductPricingModel(model) {
        const cardPaid = document.getElementById('cardProductPaid');
        const cardFree = document.getElementById('cardProductFree');
        const radioPaid = document.getElementById('radioProductPaid');
        const radioFree = document.getElementById('radioProductFree');
        const pricingSection = document.getElementById('productPricingFieldsSection');
        const isFreeInput = document.getElementById('inputIsFreeProduct');
        const priceInput = document.getElementById('inputProductPrice');

        if (model === 'free') {
            cardPaid.classList.remove('selected');
            cardFree.classList.add('selected');
            if (radioPaid) radioPaid.checked = false;
            if (radioFree) radioFree.checked = true;
            isFreeInput.value = '1';
            if (pricingSection) pricingSection.style.display = 'none';
            if (priceInput) priceInput.value = '0.00';
            const priceDisp = document.getElementById('liveProductPriceDisplay');
            if (priceDisp) priceDisp.textContent = 'FREE';
            const mrpDisp = document.getElementById('liveProductMrpDisplay');
            if (mrpDisp) mrpDisp.textContent = '';
        } else {
            cardFree.classList.remove('selected');
            cardPaid.classList.add('selected');
            if (radioFree) radioFree.checked = false;
            if (radioPaid) radioPaid.checked = true;
            isFreeInput.value = '0';
            if (pricingSection) pricingSection.style.display = 'block';
            if (priceInput && (!priceInput.value || parseFloat(priceInput.value) <= 0)) {
                priceInput.value = '1499.00';
            }
            calculateProductDiscount();
        }
        updateLiveProductPill();
    }

    function calculateProductDiscount() {
        const mrpInput = document.getElementById('inputProductMrp');
        const priceInput = document.getElementById('inputProductPrice');
        const badge = document.getElementById('liveProductDiscountBadge');
        const savingsText = document.getElementById('liveProductSavingsText');

        if (!mrpInput || !priceInput) return;

        const mrp = parseFloat(mrpInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;

        if (mrp > price && price >= 0 && mrp > 0) {
            const savings = mrp - price;
            const percent = Math.round((savings / mrp) * 100);
            if (badge) {
                badge.textContent = percent + '% OFF';
                badge.className = 'badge bg-danger rounded-pill px-2.5 py-1 fw-bold fs-7';
            }
            if (savingsText) {
                savingsText.innerHTML = 'Customers save <strong>₹' + savings.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</strong> on this product!';
            }
        } else if (price === mrp && price > 0) {
            if (badge) {
                badge.textContent = 'Standard MRP';
                badge.className = 'badge bg-secondary rounded-pill px-2.5 py-1 fw-bold fs-7';
            }
            if (savingsText) savingsText.innerHTML = 'Standard list price';
        } else {
            if (badge) {
                badge.textContent = 'Special Deal';
                badge.className = 'badge bg-info rounded-pill px-2.5 py-1 fw-bold fs-7';
            }
            if (savingsText) savingsText.innerHTML = 'Special deal item';
        }
        updateLiveProductPill();
    }

    function updateLiveProductPill() {
        const stock = document.getElementById('inputStockQuantity')?.value || '250';
        const shipping = document.getElementById('inputShippingDetails')?.value || 'Instant Digital Download';
        const price = parseFloat(document.getElementById('inputProductPrice')?.value) || 0;
        const mrp = parseFloat(document.getElementById('inputProductMrp')?.value) || 0;
        const isFree = document.getElementById('inputIsFreeProduct')?.value === '1';

        const summaryEl = document.getElementById('liveProductSummaryText');
        if (summaryEl) {
            summaryEl.textContent = shipping + ' • ' + stock + ' Units Available';
        }

        const priceEl = document.getElementById('liveProductPriceDisplay');
        const mrpEl = document.getElementById('liveProductMrpDisplay');

        if (isFree) {
            if (priceEl) priceEl.textContent = 'FREE Download';
            if (mrpEl) mrpEl.textContent = '';
        } else {
            if (priceEl) priceEl.textContent = '₹' + price.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            if (mrpEl) {
                if (mrp > price) {
                    mrpEl.style.display = 'block';
                    mrpEl.textContent = '₹' + mrp.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                } else {
                    mrpEl.style.display = 'none';
                }
            }
        }
    }

    function selectProductType(type, element) {
        document.querySelectorAll('.type-select-card').forEach(c => {
            c.classList.remove('selected');
            const radio = c.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });
        element.classList.add('selected');
        const r = element.querySelector('input[type="radio"]');
        if (r) r.checked = true;
        document.getElementById('inputProductType').value = type;
    }

    function addProductHighlightRow() {
        const container = document.getElementById('productHighlightsContainer');
        const div = document.createElement('div');
        div.className = 'input-group input-group-sm';
        div.innerHTML = `
            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
            <input type="text" name="features[]" class="form-control" placeholder="Enter product highlight...">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function selectProductPlan(name, price, element) {
        document.querySelectorAll('.pricing-plan-card').forEach(p => {
            p.classList.remove('selected');
            const r = p.querySelector('input[type="radio"]');
            if (r) r.checked = false;
            const btn = p.querySelector('.btn-plan-action');
            if (btn) {
                btn.textContent = 'Select Plan';
                btn.removeAttribute('style');
            }
        });

        element.classList.add('selected');
        const r = element.querySelector('input[type="radio"]');
        if (r) r.checked = true;
        const btn = element.querySelector('.btn-plan-action');
        if (btn) {
            btn.textContent = 'Selected ✓';
            btn.removeAttribute('style');
        }

        document.getElementById('inputProductPlanName').value = name;
        document.getElementById('inputListingPlanPrice').value = price.toFixed(2);
        updateProductSummary();
    }

    function updateProductSummary() {
        const planName = document.getElementById('inputProductPlanName').value;
        const planPrice = parseFloat(document.getElementById('inputListingPlanPrice').value) || 0;
        const addon1 = document.getElementById('productAddon1').checked;
        const addon2 = document.getElementById('productAddon2').checked;

        document.getElementById('summaryProductPlanText').textContent = planName + ' (1 Year)';
        document.getElementById('summaryProductPlanPrice').textContent = '₹' + planPrice.toLocaleString();

        let total = planPrice;
        if (addon1) total += 499;
        if (addon2) total += 299;

        const badgeRow = document.getElementById('summaryProductBadgeRow');
        if (badgeRow) badgeRow.style.display = addon1 ? 'flex' : 'none';

        document.getElementById('summaryProductTotalPrice').textContent = '₹' + total.toLocaleString();
    }

    // ==========================================
    // MEDIA & GALLERY FILE UPLOAD HANDLERS
    // ==========================================
    const uploadApiUrl = "{{ route('seller.media.upload') }}";
    const csrfToken = "{{ csrf_token() }}";

    function uploadFileAjax(file, type, onSuccess, onError, onProgress) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', type);
        formData.append('_token', csrfToken);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', uploadApiUrl, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        if (onProgress && xhr.upload) {
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    onProgress(percent);
                }
            };
        }

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const res = JSON.parse(xhr.responseText);
                    if (res.success) {
                        if (onSuccess) onSuccess(res);
                        return;
                    }
                } catch(e) {}
            }
            if (onError) onError(xhr.statusText || 'Upload failed');
        };

        xhr.onerror = function() {
            if (onError) onError('Network error occurred during upload');
        };

        xhr.send(formData);
    }

    // 1. Thumbnail / Product Logo
    function handleThumbnailSelect(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.getElementById('badgePreviewImg');
            const defaultPlaceholder = document.getElementById('badgeDefaultPlaceholder');
            if (previewImg) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
            }
            if (defaultPlaceholder) defaultPlaceholder.classList.add('d-none');
        };
        reader.readAsDataURL(file);

        const uploadText = document.getElementById('badgeUploadText');
        const uploadSub = document.getElementById('badgeUploadSubtext');
        const uploadIcon = document.getElementById('badgeUploadIcon');
        if (uploadText) uploadText.innerHTML = '<span class="text-primary"><i class="fa-solid fa-spinner fa-spin me-1"></i> Uploading ' + file.name + '...</span>';

        uploadFileAjax(file, 'thumbnail', function(res) {
            if (uploadText) uploadText.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Image Ready: ' + file.name + '</span>';
            if (uploadSub) uploadSub.textContent = (file.size / 1024).toFixed(1) + ' KB • Click to change';
            if (uploadIcon) uploadIcon.className = 'fa-solid fa-circle-check text-success fs-4 mb-1';
            document.getElementById('inputThumbnailUrl').value = res.url;
        }, function(err) {
            if (uploadText) uploadText.innerHTML = '<span class="text-primary"><i class="fa-solid fa-circle-check me-1"></i> Image Selected: ' + file.name + '</span>';
            if (uploadSub) uploadSub.textContent = (file.size / 1024).toFixed(1) + ' KB • Ready for save';
        });
    }

    // 2. Cover Banner
    function handleCoverSelect(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        const reader = new FileReader();
        reader.onload = function(e) {
            const bannerBox = document.getElementById('bannerPreviewBox');
            if (bannerBox) {
                bannerBox.style.background = "linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.65)), url('" + e.target.result + "') center/cover";
            }
        };
        reader.readAsDataURL(file);

        const sub = document.getElementById('bannerSubtext');
        if (sub) sub.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Uploading ' + file.name + '...';

        uploadFileAjax(file, 'cover', function(res) {
            if (sub) sub.innerHTML = '<i class="fa-solid fa-circle-check text-success me-1"></i> Custom Banner Ready: ' + file.name;
            document.getElementById('inputCoverUrl').value = res.url;
        }, function(err) {
            if (sub) sub.innerHTML = '<i class="fa-solid fa-check text-success me-1"></i> Banner Selected: ' + file.name;
        });
    }

    function clearBannerImage() {
        const input = document.getElementById('inputCoverFile');
        if (input) input.value = '';
        document.getElementById('inputCoverUrl').value = '';
        const bannerBox = document.getElementById('bannerPreviewBox');
        if (bannerBox) {
            bannerBox.style.background = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800') center/cover";
        }
        const sub = document.getElementById('bannerSubtext');
        if (sub) sub.textContent = 'Cover Banner Preview • Click anywhere to upload';
    }

    // 3. Gallery Multi-files
    let galleryList = [];
    function handleGallerySelect(input) {
        if (!input.files || input.files.length === 0) return;
        const container = document.getElementById('galleryContainer');
        const addBtn = container.querySelector('.border-dashed');

        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'rounded-2 border overflow-hidden position-relative';
                itemDiv.style.width = '70px';
                itemDiv.style.height = '50px';
                itemDiv.innerHTML = `
                    <img src="${e.target.result}" class="w-100 h-100 object-fit-cover">
                    <span class="position-absolute top-0 end-0 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" 
                          style="width: 16px; height: 16px; font-size: 0.55rem; cursor: pointer; margin: 2px;"
                          onclick="this.parentElement.remove(); updateGalleryJson();" title="Remove">&times;</span>
                `;
                container.insertBefore(itemDiv, addBtn);
            };
            reader.readAsDataURL(file);

            uploadFileAjax(file, 'gallery', function(res) {
                galleryList.push(res.url);
                updateGalleryJson();
            });
        });
    }

    function updateGalleryJson() {
        document.getElementById('inputGalleryJson').value = JSON.stringify(galleryList);
    }

    // 4. Video Upload
    function handleVideoSelect(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        const player = document.getElementById('videoPreviewPlayer');
        const placeholder = document.getElementById('videoPreviewPlaceholder');
        if (player) {
            player.src = URL.createObjectURL(file);
            player.classList.remove('d-none');
        }
        if (placeholder) placeholder.classList.add('d-none');

        const uploadText = document.getElementById('videoUploadText');
        const uploadSub = document.getElementById('videoUploadSubtext');
        const uploadIcon = document.getElementById('videoUploadIcon');
        const sizeMb = (file.size / (1024 * 1024)).toFixed(1);

        if (uploadText) uploadText.innerHTML = '<span class="text-primary"><i class="fa-solid fa-spinner fa-spin me-1"></i> Uploading ' + file.name + ' (' + sizeMb + ' MB)...</span>';

        uploadFileAjax(file, 'video', function(res) {
            if (uploadText) uploadText.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Video Ready: ' + file.name + '</span>';
            if (uploadSub) uploadSub.textContent = sizeMb + ' MB • Uploaded successfully';
            if (uploadIcon) uploadIcon.className = 'fa-solid fa-circle-check text-success fs-4 mb-1';
            document.getElementById('inputVideoUrl').value = res.url;
            const urlField = document.getElementById('inputVideoUrlField');
            if (urlField) urlField.value = res.url;
        }, function(err) {
            if (uploadText) uploadText.innerHTML = '<span class="text-primary"><i class="fa-solid fa-circle-check me-1"></i> Video Selected: ' + file.name + '</span>';
            if (uploadSub) uploadSub.textContent = sizeMb + ' MB • Ready for save';
        }, function(progress) {
            if (uploadSub) uploadSub.textContent = 'Uploading: ' + progress + '% (' + sizeMb + ' MB)';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        calculateProductDiscount();
        updateLiveProductPill();
        updateProductSummary();
    });
</script>
@endsection
