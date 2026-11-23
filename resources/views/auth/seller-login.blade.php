@extends('layouts.app')

@section('title', 'Seller Portal Login - Digital Class Marketplace')

@section('styles')
<style>
    .seller-auth-wrapper {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0b1120 50%, #030712 100%);
        padding: 4rem 1rem;
        position: relative;
        overflow: hidden;
    }

    .seller-auth-wrapper::before {
        content: '';
        position: absolute;
        top: -150px;
        left: 20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(217, 119, 6, 0.18) 0%, transparent 70%);
        pointer-events: none;
        filter: blur(50px);
    }

    .seller-auth-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1020px;
        margin: 0 auto;
    }

    .seller-auth-card {
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 0 35px 80px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.1);
        overflow: hidden;
        border: none;
    }

    /* Left Showcase Pane */
    .seller-showcase-pane {
        background: linear-gradient(145deg, #090d16 0%, #0f172a 50%, #1e293b 100%);
        color: #ffffff;
        padding: 3.5rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }

    .seller-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(245, 158, 11, 0.12);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.25);
        font-size: 0.775rem;
        font-weight: 700;
        padding: 0.4rem 1rem;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
    }

    .seller-showcase-heading {
        font-family: var(--dc-font-heading);
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
        color: #ffffff;
        letter-spacing: -0.02em;
        margin-bottom: 1rem;
    }
    .seller-showcase-heading span {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .seller-showcase-glass {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.25s ease;
    }
    .seller-showcase-glass:hover {
        transform: translateX(4px);
        background: rgba(255, 255, 255, 0.09);
    }
    .seller-glass-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.25) 0%, rgba(15, 23, 42, 0.4) 100%);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #fbbf24;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Right Form Pane */
    .seller-form-pane {
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
        background: #0f172a;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }
    .portal-tab-btn:hover:not(.active) {
        color: #0f172a;
    }

    .seller-input-box {
        margin-bottom: 1.25rem;
    }
    .seller-input-box label {
        display: block;
        font-size: 0.825rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.45rem;
    }
    .seller-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.2s ease;
        overflow: hidden;
    }
    .seller-input-wrapper:focus-within {
        border-color: #0f172a;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.12);
    }
    .seller-input-icon {
        padding: 0 1rem;
        color: #94a3b8;
        font-size: 1rem;
        display: flex;
        align-items: center;
    }
    .seller-input-wrapper:focus-within .seller-input-icon {
        color: #0f172a;
    }
    .seller-input-field {
        width: 100%;
        border: none;
        background: transparent;
        padding: 0.85rem 1rem 0.85rem 0;
        font-size: 0.925rem;
        color: #0f172a;
        font-family: inherit;
        outline: none;
    }
    .seller-input-toggle {
        padding: 0 1rem;
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
    }
    .seller-input-toggle:hover {
        color: #475569;
    }

    .btn-seller-submit {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-weight: 700;
        font-size: 0.975rem;
        padding: 0.95rem 1.75rem;
        border-radius: 14px;
        width: 100%;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 25px -4px rgba(15, 23, 42, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }
    .btn-seller-submit:hover {
        background: linear-gradient(135deg, #020617 0%, #0f172a 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 16px 30px -4px rgba(15, 23, 42, 0.55);
    }
    .btn-seller-submit:active {
        transform: translateY(0);
    }

    @media (max-width: 991.98px) {
        .seller-showcase-pane {
            display: none;
        }
        .seller-form-pane {
            padding: 2.5rem 1.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="seller-auth-wrapper">
    <div class="container seller-auth-container">
        <div class="seller-auth-card">
            <div class="row g-0">
                
                <!-- Left Showcase Pane (Dark Obsidian & Warm Amber) -->
                <div class="col-lg-5 seller-showcase-pane d-none d-lg-flex">
                    <div>
                        <div class="seller-pill">
                            <i class="fa-solid fa-briefcase text-warning"></i> Creator & Business Portal
                        </div>
                        <h2 class="seller-showcase-heading">
                            Sell Courses, Services & <span>Grow Revenue</span>.
                        </h2>
                        <p class="text-white-50 small mb-4" style="line-height: 1.6;">
                            Reach 50,000+ motivated learners and direct buyers across India with zero upfront barrier.
                        </p>

                        <div class="seller-showcase-glass">
                            <div class="seller-glass-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white small">Unified Catalog Engine</div>
                                <div class="text-white-50" style="font-size: 0.775rem;">List video courses, physical/digital products, and services in 1 dashboard.</div>
                            </div>
                        </div>

                        <div class="seller-showcase-glass">
                            <div class="seller-glass-icon">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white small">Direct Payouts & Invoicing</div>
                                <div class="text-white-50" style="font-size: 0.775rem;">Automated GST invoicing and transparent payouts to your bank account.</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top border-white border-opacity-10 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-warning"></i>
                            <span class="text-white small fw-bold">Verified Merchant Ecosystem</span>
                        </div>
                        <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 px-2.5 py-1" style="font-size: 0.725rem;">
                            11,000+ Institutes
                        </span>
                    </div>
                </div>

                <!-- Right Form Pane -->
                <div class="col-lg-7 seller-form-pane">
                    
                    <!-- Portal Switcher Bar -->
                    <div class="portal-switcher-tabs">
                        <a href="{{ route('customer.login') }}" class="portal-tab-btn">
                            <i class="fa-solid fa-user"></i> Customer Login
                        </a>
                        <a href="{{ route('seller.login') }}" class="portal-tab-btn active">
                            <i class="fa-solid fa-store"></i> Seller Portal
                        </a>
                    </div>

                    <div class="mb-3">
                        <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Seller Portal Login</h1>
                        <p class="text-muted small mb-0">
                            Sign in using your registered <strong>Email Address</strong> or <strong>Seller ID</strong>.
                        </p>
                    </div>

                    <!-- Flash Notifications -->
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center py-2 px-3 small rounded-3 mb-3">
                            <i class="fa-solid fa-circle-check me-2 flex-shrink-0"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center py-2 px-3 small rounded-3 mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-2 flex-shrink-0"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning d-flex align-items-center py-2 px-3 small rounded-3 mb-3 text-dark" style="background-color: #fef3c7; border-color: #fde68a;">
                            <i class="fa-solid fa-triangle-exclamation me-2 text-warning flex-shrink-0"></i>
                            <div>{{ session('warning') }}</div>
                        </div>
                    @endif

                    @if($errors->has('login') || $errors->has('email'))
                        <div class="alert alert-danger d-flex align-items-center py-2 px-3 small rounded-3 mb-3">
                            <i class="fa-solid fa-circle-xmark me-2 flex-shrink-0"></i>
                            <div>{{ $errors->first('login') ?: $errors->first('email') }}</div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('seller.login.submit') }}" method="POST" id="sellerLoginForm">
                        @csrf

                        <!-- Login Field (Email or Seller ID) -->
                        <div class="seller-input-box">
                            <label for="loginInput">Email Address or Seller ID</label>
                            <div class="seller-input-wrapper">
                                <div class="seller-input-icon">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <input type="text"
                                       name="login"
                                       id="loginInput"
                                       class="seller-input-field"
                                       placeholder="e.g. yourname@gmail.com or DC-SELL-000004"
                                       value="{{ old('login', old('email')) }}"
                                       required
                                       autofocus>
                            </div>
                            <div class="form-text text-muted mt-1" style="font-size: 0.75rem;">
                                Enter either your registered email address or unique Seller ID.
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="seller-input-box">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="passwordInput" class="mb-0">Password</label>
                            </div>
                            <div class="seller-input-wrapper">
                                <div class="seller-input-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <input type="password"
                                       name="password"
                                       id="passwordInput"
                                       class="seller-input-field"
                                       placeholder="••••••••"
                                       required>
                                <button type="button" class="seller-input-toggle" onclick="togglePasswordVisibility('passwordInput', this)" title="Toggle Password">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" {{ old('remember', '1') ? 'checked' : '' }} style="accent-color: #0f172a;">
                                <label class="form-check-label small text-muted" for="remember">
                                    Keep me logged in (Persistent Session)
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-seller-submit mb-3">
                            <i class="fa-solid fa-arrow-right-to-bracket me-1 text-warning"></i>
                            <span>Sign In to Seller Dashboard</span>
                        </button>

                        <!-- Footer: Register Switch -->
                        <div class="text-center pt-3 border-top mt-3">
                            <span class="small text-muted">New seller on Digital Class?</span>
                            <div class="mt-2">
                                <a href="{{ route('seller.register') }}" class="btn btn-outline-dark btn-sm px-3 fw-bold rounded-pill">
                                    <i class="fa-solid fa-store me-1"></i> Register New Seller Account
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-light small text-decoration-none opacity-75">
                &larr; Return to Marketplace Homepage
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
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

    // Refresh page if restored from Back-Forward Cache (bfcache) so CSRF token is fresh
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    // Auto-refresh CSRF token when window gets focus or after idle period
    let lastActive = Date.now();
    function refreshCsrfToken() {
        fetch('{{ route("refresh-csrf") }}', { credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                if (data && data.token) {
                    const tokenInputs = document.querySelectorAll('input[name="_token"]');
                    tokenInputs.forEach(input => input.value = data.token);
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if (meta) meta.setAttribute('content', data.token);
                }
            })
            .catch(() => {});
    }

    window.addEventListener('focus', function () {
        if (Date.now() - lastActive > 300000) {
            refreshCsrfToken();
        }
        lastActive = Date.now();
    });

    setInterval(refreshCsrfToken, 600000);

    // Prevent double form submission
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('sellerLoginForm');
        if (form) {
            form.addEventListener('submit', function () {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    setTimeout(() => {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Signing in...';
                    }, 50);
                }
            });
        }
    });
</script>
@endsection
