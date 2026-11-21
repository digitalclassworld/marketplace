@extends('layouts.app')

@section('title', ($tutor->name ?: 'Instructor') . ' - Courses & Profile | Digital Class')

@section('meta_description', Str::limit(strip_tags($tutor->about_self ?: ($tutor->name . ' online courses and professional training on Digital Class.')), 160))

@section('styles')
<style>
    .tutor-profile-header-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }
    .tutor-avatar-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        text-align: center;
    }
    .tutor-avatar-img {
        width: 100%;
        max-width: 250px;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 10px;
        background: #f8fafc;
    }
    .tutor-cred-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.92rem;
        color: #334155;
    }
    .tutor-cred-item:last-child {
        border-bottom: none;
    }
    .tutor-cred-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.95rem;
    }
    .tutor-course-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .tutor-course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.12);
        border-color: #00b074;
    }
    .tutor-course-thumb-box {
        position: relative;
        width: 100%;
        height: 170px;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    .tutor-course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .tutor-course-card:hover .tutor-course-thumb-box img {
        transform: scale(1.05);
    }
    .course-badge-flag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }
    .course-wish-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .course-wish-btn:hover {
        color: #ef4444;
        background: #ffffff;
    }
    .course-card-title-link {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.8em;
        text-decoration: none;
    }
    .course-card-title-link:hover {
        color: #0066ff;
    }
    .price-row-wrap {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 12px;
    }
    .price-current {
        font-size: 1.15rem;
        font-weight: 800;
        color: #111827;
    }
    .price-original {
        font-size: 0.85rem;
        color: #9ca3af;
        text-decoration: line-through;
    }
    .badge-discount-orange {
        background: #ff7a18;
        color: #ffffff;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
    }
    .btn-add-to-cart-green {
        background-color: #00b074;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 700;
        font-size: 0.88rem;
        text-align: center;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-add-to-cart-green:hover {
        background-color: #009663;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 176, 116, 0.35);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses') }}" class="text-decoration-none">E-Learning</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $tutor->name }}</li>
        </ol>
    </nav>

    <!-- Tutor Profile Header (Clean 2-Column Layout matching authentic DC design) -->
    <div class="tutor-profile-header-card mb-5">
        <div class="row g-4 align-items-center">
            <!-- Left: Tutor Profile Image & Quick Rating Card -->
            <div class="col-lg-4 col-xl-3 text-center">
                <div class="tutor-avatar-box">
                    <img src="{{ $tutor->profile_url }}" 
                         alt="{{ $tutor->name }}" 
                         class="tutor-avatar-img mb-3"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($tutor->name) }}&background=008060&color=fff&size=250';">
                    
                    <div class="d-flex align-items-center justify-content-center gap-1 text-warning mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span class="ms-1 fw-bold text-dark small">4.8 / 5.0</span>
                    </div>

                    @if(!empty($tutor->contact))
                        <a href="tel:{{ $tutor->contact }}" class="btn btn-outline-primary btn-sm w-100 fw-semibold mb-2">
                            <i class="fa-solid fa-phone me-1"></i> Contact Instructor
                        </a>
                    @endif

                    <div class="text-muted small">
                        <i class="fa-solid fa-book-open text-success me-1"></i> <strong>{{ count($courses) }}</strong> Published Courses
                    </div>
                </div>
            </div>

            <!-- Right: Tutor Info & Credentials -->
            <div class="col-lg-8 col-xl-9">
                <div class="mb-3">
                    <div class="text-primary small text-uppercase tracking-wider fw-bold mb-1">Hi, I am</div>
                    <h1 class="display-6 fw-bold text-dark mb-2" style="font-size: 2.1rem; line-height: 1.25;">
                        {{ $tutor->name }}
                    </h1>

                    <div class="d-flex flex-wrap align-items-center gap-2 my-2">
                        @if(!empty($tutor->expert_category))
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fs-6 rounded-pill">
                                <i class="fa-solid fa-tag me-1"></i> {{ $tutor->expert_category }}
                            </span>
                        @endif

                        @if(!empty($tutor->expert_in))
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 fs-6 rounded-pill">
                                <i class="fa-solid fa-certificate me-1"></i> {{ $tutor->expert_in }}
                            </span>
                        @endif

                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 small">
                            <i class="fa-solid fa-circle-check me-1"></i> Verified Instructor
                        </span>
                    </div>
                </div>

                @if(!empty($tutor->about_self))
                    <p class="text-secondary mb-4" style="font-size: 1rem; line-height: 1.7;">
                        {{ $tutor->about_self }}
                    </p>
                @endif

                <!-- Credentials List -->
                <div class="row g-2">
                    @if(!empty($tutor->education))
                        <div class="col-md-12">
                            <div class="tutor-cred-item">
                                <div class="tutor-cred-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark">Education &amp; Qualifications:</span>
                                    <span class="text-secondary ms-1">{{ $tutor->education }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($tutor->experience))
                        <div class="col-md-6">
                            <div class="tutor-cred-item">
                                <div class="tutor-cred-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark">Experience:</span>
                                    <span class="text-secondary ms-1">{{ $tutor->experience }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($tutor->language_known))
                        <div class="col-md-6">
                            <div class="tutor-cred-item">
                                <div class="tutor-cred-icon bg-success bg-opacity-10 text-success">
                                    <i class="fa-solid fa-language"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark">Languages:</span>
                                    <span class="text-secondary ms-1">{{ $tutor->language_known }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($tutor->city))
                        <div class="col-md-6">
                            <div class="tutor-cred-item">
                                <div class="tutor-cred-icon bg-danger bg-opacity-10 text-danger">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark">Location:</span>
                                    <span class="text-secondary ms-1">{{ $tutor->city }}{{ !empty($tutor->country) ? ', ' . $tutor->country : ', India' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($tutor->website))
                        <div class="col-md-6">
                            <div class="tutor-cred-item">
                                <div class="tutor-cred-icon bg-info bg-opacity-10 text-info">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark">Website:</span>
                                    <a href="{{ str_starts_with($tutor->website, 'http') ? $tutor->website : 'https://' . $tutor->website }}" target="_blank" class="ms-1 text-decoration-none fw-semibold">
                                        {{ $tutor->website }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- My Courses Section -->
    <div id="tutor-courses-section" class="mb-5">
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-2">
            <div>
                <h2 class="h3 fw-bold text-dark mb-0">
                    My Courses <span class="badge bg-primary bg-opacity-10 text-primary fs-6 ms-1">({{ count($courses) }})</span>
                </h2>
            </div>
            <span class="text-muted small">All certified courses by {{ $tutor->name }}</span>
        </div>

        @if(count($courses) > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($courses as $course)
                    <div class="col" id="course-{{ $course->id }}">
                        <div class="tutor-course-card">
                            <div class="tutor-course-thumb-box">
                                <a href="{{ $course->url }}" class="d-block w-100 h-100">
                                    <img src="{{ $course->thumbnail_url }}" 
                                         alt="{{ $course->course_name }}" 
                                         loading="lazy" 
                                         onerror="this.src='https://digitalclassworld.com/business-listing/public/camera_placeholder.png';">
                                </a>
                                <span class="course-badge-flag">{{ $course->level ?: 'All level' }}</span>
                                <button type="button" class="course-wish-btn" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>

                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <a href="{{ $course->url }}" class="course-card-title-link" title="{{ $course->course_name }}">
                                    {{ $course->course_name }}
                                </a>

                                <div class="mt-auto">
                                    @php
                                        $tSellPrice = (float)($course->selling_price ?? 0);
                                        $tMrpPrice = (float)($course->original_price ?? 0);
                                        if ($tSellPrice == 0) {
                                            if (isset($course->discount_price) && $course->discount_price > 0 && $course->price > $course->discount_price) {
                                                $tSellPrice = (float)$course->discount_price;
                                                $tMrpPrice = (float)$course->price;
                                            } else {
                                                $tSellPrice = (float)($course->price ?? 0);
                                            }
                                        }
                                        if ($tMrpPrice == 0 && isset($course->price) && $course->price > $tSellPrice) {
                                            $tMrpPrice = (float)$course->price;
                                        }
                                    @endphp
                                    <div class="price-row-wrap">
                                        <span class="price-current">₹{{ number_format($tSellPrice, 0) }}</span>
                                        @if($tMrpPrice > $tSellPrice && $tSellPrice > 0)
                                            <span class="price-original">₹{{ number_format($tMrpPrice, 0) }}</span>
                                            <span class="badge-discount-orange">{{ $course->discount_text ?? $course->discount_percentage ?? round((($tMrpPrice - $tSellPrice)/$tMrpPrice)*100) . '% off' }}</span>
                                        @elseif($tSellPrice == 0)
                                            <span class="price-original">₹0</span>
                                            <span class="badge-discount-orange">0% off</span>
                                        @endif
                                    </div>

                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="course">
                                        <input type="hidden" name="id" value="{{ $course->id }}">
                                        <input type="hidden" name="name" value="{{ $course->course_name }}">
                                        <input type="hidden" name="price" value="{{ $tSellPrice }}">
                                        <input type="hidden" name="image" value="{{ $course->thumbnail_url }}">
                                        <button type="submit" class="btn-add-to-cart-green">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Add To Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted">
                <i class="fa-solid fa-book-open fa-3x text-muted mb-3 opacity-50"></i>
                <h5>No courses currently listed</h5>
                <p class="small mb-0">Check back soon for new training sessions from this tutor.</p>
            </div>
        @endif
    </div>
</div>
@endsection
