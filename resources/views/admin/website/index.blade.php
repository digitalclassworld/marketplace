@extends('admin.layouts.admin')

@section('title', 'Website Management - Digital Class Super Admin')

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

    <!-- Page Header & Action Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Website Management</h1>
            <p class="text-muted small mb-0">Manage your website content, pages, menus, banners and settings. Build and customize your platform without coding.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 bg-white text-dark fw-semibold px-3 py-2">
                <i class="fa-solid fa-arrow-up-right-from-square me-1 text-muted"></i> View Website
            </a>
            <button type="button" class="btn btn-sm btn-primary rounded-3 fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#createPageModal">
                <i class="fa-solid fa-plus me-1.5"></i> Create New Page
            </button>
        </div>
    </div>

    <!-- 4 KPI Cards Row -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Pages -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-file-lines fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['pages_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Pages</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['total_pages'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['pages_sub'] }}</div>
            </div>
        </div>

        <!-- 2. Total Banners -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #f5f3ff; color: #8b5cf6;">
                        <i class="fa-solid fa-image fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['banners_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Banners</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['total_banners'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['banners_sub'] }}</div>
            </div>
        </div>

        <!-- 3. Active Menus -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fff7ed; color: #ea580c;">
                        <i class="fa-solid fa-bars-staggered fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['menus_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Active Menus</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['active_menus'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['menus_sub'] }}</div>
            </div>
        </div>

        <!-- 4. Website Status -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-globe fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Website Status</div>
                <div class="fs-4 fw-bold text-success mb-1">{{ $kpi['website_status'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['status_sub'] }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="px-3 pt-2 border-bottom d-flex align-items-center gap-2 overflow-auto scrollbar-none" style="scrollbar-width: none;">
            <a href="{{ route('admin.website.index') }}" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small active-tab">
                <i class="fa-solid fa-file-lines me-1.5"></i> Pages
            </a>
            <a href="#menus" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-bars me-1.5"></i> Menus
            </a>
            <a href="{{ route('admin.promotions.index') }}" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-images me-1.5"></i> Banners & Sliders
            </a>
            <a href="#themes" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-palette me-1.5"></i> Themes & Design
            </a>
            <a href="#seo" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-magnifying-glass-chart me-1.5"></i> SEO & Meta
            </a>
            <a href="#custom-code" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-code me-1.5"></i> Custom Code
            </a>
            <a href="#settings" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-gear me-1.5"></i> Settings
            </a>
        </div>
    </div>

    <!-- 2-Column Content Layout -->
    <div class="row g-4">
        <!-- LEFT COLUMN: Website Pages Table (8 cols) -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <!-- Table Header with Search & Filters -->
                <div class="p-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h2 class="h6 fw-bold text-dark mb-0">Website Pages (28)</h2>
                    <button type="button" class="btn btn-sm btn-primary rounded-3 fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#createPageModal">
                        <i class="fa-solid fa-plus me-1"></i> Add New Page
                    </button>
                </div>

                <!-- 1-Row Search & Filter Bar -->
                <div class="p-3 border-bottom bg-light">
                    <form action="{{ route('admin.website.index') }}" method="GET" class="row g-2 align-items-center">
                        @if($selectedPage)
                            <input type="hidden" name="selected" value="{{ $selectedPage->id }}">
                        @endif

                        <div class="col-md-5">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" name="search" value="{{ $search }}" class="form-control bg-white border-start-0" placeholder="Search pages by title, URL or type...">
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <select name="type" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="System" {{ $type === 'System' ? 'selected' : '' }}>System</option>
                                <option value="Custom" {{ $type === 'Custom' ? 'selected' : '' }}>Custom</option>
                                <option value="Blog" {{ $type === 'Blog' ? 'selected' : '' }}>Blog</option>
                                <option value="Legal" {{ $type === 'Legal' ? 'selected' : '' }}>Legal</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-6">
                            <select name="status" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="Published" {{ $status === 'Published' ? 'selected' : '' }}>Published</option>
                                <option value="Draft" {{ $status === 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Scheduled" {{ $status === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>

                        <div class="col-md-2 text-end">
                            <a href="{{ route('admin.website.index') }}" class="btn btn-sm btn-outline-secondary bg-white w-100 fw-semibold">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 page-table">
                        <thead class="bg-light table-light border-bottom text-muted small fw-semibold">
                            <tr>
                                <th style="width: 32px;" class="ps-3"><input type="checkbox" class="form-check-input" id="checkAllPages"></th>
                                <th style="width: 36px;">#</th>
                                <th>Page Title</th>
                                <th style="width: 140px;">URL / Slug</th>
                                <th style="width: 90px;">Type</th>
                                <th style="width: 95px;">Status</th>
                                <th style="width: 130px;">Last Updated</th>
                                <th style="width: 45px;" class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $index => $item)
                            <tr class="{{ $selectedPage && $selectedPage->id === $item->id ? 'table-primary-subtle' : '' }}" style="cursor: pointer;" onclick="window.location='{{ route('admin.website.index', array_merge(request()->query(), ['selected' => $item->id])) }}'">
                                <td class="ps-3" onclick="event.stopPropagation();"><input type="checkbox" class="form-check-input page-chk"></td>
                                <td class="text-muted small fw-semibold">{{ ($pages->currentPage() - 1) * $pages->perPage() + $index + 1 }}</td>
                                
                                <!-- Page Title & Thumbnail -->
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="rounded-2 object-fit-cover shadow-xs border flex-shrink-0" style="width: 38px; height: 38px;">
                                        <div class="overflow-hidden">
                                            <div class="fw-bold text-dark text-truncate small">{{ $item->title }}</div>
                                            @if($item->is_homepage)
                                                <span class="badge bg-primary-subtle text-primary p-0.5 px-1 rounded-pill" style="font-size: 0.6rem;">Homepage</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- URL / Slug -->
                                <td class="small font-monospace text-muted text-truncate" style="max-width: 140px;">
                                    {{ $item->slug }}
                                </td>

                                <!-- Type -->
                                <td>
                                    @php
                                        $typeStyles = [
                                            'System' => 'background-color: #eff6ff; color: #2563eb;',
                                            'Custom' => 'background-color: #fff7ed; color: #ea580c;',
                                            'Blog'   => 'background-color: #ecfeff; color: #0891b2;',
                                            'Legal'  => 'background-color: #fdf2f8; color: #db2777;',
                                        ];
                                        $style = $typeStyles[$item->type] ?? 'background-color: #f1f5f9; color: #475569;';
                                    @endphp
                                    <span class="badge rounded-pill fw-semibold small" style="{{ $style }}; font-size: 0.7rem; padding: 0.32rem 0.6rem;">
                                        {{ $item->type }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td>
                                    @if($item->status === 'Published')
                                        <span class="badge bg-success-subtle text-success rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Published</span>
                                    @elseif($item->status === 'Draft')
                                        <span class="badge bg-light text-muted border rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Draft</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill fw-semibold small" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">Scheduled</span>
                                    @endif
                                </td>

                                <!-- Last Updated -->
                                <td>
                                    <div class="small fw-medium text-dark">{{ $item->last_updated_at ? $item->last_updated_at->format('d M Y') : 'Recent' }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $item->last_updated_at ? $item->last_updated_at->format('h:i A') : '10:00 AM' }}</div>
                                </td>

                                <!-- Actions Dropdown -->
                                <td class="text-end pe-3" onclick="event.stopPropagation();">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-2 text-muted border-0 p-1" type="button" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small rounded-3">
                                            <li>
                                                <a href="{{ url($item->slug) }}" target="_blank" class="dropdown-item py-1.5"><i class="fa-solid fa-eye me-2 text-primary"></i> Preview</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.website.duplicate', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-1.5"><i class="fa-regular fa-copy me-2 text-info"></i> Duplicate</button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('admin.website.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete page {{ addslashes($item->title) }}?');">
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
                                <td colspan="8" class="text-center py-5 text-muted small">
                                    <i class="fa-regular fa-folder-open fs-3 mb-2 d-block text-secondary"></i>
                                    No pages found matching your search.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="p-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="text-muted small">
                        Showing {{ $pages->firstItem() ?? 0 }} to {{ $pages->lastItem() ?? 0 }} of {{ $pages->total() }} pages
                    </div>
                    <div>
                        {{ $pages->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Page Preview & Page Settings (4 cols) -->
        <div class="col-xl-4">
            <!-- 1. Page Preview Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h6 fw-bold text-dark mb-0">Page Preview</h2>
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select form-select-sm bg-light" style="width: 120px;" onchange="window.location='{{ route('admin.website.index') }}?selected=' + this.value">
                            @foreach($pages as $p)
                                <option value="{{ $p->id }}" {{ $selectedPage && $selectedPage->id === $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                            @endforeach
                        </select>
                        <a href="{{ $selectedPage ? url($selectedPage->slug) : route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary py-0.5 px-2 rounded-2 small fw-semibold" style="font-size: 0.72rem;">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live
                        </a>
                    </div>
                </div>

                <!-- Miniature Desktop Browser Window Mockup -->
                <div class="border rounded-3 overflow-hidden shadow-xs mb-3 bg-white">
                    <!-- Browser Top Bar -->
                    <div class="bg-light px-2 py-1.5 border-bottom d-flex align-items-center gap-1.5">
                        <span class="rounded-circle bg-danger" style="width: 8px; height: 8px;"></span>
                        <span class="rounded-circle bg-warning" style="width: 8px; height: 8px;"></span>
                        <span class="rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                        <div class="bg-white rounded-pill px-2 py-0.5 border text-muted small text-truncate flex-grow-1 ms-1" style="font-size: 0.62rem;">
                            https://digitalclass.in{{ $selectedPage ? $selectedPage->slug : '/' }}
                        </div>
                    </div>

                    <!-- Scaled Realistic Mini Web Preview -->
                    <div class="mini-web-preview p-3 position-relative" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); min-height: 220px; font-size: 0.75rem;">
                        <!-- Mini Navbar -->
                        <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                            <div class="fw-bold text-dark d-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                <span class="text-primary"><i class="fa-solid fa-graduation-cap"></i></span> Digital Class
                            </div>
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.65rem;">
                                <span class="text-dark fw-semibold">Courses</span>
                                <span>Services</span>
                                <span>Institutes</span>
                                <span>Products</span>
                                <span>Blog</span>
                            </div>
                        </div>

                        <!-- Mini Hero Header -->
                        <div class="row align-items-center g-2 my-1">
                            <div class="col-8">
                                <h3 class="fw-bold text-dark lh-sm mb-1" style="font-size: 0.85rem;">
                                    {{ $selectedPage && $selectedPage->slug !== '/' ? $selectedPage->title : 'Learn. Teach. Grow.' }}
                                </h3>
                                <p class="text-muted mb-2" style="font-size: 0.65rem; line-height: 1.3;">
                                    {{ $selectedPage && $selectedPage->meta_description ? \Illuminate\Support\Str::limit($selectedPage->meta_description, 80) : 'All in One Educational Platform for courses, services and institutes.' }}
                                </p>
                                <div class="input-group input-group-sm mb-2" style="max-width: 170px;">
                                    <input type="text" class="form-control form-control-sm py-0.5 px-1.5" placeholder="Search..." style="font-size: 0.6rem;">
                                    <button class="btn btn-primary py-0 px-2" style="font-size: 0.6rem;"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=150&q=80" alt="Students" class="rounded-3 img-fluid shadow-xs">
                            </div>
                        </div>

                        <!-- Mini 4 Category Buttons -->
                        <div class="row g-1 text-center mt-1">
                            <div class="col-3"><div class="p-1 rounded bg-primary-subtle text-primary fw-semibold" style="font-size: 0.58rem;">Courses</div></div>
                            <div class="col-3"><div class="p-1 rounded bg-success-subtle text-success fw-semibold" style="font-size: 0.58rem;">Services</div></div>
                            <div class="col-3"><div class="p-1 rounded bg-warning-subtle text-warning-emphasis fw-semibold" style="font-size: 0.58rem;">Products</div></div>
                            <div class="col-3"><div class="p-1 rounded bg-info-subtle text-info fw-semibold" style="font-size: 0.58rem;">Institutes</div></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Bar -->
                <div class="d-flex align-items-center justify-content-between gap-2 pt-2 border-top">
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-2 flex-grow-1" onclick="document.getElementById('pageTitleInput').focus();">
                        <i class="fa-regular fa-pen-to-square me-1"></i> Edit Page
                    </button>
                    @if($selectedPage)
                    <form action="{{ route('admin.website.duplicate', $selectedPage->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-outline-secondary rounded-2 w-100">
                            <i class="fa-regular fa-copy me-1"></i> Duplicate
                        </button>
                    </form>
                    <a href="{{ url($selectedPage->slug) }}" target="_blank" class="btn btn-xs btn-outline-secondary rounded-2 flex-grow-1 text-center text-decoration-none">
                        <i class="fa-regular fa-eye me-1"></i> Preview
                    </a>
                    <form action="{{ route('admin.website.destroy', $selectedPage->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Delete this page?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger rounded-2 w-100">
                            <i class="fa-regular fa-trash-can me-1"></i> Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- 2. Page Settings Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h2 class="h6 fw-bold text-dark mb-3">Page Settings</h2>

                <!-- Sub-tabs -->
                <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom overflow-auto scrollbar-none" style="scrollbar-width: none;">
                    <a href="javascript:void(0)" class="small fw-semibold text-primary border-bottom border-primary border-2 pb-1 text-decoration-none">General</a>
                    <a href="javascript:void(0)" class="small fw-medium text-muted pb-1 text-decoration-none" onclick="alert('SEO & Meta tab');">SEO & Meta</a>
                    <a href="javascript:void(0)" class="small fw-medium text-muted pb-1 text-decoration-none" onclick="alert('Design tab');">Design</a>
                    <a href="javascript:void(0)" class="small fw-medium text-muted pb-1 text-decoration-none" onclick="alert('Advanced tab');">Advanced</a>
                    <a href="javascript:void(0)" class="small fw-medium text-muted pb-1 text-decoration-none" onclick="alert('Access tab');">Access</a>
                </div>

                @if($selectedPage)
                <form action="{{ route('admin.website.update', $selectedPage->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Page Title -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Page Title <span class="text-danger">*</span></label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="pageTitleCharCount">{{ strlen($selectedPage->title) }}/100</span>
                        </div>
                        <input type="text" name="title" id="pageTitleInput" value="{{ $selectedPage->title }}" maxlength="100" required class="form-control form-control-sm bg-light">
                    </div>

                    <!-- Page Type & Status -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Page Type</label>
                            <select name="type" class="form-select form-select-sm bg-light">
                                <option value="System" {{ $selectedPage->type === 'System' ? 'selected' : '' }}>System Page</option>
                                <option value="Custom" {{ $selectedPage->type === 'Custom' ? 'selected' : '' }}>Custom Page</option>
                                <option value="Blog" {{ $selectedPage->type === 'Blog' ? 'selected' : '' }}>Blog Page</option>
                                <option value="Legal" {{ $selectedPage->type === 'Legal' ? 'selected' : '' }}>Legal Page</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Status</label>
                            <select name="status" class="form-select form-select-sm bg-light">
                                <option value="Published" {{ $selectedPage->status === 'Published' ? 'selected' : '' }}>🟢 Published</option>
                                <option value="Draft" {{ $selectedPage->status === 'Draft' ? 'selected' : '' }}>⚪ Draft</option>
                                <option value="Scheduled" {{ $selectedPage->status === 'Scheduled' ? 'selected' : '' }}>🟡 Scheduled</option>
                            </select>
                        </div>
                    </div>

                    <!-- URL / Slug -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">URL / Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" value="{{ $selectedPage->slug }}" required class="form-control form-control-sm bg-light font-monospace">
                        <div class="text-muted mt-1" style="font-size: 0.7rem;">This will be the page URL. Use lowercase and hyphens.</div>
                    </div>

                    <!-- Toggle: Show in Menu -->
                    <div class="d-flex align-items-center justify-content-between py-2 border-top">
                        <span class="small fw-semibold text-dark">Show in Menu</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="show_in_menu" value="1" role="switch" {{ $selectedPage->show_in_menu ? 'checked' : '' }}>
                        </div>
                    </div>

                    <!-- Toggle: Set as Homepage -->
                    <div class="d-flex align-items-center justify-content-between py-2 border-top mb-3">
                        <span class="small fw-semibold text-dark">Set as Homepage</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_homepage" value="1" role="switch" {{ $selectedPage->is_homepage ? 'checked' : '' }}>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 fw-semibold py-2">
                        <i class="fa-solid fa-floppy-disk me-1.5"></i> Save Settings
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create New Page -->
<div class="modal fade" id="createPageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark fs-6"><i class="fa-solid fa-plus me-2 text-primary"></i> Create New Website Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" required class="form-control form-control-sm bg-light" placeholder="e.g. Student Scholarships 2027" id="newPageTitle" oninput="document.getElementById('newPageSlug').value = '/' + this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">URL / Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" required class="form-control form-control-sm bg-light font-monospace" placeholder="/student-scholarships-2027" id="newPageSlug">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark">Page Type</label>
                            <select name="type" class="form-select form-select-sm bg-light">
                                <option value="Custom">Custom Page</option>
                                <option value="System">System Page</option>
                                <option value="Blog">Blog Page</option>
                                <option value="Legal">Legal Page</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark">Status</label>
                            <select name="status" class="form-select form-select-sm bg-light">
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                                <option value="Scheduled">Scheduled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="show_in_menu" value="1" id="newShowMenu" checked>
                        <label class="form-check-label small" for="newShowMenu">Show in Website Navigation Menu</label>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-sm btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold px-4">
                        <i class="fa-solid fa-plus me-1.5"></i> Create Page
                    </button>
                </div>
            </form>
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
.page-table th, .page-table td {
    padding: 0.75rem 0.65rem;
    font-size: 0.825rem;
}
.page-table tbody tr:hover {
    background-color: #f8fafc;
}
.table-primary-subtle {
    background-color: #eff6ff !important;
}
.btn-xs {
    font-size: 0.72rem;
    padding: 0.2rem 0.5rem;
}
.shadow-xs {
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pageTitleInput = document.getElementById('pageTitleInput');
    const counter = document.getElementById('pageTitleCharCount');
    if (pageTitleInput && counter) {
        pageTitleInput.addEventListener('input', function () {
            counter.textContent = this.value.length + '/100';
        });
    }

    const checkAll = document.getElementById('checkAllPages');
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll('.page-chk').forEach(c => c.checked = checkAll.checked);
        });
    }
});
</script>
@endsection
