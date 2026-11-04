@extends('admin.layouts.admin')

@section('title', 'Course Approvals - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="display-heading h3 text-dark mb-1">Online Courses Verification</h2>
            <p class="text-muted small mb-0">Review submitted video batches, syllabus, pricing, and approve or reject listings.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
                <i class="fa-solid fa-clock me-1"></i> {{ $counts['pending'] }} Pending Review
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Status Filter Pills -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('admin.catalog.courses') }}" class="btn btn-sm {{ !$status ? 'btn-primary' : 'btn-light border' }}">
            All Courses ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.catalog.courses', ['status' => 'pending']) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-light border' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.catalog.courses', ['status' => 'approved']) }}" class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-light border' }}">
            Approved ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.catalog.courses', ['status' => 'rejected']) }}" class="btn btn-sm {{ $status === 'rejected' ? 'btn-danger' : 'btn-light border' }}">
            Rejected ({{ $counts['rejected'] }})
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">
                        <th class="ps-4 py-3">Course Title</th>
                        <th class="py-3">Seller / Store</th>
                        <th class="py-3">Category & Level</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Submitted</th>
                        <th class="pe-4 py-3 text-end">Verification Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $course->title }}</div>
                                <small class="text-muted">{{ Str::limit($course->short_description ?? 'No description', 45) }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $course->seller?->businessDetail?->business_name ?? $course->seller?->user?->name }}</div>
                                <span class="badge bg-light text-primary font-mono-code border">{{ $course->seller?->seller_code }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $course->category }}</span>
                                <span class="badge bg-light text-muted border">{{ $course->level }}</span>
                            </td>
                            <td>
                                @if($course->is_free)
                                    <span class="badge bg-success-subtle text-success">FREE</span>
                                @else
                                    <div class="fw-bold text-dark font-mono-code">₹{{ number_format($course->price, 2) }}</div>
                                    @if($course->discount_price)
                                        <small class="text-muted text-decoration-line-through font-mono-code">₹{{ number_format($course->discount_price, 2) }}</small>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($course->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="fa-solid fa-circle-check me-1"></i> Approved
                                    </span>
                                @elseif($course->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" title="{{ $course->rejection_reason }}">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $course->created_at->format('M d, Y') }}</small>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <!-- View Details Button -->
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewCourseModal{{ $course->id }}">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </button>

                                    @if($course->status !== 'approved')
                                        <form action="{{ route('admin.catalog.courses.approve', $course->id) }}" method="POST" onsubmit="return confirm('Approve this course and make it live in the marketplace?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                    @endif

                                    @if($course->status !== 'rejected')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $course->id }}">
                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                        </button>
                                    @endif

                                    <!-- ================= VIEW COURSE DETAILS MODAL ================= -->
                                    <div class="modal fade" id="viewCourseModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable text-start">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-bottom pb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2">
                                                            <i class="fa-solid fa-graduation-cap fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="modal-title fw-bold text-dark mb-0">{{ $course->title }}</h5>
                                                            <small class="text-muted">Submitted on {{ $course->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <!-- Status & Key Attributes -->
                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4 p-3 bg-light rounded-3">
                                                        <div>
                                                            <span class="text-muted small d-block">Status:</span>
                                                            @if($course->status === 'approved')
                                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-circle-check me-1"></i> Approved / Live
                                                                </span>
                                                            @elseif($course->status === 'rejected')
                                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                                                </span>
                                                            @else
                                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                                                    <i class="fa-solid fa-clock me-1"></i> Pending Verification
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="ms-md-3">
                                                            <span class="text-muted small d-block">Category:</span>
                                                            <span class="badge bg-white text-dark border">{{ $course->category }}</span>
                                                        </div>
                                                        <div class="ms-md-3">
                                                            <span class="text-muted small d-block">Level & Language:</span>
                                                            <span class="badge bg-white text-dark border">{{ $course->level }}</span>
                                                            <span class="badge bg-white text-dark border">{{ $course->language }}</span>
                                                        </div>
                                                        <div class="ms-md-auto text-md-end">
                                                            <span class="text-muted small d-block">Access Type:</span>
                                                            <span class="fw-semibold text-dark">{{ $course->access_type }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Seller & Pricing Grid -->
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-store text-primary me-2"></i>Seller Information</h6>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Business / Store:</span>
                                                                    <strong>{{ $course->seller?->businessDetail?->business_name ?? 'N/A' }}</strong>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Seller Code:</span>
                                                                    <span class="font-mono-code text-primary fw-bold">{{ $course->seller?->seller_code }}</span>
                                                                </div>
                                                                <div class="small mb-1">
                                                                    <span class="text-muted">Instructor Name:</span>
                                                                    <span>{{ $course->seller?->user?->name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="small">
                                                                    <span class="text-muted">Email:</span>
                                                                    <span>{{ $course->seller?->user?->email ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-indian-rupee-sign text-success me-2"></i>Pricing & Perks</h6>
                                                                <div class="d-flex align-items-baseline gap-2 mb-2">
                                                                    @if($course->is_free)
                                                                        <span class="fs-4 fw-bold text-success font-mono-code">FREE</span>
                                                                    @else
                                                                        <span class="fs-4 fw-bold text-dark font-mono-code">₹{{ number_format($course->price, 2) }}</span>
                                                                        @if($course->discount_price)
                                                                            <span class="text-muted text-decoration-line-through font-mono-code">₹{{ number_format($course->discount_price, 2) }}</span>
                                                                            @php
                                                                                $discountPct = $course->discount_price < $course->price ? round((($course->price - $course->discount_price) / $course->price) * 100) : 0;
                                                                            @endphp
                                                                            @if($discountPct > 0)
                                                                                <span class="badge bg-danger-subtle text-danger small">{{ $discountPct }}% OFF</span>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                <div class="small text-muted mb-1">
                                                                    <i class="fa-solid {{ $course->certificate_included ? 'fa-circle-check text-success' : 'fa-circle-xmark text-muted' }} me-1"></i>
                                                                    Completion Certificate Included
                                                                </div>
                                                                <div class="small text-muted">
                                                                    <i class="fa-solid {{ $course->qa_enabled ? 'fa-circle-check text-success' : 'fa-circle-xmark text-muted' }} me-1"></i>
                                                                    Discussion & Q&A Forum Enabled
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Descriptions -->
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold text-dark mb-2">Short Overview</h6>
                                                        <p class="text-muted small p-3 bg-light rounded-3 mb-0">
                                                            {{ $course->short_description ?? 'No short description provided.' }}
                                                        </p>
                                                    </div>

                                                    @if($course->description)
                                                        <div class="mb-4">
                                                            <h6 class="fw-bold text-dark mb-2">Full Course Description & Syllabus</h6>
                                                            <div class="text-muted small p-3 bg-light rounded-3" style="white-space: pre-line;">
                                                                {{ $course->description }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Curriculum / Lectures List -->
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <h6 class="fw-bold text-dark mb-0">
                                                                <i class="fa-solid fa-list-ol text-primary me-2"></i>Curriculum Content ({{ $course->contents->count() }} Lectures)
                                                            </h6>
                                                        </div>
                                                        @if($course->contents->count() > 0)
                                                            <div class="list-group rounded-3">
                                                                @foreach($course->contents as $lecture)
                                                                    <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                                                                        <div>
                                                                            <span class="badge bg-light text-dark border me-2 small">{{ $lecture->section_title }}</span>
                                                                            <span class="fw-semibold text-dark">{{ $lecture->lecture_title }}</span>
                                                                        </div>
                                                                        <span class="badge bg-secondary-subtle text-secondary font-mono-code">
                                                                            <i class="fa-regular fa-clock me-1"></i> {{ $lecture->duration ?? '10:00' }}
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-muted small p-3 bg-light rounded-3">
                                                                No individual lecture files specified.
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if($course->rejection_reason)
                                                        <div class="alert alert-danger border-0 rounded-3 mb-0">
                                                            <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Current Rejection Reason:</strong>
                                                            <small>{{ $course->rejection_reason }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-top bg-light">
                                                    <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Close</button>

                                                    @if($course->status !== 'rejected')
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $course->id }}">
                                                            <i class="fa-solid fa-xmark me-1"></i> Reject Course
                                                        </button>
                                                    @endif

                                                    @if($course->status !== 'approved')
                                                        <form action="{{ route('admin.catalog.courses.approve', $course->id) }}" method="POST" onsubmit="return confirm('Approve this course and publish to marketplace?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm px-3">
                                                                <i class="fa-solid fa-check me-1"></i> Approve Course
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog text-start">
                                            <form action="{{ route('admin.catalog.courses.reject', $course->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="small text-muted mb-2">Provide a reason so the seller can update their submission:</p>
                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="e.g. Incomplete video lectures or inaccurate syllabus content."></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">Confirm Rejection</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-video fs-2 text-muted mb-2 d-block"></i>
                                No courses found in this status.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $courses->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

