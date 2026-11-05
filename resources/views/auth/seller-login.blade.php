@extends('layouts.app')

@section('title', 'Seller Portal Login - Digital Class Marketplace')

@section('styles')
<style>
    .dc-auth-wrapper {
        padding: 3.5rem 0 5rem;
        background-color: #f8fafc;
        min-height: 85vh;
        display: flex;
        align-items: center;
    }

    .dc-auth-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        padding: 2.5rem 2rem;
    }

    .dc-auth-title {
        font-weight: 700;
        color: #0e1726;
        font-size: 1.5rem;
        margin-bottom: 0.35rem;
    }

    .dc-input-icon {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #64748b;
    }

    .dc-form-input {
        border-color: #cbd5e1;
        padding: 0.7rem 0.95rem;
        font-size: 0.9375rem;
    }

    .dc-form-input:focus {
        border-color: #0066ff;
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
    }

    .dc-demo-box {
        background: #f1f5f9;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        font-size: 0.8125rem;
    }
</style>
@endsection

@section('content')
<div class="dc-auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="dc-auth-card">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="d-inline-block mb-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Digital Class Educational World" style="height: 46px; width: auto; object-fit: contain;">
                        </a>
                        <h1 class="dc-auth-title">Seller Portal Login</h1>
                        <p class="text-muted small mb-0">
                            Sign in using your registered <strong>Email Address</strong> or <strong>Seller ID</strong>.
                        </p>
                    </div>

                    <!-- Flash Notifications -->
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center py-2 px-3 small rounded-3 mb-3" role="alert">
                            <i class="fa-solid fa-circle-check me-2 flex-shrink-0"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                        <div class="alert alert-dark d-flex align-items-center justify-content-between py-2 px-3 small rounded-3 mb-3" role="alert">
                            <div>
                                <i class="fa-solid fa-shield-halved text-warning me-2"></i>
                                Currently signed in as: <strong>Super Admin</strong>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm py-0 px-2 fw-semibold" style="font-size: 0.75rem;">
                                    Admin Dashboard &rarr;
                                </a>
                                <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm py-0 px-2" style="font-size: 0.75rem;">
                                    Logout
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center py-2 px-3 small rounded-3 mb-3" role="alert">
                            <i class="fa-solid fa-triangle-exclamation me-2 flex-shrink-0"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info d-flex align-items-center py-2 px-3 small rounded-3 mb-3" role="alert">
                            <i class="fa-solid fa-circle-info me-2 flex-shrink-0"></i>
                            <div>{{ session('info') }}</div>
                        </div>
                    @endif

                    @if($errors->has('login') || $errors->has('email'))
                        <div class="alert alert-danger d-flex align-items-center py-2 px-3 small rounded-3 mb-3" role="alert">
                            <i class="fa-solid fa-circle-xmark me-2 flex-shrink-0"></i>
                            <div>{{ $errors->first('login') ?: $errors->first('email') }}</div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('seller.login.submit') }}" method="POST" id="sellerLoginForm">
                        @csrf

                        <!-- Login Field (Email or Seller ID) -->
                        <div class="mb-3">
                            <label for="loginInput" class="form-label small fw-semibold text-dark">Email Address or Seller ID</label>
                            <div class="input-group">
                                <span class="input-group-text dc-input-icon"><i class="fa-regular fa-user"></i></span>
                                <input type="text"
                                       name="login"
                                       id="loginInput"
                                       class="form-control dc-form-input @if($errors->has('login') || $errors->has('email')) is-invalid @enderror"
                                       placeholder="e.g. newsell@gmail.com or DC-SELL-000004"
                                       value="{{ old('login', old('email')) }}"
                                       required
                                       autofocus>
                            </div>
                            <div class="form-text text-muted" style="font-size: 0.775rem;">
                                You can enter either your registered email or your unique Seller ID.
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="passwordInput" class="form-label small fw-semibold text-dark mb-0">Password</label>
                                <span class="text-muted small">Default: <code class="text-primary">password</code></span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text dc-input-icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password"
                                       name="password"
                                       id="passwordInput"
                                       class="form-control dc-form-input @error('password') is-invalid @enderror"
                                       placeholder="••••••••"
                                       required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePasswordVisibility('passwordInput', this)" title="Show/Hide Password">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" {{ old('remember', '1') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Keep me logged in (Persistent Session)
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary py-2 fw-semibold" style="background-color: #0066ff; border-color: #0066ff;">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Sign In to Seller Dashboard
                            </button>
                        </div>
                    </form>

                    <!-- Fresh Start Notice -->
                    <div class="dc-demo-box mt-3 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-sparkles text-primary"></i>
                            <strong class="text-dark">Clean Fresh State:</strong>
                        </div>
                        <div class="text-muted" style="font-size: 0.8rem;">
                            All previous test seller records were removed. Click below to register your fresh seller account with auto-generated <strong>Seller ID (DC-SELL-000001)</strong>.
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('seller.register') }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                <i class="fa-solid fa-store me-1"></i> Start New Seller Registration &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Footer: Register Switch -->
                    <div class="text-center pt-3 border-top">
                        <span class="small text-muted">New seller on Digital Class?</span>
                        <div class="mt-2">
                            <a href="{{ route('seller.register') }}" class="btn btn-outline-primary btn-sm px-3 fw-semibold">
                                <i class="fa-solid fa-user-plus me-1"></i> Register New Seller Account
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                        &larr; Return to Marketplace Homepage
                    </a>
                </div>
            </div>
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

    function fillDemo(login, pwd) {
        document.getElementById('loginInput').value = login;
        document.getElementById('passwordInput').value = pwd;
        document.getElementById('passwordInput').focus();
    }
</script>
@endsection
