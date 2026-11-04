@extends('admin.layouts.admin')

@section('title', $moduleTitle . ' - Super Admin')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center">
        <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background-color: #f1f5f9; color: var(--admin-primary);">
            <i class="fa-solid fa-layer-group fs-1"></i>
        </div>
        <span class="badge bg-secondary-subtle text-secondary border px-3 py-1 rounded-pill mb-2 mx-auto">
            Upcoming Milestone
        </span>
        <h3 class="fw-bold text-dark mb-2">{{ $moduleTitle }}</h3>
        <p class="text-muted small max-w-500 mx-auto mb-4" style="max-width: 500px;">
            This module is structured in the platform architecture and scheduled for subsequent release phases. The current phase establishes the Super Admin Foundation, Authentication, and the Seller Approval & Permission Workflow.
        </p>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Return to Dashboard
            </a>
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-primary btn-sm px-3">
                <i class="fa-solid fa-store me-1"></i> Manage Sellers
            </a>
        </div>
    </div>
</div>
@endsection

