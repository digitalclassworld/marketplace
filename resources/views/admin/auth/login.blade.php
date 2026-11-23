@extends('layouts.app')

@section('title', 'Super Admin Login - Digital Class Marketplace')

@section('styles')
<style>
    .admin-login-wrapper {
        min-height: 88vh;
        display: flex;
        align-items: center;
        background: radial-gradient(circle at 50% 10%, #1e293b 0%, #0b1120 60%, #050811 100%);
        padding: 4rem 1rem;
        position: relative;
        overflow: hidden;
    }

    .admin-login-wrapper::before {
        content: '';
        position: absolute;
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 350px;
        background: radial-gradient(circle, rgba(217, 119, 6, 0.12) 0%, rgba(217, 119, 6, 0) 70%);
        pointer-events: none;
    }

    .admin-login-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.1);
        padding: 3rem 2.75rem;
        position: relative;
        z-index: 1;
    }

    .admin-crest {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #f59e0b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25), inset 0 0 0 1px rgba(245, 158, 11, 0.25);
        margin-bottom: 1.25rem;
    }

    .admin-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .admin-input-group label {
        font-size: 0.825rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.01em;
        margin-bottom: 0.35rem;
    }

    .admin-input-group .form-control {
        border-radius: 12px;
        padding: 0.8rem 1rem;
        border: 1.5px solid #e2e8f0;
        font-size: 0.925rem;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .admin-input-group .input-group-text {
        border-radius: 12px 0 0 12px;
        border: 1.5px solid #e2e8f0;
        border-right: none;
        background-color: #f8fafc;
        color: #64748b;
    }

    .admin-input-group .form-control:focus {
        border-color: #0f172a;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.12);
    }

    .admin-input-group .input-group:focus-within .input-group-text {
        border-color: #0f172a;
        background-color: #ffffff;
        color: #0f172a;
    }

    .btn-admin-submit {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border: none;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.9rem 1.75rem;
        border-radius: 12px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.4);
    }
    .btn-admin-submit:hover {
        background: linear-gradient(135deg, #020617 0%, #0f172a 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px -4px rgba(15, 23, 42, 0.55);
    }
    .btn-admin-submit:active {
        transform: translateY(0);
    }

    .security-notice {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.775rem;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
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
                        <div class="admin-crest">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="mb-2">
                            <span class="admin-badge">
                                <i class="fa-solid fa-lock"></i> Super Admin Portal
                            </span>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">Administrative Login</h3>
                        <p class="text-muted small mb-0">
                            Secure gateway for marketplace administration and system configuration.
                        </p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning rounded-3 py-2 px-3 small mb-3 text-dark" style="background-color: #fef3c7; border-color: #fde68a;">
                            <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> {{ session('warning') }}
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
                            <label for="email" class="form-label">Admin Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="admin@digitalclassworld.com" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 admin-input-group">
                            <label for="password" class="form-label">Admin Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter administrative password" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePasswordVisibility('password', this)" style="border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: none; background: #f8fafc;" title="Toggle Password">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">
                                    Maintain administrative session
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-admin-submit">
                                <i class="fa-solid fa-shield-halved me-2 text-warning"></i> Access Super Admin Dashboard
                            </button>
                        </div>
                    </form>

                    <div class="security-notice mt-4">
                        <i class="fa-solid fa-shield-cat text-secondary"></i>
                        <span>End-to-end encrypted session with role authorization verification.</span>
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

    // Refresh page if restored from Back-Forward Cache (bfcache) so CSRF token is fresh
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    // Auto-refresh CSRF token when window gets focus or after idle period
    let lastActiveAdmin = Date.now();
    function refreshAdminCsrfToken() {
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
        if (Date.now() - lastActiveAdmin > 300000) {
            refreshAdminCsrfToken();
        }
        lastActiveAdmin = Date.now();
    });

    setInterval(refreshAdminCsrfToken, 600000);
</script>
@endsection
