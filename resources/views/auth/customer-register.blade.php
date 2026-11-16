@extends('layouts.app')

@section('title', 'Create Customer Account - Digital Class World')

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
                            <i class="fa-solid fa-user-plus fs-5"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Create Customer Account</h4>
                        <p class="mb-0 text-white-50 small">Join thousands of students and clients learning & shopping</p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">

                        @if($errors->any())
                            <div class="alert alert-danger border-0 small rounded-3 mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.register.submit') }}">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-regular fa-user"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control bg-light border-start-0" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="name@example.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small">Mobile Number (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        +91
                                    </span>
                                    <input type="tel" name="phone" class="form-control bg-light border-start-0" placeholder="9876543210" value="{{ old('phone') }}">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="regPass" class="form-control bg-light border-start-0 border-end-0" placeholder="Min. 6 characters" required>
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePass('regPass', this)">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark small">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="regPassConf" class="form-control bg-light border-start-0 border-end-0" placeholder="Repeat your password" required>
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" onclick="togglePass('regPassConf', this)">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow-sm rounded-3 mb-3" style="background-color: #0066ff;">
                                <i class="fa-solid fa-user-check me-1.5"></i> Register as Customer
                            </button>

                            <!-- Login Link -->
                            <div class="text-center small text-muted mb-3">
                                Already have an account? 
                                <a href="{{ route('customer.login') }}" class="text-primary fw-bold text-decoration-none">Login</a>
                            </div>

                            <hr class="my-3 opacity-25">

                            <!-- Seller Portal Switch -->
                            <div class="text-center p-2 rounded-3 bg-light border">
                                <span class="small text-muted d-block mb-1">Want to teach courses or sell services?</span>
                                <a href="{{ route('seller.register') }}" class="btn btn-outline-success btn-sm fw-semibold rounded-pill px-3" style="font-size: 0.775rem;">
                                    <i class="fa-solid fa-graduation-cap me-1"></i> Register as a Seller / Instructor
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

