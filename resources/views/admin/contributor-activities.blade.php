@extends('layouts.app')

@section('page-title', 'Contributor Management')
@section('page-subtitle', 'Monitor and manage contributors and their activities')

@section('content')

<div class="container py-4" style="max-width: 1200px; min-height: calc(100vh - 80px);">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #0d3b66;">
                <i class="fa fa-users me-2"></i>Contributor Activities
            </h1>
            <p class="text-muted mb-0">Monitor and manage contributor uploads and activity.</p>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <form method="GET" action="{{ route('admin.contributor-activities') }}" class="admin-card card border-0 mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Status</label>
                    <select class="form-select" name="status">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ ($status ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted">Sort By</label>
                    <select class="form-select" name="sort">
                        <option value="upload_desc" {{ ($sort ?? '') === 'upload_desc' ? 'selected' : '' }}>Most Uploads</option>
                        <option value="upload_asc" {{ ($sort ?? '') === 'upload_asc' ? 'selected' : '' }}>Fewest Uploads</option>
                        <option value="recent" {{ ($sort ?? '') === 'recent' ? 'selected' : '' }}>Most Recent Upload</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted">Search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{ $q ?? '' }}"
                               placeholder="Search contributors (name/email)...">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-2 d-grid">
                    <a href="{{ route('admin.contributor-activities') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-times me-1"></i>Clear
                    </a>
                </div>
            </div>
        </div>
    </form>

    <!-- Contributor Statistics -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-lg-6">
            <div class="admin-card card border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-3">Total Contributors</h6>
                    <h1 class="display-5 fw-bold text-primary mb-2">{{ $summary['totalContributors'] ?? 0 }}</h1>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="admin-card card border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-3">Total Uploads</h6>
                    <h1 class="display-5 fw-bold text-success mb-2">{{ $summary['totalUploads'] ?? 0 }}</h1>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="admin-card card border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-3">Avg. Resources/Contributor</h6>
                    <h1 class="display-5 fw-bold text-warning mb-2">{{ $summary['avgPerUser'] ?? 0 }}</h1>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="admin-card card border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-3">Pending Review (Resources)</h6>
                    <h1 class="display-5 fw-bold text-danger mb-2">{{ $summary['pendingReview'] ?? 0 }}</h1>
                    <div class="small">
                        <a href="{{ route('admin.reviews') }}" class="text-decoration-none">
                            Review now <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @if(($summary['pendingReview'] ?? 0) === 0)
                        <small class="text-muted d-block mt-2">Add review_status column to resources to enable this.</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contributors Table -->
    <div class="admin-card card border-0">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-list me-2"></i>Contributors List
                <span class="badge bg-primary ms-2">{{ $contributors->total() }}</span>
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Contributor</th>
                            <th>Status</th>
                            <th>Uploads</th>
                            <th>Last Upload</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($contributors as $c)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="https://ui-avatars.com/api/?name={{ urlencode($c->name ?? 'User') }}&background=0d3b66&color=fff&size=40"
                                            class="rounded-circle me-3" width="40" height="40" alt="avatar"
                                        >
                                        <div>
                                            <div class="fw-bold">{{ $c->name ?? '(No Name)' }}</div>
                                            <small class="text-muted">{{ $c->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if(($c->account_status ?? 'active') === 'suspended')
                                        <span class="badge bg-danger">Suspended</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-primary">{{ $c->uploads }}</span>
                                </td>

                                <td>
                                    {{ $c->last_upload_at ? \Carbon\Carbon::parse($c->last_upload_at)->diffForHumans() : '-' }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-outline-primary"
                                       href="{{ route('admin.showUser', $c->id) }}" title="View User">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-outline-warning"
                                       href="{{ route('admin.editUser', $c->id) }}" title="Edit User">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No contributors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0">
            {{ $contributors->links() }}
        </div>
    </div>

</div>
@endsection
