@extends('layouts.app')

@section('title', 'Become a Seller - Create Your Seller Account | Digital Class Marketplace')

@section('styles')
<style>
    /* Page Layout & Background */
    .dc-register-wrapper {
        background-color: #f8fafc;
        padding: 2.25rem 0 4rem;
        min-height: calc(100vh - 120px);
    }

    /* Left Promo Column */
    .hero-badge-pill {
        display: inline-block;
        background-color: #eff6ff;
        color: #0066ff;
        font-size: 0.825rem;
        font-weight: 700;
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        border: 1px solid #dbeafe;
        margin-bottom: 1rem;
    }

    .hero-title-main {
        font-family: var(--dc-font-heading);
        font-size: 2.35rem;
        font-weight: 800;
        line-height: 1.18;
        color: #0f172a;
        letter-spacing: -0.03em;
        margin-bottom: 0.35rem;
    }

    .hero-subtitle-blue {
        font-family: var(--dc-font-heading);
        font-size: 1.35rem;
        font-weight: 700;
        color: #0066ff;
        line-height: 1.3;
        margin-bottom: 1rem;
    }

    .hero-desc-text {
        font-size: 0.925rem;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 1.75rem;
    }

    .feature-point-row {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        margin-bottom: 1.15rem;
    }

    .feature-icon-square {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    /* Floating Showcase Graphic */
    .showcase-container {
        position: relative;
        margin-top: 2rem;
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(145deg, #eff6ff 0%, #e0f2fe 100%);
        padding: 1.5rem 1rem 0;
        text-align: center;
    }

    .showcase-tutor-img {
        max-width: 240px;
        height: auto;
        display: block;
        margin: 0 auto;
        filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.15));
        border-radius: 16px 16px 0 0;
    }

    .floating-chip {
        position: absolute;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.12);
        border: 1px solid #e2e8f0;
        padding: 0.65rem 0.85rem;
        text-align: left;
        z-index: 2;
        font-size: 0.75rem;
    }

    .chip-left {
        bottom: 25px;
        left: 10px;
        width: 175px;
    }

    .chip-right-top {
        top: 25px;
        right: 10px;
        width: 170px;
    }

    .chip-right-bottom {
        bottom: 20px;
        right: 10px;
        width: 160px;
    }

    /* Middle Form Card */
    .reg-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        padding: 2rem 2.25rem;
    }

    /* 4-Step Stepper Header (matching screenshot) */
    .reg-stepper-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        margin-bottom: 2rem;
        padding: 0 0.5rem;
    }

    .reg-stepper-wrap::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 25px;
        right: 25px;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    .step-item {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #cbd5e1;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.35rem;
        transition: all 0.2s ease;
    }

    .step-item.active .step-circle {
        background: #0066ff;
        border-color: #0066ff;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.15);
    }

    .step-label {
        font-size: 0.725rem;
        font-weight: 600;
        color: #64748b;
    }

    .step-item.active .step-label {
        color: #0066ff;
        font-weight: 700;
    }

    /* Account Type Selectable Cards */
    .account-type-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.65rem;
        margin-bottom: 1.5rem;
    }

    .account-type-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 0.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        position: relative;
    }

    .account-type-card:hover {
        border-color: #93c5fd;
        background: #f8fafc;
    }

    .account-type-card.selected {
        border-color: #0066ff;
        background: #eff6ff;
        box-shadow: 0 2px 8px rgba(0, 102, 255, 0.12);
    }

    .account-type-card .icon-box {
        font-size: 1.25rem;
        color: #0066ff;
        margin-bottom: 0.35rem;
    }

    .account-type-card .title-text {
        font-size: 0.8rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.15rem;
    }

    .account-type-card .sub-text {
        font-size: 0.65rem;
        color: #64748b;
        line-height: 1.2;
    }

    /* Right Why Sell Card */
    .why-sell-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        padding: 1.75rem 1.65rem;
    }

    .benefit-item-row {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        margin-bottom: 1.2rem;
    }

    .benefit-icon-box {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .free-reg-banner {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        padding: 0.95rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .video-preview-banner {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 14px;
        padding: 1.15rem;
    }

    .video-thumb-card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-top: 0.85rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .video-thumb-img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        display: block;
    }

    .video-overlay-play {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #ffffff;
        transition: background 0.2s;
    }
    .video-overlay-play:hover {
        background: rgba(15, 23, 42, 0.3);
    }

    .video-play-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #ffffff;
        color: #0066ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-bottom: 0.35rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('content')
<div class="dc-register-wrapper">
    <div class="container-fluid px-lg-4">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 mx-auto" style="max-width: 1280px;" role="alert">
                <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Please check the form:</strong>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 align-items-start justify-content-center">

            <!-- ===================================================================
                 LEFT COLUMN: HERO BRANDING & BENEFITS (Matching Screenshot)
                 =================================================================== -->
            <div class="col-xl-4 col-lg-5">
                <div class="pe-xl-3">
                    <span class="hero-badge-pill">Become a Seller on Digital Class</span>

                    <h1 class="hero-title-main">
                        Sell Your Courses, Services & Products
                    </h1>

                    <h2 class="hero-subtitle-blue">
                        Grow Your Business with India's Trusted Marketplace
                    </h2>

                    <p class="hero-desc-text">
                        Reach thousands of students, professionals and businesses. Create your own store, list your offerings and start earning.
                    </p>

                    <!-- 4 Key Points with Soft-Colored Badges -->
                    <div class="feature-point-row">
                        <div class="feature-icon-square" style="background-color: #ecfdf5; color: #10b981;">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">One Seller Store</div>
                            <div class="text-muted" style="font-size: 0.8rem;">List Courses, Services & Products</div>
                        </div>
                    </div>

                    <div class="feature-point-row">
                        <div class="feature-icon-square" style="background-color: #eff6ff; color: #2563eb;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">Wide Audience</div>
                            <div class="text-muted" style="font-size: 0.8rem;">Students, Professionals & Businesses</div>
                        </div>
                    </div>

                    <div class="feature-point-row">
                        <div class="feature-icon-square" style="background-color: #fff7ed; color: #ea580c;">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">Easy Management</div>
                            <div class="text-muted" style="font-size: 0.8rem;">Manage everything from one dashboard</div>
                        </div>
                    </div>

                    <div class="feature-point-row">
                        <div class="feature-icon-square" style="background-color: #fdf4ff; color: #a855f7;">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">Grow Your Brand</div>
                            <div class="text-muted" style="font-size: 0.8rem;">Get more visibility and sales</div>
                        </div>
                    </div>

                    <!-- Floating Showcase Graphic (Matching Screenshot) -->
                    <div class="showcase-container d-none d-md-block">
                        <!-- Floating Card 1: Courses -->
                        <div class="floating-chip chip-left">
                            <div class="d-flex align-items-center gap-1 fw-bold text-primary mb-1">
                                <i class="fa-solid fa-graduation-cap"></i> My Courses
                            </div>
                            <div class="text-muted" style="font-size: 0.675rem;">
                                <div>• Digital Marketing <span class="badge bg-light text-dark float-end">125</span></div>
                                <div>• Tally Prime <span class="badge bg-light text-dark float-end">85</span></div>
                                <div>• AI Tools Mastery <span class="badge bg-light text-dark float-end">64</span></div>
                            </div>
                        </div>

                        <!-- Floating Card 2: Services -->
                        <div class="floating-chip chip-right-top">
                            <div class="d-flex align-items-center gap-1 fw-bold text-success mb-1">
                                <i class="fa-solid fa-handshake-angle"></i> My Services
                            </div>
                            <div class="text-muted" style="font-size: 0.675rem;">
                                <div>• Website Dev <span class="badge bg-light text-dark float-end">25</span></div>
                                <div>• Graphics Design <span class="badge bg-light text-dark float-end">19</span></div>
                                <div>• Resume Making <span class="badge bg-light text-dark float-end">42</span></div>
                            </div>
                        </div>

                        <!-- Floating Card 3: Products -->
                        <div class="floating-chip chip-right-bottom">
                            <div class="d-flex align-items-center gap-1 fw-bold text-danger mb-1">
                                <i class="fa-solid fa-box-open"></i> My Products
                            </div>
                            <div class="text-muted" style="font-size: 0.675rem;">
                                <div>• Laptop Accessories</div>
                                <div>• UI Kits & Notes</div>
                            </div>
                        </div>

                        <!-- Tutor Visual Illustration -->
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80" alt="Successful Seller on Digital Class" class="showcase-tutor-img">
                    </div>
                </div>
            </div>

            <!-- ===================================================================
                 MIDDLE COLUMN: CREATE SELLER ACCOUNT FORM (Matching Screenshot)
                 =================================================================== -->
            <div class="col-xl-5 col-lg-7">
                <div class="reg-form-card">
                    <!-- Form Header -->
                    <h3 class="fw-bold text-dark mb-1" style="font-family: var(--dc-font-heading);">
                        Create Your Seller Account
                    </h3>
                    <p class="text-muted small mb-3">
                        It's free and takes less than 2 minutes. Start selling your courses, services or products on Digital Class.
                    </p>

                    @auth
                        <div class="alert alert-info py-2 px-3 small rounded-3 mb-3 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa-solid fa-user-circle me-1"></i>
                                Currently signed in as <strong>{{ Auth::user()->name }}</strong>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if(Auth::user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}" class="btn btn-sm btn-outline-primary py-0 px-2 fw-semibold" style="font-size: 0.75rem;">
                                        Dashboard &rarr;
                                    </a>
                                @endif
                                <a href="{{ route('seller.logout') }}" class="btn btn-sm btn-outline-danger py-0 px-2 fw-semibold" style="font-size: 0.75rem;">
                                    Log Out
                                </a>
                            </div>
                        </div>
                    @endauth

                    <!-- 4-Step Stepper (matching screenshot 1: Basic Details, 2: Business Info, 3: Verify, 4: Go Live) -->
                    <div class="reg-stepper-wrap">
                        <div class="step-item active">
                            <div class="step-circle">1</div>
                            <span class="step-label">Basic Details</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle">2</div>
                            <span class="step-label">Business Info</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle">3</div>
                            <span class="step-label">Verify</span>
                        </div>
                        <div class="step-item">
                            <div class="step-circle">4</div>
                            <span class="step-label">Go Live</span>
                        </div>
                    </div>

                    <form action="{{ route('seller.register.submit') }}" method="POST" id="sellerRegisterForm">
                        @csrf

                        <!-- 1. Full Name -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Enter your full name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 2. Email Address -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Enter your email address" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 3. Mobile Number with +91 selector -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Mobile Number <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <button class="btn btn-outline-secondary dropdown-toggle bg-light text-dark fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.9rem;">
                                    +91
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item small" href="#">+91 (India)</a></li>
                                    <li><a class="dropdown-item small" href="#">+1 (USA)</a></li>
                                    <li><a class="dropdown-item small" href="#">+44 (UK)</a></li>
                                    <li><a class="dropdown-item small" href="#">+971 (UAE)</a></li>
                                </ul>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter your mobile number" value="{{ old('phone') }}" required>
                            </div>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 4. Password -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="password" name="password" id="regPassword" class="form-control @error('password') is-invalid @enderror" placeholder="Create a password" required>
                                <button class="btn btn-outline-secondary bg-white" type="button" onclick="togglePasswordVisibility('regPassword', this)">
                                    <i class="fa-regular fa-eye text-muted"></i>
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 0.775rem;">
                                Use at least 6 characters with a number or symbol.
                            </small>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 5. Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="password" name="password_confirmation" id="regPasswordConfirm" class="form-control" placeholder="Confirm your password" required>
                                <button class="btn btn-outline-secondary bg-white" type="button" onclick="togglePasswordVisibility('regPasswordConfirm', this)">
                                    <i class="fa-regular fa-eye text-muted"></i>
                                </button>
                            </div>
                        </div>

                        <!-- 6. I am a * (Account Type 3-card Selection) -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark mb-2">I am a <span class="text-danger">*</span></label>
                            
                            <div class="account-type-grid">
                                <!-- Option 1: Individual -->
                                <div class="account-type-card {{ old('account_type', \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL) == \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL ? 'selected' : '' }}" onclick="selectAccountType('{{ \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL }}', this)">
                                    <div class="icon-box"><i class="fa-solid fa-user"></i></div>
                                    <div class="title-text">Individual</div>
                                    <div class="sub-text">Freelancer / Trainer</div>
                                </div>

                                <!-- Option 2: Institute / Company -->
                                <div class="account-type-card {{ old('account_type') == \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE ? 'selected' : '' }}" onclick="selectAccountType('{{ \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE }}', this)">
                                    <div class="icon-box"><i class="fa-solid fa-building-columns"></i></div>
                                    <div class="title-text">Institute / Company</div>
                                    <div class="sub-text">Training Institute, Business</div>
                                </div>

                                <!-- Option 3: Agency -->
                                <div class="account-type-card {{ old('account_type') == \App\Models\Seller::ACCOUNT_TYPE_AGENCY ? 'selected' : '' }}" onclick="selectAccountType('{{ \App\Models\Seller::ACCOUNT_TYPE_AGENCY }}', this)">
                                    <div class="icon-box"><i class="fa-solid fa-users-gear"></i></div>
                                    <div class="title-text">Agency</div>
                                    <div class="sub-text">Multi-service Provider</div>
                                </div>
                            </div>
                            
                            <!-- Hidden input holding selected account type -->
                            <input type="hidden" name="account_type" id="selectedAccountType" value="{{ old('account_type', \App\Models\Seller::ACCOUNT_TYPE_INDIVIDUAL) }}">
                            @error('account_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Optional Institute/Business Fields (Collapsible / Seamless) -->
                        <div id="businessOptionalFields" class="p-3 bg-light rounded-3 mb-3" style="display: {{ old('account_type') == \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE || old('account_type') == \App\Models\Seller::ACCOUNT_TYPE_AGENCY ? 'block' : 'none' }};">
                            <h6 class="fw-bold small text-dark mb-2"><i class="fa-solid fa-building text-primary me-1"></i> Business / Institute Info</h6>
                            <div class="row g-2">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="business_name" class="form-control form-control-sm" placeholder="Store / Institute Name" value="{{ old('business_name') }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="city" class="form-control form-control-sm" placeholder="City (e.g. Ahmedabad)" value="{{ old('city', 'Ahmedabad') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Continue Button (Matching Screenshot) -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #0066ff; border-radius: 10px;">
                            <span>Continue</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <!-- Already have an account link -->
                        <div class="text-center mt-3">
                            <span class="text-muted small">Already have a seller account? </span>
                            <a href="{{ route('seller.login') }}" class="small fw-bold text-primary text-decoration-none">Login here</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===================================================================
                 RIGHT COLUMN: WHY SELL ON DIGITAL CLASS? (Matching Screenshot)
                 =================================================================== -->
            <div class="col-xl-3 col-lg-5">
                <div class="why-sell-card">
                    <!-- Rocket Icon Header -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.3rem;">
                            <i class="fa-solid fa-rocket"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0" style="font-family: var(--dc-font-heading); font-size: 1.1rem;">
                                Why Sell on Digital Class?
                            </h5>
                        </div>
                    </div>
                    <p class="text-muted small mb-4">
                        Everything you need to grow your education and service business.
                    </p>

                    <!-- 5 Feature Points with Colored Square Badges -->
                    <div class="benefit-item-row">
                        <div class="benefit-icon-box" style="background-color: #ecfdf5; color: #10b981;">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">All-in-One Marketplace</div>
                            <div class="text-muted" style="font-size: 0.775rem;">Sell courses, services and products from one store.</div>
                        </div>
                    </div>

                    <div class="benefit-item-row">
                        <div class="benefit-icon-box" style="background-color: #eff6ff; color: #2563eb;">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">Reach the Right Audience</div>
                            <div class="text-muted" style="font-size: 0.775rem;">Students, professionals, businesses and institutions.</div>
                        </div>
                    </div>

                    <div class="benefit-item-row">
                        <div class="benefit-icon-box" style="background-color: #fff7ed; color: #ea580c;">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">Trusted Platform</div>
                            <div class="text-muted" style="font-size: 0.775rem;">Verified sellers, secure payments and support.</div>
                        </div>
                    </div>

                    <div class="benefit-item-row">
                        <div class="benefit-icon-box" style="background-color: #fdf4ff; color: #a855f7;">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">Easy Store Management</div>
                            <div class="text-muted" style="font-size: 0.775rem;">Manage listings, orders, students and earnings easily.</div>
                        </div>
                    </div>

                    <div class="benefit-item-row">
                        <div class="benefit-icon-box" style="background-color: #fef2f2; color: #ef4444;">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">Multiple Earning Opportunities</div>
                            <div class="text-muted" style="font-size: 0.775rem;">Sell online courses, offer services or physical products.</div>
                        </div>
                    </div>

                    <!-- Highlight Box 1: Free Seller Registration -->
                    <div class="free-reg-banner">
                        <div class="rounded-circle bg-white text-warning shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 1.1rem;">
                            <i class="fa-solid fa-gift"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success small">Free Seller Registration</div>
                            <div class="text-muted" style="font-size: 0.75rem;">No listing fees. Start selling today!</div>
                        </div>
                    </div>

                    <!-- Highlight Box 2: Watch: How to Become a Seller -->
                    <div class="video-preview-banner">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-circle-play text-warning fs-5"></i>
                            <div class="fw-bold text-dark small">Watch: How to Become a Seller</div>
                        </div>
                        <div class="text-muted" style="font-size: 0.75rem;">
                            Learn how to create your store, list courses, services and products in just a few steps.
                        </div>

                        <!-- Video thumbnail preview card -->
                        <div class="video-thumb-card" onclick="alert('Digital Class Seller Onboarding Guide (02:30)')">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=80" alt="Watch Video" class="video-thumb-img">
                            <div class="video-overlay-play">
                                <div class="video-play-btn">
                                    <i class="fa-solid fa-play ps-1"></i>
                                </div>
                                <span class="badge bg-black bg-opacity-75 font-mono-code" style="font-size: 0.65rem;">
                                    How to Become a Seller (02:30)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function selectAccountType(type, cardEl) {
        document.querySelectorAll('.account-type-card').forEach(el => el.classList.remove('selected'));
        cardEl.classList.add('selected');
        document.getElementById('selectedAccountType').value = type;

        const businessSection = document.getElementById('businessOptionalFields');
        if (type === '{{ \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE }}' || type === '{{ \App\Models\Seller::ACCOUNT_TYPE_AGENCY }}') {
            businessSection.style.display = 'block';
        } else {
            businessSection.style.display = 'none';
        }
    }

    function togglePasswordVisibility(inputId, btnEl) {
        const input = document.getElementById(inputId);
        const icon = btnEl.querySelector('i');
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
