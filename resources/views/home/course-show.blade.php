@extends('layouts.app')

@section('title', ($course->title ?? 'Digital Marketing Complete Course 2026') . ' - Digital Class')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($course->meta_description ?? ($course->short_description ?: 'Learn ' . $course->title . ' with step by step practical training, live projects and industry certification.')), 160))
@section('meta_keywords', $course->meta_keywords ?? ($course->category . ', ' . $course->title . ', online courses, certification, digital class'))
@section('og_image', $course->thumbnail)
@section('og_type', 'article')

@section('styles')
<!-- SEO Meta Tags -->
<meta name="description" content="{{ $course->meta_description ?? ($course->short_description ?: 'Learn ' . $course->title . ' with step by step practical training, live projects and industry certification.') }}">
<meta name="keywords" content="{{ $course->meta_keywords ?? ($course->category . ', ' . $course->title . ', online courses, certification, digital class') }}">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph SEO -->
<meta property="og:title" content="{{ $course->title }} - Digital Class">
<meta property="og:description" content="{{ $course->short_description ?: 'Master in-demand skills with practical training and certified credentials.' }}">
<meta property="og:image" content="{{ $course->thumbnail }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="article">

<!-- Twitter Card SEO -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $course->title }} - Digital Class">
<meta name="twitter:description" content="{{ $course->short_description ?: 'Learn practical skills and get certified.' }}">
<meta name="twitter:image" content="{{ $course->thumbnail }}">

<!-- Google Schema.org Structured Data for Rich Snippets -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Course',
    'name' => $course->title,
    'description' => $course->short_description ?: $course->description,
    'provider' => [
        '@type' => 'Organization',
        'name' => 'Digital Class - Educational World',
        'sameAs' => url('/'),
    ],
    'instructor' => [
        '@type' => 'Person',
        'name' => $course->instructor_name,
    ],
    'offers' => [
        '@type' => 'Offer',
        'price' => (string)($course->discount_price > 0 ? $course->discount_price : $course->price),
        'priceCurrency' => 'INR',
        'availability' => 'https://schema.org/InStock',
    ],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.8',
        'reviewCount' => '1250',
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<style>
    /* Breadcrumbs */
    .course-page-breadcrumb {
        font-size: 0.75rem;
        color: #64748b;
        padding: 0.85rem 0 0.5rem;
        background: transparent;
    }
    .course-page-breadcrumb a {
        color: #64748b;
        text-decoration: none;
    }
    .course-page-breadcrumb a:hover {
        color: #0066ff;
    }

    /* Top Course Header Area */
    .course-hero-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    }

    .video-preview-thumbnail-box {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        background: #0b1528;
        cursor: pointer;
        width: 100%;
        height: 210px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }
    .video-preview-thumbnail-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.9;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    }
    .video-preview-thumbnail-box:hover img {
        transform: scale(1.05);
        opacity: 0.98;
    }

    .video-play-center-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.25), 0 8px 20px rgba(0, 102, 255, 0.4);
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .video-preview-thumbnail-box:hover .video-play-center-btn {
        transform: translate(-50%, -50%) scale(1.12);
        box-shadow: 0 0 0 12px rgba(255, 255, 255, 0.35), 0 12px 28px rgba(0, 102, 255, 0.5);
    }

    .video-bottom-strip {
        position: absolute;
        bottom: 10px;
        left: 10px;
        right: 10px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(8px);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .course-meta-four-box {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        margin-top: 1rem;
        padding-top: 0.85rem;
        border-top: 1px solid #f1f5f9;
        font-size: 0.78rem;
        color: #475569;
    }
    .course-meta-item-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    /* Sticky Buy Card */
    .sticky-purchase-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 16px 36px -4px rgba(15, 23, 42, 0.1), 0 0 0 1px rgba(226, 232, 240, 0.8);
        position: sticky;
        top: 85px;
        z-index: 10;
    }

    .huge-price-display {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    /* Sticky Sub-Navigation Tabs matching screenshot */
    .course-subnav-tabs {
        background: #eef2f6;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 6px;
        overflow-x: auto;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    }
    .course-subnav-link {
        display: inline-block;
        padding: 0.45rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #0066ff;
        text-decoration: none;
        border-radius: 8px;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .course-subnav-link:hover {
        color: #004edb;
        background: rgba(0, 102, 255, 0.08);
    }
    .course-subnav-link.active {
        color: #ffffff !important;
        background: #0066ff !important;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
    }

    /* Tab switching: Only the clicked tab opens */
    .course-tab-pane {
        display: none;
    }
    .course-tab-pane.active {
        display: block;
        animation: fadeInTabPane 0.2s ease-in-out;
    }
    @keyframes fadeInTabPane {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Section Cards */
    .section-card-white {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.5rem 1.65rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    .section-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.015em;
        margin-bottom: 0.85rem;
    }

    /* Course Description Collapse */
    .course-desc-wrapper {
        position: relative;
        max-height: 220px;
        overflow: hidden;
        transition: max-height 0.35s ease;
    }
    .course-desc-wrapper.expanded {
        max-height: none;
    }
    .course-desc-wrapper:not(.expanded)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.95) 100%);
        pointer-events: none;
    }
    .btn-toggle-see-more {
        color: #6d28d9;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        cursor: pointer;
        margin-top: 0.65rem;
        margin-bottom: 0.5rem;
    }
    .btn-toggle-see-more:hover {
        color: #5b21b6;
        text-decoration: underline;
    }

    /* What you'll learn Box */
    .what-you-learn-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.5rem 1.65rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    .learn-point-check {
        display: flex;
        align-items: flex-start;
        gap: 0.45rem;
        font-size: 0.8rem;
        color: #1e293b;
        margin-bottom: 0.55rem;
        line-height: 1.4;
    }

    /* Promotion Mini Banners */
    .cert-promo-banner {
        background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem 1.15rem;
    }

    .learn-anywhere-banner {
        background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
        border: 1px solid #e9d5ff;
        border-radius: 12px;
        padding: 1rem 1.15rem;
    }

    /* Curriculum Accordion */
    .accordion-curriculum .accordion-item {
        border: 1px solid #e2e8f0;
        border-radius: 10px !important;
        margin-bottom: 0.5rem;
        overflow: hidden;
    }
    .accordion-curriculum .accordion-button {
        font-size: 0.825rem;
        font-weight: 700;
        color: #0f172a;
        background: #f8fafc;
        padding: 0.75rem 1rem;
    }
    .accordion-curriculum .accordion-button:not(.collapsed) {
        background: #eff6ff;
        color: #0066ff;
        box-shadow: none;
    }
    .lecture-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.75rem;
    }
    .lecture-item-row:last-child {
        border-bottom: none;
    }

    /* Star Rating Bars */
    .rating-bar-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.72rem;
        color: #64748b;
        margin-bottom: 0.25rem;
    }
    .rating-progress-track {
        flex-grow: 1;
        height: 6px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }
    .rating-progress-fill {
        height: 100%;
        background: #f59e0b;
        border-radius: 999px;
    }

    /* Related Course Card in Footer */
    .related-course-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.15s, box-shadow 0.15s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .related-course-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
    .related-thumb-img {
        width: 100%;
        height: 110px;
        object-fit: cover;
    }

    /* Mobile Responsive Polish */
    @media (max-width: 991px) {
        .mobile-sticky-purchase-bar {
            position: fixed;
            bottom: 64px; /* Sits right above the mobile bottom dock */
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(226, 232, 240, 0.9);
            padding: 10px 16px;
            z-index: 1030;
            box-shadow: 0 -4px 16px rgba(15, 23, 42, 0.08);
        }
        .course-hero-header-card {
            padding: 1.15rem;
            border-radius: 14px;
        }
        .video-preview-thumbnail-box {
            height: 185px;
        }
        .course-subnav-tabs {
            border-radius: 12px;
            padding: 4px;
        }
        .course-meta-four-box {
            gap: 0.75rem;
            padding-top: 0.65rem;
        }
    }
    @media (max-width: 576px) {
        .video-preview-thumbnail-box {
            height: 165px;
        }
        .huge-price-display {
            font-size: 1.65rem;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid px-lg-4 pb-5">

    <!-- ========================================================================
         1. BREADCRUMBS
         ======================================================================== -->
    <nav class="course-page-breadcrumb">
        <a href="{{ route('home') }}">Home</a> &gt; 
        @if(!empty($course->is_institute_course))
            <a href="{{ route('businesses') }}">Coaching Institutes</a> &gt; 
            @if(!empty($course->instructor_url))
                <a href="{{ $course->instructor_url }}">{{ $course->instructor_name }}</a> &gt; 
            @endif
        @elseif(!empty($course->is_elearn_course))
            <a href="{{ route('courses') }}">E-Learning</a> &gt; 
            @if(!empty($course->tutor_url))
                <a href="{{ $course->tutor_url }}">{{ $course->instructor_name }}</a> &gt; 
            @endif
        @else
            <a href="{{ route('courses') }}">Courses</a> &gt; 
            <a href="{{ route('courses', ['category' => $course->category]) }}">{{ $course->category }}</a> &gt; 
        @endif
        <span class="text-dark fw-semibold">{{ $course->title }}</span>
    </nav>

    <!-- ========================================================================
         2. TOP COURSE HEADER & PREVIEW BOX
         ======================================================================== -->
    <div class="course-hero-header-card">
        <div class="row align-items-center g-4">
            
            <!-- Video Preview Thumbnail with Glowing Play Overlay -->
            <div class="col-lg-4 col-md-5">
                <div class="video-preview-thumbnail-box" onclick="openTrailerModal()">
                    <img src="{{ $course->thumbnail ?? 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&auto=format&fit=crop&q=80' }}" alt="{{ $course->title }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';">
                    <div class="video-play-center-btn">
                        <i class="fa-solid fa-play ms-1"></i>
                    </div>
                    <div class="video-bottom-strip">
                        <span><i class="fa-solid fa-circle-play me-1"></i> Preview This Course</span>
                        <span>02:15</span>
                    </div>
                </div>
            </div>

            <!-- Course Title & Key Metadata -->
            <div class="col-lg-8 col-md-7">
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    @if($course->badge === 'Bestseller' || $course->id == 1 || str_contains(strtolower($course->title), 'digital marketing'))
                        <span class="badge bg-warning text-dark fw-bold px-2 py-1" style="font-size: 0.7rem;">Bestseller</span>
                    @endif

                    <div class="d-flex align-items-center gap-1 text-warning small fw-bold">
                        <i class="fa-solid fa-star"></i> {{ number_format($course->rating, 1) }}
                        <span class="text-muted fw-normal">({{ $course->reviews_count }} reviews)</span>
                    </div>
                </div>

                <h1 class="fw-bold text-dark mb-2" style="font-size: 1.65rem; letter-spacing: -0.02em; line-height: 1.25;">
                    {{ $course->title }}
                </h1>

                <p class="text-secondary small mb-3" style="font-size: 0.825rem; line-height: 1.5; max-width: 720px;">
                    {{ $course->short_description ?: ($course->title . ' - comprehensive online training program by ' . $course->instructor_name . '.') }}
                </p>

                <!-- Instructor Byline -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ $course->instructor_url ?: '#' }}" class="text-decoration-none">
                        <img src="{{ $course->instructor_avatar }}" alt="{{ $course->instructor_name }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=160&auto=format&fit=crop&q=80';">
                    </a>
                    <div style="font-size: 0.78rem;">
                        <a href="{{ $course->instructor_url ?: '#' }}" class="text-decoration-none text-dark fw-bold">By {{ $course->instructor_name }}</a>
                        <span class="text-muted ms-1">&bull; {{ $course->instructor_category }} Expert | {{ $course->instructor_subtitle ?? 'Verified Educator' }}</span>
                    </div>
                </div>

                <!-- 4 Metadata Items -->
                <div class="course-meta-four-box">
                    <div class="course-meta-item-badge">
                        <i class="fa-regular fa-calendar-check text-primary"></i>
                        <span>Last Updated: <strong>{{ $course->updated_at ? $course->updated_at->format('M Y') : 'Jan 2026' }}</strong></span>
                    </div>
                    <div class="course-meta-item-badge">
                        <i class="fa-solid fa-language text-success"></i>
                        <span>Language: <strong>{{ $course->language }}</strong></span>
                    </div>
                    <div class="course-meta-item-badge">
                        <i class="fa-solid fa-users text-info"></i>
                        <span>Students: <strong>{{ $course->students_count }}</strong></span>
                    </div>
                    <div class="course-meta-item-badge">
                        <i class="fa-solid fa-certificate text-warning"></i>
                        <span>Certificate: <strong>{{ $course->certificate_included ? 'Included' : 'Available' }}</strong></span>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ========================================================================
         3. STICKY SUB-NAVIGATION TABS (Only the clicked tab opens)
         ======================================================================== -->
    <div class="course-subnav-tabs">
        <button type="button" class="course-subnav-link active" data-tab="overview" onclick="switchCourseTab('overview', this)">Overview</button>
        <button type="button" class="course-subnav-link" data-tab="topics" onclick="switchCourseTab('topics', this)">Topics</button>
        <button type="button" class="course-subnav-link" data-tab="curriculum" onclick="switchCourseTab('curriculum', this)">Curriculum</button>
        <button type="button" class="course-subnav-link" data-tab="faqs" onclick="switchCourseTab('faqs', this)">FAQ's</button>
        <button type="button" class="course-subnav-link" data-tab="instructor" onclick="switchCourseTab('instructor', this)">Instructor</button>
        <button type="button" class="course-subnav-link" data-tab="reviews" onclick="switchCourseTab('reviews', this)">Reviews</button>
    </div>

    <!-- ========================================================================
         4. TWO-COLUMN MAIN CONTENT (LEFT SECTIONS + RIGHT STICKY BUY CARD)
         ======================================================================== -->
    <div class="row g-3">
        
        <!-- Left Column: Course In-Depth Details (Tab-switched) -->
        <div class="col-lg-8">
            
            <!-- PANE 1: Course Overview Section -->
            <div id="tab-pane-overview" class="course-tab-pane active">
                <div id="overview" class="section-card-white mb-3">
                    <h2 class="section-card-title mb-3" style="font-size: 1.35rem; font-weight: 700;">Course Overview</h2>
                    
                    <div class="course-desc-wrapper" id="courseDescWrap">
                        <div class="course-desc-content text-secondary" style="font-size: 0.86rem; line-height: 1.65;">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="btn-toggle-see-more" id="descSeeMoreBtn" onclick="toggleCourseDescription()">
                        <span id="descToggleText">See more</span> <i class="fa-solid fa-chevron-down" id="descToggleIcon" style="font-size: 0.72rem;"></i>
                    </a>

                    @if(!empty($course->course_activation_instruction))
                        <div class="alert alert-info mt-3 p-3 rounded-3 border-0 bg-primary-subtle" style="font-size: 0.8rem;">
                            <div class="fw-bold text-primary mb-1"><i class="fa-solid fa-circle-info me-1"></i> Course Access & Activation Instructions</div>
                            <div class="text-secondary">{!! nl2br(e($course->course_activation_instruction)) !!}</div>
                        </div>
                    @endif
                </div>

                <!-- Course Highlights Grid -->
                <div class="section-card-white mb-3 p-3">
                    <div class="row g-2">
                        <div class="col-sm-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2 bg-light">
                                <i class="fa-regular fa-clock text-primary fs-5"></i>
                                <div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Duration</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.78rem;">{{ $course->duration }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2 bg-light">
                                <i class="fa-solid fa-layer-group text-success fs-5"></i>
                                <div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Chapters / Modules</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.78rem;">{{ $course->course_chapter ?: count($curriculum) }} Modules</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2 bg-light">
                                <i class="fa-solid fa-video text-info fs-5"></i>
                                <div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Video Lessons</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.78rem;">{{ $course->course_video ?: 24 }} Lectures</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2 bg-light">
                                <i class="fa-solid fa-signal text-warning fs-5"></i>
                                <div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Skill Level</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.78rem;">{{ $course->level }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2 bg-light">
                                <i class="fa-solid fa-language text-purple fs-5" style="color: #9333ea;"></i>
                                <div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Language</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.78rem;">{{ $course->language }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2 bg-light">
                                <i class="fa-solid fa-certificate text-danger fs-5"></i>
                                <div>
                                    <div class="text-muted" style="font-size: 0.68rem;">Certificate</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.78rem;">Official Verified</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANE 2: Topics Section -->
            <div id="tab-pane-topics" class="course-tab-pane">
                <div id="topics" class="section-card-white mb-3">
                    <h2 class="section-card-title mb-3" style="font-size: 1.35rem; font-weight: 700;">Topics</h2>
                    
                    @php
                        $displayTopics = !empty($topics) ? $topics : $learningPoints;
                        $halfLp = ceil(count($displayTopics) / 2);
                    @endphp
                    <div class="row g-2">
                        <div class="col-md-6">
                            @foreach(array_slice($displayTopics, 0, $halfLp) as $t)
                                <div class="learn-point-check d-flex align-items-start gap-2 mb-2.5">
                                    <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0" style="font-size: 0.95rem;"></i>
                                    <span style="font-size: 0.88rem; color: #1e293b; line-height: 1.5;">{{ $t }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            @foreach(array_slice($displayTopics, $halfLp) as $t)
                                <div class="learn-point-check d-flex align-items-start gap-2 mb-2.5">
                                    <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0" style="font-size: 0.95rem;"></i>
                                    <span style="font-size: 0.88rem; color: #1e293b; line-height: 1.5;">{{ $t }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANE 3: Course Curriculum Section -->
            <div id="tab-pane-curriculum" class="course-tab-pane">
                <div id="curriculum" class="section-card-white mb-3">
                    @php
                        $totalCurriculumLectures = 0;
                        foreach($curriculum as $m) {
                            $totalCurriculumLectures += count($m['items'] ?? []);
                        }
                        $displayModules = !empty($course->course_chapter) ? $course->course_chapter : count($curriculum);
                        $displayLectures = !empty($course->course_video) ? $course->course_video : ($totalCurriculumLectures ?: (!empty($curriculumDirectItems) ? count($curriculumDirectItems) : 24));
                    @endphp
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="section-card-title mb-0" style="font-size: 1.35rem; font-weight: 700;">Curriculum</h2>
                        <span class="text-muted small" style="font-size: 0.75rem;">
                            {{ $displayModules }} Modules &bull; {{ $displayLectures }} Lectures &bull; {{ $course->duration }} Total Length
                        </span>
                    </div>

                    @if(!empty($curriculumDirectItems) && count($curriculumDirectItems) > 0)
                        {{-- Direct Authentic Curriculum items matching screenshot media_1795423722571_765e14dc.png --}}
                        <div class="curriculum-direct-list mb-3">
                            @foreach($curriculumDirectItems as $cItem)
                                <div class="d-flex align-items-start gap-2.5 mb-2.5 p-2 rounded-2" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                    <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0" style="font-size: 0.95rem;"></i>
                                    <span style="font-size: 0.88rem; color: #1e293b; line-height: 1.55;">{{ $cItem }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($curriculum) && count($curriculum) > 0 && (empty($curriculumDirectItems) || count($curriculumDirectItems) <= 1))
                        {{-- Structured Accordion for Multi-module courses like Course 1324 --}}
                        <div class="accordion accordion-curriculum mt-2" id="courseAccordion">
                            @foreach($curriculum as $idx => $mod)
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="heading{{ $idx }}">
                                        <button class="accordion-button {{ $idx > 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idx }}" aria-expanded="{{ $idx <= 1 ? 'true' : 'false' }}">
                                            <div class="d-flex align-items-center justify-content-between w-100 me-2">
                                                <span>{{ $mod['section'] }}</span>
                                                <span class="text-muted fw-normal small" style="font-size: 0.7rem;">
                                                    {{ $mod['lectures'] }} &bull; {{ $mod['duration'] }}
                                                </span>
                                            </div>
                                        </button>
                                    </h3>
                                    <div id="collapse{{ $idx }}" class="accordion-collapse collapse {{ $idx <= 1 ? 'show' : '' }}" data-bs-parent="#courseAccordion">
                                        <div class="accordion-body p-0">
                                            @foreach($mod['items'] as $item)
                                                <div class="lecture-item-row">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fa-regular fa-circle-play text-primary"></i>
                                                        <span>{{ $item['title'] }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if(!empty($item['preview']))
                                                            <span class="badge bg-primary-subtle text-primary" style="font-size: 0.65rem; cursor: pointer;" onclick="openTrailerModal()">Preview</span>
                                                        @endif
                                                        <span class="text-muted">{{ $item['duration'] }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- PANE 4: Frequently Asked Questions Section -->
            <div id="tab-pane-faqs" class="course-tab-pane">
                <div id="faqs" class="section-card-white mb-3">
                    <h2 class="section-card-title mb-3" style="font-size: 1.35rem; font-weight: 700;">Frequently Asked Questions</h2>
                    <div class="accordion accordion-curriculum" id="courseFaqAccordion">
                        @foreach($faqs as $fIdx => $faq)
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqHeading{{ $fIdx }}">
                                    <button class="accordion-button {{ $fIdx > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $fIdx }}" aria-expanded="{{ $fIdx === 0 ? 'true' : 'false' }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-regular fa-circle-question text-primary"></i>
                                            <span class="fw-bold">{{ $faq['q'] }}</span>
                                        </div>
                                    </button>
                                </h3>
                                <div id="faqCollapse{{ $fIdx }}" class="accordion-collapse collapse {{ $fIdx === 0 ? 'show' : '' }}" data-bs-parent="#courseFaqAccordion">
                                    <div class="accordion-body text-secondary" style="font-size: 0.85rem; line-height: 1.6;">
                                        {!! nl2br(e($faq['a'])) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- PANE 5: About the Instructor Section -->
            <div id="tab-pane-instructor" class="course-tab-pane">
                <div id="instructor" class="section-card-white mb-3">
                    <h2 class="section-card-title mb-3" style="font-size: 1.35rem; font-weight: 700;">About the Instructor</h2>
                    
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <img src="{{ $course->instructor_avatar }}" alt="{{ $course->instructor_name }}" class="rounded-circle border" style="width: 68px; height: 68px; object-fit: cover;" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=160&auto=format&fit=crop&q=80';">
                        
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ $course->instructor_url ?: '#' }}" class="text-decoration-none">
                                    <h4 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $course->instructor_name }}</h4>
                                </a>
                                <span class="badge bg-primary text-white py-1 px-2" style="font-size: 0.65rem;">Top Instructor</span>
                            </div>
                            <div class="text-primary small fw-semibold" style="font-size: 0.78rem;">{{ $course->instructor_subtitle ?? ($course->instructor_category . ' Expert') }}</div>
                            <div class="text-muted small" style="font-size: 0.72rem;">Authentic educator &amp; course creator on Digital Class</div>

                            <div class="mt-2">
                                <a href="{{ $course->instructor_url ?: '#' }}" class="btn btn-sm btn-outline-primary fw-bold" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-store me-1"></i> View Instructor / Institute Profile &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <p class="text-secondary small mb-0" style="font-size: 0.8rem; line-height: 1.55;">
                        {{ $course->instructor_bio ?? ($course->short_description ?: ($course->instructor_name . ' provides high quality education and career guidance on Digital Class.')) }}
                    </p>
                </div>
            </div>

            <!-- PANE 6: Student Reviews Section -->
            <div id="tab-pane-reviews" class="course-tab-pane">
                <div id="reviews" class="section-card-white mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="section-card-title mb-0" style="font-size: 1.35rem; font-weight: 700;">Student Reviews</h2>
                        <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3 fw-semibold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#reviewCourseModal">
                            Write a Review
                        </button>
                    </div>

                    @if(!empty($reviews) && count($reviews) > 0)
                        <div class="row g-2">
                            @foreach($reviews as $r)
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 h-100 d-flex flex-direction-column justify-content-between border">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <img src="{{ $r['avatar'] }}" alt="{{ $r['author'] }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $r['author'] }}</div>
                                                    <div class="text-warning" style="font-size: 0.65rem;">
                                                        @for($i=1; $i<=5; $i++)
                                                            <i class="fa-solid fa-star"></i>
                                                        @endfor
                                                        <span class="text-muted ms-1" style="font-size: 0.6rem;">{{ $r['time_ago'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-secondary small mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                                                {{ $r['text'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 bg-light rounded-3 border">
                            <i class="fa-regular fa-star text-muted fs-3 mb-2"></i>
                            <div class="fw-bold text-dark small">No Reviews Yet</div>
                            <p class="text-muted small mb-3" style="font-size: 0.78rem;">Be the first student to review this course and share your learning feedback!</p>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-bold px-3 py-1.5" data-bs-toggle="modal" data-bs-target="#reviewCourseModal" style="font-size: 0.78rem;">
                                <i class="fa-regular fa-pen-to-square me-1"></i> Write First Review
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column: Sticky Purchase Card & Requirements Sidebars -->
        <div class="col-lg-4">
            
            <!-- Sticky Purchase Card -->
            <div class="sticky-purchase-card mb-3">
                
                @php
                    $sellPrice = (float)($course->selling_price ?? 0);
                    $mrpPrice = (float)($course->original_price ?? 0);
                    if ($sellPrice == 0) {
                        if (isset($course->discount_price) && $course->discount_price > 0 && $course->price > $course->discount_price) {
                            $sellPrice = (float)$course->discount_price;
                            $mrpPrice = (float)$course->price;
                        } else {
                            $sellPrice = (float)($course->price ?? 0);
                        }
                    }
                    if ($mrpPrice == 0 && isset($course->price) && $course->price > $sellPrice) {
                        $mrpPrice = (float)$course->price;
                    }
                @endphp
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    @if($sellPrice == 0)
                        <span class="huge-price-display text-success">FREE</span>
                        @if($mrpPrice > 0)
                            <span class="text-muted text-decoration-line-through small">₹{{ number_format($mrpPrice) }}</span>
                        @endif
                    @else
                        <span class="huge-price-display">₹{{ number_format($sellPrice) }}</span>
                        @if($mrpPrice > $sellPrice)
                            <span class="text-muted text-decoration-line-through small">₹{{ number_format($mrpPrice) }}</span>
                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.7rem;">{{ $course->discount_percentage ?? $course->discount_text ?? round((($mrpPrice - $sellPrice)/$mrpPrice)*100) . '% OFF' }}</span>
                        @endif
                    @endif
                </div>

                <div class="text-danger small fw-semibold mb-3" style="font-size: 0.72rem;">
                    <i class="fa-regular fa-clock me-1"></i> Offer ends in 2 days
                </div>

                <!-- CTA Action Buttons -->
                <form action="{{ route('course.enroll', $course->slug) }}" method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn w-100 fw-bold py-2 shadow-sm text-white" style="background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%); border: none; font-size: 0.875rem; border-radius: 8px;">
                        Buy Now
                    </button>
                </form>

                <button type="button" class="btn w-100 fw-bold py-2 mb-3" style="border: 2px solid #7c3aed; color: #6d28d9; background: #ffffff; font-size: 0.82rem; border-radius: 8px; transition: all 0.2s;" onclick="addToCart({ id: '{{ $course->id }}', type: 'Course', title: '{{ addslashes($course->title) }}', price: {{ (float)$sellPrice }}, thumbnail: '{{ $course->thumbnail }}', seller_id: {{ $course->seller_id ?? 1 }} })">
                    <i class="fa-solid fa-cart-shopping me-1"></i> Add to Cart
                </button>

                <!-- Guarantee Checkpoints List -->
                <div class="pt-2 border-top">
                    <div class="d-flex align-items-center gap-2 mb-2 text-dark" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check text-success"></i> <span>Lifetime Access</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2 text-dark" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check text-success"></i> <span>Learn at Your Own Pace</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2 text-dark" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check text-success"></i> <span>Mobile, Tablet & Desktop Access</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2 text-dark" style="font-size: 0.75rem;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i> <span>Certificate of Completion</span>
                        </div>
                        <a href="{{ route('course.certificate', $course->slug ?? 'digital-marketing-complete-course-2026') }}" target="_blank" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.7rem;">
                            View PDF &rarr;
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2 text-dark" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check text-success"></i> <span>Live Projects & Resources</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-dark" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-check text-success"></i> <span>30 Days Money Back Guarantee</span>
                    </div>
                </div>

            </div>

            <!-- This Course Includes Box -->
            <div class="section-card-white mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h3 class="section-card-title mb-0" style="font-size: 0.95rem;">This Course Includes</h3>
                    <i class="fa-solid fa-graduation-cap text-primary fs-5"></i>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-video text-primary"></i> <span>45+ Hours On-Demand Video</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-diagram-project text-info"></i> <span>20+ Live Projects</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-download text-success"></i> <span>Downloadable Resources</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-file-pen text-warning"></i> <span>Quizzes & Assignments</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-user-group text-purple" style="color: #9333ea;"></i> <span>Community Support</span>
                </div>
                <div class="d-flex align-items-center gap-2 text-secondary" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-certificate text-danger"></i> <span>Certificate of Completion</span>
                </div>
            </div>

            <!-- Who is this course for? -->
            <div class="section-card-white mb-3" style="background: #faf5ff; border-color: #f3e8ff;">
                <h3 class="section-card-title mb-2" style="font-size: 0.95rem; color: #6b21a8;">Who is this course for?</h3>
                @foreach($targetAudience as $ta)
                    <div class="d-flex align-items-start gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-check text-purple mt-1" style="color: #9333ea;"></i>
                        <span>{{ $ta }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Requirements Box -->
            <div class="section-card-white mb-3">
                <h3 class="section-card-title mb-2" style="font-size: 0.95rem;">Requirements</h3>
                @foreach($requirements as $req)
                    <div class="d-flex align-items-start gap-2 mb-2 text-secondary" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-dot text-danger mt-1" style="font-size: 0.65rem;"></i>
                        <span>{{ $req }}</span>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <!-- ========================================================================
         5. "YOU MAY ALSO LIKE" RELATED COURSES (BOTTOM SECTION)
         ======================================================================== -->
    <div class="mt-4 pt-3 border-top">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="section-card-title mb-0">You May Also Like</h2>
            <a href="{{ route('courses') }}" class="text-primary text-decoration-none fw-semibold small" style="font-size: 0.75rem;">
                View All &rarr;
            </a>
        </div>

        <div class="row g-3">
            @foreach($relatedCourses as $rc)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="related-course-card">
                        <a href="{{ route('course.show', $rc->slug) }}">
                            <img src="{{ $rc->thumbnail }}" alt="{{ $rc->title }}" class="related-thumb-img" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';">
                        </a>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <h4 class="fw-bold mb-1" style="font-size: 0.825rem; line-height: 1.3;">
                                <a href="{{ route('course.show', $rc->slug) }}" class="text-dark text-decoration-none">
                                    {{ $rc->title }}
                                </a>
                            </h4>
                            <div class="text-warning small mb-2" style="font-size: 0.68rem;">
                                <i class="fa-solid fa-star"></i> {{ number_format($rc->rating, 1) }}
                                <span class="text-muted ms-1">({{ $rc->reviews_count }})</span>
                            </div>
                            @php
                                $rSellPrice = (float)($rc->selling_price ?? 0);
                                $rMrpPrice = (float)($rc->original_price ?? 0);
                                if ($rSellPrice == 0) {
                                    if (isset($rc->discount_price) && $rc->discount_price > 0 && $rc->price > $rc->discount_price) {
                                        $rSellPrice = (float)$rc->discount_price;
                                        $rMrpPrice = (float)$rc->price;
                                    } else {
                                        $rSellPrice = (float)($rc->price ?? 0);
                                    }
                                }
                                if ($rMrpPrice == 0 && isset($rc->price) && $rc->price > $rSellPrice) {
                                    $rMrpPrice = (float)$rc->price;
                                }
                            @endphp
                            <div class="mt-auto d-flex align-items-baseline gap-2">
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">₹{{ number_format($rSellPrice) }}</span>
                                @if($rMrpPrice > $rSellPrice && $rSellPrice > 0)
                                    <span class="text-muted text-decoration-line-through small" style="font-size: 0.7rem;">₹{{ number_format($rMrpPrice) }}</span>
                                    <span class="badge bg-success-subtle text-success py-0 px-1" style="font-size: 0.6rem;">{{ $rc->discount_percentage ?? $rc->discount_text ?? round((($rMrpPrice - $rSellPrice)/$rMrpPrice)*100) . '% off' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<!-- ========================================================================
     MODALS: VIDEO TRAILER & WRITE REVIEW
     ======================================================================== -->
<!-- Video Trailer Modal -->
<div class="modal fade" id="trailerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow bg-dark text-white overflow-hidden">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-white">{{ $course->title }} &mdash; Free Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                    <iframe src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=0" title="Course Trailer" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Write Review Modal -->
<div class="modal fade" id="reviewCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Write a Review for {{ $course->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('course.review', $course->slug) }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Your Name</label>
                        <input type="text" name="author" class="form-control" placeholder="e.g. Priya Shah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Rating</label>
                        <select name="rating" class="form-select">
                            <option value="5">⭐⭐⭐⭐⭐ (5 Stars - Outstanding)</option>
                            <option value="4">⭐⭐⭐⭐☆ (4 Stars - Very Good)</option>
                            <option value="3">⭐⭐⭐☆☆ (3 Stars - Good)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Your Feedback</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience taking this course..." required></textarea>
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

<!-- JavaScript Logic -->
<script>
    function openTrailerModal() {
        const modal = new bootstrap.Modal(document.getElementById('trailerModal'));
        modal.show();
    }

    // Interactive Tab Switching: Whatever clicks, only it opens
    function switchCourseTab(tabKey, btn) {
        // 1. Update button active states
        const btns = document.querySelectorAll('.course-subnav-link');
        btns.forEach(b => b.classList.remove('active'));
        if (btn) {
            btn.classList.add('active');
        } else {
            const match = document.querySelector(`.course-subnav-link[data-tab="${tabKey}"]`);
            if (match) match.classList.add('active');
        }

        // 2. Hide all panes, show only the selected tab pane
        const panes = document.querySelectorAll('.course-tab-pane');
        panes.forEach(p => p.classList.remove('active'));

        const target = document.getElementById(`tab-pane-${tabKey}`);
        if (target) {
            target.classList.add('active');
        }

        // 3. Update URL hash
        if (history.replaceState) {
            history.replaceState(null, null, `#${tabKey}`);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.replace('#', '').toLowerCase();
        if (['overview', 'topics', 'curriculum', 'faqs', 'instructor', 'reviews'].includes(hash)) {
            const btn = document.querySelector(`.course-subnav-link[data-tab="${hash}"]`);
            if (btn) {
                switchCourseTab(hash, btn);
            }
        }
    });

    function toggleCourseDescription() {
        const wrap = document.getElementById('courseDescWrap');
        const text = document.getElementById('descToggleText');
        const icon = document.getElementById('descToggleIcon');
        if (!wrap || !text || !icon) return;

        const isExpanded = wrap.classList.toggle('expanded');
        if (isExpanded) {
            text.textContent = 'See less';
            icon.className = 'fa-solid fa-chevron-up';
        } else {
            text.textContent = 'See more';
            icon.className = 'fa-solid fa-chevron-down';
            wrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const wrap = document.getElementById('courseDescWrap');
        const btn = document.getElementById('descSeeMoreBtn');
        if (wrap && btn) {
            // Only show toggle if description is taller than collapsed threshold
            if (wrap.scrollHeight <= 230) {
                btn.style.display = 'none';
                wrap.classList.add('expanded');
            }
        }
    });

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

<!-- Mobile Sticky Purchase Bar (Bottom Fixed on Phones) -->
<div class="mobile-sticky-purchase-bar d-lg-none">
    <div class="d-flex align-items-center justify-content-between gap-3">
        <div>
            <div class="d-flex align-items-baseline gap-1.5">
                @if($sellPrice == 0)
                    <span class="fw-bold fs-5 text-success">FREE</span>
                @else
                    <span class="fw-bold fs-5 text-dark">₹{{ number_format($sellPrice) }}</span>
                    @if($mrpPrice > $sellPrice)
                        <span class="text-muted text-decoration-line-through small" style="font-size: 0.72rem;">₹{{ number_format($mrpPrice) }}</span>
                    @endif
                @endif
            </div>
            @if($mrpPrice > $sellPrice)
                <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.65rem;">
                    {{ $course->discount_percentage ?? $course->discount_text ?? round((($mrpPrice - $sellPrice)/$mrpPrice)*100) . '% OFF' }}
                </span>
            @endif
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm px-3 rounded-pill fw-semibold" onclick="addToCart({ id: '{{ $course->id }}', type: 'Course', title: '{{ addslashes($course->title) }}', price: {{ (float)$sellPrice }}, thumbnail: '{{ $course->thumbnail }}', seller_id: {{ $course->seller_id ?? 1 }} })" title="Add to Cart">
                <i class="fa-solid fa-cart-shopping"></i>
            </button>
            <form action="{{ route('course.enroll', $course->slug) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill fw-bold" style="background-color: #0066ff;">
                    Buy Now
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
