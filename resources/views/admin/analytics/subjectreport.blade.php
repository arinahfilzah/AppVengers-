@extends('layouts.app')

@section('title', 'Subject Reports')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="fas fa-chart-bar text-primary me-2"></i> Subject Popularity Reports
        </h2>
        <div class="text-muted small">
            <i class="fas fa-info-circle me-1"></i> Data updates automatically
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Date Range</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="startDate" 
                               value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                        <span class="input-group-text">to</span>
                        <input type="date" class="form-control" id="endDate" 
                               value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Filter by Year</label>
                    <select class="form-select" id="yearFilter">
                        <option value="all">All Years</option>
                        <option value="Year 1">Year 1</option>
                        <option value="Year 2">Year 2</option>
                        <option value="Year 3">Year 3</option>
                        <option value="Year 4">Year 4</option>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="generateReport()">
                        <i class="fas fa-play me-1"></i> Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-6 text-primary" id="totalDownloads">0</h1>
                    <p class="text-muted mb-0">Total Downloads</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-6 text-success" id="totalSubjects">0</h1>
                    <p class="text-muted mb-0">Subjects</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-6 text-info" id="avgRating">0.0</h1>
                    <p class="text-muted mb-0">Avg Rating</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-6 text-warning" id="activeUsers">0</h1>
                    <p class="text-muted mb-0">Active Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Top 10 Subjects by Downloads</h5>
                </div>
                <div class="card-body">
                    <canvas id="subjectChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Insights</h5>
                </div>
                <div class="card-body">
                    <div id="insightsList">
                        <p class="text-center text-muted">Generate report to see insights</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Subject Statistics</h5>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search subjects..." id="searchSubjects">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">Rank</th>
                            <th width="30%">Subject</th>
                            <th width="15%">Downloads</th>
                            <th width="15%">Resources</th>
                            <th width="15%">Avg Rating</th>
                            <th width="10%">Trend</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reportTable">
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Select date range and click "Generate Report"
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="d-flex justify-content-center mt-4">
        <div class="btn-group">
            <button class="btn btn-success" onclick="exportPDF()">
                <i class="fas fa-file-pdf me-1"></i> Export as PDF
            </button>
            <button class="btn btn-info" onclick="exportExcel()">
                <i class="fas fa-file-excel me-1"></i> Export as Excel
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let subjectChart = null;

function generateReport() {
    const startDate = $('#startDate').val();
    const endDate = $('#endDate').val();
    const year = $('#yearFilter').val();
    
    // Show loading
    $('#reportTable').html(`
        <tr>
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Generating report...</p>
            </td>
        </tr>
    `);
    
    $.ajax({
        url: '{{ route("admin.analytics.generate") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            start_date: startDate,
            end_date: endDate,
            year: year
        },
        success: function(response) {
            if (response.success) {
                updateStats(response.data.stats);
                updateChart(response.data.chart);
                updateTable(response.data.subjects);
                updateInsights(response.data.insights);
            } else {
                alert(response.message || 'Error generating report');
            }
        },
        error: function() {
            alert('Failed to generate report. Please try again.');
        }
    });
}

function updateStats(stats) {
    $('#totalDownloads').text(stats.total_downloads.toLocaleString());
    $('#totalSubjects').text(stats.total_subjects);
    $('#avgRating').text(stats.avg_rating.toFixed(1));
    $('#activeUsers').text(stats.active_users.toLocaleString());
}

function updateChart(chartData) {
    const ctx = document.getElementById('subjectChart').getContext('2d');
    
    if (subjectChart) {
        subjectChart.destroy();
    }
    
    subjectChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Downloads',
                data: chartData.data,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

function updateTable(subjects) {
    let html = '';
    
    if (subjects.length === 0) {
        html = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    No data found for selected criteria
                </td>
            </tr>
        `;
    } else {
        subjects.forEach(function(subject, index) {
            const trendIcon = subject.trend === 'up' ? '↑' : subject.trend === 'down' ? '↓' : '→';
            const trendClass = subject.trend === 'up' ? 'text-success' : 
                             subject.trend === 'down' ? 'text-danger' : 'text-muted';
            
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <strong>${subject.name}</strong>
                        <div class="text-muted small">${subject.resources} resources</div>
                    </td>
                    <td>${subject.downloads.toLocaleString()}</td>
                    <td>
                        <span class="badge bg-primary">${subject.resources}</span>
                    </td>
                    <td>
                        <span class="badge bg-info">${subject.rating}/5</span>
                    </td>
                    <td>
                        <span class="${trendClass} fw-bold">${trendIcon} ${subject.growth}%</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" 
                                onclick="viewSubjectDetails('${subject.name}')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    $('#reportTable').html(html);
}

function updateInsights(insights) {
    let html = '';
    
    insights.forEach(function(insight) {
        const icon = insight.type === 'success' ? 'fa-check-circle text-success' :
                    insight.type === 'warning' ? 'fa-exclamation-triangle text-warning' :
                    'fa-info-circle text-info';
        
        html += `
            <div class="alert alert-light border mb-2">
                <i class="fas ${icon} me-2"></i>
                ${insight.message}
            </div>
        `;
    });
    
    $('#insightsList').html(html);
}

function exportPDF() {
    const startDate = $('#startDate').val();
    const endDate = $('#endDate').val();
    const year = $('#yearFilter').val();
    
    window.open(`/admin/analytics/export/pdf?start_date=${startDate}&end_date=${endDate}&year=${year}`, '_blank');
}

function exportExcel() {
    const startDate = $('#startDate').val();
    const endDate = $('#endDate').val();
    const year = $('#yearFilter').val();
    
    window.open(`/admin/analytics/export/excel?start_date=${startDate}&end_date=${endDate}&year=${year}`, '_blank');
}

function viewSubjectDetails(subjectName) {
    alert(`Viewing details for: ${subjectName}\n\nIn a real implementation, this would open a modal or navigate to a detailed page.`);
}

// Search functionality
$('#searchSubjects').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('#reportTable tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>
@endpush
@endsection