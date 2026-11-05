@extends('admin.layouts.admin')

@section('title', 'SEO Management - Digital Class Super Admin')

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
            <h1 class="h4 fw-bold text-dark mb-1">SEO Management</h1>
            <p class="text-muted small mb-0">Configure SEO settings for your marketplace. Manage meta tags, URLs, sitemap, schema, indexing and more.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 bg-white text-dark fw-semibold px-3 py-2">
                <i class="fa-solid fa-arrow-up-right-from-square me-1 text-muted"></i> View Website
            </a>
            <button type="button" class="btn btn-sm btn-primary rounded-3 fw-semibold px-3 py-2" onclick="document.getElementById('seoGlobalForm').submit();">
                <i class="fa-solid fa-floppy-disk me-1.5"></i> Save Settings
            </button>
        </div>
    </div>

    <!-- 6 KPI Metric Cards Row -->
    <div class="row g-3 mb-4">
        <!-- 1. Google Index Status -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-white shadow-xs border" style="width: 40px; height: 40px;">
                        <i class="fa-brands fa-google fs-5" style="color: #ea4335;"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['indexed_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Google Index Status</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['indexed_pages'] }}</div>
                <div class="text-muted" style="font-size: 0.72rem;">{{ $kpi['indexed_sub'] }}</div>
            </div>
        </div>

        <!-- 2. Total SEO Pages -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-file-lines fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Total SEO Pages</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['total_seo_pages'] }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $kpi['total_seo_sub'] }}</div>
            </div>
        </div>

        <!-- 3. Sitemap Status -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                        <i class="fa-solid fa-sitemap fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Sitemap Status</div>
                <div class="fs-4 fw-bold text-success mb-1">{{ $kpi['sitemap_status'] }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $kpi['sitemap_sub'] }}</div>
            </div>
        </div>

        <!-- 4. Robots.txt -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eff6ff; color: #0284c7;">
                        <i class="fa-solid fa-robot fs-6"></i>
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">Robots.txt</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['robots_status'] }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $kpi['robots_sub'] }}</div>
            </div>
        </div>

        <!-- 5. SEO Score -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 0.85rem;">
                        92
                    </div>
                </div>
                <div class="text-muted small fw-medium mb-1">SEO Score</div>
                <div class="fs-4 fw-bold text-success mb-1">{{ $kpi['seo_score'] }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $kpi['seo_score_label'] }}</div>
            </div>
        </div>

        <!-- 6. Organic Traffic -->
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fdf2f8; color: #db2777;">
                        <i class="fa-solid fa-chart-line fs-6"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-semibold rounded-pill small" style="font-size: 0.7rem;">
                        {{ $kpi['traffic_growth'] }}
                    </span>
                </div>
                <div class="text-muted small fw-medium mb-1">Organic Traffic</div>
                <div class="fs-4 fw-bold text-dark mb-1">{{ $kpi['organic_traffic'] }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $kpi['traffic_sub'] }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="px-3 pt-2 border-bottom d-flex align-items-center gap-2 overflow-auto scrollbar-none" style="scrollbar-width: none;">
            <a href="{{ route('admin.seo.index') }}" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small active-tab">
                <i class="fa-solid fa-gear me-1.5"></i> Global Settings
            </a>
            <a href="#courses-seo" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-graduation-cap me-1.5"></i> Courses SEO
            </a>
            <a href="#services-seo" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-briefcase me-1.5"></i> Services SEO
            </a>
            <a href="#products-seo" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-box-open me-1.5"></i> Products SEO
            </a>
            <a href="#business-seo" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-building me-1.5"></i> Business SEO
            </a>
            <a href="#categories-seo" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-folder-tree me-1.5"></i> Categories SEO
            </a>
            <a href="#sitemap" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-sitemap me-1.5"></i> Sitemap & Robots
            </a>
            <a href="#redirects" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-arrow-turn-down me-1.5"></i> Redirects
            </a>
            <a href="#schema" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-code me-1.5"></i> Schema Markup
            </a>
            <a href="#analytics" class="tab-link px-3 py-2.5 text-decoration-none fw-semibold small text-muted">
                <i class="fa-solid fa-chart-simple me-1.5"></i> SEO Analytics
            </a>
        </div>
    </div>

    <!-- 3-Column Studio Form Layout -->
    <form action="{{ route('admin.seo.update') }}" method="POST" id="seoGlobalForm">
        @csrf
        <div class="row g-4">
            <!-- 1. COLUMN 1: Global SEO Settings (4 cols) -->
            <div class="col-xl-4 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h2 class="h6 fw-bold text-dark mb-1">Global SEO Settings</h2>
                    <p class="text-muted small mb-3" style="font-size: 0.75rem;">These settings will be applied to your entire marketplace. You can also set custom settings for each section.</p>

                    <!-- Website Title -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Website Title <span class="text-danger">*</span></label>
                        <input type="text" name="site_title" id="siteTitleInput" value="{{ $seo->site_title }}" required class="form-control form-control-sm bg-light">
                    </div>

                    <!-- Website Tagline -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Website Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $seo->site_tagline }}" class="form-control form-control-sm bg-light">
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Meta Description <span class="text-danger">*</span></label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="metaDescCount">{{ strlen($seo->meta_description) }}/160</span>
                        </div>
                        <textarea name="meta_description" id="metaDescInput" rows="3" maxlength="160" required class="form-control bg-light small" style="font-size: 0.8rem;">{{ $seo->meta_description }}</textarea>
                    </div>

                    <!-- Default Keywords -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0">Default Keywords</label>
                            <span class="text-muted" style="font-size: 0.72rem;" id="keywordsCount">{{ strlen($seo->default_keywords) }}/200</span>
                        </div>
                        <textarea name="default_keywords" id="keywordsInput" rows="2" maxlength="200" class="form-control bg-light small" style="font-size: 0.8rem;">{{ $seo->default_keywords }}</textarea>
                    </div>

                    <!-- Default Social Share Image -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Default Social Share Image</label>
                        <div class="d-flex align-items-center gap-2.5 p-2 rounded-3 border bg-light">
                            <img src="{{ $seo->social_image_url }}" alt="Social Share Preview" class="rounded-2 object-fit-cover shadow-xs border flex-shrink-0" style="width: 60px; height: 38px;">
                            <div class="flex-grow-1">
                                <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 rounded-2 small mb-1" onclick="alert('Image upload dialog');">
                                    <i class="fa-solid fa-arrows-rotate me-1"></i> Change Image
                                </button>
                                <div class="text-muted" style="font-size: 0.65rem;">Recommended size: 1200 x 630 px (PNG/JPG)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Default Favicon -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Default Favicon</label>
                        <div class="d-flex align-items-center gap-2.5 p-2 rounded-3 border bg-light">
                            <div class="rounded-2 bg-dark text-warning fw-bold d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                DC
                            </div>
                            <div class="flex-grow-1">
                                <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 rounded-2 small mb-1" onclick="alert('Favicon upload dialog');">
                                    <i class="fa-solid fa-arrows-rotate me-1"></i> Change Favicon
                                </button>
                                <div class="text-muted" style="font-size: 0.65rem;">Recommended size: 32 x 32 px (ICO/PNG)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Robots & Canonical -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Default Meta Robots</label>
                            <select name="meta_robots" class="form-select form-select-sm bg-light">
                                <option value="Index, Follow" {{ $seo->meta_robots === 'Index, Follow' ? 'selected' : '' }}>Index, Follow</option>
                                <option value="NoIndex, Follow" {{ $seo->meta_robots === 'NoIndex, Follow' ? 'selected' : '' }}>NoIndex, Follow</option>
                                <option value="Index, NoFollow" {{ $seo->meta_robots === 'Index, NoFollow' ? 'selected' : '' }}>Index, NoFollow</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Default Canonical</label>
                            <select name="canonical_mode" class="form-select form-select-sm bg-light">
                                <option value="Auto Generated" {{ $seo->canonical_mode === 'Auto Generated' ? 'selected' : '' }}>Auto Generated</option>
                                <option value="Self Referencing" {{ $seo->canonical_mode === 'Self Referencing' ? 'selected' : '' }}>Self Referencing</option>
                            </select>
                        </div>
                    </div>

                    <!-- Toggles -->
                    <div class="pt-2 border-top d-flex flex-column gap-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="small fw-semibold text-dark">Enable Open Graph Tags</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="enable_open_graph" value="1" role="switch" {{ $seo->enable_open_graph ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="small fw-semibold text-dark">Enable Twitter Card</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="enable_twitter_card" value="1" role="switch" {{ $seo->enable_twitter_card ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="small fw-semibold text-dark">Enable Breadcrumbs</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="enable_breadcrumbs" value="1" role="switch" {{ $seo->enable_breadcrumbs ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="small fw-semibold text-dark">Enable JSON-LD Schema</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="enable_json_ld" value="1" role="switch" {{ $seo->enable_json_ld ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. COLUMN 2: SEO URL & Meta Templates (4 cols) -->
            <div class="col-xl-4 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h2 class="h6 fw-bold text-dark mb-1">SEO URL & Meta Templates</h2>
                    <p class="text-muted small mb-3" style="font-size: 0.75rem;">Use dynamic variables to automatically generate SEO meta tags for different pages.</p>

                    <!-- Section Tabs -->
                    <div class="d-flex align-items-center gap-1.5 overflow-auto pb-2 mb-3 scrollbar-none" style="scrollbar-width: none;">
                        <button type="button" class="btn btn-xs btn-primary rounded-pill px-3 py-1 fw-semibold">Courses</button>
                        <button type="button" class="btn btn-xs btn-light text-muted rounded-pill px-3 py-1">Services</button>
                        <button type="button" class="btn btn-xs btn-light text-muted rounded-pill px-3 py-1">Products</button>
                        <button type="button" class="btn btn-xs btn-light text-muted rounded-pill px-3 py-1 text-nowrap">Business Listings</button>
                        <button type="button" class="btn btn-xs btn-light text-muted rounded-pill px-3 py-1">Categories</button>
                    </div>

                    <!-- Course Page Template Accordion Box -->
                    <div class="border rounded-3 p-3 bg-light mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-dark small">Course Page Template</span>
                            <i class="fa-solid fa-chevron-up text-primary small"></i>
                        </div>

                        <!-- Page Title Template -->
                        <div class="mb-2.5">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label small fw-semibold text-dark mb-0">Page Title Template <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-link p-0 text-primary small text-decoration-none" style="font-size: 0.68rem;" onclick="alert('Variables: {course_name}, {institute_name}, {category_name}, {price}');">
                                    Available Variables <i class="fa-solid fa-chevron-right ms-0.5"></i>
                                </button>
                            </div>
                            <input type="text" name="course_title_template" id="tplTitleInput" value="{{ $seo->course_title_template }}" required class="form-control form-control-sm bg-white font-monospace" style="font-size: 0.75rem;">
                        </div>

                        <!-- Meta Description Template -->
                        <div class="mb-2.5">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label small fw-semibold text-dark mb-0">Meta Description Template <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-link p-0 text-primary small text-decoration-none" style="font-size: 0.68rem;" onclick="alert('Variables: {course_name}, {institute_name}, {duration}, {price}');">
                                    Available Variables <i class="fa-solid fa-chevron-right ms-0.5"></i>
                                </button>
                            </div>
                            <textarea name="course_description_template" id="tplDescInput" rows="2" required class="form-control bg-white font-monospace small" style="font-size: 0.75rem;">{{ $seo->course_description_template }}</textarea>
                        </div>

                        <!-- URL Structure -->
                        <div class="mb-2.5">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label small fw-semibold text-dark mb-0">URL Structure</label>
                                <button type="button" class="btn btn-link p-0 text-primary small text-decoration-none" style="font-size: 0.68rem;">
                                    Available Variables <i class="fa-solid fa-chevron-right ms-0.5"></i>
                                </button>
                            </div>
                            <input type="text" name="course_url_template" id="tplUrlInput" value="{{ $seo->course_url_template }}" class="form-control form-control-sm bg-white font-monospace" style="font-size: 0.75rem;">
                        </div>

                        <!-- Focus Keywords (Auto) -->
                        <div>
                            <label class="form-label small fw-semibold text-dark mb-1">Focus Keywords (Auto)</label>
                            <input type="text" name="course_focus_keywords" value="{{ $seo->course_focus_keywords }}" class="form-control form-control-sm bg-white font-monospace" style="font-size: 0.75rem;">
                        </div>
                    </div>

                    <!-- Collapsed Template Rows -->
                    <div class="d-flex flex-column gap-2 mb-3">
                        <div class="p-2.5 rounded-3 border bg-white d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="alert('Category template configuration');">
                            <span class="small fw-semibold text-dark">Course Category Template</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </div>
                        <div class="p-2.5 rounded-3 border bg-white d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="alert('Subcategory template configuration');">
                            <span class="small fw-semibold text-dark">Course Subcategory Template</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </div>
                        <div class="p-2.5 rounded-3 border bg-white d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="alert('Institute page template configuration');">
                            <span class="small fw-semibold text-dark">Course Institute Page Template</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </div>
                        <div class="p-2.5 rounded-3 border bg-white d-flex align-items-center justify-content-between" style="cursor: pointer;" onclick="alert('Search page template configuration');">
                            <span class="small fw-semibold text-dark">Course Search Page Template</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </div>
                    </div>

                    <!-- 5 Bottom Action / Utility Cards Row -->
                    <div class="row g-2 pt-2 border-top">
                        <!-- XML Sitemap -->
                        <div class="col-6">
                            <div class="p-2.5 rounded-3 border bg-light h-100">
                                <div class="d-flex align-items-center gap-1.5 mb-1">
                                    <i class="fa-solid fa-sitemap text-primary fs-7"></i>
                                    <span class="fw-bold small text-dark">XML Sitemap</span>
                                </div>
                                <div class="text-muted" style="font-size: 0.65rem;">Auto-generate sitemap for all pages.</div>
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-xs btn-outline-primary py-0.5 px-2 rounded-2" onclick="document.getElementById('sitemapGenForm').submit();">Generate Sitemap</button>
                                </div>
                            </div>
                        </div>

                        <!-- Robots.txt -->
                        <div class="col-6">
                            <div class="p-2.5 rounded-3 border bg-light h-100">
                                <div class="d-flex align-items-center gap-1.5 mb-1">
                                    <i class="fa-solid fa-robot text-info fs-7"></i>
                                    <span class="fw-bold small text-dark">Robots.txt</span>
                                </div>
                                <div class="text-muted" style="font-size: 0.65rem;">Manage robots.txt for search engines.</div>
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-xs btn-outline-secondary py-0.5 px-2 rounded-2" onclick="alert('Robots.txt is configured and live.');">Edit Robots.txt</button>
                                </div>
                            </div>
                        </div>

                        <!-- Indexing Control -->
                        <div class="col-6">
                            <div class="p-2.5 rounded-3 border bg-light h-100">
                                <div class="d-flex align-items-center gap-1.5 mb-1">
                                    <i class="fa-solid fa-toggle-on text-success fs-7"></i>
                                    <span class="fw-bold small text-dark">Indexing Control</span>
                                </div>
                                <div class="text-muted" style="font-size: 0.65rem;">Control which pages can be indexed.</div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-xs btn-light border py-0.5 px-2 rounded-2 text-dark">Manage Indexing</button>
                                </div>
                            </div>
                        </div>

                        <!-- 301 Redirects -->
                        <div class="col-6">
                            <div class="p-2.5 rounded-3 border bg-light h-100">
                                <div class="d-flex align-items-center gap-1.5 mb-1">
                                    <i class="fa-solid fa-link text-warning-emphasis fs-7"></i>
                                    <span class="fw-bold small text-dark">301 Redirects</span>
                                </div>
                                <div class="text-muted" style="font-size: 0.65rem;">Manage URL redirects. Total: 24.</div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-xs btn-light border py-0.5 px-2 rounded-2 text-dark">Manage Redirects</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. COLUMN 3: SEO Preview (Course Page) (4 cols) -->
            <div class="col-xl-4 col-lg-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h2 class="h6 fw-bold text-dark mb-3">SEO Preview (Course Page)</h2>

                    <!-- Preview Tabs -->
                    <div class="d-flex align-items-center gap-1 mb-3">
                        <button type="button" class="btn btn-xs btn-primary rounded-pill px-3 py-1 fw-semibold" id="prevGoogleBtn" onclick="switchPreviewMode('google')">Google Search</button>
                        <button type="button" class="btn btn-xs btn-light text-muted rounded-pill px-3 py-1" id="prevSocialBtn" onclick="switchPreviewMode('social')">Social Share</button>
                        <button type="button" class="btn btn-xs btn-light text-muted rounded-pill px-3 py-1" id="prevSchemaBtn" onclick="switchPreviewMode('schema')">Schema Markup</button>
                    </div>

                    <!-- Live Google SERP Snippet Preview Box -->
                    <div class="p-3 rounded-3 border bg-white shadow-xs mb-3" id="googleSerpBox">
                        <!-- URL with favicon -->
                        <div class="d-flex align-items-center gap-2 mb-1.5">
                            <div class="rounded-circle bg-dark text-white fw-bold d-flex align-items-center justify-content-center" style="width: 18px; height: 18px; font-size: 0.55rem;">DC</div>
                            <div class="text-muted small text-truncate" style="font-size: 0.72rem;" id="serpUrlDisplay">
                                https://www.digitalclass.in &rsaquo; course &rsaquo; web-development
                            </div>
                        </div>

                        <!-- Title in Google Blue -->
                        <div class="row g-2 align-items-center">
                            <div class="col-8">
                                <h3 class="fw-medium mb-1 text-decoration-none lh-sm" style="color: #1a0dab; font-size: 0.95rem; cursor: pointer;" id="serpTitleDisplay">
                                    Complete Web Development Course Online | VCEC | Digital Class
                                </h3>
                                <p class="text-muted mb-0 lh-sm" style="font-size: 0.75rem; color: #4d5156 !important;" id="serpDescDisplay">
                                    Learn complete web development course online from VCEC. Course duration: 3 months. Fees: ₹5,000. Enroll now on Digital Class.
                                </p>
                            </div>
                            <div class="col-4 text-center">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=120&q=80" alt="Course" class="rounded-3 img-fluid shadow-xs object-fit-cover" style="height: 62px; width: 100%;">
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Preview with Sample Data Form -->
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="d-flex align-items-center gap-1.5 mb-2.5 text-success small fw-semibold">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Preview with sample data</span>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label text-muted small mb-0.5" style="font-size: 0.68rem;">Course Name</label>
                                <input type="text" id="sampleCourse" value="Web Development" class="form-control form-control-sm bg-white" style="font-size: 0.78rem;">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small mb-0.5" style="font-size: 0.68rem;">Institute Name</label>
                                <input type="text" id="sampleInstitute" value="VCEC" class="form-control form-control-sm bg-white" style="font-size: 0.78rem;">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small mb-0.5" style="font-size: 0.68rem;">Duration</label>
                                <input type="text" id="sampleDuration" value="3 Months" class="form-control form-control-sm bg-white" style="font-size: 0.78rem;">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small mb-0.5" style="font-size: 0.68rem;">Price</label>
                                <input type="text" id="samplePrice" value="₹5,000" class="form-control form-control-sm bg-white" style="font-size: 0.78rem;">
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-3 fw-semibold py-1.5" style="font-size: 0.75rem;" onclick="updateSerpPreview()">
                            <i class="fa-solid fa-arrows-rotate me-1"></i> Update Preview
                        </button>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold py-2">
                            <i class="fa-solid fa-floppy-disk me-1.5"></i> Save SEO Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Hidden Sitemap Form -->
<form action="{{ route('admin.seo.sitemap') }}" method="POST" id="sitemapGenForm" class="d-none">
    @csrf
</form>

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
    const metaDesc = document.getElementById('metaDescInput');
    const keywords = document.getElementById('keywordsInput');

    if (metaDesc) {
        metaDesc.addEventListener('input', function () {
            document.getElementById('metaDescCount').textContent = this.value.length + '/160';
        });
    }

    if (keywords) {
        keywords.addEventListener('input', function () {
            document.getElementById('keywordsCount').textContent = this.value.length + '/200';
        });
    }
});

function updateSerpPreview() {
    const course = document.getElementById('sampleCourse').value || 'Course Title';
    const inst = document.getElementById('sampleInstitute').value || 'Institute';
    const dur = document.getElementById('sampleDuration').value || '3 Months';
    const price = document.getElementById('samplePrice').value || '₹5,000';

    const tplTitle = document.getElementById('tplTitleInput').value || '{course_name} Online Course | {institute_name} | Digital Class';
    const tplDesc = document.getElementById('tplDescInput').value || 'Learn {course_name} online from {institute_name}. Course duration: {duration}. Fees: {price}. Enroll now on Digital Class.';
    const tplUrl = document.getElementById('tplUrlInput').value || '/course/{course_slug}';

    const slug = course.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');

    const finalTitle = tplTitle.replace('{course_name}', course).replace('{institute_name}', inst);
    const finalDesc = tplDesc.replace('{course_name}', course).replace('{institute_name}', inst).replace('{duration}', dur).replace('{price}', price);
    const finalUrl = 'https://www.digitalclass.in › ' + tplUrl.replace('/course/', 'course › ').replace('{course_slug}', slug);

    document.getElementById('serpTitleDisplay').textContent = finalTitle;
    document.getElementById('serpDescDisplay').textContent = finalDesc;
    document.getElementById('serpUrlDisplay').textContent = finalUrl;
}

function switchPreviewMode(mode) {
    ['prevGoogleBtn', 'prevSocialBtn', 'prevSchemaBtn'].forEach(b => {
        document.getElementById(b).className = 'btn btn-xs btn-light text-muted rounded-pill px-3 py-1';
    });

    const active = document.getElementById('prev' + mode.charAt(0).toUpperCase() + mode.slice(1) + 'Btn');
    if (active) active.className = 'btn btn-xs btn-primary rounded-pill px-3 py-1 fw-semibold';

    if (mode === 'social') {
        alert('Showing social Open Graph and Twitter Card card preview simulation.');
    } else if (mode === 'schema') {
        alert('JSON-LD schema structured data: Valid Course schema detected.');
    }
}
</script>
@endsection

