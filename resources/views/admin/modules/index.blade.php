@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Modules & Feature Switches</h2>
            <p class="text-muted small mb-0">Dynamically toggle core marketplace vertical pillars, registration workflows, and platform capabilities.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-6 fw-semibold">
                <i class="bi bi-toggle2-on me-1"></i> {{ $activeCount }} / {{ $totalCount }} Modules Active
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Module Grid -->
    <div class="row g-4">
        @foreach($modules as $key => $module)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-card" style="border-left: 4px solid {{ $module['enabled'] ? '#0066ff' : '#cbd5e1' }} !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="rounded-3 p-3 {{ $module['enabled'] ? 'bg-primary bg-opacity-10 text-primary' : 'bg-light text-muted' }}">
                                    <i class="bi {{ $module['icon'] }} fs-3"></i>
                                </div>
                                <span class="badge {{ $module['enabled'] ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-secondary bg-opacity-10 text-secondary' }} px-3 py-1 rounded-pill">
                                    {{ $module['enabled'] ? 'Active' : 'Disabled' }}
                                </span>
                            </div>

                            <span class="badge bg-light text-muted small mb-2 border">{{ $module['category'] }}</span>
                            <h5 class="fw-bold text-dark mb-2">{{ $module['name'] }}</h5>
                            <p class="text-muted small mb-4" style="min-height: 40px;">{{ $module['description'] }}</p>
                        </div>

                        <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                            <span class="small fw-medium {{ $module['enabled'] ? 'text-success' : 'text-muted' }}">
                                <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>
                                {{ $module['enabled'] ? 'Serving Public Traffic' : 'Temporarily Offline' }}
                            </span>
                            <form method="POST" action="{{ route('admin.modules.toggle', $key) }}" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $module['enabled'] ? 'btn-outline-danger' : 'btn-outline-primary' }} rounded-pill px-3 fw-semibold">
                                    @if($module['enabled'])
                                        <i class="bi bi-power me-1"></i> Deactivate
                                    @else
                                        <i class="bi bi-check-lg me-1"></i> Activate
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick info callout -->
    <div class="card border-0 shadow-sm rounded-4 mt-4 bg-light">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            <div class="rounded-circle p-3 bg-primary text-white">
                <i class="bi bi-info-circle-fill fs-4"></i>
            </div>
            <div>
                <h6 class="fw-bold text-dark mb-1">How Feature Switches Work</h6>
                <p class="text-muted small mb-0">Deactivating a module hides customer navigation links and blocks new submissions instantly without dropping existing database records or historical order data.</p>
            </div>
        </div>
    </div>
</div>
@endsection
