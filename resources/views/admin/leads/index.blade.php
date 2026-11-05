@extends('admin.layouts.admin')

@section('title', 'Marketing & Leads Management - Super Admin')

@section('styles')
<style>
    /* KPI Metric Cards matching screenshot pixel-for-pixel */
    .lead-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        height: 100%;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .lead-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .lead-icon-circle {
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
    .kpi-icon-green   { background: #ecfdf5; color: #059669; }
    .kpi-icon-purple  { background: #f5f3ff; color: #8b5cf6; }
    .kpi-icon-orange  { background: #fff7ed; color: #ea580c; }
    .kpi-icon-red     { background: #fef2f2; color: #dc2626; }

    /* Navigation Filter Tabs */
    .lead-tabs-nav {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .lead-tabs-nav .nav-link {
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
    .lead-tabs-nav .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .lead-tabs-nav .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .lead-tabs-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    /* Analytics Chart Cards */
    .chart-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.15rem;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    /* Funnel Bars */
    .funnel-container {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        justify-content: center;
        height: 190px;
    }
    .funnel-step {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }
    .funnel-bar-wrap {
        flex: 1;
        display: flex;
        justify-content: center;
    }
    .funnel-bar {
        height: 22px;
        border-radius: 4px;
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: width 0.3s ease;
    }

    /* Status Badges */
    .lead-status-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        display: inline-block;
        white-space: nowrap;
    }
    .status-qualified       { background: #dcfce7; color: #15803d; }
    .status-demo-scheduled  { background: #ffedd5; color: #c2410c; }
    .status-new             { background: #e0f2fe; color: #0369a1; }
    .status-contacted       { background: #fef3c7; color: #b45309; }
    .status-not-interested  { background: #fee2e2; color: #b91c1c; }
    .status-converted       { background: #f3e8ff; color: #7e22ce; }
    .status-follow-up       { background: #ccfbf1; color: #0f766e; }

    /* Table Styles */
    .leads-table-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .leads-table-row:hover {
        background-color: #f8fafc !important;
    }
    .leads-table-row.selected-row {
        background-color: #f0f7ff !important;
        outline: 1.5px solid #0066ff;
    }

    /* Right Inspector */
    .lead-inspector-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        position: sticky;
        top: 80px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }

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

    /* Vertical Timeline */
    .lead-timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    .lead-timeline::before {
        content: '';
        position: absolute;
        top: 6px;
        bottom: 6px;
        left: 8px;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-node {
        position: relative;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
    }
    .timeline-dot {
        position: absolute;
        left: -1.5rem;
        top: 2px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.55rem;
        color: #ffffff;
        border: 2px solid #ffffff;
    }
    .dot-purple  { background: #8b5cf6; }
    .dot-success { background: #10b981; }
    .dot-info    { background: #06b6d4; }
    .dot-warning { background: #f59e0b; }
    .dot-danger  { background: #ef4444; }
    .dot-primary { background: #3b82f6; }
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
            <h1 class="h3 fw-bold text-dark mb-1">Marketing & Leads</h1>
            <p class="text-muted small mb-0">Manage marketing campaigns, track leads, analyze performance and convert leads to customers.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- + Create Campaign Button --}}
            <button class="btn btn-primary px-3 py-2 fw-medium shadow-sm" style="background-color: #0066ff; border-color: #0066ff;" data-bs-toggle="modal" data-bs-target="#createCampaignModal">
                <i class="fa-solid fa-plus me-1.5"></i> Create Campaign
            </button>

            {{-- Lead Sources Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#leadSourcesModal">
                <i class="fa-solid fa-list-check me-1.5 text-muted"></i> Lead Sources
            </button>

            {{-- Import Leads Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" onclick="alert('Import leads CSV file.')">
                <i class="fa-solid fa-file-import me-1.5 text-muted"></i> Import Leads
            </button>

            {{-- Export Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-white border bg-white text-secondary dropdown-toggle px-3 py-2 fw-medium shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-arrow-down-to-bracket me-1.5 text-muted"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item py-2" href="{{ route('admin.leads.export', ['format' => 'excel']) }}"><i class="fa-regular fa-file-excel text-success me-2"></i> Download as Excel</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.leads.export', ['format' => 'pdf']) }}"><i class="fa-regular fa-file-pdf text-danger me-2"></i> Download as PDF</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.leads.export', ['format' => 'filtered']) }}"><i class="fa-solid fa-filter text-primary me-2"></i> Download Filtered Data</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- 5 KPI Metric Cards matching screenshot --}}
    <div class="row g-3 mb-4">
        {{-- Total Leads --}}
        <div class="col-xl col-md-4 col-sm-6">
            <div class="lead-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Total Leads</span>
                    <div class="lead-icon-circle kpi-icon-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_leads'] ?? '624' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.72rem;">{{ $stats['leads_growth'] ?? '↑ 28%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['leads_sub'] ?? '+136 this month' }}</span>
            </div>
        </div>

        {{-- Qualified Leads --}}
        <div class="col-xl col-md-4 col-sm-6">
            <div class="lead-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Qualified Leads</span>
                    <div class="lead-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['qualified_leads'] ?? '312' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['qualified_sub'] ?? '50% of total' }}</span>
            </div>
        </div>

        {{-- Demo Scheduled --}}
        <div class="col-xl col-md-4 col-sm-6">
            <div class="lead-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Demo Scheduled</span>
                    <div class="lead-icon-circle kpi-icon-purple">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['demo_scheduled'] ?? '186' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['demo_sub'] ?? '30% of total' }}</span>
            </div>
        </div>

        {{-- Converted --}}
        <div class="col-xl col-md-4 col-sm-6">
            <div class="lead-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Converted</span>
                    <div class="lead-icon-circle kpi-icon-orange">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['converted'] ?? '68' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['converted_sub'] ?? '11% of total' }}</span>
            </div>
        </div>

        {{-- Not Interested --}}
        <div class="col-xl col-md-4 col-sm-6">
            <div class="lead-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Not Interested</span>
                    <div class="lead-icon-circle kpi-icon-red">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['not_interested'] ?? '58' }}</h2>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['not_interested_sub'] ?? '9% of total' }}</span>
            </div>
        </div>
    </div>

    {{-- Analytics Row (3 Chart Cards) matching screenshot --}}
    <div class="row g-3 mb-4">
        {{-- 1. Leads Trend --}}
        <div class="col-lg-4 col-md-12">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0 fs-6">Leads Trend</h6>
                    <select class="form-select form-select-sm text-secondary" style="width: 120px; font-size: 0.75rem;">
                        <option selected>Last 30 Days</option>
                        <option>Last 7 Days</option>
                        <option>This Month</option>
                    </select>
                </div>
                <div style="height: 200px; position: relative;">
                    <canvas id="leadsTrendChart"></canvas>
                </div>
            </div>
        </div>

        {{-- 2. Leads by Source --}}
        <div class="col-lg-4 col-md-12">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0 fs-6">Leads by Source</h6>
                </div>
                <div class="d-flex align-items-center justify-content-between" style="height: 200px;">
                    {{-- Donut with inner count --}}
                    <div style="width: 160px; height: 160px; position: relative;">
                        <canvas id="leadsSourceChart"></canvas>
                        <div class="position-absolute top-50 start-50 translate-middle text-center" style="pointer-events: none;">
                            <div class="fw-bold text-dark" style="font-size: 1.15rem; line-height: 1;">624</div>
                            <div class="text-muted" style="font-size: 0.68rem;">Total Leads</div>
                        </div>
                    </div>

                    {{-- Donut Legend List --}}
                    <div class="flex-grow-1 ps-3" style="font-size: 0.75rem;">
                        @foreach($sourceBreakdown as $sb)
                            <div class="d-flex align-items-center justify-content-between py-1">
                                <div class="d-flex align-items-center gap-1.5">
                                    <span class="rounded-circle" style="width: 8px; height: 8px; background-color: {{ $sb['color'] }};"></span>
                                    <span class="text-secondary">{{ $sb['name'] }}</span>
                                </div>
                                <span class="fw-bold text-dark">{{ $sb['count'] }} <span class="text-muted fw-normal">({{ $sb['percent'] }}%)</span></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Lead Funnel --}}
        <div class="col-lg-4 col-md-12">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0 fs-6">Lead Funnel</h6>
                </div>
                <div class="funnel-container">
                    @foreach($funnel as $fn)
                        <div class="funnel-step">
                            <div class="funnel-bar-wrap">
                                <div class="funnel-bar shadow-sm" style="width: {{ max(40, $fn['percent']) }}%; background-color: {{ $fn['color'] }};">
                                    {{ $fn['stage'] }}
                                </div>
                            </div>
                            <div class="fw-bold text-dark text-end" style="width: 85px; font-size: 0.75rem;">
                                {{ $fn['count'] }} <span class="text-muted fw-normal">({{ $fn['percent'] }}%)</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Status Tabs Row matching screenshot --}}
    <div class="d-flex lead-tabs-nav mb-3 overflow-auto">
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'all'])) }}" class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}">
            All Leads ({{ number_format($counts['all'] ?? 624) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'new'])) }}" class="nav-link {{ $currentTab === 'new' ? 'active' : '' }}">
            New ({{ number_format($counts['new'] ?? 144) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'contacted'])) }}" class="nav-link {{ $currentTab === 'contacted' ? 'active' : '' }}">
            Contacted ({{ number_format($counts['contacted'] ?? 206) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'qualified'])) }}" class="nav-link {{ $currentTab === 'qualified' ? 'active' : '' }}">
            Qualified ({{ number_format($counts['qualified'] ?? 312) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'demo_scheduled'])) }}" class="nav-link {{ $currentTab === 'demo_scheduled' ? 'active' : '' }}">
            Demo Scheduled ({{ number_format($counts['demo_scheduled'] ?? 186) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'converted'])) }}" class="nav-link {{ $currentTab === 'converted' ? 'active' : '' }}">
            Converted ({{ number_format($counts['converted'] ?? 68) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'not_interested'])) }}" class="nav-link {{ $currentTab === 'not_interested' ? 'active' : '' }}">
            Not Interested ({{ number_format($counts['not_interested'] ?? 58) }})
        </a>
        <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['tab' => 'follow_up'])) }}" class="nav-link {{ $currentTab === 'follow_up' ? 'active' : '' }}">
            Follow Up ({{ number_format($counts['follow_up'] ?? 92) }})
        </a>
    </div>

    {{-- Single Row Filter Bar matching screenshot --}}
    <form action="{{ route('admin.leads.index') }}" method="GET" class="card border-0 shadow-sm p-3 mb-4 rounded-3 bg-white">
        <input type="hidden" name="tab" value="{{ $currentTab }}">

        <div class="row g-2 align-items-center">
            {{-- Search input --}}
            <div class="col-lg-3 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3 pe-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-1" placeholder="Search by name, phone, email..." value="{{ $search ?? '' }}">
                </div>
            </div>

            {{-- Lead Source --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="source" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">Lead Source</option>
                    <option value="Meta Ads" {{ ($sourceFilter ?? '') === 'Meta Ads' ? 'selected' : '' }}>Meta Ads</option>
                    <option value="Google Ads" {{ ($sourceFilter ?? '') === 'Google Ads' ? 'selected' : '' }}>Google Ads</option>
                    <option value="Website" {{ ($sourceFilter ?? '') === 'Website' ? 'selected' : '' }}>Website</option>
                    <option value="WhatsApp" {{ ($sourceFilter ?? '') === 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="Referral" {{ ($sourceFilter ?? '') === 'Referral' ? 'selected' : '' }}>Referral</option>
                    <option value="Others" {{ ($sourceFilter ?? '') === 'Others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>

            {{-- Campaign --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="campaign" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">Campaign</option>
                    <option value="Institute ERP" {{ ($campaignFilter ?? '') === 'Institute ERP' ? 'selected' : '' }}>Institute ERP</option>
                    <option value="Website Leads" {{ ($campaignFilter ?? '') === 'Website Leads' ? 'selected' : '' }}>Website Leads</option>
                    <option value="Download Brochure" {{ ($campaignFilter ?? '') === 'Download Brochure' ? 'selected' : '' }}>Download Brochure</option>
                    <option value="Referral" {{ ($campaignFilter ?? '') === 'Referral' ? 'selected' : '' }}>Referral</option>
                    <option value="Diwali Offer" {{ ($campaignFilter ?? '') === 'Diwali Offer' ? 'selected' : '' }}>Diwali Offer</option>
                    <option value="Course Enquiry" {{ ($campaignFilter ?? '') === 'Course Enquiry' ? 'selected' : '' }}>Course Enquiry</option>
                    <option value="App Promotion" {{ ($campaignFilter ?? '') === 'App Promotion' ? 'selected' : '' }}>App Promotion</option>
                    <option value="Partnership" {{ ($campaignFilter ?? '') === 'Partnership' ? 'selected' : '' }}>Partnership</option>
                    <option value="Business Listing" {{ ($campaignFilter ?? '') === 'Business Listing' ? 'selected' : '' }}>Business Listing</option>
                </select>
            </div>

            {{-- Lead Status --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="status" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">Lead Status</option>
                    <option value="New" {{ ($statusFilter ?? '') === 'New' ? 'selected' : '' }}>New</option>
                    <option value="Contacted" {{ ($statusFilter ?? '') === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="Qualified" {{ ($statusFilter ?? '') === 'Qualified' ? 'selected' : '' }}>Qualified</option>
                    <option value="Demo Scheduled" {{ ($statusFilter ?? '') === 'Demo Scheduled' ? 'selected' : '' }}>Demo Scheduled</option>
                    <option value="Converted" {{ ($statusFilter ?? '') === 'Converted' ? 'selected' : '' }}>Converted</option>
                    <option value="Not Interested" {{ ($statusFilter ?? '') === 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
                    <option value="Follow Up" {{ ($statusFilter ?? '') === 'Follow Up' ? 'selected' : '' }}>Follow Up</option>
                </select>
            </div>

            {{-- Assigned To --}}
            <div class="col-lg-1 col-md-3 col-6">
                <select name="assigned_to" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">Assigned To</option>
                    <option value="Manish" {{ ($assignedFilter ?? '') === 'Manish' ? 'selected' : '' }}>Manish</option>
                    <option value="Prakash" {{ ($assignedFilter ?? '') === 'Prakash' ? 'selected' : '' }}>Prakash</option>
                    <option value="Tushar" {{ ($assignedFilter ?? '') === 'Tushar' ? 'selected' : '' }}>Tushar</option>
                </select>
            </div>

            {{-- Date Range & Reset --}}
            <div class="col-lg-2 col-md-6 col-12 d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                    <input type="text" class="form-control border-start-0" value="01 Oct 2026 - 31 Oct 2026" readonly style="font-size: 0.8rem; background-color: #ffffff;">
                </div>
                <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>
    </form>

    {{-- Main Workspace: Table (Left) + Inspector Panel (Right) --}}
    <div class="row g-3">
        {{-- Leads Table Column --}}
        <div class="col-xxl-8 col-xl-7 col-lg-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="leadsTable">
                        <thead class="table-light text-uppercase fw-bold text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-3" style="width: 30px;"><input type="checkbox" class="form-check-input" id="selectAllLeads"></th>
                                <th style="width: 35px;">#</th>
                                <th style="min-width: 130px;">Name</th>
                                <th style="min-width: 115px;">Contact</th>
                                <th style="min-width: 95px;">Source</th>
                                <th style="min-width: 125px;">Campaign</th>
                                <th style="min-width: 110px;">Status</th>
                                <th style="min-width: 85px;">Assigned To</th>
                                <th style="min-width: 125px;">Created At</th>
                                <th style="min-width: 100px;">Next Follow Up</th>
                                <th class="text-end pe-3" style="width: 45px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.82rem;">
                            @forelse($leads as $idx => $lead)
                                @php
                                    $statusSlug = strtolower(str_replace(' ', '-', $lead->status));
                                @endphp
                                <tr class="leads-table-row {{ $idx === 0 ? 'selected-row' : '' }}"
                                    data-lead="{{ json_encode($lead) }}"
                                    onclick="inspectLead(this)">
                                    <td class="ps-3" onclick="event.stopPropagation();">
                                        <input type="checkbox" class="form-check-input lead-checkbox">
                                    </td>
                                    <td class="text-muted fw-semibold">{{ $lead->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $lead->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($lead->name) . '&background=0066ff&color=fff' }}"
                                                 alt="{{ $lead->name }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;">
                                            <span class="fw-bold text-dark">{{ $lead->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted font-monospace" style="font-size: 0.78rem;">
                                        {{ $lead->phone }}
                                    </td>
                                    <td>
                                        <span class="text-secondary fw-medium">{{ $lead->source }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $lead->campaign }}</span>
                                    </td>
                                    <td>
                                        <span class="lead-status-badge status-{{ $statusSlug }}">
                                            {{ $lead->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary fw-semibold">{{ $lead->assigned_to ?: '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $lead->created_at ? $lead->created_at->format('d M Y') : '30 Oct 2026' }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $lead->created_at ? $lead->created_at->format('h:i A') : '10:24 AM' }}</div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium">{{ $lead->next_follow_up ? $lead->next_follow_up->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td class="text-end pe-3" onclick="event.stopPropagation();">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 px-2 text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                                                <li>
                                                    <button class="dropdown-item py-1.5" onclick="inspectLeadById({{ $lead->id }})">
                                                        <i class="fa-regular fa-eye me-2 text-primary"></i> View Details
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item py-1.5 text-success" onclick="openScheduleDemoModal({{ $lead->id }}, '{{ addslashes($lead->name) }}')">
                                                        <i class="fa-regular fa-calendar-check me-2"></i> Schedule Demo
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item py-1.5 text-info" onclick="openStatusModal({{ $lead->id }}, '{{ $lead->status }}')">
                                                        <i class="fa-solid fa-arrows-rotate me-2"></i> Change Status
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Permanently delete lead {{ $lead->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-1.5 text-danger">
                                                            <i class="fa-regular fa-trash-can me-2"></i> Delete Lead
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-bullseye fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                                        <h6>No Leads Found</h6>
                                        <p class="small mb-0">Try adjusting your filters or search query.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer & Pagination matching screenshot --}}
                <div class="card-footer bg-white border-0 px-3 py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
                        Showing <strong>1 to {{ count($leads) }}</strong> of <strong>{{ number_format($counts['all'] ?? 624) }}</strong> leads
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <nav aria-label="Lead pagination">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                <li class="page-item"><a class="page-link" href="#">63</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>

                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <span>Show</span>
                            <select class="form-select form-select-sm" style="width: 70px;">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span>per page</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Inspector Panel Column matching screenshot --}}
        @php
            $firstLead = $activeLead ?? $leads->first() ?? null;
        @endphp
        <div class="col-xxl-4 col-xl-5 col-lg-12">
            <div class="lead-inspector-card shadow-sm" id="leadInspector">
                {{-- Inspector Header --}}
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 fs-6">Lead Details</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary py-0.5 px-2" style="font-size: 0.75rem;" onclick="alert('Edit lead details.')">
                        <i class="fa-solid fa-pen me-1"></i> Edit
                    </button>
                </div>

                {{-- Empty state when no leads present --}}
                <div id="inspectorEmptyState" class="text-center py-5 text-muted" style="{{ $firstLead ? 'display: none;' : '' }}">
                    <i class="fa-solid fa-bullseye fs-1 mb-2 opacity-50"></i>
                    <p class="small mb-0">Select a lead from the list to view detailed profile and activity timeline.</p>
                </div>

                <div id="inspectorContent" style="{{ $firstLead ? '' : 'display: none;' }}">
                    {{-- Profile Header Card matching screenshot --}}
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img id="inspAvatar" src="{{ $firstLead->avatar ?? '' }}" alt="Avatar" class="rounded-circle border" style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-0.5">
                                <h5 class="fw-bold text-dark mb-0 fs-6" id="inspName">{{ $firstLead->name ?? '' }}</h5>
                                <span class="lead-status-badge status-{{ $firstLead ? strtolower(str_replace(' ', '-', $firstLead->status)) : 'qualified' }}" id="inspStatusBadge">
                                    {{ $firstLead->status ?? 'Qualified' }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.75rem;">
                                <span><i class="fa-solid fa-phone me-1"></i> <span id="inspPhone">{{ $firstLead->phone ?? '' }}</span></span>
                                <a href="#" id="inspWhatsAppLink" class="text-success" target="_blank"><i class="fa-brands fa-whatsapp fs-6"></i></a>
                            </div>
                            <div class="text-muted" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-envelope me-1"></i> <span id="inspEmail">{{ $firstLead->email ?? '' }}</span>
                            </div>
                            <div class="text-muted" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-location-dot me-1"></i> <span id="inspCity">{{ $firstLead->city ?? 'Ahmedabad, Gujarat' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Metadata Key-Values matching screenshot --}}
                    <div class="border rounded-3 p-2.5 mb-3 bg-white">
                        <div class="meta-detail-row">
                            <span class="text-muted">Lead Source</span>
                            <span class="fw-semibold text-dark" id="inspSource">{{ $firstLead->source ?? '' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Campaign</span>
                            <span class="fw-semibold text-dark" id="inspCampaign">{{ $firstLead->campaign ?? '' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Platform</span>
                            <span class="fw-semibold text-dark" id="inspPlatform">{{ $firstLead->platform ?? 'Website' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Created At</span>
                            <span class="fw-semibold text-dark" id="inspCreatedAt">{{ $firstLead && $firstLead->created_at ? $firstLead->created_at->format('d M Y, h:i A') : '30 Oct 2026, 10:24 AM' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Assigned To</span>
                            <span class="fw-semibold text-dark" id="inspAssignedTo">{{ $firstLead->assigned_to ?? 'Manish' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Lead Status</span>
                            <span class="fw-bold text-success" id="inspStatusText">{{ $firstLead->status ?? 'Qualified' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Next Follow Up</span>
                            <span class="fw-semibold text-dark" id="inspNextFollowUp">{{ $firstLead && $firstLead->next_follow_up ? $firstLead->next_follow_up->format('d M Y') : '01 Nov 2026' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Interested In</span>
                            <span class="fw-semibold text-dark" id="inspInterestedIn">{{ $firstLead->interested_in ?? 'Institute Management Software' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Budget</span>
                            <span class="fw-semibold text-dark" id="inspBudget">{{ $firstLead->budget ?? '₹10,000 - ₹20,000' }}</span>
                        </div>
                        <div class="meta-detail-row">
                            <span class="text-muted">Remarks</span>
                            <span class="fw-semibold text-dark text-truncate" style="max-width: 170px;" id="inspRemarks">{{ $firstLead->remarks ?? 'Wants demo for 3 branches.' }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons Grid matching screenshot --}}
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <button type="button" class="btn btn-success btn-sm w-100 fw-semibold py-1.5" style="font-size: 0.78rem; background-color: #10b981; border-color: #10b981;" onclick="openScheduleDemoModal(activeLeadData.id, activeLeadData.name)">
                                <i class="fa-regular fa-calendar-check me-1"></i> Schedule Demo
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 fw-semibold py-1.5" style="font-size: 0.78rem;" onclick="window.open('https://wa.me/' + (activeLeadData.phone ? activeLeadData.phone.replace(/[^0-9]/g, '') : ''), '_blank')">
                                <i class="fa-regular fa-paper-plane me-1"></i> Send Message
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-warning btn-sm w-100 fw-semibold py-1.5 text-dark" style="font-size: 0.78rem;" onclick="openNoteModal(activeLeadData.id)">
                                <i class="fa-regular fa-note-sticky me-1"></i> Add Note
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 fw-semibold py-1.5" style="font-size: 0.78rem;" onclick="openStatusModal(activeLeadData.id, activeLeadData.status)">
                                <i class="fa-solid fa-arrows-rotate me-1"></i> Change Status
                            </button>
                        </div>
                    </div>

                    {{-- Activity Timeline matching screenshot --}}
                    <div class="pb-2 mb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted fw-bold" style="font-size: 0.75rem;">Activity Timeline</span>
                            <a href="javascript:void(0)" class="text-primary text-decoration-none" style="font-size: 0.72rem;">View All</a>
                        </div>
                        <div class="lead-timeline" id="inspTimeline">
                            @if($firstLead && !empty($firstLead->activities))
                                @foreach($firstLead->activities as $act)
                                    <div class="timeline-node">
                                        <div class="timeline-dot dot-{{ $act['color'] ?? 'primary' }}">
                                            <i class="fa-solid {{ $act['icon'] ?? 'fa-check' }}"></i>
                                        </div>
                                        <div class="fw-semibold text-dark">{{ $act['action'] }}</div>
                                        <div class="text-muted" style="font-size: 0.68rem;">{{ $act['time'] }}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Notes Section matching screenshot --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted fw-bold" style="font-size: 0.75rem;">Notes</span>
                            <button type="button" class="btn btn-link text-primary text-decoration-none p-0" style="font-size: 0.72rem;" onclick="openNoteModal(activeLeadData.id)">
                                <i class="fa-solid fa-pen me-1"></i> Add Note
                            </button>
                        </div>
                        <div id="inspNotesWrapper">
                            @if($firstLead && !empty($firstLead->notes))
                                @foreach($firstLead->notes as $n)
                                    <div class="border rounded-3 p-2 bg-light mb-1.5">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <img src="{{ $n['avatar'] ?? 'https://ui-avatars.com/api/?name=User&background=0066ff&color=fff' }}" alt="Author" class="rounded-circle" style="width: 22px; height: 22px;">
                                            <span class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $n['author'] }}</span>
                                            <span class="text-muted ms-auto" style="font-size: 0.68rem;">{{ $n['time'] }}</span>
                                        </div>
                                        <div class="text-secondary" style="font-size: 0.75rem; line-height: 1.4;">
                                            {{ $n['content'] }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted small py-2 text-center">No notes added yet.</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODALS --}}

{{-- 1. Create Campaign / Lead Modal --}}
<div class="modal fade" id="createCampaignModal" tabindex="-1" aria-labelledby="createCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="createCampaignModalLabel">Create Campaign / Add Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.leads.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Lead / Contact Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Rahul Patel" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Phone Number *</label>
                            <input type="text" name="phone" class="form-control" placeholder="+91 98765 43210" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="user@gmail.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Lead Source</label>
                            <select name="source" class="form-select">
                                <option value="Meta Ads" selected>Meta Ads</option>
                                <option value="Google Ads">Google Ads</option>
                                <option value="Website">Website</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Referral">Referral</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Campaign Name</label>
                            <input type="text" name="campaign" class="form-control" placeholder="e.g. Institute ERP" value="Institute ERP" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">City / Location</label>
                            <input type="text" name="city" class="form-control" placeholder="Ahmedabad, Gujarat" value="Ahmedabad, Gujarat">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Assigned To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="Manish" selected>Manish</option>
                                <option value="Prakash">Prakash</option>
                                <option value="Tushar">Tushar</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Interested In / Requirement</label>
                        <input type="text" name="interested_in" class="form-control" placeholder="e.g. Institute Management Software">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Remarks</label>
                        <textarea name="remarks" rows="2" class="form-control" placeholder="Notes about inquiry or budget..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4" style="background-color: #0066ff; border-color: #0066ff;">
                        Save Lead
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. Schedule Demo Modal --}}
<div class="modal fade" id="scheduleDemoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Schedule Product Demo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="scheduleDemoForm" method="POST" action="">
                @csrf
                <div class="modal-body py-3">
                    <p class="text-muted small mb-3">Schedule an online demonstration session for <strong id="demoLeadName" class="text-dark"></strong>.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Select Date *</label>
                        <input type="date" name="demo_date" class="form-control" value="{{ now()->addDay()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Select Time Slot *</label>
                        <select name="demo_time" class="form-select" required>
                            <option value="11:00 AM">11:00 AM - 12:00 PM</option>
                            <option value="02:00 PM" selected>02:00 PM - 03:00 PM</option>
                            <option value="04:00 PM">04:00 PM - 05:00 PM</option>
                            <option value="06:00 PM">06:00 PM - 07:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-3 px-4" style="background-color: #10b981; border-color: #10b981;">
                        Confirm Demo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 3. Change Status Modal --}}
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Update Lead Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeStatusForm" method="POST" action="">
                @csrf
                <div class="modal-body py-3">
                    <label class="form-label small fw-bold text-dark">New Status *</label>
                    <select name="status" id="selectNewStatus" class="form-select mb-3">
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Demo Scheduled">Demo Scheduled</option>
                        <option value="Converted">Converted</option>
                        <option value="Not Interested">Not Interested</option>
                        <option value="Follow Up">Follow Up</option>
                    </select>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4" style="background-color: #0066ff; border-color: #0066ff;">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 4. Add Note Modal --}}
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add Internal Lead Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addNoteForm" method="POST" action="">
                @csrf
                <div class="modal-body py-3">
                    <label class="form-label small fw-bold text-dark">Internal Note Content *</label>
                    <textarea name="content" rows="3" class="form-control" placeholder="Write internal team note or client remarks..." required></textarea>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4" style="background-color: #0066ff; border-color: #0066ff;">
                        Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 5. Lead Sources Modal --}}
<div class="modal fade" id="leadSourcesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Configured Inbound Lead Sources</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <ul class="list-group list-group-flush" style="font-size: 0.85rem;">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="fa-brands fa-facebook text-primary me-2"></i> Meta Ads Lead Generation Form</div>
                        <span class="badge bg-success">Active</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="fa-brands fa-google text-danger me-2"></i> Google Search & Display Ads</div>
                        <span class="badge bg-success">Active</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="fa-solid fa-globe text-info me-2"></i> Website Contact & Brochure Forms</div>
                        <span class="badge bg-success">Active</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="fa-brands fa-whatsapp text-success me-2"></i> WhatsApp Click-to-Chat Leads</div>
                        <span class="badge bg-success">Active</span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let activeLeadData = {!! $firstLead ? json_encode($firstLead) : 'null' !!};

    function inspectLead(rowEl) {
        document.querySelectorAll('.leads-table-row').forEach(r => r.classList.remove('selected-row'));
        rowEl.classList.add('selected-row');

        const data = JSON.parse(rowEl.getAttribute('data-lead'));
        populateLeadInspector(data);
    }

    function inspectLeadById(id) {
        const rows = document.querySelectorAll('.leads-table-row');
        for (let r of rows) {
            const data = JSON.parse(r.getAttribute('data-lead'));
            if (data.id === id) {
                inspectLead(r);
                break;
            }
        }
    }

    function populateLeadInspector(data) {
        activeLeadData = data;

        document.getElementById('inspectorContent').style.display = 'block';
        const emptyState = document.getElementById('inspectorEmptyState');
        if (emptyState) emptyState.style.display = 'none';

        // Profile
        document.getElementById('inspAvatar').src = data.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.name) + '&background=0066ff&color=fff';
        document.getElementById('inspName').innerText = data.name;
        document.getElementById('inspPhone').innerText = data.phone;
        document.getElementById('inspEmail').innerText = data.email || 'user@example.com';
        document.getElementById('inspCity').innerText = data.city || 'Ahmedabad, Gujarat';

        const statusSlug = data.status.toLowerCase().replace(/ /g, '-');
        const badge = document.getElementById('inspStatusBadge');
        badge.innerText = data.status;
        badge.className = 'lead-status-badge status-' + statusSlug;

        document.getElementById('inspStatusText').innerText = data.status;
        document.getElementById('inspSource').innerText = data.source;
        document.getElementById('inspCampaign').innerText = data.campaign;
        document.getElementById('inspPlatform').innerText = data.platform || 'Website';
        document.getElementById('inspCreatedAt').innerText = data.created_at ? new Date(data.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', 10:24 AM' : '30 Oct 2026, 10:24 AM';
        document.getElementById('inspAssignedTo').innerText = data.assigned_to || 'Manish';
        document.getElementById('inspNextFollowUp').innerText = data.next_follow_up || '01 Nov 2026';
        document.getElementById('inspInterestedIn').innerText = data.interested_in || 'Institute Management Software';
        document.getElementById('inspBudget').innerText = data.budget || '₹10,000 - ₹20,000';
        document.getElementById('inspRemarks').innerText = data.remarks || 'Wants demo for 3 branches.';

        // WhatsApp link
        const cleanPhone = (data.phone || '').replace(/[^0-9]/g, '');
        document.getElementById('inspWhatsAppLink').href = 'https://wa.me/' + cleanPhone;

        // Timeline
        const timeline = document.getElementById('inspTimeline');
        timeline.innerHTML = '';
        if (data.activities && data.activities.length > 0) {
            data.activities.forEach(act => {
                const node = document.createElement('div');
                node.className = 'timeline-node';
                node.innerHTML = `
                    <div class="timeline-dot dot-${act.color || 'primary'}">
                        <i class="fa-solid ${act.icon || 'fa-check'}"></i>
                    </div>
                    <div class="fw-semibold text-dark">${act.action}</div>
                    <div class="text-muted" style="font-size: 0.68rem;">${act.time}</div>
                `;
                timeline.appendChild(node);
            });
        }

        // Notes
        const notesWrap = document.getElementById('inspNotesWrapper');
        notesWrap.innerHTML = '';
        if (data.notes && data.notes.length > 0) {
            data.notes.forEach(n => {
                const noteCard = document.createElement('div');
                noteCard.className = 'border rounded-3 p-2 bg-light mb-1.5';
                noteCard.innerHTML = `
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <img src="${n.avatar || 'https://ui-avatars.com/api/?name=User&background=0066ff&color=fff'}" alt="Author" class="rounded-circle" style="width: 22px; height: 22px;">
                        <span class="fw-bold text-dark" style="font-size: 0.75rem;">${n.author}</span>
                        <span class="text-muted ms-auto" style="font-size: 0.68rem;">${n.time}</span>
                    </div>
                    <div class="text-secondary" style="font-size: 0.75rem; line-height: 1.4;">${n.content}</div>
                `;
                notesWrap.appendChild(noteCard);
            });
        } else {
            notesWrap.innerHTML = '<div class="text-muted small py-2 text-center">No notes added yet.</div>';
        }
    }

    function openScheduleDemoModal(id, name) {
        document.getElementById('demoLeadName').innerText = name;
        document.getElementById('scheduleDemoForm').action = '/admin/leads/' + id + '/schedule-demo';
        new bootstrap.Modal(document.getElementById('scheduleDemoModal')).show();
    }

    function openStatusModal(id, currentStatus) {
        document.getElementById('selectNewStatus').value = currentStatus;
        document.getElementById('changeStatusForm').action = '/admin/leads/' + id + '/status';
        new bootstrap.Modal(document.getElementById('changeStatusModal')).show();
    }

    function openNoteModal(id) {
        document.getElementById('addNoteForm').action = '/admin/leads/' + id + '/note';
        new bootstrap.Modal(document.getElementById('addNoteModal')).show();
    }

    // Chart.js initialization
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Leads Trend Chart (Line)
        const ctxTrend = document.getElementById('leadsTrendChart');
        if (ctxTrend) {
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: ['1 Oct', '5 Oct', '10 Oct', '15 Oct', '20 Oct', '25 Oct', '31 Oct'],
                    datasets: [{
                        label: 'Leads',
                        data: [22, 28, 48, 42, 60, 46, 75],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#2563eb',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 80,
                            ticks: { stepSize: 20, font: { size: 10 } },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { font: { size: 10 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Leads by Source Chart (Donut)
        const ctxSource = document.getElementById('leadsSourceChart');
        if (ctxSource) {
            new Chart(ctxSource, {
                type: 'doughnut',
                data: {
                    labels: ['Meta Ads', 'Google Ads', 'Website', 'Referral', 'WhatsApp', 'Others'],
                    datasets: [{
                        data: [280, 120, 86, 52, 48, 38],
                        backgroundColor: ['#2563eb', '#06b6d4', '#8b5cf6', '#ec4899', '#10b981', '#f59e0b'],
                        borderWidth: 2,
                        hoverOffset: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // Checkbox select all
        const selectAll = document.getElementById('selectAllLeads');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.lead-checkbox').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
            });
        }
    });
</script>
@endpush
@endsection

