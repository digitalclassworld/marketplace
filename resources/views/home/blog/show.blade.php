@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title . ' - Digital Class')

@section('content')
<div class="bg-light py-3 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small text-muted">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Blog & Articles</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index', ['category' => $post->category]) }}" class="text-decoration-none text-muted">{{ $post->category }}</a></li>
                <li class="breadcrumb-item active text-primary fw-semibold text-truncate" style="max-width: 320px;" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<article class="container py-4 py-lg-5">
    <div class="row g-4 justify-content-center">
        <!-- Article Main Content (8 cols) -->
        <div class="col-lg-8">
            <!-- Article Header -->
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1.5 rounded-pill small">
                        {{ $post->category }}
                    </span>
                    @if($post->is_featured)
                        <span class="badge bg-warning-subtle text-warning-emphasis fw-semibold px-2.5 py-1 rounded-pill small">
                            <i class="fa-solid fa-star me-1 text-warning"></i> Featured
                        </span>
                    @endif
                    <span class="text-muted small ms-auto">
                        <i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time }} min read
                    </span>
                </div>

                <h1 class="h2 fw-bold text-dark lh-sm mb-3">
                    {{ $post->title }}
                </h1>

                @if($post->excerpt)
                    <p class="lead text-muted fs-6 mb-4">
                        {{ $post->excerpt }}
                    </p>
                @endif

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3 pb-3 border-top border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $post->author_avatar_url }}" alt="{{ $post->author_name }}" class="rounded-circle shadow-sm" style="width: 44px; height: 44px; object-fit: cover;">
                        <div>
                            <div class="fw-bold text-dark small">{{ $post->author_name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                Published on {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 text-muted small">
                        <span><i class="fa-regular fa-eye me-1 text-primary"></i> {{ number_format($post->views) }} views</span>
                        <span><i class="fa-regular fa-comment me-1 text-info"></i> {{ $post->comments->where('is_approved', true)->count() }} comments</span>
                        <!-- Social Share -->
                        <div class="d-flex align-items-center gap-1 ms-2">
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-light rounded-circle text-success" title="Share on WhatsApp" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm btn-light rounded-circle text-primary" title="Share on LinkedIn" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Article link copied to clipboard!');" class="btn btn-sm btn-light rounded-circle text-secondary" title="Copy Link" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-100 object-fit-cover" style="max-height: 440px;">
            </div>

            <!-- Article Body Content -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
                <div class="article-content fs-6 lh-lg text-dark">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <!-- Tags -->
                @if(!empty($post->tags) && count($post->tags) > 0)
                <div class="pt-4 mt-4 border-top">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="small fw-bold text-muted me-1"><i class="fa-solid fa-tags me-1"></i> Tags:</span>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}" class="badge bg-light text-dark border text-decoration-none px-2.5 py-1.5 rounded-pill small fw-normal hover-primary">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Author Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $post->author_avatar_url }}" alt="{{ $post->author_name }}" class="rounded-circle" style="width: 58px; height: 58px; object-fit: cover;">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="h6 fw-bold text-dark mb-0">{{ $post->author_name }}</h3>
                            <span class="badge bg-primary-subtle text-primary rounded-pill small" style="font-size: 0.65rem;">Author</span>
                        </div>
                        <p class="text-muted small mb-0 mt-1">Content Editor & Educational Researcher at Digital Class Educational World.</p>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white" id="comments">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <h3 class="h5 fw-bold text-dark mb-0">
                        Discussion ({{ $post->comments->where('is_approved', true)->count() }})
                    </h3>
                    <span class="text-muted small">Join the conversation</span>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 small mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Comments List -->
                <div class="d-flex flex-column gap-3 mb-5">
                    @forelse($post->comments->where('is_approved', true) as $comment)
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold small" style="width: 32px; height: 32px;">
                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold text-dark small">{{ $comment->name }}</span>
                            </div>
                            <span class="text-muted small" style="font-size: 0.75rem;">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-muted small mb-0 ps-4 ms-2">
                            {{ $comment->comment }}
                        </p>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted small">
                        <i class="fa-regular fa-comments fs-3 mb-2 d-block text-secondary"></i>
                        No comments yet. Be the first to share your thoughts!
                    </div>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                @if($post->allow_comments)
                <div class="pt-3 border-top">
                    <h4 class="h6 fw-bold text-dark mb-3">Leave a Reply</h4>
                    <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" required class="form-control form-control-sm bg-light" placeholder="e.g. Rahul Sharma">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Your Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" required class="form-control form-control-sm bg-light" placeholder="e.g. rahul@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark">Your Comment <span class="text-danger">*</span></label>
                                <textarea name="comment" rows="4" required class="form-control bg-light" placeholder="Share your feedback, question, or thought..."></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill fw-semibold">
                            Post Comment <i class="fa-solid fa-paper-plane ms-1"></i>
                        </button>
                    </form>
                </div>
                @else
                <div class="alert alert-light text-muted small mb-0 text-center">
                    Comments are closed for this article.
                </div>
                @endif
            </div>

            <!-- Related Articles -->
            @if($relatedPosts->count() > 0)
            <div>
                <h3 class="h5 fw-bold text-dark mb-3">Related Articles</h3>
                <div class="row g-3">
                    @foreach($relatedPosts as $rel)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-lift">
                            <a href="{{ route('blog.show', $rel->slug) }}">
                                <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}" class="w-100 object-fit-cover" style="height: 130px;">
                            </a>
                            <div class="card-body p-3 d-flex flex-column">
                                <span class="badge bg-light text-primary align-self-start small mb-2">{{ $rel->category }}</span>
                                <h4 class="small fw-bold mb-2 line-clamp-2">
                                    <a href="{{ route('blog.show', $rel->slug) }}" class="text-dark text-decoration-none hover-primary">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                                <div class="mt-auto text-muted" style="font-size: 0.7rem;">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $rel->reading_time }} min read
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column (4 cols) -->
        <div class="col-lg-4">
            <!-- Share Widget -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h3 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom">Share Article</h3>
                <div class="d-flex flex-column gap-2">
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-3 text-start d-flex align-items-center justify-content-between">
                        <span><i class="fa-brands fa-whatsapp me-2 fs-5"></i> Share on WhatsApp</span>
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-3 text-start d-flex align-items-center justify-content-between">
                        <span><i class="fa-brands fa-linkedin me-2 fs-5"></i> Share on LinkedIn</span>
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Article link copied to clipboard!');" class="btn btn-outline-secondary btn-sm rounded-3 text-start d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-link me-2"></i> Copy Article Link</span>
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h3 class="h6 fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                    <i class="fa-solid fa-layer-group text-primary"></i> Browse Categories
                </h3>
                <div class="d-flex flex-column gap-1.5">
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->name]) }}" class="d-flex align-items-center justify-content-between p-2 rounded-3 text-decoration-none text-dark hover-bg-light transition-all {{ $post->category === $cat->name ? 'bg-primary-subtle text-primary fw-semibold' : '' }}">
                        <span class="small">{{ $cat->name }}</span>
                        <span class="badge bg-light text-muted rounded-pill small">{{ $cat->posts_count ?? $cat->posts()->where('status', 'Published')->count() }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- CTA Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="fa-solid fa-graduation-cap fs-4"></i>
                </div>
                <h4 class="h6 fw-bold text-dark mb-2">Want to Learn with Experts?</h4>
                <p class="text-muted small mb-3">Explore verified courses, coaching classes and institutes on Digital Class Marketplace.</p>
                <a href="{{ route('courses') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                    Explore Courses <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</article>

<style>
.article-content {
    line-height: 1.85;
    color: #1e293b;
    font-size: 1.05rem;
}
.article-content p {
    margin-bottom: 1.4rem;
}
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
.transition-all {
    transition: all 0.2s ease;
}
</style>
@endsection

