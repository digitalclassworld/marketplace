@extends('customer.layouts.customer')

@section('title', 'Messages & Support - Digital Class World')

@section('content')
<div class="py-4 bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="fa-regular fa-message text-primary me-2"></i> Messages &amp; Support Desk
                </h3>
                <p class="text-muted small mb-0">Direct communication with Digital Class support advisors, instructors, and agencies</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="https://wa.me/919876543210?text=Hello%20Digital%20Class%20Support" target="_blank" class="btn btn-success btn-sm fw-semibold rounded-pill px-3 shadow-sm">
                    <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp Support
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <!-- Left Col: Support Channels & Advisor Info -->
            <div class="col-lg-4">
                <!-- Advisor Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 52px; height: 52px; font-size: 1.25rem;">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Digital Class Support</h6>
                            <span class="badge bg-success-subtle text-success small rounded-pill mt-1">
                                <i class="fa-solid fa-circle me-1" style="font-size: 0.5rem;"></i> Online 24/7
                            </span>
                        </div>
                    </div>
                    <p class="text-muted small mb-3" style="line-height: 1.5;">
                        Have questions about course access, certificates, payment receipts, or agency quotes? Send us a message and our counselor will assist you.
                    </p>
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex align-items-center gap-2 mb-2 text-dark small fw-semibold">
                            <i class="fa-regular fa-clock text-primary"></i> Average Response Time:
                        </div>
                        <div class="text-primary fw-bold fs-6">Under 15 Minutes</div>
                    </div>
                </div>

                <!-- Contact Channels -->
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="text-muted small fw-bold text-uppercase mb-3 px-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Support Channels</div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-2 py-2 border-0 d-flex align-items-center gap-3">
                            <i class="fa-solid fa-envelope text-primary fs-5"></i>
                            <div>
                                <div class="fw-bold text-dark small">Email Support</div>
                                <small class="text-muted">support@digitalclassworld.in</small>
                            </div>
                        </div>
                        <div class="list-group-item px-2 py-2 border-0 d-flex align-items-center gap-3">
                            <i class="fa-solid fa-phone text-success fs-5"></i>
                            <div>
                                <div class="fw-bold text-dark small">Phone Helpline</div>
                                <small class="text-muted">+91 98765 43210 (9 AM - 7 PM)</small>
                            </div>
                        </div>
                        <div class="list-group-item px-2 py-2 border-0 d-flex align-items-center gap-3">
                            <i class="fa-solid fa-graduation-cap text-info fs-5"></i>
                            <div>
                                <div class="fw-bold text-dark small">Academic Guidance</div>
                                <small class="text-muted">Free Career &amp; Course Counseling</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Interactive Message Composer & Sent History -->
            <div class="col-lg-8">
                <!-- Message Composer Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-paper-plane text-primary me-2"></i> Send a Message to Support
                    </h5>
                    <form action="{{ route('customer.messages.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Subject / Topic</label>
                            <input type="text" name="subject" class="form-control" placeholder="e.g. Course certificate query, order invoice, or syllabus question" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Your Message</label>
                            <textarea name="message" rows="4" class="form-control" placeholder="Describe your question or requirement in detail..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted"><i class="fa-solid fa-shield-halved text-success me-1"></i> Responses will be sent to <strong>{{ $user->email ?? 'your email' }}</strong></small>
                            <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                                <i class="fa-solid fa-paper-plane me-1"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Recent Messages / Inquiries Timeline -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-clock-rotate-left text-muted me-2"></i> Your Recent Messages &amp; Inquiries
                    </h6>

                    @php
                        $hasMessages = (!empty($sessionMessages) && count($sessionMessages) > 0) || (isset($conversations) && $conversations->isNotEmpty());
                    @endphp

                    @if($hasMessages)
                        <div class="list-group list-group-flush">
                            @if(isset($conversations))
                                @foreach($conversations as $conv)
                                    <div class="list-group-item px-0 py-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold text-dark mb-0">Ticket #{{ $conv->ticket_number }}: {{ $conv->category ?: 'Support' }}</h6>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $conv->status ?: 'Open' }}</span>
                                        </div>
                                        <p class="text-muted small mb-2">{{ $conv->last_message }}</p>
                                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $conv->created_at ? $conv->created_at->format('M d, Y h:i A') : 'Recently' }}</small>
                                    </div>
                                @endforeach
                            @endif

                            @if(!empty($sessionMessages))
                                @foreach(array_reverse($sessionMessages) as $msg)
                                    <div class="list-group-item px-0 py-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold text-dark mb-0">{{ $msg['subject'] }}</h6>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $msg['status'] }}</span>
                                        </div>
                                        <p class="text-muted small mb-2">{{ $msg['message'] }}</p>
                                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $msg['created_at'] }}</small>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @else
                        <!-- Clean empty state for messages -->
                        <div class="text-center py-4 text-muted">
                            <i class="fa-regular fa-comments fs-2 text-muted mb-2 d-block"></i>
                            <p class="small mb-0">No past inquiries. Submit your message above to start a conversation with our advisors.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
