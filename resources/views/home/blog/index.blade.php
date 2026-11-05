@extends('layouts.app')

@section('title', 'Blog & Knowledge Hub - Digital Class Educational World')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 small text-muted">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Blog & Articles</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-1">Digital Class Knowledge Hub</h1>
                <p class="text-muted mb-0 small">Latest trends, guides, career insights, and digital strategies for students, educators & entrepreneurs.</p>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
                <form action="{{ route('blog.index') }}" method="GET" class="d-flex gap-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-start-0 ps-0 bg-white" placeholder="Search articles, guides, topics..." style="font-size: 0.875rem;">
                        <button class="btn btn-primary px-3" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- Category Filter Pills -->
    <div class="d-flex align-items-center gap-2 overflow-auto pb-2 mb-4 text-nowrap scrollbar-none" style="scrollbar-width: thin;">
        <a href="{{ route('blog.index', array_filter(['search' => $search])) }}" 
           class="btn btn-sm rounded-pill px-3 py-1 fw-medium {{ empty($selectedCat) || $selectedCat === 'All' ? 'btn-primary' : 'btn-outline-secondary bg-white' }}">
            All Topics
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('blog.index', array_filter(['category' => $cat->name, 'search' => $search])) }}" 
               class="btn btn-sm rounded-pill px-3 py-1 fw-medium {{ $selectedCat === $cat->name ? 'btn-primary' : 'btn-outline-secondary bg-white' }}">
                {{ $cat->name }}
                <span class="badge {{ $selectedCat === $cat->name ? 'bg-white text-primary' : 'bg-light text-muted' }} rounded-pill ms-1" style="font-size: 0.65rem;">
                    {{ $cat->posts_count ?? $cat->posts()->where('status', 'Published')->count() }}
                </span>
            </a>
        @endforeach
    </div>

    @if($featuredPost && empty($search) && (empty($selectedCat) || $selectedCat === 'All'))
    <!-- Featured Hero Article -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
        <div class="row g-0">
            <div class="col-lg-7 position-relative">
                <a href="{{ route('blog.show', $featuredPost->slug) }}">
                    <img src="{{ $featuredPost->featured_image_url }}" alt="{{ $featuredPost->title }}" class="img-fluid w-100 h-100 object-fit-cover" style="min-height: 320px; max-height: 420px;">
                </a>
                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm fs-7">
                    <i class="fa-solid fa-star me-1 text-warning"></i> Featured Article
                </span>
            </div>
            <div class="col-lg-5 p-4 p-xl-5 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill small">
                            {{ $featuredPost->category }}
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> {{ $featuredPost->reading_time }} min read
                        </span>
                    </div>
                    <h2 class="h4 fw-bold mb-3">
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="text-dark text-decoration-none hover-primary">
                            {{ $featuredPost->title }}
                        </a>
                    </h2>
                    <p class="text-muted small mb-4 line-clamp-3">
                        {{ $featuredPost->excerpt }}
                    </p>
                </div>

                <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2.5">
                        <img src="{{ $featuredPost->author_avatar_url }}" alt="{{ $featuredPost->author_name }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                        <div>
                            <div class="fw-semibold small text-dark">{{ $featuredPost->author_name }}</div>
                            <div class="text-muted" style="font-size: 0.72rem;">{{ $featuredPost->published_at ? $featuredPost->published_at->format('M d, Y') : 'Recent' }}</div>
                        </div>
                    </div>
                    <a href="{{ route('blog.show', $featuredPost->slug) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        Read More <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Grid -->
    <div class="row g-4">
        <!-- Posts List (Left 8 cols) -->
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 fw-bold text-dark mb-0">
                    @if(!empty($selectedCat) && $selectedCat !== 'All')
                        Articles in "{{ $selectedCat }}"
                    @elseif(!empty($search))
                        Search Results for "{{ $search }}"
                    @else
                        Recent Articles
                    @endif
                </h2>
                <span class="text-muted small">{{ $posts->total() }} Articles</span>
            </div>

            @if($posts->count() > 0)
                <div class="row g-4">
                    @foreach($posts as $post)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-lift transition-all">
                            <div class="position-relative">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-100 object-fit-cover" style="height: 190px;">
                                </a>
                                <span class="badge bg-white text-dark shadow-sm position-absolute top-0 start-0 m-2.5 px-2.5 py-1 rounded-pill small fw-semibold">
                                    {{ $post->category }}
                                </span>
                            </div>
                            <div class="card-body p-3.5 d-flex flex-column">
                                <div class="d-flex align-items-center gap-2 text-muted mb-2" style="font-size: 0.75rem;">
                                    <span><i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : 'Recent' }}</span>
                                    <span>•</span>
                                    <span><i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time }} min read</span>
                                    <span>•</span>
                                    <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($post->views) }}</span>
                                </div>
                                <h3 class="h6 fw-bold mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none hover-primary line-clamp-2">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-muted small mb-3 line-clamp-2 flex-grow-1">
                                    {{ $post->excerpt }}
                                </p>
                                <div class="pt-2.5 border-top d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $post->author_avatar_url }}" alt="{{ $post->author_name }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                                        <span class="small fw-medium text-dark text-truncate" style="max-width: 120px;">{{ $post->author_name }}</span>
                                    </div>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="small fw-semibold text-primary text-decoration-none">
                                        Read <i class="fa-solid fa-angle-right ms-0.5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4 pt-2">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4 text-center py-5 px-4 bg-white">
                    <div class="mx-auto mb-3 text-muted" style="font-size: 3rem;">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    <h3 class="h5 fw-bold text-dark">No Articles Found</h3>
                    <p class="text-muted small mb-4">We couldn't find any articles matching your search or selected category filter.</p>
                    <div>
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm">
                            Clear Filters & View All
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Sidebar (4 cols) -->
        <div class="col-lg-4">
            <!-- Popular Articles -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h3 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                    <i class="fa-solid fa-fire text-danger"></i> Most Read Articles
                </h3>
                <div class="d-flex flex-column gap-3">
                    @foreach($popularPosts as $index => $pop)
                    <div class="d-flex gap-3 align-items-center">
                        <span class="fw-bold text-muted fs-5" style="width: 22px;">0{{ $index + 1 }}</span>
                        <a href="{{ route('blog.show', $pop->slug) }}" class="flex-shrink-0">
                            <img src="{{ $pop->featured_image_url }}" alt="{{ $pop->title }}" class="rounded-3 object-fit-cover" style="width: 64px; height: 50px;">
                        </a>
                        <div class="flex-grow-1 overflow-hidden">
                            <h4 class="small fw-semibold mb-1 text-truncate">
                                <a href="{{ route('blog.show', $pop->slug) }}" class="text-dark text-decoration-none hover-primary">
                                    {{ $pop->title }}
                                </a>
                            </h4>
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.7rem;">
                                <span>{{ $pop->category }}</span>
                                <span>•</span>
                                <span><i class="fa-regular fa-eye me-0.5"></i> {{ number_format($pop->views) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Browse by Categories -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h3 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                    <i class="fa-solid fa-layer-group text-primary"></i> Browse Categories
                </h3>
                <div class="d-flex flex-column gap-2">
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->name]) }}" class="d-flex align-items-center justify-content-between p-2 rounded-3 text-decoration-none text-dark hover-bg-light transition-all {{ $selectedCat === $cat->name ? 'bg-primary-subtle text-primary fw-semibold' : '' }}">
                        <span class="small">{{ $cat->name }}</span>
                        <span class="badge bg-light text-muted rounded-pill small">{{ $cat->posts_count ?? $cat->posts()->where('status', 'Published')->count() }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Newsletter Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0066ff 0%, #0044bb 100%);">
                <div class="position-relative z-1">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white text-primary rounded-circle mb-3" style="width: 44px; height: 44px;">
                        <i class="fa-regular fa-envelope fs-5"></i>
                    </div>
                    <h3 class="h6 fw-bold mb-1">Stay Ahead in Education & Tech</h3>
                    <p class="small text-white-50 mb-3">Get the latest student guides, teacher tools & digital strategies delivered to your inbox every week.</p>
                    <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to Digital Class newsletter!'); this.reset();" class="d-flex flex-column gap-2">
                        <input type="email" required placeholder="Enter your email" class="form-control form-control-sm border-0 rounded-3 py-2 px-3 text-dark bg-white" style="font-size: 0.85rem;">
                        <button type="submit" class="btn btn-warning btn-sm rounded-3 fw-bold py-2 text-dark">
                            Subscribe Now <i class="fa-solid fa-paper-plane ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
}
.hover-primary:hover {
    color: #0066ff !important;
}
.hover-bg-light:hover {
    background-color: #f8fafc;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.transition-all {
    transition: all 0.2s ease;
}
</style>
@endsection

