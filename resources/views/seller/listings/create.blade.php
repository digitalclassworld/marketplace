@extends('seller.layouts.seller')

@section('title', 'Add Business Listing - Digital Class Seller')

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
        gap: 0.5rem;
        padding: 0.4rem 0.75rem;
        border-radius: 10px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        flex-shrink: 0;
    }
    .wizard-step-item.active {
        background-color: #eff6ff;
        color: #0066ff;
        font-weight: 700;
    }
    .wizard-step-item.completed {
        color: #10b981;
    }
    .wizard-step-num {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: #475569;
    }
    .wizard-step-item.active .wizard-step-num {
        background: #0066ff;
        color: #ffffff;
    }
    .wizard-step-item.completed .wizard-step-num {
        background: #10b981;
        color: #ffffff;
    }
    .wizard-step-title {
        font-size: 0.825rem;
        line-height: 1.2;
    }
    .wizard-step-sub {
        font-size: 0.675rem;
        color: #94a3b8;
        display: block;
        font-weight: 400;
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
    }
    .pricing-plan-card:hover {
        border-color: #cbd5e1;
    }
    .pricing-plan-card.selected {
        border-color: #0066ff;
        background: #f8faff;
        box-shadow: 0 8px 24px -8px rgba(0, 102, 255, 0.2);
    }

    .font-mono-code {
        font-family: var(--dc-font-mono) !important;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.5rem;">
                Add Business Listing
            </h2>
            <p class="text-muted small mb-0">List your business and showcase it to thousands of potential customers</p>
        </div>
        <a href="{{ route('seller.listings.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Listings
        </a>
    </div>

    <!-- Multi-Step Stepper Navigation (1 to 7) -->
    <div class="wizard-steps-container">
        <div class="wizard-step-item active" id="step-nav-1" onclick="goToStep(1)">
            <div class="wizard-step-num">1</div>
            <div>
                <span class="wizard-step-title">Choose Listing Type</span>
                <span class="wizard-step-sub">Select type of listing</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-2" onclick="goToStep(2)">
            <div class="wizard-step-num">2</div>
            <div>
                <span class="wizard-step-title">Basic Information</span>
                <span class="wizard-step-sub">Business basic details</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-3" onclick="goToStep(3)">
            <div class="wizard-step-num">3</div>
            <div>
                <span class="wizard-step-title">Business Details</span>
                <span class="wizard-step-sub">Complete information</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-4" onclick="goToStep(4)">
            <div class="wizard-step-num">4</div>
            <div>
                <span class="wizard-step-title">Media & Gallery</span>
                <span class="wizard-step-sub">Images, logo & videos</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-5" onclick="goToStep(5)">
            <div class="wizard-step-num">5</div>
            <div>
                <span class="wizard-step-title">Contact & Location</span>
                <span class="wizard-step-sub">Contact & address</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-6" onclick="goToStep(6)">
            <div class="wizard-step-num">6</div>
            <div>
                <span class="wizard-step-title">Plan & Publish</span>
                <span class="wizard-step-sub">Listing plan & add-ons</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-7" onclick="goToStep(7)">
            <div class="wizard-step-num">7</div>
            <div>
                <span class="wizard-step-title">Preview & Publish</span>
                <span class="wizard-step-sub">Final review</span>
            </div>
        </div>
    </div>

    <!-- Main Wizard Form -->
    <form action="{{ route('seller.listings.store') }}" method="POST" id="listingWizardForm" novalidate>
        @csrf

        <!-- ================= STEP 1: CHOOSE LISTING TYPE ================= -->
        <div class="wizard-step-content" id="step-content-1">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Listing Type</h5>
                    <p class="text-muted small mb-0">Select the type that best describes your business or enterprise</p>
                </div>

                <input type="hidden" name="listing_type" id="inputListingType" value="Business Profile">

                <!-- 1. Business Profile -->
                <div class="type-select-card selected" onclick="selectType('Business Profile', this)">
                    <input type="radio" name="type_radio" class="form-check-input flex-shrink-0" checked>
                    <div class="type-icon-box" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Business Profile</h6>
                        <small class="text-muted">Showcase your business, services, contact details and get inquiries.</small>
                    </div>
                </div>

                <!-- 2. Service Provider -->
                <div class="type-select-card" onclick="selectType('Service Provider', this)">
                    <input type="radio" name="type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Service Provider</h6>
                        <small class="text-muted">List your business as a professional service provider.</small>
                    </div>
                </div>

                <!-- 3. Manufacturer / Supplier -->
                <div class="type-select-card" onclick="selectType('Manufacturer / Supplier', this)">
                    <input type="radio" name="type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #dcfce7; color: #16a34a;">
                        <i class="fa-solid fa-industry"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Manufacturer / Supplier</h6>
                        <small class="text-muted">Show your manufacturing business and products.</small>
                    </div>
                </div>

                <!-- 4. Institute / Training Center -->
                <div class="type-select-card" onclick="selectType('Institute / Training Center', this)">
                    <input type="radio" name="type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #ede9fe; color: #7c3aed;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Institute / Training Center</h6>
                        <small class="text-muted">List your institute, coaching or training center.</small>
                    </div>
                </div>

                <!-- 5. Other Business -->
                <div class="type-select-card" onclick="selectType('Other Business', this)">
                    <input type="radio" name="type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #f1f5f9; color: #475569;">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Other Business</h6>
                        <small class="text-muted">Any other type of business.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(2)">
                        Continue &rarr;
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 2: BASIC BUSINESS INFORMATION ================= -->
        <div class="wizard-step-content d-none" id="step-content-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Basic Information</h5>
                    <p class="text-muted small mb-0">Add your business basic details</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Business Name <span class="text-danger">*</span></label>
                    <input type="text" name="business_name" id="inputBusinessName" class="form-control" placeholder="e.g. Apex Coding Academy & Training Institute" value="{{ old('business_name', 'VCEC - Vinayak Computer Education Center') }}" required>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">Short Description <span class="text-danger">*</span></label>
                        <small class="text-muted" id="shortDescCounter">135/300</small>
                    </div>
                    <textarea name="tagline" class="form-control" rows="3" maxlength="300" placeholder="Brief summary of your institute or business..." oninput="document.getElementById('shortDescCounter').textContent = this.value.length + '/300'">{{ old('tagline', 'Professional computer education and skill development institute in Ahmedabad. We offer computer courses, digital marketing, Tally, CCC, programming and more.') }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Business Category <span class="text-danger">*</span></label>
                        <select name="category" id="inputCategory" class="form-select" required>
                            <option value="Education & Training" {{ old('category', 'Education & Training') == 'Education & Training' ? 'selected' : '' }}>Education & Training</option>
                            <option value="Software & IT Agency">Software & IT Agency</option>
                            <option value="Design & Media Studio">Design & Media Studio</option>
                            <option value="Manufacturing & Supply">Manufacturing & Supply</option>
                            <option value="Professional Services">Professional Services</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Sub Category <span class="text-danger">*</span></label>
                        <select name="sub_category" id="inputSubCategory" class="form-select">
                            <option value="Computer Training Institute" {{ old('sub_category', 'Computer Training Institute') == 'Computer Training Institute' ? 'selected' : '' }}>Computer Training Institute</option>
                            <option value="Coaching Academy">Coaching Academy</option>
                            <option value="Language School">Language School</option>
                            <option value="Vocational Center">Vocational Center</option>
                            <option value="Software Agency">Software Agency</option>
                            <option value="Consulting Firm">Consulting Firm</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Year of Establishment</label>
                        <input type="text" name="established_year" id="inputYear" class="form-control" placeholder="e.g. 2020" value="{{ old('established_year', '2015') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Number of Employees</label>
                        <select name="employees_count" id="inputEmployees" class="form-select">
                            <option value="1 - 5">1 - 5</option>
                            <option value="5 - 10" {{ old('employees_count', '5 - 10') == '5 - 10' ? 'selected' : '' }}>5 - 10</option>
                            <option value="10 - 25">10 - 25</option>
                            <option value="25 - 50">25 - 50</option>
                            <option value="50+">50+</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(1)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(3)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 3: BUSINESS DETAILS ================= -->
        <div class="wizard-step-content d-none" id="step-content-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Business Details</h5>
                    <p class="text-muted small mb-0">Add complete information about your business</p>
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
                    <textarea name="description" class="form-control rounded-top-0" rows="5" maxlength="1000" placeholder="Provide complete information about your institute, business services, faculty and offerings..." oninput="document.getElementById('descCounter').textContent = this.value.length + '/1000'">{{ old('description', 'VCEC is a trusted computer education center providing industry-relevant courses for students, professionals and business owners. Our mission is to make everyone digitally skilled and job-ready with practical training.') }}</textarea>
                </div>

                <!-- Key Features / Highlights -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small mb-2">Key Features / Highlights</label>
                    <div id="highlightsContainer" class="d-flex flex-column gap-2">
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
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 fw-semibold" onclick="addHighlightRow()">
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

                <!-- Business Logo -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Business Logo <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 border d-flex flex-column align-items-center justify-content-center p-2 bg-light flex-shrink-0" style="width: 80px; height: 80px;">
                            <span class="fw-bold text-primary display-heading fs-4">V</span>
                            <small class="fw-bold text-dark" style="font-size: 0.65rem;">VCEC</small>
                        </div>
                        <div class="p-3 border border-dashed rounded-3 flex-grow-1 text-center bg-light bg-opacity-25" style="border-style: dashed !important; cursor: pointer;">
                            <i class="fa-solid fa-cloud-arrow-up text-primary fs-4 mb-1"></i>
                            <div class="fw-bold small text-dark">Upload Logo</div>
                            <small class="text-muted">PNG, JPG (Max 2MB)</small>
                            <input type="hidden" name="logo" value="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=200">
                        </div>
                    </div>
                </div>

                <!-- Cover Image / Banner -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Cover Image / Banner</label>
                    <div class="p-4 rounded-3 text-center text-white mb-3 position-relative overflow-hidden" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800') center/cover; min-height: 140px;">
                        <span class="badge bg-dark bg-opacity-75 position-absolute top-0 end-0 m-2" style="cursor: pointer;"><i class="fa-solid fa-xmark"></i></span>
                        <h5 class="display-heading fw-bold mb-0 mt-3 text-white">SKILL TODAY BETTER TOMORROW</h5>
                        <small class="text-white-50">Cover Banner Preview</small>
                    </div>
                    <input type="hidden" name="cover_image" value="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800">

                    <!-- Gallery Thumbnails -->
                    <div class="d-flex flex-wrap gap-2">
                        <div class="rounded-2 border overflow-hidden position-relative" style="width: 70px; height: 50px;">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=200" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="rounded-2 border overflow-hidden position-relative" style="width: 70px; height: 50px;">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=200" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="rounded-2 border overflow-hidden position-relative" style="width: 70px; height: 50px;">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=200" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="rounded-2 border border-dashed d-flex flex-column align-items-center justify-content-center text-muted" style="width: 70px; height: 50px; cursor: pointer; font-size: 0.65rem;">
                            <i class="fa-solid fa-plus"></i>
                            <span>Add More</span>
                        </div>
                    </div>
                </div>

                <!-- Intro Video (Optional) -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Intro Video (Optional)</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 border overflow-hidden position-relative flex-shrink-0" style="width: 90px; height: 60px;">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200" class="w-100 h-100 object-fit-cover">
                            <span class="position-absolute top-50 start-50 translate-middle text-white fs-5"><i class="fa-solid fa-circle-play"></i></span>
                        </div>
                        <div class="p-3 border border-dashed rounded-3 flex-grow-1 text-center bg-light bg-opacity-25" style="border-style: dashed !important; cursor: pointer;">
                            <i class="fa-solid fa-video text-primary fs-4 mb-1"></i>
                            <div class="fw-bold small text-dark">Upload Video</div>
                            <small class="text-muted">MP4 (Max 100MB)</small>
                            <input type="hidden" name="video_url" value="https://example.com/intro-video.mp4">
                        </div>
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
                            <input type="text" name="phone" id="inputPhone" class="form-control" placeholder="Enter 10-digit mobile number" value="{{ old('phone', '9876543210') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold text-dark small mb-0">WhatsApp Number</label>
                            <div class="form-check form-check-inline me-0">
                                <input class="form-check-input" type="checkbox" id="samePhoneCheck" checked onchange="document.getElementById('inputWhatsapp').value = this.checked ? document.getElementById('inputPhone').value : ''">
                                <label class="form-check-label small text-muted" for="samePhoneCheck" style="font-size: 0.725rem;">Same as business phone</label>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="text" name="whatsapp_number" id="inputWhatsapp" class="form-control" placeholder="Enter WhatsApp number" value="{{ old('whatsapp_number', '9876543210') }}">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Business Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="contact@yourbusiness.com" value="{{ old('email', 'info@vcec.in') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Website (Optional)</label>
                        <input type="url" name="website" id="inputWebsite" class="form-control" placeholder="https://www.yourbusiness.com" value="{{ old('website', 'https://www.vcec.in') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="inputAddress" class="form-control" placeholder="Floor, Building, Street, Landmark" value="{{ old('address', '3rd Floor, Shreeji Complex, Nikol, Ahmedabad - 382350') }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" id="inputCity" class="form-control" placeholder="Ahmedabad" value="{{ old('city', 'Ahmedabad') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" id="inputState" class="form-control" placeholder="Gujarat" value="{{ old('state', 'Gujarat') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" id="inputPincode" class="form-control font-mono-code" placeholder="380001" value="{{ old('pincode', '382350') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Google Maps Location</label>
                    <div class="input-group mb-2">
                        <input type="text" name="map_location" id="inputMap" class="form-control" placeholder="Google Maps share link or location URL" value="{{ old('map_location', 'https://maps.google.com/?q=VCEC+Nikol') }}">
                        <button class="btn btn-outline-primary fw-semibold" type="button">Get Location</button>
                    </div>
                    <!-- Miniature Map Preview Card Matching Screenshot -->
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

        <!-- ================= STEP 6: PLAN & PUBLISH ================= -->
        <div class="wizard-step-content d-none" id="step-content-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Plan & Publish</h5>
                    <p class="text-muted small mb-0">Choose a listing plan and publish your business</p>
                </div>

                <input type="hidden" name="plan_name" id="inputPlanName" value="Premium Listing">
                <input type="hidden" name="plan_price" id="inputPlanPrice" value="1499.00">

                <div class="row g-3 mb-4">
                    <!-- Plan 1: Free Listing -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card" id="cardPlanFree" onclick="selectPlan('Free Listing', 0, this)">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="plan_radio" class="form-check-input">
                                <h6 class="fw-bold text-dark mb-0">Free Listing</h6>
                            </div>
                            <div class="display-heading fw-bold text-dark mb-3" style="font-size: 1.4rem;">
                                ₹0 <small class="text-muted fs-6 fw-normal">/ lifetime</small>
                            </div>
                            <ul class="list-unstyled small text-secondary flex-grow-1 mb-3">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Basic business profile</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> 3 images</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Appear in search results</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Get customer inquiries</li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 fw-semibold">Select Plan</button>
                        </div>
                    </div>

                    <!-- Plan 2: Premium Listing (Most Popular) -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card selected" id="cardPlanPremium" onclick="selectPlan('Premium Listing', 1499, this)">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2 rounded-pill px-2 py-1" style="font-size: 0.65rem;">Most Popular</span>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="plan_radio" class="form-check-input" checked>
                                <h6 class="fw-bold text-dark mb-0">Premium Listing</h6>
                            </div>
                            <div class="display-heading fw-bold text-dark mb-3" style="font-size: 1.4rem;">
                                ₹1,499 <small class="text-muted fs-6 fw-normal">/ year</small>
                            </div>
                            <ul class="list-unstyled small text-secondary flex-grow-1 mb-3">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Business profile with banner</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> 10 images + 1 video</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Featured in search results</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Show contact details</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Get verified badge</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Priority in listings</li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-sm w-100 fw-semibold" style="background-color: #0066ff;">Selected &check;</button>
                        </div>
                    </div>

                    <!-- Plan 3: Featured Listing -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card" id="cardPlanFeatured" onclick="selectPlan('Featured Listing', 2999, this)">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="plan_radio" class="form-check-input">
                                <h6 class="fw-bold text-dark mb-0">Featured Listing</h6>
                            </div>
                            <div class="display-heading fw-bold text-dark mb-3" style="font-size: 1.4rem;">
                                ₹2,999 <small class="text-muted fs-6 fw-normal">/ year</small>
                            </div>
                            <ul class="list-unstyled small text-secondary flex-grow-1 mb-3">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> All Premium features</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Top position in category</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Homepage featured</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Special highlight badge</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> More visibility & leads</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Dedicated support</li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 fw-semibold">Select Plan</button>
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
                                    <input class="form-check-input" type="checkbox" name="add_ons[]" value="Verified Business Badge" id="addon1" checked onchange="updateSummary()">
                                    <label class="form-check-label small fw-semibold text-dark" for="addon1">
                                        Verified Business Badge
                                    </label>
                                </div>
                                <span class="fw-bold text-dark font-mono-code small">₹499 / year</span>
                            </div>

                            <div class="p-3 border rounded-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="add_ons[]" value="Additional Gallery Images" id="addon2" onchange="updateSummary()">
                                    <label class="form-check-label small fw-semibold text-dark" for="addon2">
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
                                <span class="text-muted" id="summaryPlanText">Premium Listing (1 Year)</span>
                                <span class="fw-semibold font-mono-code" id="summaryPlanPrice">₹1,499</span>
                            </div>
                            <div class="d-flex justify-content-between py-1 small" id="summaryBadgeRow">
                                <span class="text-muted">Verified Business Badge</span>
                                <span class="fw-semibold font-mono-code">₹499</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top mt-2 fw-bold text-dark">
                                <span>Total:</span>
                                <span class="font-mono-code text-primary fs-6" id="summaryTotalPrice">₹1,998</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(5)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(7)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 7: PREVIEW & PUBLISH ================= -->
        <div class="wizard-step-content d-none" id="step-content-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="display-heading fw-bold text-dark mb-1">Preview & Publish</h5>
                        <p class="text-muted small mb-0">Review your listing and publish</p>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary fw-semibold px-3" style="background-color: #0066ff;">Desktop View</button>
                        <button type="button" class="btn btn-outline-secondary fw-semibold px-3">Mobile View</button>
                    </div>
                </div>

                <!-- Full Business Directory Live Card Preview (Matching Page 40) -->
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
                                    <span class="fw-bold text-primary display-heading fs-5" id="previewLogoChar">V</span>
                                    <small class="fw-bold text-dark" style="font-size: 0.6rem;" id="previewLogoSub">VCEC</small>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <h5 class="display-heading fw-bold text-dark mb-0" id="previewTitle">
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
                                        <span class="text-muted" id="previewCategory">Computer Training Institute • Education & Training</span>
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
                            <div><i class="fa-regular fa-calendar text-muted me-1"></i> Year <strong class="text-dark" id="previewYear">2015</strong></div>
                            <div><i class="fa-solid fa-users text-muted me-1"></i> Employees <strong class="text-dark" id="previewEmployees">5 - 10</strong></div>
                            <div><i class="fa-solid fa-location-dot text-danger me-1"></i> Location <strong class="text-dark" id="previewLocation">Ahmedabad, Gujarat</strong></div>
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
                            <h6 class="fw-bold text-dark mb-2" id="previewAboutHeading">About VCEC - Vinayak Computer Education Center</h6>
                            <p class="text-muted small mb-0" id="previewAbout">
                                VCEC is a trusted computer education center providing industry-relevant courses for students, professionals and business owners. Our mission is to make everyone digitally skilled and job-ready with practical training.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(6)">&larr; Back</button>
                    <button type="submit" class="btn btn-success px-5 fw-bold btn-lg shadow-sm">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Publish Listing
                    </button>
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

        // Hide all step contents
        for (let i = 1; i <= 7; i++) {
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

        // Show active content
        const activeContent = document.getElementById('step-content-' + step);
        const activeNav = document.getElementById('step-nav-' + step);
        if (activeContent) activeContent.classList.remove('d-none');
        if (activeNav) activeNav.classList.add('active');

        // Scroll smoothly to top
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Update step 7 preview fields dynamically
        if (step === 7) {
            const bName = document.getElementById('inputBusinessName')?.value;
            const bCat = document.getElementById('inputCategory')?.value;
            const bSub = document.getElementById('inputSubCategory')?.value;
            const bYear = document.getElementById('inputYear')?.value;
            const bEmp = document.getElementById('inputEmployees')?.value;
            const bCity = document.getElementById('inputCity')?.value;
            const bState = document.getElementById('inputState')?.value;
            const bDesc = document.querySelector('textarea[name="description"]')?.value;

            if (bName) {
                document.getElementById('previewTitle').textContent = bName;
                document.getElementById('previewAboutHeading').textContent = 'About ' + bName;
                document.getElementById('previewLogoChar').textContent = bName.charAt(0).toUpperCase();
                document.getElementById('previewLogoSub').textContent = bName.split(' ')[0].substring(0, 4).toUpperCase();
            }
            if (bCat && bSub) document.getElementById('previewCategory').textContent = bSub + ' • ' + bCat;
            if (bYear) document.getElementById('previewYear').textContent = bYear;
            if (bEmp) document.getElementById('previewEmployees').textContent = bEmp;
            if (bCity && bState) document.getElementById('previewLocation').textContent = bCity + ', ' + bState;
            if (bDesc) document.getElementById('previewAbout').textContent = bDesc;
        }
    }

    function selectType(type, element) {
        document.querySelectorAll('.type-select-card').forEach(c => {
            c.classList.remove('selected');
            const radio = c.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });
        element.classList.add('selected');
        const r = element.querySelector('input[type="radio"]');
        if (r) r.checked = true;
        document.getElementById('inputListingType').value = type;
    }

    function addHighlightRow() {
        const container = document.getElementById('highlightsContainer');
        const div = document.createElement('div');
        div.className = 'input-group input-group-sm';
        div.innerHTML = `
            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
            <input type="text" name="features[]" class="form-control" placeholder="Enter feature highlight...">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function selectPlan(name, price, element) {
        document.querySelectorAll('.pricing-plan-card').forEach(p => {
            p.classList.remove('selected');
            const r = p.querySelector('input[type="radio"]');
            if (r) r.checked = false;
            const btn = p.querySelector('button');
            if (btn) {
                btn.className = 'btn btn-outline-primary btn-sm w-100 fw-semibold';
                btn.textContent = 'Select Plan';
            }
        });

        element.classList.add('selected');
        const r = element.querySelector('input[type="radio"]');
        if (r) r.checked = true;
        const btn = element.querySelector('button');
        if (btn) {
            btn.className = 'btn btn-primary btn-sm w-100 fw-semibold';
            btn.textContent = 'Selected ✓';
        }

        document.getElementById('inputPlanName').value = name;
        document.getElementById('inputPlanPrice').value = price.toFixed(2);
        updateSummary();
    }

    function updateSummary() {
        const planName = document.getElementById('inputPlanName').value;
        const planPrice = parseFloat(document.getElementById('inputPlanPrice').value) || 0;
        const addon1 = document.getElementById('addon1').checked;
        const addon2 = document.getElementById('addon2').checked;

        document.getElementById('summaryPlanText').textContent = planName + ' (1 Year)';
        document.getElementById('summaryPlanPrice').textContent = '₹' + planPrice.toLocaleString();

        let total = planPrice;
        if (addon1) total += 499;
        if (addon2) total += 299;

        const badgeRow = document.getElementById('summaryBadgeRow');
        if (badgeRow) badgeRow.style.display = addon1 ? 'flex' : 'none';

        document.getElementById('summaryTotalPrice').textContent = '₹' + total.toLocaleString();
    }
</script>
@endsection
