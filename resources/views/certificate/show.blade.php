<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Achievement - {{ $certificate->student_name }} - {{ $certificate->certificate_no }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Great+Vibes&family=Pinyon+Script&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- html2pdf.js library for client-side PDF download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        :root {
            --cert-gold-dark: #8a5814;
            --cert-gold-mid: #b38029;
            --cert-gold-light: #c59b27;
            --cert-gold-pale: #e0c37b;
            --cert-bg: #fffefb;
            --cert-ribbon-bg: #faeed4;
        }

        body {
            background-color: #0f172a;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Top Action Toolbar */
        .cert-toolbar {
            background: #1e293b;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.85rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .cert-canvas-wrapper {
            padding: 2.5rem 1rem 4rem 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: auto;
        }

        /* Certificate Canvas - Landscape A4 Proportion (1050px x 742px) */
        #certificateCanvas {
            width: 1050px;
            height: 742px;
            background-color: var(--cert-bg);
            background-image:
                radial-gradient(ellipse at 50% 50%, rgba(255, 255, 255, 0.9) 0%, rgba(253, 250, 243, 0.95) 75%, rgba(248, 241, 227, 0.8) 100%);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            padding: 22px;
            position: relative;
            box-sizing: border-box;
            user-select: none;
            overflow: hidden;
        }

        /* Outer Thin Gold Border */
        .cert-outer-frame {
            width: 100%;
            height: 100%;
            border: 2px solid var(--cert-gold-mid);
            padding: 10px;
            position: relative;
            box-sizing: border-box;
        }

        /* Inner Double Gold Border */
        .cert-inner-frame {
            width: 100%;
            height: 100%;
            border: 3px double var(--cert-gold-mid);
            outline: 1px solid var(--cert-gold-pale);
            outline-offset: 4px;
            padding: 24px 34px 20px 34px;
            position: relative;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Corner Filigree SVGs */
        .corner-filigree {
            position: absolute;
            width: 110px;
            height: 110px;
            pointer-events: none;
            z-index: 2;
        }
        .corner-filigree.top-left {
            top: 6px;
            left: 6px;
        }
        .corner-filigree.top-right {
            top: 6px;
            right: 6px;
            transform: scaleX(-1);
        }
        .corner-filigree.bottom-left {
            bottom: 6px;
            left: 6px;
            transform: scaleY(-1);
        }
        .corner-filigree.bottom-right {
            bottom: 6px;
            right: 6px;
            transform: scale(-1, -1);
        }

        /* Top Logos Row */
        .cert-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0 10px;
        }

        .cert-institute-badge {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-align: right;
        }

        .institute-wreath-icon {
            color: var(--cert-gold-mid);
            font-size: 2.2rem;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .institute-wreath-icon i.fa-graduation-cap {
            font-size: 0.95rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #8a5814;
        }

        .institute-name-text {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            color: #2b1f09;
            font-size: 1.15rem;
            line-height: 1.1;
            letter-spacing: 0.04em;
        }

        /* Title Area */
        .cert-title-area {
            text-align: center;
            margin-top: -6px;
        }

        .cert-main-title {
            font-family: 'Cinzel', serif;
            font-size: 2.75rem;
            font-weight: 800;
            letter-spacing: 0.22em;
            color: var(--cert-gold-dark);
            margin: 0;
            line-height: 1;
            text-transform: uppercase;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.8);
        }

        .cert-of-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 4px 0 2px 0;
        }

        .cert-of-text {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.25em;
            color: var(--cert-gold-dark);
        }

        .cert-sub-title {
            font-family: 'Cinzel', serif;
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 0.2em;
            color: var(--cert-gold-dark);
            margin: 0;
            line-height: 1;
            text-transform: uppercase;
        }

        .cert-divider-scroll {
            margin: 6px auto 0 auto;
            width: 240px;
            height: 14px;
        }

        /* Awarded To */
        .cert-awarded-text {
            text-align: center;
            font-size: 0.8rem;
            letter-spacing: 0.22em;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            margin: 8px 0 2px 0;
        }

        .cert-recipient-name {
            font-family: 'Pinyon Script', 'Great Vibes', cursive;
            font-size: 3.8rem;
            color: #6a3a05;
            text-align: center;
            line-height: 1.05;
            margin: 0 0 2px 0;
            font-weight: 500;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9);
        }

        .cert-name-underline {
            margin: 0 auto 6px auto;
            width: 380px;
            height: 12px;
            display: block;
        }

        .cert-completion-desc {
            text-align: center;
            font-size: 0.88rem;
            color: #334155;
            font-weight: 500;
            margin: 0 0 8px 0;
        }

        /* Ribbon Course Banner */
        .cert-ribbon-container {
            display: flex;
            justify-content: center;
            margin-bottom: 6px;
        }

        .cert-course-ribbon {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fef3c7 100%);
            border-top: 1.5px solid var(--cert-gold-mid);
            border-bottom: 1.5px solid var(--cert-gold-mid);
            padding: 0.5rem 3rem;
            position: relative;
            box-shadow: 0 2px 6px rgba(180, 128, 41, 0.15);
        }
        .cert-course-ribbon::before,
        .cert-course-ribbon::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 0;
            height: 0;
            border-style: solid;
            transform: translateY(-50%);
        }
        .cert-course-ribbon::before {
            left: -14px;
            border-width: 14px 14px 14px 0;
            border-color: transparent #fde68a transparent transparent;
        }
        .cert-course-ribbon::after {
            right: -14px;
            border-width: 14px 0 14px 14px;
            border-color: transparent transparent transparent #fde68a;
        }

        .cert-course-title {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            font-size: 1.45rem;
            color: #1e293b;
            letter-spacing: 0.04em;
            margin: 0;
            text-transform: capitalize;
        }

        .cert-dedication-sub {
            text-align: center;
            font-size: 0.8rem;
            color: #475569;
            font-style: italic;
            margin-bottom: 14px;
        }

        /* 5-Column Metadata Table */
        .cert-meta-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            width: 88%;
            margin: 0 auto 12px auto;
            text-align: center;
            border-top: 1px solid rgba(197, 155, 39, 0.25);
            padding-top: 8px;
        }

        .cert-meta-col {
            position: relative;
            padding: 0 8px;
        }
        .cert-meta-col:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 2px;
            bottom: 2px;
            width: 1px;
            background: rgba(197, 155, 39, 0.4);
        }

        .cert-meta-label {
            font-size: 0.68rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 2px;
        }

        .cert-meta-value {
            font-size: 0.8rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Bottom Signatures & Seal Section */
        .cert-bottom-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 0 20px 6px 20px;
            margin-top: 6px;
        }

        .cert-signature-block {
            width: 220px;
            text-align: center;
        }

        .cert-sig-script {
            font-family: 'Great Vibes', cursive;
            font-size: 2.3rem;
            color: #1e293b;
            line-height: 1;
            margin-bottom: -4px;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cert-sig-line {
            width: 100%;
            height: 1px;
            background-color: #1e293b;
            margin: 2px auto 5px auto;
        }

        .cert-sig-name {
            font-weight: 700;
            font-size: 0.85rem;
            color: #0f172a;
            line-height: 1.2;
        }

        .cert-sig-role {
            font-size: 0.72rem;
            color: #64748b;
            line-height: 1.2;
        }

        /* Center Golden Seal */
        .cert-seal-center {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .cert-seal-graphic {
            width: 82px;
            height: 82px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Media Print Query for 100% exact edge-to-edge landscape page */
        @media print {
            body {
                background: none !important;
                color: #000 !important;
            }
            .cert-toolbar {
                display: none !important;
            }
            .cert-canvas-wrapper {
                padding: 0 !important;
                margin: 0 !important;
            }
            #certificateCanvas {
                width: 100vw !important;
                height: 100vh !important;
                max-width: 100vw !important;
                max-height: 100vh !important;
                box-shadow: none !important;
                page-break-inside: avoid;
            }
            @page {
                size: landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Toolbar -->
    <header class="cert-toolbar text-white">
        <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                @if(isset($course) && $course->slug)
                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Back to Course</span>
                    </a>
                @else
                    <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-light d-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>All Courses</span>
                    </a>
                @endif

                <div class="d-none d-md-flex align-items-center gap-2 text-white-50 small border-start border-white-25 ps-3">
                    <span class="badge bg-success-subtle text-success border border-success-subtle d-flex align-items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Verified Authentic</span>
                    </span>
                    <span>Certificate No: <strong class="text-white">{{ $certificate->certificate_no }}</strong></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-light d-flex align-items-center gap-2" onclick="window.print()">
                    <i class="fa-solid fa-print"></i>
                    <span>Print</span>
                </button>

                <button type="button" class="btn btn-sm btn-warning text-dark fw-bold d-flex align-items-center gap-2 px-3 shadow-sm" id="btnDownloadPdf" onclick="downloadCertificatePdf()">
                    <i class="fa-solid fa-file-pdf text-danger"></i>
                    <span>Download PDF</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Certificate Container -->
    <main class="cert-canvas-wrapper">
        <div id="certificateCanvas">

            <!-- Corner Filigree Vectors (Gold Ornaments Matching Image) -->
            <!-- Top Left -->
            <svg class="corner-filigree top-left" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H40C20 4 10 14 10 34V70C10 50 20 40 40 40H70C50 40 40 50 40 70V96" stroke="#b38029" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="3.5" fill="#b38029"/>
                <circle cx="28" cy="8" r="2.5" fill="#c59b27"/>
                <circle cx="8" cy="28" r="2.5" fill="#c59b27"/>
                <path d="M6 6 Q 30 10 40 30 Q 30 40 10 40 Z" fill="none" stroke="#d4af37" stroke-width="1.2"/>
                <path d="M16 16 C 30 16 35 30 35 35" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="6" cy="6" r="3" fill="#8a5814"/>
            </svg>

            <!-- Top Right -->
            <svg class="corner-filigree top-right" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H40C20 4 10 14 10 34V70C10 50 20 40 40 40H70C50 40 40 50 40 70V96" stroke="#b38029" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="3.5" fill="#b38029"/>
                <circle cx="28" cy="8" r="2.5" fill="#c59b27"/>
                <circle cx="8" cy="28" r="2.5" fill="#c59b27"/>
                <path d="M6 6 Q 30 10 40 30 Q 30 40 10 40 Z" fill="none" stroke="#d4af37" stroke-width="1.2"/>
                <path d="M16 16 C 30 16 35 30 35 35" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="6" cy="6" r="3" fill="#8a5814"/>
            </svg>

            <!-- Bottom Left -->
            <svg class="corner-filigree bottom-left" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H40C20 4 10 14 10 34V70C10 50 20 40 40 40H70C50 40 40 50 40 70V96" stroke="#b38029" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="3.5" fill="#b38029"/>
                <circle cx="28" cy="8" r="2.5" fill="#c59b27"/>
                <circle cx="8" cy="28" r="2.5" fill="#c59b27"/>
                <path d="M6 6 Q 30 10 40 30 Q 30 40 10 40 Z" fill="none" stroke="#d4af37" stroke-width="1.2"/>
                <path d="M16 16 C 30 16 35 30 35 35" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="6" cy="6" r="3" fill="#8a5814"/>
            </svg>

            <!-- Bottom Right -->
            <svg class="corner-filigree bottom-right" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H40C20 4 10 14 10 34V70C10 50 20 40 40 40H70C50 40 40 50 40 70V96" stroke="#b38029" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="3.5" fill="#b38029"/>
                <circle cx="28" cy="8" r="2.5" fill="#c59b27"/>
                <circle cx="8" cy="28" r="2.5" fill="#c59b27"/>
                <path d="M6 6 Q 30 10 40 30 Q 30 40 10 40 Z" fill="none" stroke="#d4af37" stroke-width="1.2"/>
                <path d="M16 16 C 30 16 35 30 35 35" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="6" cy="6" r="3" fill="#8a5814"/>
            </svg>

            <!-- Outer Frame -->
            <div class="cert-outer-frame">
                <!-- Inner Double Frame -->
                <div class="cert-inner-frame">

                    <!-- TOP LOGOS ROW -->
                    <div class="cert-top-bar">
                        <!-- Digital Class Logo -->
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Digital Class Educational World" style="height: 48px; width: auto; object-fit: contain;">
                        </div>

                        <!-- Institute Crest & Name (Top Right) -->
                        <div class="cert-institute-badge">
                            <div class="institute-wreath-icon">
                                <i class="fa-solid fa-award"></i>
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div>
                                <div class="institute-name-text">{{ $certificate->institute_name }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- CERTIFICATE TITLE -->
                    <div class="cert-title-area">
                        <h1 class="cert-main-title">CERTIFICATE</h1>
                        <div class="cert-of-wrap">
                            <svg width="24" height="12" viewBox="0 0 24 12" fill="none">
                                <path d="M2 6 C 8 2, 16 10, 22 6" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <span class="cert-of-text">OF</span>
                            <svg width="24" height="12" viewBox="0 0 24 12" fill="none">
                                <path d="M2 6 C 8 10, 16 2, 22 6" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h2 class="cert-sub-title">ACHIEVEMENT</h2>

                        <!-- Ornate Filigree Divider -->
                        <svg class="cert-divider-scroll" viewBox="0 0 240 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 7 H90 M150 7 H230" stroke="#b38029" stroke-width="1"/>
                            <path d="M95 7 C 105 2, 115 12, 120 7 C 125 2, 135 12, 145 7" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="120" cy="7" r="2.5" fill="#8a5814"/>
                            <circle cx="95" cy="7" r="1.5" fill="#c59b27"/>
                            <circle cx="145" cy="7" r="1.5" fill="#c59b27"/>
                        </svg>
                    </div>

                    <!-- RECIPIENT AWARD -->
                    <div>
                        <div class="cert-awarded-text">THIS CERTIFICATE IS AWARDED TO</div>
                        <div class="cert-recipient-name">{{ $certificate->student_name }}</div>

                        <!-- Graceful Underline Flourish -->
                        <svg class="cert-name-underline" viewBox="0 0 380 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6 H150 M230 6 H360" stroke="#b38029" stroke-width="1"/>
                            <path d="M150 6 C 165 1, 175 11, 190 6 C 205 1, 215 11, 230 6" stroke="#b38029" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="190" cy="6" r="3" fill="#8a5814"/>
                        </svg>

                        <div class="cert-completion-desc">For successfully completing the course</div>

                        <!-- Course Ribbon -->
                        <div class="cert-ribbon-container">
                            <div class="cert-course-ribbon">
                                <div class="cert-course-title">{{ $certificate->course_title }}</div>
                            </div>
                        </div>

                        <div class="cert-dedication-sub">
                            With dedication and successful completion of all course requirements.
                        </div>
                    </div>

                    <!-- 5-COLUMN VERIFICATION METADATA -->
                    <div class="cert-meta-grid">
                        <div class="cert-meta-col">
                            <div class="cert-meta-label">Student ID</div>
                            <div class="cert-meta-value">{{ $certificate->student_id ?? 'STU20260045' }}</div>
                        </div>
                        <div class="cert-meta-col">
                            <div class="cert-meta-label">Course Duration</div>
                            <div class="cert-meta-value">{{ $certificate->duration }}</div>
                        </div>
                        <div class="cert-meta-col">
                            <div class="cert-meta-label">Start Date</div>
                            <div class="cert-meta-value">{{ $certificate->start_date }}</div>
                        </div>
                        <div class="cert-meta-col">
                            <div class="cert-meta-label">Completion Date</div>
                            <div class="cert-meta-value">{{ $certificate->completion_date }}</div>
                        </div>
                        <div class="cert-meta-col">
                            <div class="cert-meta-label">Certificate No.</div>
                            <div class="cert-meta-value">{{ $certificate->certificate_no }}</div>
                        </div>
                    </div>

                    <!-- BOTTOM SIGNATURES & GOLD SEAL -->
                    <div class="cert-bottom-row">
                        <!-- Instructor Signature (Left) -->
                        <div class="cert-signature-block">
                            <div class="cert-sig-script">{{ $certificate->instructor_signature ?? 'Rajesh' }}</div>
                            <div class="cert-sig-line"></div>
                            <div class="cert-sig-name">{{ $certificate->instructor_name }}</div>
                            <div class="cert-sig-role">{{ $certificate->instructor_title }}</div>
                        </div>

                        <!-- Official Golden Laurel Wreath Seal (Center) -->
                        <div class="cert-seal-center">
                            <div class="cert-seal-graphic">
                                <svg width="78" height="78" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Laurel Wreath -->
                                    <circle cx="50" cy="50" r="44" stroke="#c59b27" stroke-width="2" stroke-dasharray="3 3"/>
                                    <circle cx="50" cy="50" r="38" stroke="#8a5814" stroke-width="1.5"/>
                                    <!-- Laurel Leaves (Left) -->
                                    <path d="M22 50 C 22 36, 32 24, 48 20 C 44 26, 40 34, 42 42" stroke="#b38029" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    <path d="M26 38 C 22 32, 28 26, 34 30" fill="#c59b27"/>
                                    <path d="M22 52 C 16 48, 20 40, 28 44" fill="#c59b27"/>
                                    <path d="M24 64 C 18 62, 20 54, 28 56" fill="#c59b27"/>
                                    <!-- Laurel Leaves (Right) -->
                                    <path d="M78 50 C 78 36, 68 24, 52 20 C 56 26, 60 34, 58 42" stroke="#b38029" stroke-width="2" fill="none" stroke-linecap="round"/>
                                    <path d="M74 38 C 78 32, 72 26, 66 30" fill="#c59b27"/>
                                    <path d="M78 52 C 84 48, 80 40, 72 44" fill="#c59b27"/>
                                    <path d="M76 64 C 82 62, 80 54, 72 56" fill="#c59b27"/>
                                    <!-- Center Graduation Cap -->
                                    <path d="M50 36 L70 44 L50 52 L30 44 Z" fill="#b38029"/>
                                    <path d="M40 48.5 V56 C 40 59, 60 59, 60 56 V48.5" fill="#8a5814"/>
                                    <path d="M66 45 V57" stroke="#8a5814" stroke-width="2" stroke-linecap="round"/>
                                    <circle cx="66" cy="58" r="1.5" fill="#c59b27"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Authorized Signatory (Right) -->
                        <div class="cert-signature-block">
                            <div class="cert-sig-script">{{ $certificate->signatory_signature ?? 'Joshi' }}</div>
                            <div class="cert-sig-line"></div>
                            <div class="cert-sig-name">{{ $certificate->signatory_name }}</div>
                            <div class="cert-sig-role">{{ $certificate->signatory_title }}</div>
                            <div class="cert-sig-role fw-semibold text-dark">{{ $certificate->institute_name }}</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <!-- PDF Download Script -->
    <script>
        function downloadCertificatePdf() {
            const btn = document.getElementById('btnDownloadPdf');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generating PDF...';
            btn.disabled = true;

            const element = document.getElementById('certificateCanvas');
            const studentName = "{{ Str::slug($certificate->student_name, '_') }}";
            const certNo = "{{ $certificate->certificate_no }}";
            const filename = 'Certificate_' + studentName + '_' + certNo + '.pdf';

            const opt = {
                margin:       0,
                filename:     filename,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  {
                    scale: 3,
                    useCORS: true,
                    letterRendering: true,
                    backgroundColor: '#ffffff'
                },
                jsPDF:        {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'landscape'
                }
            };

            html2pdf().set(opt).from(element).save().then(function() {
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }).catch(function(err) {
                console.error('PDF generation error:', err);
                btn.innerHTML = originalContent;
                btn.disabled = false;
                // Fallback to print
                window.print();
            });
        }
    </script>
</body>
</html>

