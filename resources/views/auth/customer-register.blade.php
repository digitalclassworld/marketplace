@extends('layouts.app')

@section('title', 'Sign Up as Customer - Instant Access to Digital Class Marketplace')

@section('styles')
<style>
    .dc-auth-wrapper {
        background: linear-gradient(180deg, #f8fafc 0%, #eef2f6 100%);
        min-height: calc(100vh - 120px);
        padding: 2.5rem 0 4rem;
    }

    .auth-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #ecfdf5;
        color: #047857;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        border: 1px solid #a7f3d0;
        margin-bottom: 1.25rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .auth-hero-title {
        font-family: var(--dc-font-heading);
        font-size: 2.35rem;
        font-weight: 800;
        line-height: 1.2;
        color: #0f172a;
        letter-spacing: -0.03em;
        margin-bottom: 0.75rem;
    }

    .auth-hero-sub {
        font-size: 1.05rem;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding: 0.85rem 1rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.2s ease;
    }
    .benefit-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        transform: translateY(-2px);
    }
    .benefit-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .auth-form-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .auth-card-header {
        background: linear-gradient(135deg, #064e3b 0%, #047857 55%, #059669 100%);
        padding: 2rem 2.25rem;
        color: #ffffff;
        position: relative;
    }

    .custom-auth-input-group {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #f8fafc;
    }
    .custom-auth-input-group:focus-within {
        border-color: #059669;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
    }
    .custom-auth-input-group .input-group-text {
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 0.95rem;
        padding-left: 0.95rem;
    }
    .custom-auth-input-group .form-control,
    .custom-auth-input-group .form-select {
        border: none;
        background: transparent;
        font-size: 0.9rem;
        padding: 0.65rem 0.85rem;
        box-shadow: none;
    }
    .custom-auth-input-group .form-control:focus,
    .custom-auth-input-group .form-select:focus {
        background: transparent;
        box-shadow: none;
    }

    .interest-chip-label {
        border: 1.5px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.35rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        user-select: none;
    }
    .interest-chip-input:checked + .interest-chip-label {
        background-color: #ecfdf5;
        border-color: #059669;
        color: #047857;
    }

    .btn-submit-customer {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        letter-spacing: 0.01em;
        transition: all 0.2s ease;
    }
    .btn-submit-customer:hover {
        background: linear-gradient(135deg, #047857 0%, #064e3b 100%);
        box-shadow: 0 6px 20px -3px rgba(5, 150, 105, 0.35);
        color: #ffffff;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="dc-auth-wrapper">
    <div class="container">
        
        <!-- Breadcrumb / Back Link -->
        <div class="mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
                <i class="fa-solid fa-arrow-left me-1.5"></i> Back to Marketplace
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="small text-muted">Already registered?</span>
                <a href="{{ route('customer.login') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Customer Login
                </a>
            </div>
        </div>

        <div class="row g-4 g-lg-5 align-items-start">
            
            <!-- LEFT COLUMN: VALUE PROPOSITION & BUYER PERKS -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="pe-xl-3 sticky-top" style="top: 100px;">
                    <div class="auth-badge-pill">
                        <i class="fa-solid fa-bolt text-warning"></i> Instant Marketplace Access
                    </div>

                    <h1 class="auth-hero-title">
                        One Account for All Learning, Services & Shopping
                    </h1>

                    <p class="auth-hero-sub">
                        Join thousands of students, business owners, professionals, and educators across India. Sign up once and buy directly with zero waiting.
                    </p>

                    <!-- Instant Access Highlights -->
                    <div class="benefit-item">
                        <div class="benefit-icon-box bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0.5" style="font-size: 0.95rem;">No Admin Approval Needed</h6>
                            <p class="small text-muted mb-0">Unlike sellers, your customer account is approved instantly! You can start browsing and buying in seconds.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-box" style="background-color: #ecfdf5; color: #047857;">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0.5" style="font-size: 0.95rem;">For Students & Learners</h6>
                            <p class="small text-muted mb-0">Enroll in top instructor-led courses, watch video lectures, access study material, and earn verified certificates.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-box bg-info bg-opacity-10 text-info">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0.5" style="font-size: 0.95rem;">For Business Owners & Employees</h6>
                            <p class="small text-muted mb-0">Hire verified agencies for web/app development, marketing, purchase software assets, and source business tools.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0.5" style="font-size: 0.95rem;">For Teachers & Educators</h6>
                            <p class="small text-muted mb-0">Access classroom kits, educational templates, and expand your digital teaching infrastructure.</p>
                        </div>
                    </div>

                    <!-- Trust Stats Bar -->
                    <div class="p-3.5 rounded-4 bg-white border mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-1.5 text-warning small fw-bold">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span class="text-dark ms-1">4.9/5 Rating</span>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-0.5" style="font-size: 0.7rem;">Verified Platform</span>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-shield-halved text-primary me-1"></i> 100% Secure Razorpay checkout & buyer satisfaction guarantee on all orders.
                        </p>
                    </div>

                    <!-- Seller Switch Callout -->
                    <div class="mt-3 text-center p-3 rounded-3 bg-light border">
                        <span class="small text-muted d-block mb-1">Want to teach courses or offer professional services?</span>
                        <a href="{{ route('seller.register') }}" class="fw-bold text-success text-decoration-none small">
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
                            <span class="badge bg-success text-white rounded-pill px-3 py-1.5 fw-bold shadow-xs" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-bolt me-1"></i> Instant Active
                            </span>
                        </div>
                        <p class="text-white-50 small mb-0" style="font-size: 0.85rem;">
                            No waiting or approvals. Sign up and immediately explore, book services, and buy products.
                        </p>
                    </div>

                    <!-- Form Body -->
                    <div class="p-4 p-md-5">

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
                            <div class="p-3 rounded-4 bg-success bg-opacity-10 border border-success border-opacity-25 text-success small mb-4 d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                                    <i class="fa-solid fa-bolt fs-6"></i>
                                </div>
                                <div class="text-dark">
                                    <strong class="d-block text-success" style="font-size: 0.85rem;">Instant Account Activation (No Approval Needed)</strong>
                                    <span class="text-muted" style="font-size: 0.8rem; line-height: 1.4;">
                                        Your customer account is ready immediately upon registration. You do not need to wait for any admin approvals — you can explore the marketplace and purchase courses, services, or products directly!
                                    </span>
                                </div>
                            </div>

                            <!-- TERMS CHECKBOX -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                                <label class="form-check-label small text-muted" for="termsCheck" style="font-size: 0.8rem;">
                                    I agree to the <a href="#" class="text-decoration-none fw-semibold" style="color: #059669;">Terms of Service</a> and <a href="#" class="text-decoration-none fw-semibold" style="color: #059669;">Privacy Policy</a> of Digital Class Marketplace.
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
                                <a href="{{ route('customer.login') }}" class="fw-bold text-decoration-none ms-1" style="color: #059669;">
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
                                <a href="{{ route('seller.register') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                                    <i class="fa-solid fa-store me-1"></i> Register as Seller
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
    if (!input || !icon) return;

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
