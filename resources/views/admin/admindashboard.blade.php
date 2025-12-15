@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">Dashboard Overview</h1>
                    <p class="text-muted mb-0">Summary of system statistics and activities</p>
                </div>
                <div>
                    <span class="badge bg-primary">Last updated: Today</span>
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
                    <h2 class="fw-bold mb-1">1,245</h2>
                    <p class="text-muted mb-0">Total Users</p>
                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i> 12% from last month</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-user-edit fa-2x text-success"></i>
                    </div>
                    <h2 class="fw-bold mb-1">87</h2>
                    <p class="text-muted mb-0">Total Contributors</p>
                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i> 5 new this week</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-file-upload fa-2x text-info"></i>
                    </div>
                    <h2 class="fw-bold mb-1">3,560</h2>
                    <p class="text-muted mb-0">Total Uploads</p>
                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i> 45 today</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-user-clock fa-2x text-warning"></i>
                    </div>
                    <h2 class="fw-bold mb-1">412</h2>
                    <p class="text-muted mb-0">Active Users (24h)</p>
                    <small class="text-danger"><i class="fas fa-arrow-down me-1"></i> 3% from yesterday</small>
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Aisyah+Rahman&background=667eea&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Aisyah">
                                            <div>
                                                <strong>Aisyah Rahman</strong>
                                                <div class="text-muted small">Top Contributor</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>aisyrah@example.com</td>
                                    <td>
                                        <span class="badge bg-primary">120</span>
                                    </td>
                                    <td>2 hours ago</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Daniel+Hakim&background=764ba2&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Daniel">
                                            <div>
                                                <strong>Daniel Hakim</strong>
                                                <div class="text-muted small">Verified Contributor</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>danielh@example.com</td>
                                    <td>
                                        <span class="badge bg-primary">98</span>
                                    </td>
                                    <td>1 day ago</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=f56565&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Siti">
                                            <div>
                                                <strong>Siti Aminah</strong>
                                                <div class="text-muted small">New Contributor</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>sitia@example.com</td>
                                    <td>
                                        <span class="badge bg-primary">15</span>
                                    </td>
                                    <td>3 days ago</td>
                                    <td>
                                        <span class="badge bg-warning">Pending Review</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-info me-2"></i>Recent Activities
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="avatar avatar-sm bg-primary rounded-circle">
                                        <i class="fas fa-upload text-white"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-0"><strong>Ahmad Ali</strong> uploaded "Database Design Notes"</p>
                                    <small class="text-muted">10 minutes ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="avatar avatar-sm bg-success rounded-circle">
                                        <i class="fas fa-check text-white"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-0"><strong>Admin</strong> approved 3 resources</p>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="avatar avatar-sm bg-warning rounded-circle">
                                        <i class="fas fa-user-plus text-white"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-0"><strong>New contributor</strong> registered: Fatimah Zara</p>
                                    <small class="text-muted">3 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i>Upload Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="uploadChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple chart for upload statistics
        const ctx = document.getElementById('uploadChart').getContext('2d');
        const uploadChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    data: [85, 10, 5],
                    backgroundColor: [
                        '#10b981', // green
                        '#f59e0b', // yellow
                        '#ef4444'  // red
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
        
        console.log('Admin dashboard loaded successfully');
    });
</script>
@endpush

@endsection