@extends('layouts.app')

@section('title', 'Resource Analytics')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="fas fa-tachometer-alt text-primary me-2"></i> Resource Performance Analytics
        </h2>
        <div class="text-muted small">
            Last updated: <span id="lastUpdated">Just now</span>
        </div>
    </div>

    <!-- Period Selection -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">@extends('layouts.app')

@section('title', 'Resource Analytics')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="fas fa-tachometer-alt text-primary me-2"></i> Resource Performance Analytics
        </h2>
        <div class="text-muted small">
            Last updated: <span id="lastUpdated">Just now</span>
        </div>
    </div>

    <!-- Period Selection -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="me-3 fw-medium">Time Period:</span>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary period-btn active" data-days="7">
                        Last 7 Days
                    </button>
                    <button type="button" class="btn btn-outline-primary period-btn" data-days="30">
                        Last 30 Days
                    </button>
                    <button type="button" class="btn btn-outline-primary period-btn" data-days="90">
                        Last 90 Days
                    </button>
                </div>
                
                <div class="ms-auto">
                    <button class="btn btn-success" onclick="exportPerformanceReport()">
                        <i class="fas fa-download me-1"></i> Export Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Overview -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-primary" id="metricDownloads">0</h3>
                    <p class="text-muted mb-0">Downloads</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-success" id="metricResources">0</h3>
                    <p class="text-muted mb-0">Resources</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-info" id="metricRating">0.0</h3>
                    <p class="text-muted mb-0">Avg Rating</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-warning" id="metricViews">0</h3>
                    <p class="text-muted mb-0">Total Views</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-danger" id="metricLowPerforming">0</h3>
                    <p class="text-muted mb-0">Low Performing</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-purple" id="metricTopRated">0</h3>
                    <p class="text-muted mb-0">Top Rated</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                <select class="form-select" id="subjectFilter">
                    <option value="all">All Subjects</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Data Engineering">Data Engineering</option>
                    <option value="Computer Networks">Computer Networks</option>
                    <option value="Database">Database</option>
                    <option value="Bioinformatics">Bioinformatics</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search resources..." id="searchResources">
            </div>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Resource Performance Ranking</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Resource</th>
                            <th width="15%">Subject</th>
                            <th width="15%">Downloads</th>
                            <th width="15%">Rating</th>
                            <th width="10%">Status</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="performanceTable">
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Loading resource performance data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Performance Insights -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-success me-2"></i> Top Performers</h5>
                </div>
                <div class="card-body">
                    <div id="topPerformersList">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Needs Improvement</h5>
                </div>
                <div class="card-body">
                    <div id="needsImprovementList">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentPeriod = 30; // Default: 30 days

$(document).ready(function() {
    loadPerformanceData(currentPeriod);
    
    // Period button clicks
    $('.period-btn').on('click', function() {
        $('.period-btn').removeClass('active');
        $(this).addClass('active');
        currentPeriod = $(this).data('days');
        loadPerformanceData(currentPeriod);
    });
    
    // Subject filter change
    $('#subjectFilter').on('change', function() {
        loadPerformanceData(currentPeriod);
    });
});

function loadPerformanceData(days) {
    const subject = $('#subjectFilter').val();
    
    // Show loading
    $('#performanceTable').html(`
        <tr>
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>
    `);
    
    $.ajax({
        url: '{{ route("admin.analytics.performance.data") }}',
        method: 'GET',
        data: {
            days: days,
            subject: subject
        },
        success: function(response) {
            if (response.success) {
                updateMetrics(response.metrics);
                updateTable(response.resources);
                updateTopPerformers(response.topPerformers);
                updateNeedsImprovement(response.needsImprovement);
                $('#lastUpdated').text(response.generated_at);
            }
        },
        error: function() {
            $('#performanceTable').html(`
                <tr>
                    <td colspan="7" class="text-center text-danger py-4">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
        }
    });
}

function updateMetrics(metrics) {
    $('#metricDownloads').text(metrics.total_downloads.toLocaleString());
    $('#metricResources').text(metrics.total_resources.toLocaleString());
    $('#metricRating').text(metrics.avg_rating.toFixed(1));
    $('#metricViews').text(metrics.total_views.toLocaleString());
    $('#metricLowPerforming').text(metrics.low_performing);
    $('#metricTopRated').text(metrics.top_rated);
}

function updateTable(resources) {
    let html = '';
    
    if (resources.length === 0) {
        html = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    No resources found for selected criteria
                </td>
            </tr>
        `;
    } else {
        resources.forEach(function(resource, index) {
            const statusClass = resource.performance === 'excellent' ? 'success' :
                              resource.performance === 'good' ? 'info' :
                              resource.performance === 'average' ? 'warning' : 'danger';
            
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="resource-icon me-3">
                                <i class="fas fa-file-pdf text-danger"></i>
                            </div>
                            <div>
                                <strong>${resource.title}</strong>
                                <div class="text-muted small">
                                    Uploaded: ${resource.upload_date} • ${resource.uploader}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">${resource.subject}</span>
                    </td>
                    <td>${resource.downloads.toLocaleString()}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-2">${resource.rating}/5</div>
                            <div class="rating-stars">
                                ${getStarsHTML(resource.rating)}
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-${statusClass}">${resource.performance}</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" 
                                onclick="viewResourceAnalytics(${resource.id})">
                            <i class="fas fa-chart-line"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    $('#performanceTable').html(html);
}

function updateTopPerformers(performers) {
    let html = '';
    
    if (performers.length === 0) {
        html = '<p class="text-muted">No top performers found</p>';
    } else {
        performers.forEach(function(performer) {
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-truncate" style="max-width: 70%;">
                        ${performer.title}
                    </div>
                    <div class="text-end">
                        <small class="text-success">${performer.downloads} downloads</small>
                        <div class="text-warning small">${performer.rating}/5</div>
                    </div>
                </div>
            `;
        });
    }
    
    $('#topPerformersList').html(html);
}

function updateNeedsImprovement(resources) {
    let html = '';
    
    if (resources.length === 0) {
        html = '<p class="text-muted">All resources are performing well!</p>';
    } else {
        resources.forEach(function(resource) {
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-truncate" style="max-width: 70%;">
                        ${resource.title}
                    </div>
                    <div class="text-end">
                        <small class="text-danger">Only ${resource.downloads} downloads</small>
                        <div class="text-muted small">Rating: ${resource.rating}/5</div>
                    </div>
                </div>
            `;
        });
    }
    
    $('#needsImprovementList').html(html);
}

function getStarsHTML(rating) {
    let stars = '';
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    
    for (let i = 0; i < fullStars; i++) {
        stars += '<i class="fas fa-star text-warning"></i>';
    }
    
    if (hasHalfStar) {
        stars += '<i class="fas fa-star-half-alt text-warning"></i>';
    }
    
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
        stars += '<i class="far fa-star text-warning"></i>';
    }
    
    return stars;
}

function viewResourceAnalytics(resourceId) {
    alert(`Viewing detailed analytics for resource ID: ${resourceId}\n\nIn a real implementation, this would open a detailed analytics modal.`);
}

function exportPerformanceReport() {
    const days = currentPeriod;
    const subject = $('#subjectFilter').val();
    
    window.open(`/admin/analytics/performance/export?days=${days}&subject=${encodeURIComponent(subject)}`, '_blank');
}

// Search functionality
$('#searchResources').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('#performanceTable tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>
@endpush
@endsection
            <div class="d-flex align-items-center">
                <span class="me-3 fw-medium">Time Period:</span>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary period-btn active" data-days="7">
                        Last 7 Days
                    </button>
                    <button type="button" class="btn btn-outline-primary period-btn" data-days="30">
                        Last 30 Days
                    </button>
                    <button type="button" class="btn btn-outline-primary period-btn" data-days="90">
                        Last 90 Days
                    </button>
                </div>
                
                <div class="ms-auto">
                    <button class="btn btn-success" onclick="exportPerformanceReport()">
                        <i class="fas fa-download me-1"></i> Export Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Overview -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-primary" id="metricDownloads">0</h3>
                    <p class="text-muted mb-0">Downloads</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-success" id="metricResources">0</h3>
                    <p class="text-muted mb-0">Resources</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-info" id="metricRating">0.0</h3>
                    <p class="text-muted mb-0">Avg Rating</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-warning" id="metricViews">0</h3>
                    <p class="text-muted mb-0">Total Views</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-danger" id="metricLowPerforming">0</h3>
                    <p class="text-muted mb-0">Low Performing</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-purple" id="metricTopRated">0</h3>
                    <p class="text-muted mb-0">Top Rated</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                <select class="form-select" id="subjectFilter">
                    <option value="all">All Subjects</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Data Engineering">Data Engineering</option>
                    <option value="Computer Networks">Computer Networks</option>
                    <option value="Database">Database</option>
                    <option value="Bioinformatics">Bioinformatics</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search resources..." id="searchResources">
            </div>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Resource Performance Ranking</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Resource</th>
                            <th width="15%">Subject</th>
                            <th width="15%">Downloads</th>
                            <th width="15%">Rating</th>
                            <th width="10%">Status</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="performanceTable">
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Loading resource performance data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Performance Insights -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line text-success me-2"></i> Top Performers</h5>
                </div>
                <div class="card-body">
                    <div id="topPerformersList">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Needs Improvement</h5>
                </div>
                <div class="card-body">
                    <div id="needsImprovementList">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentPeriod = 30; // Default: 30 days

$(document).ready(function() {
    loadPerformanceData(currentPeriod);
    
    // Period button clicks
    $('.period-btn').on('click', function() {
        $('.period-btn').removeClass('active');
        $(this).addClass('active');
        currentPeriod = $(this).data('days');
        loadPerformanceData(currentPeriod);
    });
    
    // Subject filter change
    $('#subjectFilter').on('change', function() {
        loadPerformanceData(currentPeriod);
    });
});

function loadPerformanceData(days) {
    const subject = $('#subjectFilter').val();
    
    // Show loading
    $('#performanceTable').html(`
        <tr>
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>
    `);
    
    $.ajax({
        url: '{{ route("admin.analytics.performance.data") }}',
        method: 'GET',
        data: {
            days: days,
            subject: subject
        },
        success: function(response) {
            if (response.success) {
                updateMetrics(response.metrics);
                updateTable(response.resources);
                updateTopPerformers(response.topPerformers);
                updateNeedsImprovement(response.needsImprovement);
                $('#lastUpdated').text(response.generated_at);
            }
        },
        error: function() {
            $('#performanceTable').html(`
                <tr>
                    <td colspan="7" class="text-center text-danger py-4">
                        Failed to load data. Please try again.
                    </td>
                </tr>
            `);
        }
    });
}

function updateMetrics(metrics) {
    $('#metricDownloads').text(metrics.total_downloads.toLocaleString());
    $('#metricResources').text(metrics.total_resources.toLocaleString());
    $('#metricRating').text(metrics.avg_rating.toFixed(1));
    $('#metricViews').text(metrics.total_views.toLocaleString());
    $('#metricLowPerforming').text(metrics.low_performing);
    $('#metricTopRated').text(metrics.top_rated);
}

function updateTable(resources) {
    let html = '';
    
    if (resources.length === 0) {
        html = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    No resources found for selected criteria
                </td>
            </tr>
        `;
    } else {
        resources.forEach(function(resource, index) {
            const statusClass = resource.performance === 'excellent' ? 'success' :
                              resource.performance === 'good' ? 'info' :
                              resource.performance === 'average' ? 'warning' : 'danger';
            
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="resource-icon me-3">
                                <i class="fas fa-file-pdf text-danger"></i>
                            </div>
                            <div>
                                <strong>${resource.title}</strong>
                                <div class="text-muted small">
                                    Uploaded: ${resource.upload_date} • ${resource.uploader}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">${resource.subject}</span>
                    </td>
                    <td>${resource.downloads.toLocaleString()}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-2">${resource.rating}/5</div>
                            <div class="rating-stars">
                                ${getStarsHTML(resource.rating)}
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-${statusClass}">${resource.performance}</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" 
                                onclick="viewResourceAnalytics(${resource.id})">
                            <i class="fas fa-chart-line"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    $('#performanceTable').html(html);
}

function updateTopPerformers(performers) {
    let html = '';
    
    if (performers.length === 0) {
        html = '<p class="text-muted">No top performers found</p>';
    } else {
        performers.forEach(function(performer) {
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-truncate" style="max-width: 70%;">
                        ${performer.title}
                    </div>
                    <div class="text-end">
                        <small class="text-success">${performer.downloads} downloads</small>
                        <div class="text-warning small">${performer.rating}/5</div>
                    </div>
                </div>
            `;
        });
    }
    
    $('#topPerformersList').html(html);
}

function updateNeedsImprovement(resources) {
    let html = '';
    
    if (resources.length === 0) {
        html = '<p class="text-muted">All resources are performing well!</p>';
    } else {
        resources.forEach(function(resource) {
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-truncate" style="max-width: 70%;">
                        ${resource.title}
                    </div>
                    <div class="text-end">
                        <small class="text-danger">Only ${resource.downloads} downloads</small>
                        <div class="text-muted small">Rating: ${resource.rating}/5</div>
                    </div>
                </div>
            `;
        });
    }
    
    $('#needsImprovementList').html(html);
}

function getStarsHTML(rating) {
    let stars = '';
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    
    for (let i = 0; i < fullStars; i++) {
        stars += '<i class="fas fa-star text-warning"></i>';
    }
    
    if (hasHalfStar) {
        stars += '<i class="fas fa-star-half-alt text-warning"></i>';
    }
    
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
        stars += '<i class="far fa-star text-warning"></i>';
    }
    
    return stars;
}

function viewResourceAnalytics(resourceId) {
    alert(`Viewing detailed analytics for resource ID: ${resourceId}\n\nIn a real implementation, this would open a detailed analytics modal.`);
}

function exportPerformanceReport() {
    const days = currentPeriod;
    const subject = $('#subjectFilter').val();
    
    window.open(`/admin/analytics/performance/export?days=${days}&subject=${encodeURIComponent(subject)}`, '_blank');
}

// Search functionality
$('#searchResources').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('#performanceTable tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>
@endpush
@endsection