@extends('admin.layouts.admin')

@section('title', 'Customer-Seller Chats Audit & Monitoring - Super Admin')

@section('styles')
<style>
    .admin-chat-layout {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 1.5rem;
        height: calc(100vh - 210px);
        min-height: 650px;
    }

    @media (max-width: 992px) {
        .admin-chat-layout {
            grid-template-columns: 1fr;
            height: auto;
        }
    }

    .admin-chat-list-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .admin-chat-conv-item {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: background-color 0.15s;
    }
    .admin-chat-conv-item:hover {
        background-color: #f8fafc;
    }
    .admin-chat-conv-item.active {
        background-color: #eff6ff;
        border-left: 3px solid #2563eb;
    }

    .admin-chat-detail-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .admin-chat-stream {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem 1.5rem;
        background-color: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .admin-bubble-seller {
        max-width: 70%;
        margin-left: auto;
        background-color: #2563eb;
        color: #ffffff;
        padding: 0.75rem 1rem;
        border-radius: 14px 14px 2px 14px;
        font-size: 0.85rem;
    }

    .admin-bubble-customer {
        max-width: 70%;
        margin-right: auto;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        padding: 0.75rem 1rem;
        border-radius: 14px 14px 14px 2px;
        font-size: 0.85rem;
    }

    .admin-bubble-moderator {
        max-width: 80%;
        margin: 0.5rem auto;
        background-color: #fef2f2;
        border: 1px dashed #ef4444;
        color: #991b1b;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-size: 0.825rem;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Page Title & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                <i class="fa-solid fa-comments text-primary me-2"></i>Customer-Seller Chats Monitoring
            </h1>
            <p class="text-secondary small mb-0">
                Super Admin audit view of all conversations, inquiries, and customer interactions across marketplace sellers.
            </p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold">
                <i class="fa-solid fa-shield-halved me-1"></i> Admin Audit Mode Active
            </span>
        </div>
    </div>

    <!-- 4 KPI Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Total Platform Chats</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_conversations'] }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-comments fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Messages Exchanged</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_messages'] }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-message fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Active Sellers</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['active_sellers'] }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info">
                        <i class="fa-solid fa-store fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small fw-semibold text-uppercase">Course Inquiries</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['inquiries_count'] }}</h3>
                    </div>
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-circle-question fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card border-0 shadow-sm rounded-3 p-3 mb-4">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" value="{{ $search }}" class="form-control border-start-0" 
                           placeholder="Search customer, seller, or message text...">
                </div>
            </div>

            <div class="col-md-3">
                <select name="seller_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Sellers (Platform-wide)</option>
                    @foreach($sellers as $s)
                        <option value="{{ $s->id }}" {{ $selectedSellerId == $s->id ? 'selected' : '' }}>
                            {{ $s->store_name }} ({{ $s->user->name ?? 'Seller' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>All Categories</option>
                    <option value="inquiries" {{ $selectedCategory === 'inquiries' ? 'selected' : '' }}>Inquiries</option>
                    <option value="orders" {{ $selectedCategory === 'orders' ? 'selected' : '' }}>Orders</option>
                    <option value="support" {{ $selectedCategory === 'support' ? 'selected' : '' }}>Support</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">Filter</button>
                @if($search || $selectedSellerId || $selectedCategory !== 'all')
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 2-Pane Audit Layout -->
    <div class="admin-chat-layout">

        <!-- ================= PANE 1: ALL CONVERSATIONS LIST ================= -->
        <div class="admin-chat-list-card">
            <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark small text-uppercase">Conversations ({{ $conversations->total() }})</span>
                <span class="badge bg-secondary-subtle text-secondary small">Live Monitoring</span>
            </div>

            <div class="flex-grow-1 overflow-auto">
                @forelse($conversations as $conv)
                    @php
                        $isActive = ($activeConversation && $activeConversation->id === $conv->id);
                    @endphp
                    <a href="{{ route('admin.messages.index', ['conversation_id' => $conv->id, 'seller_id' => $selectedSellerId, 'category' => $selectedCategory, 'search' => $search]) }}" 
                       class="admin-chat-conv-item {{ $isActive ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-primary-subtle text-primary" style="font-size: 0.65rem;">
                                🏪 {{ $conv->seller->store_name ?? 'Seller' }}
                            </span>
                            <span class="text-muted" style="font-size: 0.7rem;">
                                {{ $conv->last_message_at ? $conv->last_message_at->format('M d, g:i A') : '' }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <img src="{{ $conv->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($conv->customer_name) . '&background=0066ff&color=fff' }}" 
                                 class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                            <div class="fw-bold text-dark small text-truncate">{{ $conv->customer_name }}</div>
                            <span class="badge bg-secondary-subtle text-muted ms-auto" style="font-size: 0.65rem;">{{ ucfirst($conv->category) }}</span>
                        </div>
                        <div class="text-truncate small text-secondary mb-1">
                            <strong>{{ $conv->subject_title }}</strong>
                        </div>
                        <div class="text-truncate text-muted" style="font-size: 0.75rem;">
                            {{ $conv->last_message }}
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted small">
                        No conversations found matching criteria.
                    </div>
                @endforelse
            </div>

            @if($conversations->hasPages())
                <div class="p-2 border-top bg-light">
                    {{ $conversations->links() }}
                </div>
            @endif
        </div>

        <!-- ================= PANE 2: CONVERSATION DETAILS & TRANSCRIPT ================= -->
        <div class="admin-chat-detail-card">
            @if($activeConversation)
                <!-- Header with Seller & Customer Metadata -->
                <div class="p-3 border-bottom bg-white">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary px-2 py-1">🏪 Seller: {{ $activeConversation->seller->store_name ?? 'Seller' }}</span>
                                <span class="badge bg-light text-dark border">Owner: {{ $activeConversation->seller->user->name ?? 'Rahul Sharma' }} ({{ $activeConversation->seller->user->email ?? '' }})</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">
                                Chat with: {{ $activeConversation->customer_name }} 
                                <span class="text-muted fw-normal fs-6">({{ $activeConversation->customer_email }})</span>
                            </h5>
                            <div class="small text-secondary">
                                <strong>Item:</strong> {{ $activeConversation->subject_title }} ({{ $activeConversation->subject_type }}) • 
                                <strong>Location:</strong> {{ $activeConversation->customer_city ?? 'Gujarat' }} • 
                                <strong>Status:</strong> <span class="text-success fw-bold">{{ $activeConversation->status }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2">
                                Total Messages: {{ $activeConversation->messages->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Messages Transcript Stream -->
                <div class="admin-chat-stream">
                    @foreach($activeConversation->messages as $msg)
                        @if($msg->sender_type === 'seller')
                            <div class="admin-bubble-seller">
                                <div class="d-flex justify-content-between align-items-center mb-1 text-white-50" style="font-size: 0.7rem;">
                                    <span>🏪 Seller ({{ $activeConversation->seller->store_name ?? 'Seller' }})</span>
                                    <span>{{ $msg->created_at->format('M d, g:i A') }}</span>
                                </div>
                                <div style="white-space: pre-line;">{{ $msg->message }}</div>
                            </div>
                        @elseif($msg->sender_type === 'admin')
                            <div class="admin-bubble-moderator">
                                <div class="fw-bold mb-1"><i class="fa-solid fa-shield-halved me-1"></i> Super Admin Moderation Notice</div>
                                <div>{{ $msg->message }}</div>
                                <div class="text-muted mt-1" style="font-size: 0.68rem;">{{ $msg->created_at->format('M d, g:i A') }}</div>
                            </div>
                        @else
                            <div class="admin-bubble-customer">
                                <div class="d-flex justify-content-between align-items-center mb-1 text-muted" style="font-size: 0.7rem;">
                                    <span>👤 Customer ({{ $activeConversation->customer_name }})</span>
                                    <span>{{ $msg->created_at->format('M d, g:i A') }}</span>
                                </div>
                                <div style="white-space: pre-line;">{{ $msg->message }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Super Admin Moderation Action Bar -->
                <div class="p-3 border-top bg-white">
                    <form action="{{ route('admin.messages.moderation-note', $activeConversation->id) }}" method="POST">
                        @csrf
                        <label class="form-label small fw-bold text-dark mb-1">
                            <i class="fa-solid fa-shield-halved text-danger me-1"></i> Post Super Admin Moderation Notice (Visible to both Seller and Customer):
                        </label>
                        <div class="input-group">
                            <input type="text" name="note" class="form-control" 
                                   placeholder="Type an official moderation warning or administrative notice..." required>
                            <button type="submit" class="btn btn-danger fw-semibold px-4">
                                Send Notice
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="h-100 d-flex flex-column align-items-center justify-content-center text-secondary">
                    <i class="fa-regular fa-comments display-4 mb-3 text-muted"></i>
                    <h5>No Conversation Selected</h5>
                    <p class="small">Click any conversation from the list to inspect the full transcript.</p>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection

