@extends('layouts.app')

@section('title', 'Premium Analytics')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="fas fa-chart-line me-2"></i>Premium Analytics</h1>
        <div class="btn-group">
            <button class="btn btn-outline-primary" id="exportBtn">
                <i class="fas fa-download me-2"></i>Export Report
            </button>
        </div>
    </div>
    
    <!-- Revenue Chart -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Revenue (Last 30 Days)</h5>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>
    
    <div class="row">
        <!-- Plan Popularity -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Plan Popularity</h5>
                </div>
                <div class="card-body">
                    <canvas id="planChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <!-- User Growth -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">User Growth (Last 90 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueData->pluck('date')),
            datasets: [{
                label: 'Daily Revenue (RM)',
                data: @json($revenueData->pluck('revenue')),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
    
    // Plan Popularity Chart
    const planCtx = document.getElementById('planChart').getContext('2d');
    const planChart = new Chart(planCtx, {
        type: 'doughnut',
        data: {
            labels: @json($planPopularity->pluck('name')),
            datasets: [{
                data: @json($planPopularity->pluck('purchase_count')),
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545', 
                    '#6f42c1', '#20c997', '#fd7e14', '#e83e8c'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
    
    // User Growth Chart
    const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const growthChart = new Chart(growthCtx, {
        type: 'bar',
        data: {
            labels: @json($userGrowth->pluck('date')),
            datasets: [{
                label: 'Total Users',
                data: @json($userGrowth->pluck('total_users')),
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
            }, {
                label: 'Premium Users',
                data: @json($userGrowth->pluck('premium_users')),
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: false,
                },
                y: {
                    stacked: false,
                    beginAtZero: true
                }
            }
        }
    });
    
    // Export functionality
    document.getElementById('exportBtn').addEventListener('click', function() {
        const data = {
            revenue_data: @json($revenueData),
            plan_popularity: @json($planPopularity),
            user_growth: @json($userGrowth)
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'premium-analytics-' + new Date().toISOString().split('T')[0] + '.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
</script>
@endpush
@endsection