@extends('admin.layouts.admin')

@php
    $storeName = $seller->businessDetail?->business_name ?? $seller->user?->name ?? 'Tech Skills Academy';
    $ownerName = $seller->user?->name ?? 'Rahul Sharma';
    $ownerEmail = $seller->user?->email ?? 'rahul@techskills.in';
    $ownerPhone = $seller->user?->phone ?? '+91 98765 43210';
    $website = $seller->businessDetail?->website ?? 'https://techskills.in';
    $city = $seller->businessDetail?->city ?? 'Surat';
    $state = $seller->businessDetail?->state ?? 'Gujarat';
    $location = $city . ', ' . $state;
    $address = $seller->businessDetail?->address ?? '401, Skyline Business Hub, Vesu, Surat - 395007';
    $about = $seller->businessDetail?->about ?? 'We provide industry-focused IT and digital skills training for students and professionals. Our goal is to make quality education accessible to everyone.';
    $sellerCode = $seller->seller_code ?: 'SELL000123';
    $statusText = $seller->isActive() ? 'Active' : ($seller->isPendingApproval() ? 'Awaiting Approval' : ($seller->isSuspended() ? 'Suspended' : ($seller->isRejected() ? 'Rejected' : 'Awaiting Approval')));
@endphp

@section('title', $storeName . ' - Seller Details - Super Admin')

@section('styles')
<style>
    .seller-dossier-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .store-logo-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #0b1528;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-weight: 700;
        font-size: 0.68rem;
        line-height: 1.1;
        padding: 0.5rem;
        flex-shrink: 0;
        border: 2px solid #e2e8f0;
    }

    .tag-pill {
        font-size: 0.72rem;
        font-weight: 500;
        padding: 0.2rem 0.65rem;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
    }

    .nav-tabs-dossier {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .nav-tabs-dossier .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.84rem;
        padding: 0.65rem 1rem;
        border-radius: 8px 8px 0 0;
        background: transparent;
        transition: all 0.15s ease;
        text-decoration: none;
        position: relative;
    }
    .nav-tabs-dossier .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .nav-tabs-dossier .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-dossier .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    .kpi-stat-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        transition: transform 0.15s ease;
    }
    .kpi-stat-box:hover {
        transform: translateY(-2px);
    }
    .kpi-stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .icon-purple { background: #f5f3ff; color: #7c3aed; }
    .icon-blue   { background: #eff6ff; color: #2563eb; }
    .icon-red    { background: #fef2f2; color: #dc2626; }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-green  { background: #ecfdf5; color: #059669; }
    .icon-sky    { background: #f0f9ff; color: #0284c7; }
    .icon-yellow { background: #fefce8; color: #ca8a04; }

    .chart-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        height: 100%;
    }

    .activity-timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #e2e8f0;
    }
    .activity-item {
        position: relative;
        margin-bottom: 1.15rem;
    }
    .activity-dot {
        position: absolute;
        left: -1.5rem;
        top: 4px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Top Breadcrumb & Action Toolbar matching Screenshot -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.sellers.index') }}" class="text-decoration-none text-muted small fw-medium">
                <i class="fa-solid fa-arrow-left me-1"></i> Sellers Management
            </a>
            <span class="text-muted small">›</span>
            <span class="text-dark small fw-semibold">Seller Details</span>
        </div>

        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Sellers
            </a>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-regular fa-comment-dots me-1"></i> Send Message
            </a>
            <a href="{{ route('seller.dashboard') }}" target="_blank" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                <i class="fa-regular fa-user me-1"></i> Impersonate
            </a>
            <button class="btn btn-outline-secondary btn-sm px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#noteModal">
                <i class="fa-regular fa-note-sticky me-1"></i> Add Note
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm px-3 fw-medium dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    More Actions
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <form method="POST" action="{{ route('admin.sellers.approve', $seller->id) }}">
                            @csrf
                            <button type="submit" class="dropdown-item small text-success">
                                <i class="fa-solid fa-check me-2"></i> Approve Seller
                            </button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.sellers.suspend', $seller->id) }}">
                            @csrf
                            <button type="submit" class="dropdown-item small text-danger">
                                <i class="fa-solid fa-ban me-2"></i> Suspend Seller
                            </button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.sellers.reject', $seller->id) }}">
                            @csrf
                            <button type="submit" class="dropdown-item small text-secondary">
                                <i class="fa-solid fa-xmark me-2"></i> Reject Application
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item small" href="{{ url('/sellers/' . \Illuminate\Support\Str::slug($storeName)) }}" target="_blank">
                            <i class="fa-solid fa-arrow-up-right-from-square me-2 text-primary"></i> View Public Store
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div class="fw-medium small">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                <div class="fw-medium small">{{ session('warning') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Profile Dossier Header Card (3-Column Layout matching Screenshot) -->
    <div class="seller-dossier-card shadow-sm mb-4">
        <div class="row g-4 align-items-start">
            <!-- Column 1: Store & Owner Summary (~55%) -->
            <div class="col-12 col-xl-7">
                <div class="d-flex align-items-start gap-3">
                    <!-- Circular Store Logo -->
                    <div class="store-logo-large">
                        <i class="fa-solid fa-book-open mb-1" style="font-size: 1.25rem;"></i>
                        TECH SKILLS<br>ACADEMY
                    </div>

                    <div class="flex-grow-1">
                        <!-- Store Title, Verified Pill, ID & Featured -->
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h4 class="fw-bold text-dark mb-0">{{ $storeName }}</h4>
                            @if($seller->isPendingApproval())
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 small fw-semibold">
                                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Awaiting Approval
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small fw-semibold">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified
                                </span>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2 text-muted small">
                            <span class="font-monospace fw-semibold text-dark">ID: {{ $sellerCode }}</span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0 fw-semibold" style="font-size: 0.68rem;">
                                <i class="fa-solid fa-star me-1"></i> Featured Seller
                            </span>
                            <span>•</span>
                            <span class="text-warning"><i class="fa-solid fa-star"></i></span>
                            <span class="fw-bold text-dark">4.8</span>
                            <span>(320 reviews)</span>
                            <span>•</span>
                            <span>Joined: 12 Jan 2024 (1 year 9 months ago)</span>
                        </div>

                        <!-- Tag Pills -->
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="tag-pill">Education</span>
                            <span class="tag-pill">IT Training</span>
                            <span class="tag-pill">Online & Offline</span>
                            <span class="tag-pill">{{ $location }}</span>
                        </div>

                        <!-- Description Bio -->
                        <p class="text-muted small mb-3" style="line-height: 1.45;">
                            {{ $about }}
                        </p>

                        <!-- Contact Details 2-Column Grid -->
                        <div class="row g-2 small" style="font-size: 0.78rem;">
                            <div class="col-sm-6">
                                <div class="text-muted mb-1">
                                    <i class="fa-regular fa-user me-2 text-primary"></i> Owner Name: <span class="fw-semibold text-dark">{{ $ownerName }}</span>
                                </div>
                                <div class="text-muted mb-1">
                                    <i class="fa-regular fa-envelope me-2 text-primary"></i> Email: <span class="text-dark">{{ $ownerEmail }}</span>
                                </div>
                                <div class="text-muted">
                                    <i class="fa-solid fa-phone me-2 text-primary"></i> Phone: <span class="text-dark">{{ $ownerPhone }}</span>
                                    <i class="fa-brands fa-whatsapp text-success ms-1" title="WhatsApp available"></i>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-muted mb-1">
                                    <i class="fa-solid fa-globe me-2 text-primary"></i> Website: <a href="{{ $website }}" target="_blank" class="text-primary text-decoration-none">{{ $website }}</a>
                                </div>
                                <div class="text-muted mb-1">
                                    <i class="fa-solid fa-location-dot me-2 text-primary"></i> Location: <span class="text-dark">{{ $location }}</span>
                                </div>
                                <div class="text-muted text-truncate" title="{{ $address }}">
                                    <i class="fa-regular fa-building me-2 text-primary"></i> Address: <span class="text-dark">{{ $address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: Account Status (~22%) -->
            <div class="col-12 col-md-6 col-xl-2 border-start-xl ps-xl-4">
                <div class="fw-bold text-dark small text-uppercase mb-2" style="letter-spacing: 0.5px;">Account Status</div>
                
                @if($seller->isPendingApproval())
                    <div class="bg-warning-subtle p-2 rounded-3 border border-warning-subtle d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold text-warning small">Awaiting Approval</span>
                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0" type="checkbox" role="switch" disabled>
                        </div>
                    </div>
                @elseif($seller->isSuspended())
                    <div class="bg-danger-subtle p-2 rounded-3 border border-danger-subtle d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold text-danger small">Suspended</span>
                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0" type="checkbox" role="switch">
                        </div>
                    </div>
                @else
                    <div class="bg-success-subtle p-2 rounded-3 border border-success-subtle d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold text-success small">Active</span>
                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                        </div>
                    </div>
                @endif

                <div class="small" style="font-size: 0.78rem;">
                    <div class="d-flex align-items-center gap-2 mb-2 text-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span class="text-dark">KYC Verified</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2 text-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span class="text-dark">Bank Details Added</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2 text-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span class="text-dark">Documents Verified</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between text-muted">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                            <span class="text-dark">Tax Verified</span>
                        </div>
                        <button class="btn btn-sm btn-outline-primary py-0 px-2 fw-semibold" style="font-size: 0.68rem;">Verify</button>
                    </div>
                </div>
            </div>

            <!-- Column 3: Plan & Subscription (~23%) -->
            <div class="col-12 col-md-6 col-xl-3 border-start-xl ps-xl-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">Plan & Subscription</span>
                    <a href="#" class="text-primary text-decoration-none small" style="font-size: 0.75rem;"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</a>
                </div>

                <div class="mb-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 small fw-semibold">
                        <i class="fa-solid fa-crown me-1 text-warning"></i> Premium Plan
                    </span>
                </div>

                <div class="fs-5 fw-bold text-dark mb-1">
                    ₹4,999 <span class="text-muted fs-6 fw-normal">/ year</span>
                </div>
                <div class="text-muted small mb-3" style="font-size: 0.75rem;">
                    Valid till: 12 Jan 2026 (68 days left)
                </div>

                <div class="d-flex flex-column gap-2">
                    <a href="#" class="btn btn-primary btn-sm fw-medium">Upgrade Plan</a>
                    <a href="#" class="btn btn-outline-secondary btn-sm fw-medium">Change Plan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 10 Navigation Tabs matching Screenshot -->
    <div class="mb-3">
        <nav class="nav nav-tabs-dossier">
            <a href="#tabOverview" data-bs-toggle="pill" class="nav-link active">
                <i class="fa-solid fa-chart-line me-1"></i> Overview
            </a>
            <a href="#tabCourses" data-bs-toggle="pill" class="nav-link">
                <i class="fa-solid fa-graduation-cap me-1"></i> Courses (28)
            </a>
            <a href="#tabServices" data-bs-toggle="pill" class="nav-link">
                <i class="fa-solid fa-briefcase me-1"></i> Services (12)
            </a>
            <a href="#tabProducts" data-bs-toggle="pill" class="nav-link">
                <i class="fa-solid fa-box me-1"></i> Products (5)
            </a>
            <a href="#tabOrders" data-bs-toggle="pill" class="nav-link">
                <i class="fa-solid fa-cart-shopping me-1"></i> Orders (1,240)
            </a>
            <a href="#tabStudents" data-bs-toggle="pill" class="nav-link">
                <i class="fa-solid fa-users me-1"></i> Students (2,480)
            </a>
            <a href="#tabPayouts" data-bs-toggle="pill" class="nav-link">
                <i class="fa-solid fa-wallet me-1"></i> Revenue & Payouts
            </a>
            <a href="#tabReviews" data-bs-toggle="pill" class="nav-link">
                <i class="fa-regular fa-star me-1"></i> Reviews (320)
            </a>
            <a href="#tabCommunications" data-bs-toggle="pill" class="nav-link">
                <i class="fa-regular fa-comments me-1"></i> Communications
            </a>
            <a href="#tabDocuments" data-bs-toggle="pill" class="nav-link">
                <i class="fa-regular fa-file-lines me-1"></i> Documents
            </a>
            <a href="#tabNotes" data-bs-toggle="pill" class="nav-link">
                <i class="fa-regular fa-note-sticky me-1"></i> Notes & Logs
            </a>
        </nav>
    </div>

    <!-- 8 KPI Stat Pills in a single row matching Screenshot -->
    <div class="row g-2 mb-4">
        <!-- 1. Total Courses -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-purple">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Total Courses</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['total_courses'] ?? 28 }}</div>
                </div>
            </div>
        </div>

        <!-- 2. Total Services -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-blue">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Total Services</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['total_services'] ?? 12 }}</div>
                </div>
            </div>
        </div>

        <!-- 3. Total Products -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-red">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Total Products</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['total_products'] ?? 5 }}</div>
                </div>
            </div>
        </div>

        <!-- 4. Total Orders -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-orange">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Total Orders</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['total_orders'] ?? '1,240' }}</div>
                </div>
            </div>
        </div>

        <!-- 5. Total Students -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Total Students</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['total_students'] ?? '2,480' }}</div>
                </div>
            </div>
        </div>

        <!-- 6. Total Revenue -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-green">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Total Revenue</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['total_revenue'] ?? '₹3,71,760' }}</div>
                </div>
            </div>
        </div>

        <!-- 7. Lifetime Payout -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-sky">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Lifetime Payout</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['lifetime_payout'] ?? '₹2,96,800' }}</div>
                </div>
            </div>
        </div>

        <!-- 8. Average Rating -->
        <div class="col-6 col-md-3 col-xl">
            <div class="kpi-stat-box">
                <div class="kpi-stat-icon icon-yellow">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.68rem;">Average Rating</div>
                    <div class="fs-5 fw-bold text-dark">{{ $stats['rating'] ?? '4.8' }} <span class="text-muted fs-6 fw-normal">({{ $stats['reviews_count'] ?? 320 }})</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Analytics Row (3 Cards matching Screenshot) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Revenue & Orders -->
        <div class="col-12 col-xl-5">
            <div class="chart-box shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Revenue & Orders</h6>
                    <select class="form-select form-select-sm text-muted" style="width: auto; font-size: 0.75rem;">
                        <option>Last 12 Months</option>
                    </select>
                </div>

                <div class="d-flex align-items-baseline gap-4 mb-3">
                    <div>
                        <div class="fs-4 fw-bold text-dark d-flex align-items-center gap-2">
                            ₹3,71,760 <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.72rem;">↑ 28%</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.75rem;">Total Revenue</div>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark d-flex align-items-center gap-2">
                            1,240 <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.72rem;">↑ 18%</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.75rem;">Total Orders</div>
                    </div>
                </div>

                <!-- SVG Bar & Line Chart -->
                <div style="height: 160px; position: relative;">
                    <svg viewBox="0 0 500 160" width="100%" height="100%" preserveAspectRatio="none">
                        <!-- Grid lines -->
                        <line x1="0" y1="20" x2="500" y2="20" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="60" x2="500" y2="60" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="100" x2="500" y2="100" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="140" x2="500" y2="140" stroke="#f1f5f9" stroke-width="1" />

                        <!-- Blue Revenue Bars -->
                        <rect x="25" y="110" width="16" height="30" rx="3" fill="#3b82f6" />
                        <rect x="65" y="95" width="16" height="45" rx="3" fill="#3b82f6" />
                        <rect x="105" y="90" width="16" height="50" rx="3" fill="#3b82f6" />
                        <rect x="145" y="85" width="16" height="55" rx="3" fill="#3b82f6" />
                        <rect x="185" y="75" width="16" height="65" rx="3" fill="#3b82f6" />
                        <rect x="225" y="70" width="16" height="70" rx="3" fill="#3b82f6" />
                        <rect x="265" y="60" width="16" height="80" rx="3" fill="#3b82f6" />
                        <rect x="305" y="55" width="16" height="85" rx="3" fill="#3b82f6" />
                        <rect x="345" y="50" width="16" height="90" rx="3" fill="#3b82f6" />
                        <rect x="385" y="40" width="16" height="100" rx="3" fill="#3b82f6" />
                        <rect x="425" y="30" width="16" height="110" rx="3" fill="#3b82f6" />
                        <rect x="465" y="20" width="16" height="120" rx="3" fill="#2563eb" />

                        <!-- Green Orders Line Overlay -->
                        <path d="M 33 120 Q 73 100, 113 95 T 193 80 T 273 65 T 353 50 T 433 35 L 473 25" fill="none" stroke="#10b981" stroke-width="2.5" />
                        <!-- Circles on Points -->
                        <circle cx="473" cy="25" r="4" fill="#10b981" />
                    </svg>
                </div>
                <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 0.68rem;">
                    <span>Nov</span><span>Dec</span><span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-2 small text-muted" style="font-size: 0.72rem;">
                    <span><i class="fa-solid fa-square text-primary me-1"></i> Revenue (₹)</span>
                    <span><i class="fa-solid fa-minus text-success me-1"></i> Orders</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Student Enrollments -->
        <div class="col-12 col-xl-4">
            <div class="chart-box shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Student Enrollments</h6>
                    <select class="form-select form-select-sm text-muted" style="width: auto; font-size: 0.75rem;">
                        <option>Last 12 Months</option>
                    </select>
                </div>

                <div class="mb-3">
                    <div class="fs-4 fw-bold text-dark d-flex align-items-center gap-2">
                        2,480 <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.72rem;">↑ 32%</span>
                    </div>
                    <div class="text-muted" style="font-size: 0.75rem;">Total Students</div>
                </div>

                <!-- Purple Bar Chart -->
                <div style="height: 160px; position: relative;">
                    <svg viewBox="0 0 400 160" width="100%" height="100%" preserveAspectRatio="none">
                        <!-- Grid lines -->
                        <line x1="0" y1="20" x2="400" y2="20" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="60" x2="400" y2="60" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="100" x2="400" y2="100" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="140" x2="400" y2="140" stroke="#f1f5f9" stroke-width="1" />

                        <!-- Purple Bars -->
                        <rect x="15" y="115" width="16" height="25" rx="3" fill="#a855f7" />
                        <rect x="48" y="105" width="16" height="35" rx="3" fill="#a855f7" />
                        <rect x="81" y="95" width="16" height="45" rx="3" fill="#a855f7" />
                        <rect x="114" y="90" width="16" height="50" rx="3" fill="#a855f7" />
                        <rect x="147" y="80" width="16" height="60" rx="3" fill="#a855f7" />
                        <rect x="180" y="75" width="16" height="65" rx="3" fill="#a855f7" />
                        <rect x="213" y="65" width="16" height="75" rx="3" fill="#a855f7" />
                        <rect x="246" y="55" width="16" height="85" rx="3" fill="#a855f7" />
                        <rect x="279" y="50" width="16" height="90" rx="3" fill="#a855f7" />
                        <rect x="312" y="45" width="16" height="95" rx="3" fill="#a855f7" />
                        <rect x="345" y="30" width="16" height="110" rx="3" fill="#a855f7" />
                        <rect x="375" y="20" width="16" height="120" rx="3" fill="#9333ea" />
                    </svg>
                </div>
                <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 0.68rem;">
                    <span>Nov</span><span>Dec</span><span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Performance Metrics -->
        <div class="col-12 col-xl-3">
            <div class="chart-box shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Performance Metrics</h6>
                    <select class="form-select form-select-sm text-muted" style="width: auto; font-size: 0.75rem;">
                        <option>Last 30 Days</option>
                    </select>
                </div>

                <div class="small" style="font-size: 0.78rem;">
                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted"><i class="fa-solid fa-circle-check text-success me-1"></i> Profile Completion</span>
                            <span class="fw-bold text-dark">100%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 100%;"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted"><i class="fa-regular fa-comment-dots text-info me-1"></i> Response Rate</span>
                            <span class="fw-bold text-dark">98%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 98%;"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted"><i class="fa-solid fa-box-open text-primary me-1"></i> Order Completion</span>
                            <span class="fw-bold text-dark">96%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 96%;"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted"><i class="fa-solid fa-user-graduate text-danger me-1"></i> Student Satisfaction</span>
                            <span class="fw-bold text-dark">4.8/5</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 96%;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted"><i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> Dispute Rate</span>
                            <span class="fw-bold text-dark">1%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" style="width: 2%;"></div>
                        </div>
                    </div>

                    <div class="pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted"><i class="fa-solid fa-chart-simple text-success me-1"></i> Overall Performance</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold" style="font-size: 0.7rem;">Excellent</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Tables Row (3 Columns matching Screenshot) -->
    <div class="row g-3">
        <!-- Column 1: Recent Activity -->
        <div class="col-12 col-xl-4">
            <div class="bg-white border rounded-3 p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Recent Activity</h6>
                    <a href="#" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">View All →</a>
                </div>

                <div class="activity-timeline">
                    @foreach($activities as $act)
                        <div class="activity-item">
                            <div class="activity-dot bg-{{ $act['color'] }}"></div>
                            <div class="text-muted" style="font-size: 0.68rem;">{{ $act['time'] }}</div>
                            <div class="fw-semibold text-dark small">{{ $act['title'] }}</div>
                            <div class="text-muted small text-truncate" style="font-size: 0.72rem;">{{ $act['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Column 2: Top Performing Courses -->
        <div class="col-12 col-xl-4">
            <div class="bg-white border rounded-3 p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Top Performing Courses</h6>
                    <a href="{{ route('admin.catalog.courses') }}" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">View All →</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light text-muted" style="font-size: 0.72rem;">
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th class="text-center">Enrollments</th>
                                <th>Revenue</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCourses as $idx => $c)
                                <tr>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $c['img'] }}" alt="{{ $c['name'] }}" class="rounded" style="width: 28px; height: 24px; object-fit: cover;">
                                            <span class="fw-semibold text-dark text-truncate" style="max-width: 110px;">{{ $c['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted fw-semibold">{{ $c['enrollments'] }}</td>
                                    <td class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $c['revenue'] }}</td>
                                    <td>
                                        <span class="text-warning small"><i class="fa-solid fa-star"></i></span>
                                        <span class="fw-semibold text-dark">{{ $c['rating'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Column 3: Recent Orders -->
        <div class="col-12 col-xl-4">
            <div class="bg-white border rounded-3 p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Recent Orders</h6>
                    <a href="#" class="text-primary text-decoration-none small" style="font-size: 0.75rem;">View All →</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light text-muted" style="font-size: 0.72rem;">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $idx => $o)
                                @php
                                    $typeBadge = match(strtolower($o['type'])) {
                                        'course' => 'bg-primary-subtle text-primary border-primary-subtle',
                                        'service' => 'bg-info-subtle text-info border-info-subtle',
                                        default => 'bg-warning-subtle text-warning border-warning-subtle',
                                    };
                                    $statusBadge = match(strtolower($o['status'])) {
                                        'completed' => 'bg-success-subtle text-success border-success-subtle',
                                        'processing' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        default => 'bg-danger-subtle text-danger border-danger-subtle',
                                    };
                                @endphp
                                <tr>
                                    <td class="text-muted">{{ $idx + 1 }}</td>
                                    <td class="font-monospace fw-semibold text-dark" style="font-size: 0.72rem;">{{ $o['code'] }}</td>
                                    <td>
                                        <span class="badge border {{ $typeBadge }}" style="font-size: 0.65rem;">{{ $o['type'] }}</span>
                                    </td>
                                    <td class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $o['amount'] }}</td>
                                    <td class="text-muted" style="font-size: 0.7rem;">{{ $o['date'] }}</td>
                                    <td>
                                        <span class="badge border {{ $statusBadge }}" style="font-size: 0.65rem;">{{ $o['status'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Note -->
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Add Administrative Note</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="4" placeholder="Enter administrative note regarding this seller..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Save Note</button>
            </div>
        </div>
    </div>
</div>
@endsection
