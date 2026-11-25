@extends('layouts.app')

@section('title', 'Sign Up as Customer - Instant Access to Digital Class Marketplace')

@section('styles')
<style>
    .dc-auth-wrapper {
        background: radial-gradient(circle at 50% 0%, #1e1145 0%, #0c0a1a 45%, #06050d 100%);
        min-height: calc(100vh - 120px);
        padding: 3rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .dc-auth-wrapper::before {
        content: '';
        position: absolute;
        top: -120px;
        left: 10%;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, rgba(124, 58, 237, 0.22) 0%, transparent 70%);
        pointer-events: none;
        filter: blur(50px);
    }
    .dc-auth-wrapper::after {
        content: '';
        position: absolute;
        bottom: 5%;
        right: 10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 70%);
        pointer-events: none;
        filter: blur(50px);
    }

    .auth-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(124, 58, 237, 0.15);
        color: #c4b5fd;
        border: 1px solid rgba(167, 139, 250, 0.3);
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.4rem 1rem;
        border-radius: 999px;
        margin-bottom: 1.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        backdrop-filter: blur(8px);
    }

    .auth-hero-title {
        font-family: var(--dc-font-heading);
        font-size: 2.4rem;
        font-weight: 800;
        line-height: 1.2;
        color: #ffffff;
        letter-spacing: -0.03em;
        margin-bottom: 0.75rem;
    }
    .auth-hero-title span {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ec4899 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .auth-hero-sub {
        font-size: 1.05rem;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.15rem;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        transition: all 0.25s ease;
    }
    .benefit-item:hover {
        border-color: rgba(167, 139, 250, 0.4);
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }
    .benefit-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .auth-form-card {
        background: #ffffff;
        border-radius: 26px;
        box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .auth-card-header {
        background: linear-gradient(135deg, #1c1038 0%, #2e1065 50%, #4c1d95 100%);
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        position: relative;
    }

    .custom-auth-input-group {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #f8fafc;
    }
    .custom-auth-input-group:focus-within {
        border-color: #7c3aed;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.12);
    }
    .custom-auth-input-group .input-group-text {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 0.95rem;
        padding-left: 1rem;
    }
    .custom-auth-input-group:focus-within .input-group-text {
        color: #7c3aed;
    }
    .custom-auth-input-group .form-control,
    .custom-auth-input-group .form-select {
        border: none;
        background: transparent;
        font-size: 0.925rem;
        padding: 0.75rem 0.95rem;
        box-shadow: none;
        color: #0f172a;
    }
    .custom-auth-input-group .form-control:focus,
    .custom-auth-input-group .form-select:focus {
        background: transparent;
        box-shadow: none;
    }

    .interest-chip-label {
        border: 1.5px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.45rem 1rem;
        font-size: 0.825rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        user-select: none;
    }
    .interest-chip-input:checked + .interest-chip-label {
        background-color: #f5f3ff;
        border-color: #7c3aed;
        color: #6d28d9;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.15);
    }

    .btn-submit-customer {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 50%, #9333ea 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        letter-spacing: 0.01em;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 25px -4px rgba(124, 58, 237, 0.45);
    }
    .btn-submit-customer:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #6d28d9 50%, #7c3aed 100%);
        box-shadow: 0 16px 32px -4px rgba(124, 58, 237, 0.55);
        color: #ffffff;
        transform: translateY(-2px);
    }
    .btn-submit-customer:active {
        transform: translateY(0);
    }

    .luxury-accent-link {
        color: #7c3aed;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .luxury-accent-link:hover {
        color: #5b21b6;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="dc-auth-wrapper">
    <div class="container position-relative" style="z-index: 2;">
        
        <!-- Breadcrumb / Back Link -->
        <div class="mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <a href="{{ route('home') }}" class="text-white-50 text-decoration-none small d-inline-flex align-items-center gap-1.5 hover-white">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Marketplace</span>
            </a>
            <div class="text-white-50 small">
                Looking for instructor/institution portal? 
                <a href="{{ route('seller.register') }}" class="text-warning fw-bold text-decoration-none ms-1">
                    Become a Seller &rarr;
                </a>
            </div>
        </div>

        <div class="row g-4 g-xl-5 align-items-start">
            
            <!-- LEFT COLUMN: VALUE PROPOSITION & PROFILES -->
            <div class="col-lg-5">
                <div class="pe-xl-3">
                    
                    <!-- Pill Badge -->
                    <span class="auth-badge-pill">
                        <i class="fa-solid fa-sparkles text-warning"></i> Instant Marketplace Access
                    </span>

                    <!-- Main Headline -->
                    <h1 class="auth-hero-title">
                        One Account for <span>Everything</span> You Need to Learn & Build.
                    </h1>

                    <p class="auth-hero-sub">
                        Create your free customer account in seconds to browse courses, hire experts, and purchase verified tools across 11,000+ top institutes.
                    </p>

                    <!-- Key Benefits -->
                    <div class="benefit-item">
                        <div class="benefit-icon-box" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-0.5" style="font-size: 0.95rem;">No Admin Approval Needed</h6>
                            <p class="small text-white-50 mb-0">Unlike sellers, your customer account is approved instantly! You can start browsing and buying in seconds.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-box" style="background: rgba(167, 139, 250, 0.2); color: #c4b5fd; border: 1px solid rgba(167, 139, 250, 0.3);">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-0.5" style="font-size: 0.95rem;">For Students & Learners</h6>
                            <p class="small text-white-50 mb-0">Enroll in top instructor-led courses, watch video lectures, access study material, and earn verified certificates.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-box" style="background: rgba(56, 189, 248, 0.2); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3);">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-0.5" style="font-size: 0.95rem;">For Business Owners & Employees</h6>
                            <p class="small text-white-50 mb-0">Hire verified agencies for web/app development, marketing, purchase software assets, and source business tools.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-box" style="background: rgba(244, 114, 182, 0.2); color: #f472b6; border: 1px solid rgba(244, 114, 182, 0.3);">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-0.5" style="font-size: 0.95rem;">For Teachers & Educators</h6>
                            <p class="small text-white-50 mb-0">Access classroom kits, educational templates, and expand your digital teaching infrastructure.</p>
                        </div>
                    </div>

                    <!-- Trust Stats Bar -->
                    <div class="p-3.5 rounded-4 border mt-4" style="background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(12px); border-color: rgba(255, 255, 255, 0.1) !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-1.5 text-warning small fw-bold">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span class="text-white ms-1">4.9/5 Rating</span>
                            </div>
                            <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 fw-bold px-2 py-0.5" style="font-size: 0.7rem;">Verified Platform</span>
                        </div>
                        <p class="small text-white-50 mb-0" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-shield-halved text-warning me-1"></i> 100% Secure checkout & buyer satisfaction guarantee on all orders.
                        </p>
                    </div>

                    <!-- Seller Switch Callout -->
                    <div class="mt-3 text-center p-3 rounded-4 border" style="background: rgba(255, 255, 255, 0.04); border-color: rgba(255, 255, 255, 0.08) !important;">
                        <span class="small text-white-50 d-block mb-1">Want to teach courses or offer professional services?</span>
                        <a href="{{ route('seller.register') }}" class="fw-bold text-warning text-decoration-none small">
                            <i class="fa-solid fa-store me-1"></i> Register as a Marketplace Seller &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: REGISTRATION FORM -->
            <div class="col-lg-7">
                <div class="auth-form-card">
                    
                    <!-- Header -->
                    <div class="auth-card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px);">
                                    <i class="fa-solid fa-user-plus text-white fs-5"></i>
                                </div>
                                <div>
                                    <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2.5 py-0.5 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">
                                        Free Registration
                                    </span>
                                    <h3 class="fw-bold mb-0 text-white fs-4 mt-0.5">Create Customer Account</h3>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1.5 fw-bold shadow-xs" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-bolt me-1"></i> Instant Active
                            </span>
                        </div>
                        <p class="text-white-50 small mb-0" style="font-size: 0.85rem;">
                            No waiting or approvals. Sign up and immediately explore, book services, and buy products.
                        </p>
                    </div>

                    <!-- Form Body -->
                    <div class="p-4 p-md-5">

                        <!-- Session Alerts -->
                        @if (session('error'))
                            <div class="alert alert-danger border-0 rounded-3 shadow-xs mb-4 p-3" role="alert">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                                    <span class="small text-danger fw-semibold">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success border-0 rounded-3 shadow-xs mb-4 p-3" role="alert">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                    <span class="small text-success fw-semibold">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 shadow-xs mb-4 p-3" role="alert">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                                    <strong class="text-dark small">Please check the following details:</strong>
                                </div>
                                <ul class="mb-0 ps-3 small text-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.register.submit') }}" id="customerFullRegisterForm">
                            @csrf

                            <!-- Redirect URL pass-through -->
                            <input type="hidden" name="redirect_to" value="{{ request('redirect_to', request('return_url')) }}">

                            <!-- ROW 1: FULL NAME & EMAIL -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                        <input type="text" name="name" class="form-control" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">Your legal name for course certificates & invoices</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">Login ID & purchase receipts will be sent here</div>
                                </div>
                            </div>

                            <!-- ROW 2: MOBILE NUMBER & PROFESSION DROPDOWN -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Mobile Number <span class="text-muted fw-normal">(Optional)</span>
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text fw-bold text-dark" style="font-size: 0.85rem;">+91</span>
                                        <input type="tel" name="phone" class="form-control font-monospace" placeholder="9876543210" value="{{ old('phone') }}" maxlength="15">
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">For order updates & instant delivery SMS</div>
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Profession / Who Are You? <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-briefcase"></i></span>
                                        <select name="profession" id="inputProfession" class="form-select fw-semibold text-dark" required>
                                            <option value="" disabled {{ old('profession') ? '' : 'selected' }}>-- Select Your Profession / Background * --</option>
                                            
                                            <optgroup label="🎓 Students & Learners">
                                                <option value="Student / Learner" {{ old('profession', 'Student / Learner') == 'Student / Learner' ? 'selected' : '' }}>Student / Learner (College / School)</option>
                                                <option value="Job Seeker / Fresher" {{ old('profession') == 'Job Seeker / Fresher' ? 'selected' : '' }}>Job Seeker / Fresher (Looking for Jobs)</option>
                                            </optgroup>

                                            <optgroup label="💼 Business Owners & Entrepreneurs">
                                                <option value="Business Owner" {{ old('profession') == 'Business Owner' ? 'selected' : '' }}>Business Owner / Founder / MSME</option>
                                                <option value="Retailer / Merchant" {{ old('profession') == 'Retailer / Merchant' ? 'selected' : '' }}>Retailer / Merchant / Store Owner</option>
                                            </optgroup>

                                            <optgroup label="👨‍💻 Working Professionals & Employees">
                                                <option value="Working Professional / Employee" {{ old('profession') == 'Working Professional / Employee' ? 'selected' : '' }}>Working Professional / Corporate Employee</option>
                                                <option value="Freelancer / Agency" {{ old('profession') == 'Freelancer / Agency' ? 'selected' : '' }}>Freelancer / Consultant / Agency</option>
                                            </optgroup>

                                            <optgroup label="👩‍🏫 Teachers & Academics">
                                                <option value="Teacher / Educator" {{ old('profession') == 'Teacher / Educator' ? 'selected' : '' }}>Teacher / Educator / Private Tutor</option>
                                                <option value="Institute Representative" {{ old('profession') == 'Institute Representative' ? 'selected' : '' }}>Institute Representative / Administrator</option>
                                            </optgroup>

                                            <optgroup label="🌐 Other Profiles">
                                                <option value="Parent / Guardian" {{ old('profession') == 'Parent / Guardian' ? 'selected' : '' }}>Parent / Guardian (For my children)</option>
                                                <option value="Other Professional" {{ old('profession') == 'Other Professional' ? 'selected' : '' }}>Other Professional Profile</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">Helps personalize your marketplace experience</div>
                                </div>
                            </div>

                            <!-- ROW 3: LOCATION (CITY & STATE) -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        City
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                        <input type="text" name="city" class="form-control" placeholder="e.g. Ahmedabad" value="{{ old('city', 'Ahmedabad') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        State
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-map"></i></span>
                                        <input type="text" name="state" class="form-control" placeholder="e.g. Gujarat" value="{{ old('state', 'Gujarat') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- ROW 4: PRIMARY INTERESTS CHIPS -->
                            <div class="mb-3.5">
                                <label class="form-label small fw-bold text-dark mb-1.5 d-block">
                                    What are you most interested in? <span class="text-muted fw-normal">(Select all that apply)</span>
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    <label class="mb-0">
                                        <input type="checkbox" name="interests[]" value="Courses" class="interest-chip-input d-none" checked>
                                        <span class="interest-chip-label">
                                            <i class="fa-solid fa-graduation-cap me-1"></i> Online Courses
                                        </span>
                                    </label>
                                    <label class="mb-0">
                                        <input type="checkbox" name="interests[]" value="Services" class="interest-chip-input d-none">
                                        <span class="interest-chip-label">
                                            <i class="fa-solid fa-briefcase me-1"></i> Professional Services
                                        </span>
                                    </label>
                                    <label class="mb-0">
                                        <input type="checkbox" name="interests[]" value="Products" class="interest-chip-input d-none">
                                        <span class="interest-chip-label">
                                            <i class="fa-solid fa-box-open me-1"></i> Digital Products & Scripts
                                        </span>
                                    </label>
                                    <label class="mb-0">
                                        <input type="checkbox" name="interests[]" value="Business Listings" class="interest-chip-input d-none">
                                        <span class="interest-chip-label">
                                            <i class="fa-solid fa-store me-1"></i> Local Businesses
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- ROW 5: PASSWORD & CONFIRM PASSWORD -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" id="fieldPassword" class="form-control" placeholder="Min. 6 characters" required>
                                        <button class="btn btn-link text-muted px-2.5 text-decoration-none" type="button" onclick="togglePassVisibility('fieldPassword', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">Minimum 6 characters</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group custom-auth-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" id="fieldPasswordConfirm" class="form-control" placeholder="Re-enter password" required>
                                        <button class="btn btn-link text-muted px-2.5 text-decoration-none" type="button" onclick="togglePassVisibility('fieldPasswordConfirm', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">Repeat password to confirm</div>
                                </div>
                            </div>

                            <!-- INSTANT ACTIVATION TRUST CALLOUT -->
                            <div class="p-3 rounded-4 mb-4 d-flex align-items-center gap-3" style="background: #f5f3ff; border: 1.5px solid #ddd6fe;">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);">
                                    <i class="fa-solid fa-bolt fs-6"></i>
                                </div>
                                <div class="text-dark">
                                    <strong class="d-block" style="font-size: 0.85rem; color: #6d28d9;">Instant Account Activation (No Approval Needed)</strong>
                                    <span class="text-muted" style="font-size: 0.8rem; line-height: 1.4;">
                                        Your customer account is ready immediately upon registration. You do not need to wait for any admin approvals — explore and purchase directly!
                                    </span>
                                </div>
                            </div>

                            <!-- TERMS CHECKBOX -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required checked style="accent-color: #7c3aed;">
                                <label class="form-check-label small text-muted" for="termsCheck" style="font-size: 0.8rem;">
                                    I agree to the <a href="#" class="luxury-accent-link">Terms of Service</a> and <a href="#" class="luxury-accent-link">Privacy Policy</a> of Digital Class Marketplace.
                                </label>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <button type="submit" class="btn btn-submit-customer btn-lg w-100 py-3 rounded-3 fs-6 d-flex align-items-center justify-content-center gap-2 mb-3 shadow-sm">
                                <span>Create Account & Start Buying</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>

                            <!-- LOGIN REDIRECT FOOTER -->
                            <div class="text-center small text-muted py-2">
                                Already have an account? 
                                <a href="{{ route('customer.login') }}" class="luxury-accent-link ms-1">
                                    Log In Here &rarr;
                                </a>
                            </div>

                            <hr class="my-4 opacity-25">

                            <!-- SELLER ENROLLMENT SWITCH -->
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border flex-wrap gap-2">
                                <div>
                                    <strong class="d-block text-dark small">Are you an Instructor, Agency or Business?</strong>
                                    <span class="text-muted small" style="font-size: 0.775rem;">Sell courses, list services or products on our marketplace</span>
                                </div>
                                <a href="{{ route('seller.register') }}" class="btn btn-dark btn-sm rounded-pill px-3 fw-bold" style="background: #0f172a;">
                                    <i class="fa-solid fa-store me-1 text-warning"></i> Register as Seller
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
