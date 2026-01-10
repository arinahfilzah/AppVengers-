@extends('layouts.app')

@section('title', 'Subject Reports')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="fas fa-chart-bar text-primary me-2"></i> Subject Popularity Reports
        </h2>
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i> Analyze subject trends and download statistics
        </small>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date Range</label>
                    <div class="input-group">
                        <input type="date" class="form-control">
                        <span class="input-group-text">to</span>
                        <input type="date" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Filter by Year</label>
                    <select class="form-select">
                        <option>All Years</option>
                        <option>Year 1</option>
                        <option>Year 2</option>
                        <option>Year 3</option>
                        <option>Year 4</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="loadDemoData()">
                        <i class="fas fa-play me-1"></i> Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2 class="text-primary" id="totalDownloads">0</h2>
                    <p class="text-muted">Total Downloads</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2 class="text-success" id="totalSubjects">0</h2>
                    <p class="text-muted">Subjects</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2 class="text-info" id="avgRating">0</h2>
                    <p class="text-muted">Avg Rating</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h2 class="text-warning" id="activeUsers">0</h2>
                    <p class="text-muted">Active Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart + Insights -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Top Subjects by Downloads</h5>
                </div>
                <div class="card-body">
                    <canvas id="subjectChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Insights</h5>
                </div>
                <div class="card-body" id="insightsList">
                    <p class="text-muted text-center">Click Generate Report</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Subject Statistics</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Downloads</th>
                        <th>Resources</th>
                        <th>Rating</th>
                        <th>Trend</th>
                    </tr>
                </thead>
                <tbody id="reportTable">
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No data yet
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chart = null;

/* HARD CODED DATA */
const demoData = {
    stats: {
        downloads: 2300,
        subjects: 25,
        rating: 4.2,
        users: 120
    },
    chart: {
        labels: [
            'Software Engineering',
            'Database',
            'Data Structures',
            'Web Programming',
            'Networks'
        ],
        data: [450, 380, 340, 300, 260]
    },
    subjects: [
        { name: 'Software Engineering', downloads: 450, resources: 35, rating: 4.8, trend: '↑' },
        { name: 'Database Systems', downloads: 380, resources: 28, rating: 4.6, trend: '↑' },
        { name: 'Data Structures', downloads: 340, resources: 30, rating: 4.7, trend: '↑' },
        { name: 'Web Programming', downloads: 300, resources: 25, rating: 4.4, trend: '→' },
        { name: 'Computer Networks', downloads: 260, resources: 20, rating: 4.2, trend: '↓' }
    ],
    insights: [
        'Software Engineering is the most popular subject.',
        'Web Programming shows stable performance.',
        'Network-related subjects need more engagement.'
    ]
};

function loadDemoData() {

    /* Stats */
    document.getElementById('totalDownloads').innerText = demoData.stats.downloads;
    document.getElementById('totalSubjects').innerText = demoData.stats.subjects;
    document.getElementById('avgRating').innerText = demoData.stats.rating;
    document.getElementById('activeUsers').innerText = demoData.stats.users;

    /* Chart */
    const ctx = document.getElementById('subjectChart');
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: demoData.chart.labels,
            datasets: [{
                data: demoData.chart.data,
                backgroundColor: 'rgba(54,162,235,0.7)'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    /* Table */
    let rows = '';
    demoData.subjects.forEach((s, i) => {
        rows += `
            <tr>
                <td>${i + 1}</td>
                <td>${s.name}</td>
                <td>${s.downloads}</td>
                <td>${s.resources}</td>
                <td>${s.rating}</td>
                <td>${s.trend}</td>
            </tr>
        `;
    });
    document.getElementById('reportTable').innerHTML = rows;

    /* Insights */
    let insightsHTML = '';
    demoData.insights.forEach(i => {
        insightsHTML += `<div class="alert alert-light">${i}</div>`;
    });
    document.getElementById('insightsList').innerHTML = insightsHTML;
    
}

/* Auto load */
loadDemoData();
</script>
@endpush