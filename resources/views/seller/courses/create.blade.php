@extends('seller.layouts.seller')

@section('title', 'Add Course - Digital Class Seller')

@section('styles')
<style>
    /* Course Add Process Theme Styles */
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
        background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
        color: #ffffff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
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
        border-color: #0066ff;
        background: #eff6ff;
        box-shadow: 0 2px 8px rgba(0, 102, 255, 0.12);
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
        background: #0066ff;
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
        color: #0066ff;
    }
    .milestone-sub {
        font-size: 0.68rem;
        color: #64748b;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* 2-Column Form Card (Left: Steps Sidebar, Right: Active Pane) */
    .course-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }
    .course-form-grid {
        display: grid;
        grid-template-columns: 270px 1fr;
        min-height: 600px;
    }
    .course-steps-sidebar {
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
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #0066ff;
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
        background: #0066ff;
        color: #ffffff;
    }
    .sidebar-step-btn.completed .sidebar-step-num {
        background: #10b981;
        color: #ffffff;
    }

    /* Right Form Content Pane */
    .course-form-content {
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
        border-color: #0066ff;
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
        outline: none;
    }

    /* Sections & Lectures Builder (Step 2) */
    .section-block {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 1rem;
        overflow: hidden;
        background: #ffffff;
    }
    .section-header {
        background: #f8fafc;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e2e8f0;
    }
    .section-title-text {
        font-weight: 700;
        font-size: 0.88rem;
        color: #0f172a;
    }
    .lecture-item {
        padding: 0.65rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px dashed #f1f5f9;
        font-size: 0.82rem;
        color: #334155;
    }
    .lecture-item:last-child {
        border-bottom: none;
    }
    .lecture-left {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .lecture-duration {
        font-size: 0.75rem;
        color: #64748b;
        font-family: monospace;
    }

    /* Live Preview Card (Step 4) */
    .course-preview-box {
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
    .preview-heart-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        font-size: 0.85rem;
        border: none;
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
        gap: 0.5rem;
    }
    .preview-curr-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
    }
    .preview-orig-price {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .preview-off-badge {
        font-size: 0.68rem;
        font-weight: 800;
        background: #fee2e2;
        color: #ef4444;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
    }

    /* Wizard Action Buttons */
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
        background: #0066ff;
        border: 1px solid #0066ff;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.55rem 1.4rem;
        border-radius: 8px;
        transition: all 0.15s;
    }
    .btn-step-next:hover {
        background: #0052cc;
        border-color: #0052cc;
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
        .course-form-grid {
            grid-template-columns: 1fr;
        }
        .course-steps-sidebar {
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Top Process Hero Banner (Matching Screenshot) -->
    <div class="process-hero-banner">
        <div class="process-hero-icon">
            <i class="fa-solid fa-circle-play"></i>
        </div>
        <div>
            <h1 class="process-hero-title">Course Add Process</h1>
            <p class="process-hero-sub">Sell online courses like Udemy</p>
        </div>
    </div>

    <!-- 5-Stage Milestone Flow Bar -->
    <div class="milestone-steps-row">
        <!-- 1. Go to Add Course -->
        <div class="milestone-step-card completed">
            <div class="milestone-badge"><i class="fa-solid fa-check"></i></div>
            <div>
                <div class="milestone-title">1. Go to Add Course</div>
                <div class="milestone-sub">Seller dashboard se Add Course par click kare</div>
            </div>
        </div>

        <!-- 2. Basic Information -->
        <div class="milestone-step-card active" id="milestone-step-1">
            <div class="milestone-badge">2</div>
            <div>
                <div class="milestone-title">2. Basic Information</div>
                <div class="milestone-sub">Course ka basic details fill kare</div>
            </div>
        </div>

        <!-- 3. Upload Content -->
        <div class="milestone-step-card" id="milestone-step-2">
            <div class="milestone-badge">3</div>
            <div>
                <div class="milestone-title">3. Upload Content</div>
                <div class="milestone-sub">Video lectures, PDFs, resources add kare</div>
            </div>
        </div>

        <!-- 4. Pricing & Publish -->
        <div class="milestone-step-card" id="milestone-step-3">
            <div class="milestone-badge">4</div>
            <div>
                <div class="milestone-title">4. Pricing & Publish</div>
                <div class="milestone-sub">Price set kare aur publish kare</div>
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

    <!-- Main Course Wizard Form -->
    <form action="{{ route('seller.courses.store') }}" method="POST" id="courseAddForm" enctype="multipart/form-data">
        @csrf

        <div class="course-form-card">
            <div class="course-form-grid">

                <!-- Left Sidebar: 4 Form Steps -->
                <div class="course-steps-sidebar">
                    <div class="steps-sidebar-heading">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <span>Add New Course</span>
                    </div>

                    <button type="button" class="sidebar-step-btn active" id="step-nav-1" onclick="goToStep(1)">
                        <span class="sidebar-step-num">1</span>
                        <span>Basic Information</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-2" onclick="goToStep(2)">
                        <span class="sidebar-step-num">2</span>
                        <span>Course Content</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-3" onclick="goToStep(3)">
                        <span class="sidebar-step-num">3</span>
                        <span>Pricing & Access</span>
                    </button>

                    <button type="button" class="sidebar-step-btn" id="step-nav-4" onclick="goToStep(4)">
                        <span class="sidebar-step-num">4</span>
                        <span>Preview & Publish</span>
                    </button>
                </div>

                <!-- Right Form Content Area -->
                <div class="course-form-content">

                    <!-- ========================================== -->
                    <!-- STEP 1: BASIC INFORMATION                  -->
                    <!-- ========================================== -->
                    <div class="step-pane" id="step-pane-1">
                        <h2 class="pane-header-title">Basic Information</h2>
                        <p class="pane-header-sub">Provide the essential details about your course</p>

                        <div class="mb-3">
                            <label class="field-label">Course Title <span class="req">*</span></label>
                            <input type="text"
                                   name="title"
                                   id="inputTitle"
                                   class="custom-input @error('title') is-invalid @enderror"
                                   placeholder="Complete Digital Marketing Course"
                                   value="{{ old('title', 'Complete Digital Marketing Course') }}"
                                   required
                                   oninput="updateLivePreview()">
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Short Description <span class="req">*</span></label>
                            <textarea name="short_description"
                                      id="inputShortDesc"
                                      rows="3"
                                      class="custom-textarea @error('short_description') is-invalid @enderror"
                                      placeholder="Learn digital marketing from basics to advanced with practical examples."
                                      required
                                      oninput="updateLivePreview()">{{ old('short_description', 'Learn digital marketing from basics to advanced with practical examples.') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Category <span class="req">*</span></label>
                            <select name="category" id="inputCategory" class="custom-select" required onchange="updateLivePreview()">
                                <option value="Digital Marketing" {{ old('category') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                <option value="IT & Software" {{ old('category') == 'IT & Software' ? 'selected' : '' }}>IT & Software</option>
                                <option value="Programming" {{ old('category') == 'Programming' ? 'selected' : '' }}>Programming & Development</option>
                                <option value="Design & Creative" {{ old('category') == 'Design & Creative' ? 'selected' : '' }}>Design & Creative</option>
                                <option value="Business & Finance" {{ old('category') == 'Business & Finance' ? 'selected' : '' }}>Business & Finance</option>
                                <option value="Spoken English" {{ old('category') == 'Spoken English' ? 'selected' : '' }}>Spoken English & Languages</option>
                                <option value="Academics" {{ old('category') == 'Academics' ? 'selected' : '' }}>Academics & Tuitions</option>
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="field-label">Language <span class="req">*</span></label>
                                <select name="language" id="inputLanguage" class="custom-select" required onchange="updateLivePreview()">
                                    <option value="Hindi" {{ old('language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                    <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Hinglish" {{ old('language') == 'Hinglish' ? 'selected' : '' }}>Hinglish (Hindi + English)</option>
                                    <option value="Gujarati" {{ old('language') == 'Gujarati' ? 'selected' : '' }}>Gujarati</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Level <span class="req">*</span></label>
                                <select name="level" id="inputLevel" class="custom-select" required onchange="updateLivePreview()">
                                    <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="All Levels" {{ old('level') == 'All Levels' ? 'selected' : '' }}>All Levels</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Course Thumbnail (Upload File or Enter Image URL)</label>
                            <input type="file" name="thumbnail_file" id="inputThumbnailFile" class="form-control form-control-sm mb-2" accept="image/*" onchange="previewUploadedThumb(this)">
                            <input type="text"
                                   name="thumbnail"
                                   id="inputThumbnailUrl"
                                   class="custom-input"
                                   placeholder="Or enter direct image URL (optional)"
                                   value="{{ old('thumbnail') }}"
                                   oninput="updateLivePreview()">
                            <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Leave empty to use the standard default course thumbnail.</small>
                        </div>

                        <div class="wizard-actions-bar">
                            <div></div>
                            <button type="button" class="btn-step-next" onclick="goToStep(2)">
                                Next &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- STEP 2: COURSE CONTENT (UPLOAD CONTENT)    -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-2">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <h2 class="pane-header-title mb-0">Course Content</h2>
                            <button type="button" class="btn btn-sm btn-primary fw-bold" onclick="addNewSection()">
                                <i class="fa-solid fa-plus me-1"></i> Add Section
                            </button>
                        </div>
                        <p class="pane-header-sub">Video lectures, PDFs, resources add kare</p>

                        <!-- Sections Container -->
                        <div id="sectionsContainer">
                            <!-- Section 1 -->
                            <div class="section-block" id="section-1">
                                <div class="section-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-folder text-primary"></i>
                                        <span class="section-title-text" contenteditable="true">1. Introduction to Digital Marketing</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="removeSection('section-1')" title="Delete section">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                                <div class="lectures-list" id="lectures-section-1">
                                    <div class="lecture-item">
                                        <div class="lecture-left">
                                            <i class="fa-regular fa-circle-play text-primary"></i>
                                            <span>1.1 What is Digital Marketing?</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="lecture-duration">12:45</span>
                                            <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()" title="Delete">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="lecture-item">
                                        <div class="lecture-left">
                                            <i class="fa-regular fa-circle-play text-primary"></i>
                                            <span>1.2 Types of Digital Marketing</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="lecture-duration">10:20</span>
                                            <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()" title="Delete">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="lecture-item">
                                        <div class="lecture-left">
                                            <i class="fa-regular fa-circle-play text-primary"></i>
                                            <span>1.3 Career Opportunities</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="lecture-duration">15:10</span>
                                            <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()" title="Delete">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bg-light bg-opacity-50 border-top">
                                    <button type="button" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none p-0" onclick="addLectureToSection('lectures-section-1')">
                                        <i class="fa-solid fa-plus me-1"></i> Add Lecture
                                    </button>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="section-block" id="section-2">
                                <div class="section-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-folder text-primary"></i>
                                        <span class="section-title-text" contenteditable="true">2. SEO Mastery</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="removeSection('section-2')" title="Delete section">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                                <div class="lectures-list" id="lectures-section-2">
                                    <div class="lecture-item">
                                        <div class="lecture-left">
                                            <i class="fa-regular fa-circle-play text-primary"></i>
                                            <span>2.1 On-Page SEO Checklist</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="lecture-duration">18:30</span>
                                            <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bg-light bg-opacity-50 border-top">
                                    <button type="button" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none p-0" onclick="addLectureToSection('lectures-section-2')">
                                        <i class="fa-solid fa-plus me-1"></i> Add Lecture
                                    </button>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="section-block" id="section-3">
                                <div class="section-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-folder text-primary"></i>
                                        <span class="section-title-text" contenteditable="true">3. Social Media Marketing</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="removeSection('section-3')" title="Delete section">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                                <div class="lectures-list" id="lectures-section-3">
                                    <div class="lecture-item">
                                        <div class="lecture-left">
                                            <i class="fa-regular fa-circle-play text-primary"></i>
                                            <span>3.1 Meta Ads Strategy 2026</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="lecture-duration">22:15</span>
                                            <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bg-light bg-opacity-50 border-top">
                                    <button type="button" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none p-0" onclick="addLectureToSection('lectures-section-3')">
                                        <i class="fa-solid fa-plus me-1"></i> Add Lecture
                                    </button>
                                </div>
                            </div>
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
                    <!-- STEP 3: PRICING & ACCESS (PRICING & PUBLISH) -->
                    <!-- ========================================== -->
                    <div class="step-pane d-none" id="step-pane-3">
                        <h2 class="pane-header-title">Pricing & Access</h2>
                        <p class="pane-header-sub">Price set kare aur publish kare</p>

                        <!-- Free / Paid Radio -->
                        <div class="d-flex align-items-center gap-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_free" id="priceRadioFree" value="1" onchange="togglePaidInputs(false)">
                                <label class="form-check-label fw-bold text-dark" for="priceRadioFree">
                                    Free Course
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_free" id="priceRadioPaid" value="0" checked onchange="togglePaidInputs(true)">
                                <label class="form-check-label fw-bold text-dark" for="priceRadioPaid">
                                    Paid Course
                                </label>
                            </div>
                        </div>

                        <!-- Price Inputs -->
                        <div class="row g-3 mb-3" id="paidPriceInputsRow">
                            <div class="col-md-6">
                                <label class="field-label">Price (₹) <span class="req">*</span></label>
                                <input type="number"
                                       name="price"
                                       id="inputPrice"
                                       class="custom-input"
                                       placeholder="2999"
                                       value="{{ old('price', 2999) }}"
                                       min="0"
                                       step="1"
                                       oninput="updateLivePreview()">
                            </div>
                            <div class="col-md-6">
                                <label class="field-label">Discount Price (Optional)</label>
                                <input type="number"
                                       name="discount_price"
                                       id="inputDiscountPrice"
                                       class="custom-input"
                                       placeholder="1999"
                                       value="{{ old('discount_price', 1999) }}"
                                       min="0"
                                       step="1"
                                       oninput="updateLivePreview()">
                            </div>
                        </div>

                        <!-- Course Access Dropdown -->
                        <div class="mb-3">
                            <label class="field-label">Course Access <span class="req">*</span></label>
                            <select name="access_type" id="inputAccessType" class="custom-select" required onchange="updateLivePreview()">
                                <option value="Lifetime Access" {{ old('access_type') == 'Lifetime Access' ? 'selected' : '' }}>Lifetime Access</option>
                                <option value="1 Year Access" {{ old('access_type') == '1 Year Access' ? 'selected' : '' }}>1 Year Access</option>
                                <option value="6 Months Access" {{ old('access_type') == '6 Months Access' ? 'selected' : '' }}>6 Months Access</option>
                                <option value="3 Months Access" {{ old('access_type') == '3 Months Access' ? 'selected' : '' }}>3 Months Access</option>
                            </select>
                        </div>

                        <!-- Feature Checkboxes -->
                        <div class="border rounded-3 p-3 mb-3 bg-light bg-opacity-50">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="certificate_included" id="checkCertificate" value="1" checked onchange="updateLivePreview()">
                                <label class="form-check-label fw-semibold text-dark small" for="checkCertificate">
                                    <i class="fa-solid fa-certificate text-primary me-1"></i> Allow Certificate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="qa_enabled" id="checkQa" value="1" checked onchange="updateLivePreview()">
                                <label class="form-check-label fw-semibold text-dark small" for="checkQa">
                                    <i class="fa-solid fa-comments text-success me-1"></i> Enable Discussion (Q&A)
                                </label>
                            </div>
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
                            <!-- Left: Live Udemy-style Course Card -->
                            <div class="col-lg-5 col-md-6">
                                <div class="course-preview-box">
                                    <div class="preview-thumb-wrap">
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&auto=format&fit=crop&q=80" id="previewImg" alt="Course Thumbnail">
                                        <button type="button" class="preview-heart-btn" title="Wishlist">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="preview-body">
                                        <div class="preview-title" id="previewTitle">Complete Digital Marketing Course</div>
                                        <div class="preview-desc" id="previewDesc">Learn digital marketing from basics to advanced with practical examples.</div>
                                        <div class="preview-rating-row">
                                            <i class="fa-solid fa-star"></i>
                                            <span class="fw-bold text-dark">4.8</span>
                                            <span class="text-muted">(124 reviews) &bull; 1,240 students</span>
                                        </div>
                                        <div class="preview-price-row">
                                            <span class="preview-curr-price" id="previewPrice">₹1,999</span>
                                            <span class="preview-orig-price" id="previewOrigPrice">₹2,999</span>
                                            <span class="preview-off-badge" id="previewOffBadge">33% OFF</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Course Specifications Summary Checklist -->
                            <div class="col-lg-7 col-md-6">
                                <div class="border rounded-3 p-3 bg-light bg-opacity-25">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fa-solid fa-circle-check text-success me-1"></i> Course Specification Checklist
                                    </h6>
                                    <table class="table table-sm table-borderless small mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted" style="width: 140px;">Category:</td>
                                                <td class="fw-bold text-dark" id="summaryCategory">Digital Marketing</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Language:</td>
                                                <td class="fw-bold text-dark" id="summaryLanguage">Hindi</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Level:</td>
                                                <td class="fw-bold text-dark" id="summaryLevel">Beginner</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Access:</td>
                                                <td class="fw-bold text-dark" id="summaryAccess">Lifetime Access</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Certificate:</td>
                                                <td class="fw-bold text-success" id="summaryCert">Included</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Discussion/Q&A:</td>
                                                <td class="fw-bold text-primary" id="summaryQa">Enabled</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-info py-2 px-3 small rounded-3 mt-3 mb-0">
                                    <i class="fa-solid fa-info-circle me-1"></i>
                                    Your course will be immediately published and visible in your seller catalog.
                                </div>
                            </div>
                        </div>

                        <div class="wizard-actions-bar">
                            <button type="button" class="btn-step-back" onclick="goToStep(3)">
                                &larr; Back
                            </button>
                            <button type="submit" class="btn-step-publish">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Publish Course
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

        // Update 4-step sidebar buttons
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

    function togglePaidInputs(isPaid) {
        const row = document.getElementById('paidPriceInputsRow');
        const priceInput = document.getElementById('inputPrice');
        if (isPaid) {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
            if (priceInput) priceInput.value = '0';
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
        const title = document.getElementById('inputTitle')?.value || 'Complete Digital Marketing Course';
        const desc = document.getElementById('inputShortDesc')?.value || 'Learn digital marketing from basics to advanced with practical examples.';
        const cat = document.getElementById('inputCategory')?.value || 'Digital Marketing';
        const lang = document.getElementById('inputLanguage')?.value || 'Hindi';
        const level = document.getElementById('inputLevel')?.value || 'Beginner';
        const access = document.getElementById('inputAccessType')?.value || 'Lifetime Access';
        const thumbUrl = document.getElementById('inputThumbnailUrl')?.value;
        const isFree = document.getElementById('priceRadioFree')?.checked;
        const price = parseFloat(document.getElementById('inputPrice')?.value) || 0;
        const discountPrice = parseFloat(document.getElementById('inputDiscountPrice')?.value) || 0;
        const cert = document.getElementById('checkCertificate')?.checked;
        const qa = document.getElementById('checkQa')?.checked;

        // Card update
        if (document.getElementById('previewTitle')) document.getElementById('previewTitle').textContent = title;
        if (document.getElementById('previewDesc')) document.getElementById('previewDesc').textContent = desc;
        if (thumbUrl && document.getElementById('previewImg') && !document.getElementById('inputThumbnailFile')?.files?.length) {
            document.getElementById('previewImg').src = thumbUrl;
        }

        const priceEl = document.getElementById('previewPrice');
        const origPriceEl = document.getElementById('previewOrigPrice');
        const offBadge = document.getElementById('previewOffBadge');

        if (isFree) {
            priceEl.textContent = 'FREE';
            origPriceEl.style.display = 'none';
            offBadge.style.display = 'none';
        } else {
            origPriceEl.style.display = 'inline';
            if (discountPrice > 0 && discountPrice < price) {
                priceEl.textContent = '₹' + discountPrice.toLocaleString('en-IN');
                origPriceEl.textContent = '₹' + price.toLocaleString('en-IN');
                const offPercent = Math.round(((price - discountPrice) / price) * 100);
                offBadge.textContent = offPercent + '% OFF';
                offBadge.style.display = 'inline';
            } else {
                priceEl.textContent = '₹' + price.toLocaleString('en-IN');
                origPriceEl.style.display = 'none';
                offBadge.style.display = 'none';
            }
        }

        // Summary Checklist update
        if (document.getElementById('summaryCategory')) document.getElementById('summaryCategory').textContent = cat;
        if (document.getElementById('summaryLanguage')) document.getElementById('summaryLanguage').textContent = lang;
        if (document.getElementById('summaryLevel')) document.getElementById('summaryLevel').textContent = level;
        if (document.getElementById('summaryAccess')) document.getElementById('summaryAccess').textContent = access;
        if (document.getElementById('summaryCert')) document.getElementById('summaryCert').textContent = cert ? 'Included' : 'None';
        if (document.getElementById('summaryQa')) document.getElementById('summaryQa').textContent = qa ? 'Enabled' : 'Disabled';
    }

    let sectionCount = 3;
    function addNewSection() {
        sectionCount++;
        const container = document.getElementById('sectionsContainer');
        const sectionId = 'section-' + sectionCount;
        const lecturesId = 'lectures-section-' + sectionCount;

        const html = `
            <div class="section-block" id="${sectionId}">
                <div class="section-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-folder text-primary"></i>
                        <span class="section-title-text" contenteditable="true">${sectionCount}. New Section</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="removeSection('${sectionId}')" title="Delete section">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
                <div class="lectures-list" id="${lecturesId}">
                    <div class="lecture-item">
                        <div class="lecture-left">
                            <i class="fa-regular fa-circle-play text-primary"></i>
                            <span contenteditable="true">Lesson 1: Introduction</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="lecture-duration" contenteditable="true">10:00</span>
                            <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-2 bg-light bg-opacity-50 border-top">
                    <button type="button" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none p-0" onclick="addLectureToSection('${lecturesId}')">
                        <i class="fa-solid fa-plus me-1"></i> Add Lecture
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeSection(sectionId) {
        const el = document.getElementById(sectionId);
        if (el) el.remove();
    }

    function addLectureToSection(lecturesId) {
        const list = document.getElementById(lecturesId);
        if (!list) return;

        const count = list.children.length + 1;
        const html = `
            <div class="lecture-item">
                <div class="lecture-left">
                    <i class="fa-regular fa-circle-play text-primary"></i>
                    <span contenteditable="true">Lesson ${count}: New Lecture Title</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="lecture-duration" contenteditable="true">10:00</span>
                    <button type="button" class="btn btn-link text-muted p-0" onclick="this.closest('.lecture-item').remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        `;
        list.insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection
