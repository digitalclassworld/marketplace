@extends('layouts.app')

@section('title', 'Certificate of Completion - ' . ($course->title ?? $course->course_name))

@section('styles')
<style>
    /* ==========================================================================
       LUXURY EXECUTIVE CERTIFICATE DESIGN
       ========================================================================== */
    .cert-page-bg {
        background-color: #0c1527;
        min-height: 90vh;
        padding: 2.5rem 1rem 4rem;
    }

    .cert-frame-wrapper {
        max-width: 1040px;
        margin: 0 auto;
        position: relative;
    }

    /* Certificate Outer Frame */
    .cert-container {
        background: radial-gradient(circle at center, #ffffff 0%, #fdfbf7 70%, #f7f1e3 100%);
        border: 12px double #c59b27;
        outline: 3px solid #0f172a;
        outline-offset: -18px;
        border-radius: 16px;
        padding: 3.5rem 3.5rem 3rem;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
        position: relative;
        text-align: center;
        overflow: hidden;
    }

    /* Four Corner Ornaments */
    .cert-corner {
        position: absolute;
        width: 44px;
        height: 44px;
        border: 4px solid #c59b27;
        z-index: 5;
    }
    .cert-corner-tl { top: 22px; left: 22px; border-right: none; border-bottom: none; }
    .cert-corner-tr { top: 22px; right: 22px; border-left: none; border-bottom: none; }
    .cert-corner-bl { bottom: 22px; left: 22px; border-right: none; border-top: none; }
    .cert-corner-br { bottom: 22px; right: 22px; border-left: none; border-top: none; }

    /* Fine filigree inner border */
    .cert-inner-border {
        position: absolute;
        top: 28px;
        left: 28px;
        right: 28px;
        bottom: 28px;
        border: 1px dashed rgba(197, 155, 39, 0.45);
        pointer-events: none;
    }

    /* Top Logos Header */
    .cert-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(197, 155, 39, 0.3);
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }
    .cert-logo-box {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .cert-logo-digitalclass {
        height: 46px;
        width: auto;
        max-width: 170px;
        object-fit: contain;
    }
    .cert-logo-owner {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #c59b27;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        background-color: #ffffff;
    }
    .cert-logo-subtext {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #64748b;
        font-weight: 600;
    }
    .cert-owner-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Center Crest */
    .cert-center-crest {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }
    .cert-center-crest i {
        color: #c59b27;
        font-size: 1.8rem;
    }
    .cert-center-crest span {
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 2px;
        color: #0f172a;
        text-transform: uppercase;
    }

    /* Certificate Typography */
    .cert-main-title {
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: 2.6rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        text-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .cert-subtitle {
        font-size: 0.95rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #b45309;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    /* Student Recipient Name */
    .cert-student-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: #0052cc;
        display: inline-block;
        padding-bottom: 0.4rem;
        border-bottom: 2.5px solid #c59b27;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
    }

    .cert-text-body {
        font-size: 1rem;
        color: #475569;
        max-width: 720px;
        margin: 0 auto 1.5rem;
        line-height: 1.7;
    }

    /* Course Name Banner */
    .cert-course-banner {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.05) 0%, rgba(197, 155, 39, 0.1) 100%);
        border: 1.5px solid rgba(197, 155, 39, 0.4);
        border-radius: 12px;
        padding: 0.85rem 2rem;
        display: inline-block;
        max-width: 820px;
        margin-bottom: 1.5rem;
    }
    .cert-course-title {
        font-size: 1.55rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    /* Signatures & Official Seal Footer */
    .cert-footer-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(197, 155, 39, 0.3);
        position: relative;
        z-index: 2;
    }
    .cert-sig-block {
        text-align: center;
        flex: 1;
    }
    .cert-sig-line {
        border-top: 1.5px solid #0f172a;
        padding-top: 0.4rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        font-weight: 700;
    }
    .cert-sig-name {
        font-family: 'Brush Script MT', cursive, Georgia, serif;
        font-size: 1.5rem;
        color: #0f172a;
        margin-bottom: 0.2rem;
    }

    /* Gold Foil Embossed Stamp */
    .cert-gold-stamp {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #fef08a 0%, #ca8a04 50%, #854d0e 100%);
        border: 3px solid #fef08a;
        box-shadow: 0 4px 15px rgba(202, 138, 4, 0.4), inset 0 0 10px rgba(0, 0, 0, 0.2);
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        margin: 0 auto 0.5rem;
    }
    .cert-gold-stamp i {
        font-size: 1.5rem;
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.4);
    }
    .cert-gold-stamp span {
        font-size: 0.55rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.4);
    }

    /* ==========================================================================
       SAMPLE / PREVIEW WATERMARK (Active when course progress < 100%)
       ========================================================================== */
    .cert-watermark-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-28deg);
        font-size: 3.4rem;
        font-weight: 900;
        letter-spacing: 6px;
        color: rgba(220, 38, 38, 0.18);
        border: 5px dashed rgba(220, 38, 38, 0.35);
        padding: 1.25rem 3rem;
        border-radius: 16px;
        pointer-events: none;
        user-select: none;
        z-index: 10;
        text-align: center;
        white-space: nowrap;
        text-transform: uppercase;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .cert-container {
            padding: 2rem 1.25rem;
        }
        .cert-header-row {
            flex-direction: column;
            gap: 1rem;
        }
        .cert-main-title {
            font-size: 1.8rem;
        }
        .cert-student-name {
            font-size: 1.8rem;
        }
        .cert-course-title {
            font-size: 1.2rem;
        }
        .cert-footer-row {
            flex-direction: column;
            gap: 2rem;
        }
        .cert-watermark-overlay {
            font-size: 1.8rem;
            padding: 0.75rem 1.5rem;
        }
    }

    /* Print Stylesheet */
    @media print {
        body * {
            visibility: hidden;
        }
        .no-print, .classroom-navbar, .dc-navbar, footer.dc-footer {
            display: none !important;
        }
        .cert-page-bg {
            background: none !important;
            padding: 0 !important;
            min-height: auto !important;
        }
        .cert-frame-wrapper {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
        }
        .cert-container, .cert-container * {
            visibility: visible !important;
        }
        .cert-container {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            box-shadow: none !important;
            border: 6px double #c59b27 !important;
            page-break-inside: avoid;
        }
        /* If not completed, prevent printing official certificate */
        @if(!$isCompleted)
        .cert-container {
            filter: grayscale(100%);
        }
        .cert-watermark-overlay {
            color: rgba(220, 38, 38, 0.45) !important;
            border-color: rgba(220, 38, 38, 0.6) !important;
        }
        @endif
    }
</style>
@endsection

@section('content')
<div class="cert-page-bg">
    <div class="container">

        <!-- Top Status & Action Toolbar -->
        <div class="cert-frame-wrapper mb-3 no-print">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-10 backdrop-blur">
                
                <!-- Left: Back Button & Title -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('customer.course.learn', ['courseId' => $course->id]) }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Back to Classroom</span>
                    </a>
                    <span class="text-white text-opacity-80 small d-none d-sm-inline">
                        {{ $course->title ?? $course->course_name }}
                    </span>
                </div>

                <!-- Right: Download / Lock Action -->
                <div class="d-flex align-items-center gap-2">
                    @if($isCompleted)
                        <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold small d-none d-md-inline-block">
                            <i class="fa-solid fa-circle-check me-1"></i> 100% Completed • Verified Credential
                        </span>
                        <button type="button" class="btn btn-success btn-sm rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-1.5 shadow" onclick="window.print()">
                            <i class="fa-solid fa-print"></i>
                            <span>Print / Download PDF</span>
                        </button>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold small">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Preview Mode ({{ $percent }}% Complete)
                        </span>
                        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3.5 py-2 fw-bold d-flex align-items-center gap-1.5 opacity-75" onclick="showLockedAlert()" title="Complete 100% of all lectures to unlock official download">
                            <i class="fa-solid fa-lock"></i>
                            <span>Download Locked</span>
                        </button>
                        <a href="{{ route('customer.course.learn', ['courseId' => $course->id]) }}" class="btn btn-primary btn-sm rounded-pill px-3.5 py-2 fw-bold d-flex align-items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-circle-play"></i>
                            <span>Finish Course ({{ $percent }}%)</span>
                        </a>
                    @endif
                </div>

            </div>

            <!-- Preview Notice Banner -->
            @if(!$isCompleted)
                <div class="alert alert-warning border-0 shadow-sm rounded-4 mt-3 mb-0 d-flex align-items-center justify-content-between flex-wrap gap-2" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-info fs-5 text-warning"></i>
                        <span class="small">
                            <strong>Template Preview Only:</strong> You have completed <strong>{{ $percent }}%</strong> of the lectures. You can preview how your certificate will look, but <strong>official downloading and printing are locked</strong> until all lectures (100%) are completed.
                        </span>
                    </div>
                    <span class="badge bg-dark text-white rounded-pill px-3 py-1.5 small">
                        {{ $completedLessons }} / {{ $totalLessons }} Finished
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mt-3 mb-0 small">
                    <i class="fa-solid fa-circle-xmark me-1"></i> {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- The Executive Certificate Frame -->
        <div class="cert-frame-wrapper">
            <div class="cert-container" id="certificateNode">
                
                <!-- Ornate Corner Accents -->
                <div class="cert-corner cert-corner-tl"></div>
                <div class="cert-corner cert-corner-tr"></div>
                <div class="cert-corner cert-corner-bl"></div>
                <div class="cert-corner cert-corner-br"></div>
                <div class="cert-inner-border"></div>

                <!-- SAMPLE / PREVIEW WATERMARK (Only shown when not 100% completed) -->
                @if(!$isCompleted)
                    <div class="cert-watermark-overlay">
                        <span>SAMPLE PREVIEW • NOT VERIFIED</span>
                    </div>
                @endif

                <!-- 1. Header with TWO OFFICIAL LOGOS: Digital Class & Course Owner -->
                <div class="cert-header-row">
                    
                    <!-- Left: Digital Class World Official Platform Logo -->
                    <div class="cert-logo-box text-start">
                        <img src="{{ $digitalClassLogo }}" alt="Digital Class" class="cert-logo-digitalclass">
                        <div>
                            <div class="fw-bold text-dark small" style="letter-spacing: 0.5px;">DIGITAL CLASS WORLD</div>
                            <div class="cert-logo-subtext">Accredited E-Learning Platform</div>
                        </div>
                    </div>

                    <!-- Center: Official Gold Crest Emblem -->
                    <div class="cert-center-crest">
                        <i class="fa-solid fa-award"></i>
                        <span>Verified Credential</span>
                    </div>

                    <!-- Right: Course Owner / Academy / Instructor Logo -->
                    <div class="cert-logo-box text-end flex-row-reverse">
                        <img src="{{ $ownerLogo }}" alt="{{ $ownerName }}" class="cert-logo-owner">
                        <div>
                            <div class="cert-owner-name">{{ $ownerName }}</div>
                            <div class="cert-logo-subtext">{{ $ownerOrg }}</div>
                        </div>
                    </div>

                </div>

                <!-- 2. Certificate Title -->
                <div class="cert-main-title">Certificate of Completion</div>
                <div class="cert-subtitle">This is Proudly Conferred Upon</div>

                <!-- 3. Student Recipient Name -->
                <div>
                    <span class="cert-student-name">{{ $user->name }}</span>
                </div>

                <!-- 4. Achievement Description -->
                <p class="cert-text-body">
                    for demonstrating exceptional competence and successfully completing all curriculum modules, coursework assessments, and required instructional video lectures in the certified professional program:
                </p>

                <!-- 5. Course Title Banner -->
                <div class="cert-course-banner">
                    <h3 class="cert-course-title">{{ $course->title ?? $course->course_name }}</h3>
                </div>

                <!-- Course Category & Verification Tags -->
                <div class="mb-4">
                    <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold me-2">
                        <i class="fa-solid fa-tag text-primary me-1"></i> {{ $course->category ?? 'Professional Training' }}
                    </span>
                    <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold me-2">
                        <i class="fa-solid fa-video text-success me-1"></i> {{ $totalLessons }} Lectures Finished
                    </span>
                    <span class="badge {{ $isCompleted ? 'bg-success text-white' : 'bg-warning text-dark' }} px-3 py-1.5 rounded-pill small fw-bold">
                        <i class="fa-solid {{ $isCompleted ? 'fa-check-double' : 'fa-hourglass-half' }} me-1"></i>
                        {{ $isCompleted ? 'Verified & Complete' : 'Incomplete (Preview)' }}
                    </span>
                </div>

                <!-- 6. Verification & Dual Authorized Signatures -->
                <div class="cert-footer-row">
                    
                    <!-- Left: Issuance Date & Digital Class Director Signature -->
                    <div class="cert-sig-block text-start">
                        <div class="fw-bold font-monospace text-dark mb-1" style="font-size: 0.9rem;">
                            {{ $completionDate->format('d F, Y') }}
                        </div>
                        <div class="cert-sig-line">Date of Issuance</div>
                        <div class="small text-muted mt-1" style="font-size: 0.72rem;">Digital Class Academic Registrar</div>
                    </div>

                    <!-- Center: Grand Gold Foil Stamp Seal & Credential ID -->
                    <div class="cert-sig-block text-center">
                        <div class="cert-gold-stamp">
                            <i class="fa-solid fa-stamp"></i>
                            <span>VERIFIED</span>
                        </div>
                        <div class="font-monospace text-dark fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                            ID: {{ $certificateId }}
                        </div>
                        <div class="small text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                            web.digitalclassworld.in/verify
                        </div>
                    </div>

                    <!-- Right: Authorized Course Owner / Instructor Signature -->
                    <div class="cert-sig-block text-end">
                        <div class="cert-sig-name">{{ $ownerName }}</div>
                        <div class="cert-sig-line">Authorized Course Instructor</div>
                        <div class="small text-muted mt-1" style="font-size: 0.72rem;">{{ $ownerOrg }}</div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<!-- Modal: Download Locked Notification -->
<div class="modal fade" id="lockedModal" tabindex="-1" aria-labelledby="lockedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-lock fs-1 text-warning"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Certificate Download Locked</h4>
                <p class="text-secondary small mb-3">
                    You have completed <strong>{{ $percent }}%</strong> ({{ $completedLessons }} of {{ $totalLessons }} lectures).
                    To maintain academic accreditation and credibility, official PDF downloads and printing are enabled only after achieving <strong>100% course completion</strong>.
                </p>
                <div class="progress mb-3" style="height: 10px; border-radius: 999px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%;"></div>
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('customer.course.learn', ['courseId' => $course->id]) }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="fa-solid fa-play me-1"></i> Continue Course
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function showLockedAlert() {
    const modalEl = document.getElementById('lockedModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } else {
        alert('Certificate Download Locked: You must complete 100% of all lectures to download or print your official certificate (Current Progress: {{ $percent }}%).');
    }
}

// Intercept Ctrl+P or Command+P if not completed
@if(!$isCompleted)
window.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P')) {
        e.preventDefault();
        showLockedAlert();
    }
});
@endif
</script>
@endsection
