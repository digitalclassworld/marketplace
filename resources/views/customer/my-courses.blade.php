@extends('layouts.app')

@section('title', 'My Courses & Learning Portal - Digital Class World')

@section('styles')
<style>
    .learning-hero {
        background: linear-gradient(135deg, #0b192c 0%, #1e3a8a 50%, #0066ff 100%);
        color: #ffffff;
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .learning-hero::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .course-card-learning {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid #e2e8f0;
    }
    .course-card-learning:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 102, 255, 0.15) !important;
        border-color: #0066ff;
    }
    .progress-bar-glow {
        background: linear-gradient(90deg, #0066ff 0%, #00d2ff 100%);
    }
    .nav-pills-learning .nav-link {
        color: #64748b;
        font-weight: 600;
        border-radius: 999px;
        padding: 0.5rem 1.25rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .nav-pills-learning .nav-link.active {
        background-color: #0066ff;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="learning-hero">
    <div class="container position-relative" style="z-index: 2;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 rounded-pill small mb-2 fw-semibold">
                    <i class="fa-solid fa-graduation-cap me-1.5"></i> Student Learning Portal
                </span>
                <h1 class="h2 fw-bold mb-1 text-white">Welcome back, {{ $user->name }}!</h1>
                <p class="text-white text-opacity-75 small mb-0">Continue watching your video lectures, track your syllabus progress, and earn certificates.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2 fw-semibold">
                    <i class="fa-solid fa-receipt me-1.5"></i> Order History
                </a>
                <a href="{{ route('courses') }}" class="btn btn-light text-primary btn-sm rounded-pill px-3.5 py-2 fw-bold shadow-sm">
                    <i class="fa-solid fa-compass me-1.5"></i> Browse More Courses
                </a>
            </div>
        </div>
    </div>
</div>

<div class="py-4 bg-light" style="min-height: 60vh;">
    <div class="container">

        <!-- Flash alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Navigation Pills -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
            <ul class="nav nav-pills nav-pills-learning gap-2">
                <li class="nav-item">
                    <a href="{{ route('customer.my-courses', ['tab' => 'all']) }}" class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}">
                        All Enrolled ({{ $allCount }})
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.my-courses', ['tab' => 'in_progress']) }}" class="nav-link {{ $currentTab === 'in_progress' ? 'active' : '' }}">
                        In Progress ({{ $inProgressCount }})
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.my-courses', ['tab' => 'completed']) }}" class="nav-link {{ $currentTab === 'completed' ? 'active' : '' }}">
                        Completed ({{ $completedCount }})
                    </a>
                </li>
            </ul>

            <div class="text-muted small">
                <i class="fa-solid fa-circle-info text-primary me-1"></i> Lifetime access to all video lectures and updates.
            </div>
        </div>

        <!-- Enrolled Courses Grid -->
        @if($enrolledItems->isNotEmpty())
            <div class="row g-4 mb-5">
                @foreach($enrolledItems as $item)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card-learning bg-white">
                            <!-- Thumbnail with Play Overlay -->
                            <div class="position-relative overflow-hidden" style="height: 180px; background-color: #0b192c;">
                                <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="w-100 h-100" style="object-fit: cover;">
                                
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2.5 py-1 rounded-pill small fw-semibold">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                @if($item->is_completed)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-success text-white px-2.5 py-1 rounded-pill small fw-bold shadow-sm">
                                            <i class="fa-solid fa-award me-1"></i> Completed
                                        </span>
                                    </div>
                                @endif

                                <a href="{{ route('customer.course.learn', ['courseId' => $item->course_id, 'lessonId' => $item->last_watched_lesson_id]) }}" class="position-absolute top-50 start-50 translate-middle rounded-circle bg-primary bg-opacity-90 text-white d-flex align-items-center justify-content-center shadow" style="width: 52px; height: 52px; text-decoration: none;">
                                    <i class="fa-solid fa-play fs-5 ms-1"></i>
                                </a>
                            </div>

                            <!-- Course Body -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1 lh-sm" style="font-size: 1.05rem; min-height: 48px;">
                                        <a href="{{ route('customer.course.learn', ['courseId' => $item->course_id, 'lessonId' => $item->last_watched_lesson_id]) }}" class="text-dark text-decoration-none hover-primary">
                                            {{ $item->title }}
                                        </a>
                                    </h5>
                                    <div class="text-muted small mb-3 d-flex align-items-center gap-1.5">
                                        <i class="fa-solid fa-chalkboard-user text-primary"></i>
                                        <span>{{ $item->instructor }}</span>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center small mb-1">
                                            <span class="text-muted fw-semibold" style="font-size: 0.78rem;">
                                                {{ $item->completed_lessons }} of {{ $item->total_lessons }} lectures completed
                                            </span>
                                            <span class="fw-bold text-primary" style="font-size: 0.8rem;">
                                                {{ $item->progress_percent }}%
                                            </span>
                                        </div>
                                        <div class="progress" style="height: 6px; border-radius: 999px; background-color: #f1f5f9;">
                                            <div class="progress-bar progress-bar-glow" role="progressbar" style="width: {{ $item->progress_percent }}%;" aria-valuenow="{{ $item->progress_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-2 border-top d-flex gap-2">
                                    <a href="{{ route('customer.course.learn', ['courseId' => $item->course_id, 'lessonId' => $item->last_watched_lesson_id]) }}" class="btn btn-primary flex-fill rounded-pill py-2 fw-bold btn-sm d-flex align-items-center justify-content-center gap-2 shadow-sm">
                                        <i class="fa-solid {{ $item->progress_percent > 0 ? 'fa-circle-play' : 'fa-play' }}"></i>
                                        <span>{{ $item->progress_percent > 0 ? ($item->is_completed ? 'Rewatch Course' : 'Continue Learning') : 'Start Course' }}</span>
                                    </a>
                                    @if($item->is_completed || $item->progress_percent >= 100)
                                        <a href="{{ route('customer.course.certificate', ['courseId' => $item->course_id]) }}" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold btn-sm" title="Download Completion Certificate">
                                            <i class="fa-solid fa-certificate"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 mb-5 bg-white">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-book-open-reader fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">No Courses Found in this View</h4>
                <p class="text-muted small mb-4" style="max-width: 460px; margin-inline: auto;">
                    @if($currentTab === 'completed')
                        You haven't completed any courses yet. Select an in-progress course and finish all lectures to unlock your certificate.
                    @else
                        You haven't enrolled in any online courses yet. Browse our extensive catalogue of programming, design, and business courses to start learning!
                    @endif
                </p>
                <div>
                    <a href="{{ route('courses') }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                        <i class="fa-solid fa-magnifying-glass me-1.5"></i> Explore Courses
                    </a>
                </div>
            </div>
        @endif

        <!-- Popular Courses to Explore -->
        @if(isset($recommendedCourses) && $recommendedCourses->isNotEmpty())
            <div class="mt-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-0">Recommended for You</h4>
                        <p class="text-muted small mb-0">Expand your skills with these trending industry certifications</p>
                    </div>
                    <a href="{{ route('courses') }}" class="text-primary fw-semibold small text-decoration-none">View All &rarr;</a>
                </div>

                <div class="row g-3">
                    @foreach($recommendedCourses as $rec)
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                                <img src="{{ $rec->thumbnail_url }}" alt="{{ $rec->course_name }}" class="w-100" style="height: 140px; object-fit: cover;">
                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="badge bg-light text-muted small border mb-1.5">{{ $rec->category }}</span>
                                        <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $rec->course_name }}">{{ $rec->course_name }}</h6>
                                        <span class="text-primary fw-bold">₹{{ number_format($rec->price, 2) }}</span>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('elearn.course.show', ['id' => $rec->id, 'slug' => $rec->slug]) }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-semibold">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
