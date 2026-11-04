@extends('seller.layouts.seller')

@section('title', $title . ' - Seller Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center">
        <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background-color: #ecfdf5; color: #10b981;">
            <i class="fa-solid fa-circle-check fs-2"></i>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill mb-2 mx-auto">
            Authorized Active Seller
        </span>
        <h3 class="fw-bold text-dark mb-2">{{ $title }}</h3>
        <p class="text-muted small max-w-500 mx-auto mb-4">
            Your seller account (<strong>{{ Auth::user()->seller?->seller_code }}</strong>) is verified and approved by Super Admin. You have full authorization to create, upload, and publish {{ strtolower($type) }} listings.
        </p>
        <div>
            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-primary px-4">
                &larr; Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

