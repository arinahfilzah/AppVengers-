{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4" style="max-width: 1200px; min-height: calc(100vh - 80px);">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">Dashboard Overview</h1>
                    <p class="text-muted mb-0">Summary of system statistics and activities</p>
                </div>
                <div>
                    <span class="badge bg-primary">
                        Last updated: {{ now()->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ number_format($stats['totalUsers'] ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-user-edit fa-2x text-success"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ number_format($stats['totalContributors'] ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Contributors</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-file-upload fa-2x text-info"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ number_format($stats['totalUploads'] ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Uploads</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-user-clock fa-2x text-warning"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ number_format($stats['activeUsers'] ?? 0) }}</h2>
                    <p class="text-muted mb-0">Active Users (24h)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contributor Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line text-primary me-2"></i>Contributor Activities
                        </h5>
                        <a href="{{ route('admin.contributor-activities') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Upload Count</th>
                                    <th>Last Activity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse(($stats['topContributors'] ?? []) as $c)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($c->name ?? 'User') }}&background=667eea&color=fff&rounded=true"
                                                    class="rounded-circle me-3" width="40" height="40" alt="{{ $c->name }}">
                                                <div>
                                                    <strong>{{ $c->name ?? '-' }}</strong>
                                                    <div class="text-muted small">Contributor</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $c->email }}</td>

                                        <td>
                                            <span class="badge bg-primary">
                                                {{ (int) ($c->upload_count ?? 0) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if(!empty($c->last_activity_at))
                                                {{ \Carbon\Carbon::parse($c->last_activity_at)->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if(($c->account_status ?? 'active') === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Suspended</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.showUser', $c->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No contributor activity found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities + Charts -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i>Resource Types (by Category)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="resourceTypeChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-info me-2"></i>Uploads (Last 12 Months)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyUploadsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ----- Chart 1: Resource Types (Donut) -----
    const resourceTypes = @json($stats['resourceTypes'] ?? []);
    const typeLabels = Object.keys(resourceTypes);
    const typeValues = Object.values(resourceTypes);

    const typeCtx = document.getElementById('resourceTypeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: typeLabels.length ? typeLabels : ['No Data'],
            datasets: [{
                data: typeValues.length ? typeValues : [1],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // ----- Chart 2: Monthly Uploads (Line) -----
    const monthlyUploads = @json($stats['monthlyUploads'] ?? []);
    const monthLabels = Array.from({length: monthlyUploads.length}, (_, i) => `M${i+1}`);

    const monthCtx = document.getElementById('monthlyUploadsChart').getContext('2d');
    new Chart(monthCtx, {
        type: 'line',
        data: {
            labels: monthLabels.length ? monthLabels : ['No Data'],
            datasets: [{
                label: 'Uploads',
                data: monthlyUploads.length ? monthlyUploads : [0],
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

});
</script>
@endpush
