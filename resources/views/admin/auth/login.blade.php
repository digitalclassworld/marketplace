@extends('layouts.app')

@section('title', 'Super Admin Login - Digital Class Marketplace')

@section('styles')
<style>
    .admin-login-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        background: radial-gradient(circle at 50% 20%, #1e293b 0%, #0b1424 100%);
        padding: 4rem 1rem;
    }

    .admin-login-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        padding: 3rem 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 0.775rem;
        font-weight: 700;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .admin-input-group .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
    }
    .admin-input-group .form-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
    }

    .btn-admin-submit {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border: none;
        font-weight: 700;
        padding: 0.85rem 1.5rem;
        border-radius: 10px;
        transition: all 0.2s ease;
    }
    .btn-admin-submit:hover {
        background: #020617;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
    }
</style>
@endsection

@section('content')
<div class="admin-login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="admin-login-card">
                    <div class="text-center mb-4">
                        <div class="mb-2">
                            <span class="admin-badge">
                                <i class="fa-solid fa-shield-halved"></i> Super Admin Portal
                            </span>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">Administrative Login</h3>
                        <p class="text-muted small mb-0">
                            Authorized personnel access only. Please sign in with your Super Admin credentials.
                        </p>
                    </div>

                    @if(Auth::check() && Auth::user()->isSeller())
                        <div class="alert alert-warning py-2 px-3 small rounded-3 mb-3 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa-solid fa-user-tag me-1"></i>
                                Currently signed in as Seller: <strong>{{ Auth::user()->name }}</strong>
                            </div>
                            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-dark btn-sm py-0 px-2" style="font-size: 0.75rem;">
                                Seller Dashboard &rarr;
                            </a>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success rounded-3 py-2 px-3 small mb-3">
                            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3 admin-input-group">
                            <label for="email" class="form-label small fw-bold text-dark">Admin Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-user-shield"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="superadmin@gmail.com" value="{{ old('email', 'superadmin@gmail.com') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 admin-input-group">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label small fw-bold text-dark mb-0">Admin Password</label>
                                <span class="text-muted small">Default: <code>Admin@123</code></span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password', this)">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Maintain administrative session
                            </label>
                        </div>

                        <!-- Quick Demo Fill -->
                        <div class="mb-3 text-center">
                            <button type="button" class="btn btn-sm btn-light border w-100 font-monospace py-1" style="font-size: 0.8rem;" onclick="fillAdmin('superadmin@gmail.com', 'Admin@123')">
                                <i class="fa-solid fa-key text-warning me-1"></i> Fill Super Admin: superadmin@gmail.com
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-admin-submit">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Access Super Admin Dashboard
                            </button>
                        </div>
                    </form>

                    <div class="p-3 rounded-3 bg-light border text-center small text-muted mt-4">
                        <i class="fa-solid fa-lock text-secondary me-1"></i>
                        Session is monitored and protected by role authorization.
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('home') }}" class="text-light small text-decoration-none opacity-75">
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

    function fillAdmin(email, pwd) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pwd;
        document.getElementById('password').focus();
    }
</script>
@endsection

