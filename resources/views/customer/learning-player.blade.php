@extends('layouts.app')

@section('title', ($currentLesson ? $currentLesson->lesson_name . ' - ' : '') . ($course->title ?? $course->course_name) . ' - Learning Classroom')

@section('styles')
<style>
    /* Immersive classroom styling */
    .classroom-navbar {
        background-color: #081628;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        padding: 0.75rem 1.25rem;
        position: sticky;
        top: 0;
        z-index: 1020;
    }
    .classroom-body {
        background-color: #f8fafc;
        min-height: calc(100vh - 120px);
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        background-color: #000000;
        border-radius: 14px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.28);
        transition: all 0.3s ease;
    }
    .video-container iframe,
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .theater-mode-active .video-stage-col {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
    .theater-mode-active .sidebar-stage-col {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
    .curriculum-sidebar {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        height: calc(100vh - 130px);
        overflow-y: auto;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
    }
    .curriculum-sidebar::-webkit-scrollbar {
        width: 6px;
    }
    .curriculum-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .lesson-item {
        padding: 0.8rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .lesson-item:hover {
        background-color: #f8fafc;
    }
    .lesson-item.active {
        background-color: #eff6ff;
        border-left: 4px solid #0066ff;
    }
    .lesson-item.active .lesson-title {
        color: #0066ff !important;
        font-weight: 700;
    }
    .study-tabs .nav-link {
        color: #64748b;
        font-weight: 600;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.75rem 1.15rem;
        background: transparent;
        font-size: 0.9rem;
    }
    .study-tabs .nav-link.active {
        color: #0066ff;
        border-bottom-color: #0066ff;
        background: transparent;
    }
    .search-input-curriculum {
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.4rem 1rem 0.4rem 2.2rem;
        font-size: 0.82rem;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .search-input-curriculum:focus {
        background-color: #ffffff;
        border-color: #0066ff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
    }
    .checkbox-lesson {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }
</style>
@endsection

@section('content')
<!-- Classroom Top Header Bar -->
<div class="classroom-navbar text-white">
    <div class="container-fluid px-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('customer.my-courses') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 d-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="d-none d-sm-inline">My Courses</span>
            </a>
            <div class="vr bg-secondary opacity-50 d-none d-sm-block"></div>
            <div>
                <h6 class="mb-0 fw-bold text-white text-truncate" style="max-width: 480px;" title="{{ $course->title ?? $course->course_name }}">
                    {{ $course->title ?? $course->course_name }}
                </h6>
                <div class="text-white text-opacity-60 small" style="font-size: 0.75rem;">
                    {{ $currentLesson ? ($currentLesson->chapter_name ?? 'Module') : 'Course Curriculum' }}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2.5">
            <!-- Progress Pill -->
            <div class="d-none d-md-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill">
                <span class="small fw-semibold text-white text-opacity-75" style="font-size: 0.75rem;">Progress:</span>
                <div class="progress" style="width: 110px; height: 6px; background-color: rgba(255,255,255,0.2); border-radius: 999px;">
                    <div class="progress-bar bg-success" id="topProgressBar" role="progressbar" style="width: {{ $progressPercent }}%;"></div>
                </div>
                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 rounded-pill" style="font-size: 0.72rem;" id="topProgressBadge">
                    {{ $progressPercent }}%
                </span>
            </div>

            <!-- Theater Mode Button -->
            <button type="button" class="btn btn-sm btn-outline-light rounded-circle p-2 d-none d-lg-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Toggle Theater Mode" onclick="toggleTheaterMode()">
                <i class="fa-solid fa-expand" id="theaterIcon" style="font-size: 0.8rem;"></i>
            </button>

            <!-- Certificate Button -->
            <a href="{{ route('customer.course.certificate', ['courseId' => $course->id]) }}" class="btn btn-sm {{ $progressPercent >= 100 ? 'btn-success' : 'btn-outline-light' }} rounded-pill px-3 fw-semibold" style="font-size: 0.8rem;">
                <i class="fa-solid fa-award me-1"></i>
                <span>{{ $progressPercent >= 100 ? 'Get Certificate' : 'Certificate' }}</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Classroom Area -->
<div class="classroom-body py-4" id="classroomMainWrapper">
    <div class="container-fluid px-3 px-xl-4">
        <div class="row g-4" id="classroomRow">

            <!-- Left / Center: Video Player Stage & Study Tabs -->
            <div class="col-12 col-xl-8 video-stage-col" id="videoStageCol">
                
                <!-- Video Container -->
                <div class="video-container mb-3 shadow">
                    @if(!empty($embedVideoUrl))
                        @if(str_contains($embedVideoUrl, 'youtube') || str_contains($embedVideoUrl, 'vimeo'))
                            <iframe src="{{ $embedVideoUrl }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="videoPlayerFrame"></iframe>
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
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);">
                            <div class="rounded-circle bg-primary bg-opacity-20 text-primary p-4 mb-3">
                                <i class="fa-solid fa-circle-play fs-1 text-white"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">{{ $currentLesson ? $currentLesson->lesson_name : 'Course Lecture Video' }}</h5>
                            <p class="text-white text-opacity-75 small mb-3" style="max-width: 480px;">
                                This high-definition video lecture is ready for playback.
                            </p>
                            <button class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow" onclick="alert('Starting interactive lecture player stream...');">
                                <i class="fa-solid fa-play"></i> Start Lecture Stream
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Lecture Control Bar & Actions -->
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary small px-2.5 py-1 rounded-pill mb-1 fw-semibold">
                                Lecture {{ $currentLesson ? $currentLesson->lesson_no : 1 }} • Duration: {{ $currentLesson ? $currentLesson->duration : '15:00' }}
                            </span>
                            <h4 class="fw-bold text-dark mb-0 fs-5" id="currentLessonTitle">
                                {{ $currentLesson ? $currentLesson->lesson_name : 'Lecture Video' }}
                            </h4>
                        </div>

                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <!-- Prev Lesson -->
                            @if($prevLesson)
                                <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $prevLesson->id]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="Previous Lecture">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Prev
                                </a>
                            @endif

                            <!-- Mark as Completed Toggle Button -->
                            <button type="button" class="btn btn-sm {{ $isCurrentCompleted ? 'btn-success' : 'btn-outline-primary' }} rounded-pill px-3.5 py-1.5 fw-bold d-flex align-items-center gap-1.5 shadow-sm" id="completeBtn" onclick="toggleCurrentLesson()">
                                <i class="fa-solid {{ $isCurrentCompleted ? 'fa-circle-check' : 'fa-check' }}"></i>
                                <span id="completeBtnText">{{ $isCurrentCompleted ? 'Completed' : 'Mark as Completed' }}</span>
                            </button>

                            <!-- Next Lesson -->
                            @if($nextLesson)
                                <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $nextLesson->id]) }}" class="btn btn-primary btn-sm rounded-pill px-3.5 py-1.5 fw-bold shadow-sm" id="nextLessonBtn" title="Next Lecture">
                                    Next <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Autoplay switch & quick helper -->
                    <div class="pt-2.5 mt-2.5 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="form-check form-switch m-0 d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="autoAdvanceSwitch" checked>
                            <label class="form-check-label text-muted small fw-medium" for="autoAdvanceSwitch">
                                Autoplay next lecture upon completion
                            </label>
                        </div>
                        <span class="text-muted small" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-lightbulb text-warning me-1"></i> Use checkboxes in the curriculum to check off completed topics.
                        </span>
                    </div>
                </div>

                <!-- Study Tabs (Overview, Notes, Q&A, Syllabus, Resources) -->
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                    <div class="card-header bg-white border-bottom px-4 pt-3 pb-0">
                        <ul class="nav nav-tabs study-tabs" id="studyTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                    <i class="fa-solid fa-book-open me-1.5"></i> Overview
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
                                    <i class="fa-solid fa-note-sticky me-1.5"></i> My Study Notes
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#qa" type="button" role="tab">
                                    <i class="fa-solid fa-comments me-1.5"></i> Q&A & Support
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">
                                    <i class="fa-solid fa-folder-open me-1.5"></i> Resources & Downloads
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="cert-tab" data-bs-toggle="tab" data-bs-target="#cert" type="button" role="tab">
                                    <i class="fa-solid fa-award me-1.5"></i> Certificate Status
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content" id="studyTabContent">
                            
                            <!-- Tab 1: Overview -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-2">About this Lecture</h6>
                                <p class="text-muted small mb-4 lh-base">
                                    {{ !empty($currentLesson->course_description) ? $currentLesson->course_description : ($course->short_description ?? 'This lecture covers practical concepts, real-world examples, and foundational exercises designed to build career-ready proficiency.') }}
                                </p>

                                <h6 class="fw-bold text-dark mb-2">Course Master Information</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <span class="text-muted small d-block">Authorized Instructor</span>
                                            <strong class="text-dark">{{ $course->instructor_name ?? 'Digital Class Certified Instructor' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <span class="text-muted small d-block">Category & Language</span>
                                            <strong class="text-dark">{{ $course->category ?? 'Professional Training' }} • {{ $course->course_language ?? 'English' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-primary bg-opacity-10 rounded-3 text-primary small">
                                    <i class="fa-solid fa-circle-check me-1.5"></i>
                                    <strong>Learning Goal:</strong> Complete practical exercises after each lecture. You have lifetime access to re-watch anytime!
                                </div>
                            </div>

                            <!-- Tab 2: My Study Notes with Timestamp & Export -->
                            <div class="tab-pane fade" id="notes" role="tabpanel">
                                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0">Lecture Notebook</h6>
                                        <span class="text-muted small">Your personal study notes are auto-saved to your student profile.</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success bg-opacity-10 text-success d-none" id="noteSavedBadge">
                                            <i class="fa-solid fa-check me-1"></i> Saved!
                                        </span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="exportNotesToFile()">
                                            <i class="fa-solid fa-download me-1"></i> Export Notes (.txt)
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control rounded-3" id="studentNoteText" rows="6" placeholder="Type your personal lecture takeaways, formulas, code snippets, or questions here...">{{ $currentNote ? $currentNote->note : '' }}</textarea>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm" onclick="saveStudentNote()">
                                        <i class="fa-solid fa-floppy-disk me-1.5"></i> Save Study Note
                                    </button>
                                </div>

                                <!-- Previous Notes in this course -->
                                @if(isset($allCourseNotes) && $allCourseNotes->isNotEmpty())
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="fw-bold text-dark mb-2 small text-uppercase">Your Saved Notes for this Course ({{ $allCourseNotes->count() }})</h6>
                                        <div class="list-group list-group-flush small">
                                            @foreach($allCourseNotes as $prevNote)
                                                <div class="list-group-item px-0 py-2">
                                                    <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                                                        <span>Lecture ID #{{ $prevNote->lesson_id }}</span>
                                                        <span>{{ $prevNote->updated_at ? $prevNote->updated_at->diffForHumans() : '' }}</span>
                                                    </div>
                                                    <p class="text-dark small mb-0 mt-1">{{ $prevNote->note }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Tab 3: Q&A -->
                            <div class="tab-pane fade" id="qa" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-2">Discussion & Question Desk</h6>
                                <p class="text-muted small mb-3">Have questions about this lecture? Ask the community and instructor.</p>
                                
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Ask a question about this topic..." id="qaInput">
                                    <button class="btn btn-primary px-3" type="button" onclick="postQuestion()">Post Question</button>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="d-flex gap-3 mb-3">
                                        <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-user small"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small">Priya Sharma <span class="text-muted fw-normal">• 2 days ago</span></div>
                                            <p class="text-muted small mb-1">What is the best practice for memory management during large file reads in this module?</p>
                                            <span class="badge bg-light text-primary border small"><i class="fa-solid fa-check text-success me-1"></i> Answered by Instructor: Using try-with-resources and buffered streaming ensures streams are closed cleanly without memory leaks.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 4: Resources -->
                            <div class="tab-pane fade" id="resources" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-2">Lecture Resources & Source Code</h6>
                                <p class="text-muted small mb-3">Downloadable supplementary materials for this course module.</p>
                                
                                <div class="list-group list-group-flush small">
                                    <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <i class="fa-solid fa-file-code text-primary fs-5"></i>
                                            <div>
                                                <div class="fw-semibold text-dark">Course_Source_Code_Module_{{ $currentLesson ? $currentLesson->lesson_no : 1 }}.zip</div>
                                                <span class="text-muted" style="font-size: 0.75rem;">Complete starter project and solution files (2.4 MB)</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="alert('Downloading source code package...');">
                                            <i class="fa-solid fa-download me-1"></i> Download
                                        </button>
                                    </div>
                                    <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <i class="fa-solid fa-file-pdf text-danger fs-5"></i>
                                            <div>
                                                <div class="fw-semibold text-dark">Lecture_Handout_CheatSheet.pdf</div>
                                                <span class="text-muted" style="font-size: 0.75rem;">Summary sheet with syntax cheat-sheet (1.1 MB)</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="alert('Downloading lecture cheat-sheet...');">
                                            <i class="fa-solid fa-download me-1"></i> Download
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 5: Certificate Status -->
                            <div class="tab-pane fade" id="cert" role="tabpanel">
                                <div class="text-center py-4">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                        <i class="fa-solid fa-certificate fs-1"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">Official Certificate of Completion</h5>
                                    <p class="text-muted small mb-3" style="max-width: 480px; margin-inline: auto;">
                                        Complete all video lectures in this course (100% progress) to generate and download your personalized, verified certificate.
                                    </p>
                                    
                                    <div class="mb-4">
                                        <span class="badge {{ $progressPercent >= 100 ? 'bg-success' : 'bg-primary' }} px-3 py-1.5 rounded-pill fs-6 fw-semibold">
                                            Current Progress: {{ $progressPercent }}% ({{ $completedCount }} / {{ $totalLessons }} Lectures)
                                        </span>
                                    </div>

                                    <a href="{{ route('customer.course.certificate', ['courseId' => $course->id]) }}" class="btn {{ $progressPercent >= 100 ? 'btn-success' : 'btn-outline-primary' }} rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        <i class="fa-solid fa-award me-1.5"></i>
                                        <span>{{ $progressPercent >= 100 ? 'View & Download Certificate' : 'Preview Certificate Template' }}</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Interactive Course Curriculum Sidebar -->
            <div class="col-12 col-xl-4 sidebar-stage-col" id="sidebarStageCol">
                <div class="curriculum-sidebar">
                    
                    <!-- Sidebar Header with Live Search -->
                    <div class="p-3 border-bottom bg-white sticky-top">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="fw-bold text-dark mb-0">Course Content</h6>
                            <span class="badge bg-primary text-white rounded-pill px-2.5 py-1" style="font-size: 0.72rem;" id="sideProgressText">
                                {{ $completedCount }}/{{ $totalLessons }} ({{ $progressPercent }}%)
                            </span>
                        </div>

                        <!-- Instant Lesson Search -->
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 10px; left: 12px; font-size: 0.75rem;"></i>
                            <input type="text" id="curriculumSearchInput" class="form-control search-input-curriculum w-100" placeholder="Search lectures in syllabus..." oninput="filterLessons()">
                        </div>
                    </div>

                    <!-- Chapters Accordion -->
                    <div class="accordion accordion-flush flex-grow-1" id="curriculumAccordion">
                        @foreach($chapters as $idx => $chapter)
                            <div class="accordion-item border-0 border-bottom chapter-group">
                                <h2 class="accordion-header" id="heading{{ $chapter->id }}">
                                    <button class="accordion-button py-3 px-3 fw-bold text-dark" style="font-size: 0.88rem; background-color: #f8fafc;" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $chapter->id }}" aria-expanded="{{ ($currentLesson && in_array($currentLesson->id, $chapter->lessons->pluck('id')->toArray())) ? 'true' : ($idx === 0 ? 'true' : 'false') }}">
                                        <div class="d-flex align-items-center justify-content-between w-100 pe-2">
                                            <span class="text-truncate" style="max-width: 230px;">
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
                                            <div class="lesson-item {{ $isActive ? 'active' : '' }}" id="lessonItem{{ $lesson->id }}" data-lesson-name="{{ strtolower($lesson->lesson_name) }}">
                                                
                                                <!-- Direct Checkbox Toggle -->
                                                <div class="flex-shrink-0" onclick="event.stopPropagation();">
                                                    <input type="checkbox" class="form-check-input checkbox-lesson" id="checkLesson{{ $lesson->id }}" {{ $isComp ? 'checked' : '' }} onchange="toggleLessonFromCheckbox({{ $lesson->id }}, this.checked)">
                                                </div>

                                                <!-- Clickable Title & Duration to jump lecture -->
                                                <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}" class="flex-grow-1 overflow-hidden text-decoration-none">
                                                    <div class="text-dark small text-truncate lesson-title mb-0.5" title="{{ $lesson->lesson_name }}">
                                                        {{ $lesson->lesson_name }}
                                                    </div>
                                                    <div class="text-muted d-flex align-items-center gap-1.5" style="font-size: 0.72rem;">
                                                        <i class="fa-regular fa-clock"></i>
                                                        <span>{{ $lesson->duration }}</span>
                                                        @if($isActive)
                                                            <span class="badge bg-primary bg-opacity-10 text-primary ms-1" style="font-size: 0.65rem;">Now Playing</span>
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
let isTheaterMode = false;

function toggleTheaterMode() {
    isTheaterMode = !isTheaterMode;
    const wrapper = document.getElementById('classroomMainWrapper');
    const icon = document.getElementById('theaterIcon');

    if (isTheaterMode) {
        wrapper.classList.add('theater-mode-active');
        icon.className = 'fa-solid fa-compress';
    } else {
        wrapper.classList.remove('theater-mode-active');
        icon.className = 'fa-solid fa-expand';
    }
}

function toggleCurrentLesson() {
    if (!currentLessonId) return;
    const btn = document.getElementById('completeBtn');
    const btnText = document.getElementById('completeBtnText');
    btn.disabled = true;

    triggerLessonToggle(currentLessonId, function(data) {
        btn.disabled = false;
        if (data.success) {
            isCompleted = data.completed;
            
            // Update button UI
            if (isCompleted) {
                btn.className = 'btn btn-sm btn-success rounded-pill px-3.5 py-1.5 fw-bold d-flex align-items-center gap-1.5 shadow-sm';
                btnText.innerText = 'Completed';
                btn.querySelector('i').className = 'fa-solid fa-circle-check';
            } else {
                btn.className = 'btn btn-sm btn-outline-primary rounded-pill px-3.5 py-1.5 fw-bold d-flex align-items-center gap-1.5 shadow-sm';
                btnText.innerText = 'Mark as Completed';
                btn.querySelector('i').className = 'fa-solid fa-check';
            }

            // Sync sidebar checkbox
            const chk = document.getElementById(`checkLesson${currentLessonId}`);
            if (chk) chk.checked = isCompleted;

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

function toggleLessonFromCheckbox(lessonId, isChecked) {
    triggerLessonToggle(lessonId, function(data) {
        if (data.success && lessonId == currentLessonId) {
            isCompleted = data.completed;
            const btn = document.getElementById('completeBtn');
            const btnText = document.getElementById('completeBtnText');
            if (isCompleted) {
                btn.className = 'btn btn-sm btn-success rounded-pill px-3.5 py-1.5 fw-bold d-flex align-items-center gap-1.5 shadow-sm';
                btnText.innerText = 'Completed';
                btn.querySelector('i').className = 'fa-solid fa-circle-check';
            } else {
                btn.className = 'btn btn-sm btn-outline-primary rounded-pill px-3.5 py-1.5 fw-bold d-flex align-items-center gap-1.5 shadow-sm';
                btnText.innerText = 'Mark as Completed';
                btn.querySelector('i').className = 'fa-solid fa-check';
            }
        }
    });
}

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
            // Update top progress meters
            const topBar = document.getElementById('topProgressBar');
            const topBadge = document.getElementById('topProgressBadge');
            const sideText = document.getElementById('sideProgressText');

            if (topBar) topBar.style.width = data.progress_percent + '%';
            if (topBadge) topBadge.innerText = data.progress_percent + '%';
            if (sideText) sideText.innerText = `${data.completed_count}/${data.total_count} (${data.progress_percent}%)`;

            // If finished 100%, show celebratory notice
            if (data.is_finished) {
                alert('Congratulations! You have completed all lectures in this course! Your Certificate of Completion is now ready.');
            }
        }
        if (callback) callback(data);
    })
    .catch(err => console.error('Error toggling lesson:', err));
}

function filterLessons() {
    const q = document.getElementById('curriculumSearchInput').value.toLowerCase().trim();
    const items = document.querySelectorAll('.curriculum-sidebar .lesson-item');

    items.forEach(item => {
        const name = item.getAttribute('data-lesson-name') || '';
        item.style.display = name.includes(q) ? '' : 'none';
    });
}

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
            setTimeout(() => badge.classList.add('d-none'), 3000);
        }
    });
}

function exportNotesToFile() {
    const text = document.getElementById('studentNoteText').value;
    if (!text.trim()) {
        alert('Your notebook is empty. Write some notes first before exporting.');
        return;
    }
    const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `Study_Notes_Lecture_${currentLessonId}.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function postQuestion() {
    const input = document.getElementById('qaInput');
    if (!input.value.trim()) return;
    alert('Your question has been posted to the instructor forum!');
    input.value = '';
}
</script>
@endsection
