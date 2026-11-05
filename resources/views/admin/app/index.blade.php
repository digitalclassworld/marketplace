@extends('admin.layouts.admin')

@section('title', 'App Management - Digital Class Super Admin')

@section('content')
<div class="container-fluid px-3 px-xl-4 py-3">

    <!-- Flash message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2.5 px-3 mb-3 d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2 fs-6"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header & Action Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">App Management</h1>
            <p class="text-muted small mb-0">Manage your Android, iOS and PWA apps. Control app content, branding, features and releases without code.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="https://play.google.com/store" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 bg-white text-dark fw-semibold px-3 py-2">
                <i class="fa-brands fa-google-play me-1 text-success"></i> View on Play Store
            </a>
            <a href="https://apple.com/app-store" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 bg-white text-dark fw-semibold px-3 py-2">
                <i class="fa-brands fa-apple me-1 text-dark"></i> View on App Store
            </a>
            <button type="button" class="btn btn-sm btn-primary rounded-3 fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#newVersionModal">
                <i class="fa-solid fa-plus me-1.5"></i> New App Version
            </button>
        </div>
    </div>

    <!-- 6 KPI Cards Row -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Downloads -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-download fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['downloads_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Downloads</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['total_downloads'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['downloads_sub'] }}</div>
            </div>
        </div>

        <!-- 2. Active Users -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-users fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['users_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Active Users</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['active_users'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['users_sub'] }}</div>
            </div>
        </div>

        <!-- 3. App Rating -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fffbeb; color: #f59e0b;">
                        <i class="fa-solid fa-star fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">App Rating</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['rating'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['rating_sub'] }}</div>
            </div>
        </div>

        <!-- 4. Crash Rate -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; color: #ef4444;">
                        <i class="fa-solid fa-shield-halved fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['crash_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Crash Rate</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['crash_rate'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['crash_sub'] }}</div>
            </div>
        </div>

        <!-- 5. App Versions -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #f5f3ff; color: #8b5cf6;">
                        <i class="fa-solid fa-layer-group fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">App Versions</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $setting?->current_version ?? $kpi['current_version'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['version_sub'] }}</div>
            </div>
        </div>

        <!-- 6. Last Updated -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fff7ed; color: #ea580c;">
                        <i class="fa-regular fa-calendar fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Last Updated</div>
                <div class="fs-4 fw-bold text-dark mb-1" style="font-size: 1.15rem !important;">{{ $setting?->last_released_at ? $setting->last_released_at->format('d M Y') : $kpi['last_updated'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $setting?->last_released_at ? $setting->last_released_at->format('h:i A') : $kpi['last_updated_time'] }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="px-3 pt-2 border-bottom d-flex align-items-center gap-2 overflow-auto scrollbar-none" style="scrollbar-width: none;">
            <a href="{{ route('admin.app.index', ['platform' => $platform]) }}" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small active-tab">
                App Settings
            </a>
            <a href="#features" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Features & Modules
            </a>
            <a href="#branding" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Branding & Design
            </a>
            <a href="#content" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Content Management
            </a>
            <a href="#config" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                App Configuration
            </a>
            <a href="#versions" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Versions & Releases
            </a>
            <a href="#users" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Users & Access
            </a>
            <a href="#analytics" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Analytics
            </a>
            <a href="#support" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                Support & Feedback
            </a>
        </div>
    </div>

    <!-- 3-Column Studio Grid -->
    <div class="row g-4">
        <!-- 1. LEFT COLUMN: Basic Information & App Assets (4 cols) -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <!-- Select Platform -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark mb-2.5">Select Platform</label>
                    <div class="row g-2">
                        <!-- Android -->
                        <div class="col-4">
                            <a href="{{ route('admin.app.index', ['platform' => 'android']) }}" class="platform-card d-block p-2.5 rounded-3 text-decoration-none border text-center transition-all {{ $platform === 'android' ? 'border-primary bg-primary-subtle' : 'bg-white' }}">
                                <i class="fa-brands fa-android text-success fs-4 mb-1 d-block"></i>
                                <div class="fw-bold small text-dark" style="font-size: 0.75rem;">Android App</div>
                                <div class="text-muted" style="font-size: 0.65rem;">v2.4.0 <span class="badge bg-success-subtle text-success p-0.5 px-1 rounded-pill" style="font-size: 0.55rem;">Live</span></div>
                            </a>
                        </div>
                        <!-- iOS -->
                        <div class="col-4">
                            <a href="{{ route('admin.app.index', ['platform' => 'ios']) }}" class="platform-card d-block p-2.5 rounded-3 text-decoration-none border text-center transition-all {{ $platform === 'ios' ? 'border-primary bg-primary-subtle' : 'bg-white' }}">
                                <i class="fa-brands fa-apple text-dark fs-4 mb-1 d-block"></i>
                                <div class="fw-bold small text-dark" style="font-size: 0.75rem;">iOS App</div>
                                <div class="text-muted" style="font-size: 0.65rem;">v2.4.0 <span class="badge bg-success-subtle text-success p-0.5 px-1 rounded-pill" style="font-size: 0.55rem;">Live</span></div>
                            </a>
                        </div>
                        <!-- PWA -->
                        <div class="col-4">
                            <a href="{{ route('admin.app.index', ['platform' => 'pwa']) }}" class="platform-card d-block p-2.5 rounded-3 text-decoration-none border text-center transition-all {{ $platform === 'pwa' ? 'border-primary bg-primary-subtle' : 'bg-white' }}">
                                <i class="fa-solid fa-globe text-primary fs-4 mb-1 d-block"></i>
                                <div class="fw-bold small text-dark" style="font-size: 0.75rem;">Web App (PWA)</div>
                                <div class="text-muted" style="font-size: 0.65rem;">v1.8.0 <span class="badge bg-info-subtle text-info p-0.5 px-1 rounded-pill" style="font-size: 0.55rem;">Beta</span></div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Basic Information Form -->
                <form action="{{ route('admin.app.update-info') }}" method="POST">
                    @csrf
                    <input type="hidden" name="platform" value="{{ $platform }}">

                    <h2 class="h6 fw-bold text-dark mb-3">Basic Information</h2>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">App Name <span class="text-danger">*</span></label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="appNameCount">13/50</span>
                        </div>
                        <input type="text" name="app_name" id="appNameInput" value="{{ $setting->app_name ?? 'Digital Class' }}" maxlength="50" required class="form-control form-control-sm bg-light">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Package Name (Android)</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="package_name" id="pkgNameInput" value="{{ $setting->package_name ?? 'com.digitalclass.app' }}" class="form-control bg-light">
                                <button type="button" class="btn btn-light border text-muted" onclick="navigator.clipboard.writeText(document.getElementById('pkgNameInput').value); alert('Package name copied!');">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Bundle ID (iOS)</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="bundle_id" id="bundleIdInput" value="{{ $setting->bundle_id ?? 'com.digitalclass.app' }}" class="form-control bg-light">
                                <button type="button" class="btn btn-light border text-muted" onclick="navigator.clipboard.writeText(document.getElementById('bundleIdInput').value); alert('Bundle ID copied!');">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">App Description</label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="descCount">90/200</span>
                        </div>
                        <textarea name="description" id="descInput" rows="3" maxlength="200" class="form-control bg-light small" style="font-size: 0.8rem;">{{ $setting->description ?? 'Your complete educational ecosystem - Courses, Services, Marketplace and Institute Management.' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Short Description (Play Store / App Store)</label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="shortDescCount">46/80</span>
                        </div>
                        <input type="text" name="short_description" id="shortDescInput" value="{{ $setting->short_description ?? 'Learn. Teach. Grow. All in one app - Digital Class.' }}" maxlength="80" class="form-control form-control-sm bg-light">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 fw-semibold py-2">
                        <i class="fa-solid fa-floppy-disk me-1.5"></i> Save App Information
                    </button>
                </form>

                <!-- App Icons & Screenshots Preview -->
                <div class="mt-4 pt-3 border-top">
                    <h2 class="h6 fw-bold text-dark mb-3">App Icons & Screenshots</h2>
                    <div class="d-flex align-items-center gap-2 overflow-auto pb-2 scrollbar-none" style="scrollbar-width: thin;">
                        <!-- App Icon -->
                        <div class="text-center flex-shrink-0" style="width: 68px;">
                            <div class="rounded-3 bg-dark text-warning fw-bold d-flex align-items-center justify-content-center shadow-xs mx-auto mb-1 border" style="width: 58px; height: 58px; font-size: 1.15rem; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                                <span style="background: linear-gradient(135deg, #f59e0b, #ef4444); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">DC</span>
                            </div>
                            <div class="text-muted" style="font-size: 0.62rem;">App Icon</div>
                            <div class="text-muted" style="font-size: 0.58rem;">(1024 x 1024)</div>
                            <a href="javascript:void(0)" onclick="alert('Icon upload dialog opened');" class="small text-primary text-decoration-none" style="font-size: 0.65rem;">Change Icon</a>
                        </div>

                        <!-- Splash Screen -->
                        <div class="text-center flex-shrink-0" style="width: 68px;">
                            <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=120&q=80" alt="Splash" class="rounded-3 object-fit-cover shadow-xs mx-auto mb-1 border" style="width: 44px; height: 58px;">
                            <div class="text-muted" style="font-size: 0.62rem;">Splash Screen</div>
                            <div class="text-muted" style="font-size: 0.58rem;">(1242 x 2688)</div>
                            <a href="javascript:void(0)" onclick="alert('Splash upload dialog opened');" class="small text-primary text-decoration-none" style="font-size: 0.65rem;">Change Image</a>
                        </div>

                        <!-- Login Screen -->
                        <div class="text-center flex-shrink-0" style="width: 68px;">
                            <img src="https://images.unsplash.com/photo-1555421689-491a97ff2040?auto=format&fit=crop&w=120&q=80" alt="Login" class="rounded-3 object-fit-cover shadow-xs mx-auto mb-1 border" style="width: 44px; height: 58px;">
                            <div class="text-muted" style="font-size: 0.62rem;">Login Screen</div>
                            <div class="text-muted" style="font-size: 0.58rem;">&nbsp;</div>
                            <a href="javascript:void(0)" onclick="alert('Login mockup dialog opened');" class="small text-primary text-decoration-none" style="font-size: 0.65rem;">Change Image</a>
                        </div>

                        <!-- Home Screen -->
                        <div class="text-center flex-shrink-0" style="width: 68px;">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=120&q=80" alt="Home Screen" class="rounded-3 object-fit-cover shadow-xs mx-auto mb-1 border" style="width: 44px; height: 58px;">
                            <div class="text-muted" style="font-size: 0.62rem;">Home Screen</div>
                            <div class="text-muted" style="font-size: 0.58rem;">&nbsp;</div>
                            <a href="javascript:void(0)" onclick="alert('Home screen mockup dialog opened');" class="small text-primary text-decoration-none" style="font-size: 0.65rem;">Change Image</a>
                        </div>

                        <!-- Feature Screens -->
                        <div class="text-center flex-shrink-0" style="width: 68px;">
                            <div class="rounded-3 bg-light d-flex align-items-center justify-content-center shadow-xs mx-auto mb-1 border" style="width: 44px; height: 58px;">
                                <i class="fa-solid fa-images text-muted fs-6"></i>
                            </div>
                            <div class="text-muted" style="font-size: 0.62rem;">Feature Screens</div>
                            <div class="text-muted" style="font-size: 0.58rem;">&nbsp;</div>
                            <a href="javascript:void(0)" onclick="alert('Manage screens modal');" class="small text-primary text-decoration-none" style="font-size: 0.65rem;">Manage Screens</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. CENTER COLUMN: App Feature Control (4 cols) -->
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <h2 class="h6 fw-bold text-dark mb-0">App Feature Control</h2>
                </div>
                <p class="text-muted small mb-3" style="font-size: 0.75rem;">Enable or disable modules and features in the app. Changes reflect instantly (no update required).</p>

                <!-- List of 13 App Features with Live Switches -->
                <div class="d-flex flex-column gap-2.5">
                    @foreach($features as $feat)
                    <div class="d-flex align-items-center justify-content-between p-2 rounded-3 hover-bg-light transition-all border border-light">
                        <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                            <div class="rounded-2 d-flex align-items-center justify-content-center text-white flex-shrink-0 shadow-xs" style="width: 32px; height: 32px; background-color: {{ $feat->color }};">
                                <i class="fa-solid {{ $feat->icon }} fs-7"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark small text-truncate" style="font-size: 0.8rem;">{{ $feat->name }}</div>
                                <div class="text-muted text-truncate" style="font-size: 0.7rem;">{{ $feat->description }}</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <!-- Live Toggle Switch -->
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input feature-toggle-chk" type="checkbox" role="switch" 
                                       data-id="{{ $feat->id }}" 
                                       data-key="{{ $feat->key }}" 
                                       {{ $feat->is_enabled ? 'checked' : '' }} 
                                       onchange="toggleAppFeature({{ $feat->id }}, this)">
                            </div>
                            <!-- Settings Gear & Chevron -->
                            <button type="button" class="btn btn-sm btn-light border-0 p-1 text-muted" title="Configure Feature" onclick="alert('Configuring settings for {{ $feat->name }}');">
                                <i class="fa-solid fa-gear" style="font-size: 0.75rem;"></i>
                            </button>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.65rem;"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 3. RIGHT COLUMN: Live App Preview & Publish Status (4 cols) -->
        <div class="col-xl-4 col-lg-12">
            <!-- Live App Preview Container -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h6 fw-bold text-dark mb-0">Live App Preview</h2>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-sm btn-primary py-0.5 px-2 small fw-semibold" id="prevAndroidBtn" onclick="switchPhonePlatform('android')">
                            <i class="fa-brands fa-android me-1"></i> Android
                        </button>
                        <button type="button" class="btn btn-sm btn-light text-muted py-0.5 px-2 small" id="prevIosBtn" onclick="switchPhonePlatform('ios')">
                            <i class="fa-brands fa-apple me-1"></i> iOS
                        </button>
                        <button type="button" class="btn btn-sm btn-light text-muted py-0.5 px-2 small" id="prevPwaBtn" onclick="switchPhonePlatform('pwa')">
                            <i class="fa-solid fa-globe me-1"></i> PWA
                        </button>
                    </div>
                </div>

                <!-- Smartphone Mockup Shell -->
                <div class="phone-mockup-frame mx-auto shadow-lg bg-dark rounded-4 p-2.5 position-relative" style="max-width: 290px; border: 6px solid #1e293b; border-radius: 36px !important;">
                    <!-- Screen Container -->
                    <div class="bg-white rounded-4 overflow-hidden position-relative" style="height: 480px; font-size: 0.75rem;">
                        <!-- Status Bar -->
                        <div class="d-flex align-items-center justify-content-between px-3 pt-1 text-dark small" style="font-size: 0.68rem; height: 24px;">
                            <span class="fw-bold">9:41</span>
                            <div class="notch-pill bg-dark rounded-pill mx-auto" style="width: 70px; height: 12px; margin-top: -6px;"></div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="fa-solid fa-signal" style="font-size: 0.6rem;"></i>
                                <i class="fa-solid fa-wifi" style="font-size: 0.6rem;"></i>
                                <i class="fa-solid fa-battery-full" style="font-size: 0.65rem;"></i>
                            </div>
                        </div>

                        <!-- App Header -->
                        <div class="p-2 border-bottom d-flex align-items-center justify-content-between">
                            <div class="fw-bold text-dark d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                                <span class="text-primary"><i class="fa-solid fa-graduation-cap"></i></span>
                                <span id="mockupAppTitle">{{ $setting->app_name ?? 'Digital Class' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5 text-muted">
                                <i class="fa-solid fa-magnifying-glass" style="font-size: 0.75rem;"></i>
                                <i class="fa-regular fa-bell" style="font-size: 0.75rem;"></i>
                            </div>
                        </div>

                        <!-- Scrollable Mobile Body -->
                        <div class="overflow-y-auto px-2 py-2" style="height: 405px;">
                            <!-- Search Bar -->
                            <div class="bg-light rounded-pill px-2.5 py-1 mb-2 d-flex align-items-center gap-1.5 text-muted border" style="font-size: 0.68rem;">
                                <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 0.6rem;"></i>
                                <span>Search courses, services, institutes...</span>
                            </div>

                            <!-- Hero Banner Card -->
                            <div class="card border-0 rounded-3 text-white p-2.5 mb-2 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0044bb 0%, #0066ff 100%); min-height: 85px;">
                                <div class="position-relative z-1" style="max-width: 65%;">
                                    <div class="fw-bold lh-1 mb-1" style="font-size: 0.78rem;">Learn New Skills, Build a Better Future</div>
                                    <span class="btn btn-warning btn-xs rounded-pill py-0.5 px-2 fw-bold text-dark mt-1" style="font-size: 0.6rem;">Explore Courses</span>
                                </div>
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" alt="Student" class="position-absolute end-0 bottom-0 rounded-circle" style="width: 75px; height: 75px; object-fit: cover; margin-right: -10px; margin-bottom: -5px;">
                            </div>

                            <!-- Mobile App Grid Features (Controlled dynamically by center column toggles!) -->
                            <div class="row g-1.5 text-center mb-2.5">
                                <div class="col-3 feat-node" id="mockup-courses">
                                    <div class="p-1 rounded-3 bg-danger-subtle text-danger mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Courses</div>
                                </div>
                                <div class="col-3 feat-node" id="mockup-services">
                                    <div class="p-1 rounded-3 bg-primary-subtle text-primary mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Services</div>
                                </div>
                                <div class="col-3 feat-node" id="mockup-products">
                                    <div class="p-1 rounded-3 bg-warning-subtle text-warning mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Products</div>
                                </div>
                                <div class="col-3 feat-node" id="mockup-business_listings">
                                    <div class="p-1 rounded-3 bg-info-subtle text-info mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Institutes</div>
                                </div>

                                <div class="col-3 feat-node" id="mockup-offers">
                                    <div class="p-1 rounded-3 bg-danger-subtle text-danger mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-percent"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Offers</div>
                                </div>
                                <div class="col-3 feat-node" id="mockup-live">
                                    <div class="p-1 rounded-3 bg-success-subtle text-success mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-video"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Live Classes</div>
                                </div>
                                <div class="col-3 feat-node" id="mockup-my_learning">
                                    <div class="p-1 rounded-3 bg-primary-subtle text-primary mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">My Learning</div>
                                </div>
                                <div class="col-3 feat-node" id="mockup-certificates">
                                    <div class="p-1 rounded-3 bg-warning-subtle text-warning mx-auto mb-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-award"></i>
                                    </div>
                                    <div style="font-size: 0.62rem;" class="fw-semibold text-dark text-truncate">Certificates</div>
                                </div>
                            </div>

                            <!-- Featured Courses Header -->
                            <div class="d-flex align-items-center justify-content-between mb-1.5 px-0.5">
                                <span class="fw-bold text-dark" style="font-size: 0.72rem;">Featured Courses</span>
                                <span class="text-primary fw-semibold" style="font-size: 0.62rem;">See All</span>
                            </div>

                            <!-- Featured Course Cards -->
                            <div class="row g-1.5">
                                <div class="col-6">
                                    <div class="card border rounded-3 p-1.5 bg-white shadow-xs">
                                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=120&q=80" alt="Course" class="rounded-2 w-100 object-fit-cover mb-1" style="height: 48px;">
                                        <div class="fw-bold text-dark text-truncate" style="font-size: 0.65rem;">Digital Marketing</div>
                                        <div class="text-muted" style="font-size: 0.58rem;"><i class="fa-solid fa-star text-warning"></i> 4.7 • 12.4k Students</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border rounded-3 p-1.5 bg-white shadow-xs">
                                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=120&q=80" alt="Course" class="rounded-2 w-100 object-fit-cover mb-1" style="height: 48px;">
                                        <div class="fw-bold text-dark text-truncate" style="font-size: 0.65rem;">Full Stack Dev</div>
                                        <div class="text-muted" style="font-size: 0.58rem;"><i class="fa-solid fa-star text-warning"></i> 4.8 • 8.2k Students</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Navigation Bar -->
                        <div class="position-absolute bottom-0 start-0 w-100 bg-white border-top d-flex align-items-center justify-content-around py-1.5 text-muted" style="font-size: 0.6rem;">
                            <div class="text-center text-primary fw-semibold">
                                <i class="fa-solid fa-house d-block fs-7"></i>
                                <span>Home</span>
                            </div>
                            <div class="text-center">
                                <i class="fa-solid fa-book-open d-block fs-7"></i>
                                <span>Learn</span>
                            </div>
                            <div class="text-center">
                                <i class="fa-solid fa-cart-shopping d-block fs-7"></i>
                                <span>Cart</span>
                            </div>
                            <div class="text-center">
                                <i class="fa-solid fa-comments d-block fs-7"></i>
                                <span>Chat</span>
                            </div>
                            <div class="text-center">
                                <i class="fa-regular fa-user d-block fs-7"></i>
                                <span>Profile</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Publish Status Card -->
                <div class="mt-4 pt-3 border-top">
                    <h3 class="h6 fw-bold text-dark mb-2.5">Publish Status</h3>
                    
                    <div class="d-flex flex-column gap-2 mb-3">
                        <!-- Play store -->
                        <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-brands fa-google-play text-success fs-5"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Google Play <span class="badge bg-success-subtle text-success ms-1 small">Live v2.4.0</span></div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Updated: 12 Oct 2026</div>
                                </div>
                            </div>
                            <a href="https://play.google.com" target="_blank" class="small text-primary text-decoration-none" style="font-size: 0.72rem;">View on Play Store</a>
                        </div>

                        <!-- App store -->
                        <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-brands fa-apple text-dark fs-5"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Apple App Store <span class="badge bg-success-subtle text-success ms-1 small">Live v2.4.0</span></div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Updated: 12 Oct 2026</div>
                                </div>
                            </div>
                            <a href="https://apple.com" target="_blank" class="small text-primary text-decoration-none" style="font-size: 0.72rem;">View on App Store</a>
                        </div>

                        <!-- Web App -->
                        <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-globe text-primary fs-5"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Web App <span class="badge bg-info-subtle text-info ms-1 small">Live v1.8.0</span></div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Updated: 10 Oct 2026</div>
                                </div>
                            </div>
                            <a href="{{ route('home') }}" target="_blank" class="small text-primary text-decoration-none" style="font-size: 0.72rem;">Open Web App</a>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary w-50 rounded-3 fw-semibold small py-2" data-bs-toggle="modal" data-bs-target="#newVersionModal">
                            <i class="fa-regular fa-calendar me-1"></i> Schedule Update
                        </button>
                        <button type="button" class="btn btn-primary w-50 rounded-3 fw-semibold small py-2" data-bs-toggle="modal" data-bs-target="#newVersionModal">
                            <i class="fa-solid fa-rocket me-1"></i> Publish New Version
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: New App Version Release -->
<div class="modal fade" id="newVersionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark fs-6"><i class="fa-solid fa-rocket me-2 text-primary"></i> Deploy New App Version</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.app.publish') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Target Platform</label>
                        <select name="platform" class="form-select form-select-sm bg-light">
                            <option value="android" {{ $platform === 'android' ? 'selected' : '' }}>Android App (Play Store)</option>
                            <option value="ios" {{ $platform === 'ios' ? 'selected' : '' }}>iOS App (Apple App Store)</option>
                            <option value="pwa" {{ $platform === 'pwa' ? 'selected' : '' }}>Web App (PWA)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Release Version</label>
                        <input type="text" name="version" value="v2.4.1" required class="form-control form-control-sm bg-light" placeholder="e.g. v2.4.1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Release Notes</label>
                        <textarea name="notes" rows="3" class="form-control bg-light small" placeholder="Describe new features, performance improvements and bug fixes...">Performance optimizations, new payment gateway enhancements and live class stability fixes.</textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-sm btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold px-4">
                        <i class="fa-solid fa-paper-plane me-1.5"></i> Publish Immediately
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.tab-link {
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
}
.tab-link:hover {
    color: #0066ff !important;
}
.tab-link.active-tab {
    color: #0066ff !important;
    border-bottom: 2px solid #0066ff;
}
.hover-bg-light:hover {
    background-color: #f8fafc;
}
.transition-all {
    transition: all 0.2s ease;
}
.shadow-xs {
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const appNameInput = document.getElementById('appNameInput');
    const descInput = document.getElementById('descInput');
    const shortDescInput = document.getElementById('shortDescInput');
    const mockupAppTitle = document.getElementById('mockupAppTitle');

    if (appNameInput) {
        appNameInput.addEventListener('input', function () {
            document.getElementById('appNameCount').textContent = this.value.length + '/50';
            if (mockupAppTitle) mockupAppTitle.textContent = this.value || 'Digital Class';
        });
    }

    if (descInput) {
        descInput.addEventListener('input', function () {
            document.getElementById('descCount').textContent = this.value.length + '/200';
        });
    }

    if (shortDescInput) {
        shortDescInput.addEventListener('input', function () {
            document.getElementById('shortDescCount').textContent = this.value.length + '/80';
        });
    }
});

// Live AJAX toggle for features
function toggleAppFeature(featureId, checkbox) {
    const isChecked = checkbox.checked;
    const featKey = checkbox.dataset.key;

    // Toggle live mockup visibility immediately
    const mockupNode = document.getElementById('mockup-' + featKey);
    if (mockupNode) {
        mockupNode.style.opacity = isChecked ? '1' : '0.2';
    }

    fetch(`/admin/app/features/${featureId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            checkbox.checked = !isChecked;
            if (mockupNode) mockupNode.style.opacity = !isChecked ? '1' : '0.2';
        }
    })
    .catch(err => {
        console.error(err);
    });
}

function switchPhonePlatform(p) {
    ['prevAndroidBtn', 'prevIosBtn', 'prevPwaBtn'].forEach(b => {
        document.getElementById(b).className = 'btn btn-sm btn-light text-muted py-0.5 px-2 small';
    });
    const active = document.getElementById('prev' + p.charAt(0).toUpperCase() + p.slice(1) + 'Btn');
    if (active) active.className = 'btn btn-sm btn-primary py-0.5 px-2 small fw-semibold';
}
</script>
@endsection
