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
                <p class="text-muted small mb-0">Direct communication with Digital Class support advisors and verified sellers / instructors</p>
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Message Mode Nav Tabs: 1) Msg to Digital Class Support, 2) Msg to Seller -->
        <div class="card border-0 shadow-sm rounded-4 p-2 bg-white mb-4">
            <ul class="nav nav-pills nav-fill gap-2" id="messageHubTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('customer.messages', ['tab' => 'support']) }}"
                       class="nav-link rounded-3 fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 {{ ($activeTab ?? 'support') === 'support' ? 'active bg-primary text-white shadow-sm' : 'text-dark bg-light' }}">
                        <i class="fa-solid fa-headset fs-5"></i>
                        <span>Digital Class Support Desk</span>
                        @if(isset($conversations) && $conversations->isNotEmpty())
                            <span class="badge rounded-pill {{ ($activeTab ?? 'support') === 'support' ? 'bg-white text-primary' : 'bg-primary text-white' }} small">
                                {{ $conversations->count() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('customer.messages', ['tab' => 'sellers']) }}"
                       class="nav-link rounded-3 fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 {{ ($activeTab ?? 'support') === 'sellers' ? 'active bg-primary text-white shadow-sm' : 'text-dark bg-light' }}">
                        <i class="fa-solid fa-store fs-5"></i>
                        <span>Messages to Sellers &amp; Instructors</span>
                        @if(isset($sellerChats) && $sellerChats->isNotEmpty())
                            <span class="badge rounded-pill {{ ($activeTab ?? 'support') === 'sellers' ? 'bg-white text-primary' : 'bg-primary text-white' }} small">
                                {{ $sellerChats->count() }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        @if(($activeTab ?? 'support') === 'support')
            <!-- ===================== SECTION 1: DIGITAL CLASS SUPPORT ===================== -->
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
                            Have questions about course access, certificates, payment receipts, or agency quotes? Send us a ticket and our counselor will assist you.
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
                            <input type="hidden" name="target" value="support">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Subject / Topic</label>
                                <input type="text" name="subject" class="form-control" placeholder="e.g. Course certificate query, order invoice, or syllabus question" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Your Message</label>
                                <textarea name="message" rows="4" class="form-control" placeholder="Describe your question or requirement in detail..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <small class="text-muted"><i class="fa-solid fa-shield-halved text-success me-1"></i> Responses will be sent to <strong>{{ $user->email ?? 'your registered contact' }}</strong></small>
                                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill shadow-sm">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Send to Support
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Recent Messages / Inquiries Timeline -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fa-solid fa-clock-rotate-left text-muted me-2"></i> Your Support Tickets &amp; Inquiries
                        </h6>

                        @php
                            $hasSupport = (!empty($sessionMessages) && count($sessionMessages) > 0) || (isset($conversations) && $conversations->isNotEmpty());
                        @endphp

                        @if($hasSupport)
                            <div class="list-group list-group-flush">
                                @if(isset($conversations))
                                    @foreach($conversations as $conv)
                                        <div class="list-group-item px-0 py-3 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start mb-1 flex-wrap gap-2">
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0">Ticket #{{ $conv->ticket_number }}: {{ $conv->category ?: 'Support' }}</h6>
                                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $conv->created_at ? $conv->created_at->format('M d, Y h:i A') : 'Recently' }}</small>
                                                </div>
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $conv->status ?: 'Open' }}</span>
                                            </div>
                                            <p class="text-dark small mb-2 bg-light p-2 rounded-2">{{ $conv->last_message }}</p>
                                            @if($conv->messages && $conv->messages->count() > 1)
                                                <div class="ms-3 ps-2 border-start border-2 border-primary mt-2">
                                                    @foreach($conv->messages->skip(1) as $msg)
                                                        <div class="small mb-1">
                                                            <strong class="{{ $msg->sender_type === 'admin' ? 'text-primary' : 'text-dark' }}">
                                                                {{ $msg->sender_name ?: ucfirst($msg->sender_type) }}:
                                                            </strong>
                                                            <span class="text-muted">{{ $msg->message }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
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
                            <div class="text-center py-4 text-muted">
                                <i class="fa-regular fa-comments fs-2 text-muted mb-2 d-block"></i>
                                <p class="small mb-0">No past inquiries. Submit your message above to start a conversation with our advisors.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @else
            <!-- ===================== SECTION 2: SELLER & INSTRUCTOR CHATS ===================== -->
            <div class="row g-4 mb-4">
                <!-- Left Col: Active Conversations List & New Chat Button -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="fa-solid fa-comments text-primary me-2"></i> Seller Chats
                            </h6>
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#newSellerChatModal">
                                <i class="fa-solid fa-plus me-1"></i> New Query
                            </button>
                        </div>

                        <div class="list-group list-group-flush" style="max-height: 520px; overflow-y: auto;">
                            @if(isset($sellerChats) && $sellerChats->isNotEmpty())
                                @foreach($sellerChats as $chat)
                                    @php
                                        $sellerName = $chat->seller?->store_name ?: ($chat->seller?->businessDetail?->business_name ?: 'Course Seller');
                                        $isActive = isset($activeSellerChat) && $activeSellerChat->id === $chat->id;
                                    @endphp
                                    <a href="{{ route('customer.messages', ['tab' => 'sellers', 'chat_id' => $chat->id]) }}"
                                       class="list-group-item list-group-item-action p-3 border-bottom {{ $isActive ? 'bg-primary-subtle border-start border-4 border-primary' : '' }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center fw-bold text-primary flex-shrink-0" style="width: 44px; height: 44px;">
                                                <i class="fa-solid fa-chalkboard-user"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="d-flex justify-content-between align-items-baseline">
                                                    <h6 class="fw-bold text-dark text-truncate mb-0" style="font-size: 0.9rem;">{{ $sellerName }}</h6>
                                                    <small class="text-muted flex-shrink-0" style="font-size: 0.7rem;">
                                                        {{ $chat->last_message_at ? $chat->last_message_at->diffForHumans() : '' }}
                                                    </small>
                                                </div>
                                                <p class="text-muted small text-truncate mb-0" style="font-size: 0.8rem;">
                                                    {{ $chat->subject_title }}
                                                </p>
                                                <p class="text-secondary small text-truncate mb-0" style="font-size: 0.75rem;">
                                                    {{ $chat->last_message }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="text-center py-5 px-3 text-muted">
                                    <i class="fa-solid fa-shop fs-1 text-muted mb-3 d-block opacity-50"></i>
                                    <h6 class="fw-bold text-dark mb-1">No seller conversations yet</h6>
                                    <p class="small text-muted mb-3">Have questions regarding a course, syllabus, or live session? Message any instructor directly.</p>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#newSellerChatModal">
                                        <i class="fa-solid fa-comment-dots me-1"></i> Ask a Seller
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Col: Conversation Thread & Message Input -->
                <div class="col-lg-8">
                    @if(isset($activeSellerChat) && $activeSellerChat)
                        @php
                            $activeSellerName = $activeSellerChat->seller?->store_name ?: ($activeSellerChat->seller?->businessDetail?->business_name ?: 'Course Seller');
                        @endphp
                        <div class="card border-0 shadow-sm rounded-4 bg-white d-flex flex-column" style="height: 600px;">
                            <!-- Active Chat Header -->
                            <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white rounded-top-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                                        <i class="fa-solid fa-store"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0">{{ $activeSellerName }}</h6>
                                        <small class="text-muted">{{ $activeSellerChat->subject_title }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 small">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 0.45rem;"></i> Active Chat
                                </span>
                            </div>

                            <!-- Messages Thread Scroll Area -->
                            <div class="flex-grow-1 p-4 overflow-y-auto bg-light d-flex flex-column gap-3" id="sellerChatBox">
                                @forelse($activeSellerChat->messages as $msg)
                                    @php
                                        $isCustomer = ($msg->sender_type === 'customer');
                                    @endphp
                                    <div class="d-flex {{ $isCustomer ? 'justify-content-end' : 'justify-content-start' }}">
                                        <div class="p-3 rounded-4 shadow-sm" style="max-width: 75%; background: {{ $isCustomer ? '#0066ff' : '#ffffff' }}; color: {{ $isCustomer ? '#ffffff' : '#1e293b' }}; border: {{ $isCustomer ? 'none' : '1px solid #e2e8f0' }};">
                                            <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                                                <strong class="small" style="font-size: 0.78rem;">
                                                    {{ $isCustomer ? 'You' : ($msg->sender_name ?: $activeSellerName) }}
                                                </strong>
                                                <small style="font-size: 0.65rem; opacity: 0.8;">
                                                    {{ $msg->created_at ? $msg->created_at->format('h:i A') : '' }}
                                                </small>
                                            </div>
                                            <div style="font-size: 0.88rem; line-height: 1.45; white-space: pre-line;">{{ $msg->message }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-regular fa-comment-dots fs-3 mb-2 d-block"></i>
                                        <p class="small mb-0">No messages yet. Send a message below to start chatting with this seller.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Message Input Form -->
                            <div class="p-3 bg-white border-top rounded-bottom-4">
                                <form action="{{ route('customer.messages.send') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="target" value="seller">
                                    <input type="hidden" name="conversation_id" value="{{ $activeSellerChat->id }}">
                                    <input type="text" name="message" class="form-control rounded-pill px-3" placeholder="Type your message to {{ $activeSellerName }}..." required autocomplete="off">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm flex-shrink-0">
                                        <i class="fa-solid fa-paper-plane me-1"></i> Send
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- No Active Chat Selected -->
                        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center d-flex align-items-center justify-content-center" style="height: 600px;">
                            <div style="max-width: 420px;">
                                <div class="rounded-circle bg-primary-subtle text-primary mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; font-size: 1.8rem;">
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Message Course Sellers &amp; Educators</h5>
                                <p class="text-muted small mb-4">
                                    Connect directly with teachers, institutes, and sellers to ask questions about syllabus, class schedules, discounts, or project guidance.
                                </p>
                                <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#newSellerChatModal">
                                    <i class="fa-solid fa-plus me-1"></i> Start a New Inquiry
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>

<!-- Modal: Start New Seller Chat -->
<div class="modal fade" id="newSellerChatModal" tabindex="-1" aria-labelledby="newSellerChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="newSellerChatModalLabel">
                    <i class="fa-solid fa-comment-medical text-primary me-2"></i> Message a Seller / Instructor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customer.messages.send') }}" method="POST">
                @csrf
                <input type="hidden" name="target" value="seller">
                <div class="modal-body pt-3">
                    <!-- Course Selection Dropdown (Optional / Quick Select) -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Which Course are you asking about? (Optional)</label>
                            <span class="badge bg-light text-muted border small">Auto-picks seller</span>
                        </div>
                        <select name="course_id" id="courseSelect" class="form-select rounded-3" onchange="handleCourseChange(this)">
                            <option value="">-- Select Specific Course (Optional) --</option>
                            @if(isset($availableCourses))
                                @foreach($availableCourses as $c)
                                    @php
                                        $cSellerName = $c->seller?->store_name ?: ($c->seller?->businessDetail?->business_name ?: 'Seller #' . $c->seller_id);
                                    @endphp
                                    <option value="{{ $c->id }}" data-seller-id="{{ $c->seller_id }}" data-course-title="{{ $c->title }}" data-seller-name="{{ $c->seller?->store_name ?: '' }}">
                                        {{ $c->title }} &mdash; by {{ $cSellerName }} (₹{{ number_format($c->discount_price ?: $c->price) }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted" style="font-size: 0.75rem;">Select the course you need details or guidance for.</small>
                    </div>

                    <!-- Seller Selection Dropdown -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Select Seller / Educator / Institute *</label>
                        <select name="seller_id" id="sellerSelect" class="form-select rounded-3" required>
                            <option value="">-- Choose Instructor or Seller --</option>
                            @if(isset($availableSellers))
                                @foreach($availableSellers as $seller)
                                    @php
                                        $sName = $seller->store_name ?: ($seller->businessDetail?->business_name ?: 'Seller #' . $seller->seller_code);
                                        $city = $seller->businessDetail?->city ?: ($seller->user?->city ?: '');
                                    @endphp
                                    <option value="{{ $seller->id }}" data-seller-name="{{ $sName }}">
                                        {{ $sName }} {{ $city ? '(' . $city . ')' : '' }} &mdash; #{{ $seller->seller_code }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Subject / Inquiry Topic -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Subject / Course Name *</label>
                        <input type="text" name="subject_title" id="subjectTitleInput" class="form-control rounded-3" placeholder="e.g. Question about Digital Marketing Mastery syllabus or schedule" required>
                    </div>

                    <!-- Message Body -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Your Message / Query *</label>
                        <textarea name="message" id="messageBodyInput" rows="4" class="form-control rounded-3" placeholder="Ask about batches, curriculum, prerequisites, project guidance, or discount offers..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-paper-plane me-1"></i> Send Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleCourseChange(selectEl) {
        const selectedOpt = selectEl.options[selectEl.selectedIndex];
        if (!selectedOpt || !selectedOpt.value) return;

        const sellerId = selectedOpt.getAttribute('data-seller-id');
        const courseTitle = selectedOpt.getAttribute('data-course-title');

        // Auto select the seller in the seller dropdown
        const sellerSelect = document.getElementById('sellerSelect');
        if (sellerSelect && sellerId) {
            sellerSelect.value = sellerId;
        }

        // Auto populate the subject title
        const subjectInput = document.getElementById('subjectTitleInput');
        if (subjectInput && courseTitle) {
            subjectInput.value = 'Inquiry for ' + courseTitle;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("sellerChatBox");
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
</script>
@endsection
