@extends('admin.layouts.admin')

@section('title', 'Users & Members - Super Admin Dashboard')

@section('styles')
<style>
    /* Metric Cards Row */
    .metric-cards-scroll-wrap {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .user-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 0.95rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
    }

    .user-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.4rem;
    }

    .stat-card-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .icon-blue { background: #eff6ff; color: #2563eb; }
    .icon-purple { background: #f3e8ff; color: #9333ea; }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-cyan { background: #e0f2fe; color: #0284c7; }
    .icon-green { background: #f0fdf4; color: #16a34a; }
    .icon-emerald { background: #ecfdf5; color: #059669; }
    .icon-pink { background: #fdf2f8; color: #db2777; }

    .stat-card-title {
        font-size: 0.74rem;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
    }

    .stat-card-num-row {
        display: flex;
        align-items: baseline;
        gap: 0.4rem;
        margin-bottom: 0.15rem;
    }

    .stat-main-number {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-trend-tag {
        font-size: 0.65rem;
        font-weight: 700;
    }

    .trend-up { color: #16a34a; }
    .trend-down { color: #dc2626; }

    .stat-sub-text {
        font-size: 0.68rem;
        color: #94a3b8;
    }

    /* Filter Tabs */
    .user-filter-tabs-bar {
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.15rem;
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
    }

    .user-tab-btn {
        padding: 0.65rem 0.2rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        position: relative;
        white-space: nowrap;
        transition: all 0.2s;
    }

    .user-tab-btn:hover,
    .user-tab-btn.active {
        color: #0066ff;
    }

    .user-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #0066ff;
        border-radius: 999px;
    }

    /* Filter Toolbar */
    .users-filter-toolbar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.65rem;
    }

    .search-user-input-box {
        position: relative;
        flex: 1 1 240px;
    }

    .search-user-input-box input {
        width: 100%;
        padding: 0.4rem 0.75rem 0.4rem 2.1rem;
        font-size: 0.82rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s;
    }

    .search-user-input-box input:focus {
        border-color: #0066ff;
        box-shadow: 0 0 0 2px rgba(0, 102, 255, 0.1);
    }

    .search-user-input-box i {
        position: absolute;
        left: 9px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Main Table & Inspector Split */
    .users-workspace-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.25rem;
        align-items: start;
    }

    .users-table-container {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .users-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.8rem;
    }

    .users-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 0.75rem 0.85rem;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .users-table td {
        padding: 0.75rem 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .user-table-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .user-table-row:hover {
        background-color: #f8fafc;
    }

    .user-table-row.active-row {
        background-color: #eff6ff !important;
    }

    .user-avatar-xs {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Type Badges */
    .badge-type-pill {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .badge-type-student { background: #e0f2fe; color: #0369a1; }
    .badge-type-professional { background: #f3e8ff; color: #7e22ce; }
    .badge-type-institute { background: #eff6ff; color: #1d4ed8; }
    .badge-type-seller { background: #ffedd5; color: #c2410c; }

    /* Status Badges */
    .badge-status-pill {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.18rem 0.5rem;
        border-radius: 6px;
    }

    .badge-status-active { background: #dcfce7; color: #15803d; }
    .badge-status-pending { background: #fef3c7; color: #b45309; }
    .badge-status-inactive { background: #fee2e2; color: #b91c1c; }

    /* Right-side Inspector Panel */
    .user-inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        position: sticky;
        top: 85px;
    }

    .inspector-header {
        padding: 1.15rem 1.15rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .inspector-avatar-box {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .inspector-avatar-img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .inspector-tabs-nav {
        display: flex;
        border-bottom: 1px solid #f1f5f9;
        padding: 0 1.15rem;
        gap: 1rem;
        background: #f8fafc;
    }

    .inspector-tab-link {
        padding: 0.55rem 0.15rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        position: relative;
    }

    .inspector-tab-link.active {
        color: #0066ff;
    }

    .inspector-tab-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #0066ff;
        border-radius: 999px;
    }

    .inspector-body-content {
        padding: 1.15rem;
    }

    .info-field-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.35rem 0;
        font-size: 0.76rem;
    }

    .info-field-row .lbl {
        color: #64748b;
        font-weight: 500;
    }

    .info-field-row .val {
        color: #0f172a;
        font-weight: 600;
        text-align: right;
    }

    .recent-order-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem 0.65rem;
        margin-bottom: 0.45rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.74rem;
    }

    /* Action Buttons in Inspector */
    .inspector-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.45rem;
        margin-top: 1rem;
    }

    .inspector-actions-grid .btn {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.45rem 0.5rem;
        border-radius: 8px;
    }

    /* Dynamic Inspector Components */
    .inspector-tab-pane {
        animation: fadeIn 0.2s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .user-timeline-item {
        position: relative;
        padding-left: 2rem;
        padding-bottom: 1.15rem;
    }
    .user-timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 0.65rem;
        top: 1.4rem;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    .user-timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 1.35rem;
        height: 1.35rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
    }
    .user-order-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.65rem 0.75rem;
        margin-bottom: 0.5rem;
        transition: all 0.15s ease-in-out;
    }
    .user-order-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .user-review-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.65rem 0.75rem;
        margin-bottom: 0.5rem;
    }
    .user-note-card {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 0.6rem 0.75rem;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 1199px) {
        .metric-cards-scroll-wrap {
            grid-template-columns: repeat(4, 1fr);
        }
        .users-workspace-grid {
            grid-template-columns: 1fr;
        }
        .user-inspector-panel {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .metric-cards-scroll-wrap {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')

<!-- ============================================== -->
<!-- PAGE HEADER WITH ACTIONS                       -->
<!-- ============================================== -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Users &amp; Members</h1>
        <p class="text-secondary small mb-0">
            Manage all platform users including students, professionals, businesses and institute representatives.
        </p>
    </div>
    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
        <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-bold" onclick="alert('Import users CSV wizard will open.')">
            <i class="fa-solid fa-download me-1"></i> Import Users
        </button>
        <a href="{{ route('admin.users.export') }}" class="btn btn-outline-secondary btn-sm px-3 fw-bold">
            <i class="fa-solid fa-upload me-1"></i> Export
        </a>
        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fa-solid fa-plus me-1"></i> Add User
        </button>
    </div>
</div>

<!-- ============================================== -->
<!-- 7 METRIC CARDS ROW                             -->
<!-- ============================================== -->
<div class="metric-cards-scroll-wrap">
    <!-- 1. Total Users -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-card-title">Total Users</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['total_users'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> {{ $stats['users_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['users_sub'] }}</div>
    </div>

    <!-- 2. Students -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-purple">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="stat-card-title">Students</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['students'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> {{ $stats['students_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['students_sub'] }}</div>
    </div>

    <!-- 3. Professionals -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-orange">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="stat-card-title">Professionals</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['professionals'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> {{ $stats['professionals_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['professionals_sub'] }}</div>
    </div>

    <!-- 4. Institutes -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-cyan">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div class="stat-card-title">Institutes</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['institutes'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> {{ $stats['institutes_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['institutes_sub'] }}</div>
    </div>

    <!-- 5. Sellers -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-green">
                <i class="fa-solid fa-store"></i>
            </div>
            <div class="stat-card-title">Sellers</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['sellers'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> {{ $stats['sellers_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['sellers_sub'] }}</div>
    </div>

    <!-- 6. Active Users -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-emerald">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-card-title">Active Users</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['active_users'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> {{ $stats['active_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['active_sub'] }}</div>
    </div>

    <!-- 7. Inactive Users -->
    <div class="user-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-pink">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div class="stat-card-title">Inactive Users</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['inactive_users'] }}</span>
            <span class="stat-trend-tag trend-down"><i class="fa-solid fa-arrow-down"></i> {{ $stats['inactive_growth'] }}</span>
        </div>
        <div class="stat-sub-text">{{ $stats['inactive_sub'] }}</div>
    </div>
</div>

<!-- ============================================== -->
<!-- FILTER TABS                                    -->
<!-- ============================================== -->
<div class="user-filter-tabs-bar">
    <a href="{{ route('admin.users.index', ['tab' => 'all']) }}" class="user-tab-btn {{ $currentTab === 'all' ? 'active' : '' }}">
        All Users ({{ $stats['total_users'] }})
    </a>
    <a href="{{ route('admin.users.index', ['tab' => 'students']) }}" class="user-tab-btn {{ $currentTab === 'students' ? 'active' : '' }}">
        Students ({{ $stats['students'] }})
    </a>
    <a href="{{ route('admin.users.index', ['tab' => 'professionals']) }}" class="user-tab-btn {{ $currentTab === 'professionals' ? 'active' : '' }}">
        Professionals ({{ $stats['professionals'] }})
    </a>
    <a href="{{ route('admin.users.index', ['tab' => 'institutes']) }}" class="user-tab-btn {{ $currentTab === 'institutes' ? 'active' : '' }}">
        Institutes ({{ $stats['institutes'] }})
    </a>
    <a href="{{ route('admin.users.index', ['tab' => 'sellers']) }}" class="user-tab-btn {{ $currentTab === 'sellers' ? 'active' : '' }}">
        Sellers ({{ $stats['sellers'] }})
    </a>
    <a href="{{ route('admin.users.index', ['tab' => 'inactive']) }}" class="user-tab-btn {{ $currentTab === 'inactive' ? 'active' : '' }}">
        Inactive ({{ $stats['inactive_users'] }})
    </a>
</div>

<!-- ============================================== -->
<!-- FILTER TOOLBAR                                 -->
<!-- ============================================== -->
<form action="{{ route('admin.users.index') }}" method="GET" class="users-filter-toolbar">
    <input type="hidden" name="tab" value="{{ $currentTab }}">

    <!-- Search Box -->
    <div class="search-user-input-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search by name, email, phone or ID...">
    </div>

    <!-- User Type -->
    <select name="user_type" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
        <option value="All" {{ empty($selectedType) || $selectedType === 'All' ? 'selected' : '' }}>User Type</option>
        <option value="Student" {{ $selectedType === 'Student' ? 'selected' : '' }}>Student</option>
        <option value="Professional" {{ $selectedType === 'Professional' ? 'selected' : '' }}>Professional</option>
        <option value="Institute" {{ $selectedType === 'Institute' ? 'selected' : '' }}>Institute</option>
        <option value="Seller" {{ $selectedType === 'Seller' ? 'selected' : '' }}>Seller</option>
    </select>

    <!-- Status -->
    <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
        <option value="All" {{ empty($selectedStatus) || $selectedStatus === 'All' ? 'selected' : '' }}>Status</option>
        <option value="Active" {{ $selectedStatus === 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Pending" {{ $selectedStatus === 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Inactive" {{ $selectedStatus === 'Inactive' ? 'selected' : '' }}>Inactive</option>
    </select>

    <!-- Location -->
    <select name="location" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
        <option value="All" {{ empty($selectedLoc) || $selectedLoc === 'All' ? 'selected' : '' }}>Location</option>
        <option value="Ahmedabad" {{ $selectedLoc === 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
        <option value="Surat" {{ $selectedLoc === 'Surat' ? 'selected' : '' }}>Surat</option>
        <option value="Mumbai" {{ $selectedLoc === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
        <option value="Bengaluru" {{ $selectedLoc === 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
        <option value="Delhi" {{ $selectedLoc === 'Delhi' ? 'selected' : '' }}>Delhi</option>
        <option value="Pune" {{ $selectedLoc === 'Pune' ? 'selected' : '' }}>Pune</option>
        <option value="Hyderabad" {{ $selectedLoc === 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
    </select>

    <!-- Date Pill -->
    <div class="d-none d-md-flex align-items-center gap-1 bg-light border rounded px-2 py-1 small text-secondary">
        <i class="fa-regular fa-calendar text-primary"></i>
        <span>01 Oct 2026 - 31 Oct 2026</span>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border small px-3">
        Reset
    </a>
</form>

<!-- ============================================== -->
<!-- WORKSPACE: TABLE & USER INSPECTOR PANEL        -->
<!-- ============================================== -->
<div class="users-workspace-grid">

    <!-- LEFT: USERS DATA TABLE -->
    <div class="users-table-container">
        <div class="table-responsive">
            <table class="users-table">
                <thead>
                    <tr>
                        <th style="width: 32px;"><input type="checkbox" class="form-check-input"></th>
                        <th style="width: 36px;">#</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>Joined On</th>
                        <th>Status</th>
                        <th>Orders/Activity</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                        @php
                            $typeClass = match($u['type']) {
                                'Student' => 'badge-type-student',
                                'Professional' => 'badge-type-professional',
                                'Institute' => 'badge-type-institute',
                                default => 'badge-type-seller',
                            };

                            $statusClass = match($u['status']) {
                                'Active' => 'badge-status-active',
                                'Pending' => 'badge-status-pending',
                                default => 'badge-status-inactive',
                            };
                        @endphp
                        <tr class="user-table-row {{ $index === 0 ? 'active-row' : '' }}" 
                            id="rowUser_{{ $u['id'] }}" 
                            onclick="inspectUser({{ json_encode($u) }}, this)">
                            <td onclick="event.stopPropagation();">
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td class="text-muted small">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $u['avatar'] }}" alt="{{ $u['name'] }}" class="user-avatar-xs">
                                    <div>
                                        <div class="fw-bold text-dark fs-7">{{ $u['name'] }}</div>
                                        <div class="text-muted fs-8">ID: {{ $u['code'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-type-pill {{ $typeClass }}">{{ $u['type'] }}</span>
                            </td>
                            <td>
                                <div class="fs-7 text-dark">{{ $u['email'] }}</div>
                                <div class="text-muted fs-8">{{ $u['phone'] }}</div>
                            </td>
                            <td>
                                <div class="fs-7 text-secondary">{{ $u['location'] }}</div>
                            </td>
                            <td>
                                <div class="fs-7 text-dark">{{ $u['joined_date'] }}</div>
                                <div class="text-muted fs-8">({{ $u['joined_ago'] }})</div>
                            </td>
                            <td>
                                <span class="badge-status-pill {{ $statusClass }}">{{ $u['status'] }}</span>
                            </td>
                            <td>
                                <div class="fw-bold fs-7 text-dark">{{ $u['orders_summary'] }}</div>
                                <div class="text-muted fs-8">{{ $u['spent_summary'] }}</div>
                            </td>
                            <td class="text-end" onclick="event.stopPropagation();">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0 py-0 px-2" type="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="inspectUser({{ json_encode($u) }})"><i class="fa-regular fa-eye me-2 text-primary"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="alert('Edit user form will open.')"><i class="fa-regular fa-pen-to-square me-2 text-info"></i> Edit User</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="alert('Message window opened for {{ $u['name'] }}')"><i class="fa-regular fa-message me-2 text-success"></i> Send Message</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirm('Are you sure you want to block {{ $u['name'] }}?')"><i class="fa-solid fa-ban me-2"></i> Block User</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-users-slash fs-2 mb-2 d-block"></i>
                                No users found matching current filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2 small">
            <span class="text-muted">Showing 1 to {{ count($users) }} of {{ $stats['total_users'] }} users</span>
            <div class="d-flex align-items-center gap-2">
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        <li class="page-item active"><span class="page-link">1</span></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item"><a class="page-link" href="#">12,456</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </nav>
                <div class="d-flex align-items-center gap-1 text-muted ms-2">
                    <span>Show</span>
                    <select class="form-select form-select-sm" style="width: 70px;">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>per page</span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: USER INSPECTOR DETAIL PANEL -->
    @php
        $firstUser = $users[0] ?? [
            'id'             => 1,
            'name'           => 'customer 1',
            'code'           => 'UDC00008',
            'status'         => 'Active',
            'type'           => 'Student',
            'joined_date'    => now()->format('d M Y'),
            'joined_ago'     => 'Recently',
            'email'          => 'customer123@gmail.com',
            'phone'          => '8978451236',
            'location'       => 'Ahmedabad, Gujarat',
            'dob'            => '01 Jan 2000',
            'gender'         => 'Unspecified',
            'total_orders'   => 0,
            'total_spent'    => 0,
            'wishlist_count' => 0,
            'avatar'         => 'https://ui-avatars.com/api/?name=customer+1&background=0066ff&color=fff',
            'recent_orders'  => [],
            'all_orders'     => [],
            'activities'     => [],
            'reviews'        => [],
            'notes'          => [],
        ];
    @endphp
    <div class="user-inspector-panel" id="userInspectorBox">
        <div class="inspector-header">
            <div class="inspector-avatar-box">
                <img id="inspAvatar" src="{{ $firstUser['avatar'] }}" alt="{{ $firstUser['name'] }}" class="inspector-avatar-img">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h6 class="fw-bold text-dark mb-0 fs-7" id="inspName">{{ $firstUser['name'] }}</h6>
                        <span class="badge bg-success-subtle text-success fs-8" id="inspStatusBadge">{{ $firstUser['status'] }}</span>
                    </div>
                    <div class="text-muted fs-8" id="inspSubtitle">{{ $firstUser['type'] }} • ID: {{ $firstUser['code'] }}</div>
                    <div class="text-muted fs-8" id="inspJoined">Joined {{ $firstUser['joined_date'] }} ({{ $firstUser['joined_ago'] }})</div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-light border-0 p-1 text-muted" onclick="document.getElementById('userInspectorBox').classList.toggle('d-none')" title="Close Panel">
                <i class="fa-solid fa-xmark fs-6"></i>
            </button>
        </div>

        <!-- Inspector Tabs: 5 Dynamic Working Tabs -->
        <div class="inspector-tabs-nav" id="userInspectorTabsNav">
            <a href="javascript:void(0)" class="inspector-tab-link active" data-tab="overview" onclick="switchInspectorTab('overview', this)">Overview</a>
            <a href="javascript:void(0)" class="inspector-tab-link" data-tab="activity" onclick="switchInspectorTab('activity', this)">Activity</a>
            <a href="javascript:void(0)" class="inspector-tab-link" data-tab="orders" onclick="switchInspectorTab('orders', this)">Orders (<span id="inspTabOrdersCount">{{ count($firstUser['all_orders'] ?? []) }}</span>)</a>
            <a href="javascript:void(0)" class="inspector-tab-link" data-tab="reviews" onclick="switchInspectorTab('reviews', this)">Reviews (<span id="inspTabReviewsCount">{{ count($firstUser['reviews'] ?? []) }}</span>)</a>
            <a href="javascript:void(0)" class="inspector-tab-link" data-tab="notes" onclick="switchInspectorTab('notes', this)">Notes (<span id="inspTabNotesCount">{{ count($firstUser['notes'] ?? []) }}</span>)</a>
        </div>

        <div class="inspector-body-content">
            <!-- TAB 1: OVERVIEW -->
            <div class="inspector-tab-pane" id="inspPane_overview">
                <!-- Basic Information -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark fs-7">Basic Information</span>
                    <button type="button" class="btn btn-sm btn-light border py-0 px-2 fs-8 fw-semibold" onclick="alert('Member profile is in active verified status.')">
                        <i class="fa-solid fa-pen fs-8 me-1"></i> Edit
                    </button>
                </div>

                <div class="border rounded-3 p-2 bg-light mb-3">
                    <div class="info-field-row">
                        <span class="lbl">Full Name</span>
                        <span class="val" id="inspFullName">{{ $firstUser['name'] }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Email</span>
                        <span class="val" id="inspEmail">{{ $firstUser['email'] }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Mobile</span>
                        <span class="val d-flex align-items-center gap-1">
                            <span id="inspPhone">{{ $firstUser['phone'] }}</span>
                            @php
                                $firstPhone = preg_replace('/[^0-9]/', '', $firstUser['phone'] ?? '');
                                if (strlen($firstPhone) === 10) $firstPhone = '91' . $firstPhone;
                            @endphp
                            <a id="inspWhatsAppLink" href="{{ !empty($firstPhone) ? 'https://wa.me/' . $firstPhone : '#' }}" target="_blank" class="text-success" title="Chat on WhatsApp" style="{{ empty($firstPhone) ? 'display: none;' : '' }}">
                                <i class="fa-brands fa-whatsapp fs-6"></i>
                            </a>
                        </span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">User Type</span>
                        <span class="val text-primary" id="inspType">{{ $firstUser['type'] }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Location</span>
                        <span class="val" id="inspLocation">{{ $firstUser['location'] }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Date of Birth</span>
                        <span class="val" id="inspDob">{{ $firstUser['dob'] ?? '01 Jan 2000' }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Gender</span>
                        <span class="val" id="inspGender">{{ $firstUser['gender'] ?? 'Unspecified' }}</span>
                    </div>
                </div>

                <!-- Platform Activity -->
                <div class="fw-bold text-dark fs-7 mb-2">Platform Activity</div>
                <div class="border rounded-3 p-2 bg-light mb-3">
                    <div class="info-field-row">
                        <span class="lbl">Total Orders</span>
                        <span class="val" id="inspTotalOrders">: {{ $firstUser['total_orders'] }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Total Spent</span>
                        <span class="val text-success" id="inspTotalSpent">: ₹{{ number_format((float)$firstUser['total_spent'], 2) }}</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Wishlist</span>
                        <span class="val" id="inspWishlist">: {{ $firstUser['wishlist_count'] }} items</span>
                    </div>
                    <div class="info-field-row">
                        <span class="lbl">Last Active</span>
                        <span class="val" id="inspLastActive">: {{ $firstUser['joined_date'] }} ({{ $firstUser['joined_ago'] }})</span>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark fs-7">Recent Orders</span>
                    <a href="javascript:void(0)" onclick="switchInspectorTab('orders')" class="small text-primary text-decoration-none fw-semibold">View All &rarr;</a>
                </div>

                <div id="inspRecentOrders">
                    @forelse(($firstUser['recent_orders'] ?? []) as $ro)
                        <div class="recent-order-pill">
                            <div>
                                <div class="fw-bold text-dark">{{ $ro['title'] }}</div>
                                <div class="text-muted fs-8">{{ $ro['date'] }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary">{{ $ro['amount'] }}</div>
                                <span class="badge {{ $ro['status'] === 'Completed' || $ro['status'] === 'Confirmed' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} fs-8">
                                    {{ $ro['status'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small p-2 text-center bg-light rounded">No recent orders placed yet.</div>
                    @endforelse
                </div>

                <!-- Quick Actions -->
                <div class="fw-bold text-dark fs-7 mt-3 mb-1">Quick Actions</div>
                <div class="inspector-actions-grid">
                    <button type="button" class="btn btn-outline-success" onclick="alert('Message window opened for ' + (window.currentInspectedUser?.name || 'User'))">
                        <i class="fa-regular fa-message me-1"></i> Message
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="switchInspectorTab('orders')">
                        <i class="fa-regular fa-file-lines me-1"></i> View Orders
                    </button>
                    <button type="button" class="btn btn-outline-warning text-dark" onclick="switchInspectorTab('notes')">
                        <i class="fa-regular fa-note-sticky me-1"></i> Add Note
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="confirm('Are you sure you want to block ' + (window.currentInspectedUser?.name || 'this member') + '?')">
                        <i class="fa-solid fa-ban me-1"></i> Block User
                    </button>
                </div>
            </div>

            <!-- TAB 2: ACTIVITY -->
            <div class="inspector-tab-pane d-none" id="inspPane_activity">
                <div class="d-flex justify-content-between align-items-center mb-2.5">
                    <span class="fw-bold text-dark fs-7">Real-time Activity Timeline</span>
                    <span class="badge bg-light text-secondary border fs-8">Live Feed</span>
                </div>
                <div id="inspActivityTimeline" class="mt-2">
                    @forelse(($firstUser['activities'] ?? []) as $act)
                        <div class="user-timeline-item">
                            <div class="user-timeline-icon {{ $act['bg'] }} {{ $act['color'] }}">
                                <i class="{{ $act['icon'] }}"></i>
                            </div>
                            <div class="fw-bold text-dark fs-7">{{ $act['title'] }}</div>
                            <div class="text-muted fs-8">{{ $act['description'] }}</div>
                            <div class="text-secondary fs-8 mt-0.5"><i class="fa-regular fa-clock me-1"></i>{{ $act['ago'] }} &bull; {{ $act['date'] }}</div>
                        </div>
                    @empty
                        <div class="text-muted small p-3 text-center bg-light rounded">No recorded activity yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 3: ORDERS -->
            <div class="inspector-tab-pane d-none" id="inspPane_orders">
                <div class="d-flex justify-content-between align-items-center mb-2.5">
                    <span class="fw-bold text-dark fs-7">Orders & Purchases (<span id="inspOrdersHeaderCount">{{ count($firstUser['all_orders'] ?? []) }}</span>)</span>
                    <span class="small text-muted fs-8">Real-time Database</span>
                </div>
                <div id="inspAllOrdersList">
                    @forelse(($firstUser['all_orders'] ?? []) as $ord)
                        <div class="user-order-card">
                            <div class="d-flex align-items-center gap-2 mb-1.5">
                                <img src="{{ $ord['thumbnail'] }}" alt="{{ $ord['title'] }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px;" class="border">
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-dark fs-7 text-truncate" title="{{ $ord['title'] }}">{{ $ord['title'] }}</span>
                                        <span class="fw-bold text-primary fs-7">{{ $ord['amount'] }}</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-0.5">
                                        <small class="text-muted fs-8">{{ $ord['order_number'] }} &bull; {{ $ord['type'] }}</small>
                                        <span class="badge bg-{{ $ord['status_badge'] }}-subtle text-{{ $ord['status_badge'] }} fs-8">{{ $ord['status'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-muted fs-8 border-top pt-1 mt-1 d-flex justify-content-between">
                                <span><i class="fa-regular fa-calendar me-1"></i>{{ $ord['date'] }}</span>
                                <span>{{ $ord['ago'] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 bg-light rounded-3 text-muted">
                            <i class="fa-solid fa-cart-shopping fs-2 mb-2 d-block text-secondary opacity-50"></i>
                            <div class="fw-semibold fs-7 text-dark">No orders found</div>
                            <div class="fs-8">This user has not placed or received any orders yet.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 4: REVIEWS -->
            <div class="inspector-tab-pane d-none" id="inspPane_reviews">
                <div class="d-flex justify-content-between align-items-center mb-2.5">
                    <span class="fw-bold text-dark fs-7">Ratings & Reviews (<span id="inspReviewsHeaderCount">{{ count($firstUser['reviews'] ?? []) }}</span>)</span>
                    <span class="small text-muted fs-8">Verified Feedbacks</span>
                </div>
                <div id="inspAllReviewsList">
                    @forelse(($firstUser['reviews'] ?? []) as $rev)
                        <div class="user-review-card">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="text-warning small fs-8">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star{{ $i <= round($rev['rating']) ? '' : '-half-stroke text-muted' }}"></i>
                                    @endfor
                                    <span class="fw-bold text-dark ms-1">{{ number_format($rev['rating'], 1) }}</span>
                                </div>
                                <span class="badge bg-success-subtle text-success fs-8">{{ $rev['status'] }}</span>
                            </div>
                            <div class="fw-bold text-dark fs-7 mb-0.5">{{ $rev['item_title'] }}</div>
                            <p class="text-muted fs-8 mb-1">{{ $rev['text'] }}</p>
                            <div class="text-secondary fs-8"><i class="fa-regular fa-calendar me-1"></i>{{ $rev['date'] }} ({{ $rev['ago'] }})</div>
                        </div>
                    @empty
                        <div class="text-center py-4 bg-light rounded-3 text-muted">
                            <i class="fa-regular fa-star fs-2 mb-2 d-block text-secondary opacity-50"></i>
                            <div class="fw-semibold fs-7 text-dark">No reviews found</div>
                            <div class="fs-8">No ratings or testimonials submitted by this member.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 5: NOTES -->
            <div class="inspector-tab-pane d-none" id="inspPane_notes">
                <div class="d-flex justify-content-between align-items-center mb-2.5">
                    <span class="fw-bold text-dark fs-7">Administrative Notes (<span id="inspNotesHeaderCount">{{ count($firstUser['notes'] ?? []) }}</span>)</span>
                    <span class="badge bg-warning-subtle text-warning-emphasis fs-8">Internal Only</span>
                </div>

                <!-- Add Note Form -->
                <div class="bg-light p-2.5 rounded-3 border mb-3">
                    <label class="form-label fs-8 fw-bold text-dark mb-1">Add Note for this Member</label>
                    <textarea id="inspNewNoteInput" class="form-control form-control-sm mb-2" rows="2" placeholder="e.g. Verified customer address, requested syllabus update..."></textarea>
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-primary px-3 fw-semibold" id="btnSaveAdminNote" onclick="saveAdminNote()">
                            <i class="fa-solid fa-plus me-1"></i> Save Note
                        </button>
                    </div>
                </div>

                <!-- Notes List -->
                <div id="inspAllNotesList">
                    @forelse(($firstUser['notes'] ?? []) as $n)
                        <div class="user-note-card" id="userNoteCard_{{ $n['id'] }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark fs-8"><i class="fa-solid fa-user-shield text-warning me-1"></i>{{ $n['admin_name'] }}</span>
                                <div class="d-flex align-items-center gap-1.5">
                                    <span class="text-muted fs-8">{{ $n['ago'] }}</span>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 border-0" onclick="deleteUserNote({{ $n['id'] }}, this)" title="Delete Note">
                                        <i class="fa-solid fa-trash-can fs-8"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-dark fs-8" style="white-space: pre-line;">{{ $n['note'] }}</div>
                            <div class="text-muted mt-1" style="font-size: 0.68rem;">{{ $n['created_at'] }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 bg-light rounded-3 text-muted" id="inspNoNotesPlaceholder">
                            <i class="fa-regular fa-note-sticky fs-2 mb-2 d-block text-secondary opacity-50"></i>
                            <div class="fw-semibold fs-7 text-dark">No notes added yet</div>
                            <div class="fs-8">Use the field above to record administrative notes.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ============================================== -->
<!-- ADD USER MODAL                                 -->
<!-- ============================================== -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-3 px-4">
                <h5 class="modal-title fw-bold fs-6" id="addUserModalLabel">
                    <i class="fa-solid fa-user-plus me-2"></i> Add New Platform Member
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Full Name *</label>
                        <input type="text" name="name" class="form-control form-control-sm" required placeholder="e.g. Anand Kumar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Email Address *</label>
                        <input type="email" name="email" class="form-control form-control-sm" required placeholder="anand@example.com">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Mobile Number</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="+91 98765 43210">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">User Role *</label>
                            <select name="role" class="form-select form-select-sm" required>
                                <option value="user" selected>Student / Learner</option>
                                <option value="seller">Seller / Institute / Partner</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Temporary Password *</label>
                        <input type="password" name="password" class="form-control form-control-sm" required value="Password@123">
                        <small class="text-muted fs-8">Default is Password@123. User will be asked to change on first login.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold">Create Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.currentInspectedUser = @json($firstUser);

    // Switch between the 5 Inspector Tabs
    function switchInspectorTab(tabName, linkElem) {
        // 1. Update navigation links
        document.querySelectorAll('#userInspectorTabsNav .inspector-tab-link').forEach(link => {
            link.classList.remove('active');
        });

        if (linkElem) {
            linkElem.classList.add('active');
        } else {
            const matchingLink = document.querySelector(`#userInspectorTabsNav .inspector-tab-link[data-tab="${tabName}"]`);
            if (matchingLink) matchingLink.classList.add('active');
        }

        // 2. Hide all tab panes
        document.querySelectorAll('#userInspectorBox .inspector-tab-pane').forEach(pane => {
            pane.classList.add('d-none');
        });

        // 3. Show target pane
        const target = document.getElementById('inspPane_' + tabName);
        if (target) {
            target.classList.remove('d-none');
        }
    }

    // Inspect user when clicked from table or dropdown
    function inspectUser(u, rowElem) {
        if (rowElem) {
            document.querySelectorAll('.user-table-row').forEach(r => r.classList.remove('active-row'));
            rowElem.classList.add('active-row');
        }

        window.currentInspectedUser = u;

        // 1. Header Information
        document.getElementById('inspAvatar').src = u.avatar;
        document.getElementById('inspName').innerText = u.name;
        document.getElementById('inspFullName').innerText = u.name;
        document.getElementById('inspStatusBadge').innerText = u.status;
        document.getElementById('inspSubtitle').innerText = u.type + ' • ID: ' + u.code;
        document.getElementById('inspJoined').innerText = 'Joined ' + u.joined_date + ' (' + u.joined_ago + ')';

        // 2. Overview - Basic Info
        document.getElementById('inspEmail').innerText = u.email;
        document.getElementById('inspPhone').innerText = u.phone;
        
        // Dynamic WhatsApp Link
        const cleanPhone = (u.phone || '').replace(/[^0-9]/g, '');
        const waLink = document.getElementById('inspWhatsAppLink');
        if (waLink) {
            if (cleanPhone && cleanPhone.length >= 10) {
                const formatted = cleanPhone.length === 10 ? '91' + cleanPhone : cleanPhone;
                waLink.href = 'https://wa.me/' + formatted;
                waLink.style.display = 'inline-block';
            } else {
                waLink.style.display = 'none';
            }
        }

        document.getElementById('inspType').innerText = u.type;
        document.getElementById('inspLocation').innerText = u.location;
        document.getElementById('inspDob').innerText = u.dob || '01 Jan 2000';
        document.getElementById('inspGender').innerText = u.gender || 'Unspecified';

        // 3. Overview - Platform Activity
        document.getElementById('inspTotalOrders').innerText = ': ' + (u.total_orders || 0);
        const spentVal = parseFloat(u.total_spent || 0);
        document.getElementById('inspTotalSpent').innerText = ': ₹' + spentVal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('inspWishlist').innerText = ': ' + (u.wishlist_count || 0) + ' items';
        document.getElementById('inspLastActive').innerText = ': ' + u.joined_date + ' (' + u.joined_ago + ')';

        // 4. Overview - Recent Orders Preview
        const recentBox = document.getElementById('inspRecentOrders');
        recentBox.innerHTML = '';
        if (u.recent_orders && u.recent_orders.length > 0) {
            u.recent_orders.forEach(ro => {
                const item = document.createElement('div');
                item.className = 'recent-order-pill';
                const badgeClass = (ro.status === 'Completed' || ro.status === 'Confirmed') ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
                item.innerHTML = `
                    <div class="flex-grow-1 text-truncate me-2">
                        <div class="fw-bold text-dark text-truncate">${ro.title}</div>
                        <div class="text-muted fs-8">${ro.date}</div>
                    </div>
                    <div class="text-end text-nowrap">
                        <div class="fw-bold text-primary">${ro.amount}</div>
                        <span class="badge ${badgeClass} fs-8">${ro.status}</span>
                    </div>
                `;
                recentBox.appendChild(item);
            });
        } else {
            recentBox.innerHTML = '<div class="text-muted small p-2 text-center bg-light rounded">No recent orders placed yet.</div>';
        }

        // 5. Activity Timeline Tab
        const activityBox = document.getElementById('inspActivityTimeline');
        activityBox.innerHTML = '';
        if (u.activities && u.activities.length > 0) {
            u.activities.forEach(act => {
                const actDiv = document.createElement('div');
                actDiv.className = 'user-timeline-item';
                actDiv.innerHTML = `
                    <div class="user-timeline-icon ${act.bg || 'bg-light'} ${act.color || 'text-primary'}">
                        <i class="${act.icon || 'fa-solid fa-clock'}"></i>
                    </div>
                    <div class="fw-bold text-dark fs-7">${act.title}</div>
                    <div class="text-muted fs-8">${act.description}</div>
                    <div class="text-secondary fs-8 mt-0.5"><i class="fa-regular fa-clock me-1"></i>${act.ago} &bull; ${act.date}</div>
                `;
                activityBox.appendChild(actDiv);
            });
        } else {
            activityBox.innerHTML = '<div class="text-muted small p-3 text-center bg-light rounded">No recorded activity yet.</div>';
        }

        // 6. Orders History Tab
        const ordersBox = document.getElementById('inspAllOrdersList');
        const ordersCount = u.all_orders ? u.all_orders.length : 0;
        document.getElementById('inspTabOrdersCount').innerText = ordersCount;
        const ordHeader = document.getElementById('inspOrdersHeaderCount');
        if (ordHeader) ordHeader.innerText = ordersCount;

        ordersBox.innerHTML = '';
        if (ordersCount > 0) {
            u.all_orders.forEach(ord => {
                const card = document.createElement('div');
                card.className = 'user-order-card';
                card.innerHTML = `
                    <div class="d-flex align-items-center gap-2 mb-1.5">
                        <img src="${ord.thumbnail}" alt="${ord.title}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px;" class="border" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80'">
                        <div class="flex-grow-1" style="min-width: 0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold text-dark fs-7 text-truncate" title="${ord.title}">${ord.title}</span>
                                <span class="fw-bold text-primary fs-7">${ord.amount}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-0.5">
                                <small class="text-muted fs-8">${ord.order_number} &bull; ${ord.type}</small>
                                <span class="badge bg-${ord.status_badge}-subtle text-${ord.status_badge} fs-8">${ord.status}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-muted fs-8 border-top pt-1 mt-1 d-flex justify-content-between">
                        <span><i class="fa-regular fa-calendar me-1"></i>${ord.date} ${ord.time ? '&bull; ' + ord.time : ''}</span>
                        <span>${ord.ago}</span>
                    </div>
                `;
                ordersBox.appendChild(card);
            });
        } else {
            ordersBox.innerHTML = `
                <div class="text-center py-4 bg-light rounded-3 text-muted">
                    <i class="fa-solid fa-cart-shopping fs-2 mb-2 d-block text-secondary opacity-50"></i>
                    <div class="fw-semibold fs-7 text-dark">No orders found</div>
                    <div class="fs-8">This user has not placed or received any orders yet.</div>
                </div>
            `;
        }

        // 7. Reviews Tab
        const reviewsBox = document.getElementById('inspAllReviewsList');
        const reviewsCount = u.reviews ? u.reviews.length : 0;
        document.getElementById('inspTabReviewsCount').innerText = reviewsCount;
        const revHeader = document.getElementById('inspReviewsHeaderCount');
        if (revHeader) revHeader.innerText = reviewsCount;

        reviewsBox.innerHTML = '';
        if (reviewsCount > 0) {
            u.reviews.forEach(rev => {
                const card = document.createElement('div');
                card.className = 'user-review-card';
                let stars = '';
                const rInt = Math.round(rev.rating || 5);
                for (let i = 1; i <= 5; i++) {
                    stars += `<i class="fa-solid fa-star${i <= rInt ? '' : '-half-stroke text-muted'}"></i>`;
                }
                card.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="text-warning small fs-8">
                            ${stars}
                            <span class="fw-bold text-dark ms-1">${parseFloat(rev.rating).toFixed(1)}</span>
                        </div>
                        <span class="badge bg-success-subtle text-success fs-8">${rev.status}</span>
                    </div>
                    <div class="fw-bold text-dark fs-7 mb-0.5">${rev.item_title}</div>
                    <p class="text-muted fs-8 mb-1">${rev.text}</p>
                    <div class="text-secondary fs-8"><i class="fa-regular fa-calendar me-1"></i>${rev.date} (${rev.ago})</div>
                `;
                reviewsBox.appendChild(card);
            });
        } else {
            reviewsBox.innerHTML = `
                <div class="text-center py-4 bg-light rounded-3 text-muted">
                    <i class="fa-regular fa-star fs-2 mb-2 d-block text-secondary opacity-50"></i>
                    <div class="fw-semibold fs-7 text-dark">No reviews found</div>
                    <div class="fs-8">No ratings or testimonials submitted by this member.</div>
                </div>
            `;
        }

        // 8. Notes Tab
        renderUserNotesList(u.notes || []);

        // Show inspector panel if closed
        document.getElementById('userInspectorBox').classList.remove('d-none');
    }

    // Helper: Render Notes List
    function renderUserNotesList(notes) {
        const notesBox = document.getElementById('inspAllNotesList');
        const count = notes ? notes.length : 0;
        document.getElementById('inspTabNotesCount').innerText = count;
        const nHeader = document.getElementById('inspNotesHeaderCount');
        if (nHeader) nHeader.innerText = count;

        notesBox.innerHTML = '';
        if (count > 0) {
            notes.forEach(n => {
                const card = document.createElement('div');
                card.className = 'user-note-card';
                card.id = 'userNoteCard_' + n.id;
                card.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark fs-8"><i class="fa-solid fa-user-shield text-warning me-1"></i>${n.admin_name}</span>
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="text-muted fs-8">${n.ago}</span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 border-0" onclick="deleteUserNote(${n.id}, this)" title="Delete Note">
                                <i class="fa-solid fa-trash-can fs-8"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-dark fs-8" style="white-space: pre-line;">${escapeHtml(n.note)}</div>
                    <div class="text-muted mt-1" style="font-size: 0.68rem;">${n.created_at}</div>
                `;
                notesBox.appendChild(card);
            });
        } else {
            notesBox.innerHTML = `
                <div class="text-center py-4 bg-light rounded-3 text-muted" id="inspNoNotesPlaceholder">
                    <i class="fa-regular fa-note-sticky fs-2 mb-2 d-block text-secondary opacity-50"></i>
                    <div class="fw-semibold fs-7 text-dark">No notes added yet</div>
                    <div class="fs-8">Use the field above to record administrative notes.</div>
                </div>
            `;
        }
    }

    // Save Admin Note dynamically via AJAX
    async function saveAdminNote() {
        if (!window.currentInspectedUser || !window.currentInspectedUser.id) {
            alert('Please select a member first.');
            return;
        }

        const input = document.getElementById('inspNewNoteInput');
        const noteText = input.value.trim();
        if (!noteText) {
            input.focus();
            return;
        }

        const btn = document.getElementById('btnSaveAdminNote');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch(`{{ url('admin/users') }}/${window.currentInspectedUser.id}/note`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ note: noteText })
            });

            const data = await res.json();
            if (data.success && data.note) {
                input.value = '';
                if (!window.currentInspectedUser.notes) window.currentInspectedUser.notes = [];
                window.currentInspectedUser.notes.unshift(data.note);
                renderUserNotesList(window.currentInspectedUser.notes);
            } else {
                alert(data.message || 'Failed to save note.');
            }
        } catch (err) {
            alert('Network error while saving note.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-plus me-1"></i> Save Note';
        }
    }

    // Delete Admin Note dynamically via AJAX
    async function deleteUserNote(noteId, btnElem) {
        if (!confirm('Are you sure you want to delete this administrative note?')) return;

        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch(`{{ url('admin/users/notes') }}/${noteId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                }
            });

            const data = await res.json();
            if (data.success) {
                const card = document.getElementById('userNoteCard_' + noteId);
                if (card) card.remove();

                if (window.currentInspectedUser && window.currentInspectedUser.notes) {
                    window.currentInspectedUser.notes = window.currentInspectedUser.notes.filter(n => n.id !== noteId);
                    renderUserNotesList(window.currentInspectedUser.notes);
                }
            } else {
                alert(data.message || 'Failed to delete note.');
            }
        } catch (err) {
            alert('Error deleting note.');
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
@endsection

