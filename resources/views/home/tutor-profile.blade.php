@extends('layouts.app')

@section('title', ($tutor->name ?: 'Instructor') . ' - Courses & Profile | Digital Class')

@section('meta_description', Str::limit(strip_tags($tutor->about_self ?: ($tutor->name . ' online courses and professional training on Digital Class.')), 160))

@section('styles')
<style>
    .tutor-cover-banner {
        height: 220px;
        background-color: #0066ff;
        background-size: cover;
        background-position: center;
        border-radius: 16px;
        position: relative;
    }
    .tutor-profile-card {
        margin-top: -65px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 1.75rem;
    }
    .tutor-avatar-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        background: #fff;
    }
    .tutor-meta-badge {
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .trending-course-card {
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
    .trending-course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.1);
        border-color: #00b074;
    }
    .trending-course-thumb-box {
        position: relative;
        width: 100%;
        height: 175px;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    .trending-course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .trending-course-card:hover .trending-course-thumb-box img {
        transform: scale(1.05);
    }
    .trending-crown-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 28px;
        height: 28px;
        background: rgba(17, 24, 39, 0.85);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
        font-size: 13px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    }
    .level-pill-badge {
        background: #fff4eb;
        color: #ff7a18;
        border-radius: 6px;
        padding: 3px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 8px;
    }
    .course-card-title {
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
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses') }}" class="text-decoration-none">E-Learning</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $tutor->name }}</li>
        </ol>
    </nav>

    <!-- Tutor Cover Banner -->
    <div class="tutor-cover-banner" style="background-image: url('{{ $tutor->cover_url }}');"></div>

    <!-- Tutor Header Info Card -->
    <div class="tutor-profile-card mb-4">
        <div class="d-flex flex-column flex-md-row gap-4 align-items-start">
            <img src="{{ $tutor->profile_url }}" alt="{{ $tutor->name }}" class="tutor-avatar-img">
            
            <div class="flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h1 class="h3 fw-bold text-dark mb-0">{{ $tutor->name }}</h1>
                    @if(strtolower($tutor->verified ?? '') === 'yes' || strtolower($tutor->status ?? '') === 'active')
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 small">
                            <i class="fa-solid fa-circle-check me-1"></i> Verified Instructor
                        </span>
                    @endif
                </div>

                @if(!empty($tutor->company_name) && $tutor->company_name !== $tutor->name)
                    <div class="text-muted fw-semibold small mb-2">{{ $tutor->company_name }} &bull; {{ $tutor->company_type ?: 'Organization' }}</div>
                @endif

                <div class="d-flex flex-wrap gap-2 my-2">
                    @if(!empty($tutor->expert_category))
                        <span class="tutor-meta-badge bg-primary-subtle text-primary">
                            <i class="fa-solid fa-tag"></i> {{ $tutor->expert_category }}
                        </span>
                    @endif
                    @if(!empty($tutor->expert_in))
                        <span class="tutor-meta-badge bg-info-subtle text-info">
                            <i class="fa-solid fa-certificate"></i> {{ $tutor->expert_in }}
                        </span>
                    @endif
                    @if(!empty($tutor->experience))
                        <span class="tutor-meta-badge bg-warning-subtle text-warning-emphasis">
                            <i class="fa-solid fa-clock-rotate-left"></i> {{ $tutor->experience }} Experience
                        </span>
                    @endif
                    @if(!empty($tutor->city))
                        <span class="tutor-meta-badge bg-light text-secondary border">
                            <i class="fa-solid fa-location-dot text-danger"></i> {{ $tutor->city }}{{ !empty($tutor->country) ? ', ' . $tutor->country : '' }}
                        </span>
                    @endif
                </div>

                <div class="d-flex flex-wrap gap-3 mt-3 text-secondary small">
                    @if(!empty($tutor->language_known))
                        <div><i class="fa-solid fa-language text-primary me-1"></i> <strong>Languages:</strong> {{ $tutor->language_known }}</div>
                    @endif
                    <div><i class="fa-solid fa-book-open text-success me-1"></i> <strong>Published Courses:</strong> {{ count($courses) }}</div>
                    @if(!empty($tutor->website))
                        <div>
                            <i class="fa-solid fa-globe text-info me-1"></i> 
                            <a href="{{ str_starts_with($tutor->website, 'http') ? $tutor->website : 'https://' . $tutor->website }}" target="_blank" class="text-decoration-none fw-semibold">
                                {{ $tutor->website }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Action / Inquiry -->
            <div class="d-flex flex-column gap-2 text-md-end w-100 w-md-auto mt-2 mt-md-0">
                <a href="#tutor-courses-section" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">
                    <i class="fa-solid fa-graduation-cap me-1"></i> View Courses ({{ count($courses) }})
                </a>
                @if(!empty($tutor->contact))
                    <a href="tel:{{ $tutor->contact }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold small">
                        <i class="fa-solid fa-phone me-1"></i> Contact Instructor
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Grid: About & Education -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <!-- About Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold text-dark mb-3"><i class="fa-regular fa-id-badge text-primary me-2"></i> About the Instructor</h4>
                <div class="text-secondary" style="font-size: 0.95rem; line-height: 1.8; white-space: pre-line;">
                    {{ $tutor->about_self ?: ($tutor->name . ' is an experienced certified professional educator offering comprehensive career-focused courses.') }}
                </div>

                @if(!empty($tutor->education))
                    <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-primary">
                        <div class="fw-bold text-dark small mb-1"><i class="fa-solid fa-graduation-cap me-1 text-primary"></i> Education & Qualifications</div>
                        <div class="text-secondary small">{{ $tutor->education }}</div>
                    </div>
                @endif
            </div>

            <!-- Courses Section -->
            <div id="tutor-courses-section">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">
                            Courses by {{ $tutor->name }}
                        </h3>
                        <p class="text-muted small mb-0">Browse all verified e-learning courses provided by this tutor</p>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ count($courses) }} Available</span>
                </div>

                @if(count($courses) > 0)
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-3 g-3">
                        @foreach($courses as $course)
                            <div class="col" id="course-{{ $course->id }}">
                                <div class="trending-course-card">
                                    <div class="trending-course-thumb-box">
                                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->course_name }}" loading="lazy" onerror="this.src='https://digitalclassworld.com/business-listing/public/camera_placeholder.png';">
                                        <div class="trending-crown-badge">
                                            <i class="fa-solid fa-crown"></i>
                                        </div>
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <div>
                                            <span class="level-pill-badge">{{ $course->level }}</span>
                                            <h5 class="course-card-title" title="{{ $course->course_name }}">
                                                {{ $course->course_name }}
                                            </h5>
                                        </div>

                                        <div class="mt-auto">
                                            <div class="price-row-wrap">
                                                <span class="price-current">₹{{ number_format($course->price, 0) }}</span>
                                                @if($course->original_price > 0 && $course->original_price > $course->price)
                                                    <span class="price-original">₹{{ number_format($course->original_price, 0) }}</span>
                                                @elseif($course->price == 0)
                                                    <span class="price-original">₹0</span>
                                                @endif
                                                <span class="badge-discount-orange">{{ $course->discount_text }}</span>
                                            </div>

                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="course">
                                                <input type="hidden" name="id" value="{{ $course->id }}">
                                                <input type="hidden" name="name" value="{{ $course->course_name }}">
                                                <input type="hidden" name="price" value="{{ $course->price }}">
                                                <input type="hidden" name="image" value="{{ $course->thumbnail_url }}">
                                                <button type="submit" class="btn-add-to-cart-green">
                                                    <i class="fa-solid fa-cart-shopping"></i> Add To Cart
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

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 20px;">
                <h5 class="fw-bold text-dark mb-3">Instructor Highlights</h5>
                
                <ul class="list-unstyled mb-4 d-flex flex-column gap-3 small text-secondary">
                    <li class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-award text-warning fs-5"></i>
                        <div>
                            <div class="fw-bold text-dark">Verified & Certified</div>
                            <div>Background checked & recognized by Digital Class</div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-graduate text-primary fs-5"></i>
                        <div>
                            <div class="fw-bold text-dark">Career Focused</div>
                            <div>Practical lessons designed for industry standards</div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-headset text-success fs-5"></i>
                        <div>
                            <div class="fw-bold text-dark">Direct Support</div>
                            <div>Ask questions & get guidance directly from tutor</div>
                        </div>
                    </li>
                </ul>

                <hr class="my-3">

                <div class="small text-muted mb-2">Share this tutor profile:</div>
                <div class="d-flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($tutor->url) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($tutor->url) }}&text={{ urlencode($tutor->name) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($tutor->name . ' - ' . $tutor->url) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($tutor->url) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

