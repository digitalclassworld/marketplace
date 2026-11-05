@extends('admin.layouts.admin')

@section('title', 'Messages & Support - Super Admin')

@section('styles')
<style>
    /* KPI Metric Cards matching screenshot pixel-for-pixel */
    .msg-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        height: 100%;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .msg-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .msg-icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .kpi-icon-blue    { background: #eff6ff; color: #2563eb; }
    .kpi-icon-orange  { background: #fff7ed; color: #ea580c; }
    .kpi-icon-cyan    { background: #f0fdf4; color: #0284c7; }
    .kpi-icon-purple  { background: #f5f3ff; color: #8b5cf6; }
    .kpi-icon-green   { background: #ecfdf5; color: #059669; }
    .kpi-icon-red     { background: #fef2f2; color: #dc2626; }

    /* Navigation Filter Tabs */
    .msg-tabs-nav {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .msg-tabs-nav .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.65rem 1.15rem;
        border-radius: 8px 8px 0 0;
        background: transparent;
        transition: all 0.15s ease;
        text-decoration: none;
        position: relative;
    }
    .msg-tabs-nav .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .msg-tabs-nav .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .msg-tabs-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    /* 3-Column Hub Layout */
    .support-hub-container {
        display: grid;
        grid-template-columns: 330px 1fr 310px;
        gap: 1rem;
        min-height: 700px;
        align-items: start;
    }

    @media (max-width: 1400px) {
        .support-hub-container {
            grid-template-columns: 310px 1fr 290px;
        }
    }

    @media (max-width: 1200px) {
        .support-hub-container {
            grid-template-columns: 320px 1fr;
        }
        .support-details-panel {
            grid-column: span 2;
        }
    }

    @media (max-width: 900px) {
        .support-hub-container {
            grid-template-columns: 1fr;
        }
        .support-details-panel {
            grid-column: span 1;
        }
    }

    /* Column 1: Ticket List */
    .ticket-list-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 750px;
    }

    .ticket-list-scroll {
        flex: 1;
        overflow-y: auto;
    }

    .ticket-item {
        padding: 0.75rem 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background-color 0.15s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .ticket-item:hover {
        background-color: #f8fafc;
    }
    .ticket-item.active {
        background-color: #f0f7ff;
        border-left: 3px solid #0066ff;
    }

    /* Column 2: Center Thread */
    .support-chat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 750px;
    }

    .chat-messages-stream {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem;
        background-color: #fafbfc;
        display: flex;
        flex-direction: column;
        gap: 1.15rem;
    }

    .chat-date-separator {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0.5rem 0;
    }
    .chat-date-separator span {
        background: #f1f5f9;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.75rem;
        border-radius: 12px;
    }

    .bubble-customer {
        display: flex;
        gap: 0.65rem;
        align-items: flex-start;
        max-width: 80%;
    }
    .bubble-customer-body {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0 14px 14px 14px;
        padding: 0.75rem 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .bubble-agent {
        display: flex;
        gap: 0.65rem;
        align-items: flex-start;
        max-width: 80%;
        margin-left: auto;
        flex-direction: row-reverse;
    }
    .bubble-agent-body {
        background: #ebf3fe;
        border: 1px solid #dbeafe;
        border-radius: 14px 0 14px 14px;
        padding: 0.75rem 1rem;
        color: #1e293b;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .bubble-internal-note {
        background: #fffbeb;
        border: 1px dashed #f59e0b;
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        font-size: 0.78rem;
        color: #92400e;
        margin: 0.25rem 0;
    }

    /* Column 3: Details Panel */
    .support-details-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem;
        height: 750px;
        overflow-y: auto;
    }

    /* Badges & Pills */
    .source-pill {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .source-website  { background: #eff6ff; color: #1d4ed8; }
    .source-whatsapp { background: #dcfce7; color: #15803d; }
    .source-email    { background: #f0fdf4; color: #0284c7; }
    .source-app      { background: #ecfdf5; color: #047857; }
    .source-phone    { background: #eff6ff; color: #2563eb; }
    .source-seller   { background: #f0fdf4; color: #166534; }

    .category-badge {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 6px;
        display: inline-block;
    }
    .category-inquiry   { background: #e0f2fe; color: #0369a1; }
    .category-support   { background: #e0f2fe; color: #0369a1; }
    .category-order     { background: #ffe4e6; color: #be123c; }
    .category-payment   { background: #ffedd5; color: #c2410c; }
    .category-plan      { background: #f3e8ff; color: #7e22ce; }
    .category-technical { background: #fee2e2; color: #b91c1c; }

    .status-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        display: inline-block;
    }
    .status-open        { background: #fee2e2; color: #dc2626; }
    .status-in-progress { background: #eff6ff; color: #2563eb; }
    .status-waiting     { background: #f5f3ff; color: #7c3aed; }
    .status-resolved    { background: #dcfce7; color: #15803d; }
    .status-spam        { background: #f1f5f9; color: #64748b; }

    .priority-badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.15rem 0.55rem;
        border-radius: 6px;
        display: inline-block;
    }
    .priority-low    { background: #f1f5f9; color: #475569; }
    .priority-medium { background: #ffedd5; color: #c2410c; }
    .priority-high   { background: #fee2e2; color: #dc2626; }
    .priority-urgent { background: #fef2f2; color: #991b1b; }

    .meta-detail-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        padding: 0.3rem 0;
        border-bottom: 1px dashed #f1f5f9;
    }
    .meta-detail-row:last-child {
        border-bottom: none;
    }

    /* Activities vertical timeline */
    .activity-timeline {
        position: relative;
        padding-left: 1.25rem;
    }
    .activity-timeline::before {
        content: '';
        position: absolute;
        top: 6px;
        bottom: 6px;
        left: 5px;
        width: 2px;
        background: #e2e8f0;
    }
    .activity-node {
        position: relative;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
    }
    .activity-node::before {
        content: '';
        position: absolute;
        left: -1.25rem;
        top: 3px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #10b981;
        border: 2px solid #ffffff;
    }
    .activity-node.node-primary::before { background: #3b82f6; }
    .activity-node.node-purple::before  { background: #8b5cf6; }
    .activity-node.node-danger::before  { background: #ef4444; }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Top Header matching screenshot --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Messages & Support</h1>
            <p class="text-muted small mb-0">Manage customer queries, support tickets, seller messages and platform communications.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Auto Reply Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#autoReplyModal">
                <i class="fa-solid fa-robot me-1.5 text-muted"></i> Auto Reply
            </button>

            {{-- Support Settings Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#supportSettingsModal">
                <i class="fa-solid fa-gear me-1.5 text-muted"></i> Support Settings
            </button>

            {{-- Export Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-white border bg-white text-secondary dropdown-toggle px-3 py-2 fw-medium shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-arrow-down-to-bracket me-1.5 text-muted"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item py-2" href="{{ route('admin.messages.export', ['format' => 'excel']) }}"><i class="fa-regular fa-file-excel text-success me-2"></i> Download as Excel</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.messages.export', ['format' => 'pdf']) }}"><i class="fa-regular fa-file-pdf text-danger me-2"></i> Download as PDF</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.messages.export', ['format' => 'filtered']) }}"><i class="fa-solid fa-filter text-primary me-2"></i> Download Filtered Data</a></li>
                </ul>
            </div>

            {{-- + Create Ticket Button --}}
            <button class="btn btn-primary px-3 py-2 fw-medium shadow-sm" style="background-color: #0066ff; border-color: #0066ff;" data-bs-toggle="modal" data-bs-target="#createTicketModal">
                <i class="fa-solid fa-plus me-1.5"></i> Create Ticket
            </button>
        </div>
    </div>

    {{-- 6 KPI Metric Cards matching screenshot --}}
    <div class="row g-3 mb-4">
        {{-- Card 1: Total Conversations --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="msg-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">Total Conversations</span>
                    <div class="msg-icon-circle kpi-icon-blue">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5 mb-1">
                    <h2 class="h4 fw-bold text-dark mb-0">{{ $stats['total_conversations'] ?? '1,240' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.68rem;">↑ {{ $stats['conversations_growth'] ?? '18%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.72rem;">{{ $stats['conversations_sub'] ?? '+210 this month' }}</span>
            </div>
        </div>

        {{-- Card 2: Open Tickets --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="msg-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">Open Tickets</span>
                    <div class="msg-icon-circle kpi-icon-orange">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5 mb-1">
                    <h2 class="h4 fw-bold text-dark mb-0">{{ $stats['open_tickets'] ?? '180' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.72rem;">{{ $stats['open_sub'] ?? '15% of total' }}</span>
            </div>
        </div>

        {{-- Card 3: In Progress --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="msg-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">In Progress</span>
                    <div class="msg-icon-circle kpi-icon-cyan">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5 mb-1">
                    <h2 class="h4 fw-bold text-dark mb-0">{{ $stats['in_progress'] ?? '320' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.72rem;">{{ $stats['in_progress_sub'] ?? '26% of total' }}</span>
            </div>
        </div>

        {{-- Card 4: Waiting for Customer --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="msg-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">Waiting for Customer</span>
                    <div class="msg-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-pause"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5 mb-1">
                    <h2 class="h4 fw-bold text-dark mb-0">{{ $stats['waiting'] ?? '160' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.72rem;">{{ $stats['waiting_sub'] ?? '13% of total' }}</span>
            </div>
        </div>

        {{-- Card 5: Resolved --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="msg-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">Resolved</span>
                    <div class="msg-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5 mb-1">
                    <h2 class="h4 fw-bold text-dark mb-0">{{ $stats['resolved'] ?? '540' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.72rem;">{{ $stats['resolved_sub'] ?? '44% of total' }}</span>
            </div>
        </div>

        {{-- Card 6: Avg. Response Time --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="msg-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.78rem;">Avg. Response Time</span>
                    <div class="msg-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-stopwatch"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-1.5 mb-1">
                    <h2 class="h4 fw-bold text-dark mb-0">{{ $stats['avg_response_time'] ?? '2.4 hrs' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.68rem;">↑ {{ $stats['response_growth'] ?? '35%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.72rem;">{{ $stats['response_sub'] ?? 'Last 30 days' }}</span>
            </div>
        </div>
    </div>

    {{-- Tabs Row matching screenshot --}}
    <div class="d-flex msg-tabs-nav mb-3 overflow-auto">
        <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['tab' => 'all'])) }}" class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}">
            All Messages ({{ number_format($counts['all'] ?? 1240) }})
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['tab' => 'open'])) }}" class="nav-link {{ $currentTab === 'open' ? 'active' : '' }}">
            Open ({{ number_format($counts['open'] ?? 180) }})
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['tab' => 'in_progress'])) }}" class="nav-link {{ $currentTab === 'in_progress' ? 'active' : '' }}">
            In Progress ({{ number_format($counts['in_progress'] ?? 320) }})
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['tab' => 'waiting'])) }}" class="nav-link {{ $currentTab === 'waiting' ? 'active' : '' }}">
            Waiting ({{ number_format($counts['waiting'] ?? 160) }})
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['tab' => 'resolved'])) }}" class="nav-link {{ $currentTab === 'resolved' ? 'active' : '' }}">
            Resolved ({{ number_format($counts['resolved'] ?? 540) }})
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['tab' => 'spam'])) }}" class="nav-link {{ $currentTab === 'spam' ? 'active' : '' }}">
            Spam ({{ number_format($counts['spam'] ?? 40) }})
        </a>
    </div>

    {{-- Single Row Filter Bar matching screenshot --}}
    <form action="{{ route('admin.messages.index') }}" method="GET" class="card border-0 shadow-sm p-3 mb-4 rounded-3 bg-white">
        <input type="hidden" name="tab" value="{{ $currentTab }}">
        @if($unreadOnly)
            <input type="hidden" name="unread" value="1">
        @endif

        <div class="row g-2 align-items-center">
            {{-- Search by name, email, mobile, message --}}
            <div class="col-lg-3 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3 pe-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-1" placeholder="Search by name, email, mobile, message..." value="{{ $search ?? '' }}">
                </div>
            </div>

            {{-- All Categories --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="category" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Course Inquiry" {{ ($categoryFilter ?? '') === 'Course Inquiry' ? 'selected' : '' }}>Course Inquiry</option>
                    <option value="Product Support" {{ ($categoryFilter ?? '') === 'Product Support' ? 'selected' : '' }}>Product Support</option>
                    <option value="Order Issue" {{ ($categoryFilter ?? '') === 'Order Issue' ? 'selected' : '' }}>Order Issue</option>
                    <option value="Course Info" {{ ($categoryFilter ?? '') === 'Course Info' ? 'selected' : '' }}>Course Info</option>
                    <option value="Plan Upgrade" {{ ($categoryFilter ?? '') === 'Plan Upgrade' ? 'selected' : '' }}>Plan Upgrade</option>
                    <option value="Payment Issue" {{ ($categoryFilter ?? '') === 'Payment Issue' ? 'selected' : '' }}>Payment Issue</option>
                    <option value="How To" {{ ($categoryFilter ?? '') === 'How To' ? 'selected' : '' }}>How To</option>
                    <option value="Business Inquiry" {{ ($categoryFilter ?? '') === 'Business Inquiry' ? 'selected' : '' }}>Business Inquiry</option>
                    <option value="Technical Issue" {{ ($categoryFilter ?? '') === 'Technical Issue' ? 'selected' : '' }}>Technical Issue</option>
                    <option value="Pricing" {{ ($categoryFilter ?? '') === 'Pricing' ? 'selected' : '' }}>Pricing</option>
                </select>
            </div>

            {{-- All Sources --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="source" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Sources</option>
                    <option value="Website" {{ ($sourceFilter ?? '') === 'Website' ? 'selected' : '' }}>Website</option>
                    <option value="WhatsApp" {{ ($sourceFilter ?? '') === 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="Email" {{ ($sourceFilter ?? '') === 'Email' ? 'selected' : '' }}>Email</option>
                    <option value="App" {{ ($sourceFilter ?? '') === 'App' ? 'selected' : '' }}>App</option>
                    <option value="Phone" {{ ($sourceFilter ?? '') === 'Phone' ? 'selected' : '' }}>Phone</option>
                    <option value="Seller" {{ ($sourceFilter ?? '') === 'Seller' ? 'selected' : '' }}>Seller</option>
                </select>
            </div>

            {{-- All Priority --}}
            <div class="col-lg-1 col-md-3 col-6">
                <select name="priority" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Priority</option>
                    <option value="Low" {{ ($priorityFilter ?? '') === 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ ($priorityFilter ?? '') === 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ ($priorityFilter ?? '') === 'High' ? 'selected' : '' }}>High</option>
                    <option value="Urgent" {{ ($priorityFilter ?? '') === 'Urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>

            {{-- All Assigned To --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="assigned_to" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Assigned To</option>
                    <option value="Hitesh" {{ ($assignedFilter ?? '') === 'Hitesh' ? 'selected' : '' }}>Hitesh</option>
                    <option value="Support Team" {{ ($assignedFilter ?? '') === 'Support Team' ? 'selected' : '' }}>Support Team</option>
                </select>
            </div>

            {{-- Date Range & Reset --}}
            <div class="col-lg-2 col-md-6 col-12 d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                    <input type="text" class="form-control border-start-0" value="01 Oct 2026 - 31 Oct 2026" readonly style="font-size: 0.8rem; background-color: #ffffff;">
                </div>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>
    </form>

    {{-- Main 3-Column Hub Container --}}
    <div class="support-hub-container">

        {{-- COLUMN 1: Conversation / Ticket List --}}
        <div class="ticket-list-card shadow-sm">
            {{-- List Header Sub-bar matching screenshot --}}
            <div class="p-2.5 border-bottom d-flex justify-content-between align-items-center bg-white">
                <div class="d-flex align-items-center gap-1.5">
                    <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['unread' => null])) }}"
                       class="btn btn-sm {{ !$unreadOnly ? 'btn-primary' : 'btn-light text-muted' }} px-2.5 py-0.5 fw-semibold" style="font-size: 0.75rem;">
                        All
                    </a>
                    <a href="{{ route('admin.messages.index', array_merge(request()->query(), ['unread' => '1'])) }}"
                       class="btn btn-sm {{ $unreadOnly ? 'btn-primary' : 'btn-light text-muted' }} px-2.5 py-0.5 fw-semibold" style="font-size: 0.75rem;">
                        Unread ({{ $counts['unread'] ?? 32 }})
                    </a>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light text-muted py-0.5 px-2 dropdown-toggle" style="font-size: 0.75rem;" type="button" data-bs-toggle="dropdown">
                        Newest
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                        <li><a class="dropdown-item py-1" href="#">Newest</a></li>
                        <li><a class="dropdown-item py-1" href="#">Oldest</a></li>
                        <li><a class="dropdown-item py-1" href="#">Highest Priority</a></li>
                    </ul>
                </div>
            </div>

            {{-- Tickets Scrollable List --}}
            <div class="ticket-list-scroll">
                @forelse($tickets as $t)
                    @php
                        $isActive = ($activeTicket && $activeTicket->id === $t->id);
                        $categoryClass = match(strtolower($t->category)) {
                            'order issue'     => 'category-order',
                            'payment issue'   => 'category-payment',
                            'plan upgrade'    => 'category-plan',
                            'technical issue' => 'category-technical',
                            default           => 'category-inquiry',
                        };

                        $sourceIcon = match(strtolower($t->source)) {
                            'whatsapp' => 'fa-brands fa-whatsapp text-success',
                            'email'    => 'fa-regular fa-envelope text-info',
                            'app'      => 'fa-solid fa-mobile-screen text-success',
                            'phone'    => 'fa-solid fa-phone text-primary',
                            'seller'   => 'fa-solid fa-shop text-success',
                            default    => 'fa-solid fa-globe text-primary',
                        };

                        $sourceClass = match(strtolower($t->source)) {
                            'whatsapp' => 'source-whatsapp',
                            'email'    => 'source-email',
                            'app'      => 'source-app',
                            'phone'    => 'source-phone',
                            'seller'   => 'source-seller',
                            default    => 'source-website',
                        };
                    @endphp

                    <div class="ticket-item {{ $isActive ? 'active' : '' }}" onclick="selectTicket({{ $t->id }})">
                        <div class="d-flex align-items-start gap-2">
                            <input type="checkbox" class="form-check-input mt-1" onclick="event.stopPropagation();">
                            <img src="{{ $t->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($t->customer_name) . '&background=0066ff&color=fff' }}"
                                 alt="{{ $t->customer_name }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-baseline mb-0.5">
                                    <span class="fw-bold text-dark text-truncate" style="font-size: 0.82rem; max-width: 140px;">
                                        {{ $t->customer_name }}
                                    </span>
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        {{ $t->last_message_at ? $t->last_message_at->format('h:i A') : '10:24 AM' }}
                                    </span>
                                </div>
                                <div class="text-muted text-truncate mb-1.5" style="font-size: 0.74rem;">
                                    {{ $t->last_message ?: 'I want to know about the Digital Marketing course...' }}
                                </div>
                                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                    <span class="category-badge {{ $categoryClass }}">
                                        {{ $t->category }}
                                    </span>
                                    <span class="source-pill {{ $sourceClass }}">
                                        <i class="{{ $sourceIcon }}"></i> {{ $t->source }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa-regular fa-comments fs-2 opacity-50 mb-2"></i>
                        <p class="small mb-0">No tickets found</p>
                    </div>
                @endforelse
            </div>

            {{-- List Footer / Pagination matching screenshot --}}
            <div class="p-2 border-top bg-white d-flex justify-content-between align-items-center" style="font-size: 0.72rem;">
                <span class="text-muted">Showing <strong>1 to {{ count($tickets) }}</strong> of <strong>{{ number_format($counts['all'] ?? 1240) }}</strong></span>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link py-0 px-1.5" href="#">&lt;</a></li>
                        <li class="page-item active"><a class="page-link py-0 px-1.5" href="#">1</a></li>
                        <li class="page-item"><a class="page-link py-0 px-1.5" href="#">2</a></li>
                        <li class="page-item"><a class="page-link py-0 px-1.5" href="#">3</a></li>
                        <li class="page-item disabled"><span class="page-link py-0 px-1.5">...</span></li>
                        <li class="page-item"><a class="page-link py-0 px-1.5" href="#">124</a></li>
                        <li class="page-item"><a class="page-link py-0 px-1.5" href="#">&gt;</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        {{-- COLUMN 2: Center Thread & Reply Box --}}
        <div class="support-chat-card shadow-sm">
            @if($activeTicket)
                {{-- Active Thread Header matching screenshot --}}
                <div class="p-3 border-bottom bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <img src="{{ $activeTicket->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($activeTicket->customer_name) . '&background=0066ff&color=fff' }}"
                             alt="{{ $activeTicket->customer_name }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-0.5">
                                <h5 class="fw-bold text-dark mb-0 fs-6">{{ $activeTicket->customer_name }}</h5>
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-envelope me-1"></i> {{ $activeTicket->customer_email }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-solid fa-phone me-1"></i> {{ $activeTicket->customer_phone ?? '+91 98765 43210' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                <span class="category-badge category-inquiry">{{ $activeTicket->category }}</span>
                                <span class="priority-badge priority-{{ strtolower($activeTicket->priority) }}">{{ $activeTicket->priority }}</span>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $activeTicket->status)) }}">{{ $activeTicket->status }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-primary btn-sm px-2.5 py-1" style="font-size: 0.75rem;" onclick="alert('Viewing customer profile: {{ $activeTicket->customer_name }}')">
                            View Profile
                        </button>

                        {{-- Assign To Dropdown matching screenshot --}}
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border d-flex align-items-center gap-1.5 py-1 px-2.5" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                <span class="text-muted">Assign To</span>
                                <img src="https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff" class="rounded-circle" style="width: 18px; height: 18px;">
                                <span class="fw-semibold text-dark">{{ $activeTicket->assigned_to ?? 'Hitesh' }}</span>
                                <i class="fa-solid fa-chevron-down" style="font-size: 0.65rem;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                                <li>
                                    <form action="{{ route('admin.messages.tickets.assign', $activeTicket->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="assigned_to" value="Hitesh">
                                        <button type="submit" class="dropdown-item py-1.5">Assign to Hitesh</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.messages.tickets.assign', $activeTicket->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="assigned_to" value="Support Team">
                                        <button type="submit" class="dropdown-item py-1.5">Assign to Support Team</button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        {{-- Action Menu --}}
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border px-2 py-1 text-muted" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                                <li>
                                    <form action="{{ route('admin.messages.tickets.status', $activeTicket->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Resolved">
                                        <button type="submit" class="dropdown-item py-1.5 text-success"><i class="fa-solid fa-check me-2"></i> Mark as Resolved</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.messages.tickets.status', $activeTicket->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Waiting">
                                        <button type="submit" class="dropdown-item py-1.5 text-warning"><i class="fa-regular fa-clock me-2"></i> Mark as Waiting</button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.messages.tickets.destroy', $activeTicket->id) }}" method="POST" onsubmit="return confirm('Delete this ticket?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item py-1.5 text-danger"><i class="fa-regular fa-trash-can me-2"></i> Delete Ticket</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Messages Stream matching screenshot --}}
                <div class="chat-messages-stream" id="chatStream">
                    <div class="chat-date-separator">
                        <span>30 Oct 2026</span>
                    </div>

                    @foreach($activeTicket->messages as $msg)
                        @if($msg->is_internal_note)
                            <div class="bubble-internal-note">
                                <div class="fw-bold mb-0.5"><i class="fa-solid fa-lock me-1"></i> Internal Note ({{ $msg->sender_name }}):</div>
                                <div>{{ $msg->message }}</div>
                            </div>
                        @elseif($msg->sender_type === 'admin')
                            {{-- Admin bubble (Right) --}}
                            <div class="bubble-agent">
                                <img src="{{ $msg->sender_avatar ?: 'https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff' }}"
                                     alt="Agent" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;">
                                <div class="bubble-agent-body">
                                    <div class="text-dark" style="font-size: 0.82rem; white-space: pre-line; line-height: 1.45;">{{ $msg->message }}</div>
                                    <div class="text-end text-muted mt-1 d-flex align-items-center justify-content-end gap-1" style="font-size: 0.68rem;">
                                        <span>{{ $msg->created_at ? $msg->created_at->format('h:i A') : '10:26 AM' }}</span>
                                        <i class="fa-solid fa-check-double text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Customer bubble (Left) --}}
                            <div class="bubble-customer">
                                <img src="{{ $msg->sender_avatar ?: ($activeTicket->customer_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($activeTicket->customer_name) . '&background=0066ff&color=fff') }}"
                                     alt="Customer" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;">
                                <div class="bubble-customer-body">
                                    <div class="text-dark" style="font-size: 0.82rem; line-height: 1.45;">{{ $msg->message }}</div>
                                    <div class="text-muted mt-1" style="font-size: 0.68rem;">
                                        {{ $msg->created_at ? $msg->created_at->format('h:i A') : '10:24 AM' }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Bottom Reply Area matching screenshot --}}
                <div class="p-3 border-top bg-white">
                    <form action="{{ route('admin.messages.tickets.reply', $activeTicket->id) }}" method="POST" id="replyForm">
                        @csrf
                        <input type="hidden" name="is_internal_note" id="isInternalNoteInput" value="0">

                        {{-- Tab Switcher: Reply / Internal Note --}}
                        <div class="d-flex align-items-center gap-3 mb-2 border-bottom pb-1.5" style="font-size: 0.78rem;">
                            <button type="button" class="btn btn-link text-decoration-none p-0 fw-bold text-primary active-tab-btn" id="tabReplyBtn" onclick="switchMode('reply')">
                                Reply
                            </button>
                            <button type="button" class="btn btn-link text-decoration-none p-0 text-muted" id="tabNoteBtn" onclick="switchMode('note')">
                                Internal Note
                            </button>
                        </div>

                        {{-- Textarea --}}
                        <textarea name="message" id="messageInput" rows="3" class="form-control mb-2"
                                  placeholder="Type your message here..." style="font-size: 0.82rem; resize: none;"></textarea>

                        {{-- Toolbar Row --}}
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2.5 text-muted" style="font-size: 0.95rem;">
                                <button type="button" class="btn btn-link text-muted p-0" title="Attachment" onclick="alert('File attachment picker.')">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>
                                <button type="button" class="btn btn-link text-muted p-0" title="Emoji" onclick="alert('Emoji picker.')">
                                    <i class="fa-regular fa-face-smile"></i>
                                </button>
                                <button type="button" class="btn btn-link text-muted p-0" title="Formatting" onclick="alert('Formatting tools.')">
                                    <i class="fa-solid fa-font"></i>
                                </button>
                                <button type="button" class="btn btn-link text-muted p-0" title="Voice note" onclick="alert('Voice recording.')">
                                    <i class="fa-solid fa-microphone"></i>
                                </button>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                        Use Template
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.78rem;">
                                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="insertTemplate('Hi, thanks for reaching out to Digital Class support! How can I assist you today?')">Greeting Template</a></li>
                                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="insertTemplate('Your issue has been forwarded to our technical team for immediate verification.')">Technical Escalation</a></li>
                                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="insertTemplate('We have processed your request. Please check your dashboard and confirm.')">Resolution Notice</a></li>
                                    </ul>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm px-3 fw-semibold d-flex align-items-center gap-1.5" style="background-color: #0066ff; border-color: #0066ff;">
                                    <i class="fa-solid fa-paper-plane" style="font-size: 0.75rem;"></i> Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center py-5 my-auto text-muted">
                    <i class="fa-regular fa-message fs-1 mb-2 opacity-50"></i>
                    <h6>No Ticket Selected</h6>
                    <p class="small mb-0">Select a ticket from the left panel to open the conversation.</p>
                </div>
            @endif
        </div>

        {{-- COLUMN 3: Ticket Details & Metadata Panel matching screenshot --}}
        <div class="support-details-panel shadow-sm">
            @if($activeTicket)
                {{-- Ticket Details --}}
                <div class="pb-3 mb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted fw-bold" style="font-size: 0.75rem;">Ticket Details</span>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $activeTicket->status)) }}">{{ $activeTicket->status }}</span>
                    </div>
                    <h5 class="fw-bold text-dark font-monospace mb-2" style="font-size: 1.05rem;">#{{ $activeTicket->ticket_number }}</h5>

                    <div class="meta-detail-row">
                        <span class="text-muted">Created On</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->created_at ? $activeTicket->created_at->format('d M Y, h:i A') : '30 Oct 2026, 10:24 AM' }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Last Reply</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->last_reply_at ? $activeTicket->last_reply_at->format('d M Y, h:i A') : '30 Oct 2026, 10:28 AM' }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Category</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->category }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Sub Category</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->sub_category ?: 'Digital Marketing' }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Source</span>
                        <span class="fw-semibold text-primary">{{ $activeTicket->source }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Priority</span>
                        <span class="priority-badge priority-{{ strtolower($activeTicket->priority) }}">{{ $activeTicket->priority }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Assigned To</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->assigned_to }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Status</span>
                        <span class="fw-semibold text-danger">{{ $activeTicket->status }}</span>
                    </div>
                </div>

                {{-- Related Information --}}
                <div class="pb-3 mb-3 border-bottom">
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.75rem;">Related Information</div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Interested In</span>
                        <span class="fw-semibold text-dark text-truncate" style="max-width: 140px;">{{ $activeTicket->interested_in ?: 'Digital Marketing Course' }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">User Type</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->user_type ?: 'Student' }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Location</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->customer_city ?: 'Ahmedabad, Gujarat' }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Previous Orders</span>
                        <span class="fw-semibold text-dark">{{ $activeTicket->previous_orders ?? 0 }}</span>
                    </div>
                    <div class="meta-detail-row">
                        <span class="text-muted">Total Spent</span>
                        <span class="fw-semibold text-dark">₹{{ number_format($activeTicket->total_spent ?? 0) }}</span>
                    </div>
                </div>

                {{-- Attachments --}}
                @if($activeTicket->attachment_name)
                    <div class="pb-3 mb-3 border-bottom">
                        <div class="text-muted fw-bold mb-2" style="font-size: 0.75rem;">Attachments</div>
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded-3 bg-light">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-image fs-5 text-primary"></i>
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.75rem;">{{ $activeTicket->attachment_name }}</div>
                                    <div class="text-muted" style="font-size: 0.68rem;">{{ $activeTicket->attachment_size ?? '120 KB' }}</div>
                                </div>
                            </div>
                            <a href="{{ $activeTicket->attachment_url ?: '#' }}" class="btn btn-sm btn-link text-primary p-0" download>
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Recent Activities (Timeline) matching screenshot --}}
                <div class="pb-3 mb-3 border-bottom">
                    <div class="text-muted fw-bold mb-2.5" style="font-size: 0.75rem;">Recent Activities</div>
                    <div class="activity-timeline">
                        @if(!empty($activeTicket->activities))
                            @foreach($activeTicket->activities as $act)
                                <div class="activity-node node-{{ $act['color'] ?? 'primary' }}">
                                    <div class="fw-semibold text-dark">{{ $act['action'] }}</div>
                                    <div class="text-muted" style="font-size: 0.68rem;">{{ $act['time'] }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="activity-node">
                                <div class="fw-semibold text-dark">Ticket created by user</div>
                                <div class="text-muted" style="font-size: 0.68rem;">30 Oct 2026, 10:24 AM</div>
                            </div>
                            <div class="activity-node node-primary">
                                <div class="fw-semibold text-dark">Assigned to Hitesh</div>
                                <div class="text-muted" style="font-size: 0.68rem;">30 Oct 2026, 10:25 AM</div>
                            </div>
                            <div class="activity-node node-purple">
                                <div class="fw-semibold text-dark">Reply sent</div>
                                <div class="text-muted" style="font-size: 0.68rem;">30 Oct 2026, 10:26 AM</div>
                            </div>
                            <div class="activity-node">
                                <div class="fw-semibold text-dark">User replied</div>
                                <div class="text-muted" style="font-size: 0.68rem;">30 Oct 2026, 10:28 AM</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions Buttons matching screenshot --}}
                <div>
                    <div class="text-muted fw-bold mb-2" style="font-size: 0.75rem;">Actions</div>
                    <div class="row g-2">
                        <div class="col-6">
                            <form action="{{ route('admin.messages.tickets.status', $activeTicket->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Resolved">
                                <button type="submit" class="btn btn-success btn-sm w-100 fw-semibold" style="font-size: 0.75rem; background-color: #10b981; border-color: #10b981;">
                                    <i class="fa-solid fa-check me-1"></i> Mark as Resolved
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('admin.messages.tickets.status', $activeTicket->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Waiting">
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100 fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-lock me-1"></i> Close Ticket
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-warning btn-sm w-100 fw-semibold text-dark" style="font-size: 0.75rem;" onclick="switchMode('note'); document.getElementById('messageInput').focus();">
                                <i class="fa-regular fa-note-sticky me-1"></i> Add Note
                            </button>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('admin.messages.tickets.destroy', $activeTicket->id) }}" method="POST" onsubmit="return confirm('Permanently delete this ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-trash-can me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5 my-auto text-muted">
                    <p class="small mb-0">Select a ticket to inspect details and history.</p>
                </div>
            @endif
        </div>

    </div>

</div>

{{-- MODALS --}}

{{-- 1. Create Ticket Modal --}}
<div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="createTicketModalLabel">Create New Support Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.messages.tickets.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Customer Name *</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="e.g. Priya Patel" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Email *</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="user@gmail.com" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Phone Number</label>
                            <input type="text" name="customer_phone" class="form-control" placeholder="+91 98765 43210">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Category</label>
                            <select name="category" class="form-select">
                                <option value="Course Inquiry">Course Inquiry</option>
                                <option value="Product Support">Product Support</option>
                                <option value="Order Issue">Order Issue</option>
                                <option value="Payment Issue">Payment Issue</option>
                                <option value="Plan Upgrade">Plan Upgrade</option>
                                <option value="Technical Issue">Technical Issue</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Initial Query / Message *</label>
                        <textarea name="message" rows="3" class="form-control" placeholder="Enter full inquiry or ticket message..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4" style="background-color: #0066ff; border-color: #0066ff;">
                        Create Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. Auto Reply Modal --}}
<div class="modal fade" id="autoReplyModal" tabindex="-1" aria-labelledby="autoReplyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="autoReplyModalLabel">Automated Support Responses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="autoReplySwitch" checked>
                    <label class="form-check-label fw-bold text-dark" for="autoReplySwitch">Enable Instant Auto-Reply for New Inquiries</label>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Welcome & Acknowledgement Message</label>
                    <textarea class="form-control" rows="3">Hello! Thank you for contacting Digital Class Support. We have received your query and a support executive will attend to you within 2 hours.</textarea>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="officeHoursSwitch" checked>
                    <label class="form-check-label fw-bold text-dark" for="officeHoursSwitch">Out-of-Office Response (7:00 PM - 9:00 AM)</label>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-dismiss="modal" onclick="alert('Auto reply settings saved.')">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 3. Support Settings Modal --}}
<div class="modal fade" id="supportSettingsModal" tabindex="-1" aria-labelledby="supportSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="supportSettingsModalLabel">Support Team & SLA Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Target First Response Time (SLA)</label>
                    <select class="form-select">
                        <option value="1">1 Hour</option>
                        <option value="2" selected>2 Hours (Standard)</option>
                        <option value="4">4 Hours</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Default Ticket Assignee</label>
                    <select class="form-select">
                        <option value="Hitesh" selected>Hitesh Mohkar (Super Admin)</option>
                        <option value="Support Team">General Support Team</option>
                    </select>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="emailNotifySwitch" checked>
                    <label class="form-check-label small fw-bold text-dark" for="emailNotifySwitch">Send Email Notification on New Inbound Query</label>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-dismiss="modal" onclick="alert('Support settings updated.')">
                    Save Configuration
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function selectTicket(ticketId) {
        const url = new URL(window.location.href);
        url.searchParams.set('ticket_id', ticketId);
        window.location.href = url.toString();
    }

    function switchMode(mode) {
        const replyBtn = document.getElementById('tabReplyBtn');
        const noteBtn = document.getElementById('tabNoteBtn');
        const internalInput = document.getElementById('isInternalNoteInput');
        const msgInput = document.getElementById('messageInput');

        if (mode === 'note') {
            internalInput.value = '1';
            noteBtn.className = 'btn btn-link text-decoration-none p-0 fw-bold text-warning active-tab-btn';
            replyBtn.className = 'btn btn-link text-decoration-none p-0 text-muted';
            msgInput.placeholder = 'Add internal note visible only to admins and support agents...';
            msgInput.style.backgroundColor = '#fffbeb';
        } else {
            internalInput.value = '0';
            replyBtn.className = 'btn btn-link text-decoration-none p-0 fw-bold text-primary active-tab-btn';
            noteBtn.className = 'btn btn-link text-decoration-none p-0 text-muted';
            msgInput.placeholder = 'Type your message here...';
            msgInput.style.backgroundColor = '#ffffff';
        }
    }

    function insertTemplate(text) {
        const msgInput = document.getElementById('messageInput');
        if (msgInput) {
            msgInput.value = text;
            msgInput.focus();
        }
    }

    // Scroll chat stream to bottom on load
    document.addEventListener('DOMContentLoaded', function() {
        const chatStream = document.getElementById('chatStream');
        if (chatStream) {
            chatStream.scrollTop = chatStream.scrollHeight;
        }
    });
</script>
@endpush
@endsection
