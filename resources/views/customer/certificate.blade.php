@extends('layouts.app')

@section('title', 'Certificate of Completion - ' . ($course->title ?? $course->course_name))

@section('styles')
<style>
    .cert-container {
        max-width: 900px;
        margin: 2rem auto;
        background: #ffffff;
        border: 12px double #b45309;
        border-radius: 12px;
        padding: 3.5rem 3rem;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        position: relative;
        text-align: center;
        background-image: radial-gradient(circle at center, #ffffff 0%, #fffbeb 100%);
    }
    .cert-corner-tl, .cert-corner-tr, .cert-corner-bl, .cert-corner-br {
        position: absolute;
        width: 36px;
        height: 36px;
        border: 4px solid #b45309;
    }
    .cert-corner-tl { top: 8px; left: 8px; border-right: none; border-bottom: none; }
    .cert-corner-tr { top: 8px; right: 8px; border-left: none; border-bottom: none; }
    .cert-corner-bl { bottom: 8px; left: 8px; border-right: none; border-top: none; }
    .cert-corner-br { bottom: 8px; right: 8px; border-left: none; border-top: none; }

    @media print {
        body * {
            visibility: hidden;
        }
        .cert-container, .cert-container * {
            visibility: visible;
        }
        .cert-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
            border: 8px double #b45309;
            box-shadow: none;
            margin: 0;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="py-4 bg-light" style="min-height: 80vh;">
    <div class="container">

        <!-- Top Action Toolbar -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2 no-print">
            <a href="{{ route('customer.course.learn', ['courseId' => $course->id]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Classroom
            </a>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm" onclick="window.print()">
                    <i class="fa-solid fa-print me-1.5"></i> Print / Download PDF
                </button>
            </div>
        </div>

        @if($percent < 100)
            <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 text-center no-print" role="alert">
                <i class="fa-solid fa-circle-info me-1"></i>
                <strong>Note:</strong> You have completed <strong>{{ $percent }}%</strong> of the lectures. This is an official preview. Once you complete 100% of the lessons, your certificate is officially verified and recorded in the public registry.
            </div>
        @endif

        <!-- Certificate Frame -->
        <div class="cert-container">
            <div class="cert-corner-tl"></div>
            <div class="cert-corner-tr"></div>
            <div class="cert-corner-bl"></div>
            <div class="cert-corner-br"></div>

            <!-- Organization Header -->
            <div class="mb-3">
                <span class="text-uppercase tracking-wider fw-bold text-muted small" style="letter-spacing: 3px;">DIGITAL CLASS WORLD EDUCATION</span>
                <h1 class="fw-bold text-dark mt-2 mb-1" style="font-family: Georgia, serif; font-size: 2.4rem;">
                    Certificate of Completion
                </h1>
                <div class="text-muted fst-italic" style="font-size: 0.95rem;">
                    This is proudly presented in recognition of successful course completion to
                </div>
            </div>

            <!-- Student Name -->
            <div class="my-4 py-2 border-bottom border-warning border-opacity-50 d-inline-block px-5">
                <h2 class="fw-bold text-primary mb-0" style="font-family: 'Times New Roman', serif; font-size: 2.2rem; letter-spacing: 0.5px;">
                    {{ $user->name }}
                </h2>
            </div>

            <!-- Course Title & Description -->
            <div class="mb-4">
                <p class="text-muted mb-2" style="font-size: 0.95rem;">
                    For demonstrating mastery and completing all required video lectures, coursework, and practical exercises in
                </p>
                <h3 class="fw-bold text-dark mb-2" style="font-size: 1.5rem;">
                    {{ $course->title ?? $course->course_name }}
                </h3>
                <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-1.5 rounded-pill fw-semibold">
                    {{ $course->category ?? 'Professional Training' }} • {{ $course->level ?? 'All Levels' }}
                </span>
            </div>

            <!-- Verification & Signatures -->
            <div class="row align-items-end mt-5 pt-3 border-top border-secondary border-opacity-25 text-start">
                <div class="col-4">
                    <div class="text-center">
                        <div class="fw-bold font-monospace text-dark mb-1" style="font-size: 0.85rem;">{{ $completionDate->format('d M, Y') }}</div>
                        <div class="border-top border-dark pt-1 small text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 1px;">Date of Issuance</div>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center p-3 border border-warning shadow-sm" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-stamp fs-3 text-warning"></i>
                    </div>
                    <div class="small text-muted mt-1 font-monospace" style="font-size: 0.7rem;">ID: {{ $certificateId }}</div>
                </div>
                <div class="col-4">
                    <div class="text-center">
                        <div class="fw-bold text-dark mb-1 fst-italic" style="font-size: 0.95rem; font-family: cursive;">{{ $instructorName }}</div>
                        <div class="border-top border-dark pt-1 small text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 1px;">Authorized Instructor</div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
