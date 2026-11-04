@extends('layouts.app')

@section('title', ($business->business_name ?? 'VCEC - Vinayak Computer Education Center') . ' - Digital Class')

@section('styles')
<style>
    /* Breadcrumb styling */
    .profile-breadcrumb {
        font-size: 0.75rem;
        background: transparent;
        padding: 0.75rem 0 0.5rem;
        color: #64748b;
    }
    .profile-breadcrumb a {
        color: #64748b;
        text-decoration: none;
    }
    .profile-breadcrumb a:hover {
        color: #0066ff;
    }

    /* Top Photo Collage Banner */
    .gallery-collage-banner {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #0f172a;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }

    .collage-grid {
        display: grid;
        grid-template-columns: 1.3fr 1.1fr 1fr 1.1fr 1.3fr;
        height: 190px;
        gap: 3px;
        background: #0b1329;
    }
    @media (max-width: 991px) {
        .collage-grid {
            grid-template-columns: 1fr 1fr;
            height: 160px;
        }
        .collage-col-hide-mobile {
            display: none;
        }
    }

    .collage-item {
        position: relative;
        height: 100%;
        overflow: hidden;
    }
    .collage-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .collage-item:hover img {
        transform: scale(1.05);
    }

    .collage-banner-card {
        background: radial-gradient(circle at 50% 50%, #0e1e38 0%, #060d1a 100%);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 0.85rem;
    }

    .skill-today-text {
        font-family: 'Outfit', sans-serif;
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #ffffff;
        line-height: 1.2;
    }
    .better-tomorrow-text {
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #38bdf8;
        margin-bottom: 0.65rem;
    }

    .feature-bullets-mini {
        display: flex;
        gap: 0.5rem;
        font-size: 0.58rem;
        color: #94a3b8;
    }
    .feature-bullets-mini span {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }

    .specialties-card-dark {
        background: #0b1528;
        color: #cbd5e1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0.85rem 1rem;
        font-size: 0.65rem;
        font-weight: 600;
        line-height: 1.6;
        letter-spacing: 0.04em;
        position: relative;
    }

    .photos-counter-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        border: 1px solid rgba(255,255,255,0.2);
        cursor: pointer;
        backdrop-filter: blur(4px);
    }
    .photos-counter-badge:hover {
        background: #0066ff;
    }

    /* Profile Header Box */
    .profile-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .business-logo-sq {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        background: #ffffff;
        padding: 4px;
        flex-shrink: 0;
    }

    .business-name-lg {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .badge-verified-pill {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
        font-size: 0.68rem;
        font-weight: 700;
        border-radius: 999px;
        padding: 0.15rem 0.55rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .meta-tag-line {
        font-size: 0.75rem;
        color: #64748b;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.85rem;
        margin-top: 0.35rem;
    }

    /* Action Buttons in Profile Header */
    .btn-profile-action {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.5rem 0.85rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-profile-call {
        background-color: #0066ff;
        color: #ffffff;
        border: 1px solid #0066ff;
    }
    .btn-profile-call:hover {
        background-color: #0052cc;
        color: #ffffff;
    }

    .btn-profile-wa {
        background-color: #25d366;
        color: #ffffff;
        border: 1px solid #25d366;
    }
    .btn-profile-wa:hover {
        background-color: #20ba59;
        color: #ffffff;
    }

    .btn-profile-enquiry {
        background-color: #0052cc;
        color: #ffffff;
        border: 1px solid #0052cc;
    }
    .btn-profile-enquiry:hover {
        background-color: #003d99;
        color: #ffffff;
    }

    .btn-profile-outline {
        background-color: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .btn-profile-outline:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }

    /* Navigation Tabs */
    .profile-nav-tabs-wrapper {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0 1rem;
        margin-bottom: 1.25rem;
        overflow-x: auto;
        white-space: nowrap;
    }

    .profile-tab-item {
        display: inline-block;
        padding: 0.75rem 1rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: all 0.15s;
    }
    .profile-tab-item:hover {
        color: #0066ff;
    }
    .profile-tab-item.active {
        color: #0066ff;
        border-bottom-color: #0066ff;
    }

    /* About Box & Stat Pills */
    .content-box-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem 1.4rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .box-title-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
    }

    .box-main-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.01em;
        margin-bottom: 0;
    }

    .highlight-pill-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .highlight-pill-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.45rem 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.72rem;
        font-weight: 700;
        color: #334155;
    }

    .video-tour-box {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        min-height: 140px;
        background: #0f172a;
        cursor: pointer;
    }
    .video-tour-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.85;
        transition: transform 0.3s ease, opacity 0.3s;
    }
    .video-tour-box:hover img {
        transform: scale(1.04);
        opacity: 0.95;
    }

    .play-tour-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        right: 10px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Course Mini Cards in Profile */
    .course-mini-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.15s, box-shadow 0.15s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .course-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }

    .course-mini-thumb {
        height: 100px;
        width: 100%;
        object-fit: cover;
    }

    .course-mini-body {
        padding: 0.65rem 0.75rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .course-mini-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
        line-height: 1.25;
        height: 2.5em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Service Tiles Row */
    .service-tile-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 0.75rem;
        text-align: center;
        transition: all 0.15s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .service-tile-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.04);
        border-color: #0066ff;
    }

    .service-tile-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-bottom: 0.45rem;
    }

    /* Testimonial Review Cards */
    .review-bubble-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Right Sidebar Widgets */
    .sidebar-profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .branch-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.75rem;
    }
    .branch-list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .demo-cta-box {
        background: radial-gradient(circle at 100% 0%, #fff7ed 0%, #ffffff 80%);
        border: 1px solid #fed7aa;
        border-radius: 14px;
        padding: 1.15rem;
        text-align: center;
    }
</style>
@endsection

@section('content')

<div class="container-fluid px-lg-4 pb-5">

    <!-- ========================================================================
         1. BREADCRUMBS
         ======================================================================== -->
    <nav class="profile-breadcrumb">
        <a href="{{ route('home') }}">Home</a> &gt; 
        <a href="{{ route('home') }}">Businesses</a> &gt; 
        <a href="{{ route('home', ['category' => 'Education']) }}">Education</a> &gt; 
        <a href="{{ route('home', ['category' => 'Computer Training']) }}">Computer Training Institute</a> &gt; 
        <span class="text-dark fw-semibold">{{ $business->business_name ?? 'VCEC - Vinayak Computer Education Center' }}</span>
    </nav>

    <!-- ========================================================================
         2. TOP PHOTO COLLAGE BANNER
         ======================================================================== -->
    <div class="gallery-collage-banner">
        <div class="collage-grid">
            
            <!-- Photo 1: Lab Students -->
            <div class="collage-item">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=500&auto=format&fit=crop&q=80" alt="VCEC Computer Lab">
            </div>

            <!-- Banner 2: Skill Today Better Tomorrow -->
            <div class="collage-item collage-banner-card">
                <div class="skill-today-text">Skill Today</div>
                <div class="better-tomorrow-text">Better Tomorrow</div>
                <div class="feature-bullets-mini">
                    <span><i class="fa-solid fa-check text-info"></i> Practical</span>
                    <span><i class="fa-solid fa-check text-info"></i> Faculty</span>
                    <span><i class="fa-solid fa-check text-info"></i> Support</span>
                    <span><i class="fa-solid fa-check text-info"></i> Certificate</span>
                </div>
            </div>

            <!-- Photo 3: Faculty Helping Student -->
            <div class="collage-item collage-col-hide-mobile">
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=500&auto=format&fit=crop&q=80" alt="Faculty Mentoring">
            </div>

            <!-- Photo 4: Smiling Students Group -->
            <div class="collage-item collage-col-hide-mobile">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&auto=format&fit=crop&q=80" alt="Students Collaboration">
            </div>

            <!-- Card 5: Dark Specialties + Photos Counter -->
            <div class="collage-item specialties-card-dark">
                <div class="text-white fw-bold mb-1" style="font-size: 0.72rem;">COMPUTER CLASSES</div>
                <div>DIGITAL MARKETING</div>
                <div>TALLY | CCC | PROGRAMMING</div>
                <div>AI COURSES | WEB & APP DEV</div>

                <div class="photos-counter-badge" onclick="openGalleryModal()">
                    <i class="fa-solid fa-camera me-1"></i> +28 Photos
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================================================
         3. PROFILE HEADER BOX
         ======================================================================== -->
    <div class="profile-header-card">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            
            <!-- Left: Logo & Identity -->
            <div class="d-flex align-items-start gap-3">
                <img src="{{ $business->logo ?? 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=160&auto=format&fit=crop&q=80' }}" 
                     alt="VCEC Logo" 
                     class="business-logo-sq">

                <div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <h1 class="business-name-lg mb-0">
                            {{ $business->business_name ?? 'VCEC - Vinayak Computer Education Center' }}
                            <i class="fa-solid fa-circle-check text-primary" style="font-size: 1.05rem;" title="Verified Business"></i>
                        </h1>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
                        <!-- Rating -->
                        <span class="d-inline-flex align-items-center text-warning fw-bold small">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-solid fa-star" style="font-size: 0.75rem;"></i>
                            @endfor
                            <span class="text-dark ms-1" style="font-size: 0.8rem;">4.8</span>
                            <span class="text-muted ms-1" style="font-size: 0.75rem;">(420 reviews)</span>
                        </span>

                        <span class="badge-verified-pill">
                            <i class="fa-solid fa-shield-check"></i> Verified Business
                        </span>

                        <span class="text-muted small" style="font-size: 0.72rem;">
                            <i class="fa-regular fa-clock me-1"></i> Since 2012
                        </span>
                    </div>

                    <!-- Meta details -->
                    <div class="meta-tag-line">
                        <span><i class="fa-solid fa-graduation-cap text-primary me-1"></i> Computer Training Institute</span>
                        <span><i class="fa-solid fa-location-dot text-danger me-1"></i> Nikol, Ahmedabad, Gujarat</span>
                        <span><i class="fa-solid fa-users text-info me-1"></i> 10K+ Students Trained</span>
                    </div>
                </div>
            </div>

            <!-- Right: Action Buttons -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" class="btn-profile-action btn-profile-outline" onclick="toggleSaveProfile(this)">
                    <i class="fa-regular fa-heart text-danger"></i> <span>Save</span>
                </button>
                <button type="button" class="btn-profile-action btn-profile-outline" data-bs-toggle="modal" data-bs-target="#shareModal">
                    <i class="fa-solid fa-share-nodes"></i> <span>Share</span>
                </button>
                <a href="tel:{{ $business->phone ?? '9876543210' }}" class="btn-profile-action btn-profile-call">
                    <i class="fa-solid fa-phone"></i> Call Now
                </a>
                <a href="https://wa.me/{{ $business->whatsapp_number ?? '919876543210' }}?text={{ urlencode('Hello, I am interested in courses at VCEC - Vinayak Computer Education Center via Digital Class.') }}" 
                   target="_blank" 
                   class="btn-profile-action btn-profile-wa">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <button type="button" class="btn-profile-action btn-profile-enquiry" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                    Enquiry
                </button>
            </div>

        </div>
    </div>

    <!-- ========================================================================
         4. NAVIGATION TABS BAR
         ======================================================================== -->
    <div class="profile-nav-tabs-wrapper">
        <a href="#overview" class="profile-tab-item active">Overview</a>
        <a href="#courses" class="profile-tab-item">Courses (12)</a>
        <a href="#services" class="profile-tab-item">Services (5)</a>
        <a href="#photos" class="profile-tab-item" onclick="openGalleryModal(); return false;">Photos (28)</a>
        <a href="#reviews" class="profile-tab-item">Reviews (420)</a>
        <a href="#location" class="profile-tab-item">Location</a>
        <a href="#about" class="profile-tab-item">About</a>
        <a href="#qa" class="profile-tab-item" onclick="alert('Student Q&A: Our counselors answer all questions within 2 hours!'); return false;">Q&A</a>
    </div>

    <!-- ========================================================================
         5. MAIN CONTENT 2-COLUMN LAYOUT
         ======================================================================== -->
    <div class="row g-3">
        
        <!-- Left Column: Content Sections -->
        <div class="col-lg-8">
            
            <!-- About VCEC Card -->
            <div id="about" class="content-box-card">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <div class="box-title-bar">
                            <h2 class="box-main-title">About VCEC</h2>
                        </div>
                        <p class="text-secondary small mb-2" style="line-height: 1.6; font-size: 0.8rem;">
                            VCEC - Vinayak Computer Education Center is a trusted and ISO 21001:2018 certified institute offering practical and job-oriented training in computer courses, digital marketing, tally, programming, AI and more. With multiple branches in Nikol, Naroda and Sardar Chowk, we have trained 10,000+ students and helped them build successful careers.
                        </p>

                        <!-- Highlights Pills -->
                        <div class="highlight-pill-row">
                            <div class="highlight-pill-item">
                                <i class="fa-solid fa-shield-halved text-primary"></i> ISO 21001:2018 Certified Institute
                            </div>
                            <div class="highlight-pill-item">
                                <i class="fa-solid fa-user-group text-info"></i> 10,000+ Students Trained
                            </div>
                            <div class="highlight-pill-item">
                                <i class="fa-solid fa-code-branch text-success"></i> 3 Branches
                            </div>
                            <div class="highlight-pill-item">
                                <i class="fa-solid fa-book-open-reader text-warning"></i> 15+ Certified Courses
                            </div>
                            <div class="highlight-pill-item">
                                <i class="fa-solid fa-briefcase text-danger"></i> 100+ Placements
                            </div>
                        </div>
                    </div>

                    <!-- Video Tour Box -->
                    <div class="col-md-4">
                        <div class="video-tour-box" onclick="openVideoModal()">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=500&auto=format&fit=crop&q=80" alt="Video Tour">
                            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle" style="width: 44px; height: 44px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                    <i class="fa-solid fa-play ms-1"></i>
                                </div>
                            </div>
                            <div class="play-tour-badge">
                                <span><i class="fa-regular fa-circle-play me-1"></i> Watch Institute Tour</span>
                                <span>2:45</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Courses Card -->
            <div id="courses" class="content-box-card">
                <div class="box-title-bar">
                    <h2 class="box-main-title">Popular Courses</h2>
                    <a href="javascript:void(0)" onclick="alert('Displaying all 12 certified vocational and IT courses.')" class="text-primary text-decoration-none fw-semibold small" style="font-size: 0.75rem;">
                        View All Courses &rarr;
                    </a>
                </div>

                <div class="row g-2">
                    @foreach($courses as $c)
                        <div class="col-xl-2 col-lg-4 col-md-4 col-6" style="flex: 1 0 18%;">
                            <div class="course-mini-card">
                                <img src="{{ $c['thumbnail'] }}" alt="{{ $c['title'] }}" class="course-mini-thumb">
                                <div class="course-mini-body">
                                    <h4 class="course-mini-title" title="{{ $c['title'] }}">{{ $c['title'] }}</h4>
                                    
                                    <div class="text-muted" style="font-size: 0.65rem; margin-bottom: 0.35rem;">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $c['duration'] }} | {{ $c['mode'] }}
                                    </div>

                                    <div class="mt-auto d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <span class="fw-bold text-dark" style="font-size: 0.8rem;">₹{{ number_format($c['price']) }}</span>
                                            <span class="text-muted text-decoration-line-through" style="font-size: 0.65rem;">₹{{ number_format($c['original_price']) }}</span>
                                        </div>
                                        <span class="badge bg-success-subtle text-success py-0 px-1" style="font-size: 0.6rem;">{{ $c['discount'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Our Services Card -->
            <div id="services" class="content-box-card">
                <div class="box-title-bar">
                    <h2 class="box-main-title">Our Services</h2>
                    <a href="javascript:void(0)" onclick="alert('Services catalog: In-house digital, resume, design and job application support.')" class="text-primary text-decoration-none fw-semibold small" style="font-size: 0.75rem;">
                        View All Services &rarr;
                    </a>
                </div>

                <div class="row g-2">
                    @foreach($services as $s)
                        <div class="col-md-2 col-6" style="flex: 1 0 18%;">
                            <div class="service-tile-box">
                                <div class="service-tile-icon" style="background-color: {{ $s['bg'] }}; color: {{ $s['color'] }};">
                                    <i class="{{ $s['icon'] }}"></i>
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 0.75rem; margin-bottom: 2px;">{{ $s['title'] }}</div>
                                <div class="text-muted" style="font-size: 0.65rem;">Starting from</div>
                                <div class="fw-bold text-primary" style="font-size: 0.78rem;">{{ $s['price'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Student Reviews Card -->
            <div id="reviews" class="content-box-card">
                <div class="box-title-bar">
                    <h2 class="box-main-title">Student Reviews</h2>
                    <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3 fw-semibold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#reviewModal">
                        Write a Review
                    </button>
                </div>

                <div class="row align-items-center g-3">
                    <!-- Left Big Score -->
                    <div class="col-md-3 text-center border-end">
                        <div class="fw-bold text-dark" style="font-size: 2.5rem; line-height: 1;">4.8</div>
                        <div class="text-warning small my-1">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <div class="text-muted small" style="font-size: 0.72rem;">420 reviews</div>
                    </div>

                    <!-- Testimonial Reviews Row -->
                    <div class="col-md-9">
                        <div class="row g-2">
                            @foreach($reviews as $r)
                                <div class="col-md-4">
                                    <div class="review-bubble-card">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{ $r['avatar'] }}" alt="{{ $r['author'] }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.75rem; line-height: 1.1;">{{ $r['author'] }}</div>
                                                <small class="text-muted" style="font-size: 0.62rem;">{{ $r['time_ago'] }}</small>
                                            </div>
                                        </div>
                                        <p class="text-secondary mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                                            {{ $r['text'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Sidebar Information -->
        <div class="col-lg-4">
            
            <!-- Visit Our Branch (Map + Directions) -->
            <div id="location" class="sidebar-profile-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h3 class="box-main-title">Visit Our Branch</h3>
                    <a href="https://maps.google.com/?q=Nikol,Ahmedabad" target="_blank" class="text-primary text-decoration-none fw-semibold small" style="font-size: 0.72rem;">
                        View on Map &rarr;
                    </a>
                </div>

                <!-- Google Map Embed -->
                <div class="rounded-3 overflow-hidden border mb-2" style="height: 140px;">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        loading="lazy" 
                        allowfullscreen 
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q=Nikol+Main+Road+Ahmedabad&t=&z=14&ie=UTF8&iwloc=&output=embed">
                    </iframe>
                </div>

                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                    <div>
                        <div class="fw-bold text-dark small" style="font-size: 0.78rem;">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i> Nikol Branch (Head Office)
                        </div>
                        <div class="text-muted" style="font-size: 0.7rem; line-height: 1.35;">
                            201, Shreeji Complex, Nikol Main Road, Ahmedabad - 382350, Gujarat
                        </div>
                    </div>
                    <a href="https://maps.google.com/?q=Nikol+Main+Road+Ahmedabad" target="_blank" class="btn btn-outline-primary btn-sm py-1 px-2 text-nowrap fw-semibold" style="font-size: 0.7rem;">
                        Get Directions
                    </a>
                </div>

                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.65rem;">
                        <i class="fa-solid fa-circle text-success me-1" style="font-size: 0.5rem;"></i> Open Now
                    </span>
                    <span class="text-muted" style="font-size: 0.7rem;">9:00 AM - 8:00 PM (Mon - Sun)</span>
                </div>
            </div>

            <!-- Our Branches -->
            <div class="sidebar-profile-card">
                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                    <h3 class="box-main-title">Our Branches</h3>
                    <a href="javascript:void(0)" onclick="alert('VCEC operates 3 full-fledged technical labs in Ahmedabad.')" class="text-primary text-decoration-none fw-semibold small" style="font-size: 0.72rem;">
                        View All &rarr;
                    </a>
                </div>

                @foreach($branches as $b)
                    <div class="branch-list-item">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-location-dot {{ $b['is_head'] ? 'text-danger' : 'text-primary' }}"></i>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $b['name'] }}</div>
                                <div class="text-muted" style="font-size: 0.68rem;">{{ $b['phone'] }}</div>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success py-1 px-2" style="font-size: 0.65rem;">{{ $b['status'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Book a Free Demo Class CTA Card -->
            <div class="demo-cta-box">
                <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle mb-2" style="width: 44px; height: 44px; font-size: 1.25rem;">
                    <i class="fa-regular fa-calendar-check" style="color: #ea580c;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Book a Free Demo Class</h4>
                <p class="text-muted small mb-3" style="font-size: 0.725rem; line-height: 1.35;">
                    Experience our training with a free demo session. No commitment, just learning!
                </p>
                <button type="button" class="btn btn-primary w-100 fw-bold py-2" style="background-color: #0066ff; border: none; font-size: 0.8rem; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#demoModal">
                    <i class="fa-solid fa-calendar-day me-1"></i> Book Free Demo &rarr;
                </button>
            </div>

        </div>

    </div>

</div>

<!-- ============================================================================
     MODALS: ENQUIRY, DEMO, VIDEO TOUR, REVIEW, SHARE
     ============================================================================ -->
<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Send Enquiry to VCEC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('business.enquiry', 'vcec-vinayak-computer-education-center') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number (WhatsApp)</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Interested Course</label>
                        <select name="course" class="form-select">
                            <option>Digital Marketing Complete Course</option>
                            <option>Tally Prime with GST</option>
                            <option>AI Tools & ChatGPT for Business</option>
                            <option>CCC (Basic Computer)</option>
                            <option>Full Stack Web Development</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Message / Questions (Optional)</label>
                        <textarea name="message" class="form-control" rows="2" placeholder="Tell us what you are looking to learn..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Submit Enquiry</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Book Demo Modal -->
<div class="modal fade" id="demoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">📅 Book a Free Demo Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('business.demo', 'vcec-vinayak-computer-education-center') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Your Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Student name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mobile Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Course For Demo</label>
                        <select name="course" class="form-select" required>
                            <option>Digital Marketing Mastery</option>
                            <option>Tally Prime with GST</option>
                            <option>AI & ChatGPT</option>
                            <option>Full Stack Web Development</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Preferred Branch</label>
                        <select name="preferred_branch" class="form-select" required>
                            <option>Nikol Branch (Head Office)</option>
                            <option>Naroda Branch</option>
                            <option>Sardar Chowk Branch</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold px-4" style="background-color: #ea580c; border: none;">
                        Confirm Free Demo Seat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Video Tour Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow bg-dark text-white overflow-hidden">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-white">VCEC Institute Virtual Tour</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                    <iframe src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=0" title="VCEC Tour" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Write Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Write a Student Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('business.review', 'vcec-vinayak-computer-education-center') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Your Name</label>
                        <input type="text" name="author" class="form-control" placeholder="e.g. Priya Shah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Rating</label>
                        <select name="rating" class="form-select">
                            <option value="5">⭐⭐⭐⭐⭐ (5 Stars - Excellent)</option>
                            <option value="4">⭐⭐⭐⭐☆ (4 Stars - Very Good)</option>
                            <option value="3">⭐⭐⭐☆☆ (3 Stars - Average)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Your Experience / Feedback</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Share how this institute helped your education and career..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Share Business Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="text-muted small mb-3">Share this verified institute with friends & students</p>
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-success rounded-circle p-3" style="width: 50px; height: 50px;" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary rounded-circle p-3" style="width: 50px; height: 50px;" title="Facebook">
                        <i class="fa-brands fa-facebook-f fs-5"></i>
                    </a>
                    <button type="button" class="btn btn-secondary rounded-circle p-3" style="width: 50px; height: 50px;" onclick="copyProfileLink()" title="Copy Link">
                        <i class="fa-regular fa-copy fs-5"></i>
                    </button>
                </div>
                <input type="text" id="shareLinkInput" class="form-control text-center text-muted small" value="{{ url()->current() }}" readonly>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Logic -->
<script>
    function toggleSaveProfile(btn) {
        btn.classList.toggle('active');
        const icon = btn.querySelector('i');
        const text = btn.querySelector('span');
        if (btn.classList.contains('active')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            text.innerText = 'Saved';
            showToast('Saved!', 'VCEC added to your saved businesses list.');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            text.innerText = 'Save';
            showToast('Removed', 'VCEC removed from saved businesses.');
        }
    }

    function openVideoModal() {
        const modal = new bootstrap.Modal(document.getElementById('videoModal'));
        modal.show();
    }

    function openGalleryModal() {
        alert('Displaying 28 verified photos: Computer lab, classrooms, live practical sessions, faculty team, and placement celebration days.');
    }

    function copyProfileLink() {
        const input = document.getElementById('shareLinkInput');
        input.select();
        document.execCommand('copy');
        alert('Profile link copied to clipboard!');
    }

    function showToast(title, message) {
        let toastEl = document.getElementById('dcLiveToast');
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.id = 'dcLiveToast';
            toastEl.style.position = 'fixed';
            toastEl.style.bottom = '24px';
            toastEl.style.right = '24px';
            toastEl.style.zIndex = '9999';
            toastEl.style.background = '#0f172a';
            toastEl.style.color = '#ffffff';
            toastEl.style.padding = '0.75rem 1.25rem';
            toastEl.style.borderRadius = '10px';
            toastEl.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
            toastEl.style.fontSize = '0.85rem';
            toastEl.style.transition = 'all 0.3s ease';
            document.body.appendChild(toastEl);
        }
        toastEl.innerHTML = '<strong>' + title + '</strong>: ' + message;
        toastEl.style.opacity = '1';
        toastEl.style.transform = 'translateY(0)';
        setTimeout(() => {
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateY(10px)';
        }, 2500);
    }
</script>

@endsection
