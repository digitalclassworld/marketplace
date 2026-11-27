@extends('customer.layouts.customer')

@section('title', 'My Learning Portal & Courses - Digital Class World')

@section('styles')
<style>
    .learning-hero {
        background: linear-gradient(135deg, #091e3a 0%, #173878 50%, #0066ff 100%);
        color: #ffffff;
        padding: 2.75rem 0 2.25rem;
        position: relative;
        overflow: hidden;
    }
    .learning-hero::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -80px;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(0, 210, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .stat-metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.15rem 1.25rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        cursor: pointer;
    }
    .stat-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 102, 255, 0.08);
        border-color: #0066ff;
    }
    .hero-resume-card {
        background: #ffffff;
        border: 1.5px solid #dbeafe;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(0, 102, 255, 0.12);
        overflow: hidden;
        transition: all 0.25s ease;
    }
    .hero-resume-card:hover {
        border-color: #0066ff;
        box-shadow: 0 16px 36px -6px rgba(0, 102, 255, 0.18);
    }
    .course-card-learning {
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: #ffffff;
        overflow: hidden;
    }
    .course-card-learning:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px -6px rgba(0, 102, 255, 0.14) !important;
        border-color: #0066ff;
    }
    .progress-bar-learning {
        background: linear-gradient(90deg, #0066ff 0%, #00d2ff 100%);
    }
    .nav-pills-learning .nav-link {
        color: #64748b;
        font-weight: 600;
        border-radius: 999px;
        padding: 0.5rem 1.25rem;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    .nav-pills-learning .nav-link:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .nav-pills-learning .nav-link.active {
        background-color: #0066ff;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.25);
    }
    .search-input-learning {
        border: 1.5px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.55rem 1.25rem 0.55rem 2.65rem;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .search-input-learning:focus {
        border-color: #0066ff;
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
        outline: none;
    }
    .next-lecture-pill {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
        color: #334155;
    }
</style>
@endsection

@section('content')
<!-- Hero Header Section -->
<div class="learning-hero">
    <div class="container position-relative" style="z-index: 2;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span class="badge bg-white px-3 py-1.5 rounded-pill small mb-2 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm" style="color: #000000 !important; background-color: #ffffff !important; border: 1.5px solid #ffffff;">
                    <i class="fa-solid fa-graduation-cap" style="color: #000000 !important;"></i> Student Learning Portal
                </span>
                <h1 class="h2 fw-bold mb-1 text-white">Welcome back, {{ $user->name }}!</h1>
                <p class="text-white text-opacity-75 small mb-0">Track your video progress, study with personal notes, and earn recognized course completion certificates.</p>
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

<div class="py-4 bg-light" style="min-height: 70vh;">
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

        <!-- Student Key Metrics Strip -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <a href="{{ route('customer.my-courses', ['tab' => 'in_progress']) }}" class="text-decoration-none">
                    <div class="stat-metric-card h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">In Progress</span>
                            <h3 class="fw-bold text-dark mt-0.5 mb-0 fs-4">{{ $stats['in_progress'] ?? 0 }}</h3>
                            <span class="text-primary small fw-medium" style="font-size: 0.75rem;">Active Courses</span>
                        </div>
                        <div class="rounded-circle p-2.5 bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-spinner fs-5"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ route('customer.my-courses', ['tab' => 'completed']) }}" class="text-decoration-none">
                    <div class="stat-metric-card h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Completed</span>
                            <h3 class="fw-bold text-success mt-0.5 mb-0 fs-4">{{ $stats['completed'] ?? 0 }}</h3>
                            <span class="text-success small fw-medium" style="font-size: 0.75rem;">100% Finished</span>
                        </div>
                        <div class="rounded-circle p-2.5 bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-metric-card h-100 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Lectures Watched</span>
                        <h3 class="fw-bold text-dark mt-0.5 mb-0 fs-4">{{ $stats['total_lectures_finished'] ?? 0 }}</h3>
                        <span class="text-muted small fw-medium" style="font-size: 0.75rem;">of {{ $stats['total_lectures_count'] ?? 0 }} total lectures</span>
                    </div>
                    <div class="rounded-circle p-2.5 bg-info bg-opacity-10 text-info">
                        <i class="fa-solid fa-play fs-5"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-metric-card h-100 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Certificates</span>
                        <h3 class="fw-bold text-warning mt-0.5 mb-0 fs-4">{{ $stats['certificates_count'] ?? 0 }}</h3>
                        <span class="text-warning small fw-medium" style="font-size: 0.75rem;">Available to Download</span>
                    </div>
                    <div class="rounded-circle p-2.5 bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-award fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jump Back In: Hero Quick Resume Card (if user has active course) -->
        @if(isset($heroCourse) && $heroCourse)
            <div class="hero-resume-card p-4 mb-4 bg-white">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="position-relative rounded-4 overflow-hidden shadow-sm" style="height: 160px; background-color: #0b192c;">
                            <img src="{{ $heroCourse->thumbnail }}" alt="{{ $heroCourse->title }}" class="w-100 h-100" style="object-fit: cover;">
                            <a href="{{ route('customer.course.learn', ['courseId' => $heroCourse->course_id, 'lessonId' => $heroCourse->last_watched_lesson_id]) }}" class="position-absolute top-50 start-50 translate-middle rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px; text-decoration: none;">
                                <i class="fa-solid fa-play fs-5 ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="d-flex align-items-center gap-2 mb-1.5">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 rounded-pill small fw-semibold">
                                <i class="fa-solid fa-bolt me-1"></i> Jump Back In
                            </span>
                            <span class="badge bg-light text-muted border small">{{ $heroCourse->category }}</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">
                            <a href="{{ route('customer.course.learn', ['courseId' => $heroCourse->course_id, 'lessonId' => $heroCourse->last_watched_lesson_id]) }}" class="text-dark text-decoration-none">
                                {{ $heroCourse->title }}
                            </a>
                        </h4>
                        <div class="text-muted small mb-3">
                            Instructor: <strong>{{ $heroCourse->instructor }}</strong>
                        </div>

                        <!-- Up Next Lecture -->
                        @if($heroCourse->next_up_lesson)
                            <div class="next-lecture-pill mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-circle-play text-primary fs-5"></i>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">
                                            Up Next: Lecture {{ $heroCourse->next_up_lesson->lesson_no ?? 1 }} - {{ $heroCourse->next_up_lesson->lesson_name ?? 'Video Lecture' }}
                                        </div>
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            {{ $heroCourse->next_up_lesson->chapter_name ?? 'Current Module' }} • Duration: {{ $heroCourse->next_up_lesson->duration ?? '15:00' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Progress Bar & CTA -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="flex-grow-1" style="max-width: 380px;">
                                <div class="d-flex justify-content-between small fw-semibold text-muted mb-1">
                                    <span>Course Progress</span>
                                    <span class="text-primary">{{ $heroCourse->progress_percent }}% ({{ $heroCourse->completed_lessons }}/{{ $heroCourse->total_lessons }} Lectures)</span>
                                </div>
                                <div class="progress" style="height: 7px; border-radius: 999px; background-color: #e2e8f0;">
                                    <div class="progress-bar progress-bar-learning" role="progressbar" style="width: {{ $heroCourse->progress_percent }}%;"></div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('customer.course.learn', ['courseId' => $heroCourse->course_id, 'lessonId' => $heroCourse->last_watched_lesson_id]) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-play"></i>
                                    <span>{{ $heroCourse->progress_percent > 0 ? 'Resume Learning' : 'Start Course' }}</span>
                                </a>
                                @if($heroCourse->is_completed)
                                    <a href="{{ route('customer.course.certificate', ['courseId' => $heroCourse->course_id]) }}" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold">
                                        <i class="fa-solid fa-award me-1"></i> Certificate
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter, Search & View Controls -->
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                
                <!-- Pills Navigation -->
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

                <!-- Live Search Box & Sort -->
                <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-sm-end" style="max-width: 480px;">
                    <div class="position-relative flex-grow-1">
                        <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 13px; left: 14px;"></i>
                        <input type="text" id="courseSearchInput" class="form-control search-input-learning w-100" placeholder="Search course by title or tutor..." value="{{ $search }}" oninput="filterCoursesClientSide()">
                    </div>

                    <select id="courseSortSelect" class="form-select rounded-pill small py-2 px-3 fw-semibold text-secondary" style="width: auto; font-size: 0.82rem;" onchange="sortCoursesClientSide()">
                        <option value="recent">Recently Studied</option>
                        <option value="progress_high">Highest Progress</option>
                        <option value="progress_low">Lowest Progress</option>
                        <option value="title">Course Title (A-Z)</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Enrolled Courses Grid -->
        @if($enrolledItems->isNotEmpty())
            <div class="row g-4 mb-5" id="enrolledCoursesGrid">
                @foreach($enrolledItems as $item)
                    <div class="col-12 col-md-6 col-lg-4 course-card-wrapper" 
                         data-title="{{ strtolower($item->title) }}" 
                         data-instructor="{{ strtolower($item->instructor) }}" 
                         data-progress="{{ $item->progress_percent }}">
                        <div class="card h-100 course-card-learning">
                            
                            <!-- Thumbnail with Play Overlay -->
                            <div class="position-relative overflow-hidden" style="height: 180px; background-color: #0b192c;">
                                <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="w-100 h-100" style="object-fit: cover;">
                                
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2.5 py-1 rounded-pill small fw-semibold">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                <div class="position-absolute top-0 end-0 m-3">
                                    @if($item->is_completed)
                                        <span class="badge bg-success text-white px-2.5 py-1 rounded-pill small fw-bold shadow-sm">
                                            <i class="fa-solid fa-award me-1"></i> Completed
                                        </span>
                                    @elseif($item->progress_percent > 0)
                                        <span class="badge bg-primary text-white px-2.5 py-1 rounded-pill small fw-bold shadow-sm">
                                            {{ $item->progress_percent }}%
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-75 text-white px-2.5 py-1 rounded-pill small fw-semibold">
                                            Not Started
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('customer.course.learn', ['courseId' => $item->course_id, 'lessonId' => $item->last_watched_lesson_id]) }}" class="position-absolute top-50 start-50 translate-middle rounded-circle bg-primary bg-opacity-90 text-white d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px; text-decoration: none;">
                                    <i class="fa-solid fa-play fs-5 ms-1"></i>
                                </a>
                            </div>

                            <!-- Course Body -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1 lh-sm" style="font-size: 1.05rem; min-height: 48px;">
                                        <a href="{{ route('customer.course.learn', ['courseId' => $item->course_id, 'lessonId' => $item->last_watched_lesson_id]) }}" class="text-dark text-decoration-none">
                                            {{ $item->title }}
                                        </a>
                                    </h5>
                                    
                                    <div class="text-muted small mb-3 d-flex align-items-center gap-1.5">
                                        <i class="fa-solid fa-chalkboard-user text-primary"></i>
                                        <span>{{ $item->instructor }}</span>
                                    </div>

                                    <!-- Next up lecture preview -->
                                    @if($item->next_up_lesson)
                                        <div class="next-lecture-pill mb-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-play text-primary" style="font-size: 0.75rem;"></i>
                                                <span class="text-truncate" style="font-size: 0.78rem;">
                                                    Next: {{ $item->next_up_lesson->lesson_name ?? 'Next Video Lecture' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

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
                                            <div class="progress-bar progress-bar-learning" role="progressbar" style="width: {{ $item->progress_percent }}%;" aria-valuenow="{{ $item->progress_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-2 border-top d-flex gap-2">
                                    <a href="{{ route('customer.course.learn', ['courseId' => $item->course_id, 'lessonId' => $item->last_watched_lesson_id]) }}" class="btn btn-primary flex-fill rounded-pill py-2 fw-bold btn-sm d-flex align-items-center justify-content-center gap-2 shadow-sm">
                                        <i class="fa-solid {{ $item->progress_percent > 0 ? 'fa-circle-play' : 'fa-play' }}"></i>
                                        <span>{{ $item->progress_percent > 0 ? ($item->is_completed ? 'Rewatch Course' : 'Resume Learning') : 'Start Course' }}</span>
                                    </a>
                                    
                                    @if($item->is_completed)
                                        <a href="{{ route('customer.course.certificate', ['courseId' => $item->course_id]) }}" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold btn-sm" title="Download Completion Certificate">
                                            <i class="fa-solid fa-award"></i>
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No search results placeholder -->
            <div id="noSearchCoursesFound" class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 mb-5 bg-white d-none">
                <i class="fa-solid fa-magnifying-glass text-muted fs-1 mb-2"></i>
                <h5 class="fw-bold text-dark mb-1">No Courses Found</h5>
                <p class="text-muted small mb-0">No enrolled courses matched your search query. Try clearing the search filter.</p>
            </div>
        @else
            <!-- Empty State -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 mb-5 bg-white">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-book-open-reader fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">No Courses Enrolled Yet</h4>
                <p class="text-muted small mb-4" style="max-width: 480px; margin-inline: auto;">
                    @if($currentTab === 'completed')
                        You haven't completed any courses yet. Choose one of your enrolled courses and watch all lectures to unlock your verified certificate.
                    @else
                        Explore our extensive catalogue of programming, business, accounts, and creative skills. When you purchase or enroll in any course, it immediately appears right here with full lifetime video access!
                    @endif
                </p>
                <div>
                    <a href="{{ route('courses') }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                        <i class="fa-solid fa-compass me-1.5"></i> Explore All Courses
                    </a>
                </div>
            </div>
        @endif

        <!-- Popular Courses to Explore -->
        @if(isset($recommendedCourses) && $recommendedCourses->isNotEmpty())
            <div class="mt-5 pt-3 border-top">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-0">Trending Certifications to Explore</h4>
                        <p class="text-muted small mb-0">Expand your career portfolio with these in-demand courses</p>
                    </div>
                    <a href="{{ route('courses') }}" class="text-primary fw-semibold small text-decoration-none">View All &rarr;</a>
                </div>

                <div class="row g-3">
                    @foreach($recommendedCourses as $rec)
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white course-card-learning">
                                <img src="{{ $rec->thumbnail_url }}" alt="{{ $rec->course_name }}" class="w-100" style="height: 140px; object-fit: cover;">
                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="badge bg-light text-muted small border mb-1.5">{{ $rec->category }}</span>
                                        <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $rec->course_name }}">{{ $rec->course_name }}</h6>
                                        <span class="text-primary fw-bold">₹{{ number_format($rec->price, 2) }}</span>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('elearn.course.show', ['id' => $rec->id, 'slug' => $rec->slug]) }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-semibold">
                                            View Course
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

@section('scripts')
<script>
function filterCoursesClientSide() {
    const query = document.getElementById('courseSearchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.course-card-wrapper');
    let visibleCount = 0;

    cards.forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const instructor = card.getAttribute('data-instructor') || '';
        
        if (title.includes(query) || instructor.includes(query)) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const noResults = document.getElementById('noSearchCoursesFound');
    if (noResults) {
        if (visibleCount === 0 && cards.length > 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }
}

function sortCoursesClientSide() {
    const sortVal = document.getElementById('courseSortSelect').value;
    const grid = document.getElementById('enrolledCoursesGrid');
    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll('.course-card-wrapper'));

    cards.sort((a, b) => {
        if (sortVal === 'progress_high') {
            return parseInt(b.getAttribute('data-progress')) - parseInt(a.getAttribute('data-progress'));
        } else if (sortVal === 'progress_low') {
            return parseInt(a.getAttribute('data-progress')) - parseInt(b.getAttribute('data-progress'));
        } else if (sortVal === 'title') {
            return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
        }
        return 0; // Default order
    });

    cards.forEach(card => grid.appendChild(card));
}
</script>
@endsection
