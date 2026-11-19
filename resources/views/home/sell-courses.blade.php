@extends('layouts.app')

@section('title', 'Online Course Selling Platform — Sell Courses Online in India | Digital Class')
@section('meta_description', 'India\'s premier online course selling platform for tutors, educators, and institutes. Sell video courses, notes, and test series with 0% upfront fees, automated certificates, and instant UPI payouts.')
@section('meta_keywords', 'online course selling platform, sell courses online India, best course selling website, platform to sell courses, sell video courses online, teach online India, edtech seller marketplace')
@section('canonical_url', url('/online-course-selling-platform'))
@section('og_title', 'Online Course Selling Platform — Sell Courses Online with Digital Class')
@section('og_description', 'Launch your online teaching academy in 5 minutes. 0% listing fee, DRM-protected video hosting, student inquiries & direct bank payouts.')

@push('schema')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'Service',
      'name' => 'Digital Class Course Selling Platform',
      'serviceType' => 'Online Course Marketplace & Selling Platform',
      'provider' => [
        '@type' => 'Organization',
        'name' => 'Digital Class',
        'url' => url('/'),
        'logo' => asset('images/logo.png')
      ],
      'areaServed' => [
        '@type' => 'Country',
        'name' => 'India'
      ],
      'description' => 'All-in-one platform for Indian educators, coaching institutes, and creators to sell online video courses with direct UPI payments.',
      'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'INR',
        'description' => 'Free seller registration and zero upfront platform charges.'
      ]
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'What is the best online course selling platform in India?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Digital Class is India\'s leading online course selling platform and coaching directory, connecting educators with over 100,000+ active learners with zero upfront setup costs, instant UPI payouts, and built-in student lead generation.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How can I sell my courses online in India?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'To sell courses online: 1. Register a free seller account on Digital Class. 2. Upload your course curriculum, video lessons, and thumbnail. 3. Set your price and publish. Students can immediately discover and purchase your courses via UPI, credit/debit cards, and net banking.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Does Digital Class charge monthly subscription fees to teachers?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'No! Digital Class charges zero monthly subscription fees to start. You can upload and list your courses for free, paying only a nominal processing commission when you successfully make a sale.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How and when do educators receive course earnings?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Earnings from course sales are credited directly to your verified Indian bank account via NEFT/IMPS or UPI with transparent automated payout tracking in your Seller Dashboard.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Can coaching institutes list their offline batches and online courses together?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Yes! Digital Class is a hybrid platform that allows coaching centers to publish online self-paced courses, manage student inquiries, and display a verified local business directory listing all in one unified profile.'
          ]
        ]
      ]
    ]
  ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="py-5" style="background: radial-gradient(circle at 10% 20%, #0a192f 0%, #020c1b 100%); color: #fff;">
    <div class="container py-lg-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); color: #38bdf8; font-size: 0.85rem; font-weight: 600;">
                    <i class="fa-solid fa-bolt"></i> India's #1 Online Course Selling Platform
                </div>
                <h1 class="display-4 fw-bold mb-3" style="letter-spacing: -0.03em; line-height: 1.15;">
                    Turn Your Knowledge Into Income. <span style="background: linear-gradient(90deg, #38bdf8 0%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Sell Courses Online</span> in India.
                </h1>
                <p class="lead text-light opacity-75 mb-4 fs-5" style="max-width: 620px;">
                    Join 17,000+ verified tutors and coaching institutes. Host your video courses, capture student admission leads, issue automated certificates, and receive direct bank payouts with 0% upfront cost.
                </p>
                <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                    <a href="{{ route('seller.register') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold rounded-pill shadow-lg" style="background: #2563eb; border: none; font-size: 1.05rem;">
                        <i class="fa-solid fa-rocket me-2"></i> Start Selling Courses Free
                    </a>
                    <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold" style="border-color: rgba(255,255,255,0.25); font-size: 1.05rem;">
                        <i class="fa-solid fa-play-circle me-2"></i> How It Works
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-4 text-light opacity-75 small pt-2">
                    <div><i class="fa-solid fa-check-circle text-info me-1"></i> No Credit Card Required</div>
                    <div><i class="fa-solid fa-check-circle text-info me-1"></i> Instant UPI / Bank Payouts</div>
                    <div><i class="fa-solid fa-check-circle text-info me-1"></i> Free Business Directory Listing</div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card p-4 rounded-4 shadow-2xl border-0" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.12) !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">Seller Fast Track</span>
                        <span class="text-white-50 small"><i class="fa-solid fa-shield-halved text-warning me-1"></i> Verified Partner</span>
                    </div>
                    <h3 class="h4 text-white fw-bold mb-2">Create Educator Account</h3>
                    <p class="text-white-50 small mb-4">Setup your branded course store in under 2 minutes.</p>
                    <form action="{{ route('seller.register.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-light small fw-semibold">Your Name or Academy Name</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-dark text-white border-secondary" placeholder="e.g. Ramesh Patel / Apex Academy" required style="font-size: 0.95rem;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-light small fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-dark text-white border-secondary" placeholder="tutor@gmail.com" required style="font-size: 0.95rem;">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-light small fw-semibold">Mobile Number (For WhatsApp Leads)</label>
                            <input type="tel" name="phone" class="form-control form-control-lg bg-dark text-white border-secondary" placeholder="9876543210" required style="font-size: 0.95rem;">
                        </div>
                        <button type="submit" class="btn btn-info btn-lg w-100 fw-bold text-dark py-3 rounded-pill shadow">
                            Get Started as Seller <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Metrics Section -->
<section class="py-4 border-bottom bg-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="h2 fw-bold text-primary mb-1">17,000+</div>
                <div class="text-muted small fw-semibold">Tutors & Institutes Registered</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="h2 fw-bold text-dark mb-1">100,000+</div>
                <div class="text-muted small fw-semibold">Students Enrolled</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="h2 fw-bold text-success mb-1">₹0 Setup</div>
                <div class="text-muted small fw-semibold">Zero Upfront Hosting Fee</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="h2 fw-bold text-info mb-1">Instant UPI</div>
                <div class="text-muted small fw-semibold">Direct Bank Payouts in INR</div>
            </div>
        </div>
    </div>
</section>

<!-- Why Digital Class Section -->
<section class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="text-center mb-5">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase">Built For Indian Educators</span>
            <h2 class="display-6 fw-bold mt-2">Why Digital Class is the Best Course Selling Platform</h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">
                Everything you need to package, host, promote, and sell your online courses, mock tests, and training sessions in India.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 rounded-4 shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-3 mb-3" style="width: 52px; height: 52px; font-size: 1.4rem;">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Indian Payment Gateways Built-In</h3>
                    <p class="text-muted small mb-0">Accept UPI (Google Pay, PhonePe, Paytm), Net Banking, RuPay, Credit, and Debit cards seamlessly with 0 setup hassle.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 rounded-4 shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-3 mb-3" style="width: 52px; height: 52px; font-size: 1.4rem;">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">DRM Protected Video Player</h3>
                    <p class="text-muted small mb-0">Embed and stream your lectures with responsive, smooth playback across smartphones, tablets, laptops, and desktop browsers.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 rounded-4 shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-3 mb-3" style="width: 52px; height: 52px; font-size: 1.4rem;">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Automated Course Certificates</h3>
                    <p class="text-muted small mb-0">Issue custom, verifiable completion certificates with QR codes automatically when students finish your course curriculum.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 rounded-4 shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center bg-info-subtle text-info rounded-3 mb-3" style="width: 52px; height: 52px; font-size: 1.4rem;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Student Lead Inquiries</h3>
                    <p class="text-muted small mb-0">Get direct student contact inquiries, WhatsApp messages, and admission demo requests delivered right to your dashboard.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 rounded-4 shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center bg-purple-subtle text-dark rounded-3 mb-3" style="width: 52px; height: 52px; font-size: 1.4rem; background: #ede9fe;">
                        <i class="fa-solid fa-store" style="color: #7c3aed;"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Free Business Directory Profile</h3>
                    <p class="text-muted small mb-0">Every course seller gets an SEO-optimized Business Profile on India's #1 coaching directory with location, maps, and reviews.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 rounded-4 shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-3 mb-3" style="width: 52px; height: 52px; font-size: 1.4rem;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Comprehensive Sales Analytics</h3>
                    <p class="text-muted small mb-0">Track student progress, total orders, daily revenue, coupons, and customer ratings from your real-time Seller Dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-5 bg-white">
    <div class="container py-lg-4">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold">How to Sell Courses Online in 3 Simple Steps</h2>
            <p class="text-muted">Launch your digital course academy today without writing any code.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3 fw-bold fs-4" style="width: 64px; height: 64px;">1</div>
                    <h3 class="h5 fw-bold">Register as a Seller</h3>
                    <p class="text-muted small">Sign up for a free educator account with your name, email, and institute details. Approval takes less than a few hours.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3 fw-bold fs-4" style="width: 64px; height: 64px;">2</div>
                    <h3 class="h5 fw-bold">Upload Your Lessons</h3>
                    <p class="text-muted small">Upload your curriculum, video lessons, downloadable study notes, and set your course price in Indian Rupees (INR).</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3 fw-bold fs-4" style="width: 64px; height: 64px;">3</div>
                    <h3 class="h5 fw-bold">Receive Direct Payouts</h3>
                    <p class="text-muted small">Students across India discover and enroll in your course. Earn revenue on autopilot with automated bank and UPI transfers.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('seller.register') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold">
                Start Selling Your Course Today <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Comparison Table Section -->
<section class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold">Why Choose Digital Class Over Other Platforms</h2>
            <p class="text-muted">See how Digital Class compares with expensive US-based platforms.</p>
        </div>
        <div class="table-responsive shadow-sm rounded-4 bg-white p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-3">Features & Capabilities</th>
                        <th class="py-3 text-center text-primary fw-bold" style="background: rgba(37,99,235,0.06); font-size: 1.1rem;">Digital Class</th>
                        <th class="py-3 text-center text-muted">Udemy</th>
                        <th class="py-3 text-center text-muted">Teachable / Graphy</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-3 fw-semibold">Upfront Setup Fees</td>
                        <td class="text-center text-success fw-bold" style="background: rgba(37,99,235,0.03);">₹0 (100% Free)</td>
                        <td class="text-center text-muted">₹0</td>
                        <td class="text-center text-danger">₹25,000 - ₹60,000 / year</td>
                    </tr>
                    <tr>
                        <td class="ps-3 fw-semibold">Indian UPI & Local Payment Support</td>
                        <td class="text-center text-success fw-bold" style="background: rgba(37,99,235,0.03);"><i class="fa-solid fa-check text-success"></i> Full UPI, RuPay & NetBanking</td>
                        <td class="text-center text-muted">Limited UPI</td>
                        <td class="text-center text-success"><i class="fa-solid fa-check text-success"></i> Yes</td>
                    </tr>
                    <tr>
                        <td class="ps-3 fw-semibold">Direct Student Contact & Leads</td>
                        <td class="text-center text-success fw-bold" style="background: rgba(37,99,235,0.03);"><i class="fa-solid fa-check text-success"></i> Full Phone & Email Access</td>
                        <td class="text-center text-danger"><i class="fa-solid fa-times text-danger"></i> Hidden by platform</td>
                        <td class="text-center text-success"><i class="fa-solid fa-check text-success"></i> Yes</td>
                    </tr>
                    <tr>
                        <td class="ps-3 fw-semibold">Free Coaching Business Directory Listing</td>
                        <td class="text-center text-success fw-bold" style="background: rgba(37,99,235,0.03);"><i class="fa-solid fa-check text-success"></i> Included Free</td>
                        <td class="text-center text-danger"><i class="fa-solid fa-times text-danger"></i> No</td>
                        <td class="text-center text-danger"><i class="fa-solid fa-times text-danger"></i> No</td>
                    </tr>
                    <tr>
                        <td class="ps-3 fw-semibold">Offer Offline & Online Admissions</td>
                        <td class="text-center text-success fw-bold" style="background: rgba(37,99,235,0.03);"><i class="fa-solid fa-check text-success"></i> Hybrid Support</td>
                        <td class="text-center text-danger"><i class="fa-solid fa-times text-danger"></i> Online only</td>
                        <td class="text-center text-danger"><i class="fa-solid fa-times text-danger"></i> Online only</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Expandable FAQ Section (For Google Search Rich Snippets) -->
<section class="py-5 bg-white">
    <div class="container py-lg-4" style="max-width: 900px;">
        <div class="text-center mb-5">
            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-bold text-uppercase">Frequently Asked Questions</span>
            <h2 class="display-6 fw-bold mt-2">Common Questions About Course Selling</h2>
            <p class="text-muted">Everything you need to know about teaching and earning on Digital Class.</p>
        </div>
        <div class="accordion accordion-flush shadow-sm rounded-4 border overflow-hidden" id="faqAccordion">
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button fw-bold py-3 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                        What is the best online course selling platform in India?
                    </button>
                </h3>
                <div id="faqCollapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Digital Class is recognized as one of India's top online course selling platforms because it charges zero upfront setup fees, provides instant UPI payouts, provides student lead phone numbers, and includes a full business directory listing for local coaching institutes.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed fw-bold py-3 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                        How can I sell my courses online in India?
                    </button>
                </h3>
                <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Selling courses on Digital Class takes 3 simple steps: 1. Register a free educator account. 2. Upload your curriculum lectures and course thumbnail. 3. Set your price and publish. Students can immediately find and enroll in your course using UPI, Google Pay, PhonePe, or cards.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading3">
                    <button class="accordion-button collapsed fw-bold py-3 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                        Does Digital Class charge monthly subscription fees to teachers?
                    </button>
                </h3>
                <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        No! Digital Class charges zero monthly subscription fees. Unlike foreign platforms that charge ₹3,000 to ₹5,000 every month, Digital Class allows you to host courses for free and only takes a small commission when you make a sale.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading4">
                    <button class="accordion-button collapsed fw-bold py-3 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4">
                        How and when do educators receive course earnings?
                    </button>
                </h3>
                <div id="faqCollapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Earnings are calculated in real time and disbursed directly to your registered Indian bank account via NEFT/IMPS or UPI with clear payout reports accessible anytime in your Seller Dashboard.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading5">
                    <button class="accordion-button collapsed fw-bold py-3 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5">
                        Can coaching institutes list both offline batches and online video courses?
                    </button>
                </h3>
                <div id="faqCollapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Yes! Digital Class is a hybrid educational marketplace. You can publish online video courses for students across India while also displaying your physical coaching center address, contact numbers, and demo booking for local classroom batches.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: #fff;">
    <div class="container text-center py-lg-4">
        <h2 class="display-6 fw-bold mb-3">Ready to Start Selling Your Courses Online?</h2>
        <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
            Join over 17,000+ educators and start reaching thousands of eager students across India today.
        </p>
        <a href="{{ route('seller.register') }}" class="btn btn-primary btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg" style="background: #2563eb; border: none; font-size: 1.1rem;">
            Create Your Free Seller Account <i class="fa-solid fa-arrow-right ms-2"></i>
        </a>
    </div>
</section>
@endsection
