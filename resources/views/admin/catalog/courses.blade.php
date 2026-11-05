@extends('admin.layouts.admin')

@section('title', 'Courses Management - Super Admin Dashboard')

@section('styles')
<style>
    /* Metric Cards Grid */
    .metric-cards-scroll-wrap {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .course-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 0.95rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
    }

    .course-stat-card:hover {
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
    .icon-green { background: #f0fdf4; color: #16a34a; }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-red { background: #fef2f2; color: #dc2626; }
    .icon-purple { background: #f3e8ff; color: #9333ea; }
    .icon-yellow { background: #fffbeb; color: #d97706; }

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
    .course-filter-tabs-bar {
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.15rem;
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
    }

    .course-tab-btn {
        padding: 0.65rem 0.2rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        position: relative;
        white-space: nowrap;
        transition: all 0.2s;
    }

    .course-tab-btn:hover,
    .course-tab-btn.active {
        color: #0066ff;
    }

    .course-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #0066ff;
        border-radius: 999px;
    }

    /* Toolbar */
    .courses-filter-toolbar {
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

    .search-course-input-box {
        position: relative;
        flex: 1 1 240px;
    }

    .search-course-input-box input {
        width: 100%;
        padding: 0.4rem 0.75rem 0.4rem 2.1rem;
        font-size: 0.82rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s;
    }

    .search-course-input-box input:focus {
        border-color: #0066ff;
        box-shadow: 0 0 0 2px rgba(0, 102, 255, 0.1);
    }

    .search-course-input-box i {
        position: absolute;
        left: 9px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Workspace Table & Inspector Grid */
    .courses-workspace-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 1.25rem;
        align-items: start;
    }

    .courses-table-container {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .courses-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.8rem;
    }

    .courses-table th {
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

    .courses-table td {
        padding: 0.75rem 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .course-table-row {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .course-table-row:hover {
        background-color: #f8fafc;
    }

    .course-table-row.active-row {
        background-color: #eff6ff !important;
    }

    .course-thumb-xs {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        object-fit: cover;
    }

    /* Category Badges */
    .cat-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.18rem 0.55rem;
        border-radius: 6px;
        white-space: nowrap;
    }
    .cat-marketing { background: #eff6ff; color: #1d4ed8; }
    .cat-development { background: #e0f2fe; color: #0369a1; }
    .cat-accounting { background: #fef3c7; color: #b45309; }
    .cat-ai { background: #f3e8ff; color: #7e22ce; }
    .cat-design { background: #fdf2f8; color: #be185d; }
    .cat-language { background: #f5f3ff; color: #6d28d9; }
    .cat-data { background: #ecfdf5; color: #047857; }
    .cat-computer { background: #eff6ff; color: #2563eb; }
    .cat-photography { background: #fff1f2; color: #be123c; }

    /* Right Inspector Panel */
    .course-inspector-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        position: sticky;
        top: 85px;
    }

    .course-banner-preview {
        position: relative;
        height: 140px;
        overflow: hidden;
        background: #0f172a;
    }

    .course-banner-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.85;
    }

    .bestseller-ribbon {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #f59e0b;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.65rem;
        padding: 0.2rem 0.55rem;
        border-radius: 4px;
        letter-spacing: 0.05em;
    }

    .inspector-header-box {
        padding: 1rem 1.15rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .inspector-nav-tabs {
        display: flex;
        border-bottom: 1px solid #f1f5f9;
        padding: 0 1.15rem;
        gap: 1rem;
        background: #f8fafc;
    }

    .inspector-nav-link {
        padding: 0.55rem 0.15rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        position: relative;
    }

    .inspector-nav-link.active {
        color: #0066ff;
    }

    .inspector-nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #0066ff;
        border-radius: 999px;
    }

    .inspector-kpi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .inspector-kpi-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.55rem 0.65rem;
    }

    .inspector-kpi-val {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
    }

    .inspector-kpi-lbl {
        font-size: 0.68rem;
        color: #64748b;
    }

    @media (max-width: 1199px) {
        .metric-cards-scroll-wrap {
            grid-template-columns: repeat(3, 1fr);
        }
        .courses-workspace-grid {
            grid-template-columns: 1fr;
        }
        .course-inspector-panel {
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
        <h1 class="h4 fw-bold text-dark mb-1">Courses Management</h1>
        <p class="text-secondary small mb-0">
            Manage all courses listed on Digital Class. Approve, edit, feature and track performance.
        </p>
    </div>
    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
        <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-bold" onclick="alert('Import courses CSV wizard will open.')">
            <i class="fa-solid fa-download me-1"></i> Import Courses
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm px-3 fw-bold" onclick="alert('Courses list export initiated.')">
            <i class="fa-solid fa-upload me-1"></i> Export
        </button>
        <a href="{{ route('seller.courses.create') }}" class="btn btn-primary btn-sm px-3 fw-bold">
            <i class="fa-solid fa-plus me-1"></i> Add Course
        </a>
    </div>
</div>

<!-- ============================================== -->
<!-- 6 METRIC CARDS ROW                             -->
<!-- ============================================== -->
<div class="metric-cards-scroll-wrap">
    <!-- 1. Total Courses -->
    <div class="course-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-blue">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="stat-card-title">Total Courses</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['total'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> 22%</span>
        </div>
        <div class="stat-sub-text">+1,056 this month</div>
    </div>

    <!-- 2. Active Courses -->
    <div class="course-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-card-title">Active Courses</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['active'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> 18%</span>
        </div>
        <div class="stat-sub-text">85% of total</div>
    </div>

    <!-- 3. Pending Approval -->
    <div class="course-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-orange">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div class="stat-card-title">Pending Approval</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['pending'] }}</span>
            <span class="stat-trend-tag trend-down"><i class="fa-solid fa-arrow-down"></i> 12%</span>
        </div>
        <div class="stat-sub-text">Needs review</div>
    </div>

    <!-- 4. Rejected -->
    <div class="course-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-red">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="stat-card-title">Rejected</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['rejected'] }}</span>
        </div>
        <div class="stat-sub-text">5% of total</div>
    </div>

    <!-- 5. Featured -->
    <div class="course-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-purple">
                <i class="fa-regular fa-eye"></i>
            </div>
            <div class="stat-card-title">Featured</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['featured'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> 28%</span>
        </div>
        <div class="stat-sub-text">7% of total</div>
    </div>

    <!-- 6. Top Performing -->
    <div class="course-stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon icon-yellow">
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="stat-card-title">Top Performing</div>
        </div>
        <div class="stat-card-num-row">
            <span class="stat-main-number">{{ $stats['top_performing'] }}</span>
            <span class="stat-trend-tag trend-up"><i class="fa-solid fa-arrow-up"></i> 35%</span>
        </div>
        <div class="stat-sub-text">Based on sales &amp; reviews</div>
    </div>
</div>

<!-- ============================================== -->
<!-- FILTER TABS                                    -->
<!-- ============================================== -->
<div class="course-filter-tabs-bar">
    <a href="{{ route('admin.catalog.courses') }}" class="course-tab-btn {{ empty($currentTab) || $currentTab === 'all' ? 'active' : '' }}">
        All Courses (5,842)
    </a>
    <a href="{{ route('admin.catalog.courses', ['tab' => 'active']) }}" class="course-tab-btn {{ $currentTab === 'active' || $currentTab === 'approved' ? 'active' : '' }}">
        Active (4,982)
    </a>
    <a href="{{ route('admin.catalog.courses', ['tab' => 'pending']) }}" class="course-tab-btn {{ $currentTab === 'pending' ? 'active' : '' }}">
        Pending (560)
    </a>
    <a href="{{ route('admin.catalog.courses', ['tab' => 'rejected']) }}" class="course-tab-btn {{ $currentTab === 'rejected' ? 'active' : '' }}">
        Rejected (300)
    </a>
    <a href="{{ route('admin.catalog.courses', ['tab' => 'featured']) }}" class="course-tab-btn {{ $currentTab === 'featured' ? 'active' : '' }}">
        Featured (420)
    </a>
    <a href="{{ route('admin.catalog.courses', ['tab' => 'top_selling']) }}" class="course-tab-btn {{ $currentTab === 'top_selling' ? 'active' : '' }}">
        Top Selling (100)
    </a>
    <a href="{{ route('admin.catalog.courses', ['tab' => 'new']) }}" class="course-tab-btn {{ $currentTab === 'new' ? 'active' : '' }}">
        New (320)
    </a>
</div>

<!-- ============================================== -->
<!-- FILTER TOOLBAR                                 -->
<!-- ============================================== -->
<form action="{{ route('admin.catalog.courses') }}" method="GET" class="courses-filter-toolbar">
    <input type="hidden" name="tab" value="{{ $currentTab }}">

    <!-- Search Box -->
    <div class="search-course-input-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search by course title, seller, ID...">
    </div>

    <!-- Category -->
    <select name="category" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
        <option value="All" {{ empty($selectedCat) || $selectedCat === 'All' ? 'selected' : '' }}>All Categories</option>
        <option value="Marketing" {{ $selectedCat === 'Marketing' ? 'selected' : '' }}>Marketing</option>
        <option value="Development" {{ $selectedCat === 'Development' ? 'selected' : '' }}>Development</option>
        <option value="Accounting" {{ $selectedCat === 'Accounting' ? 'selected' : '' }}>Accounting</option>
        <option value="AI & Tools" {{ $selectedCat === 'AI & Tools' ? 'selected' : '' }}>AI &amp; Tools</option>
        <option value="Design" {{ $selectedCat === 'Design' ? 'selected' : '' }}>Design</option>
        <option value="Language" {{ $selectedCat === 'Language' ? 'selected' : '' }}>Language</option>
        <option value="Data Science" {{ $selectedCat === 'Data Science' ? 'selected' : '' }}>Data Science</option>
        <option value="Computer" {{ $selectedCat === 'Computer' ? 'selected' : '' }}>Computer</option>
        <option value="Photography" {{ $selectedCat === 'Photography' ? 'selected' : '' }}>Photography</option>
    </select>

    <!-- Level -->
    <select name="level" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
        <option value="All" {{ empty($selectedLevel) || $selectedLevel === 'All' ? 'selected' : '' }}>All Levels</option>
        <option value="Beginner" {{ $selectedLevel === 'Beginner' ? 'selected' : '' }}>Beginner</option>
        <option value="Intermediate" {{ $selectedLevel === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
        <option value="Advanced" {{ $selectedLevel === 'Advanced' ? 'selected' : '' }}>Advanced</option>
    </select>

    <!-- Language -->
    <select name="language" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
        <option value="All" {{ empty($selectedLang) || $selectedLang === 'All' ? 'selected' : '' }}>All Languages</option>
        <option value="Hindi" {{ $selectedLang === 'Hindi' ? 'selected' : '' }}>Hindi</option>
        <option value="English" {{ $selectedLang === 'English' ? 'selected' : '' }}>English</option>
        <option value="Gujarati" {{ $selectedLang === 'Gujarati' ? 'selected' : '' }}>Gujarati</option>
    </select>

    <!-- Date Range -->
    <div class="d-none d-md-flex align-items-center gap-1 bg-light border rounded px-2 py-1 small text-secondary">
        <i class="fa-regular fa-calendar text-primary"></i>
        <span>01 Oct 2026 - 31 Oct 2026</span>
    </div>

    <a href="{{ route('admin.catalog.courses') }}" class="btn btn-sm btn-light border small px-3">
        Reset
    </a>
</form>

<!-- ============================================== -->
<!-- WORKSPACE: COURSES TABLE & INSPECTOR PANEL     -->
<!-- ============================================== -->
<div class="courses-workspace-grid">

    <!-- LEFT: COURSES DATA TABLE -->
    <div class="courses-table-container">
        <div class="table-responsive">
            <table class="courses-table">
                <thead>
                    <tr>
                        <th style="width: 32px;"><input type="checkbox" class="form-check-input"></th>
                        <th style="width: 36px;">#</th>
                        <th>Course Details</th>
                        <th>Seller / Institute</th>
                        <th>Category</th>
                        <th>Level</th>
                        <th>Price</th>
                        <th>Price</th>
                        <th>Enrollments</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $idx => $c)
                        @php
                            $catClass = match(strtolower($c['category'])) {
                                'marketing' => 'cat-marketing',
                                'development' => 'cat-development',
                                'accounting' => 'cat-accounting',
                                'ai & tools' => 'cat-ai',
                                'design' => 'cat-design',
                                'language' => 'cat-language',
                                'data science' => 'cat-data',
                                'computer' => 'cat-computer',
                                'photography' => 'cat-photography',
                                default => 'cat-marketing',
                            };

                            $statusBadge = match(strtolower($c['status'])) {
                                'active', 'approved' => 'bg-success-subtle text-success',
                                'pending' => 'bg-warning-subtle text-warning',
                                default => 'bg-danger-subtle text-danger',
                            };
                        @endphp
                        <tr class="course-table-row {{ $idx === 0 ? 'active-row' : '' }}" 
                            onclick="inspectCourse({{ json_encode($c) }}, this)">
                            <td onclick="event.stopPropagation();">
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td class="text-muted small">{{ $idx + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $c['thumbnail'] }}" alt="{{ $c['title'] }}" class="course-thumb-xs">
                                    <div>
                                        <div class="fw-bold text-dark fs-7 text-truncate" style="max-width: 170px;">{{ $c['title'] }}</div>
                                        <div class="text-muted fs-8">ID: {{ $c['code'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $c['seller_logo'] }}" class="rounded-circle" style="width: 20px; height: 20px;">
                                    <div>
                                        <div class="fw-semibold text-dark fs-7">{{ $c['seller_name'] }}</div>
                                        <div class="text-muted fs-8">{{ $c['seller_city'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="cat-badge {{ $catClass }}">{{ $c['category'] }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border fs-8">{{ $c['level'] }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">₹{{ number_format($c['price']) }}</span>
                            </td>
                            <td>
                                <span class="text-muted text-decoration-line-through small">{{ number_format($c['discount_price']) }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ number_format($c['enrollments']) }}</span>
                            </td>
                            <td>
                                <span class="text-warning fw-semibold small">
                                    <i class="fa-solid fa-star"></i> {{ number_format($c['rating'], 1) }}
                                    <span class="text-muted fw-normal">({{ $c['reviews_count'] }})</span>
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $statusBadge }} fs-8">{{ $c['status'] }}</span>
                            </td>
                            <td class="text-end" onclick="event.stopPropagation();">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border-0 py-0 px-2" type="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                                        <li><a class="dropdown-item" href="{{ route('course.show', $c['slug']) }}" target="_blank"><i class="fa-regular fa-eye me-2 text-primary"></i> View Course Page</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="inspectCourse({{ json_encode($c) }})"><i class="fa-solid fa-sliders me-2 text-info"></i> Course Details</a></li>
                                        @if(strtolower($c['status']) === 'pending')
                                            <li>
                                                <form action="{{ route('admin.catalog.courses.approve', $c['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-check me-2"></i> Approve Listing</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.catalog.courses.reject', $c['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-xmark me-2"></i> Reject Listing</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4 text-muted">
                                No courses found matching current filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2 small">
            <span class="text-muted">Showing 1 to {{ count($courses) }} of 5,842 courses</span>
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
                        <li class="page-item"><a class="page-link" href="#">584</a></li>
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

    <!-- RIGHT: COURSE INSPECTOR PANEL -->
    @php
        $firstCourse = $courses[0] ?? [
            'id' => 125,
            'code' => 'CRS00125',
            'title' => 'Digital Marketing Mastery',
            'slug' => 'digital-marketing-mastery',
            'seller_name' => 'VCEC Institute',
            'status' => 'Active',
            'category' => 'Marketing',
            'sub_category' => 'Digital Marketing',
            'level' => 'Beginner',
            'language' => 'Hindi, English',
            'price' => 2999,
            'discount_price' => 7299,
            'duration' => '3 Months',
            'certificate' => 'Yes',
            'mode' => 'Online (Recorded + Live)',
            'enrollments' => 1240,
            'total_revenue' => '₹3,71,760',
            'rating' => 4.8,
            'reviews_count' => 320,
            'banner' => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=800&auto=format&fit=crop&q=80',
            'tags' => ['Digital Marketing', 'SEO', 'Social Media', 'Google Ads', 'Email Marketing'],
        ];
    @endphp
    <div class="course-inspector-panel" id="courseInspectorBox">
        <div class="course-banner-preview">
            <img id="inspBanner" src="{{ $firstCourse['banner'] }}" alt="{{ $firstCourse['title'] }}">
            <span class="bestseller-ribbon">Best Seller</span>
            <button type="button" class="btn btn-sm btn-dark position-absolute top-2 end-2 p-1 px-2 border-0 opacity-75 fs-8" onclick="alert('Edit course banner')">
                <i class="fa-solid fa-pen"></i> Edit
            </button>
        </div>

        <div class="inspector-header-box">
            <div class="d-flex align-items-center gap-2 mb-1">
                <h6 class="fw-bold text-dark mb-0 fs-7" id="inspCourseTitle">{{ $firstCourse['title'] }}</h6>
                <span class="badge bg-success-subtle text-success fs-8" id="inspCourseStatus">{{ $firstCourse['status'] }}</span>
            </div>
            <div class="text-muted fs-8 mb-2" id="inspCourseMeta">ID: {{ $firstCourse['code'] }} | Listed by: {{ $firstCourse['seller_name'] }}</div>

            <div class="d-flex gap-2">
                <a id="inspViewCourseBtn" href="{{ route('course.show', $firstCourse['slug'] ?? 'digital-marketing-mastery') }}" target="_blank" class="btn btn-primary btn-sm flex-grow-1 fw-bold fs-8">
                    View Course
                </a>
                <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 fw-bold fs-8" onclick="alert('Course editor opened.')">
                    Edit Course
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm p-1 px-2" title="More Actions">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
            </div>
        </div>

        <!-- Inspector Tabs -->
        <div class="inspector-nav-tabs">
            <a href="javascript:void(0)" class="inspector-nav-link active">Overview</a>
            <a href="javascript:void(0)" class="inspector-nav-link">Curriculum</a>
            <a href="javascript:void(0)" class="inspector-nav-link">Reviews</a>
            <a href="javascript:void(0)" class="inspector-nav-link">Enrolled Students</a>
        </div>

        <div class="p-3">
            <!-- 4 Metrics -->
            <div class="inspector-kpi-grid">
                <div class="inspector-kpi-card">
                    <div class="inspector-kpi-lbl">Enrollments</div>
                    <div class="inspector-kpi-val text-primary" id="inspEnrollments">{{ number_format($firstCourse['enrollments']) }}</div>
                </div>
                <div class="inspector-kpi-card">
                    <div class="inspector-kpi-lbl">Total Revenue</div>
                    <div class="inspector-kpi-val text-success" id="inspRevenue">{{ $firstCourse['total_revenue'] }}</div>
                </div>
                <div class="inspector-kpi-card">
                    <div class="inspector-kpi-lbl">Average Rating</div>
                    <div class="inspector-kpi-val text-warning" id="inspRating">
                        <i class="fa-solid fa-star fs-8"></i> {{ number_format($firstCourse['rating'], 1) }} ({{ $firstCourse['reviews_count'] }})
                    </div>
                </div>
                <div class="inspector-kpi-card">
                    <div class="inspector-kpi-lbl">Course Views</div>
                    <div class="inspector-kpi-val text-dark" id="inspViews">{{ $firstCourse['course_views'] ?? '14,820' }}</div>
                </div>
            </div>

            <!-- Course Information -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-dark fs-7">Course Information</span>
                <button type="button" class="btn btn-sm btn-light border py-0 px-2 fs-8 fw-semibold" onclick="alert('Edit Course Info')">
                    <i class="fa-solid fa-pen fs-8 me-1"></i> Edit
                </button>
            </div>

            <div class="border rounded-3 p-2 bg-light mb-3" style="font-size: 0.76rem;">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Title</span>
                    <span class="fw-semibold text-dark" id="infoTitle">{{ $firstCourse['title'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Category</span>
                    <span class="fw-semibold text-primary" id="infoCategory">{{ $firstCourse['category'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Sub Category</span>
                    <span class="fw-semibold text-dark" id="infoSubCategory">{{ $firstCourse['sub_category'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Level</span>
                    <span class="fw-semibold text-dark" id="infoLevel">{{ $firstCourse['level'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Language</span>
                    <span class="fw-semibold text-dark" id="infoLanguage">{{ $firstCourse['language'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Price</span>
                    <span class="fw-bold text-dark" id="infoPrice">₹{{ number_format($firstCourse['price']) }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Discount Price</span>
                    <span class="text-muted text-decoration-line-through" id="infoDiscPrice">₹{{ number_format($firstCourse['discount_price']) }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Duration</span>
                    <span class="fw-semibold text-dark" id="infoDuration">{{ $firstCourse['duration'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Certificate</span>
                    <span class="fw-semibold text-success" id="infoCertificate">{{ $firstCourse['certificate'] }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Mode</span>
                    <span class="fw-semibold text-dark" id="infoMode">{{ $firstCourse['mode'] }}</span>
                </div>
            </div>

            <!-- Tags -->
            <div class="fw-bold text-dark fs-7 mb-2">Tags</div>
            <div class="d-flex flex-wrap gap-1 mb-3" id="inspTagsBox">
                @foreach($firstCourse['tags'] as $t)
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-8">{{ $t }}</span>
                @endforeach
            </div>

            <!-- Quick Actions -->
            <div class="fw-bold text-dark fs-7 mb-2">Quick Actions</div>
            <div class="d-grid gap-2">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" onclick="alert('Course marked as approved')">
                        <i class="fa-solid fa-check me-1"></i> Approve
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger fw-bold" onclick="alert('Course marked as rejected')">
                        <i class="fa-solid fa-xmark me-1"></i> Reject
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold" onclick="alert('Course toggled as featured')">
                        <i class="fa-solid fa-star me-1"></i> Feature
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    function inspectCourse(c, rowEl) {
        if (rowEl) {
            document.querySelectorAll('.course-table-row').forEach(r => r.classList.remove('active-row'));
            rowEl.classList.add('active-row');
        }

        document.getElementById('inspBanner').src = c.banner;
        document.getElementById('inspCourseTitle').innerText = c.title;
        document.getElementById('inspCourseStatus').innerText = c.status;
        document.getElementById('inspCourseMeta').innerText = 'ID: ' + c.code + ' | Listed by: ' + c.seller_name;
        document.getElementById('inspViewCourseBtn').href = '/course/' + c.slug;
        document.getElementById('inspEnrollments').innerText = parseInt(c.enrollments).toLocaleString();
        document.getElementById('inspRevenue').innerText = c.total_revenue || '₹0';
        document.getElementById('inspRating').innerHTML = '<i class="fa-solid fa-star fs-8"></i> ' + parseFloat(c.rating).toFixed(1) + ' (' + c.reviews_count + ')';
        document.getElementById('inspViews').innerText = c.course_views || '5,000';

        document.getElementById('infoTitle').innerText = c.title;
        document.getElementById('infoCategory').innerText = c.category;
        document.getElementById('infoSubCategory').innerText = c.sub_category || c.category;
        document.getElementById('infoLevel').innerText = c.level;
        document.getElementById('infoLanguage').innerText = c.language;
        document.getElementById('infoPrice').innerText = '₹' + parseInt(c.price).toLocaleString();
        document.getElementById('infoDiscPrice').innerText = '₹' + parseInt(c.discount_price).toLocaleString();
        document.getElementById('infoDuration').innerText = c.duration;
        document.getElementById('infoCertificate').innerText = c.certificate;
        document.getElementById('infoMode').innerText = c.mode;

        const tagsBox = document.getElementById('inspTagsBox');
        tagsBox.innerHTML = '';
        if (c.tags && Array.isArray(c.tags)) {
            c.tags.forEach(t => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary-subtle text-primary border border-primary-subtle fs-8';
                badge.innerText = t;
                tagsBox.appendChild(badge);
            });
        }
    }
</script>
@endsection
