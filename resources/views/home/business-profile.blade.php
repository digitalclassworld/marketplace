@extends('layouts.app')

@section('title', ($business->business_name ?? 'Institute') . ' - Courses, Fees & Admission')

@section('meta_description', Str::limit(strip_tags($business->description ?? ($business->business_name . ' coaching institute')), 160))

@section('styles')
<style>
    /* Legacy-matched authentic institute profile styling */
    .institute-profile-wrapper {
        background-color: #f8fafc;
        min-height: calc(100vh - 120px);
    }
    .profile-breadcrumb {
        font-size: 0.85rem;
        color: #64748b;
    }
    .profile-breadcrumb a {
        color: #0284c7;
        text-decoration: none;
        transition: color 0.15s;
    }
    .profile-breadcrumb a:hover {
        color: #0369a1;
        text-decoration: underline;
    }
    .profile-breadcrumb .sep {
        margin: 0 0.4rem;
        color: #94a3b8;
    }

    /* Main Header Card */
    .institute-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        position: relative;
        overflow: hidden;
    }
    .institute-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0066ff 0%, #00d2ff 50%, #10b981 100%);
    }
    .institute-logo-box {
        width: 190px;
        height: 160px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        margin-bottom: 0.85rem;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease;
    }
    .institute-logo-box:hover {
        transform: scale(1.02);
    }
    .institute-logo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .btn-send-inquiry {
        background: linear-gradient(135deg, #0097a7 0%, #00838f 100%);
        color: #ffffff;
        border: none;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.65rem 1.25rem;
        width: 190px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 151, 167, 0.25);
    }
    .btn-send-inquiry:hover {
        background: linear-gradient(135deg, #00838f 0%, #006064 100%);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 151, 167, 0.35);
    }
    .institute-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin: 0;
    }
    .btn-claim-business {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 4px;
        transition: all 0.15s;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-claim-business:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .institute-category-sub {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0.35rem 0 0.5rem;
    }
    .institute-tagline {
        font-size: 0.875rem;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 0.65rem;
    }
    .institute-meta-item {
        font-size: 0.875rem;
        color: #1e293b;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .institute-meta-item a {
        text-decoration: none;
    }
    .institute-meta-item a:hover {
        text-decoration: underline;
    }

    /* Social Share Buttons */
    .share-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: #ffffff !important;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 4px;
        text-decoration: none;
        transition: opacity 0.15s;
    }
    .share-pill:hover {
        opacity: 0.9;
    }
    .share-fb { background-color: #3b5998; }
    .share-tw { background-color: #000000; }
    .share-pin { background-color: #bd081c; }
    .share-wa { background-color: #25d366; }
    .share-in { background-color: #0077b5; }

    /* Navigation Tabs */
    .institute-tabs-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.35rem 0.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .institute-tabs-bar .nav-link {
        color: #475569;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.55rem 1.1rem;
        border-radius: 6px;
        border: none;
        background: transparent;
        transition: all 0.15s;
    }
    .institute-tabs-bar .nav-link:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .institute-tabs-bar .nav-link.active {
        background-color: #e0f2fe;
        color: #0284c7;
        font-weight: 700;
    }

    /* Tab Content Section */
    .tab-content-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .section-accent-header {
        position: relative;
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
    }
    .section-accent-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: #0066ff;
        border-radius: 2px;
    }

    /* Course Cards */
    .course-card-authentic {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.15s, box-shadow 0.15s;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .course-card-authentic:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    .course-thumb-box {
        height: 150px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-bottom: 1px solid #f1f5f9;
    }
    .course-thumb-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .course-body-authentic {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .course-title-authentic {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.4rem;
        line-height: 1.35;
    }

    /* Sidebar Related Institutes */
    .sidebar-widget-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .sidebar-widget-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .related-institute-item {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    .related-institute-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .related-logo-box {
        width: 120px;
        height: 90px;
        margin: 0 auto 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
    }
    .related-logo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .related-name {
        font-size: 0.92rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .btn-view-more {
        background-color: #00a65a;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.82rem;
        padding: 0.4rem 1rem;
        border-radius: 4px;
        display: inline-block;
        width: 100%;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.15s;
    }
    .btn-view-more:hover {
        background-color: #008d4c;
    }

    /* Gallery Grid */
    .gallery-img-box {
        height: 180px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        cursor: pointer;
        transition: transform 0.15s;
    }
    .gallery-img-box:hover {
        transform: scale(1.02);
    }
    .gallery-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .institute-header-card {
            padding: 1.25rem 1rem;
            border-radius: 14px;
        }
        .institute-header-flex {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }
        .institute-title {
            font-size: 1.45rem;
        }
        .institute-logo-box {
            width: 140px;
            height: 130px;
            margin: 0 auto 0.75rem;
        }
        .btn-send-inquiry {
            width: 100%;
            max-width: 280px;
            margin: 0 auto 1.25rem;
        }
        .institute-meta-item {
            justify-content: center;
            text-align: center;
            font-size: 0.8rem;
        }
        .institute-tabs-bar {
            padding: 4px;
            overflow-x: auto;
        }
        .course-thumb-box {
            height: 140px;
        }
    }
</style>
@endsection

@section('content')
<div class="institute-profile-wrapper py-3">
    <div class="container">
        <!-- 1. BREADCRUMBS -->
        <div class="profile-breadcrumb mb-3">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
            <span class="sep">&gt;</span>
            <a href="{{ route('businesses') }}">Coaching Institutes</a>
            <span class="sep">&gt;</span>
            @php
                $displayState = $business->state ?: 'Gujarat';
                $displayCity = $business->city ?: 'Ahmedabad';
            @endphp
            <a href="{{ route('businesses', ['state' => $displayState]) }}">{{ $displayState }}</a>
            <span class="sep">&gt;</span>
            <a href="{{ route('businesses', ['city' => $displayCity]) }}">{{ $displayCity }}</a>
            <span class="sep">&gt;</span>
            <span class="text-dark fw-bold">{{ $business->business_name }}</span>
        </div>

        <!-- 2. MAIN INSTITUTE HEADER CARD -->
        <div class="institute-header-card mb-4">
            <div class="d-flex institute-header-flex align-items-start gap-4">
                <!-- Left Column: Logo & Send Inquiry Button -->
                <div class="flex-shrink-0 text-center">
                    <div class="institute-logo-box">
                        @if(!empty($business->logo))
                            <img src="{{ $business->logo }}" alt="{{ $business->business_name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=300&auto=format&fit=crop&q=80';">
                        @else
                            <div class="text-center text-muted">
                                <i class="fa-solid fa-building-columns fa-3x mb-2 text-primary"></i>
                                <div class="fw-bold small">{{ Str::limit($business->business_name, 15) }}</div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-send-inquiry" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                        <i class="fa-solid fa-circle-info"></i> Send Inquiry
                    </button>

                    @if($business->hasHighSupport())
                        <div class="mt-3 p-2.5 rounded-3 border bg-light text-start shadow-2xs" style="max-width: 220px;">
                            <div class="d-flex align-items-center gap-1.5 text-success fw-bold small mb-1">
                                <i class="fa-solid fa-shield-halved"></i> High Support
                            </div>
                            <div class="text-secondary small" style="font-size: 0.72rem; line-height: 1.35;">
                                This verified premium business provides dedicated high priority customer support & quick response.
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Details & Social Share -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-1">
                        <h1 class="institute-title mb-0">{{ $business->business_name }}</h1>
                        <button type="button" class="btn-claim-business" data-bs-toggle="modal" data-bs-target="#claimModal">
                            Claim This Business
                        </button>
                    </div>

                    @if($business->hasHighSupport())
                        <div class="d-flex align-items-center gap-2 my-2 flex-wrap">
                            <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-crown me-1"></i> Premium Business
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-headset me-1"></i> High Support Included
                            </span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-bolt me-1"></i> Top Suggested
                            </span>
                        </div>
                    @endif

                    <!-- Category & Subcategory -->
                    <div class="institute-category-sub">
                        {{ $business->category ?? 'Coaching Institute' }}
                        @if(!empty($business->sub_category))
                            ({{ $business->sub_category }})
                        @endif
                    </div>

                    <!-- Tagline / Short Description -->
                    <div class="institute-tagline">
                        {{ $business->tagline ?: Str::limit(strip_tags($business->description), 160) }}
                    </div>

                    <!-- Address -->
                    <div class="institute-meta-item">
                        <i class="fa-solid fa-location-dot text-danger mt-1"></i>
                        <span>
                            {{ $business->address ?: ($business->city . ', ' . $business->state . ' India') }}
                            <span class="text-danger ms-1">📍</span>
                        </span>
                    </div>

                    <!-- Phone Number -->
                    @if(!empty($business->phone))
                        <div class="institute-meta-item">
                            <i class="fa-solid fa-phone mt-1" style="color: #e91e63;"></i>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $business->phone) }}" class="fw-bold text-dark">
                                {{ $business->phone }}
                            </a>
                        </div>
                    @endif

                    <!-- Email -->
                    @if(!empty($business->email))
                        <div class="institute-meta-item">
                            <i class="fa-solid fa-envelope text-info mt-1"></i>
                            <a href="mailto:{{ $business->email }}" class="text-secondary">
                                {{ $business->email }}
                            </a>
                        </div>
                    @endif

                    <!-- Website URL -->
                    @if(!empty($business->website) && strtolower($business->website) !== 'n/a')
                        <div class="institute-meta-item">
                            <i class="fa-solid fa-globe text-primary mt-1"></i>
                            <a href="{{ Str::startsWith($business->website, 'http') ? $business->website : 'https://' . $business->website }}" target="_blank" rel="noopener" class="text-primary">
                                {{ $business->website }}
                            </a>
                        </div>
                    @endif

                    <!-- Social Share Buttons -->
                    <div class="d-flex align-items-center gap-2 mt-3 pt-2 border-top flex-wrap">
                        <span class="fw-bold text-dark small me-1">Share on</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="share-pill share-fb">
                            <i class="fa-brands fa-facebook-f"></i> Share
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($business->business_name) }}" target="_blank" rel="noopener" class="share-pill share-tw">
                            <i class="fa-brands fa-x-twitter"></i> Post
                        </a>
                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ urlencode($business->business_name) }}" target="_blank" rel="noopener" class="share-pill share-pin">
                            <i class="fa-brands fa-pinterest"></i> Pin
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($business->business_name . ' - ' . url()->current()) }}" target="_blank" rel="noopener" class="share-pill share-wa">
                            <i class="fa-brands fa-whatsapp"></i> Share
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="share-pill share-in">
                            <i class="fa-brands fa-linkedin-in"></i> Share
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. NAVIGATION TABS BAR -->
        <div class="institute-tabs-bar mb-4">
            <ul class="nav nav-pills border-0 gap-1 w-100 no-scrollbar" id="profileTabs" role="tablist" style="overflow-x: auto; flex-wrap: nowrap;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(count($courses) == 0) active @endif" id="overview-tab" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if(count($courses) > 0) active @endif" id="courses-tab" data-bs-toggle="pill" data-bs-target="#tab-courses" type="button" role="tab">
                        Courses @if(count($courses) > 0)<span class="badge rounded-pill bg-primary ms-1">{{ count($courses) }}</span>@endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="pill" data-bs-target="#tab-gallery" type="button" role="tab">
                        Gallary @if(count($galleryImages) > 0)<span class="badge rounded-pill bg-secondary ms-1">{{ count($galleryImages) }}</span>@endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="faqs-tab" data-bs-toggle="pill" data-bs-target="#tab-faqs" type="button" role="tab">FAQ's</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="faculty-tab" data-bs-toggle="pill" data-bs-target="#tab-faculty" type="button" role="tab">
                        Faculty @if(count($staffMembers) > 0)<span class="badge rounded-pill bg-secondary ms-1">{{ count($staffMembers) }}</span>@endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="portfolio-tab" data-bs-toggle="pill" data-bs-target="#tab-portfolio" type="button" role="tab">
                        Portfolio @if(count($portfolios) > 0)<span class="badge rounded-pill bg-secondary ms-1">{{ count($portfolios) }}</span>@endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="blogs-tab" data-bs-toggle="pill" data-bs-target="#tab-blogs" type="button" role="tab">
                        Blogs @if(count($articles) > 0)<span class="badge rounded-pill bg-secondary ms-1">{{ count($articles) }}</span>@endif
                    </button>
                </li>
            </ul>
        </div>

        <!-- 4. TWO-COLUMN MAIN BODY (Tabs Content Left + Related Institutes Right) -->
        <div class="row g-4">
            <!-- Left Main Column (approx 72%) -->
            <div class="col-lg-8">
                <div class="tab-content" id="profileTabsContent">

                    <!-- TAB: COURSES -->
                    <div class="tab-pane fade @if(count($courses) > 0) show active @endif" id="tab-courses" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">Courses</h2>
                            @if(!empty($courses) && count($courses) > 0)
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    @foreach($courses as $course)
                                        <div class="col">
                                            <div class="course-card-authentic">
                                                <div class="course-thumb-box">
                                                    @if(!empty($course['url']))
                                                        <a href="{{ $course['url'] }}" class="d-block w-100 h-100 text-decoration-none">
                                                    @endif
                                                    @if(!empty($course['thumbnail']))
                                                        <img src="{{ $course['thumbnail'] }}" alt="{{ $course['title'] }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';">
                                                    @else
                                                        <div class="text-center text-primary py-3">
                                                            <i class="fa-solid fa-graduation-cap fa-3x mb-1"></i>
                                                            <div class="fw-bold small">{{ $course['title'] }}</div>
                                                        </div>
                                                    @endif
                                                    @if(!empty($course['url']))
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="course-body-authentic">
                                                    <h3 class="course-title-authentic">
                                                        @if(!empty($course['url']))
                                                            <a href="{{ $course['url'] }}" class="text-dark text-decoration-none hover-primary">{{ $course['title'] }}</a>
                                                        @else
                                                            {{ $course['title'] }}
                                                        @endif
                                                    </h3>
                                                    <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                                                        <span><i class="fa-regular fa-clock text-primary me-1"></i> {{ $course['duration'] ?? '3 Months' }}</span>
                                                        <span>&bull;</span>
                                                        <span><i class="fa-solid fa-chalkboard-user text-success me-1"></i> {{ $course['mode'] ?? 'Offline/Online' }}</span>
                                                    </div>
                                                    @if(!empty($course['description']))
                                                        <p class="small text-muted mb-3" style="line-height: 1.4;">
                                                            {{ Str::limit(strip_tags($course['description']), 100) }}
                                                        </p>
                                                    @endif
                                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                                        <div class="fw-bold text-dark">
                                                            @if(!empty($course['price']) && $course['price'] > 0)
                                                                ₹{{ number_format($course['price']) }}
                                                            @else
                                                                <span class="badge bg-success-subtle text-success">Free / Inquire</span>
                                                            @endif
                                                        </div>
                                                        @if(!empty($course['url']))
                                                            <a href="{{ $course['url'] }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-semibold">
                                                                View Details
                                                            </a>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#inquiryModal" onclick="document.getElementById('inquiryCourseField').value='{{ addslashes($course['title']) }}'">
                                                                Inquire Now
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="fs-4 fw-bold text-secondary mb-2">Data Not Updated</div>
                                    <p class="small text-muted mb-3">Courses and syllabus have not been updated by the institute yet.</p>
                                    <button type="button" class="btn btn-primary btn-sm px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                                        <i class="fa-solid fa-envelope me-1"></i> Send Course Inquiry
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- TAB: OVERVIEW -->
                    <div class="tab-pane fade @if(count($courses) == 0) show active @endif" id="tab-overview" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">About {{ $business->business_name }}</h2>
                            <div class="institute-full-description mb-4 text-secondary" style="font-size: 0.92rem; line-height: 1.7; white-space: pre-line;">
                                {{ $business->description ?: ($business->business_name . ' is an educational coaching institute dedicated to quality guidance and training in ' . ($business->city ?: 'Ahmedabad') . ', ' . ($business->state ?: 'Gujarat') . '.') }}
                            </div>

                            <!-- Key Information Overview Table -->
                            <h3 class="h5 fw-bold text-dark mb-3">Key Information</h3>
                            <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Category</div>
                                        <div class="fw-bold text-dark">{{ $business->category ?? 'Coaching Institute' }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Specialization / Subcategory</div>
                                        <div class="fw-bold text-dark">{{ $business->sub_category ?: 'General' }}</div>
                                    </div>
                                </div>
                                @if(!empty($affiliate->since))
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Established Year</div>
                                        <div class="fw-bold text-dark">{{ $affiliate->since }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($affiliate->total_students))
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Students Enrolled</div>
                                        <div class="fw-bold text-dark">{{ $affiliate->total_students }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($affiliate->language_known))
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Languages of Instruction</div>
                                        <div class="fw-bold text-dark">{{ $affiliate->language_known }}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($affiliate->payment_mode))
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Payment Modes</div>
                                        <div class="fw-bold text-dark">{{ $affiliate->payment_mode }}</div>
                                    </div>
                                </div>
                                @endif
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Location</div>
                                        <div class="fw-bold text-dark">{{ $business->city ?: 'Ahmedabad' }}, {{ $business->state ?: 'Gujarat' }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <div class="text-muted small">Verification</div>
                                        <div class="fw-bold text-success"><i class="fa-solid fa-circle-check"></i> Verified Profile</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: GALLERY -->
                    <div class="tab-pane fade" id="tab-gallery" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">Photo Gallery</h2>
                            @if(!empty($galleryImages) && count($galleryImages) > 0)
                                <div class="row row-cols-2 row-cols-md-3 g-3">
                                    @foreach($galleryImages as $img)
                                        <div class="col">
                                            <div class="gallery-img-box" onclick="window.open('{{ $img->image }}', '_blank')">
                                                <img src="{{ $img->image }}" alt="{{ $business->business_name }} Photo" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80';">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="fs-4 fw-bold text-secondary mb-2">Data Not Updated</div>
                                    <p class="small text-muted">Photos have not been updated by the institute yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- TAB: FAQS -->
                    <div class="tab-pane fade" id="tab-faqs" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">Frequently Asked Questions</h2>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            How do I enroll in courses at {{ $business->business_name }}?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-secondary small">
                                            You can click the <strong>"Send Inquiry"</strong> button above, or call {{ $business->phone ?: 'the institute' }} directly to check batch timings, admission requirements, and registration procedure.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Are demo classes offered before admission?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-secondary small">
                                            Yes, demo sessions and counseling consultations are available. Please submit an inquiry with your preferred course to schedule your session.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            What are the accepted payment methods?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-secondary small">
                                            {{ $affiliate->payment_mode ?? 'Cash, UPI, Debit/Credit Card, and Online Net Banking' }} are generally accepted for course fee installments.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: FACULTY -->
                    <div class="tab-pane fade" id="tab-faculty" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">Faculty & Instructors</h2>
                            @if(!empty($staffMembers) && count($staffMembers) > 0)
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    @foreach($staffMembers as $staff)
                                        <div class="col">
                                            <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    @if(!empty($staff->profile))
                                                        <img src="{{ $staff->profile }}" class="rounded-circle" style="width: 55px; height: 55px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; font-weight: bold; font-size: 1.2rem;">
                                                            {{ strtoupper(substr($staff->name ?? 'F', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $staff->name }}</div>
                                                    <div class="small text-muted">{{ $staff->designation ?? 'Faculty Instructor' }}</div>
                                                    @if(!empty($staff->experience))
                                                        <div class="small text-secondary">{{ $staff->experience }} Experience</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="fs-4 fw-bold text-secondary mb-2">Data Not Updated</div>
                                    <p class="small text-muted">Faculty profiles have not been updated by the institute yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- TAB: PORTFOLIO -->
                    <div class="tab-pane fade" id="tab-portfolio" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">Portfolio & Achievements</h2>
                            @if(!empty($portfolios) && count($portfolios) > 0)
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    @foreach($portfolios as $p)
                                        <div class="col">
                                            <div class="p-3 border rounded-3 bg-white">
                                                <div class="fw-bold text-dark">{{ $p->title }}</div>
                                                @if(!empty($p->total_number))
                                                    <div class="badge bg-primary-subtle text-primary mt-1">{{ $p->total_number }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="fs-4 fw-bold text-secondary mb-2">Data Not Updated</div>
                                    <p class="small text-muted">Portfolio items have not been updated by the institute yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- TAB: BLOGS -->
                    <div class="tab-pane fade" id="tab-blogs" role="tabpanel">
                        <div class="tab-content-card">
                            <h2 class="section-accent-header">Articles & Updates</h2>
                            @if(!empty($articles) && count($articles) > 0)
                                <div class="row row-cols-1 g-3">
                                    @foreach($articles as $art)
                                        <div class="col">
                                            <div class="p-3 border rounded-3 bg-white">
                                                <h4 class="h6 fw-bold text-dark mb-1">{{ $art->title }}</h4>
                                                <p class="small text-muted mb-0">{{ Str::limit(strip_tags($art->description ?? ''), 140) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="fs-4 fw-bold text-secondary mb-2">Data Not Updated</div>
                                    <p class="small text-muted">Articles and news have not been updated by the institute yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Sidebar: Related Institutes + Quick Inquiry (approx 28%) -->
            <div class="col-lg-4">
                <!-- Related Institutes Widget -->
                <div class="sidebar-widget-card">
                    <h3 class="sidebar-widget-title">Related Institutes</h3>
                    @if(!empty($relatedInstitutes) && count($relatedInstitutes) > 0)
                        @foreach($relatedInstitutes as $rel)
                            <div class="related-institute-item">
                                <div class="related-logo-box">
                                    @if(!empty($rel->logo))
                                        <img src="{{ $rel->logo }}" alt="{{ $rel->business_name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=200&auto=format&fit=crop&q=80';">
                                    @else
                                        <i class="fa-solid fa-graduation-cap fa-2x text-primary"></i>
                                    @endif
                                </div>
                                <div class="related-name">{{ $rel->business_name }}</div>
                                <a href="{{ $rel->url ?: url('/business-listing/coaching/' . $rel->clean_slug) }}" class="btn-view-more">
                                    View More
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3 small">
                            Explore other certified coaching institutes in {{ $displayCity }}.
                        </div>
                    @endif
                </div>

                <!-- Instant Inquiry Widget -->
                <div class="sidebar-widget-card">
                    <h3 class="sidebar-widget-title">Send Instant Inquiry</h3>
                    <form action="{{ route('business.enquiry') }}" method="POST">
                        @csrf
                        <input type="hidden" name="business_id" value="{{ $business->id }}">
                        <div class="mb-2">
                            <label class="form-label small fw-bold mb-1">Your Full Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold mb-1">Contact Phone</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="Enter 10-digit mobile number" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold mb-1">Select Course / Topic</label>
                            <input type="text" name="course" id="inquiryCourseField" class="form-control form-control-sm" placeholder="e.g. {{ $courses[0]['title'] ?? $business->category }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold mb-1">Message / Question</label>
                            <textarea name="message" rows="3" class="form-control form-control-sm" placeholder="Ask about fees, upcoming batch, duration, etc."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-sm fw-bold py-2 rounded-2">
                            <i class="fa-solid fa-paper-plane me-1"></i> Submit Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Send Inquiry -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fa-solid fa-envelope-open-text text-primary me-2"></i> Inquiry for {{ $business->business_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('business.enquiry') }}" method="POST">
                @csrf
                <input type="hidden" name="business_id" value="{{ $business->id }}">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Your Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Mobile Phone Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="Enter 10-digit mobile number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Interested Course / Program</label>
                        <input type="text" name="course" class="form-control" placeholder="Course name (e.g. {{ $courses[0]['title'] ?? $business->category }})">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Message / Query</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Tell us what you are looking for (batch timings, fees, demo class)"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Send Inquiry Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Claim This Business -->
<div class="modal fade" id="claimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fa-solid fa-award text-warning me-2"></i> Claim {{ $business->business_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('seller.register') }}" method="GET">
                <div class="modal-body p-4">
                    <p class="text-secondary small mb-3">
                        Are you the owner, director, or authorized manager of <strong>{{ $business->business_name }}</strong>?
                    </p>
                    <p class="text-secondary small mb-0">
                        Create a verified Seller / Institute account to manage this profile, update course details, upload photos, and receive student inquiries directly to your dashboard.
                    </p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('seller.register') }}" class="btn btn-success btn-sm px-4 fw-bold">
                        Continue to Claim &rarr;
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
