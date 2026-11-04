@extends('seller.layouts.seller')

@section('title', 'Add Course - Digital Class Seller')

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
                Course Add Process
            </h2>
            <p class="text-muted small mb-0">Upload your course and showcase it to thousands of potential learners</p>
        </div>
        <a href="{{ route('seller.courses.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Courses
        </a>
    </div>

    <!-- Multi-Step Stepper Navigation (1 to 7) -->
    <div class="wizard-steps-container">
        <div class="wizard-step-item active" id="step-nav-1" onclick="goToStep(1)">
            <div class="wizard-step-num">1</div>
            <div>
                <span class="wizard-step-title">Choose Course Type</span>
                <span class="wizard-step-sub">Select type of course</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-2" onclick="goToStep(2)">
            <div class="wizard-step-num">2</div>
            <div>
                <span class="wizard-step-title">Basic Information</span>
                <span class="wizard-step-sub">Course basic details</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-3" onclick="goToStep(3)">
            <div class="wizard-step-num">3</div>
            <div>
                <span class="wizard-step-title">Course Curriculum</span>
                <span class="wizard-step-sub">Syllabus & highlights</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-4" onclick="goToStep(4)">
            <div class="wizard-step-num">4</div>
            <div>
                <span class="wizard-step-title">Media & Gallery</span>
                <span class="wizard-step-sub">Thumbnail, banner & demo</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-5" onclick="goToStep(5)">
            <div class="wizard-step-num">5</div>
            <div>
                <span class="wizard-step-title">Instructor & Support</span>
                <span class="wizard-step-sub">Contact & institute info</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-6" onclick="goToStep(6)">
            <div class="wizard-step-num">6</div>
            <div>
                <span class="wizard-step-title">Pricing & Publish</span>
                <span class="wizard-step-sub">Enrollment & add-ons</span>
            </div>
            <i class="fa-solid fa-chevron-right text-muted ms-1" style="font-size: 0.65rem;"></i>
        </div>

        <div class="wizard-step-item" id="step-nav-7" onclick="goToStep(7)">
            <div class="wizard-step-num">7</div>
            <div>
                <span class="wizard-step-title">Preview & Publish</span>
                <span class="wizard-step-sub">Final course review</span>
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
    <form action="{{ route('seller.courses.store') }}" method="POST" id="courseWizardForm" novalidate>
        @csrf

        <!-- ================= STEP 1: CHOOSE COURSE TYPE ================= -->
        <div class="wizard-step-content" id="step-content-1">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Choose Course Type</h5>
                    <p class="text-muted small mb-0">Select the type of course or training batch you are publishing</p>
                </div>

                <input type="hidden" name="course_type" id="inputCourseType" value="Online Video Course">

                <!-- 1. Online Video Course -->
                <div class="type-select-card selected" onclick="selectCourseType('Online Video Course', this)">
                    <input type="radio" name="course_type_radio" class="form-check-input flex-shrink-0" checked>
                    <div class="type-icon-box" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Online Video Masterclass</h6>
                        <small class="text-muted">Pre-recorded HD video lessons, modules, and downloadable exercises.</small>
                    </div>
                </div>

                <!-- 2. Live Interactive Batch -->
                <div class="type-select-card" onclick="selectCourseType('Live Interactive Batch', this)">
                    <input type="radio" name="course_type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Live Interactive Cohort</h6>
                        <small class="text-muted">Scheduled live classes, screen sharing, real-time Q&A, and mentorship.</small>
                    </div>
                </div>

                <!-- 3. Certification Program -->
                <div class="type-select-card" onclick="selectCourseType('Certification Program', this)">
                    <input type="radio" name="course_type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #ede9fe; color: #7c3aed;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Professional Certification Program</h6>
                        <small class="text-muted">Structured curriculum, graded assignments, exams, and verified certificates.</small>
                    </div>
                </div>

                <!-- 4. Study Notes & Batches -->
                <div class="type-select-card" onclick="selectCourseType('Study Notes & Batches', this)">
                    <input type="radio" name="course_type_radio" class="form-check-input flex-shrink-0">
                    <div class="type-icon-box" style="background: #dcfce7; color: #16a34a;">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Study Notes & Material Bundle</h6>
                        <small class="text-muted">Downloadable PDFs, cheatsheets, source code, and question banks.</small>
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
                    <p class="text-muted small mb-0">Add your course essential details for learners to discover</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Course Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="inputCourseTitle" class="form-control" placeholder="e.g. Complete Digital Marketing & AI Masterclass 2026" value="{{ old('title', 'Complete Digital Marketing & AI Masterclass 2026') }}" required>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">Short Description <span class="text-danger">*</span></label>
                        <small class="text-muted" id="shortDescCounter">135/300</small>
                    </div>
                    <textarea name="short_description" id="inputShortDesc" class="form-control" rows="3" maxlength="300" placeholder="Brief summary of what students will achieve..." oninput="document.getElementById('shortDescCounter').textContent = this.value.length + '/300'">{{ old('short_description', 'Master SEO, Meta Ads, Google Ads, AI Content Marketing, and Automation with real-world live projects and industry certification.') }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Course Category <span class="text-danger">*</span></label>
                        <select name="category" id="inputCourseCategory" class="form-select" required>
                            <option value="Digital Marketing" {{ old('category', 'Digital Marketing') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing & Advertising</option>
                            <option value="Web Development">Web & Full-Stack Development</option>
                            <option value="Graphic Design">Graphic Design & UI/UX</option>
                            <option value="Business & Finance">Business, Accounting & Tally</option>
                            <option value="Data Science & AI">Data Science & AI Automation</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Sub Category <span class="text-danger">*</span></label>
                        <select name="sub_category" id="inputCourseSubCategory" class="form-select">
                            <option value="Performance Marketing & SEO" selected>Performance Marketing & SEO</option>
                            <option value="Social Media Strategy">Social Media Strategy</option>
                            <option value="AI Copywriting & Growth">AI Copywriting & Growth</option>
                            <option value="Google & Meta Ads">Google & Meta Ads</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Instruction Language <span class="text-danger">*</span></label>
                        <select name="language" class="form-select" required>
                            <option value="English" {{ old('language', 'English') == 'English' ? 'selected' : '' }}>English</option>
                            <option value="Hindi" {{ old('language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                            <option value="Hinglish" {{ old('language') == 'Hinglish' ? 'selected' : '' }}>Hinglish</option>
                            <option value="Gujarati" {{ old('language') == 'Gujarati' ? 'selected' : '' }}>Gujarati</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Skill Level <span class="text-danger">*</span></label>
                        <select name="level" class="form-select" required>
                            <option value="All Levels" {{ old('level', 'All Levels') == 'All Levels' ? 'selected' : '' }}>All Levels (Beginner to Advanced)</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(1)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(3)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 3: COURSE CURRICULUM ================= -->
        <div class="wizard-step-content d-none" id="step-content-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Course Curriculum & Details</h5>
                    <p class="text-muted small mb-0">Add complete syllabus breakdown and highlight offerings</p>
                </div>

                <!-- Sub-tabs -->
                <ul class="nav nav-pills mb-3 border-bottom pb-2">
                    <li class="nav-item">
                        <button class="nav-link active py-1 px-3 small fw-semibold" type="button">Overview</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1 px-3 small fw-semibold" type="button">Modules</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1 px-3 small fw-semibold" type="button">Highlights</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1 px-3 small fw-semibold" type="button">Certification</button>
                    </li>
                </ul>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">Detailed Curriculum Description</label>
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
                    <textarea name="description" id="inputCourseDesc" class="form-control rounded-top-0" rows="5" maxlength="1000" placeholder="Provide complete information about modules, assignments, tools, and prerequisites..." oninput="document.getElementById('descCounter').textContent = this.value.length + '/1000'">{{ old('description', 'Complete industry-relevant Digital Marketing Masterclass designed for students, freelancers and business owners. Our mission is to make everyone digitally skilled with practical hands-on ad campaigns, SEO auditing, AI copy generation and real client case studies.') }}</textarea>
                </div>

                <!-- Key Features / Highlights -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small mb-2">Key Course Highlights</label>
                    <div id="courseHighlightsContainer" class="d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="ISO 21001:2018 Certified Digital Certificate">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="48.5 Hours of On-Demand HD Video Lectures">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Live Ad Campaign Budget Practice & Case Studies">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Direct Instructor Q&A & Community Discussion">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
                            <input type="text" name="features[]" class="form-control" value="Placement Assistance & Freelance Client Strategy">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 fw-semibold" onclick="addCourseHighlightRow()">
                        <i class="fa-solid fa-plus me-1"></i> Add Another Highlight
                    </button>
                </div>

                <!-- Structured Lectures (Hidden/Pass-through for Controller) -->
                <input type="hidden" name="sections[0][section_title]" value="1. Introduction to Digital Strategy">
                <input type="hidden" name="sections[0][lecture_title]" value="1.1 Foundations & Growth Frameworks">
                <input type="hidden" name="sections[0][duration]" value="14:20">
                <input type="hidden" name="sections[1][section_title]" value="1. Introduction to Digital Strategy">
                <input type="hidden" name="sections[1][lecture_title]" value="1.2 Setting ROAS KPIs & Audience Segmentation">
                <input type="hidden" name="sections[1][duration]" value="18:45">

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
                    <p class="text-muted small mb-0">Add thumbnail emblem, course banner, and preview video</p>
                </div>

                <!-- Course Logo / Emblem -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Course Badge / Emblem <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 border d-flex flex-column align-items-center justify-content-center p-2 bg-light flex-shrink-0" style="width: 80px; height: 80px;">
                            <span class="fw-bold text-primary display-heading fs-4">DM</span>
                            <small class="fw-bold text-dark" style="font-size: 0.65rem;">PRO</small>
                        </div>
                        <div class="p-3 border border-dashed rounded-3 flex-grow-1 text-center bg-light bg-opacity-25" style="border-style: dashed !important; cursor: pointer;">
                            <i class="fa-solid fa-cloud-arrow-up text-primary fs-4 mb-1"></i>
                            <div class="fw-bold small text-dark">Upload Course Badge</div>
                            <small class="text-muted">PNG, JPG (Max 2MB)</small>
                            <input type="hidden" name="thumbnail" value="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800">
                        </div>
                    </div>
                </div>

                <!-- Cover Image / Banner -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Course Cover Banner</label>
                    <div class="p-4 rounded-3 text-center text-white mb-3 position-relative overflow-hidden" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800') center/cover; min-height: 140px;">
                        <span class="badge bg-dark bg-opacity-75 position-absolute top-0 end-0 m-2" style="cursor: pointer;"><i class="fa-solid fa-xmark"></i></span>
                        <h5 class="display-heading fw-bold mb-0 mt-3 text-white">SKILL TODAY BETTER TOMORROW</h5>
                        <small class="text-white-50">Course Banner Preview</small>
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
                    <label class="form-label fw-bold text-dark small">Course Trailer / Promo Video (Optional)</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 border overflow-hidden position-relative flex-shrink-0" style="width: 90px; height: 60px;">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200" class="w-100 h-100 object-fit-cover">
                            <span class="position-absolute top-50 start-50 translate-middle text-white fs-5"><i class="fa-solid fa-circle-play"></i></span>
                        </div>
                        <div class="p-3 border border-dashed rounded-3 flex-grow-1 text-center bg-light bg-opacity-25" style="border-style: dashed !important; cursor: pointer;">
                            <i class="fa-solid fa-video text-primary fs-4 mb-1"></i>
                            <div class="fw-bold small text-dark">Upload Promo Video</div>
                            <small class="text-muted">MP4 (Max 100MB)</small>
                            <input type="hidden" name="video_url" value="https://example.com/course-trailer.mp4">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" onclick="goToStep(3)">&larr; Back</button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" style="background-color: #0066ff;" onclick="goToStep(5)">Continue &rarr;</button>
                </div>
            </div>
        </div>

        <!-- ================= STEP 5: INSTRUCTOR & SUPPORT ================= -->
        <div class="wizard-step-content d-none" id="step-content-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Instructor Contact & Location</h5>
                    <p class="text-muted small mb-0">Add student contact and institute support details</p>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Support Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="text" name="phone" id="inputCoursePhone" class="form-control" placeholder="10-digit mobile number" value="{{ old('phone', '9876543210') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold text-dark small mb-0">WhatsApp Community</label>
                            <div class="form-check form-check-inline me-0">
                                <input class="form-check-input" type="checkbox" id="samePhoneCourse" checked onchange="document.getElementById('inputCourseWhatsapp').value = this.checked ? document.getElementById('inputCoursePhone').value : ''">
                                <label class="form-check-label small text-muted" for="samePhoneCourse" style="font-size: 0.725rem;">Same as support phone</label>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="text" name="whatsapp_number" id="inputCourseWhatsapp" class="form-control" placeholder="Enter WhatsApp number" value="{{ old('whatsapp_number', '9876543210') }}">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Official Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="inputCourseEmail" class="form-control" placeholder="support@academy.com" value="{{ old('email', 'info@vcec.in') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Website / Portal (Optional)</label>
                        <input type="url" name="website" id="inputCourseWebsite" class="form-control" placeholder="https://www.academy.com" value="{{ old('website', 'https://www.vcec.in') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Institute / Academy Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="inputCourseAddress" class="form-control" placeholder="Campus / Institute Street Address" value="{{ old('address', '3rd Floor, Shreeji Complex, Nikol, Ahmedabad - 382350') }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" id="inputCourseCity" class="form-control" placeholder="Ahmedabad" value="{{ old('city', 'Ahmedabad') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" id="inputCourseState" class="form-control" placeholder="Gujarat" value="{{ old('state', 'Gujarat') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" id="inputCoursePincode" class="form-control font-mono-code" placeholder="382350" value="{{ old('pincode', '382350') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Campus Map Location</label>
                    <div class="input-group mb-2">
                        <input type="text" name="map_location" id="inputCourseMap" class="form-control" placeholder="Google Maps link" value="{{ old('map_location', 'https://maps.google.com/?q=VCEC+Nikol') }}">
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

        <!-- ================= STEP 6: PRICING & PLAN ================= -->
        <div class="wizard-step-content d-none" id="step-content-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-4">
                    <h5 class="display-heading fw-bold text-dark mb-1">Plan & Publish</h5>
                    <p class="text-muted small mb-0">Choose a course pricing plan and enrollment options</p>
                </div>

                <input type="hidden" name="is_free" id="inputIsFree" value="0">
                <input type="hidden" name="price" id="inputCoursePrice" value="2999.00">
                <input type="hidden" name="discount_price" id="inputCourseDiscount" value="1499.00">
                <input type="hidden" name="access_type" value="Lifetime Access">
                <input type="hidden" name="plan_name" id="inputCoursePlanName" value="Premium Course Track">

                <div class="row g-3 mb-4">
                    <!-- Plan 1: Free Preview -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card" id="cardCourseFree" onclick="selectCoursePricingPlan('Free Preview Tier', 0, 0, this)">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="course_plan_radio" class="form-check-input">
                                <h6 class="fw-bold text-dark mb-0">Free Preview Tier</h6>
                            </div>
                            <div class="display-heading fw-bold text-dark mb-3" style="font-size: 1.4rem;">
                                ₹0 <small class="text-muted fs-6 fw-normal">/ lifetime</small>
                            </div>
                            <ul class="list-unstyled small text-secondary flex-grow-1 mb-3">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Access to introductory modules</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Community forum read access</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Standard video playback</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Lead generation access</li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 fw-semibold">Select Plan</button>
                        </div>
                    </div>

                    <!-- Plan 2: Premium Course Track (Most Popular) -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card selected" id="cardCoursePremium" onclick="selectCoursePricingPlan('Premium Course Track', 1499, 2999, this)">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2 rounded-pill px-2 py-1" style="font-size: 0.65rem;">Most Popular</span>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="course_plan_radio" class="form-check-input" checked>
                                <h6 class="fw-bold text-dark mb-0">Premium Listing</h6>
                            </div>
                            <div class="display-heading fw-bold text-dark mb-3" style="font-size: 1.4rem;">
                                ₹1,499 <small class="text-muted fs-6 fw-normal text-decoration-line-through">₹2,999</small>
                            </div>
                            <ul class="list-unstyled small text-secondary flex-grow-1 mb-3">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Full lifetime course access</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> 48.5 Hours of HD video lessons</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Verified completion certificate</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> 45+ Downloadable resource files</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Direct instructor Q&A access</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Featured on category top shelf</li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-sm w-100 fw-semibold" style="background-color: #0066ff;">Selected &check;</button>
                        </div>
                    </div>

                    <!-- Plan 3: Featured Mentorship Track -->
                    <div class="col-md-4">
                        <div class="pricing-plan-card" id="cardCourseFeatured" onclick="selectCoursePricingPlan('Featured Master Track', 2999, 4999, this)">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <input type="radio" name="course_plan_radio" class="form-check-input">
                                <h6 class="fw-bold text-dark mb-0">Featured Listing</h6>
                            </div>
                            <div class="display-heading fw-bold text-dark mb-3" style="font-size: 1.4rem;">
                                ₹2,999 <small class="text-muted fs-6 fw-normal text-decoration-line-through">₹4,999</small>
                            </div>
                            <ul class="list-unstyled small text-secondary flex-grow-1 mb-3">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> All Premium features included</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> 1-on-1 Project code review</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Homepage featured banner position</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Special highlight verified badge</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Career counseling & mock interviews</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-1"></i> Dedicated student support</li>
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
                                    <input class="form-check-input" type="checkbox" name="certificate_included" value="1" id="courseAddon1" checked onchange="updateCourseSummary()">
                                    <label class="form-check-label small fw-semibold text-dark" for="courseAddon1">
                                        Verified Business Badge & Certificate
                                    </label>
                                </div>
                                <span class="fw-bold text-dark font-mono-code small">₹499 / year</span>
                            </div>

                            <div class="p-3 border rounded-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="qa_enabled" value="1" id="courseAddon2" onchange="updateCourseSummary()">
                                    <label class="form-check-label small fw-semibold text-dark" for="courseAddon2">
                                        Additional Gallery Images & Assets (up to 20)
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
                                <span class="text-muted" id="summaryCoursePlanText">Premium Listing (1 Year)</span>
                                <span class="fw-semibold font-mono-code" id="summaryCoursePlanPrice">₹1,499</span>
                            </div>
                            <div class="d-flex justify-content-between py-1 small" id="summaryCourseBadgeRow">
                                <span class="text-muted">Verified Business Badge</span>
                                <span class="fw-semibold font-mono-code">₹499</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top mt-2 fw-bold text-dark">
                                <span>Total:</span>
                                <span class="font-mono-code text-primary fs-6" id="summaryCourseTotalPrice">₹1,998</span>
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
                        <p class="text-muted small mb-0">Review your course listing and publish</p>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-primary fw-semibold px-3" style="background-color: #0066ff;">Desktop View</button>
                        <button type="button" class="btn btn-outline-secondary fw-semibold px-3">Mobile View</button>
                    </div>
                </div>

                <!-- Full Course Directory Live Card Preview (Matching Page 40) -->
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
                                    <span class="fw-bold text-primary display-heading fs-5" id="previewCourseLogoChar">V</span>
                                    <small class="fw-bold text-dark" style="font-size: 0.6rem;" id="previewCourseLogoSub">VCEC</small>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <h5 class="display-heading fw-bold text-dark mb-0" id="previewCourseTitle">
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
                                        <span class="text-muted" id="previewCourseCategory">Computer Training Institute • Education & Training</span>
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
                            <div><i class="fa-solid fa-location-dot text-danger me-1"></i> Location <strong class="text-dark" id="previewCourseLocation">Ahmedabad, Gujarat</strong></div>
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
                            <h6 class="fw-bold text-dark mb-2" id="previewCourseAboutHeading">About VCEC - Vinayak Computer Education Center</h6>
                            <p class="text-muted small mb-0" id="previewCourseAbout">
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

        const activeContent = document.getElementById('step-content-' + step);
        const activeNav = document.getElementById('step-nav-' + step);
        if (activeContent) activeContent.classList.remove('d-none');
        if (activeNav) activeNav.classList.add('active');

        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (step === 7) {
            const title = document.getElementById('inputCourseTitle')?.value;
            const cat = document.getElementById('inputCourseCategory')?.value;
            const sub = document.getElementById('inputCourseSubCategory')?.value;
            const city = document.getElementById('inputCourseCity')?.value;
            const state = document.getElementById('inputCourseState')?.value;
            const desc = document.getElementById('inputCourseDesc')?.value;

            if (title) {
                document.getElementById('previewCourseTitle').textContent = title;
                document.getElementById('previewCourseAboutHeading').textContent = 'About ' + title;
                document.getElementById('previewCourseLogoChar').textContent = title.charAt(0).toUpperCase();
                document.getElementById('previewCourseLogoSub').textContent = title.split(' ')[0].substring(0, 4).toUpperCase();
            }
            if (cat && sub) document.getElementById('previewCourseCategory').textContent = sub + ' • ' + cat;
            if (city && state) document.getElementById('previewCourseLocation').textContent = city + ', ' + state;
            if (desc) document.getElementById('previewCourseAbout').textContent = desc;
        }
    }

    function selectCourseType(type, element) {
        document.querySelectorAll('.type-select-card').forEach(c => {
            c.classList.remove('selected');
            const radio = c.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });
        element.classList.add('selected');
        const r = element.querySelector('input[type="radio"]');
        if (r) r.checked = true;
        document.getElementById('inputCourseType').value = type;
    }

    function addCourseHighlightRow() {
        const container = document.getElementById('courseHighlightsContainer');
        const div = document.createElement('div');
        div.className = 'input-group input-group-sm';
        div.innerHTML = `
            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-plus"></i></span>
            <input type="text" name="features[]" class="form-control" placeholder="Enter course highlight...">
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function selectCoursePricingPlan(name, price, mrp, element) {
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

        document.getElementById('inputCoursePlanName').value = name;
        document.getElementById('inputCourseDiscount').value = price.toFixed(2);
        document.getElementById('inputCoursePrice').value = mrp.toFixed(2);
        document.getElementById('inputIsFree').value = price === 0 ? '1' : '0';
        updateCourseSummary();
    }

    function updateCourseSummary() {
        const planName = document.getElementById('inputCoursePlanName').value;
        const planPrice = parseFloat(document.getElementById('inputCourseDiscount').value) || 0;
        const addon1 = document.getElementById('courseAddon1').checked;
        const addon2 = document.getElementById('courseAddon2').checked;

        document.getElementById('summaryCoursePlanText').textContent = planName + ' (1 Year)';
        document.getElementById('summaryCoursePlanPrice').textContent = '₹' + planPrice.toLocaleString();

        let total = planPrice;
        if (addon1) total += 499;
        if (addon2) total += 299;

        const badgeRow = document.getElementById('summaryCourseBadgeRow');
        if (badgeRow) badgeRow.style.display = addon1 ? 'flex' : 'none';

        document.getElementById('summaryCourseTotalPrice').textContent = '₹' + total.toLocaleString();
    }
</script>
@endsection
