@extends('admin.layouts.admin')

@section('title', 'Blog & CMS Management - Super Admin')

@section('styles')
<style>
    /* Custom Styling matching screenshot 1 pixel-for-pixel */
    .cms-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        height: 100%;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .cms-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .cms-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .kpi-icon-blue    { background: #eff6ff; color: #2563eb; }
    .kpi-icon-green   { background: #ecfdf5; color: #059669; }
    .kpi-icon-purple  { background: #f5f3ff; color: #8b5cf6; }
    .kpi-icon-orange  { background: #fff7ed; color: #ea580c; }

    /* Navigation Filter Tabs */
    .cms-tabs-nav {
        border-bottom: 2px solid #e2e8f0;
        gap: 0.25rem;
    }
    .cms-tabs-nav .nav-link {
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
    .cms-tabs-nav .nav-link:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .cms-tabs-nav .nav-link.active {
        color: #0066ff;
        background: transparent;
        font-weight: 700;
    }
    .cms-tabs-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0066ff;
    }

    /* Type & Category Badges */
    .badge-pill-type {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-block;
    }

    .cat-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
    }
    .cat-technology { background: #f5f3ff; color: #7c3aed; }
    .cat-business   { background: #fff7ed; color: #c2410c; }
    .cat-marketing  { background: #ecfdf5; color: #047857; }
    .cat-education  { background: #fef2f2; color: #b91c1c; }
    .cat-career     { background: #eff6ff; color: #1d4ed8; }
    .cat-software   { background: #fdf4ff; color: #a21caf; }
    .cat-teaching   { background: #fff1f2; color: #be123c; }
    .cat-offers     { background: #fff7ed; color: #ea580c; }
    .cat-trends     { background: #f5f3ff; color: #6d28d9; }
    .cat-others     { background: #f1f5f9; color: #475569; }

    /* Status Badges */
    .status-badge-post {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        display: inline-block;
    }
    .status-published { background: #dcfce7; color: #15803d; }
    .status-draft     { background: #fef3c7; color: #b45309; }
    .status-scheduled { background: #ffedd5; color: #c2410c; }

    /* Right Sidebar Widgets */
    .cms-sidebar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.15rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
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

    {{-- Top Header matching screenshot 1 --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Blog & CMS</h1>
            <p class="text-muted small mb-0">Manage blog posts, pages, categories, menus and website content for your platform.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- + Create Post Button --}}
            <a href="{{ route('admin.cms.create') }}" class="btn btn-primary px-3 py-2 fw-medium shadow-sm d-flex align-items-center gap-1.5" style="background-color: #0066ff; border-color: #0066ff;">
                <i class="fa-solid fa-plus"></i> Create Post
            </a>

            {{-- Create Page Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" onclick="alert('Page builder will open.')">
                <i class="fa-regular fa-file-lines me-1 text-muted"></i> Create Page
            </button>

            {{-- Manage Categories Button --}}
            <button class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                <i class="fa-solid fa-folder-tree me-1 text-muted"></i> Manage Categories
            </button>

            {{-- More Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-white border bg-white text-secondary dropdown-toggle px-3 py-2 fw-medium shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    More
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item py-2" href="{{ route('blog.index') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square text-primary me-2"></i> View Live Blog Website</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('admin.cms.export') }}"><i class="fa-regular fa-file-excel text-success me-2"></i> Export Posts (CSV)</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="alert('Menu manager')"><i class="fa-solid fa-bars text-secondary me-2"></i> Navigation Menus</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- 4 KPI Metric Cards matching screenshot 1 --}}
    <div class="row g-3 mb-4">
        {{-- Card 1: Total Posts --}}
        <div class="col-xl-3 col-md-6">
            <div class="cms-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Total Posts</span>
                    <div class="cms-icon-circle kpi-icon-blue">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_posts'] ?? '248' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.72rem;">{{ $stats['posts_growth'] ?? '↑ 18%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['posts_sub'] ?? '+36 this month' }}</span>
            </div>
        </div>

        {{-- Card 2: Total Views --}}
        <div class="col-xl-3 col-md-6">
            <div class="cms-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Total Views</span>
                    <div class="cms-icon-circle kpi-icon-green">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_views'] ?? '1,24,560' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.72rem;">{{ $stats['views_growth'] ?? '↑ 32%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['views_sub'] ?? '+28,400 this month' }}</span>
            </div>
        </div>

        {{-- Card 3: Unique Visitors --}}
        <div class="col-xl-3 col-md-6">
            <div class="cms-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Unique Visitors</span>
                    <div class="cms-icon-circle kpi-icon-purple">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['unique_visitors'] ?? '42,380' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.72rem;">{{ $stats['visitors_growth'] ?? '↑ 26%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['visitors_sub'] ?? '+8,920 this month' }}</span>
            </div>
        </div>

        {{-- Card 4: Total Comments --}}
        <div class="col-xl-3 col-md-6">
            <div class="cms-kpi-card shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-muted fw-semibold" style="font-size: 0.8rem;">Total Comments</span>
                    <div class="cms-icon-circle kpi-icon-orange">
                        <i class="fa-regular fa-comment-dots"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_comments'] ?? '860' }}</h2>
                    <span class="badge bg-success-subtle text-success fw-bold font-monospace" style="font-size: 0.72rem;">{{ $stats['comments_growth'] ?? '↑ 14%' }}</span>
                </div>
                <span class="text-muted" style="font-size: 0.75rem;">{{ $stats['comments_sub'] ?? '+105 this month' }}</span>
            </div>
        </div>
    </div>

    {{-- Status Tabs Row matching screenshot 1 --}}
    <div class="d-flex cms-tabs-nav mb-3 overflow-auto">
        <a href="{{ route('admin.cms.index', array_merge(request()->query(), ['tab' => 'all'])) }}" class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}">
            All Posts ({{ number_format($counts['all'] ?? 248) }})
        </a>
        <a href="{{ route('admin.cms.index', array_merge(request()->query(), ['tab' => 'published'])) }}" class="nav-link {{ $currentTab === 'published' ? 'active' : '' }}">
            Published ({{ number_format($counts['published'] ?? 186) }})
        </a>
        <a href="{{ route('admin.cms.index', array_merge(request()->query(), ['tab' => 'drafts'])) }}" class="nav-link {{ $currentTab === 'drafts' ? 'active' : '' }}">
            Drafts ({{ number_format($counts['drafts'] ?? 32) }})
        </a>
        <a href="{{ route('admin.cms.index', array_merge(request()->query(), ['tab' => 'scheduled'])) }}" class="nav-link {{ $currentTab === 'scheduled' ? 'active' : '' }}">
            Scheduled ({{ number_format($counts['scheduled'] ?? 14) }})
        </a>
        <a href="{{ route('admin.cms.index', array_merge(request()->query(), ['tab' => 'pages'])) }}" class="nav-link {{ $currentTab === 'pages' ? 'active' : '' }}">
            Pages ({{ number_format($counts['pages'] ?? 28) }})
        </a>
    </div>

    {{-- Single Row Filter Bar matching screenshot 1 --}}
    <form action="{{ route('admin.cms.index') }}" method="GET" class="card border-0 shadow-sm p-3 mb-4 rounded-3 bg-white">
        <input type="hidden" name="tab" value="{{ $currentTab }}">

        <div class="row g-2 align-items-center">
            {{-- Search input --}}
            <div class="col-lg-3 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3 pe-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-1" placeholder="Search by title, keyword or author..." value="{{ $search ?? '' }}">
                </div>
            </div>

            {{-- All Types --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="type" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="Blog" {{ ($typeFilter ?? '') === 'Blog' ? 'selected' : '' }}>Blog Post</option>
                    <option value="Page" {{ ($typeFilter ?? '') === 'Page' ? 'selected' : '' }}>Page</option>
                    <option value="News" {{ ($typeFilter ?? '') === 'News' ? 'selected' : '' }}>News</option>
                    <option value="Announcement" {{ ($typeFilter ?? '') === 'Announcement' ? 'selected' : '' }}>Announcement</option>
                </select>
            </div>

            {{-- All Categories --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="category" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Technology" {{ ($categoryFilter ?? '') === 'Technology' ? 'selected' : '' }}>Technology</option>
                    <option value="Business" {{ ($categoryFilter ?? '') === 'Business' ? 'selected' : '' }}>Business</option>
                    <option value="Marketing" {{ ($categoryFilter ?? '') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Education" {{ ($categoryFilter ?? '') === 'Education' ? 'selected' : '' }}>Education</option>
                    <option value="Career" {{ ($categoryFilter ?? '') === 'Career' ? 'selected' : '' }}>Career</option>
                    <option value="Software" {{ ($categoryFilter ?? '') === 'Software' ? 'selected' : '' }}>Software</option>
                    <option value="Teaching" {{ ($categoryFilter ?? '') === 'Teaching' ? 'selected' : '' }}>Teaching</option>
                    <option value="Offers" {{ ($categoryFilter ?? '') === 'Offers' ? 'selected' : '' }}>Offers</option>
                    <option value="Trends" {{ ($categoryFilter ?? '') === 'Trends' ? 'selected' : '' }}>Trends</option>
                </select>
            </div>

            {{-- All Authors --}}
            <div class="col-lg-2 col-md-3 col-6">
                <select name="author" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Authors</option>
                    <option value="Hitesh Mohkar" {{ ($authorFilter ?? '') === 'Hitesh Mohkar' ? 'selected' : '' }}>Hitesh Mohkar</option>
                    <option value="Manish Patel" {{ ($authorFilter ?? '') === 'Manish Patel' ? 'selected' : '' }}>Manish Patel</option>
                    <option value="Prakash Shah" {{ ($authorFilter ?? '') === 'Prakash Shah' ? 'selected' : '' }}>Prakash Shah</option>
                    <option value="Tushar Mehta" {{ ($authorFilter ?? '') === 'Tushar Mehta' ? 'selected' : '' }}>Tushar Mehta</option>
                    <option value="Neha Shah" {{ ($authorFilter ?? '') === 'Neha Shah' ? 'selected' : '' }}>Neha Shah</option>
                </select>
            </div>

            {{-- All Status --}}
            <div class="col-lg-1 col-md-3 col-6">
                <select name="status" class="form-select text-secondary" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="Published" {{ ($statusFilter ?? '') === 'Published' ? 'selected' : '' }}>Published</option>
                    <option value="Draft" {{ ($statusFilter ?? '') === 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Scheduled" {{ ($statusFilter ?? '') === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>
            </div>

            {{-- Date Range & Reset --}}
            <div class="col-lg-2 col-md-6 col-12 d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                    <input type="text" class="form-control border-start-0" value="01 Oct 2026 - 31 Oct 2026" readonly style="font-size: 0.8rem; background-color: #ffffff;">
                </div>
                <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </div>
        </div>
    </form>

    {{-- Main Workspace: Table (Left ~70%) + Quick Create / Categories Widget (Right ~30%) --}}
    <div class="row g-3">
        {{-- Posts Table Column --}}
        <div class="col-xxl-8 col-xl-7 col-lg-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="postsTable">
                        <thead class="table-light text-uppercase fw-bold text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-3" style="width: 30px;"><input type="checkbox" class="form-check-input" id="selectAllPosts"></th>
                                <th style="width: 35px;">#</th>
                                <th style="min-width: 80px;">Featured Image</th>
                                <th style="min-width: 220px;">Title</th>
                                <th style="min-width: 70px;">Type</th>
                                <th style="min-width: 95px;">Category</th>
                                <th style="min-width: 130px;">Author</th>
                                <th style="min-width: 85px;">Views</th>
                                <th style="min-width: 85px;">Status</th>
                                <th style="min-width: 125px;">Published At</th>
                                <th class="text-end pe-3" style="width: 45px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.82rem;">
                            @forelse($posts as $idx => $post)
                                @php
                                    $catClass = 'cat-' . strtolower($post->category);
                                    $statusClass = 'status-' . strtolower($post->status);
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        <input type="checkbox" class="form-check-input post-checkbox">
                                    </td>
                                    <td class="text-muted fw-semibold">{{ $post->id }}</td>
                                    <td>
                                        <img src="{{ $post->featured_image ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=120&auto=format&fit=crop&q=80' }}"
                                             alt="Thumbnail" class="rounded border" style="width: 44px; height: 32px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                                                {{ $post->title }}
                                            </a>
                                            <div class="text-muted text-truncate font-monospace" style="font-size: 0.7rem; max-width: 210px;">
                                                {{ $post->slug }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-pill-type">{{ $post->type }}</span>
                                    </td>
                                    <td>
                                        <span class="cat-badge {{ $catClass }}">{{ $post->category }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <img src="{{ $post->author_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($post->author_name) . '&background=0066ff&color=fff' }}"
                                                 alt="{{ $post->author_name }}" class="rounded-circle" style="width: 22px; height: 22px; object-fit: cover;">
                                            <span class="text-secondary fw-medium" style="font-size: 0.78rem;">{{ $post->author_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted d-flex align-items-center gap-1">
                                            <i class="fa-regular fa-eye" style="font-size: 0.7rem;"></i> {{ number_format($post->views) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge-post {{ $statusClass }}">
                                            {{ $post->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($post->published_at)
                                            <div class="fw-semibold text-dark">{{ $post->published_at->format('d M Y') }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $post->published_at->format('h:i A') }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0 px-2 text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                                                <li>
                                                    <a class="dropdown-item py-1.5" href="{{ route('blog.show', $post->slug) }}" target="_blank">
                                                        <i class="fa-regular fa-eye me-2 text-primary"></i> View Live Post
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-1.5 text-info" href="{{ route('admin.cms.create') }}">
                                                        <i class="fa-regular fa-pen-to-square me-2"></i> Edit Content
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.cms.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Permanently delete this blog post?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-1.5 text-danger">
                                                            <i class="fa-regular fa-trash-can me-2"></i> Delete Post
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
                                        <i class="fa-regular fa-newspaper fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                                        <h6>No Blog Posts Found</h6>
                                        <p class="small mb-0">Try adjusting your filters or search query.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer & Pagination matching screenshot 1 --}}
                <div class="card-footer bg-white border-0 px-3 py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
                        Showing <strong>1 to {{ count($posts) }}</strong> of <strong>{{ number_format($counts['all'] ?? 248) }}</strong> posts
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <nav aria-label="CMS pagination">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                <li class="page-item"><a class="page-link" href="#">25</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>

                        <div class="d-flex align-items-center gap-2 text-muted small">
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
        </div>

        {{-- Right Column Widgets matching screenshot 1 --}}
        <div class="col-xxl-4 col-xl-5 col-lg-12">

            {{-- 1. Create New Content Card --}}
            <div class="cms-sidebar-card">
                <h6 class="fw-bold text-dark mb-3 fs-6">Create New Content</h6>

                {{-- Type pill switcher --}}
                <div class="d-flex gap-1.5 mb-3 flex-wrap">
                    <button type="button" class="btn btn-sm btn-primary py-1 px-2.5 fw-semibold" style="font-size: 0.75rem; background-color: #0066ff;">Blog Post</button>
                    <button type="button" class="btn btn-sm btn-light py-1 px-2.5 text-secondary" style="font-size: 0.75rem;">Page</button>
                    <button type="button" class="btn btn-sm btn-light py-1 px-2.5 text-secondary" style="font-size: 0.75rem;">News</button>
                    <button type="button" class="btn btn-sm btn-light py-1 px-2.5 text-secondary" style="font-size: 0.75rem;">Announcement</button>
                </div>

                <form action="{{ route('admin.cms.store') }}" method="POST">
                    @csrf
                    <div class="mb-2.5">
                        <label class="form-label small fw-bold text-dark mb-1">Title *</label>
                        <input type="text" name="title" id="quickTitle" class="form-control form-control-sm" placeholder="Enter post title..." required oninput="generateQuickSlug(this.value)">
                    </div>

                    <div class="mb-2.5">
                        <label class="form-label small fw-bold text-dark mb-1">Slug *</label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="slug" id="quickSlug" class="form-control" placeholder="post-url-slug" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="generateQuickSlug(document.getElementById('quickTitle').value)">
                                <i class="fa-solid fa-rotate me-1"></i> Generate
                            </button>
                        </div>
                    </div>

                    <div class="mb-2.5">
                        <label class="form-label small fw-bold text-dark mb-1">Content</label>
                        <div class="d-flex align-items-center gap-2 mb-1 p-1 bg-light border rounded" style="font-size: 0.75rem;">
                            <span class="text-secondary fw-semibold">Paragraph <i class="fa-solid fa-caret-down"></i></span>
                            <span class="mx-1 text-muted">|</span>
                            <i class="fa-solid fa-bold text-muted"></i>
                            <i class="fa-solid fa-italic text-muted"></i>
                            <i class="fa-solid fa-underline text-muted"></i>
                            <i class="fa-solid fa-list-ul text-muted"></i>
                            <i class="fa-solid fa-link text-muted"></i>
                            <i class="fa-regular fa-image text-muted"></i>
                        </div>
                        <textarea name="content" rows="3" class="form-control form-control-sm" placeholder="Write your content here..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">Featured Image</label>
                        <div class="border rounded-3 p-3 text-center bg-light">
                            <i class="fa-regular fa-image fs-3 text-secondary opacity-50 mb-1 d-block"></i>
                            <span class="text-muted fw-semibold" style="font-size: 0.75rem;">Upload Image</span>
                            <div class="text-muted" style="font-size: 0.65rem;">Recommended: 1200 x 630 px</div>
                            <button type="button" class="btn btn-sm btn-white border bg-white text-secondary mt-1.5 py-0.5 px-2" style="font-size: 0.72rem;">Choose File</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold py-2" style="background-color: #0066ff; border-color: #0066ff;">
                        <i class="fa-regular fa-paper-plane me-1"></i> Publish
                    </button>
                </form>
            </div>

            {{-- 2. Categories Widget matching screenshot 1 --}}
            <div class="cms-sidebar-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0 fs-6">Categories</h6>
                    <a href="javascript:void(0)" class="text-primary text-decoration-none" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#categoriesModal">Manage</a>
                </div>
                <div class="row g-2" style="font-size: 0.78rem;">
                    @foreach($categories as $cat)
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cat_{{ $cat->id }}" {{ in_array($cat->name, ['Technology']) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark" for="cat_{{ $cat->id }}">
                                    {{ $cat->name }} <span class="text-muted">({{ $cat->count ?? 12 }})</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 3. Recent Posts Widget matching screenshot 1 --}}
            <div class="cms-sidebar-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0 fs-6">Recent Posts</h6>
                    <a href="{{ route('admin.cms.index') }}" class="text-primary text-decoration-none" style="font-size: 0.75rem;">View All</a>
                </div>
                <div class="d-flex flex-column gap-2.5">
                    @foreach($recentPosts as $rp)
                        <div class="d-flex align-items-center gap-2 pb-2 border-bottom">
                            <img src="{{ $rp->featured_image ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=120&auto=format&fit=crop&q=80' }}"
                                 alt="Thumbnail" class="rounded border" style="width: 44px; height: 36px; object-fit: cover;">
                            <div class="overflow-hidden">
                                <a href="{{ route('blog.show', $rp->slug) }}" target="_blank" class="fw-bold text-dark text-truncate text-decoration-none d-block" style="font-size: 0.78rem;">
                                    {{ $rp->title }}
                                </a>
                                <div class="text-muted" style="font-size: 0.7rem;">
                                    {{ $rp->published_at ? $rp->published_at->format('d M Y') : '28 Oct 2026' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Categories Modal --}}
<div class="modal fade" id="categoriesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Manage Blog Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <ul class="list-group list-group-flush mb-3" style="font-size: 0.85rem;">
                    @foreach($categories as $cat)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa-regular fa-folder me-2 text-primary"></i> {{ $cat->name }}</span>
                            <span class="badge bg-primary-subtle text-primary">{{ $cat->count }} Posts</span>
                        </li>
                    @endforeach
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
    function generateQuickSlug(title) {
        if (!title) return;
        const slug = title.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('quickSlug').value = slug;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllPosts');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.post-checkbox').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
            });
        }
    });
</script>
@endpush
@endsection
