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

    /* Sticky Sub-Navigation Tabs */
    .course-subnav-tabs {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 4px 8px;
        margin-bottom: 1.5rem;
        overflow-x: auto;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    }
    .course-subnav-link {
        display: inline-block;
        padding: 0.5rem 1.15rem;
        font-size: 0.825rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-radius: 999px;
        transition: all 0.2s ease;
    }
    .course-subnav-link:hover {
        color: #0066ff;
        background: #eff6ff;
    }
    .course-subnav-link.active {
        color: #0066ff;
        background: #eff6ff;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(0, 102, 255, 0.1);
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

    /* What Will You Learn Box */
    .what-you-learn-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 100%);
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        padding: 1.25rem 1.4rem;
        margin-bottom: 1.25rem;
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
                    <img src="{{ $course->thumbnail ?? 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&auto=format&fit=crop&q=80' }}" alt="{{ $course->title }}">
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
                    {{ $course->short_description ?: 'Learn SEO, Social Media, Google Ads, Content Marketing, Email Marketing and AI Tools. Step by step practical training with live projects and certification.' }}
                </p>

                <!-- Instructor Byline -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ $course->instructor_url ?: '#' }}" class="text-decoration-none">
                        <img src="{{ $course->instructor_avatar }}" alt="{{ $course->instructor_name }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
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
         3. STICKY SUB-NAVIGATION TABS
         ======================================================================== -->
    <div class="course-subnav-tabs">
        <a href="#overview" class="course-subnav-link active">Overview</a>
        <a href="#curriculum" class="course-subnav-link">Curriculum</a>
        <a href="#instructor" class="course-subnav-link">Instructor</a>
        <a href="#reviews" class="course-subnav-link">Reviews</a>
        <a href="#faqs" class="course-subnav-link">FAQs</a>
    </div>

    <!-- ========================================================================
         4. TWO-COLUMN MAIN CONTENT (LEFT SECTIONS + RIGHT STICKY BUY CARD)
         ======================================================================== -->
    <div class="row g-3">
        
        <!-- Left Column: Course In-Depth Details -->
        <div class="col-lg-8">
            
            <!-- What Will You Learn Box -->
            <div id="overview" class="what-you-learn-box">
                <h2 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">What Will You Learn?</h2>
                
                <div class="row g-2">
                    <div class="col-md-6">
                        @foreach(array_slice($learningPoints, 0, 5) as $lp)
                            <div class="learn-point-check">
                                <i class="fa-solid fa-circle-check text-success fs-6 mt-1 flex-shrink-0"></i>
                                <span>{{ $lp }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        @foreach(array_slice($learningPoints, 5, 5) as $lp)
                            <div class="learn-point-check">
                                <i class="fa-solid fa-circle-check text-success fs-6 mt-1 flex-shrink-0"></i>
                                <span>{{ $lp }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Two Promotional Mini Banners -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <a href="{{ route('course.certificate', $course->slug ?? 'digital-marketing-complete-course-2026') }}" class="text-decoration-none d-block h-100" title="View & Download Official Course Certificate">
                        <div class="cert-promo-banner d-flex align-items-center justify-content-between h-100" style="transition: transform 0.2s ease, box-shadow 0.2s ease;">
                            <div>
                                <div class="fw-bold text-primary mb-1 d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                                    <i class="fa-solid fa-award me-1"></i> Get Certified & Boost Your Career
                                    <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">Download PDF</span>
                                </div>
                                <p class="text-secondary small mb-0" style="font-size: 0.72rem; line-height: 1.35;">
                                    Complete this course and get a verified certificate from Digital Class - Educational World.
                                </p>
                            </div>
                            <div class="ms-2 flex-shrink-0">
                                <i class="fa-solid fa-certificate text-warning" style="font-size: 2.25rem; opacity: 0.95;"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <div class="learn-anywhere-banner d-flex align-items-center justify-content-between h-100">
                        <div>
                            <div class="fw-bold text-purple mb-1" style="font-size: 0.85rem; color: #7e22ce;">
                                <i class="fa-solid fa-laptop-code me-1"></i> Learn from Anywhere
                            </div>
                            <p class="text-secondary small mb-0" style="font-size: 0.72rem; line-height: 1.35;">
                                Access on Mobile, Tablet & Desktop. Learn anytime, anywhere at your own schedule.
                            </p>
                        </div>
                        <div class="ms-2 flex-shrink-0">
                            <i class="fa-solid fa-mobile-screen-button text-purple" style="font-size: 2.25rem; color: #9333ea; opacity: 0.85;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Curriculum Section -->
            <div id="curriculum" class="section-card-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="section-card-title mb-0">Course Curriculum</h2>
                    <span class="text-muted small" style="font-size: 0.75rem;">
                        {{ count($curriculum) }} Modules &bull; 60+ Lectures &bull; 45h Total Length
                    </span>
                </div>

                <div class="accordion accordion-curriculum" id="courseAccordion">
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
            </div>

            <!-- About the Instructor Section -->
            <div id="instructor" class="section-card-white">
                <h2 class="section-card-title mb-3">About the Instructor</h2>
                
                <div class="d-flex align-items-start gap-3 mb-3">
                    <img src="{{ $course->instructor_avatar }}" alt="{{ $course->instructor_name }}" class="rounded-circle border" style="width: 68px; height: 68px; object-fit: cover;">
                    
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ $course->instructor_url ?: '#' }}" class="text-decoration-none">
                                <h4 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $course->instructor_name }}</h4>
                            </a>
                            <span class="badge bg-primary text-white py-1 px-2" style="font-size: 0.65rem;">Top Instructor</span>
                        </div>
                        <div class="text-primary small fw-semibold" style="font-size: 0.78rem;">{{ $course->instructor_subtitle ?? ($course->instructor_category . ' Expert') }}</div>
                        <div class="text-muted small" style="font-size: 0.72rem;">Authentic educator &amp; course creator on Digital Class</div>

                        <!-- 4 Instructor Stats -->
                        <div class="d-flex flex-wrap gap-3 mt-2 font-monospace" style="font-size: 0.72rem;">
                            <span><i class="fa-solid fa-users text-primary me-1"></i> <strong>50,000+</strong> Students</span>
                            <span><i class="fa-solid fa-book text-success me-1"></i> <strong>15+</strong> Courses</span>
                            <span><i class="fa-solid fa-star text-warning me-1"></i> <strong>4.8</strong> Rating</span>
                            <span><i class="fa-solid fa-briefcase text-info me-1"></i> <strong>200+</strong> Live Projects</span>
                        </div>

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

            <!-- Student Reviews Section -->
            <div id="reviews" class="section-card-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="section-card-title mb-0">Student Reviews</h2>
                    <button type="button" class="btn btn-outline-primary btn-sm py-1 px-3 fw-semibold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#reviewCourseModal">
                        Write a Review
                    </button>
                </div>

                <div class="row align-items-center g-3 mb-4">
                    <!-- Left Score Box -->
                    <div class="col-md-4 text-center border-end">
                        <div class="fw-bold text-dark" style="font-size: 2.75rem; line-height: 1;">4.8</div>
                        <div class="text-warning small my-1">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <div class="text-muted small" style="font-size: 0.75rem;">1,250 reviews</div>
                    </div>

                    <!-- Middle Rating Bars -->
                    <div class="col-md-8">
                        <div class="rating-bar-container">
                            <span style="width: 45px;">5 Star</span>
                            <div class="rating-progress-track">
                                <div class="rating-progress-fill" style="width: 82%;"></div>
                            </div>
                            <span style="width: 30px;">82%</span>
                        </div>
                        <div class="rating-bar-container">
                            <span style="width: 45px;">4 Star</span>
                            <div class="rating-progress-track">
                                <div class="rating-progress-fill" style="width: 13%;"></div>
                            </div>
                            <span style="width: 30px;">13%</span>
                        </div>
                        <div class="rating-bar-container">
                            <span style="width: 45px;">3 Star</span>
                            <div class="rating-progress-track">
                                <div class="rating-progress-fill" style="width: 3%;"></div>
                            </div>
                            <span style="width: 30px;">3%</span>
                        </div>
                        <div class="rating-bar-container">
                            <span style="width: 45px;">2 Star</span>
                            <div class="rating-progress-track">
                                <div class="rating-progress-fill" style="width: 1%;"></div>
                            </div>
                            <span style="width: 30px;">1%</span>
                        </div>
                        <div class="rating-bar-container">
                            <span style="width: 45px;">1 Star</span>
                            <div class="rating-progress-track">
                                <div class="rating-progress-fill" style="width: 1%;"></div>
                            </div>
                            <span style="width: 30px;">1%</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Cards Row -->
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
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm" style="background-color: #0066ff; border: none; font-size: 0.875rem; border-radius: 8px;">
                        Buy Now
                    </button>
                </form>

                <button type="button" class="btn btn-outline-primary w-100 fw-semibold py-2 mb-3" style="font-size: 0.8rem; border-radius: 8px;" onclick="addToCart({ id: '{{ $course->id }}', type: 'Course', title: '{{ addslashes($course->title) }}', price: {{ (float)$sellPrice }}, thumbnail: '{{ $course->thumbnail }}', seller_id: {{ $course->seller_id ?? 1 }} })">
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
                            <img src="{{ $rc->thumbnail }}" alt="{{ $rc->title }}" class="related-thumb-img">
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
