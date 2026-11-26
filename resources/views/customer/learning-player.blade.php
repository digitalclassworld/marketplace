@extends('layouts.app')

@section('title', ($currentLesson ? $currentLesson->lesson_name . ' - ' : '') . ($course->title ?? $course->course_name) . ' - Online Learning Classroom')

@section('styles')
<style>
    /* ==========================================================================
       DISTRACTION-FREE LMS CLASSROOM (Fullscreen Cinema Experience)
       ========================================================================== */
    /* Hide general marketplace headers and footers to give 100% screen space to student */
    .dc-navbar, 
    footer.dc-footer, 
    .dc-mobile-bottom-dock,
    .top-notice-bar {
        display: none !important;
    }
    body {
        background-color: #0b1320 !important;
        overflow-x: hidden;
        margin: 0 !important;
        padding: 0 !important;
    }
    main.flex-grow-1 {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Top Classroom Header */
    .classroom-navbar {
        background-color: #08111e;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        padding: 0.75rem 1.75rem;
        position: sticky;
        top: 0;
        z-index: 1030;
    }

    /* Main Container & Layout */
    .classroom-wrapper {
        background-color: #f1f5f9;
        min-height: calc(100vh - 65px);
        padding: 1.5rem 2rem 4rem;
        transition: all 0.3s ease;
    }

    /* ==========================================================================
       CINEMA VIDEO STAGE (Massive, Widescreen, Immersive)
       ========================================================================== */
    .cinema-stage {
        background-color: #000000;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.08);
        position: relative;
        width: 100%;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    .video-viewport {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Standard widescreen */
        min-height: 480px;
        max-height: 76vh;
        background-color: #000000;
    }
    @media (min-width: 992px) {
        .video-viewport {
            min-height: 560px;
        }
    }
    @media (min-width: 1400px) {
        .video-viewport {
            min-height: 640px;
        }
    }
    .video-viewport iframe,
    .video-viewport video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Cinema Stage Floating Controls overlay (for instant Fullscreen & Theater) */
    .cinema-overlay-controls {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 20;
        display: flex;
        gap: 8px;
        opacity: 0.85;
        transition: opacity 0.2s ease;
    }
    .cinema-stage:hover .cinema-overlay-controls {
        opacity: 1;
    }
    .btn-cinema-ctrl {
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-cinema-ctrl:hover {
        background: #0066ff;
        color: #ffffff;
        border-color: #0066ff;
        transform: translateY(-1px);
    }

    /* True Native Fullscreen Mode */
    .cinema-stage:fullscreen,
    .cinema-stage:-webkit-full-screen {
        width: 100vw !important;
        height: 100vh !important;
        max-height: 100vh !important;
        border-radius: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
    }
    .cinema-stage:fullscreen .video-viewport,
    .cinema-stage:-webkit-full-screen .video-viewport {
        height: 100vh !important;
        max-height: 100vh !important;
        min-height: 100vh !important;
        padding-bottom: 0 !important;
    }

    /* ==========================================================================
       ACTION CONTROL BAR BENEATH VIDEO
       ========================================================================== */
    .player-action-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.5rem 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.75rem;
    }

    /* BIG, ATTRACTIVE MARK AS COMPLETED BUTTON */
    .btn-mark-complete {
        font-size: 1.05rem;
        font-weight: 800;
        padding: 0.85rem 2.25rem;
        border-radius: 999px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        user-select: none;
    }
    .btn-mark-complete.btn-not-done {
        background: #ffffff;
        border: 2.5px solid #0066ff;
        color: #0066ff;
        box-shadow: 0 4px 14px rgba(0, 102, 255, 0.15);
    }
    .btn-mark-complete.btn-not-done:hover {
        background-color: #eff6ff;
        border-color: #0052cc;
        color: #0052cc;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(0, 102, 255, 0.25);
    }
    .btn-mark-complete.btn-is-done {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border: 2.5px solid #059669;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.38);
    }
    .btn-mark-complete.btn-is-done:hover {
        background: linear-gradient(135deg, #047857 0%, #059669 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.45);
    }

    /* Lecture Navigation Buttons (Prev / Next) */
    .btn-lecture-nav {
        font-weight: 700;
        font-size: 0.95rem;
        border-radius: 999px;
        padding: 0.75rem 1.6rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ==========================================================================
       RIGHT CURRICULUM SIDEBAR (Sticky, clean, NO empty white void)
       ========================================================================== */
    .curriculum-sidebar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        max-height: 80vh; /* Wraps snugly, no artificial 100vh blank void! */
        position: sticky;
        top: 80px;
    }
    .curriculum-scroll-area {
        overflow-y: auto;
        flex: 1;
    }
    .curriculum-scroll-area::-webkit-scrollbar {
        width: 6px;
    }
    .curriculum-scroll-area::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    /* Lesson row item */
    .lesson-item-row {
        padding: 0.95rem 1.15rem;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        text-decoration: none;
    }
    .lesson-item-row:hover {
        background-color: #f8fafc;
    }
    .lesson-item-row.active {
        background-color: #eff6ff;
        border-left: 4px solid #0066ff;
    }
    .lesson-item-row.active .lesson-title-text {
        color: #0066ff !important;
        font-weight: 700;
    }

    /* Checkbox circle in sidebar */
    .lesson-check-circle {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .lesson-check-circle.checked {
        background-color: #10b981;
        color: #ffffff;
        border: 2px solid #10b981;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
    }
    .lesson-check-circle.unchecked {
        background-color: #ffffff;
        border: 2px solid #cbd5e1;
        color: transparent;
    }
    .lesson-check-circle.unchecked:hover {
        border-color: #0066ff;
        background-color: #eff6ff;
        transform: scale(1.1);
    }

    /* ==========================================================================
       THEATER MODE & FULL-WIDTH TOGGLES
       ========================================================================== */
    /* When Theater Mode is Active: Video occupies 100% full width on top */
    .theater-mode-active #stageCol {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
    .theater-mode-active #sidebarCol {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
        margin-top: 1.5rem;
    }
    .theater-mode-active .curriculum-sidebar-card {
        position: static !important;
        max-height: 480px;
    }

    /* When Sidebar is Hidden */
    .sidebar-hidden #sidebarCol {
        display: none !important;
    }
    .sidebar-hidden #stageCol {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    /* ==========================================================================
       STUDY WORKSPACE TABS & NOTEBOOK (Bigger, Spacious & Polished)
       ========================================================================== */
    .study-tabs-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }
    .study-tabs {
        border-bottom: 1.5px solid #e2e8f0;
        background-color: #ffffff;
        padding-inline: 1rem;
    }
    .study-tabs .nav-link {
        color: #64748b;
        font-weight: 700;
        font-size: 1.02rem;
        padding: 1.15rem 1.65rem;
        border: none;
        border-bottom: 3.5px solid transparent;
        background: transparent;
        transition: all 0.2s ease;
    }
    .study-tabs .nav-link:hover {
        color: #0066ff;
    }
    .study-tabs .nav-link.active {
        color: #0066ff;
        border-bottom-color: #0066ff;
        background: transparent;
        font-weight: 800;
    }
    .study-card-body {
        padding: 2.25rem 2.5rem;
    }
    @media (max-width: 768px) {
        .study-card-body {
            padding: 1.25rem 1rem;
        }
        .study-tabs .nav-link {
            font-size: 0.9rem;
            padding: 0.85rem 1rem;
        }
    }

    /* Large Student Notebook Textarea */
    .notebook-textarea {
        min-height: 380px;
        font-size: 1.05rem;
        line-height: 1.8;
        padding: 1.5rem;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        background-color: #f8fafc;
        color: #0f172a;
        transition: all 0.2s ease;
        font-family: inherit;
        resize: vertical;
    }
    .notebook-textarea:focus {
        background-color: #ffffff;
        border-color: #0066ff;
        box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.12);
        outline: none;
    }
</style>
@endsection

@section('content')

<!-- Classroom Dedicated Top Navbar -->
<header class="classroom-navbar">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        
        <!-- Left: Course Navigation & Title -->
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('customer.my-courses') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 d-flex align-items-center gap-1.5 fw-semibold" style="font-size: 0.82rem;">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to My Courses</span>
            </a>
            <div class="vr bg-secondary opacity-50 d-none d-sm-block" style="height: 24px;"></div>
            <div>
                <h6 class="mb-0 fw-bold text-white text-truncate" style="max-width: 550px;" title="{{ $course->title ?? $course->course_name }}">
                    {{ $course->title ?? $course->course_name }}
                </h6>
                <div class="text-white text-opacity-70 small" style="font-size: 0.78rem;">
                    Course Content & Curriculum • Lecture {{ $currentLesson ? $currentLesson->lesson_no : 1 }} of {{ $totalLessons }}
                </div>
            </div>
        </div>

        <!-- Right: Progress Meter, Fullscreen & Controls -->
        <div class="d-flex align-items-center gap-2.5">
            
            <!-- Progress Pill -->
            <div class="d-none d-md-flex align-items-center gap-2 bg-white bg-opacity-10 px-3.5 py-1.5 rounded-pill border border-white border-opacity-10">
                <span class="small fw-semibold text-white text-opacity-90" style="font-size: 0.8rem;">Your Progress:</span>
                <div class="progress" style="width: 120px; height: 8px; background-color: rgba(255,255,255,0.2); border-radius: 999px;">
                    <div class="progress-bar bg-success" id="topProgressBar" role="progressbar" style="width: {{ $progressPercent }}%;"></div>
                </div>
                <span class="badge bg-success text-white rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.75rem;" id="topProgressBadge">
                    {{ $progressPercent }}%
                </span>
            </div>

            <!-- Fullscreen Button -->
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 d-flex align-items-center gap-1.5 fw-bold shadow-sm" title="Full Screen Cinema Mode (F)" onclick="toggleFullscreenPlayer()">
                <i class="fa-solid fa-expand" id="topFsIcon"></i>
                <span>Full Screen</span>
            </button>

            <!-- Theater Mode Button -->
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 d-flex align-items-center gap-1.5 fw-semibold" title="Toggle Theater Widescreen (T)" onclick="toggleTheaterMode()" id="theaterModeBtn">
                <i class="fa-solid fa-tv"></i>
                <span id="theaterModeBtnText">Theater View</span>
            </button>

            <!-- Toggle Sidebar Visibility Button -->
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 d-flex align-items-center gap-1.5 fw-semibold" title="Toggle Curriculum Sidebar" onclick="toggleCurriculumSidebar()">
                <i class="fa-solid fa-bars-staggered"></i>
                <span id="sidebarToggleText">Hide Sidebar</span>
            </button>

            <!-- Certificate Button -->
            <a href="{{ route('customer.course.certificate', ['courseId' => $course->id]) }}" class="btn btn-sm {{ $progressPercent >= 100 ? 'btn-success text-white shadow-sm' : 'btn-outline-light' }} rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.82rem;">
                <i class="fa-solid fa-award me-1"></i>
                <span>{{ $progressPercent >= 100 ? 'Certificate Unlocked!' : 'Certificate' }}</span>
            </a>
        </div>
    </div>
</header>

<!-- Main Classroom Layout Stage -->
<div class="classroom-wrapper" id="classroomPageWrapper">
    <div class="row g-4" id="mainPlayerRow">

        <!-- Left / Center: Cinema Video Stage & Study Tabs -->
        <div class="col-12 col-xl-8" id="stageCol">
            
            <!-- Cinema Video Stage (Large, Cinematic Widescreen Viewport) -->
            <div class="cinema-stage" id="cinemaVideoStage">
                
                <!-- Quick Floating Overlay Controls -->
                <div class="cinema-overlay-controls">
                    <button type="button" class="btn btn-cinema-ctrl" onclick="toggleTheaterMode()" title="Expand to Full Width (T)">
                        <i class="fa-solid fa-tv"></i> <span class="d-none d-sm-inline">Theater Mode</span>
                    </button>
                    <button type="button" class="btn btn-cinema-ctrl" onclick="toggleFullscreenPlayer()" title="Full Screen (F)">
                        <i class="fa-solid fa-expand"></i> <span class="d-none d-sm-inline">Full Screen</span>
                    </button>
                </div>

                <div class="video-viewport">
                    @if(!empty($embedVideoUrl))
                        @if(str_contains($embedVideoUrl, 'youtube') || str_contains($embedVideoUrl, 'vimeo'))
                            <iframe src="{{ $embedVideoUrl }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen id="videoPlayerFrame"></iframe>
                        @elseif(preg_match('/\.(mp4|webm|ogg|m3u8)/i', $embedVideoUrl))
                            <video controls autoplay class="w-100 h-100" id="html5VideoPlayer">
                                <source src="{{ $embedVideoUrl }}" type="video/mp4">
                                Your browser does not support HTML5 video streaming.
                            </video>
                        @else
                            <iframe src="{{ $embedVideoUrl }}" allowfullscreen></iframe>
                        @endif
                    @else
                        <!-- Fallback / Simulated Interactive Video Player -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: radial-gradient(circle at center, #1e293b 0%, #08111e 100%);">
                            <div class="rounded-circle bg-primary bg-opacity-20 text-primary p-4 mb-3">
                                <i class="fa-solid fa-circle-play fs-1 text-white"></i>
                            </div>
                            <h4 class="fw-bold text-white mb-2">{{ $currentLesson ? $currentLesson->lesson_name : 'Course Lecture Video' }}</h4>
                            <p class="text-white text-opacity-75 small mb-3" style="max-width: 520px;">
                                This high-definition video lecture is ready. Click below to begin streaming with full learning controls.
                            </p>
                            <button class="btn btn-primary btn-lg rounded-pill px-4 py-2.5 fw-bold d-flex align-items-center gap-2 shadow" onclick="alert('Starting interactive lecture player stream...');">
                                <i class="fa-solid fa-play"></i> Start Lecture Stream
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Player Action & Status Control Bar -->
            <div class="player-action-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    
                    <!-- Left: Lecture Title & Details -->
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1.5">
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-1.5 rounded-pill" style="font-size: 0.82rem;">
                                Lecture {{ $currentLesson ? $currentLesson->lesson_no : 1 }} of {{ $totalLessons }} • Duration: {{ $currentLesson ? $currentLesson->duration : '15:00' }}
                            </span>
                            <span class="badge {{ $isCurrentCompleted ? 'bg-success text-white' : 'bg-secondary text-white' }} px-3 py-1.5 rounded-pill fw-bold" id="lessonStatusBadge" style="font-size: 0.78rem;">
                                {{ $isCurrentCompleted ? 'Status: Completed ✓' : 'Status: In Progress' }}
                            </span>
                        </div>
                        <h3 class="fw-bold text-dark mb-0 fs-3" id="currentLessonTitle">
                            {{ $currentLesson ? $currentLesson->lesson_name : 'Lecture Video' }}
                        </h3>
                    </div>

                    <!-- Right: Large Mark as Completed Button & Lecture Navigation -->
                    <div class="d-flex align-items-center flex-wrap gap-2.5">
                        
                        <!-- Previous Lecture Button -->
                        @if($prevLesson)
                            <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $prevLesson->id]) }}" class="btn btn-outline-secondary btn-lecture-nav" title="Previous Lecture">
                                <i class="fa-solid fa-chevron-left"></i>
                                <span>Prev</span>
                            </a>
                        @endif

                        <!-- BIG, ATTRACTIVE MARK AS COMPLETED BUTTON -->
                        <button type="button" class="btn-mark-complete {{ $isCurrentCompleted ? 'btn-is-done' : 'btn-not-done' }}" id="completeBtn" onclick="toggleCurrentLesson()" title="Click to toggle completion status">
                            <i class="fa-solid {{ $isCurrentCompleted ? 'fa-circle-check fs-4' : 'fa-circle-notch fs-4' }}" id="completeBtnIcon"></i>
                            <span id="completeBtnText">{{ $isCurrentCompleted ? 'Completed ✓' : 'Mark as Completed' }}</span>
                        </button>

                        <!-- Next Lecture Button -->
                        @if($nextLesson)
                            <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $nextLesson->id]) }}" class="btn btn-primary btn-lecture-nav shadow-sm" id="nextLessonBtn" title="Next Lecture">
                                <span>Next Lecture</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        @endif

                        <!-- Fullscreen Button -->
                        <button type="button" class="btn btn-outline-dark btn-lecture-nav" onclick="toggleFullscreenPlayer()" title="Full Screen View (F)">
                            <i class="fa-solid fa-expand"></i>
                            <span class="d-none d-md-inline">Full Screen</span>
                        </button>
                    </div>

                </div>

                <!-- Autoplay Switch & Helper Tip -->
                <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="form-check form-switch m-0 d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="autoAdvanceSwitch" checked style="width: 2.5em; height: 1.3em;">
                        <label class="form-check-label text-dark fw-semibold small" for="autoAdvanceSwitch">
                            Autoplay next lecture automatically when marked completed
                        </label>
                    </div>
                    <span class="text-muted small">
                        <i class="fa-solid fa-circle-check text-success me-1"></i> You can also check off any completed lecture directly in the curriculum playlist on the right!
                    </span>
                </div>
            </div>

            <!-- Multi-Tab Study Workspace (Much Bigger, More Spacious, Clean Data) -->
            <div class="study-tabs-card">
                <div class="card-header bg-white border-0 p-0">
                    <ul class="nav nav-tabs study-tabs" id="studyTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="fa-solid fa-book-open me-2"></i> Course Content & Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
                                <i class="fa-solid fa-note-sticky me-2"></i> My Study Notes
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">
                                <i class="fa-solid fa-folder-open me-2"></i> Resources & Materials
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#qa" type="button" role="tab">
                                <i class="fa-solid fa-circle-question me-2"></i> Course Q&A / FAQs
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="cert-tab" data-bs-toggle="tab" data-bs-target="#cert" type="button" role="tab">
                                <i class="fa-solid fa-award me-2"></i> Certificate Status
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="study-card-body">
                    <div class="tab-content" id="studyTabContent">
                        
                        <!-- Tab 1: Course Content & Overview (Expanded & Rich) -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                <h4 class="fw-bold text-dark mb-0 fs-4">About this Lecture & Syllabus</h4>
                                <span class="badge bg-light text-primary border px-3 py-1.5 rounded-pill fw-semibold">
                                    {{ $currentLesson ? ($currentLesson->chapter_name ?? 'Module') : 'Module' }}
                                </span>
                            </div>

                            <p class="text-secondary mb-4 lh-lg fs-6">
                                {{ !empty($currentLesson->course_description) ? $currentLesson->course_description : ($course->short_description ?? ($course->description ? Str::limit(strip_tags($course->description), 350) : 'This lecture covers practical concepts, real-world examples, and foundational exercises designed to build career-ready proficiency.')) }}
                            </p>

                            <!-- Key Learning Points / Objectives (from Course Data) -->
                            @if(!empty($learningPoints) && count($learningPoints) > 0)
                                <div class="p-4 bg-light rounded-4 border mb-4">
                                    <h5 class="fw-bold text-dark mb-3 fs-5">
                                        <i class="fa-solid fa-bullseye text-primary me-2"></i> What You Learn in this Course
                                    </h5>
                                    <div class="row g-2.5">
                                        @foreach($learningPoints as $pt)
                                            <div class="col-12 col-md-6 d-flex align-items-start gap-2">
                                                <i class="fa-solid fa-check text-success mt-1"></i>
                                                <span class="text-dark small lh-base">{{ $pt }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Requirements & Prerequisites (from Course Data) -->
                            @if(!empty($requirements) && count($requirements) > 0)
                                <div class="p-4 bg-white rounded-4 border mb-3">
                                    <h6 class="fw-bold text-dark mb-2.5 fs-6">
                                        <i class="fa-solid fa-list-check text-secondary me-2"></i> Prerequisites & Requirements
                                    </h6>
                                    <ul class="text-secondary small mb-0 ps-3 lh-lg">
                                        @foreach($requirements as $req)
                                            <li>{{ $req }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Instructor Info Banner -->
                            <div class="d-flex align-items-center gap-3 p-3.5 bg-light bg-opacity-70 rounded-3 border">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px; font-size: 1.1rem;">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $course->instructor_name ?? 'Digital Class Instructor' }}</div>
                                    <span class="text-muted small">Course Instructor • Verified E-Learning Curriculum</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: My Study Notes (BIGGER & MORE SPACIOUS NOTEBOOK) -->
                        <div class="tab-pane fade" id="notes" role="tabpanel">
                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                <div>
                                    <h4 class="fw-bold text-dark mb-0 fs-4">Lecture Study Notebook</h4>
                                    <span class="text-muted small">
                                        Notes for: <strong>{{ $currentLesson ? $currentLesson->lesson_name : 'Current Lecture' }}</strong>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3.5 py-2 fw-semibold d-flex align-items-center gap-1.5" onclick="exportNotesToFile()">
                                        <i class="fa-solid fa-download"></i>
                                        <span>Export Notes (.txt)</span>
                                    </button>
                                    <button class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-1.5 shadow-sm" onclick="saveStudentNote()">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        <span>Save Note (Ctrl+S)</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Large Notebook Textarea -->
                            <textarea id="studentNoteText" class="form-control notebook-textarea mb-3" placeholder="Write your comprehensive study notes, key takeaways, important formulas, timestamps, and lecture reminders here...">{{ $currentNote ? $currentNote->note : '' }}</textarea>
                            
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-lock text-secondary me-1"></i> Notes are automatically tied to this lecture and saved privately in your student profile.
                                </span>
                                <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-semibold d-none" id="noteSavedBadge">
                                    <i class="fa-solid fa-check me-1"></i> Saved to your notebook!
                                </span>
                            </div>

                            <!-- Past Notes in this Course (if student saved notes in other lectures) -->
                            @if(!empty($allCourseNotes) && $allCourseNotes->count() > 1)
                                <div class="border-top pt-4 mt-2">
                                    <h6 class="fw-bold text-dark mb-3 fs-6">
                                        <i class="fa-solid fa-book-bookmark text-primary me-2"></i> All Notes Saved Across This Course ({{ $allCourseNotes->count() }})
                                    </h6>
                                    <div class="accordion accordion-flush" id="allNotesAccordion">
                                        @foreach($allCourseNotes as $nIdx => $pastNote)
                                            @php
                                                $associatedLesson = $allLessons->firstWhere('id', $pastNote->lesson_id);
                                            @endphp
                                            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                                                <h2 class="accordion-header" id="noteHeading{{ $nIdx }}">
                                                    <button class="accordion-button collapsed py-2.5 px-3.5 small fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#noteCollapse{{ $nIdx }}" style="background-color: #f8fafc;">
                                                        <div class="d-flex align-items-center justify-content-between w-100 pe-2">
                                                            <span>Lecture: {{ $associatedLesson ? $associatedLesson->lesson_name : 'Lesson #' . $pastNote->lesson_id }}</span>
                                                            <span class="text-muted fw-normal small" style="font-size: 0.75rem;">{{ $pastNote->updated_at ? $pastNote->updated_at->diffForHumans() : '' }}</span>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="noteCollapse{{ $nIdx }}" class="accordion-collapse collapse" data-bs-parent="#allNotesAccordion">
                                                    <div class="accordion-body bg-white text-secondary small p-3 lh-base" style="white-space: pre-wrap;">{{ $pastNote->note }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Tab 3: Resources & Materials (NO Fake / Dummy Downloads) -->
                        <div class="tab-pane fade" id="resources" role="tabpanel">
                            <h4 class="fw-bold text-dark mb-1 fs-4">Course Learning Materials & Resources</h4>
                            <p class="text-muted small mb-4">Official study tools, curriculum outline, and downloadable notes.</p>

                            <div class="row g-3">
                                <!-- Export Personal Notes -->
                                <div class="col-12 col-md-6">
                                    <div class="p-3.5 border rounded-4 bg-light d-flex align-items-center justify-content-between h-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 fs-4">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">Lecture Notebook File</div>
                                                <span class="text-muted small">Export all your personal study notes to a text file</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1.5 fw-bold" onclick="exportNotesToFile()">
                                            <i class="fa-solid fa-download me-1"></i> Export
                                        </button>
                                    </div>
                                </div>

                                <!-- Export Course Syllabus -->
                                <div class="col-12 col-md-6">
                                    <div class="p-3.5 border rounded-4 bg-light d-flex align-items-center justify-content-between h-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 fs-4">
                                                <i class="fa-solid fa-book-open"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">Full Course Syllabus</div>
                                                <span class="text-muted small">Download outline with all {{ $totalLessons }} lecture topics</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-success btn-sm rounded-pill px-3 py-1.5 fw-bold" onclick="exportSyllabusToFile()">
                                            <i class="fa-solid fa-download me-1"></i> Syllabus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-light rounded-4 border mt-4 text-center">
                                <i class="fa-solid fa-circle-info text-primary fs-3 mb-2"></i>
                                <h6 class="fw-bold text-dark mb-1">Instructional Delivery Format</h6>
                                <p class="text-secondary small mb-0" style="max-width: 600px; margin-inline: auto;">
                                    All instructional demonstrations, coding exercises, and concepts are self-contained in the high-definition video player. Use your personal Study Notes tab to capture key insights as you progress.
                                </p>
                            </div>
                        </div>

                        <!-- Tab 4: Course Q&A / FAQs (AUTHENTIC COURSE DETAIL FAQS - NO STATIC DUMMY DATA - NO POST INPUT) -->
                        <div class="tab-pane fade" id="qa" role="tabpanel">
                            <div class="mb-4">
                                <h4 class="fw-bold text-dark mb-1 fs-4">Course Q&A & Frequently Asked Questions</h4>
                                <p class="text-muted small mb-0">Official questions & answers as featured on the course details page.</p>
                            </div>

                            @if(!empty($faqs) && count($faqs) > 0)
                                <div class="accordion accordion-flush" id="classroomFaqAccordion">
                                    @foreach($faqs as $fIdx => $faq)
                                        <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                                            <h2 class="accordion-header" id="faqHeading{{ $fIdx }}">
                                                <button class="accordion-button {{ $fIdx > 0 ? 'collapsed' : '' }} py-3.5 px-4 fw-bold text-dark" style="font-size: 1.02rem; background-color: #f8fafc;" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $fIdx }}" aria-expanded="{{ $fIdx === 0 ? 'true' : 'false' }}">
                                                    <div class="d-flex align-items-center gap-2.5">
                                                        <i class="fa-regular fa-circle-question text-primary fs-5"></i>
                                                        <span>{{ $faq['q'] }}</span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="faqCollapse{{ $fIdx }}" class="accordion-collapse collapse {{ $fIdx === 0 ? 'show' : '' }}" data-bs-parent="#classroomFaqAccordion">
                                                <div class="accordion-body bg-white text-secondary py-3.5 px-4 fs-6" style="line-height: 1.75;">
                                                    {!! nl2br(e($faq['a'])) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 bg-light rounded-4 border">
                                    <i class="fa-regular fa-circle-question fs-1 text-muted mb-3 opacity-50"></i>
                                    <h5 class="fw-bold text-dark mb-1">Self-Paced Course Curriculum</h5>
                                    <p class="text-muted small mb-0" style="max-width: 480px; margin-inline: auto;">
                                        All curriculum concepts, prerequisites, and learning directions are explained in the video lessons. Check the Course Content tab for detailed learning points.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Tab 5: Certificate Status -->
                        <div class="tab-pane fade" id="cert" role="tabpanel">
                            <div class="text-center py-5">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center p-3.5 mb-3.5" style="width: 84px; height: 84px;">
                                    <i class="fa-solid fa-award fs-1"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-2 fs-3">Official Certificate of Completion</h3>
                                <p class="text-muted small mb-4" style="max-width: 540px; margin-inline: auto; font-size: 0.95rem; line-height: 1.6;">
                                    Complete all video lectures in this course (100% progress) to unlock your verified, personalized completion certificate with serial credentials.
                                </p>
                                
                                <div class="mb-4">
                                    <span class="badge {{ $progressPercent >= 100 ? 'bg-success' : 'bg-primary' }} px-4 py-2.5 rounded-pill fs-6 fw-bold shadow-sm">
                                        Current Progress: {{ $progressPercent }}% ({{ $completedCount }} / {{ $totalLessons }} Lectures Finished)
                                    </span>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                                    <a href="{{ route('customer.course.certificate', ['courseId' => $course->id]) }}" class="btn {{ $progressPercent >= 100 ? 'btn-success' : 'btn-outline-primary' }} btn-lg rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                                        <i class="fa-solid fa-award me-2"></i>
                                        <span>{{ $progressPercent >= 100 ? 'Download Verified Certificate' : 'Preview Certificate Template' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Interactive Curriculum Sidebar (Snug, Sticky & Scrollable - NO empty white void) -->
        <div class="col-12 col-xl-4" id="sidebarCol">
            <div class="curriculum-sidebar-card">
                
                <!-- Sidebar Header with Search & Progress -->
                <div class="p-3 border-bottom bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Course Content & Curriculum</h6>
                            <span class="text-muted small" style="font-size: 0.75rem;">
                                {{ $chapters->count() }} Modules • {{ $totalLessons }} Lectures
                            </span>
                        </div>
                        <span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.78rem;" id="sideProgressText">
                            {{ $completedCount }}/{{ $totalLessons }} ({{ $progressPercent }}%)
                        </span>
                    </div>

                    <!-- Search Input -->
                    <div class="position-relative">
                        <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 10px; left: 12px; font-size: 0.75rem;"></i>
                        <input type="text" id="curriculumSearchInput" class="form-control rounded-pill small py-1.5 ps-4 text-secondary bg-light border-0" placeholder="Search lectures..." style="font-size: 0.8rem;" oninput="filterLessons()">
                    </div>
                </div>

                <!-- Accordion Scroll Area -->
                <div class="curriculum-scroll-area">
                    <div class="accordion accordion-flush" id="curriculumAccordion">
                        @foreach($chapters as $idx => $chapter)
                            <div class="accordion-item border-0 border-bottom chapter-group">
                                <h2 class="accordion-header" id="heading{{ $chapter->id }}">
                                    <button class="accordion-button py-3 px-3 fw-bold text-dark" style="font-size: 0.88rem; background-color: #f8fafc;" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $chapter->id }}" aria-expanded="{{ ($currentLesson && in_array($currentLesson->id, $chapter->lessons->pluck('id')->toArray())) ? 'true' : ($idx === 0 ? 'true' : 'false') }}">
                                        <div class="d-flex align-items-center justify-content-between w-100 pe-2">
                                            <span class="text-truncate" style="max-width: 240px;">
                                                {{ $chapter->chapter_name }}
                                            </span>
                                            <span class="badge bg-light text-muted border rounded-pill small fw-normal ms-2">
                                                {{ $chapter->lessons->count() }}
                                            </span>
                                        </div>
                                    </button>
                                </h2>

                                <div id="collapse{{ $chapter->id }}" class="accordion-collapse collapse {{ ($currentLesson && in_array($currentLesson->id, $chapter->lessons->pluck('id')->toArray())) ? 'show' : ($idx === 0 ? 'show' : '') }}" data-bs-parent="#curriculumAccordion">
                                    <div class="accordion-body p-0">
                                        @foreach($chapter->lessons as $lesson)
                                            @php
                                                $isActive = ($currentLesson && $currentLesson->id == $lesson->id);
                                                $isComp = in_array($lesson->id, $completedLessonIds);
                                            @endphp
                                            <div class="lesson-item-row {{ $isActive ? 'active' : '' }}" id="lessonItemRow{{ $lesson->id }}" data-lesson-name="{{ strtolower($lesson->lesson_name) }}">
                                                
                                                <!-- Clickable Check Circle Icon -->
                                                <div class="lesson-check-circle {{ $isComp ? 'checked' : 'unchecked' }}" 
                                                     id="checkCircle{{ $lesson->id }}" 
                                                     title="{{ $isComp ? 'Completed ✓ (Click to mark incomplete)' : 'Mark as Completed' }}"
                                                     onclick="toggleLessonFromCircle({{ $lesson->id }})">
                                                    <i class="fa-solid fa-check" style="font-size: 0.7rem;"></i>
                                                </div>

                                                <!-- Clickable Lecture Title & Duration -->
                                                <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}" class="flex-grow-1 overflow-hidden text-decoration-none">
                                                    <div class="text-dark small text-truncate lesson-title-text mb-0.5" title="{{ $lesson->lesson_name }}">
                                                        {{ $lesson->lesson_name }}
                                                    </div>
                                                    <div class="text-muted d-flex align-items-center gap-1.5" style="font-size: 0.72rem;">
                                                        <i class="fa-regular fa-clock"></i>
                                                        <span>{{ $lesson->duration }}</span>
                                                        @if($isActive)
                                                            <span class="badge bg-primary bg-opacity-10 text-primary ms-1 fw-bold" style="font-size: 0.65rem;">Now Playing</span>
                                                        @endif
                                                    </div>
                                                </a>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Syllabus Footer Card (Summary so sidebar always looks balanced and neat) -->
                <div class="p-3 bg-light border-top">
                    <div class="d-flex align-items-center justify-content-between text-muted small">
                        <span><i class="fa-solid fa-award text-warning me-1"></i> Certificate at 100%</span>
                        <span class="fw-semibold text-dark">{{ $completedCount }}/{{ $totalLessons }} Done</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
const courseId = {{ $course->id }};
let currentLessonId = {{ $currentLesson ? $currentLesson->id : 0 }};
let isCompleted = {{ $isCurrentCompleted ? 'true' : 'false' }};
let isSidebarHidden = false;
let isTheaterMode = false;

// 1. Toggle Sidebar Visibility (expands video to 100% full width)
function toggleCurriculumSidebar() {
    isSidebarHidden = !isSidebarHidden;
    const pageWrapper = document.getElementById('classroomPageWrapper');
    const toggleText = document.getElementById('sidebarToggleText');

    if (isSidebarHidden) {
        pageWrapper.classList.add('sidebar-hidden');
        toggleText.innerText = 'Show Sidebar';
    } else {
        pageWrapper.classList.remove('sidebar-hidden');
        toggleText.innerText = 'Hide Sidebar';
    }
}

// 2. Toggle Theater Mode (Full Width Player on Top)
function toggleTheaterMode() {
    isTheaterMode = !isTheaterMode;
    const pageWrapper = document.getElementById('classroomPageWrapper');
    const theaterBtnText = document.getElementById('theaterModeBtnText');

    if (isTheaterMode) {
        pageWrapper.classList.add('theater-mode-active');
        if (theaterBtnText) theaterBtnText.innerText = 'Split View';
    } else {
        pageWrapper.classList.remove('theater-mode-active');
        if (theaterBtnText) theaterBtnText.innerText = 'Theater View';
    }
}

// 3. Fullscreen Video Player Mode (standard browser Fullscreen API)
function toggleFullscreenPlayer() {
    const stage = document.getElementById('cinemaVideoStage');
    const topFsIcon = document.getElementById('topFsIcon');

    if (!document.fullscreenElement && !document.webkitFullscreenElement) {
        if (stage.requestFullscreen) {
            stage.requestFullscreen();
        } else if (stage.webkitRequestFullscreen) {
            stage.webkitRequestFullscreen();
        }
        if (topFsIcon) topFsIcon.className = 'fa-solid fa-compress';
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
        if (topFsIcon) topFsIcon.className = 'fa-solid fa-expand';
    }
}

document.addEventListener('fullscreenchange', () => {
    const topFsIcon = document.getElementById('topFsIcon');
    if (!document.fullscreenElement && topFsIcon) {
        topFsIcon.className = 'fa-solid fa-expand';
    }
});

// Keyboard shortcuts: F for Fullscreen, T for Theater Mode, Ctrl+S for saving notes
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
        e.preventDefault();
        saveStudentNote();
        return;
    }
    if (['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;
    if (e.key === 'f' || e.key === 'F') {
        toggleFullscreenPlayer();
    } else if (e.key === 't' || e.key === 'T') {
        toggleTheaterMode();
    }
});

// 4. Mark Current Lesson Completed / Incomplete
function toggleCurrentLesson() {
    if (!currentLessonId) return;
    const btn = document.getElementById('completeBtn');
    btn.disabled = true;

    triggerLessonToggle(currentLessonId, function(data) {
        btn.disabled = false;
        if (data.success) {
            isCompleted = data.completed;
            updateButtonUI(isCompleted);

            // Sync sidebar circle
            const circle = document.getElementById(`checkCircle${currentLessonId}`);
            if (circle) {
                if (isCompleted) {
                    circle.className = 'lesson-check-circle checked';
                    circle.title = 'Completed ✓ (Click to mark incomplete)';
                } else {
                    circle.className = 'lesson-check-circle unchecked';
                    circle.title = 'Mark as Completed';
                }
            }

            // Autoplay next if enabled and completed
            const autoAdvance = document.getElementById('autoAdvanceSwitch').checked;
            if (isCompleted && autoAdvance && data.next_lesson_id) {
                setTimeout(() => {
                    window.location.href = `{{ url('/customer/course') }}/${courseId}/learn/${data.next_lesson_id}`;
                }, 800);
            }
        }
    });
}

// 5. Toggle Lesson directly from sidebar circle click
function toggleLessonFromCircle(lessonId) {
    triggerLessonToggle(lessonId, function(data) {
        if (data.success) {
            const circle = document.getElementById(`checkCircle${lessonId}`);
            if (circle) {
                if (data.completed) {
                    circle.className = 'lesson-check-circle checked';
                    circle.title = 'Completed ✓ (Click to mark incomplete)';
                } else {
                    circle.className = 'lesson-check-circle unchecked';
                    circle.title = 'Mark as Completed';
                }
            }

            // If active lesson was toggled, update main action button too
            if (lessonId == currentLessonId) {
                isCompleted = data.completed;
                updateButtonUI(isCompleted);
            }
        }
    });
}

function updateButtonUI(completed) {
    const btn = document.getElementById('completeBtn');
    const btnText = document.getElementById('completeBtnText');
    const btnIcon = document.getElementById('completeBtnIcon');
    const statusBadge = document.getElementById('lessonStatusBadge');

    if (completed) {
        btn.className = 'btn-mark-complete btn-is-done';
        btnText.innerText = 'Completed ✓';
        btnIcon.className = 'fa-solid fa-circle-check fs-4';
        if (statusBadge) {
            statusBadge.className = 'badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold';
            statusBadge.innerText = 'Status: Completed ✓';
        }
    } else {
        btn.className = 'btn-mark-complete btn-not-done';
        btnText.innerText = 'Mark as Completed';
        btnIcon.className = 'fa-solid fa-circle-notch fs-4';
        if (statusBadge) {
            statusBadge.className = 'badge bg-secondary text-white px-3 py-1.5 rounded-pill fw-bold';
            statusBadge.innerText = 'Status: In Progress';
        }
    }
}

// 6. Shared AJAX toggle request
function triggerLessonToggle(lessonId, callback) {
    fetch(`{{ url('/customer/learning') }}/${courseId}/lesson/${lessonId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Update top progress bar & badges
            const topBar = document.getElementById('topProgressBar');
            const topBadge = document.getElementById('topProgressBadge');
            const sideText = document.getElementById('sideProgressText');

            if (topBar) topBar.style.width = data.progress_percent + '%';
            if (topBadge) topBadge.innerText = data.progress_percent + '%';
            if (sideText) sideText.innerText = `${data.completed_count}/${data.total_count} (${data.progress_percent}%)`;

            if (data.is_finished) {
                alert('Congratulations! You completed all lectures in this course! Your Certificate of Completion is now unlocked.');
            }
        }
        if (callback) callback(data);
    })
    .catch(err => console.error('Error toggling lesson:', err));
}

// 7. Curriculum Sidebar Search
function filterLessons() {
    const q = document.getElementById('curriculumSearchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('.lesson-item-row');

    rows.forEach(row => {
        const name = row.getAttribute('data-lesson-name') || '';
        row.style.display = name.includes(q) ? '' : 'none';
    });
}

// 8. Save Note
function saveStudentNote() {
    const text = document.getElementById('studentNoteText').value;
    const badge = document.getElementById('noteSavedBadge');

    fetch(`{{ url('/customer/learning') }}/${courseId}/lesson/${currentLessonId}/note`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ note: text })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            badge.classList.remove('d-none');
            setTimeout(() => badge.classList.add('d-none'), 3500);
        }
    });
}

// 9. Export Notes
function exportNotesToFile() {
    const text = document.getElementById('studentNoteText').value;
    if (!text.trim()) {
        alert('Your notebook is empty. Write some notes first before exporting.');
        return;
    }
    const fullContent = `COURSE: {{ addslashes($course->title ?? $course->course_name) }}\nLECTURE: {{ addslashes($currentLesson ? $currentLesson->lesson_name : 'Lesson') }}\nDATE: ${new Date().toLocaleDateString()}\n=======================================================\n\n` + text;
    const blob = new Blob([fullContent], { type: 'text/plain;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `Study_Notes_{{ Str::slug($course->title ?? $course->course_name) }}.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

// 10. Export Full Course Syllabus Outline
function exportSyllabusToFile() {
    let content = `COURSE SYLLABUS: {{ addslashes($course->title ?? $course->course_name) }}\nTOTAL LECTURES: {{ $totalLessons }}\n=======================================================\n\n`;
    @foreach($chapters as $ch)
        content += `\nMODULE: {{ addslashes($ch->chapter_name) }}\n`;
        @foreach($ch->lessons as $l)
            content += `  - {{ addslashes($l->lesson_name) }} (Duration: {{ $l->duration }})\n`;
        @endforeach
    @endforeach

    const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `Syllabus_{{ Str::slug($course->title ?? $course->course_name) }}.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>
@endsection
