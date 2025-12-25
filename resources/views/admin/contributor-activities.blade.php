@extends('layouts.app')

@section('page-title', 'Contributor Management')
@section('page-subtitle', 'Monitor and manage verified contributors and their activities')

@section('content')

<!-- Page Header -->
<div class="container py-4" style="max-width: 1200px; min-height: calc(100vh - 80px);">
    <div>
        <h1 class="h2 mb-1" style="color: #0d3b66;">
            <i class="fa fa-users me-2"></i>Contributor Activities
        </h1>
        <p class="text-muted mb-0">Monitor and manage all verified contributors' activities, uploads, and performance.</p>
    </div>
    <div class="text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContributorModal">
            <i class="fa fa-user-plus me-1"></i>Add Contributor
        </button>
    </div>

<!-- Filters & Search Bar -->
<div class="admin-card card border-0 mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label small text-muted">Status</label>
                <select class="form-select" id="filterStatus">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending Verification</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Sort By</label>
                <select class="form-select" id="filterSort">
                    <option value="upload_desc">Most Uploads</option>
                    <option value="upload_asc">Fewest Uploads</option>
                    <option value="recent">Most Recent</option>
                    <option value="rating">Highest Rating</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Date Range</label>
                <select class="form-select" id="filterDate">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search contributors..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-sm btn-outline-secondary me-2" id="clearFilters">
                    <i class="fa fa-times me-1"></i>Clear Filters
                </button>
                <button class="btn btn-sm btn-primary" id="applyFilters">
                    <i class="fa fa-filter me-1"></i>Apply Filters
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Contributor Statistics -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-lg-6">
        <div class="admin-card card border-0 h-100">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Total Contributors</h6>
                <h1 class="display-5 fw-bold text-primary mb-2">89</h1>
                <div class="small">
                    <span class="text-success">
                        <i class="fa fa-arrow-up me-1"></i>12 this month
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="admin-card card border-0 h-100">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Total Uploads</h6>
                <h1 class="display-5 fw-bold text-success mb-2">2,456</h1>
                <div class="small">
                    <span class="text-success">
                        <i class="fa fa-arrow-up me-1"></i>342 this month
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="admin-card card border-0 h-100">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Avg. Resources/User</h6>
                <h1 class="display-5 fw-bold text-warning mb-2">27.6</h1>
                <div class="small">
                    <span class="text-success">
                        <i class="fa fa-arrow-up me-1"></i>2.1 from last month
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="admin-card card border-0 h-100">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Pending Verification</h6>
                <h1 class="display-5 fw-bold text-danger mb-2">12</h1>
                <div class="small">
                    <a href="#" class="text-decoration-none">Review now <i class="fa fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contributors Table -->
<div class="admin-card card border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fa fa-list me-2"></i>Contributors List
            <span class="badge bg-primary ms-2" id="contributorCount">89</span>
        </h5>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="exportCSV">
                <i class="fa fa-download me-1"></i>Export
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="printTable">
                <i class="fa fa-print me-1"></i>Print
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="contributorsTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th>Contributor</th>
                        <th>Status</th>
                        <th>Uploads</th>
                        <th>Downloads</th>
                        <th>Rating</th>
                        <th>Last Activity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contributor 1 -->
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input row-checkbox" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name=Ali+Ahmad&background=0d3b66&color=fff&size=40" 
                                         class="rounded-circle me-3" alt="Ali Ahmad">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                </div>
                                <div>
                                    <div class="fw-bold">Ali Ahmad</div>
                                    <small class="text-muted">aliahmed@graduate.utm.my</small>
                                    <div class="small">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">Software Eng.</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <div class="fw-bold">142</div>
                            <small class="text-muted">+12 this month</small>
                        </td>
                        <td>
                            <div class="fw-bold">2,845</div>
                            <small class="text-muted">Avg: 20/download</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-2">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-alt"></i>
                                </div>
                                <span class="fw-bold">4.7</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">2 hours ago</div>
                            <small class="text-muted">Uploaded: Database notes</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary" title="View Profile" onclick="viewContributor(1)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success" title="Send Message">
                                    <i class="fa fa-envelope"></i>
                                </button>
                                <button class="btn btn-outline-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Contributor 2 -->
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input row-checkbox" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name=Siti+Sarah&background=28a745&color=fff&size=40" 
                                         class="rounded-circle me-3" alt="Siti Sarah">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                </div>
                                <div>
                                    <div class="fw-bold">Siti Sarah</div>
                                    <small class="text-muted">sitisarah@graduate.utm.my</small>
                                    <div class="small">
                                        <span class="badge bg-success bg-opacity-10 text-success">Web Programming</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <div class="fw-bold">98</div>
                            <small class="text-muted">+8 this month</small>
                        </td>
                        <td>
                            <div class="fw-bold">1,923</div>
                            <small class="text-muted">Avg: 19/download</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-2">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <span class="fw-bold">5.0</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">1 day ago</div>
                            <small class="text-muted">Updated: Web Dev tutorial</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary" title="View Profile">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success" title="Send Message">
                                    <i class="fa fa-envelope"></i>
                                </button>
                                <button class="btn btn-outline-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Contributor 3 -->
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input row-checkbox" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name=Raj+Kumar&background=ffc107&color=000&size=40" 
                                         class="rounded-circle me-3" alt="Raj Kumar">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-warning border border-2 border-white rounded-circle"></span>
                                </div>
                                <div>
                                    <div class="fw-bold">Raj Kumar</div>
                                    <small class="text-muted">rajkumar@graduate.utm.my</small>
                                    <div class="small">
                                        <span class="badge bg-warning bg-opacity-10 text-warning">Data Structures</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-warning">Pending</span>
                        </td>
                        <td>
                            <div class="fw-bold">23</div>
                            <small class="text-muted">New contributor</small>
                        </td>
                        <td>
                            <div class="fw-bold">456</div>
                            <small class="text-muted">Avg: 20/download</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-2">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <span class="fw-bold">5.0</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">3 days ago</div>
                            <small class="text-muted">Applied for verification</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary" title="View Profile">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success" title="Verify" onclick="verifyContributor(3)">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Reject">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Contributor 4 -->
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input row-checkbox" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name=Lisa+Tan&background=17a2b8&color=fff&size=40" 
                                         class="rounded-circle me-3" alt="Lisa Tan">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-danger border border-2 border-white rounded-circle"></span>
                                </div>
                                <div>
                                    <div class="fw-bold">Lisa Tan</div>
                                    <small class="text-muted">lisatan@graduate.utm.my</small>
                                    <div class="small">
                                        <span class="badge bg-info bg-opacity-10 text-info">Computer Networks</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-danger">Inactive</span>
                        </td>
                        <td>
                            <div class="fw-bold">67</div>
                            <small class="text-muted">No activity in 30 days</small>
                        </td>
                        <td>
                            <div class="fw-bold">1,234</div>
                            <small class="text-muted">Avg: 18/download</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-2">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <span class="fw-bold">4.8</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">1 month ago</div>
                            <small class="text-muted">Last login: 32 days ago</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary" title="View Profile">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success" title="Activate">
                                    <i class="fa fa-power-off"></i>
                                </button>
                                <button class="btn btn-outline-secondary" title="Send Reminder">
                                    <i class="fa fa-bell"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Contributor 5 -->
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input row-checkbox" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="https://ui-avatars.com/api/?name=Ahmad+Faiz&background=dc3545&color=fff&size=40" 
                                         class="rounded-circle me-3" alt="Ahmad Faiz">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
                                </div>
                                <div>
                                    <div class="fw-bold">Ahmad Faiz</div>
                                    <small class="text-muted">ahmadfaiz@graduate.utm.my</small>
                                    <div class="small">
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Security</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <div class="fw-bold">187</div>
                            <small class="text-muted">+21 this month</small>
                        </td>
                        <td>
                            <div class="fw-bold">3,421</div>
                            <small class="text-muted">Avg: 18/download</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="text-warning me-2">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-alt"></i>
                                </div>
                                <span class="fw-bold">4.6</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">5 hours ago</div>
                            <small class="text-muted">Uploaded: Security guide</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary" title="View Profile">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success" title="Send Message">
                                    <i class="fa fa-envelope"></i>
                                </button>
                                <button class="btn btn-outline-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing <span id="showingCount">5</span> of <span id="totalCount">89</span> contributors
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Bulk Actions -->
<div class="admin-card card border-0 mt-4" id="bulkActionsCard" style="display: none;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold me-3" id="selectedCount">0</span> contributors selected
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="bulkVerify">
                    <i class="fa fa-check me-1"></i>Verify
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="bulkMessage">
                    <i class="fa fa-envelope me-1"></i>Message
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" id="bulkDelete">
                    <i class="fa fa-trash me-1"></i>Remove
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="clearSelection">
                    <i class="fa fa-times me-1"></i>Clear
                </button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select All functionality
        const selectAll = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkActionsCard = document.getElementById('bulkActionsCard');
        const selectedCount = document.getElementById('selectedCount');
        
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateBulkActions();
        });

        // Individual checkbox changes
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            const count = selected.length;
            
            if (count > 0) {
                bulkActionsCard.style.display = 'block';
                selectedCount.textContent = count;
            } else {
                bulkActionsCard.style.display = 'none';
                selectAll.checked = false;
            }
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') performSearch();
        });

        function performSearch() {
            const query = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#contributorsTable tbody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (query === '' || text.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            document.getElementById('showingCount').textContent = visibleCount;
        }

        // Filter functionality
        const applyFilters = document.getElementById('applyFilters');
        const clearFilters = document.getElementById('clearFilters');
        
        applyFilters.addEventListener('click', function() {
            const status = document.getElementById('filterStatus').value;
            const sort = document.getElementById('filterSort').value;
            const date = document.getElementById('filterDate').value;
            
            // In real implementation, this would make an API call
            console.log('Applying filters:', { status, sort, date });
            
            // Show success message
            showAlert('Filters applied successfully!', 'success');
        });
        
        clearFilters.addEventListener('click', function() {
            document.getElementById('filterStatus').value = 'all';
            document.getElementById('filterSort').value = 'upload_desc';
            document.getElementById('filterDate').value = 'all';
            searchInput.value = '';
            performSearch();
            showAlert('Filters cleared!', 'info');
        });

        // Export functionality
        document.getElementById('exportCSV').addEventListener('click', function() {
            // In real implementation, this would generate/download CSV
            showAlert('Exporting CSV file...', 'info');
            setTimeout(() => showAlert('CSV exported successfully!', 'success'), 1000);
        });

        // Print functionality
        document.getElementById('printTable').addEventListener('click', function() {
            window.print();
        });

        // Bulk Actions
        document.getElementById('bulkVerify').addEventListener('click', function() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            showAlert(`Verified ${selected.length} contributor(s)`, 'success');
        });
        
        document.getElementById('clearSelection').addEventListener('click', function() {
            rowCheckboxes.forEach(checkbox => checkbox.checked = false);
            updateBulkActions();
        });

        // Helper function to show alerts
        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="fa fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            setTimeout(() => alert.remove(), 3000);
        }
    });

    // View contributor details (would open modal in real implementation)
    function viewContributor(id) {
        console.log('Viewing contributor ID:', id);
        showAlert('Opening contributor profile...', 'info');
    }

    // Verify contributor
    function verifyContributor(id) {
        if (confirm('Are you sure you want to verify this contributor?')) {
            console.log('Verifying contributor ID:', id);
            showAlert('Contributor verified successfully!', 'success');
            // In real implementation, update UI and make API call
        }
    }
</script>
@endpush