@extends('seller.layouts.seller')

@section('title', 'Seller Profile & Settings - Digital Class Marketplace')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Seller Profile & Settings</h3>
            <p class="text-muted small mb-0">Manage your verified seller identity, personal details, and store profile.</p>
        </div>
        <div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 font-monospace fs-6">
                Seller ID: {{ $seller->seller_code }}
            </span>
        </div>
    </div>

    <!-- Security & Restrictions Notice Alert -->
    <div class="alert alert-light border rounded-3 p-3 mb-4 small">
        <div class="d-flex align-items-center gap-2 mb-1">
            <i class="fa-solid fa-shield-halved text-primary"></i>
            <strong class="text-dark">Identity & Verification Security Notice</strong>
        </div>
        <p class="text-muted mb-0">
            For security, compliance, and marketplace integrity, your <strong>Seller ID</strong>, <strong>User ID</strong>, <strong>Account Type</strong>, <strong>Seller Status</strong>, and <strong>Verification Status</strong> are permanently bound to your account and cannot be modified by sellers. Permitted contact details and store presentation info can be updated below.
        </p>
    </div>

    <div class="row g-4">
        <!-- Left Column: Read-Only System Identity Cards -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="text-center pb-3 border-bottom mb-3">
                    <div class="dc-user-avatar mx-auto mb-2" style="width: 72px; height: 72px; font-size: 1.85rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-0">{{ $user->name }}</h5>
                    <div class="text-primary fw-bold font-monospace small mb-2">{{ $seller->seller_code }}</div>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                        {{ $seller->seller_status }}
                    </span>
                </div>

                <div class="small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Database ID:</span>
                        <strong class="text-dark">#{{ $seller->id }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">User Account ID:</span>
                        <strong class="text-dark">#{{ $user->id }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Account Type:</span>
                        <span class="fw-semibold text-dark">{{ $seller->account_type }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Verification Status:</span>
                        <span class="badge bg-secondary-subtle text-secondary border">
                            {{ $seller->verification_status }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Registration Date:</span>
                        <span class="text-dark">{{ $seller->registration_date ? $seller->registration_date->format('d M, Y') : 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Approved At:</span>
                        <span class="text-muted">{{ $seller->approved_at ? $seller->approved_at->format('d M, Y') : 'Pending Approval' }}</span>
                    </div>
                </div>
            </div>

            <!-- Verification Progress Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold text-dark mb-3">Account Verification Checklist</h6>
                <div class="d-flex flex-column gap-3 small">
                    <div class="d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-circle-check text-success me-2"></i> Account Registration</span>
                        <span class="badge bg-success-subtle text-success">Completed</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-circle-check text-success me-2"></i> Seller ID Generated</span>
                        <span class="badge bg-success-subtle text-success">Completed</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-clock-rotate-left text-warning me-2"></i> Admin Approval</span>
                        <span class="badge bg-warning-subtle text-warning">In Review</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-circle-xmark text-secondary me-2"></i> Business KYC</span>
                        <span class="badge bg-light text-muted">Pending</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Editable Profile Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                    <i class="fa-regular fa-pen-to-square text-primary me-2"></i>Edit Permitted Information
                </h5>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3 py-2 px-3 small mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seller.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Read-Only Locked Fields Banner -->
                    <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1">
                                <i class="fa-solid fa-lock me-1"></i> Permanent Seller ID
                            </label>
                            <input type="text" class="form-control form-control-sm bg-white font-monospace fw-bold" value="{{ $seller->seller_code }}" disabled readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1">
                                <i class="fa-solid fa-lock me-1"></i> Seller Account Type
                            </label>
                            <input type="text" class="form-control form-control-sm bg-white" value="{{ $seller->account_type }}" disabled readonly>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3">1. Personal & Contact Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-bold">Login Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label small fw-bold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3">2. Business & Store Information</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="business_name" class="form-label small fw-bold">Store / Business Name</label>
                            <input type="text" name="business_name" id="business_name" class="form-control" value="{{ old('business_name', $seller->businessDetail?->business_name) }}" placeholder="e.g. My Training Academy">
                        </div>

                        <div class="col-md-6">
                            <label for="website" class="form-label small fw-bold">Website / Social URL</label>
                            <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $seller->businessDetail?->website) }}" placeholder="https://example.com">
                        </div>

                        <div class="col-md-6">
                            <label for="business_email" class="form-label small fw-bold">Public Business Email</label>
                            <input type="email" name="business_email" id="business_email" class="form-control" value="{{ old('business_email', $seller->businessDetail?->business_email) }}" placeholder="contact@example.com">
                        </div>

                        <div class="col-md-6">
                            <label for="business_phone" class="form-label small fw-bold">Public Business Phone</label>
                            <input type="tel" name="business_phone" id="business_phone" class="form-control" value="{{ old('business_phone', $seller->businessDetail?->business_phone) }}" placeholder="+91 98765 43210">
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label small fw-bold">Address / Street</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $seller->businessDetail?->address) }}" placeholder="Office / Shop Address">
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="form-label small fw-bold">City</label>
                            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $seller->businessDetail?->city) }}">
                        </div>

                        <div class="col-md-4">
                            <label for="state" class="form-label small fw-bold">State</label>
                            <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $seller->businessDetail?->state) }}">
                        </div>

                        <div class="col-md-4">
                            <label for="pincode" class="form-label small fw-bold">Pincode</label>
                            <input type="text" name="pincode" id="pincode" class="form-control" value="{{ old('pincode', $seller->businessDetail?->pincode) }}">
                        </div>

                        <div class="col-12">
                            <label for="business_description" class="form-label small fw-bold">Business Description / Bio</label>
                            <textarea name="business_description" id="business_description" rows="3" class="form-control" placeholder="Describe your courses, products or services...">{{ old('business_description', $seller->businessDetail?->business_description) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-dc-primary px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

