@extends('admin.layouts.admin')

@section('title', 'Roles & Permissions - Super Admin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                Roles & Permissions Management
            </h2>
            <p class="text-secondary small mb-0">Role-based access control (RBAC), administrative staff assignment, and module permissions matrix.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-primary btn-sm px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5 rounded-pill shadow-sm" style="background-color: #0066ff;" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="fa-solid fa-user-plus"></i>
                <span>Add Staff Member</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2.5 mb-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Roles Grid Cards -->
    <div class="row g-3 mb-4">
        @foreach($roles as $role)
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-{{ $role['badge'] }}-subtle text-{{ $role['badge'] }} fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                {{ $role['staff_count'] }} Active Staff
                            </span>
                            <span class="text-muted small"><i class="fa-solid fa-shield-halved"></i></span>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">{{ $role['name'] }}</h6>
                        <p class="text-muted small mb-3" style="font-size: 0.75rem; line-height: 1.4;">{{ $role['description'] }}</p>
                    </div>

                    <div>
                        <div class="d-flex flex-wrap gap-1 border-top pt-2.5">
                            @foreach($role['permissions'] as $perm)
                                <span class="badge bg-light text-secondary border px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-check text-success me-0.5"></i> {{ $perm }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Staff Members List Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-0 fs-6">Administrative Staff Members</h5>
                <span class="text-muted small">Current users with backoffice administration permissions</span>
            </div>
            <span class="badge bg-primary text-white rounded-pill px-2.5 py-1">{{ $admins->count() }} Staff</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                <thead class="bg-light text-muted small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-3 py-3">Staff Name</th>
                        <th class="py-3">Email Address</th>
                        <th class="py-3">Role Assigned</th>
                        <th class="py-3">Access Level</th>
                        <th class="py-3">Date Added</th>
                        <th class="pe-3 py-3 text-end">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($admins as $admin)
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $admin->name }}</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">User ID: #{{ $admin->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 font-monospace text-secondary" style="font-size: 0.8rem;">
                                {{ $admin->email }}
                            </td>
                            <td class="py-3">
                                @if($admin->role === 'superadmin')
                                    <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-crown me-1"></i> Super Admin
                                    </span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-user-shield me-1"></i> Administrator
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">
                                    Full Read/Write
                                </span>
                            </td>
                            <td class="py-3 text-muted" style="font-size: 0.78rem;">
                                {{ $admin->created_at ? $admin->created_at->format('d M Y') : 'System Initial' }}
                            </td>
                            <td class="pe-3 py-3 text-end">
                                <span class="badge bg-success text-white px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">Active</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No staff members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Add Staff Member -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title fw-bold text-dark fs-6">Add Administrative Staff Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Staff Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Priyank Patel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Official Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="priyank@digitalclassworld.in" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Role & Permission Tier <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Administrator (Operations & Catalog)</option>
                            <option value="superadmin">Super Administrator (Full System Access)</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-dark">Initial Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required minlength="6">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4" style="background-color: #0066ff;">Create Staff Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
