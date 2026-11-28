@extends('seller.layouts.seller')

@section('title', 'Add Product - Digital Class Seller')

@section('styles')
<style>
    /* Product Add Process Theme Styles */
    .process-hero-banner {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }
    .process-hero-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }
    .process-hero-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }
    .process-hero-sub {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0.15rem 0 0;
    }

    /* 5-Step Process Milestone Bar */
    .milestone-steps-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .milestone-step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .milestone-step-card.active {
        border-color: #10b981;
        background: #ecfdf5;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.12);
    }
    .milestone-step-card.completed {
        border-color: #10b981;
        background: #f0fdf4;
    }
    .milestone-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #0f172a;
        font-weight: 800;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .milestone-step-card.active .milestone-badge {
        background: #10b981;
        color: #ffffff;
    }
    .milestone-step-card.completed .milestone-badge {
        background: #10b981;
        color: #ffffff;
    }
    .milestone-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .milestone-step-card.active .milestone-title {
        color: #059669;
    }
    .milestone-sub {
        font-size: 0.68rem;
        color: #64748b;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* 2-Column Form Card (Left: Steps Sidebar, Right: Active Pane) */
    .product-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }
    .product-form-grid {
        display: grid;
        grid-template-columns: 270px 1fr;
        min-height: 600px;
    }
    .product-steps-sidebar {
        background: #f8fafc;
        border-right: 1px solid #e2e8f0;
        padding: 1.5rem 1.25rem;
    }
    .steps-sidebar-heading {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sidebar-step-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.85rem;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #64748b;
        text-align: left;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .sidebar-step-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .sidebar-step-btn.active {
        background: #ffffff;
        color: #059669;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }
    .sidebar-step-btn.completed {
        color: #059669;
    }
    .step-num-pill {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 800;
        flex-shrink: 0;
    }
    .sidebar-step-btn.active .step-num-pill {
        background: #10b981;
        color: #ffffff;
    }
    .sidebar-step-btn.completed .step-num-pill {
        background: #10b981;
        color: #ffffff;
    }
    .sidebar-step-label {
        font-size: 0.88rem;
    }

    /* Form Content Area */
    .product-form-content {
        padding: 2rem;
        background: #ffffff;
    }
    .pane-header-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }
    .pane-header-sub {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    /* Form Inputs */
    .field-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.4rem;
        display: block;
    }
    .field-label .req {
        color: #ef4444;
    }
    .custom-input, .custom-select, .custom-textarea {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #0f172a;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }
    .custom-input:focus, .custom-select:focus, .custom-textarea:focus {
        border-color: #10b981;
        outline: none;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }
    .type-select-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        height: 100%;
    }
    .type-select-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .type-select-card.active {
        border-color: #10b981;
        background: #ecfdf5;
    }

    /* Wizard Action Navigation */
    .wizard-actions-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1.5rem;
        margin-top: 2rem;
        border-top: 1px solid #f1f5f9;
    }
    .btn-step-back {
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-step-back:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .btn-step-next {
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        border: none;
        background: #10b981;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
        transition: all 0.2s;
    }
    .btn-step-next:hover {
        background: #059669;
    }
    .btn-step-publish {
        padding: 0.65rem 1.75rem;
        border-radius: 8px;
        border: none;
        background: #10b981;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.92rem;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        transition: all 0.2s;
    }
    .btn-step-publish:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Live Preview Card */
    .product-preview-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        max-width: 320px;
        margin: 0 auto;
    }
    .preview-thumb-wrap {
        width: 100%;
        height: 180px;
        background: #f1f5f9;
        position: relative;
        overflow: hidden;
    }
    .preview-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
    }
    .preview-body {
        padding: 1.15rem;
    }
    .preview-title {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 0.4rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .preview-desc {
        font-size: 0.78rem;
        color: #64748b;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .preview-rating-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        margin-bottom: 0.85rem;
    }
    .preview-rating-row .fa-star {
        color: #f59e0b;
    }
    .preview-price-row {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid #f1f5f9;
    }
    .preview-curr-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
    }
    .preview-old-price {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .preview-discount-badge {
        font-size: 0.72rem;
        font-weight: 800;
        color: #ef4444;
        background: #fee2e2;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        margin-left: auto;
    }

    @media (max-width: 991px) {
        .milestone-steps-row {
            grid-template-columns: 1fr;
        }
        .product-form-grid {
            grid-template-columns: 1fr;
        }
        .product-steps-sidebar {
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    <!-- Hero Process Banner -->
    <div class="process-hero-banner">
        <div class="process-hero-icon">
            <i class="fa-solid fa-box-archive"></i>
        </div>
        <div>
            <h1 class="process-hero-title">Product Add Process</h1>
            <p class="process-hero-sub">Sell educational books, notes, software & study materials with instant buyer checkout</p>
        </div>
    </div>

    <!-- 5-Step Process Milestone Bar -->
    <div class="milestone-steps-row">
        <!-- Milestone 1 -->
        <div class="milestone-step-card completed" id="milestone-step-0">
            <div class="milestone-badge">
                <i class="fa-solid fa-check" style="font-size: 0.75rem;"></i>
            </div>
            <div>
                <div class="milestone-title">1. Go to Add Product</div>
                <div class="milestone-sub">Seller dashboard se Add Product par click kare</div>
            </div>
        </div>

        <!-- Milestone 2 -->
        <div class="milestone-step-card active" id="milestone-step-1">
            <div class="milestone-badge">2</div>
            <div>
                <div class="milestone-title">2. Basic Information</div>
                <div class="milestone-sub">Product ka basic details fill kare</div>
            </div>
        </div>

        <!-- Milestone 3 -->
        <div class="milestone-step-card" id="milestone-step-2">
            <div class="milestone-badge">3</div>
            <div>
                <div class="milestone-title">3. Inventory & Specs</div>
                <div class="milestone-sub">Stock, SKU aur format details add kare</div>
            </div>
        </div>

        <!-- Milestone 4 -->
        <div class="milestone-step-card" id="milestone-step-3">
            <div class="milestone-badge">4</div>
            <div>
                <div class="milestone-title">4. Pricing & Shipping</div>
                <div class="milestone-sub">Price aur delivery terms set kare</div>
            </div>
        </div>

        <!-- Milestone 5 -->
        <div class="milestone-step-card" id="milestone-step-4">
            <div class="milestone-badge">5</div>
            <div>
                <div class="milestone-title">5. Preview & Publish</div>
                <div class="milestone-sub">Final review karke publish kare</div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-4 shadow-sm">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-1"></i> Please check the required fields:</h6>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main 2-Column Form Card -->
    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="productWizardForm">
        @csrf

        <div class="product-form-card">
            <div class="product-form-grid">

                <!-- Left Sidebar: 4 Interactive Step Buttons -->
                <div class="product-steps-sidebar">
                    <div class="steps-sidebar-heading">
                        <i class="fa-solid fa-boxes-stacked text-success"></i>
                        <span>Add New Product</span>
                    </div>

                    <button type="button" class="sidebar-step-btn active" id="step-nav-1" onclick="goToStep(1)">
                        <span class="step-num-pill">1</span>
                        <span class="sidebar-step-label">Basic Information</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-2" onclick="goToStep(2)">
                        <span class="step-num-pill">2</span>
                        <span class="sidebar-step-label">Inventory & Specs</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-3" onclick="goToStep(3)">
                        <span class="step-num-pill">3</span>
                        <span class="sidebar-step-label">Pricing & Shipping</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-4" onclick="goToStep(4)">
                        <span class="step-num-pill">4</span>
                        <span class="sidebar-step-label">Preview & Publish</span>
                    </button>

                    <div class="mt-4 pt-4 border-top">
                        <div class="small text-muted mb-2">Need quick assistance?</div>
                        <a href="{{ route('seller.products.index') }}" class="btn btn-sm btn-outline-secondary w-100 rounded-3">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
                        </a>
                    </div>
                </div>

                <!-- Right Form Content Pane -->
                <div class="product-form-content">

                    <!-- ========================================== -->
                    <!-- STEP 1: BASIC INFORMATION                  -->
                    <!-- ========================================== -->
                    <div class="step-pane" id="step-pane-1">
                        <h2 class="pane-header-title">Basic Information</h2>
                        <p class="pane-header-sub">Product ka basic details fill kare</p>

                        <div class="mb-3">
                            <label class="field-label">Product Title <span class="req">*</span></label>
                            <input type="text"
                                   name="title"
                                   id="inputTitle"
                                   class="custom-input"
                                   placeholder="e.g. Complete Mathematics Hand-Written Notes (IIT-JEE & NEET)"
                                   value="{{ old('title', 'Complete Mathematics Hand-Written Notes (IIT-JEE & NEET)') }}"
                                   required
                                   oninput="updateLivePreview()">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="field-label">Category <span class="req">*</span></label>
                                <select name="category" id="inputCategory" class="custom-select" required onchange="updateLivePreview()">
                                    <option value="Study Notes & PDFs" {{ old('category') == 'Study Notes & PDFs' ? 'selected' : '' }}>Study Notes & PDFs</option>
                                    <option value="Books & Publications" {{ old('category') == 'Books & Publications' ? 'selected' : '' }}>Books & Publications</option>
                                    <option value="Question Banks & Tests" {{ old('category') == 'Question Banks & Tests' ? 'selected' : '' }}>Question Banks & Tests</option>
                                    <option value="Educational Software & Tools" {{ old('category') == 'Educational Software & Tools' ? 'selected' : '' }}>Educational Software & Tools</option>
                                    <option value="Hardware & Lab Kits" {{ old('category') == 'Hardware & Lab Kits' ? 'selected' : '' }}>Hardware & Lab Kits</option>
                                    <option value="Stationery & Supplies" {{ old('category') == 'Stationery & Supplies' ? 'selected' : '' }}>Stationery & Supplies</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Product Type <span class="req">*</span></label>
                                <select name="product_type" id="inputProductType" class="custom-select" required onchange="handleProductTypeChange()">
                                    <option value="Digital" {{ old('product_type', 'Digital') == 'Digital' ? 'selected' : '' }}>Digital (Downloadable PDF/Software)</option>
                                    <option value="Physical" {{ old('product_type') == 'Physical' ? 'selected' : '' }}>Physical (Shipped Book/Hardware)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Description / Overview</label>
                            <textarea name="description"
                                      id="inputDescription"
                                      rows="4"
                                      class="custom-textarea"
                                      placeholder="Provide a detailed overview of what's inside this product, benefits, and target audience..."
                                      oninput="updateLivePreview()">{{ old('description', 'Comprehensive chapter-wise hand-written study material designed by top faculties for quick revision and deep concept clarity.') }}</textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="field-label">Product Thumbnail URL (Optional)</label>
                                <input type="url"
                                       name="thumbnail"
                                       id="inputThumbnailUrl"
                                       class="custom-input"
                                       placeholder="https://example.com/product.jpg (optional)"
                                       value="{{ old('thumbnail') }}"
                                       oninput="updateLivePreview()">
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Or Upload Thumbnail File</label>
                                <input type="file"
                                       name="thumbnail_file"
                                       id="inputThumbnailFile"
                                       class="custom-input"
                                       accept="image/*"
                                       onchange="previewUploadedThumb(this)">
                            </div>
                        </div>

                        <div class="wizard-actions-bar">
                            <button type="button" class="btn-step-next" onclick="goToStep(2)">
                                Next &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 2: INVENTORY & SPECS                  -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-2">
                        <h2 class="pane-header-title">Inventory & Specs</h2>
                        <p class="pane-header-sub">Stock, SKU aur format details add kare</p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="field-label">SKU (Stock Keeping Unit)</label>
                                <input type="text"
                                       name="sku"
                                       id="inputSku"
                                       class="custom-input"
                                       placeholder="e.g. BK-MATH-2026"
                                       value="{{ old('sku', 'BK-MATH-2026') }}"
                                       oninput="updateLivePreview()">
                                <small class="text-muted">Unique inventory identifier for your store.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Stock Quantity <span class="req">*</span></label>
                                <input type="number"
                                       name="stock_quantity"
                                       id="inputStock"
                                       class="custom-input"
                                       placeholder="100"
                                       value="{{ old('stock_quantity', 150) }}"
                                       min="0"
                                       required
                                       oninput="updateLivePreview()">
                                <small class="text-muted">For digital goods, set a high number (e.g. 999).</small>
                            </div>
                        </div>

                        <div class="row g-3 mb-3" id="physicalSpecsRow">
                            <div class="col-md-6">
                                <label class="field-label">Weight (in grams)</label>
                                <input type="number"
                                       name="weight_grams"
                                       id="inputWeight"
                                       class="custom-input"
                                       placeholder="e.g. 450"
                                       value="{{ old('weight_grams', 350) }}"
                                       min="0">
                                <small class="text-muted">Used to calculate courier delivery costs.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Pages / Format</label>
                                <input type="text"
                                       class="custom-input"
                                       placeholder="e.g. 380 Pages &bull; Spiral Bound / PDF"
                                       value="380 Pages &bull; Spiral Bound">
                            </div>
                        </div>

                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fa-solid fa-cloud-arrow-down text-primary"></i>
                                <span class="fw-bold text-dark small">Instant Buyer Access & Delivery</span>
                            </div>
                            <p class="text-muted small mb-0">
                                Digital items are automatically unlocked in the student's learning library immediately upon checkout. Physical products are queued for dispatch tracking.
                            </p>
                        </div>

                        <div class="wizard-actions-bar">
                            <button type="button" class="btn-step-back" onclick="goToStep(1)">
                                &larr; Back
                            </button>
                            <button type="button" class="btn-step-next" onclick="goToStep(3)">
                                Next &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 3: PRICING & SHIPPING                 -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-3">
                        <h2 class="pane-header-title">Pricing & Shipping</h2>
                        <p class="pane-header-sub">Price aur delivery terms set kare</p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="field-label">Original MRP (₹)</label>
                                <input type="number"
                                       name="mrp"
                                       id="inputMrp"
                                       class="custom-input"
                                       placeholder="999"
                                       value="{{ old('mrp', 999) }}"
                                       min="0"
                                       step="1"
                                       oninput="updateLivePreview()">
                                <small class="text-muted">Strikethrough reference price shown to buyers.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Selling Price (₹) <span class="req">*</span></label>
                                <input type="number"
                                       name="price"
                                       id="inputPrice"
                                       class="custom-input"
                                       placeholder="499"
                                       value="{{ old('price', 499) }}"
                                       min="0"
                                       step="1"
                                       required
                                       oninput="updateLivePreview()">
                                <small class="text-muted">Actual final checkout price.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Shipping & Delivery Details</label>
                            <input type="text"
                                   name="shipping_details"
                                   id="inputShipping"
                                   class="custom-input"
                                   placeholder="e.g. Free delivery across India (Estimated 3-5 business days)"
                                   value="{{ old('shipping_details', 'Free delivery across India (Estimated 3-5 business days)') }}"
                                   oninput="updateLivePreview()">
                        </div>

                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fa-solid fa-shield-check text-success"></i>
                                <span class="fw-bold text-dark small">Verified Seller Guarantee</span>
                            </div>
                            <p class="text-muted small mb-0">
                                100% genuine product guarantee with buyer return protection for physical defects.
                            </p>
                        </div>

                        <div class="wizard-actions-bar">
                            <button type="button" class="btn-step-back" onclick="goToStep(2)">
                                &larr; Back
                            </button>
                            <button type="button" class="btn-step-next" onclick="goToStep(4)">
                                Next &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 4: PREVIEW & PUBLISH                  -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-4">
                        <h2 class="pane-header-title">Preview & Publish</h2>
                        <p class="pane-header-sub">Final review karke publish kare</p>

                        <div class="row g-4 align-items-start">
                            <!-- Left: Interactive Product Card -->
                            <div class="col-lg-5 col-md-6">
                                <div class="product-preview-box">
                                    <div class="preview-thumb-wrap">
                                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80" id="previewImg" alt="Product Thumbnail">
                                        <div class="preview-type-badge" id="previewTypeBadge">Digital Product</div>
                                    </div>
                                    <div class="preview-body">
                                        <div class="preview-title" id="previewTitle">Complete Mathematics Hand-Written Notes (IIT-JEE & NEET)</div>
                                        <div class="preview-desc" id="previewDesc">Comprehensive chapter-wise hand-written study material designed by top faculties.</div>
                                        <div class="preview-rating-row">
                                            <i class="fa-solid fa-star"></i>
                                            <span class="fw-bold text-dark">5.0</span>
                                            <span class="text-muted">(120 reviews) &bull; <span id="previewStockStatus" class="text-success fw-bold">In Stock</span></span>
                                        </div>
                                        <div class="preview-price-row">
                                            <span class="preview-curr-price" id="previewPrice">₹499</span>
                                            <span class="preview-old-price" id="previewMrp">₹999</span>
                                            <span class="preview-discount-badge" id="previewDiscountBadge">50% OFF</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Product Summary Checklist -->
                            <div class="col-lg-7 col-md-6">
                                <div class="border rounded-3 p-3 bg-light bg-opacity-25">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fa-solid fa-circle-check text-success me-1"></i> Product Overview Checklist
                                    </h6>
                                    <table class="table table-sm table-borderless small mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted" style="width: 140px;">Category:</td>
                                                <td class="fw-bold text-dark" id="summaryCategory">Study Notes & PDFs</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Type:</td>
                                                <td class="fw-bold text-dark" id="summaryType">Digital Download</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">SKU:</td>
                                                <td class="fw-bold text-dark" id="summarySku">BK-MATH-2026</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Stock Quantity:</td>
                                                <td class="fw-bold text-dark" id="summaryStock">150 units</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Final Price:</td>
                                                <td class="fw-bold text-success" id="summaryPrice">₹499</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Shipping Terms:</td>
                                                <td class="fw-bold text-dark" id="summaryShipping">Free delivery across India</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-info py-2 px-3 small rounded-3 mt-3 mb-0">
                                    <i class="fa-solid fa-info-circle me-1"></i>
                                    Your product will be submitted for verification and will go live on the Digital Class marketplace catalog upon review.
                                </div>
                            </div>
                        </div>

                        <div class="wizard-actions-bar">
                            <button type="button" class="btn-step-back" onclick="goToStep(3)">
                                &larr; Back
                            </button>
                            <button type="submit" class="btn-step-publish">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Publish Product
                            </button>
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

        for (let i = 1; i <= 4; i++) {
            const pane = document.getElementById('step-pane-' + i);
            const btn = document.getElementById('step-nav-' + i);
            const milestone = document.getElementById('milestone-step-' + i);

            if (pane) pane.classList.add('d-none');
            if (btn) {
                btn.classList.remove('active');
                if (i < step) {
                    btn.classList.add('completed');
                } else {
                    btn.classList.remove('completed');
                }
            }
            if (milestone) {
                milestone.classList.remove('active');
                if (i < step) {
                    milestone.classList.add('completed');
                } else {
                    milestone.classList.remove('completed');
                }
            }
        }

        const activePane = document.getElementById('step-pane-' + step);
        const activeBtn = document.getElementById('step-nav-' + step);
        const activeMilestone = document.getElementById('milestone-step-' + step);

        if (activePane) activePane.classList.remove('d-none');
        if (activeBtn) activeBtn.classList.add('active');
        if (activeMilestone) activeMilestone.classList.add('active');

        updateLivePreview();
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    function handleProductTypeChange() {
        const type = document.getElementById('inputProductType').value;
        const badge = document.getElementById('previewTypeBadge');
        if (badge) {
            badge.textContent = type === 'Digital' ? 'Digital Product' : 'Physical Product';
        }
        updateLivePreview();
    }

    function previewUploadedThumb(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateLivePreview() {
        const title = document.getElementById('inputTitle')?.value || 'Complete Mathematics Hand-Written Notes (IIT-JEE & NEET)';
        const desc = document.getElementById('inputDescription')?.value || 'Comprehensive chapter-wise hand-written study material designed by top faculties.';
        const cat = document.getElementById('inputCategory')?.value || 'Study Notes & PDFs';
        const type = document.getElementById('inputProductType')?.value || 'Digital';
        const sku = document.getElementById('inputSku')?.value || 'BK-MATH-2026';
        const stock = parseInt(document.getElementById('inputStock')?.value) || 0;
        const mrp = parseFloat(document.getElementById('inputMrp')?.value) || 0;
        const price = parseFloat(document.getElementById('inputPrice')?.value) || 0;
        const shipping = document.getElementById('inputShipping')?.value || 'Free delivery across India';
        const thumbUrl = document.getElementById('inputThumbnailUrl')?.value;

        if (document.getElementById('previewTitle')) document.getElementById('previewTitle').textContent = title;
        if (document.getElementById('previewDesc')) document.getElementById('previewDesc').textContent = desc;
        if (document.getElementById('previewPrice')) document.getElementById('previewPrice').textContent = '₹' + price.toLocaleString('en-IN');
        
        if (document.getElementById('previewMrp')) {
            if (mrp > price) {
                document.getElementById('previewMrp').style.display = 'inline';
                document.getElementById('previewMrp').textContent = '₹' + mrp.toLocaleString('en-IN');
            } else {
                document.getElementById('previewMrp').style.display = 'none';
            }
        }

        if (document.getElementById('previewDiscountBadge')) {
            if (mrp > price && mrp > 0) {
                const discount = Math.round(((mrp - price) / mrp) * 100);
                document.getElementById('previewDiscountBadge').style.display = 'inline-block';
                document.getElementById('previewDiscountBadge').textContent = discount + '% OFF';
            } else {
                document.getElementById('previewDiscountBadge').style.display = 'none';
            }
        }

        if (document.getElementById('previewTypeBadge')) {
            document.getElementById('previewTypeBadge').textContent = type === 'Digital' ? 'Digital Product' : 'Physical Product';
        }

        if (document.getElementById('previewStockStatus')) {
            if (stock > 0) {
                document.getElementById('previewStockStatus').textContent = 'In Stock (' + stock + ')';
                document.getElementById('previewStockStatus').className = 'text-success fw-bold';
            } else {
                document.getElementById('previewStockStatus').textContent = 'Out of Stock';
                document.getElementById('previewStockStatus').className = 'text-danger fw-bold';
            }
        }

        if (thumbUrl && document.getElementById('previewImg') && !document.getElementById('inputThumbnailFile')?.files?.length) {
            document.getElementById('previewImg').src = thumbUrl;
        }

        if (document.getElementById('summaryCategory')) document.getElementById('summaryCategory').textContent = cat;
        if (document.getElementById('summaryType')) document.getElementById('summaryType').textContent = type === 'Digital' ? 'Digital Download' : 'Physical Parcel';
        if (document.getElementById('summarySku')) document.getElementById('summarySku').textContent = sku;
        if (document.getElementById('summaryStock')) document.getElementById('summaryStock').textContent = stock + ' units';
        if (document.getElementById('summaryPrice')) document.getElementById('summaryPrice').textContent = '₹' + price.toLocaleString('en-IN');
        if (document.getElementById('summaryShipping')) document.getElementById('summaryShipping').textContent = shipping;
    }
</script>
@endsection
