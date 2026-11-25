@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">API & Third-Party Integrations</h2>
            <p class="text-muted small mb-0">Manage REST API credentials, webhook listeners, payment gateways, and connected cloud microservices.</p>
        </div>
        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('admin.api.test-webhook') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="bi bi-broadcast"></i> Test Webhook Ping
                </button>
            </form>
            <form method="POST" action="{{ route('admin.api.regenerate') }}" onsubmit="return confirm('Regenerating keys will invalidate existing API integrations immediately. Are you sure?');" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-key-fill"></i> Roll API Keys
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Third-Party Integrations Status -->
    <h5 class="fw-bold text-dark mb-3">Active Gateway & Cloud Integrations</h5>
    <div class="row g-3 mb-4">
        @foreach($integrations as $key => $int)
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="rounded-3 p-2 bg-light text-primary">
                            <i class="bi {{ $int['icon'] }} fs-4"></i>
                        </div>
                        <span class="badge bg-{{ $int['badge'] }} bg-opacity-10 text-{{ $int['badge'] }} rounded-pill px-2 py-1">
                            {{ $int['status'] }}
                        </span>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">{{ $int['name'] }}</h6>
                    <p class="text-muted small mb-2" style="font-size: 12px; min-height: 34px;">{{ $int['description'] }}</p>
                    <div class="bg-light p-2 rounded-2 mt-auto">
                        <span class="text-muted small d-block" style="font-size: 11px;">Configuration Target:</span>
                        <code class="text-dark small text-truncate d-block">{{ $int['key_preview'] }}</code>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- API Keys and Webhooks -->
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark">Marketplace REST API Credentials</h5>
                    <p class="text-muted small mb-0">Use these keys to authenticate server-to-server calls into Digital Class World API endpoints.</p>
                </div>
                <div class="card-body p-4 pt-0">
                    <form method="POST" action="{{ route('admin.api.update') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small text-uppercase">Public API Key (Client ID)</label>
                            <div class="input-group">
                                <input type="text" class="form-control font-monospace bg-light" value="{{ $apiSettings['api_key'] ?? '' }}" readonly id="apiKeyInput">
                                <button class="btn btn-outline-secondary" type="button" onclick="navigator.clipboard.writeText(document.getElementById('apiKeyInput').value); alert('API Key copied to clipboard!');">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small text-uppercase">Secret Key (Private)</label>
                            <div class="input-group">
                                <input type="password" class="form-control font-monospace bg-light" value="{{ $apiSettings['api_secret'] ?? '' }}" readonly id="apiSecretInput">
                                <button class="btn btn-outline-secondary" type="button" onclick="const f = document.getElementById('apiSecretInput'); f.type = f.type === 'password' ? 'text' : 'password';">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary" type="button" onclick="navigator.clipboard.writeText(document.getElementById('apiSecretInput').value); alert('Secret Key copied to clipboard!');">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                            <span class="text-muted small">Never expose this secret key in client-side code or mobile apps.</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small text-uppercase">Rate Limit (Requests / minute)</label>
                            <input type="number" name="rate_limit_per_min" class="form-control" value="{{ $apiSettings['rate_limit_per_min'] ?? 120 }}" min="10" max="1000">
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="api_enabled" id="apiEnabled" {{ !empty($apiSettings['api_enabled']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark" for="apiEnabled">Enable REST API for external third-party requests</label>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 rounded-3">Save API Settings</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark">Webhook Configuration</h5>
                    <p class="text-muted small mb-0">Incoming transaction & order fulfillment webhook listener.</p>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Listener Endpoint</label>
                        <input type="text" class="form-control font-monospace bg-light" value="{{ $apiSettings['webhook_url'] ?? url('/api/v1/webhooks/gateway') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Webhook Secret</label>
                        <input type="text" class="form-control font-monospace bg-light" value="{{ $apiSettings['webhook_secret'] ?? '' }}" readonly>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 small mb-3">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Webhook signatures are cryptographically signed with <code>HMAC-SHA256</code> on all incoming payload bodies.
                    </div>

                    <h6 class="fw-bold text-dark mt-4 mb-2 small text-uppercase">Supported Webhook Events</h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <code>order.paid</code>
                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <code>payment.refunded</code>
                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <code>payout.processed</code>
                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <code>seller.verified</code>
                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
