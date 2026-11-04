@extends('layouts.app')

@section('title', 'Registration Successful - Go Live | Digital Class Marketplace')

@section('content')
<div class="py-5 bg-light min-vh-75 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center">
                    
                    <!-- Success Animated / Glowing Icon -->
                    <div class="mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background-color: #ecfdf5; color: #10b981; border: 4px solid #d1fae5;">
                        <i class="fa-solid fa-check fs-1"></i>
                    </div>

                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill mb-2">Step 4: Go Live Complete</span>
                    <h2 class="fw-bold text-dark mb-2">Registration Successful!</h2>
                    <p class="text-muted mb-4 lead" style="font-size: 1.05rem;">
                        Your seller account has been successfully registered. Your unique Seller ID has been generated. Your account is awaiting approval.
                    </p>

                    <!-- Generated Seller ID Highlight Box -->
                    <div class="p-3 mb-4 rounded-3 border bg-light text-start">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <span class="text-muted small fw-semibold text-uppercase">Permanent Seller Credentials</span>
                            <span class="badge bg-primary">Active Session</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Generated Seller ID</small>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fs-4 fw-bold text-primary font-monospace" id="sellerIdVal">{{ $seller['seller_id'] }}</span>
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="navigator.clipboard.writeText('{{ $seller['seller_id'] }}'); alert('Seller ID copied!');" title="Copy Seller ID">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <small class="text-muted d-block">Seller / Business Name</small>
                                <span class="fw-bold text-dark">{{ $seller['business_name'] ?? $seller['name'] }}</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Owner: {{ $seller['name'] }}</small>
                            </div>

                            <div class="col-sm-6">
                                <small class="text-muted d-block">Account Type</small>
                                <span class="fw-semibold text-dark">{{ $seller['account_type'] }}</span>
                            </div>

                            <div class="col-sm-6">
                                <small class="text-muted d-block">Registration Date</small>
                                <span class="fw-semibold text-dark">{{ $seller['registration_date'] }}</span>
                            </div>

                            <div class="col-sm-6">
                                <small class="text-muted d-block">Seller Account Status</small>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                    <i class="fa-solid fa-clock-rotate-left me-1"></i> {{ $seller['seller_status'] }}
                                </span>
                            </div>

                            <div class="col-sm-6">
                                <small class="text-muted d-block">Verification Status</small>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                    <i class="fa-solid fa-circle-question me-1"></i> {{ $seller['verification_status'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Next steps alert -->
                    <div class="alert alert-info border-0 rounded-3 text-start small mb-4 d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-info fs-5 mt-1 text-primary"></i>
                        <div>
                            <strong>What you can do now:</strong>
                            <p class="mb-0 mt-1">
                                You have full access to your <strong>Seller Dashboard</strong>. You can review your profile, customize business details, and prepare your listings while platform administrators review your store application.
                            </p>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ route('seller.dashboard') }}" class="btn btn-dc-primary btn-lg px-4">
                            <i class="fa-solid fa-gauge-high me-1"></i> Proceed to Seller Dashboard
                        </a>
                        <a href="{{ route('seller.profile') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fa-solid fa-id-card me-1"></i> View Seller Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

