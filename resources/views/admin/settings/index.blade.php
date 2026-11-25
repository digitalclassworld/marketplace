@extends('admin.layouts.admin')

@section('title', 'General Settings - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                General Platform Settings
            </h2>
            <p class="text-secondary small mb-0">Configure marketplace branding, commission parameters, payment gateway, and system rules.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="submit" form="settingsForm" class="btn btn-primary btn-sm px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5 rounded-pill shadow-sm" style="background-color: #0066ff;">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save All Changes</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2.5 mb-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Column: Branding & Business Information -->
            <div class="col-lg-7">
                <!-- 1. Marketplace Identity -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-dark mb-3">Marketplace Identity</h5>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Platform Name <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Marketplace Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline']) }}">
                        <span class="text-muted" style="font-size: 0.72rem;">Displayed in search engine meta titles and marketing headers.</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Official Support Email <span class="text-danger">*</span></label>
                            <input type="email" name="support_email" class="form-control" value="{{ old('support_email', $settings['support_email']) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Contact Phone</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone']) }}">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">HQ / Office Address</label>
                        <textarea name="office_address" rows="2" class="form-control">{{ old('office_address', $settings['office_address']) }}</textarea>
                    </div>
                </div>

                <!-- 2. Financial & Commission Rules -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-dark mb-3">Commission & Financial Policy</h5>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Default Marketplace Currency</label>
                            <input type="text" class="form-control bg-light" value="{{ $settings['default_currency'] }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Default Platform Cut (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="commission_rate" class="form-control" value="{{ old('commission_rate', $settings['commission_rate']) }}" required min="0" max="100">
                                <span class="input-group-text bg-light text-muted">%</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.72rem;">Commission retained by Digital Class on provider sales.</span>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">Minimum Payout Settlement Threshold (₹) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">₹</span>
                            <input type="number" name="min_payout_threshold" class="form-control" value="{{ old('min_payout_threshold', $settings['min_payout_threshold']) }}" required min="0">
                        </div>
                        <span class="text-muted" style="font-size: 0.72rem;">Sellers must accumulate this minimum balance before requesting bank payouts.</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Payment Gateway & System Switches -->
            <div class="col-lg-5">
                <!-- 3. Payment Gateway Config -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark mb-0">Payment Gateway</h5>
                        <span class="badge bg-success-subtle text-success fw-semibold px-2 py-0.5 rounded-pill" style="font-size: 0.72rem;">Razorpay Live</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Razorpay Key ID</label>
                        <input type="text" name="razorpay_key" class="form-control font-monospace" value="{{ old('razorpay_key', $settings['razorpay_key']) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Razorpay Secret Key</label>
                        <input type="password" class="form-control font-monospace" value="••••••••••••••••" readonly>
                        <span class="text-muted" style="font-size: 0.72rem;">Stored securely in production environment file.</span>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">Google Client ID</label>
                        <input type="text" name="google_client_id" class="form-control font-monospace" value="{{ old('google_client_id', $settings['google_client_id']) }}" placeholder="optional-oauth-client-id">
                    </div>
                </div>

                <!-- 4. System Toggles & Policies -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">System Controls</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="allow_registration" value="1" id="allowReg" {{ !empty($settings['allow_registration']) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-dark small" for="allowReg">
                            Public User & Customer Registration
                        </label>
                        <div class="text-muted" style="font-size: 0.72rem;">Allows new customers to sign up freely.</div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="auto_approve_sellers" value="1" id="autoApprove" {{ !empty($settings['auto_approve_sellers']) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-dark small" for="autoApprove">
                            Auto-Approve Seller Applications
                        </label>
                        <div class="text-muted" style="font-size: 0.72rem;">If disabled, new sellers require admin verification before selling.</div>
                    </div>

                    <div class="form-check form-switch p-3 rounded-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 mb-0">
                        <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="maintMode" {{ !empty($settings['maintenance_mode']) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-danger small ms-1" for="maintMode">
                            Maintenance Mode
                        </label>
                        <div class="text-danger small" style="font-size: 0.72rem;">Displays maintenance page to all public visitors. Admins remain unaffected.</div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
