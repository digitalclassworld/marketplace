@extends('layouts.app')

@section('title', 'Customer Login - Digital Class World')

@section('styles')
<style>
    .customer-login-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        background: linear-gradient(180deg, #f0fdf4 0%, #f8fafc 60%, #f1f5f9 100%);
        padding: 3.5rem 1rem;
        position: relative;
    }

    .customer-login-card {
        background: #ffffff;
        border-radius: 22px;
        box-shadow: 0 15px 45px -10px rgba(6, 78, 59, 0.12), 0 0 0 1px rgba(5, 150, 105, 0.08);
        overflow: hidden;
        border: none;
    }

    .customer-login-header {
        background: linear-gradient(135deg, #064e3b 0%, #047857 55%, #059669 100%);
        color: #ffffff;
        padding: 2.5rem 2rem 2.25rem;
        text-align: center;
        position: relative;
    }

    .customer-avatar-badge {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: #ffffff;
        color: #047857;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        box-shadow: 0 8px 20px -3px rgba(0, 0, 0, 0.2);
        margin-bottom: 0.85rem;
    }

    .customer-form-body {
        padding: 2.25rem 2.25rem 2.5rem;
    }

    .customer-input-group label {
        font-size: 0.825rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.35rem;
    }

    .customer-input-group .form-control {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        font-size: 0.925rem;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .customer-input-group .input-group-text {
        border-radius: 12px 0 0 12px;
        border: 1.5px solid #e2e8f0;
        border-right: none;
        background-color: #f8fafc;
        color: #64748b;
    }

    .customer-input-group .form-control:focus {
        border-color: #059669;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
    }

    .customer-input-group .input-group:focus-within .input-group-text {
        border-color: #059669;
        background-color: #ffffff;
        color: #059669;
    }

    .btn-customer-submit {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: #ffffff;
        border: none;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.85rem 1.5rem;
        border-radius: 12px;
        transition: all 0.25s ease;
        box-shadow: 0 8px 20px -4px rgba(5, 150, 105, 0.35);
    }
    .btn-customer-submit:hover {
        background: linear-gradient(135deg, #047857 0%, #064e3b 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px -4px rgba(5, 150, 105, 0.45);
    }
    .btn-customer-submit:active {
        transform: translateY(0);
    }

    .customer-link {
        color: #059669;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .customer-link:hover {
        color: #047857;
        text-decoration: underline;
    }

    .seller-switch-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
        padding: 1rem;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="customer-login-wrapper">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                
                <!-- Card Container -->
                <div class="customer-login-card">
                    
                    <!-- Header -->
                    <div class="customer-login-header">
                        <div class="customer-avatar-badge">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Customer Login</h4>
                        <p class="mb-0 text-white-50 small">Access your enrolled courses, hired services, and orders</p>
                    </div>

                    <div class="customer-form-body bg-white">
                        
                        <!-- Seller Switch Notice -->
                        @if(Auth::check() && Auth::user()->isSeller())
                            <div class="alert alert-warning border-0 small rounded-3 mb-4 d-flex align-items-start gap-2" style="background-color: #fffbeb; border: 1px solid #fde68a !important;">
                                <i class="fa-solid fa-triangle-exclamation text-warning fs-5 flex-shrink-0 mt-0.5"></i>
                                <div>
                                    <strong class="d-block text-dark">Logged in as Seller</strong>
                                    You are currently signed in as <strong>{{ Auth::user()->name }}</strong> (Seller).
                                    To purchase items or manage personal orders, please log in with your <strong>Customer account</strong>.
                                    <div class="mt-2">
                                        <a href="{{ route('seller.dashboard') }}" class="btn btn-sm btn-dark py-1 px-2 fw-semibold" style="font-size: 0.72rem;">Go to Seller Dashboard</a>
                                        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger py-1 px-2 fw-semibold ms-1" style="font-size: 0.72rem;">Logout First</a>
                                    </div>
                                </div>
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

                            <!-- Email / Phone Field -->
                            <div class="mb-3 customer-input-group">
                                <label class="form-label">Email Address or Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="text" name="email" class="form-control" placeholder="name@example.com or 9876543210" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3 customer-input-group">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0">Password</label>
                                    <a href="#" class="customer-link small" style="font-size: 0.75rem;">Forgot Password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="customerPasswordInput" class="form-control border-end-0" placeholder="Enter your password" required>
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePass('customerPasswordInput', this)" style="border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: none; background: #f8fafc;" title="Toggle Password">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberCustomer" checked>
                                <label class="form-check-label small text-muted" for="rememberCustomer">
                                    Keep me logged in
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-customer-submit w-100 mb-3">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1.5"></i> Login to My Account
                            </button>

                            <!-- Sign Up Link -->
                            <div class="text-center small text-muted mb-3">
                                Don't have a customer account? 
                                <a href="{{ route('customer.register') }}" class="customer-link fw-bold">Create Account</a>
                            </div>

                            <hr class="my-3 opacity-25">

                            <!-- Seller Portal Switch -->
                            <div class="seller-switch-box">
                                <span class="small text-muted d-block mb-1">Are you an Instructor, Institute, or Business Seller?</span>
                                <a href="{{ route('seller.login') }}" class="btn btn-outline-dark btn-sm fw-semibold rounded-pill px-3" style="font-size: 0.775rem;">
                                    <i class="fa-solid fa-store me-1 text-success"></i> Switch to Seller Login
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
