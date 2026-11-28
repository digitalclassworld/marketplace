@extends('seller.layouts.seller')

@section('title', 'Add Service - Digital Class Seller')

@section('styles')
<style>
    /* Service Add Process Theme Styles */
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
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
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
        border-color: #0284c7;
        background: #f0f9ff;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.12);
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
        background: #0284c7;
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
        color: #0284c7;
    }
    .milestone-sub {
        font-size: 0.68rem;
        color: #64748b;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* 2-Column Form Card */
    .service-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }
    .service-form-grid {
        display: grid;
        grid-template-columns: 270px 1fr;
        min-height: 600px;
    }
    .service-steps-sidebar {
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
        padding: 0.75rem 0.9rem;
        border-radius: 10px;
        border: 1px solid transparent;
        background: transparent;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        text-align: left;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .sidebar-step-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .sidebar-step-btn.active {
        background: #f0f9ff;
        border-color: #bae6fd;
        color: #0284c7;
        font-weight: 700;
    }
    .sidebar-step-btn.completed {
        color: #059669;
    }
    .sidebar-step-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        font-weight: 800;
        flex-shrink: 0;
    }
    .sidebar-step-btn.active .sidebar-step-num {
        background: #0284c7;
        color: #ffffff;
    }
    .sidebar-step-btn.completed .sidebar-step-num {
        background: #10b981;
        color: #ffffff;
    }

    /* Right Form Content Pane */
    .service-form-content {
        padding: 2rem 2.25rem;
        background: #ffffff;
    }
    .pane-header-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }
    .pane-header-sub {
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 1.75rem;
    }

    /* Form Fields */
    .field-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .field-label .req {
        color: #ef4444;
        margin-left: 2px;
    }
    .custom-input, .custom-select, .custom-textarea {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.65rem 0.9rem;
        font-size: 0.875rem;
        color: #0f172a;
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #ffffff;
    }
    .custom-input:focus, .custom-select:focus, .custom-textarea:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        outline: none;
    }

    /* Live Preview Card */
    .service-preview-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        max-width: 360px;
    }
    .preview-thumb-wrap {
        width: 100%;
        height: 180px;
        background: #0f172a;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .preview-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-body {
        padding: 1rem 1.15rem;
    }
    .preview-title {
        font-weight: 800;
        font-size: 0.95rem;
        color: #0f172a;
        line-height: 1.3;
        margin-bottom: 0.4rem;
    }
    .preview-desc {
        font-size: 0.76rem;
        color: #64748b;
        line-height: 1.35;
        margin-bottom: 0.65rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .preview-rating-row {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: #f59e0b;
        margin-bottom: 0.65rem;
    }
    .preview-price-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
    }
    .preview-curr-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Wizard Actions */
    .wizard-actions-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 1.25rem;
        border-top: 1px solid #f1f5f9;
    }
    .btn-step-back {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.55rem 1.25rem;
        border-radius: 8px;
        transition: all 0.15s;
    }
    .btn-step-back:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .btn-step-next {
        background: #0284c7;
        border: 1px solid #0284c7;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.55rem 1.4rem;
        border-radius: 8px;
        transition: all 0.15s;
    }
    .btn-step-next:hover {
        background: #0369a1;
        border-color: #0369a1;
        color: #ffffff;
    }
    .btn-step-publish {
        background: #10b981;
        border: 1px solid #10b981;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.88rem;
        padding: 0.6rem 1.6rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        transition: all 0.15s;
    }
    .btn-step-publish:hover {
        background: #059669;
        border-color: #059669;
        color: #ffffff;
    }

    @media (max-width: 991px) {
        .milestone-steps-row {
            grid-template-columns: 1fr;
        }
        .service-form-grid {
            grid-template-columns: 1fr;
        }
        .service-steps-sidebar {
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Top Process Hero Banner -->
    <div class="process-hero-banner">
        <div class="process-hero-icon">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div>
            <h1 class="process-hero-title">Service Add Process</h1>
            <p class="process-hero-sub">Sell freelance, educational & institutional services</p>
        </div>
    </div>

    <!-- 5-Stage Milestone Flow Bar -->
    <div class="milestone-steps-row">
        <!-- 1. Go to Add Service -->
        <div class="milestone-step-card completed">
            <div class="milestone-badge"><i class="fa-solid fa-check"></i></div>
            <div>
                <div class="milestone-title">1. Go to Add Service</div>
                <div class="milestone-sub">Seller dashboard se Add Service par click kare</div>
            </div>
        </div>

        <!-- 2. Basic Information -->
        <div class="milestone-step-card active" id="milestone-step-1">
            <div class="milestone-badge">2</div>
            <div>
                <div class="milestone-title">2. Basic Information</div>
                <div class="milestone-sub">Service ka basic details fill kare</div>
            </div>
        </div>

        <!-- 3. Service Deliverables -->
        <div class="milestone-step-card" id="milestone-step-2">
            <div class="milestone-badge">3</div>
            <div>
                <div class="milestone-title">3. Service Deliverables</div>
                <div class="milestone-sub">Scope, deliverables aur timeline add kare</div>
            </div>
        </div>

        <!-- 4. Pricing & Packages -->
        <div class="milestone-step-card" id="milestone-step-3">
            <div class="milestone-badge">4</div>
            <div>
                <div class="milestone-title">4. Pricing & Packages</div>
                <div class="milestone-sub">Package price aur features set kare</div>
            </div>
        </div>

        <!-- 5. Preview & Publish -->
        <div class="milestone-step-card" id="milestone-step-4">
            <div class="milestone-badge">5</div>
            <div>
                <div class="milestone-title">5. Preview & Publish</div>
                <div class="milestone-sub">Final review karke publish kare</div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Please fix the errors below:</strong>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Service Wizard Form -->
    <form action="{{ route('seller.services.store') }}" method="POST" id="serviceAddForm" enctype="multipart/form-data">
        @csrf

        <div class="service-form-card">
            <div class="service-form-grid">

                <!-- Left Sidebar: 4 Form Steps -->
                <div class="service-steps-sidebar">
                    <div class="steps-sidebar-heading">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <span>Add New Service</span>
                    </div>

                    <button type="button" class="sidebar-step-btn active" id="step-nav-1" onclick="goToStep(1)">
                        <span class="sidebar-step-num">1</span>
                        <span>Basic Information</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-2" onclick="goToStep(2)">
                        <span class="sidebar-step-num">2</span>
                        <span>Service Deliverables</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-3" onclick="goToStep(3)">
                        <span class="sidebar-step-num">3</span>
                        <span>Pricing & Packages</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-4" onclick="goToStep(4)">
                        <span class="sidebar-step-num">4</span>
                        <span>Preview & Publish</span>
                    </button>
                </div>

                <!-- Right Form Content Area -->
                <div class="service-form-content">

                    <!-- ========================================== -->
                    <!-- STEP 1: BASIC INFORMATION                  -->
                    <!-- ========================================== -->
                    <div class="step-pane" id="step-pane-1">
                        <h2 class="pane-header-title">Basic Information</h2>
                        <p class="pane-header-sub">Provide the essential details about your service</p>

                        <div class="mb-3">
                            <label class="field-label">Service Title <span class="req">*</span></label>
                            <input type="text"
                                   name="title"
                                   id="inputTitle"
                                   class="custom-input @error('title') is-invalid @enderror"
                                   placeholder="e.g. Website Development for Institute"
                                   value="{{ old('title', 'Website Development for Institute') }}"
                                   required
                                   oninput="updateLivePreview()">
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Category <span class="req">*</span></label>
                            <select name="category" id="inputCategory" class="custom-select" required onchange="updateLivePreview()">
                                <option value="Web Development" {{ old('category') == 'Web Development' ? 'selected' : '' }}>Web Development & Design</option>
                                <option value="Digital Marketing" {{ old('category') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing & SEO</option>
                                <option value="Graphic Design" {{ old('category') == 'Graphic Design' ? 'selected' : '' }}>Graphics & Banner Design</option>
                                <option value="Consulting" {{ old('category') == 'Consulting' ? 'selected' : '' }}>Education Consulting & Guidance</option>
                                <option value="Content Writing" {{ old('category') == 'Content Writing' ? 'selected' : '' }}>Content & Resume Making</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Short Description <span class="req">*</span></label>
                            <textarea name="short_description"
                                      id="inputShortDesc"
                                      rows="3"
                                      class="custom-textarea"
                                      placeholder="Professional institute website with student admission forms and live payment support."
                                      required
                                      oninput="updateLivePreview()">{{ old('short_description', 'Professional institute website with student admission forms and live payment support.') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Search Tags (Comma separated)</label>
                            <input type="text"
                                   name="tags"
                                   id="inputTags"
                                   class="custom-input"
                                   placeholder="web development, institute website, wordpress, responsive"
                                   value="{{ old('tags', 'web development, institute website, wordpress') }}">
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Service Thumbnail (Upload File or Enter Image URL)</label>
                            <input type="file" name="thumbnail_file" id="inputThumbnailFile" class="form-control form-control-sm mb-2" accept="image/*" onchange="previewUploadedThumb(this)">
                            <input type="text"
                                   name="thumbnail"
                                   id="inputThumbnailUrl"
                                   class="custom-input"
                                   placeholder="Or enter direct image URL (optional)"
                                   value="{{ old('thumbnail') }}"
                                   oninput="updateLivePreview()">
                            <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Leave empty to use the standard default service thumbnail.</small>
                        </div>

                        <div class="wizard-actions-bar">
                            <div></div>
                            <button type="button" class="btn-step-next" onclick="goToStep(2)">
                                Next &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 2: SERVICE DELIVERABLES               -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-2">
                        <h2 class="pane-header-title">Service Deliverables</h2>
                        <p class="pane-header-sub">Scope, deliverables aur timeline add kare</p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="field-label">Package Name <span class="req">*</span></label>
                                <input type="text"
                                       name="package_name"
                                       id="inputPackageName"
                                       class="custom-input"
                                       placeholder="Complete Website Package"
                                       value="{{ old('package_name', 'Complete Website Package') }}"
                                       required
                                       oninput="updateLivePreview()">
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Delivery Timeline (Days) <span class="req">*</span></label>
                                <input type="number"
                                       name="delivery_days"
                                       id="inputDeliveryDays"
                                       class="custom-input"
                                       placeholder="7"
                                       value="{{ old('delivery_days', 7) }}"
                                       min="1"
                                       required
                                       oninput="updateLivePreview()">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Package Features & Inclusions</label>
                            <textarea name="package_features"
                                      id="inputFeatures"
                                      rows="3"
                                      class="custom-textarea"
                                      placeholder="✔ 5 Custom Pages (Home, Courses, Faculty, About, Contact)&#10;✔ Mobile & Tablet Responsive&#10;✔ Inquiry Form with Email Notifications&#10;✔ Free 1 Year Domain & Hosting Setup">{{ old('package_features', "✔ 5 Custom Pages (Home, Courses, Faculty, About, Contact)\n✔ Mobile & Tablet Responsive\n✔ Inquiry Form with Email Notifications") }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Buyer Requirements (What you need to start)</label>
                            <textarea name="buyer_requirements"
                                      id="inputRequirements"
                                      rows="2"
                                      class="custom-textarea"
                                      placeholder="Please provide your institute logo, list of courses, contact details, and faculty pictures.">{{ old('buyer_requirements', 'Please provide your institute logo, list of courses, and contact details.') }}</textarea>
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
                    <!-- STEP 3: PRICING & PACKAGES                 -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-3">
                        <h2 class="pane-header-title">Pricing & Packages</h2>
                        <p class="pane-header-sub">Package price aur features set kare</p>

                        <div class="mb-4">
                            <label class="field-label">Package Price (₹) <span class="req">*</span></label>
                            <input type="number"
                                   name="price"
                                   id="inputPrice"
                                   class="custom-input"
                                   placeholder="4999"
                                   value="{{ old('price', 4999) }}"
                                   min="0"
                                   step="1"
                                   required
                                   oninput="updateLivePreview()">
                        </div>

                        <div class="border rounded-3 p-3 bg-light bg-opacity-50 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fa-solid fa-shield-check text-success"></i>
                                <span class="fw-bold text-dark small">Digital Class Escrow Protection</span>
                            </div>
                            <p class="text-muted small mb-0">
                                Client payment will be held securely in escrow and released to your wallet upon successful delivery.
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
                            <!-- Left: Live Service Card -->
                            <div class="col-lg-5 col-md-6">
                                <div class="service-preview-box">
                                    <div class="preview-thumb-wrap">
                                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=80" id="previewImg" alt="Service Thumbnail">
                                    </div>
                                    <div class="preview-body">
                                        <div class="preview-title" id="previewTitle">Website Development for Institute</div>
                                        <div class="preview-desc" id="previewDesc">Professional institute website with student admission forms and live payment support.</div>
                                        <div class="preview-rating-row">
                                            <i class="fa-solid fa-star"></i>
                                            <span class="fw-bold text-dark">5.0</span>
                                            <span class="text-muted">(48 reviews) &bull; <span id="previewDays">7 Days Delivery</span></span>
                                        </div>
                                        <div class="preview-price-row">
                                            <div>
                                                <span class="text-muted small d-block" style="font-size: 0.7rem;">Starting At</span>
                                                <span class="preview-curr-price" id="previewPrice">₹4,999</span>
                                            </div>
                                            <span class="badge bg-primary bg-opacity-10 text-primary small px-2 py-1" id="previewPkg">Complete Website</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Service Summary Checklist -->
                            <div class="col-lg-7 col-md-6">
                                <div class="border rounded-3 p-3 bg-light bg-opacity-25">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fa-solid fa-circle-check text-success me-1"></i> Service Deliverables Summary
                                    </h6>
                                    <table class="table table-sm table-borderless small mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted" style="width: 140px;">Category:</td>
                                                <td class="fw-bold text-dark" id="summaryCategory">Web Development</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Package:</td>
                                                <td class="fw-bold text-dark" id="summaryPackage">Complete Website Package</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Delivery:</td>
                                                <td class="fw-bold text-dark" id="summaryDelivery">7 Days</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Price:</td>
                                                <td class="fw-bold text-success" id="summaryPrice">₹4,999</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-info py-2 px-3 small rounded-3 mt-3 mb-0">
                                    <i class="fa-solid fa-info-circle me-1"></i>
                                    Your service will be immediately published in your store and open for client orders.
                                </div>
                            </div>
                        </div>

                        <div class="wizard-actions-bar">
                            <button type="button" class="btn-step-back" onclick="goToStep(3)">
                                &larr; Back
                            </button>
                            <button type="submit" class="btn-step-publish">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Publish Service
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
        const title = document.getElementById('inputTitle')?.value || 'Website Development for Institute';
        const desc = document.getElementById('inputShortDesc')?.value || 'Professional institute website with student admission forms.';
        const cat = document.getElementById('inputCategory')?.value || 'Web Development';
        const pkg = document.getElementById('inputPackageName')?.value || 'Complete Website Package';
        const days = document.getElementById('inputDeliveryDays')?.value || 7;
        const price = parseFloat(document.getElementById('inputPrice')?.value) || 0;
        const thumbUrl = document.getElementById('inputThumbnailUrl')?.value;

        if (document.getElementById('previewTitle')) document.getElementById('previewTitle').textContent = title;
        if (document.getElementById('previewDesc')) document.getElementById('previewDesc').textContent = desc;
        if (document.getElementById('previewDays')) document.getElementById('previewDays').textContent = days + ' Days Delivery';
        if (document.getElementById('previewPrice')) document.getElementById('previewPrice').textContent = '₹' + price.toLocaleString('en-IN');
        if (document.getElementById('previewPkg')) document.getElementById('previewPkg').textContent = pkg;
        if (thumbUrl && document.getElementById('previewImg') && !document.getElementById('inputThumbnailFile')?.files?.length) {
            document.getElementById('previewImg').src = thumbUrl;
        }

        if (document.getElementById('summaryCategory')) document.getElementById('summaryCategory').textContent = cat;
        if (document.getElementById('summaryPackage')) document.getElementById('summaryPackage').textContent = pkg;
        if (document.getElementById('summaryDelivery')) document.getElementById('summaryDelivery').textContent = days + ' Days';
        if (document.getElementById('summaryPrice')) document.getElementById('summaryPrice').textContent = '₹' + price.toLocaleString('en-IN');
    }
</script>
@endsection
