@extends('customer.layouts.customer')

@section('title', 'My Account & Profile - Digital Class World')

@section('styles')
<style>
    .dc-profile-wrapper {
        background: #f8fafc;
        min-height: calc(100vh - 180px);
        padding: 2.25rem 0 3.5rem;
    }

    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 16px -2px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .profile-section-title {
        font-family: var(--dc-font-heading);
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }

    .profile-input-group {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #f8fafc;
    }
    .profile-input-group:focus-within {
        border-color: #0066ff;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
    }
    .profile-input-group .input-group-text {
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 0.95rem;
        padding-left: 0.95rem;
    }
    .profile-input-group .form-control,
    .profile-input-group .form-select {
        border: none;
        background: transparent;
        font-size: 0.9rem;
        padding: 0.65rem 0.85rem;
        box-shadow: none;
    }
    .profile-input-group .form-control:focus,
    .profile-input-group .form-select:focus {
        background: transparent;
        box-shadow: none;
    }

    .interest-pill-label {
        border: 1.5px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.35rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        user-select: none;
    }
    .interest-pill-input:checked + .interest-pill-label {
        background-color: #eff6ff;
        border-color: #0066ff;
        color: #0066ff;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }
    .avatar-camera-btn {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #0066ff;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
    }
    .avatar-camera-btn:hover {
        background: #0052cc;
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="dc-profile-wrapper">
    <div class="container">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary-subtle text-primary fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-user-gear me-1"></i> Account Settings
                    </span>
                    <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-circle-check me-1"></i> Active Customer
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-0">My Account</h3>
                <p class="text-muted small mb-0">View and update your personal profile, profession, location, and account details</p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.my-courses') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold">
                    <i class="fa-solid fa-graduation-cap me-1.5"></i> My Learning Portal
                </a>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                    <i class="fa-solid fa-bag-shopping me-1.5"></i> My Orders ({{ $ordersCount }})
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm rounded-pill px-3.5 fw-bold shadow-xs" style="background-color: #0066ff;">
                    <i class="fa-solid fa-store me-1.5"></i> Visit Marketplace
                </a>
            </div>
        </div>

        <!-- Success & Error Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-xs mb-4 p-3" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check fs-5 text-success"></i>
                    <div>
                        <strong class="d-block text-dark small fw-bold">Success</strong>
                        <span class="small">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-xs mb-4 p-3" role="alert">
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-triangle-exclamation fs-5 text-danger mt-0.5"></i>
                    <div>
                        <strong class="d-block text-dark small fw-bold">Please correct the errors below:</strong>
                        <ul class="mb-0 ps-3 small text-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <!-- LEFT COLUMN: PROFILE CARD & OVERVIEW -->
            <div class="col-lg-4">
                <div class="profile-card p-4 text-center mb-4">
                    
                    <!-- Avatar with Camera Button -->
                    <div class="avatar-wrapper mb-3">
                        <img src="{{ $user->avatar_url }}" id="profileAvatarPreview" class="rounded-circle object-fit-cover shadow-sm border" style="width: 110px; height: 110px;" alt="{{ $user->name }}">
                        <label for="inputAvatarFile" class="avatar-camera-btn" title="Change Avatar Image">
                            <i class="fa-solid fa-camera" style="font-size: 0.8rem;"></i>
                        </label>
                    </div>

                    <h5 class="fw-bold text-dark mb-0.5">{{ $user->name }}</h5>
                    <p class="text-muted small text-truncate mb-2">{{ $user->email }}</p>

                    <div class="d-flex align-items-center justify-content-center gap-1.5 flex-wrap mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.75rem;">
                            {{ $user->profession ?: 'Student / Learner' }}
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.75rem;">
                            Customer Account
                        </span>
                    </div>

                    <!-- Quick Information List -->
                    <div class="text-start p-3 rounded-3 bg-light border small text-secondary mb-3">
                        <div class="d-flex justify-content-between py-1.5 border-bottom">
                            <span class="text-muted">Account ID:</span>
                            <span class="fw-bold text-dark font-monospace">UDC{{ str_pad((string)$user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1.5 border-bottom">
                            <span class="text-muted">Mobile:</span>
                            <span class="fw-semibold text-dark">{{ $user->phone ?: 'Not provided' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1.5 border-bottom">
                            <span class="text-muted">Location:</span>
                            <span class="fw-semibold text-dark">{{ $user->city ?: 'Ahmedabad' }}, {{ $user->state ?: 'Gujarat' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1.5 border-bottom">
                            <span class="text-muted">Total Orders:</span>
                            <span class="fw-bold text-primary">{{ $ordersCount }} Orders</span>
                        </div>
                        <div class="d-flex justify-content-between py-1.5">
                            <span class="text-muted">Member Since:</span>
                            <span class="fw-semibold text-dark">{{ $user->created_at ? $user->created_at->format('d M Y') : 'Nov 2026' }}</span>
                        </div>
                    </div>

                    <!-- Instant Activation Trust Callout -->
                    <div class="p-2.5 rounded-3 bg-success bg-opacity-10 text-success small text-start border border-success border-opacity-25 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                            <div>
                                <strong class="d-block text-dark fw-bold" style="font-size: 0.78rem;">Direct Buyer Access</strong>
                                <span style="font-size: 0.74rem;">Your account is 100% active. You can browse and buy anytime.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Action Links -->
                    <div class="d-flex flex-column gap-2 text-start">
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary btn-sm py-2 px-3 fw-semibold text-start d-flex align-items-center justify-content-between rounded-3">
                            <span><i class="fa-solid fa-bag-shopping me-2 text-primary"></i> View Orders History</span>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.7rem;"></i>
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm py-2 px-3 fw-semibold text-start d-flex align-items-center justify-content-between rounded-3">
                            <span><i class="fa-solid fa-graduation-cap me-2 text-warning"></i> Explore Courses & Services</span>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.7rem;"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- RIGHT COLUMN: FULL ACCOUNT DETAILS UPDATE FORM -->
            <div class="col-lg-8">
                <div class="profile-card p-4 p-md-5">

                    <div class="border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-dark mb-0.5">Account Details</h4>
                            <p class="text-muted small mb-0">Update your personal profile, profession, location, and password</p>
                        </div>
                        <span class="text-muted small">
                            <span class="text-danger">*</span> Required fields
                        </span>
                    </div>

                    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hidden Avatar File Picker -->
                        <input type="file" name="avatar" id="inputAvatarFile" class="d-none" accept="image/png,image/jpeg,image/webp" onchange="previewProfileAvatar(this)">

                        <!-- SECTION 1: PERSONAL DETAILS -->
                        <div class="mb-4">
                            <h6 class="profile-section-title">
                                <i class="fa-regular fa-user text-primary me-1.5"></i> Personal Details
                            </h6>
                            <p class="text-muted small mb-3">Your primary identity details used across orders and invoices</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="e.g. Rahul Sharma" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="name@example.com" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Mobile Number
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text fw-bold text-dark" style="font-size: 0.85rem;">+91</span>
                                        <input type="tel" name="phone" class="form-control font-monospace" value="{{ old('phone', $user->phone) }}" placeholder="9876543210" maxlength="15">
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">Used for order delivery and SMS status updates</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Avatar / Profile Picture
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-image"></i></span>
                                        <input type="text" class="form-control" placeholder="Choose image..." readonly onclick="document.getElementById('inputAvatarFile').click()" id="avatarFilenameDisplay" style="cursor: pointer;">
                                        <button class="btn btn-outline-secondary border-0 btn-sm px-3" type="button" onclick="document.getElementById('inputAvatarFile').click()">
                                            Browse
                                        </button>
                                    </div>
                                    <div class="form-text small text-muted" style="font-size: 0.72rem;">JPG, PNG, or WEBP up to 2MB</div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: PROFESSION & BACKGROUND -->
                        <div class="mb-4 pt-3 border-top">
                            <h6 class="profile-section-title">
                                <i class="fa-solid fa-briefcase text-primary me-1.5"></i> Profession & Role
                            </h6>
                            <p class="text-muted small mb-3">Tell us who you are so we can tailor educational courses, services, and product recommendations</p>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Select Your Profession / Profile Type <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-user-graduate"></i></span>
                                        <select name="profession" id="inputProfileProfession" class="form-select fw-semibold text-dark" required>
                                            @php $curProf = old('profession', $user->profession); @endphp
                                            <option value="" disabled>-- Select Your Profession / Background * --</option>
                                            
                                            <optgroup label="🎓 Students & Learners">
                                                <option value="Student / Learner" {{ $curProf == 'Student / Learner' ? 'selected' : '' }}>Student / Learner (College / School)</option>
                                                <option value="Job Seeker / Fresher" {{ $curProf == 'Job Seeker / Fresher' ? 'selected' : '' }}>Job Seeker / Fresher (Looking for Jobs)</option>
                                            </optgroup>

                                            <optgroup label="💼 Business Owners & Entrepreneurs">
                                                <option value="Business Owner" {{ $curProf == 'Business Owner' ? 'selected' : '' }}>Business Owner / Founder / MSME</option>
                                                <option value="Retailer / Merchant" {{ $curProf == 'Retailer / Merchant' ? 'selected' : '' }}>Retailer / Merchant / Store Owner</option>
                                            </optgroup>

                                            <optgroup label="👨‍💻 Working Professionals & Employees">
                                                <option value="Working Professional / Employee" {{ $curProf == 'Working Professional / Employee' ? 'selected' : '' }}>Working Professional / Corporate Employee</option>
                                                <option value="Freelancer / Agency" {{ $curProf == 'Freelancer / Agency' ? 'selected' : '' }}>Freelancer / Consultant / Agency</option>
                                            </optgroup>

                                            <optgroup label="👩‍🏫 Teachers & Academics">
                                                <option value="Teacher / Educator" {{ $curProf == 'Teacher / Educator' ? 'selected' : '' }}>Teacher / Educator / Private Tutor</option>
                                                <option value="Institute Representative" {{ $curProf == 'Institute Representative' ? 'selected' : '' }}>Institute Representative / Administrator</option>
                                            </optgroup>

                                            <optgroup label="🌐 Other Profiles">
                                                <option value="Parent / Guardian" {{ $curProf == 'Parent / Guardian' ? 'selected' : '' }}>Parent / Guardian (For my children)</option>
                                                <option value="Other Professional" {{ $curProf == 'Other Professional' ? 'selected' : '' }}>Other Professional Profile</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: LOCATION DETAILS -->
                        <div class="mb-4 pt-3 border-top">
                            <h6 class="profile-section-title">
                                <i class="fa-solid fa-location-dot text-primary me-1.5"></i> Location Details
                            </h6>
                            <p class="text-muted small mb-3">Your default city and state for marketplace shipping and local services</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        City
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-building"></i></span>
                                        <input type="text" name="city" class="form-control" value="{{ old('city', $user->city ?: 'Ahmedabad') }}" placeholder="e.g. Ahmedabad">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        State
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-map"></i></span>
                                        <input type="text" name="state" class="form-control" value="{{ old('state', $user->state ?: 'Gujarat') }}" placeholder="e.g. Gujarat">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: PRIMARY INTERESTS -->
                        <div class="mb-4 pt-3 border-top">
                            <h6 class="profile-section-title">
                                <i class="fa-solid fa-heart text-danger me-1.5"></i> Primary Interests
                            </h6>
                            <p class="text-muted small mb-3">Choose the categories you are most interested in buying</p>

                            @php
                                $userInterests = explode(',', (string)$user->interests);
                                $userInterests = array_map('trim', $userInterests);
                            @endphp

                            <div class="d-flex flex-wrap gap-2">
                                <label class="mb-0">
                                    <input type="checkbox" name="interests[]" value="Courses" class="interest-pill-input d-none" {{ in_array('Courses', $userInterests) || empty($user->interests) ? 'checked' : '' }}>
                                    <span class="interest-pill-label">
                                        <i class="fa-solid fa-graduation-cap me-1"></i> Online Courses & Certifications
                                    </span>
                                </label>
                                <label class="mb-0">
                                    <input type="checkbox" name="interests[]" value="Services" class="interest-pill-input d-none" {{ in_array('Services', $userInterests) ? 'checked' : '' }}>
                                    <span class="interest-pill-label">
                                        <i class="fa-solid fa-briefcase me-1"></i> Professional Services & Freelancers
                                    </span>
                                </label>
                                <label class="mb-0">
                                    <input type="checkbox" name="interests[]" value="Products" class="interest-pill-input d-none" {{ in_array('Products', $userInterests) ? 'checked' : '' }}>
                                    <span class="interest-pill-label">
                                        <i class="fa-solid fa-box-open me-1"></i> Digital Products & Scripts
                                    </span>
                                </label>
                                <label class="mb-0">
                                    <input type="checkbox" name="interests[]" value="Business Listings" class="interest-pill-input d-none" {{ in_array('Business Listings', $userInterests) ? 'checked' : '' }}>
                                    <span class="interest-pill-label">
                                        <i class="fa-solid fa-store me-1"></i> Local Businesses & Institutes
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- SECTION 5: SECURITY & CHANGE PASSWORD -->
                        <div class="mb-4 pt-3 border-top">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="profile-section-title mb-0">
                                    <i class="fa-solid fa-lock text-primary me-1.5"></i> Security & Password
                                </h6>
                                <span class="badge bg-light text-muted border" style="font-size: 0.72rem;">Optional</span>
                            </div>
                            <p class="text-muted small mb-3">Leave blank if you do not wish to change your current password</p>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Current Password
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                        <input type="password" name="current_password" id="fieldCurrentPass" class="form-control" placeholder="Current password">
                                        <button class="btn btn-link text-muted px-2.5 text-decoration-none" type="button" onclick="togglePasswordVisibility('fieldCurrentPass', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        New Password
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" id="fieldNewPass" class="form-control" placeholder="Min. 6 characters">
                                        <button class="btn btn-link text-muted px-2.5 text-decoration-none" type="button" onclick="togglePasswordVisibility('fieldNewPass', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark mb-1">
                                        Confirm New Password
                                    </label>
                                    <div class="input-group profile-input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" id="fieldNewPassConf" class="form-control" placeholder="Repeat new password">
                                        <button class="btn btn-link text-muted px-2.5 text-decoration-none" type="button" onclick="togglePasswordVisibility('fieldNewPassConf', this)">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM ACTION BUTTONS -->
                        <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="text-muted small">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i> Changes save instantly to your active profile
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('home') }}" class="btn btn-light border px-4 py-2.5 fw-semibold rounded-3 text-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4 py-2.5 fw-bold rounded-3 shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #0066ff;">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>Save Account Details</span>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
function previewProfileAvatar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profileAvatarPreview');
            if (preview) {
                preview.src = e.target.result;
            }
            const display = document.getElementById('avatarFilenameDisplay');
            if (display) {
                display.value = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            }
        };
        reader.readAsDataURL(file);
    }
}

function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (!input || !icon) return;

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
</script>
@endsection
