@extends('layouts.app')

@section('title', 'Subject Reports')

@section('content')
<div class="container py-4" style="max-width: 1200px; min-height: calc(100vh - 80px);">

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
                        <input type="date" class="form-control" id="startDate">
                        <span class="input-group-text">to</span>
                        <input type="date" class="form-control" id="endDate">
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
                    <button class="btn btn-primary w-100" onclick="generateSubjectReport()">
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

document.addEventListener('DOMContentLoaded', () => {
    // Optional: auto-run with default last 30 days
    generateSubjectReport();
});

function generateSubjectReport() {
    const start = document.getElementById('startDate').value;
    const end   = document.getElementById('endDate').value;
    const year  = document.getElementById('yearFilter').value;

    // Loading state
    document.getElementById('reportTable').innerHTML = `
        <tr>
            <td colspan="5" class="text-center text-muted">Loading...</td>
        </tr>
    `;
    document.getElementById('insightsList').innerHTML = `
        <p class="text-muted text-center">Generating report...</p>
    `;

    fetch(`{{ route('admin.analytics.subjectreport.data') }}?start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}&year=${encodeURIComponent(year)}`)
        .then(r => r.json())
        .then(res => {
            if (!res.success) throw new Error('Failed');

            // Cards
            document.getElementById('totalDownloads').innerText = (res.stats.downloads ?? 0).toLocaleString();
            document.getElementById('totalSubjects').innerText  = (res.stats.subjects ?? 0).toLocaleString();
            document.getElementById('activeUsers').innerText    = (res.stats.users ?? 0).toLocaleString();

            // Chart
            const ctx = document.getElementById('subjectChart');
            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.chart.labels,
                    datasets: [{
                        data: res.chart.data,
                        backgroundColor: 'rgba(54,162,235,0.7)'
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Table
            let rowsHtml = '';
            if (!res.rows || res.rows.length === 0) {
                rowsHtml = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">No data for selected filters</td>
                    </tr>
                `;
            } else {
                res.rows.forEach((s, i) => {
                    rowsHtml += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${s.subject}</td>
                            <td>${(s.downloads ?? 0).toLocaleString()}</td>
                            <td>${(s.resources ?? 0).toLocaleString()}</td>
                            <td>${s.trend ?? '→'}</td>
                        </tr>
                    `;
                });
            }
            document.getElementById('reportTable').innerHTML = rowsHtml;

            // Insights
            let insightsHTML = '';
            (res.insights ?? []).forEach(t => {
                insightsHTML += `<div class="alert alert-light">${t}</div>`;
            });
            document.getElementById('insightsList').innerHTML = insightsHTML || `<p class="text-muted text-center">No insights</p>`;
        })
        .catch(() => {
            document.getElementById('reportTable').innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">Failed to load report</td>
                </tr>
            `;
            document.getElementById('insightsList').innerHTML = `
                <p class="text-danger text-center">Error generating report</p>
            `;
        });
}

// Optional: export CSV
function exportSubjectReport() {
    const start = document.getElementById('startDate').value;
    const end   = document.getElementById('endDate').value;
    const year  = document.getElementById('yearFilter').value;

    window.open(`{{ route('admin.analytics.subjectreport.export') }}?start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}&year=${encodeURIComponent(year)}`, '_blank');
}
</script>
@endpush
