@extends('admin.layouts.admin')

@section('title', 'Notifications - Digital Class Super Admin')

@section('content')
<div class="container-fluid px-3 px-xl-4 py-3">

    <!-- Flash message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2.5 px-3 mb-3 d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2 fs-6"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Title & Top CTA -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Notifications</h1>
            <p class="text-muted small mb-0">Send and manage notifications to users, institutes, sellers and other members across web and mobile app.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.notifications.export') }}" class="btn btn-sm btn-outline-secondary rounded-3 bg-white text-dark fw-semibold px-3 py-2">
                <i class="fa-solid fa-download me-1 text-muted"></i> Export
            </a>
            <button type="button" class="btn btn-sm btn-primary rounded-3 fw-semibold px-3 py-2" onclick="document.getElementById('notifTitleInput').focus(); document.getElementById('createNotificationCard').scrollIntoView({behavior: 'smooth'});">
                <i class="fa-solid fa-plus me-1.5"></i> Create Notification
            </button>
        </div>
    </div>

    <!-- 5 KPI Cards Row -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Sent -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-paper-plane fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['sent_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Sent</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['total_sent'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['sent_sub'] }}</div>
            </div>
        </div>

        <!-- 2. Total Recipients -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eff6ff; color: #3b82f6;">
                        <i class="fa-solid fa-users fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['recipients_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Recipients</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['total_recipients'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['recipients_sub'] }}</div>
            </div>
        </div>

        <!-- 3. Opened -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-eye fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Opened</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['opened'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['opened_rate'] }}</div>
            </div>
        </div>

        <!-- 4. Clicked -->
        <div class="col-xl col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fff7ed; color: #f97316;">
                        <i class="fa-solid fa-hand-pointer fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Clicked</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['clicked'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['click_rate'] }}</div>
            </div>
        </div>

        <!-- 5. Scheduled -->
        <div class="col-xl col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; color: #ef4444;">
                        <i class="fa-solid fa-clock fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Scheduled</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['scheduled'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['scheduled_sub'] }}</div>
            </div>
        </div>
    </div>

    <!-- Main 2-Column Content Layout -->
    <div class="row g-4">
        <!-- LEFT COLUMN: Table, Status Tabs & Filters (8 Columns) -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <!-- Status Tabs Bar -->
                <div class="px-3 pt-3 border-bottom d-flex align-items-center gap-1 overflow-auto scrollbar-none" style="scrollbar-width: none;">
                    <a href="{{ route('admin.notifications.index', ['tab' => 'all']) }}" 
                       class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small {{ $tab === 'all' ? 'active-tab' : 'text-muted' }}">
                        All Notifications ({{ $allCount }})
                    </a>
                    <a href="{{ route('admin.notifications.index', ['tab' => 'sent']) }}" 
                       class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small {{ $tab === 'sent' ? 'active-tab' : 'text-muted' }}">
                        Sent ({{ $sentCount }})
                    </a>
                    <a href="{{ route('admin.notifications.index', ['tab' => 'scheduled']) }}" 
                       class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small {{ $tab === 'scheduled' ? 'active-tab' : 'text-muted' }}">
                        Scheduled ({{ $scheduledCount }})
                    </a>
                    <a href="{{ route('admin.notifications.index', ['tab' => 'drafts']) }}" 
                       class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small {{ $tab === 'drafts' ? 'active-tab' : 'text-muted' }}">
                        Drafts ({{ $draftsCount }})
                    </a>
                    <a href="{{ route('admin.notifications.index', ['tab' => 'failed']) }}" 
                       class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small {{ $tab === 'failed' ? 'active-tab' : 'text-muted' }}">
                        Failed ({{ $failedCount }})
                    </a>
                </div>

                <!-- 1-Row Filter Bar -->
                <div class="p-3 border-bottom bg-white">
                    <form action="{{ route('admin.notifications.index') }}" method="GET" class="row g-2 align-items-center">
                        <input type="hidden" name="tab" value="{{ $tab }}">

                        <!-- Search -->
                        <div class="col-lg-3 col-md-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" name="search" value="{{ $search }}" class="form-control bg-light border-start-0" placeholder="Search by title, message or campaign...">
                            </div>
                        </div>

                        <!-- All Types -->
                        <div class="col-lg-2 col-md-3 col-6">
                            <select name="type" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="Promotion" {{ $type === 'Promotion' ? 'selected' : '' }}>Promotion</option>
                                <option value="Course" {{ $type === 'Course' ? 'selected' : '' }}>Course</option>
                                <option value="System" {{ $type === 'System' ? 'selected' : '' }}>System</option>
                                <option value="Update" {{ $type === 'Update' ? 'selected' : '' }}>Update</option>
                                <option value="Reminder" {{ $type === 'Reminder' ? 'selected' : '' }}>Reminder</option>
                                <option value="Welcome" {{ $type === 'Welcome' ? 'selected' : '' }}>Welcome</option>
                                <option value="Engagement" {{ $type === 'Engagement' ? 'selected' : '' }}>Engagement</option>
                                <option value="Product" {{ $type === 'Product' ? 'selected' : '' }}>Product</option>
                                <option value="Event" {{ $type === 'Event' ? 'selected' : '' }}>Event</option>
                            </select>
                        </div>

                        <!-- All Audience -->
                        <div class="col-lg-2 col-md-3 col-6">
                            <select name="audience" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                                <option value="">All Audience</option>
                                <option value="All Users" {{ $audience === 'All Users' ? 'selected' : '' }}>All Users</option>
                                <option value="Students" {{ $audience === 'Students' ? 'selected' : '' }}>Students</option>
                                <option value="Sellers" {{ $audience === 'Sellers' ? 'selected' : '' }}>Sellers</option>
                                <option value="Institutes" {{ $audience === 'Institutes' ? 'selected' : '' }}>Institutes</option>
                                <option value="Registered Users" {{ $audience === 'Registered Users' ? 'selected' : '' }}>Registered Users</option>
                            </select>
                        </div>

                        <!-- All Status -->
                        <div class="col-lg-1 col-md-3 col-6">
                            <select name="status" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="Sent" {{ $status === 'Sent' ? 'selected' : '' }}>Sent</option>
                                <option value="Scheduled" {{ $status === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="Draft" {{ $status === 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Failed" {{ $status === 'Failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <!-- All Platforms -->
                        <div class="col-lg-1 col-md-3 col-6">
                            <select name="platform" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                                <option value="">All Platforms</option>
                                <option value="Website" {{ $platform === 'Website' ? 'selected' : '' }}>Website</option>
                                <option value="Android App" {{ $platform === 'Android App' ? 'selected' : '' }}>Android</option>
                                <option value="iOS App" {{ $platform === 'iOS App' ? 'selected' : '' }}>iOS App</option>
                                <option value="Email" {{ $platform === 'Email' ? 'selected' : '' }}>Email</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="col-lg-2 col-md-4 col-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                                <input type="text" name="date_range" value="{{ $dateRange }}" class="form-control bg-light border-start-0" placeholder="01 Oct 2026 - 31 Oct 2026">
                            </div>
                        </div>

                        <!-- Reset -->
                        <div class="col-lg-1 col-md-2 col-4 text-end">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-light text-muted w-100 fw-semibold">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Notifications Data Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 notif-table">
                        <thead class="bg-light table-light border-bottom text-muted small fw-semibold">
                            <tr>
                                <th style="width: 32px;" class="ps-3"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th style="width: 36px;">#</th>
                                <th>Title & Message</th>
                                <th style="width: 90px;">Type</th>
                                <th style="width: 120px;">Audience</th>
                                <th style="width: 100px;">Platform</th>
                                <th style="width: 85px;">Status</th>
                                <th style="width: 110px;">Sent / Scheduled</th>
                                <th style="width: 45px;" class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $index => $item)
                            <tr>
                                <td class="ps-3"><input type="checkbox" class="form-check-input row-chk"></td>
                                <td class="text-muted small fw-semibold">{{ ($notifications->currentPage() - 1) * $notifications->perPage() + $index + 1 }}</td>
                                
                                <!-- Title & Message with Thumbnail / Icon -->
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="flex-shrink-0">
                                            @if($item->type === 'Promotion')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                                                    <i class="fa-solid fa-gift fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'Course')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
                                                    <i class="fa-solid fa-graduation-cap fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'System')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                                                    <i class="fa-solid fa-wrench fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'Update')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                                    <i class="fa-solid fa-envelope fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'Reminder')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);">
                                                    <i class="fa-solid fa-circle-check fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'Welcome')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                                    <i class="fa-solid fa-user-plus fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'Engagement')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                                    <i class="fa-solid fa-star fs-6"></i>
                                                </div>
                                            @elseif($item->type === 'Product')
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                                                    <i class="fa-solid fa-bell fs-6"></i>
                                                </div>
                                            @else
                                                <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 38px; height: 38px; background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);">
                                                    <i class="fa-solid fa-calendar-days fs-6"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="overflow-hidden" style="max-width: 250px;">
                                            <div class="fw-bold text-dark text-truncate small" title="{{ $item->title }}">{{ $item->title }}</div>
                                            <div class="text-muted text-truncate" style="font-size: 0.73rem;" title="{{ $item->message }}">{{ $item->message }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Type Badge -->
                                <td>
                                    @php
                                        $typeStyles = [
                                            'Promotion'  => 'background-color: #fef2f2; color: #dc2626;',
                                            'Course'     => 'background-color: #f5f3ff; color: #7c3aed;',
                                            'System'     => 'background-color: #f0f9ff; color: #0284c7;',
                                            'Update'     => 'background-color: #ecfdf5; color: #059669;',
                                            'Reminder'   => 'background-color: #fffbeb; color: #d97706;',
                                            'Welcome'    => 'background-color: #eff6ff; color: #2563eb;',
                                            'Engagement' => 'background-color: #faf5ff; color: #9333ea;',
                                            'Product'    => 'background-color: #ecfeff; color: #0891b2;',
                                            'Event'      => 'background-color: #fdf2f8; color: #db2777;',
                                        ];
                                        $style = $typeStyles[$item->type] ?? 'background-color: #f1f5f9; color: #475569;';
                                    @endphp
                                    <span class="badge rounded-pill fw-semibold small" style="{{ $style }}; font-size: 0.7rem; padding: 0.35rem 0.65rem;">
                                        {{ $item->type }}
                                    </span>
                                </td>

                                <!-- Audience -->
                                <td>
                                    <div class="small fw-semibold text-dark">{{ $item->audience }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">({{ number_format($item->audience_count ?: $item->recipients_count) }})</div>
                                </td>

                                <!-- Platforms Icons -->
                                <td>
                                    <div class="d-flex align-items-center gap-1.5 text-muted">
                                        @php $platforms = (array) $item->platforms; @endphp
                                        @if(in_array('Website', $platforms))
                                            <span title="Website"><i class="fa-solid fa-globe text-primary" style="font-size: 0.9rem;"></i></span>
                                        @endif
                                        @if(in_array('Android App', $platforms))
                                            <span title="Android App"><i class="fa-brands fa-android text-success" style="font-size: 0.95rem;"></i></span>
                                        @endif
                                        @if(in_array('iOS App', $platforms))
                                            <span title="iOS App"><i class="fa-brands fa-apple text-dark" style="font-size: 0.95rem;"></i></span>
                                        @endif
                                        @if(in_array('Email', $platforms))
                                            <span title="Email"><i class="fa-solid fa-envelope text-info" style="font-size: 0.85rem;"></i></span>
                                        @endif
                                        @if(in_array('WhatsApp', $platforms))
                                            <span title="WhatsApp"><i class="fa-brands fa-whatsapp text-success" style="font-size: 0.95rem;"></i></span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td>
                                    @if($item->status === 'Sent')
                                        <span class="badge bg-success-subtle text-success rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Sent</span>
                                    @elseif($item->status === 'Scheduled')
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Scheduled</span>
                                    @elseif($item->status === 'Draft')
                                        <span class="badge bg-light text-muted border rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Draft</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Failed</span>
                                    @endif
                                </td>

                                <!-- Sent / Scheduled -->
                                <td>
                                    @if($item->status === 'Sent' && $item->sent_at)
                                        <div class="small fw-medium text-dark">{{ $item->sent_at->format('d M Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $item->sent_at->format('h:i A') }}</div>
                                    @elseif($item->status === 'Scheduled' && $item->scheduled_at)
                                        <div class="small fw-medium text-dark">{{ $item->scheduled_at->format('d M Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $item->scheduled_at->format('h:i A') }}</div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <!-- Actions Dropdown -->
                                <td class="text-end pe-3">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-2 text-muted border-0 p-1" type="button" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small rounded-3">
                                            <li>
                                                <form action="{{ route('admin.notifications.resend', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-1.5"><i class="fa-solid fa-share me-2 text-primary"></i> Resend</button>
                                                </form>
                                            </li>
                                            <li>
                                                <button class="dropdown-item py-1.5" onclick="populateEdit('{{ addslashes($item->title) }}', '{{ addslashes($item->message) }}', '{{ $item->type }}', '{{ $item->audience }}')">
                                                    <i class="fa-regular fa-copy me-2 text-info"></i> Duplicate
                                                </button>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('admin.notifications.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this notification?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-1.5 text-danger"><i class="fa-regular fa-trash-can me-2"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted small">
                                    <i class="fa-regular fa-bell-slash fs-3 mb-2 d-block text-secondary"></i>
                                    No notifications found matching your criteria.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="p-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="text-muted small">
                        Showing {{ $notifications->firstItem() ?? 0 }} to {{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }} notifications
                    </div>
                    <div>
                        {{ $notifications->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Create New Notification Studio (4 Columns) -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" id="createNotificationCard">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h6 fw-bold text-dark mb-0">Create New Notification</h2>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.notifications.store') }}" method="POST" id="createNotifForm">
                    @csrf
                    <input type="hidden" name="action_type" id="formActionType" value="send">
                    <input type="hidden" name="image_url" id="formImageUrl" value="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=400&q=80">

                    <!-- Channel Pills -->
                    <div class="btn-group w-100 mb-3" role="group">
                        <input type="radio" class="btn-check" name="channel" id="chanPush" value="Push Notification" checked>
                        <label class="btn btn-outline-primary btn-sm fw-semibold rounded-start-3" for="chanPush">Push Notification</label>

                        <input type="radio" class="btn-check" name="channel" id="chanInApp" value="In-App">
                        <label class="btn btn-outline-primary btn-sm fw-semibold" for="chanInApp">In-App</label>

                        <input type="radio" class="btn-check" name="channel" id="chanEmail" value="Email">
                        <label class="btn btn-outline-primary btn-sm fw-semibold" for="chanEmail">Email</label>

                        <input type="radio" class="btn-check" name="channel" id="chanSMS" value="SMS">
                        <label class="btn btn-outline-primary btn-sm fw-semibold rounded-end-3" for="chanSMS">SMS</label>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Title <span class="text-danger">*</span></label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="titleCharCount">20/100</span>
                        </div>
                        <input type="text" name="title" id="notifTitleInput" value="Diwali Offer is Live!" maxlength="100" required class="form-control form-control-sm bg-light" placeholder="e.g. Diwali Offer is Live!">
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Message <span class="text-danger">*</span></label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="msgCharCount">56/300</span>
                        </div>
                        <textarea name="message" id="notifMsgInput" rows="3" maxlength="300" required class="form-control bg-light" placeholder="Enter notification message copy...">Get 50% OFF on all Online Courses. Use Code DIWALI50 now!</textarea>
                    </div>

                    <!-- Notification Type & Target Audience -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Notification Type <i class="fa-regular fa-circle-question text-muted ms-0.5"></i></label>
                            <select name="type" id="notifTypeSelect" class="form-select form-select-sm bg-light">
                                <option value="Promotion" selected>Promotion</option>
                                <option value="Course">Course</option>
                                <option value="System">System</option>
                                <option value="Update">Update</option>
                                <option value="Reminder">Reminder</option>
                                <option value="Welcome">Welcome</option>
                                <option value="Engagement">Engagement</option>
                                <option value="Product">Product</option>
                                <option value="Event">Event</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Target Audience <i class="fa-regular fa-circle-question text-muted ms-0.5"></i></label>
                            <select name="audience" id="notifAudienceSelect" class="form-select form-select-sm bg-light">
                                <option value="All Users" selected>All Users</option>
                                <option value="Students">Students</option>
                                <option value="Sellers">Sellers</option>
                                <option value="Institutes">Institutes</option>
                                <option value="Registered Users">Registered Users</option>
                            </select>
                        </div>
                    </div>

                    <!-- Platform Checkboxes -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1.5">Platform</label>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="platforms[]" value="Website" id="platWeb" checked>
                                <label class="form-check-label small" for="platWeb">Website</label>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="platforms[]" value="Android App" id="platAndroid" checked>
                                <label class="form-check-label small" for="platAndroid">Android App</label>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="platforms[]" value="iOS App" id="platIOS" checked>
                                <label class="form-check-label small" for="platIOS">iOS App</label>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="platforms[]" value="Email" id="platEmail">
                                <label class="form-check-label small" for="platEmail">Email</label>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule (Optional) -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Schedule (Optional)</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="schedule_opt" id="schedNow" value="now" checked onchange="toggleScheduleRow(false)">
                                <label class="form-check-label small" for="schedNow">Send Now</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="schedule_opt" id="schedLater" value="later" onchange="toggleScheduleRow(true)">
                                <label class="form-check-label small" for="schedLater">Schedule for Later</label>
                            </div>
                        </div>
                        <div class="row g-2" id="scheduleInputsRow" style="display: none;">
                            <div class="col-7">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-calendar"></i></span>
                                    <input type="date" name="sched_date" value="2026-10-30" class="form-control bg-light">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-clock"></i></span>
                                    <input type="time" name="sched_time" value="10:00" class="form-control bg-light">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image / Banner (Optional) -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Image / Banner (Optional)</label>
                        <div class="d-flex align-items-center gap-2.5 p-2 rounded-3 border bg-light">
                            <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=120&q=80" alt="Banner Preview" id="bannerThumbPreview" class="rounded-2 object-fit-cover flex-shrink-0" style="width: 54px; height: 38px;">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 rounded-2 small" onclick="changeImagePrompt()">
                                        <i class="fa-solid fa-arrows-rotate me-1"></i> Change Image
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-danger py-0.5 px-2 rounded-2 small" onclick="removeImage()">
                                        <i class="fa-regular fa-trash-can me-1"></i> Remove
                                    </button>
                                </div>
                                <div class="text-muted" style="font-size: 0.68rem;">Recommended size: 1200 x 630 px (JPG/PNG)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Simulated Preview Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small fw-bold text-dark">Preview</span>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-xs btn-primary py-0.5 px-2 rounded-pill small" id="prevTabApp" onclick="switchPreviewTab('app')">App Notification</button>
                                <button type="button" class="btn btn-xs btn-light text-muted py-0.5 px-2 rounded-pill small" id="prevTabEmail" onclick="switchPreviewTab('email')">Email Preview</button>
                                <button type="button" class="btn btn-xs btn-light text-muted py-0.5 px-2 rounded-pill small" id="prevTabInApp" onclick="switchPreviewTab('inapp')">In-App</button>
                            </div>
                        </div>

                        <!-- Device App Notification Card Preview -->
                        <div class="p-3 rounded-3 border shadow-xs bg-white position-relative" id="devicePreviewBox">
                            <div class="d-flex align-items-start justify-content-between mb-1.5">
                                <div class="d-flex align-items-center gap-1.5">
                                    <span class="badge bg-dark text-white rounded-2 px-1.5 py-0.5 fw-bold" style="font-size: 0.65rem;">DC</span>
                                    <span class="fw-bold text-dark small" style="font-size: 0.78rem;">Digital Class</span>
                                </div>
                                <span class="text-muted" style="font-size: 0.7rem;">now</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark small text-truncate" id="previewTitleDisplay">Diwali Offer is Live!</div>
                                    <div class="text-muted small line-clamp-2" style="font-size: 0.73rem;" id="previewMsgDisplay">Get 50% OFF on all Online Courses. Use Code DIWALI50 now!</div>
                                </div>
                                <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=80&q=80" alt="Preview Thumb" id="previewThumbDisplay" class="rounded-2 object-fit-cover flex-shrink-0" style="width: 36px; height: 36px;">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-2 pt-2">
                        <button type="button" class="btn btn-outline-secondary w-50 rounded-3 fw-semibold small py-2" onclick="submitAsDraft()">
                            Save as Draft
                        </button>
                        <button type="submit" class="btn btn-primary w-50 rounded-3 fw-semibold small py-2" onclick="document.getElementById('formActionType').value='send';">
                            <i class="fa-solid fa-paper-plane me-1.5"></i> Send Notification
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.tab-link {
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
}
.tab-link:hover {
    color: #0066ff !important;
}
.tab-link.active-tab {
    color: #0066ff !important;
    border-bottom: 2px solid #0066ff;
}
.notif-table th, .notif-table td {
    padding: 0.75rem 0.65rem;
    font-size: 0.825rem;
}
.notif-table tbody tr:hover {
    background-color: #f8fafc;
}
.btn-xs {
    font-size: 0.72rem;
    padding: 0.2rem 0.5rem;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.shadow-xs {
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.getElementById('notifTitleInput');
    const msgInput = document.getElementById('notifMsgInput');
    const titleCounter = document.getElementById('titleCharCount');
    const msgCounter = document.getElementById('msgCharCount');
    const previewTitle = document.getElementById('previewTitleDisplay');
    const previewMsg = document.getElementById('previewMsgDisplay');

    function updateCountersAndPreview() {
        if (titleInput && titleCounter) {
            titleCounter.textContent = titleInput.value.length + '/100';
            if (previewTitle) {
                previewTitle.textContent = titleInput.value || 'Notification Title';
            }
        }
        if (msgInput && msgCounter) {
            msgCounter.textContent = msgInput.value.length + '/300';
            if (previewMsg) {
                previewMsg.textContent = msgInput.value || 'Notification message preview will appear here...';
            }
        }
    }

    if (titleInput) titleInput.addEventListener('input', updateCountersAndPreview);
    if (msgInput) msgInput.addEventListener('input', updateCountersAndPreview);
    updateCountersAndPreview();

    // Check all checkbox
    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll('.row-chk').forEach(c => c.checked = checkAll.checked);
        });
    }
});

function toggleScheduleRow(isLater) {
    const row = document.getElementById('scheduleInputsRow');
    if (row) {
        row.style.display = isLater ? 'flex' : 'none';
    }
}

function submitAsDraft() {
    document.getElementById('formActionType').value = 'draft';
    document.getElementById('createNotifForm').submit();
}

function switchPreviewTab(tab) {
    const tabs = ['prevTabApp', 'prevTabEmail', 'prevTabInApp'];
    tabs.forEach(t => {
        const el = document.getElementById(t);
        if (el) {
            el.className = 'btn btn-xs btn-light text-muted py-0.5 px-2 rounded-pill small';
        }
    });

    const activeEl = document.getElementById('prevTab' + tab.charAt(0).toUpperCase() + tab.slice(1));
    if (activeEl) {
        activeEl.className = 'btn btn-xs btn-primary py-0.5 px-2 rounded-pill small';
    }

    const box = document.getElementById('devicePreviewBox');
    if (tab === 'email') {
        box.style.borderLeft = '3px solid #0284c7';
    } else if (tab === 'inapp') {
        box.style.borderLeft = '3px solid #8b5cf6';
    } else {
        box.style.borderLeft = '1px solid #e2e8f0';
    }
}

function changeImagePrompt() {
    const url = prompt('Enter image URL for banner:', 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=400&q=80');
    if (url) {
        document.getElementById('bannerThumbPreview').src = url;
        document.getElementById('previewThumbDisplay').src = url;
        document.getElementById('formImageUrl').value = url;
    }
}

function removeImage() {
    document.getElementById('bannerThumbPreview').src = 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=120&q=80';
    document.getElementById('previewThumbDisplay').src = 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=80&q=80';
    document.getElementById('formImageUrl').value = '';
}

function populateEdit(title, msg, type, audience) {
    document.getElementById('notifTitleInput').value = title;
    document.getElementById('notifMsgInput').value = msg;
    document.getElementById('notifTypeSelect').value = type;
    document.getElementById('notifAudienceSelect').value = audience;
    document.getElementById('notifTitleInput').dispatchEvent(new Event('input'));
    document.getElementById('notifMsgInput').dispatchEvent(new Event('input'));
    document.getElementById('createNotificationCard').scrollIntoView({behavior: 'smooth'});
}
</script>
@endsection
