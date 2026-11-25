@extends('layouts.app')

@section('title', 'Customer Login - Digital Class World')

@section('styles')
<style>
    .luxury-auth-wrapper {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        background: radial-gradient(circle at 50% 0%, #1e1145 0%, #0c0a1a 45%, #06050d 100%);
        padding: 4rem 1rem;
        position: relative;
        overflow: hidden;
    }

    /* Ambient background glow orbs */
    .luxury-auth-wrapper::before {
        content: '';
        position: absolute;
        top: -150px;
        left: 20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(124, 58, 237, 0.25) 0%, rgba(124, 58, 237, 0) 70%);
        pointer-events: none;
        filter: blur(40px);
    }
    .luxury-auth-wrapper::after {
        content: '';
        position: absolute;
        bottom: -100px;
        right: 15%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(217, 119, 6, 0.18) 0%, rgba(217, 119, 6, 0) 70%);
        pointer-events: none;
        filter: blur(50px);
    }

    .luxury-auth-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1020px;
        margin: 0 auto;
    }

    .luxury-auth-card {
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 0 35px 80px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
        overflow: hidden;
        border: none;
    }

    /* Left Showcase Column */
    .luxury-showcase-pane {
        background: linear-gradient(145deg, #1c1038 0%, #2e1065 50%, #150d2e 100%);
        color: #ffffff;
        padding: 3.5rem 3rem;
        display: flex;
        flex-column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .luxury-showcase-pane::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 100% 0%, rgba(245, 158, 11, 0.15) 0%, transparent 60%);
        pointer-events: none;
    }

    .showcase-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fbbf24;
        font-size: 0.775rem;
        font-weight: 700;
        padding: 0.4rem 1rem;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
    }

    .showcase-heading {
        font-family: var(--dc-font-heading);
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
        color: #ffffff;
        letter-spacing: -0.02em;
        margin-bottom: 1rem;
    }
    .showcase-heading span {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .showcase-desc {
        color: #cbd5e1;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 2.5rem;
    }

    .showcase-feature-glass {
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 18px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.25s ease;
    }
    .showcase-feature-glass:hover {
        transform: translateX(4px);
        background: rgba(255, 255, 255, 0.1);
    }
    .feature-glass-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.25) 0%, rgba(124, 58, 237, 0.3) 100%);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #fbbf24;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Right Form Column */
    .luxury-form-pane {
        padding: 3.5rem 3rem;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .portal-switcher-tabs {
        display: flex;
        background: #f1f5f9;
        padding: 0.35rem;
        border-radius: 14px;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }
    .portal-tab-btn {
        flex: 1;
        text-align: center;
        padding: 0.55rem 0.85rem;
        font-size: 0.825rem;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
    }
    .portal-tab-btn.active {
        background: #ffffff;
        color: #6d28d9;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .portal-tab-btn:hover:not(.active) {
        color: #0f172a;
    }

    .form-hero-title {
        font-family: var(--dc-font-heading);
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin-bottom: 0.35rem;
    }

    .form-hero-sub {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 2rem;
    }

    .luxury-input-box {
        margin-bottom: 1.25rem;
    }
    .luxury-input-box label {
        display: block;
        font-size: 0.825rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.45rem;
    }
    .luxury-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.2s ease;
        overflow: hidden;
    }
    .luxury-input-wrapper:focus-within {
        border-color: #7c3aed;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.12);
    }
    .luxury-input-icon {
        padding: 0 1rem;
        color: #94a3b8;
        font-size: 1rem;
        display: flex;
        align-items: center;
    }
    .luxury-input-wrapper:focus-within .luxury-input-icon {
        color: #7c3aed;
    }
    .luxury-input-field {
        width: 100%;
        border: none;
        background: transparent;
        padding: 0.85rem 1rem 0.85rem 0;
        font-size: 0.925rem;
        color: #0f172a;
        font-family: inherit;
        outline: none;
    }
    .luxury-input-toggle {
        padding: 0 1rem;
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
    }
    .luxury-input-toggle:hover {
        color: #475569;
    }

    .btn-luxury-submit {
        background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 50%, #9333ea 100%);
        color: #ffffff;
        border: none;
        font-weight: 700;
        font-size: 0.975rem;
        padding: 0.95rem 1.75rem;
        border-radius: 14px;
        width: 100%;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 25px -4px rgba(124, 58, 237, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }
    .btn-luxury-submit:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #6d28d9 50%, #7c3aed 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 16px 30px -4px rgba(124, 58, 237, 0.55);
    }
    .btn-luxury-submit:active {
        transform: translateY(0);
    }

    .brand-accent-link {
        color: #7c3aed;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }
    .brand-accent-link:hover {
        color: #5b21b6;
        text-decoration: underline;
    }

    @media (max-width: 991.98px) {
        .luxury-showcase-pane {
            display: none;
        }
        .luxury-form-pane {
            padding: 2.5rem 1.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="luxury-auth-wrapper">
    <div class="container luxury-auth-container">
        <div class="luxury-auth-card">
            <div class="row g-0">
                
                <!-- Left Visual Showcase Column (Opulent Amethyst & Gold) -->
                <div class="col-lg-5 luxury-showcase-pane d-none d-lg-flex flex-column justify-content-between">
                    <div>
                        <div class="showcase-pill">
                            <i class="fa-solid fa-crown text-warning"></i> Elite Marketplace
                        </div>
                        <h2 class="showcase-heading">
                            Elevate Your <span>Knowledge</span> & Career.
                        </h2>
                        <p class="showcase-desc">
                            Access India's largest curated network of 11,000+ verified coaching institutes, interactive courses, and verified freelance services.
                        </p>

                        <div class="showcase-feature-glass">
                            <div class="feature-glass-icon">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white small">Verified Certificates</div>
                                <div class="text-white-50" style="font-size: 0.775rem;">Official credentials recognized by employers nationwide.</div>
                            </div>
                        </div>

                        <div class="showcase-feature-glass">
                            <div class="feature-glass-icon">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white small">Instant Access & Zero Waiting</div>
                                <div class="text-white-50" style="font-size: 0.775rem;">Immediate enrollment and lifetime cloud resources.</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top border-white border-opacity-10 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1.5 text-warning small">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span class="text-white fw-bold ms-1" style="font-size: 0.8rem;">4.9/5 Rating</span>
                        </div>
                        <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 px-2.5 py-1" style="font-size: 0.725rem;">
                            50,000+ Students
                        </span>
                    </div>
                </div>

                <!-- Right Form Pane -->
                <div class="col-lg-7 luxury-form-pane">
                    
                    <!-- Portal Switcher Bar -->
                    <div class="portal-switcher-tabs">
                        <a href="{{ route('customer.login') }}" class="portal-tab-btn active">
                            <i class="fa-solid fa-user"></i> Customer Login
                        </a>
                        <a href="{{ route('seller.login') }}" class="portal-tab-btn">
                            <i class="fa-solid fa-store"></i> Seller Portal
                        </a>
                    </div>

                    <div>
                        <h1 class="form-hero-title">Customer Login</h1>
                        <p class="form-hero-sub">Sign in to access your purchased courses, projects, and personal library.</p>
                    </div>

                    <!-- Alerts -->
                    @if(Auth::check() && Auth::user()->isSeller())
                        <div class="alert alert-warning border-0 small rounded-3 mb-4 d-flex align-items-start gap-2" style="background-color: #fffbeb; border: 1px solid #fde68a !important;">
                            <i class="fa-solid fa-triangle-exclamation text-warning fs-5 flex-shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="d-block text-dark">Signed in as Seller</strong>
                                You are currently active as <strong>{{ Auth::user()->name }}</strong> (Seller Account).
                                To manage personal purchases or learn as a student, please log in with your customer profile.
                                <div class="mt-2">
                                    <a href="{{ route('seller.dashboard') }}" class="btn btn-sm btn-dark py-1 px-2 fw-semibold" style="font-size: 0.72rem;">Go to Seller Dashboard</a>
                                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger py-1 px-2 fw-semibold ms-1" style="font-size: 0.72rem;">Logout First</a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger border-0 small rounded-3 mb-4 p-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                            <span class="text-danger fw-semibold">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success border-0 small rounded-3 mb-4 p-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success fs-5"></i>
                            <span class="text-success fw-semibold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 small rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.login.submit') }}">
                        @csrf

                        <!-- Email / Phone Input -->
                        <div class="luxury-input-box">
                            <label for="customerLoginEmail">Email Address or Phone Number</label>
                            <div class="luxury-input-wrapper">
                                <div class="luxury-input-icon">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <input type="text"
                                       name="email"
                                       id="customerLoginEmail"
                                       class="luxury-input-field"
                                       placeholder="name@example.com or 9876543210"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="luxury-input-box">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="customerLoginPass" class="mb-0">Password</label>
                                <a href="#" class="brand-accent-link" style="font-size: 0.75rem;">Forgot Password?</a>
                            </div>
                            <div class="luxury-input-wrapper">
                                <div class="luxury-input-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <input type="password"
                                       name="password"
                                       id="customerLoginPass"
                                       class="luxury-input-field"
                                       placeholder="Enter your account password"
                                       required>
                                <button type="button" class="luxury-input-toggle" onclick="togglePass('customerLoginPass', this)" title="Toggle visibility">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberCustomer" checked style="accent-color: #7c3aed;">
                                <label class="form-check-label small text-muted" for="rememberCustomer">
                                    Keep me logged in
                                </label>
                            </div>
                        </div>

                        <!-- Submit CTA Button -->
                        <button type="submit" class="btn-luxury-submit mb-3">
                            <span>Sign In to Account</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <!-- Switch to Register -->
                        <div class="text-center small text-muted mt-2">
                            New to Digital Class? 
                            <a href="{{ route('customer.register') }}" class="brand-accent-link">Create Free Account</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-light small text-decoration-none opacity-75">
                &larr; Back to Digital Class Home
            </a>
        </div>
    </div>
</div>

<script>
function togglePass(id, btn) {
    const el = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (el.type === 'password') {
        el.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        el.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
