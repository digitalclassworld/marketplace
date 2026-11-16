@extends('layouts.app')

@section('title', 'Customer Login - Digital Class World')

@section('content')
<div class="py-5 bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                
                <!-- Card Container -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    
                    <!-- Header -->
                    <div class="bg-primary text-white p-4 text-center" style="background: linear-gradient(135deg, #0066ff 0%, #004ecc 100%) !important;">
                        <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-user fs-5"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Customer Login</h4>
                        <p class="mb-0 text-white-50 small">Access your courses, services, and digital purchases</p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        
                        <!-- Seller Switch Notice -->
                        @if(Auth::check() && Auth::user()->isSeller())
                            <div class="alert alert-warning border-0 small rounded-3 mb-4 d-flex align-items-start gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-warning fs-5 flex-shrink-0 mt-0.5"></i>
                                <div>
                                    <strong class="d-block text-dark">Logged in as Seller</strong>
                                    You are currently logged in as <strong>{{ Auth::user()->name }}</strong> (Seller).
                                    To place orders and purchase items, please login or register with a <strong>Customer account</strong>.
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
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small">Email Address or Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="text" name="email" class="form-control bg-light border-start-0" placeholder="name@example.com or 9876543210" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fw-semibold text-dark small mb-0">Password</label>
                                    <a href="#" class="text-decoration-none small text-primary" style="font-size: 0.75rem;">Forgot Password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="customerPasswordInput" class="form-control bg-light border-start-0 border-end-0" placeholder="Enter your password" required>
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePass('customerPasswordInput', this)">
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
                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow-sm rounded-3 mb-3" style="background-color: #0066ff;">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1.5"></i> Login to My Account
                            </button>

                            <!-- Sign Up Link -->
                            <div class="text-center small text-muted mb-3">
                                Don't have a customer account? 
                                <a href="{{ route('customer.register') }}" class="text-primary fw-bold text-decoration-none">Create Account</a>
                            </div>

                            <hr class="my-3 opacity-25">

                            <!-- Seller Portal Switch -->
                            <div class="text-center p-2 rounded-3 bg-light border">
                                <span class="small text-muted d-block mb-1">Are you an Instructor, Institute, or Seller?</span>
                                <a href="{{ route('seller.login') }}" class="btn btn-outline-dark btn-sm fw-semibold rounded-pill px-3" style="font-size: 0.775rem;">
                                    <i class="fa-solid fa-store me-1"></i> Switch to Seller Login
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

