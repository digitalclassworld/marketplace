@extends('seller.layouts.seller')

@section('title', 'Messages - Seller Dashboard')

@section('styles')
<style>
    .chat-container-layout {
        display: grid;
        grid-template-columns: 320px 1fr 310px;
        gap: 1.25rem;
        height: calc(100vh - 165px);
        min-height: 650px;
    }

    @media (max-width: 1200px) {
        .chat-container-layout {
            grid-template-columns: 300px 1fr;
        }
        .chat-info-column {
            display: none;
        }
    }

    @media (max-width: 900px) {
        .chat-container-layout {
            grid-template-columns: 1fr;
            height: auto;
        }
        .chat-sidebar-column {
            display: none;
        }
    }

    /* Col 1: Sidebar Contacts */
    .chat-sidebar-column {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .chat-tabs-bar {
        padding: 0.75rem 0.75rem 0.5rem;
        display: flex;
        gap: 0.35rem;
        border-bottom: 1px solid #f1f5f9;
        overflow-x: auto;
    }

    .chat-tab-pill {
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        white-space: nowrap;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .chat-tab-pill:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .chat-tab-pill.active {
        background: #0066ff;
        color: #ffffff;
    }

    .conversation-list-scroll {
        flex: 1;
        overflow-y: auto;
    }

    .conversation-card-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f8fafc;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        position: relative;
        transition: background-color 0.15s;
    }
    .conversation-card-item:hover {
        background-color: #f8fafc;
    }
    .conversation-card-item.active {
        background-color: #f0fdf4;
        border-left: 3px solid #10b981;
    }

    .conv-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .conv-avatar-img {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
    }
    .conv-online-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }

    .conv-info {
        flex: 1;
        min-width: 0;
    }
    .conv-header-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2px;
    }
    .conv-customer-name {
        font-weight: 700;
        font-size: 0.875rem;
        color: #0f172a;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .conv-time {
        font-size: 0.725rem;
        color: #64748b;
    }
    .conversation-card-item.active .conv-time {
        color: #10b981;
        font-weight: 600;
    }
    .conv-snippet {
        font-size: 0.775rem;
        color: #64748b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .conv-unread-badge {
        font-size: 0.65rem;
        background-color: #ef4444;
        color: #ffffff;
        font-weight: 700;
        border-radius: 999px;
        padding: 0.15rem 0.45rem;
        margin-left: 0.35rem;
    }

    /* Col 2: Chat Main Box */
    .chat-main-column {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .chat-header-bar {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }

    .chat-header-subject-thumb {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        object-fit: cover;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .chat-header-status-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
    }

    .chat-messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem 1.5rem;
        background-color: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .chat-date-divider {
        text-align: center;
        margin: 0.25rem 0;
        position: relative;
    }
    .chat-date-pill {
        display: inline-block;
        background: #e2e8f0;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.75rem;
        border-radius: 20px;
    }

    /* Outgoing Bubble (Blue) */
    .chat-msg-row-outgoing {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        gap: 0.5rem;
    }
    .chat-bubble-outgoing {
        max-width: 65%;
        background-color: #0066ff;
        color: #ffffff;
        padding: 0.75rem 1rem;
        border-radius: 16px 16px 4px 16px;
        font-size: 0.85rem;
        line-height: 1.45;
        box-shadow: 0 2px 6px rgba(0, 102, 255, 0.15);
    }
    .chat-bubble-outgoing .chat-meta {
        font-size: 0.68rem;
        color: rgba(255, 255, 255, 0.75);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        margin-top: 4px;
    }

    /* Incoming Bubble (White) */
    .chat-msg-row-incoming {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        gap: 0.65rem;
    }
    .chat-msg-incoming-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .chat-bubble-incoming {
        max-width: 65%;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        padding: 0.75rem 1rem;
        border-radius: 16px 16px 16px 4px;
        font-size: 0.85rem;
        line-height: 1.45;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }
    .chat-bubble-incoming .chat-meta {
        font-size: 0.68rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        margin-top: 4px;
    }

    /* Admin notice bubble */
    .chat-bubble-admin {
        max-width: 75%;
        background-color: #fef2f2;
        border: 1px dashed #ef4444;
        color: #991b1b;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-size: 0.825rem;
        margin: 0.5rem auto;
        text-align: center;
    }

    .chat-input-bar {
        padding: 0.75rem 1rem;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chat-input-control {
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 0.55rem 1.15rem;
        font-size: 0.875rem;
        flex: 1;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s;
    }
    .chat-input-control:focus {
        background: #ffffff;
        border-color: #0066ff;
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
    }

    .chat-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
    }
    .chat-icon-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .chat-send-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #0066ff;
        color: #ffffff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.15s, background-color 0.2s;
        box-shadow: 0 2px 8px rgba(0, 102, 255, 0.3);
    }
    .chat-send-btn:hover {
        background: #0052cc;
        transform: scale(1.04);
    }

    /* Col 3: Customer Details & Info */
    .chat-info-column {
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .chat-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.15rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .quick-action-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.55rem 0.75rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        cursor: pointer;
        text-align: left;
        transition: all 0.2s;
        text-decoration: none;
    }
    .quick-action-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    /* Floating notification pills */
    .notification-floating-toast {
        position: absolute;
        top: 15px;
        right: 25px;
        z-index: 1030;
        display: flex;
        flex-direction: column;
        gap: 6px;
        max-width: 320px;
        pointer-events: none;
    }
    .toast-mini-pill {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.45rem 0.85rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        animation: fadeInRight 0.3s ease;
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>
@endsection

@section('content')
<div class="position-relative">
    <!-- Floating Notification Pills Matching Design -->
    <div class="notification-floating-toast d-none d-xl-flex">
        <div class="toast-mini-pill">
            <span class="text-warning">🔔</span>
            <div>
                <span class="fw-bold">New message from Rimsha Khan</span>
                <span class="text-muted ms-1" style="font-size: 0.68rem;">• 2m ago</span>
            </div>
        </div>
        <div class="toast-mini-pill">
            <span class="text-primary">📦</span>
            <div>
                <span class="fw-bold">New order received</span>
                <span class="text-muted ms-1" style="font-size: 0.68rem;">• 12m ago</span>
            </div>
        </div>
        <div class="toast-mini-pill">
            <span class="text-success">💳</span>
            <div>
                <span class="fw-bold">Payment received ₹2,999</span>
                <span class="text-muted ms-1" style="font-size: 0.68rem;">• 1h ago</span>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Messages</h1>
            <p class="text-secondary small mb-0">Chat with your customers and manage all your conversations in one place.</p>
        </div>
    </div>

    <!-- 3-Column Interactive Messenger Layout -->
    <div class="chat-container-layout">

        <!-- ================= COLUMN 1: CONVERSATION LIST ================= -->
        <div class="chat-sidebar-column">
            <!-- Tabs Bar -->
            <div class="chat-tabs-bar">
                <a href="{{ route('seller.messages.index', ['tab' => 'all']) }}" 
                   class="chat-tab-pill {{ $currentTab === 'all' ? 'active' : '' }}">
                    All ({{ $counts['all'] }})
                </a>
                <a href="{{ route('seller.messages.index', ['tab' => 'orders']) }}" 
                   class="chat-tab-pill {{ $currentTab === 'orders' ? 'active' : '' }}">
                    Orders ({{ $counts['orders'] }})
                </a>
                <a href="{{ route('seller.messages.index', ['tab' => 'inquiries']) }}" 
                   class="chat-tab-pill {{ $currentTab === 'inquiries' ? 'active' : '' }}">
                    Inquiries ({{ $counts['inquiries'] }})
                </a>
                <a href="{{ route('seller.messages.index', ['tab' => 'support']) }}" 
                   class="chat-tab-pill {{ $currentTab === 'support' ? 'active' : '' }}">
                    Support ({{ $counts['support'] }})
                </a>
            </div>

            <!-- Contacts Scroll List -->
            <div class="conversation-list-scroll">
                @forelse($conversations as $conv)
                    @php
                        $isActive = ($activeConversation && $activeConversation->id === $conv->id);
                        $formattedTime = $conv->last_message_at ? ($conv->last_message_at->isToday() ? $conv->last_message_at->format('g:i A') : ($conv->last_message_at->isYesterday() ? 'Yesterday' : $conv->last_message_at->diffForHumans(null, true) . ' ago')) : 'Recent';
                    @endphp
                    <a href="{{ route('seller.messages.index', ['conversation_id' => $conv->id, 'tab' => $currentTab]) }}" 
                       class="conversation-card-item {{ $isActive ? 'active' : '' }}">
                        <div class="conv-avatar-wrap">
                            <img src="{{ $conv->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($conv->customer_name) . '&background=0066ff&color=fff' }}" 
                                 alt="{{ $conv->customer_name }}" class="conv-avatar-img">
                            @if($conv->customer_online_status === 'Online')
                                <span class="conv-online-dot"></span>
                            @endif
                        </div>
                        <div class="conv-info">
                            <div class="conv-header-line">
                                <h6 class="conv-customer-name">{{ $conv->customer_name }}</h6>
                                <span class="conv-time">{{ $formattedTime }}</span>
                            </div>
                            <p class="conv-snippet">{{ $conv->last_message }}</p>
                        </div>
                        @if($conv->unread_count > 0)
                            <span class="conv-unread-badge">{{ $conv->unread_count }}</span>
                        @endif
                    </a>
                @empty
                    <div class="p-4 text-center text-secondary small">
                        <i class="fa-solid fa-comment-slash fs-3 mb-2 text-muted"></i>
                        <p class="mb-0">No conversations found in this tab.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-2 border-top text-center bg-white">
                <a href="{{ route('seller.messages.index', ['tab' => 'all']) }}" class="small fw-semibold text-primary text-decoration-none">
                    View All Messages &rarr;
                </a>
            </div>
        </div>

        <!-- ================= COLUMN 2: ACTIVE CHAT AREA ================= -->
        <div class="chat-main-column">
            @if($activeConversation)
                <!-- Chat Top Header -->
                <div class="chat-header-bar">
                    <div class="d-flex align-items-center gap-2">
                        @if($activeConversation->subject_thumbnail)
                            <img src="{{ $activeConversation->subject_thumbnail }}" alt="Item" class="chat-header-subject-thumb">
                        @else
                            <div class="chat-header-subject-thumb">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem; line-height: 1.2;">
                                {{ $activeConversation->subject_title }}
                            </div>
                            <div class="text-secondary small d-flex align-items-center gap-2 mt-1">
                                <span>{{ $activeConversation->subject_type }}</span>
                                <span>•</span>
                                <span class="text-success fw-medium">
                                    <span class="chat-header-status-dot"></span>Online • 2m ago
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical text-secondary"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-envelope me-2 text-primary"></i> Mark as Unread</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-bell-slash me-2 text-secondary"></i> Mute Notifications</a></li>
                            <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-box-archive me-2 text-secondary"></i> Archive Chat</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-flag me-2"></i> Report Conversation</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Messages Stream Body -->
                <div class="chat-messages-area" id="chatMessagesArea">
                    <!-- Date Divider -->
                    <div class="chat-date-divider">
                        <span class="chat-date-pill">
                            {{ $activeConversation->active_since ? $activeConversation->active_since->format('M d, Y') : 'Oct 31, 2026' }}
                        </span>
                    </div>

                    @foreach($messages as $msg)
                        @if($msg->sender_type === 'seller')
                            <!-- Outgoing Message (Seller) -->
                            <div class="chat-msg-row-outgoing">
                                <div class="chat-bubble-outgoing">
                                    <div style="white-space: pre-line;">{{ $msg->message }}</div>
                                    @if($msg->attachment_type === 'pdf')
                                        <div class="mt-2 p-2 bg-white bg-opacity-25 rounded d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-file-pdf fs-5"></i>
                                            <div class="flex-grow-1 small text-truncate">Course_Curriculum_Brochure.pdf</div>
                                            <i class="fa-solid fa-download"></i>
                                        </div>
                                    @endif
                                    <div class="chat-meta">
                                        <span>{{ $msg->created_at->format('g:i A') }}</span>
                                        <i class="fa-solid fa-check-double ms-1" style="font-size: 0.7rem;"></i>
                                    </div>
                                </div>
                            </div>
                        @elseif($msg->sender_type === 'admin')
                            <!-- Admin System / Moderator Message -->
                            <div class="chat-bubble-admin">
                                <div class="fw-bold mb-1"><i class="fa-solid fa-shield-halved me-1"></i> Official Administrator Notice</div>
                                <div>{{ $msg->message }}</div>
                                <div class="small text-muted mt-1">{{ $msg->created_at->format('M d, g:i A') }}</div>
                            </div>
                        @else
                            <!-- Incoming Message (Customer) -->
                            <div class="chat-msg-row-incoming">
                                <img src="{{ $activeConversation->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($activeConversation->customer_name) . '&background=0066ff&color=fff' }}" 
                                     alt="{{ $activeConversation->customer_name }}" class="chat-msg-incoming-avatar">
                                <div class="chat-bubble-incoming">
                                    <div style="white-space: pre-line;">{{ $msg->message }}</div>
                                    <div class="chat-meta">
                                        <span>{{ $msg->created_at->format('g:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Input Footer Bar -->
                <form action="{{ route('seller.messages.send', $activeConversation->id) }}" method="POST" id="chatSendForm" class="chat-input-bar">
                    @csrf
                    <input type="hidden" name="tab" value="{{ $currentTab }}">
                    
                    <button type="button" class="chat-icon-btn" title="Attach Document" onclick="triggerBrochureAction()">
                        <i class="fa-solid fa-paperclip"></i>
                    </button>

                    <input type="text" name="message" id="chatMessageInput" class="chat-input-control" 
                           placeholder="Type a message..." autocomplete="off" required>

                    <button type="button" class="chat-icon-btn" title="Add Emoji" onclick="insertEmoji('😊')">
                        <i class="fa-regular fa-face-smile"></i>
                    </button>

                    <button type="button" class="chat-icon-btn" title="Send Image" onclick="triggerImageUpload()">
                        <i class="fa-regular fa-image"></i>
                    </button>

                    <button type="submit" class="chat-send-btn" title="Send Message">
                        <i class="fa-solid fa-paper-plane" style="font-size: 0.95rem; margin-left: -2px;"></i>
                    </button>
                </form>
            @else
                <div class="h-100 d-flex flex-column align-items-center justify-content-center text-secondary">
                    <i class="fa-regular fa-comments display-4 mb-3 text-muted"></i>
                    <h5>No Conversation Selected</h5>
                    <p class="small">Choose a conversation from the left to start chatting.</p>
                </div>
            @endif
        </div>

        <!-- ================= COLUMN 3: CUSTOMER DETAILS & QUICK ACTIONS ================= -->
        <div class="chat-info-column">
            @if($activeConversation)
                <!-- Customer Profile Card -->
                <div class="chat-card text-center">
                    <div class="position-relative d-inline-block mb-2">
                        <img src="{{ $activeConversation->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($activeConversation->customer_name) . '&background=0066ff&color=fff' }}" 
                             alt="{{ $activeConversation->customer_name }}" 
                             class="rounded-circle shadow-sm" style="width: 72px; height: 72px; object-fit: cover;">
                        @if($activeConversation->customer_online_status === 'Online')
                            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle" style="width: 14px; height: 14px;"></span>
                        @endif
                    </div>
                    <h5 class="fw-bold text-dark mb-0">{{ $activeConversation->customer_name }}</h5>
                    <div class="text-success small fw-medium mb-3">
                        <span class="chat-header-status-dot"></span>Online
                    </div>

                    <div class="text-start border-top pt-3 small text-secondary">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fa-regular fa-envelope text-muted" style="width: 16px;"></i>
                            <span class="text-truncate">{{ $activeConversation->customer_email }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fa-solid fa-phone text-muted" style="width: 16px;"></i>
                            <span>{{ $activeConversation->customer_phone ?? '+91 98765 43210' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fa-solid fa-location-dot text-muted" style="width: 16px;"></i>
                            <span>{{ $activeConversation->customer_city ?? 'Ahmedabad, Gujarat' }}</span>
                        </div>
                        <div class="d-flex align-items-start gap-2 mb-3">
                            <i class="fa-solid fa-tag text-muted mt-1" style="width: 16px;"></i>
                            <span class="fw-medium text-dark">Interested in: {{ $activeConversation->subject_title }}</span>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-3 fw-semibold py-1.5" onclick="showCustomerModal()">
                        View Customer Profile &rarr;
                    </button>
                </div>

                <!-- Quick Actions Card -->
                <div class="chat-card">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.85rem;">Quick Actions</h6>
                    
                    <!-- 1. Send Brochure / PDF -->
                    <button type="button" class="quick-action-btn" onclick="executeQuickAction('brochure')">
                        <span class="text-primary fs-6">📄</span>
                        <span>Send Brochure / PDF</span>
                    </button>

                    <!-- 2. Share Discount Coupon -->
                    <button type="button" class="quick-action-btn" onclick="executeQuickAction('coupon')">
                        <span class="text-purple fs-6">🏷️</span>
                        <span>Share Discount Coupon</span>
                    </button>

                    <!-- 3. Create Custom Offer -->
                    <button type="button" class="quick-action-btn" onclick="executeQuickAction('custom_offer')">
                        <span class="text-warning fs-6">🎁</span>
                        <span>Create Custom Offer</span>
                    </button>

                    <!-- 4. View Order Details -->
                    <a href="{{ route('seller.orders.index') }}" class="quick-action-btn">
                        <span class="text-info fs-6">📦</span>
                        <span>View Order Details</span>
                    </a>

                    <!-- 5. Report User -->
                    <button type="button" class="quick-action-btn text-danger border-danger-subtle" onclick="reportUser()">
                        <span class="fs-6">⚠️</span>
                        <span class="fw-semibold">Report User</span>
                    </button>
                </div>

                <!-- Conversation Summary Card -->
                <div class="chat-card">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.85rem;">Conversation Summary</h6>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-secondary">Total Messages</span>
                        <span class="fw-bold text-dark">{{ $activeConversation->total_messages }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-secondary">Active Since</span>
                        <span class="fw-medium text-dark">
                            {{ $activeConversation->active_since ? $activeConversation->active_since->format('M d, Y') : 'Oct 31, 2026' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-secondary">Last Message</span>
                        <span class="fw-medium text-dark">
                            {{ $activeConversation->last_message_at ? $activeConversation->last_message_at->format('g:i A') : '10:24 AM' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-secondary">Status</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                            {{ $activeConversation->status }}
                        </span>
                    </div>
                </div>

                <!-- Did You Know? Tip Card -->
                <div class="chat-card bg-primary bg-opacity-10 border-primary border-opacity-25">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fs-5">💡</span>
                        <span class="fw-bold text-primary small">Did you know?</span>
                    </div>
                    <p class="text-secondary mb-2" style="font-size: 0.75rem; line-height: 1.4;">
                        You can set automated replies for common questions from Settings &rarr; Auto Replies.
                    </p>
                    <a href="#" class="small fw-semibold text-primary text-decoration-none" onclick="notifyComingSoon('Auto Replies Setup'); return false;">
                        Manage Auto Replies &rarr;
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Modal: Customer Profile Details -->
<div class="modal fade" id="customerProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Customer Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-2">
                @if($activeConversation)
                    <img src="{{ $activeConversation->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($activeConversation->customer_name) . '&background=0066ff&color=fff' }}" 
                         alt="{{ $activeConversation->customer_name }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <h5 class="fw-bold mb-1">{{ $activeConversation->customer_name }}</h5>
                    <span class="badge bg-success-subtle text-success mb-3">Verified Marketplace Buyer</span>

                    <div class="text-start bg-light rounded-3 p-3 small mb-3">
                        <div class="row g-2">
                            <div class="col-4 text-secondary">Email:</div>
                            <div class="col-8 fw-medium">{{ $activeConversation->customer_email }}</div>
                            <div class="col-4 text-secondary">Phone:</div>
                            <div class="col-8 fw-medium">{{ $activeConversation->customer_phone ?? '+91 98765 43210' }}</div>
                            <div class="col-4 text-secondary">City:</div>
                            <div class="col-8 fw-medium">{{ $activeConversation->customer_city ?? 'Ahmedabad, Gujarat' }}</div>
                            <div class="col-4 text-secondary">Interests:</div>
                            <div class="col-8 fw-medium">{{ $activeConversation->subject_title }}</div>
                            <div class="col-4 text-secondary">Total Orders:</div>
                            <div class="col-8 fw-medium">3 Purchases (₹7,497)</div>
                        </div>
                    </div>
                @endif
                <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto scroll chat to bottom
    function scrollChatToBottom() {
        const chatArea = document.getElementById('chatMessagesArea');
        if (chatArea) {
            chatArea.scrollTop = chatArea.scrollHeight;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        scrollChatToBottom();

        // Focus message input
        const msgInput = document.getElementById('chatMessageInput');
        if (msgInput) {
            msgInput.focus();
        }
    });

    // Insert Emoji into input
    function insertEmoji(emoji) {
        const input = document.getElementById('chatMessageInput');
        if (input) {
            input.value += emoji + ' ';
            input.focus();
        }
    }

    // Trigger brochure upload or action
    function triggerBrochureAction() {
        executeQuickAction('brochure');
    }

    function triggerImageUpload() {
        alert('Image attachment selector opened. Select JPG or PNG to attach to chat.');
    }

    function showCustomerModal() {
        const modal = new bootstrap.Modal(document.getElementById('customerProfileModal'));
        modal.show();
    }

    function reportUser() {
        if (confirm('Are you sure you want to flag or report this user for administrative review?')) {
            alert('User reported to Super Admin moderation team. Thank you.');
        }
    }

    // Execute quick action via AJAX
    @if($activeConversation)
    function executeQuickAction(actionType) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                   || '{{ csrf_token() }}';

        fetch("{{ route('seller.messages.quick-action', $activeConversation->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: actionType })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            window.location.reload();
        });
    }
    @endif
</script>
@endsection

