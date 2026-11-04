@extends('seller.layouts.seller')

@section('title', 'Seller Dashboard - Digital Class Marketplace')

@section('styles')
<style>
    /* Super Premium Typography & Colors */
    :root {
        --dc-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --dc-font-heading: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        --dc-font-mono: 'JetBrains Mono', monospace;
    }

    .display-heading {
        font-family: var(--dc-font-heading);
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    /* Pulse animation for Under Process badge */
    @keyframes dc-pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.5); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    .badge-pulse {
        animation: dc-pulse 2s infinite ease-in-out;
    }

    /* Under Process Hero Card */
    .dc-hero-under-process {
        background: radial-gradient(circle at 100% 0%, #fffbeb 0%, #fef3c7 40%, #ffffff 100%);
        border: 1px solid #fde68a;
        border-radius: 20px;
        box-shadow: 0 10px 30px -10px rgba(217, 119, 6, 0.12);
        padding: 2.25rem 2.25rem;
        position: relative;
        overflow: hidden;
    }

    /* Rejected Hero Card */
    .dc-hero-rejected {
        background: radial-gradient(circle at 100% 0%, #fff1f2 0%, #ffe4e6 40%, #ffffff 100%);
        border: 1px solid #fecdd3;
        border-radius: 20px;
        box-shadow: 0 10px 30px -10px rgba(225, 29, 72, 0.12);
        padding: 2.25rem 2.25rem;
        position: relative;
        overflow: hidden;
    }

    /* Review Steps Progress */
    .dc-step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        flex: 1;
        transition: all 0.2s ease;
    }
    .dc-step-card.completed {
        border-color: #86efac;
        background: #f0fdf4;
    }
    .dc-step-card.in-progress {
        border-color: #fde047;
        background: #fefce8;
        box-shadow: 0 4px 14px rgba(234, 179, 8, 0.12);
    }
    .dc-step-card.locked {
        opacity: 0.65;
        background: #f8fafc;
    }

    /* Page 4 Stat Metric Cards */
    .dc-metric-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 1.25rem 1.4rem;
        transition: all 0.2s ease;
        position: relative;
    }
    .dc-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -10px rgba(0, 0, 0, 0.08);
    }
    .dc-metric-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Quick Action Button Box */
    .dc-quick-action-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 0.5rem;
        text-align: center;
        text-decoration: none;
        color: #334155;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        height: 100%;
    }
    .dc-quick-action-btn:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 6px 16px -6px rgba(0,0,0,0.08);
        transform: translateY(-2px);
        color: #0066ff;
    }
    .dc-quick-action-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    /* Donut Center Overlay */
    .dc-donut-container {
        position: relative;
        width: 190px;
        height: 190px;
        margin: 0 auto;
    }
    .dc-donut-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .font-mono-code {
        font-family: var(--dc-font-mono) !important;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- =========================================================================
         STATE 1: UNDER PROCESS (Pending Admin Approval)
         ========================================================================= --}}
    @if($seller && $seller->isPendingApproval())
        
        <!-- Under Process Banner -->
        <div class="dc-hero-under-process mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" 
                         style="width: 58px; height: 58px; background-color: #fef3c7; color: #d97706; border: 3px solid #fde68a;">
                        <i class="fa-solid fa-hourglass-half fs-3 badge-pulse"></i>
                    </div>
                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold" style="letter-spacing: 0.04em;">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i> UNDER PROCESS
                            </span>
                            <span class="badge bg-white text-secondary border font-mono-code px-2 py-1">
                                {{ $seller->seller_code }}
                            </span>
                        </div>
                        <h2 class="display-heading text-dark mb-2">
                            Your Seller Account is Under Process!
                        </h2>
                        <p class="text-muted mb-0" style="max-width: 720px; font-size: 0.95rem; line-height: 1.5;">
                            Thank you for registering with <strong>Digital Class Marketplace</strong>. Your store application and business profile are currently under administrative review. Once Super Admin approves your account, your full selling dashboard and listing publishing tools will immediately activate.
                        </p>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="d-flex flex-column gap-2 flex-shrink-0">
                    <a href="{{ route('seller.profile') }}" class="btn btn-outline-dark fw-semibold px-3 py-2 rounded-3 text-nowrap">
                        <i class="fa-solid fa-id-card me-1"></i> View Store Profile
                    </a>
                </div>
            </div>

            <!-- Review Steps Timeline -->
            <div class="row g-3 mt-3 pt-3 border-top border-warning-subtle">
                <div class="col-md-4">
                    <div class="dc-step-card completed">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-circle-check text-success fs-5"></i>
                            <span class="fw-bold text-dark small">Step 1: Registration Completed</span>
                        </div>
                        <small class="text-muted d-block">
                            Submitted on {{ $seller->registration_date ? $seller->registration_date->format('d M, Y') : now()->format('d M, Y') }}
                        </small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="dc-step-card in-progress">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-clock text-warning fs-5"></i>
                            <span class="fw-bold text-dark small">Step 2: Admin Verification</span>
                        </div>
                        <small class="text-warning-emphasis d-block fw-semibold">
                            Currently Under Process by Super Admin
                        </small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="dc-step-card locked">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-lock text-secondary fs-5"></i>
                            <span class="fw-bold text-dark small">Step 3: Marketplace Go-Live</span>
                        </div>
                        <small class="text-muted d-block">
                            Unlocks upon Super Admin approval
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submitted Profile Details & Super Admin Approval Workflow -->
        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="display-heading text-dark mb-3">
                        <i class="fa-solid fa-store text-primary me-2"></i>Submitted Seller Details
                    </h5>
                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Permanent Seller ID</span>
                            <span class="font-mono-code text-primary fs-5">{{ $seller->seller_code }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Store / Business Name</span>
                            <strong class="text-dark fs-6">{{ $seller->businessDetail?->business_name ?? $user->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Account Type</span>
                            <span class="fw-semibold text-dark">{{ $seller->account_type }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Registered Email</span>
                            <span class="fw-semibold text-dark">{{ $user->email }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Contact Phone</span>
                            <span class="fw-semibold text-dark">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Location</span>
                            <span class="fw-semibold text-dark">{{ $seller->businessDetail?->city ?? 'Ahmedabad' }}, {{ $seller->businessDetail?->state ?? 'Gujarat' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 border-start border-4 border-primary">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-user-shield text-primary fs-5"></i>
                        <h6 class="display-heading text-dark mb-0">Super Admin Approval Workflow</h6>
                    </div>
                    <p class="text-muted small mb-3">
                        To activate this seller and unlock their full working dashboard:
                    </p>
                    <ol class="small text-muted ps-3 mb-3">
                        <li class="mb-1">Log in to the <strong>Super Admin Portal</strong> (<code>superadmin@gmail.com</code> / <code>Admin@123</code>).</li>
                        <li class="mb-1">Open <strong>Sellers &rarr; Pending Approvals</strong>.</li>
                        <li>Click <strong>Approve</strong> on seller <code>{{ $seller->seller_code }}</code>.</li>
                    </ol>
                    <a href="{{ route('admin.login') }}" target="_blank" class="btn btn-sm btn-primary fw-semibold mt-auto" style="background-color: #0066ff;">
                        <i class="fa-solid fa-shield-halved me-1"></i> Open Super Admin Portal &rarr;
                    </a>
                </div>
            </div>
        </div>

    {{-- =========================================================================
         STATE 2: REJECTED (Sorry! Not Approved)
         ========================================================================= --}}
    @elseif($seller && $seller->isRejected())

        <div class="dc-hero-rejected mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" 
                         style="width: 58px; height: 58px; background-color: #ffe4e6; color: #e11d48; border: 3px solid #fecdd3;">
                        <i class="fa-solid fa-circle-xmark fs-2"></i>
                    </div>
                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="badge bg-danger text-white px-3 py-1 rounded-pill fw-bold" style="letter-spacing: 0.04em;">
                                <i class="fa-solid fa-ban me-1"></i> NOT APPROVED
                            </span>
                            <span class="badge bg-white text-secondary border font-mono-code px-2 py-1">
                                {{ $seller->seller_code }}
                            </span>
                        </div>
                        <h2 class="display-heading text-dark mb-2">
                            Sorry! Your Application was Not Approved
                        </h2>
                        <p class="text-muted mb-0" style="max-width: 720px; font-size: 0.95rem; line-height: 1.5;">
                            Our platform compliance and administrative team carefully reviewed your seller application, and unfortunately it could not be approved at this time.
                        </p>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="d-flex flex-column gap-2 flex-shrink-0">
                    <a href="{{ route('seller.profile') }}" class="btn btn-danger fw-semibold px-3 py-2 rounded-3 text-nowrap">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Update Store Profile
                    </a>
                </div>
            </div>

            <!-- Rejection Reason Card -->
            <div class="card border-0 bg-white rounded-3 p-3 mt-4 border-start border-4 border-danger shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="text-danger small text-uppercase" style="letter-spacing: 0.05em;">Administrative Review Feedback</strong>
                    <span class="text-muted small">{{ $seller->rejected_at ? $seller->rejected_at->format('d M, Y h:i A') : 'Recent Review' }}</span>
                </div>
                <p class="text-dark mb-0 fw-medium">
                    "{{ $seller->rejection_reason ?? 'Your application did not satisfy our marketplace seller verification standards or required business documentation was incomplete.' }}"
                </p>
            </div>

            <div class="mt-4 pt-3 border-top border-danger-subtle d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="small text-muted">
                    <i class="fa-solid fa-circle-info text-danger me-1"></i>
                    Need help? Review your store details in profile or reach out to our team at <strong>support@digitalclass.com</strong>.
                </div>
                <a href="{{ route('seller.profile') }}" class="btn btn-outline-danger btn-sm fw-semibold">
                    Review Store Information &rarr;
                </a>
            </div>
        </div>

    {{-- =========================================================================
         STATE 3: SUSPENDED
         ========================================================================= --}}
    @elseif($seller && $seller->isSuspended())

        <div class="alert alert-warning rounded-4 p-4 mb-4 border-0 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation fs-1 text-warning"></i>
                <div>
                    <h4 class="display-heading mb-1 text-dark">Seller Account Temporarily Suspended</h4>
                    <p class="text-muted mb-0 small">
                        Your seller portal has been suspended by administration. Listing publishing and public store display are temporarily blocked. Please contact support.
                    </p>
                </div>
            </div>
        </div>

    {{-- =========================================================================
         STATE 4: ACTIVE & APPROVED - EXACT MATCH OF PAGE 4 DESIGN
         ========================================================================= --}}
    @else

        <!-- Top Greeting Bar & Date Range Dropdown -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="display-heading fw-bold text-dark mb-1" style="font-size: 1.65rem;">
                    Welcome back, {{ explode(' ', $user->name)[0] }}! 👋
                </h2>
                <p class="text-muted mb-0 small" style="font-size: 0.875rem;">Here's what's happening with your marketplace store today.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-white bg-white border shadow-sm px-3 py-2 rounded-3 text-secondary small fw-semibold d-flex align-items-center gap-2" style="font-size: 0.825rem;">
                        <i class="fa-regular fa-calendar text-muted"></i>
                        <span>Oct 1, 2026 - Oct 31, 2026</span>
                        <i class="fa-solid fa-chevron-down text-muted ms-1" style="font-size: 0.65rem;"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= ROW 1: 4 STAT METRIC CARDS ================= -->
        <div class="row g-3 mb-4">
            <!-- 1. Total Orders -->
            <div class="col-xl-3 col-sm-6">
                <div class="dc-metric-card h-100">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="dc-metric-icon" style="background: #e0f2fe; color: #0284c7;">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Total Orders</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                            {{ $stats['total_orders'] }}
                        </h3>
                        <span class="badge rounded-pill fw-bold bg-success-subtle text-success" style="font-size: 0.725rem;">
                            {{ $stats['orders_growth'] ?? '+18%' }}
                        </span>
                    </div>
                    <span class="text-muted small" style="font-size: 0.75rem;">{{ $stats['orders_sub'] ?? '18 this month' }}</span>
                </div>
            </div>

            <!-- 2. Total Earnings -->
            <div class="col-xl-3 col-sm-6">
                <div class="dc-metric-card h-100">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="dc-metric-icon" style="background: #dcfce7; color: #16a34a;">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Total Earnings</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                            ₹{{ number_format($stats['total_earnings']) }}
                        </h3>
                        <span class="badge rounded-pill fw-bold bg-success-subtle text-success" style="font-size: 0.725rem;">
                            {{ $stats['earnings_growth'] ?? '+26%' }}
                        </span>
                    </div>
                    <span class="text-muted small" style="font-size: 0.75rem;">{{ $stats['earnings_sub'] ?? '+₹24,560 this month' }}</span>
                </div>
            </div>

            <!-- 3. Total Views -->
            <div class="col-xl-3 col-sm-6">
                <div class="dc-metric-card h-100">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="dc-metric-icon" style="background: #f3e8ff; color: #9333ea;">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Total Views</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                            {{ number_format($stats['total_views']) }}
                        </h3>
                        <span class="badge rounded-pill fw-bold bg-success-subtle text-success" style="font-size: 0.725rem;">
                            {{ $stats['views_growth'] ?? '+68%' }}
                        </span>
                    </div>
                    <span class="text-muted small" style="font-size: 0.75rem;">{{ $stats['views_sub'] ?? '+4,820 this month' }}</span>
                </div>
            </div>

            <!-- 4. Total Customers -->
            <div class="col-xl-3 col-sm-6">
                <div class="dc-metric-card h-100">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="dc-metric-icon" style="background: #ffedd5; color: #ea580c;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold small" style="font-size: 0.8rem;">Total Customers</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="display-heading text-dark mb-0 font-mono-code" style="font-size: 1.75rem;">
                            {{ $stats['total_customers'] }}
                        </h3>
                        <span class="badge rounded-pill fw-bold bg-success-subtle text-success" style="font-size: 0.725rem;">
                            {{ $stats['customers_growth'] ?? '+32%' }}
                        </span>
                    </div>
                    <span class="text-muted small" style="font-size: 0.75rem;">{{ $stats['customers_sub'] ?? '+34 this month' }}</span>
                </div>
            </div>
        </div>

        <!-- ================= ROW 2: MANAGE YOUR LISTINGS (68%) + STORE PREVIEW (32%) ================= -->
        <div class="row g-4 mb-4">
            <!-- Left: Manage Your Listings (4 Cards) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="mb-3">
                        <h5 class="display-heading fw-bold text-dark mb-1" style="font-size: 1.15rem;">Manage Your Listings</h5>
                        <p class="text-muted small mb-0">Create and manage your content across all categories</p>
                    </div>

                    <div class="row g-3">
                        <!-- 1. Courses -->
                        <div class="col-md-3 col-sm-6">
                            <div class="p-3 rounded-3 h-100 d-flex flex-column" style="background: #fff8f8; border: 1px solid #fee2e2;">
                                <div class="d-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 36px; height: 36px; background: #fee2e2; color: #dc2626;">
                                    <i class="fa-brands fa-youtube fs-5"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Courses</h6>
                                <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.725rem; line-height: 1.35;">
                                    Upload and sell online courses, batches and study material
                                </p>
                                <a href="{{ route('seller.courses.index') }}" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold mb-2 py-1" style="font-size: 0.75rem; border-color: #ef4444; color: #dc2626;">
                                    Manage Courses &rarr;
                                </a>
                                <div class="text-muted small text-center" style="font-size: 0.725rem;">
                                    <strong>{{ $stats['courses_count'] }} Courses</strong> | <span class="text-secondary fw-medium">{{ $stats['courses_pending'] }} Pending</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Services -->
                        <div class="col-md-3 col-sm-6">
                            <div class="p-3 rounded-3 h-100 d-flex flex-column" style="background: #f0f7ff; border: 1px solid #dbeafe;">
                                <div class="d-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 36px; height: 36px; background: #dbeafe; color: #0284c7;">
                                    <i class="fa-solid fa-briefcase fs-6"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Services</h6>
                                <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.725rem; line-height: 1.35;">
                                    List your professional services and get orders
                                </p>
                                <a href="{{ route('seller.services.index') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold mb-2 py-1" style="font-size: 0.75rem; border-color: #3b82f6; color: #2563eb;">
                                    Manage Services &rarr;
                                </a>
                                <div class="text-muted small text-center" style="font-size: 0.725rem;">
                                    <strong>{{ $stats['services_count'] }} Services</strong> | <span class="text-secondary fw-medium">{{ $stats['services_pending'] }} Pending</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Products -->
                        <div class="col-md-3 col-sm-6">
                            <div class="p-3 rounded-3 h-100 d-flex flex-column" style="background: #f0fdf4; border: 1px solid #dcfce7;">
                                <div class="d-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 36px; height: 36px; background: #dcfce7; color: #16a34a;">
                                    <i class="fa-solid fa-cube fs-6"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Products</h6>
                                <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.725rem; line-height: 1.35;">
                                    Add physical products and manage inventory
                                </p>
                                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold mb-2 py-1" style="font-size: 0.75rem; border-color: #22c55e; color: #16a34a;">
                                    Manage Products &rarr;
                                </a>
                                <div class="text-muted small text-center" style="font-size: 0.725rem;">
                                    <strong>{{ $stats['products_count'] }} Products</strong> | <span class="text-secondary fw-medium">{{ $stats['products_pending'] }} Pending</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Business Listing -->
                        <div class="col-md-3 col-sm-6">
                            <div class="p-3 rounded-3 h-100 d-flex flex-column" style="background: #faf5ff; border: 1px solid #f3e8ff;">
                                <div class="d-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 36px; height: 36px; background: #f3e8ff; color: #9333ea;">
                                    <i class="fa-solid fa-store fs-6"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Business Listing</h6>
                                <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.725rem; line-height: 1.35;">
                                    Showcase your business with complete details
                                </p>
                                <a href="{{ route('seller.listings.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100 fw-bold mb-2 py-1" style="font-size: 0.75rem; border-color: #a855f7; color: #9333ea;">
                                    Manage Listing &rarr;
                                </a>
                                <div class="text-muted small text-center" style="font-size: 0.725rem;">
                                    <strong>{{ $stats['listings_count'] }} Listings</strong> | <span class="text-secondary fw-medium">{{ $stats['listings_pending'] }} Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Your Store Preview -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.15rem;">Your Store Preview</h5>
                        <a href="{{ route('home') }}" target="_blank" class="text-primary text-decoration-none small fw-semibold">
                            View Store <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                        </a>
                    </div>

                    <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 56px; height: 56px; background: #0b1424; color: #f59e0b; border: 2px solid #eab308; font-weight: 800; font-size: 1.35rem; font-family: var(--dc-font-heading);">
                                {{ strtoupper(substr($seller?->businessDetail?->business_name ?? $user->name, 0, 2)) }}
                            </div>
                            <div class="overflow-hidden">
                                <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 1.05rem;">
                                    {{ $seller?->businessDetail?->business_name ?? ($user->name . "'s Store") }}
                                </h6>
                                <div class="d-flex align-items-center gap-1 small mb-1">
                                    <i class="fa-solid fa-star text-warning" style="font-size: 0.8rem;"></i>
                                    <strong class="text-dark" style="font-size: 0.85rem;">5.0</strong>
                                    <span class="text-muted" style="font-size: 0.775rem;">(New Store)</span>
                                </div>
                                <div class="text-muted small text-truncate" style="font-size: 0.775rem;">
                                    <i class="fa-solid fa-location-dot text-danger me-1"></i>
                                    {{ $seller?->businessDetail?->city ?? 'Location not set' }}
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 mt-2 border-top text-muted small" style="font-size: 0.75rem;">
                            Courses | Services | Digital Products
                        </div>
                    </div>

                    <a href="{{ route('seller.profile') }}" class="btn btn-outline-dark btn-sm rounded-pill w-100 fw-bold mt-auto py-2" style="font-size: 0.825rem;">
                        <i class="fa-solid fa-pen me-1"></i> Edit Store Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- ================= ROW 3: SALES OVERVIEW + CATEGORY PERFORMANCE + RECENT ORDERS ================= -->
        <div class="row g-4 mb-4">
            <!-- 1. Sales Overview (Stacked Bar Chart) -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.1rem;">Sales Overview</h5>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border text-secondary px-2 py-1 rounded-2 fw-medium" style="font-size: 0.75rem;">
                                Last 30 Days <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Custom Mini Legend -->
                    <div class="d-flex flex-wrap gap-2 gap-sm-3 mb-2" style="font-size: 0.75rem;">
                        <span class="d-flex align-items-center gap-1 text-muted">
                            <span style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%; display: inline-block;"></span> Courses
                        </span>
                        <span class="d-flex align-items-center gap-1 text-muted">
                            <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block;"></span> Services
                        </span>
                        <span class="d-flex align-items-center gap-1 text-muted">
                            <span style="width: 8px; height: 8px; background: #f97316; border-radius: 50%; display: inline-block;"></span> Products
                        </span>
                        <span class="d-flex align-items-center gap-1 text-muted">
                            <span style="width: 8px; height: 8px; background: #a855f7; border-radius: 50%; display: inline-block;"></span> Others
                        </span>
                    </div>

                    <!-- Canvas -->
                    <div class="flex-grow-1" style="min-height: 220px; position: relative;">
                        <canvas id="salesOverviewChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- 2. Category Performance (Donut Chart) -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="display-heading fw-bold text-dark mb-3" style="font-size: 1.1rem;">Category Performance</h5>

                    <!-- Donut Container with Center Overlay -->
                    <div class="dc-donut-container my-1">
                        <canvas id="categoryDonutChart"></canvas>
                        <div class="dc-donut-center">
                            <div class="display-heading fw-bold text-dark" style="font-size: 1.15rem; line-height: 1.1;">₹{{ number_format($stats['total_earnings']) }}</div>
                            <span class="text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.04em;">Total Earnings</span>
                        </div>
                    </div>

                    <!-- Legend & Percentages List -->
                    <div class="mt-3 pt-2 border-top small" style="font-size: 0.75rem;">
                        <div class="d-flex justify-content-between align-items-center py-1">
                            <span class="d-flex align-items-center gap-1 text-muted">
                                <span style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%; display: inline-block;"></span> Courses
                            </span>
                            <div>
                                <strong class="text-dark">40%</strong>
                                <span class="text-muted ms-1" style="font-size: 0.7rem;">₹19,328</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-1">
                            <span class="d-flex align-items-center gap-1 text-muted">
                                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block;"></span> Services
                            </span>
                            <div>
                                <strong class="text-dark">28%</strong>
                                <span class="text-muted ms-1" style="font-size: 0.7rem;">₹13,530</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-1">
                            <span class="d-flex align-items-center gap-1 text-muted">
                                <span style="width: 8px; height: 8px; background: #f97316; border-radius: 50%; display: inline-block;"></span> Products
                            </span>
                            <div>
                                <strong class="text-dark">22%</strong>
                                <span class="text-muted ms-1" style="font-size: 0.7rem;">₹10,630</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-1">
                            <span class="d-flex align-items-center gap-1 text-muted">
                                <span style="width: 8px; height: 8px; background: #a855f7; border-radius: 50%; display: inline-block;"></span> Business Listing
                            </span>
                            <div>
                                <strong class="text-dark">10%</strong>
                                <span class="text-muted ms-1" style="font-size: 0.7rem;">₹4,832</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Recent Orders -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.1rem;">Recent Orders</h5>
                        <a href="{{ route('seller.orders.index') }}" class="text-primary text-decoration-none small fw-semibold">View All</a>
                    </div>

                    @if($seller && $seller->orders()->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($seller->orders()->latest('placed_at')->take(5)->get() as $recentOrder)
                                <div class="d-flex align-items-center justify-content-between gap-2 pb-2 border-bottom">
                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 36px; height: 36px; background: #0f172a; color: #38bdf8; font-size: 0.85rem;">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="text-dark fw-bold text-truncate" style="font-size: 0.825rem;">{{ $recentOrder->item_title }}</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $recentOrder->order_type }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end flex-shrink-0">
                                        <div class="fw-bold text-dark" style="font-size: 0.825rem;">₹{{ number_format($recentOrder->amount) }}</div>
                                        <span class="badge rounded-pill fw-semibold" style="background: #dcfce7; color: #16a34a; font-size: 0.65rem;">{{ ucfirst($recentOrder->status) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 my-auto text-muted">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-cart-shopping fs-5 text-secondary opacity-50"></i>
                            </div>
                            <h6 class="text-dark small fw-bold mb-1">No Orders Yet</h6>
                            <p class="text-muted small mb-0">Customer orders will appear here once placed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ================= ROW 4: RECENT REVIEWS + QUICK ACTIONS + PLATFORM ANNOUNCEMENTS ================= -->
        <div class="row g-4 mb-4">
            <!-- 1. Recent Reviews -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.1rem;">Recent Reviews</h5>
                        <a href="#" class="text-primary text-decoration-none small fw-semibold" onclick="notifyComingSoon('Customer Reviews'); return false;">View All</a>
                    </div>

                    <div class="text-center py-5 my-auto text-muted">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px;">
                            <i class="fa-regular fa-star fs-5 text-secondary opacity-50"></i>
                        </div>
                        <h6 class="text-dark small fw-bold mb-1">No Reviews Yet</h6>
                        <p class="text-muted small mb-0">Customer feedback and ratings will appear here.</p>
                    </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="display-heading fw-bold text-dark mb-3" style="font-size: 1.1rem;">Quick Actions</h5>

                    <div class="row g-2">
                        <!-- Action 1: Add New Course -->
                        <div class="col-3">
                            <a href="{{ route('seller.courses.create') }}" class="dc-quick-action-btn">
                                <div class="dc-quick-action-icon" style="background: #fee2e2; color: #dc2626;">
                                    <i class="fa-brands fa-youtube"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Add New Course</span>
                            </a>
                        </div>

                        <!-- Action 2: Add New Service -->
                        <div class="col-3">
                            <a href="{{ route('seller.services.create') }}" class="dc-quick-action-btn">
                                <div class="dc-quick-action-icon" style="background: #dbeafe; color: #0284c7;">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Add New Service</span>
                            </a>
                        </div>

                        <!-- Action 3: Add New Product -->
                        <div class="col-3">
                            <a href="{{ route('seller.products.create') }}" class="dc-quick-action-btn">
                                <div class="dc-quick-action-icon" style="background: #dcfce7; color: #16a34a;">
                                    <i class="fa-solid fa-cube"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Add New Product</span>
                            </a>
                        </div>

                        <!-- Action 4: Update Business -->
                        <div class="col-3">
                            <a href="{{ route('seller.listings.create') }}" class="dc-quick-action-btn">
                                <div class="dc-quick-action-icon" style="background: #f3e8ff; color: #9333ea;">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Update Business</span>
                            </a>
                        </div>

                        <!-- Action 5: Orders -->
                        <div class="col-3">
                            <a href="{{ route('seller.orders.index') }}" class="dc-quick-action-btn">
                                <div class="dc-quick-action-icon" style="background: #e0f2fe; color: #2563eb;">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Orders</span>
                            </a>
                        </div>

                        <!-- Action 6: Coupons -->
                        <div class="col-3">
                            <a href="#" class="dc-quick-action-btn" onclick="notifyComingSoon('Coupons & Discounts'); return false;">
                                <div class="dc-quick-action-icon" style="background: #ffedd5; color: #ea580c;">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Coupons</span>
                            </a>
                        </div>

                        <!-- Action 7: Promotions -->
                        <div class="col-3">
                            <a href="#" class="dc-quick-action-btn" onclick="notifyComingSoon('Promotions'); return false;">
                                <div class="dc-quick-action-icon" style="background: #e0e7ff; color: #4f46e5;">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Promotions</span>
                            </a>
                        </div>

                        <!-- Action 8: Reports -->
                        <div class="col-3">
                            <a href="#" class="dc-quick-action-btn" onclick="notifyComingSoon('Reports & Analytics'); return false;">
                                <div class="dc-quick-action-icon" style="background: #f1f5f9; color: #475569;">
                                    <i class="fa-solid fa-chart-column"></i>
                                </div>
                                <span class="fw-semibold text-center" style="font-size: 0.65rem; line-height: 1.2;">Reports</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Platform Announcements -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="display-heading fw-bold text-dark mb-0" style="font-size: 1.1rem;">Platform Announcements</h5>
                        <a href="#" class="text-primary text-decoration-none small fw-semibold" onclick="notifyComingSoon('Platform Announcements'); return false;">View All</a>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <!-- Announcement 1 -->
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-start gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 34px; height: 34px; background: #f3e8ff; color: #9333ea;">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div class="overflow-hidden flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.85rem;">New Seller Verification Process</h6>
                                        <small class="text-muted" style="font-size: 0.7rem;">Oct 28, 2026</small>
                                    </div>
                                    <p class="text-secondary small mb-0" style="font-size: 0.75rem; line-height: 1.35;">
                                        Complete your KYC to get higher visibility and customer trust badge on all listings.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Announcement 2 -->
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-start gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 34px; height: 34px; background: #ffedd5; color: #ea580c;">
                                    <i class="fa-solid fa-gift"></i>
                                </div>
                                <div class="overflow-hidden flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.85rem;">Festival Sale Campaign</h6>
                                        <small class="text-muted" style="font-size: 0.7rem;">Oct 25, 2026</small>
                                    </div>
                                    <p class="text-secondary small mb-0" style="font-size: 0.75rem; line-height: 1.35;">
                                        Join the Diwali festival campaign and get featured across our homepage banner carousel.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Stacked Bar Chart for Sales Overview
        const salesCanvas = document.getElementById('salesOverviewChart');
        if (salesCanvas) {
            const ctxSales = salesCanvas.getContext('2d');
            new Chart(ctxSales, {
                type: 'bar',
                data: {
                    labels: ['Oct 1', 'Oct 5', 'Oct 10', 'Oct 15', 'Oct 20', 'Oct 25', 'Oct 31'],
                    datasets: [
                        {
                            label: 'Courses',
                            data: [3200, 4800, 3600, 6200, 4500, 7400, 5900],
                            backgroundColor: '#3b82f6',
                            borderRadius: 4,
                            stack: 'salesStack'
                        },
                        {
                            label: 'Services',
                            data: [2100, 2900, 2000, 3900, 3000, 4300, 3600],
                            backgroundColor: '#10b981',
                            borderRadius: 4,
                            stack: 'salesStack'
                        },
                        {
                            label: 'Products',
                            data: [1600, 2200, 1700, 3000, 2200, 3200, 2700],
                            backgroundColor: '#f97316',
                            borderRadius: 4,
                            stack: 'salesStack'
                        },
                        {
                            label: 'Others',
                            data: [800, 1100, 900, 1500, 1200, 1600, 1400],
                            backgroundColor: '#a855f7',
                            borderRadius: 4,
                            stack: 'salesStack'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₹' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false },
                            ticks: { font: { size: 10, family: "'Plus Jakarta Sans', sans-serif" } }
                        },
                        y: {
                            stacked: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(val) {
                                    return '₹' + (val / 1000) + 'K';
                                },
                                font: { size: 10, family: "'Plus Jakarta Sans', sans-serif" }
                            }
                        }
                    }
                }
            });
        }

        // 2. Donut Chart for Category Performance
        const donutCanvas = document.getElementById('categoryDonutChart');
        if (donutCanvas) {
            const ctxDonut = donutCanvas.getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: ['Courses', 'Services', 'Products', 'Business Listing'],
                    datasets: [{
                        data: [40, 28, 22, 10],
                        backgroundColor: ['#3b82f6', '#10b981', '#f97316', '#a855f7'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
