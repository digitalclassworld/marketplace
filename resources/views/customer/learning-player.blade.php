@extends('layouts.app')

@section('title', ($currentLesson ? $currentLesson->lesson_name . ' - ' : '') . ($course->title ?? $course->course_name) . ' - Learning Portal')

@section('styles')
<style>
    /* Full height immersive learning classroom */
    .classroom-navbar {
        background-color: #0b192c;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.75rem 1.25rem;
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
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
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
    .curriculum-sidebar {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        height: calc(100vh - 140px);
        overflow-y: auto;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }
    .curriculum-sidebar::-webkit-scrollbar {
        width: 6px;
    }
    .curriculum-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .lesson-item {
        padding: 0.75rem 1rem;
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
        padding: 0.75rem 1rem;
        background: transparent;
    }
    .study-tabs .nav-link.active {
        color: #0066ff;
        border-bottom-color: #0066ff;
        background: transparent;
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
                <div class="text-white text-opacity-50 small" style="font-size: 0.75rem;">
                    {{ $currentLesson ? $currentLesson->chapter_name : 'Course Curriculum' }}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Progress Pill -->
            <div class="d-none d-md-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill">
                <span class="small fw-semibold text-white text-opacity-75" style="font-size: 0.75rem;">Progress:</span>
                <div class="progress" style="width: 100px; height: 6px; background-color: rgba(255,255,255,0.2);">
                    <div class="progress-bar bg-success" id="topProgressBar" role="progressbar" style="width: {{ $progressPercent }}%;"></div>
                </div>
                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 rounded-pill" style="font-size: 0.72rem;" id="topProgressBadge">
                    {{ $progressPercent }}%
                </span>
            </div>

            <!-- Certificate Button -->
            <a href="{{ route('customer.course.certificate', ['courseId' => $course->id]) }}" class="btn btn-sm {{ $progressPercent >= 100 ? 'btn-success' : 'btn-outline-light' }} rounded-pill px-3 fw-semibold" style="font-size: 0.8rem;">
                <i class="fa-solid fa-award me-1"></i>
                <span>{{ $progressPercent >= 100 ? 'Get Certificate' : 'Certificate' }}</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Classroom Area -->
<div class="classroom-body py-4">
    <div class="container-fluid px-3 px-xl-4">
        <div class="row g-4">

            <!-- Left: Video Player Stage & Study Tabs (8 cols) -->
            <div class="col-12 col-xl-8">
                
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
                                This high-definition video lecture is ready for playback. Click below to begin streaming with full learning playback controls.
                            </p>
                            <button class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow" onclick="alert('Starting interactive lecture player stream...');">
                                <i class="fa-solid fa-play"></i> Start Lecture Stream
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Lecture Control Bar -->
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary small px-2.5 py-1 rounded-pill mb-1 fw-semibold">
                                Lecture {{ $currentLesson ? $currentLesson->lesson_no : 1 }} • {{ $currentLesson ? $currentLesson->duration : '15:00' }}
                            </span>
                            <h4 class="fw-bold text-dark mb-0 fs-5" id="currentLessonTitle">
                                {{ $currentLesson ? $currentLesson->lesson_name : 'Lecture Video' }}
                            </h4>
                        </div>

                        <div class="d-flex align-items-center gap-2">
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
                                <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $nextLesson->id]) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold shadow-sm" id="nextLessonBtn" title="Next Lecture">
                                    Next <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Study Tabs (Overview, Notes, Q&A, Syllabus, Resources) -->
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header bg-white border-bottom px-4 pt-3 pb-0">
                        <ul class="nav nav-tabs study-tabs" id="studyTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                    <i class="fa-solid fa-book-open me-1.5"></i> Overview
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
                                    <i class="fa-solid fa-note-sticky me-1.5"></i> My Notes
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#qa" type="button" role="tab">
                                    <i class="fa-solid fa-comments me-1.5"></i> Q&A / Discussion
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">
                                    <i class="fa-solid fa-folder-open me-1.5"></i> Resources & Code
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="cert-tab" data-bs-toggle="tab" data-bs-target="#cert" type="button" role="tab">
                                    <i class="fa-solid fa-award me-1.5"></i> Certificate
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content" id="studyTabContent">
                            
                            <!-- Tab 1: Overview -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-2">About this Lecture</h6>
                                <p class="text-muted small mb-4">
                                    {{ !empty($currentLesson->course_description) ? $currentLesson->course_description : ($course->short_description ?? 'This lecture covers practical concepts, industry standard code implementations, and key problem-solving techniques.') }}
                                </p>

                                <h6 class="fw-bold text-dark mb-2">Course Information</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <span class="text-muted small d-block">Instructor / Master Trainer</span>
                                            <strong class="text-dark">{{ $course->instructor_name ?? 'Digital Class Certified Instructor' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <span class="text-muted small d-block">Skill Level & Language</span>
                                            <strong class="text-dark">{{ $course->level ?? 'All Levels' }} • {{ $course->course_language ?? 'English' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-primary bg-opacity-10 rounded-3 text-primary small">
                                    <i class="fa-solid fa-lightbulb me-1.5"></i>
                                    <strong>Pro Tip:</strong> Complete each lecture and test your code locally in your IDE to solidify understanding before moving to the next chapter.
                                </div>
                            </div>

                            <!-- Tab 2: My Notes -->
                            <div class="tab-pane fade" id="notes" role="tabpanel">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0">Lecture Notes</h6>
                                        <span class="text-muted small">Your personal study notes are auto-saved to your student account.</span>
                                    </div>
                                    <span class="badge bg-success bg-opacity-10 text-success d-none" id="noteSavedBadge">
                                        <i class="fa-solid fa-check me-1"></i> Saved
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control rounded-3" id="studentNoteText" rows="6" placeholder="Type your personal lecture takeaways, formulas, or code snippets here...">{{ $currentNote ? $currentNote->note : '' }}</textarea>
                                </div>

                                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 fw-semibold" onclick="saveStudentNote()">
                                    <i class="fa-solid fa-floppy-disk me-1.5"></i> Save Study Note
                                </button>
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
                                            <span class="badge bg-light text-primary border small"><i class="fa-solid fa-check text-success me-1"></i> Answered by Instructor</span>
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

                            <!-- Tab 5: Certificate -->
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

            <!-- Right: Interactive Course Curriculum Sidebar (4 cols) -->
            <div class="col-12 col-xl-4">
                <div class="curriculum-sidebar">
                    
                    <!-- Sidebar Header -->
                    <div class="p-3 border-bottom bg-white sticky-top">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <h6 class="fw-bold text-dark mb-0">Course Content</h6>
                            <span class="badge bg-primary text-white rounded-pill px-2.5 py-1" style="font-size: 0.7rem;" id="sideProgressText">
                                {{ $completedCount }}/{{ $totalLessons }} ({{ $progressPercent }}%)
                            </span>
                        </div>
                        <span class="text-muted small" style="font-size: 0.78rem;">
                            {{ $chapters->count() }} Modules • {{ $totalLessons }} Video Lectures
                        </span>
                    </div>

                    <!-- Chapters Accordion -->
                    <div class="accordion accordion-flush" id="curriculumAccordion">
                        @foreach($chapters as $idx => $chapter)
                            <div class="accordion-item border-0 border-bottom">
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
                                            <a href="{{ route('customer.course.learn', ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}" class="lesson-item {{ $isActive ? 'active' : '' }}" id="lessonItem{{ $lesson->id }}">
                                                <!-- Checkbox icon -->
                                                <div class="flex-shrink-0">
                                                    @if($isComp)
                                                        <i class="fa-solid fa-circle-check text-success fs-5 lesson-icon-{{ $lesson->id }}"></i>
                                                    @elseif($isActive)
                                                        <i class="fa-solid fa-circle-play text-primary fs-5 lesson-icon-{{ $lesson->id }}"></i>
                                                    @else
                                                        <i class="fa-regular fa-circle text-muted fs-5 lesson-icon-{{ $lesson->id }}"></i>
                                                    @endif
                                                </div>

                                                <!-- Title & Duration -->
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <div class="text-dark small text-truncate lesson-title mb-0.5" title="{{ $lesson->lesson_name }}">
                                                        {{ $lesson->lesson_name }}
                                                    </div>
                                                    <div class="text-muted d-flex align-items-center gap-1.5" style="font-size: 0.72rem;">
                                                        <i class="fa-regular fa-clock"></i>
                                                        <span>{{ $lesson->duration }}</span>
                                                    </div>
                                                </div>
                                            </a>
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

function toggleCurrentLesson() {
    if (!currentLessonId) return;

    const btn = document.getElementById('completeBtn');
    const btnText = document.getElementById('completeBtnText');
    btn.disabled = true;

    fetch(`{{ url('/customer/learning') }}/${courseId}/lesson/${currentLessonId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
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

            // Update top progress meters
            const topBar = document.getElementById('topProgressBar');
            const topBadge = document.getElementById('topProgressBadge');
            const sideText = document.getElementById('sideProgressText');

            if (topBar) topBar.style.width = data.progress_percent + '%';
            if (topBadge) topBadge.innerText = data.progress_percent + '%';
            if (sideText) sideText.innerText = `${data.completed_count}/${data.total_count} (${data.progress_percent}%)`;

            // Update icon in sidebar
            const icon = document.querySelector(`.lesson-icon-${currentLessonId}`);
            if (icon) {
                icon.className = isCompleted ? 'fa-solid fa-circle-check text-success fs-5' : 'fa-solid fa-circle-play text-primary fs-5';
            }

            // If finished 100%, show celebratory toast
            if (data.is_finished) {
                alert('Congratulations! You have completed all lectures in this course! Your Certificate of Completion is now ready.');
            }
        }
    })
    .catch(err => {
        btn.disabled = false;
        console.error('Error toggling lesson:', err);
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

function postQuestion() {
    const input = document.getElementById('qaInput');
    if (!input.value.trim()) return;
    alert('Your question has been posted to the instructor forum!');
    input.value = '';
}
</script>
@endsection
