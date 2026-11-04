@extends('seller.layouts.seller')

@section('title', 'My Courses - Digital Class Seller')

@section('page-title')
    <div class="d-flex align-items-center gap-2">
        <h1 class="h4 mb-0 fw-bold text-dark">My Courses</h1>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1 small">
            {{ $courses->total() }} Courses
        </span>
    </div>
@endsection

@section('header-actions')
    <a href="{{ route('seller.courses.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm" style="background-color: #0066ff;">
        <i class="fa-solid fa-plus me-1"></i> Add New Course
    </a>
@endsection

@section('content')
<div class="container-fluid px-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2 align-items-center justify-content-between">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Search courses by title or category..." id="courseSearch">
                    </div>
                </div>
                <div class="col-md-7 d-flex justify-content-md-end gap-2">
                    <span class="badge bg-light text-muted border d-flex align-items-center px-3 py-2">
                        Status: All ({{ $courses->total() }})
                    </span>
                    <a href="{{ route('seller.courses.create') }}" class="btn btn-primary btn-sm px-3" style="background-color: #0066ff;">
                        <i class="fa-solid fa-plus me-1"></i> Add New Course
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses List -->
    @if($courses->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                            <th class="ps-4 py-3">Course Info</th>
                            <th class="py-3">Category & Level</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Lectures</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                                            <i class="fa-solid fa-graduation-cap fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $course->title }}</div>
                                            <small class="text-muted">{{ Str::limit($course->short_description ?? 'No description provided', 55) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $course->category }}</span>
                                    <span class="badge bg-light text-muted border">{{ $course->level }}</span>
                                </td>
                                <td>
                                    @if($course->is_free)
                                        <span class="badge bg-success-subtle text-success fw-bold">FREE</span>
                                    @else
                                        <div class="fw-bold text-dark">₹{{ number_format($course->price, 2) }}</div>
                                        @if($course->discount_price)
                                            <small class="text-muted text-decoration-line-through">₹{{ number_format($course->discount_price, 2) }}</small>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        <i class="fa-solid fa-film me-1"></i> {{ $course->contents_count }} Lectures
                                    </span>
                                </td>
                                <td>
                                    @if($course->status === 'approved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="fa-solid fa-circle-check me-1"></i> Published
                                        </span>
                                    @elseif($course->status === 'rejected')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $course->rejection_reason }}">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="fa-solid fa-clock me-1"></i> Pending Approval
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <span class="text-muted small">
                                        {{ $course->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($courses->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State matching Screenshot -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body py-5">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-video fs-1"></i>
                </div>
                <h4 class="display-heading text-dark mb-2">No courses added yet</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 480px;">
                    Start uploading your online video lectures, notes, and curriculum. Our intuitive 5-step course builder gets you live in minutes.
                </p>
                <a href="{{ route('seller.courses.create') }}" class="btn btn-primary px-4 py-2" style="background-color: #0066ff;">
                    <i class="fa-solid fa-plus me-1"></i> Add Your First Course
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

