@extends('layouts.app')

@section('title', 'Content Review')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">Content Review</h1>
                    <p class="text-muted mb-0">Review and moderate uploaded resources</p>
                </div>
                <div class="d-flex">
                    <div class="input-group me-3" style="width: 300px;">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search resources..." id="searchResources">
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-warning active filter-btn" data-filter="pending">
                            Pending <span class="badge bg-warning ms-1" id="count-pending">0</span>
                        </button>
                        <button type="button" class="btn btn-outline-success filter-btn" data-filter="approved">
                            Approved <span class="badge bg-success ms-1" id="count-approved">0</span>
                        </button>
                        <button type="button" class="btn btn-outline-danger filter-btn" data-filter="rejected">
                            Rejected <span class="badge bg-danger ms-1" id="count-rejected">0</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Review Cards -->
    <div class="row g-4" id="resourcesContainer">
        <!-- Pending Resource 1 -->
        <div class="col-xl-4 col-lg-6 resource-card" data-status="pending" data-category="software" data-search="Database Design Notes">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning">Pending Review</span>
                        <small class="text-muted">2 hours ago</small>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-2">Database Design Notes.pdf</h5>
                    <p class="card-text text-muted small mb-3">
                        Complete notes on database normalization, ER diagrams, and SQL optimization techniques.
                    </p>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-1">Software Engineering</span>
                        <span class="badge bg-light text-dark">Year 2</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Ali&background=667eea&color=fff&rounded=true" 
                             class="rounded-circle me-2" width="30" height="30" alt="Uploader">
                        <div>
                            <small class="d-block"><strong>Ahmad Ali</strong></small>
                            <small class="text-muted">12 previous uploads</small>
                        </div>
                    </div>
                    
                    <div class="file-info mb-3">
                        <small class="d-flex align-items-center text-muted">
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            PDF Document • 2.4 MB • 45 pages
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm preview-btn" data-id="1">
                            <i class="fas fa-eye me-1"></i> Preview Content
                        </button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success btn-sm approve-btn" data-id="1">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm reject-btn" data-id="1">
                                <i class="fas fa-times me-1"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Resource 2 -->
        <div class="col-xl-4 col-lg-6 resource-card" data-status="pending" data-category="network" data-search="Network Security Guide">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning">Pending Review</span>
                        <small class="text-muted">5 hours ago</small>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-2">Network Security Guide.pptx</h5>
                    <p class="card-text text-muted small mb-3">
                        Presentation on network security protocols, firewall configuration, and penetration testing.
                    </p>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-1">Computer Network & Security</span>
                        <span class="badge bg-light text-dark">Year 3</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=764ba2&color=fff&rounded=true" 
                             class="rounded-circle me-2" width="30" height="30" alt="Uploader">
                        <div>
                            <small class="d-block"><strong>Siti Aminah</strong></small>
                            <small class="text-muted">8 previous uploads</small>
                        </div>
                    </div>
                    
                    <div class="file-info mb-3">
                        <small class="d-flex align-items-center text-muted">
                            <i class="fas fa-file-powerpoint text-warning me-2"></i>
                            PowerPoint • 5.1 MB • 32 slides
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm preview-btn" data-id="2">
                            <i class="fas fa-eye me-1"></i> Preview Content
                        </button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success btn-sm approve-btn" data-id="2">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm reject-btn" data-id="2">
                                <i class="fas fa-times me-1"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flagged Resource -->
        <div class="col-xl-4 col-lg-6 resource-card" data-status="pending" data-category="software" data-search="Java Programming">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-3">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-warning me-2">Pending Review</span>
                            <span class="badge bg-danger">Reported</span>
                        </div>
                        <small class="text-muted">1 day ago</small>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-2">Java Programming Cheatsheet.pdf</h5>
                    <p class="card-text text-muted small mb-3">
                        Quick reference for Java syntax, OOP concepts, and common algorithms.
                    </p>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-1">Software Engineering</span>
                        <span class="badge bg-light text-dark">Year 1</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Mohd+Faiz&background=ef4444&color=fff&rounded=true" 
                             class="rounded-circle me-2" width="30" height="30" alt="Uploader">
                        <div>
                            <small class="d-block"><strong>Mohd Faiz</strong></small>
                            <small class="text-muted">New contributor</small>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning small mb-3">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>Reported by users:</strong> Contains commercial advertising links.
                    </div>
                    
                    <div class="file-info mb-3">
                        <small class="d-flex align-items-center text-muted">
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            PDF Document • 1.8 MB • 28 pages
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm preview-btn" data-id="3">
                            <i class="fas fa-eye me-1"></i> Preview Content
                        </button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success btn-sm approve-btn" data-id="3">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm reject-btn" data-id="3">
                                <i class="fas fa-times me-1"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Resource -->
        <div class="col-xl-4 col-lg-6 resource-card" data-status="approved" data-category="data" data-search="Data Analysis">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">Approved</span>
                        <small class="text-muted">Nov 17, 2025</small>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-2">Data Analysis with Python.zip</h5>
                    <p class="card-text text-muted small mb-3">
                        Complete dataset and Python scripts for data analysis tutorial.
                    </p>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-1">Data Engineering</span>
                        <span class="badge bg-light text-dark">Year 3</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Lim&background=10b981&color=fff&rounded=true" 
                             class="rounded-circle me-2" width="30" height="30" alt="Uploader">
                        <div>
                            <small class="d-block"><strong>Sarah Lim</strong></small>
                            <small class="text-muted">Verified Contributor</small>
                        </div>
                    </div>
                    
                    <div class="file-info mb-3">
                        <small class="d-flex align-items-center text-muted">
                            <i class="fas fa-file-archive text-secondary me-2"></i>
                            ZIP Archive • 15.2 MB • 5 files
                        </small>
                    </div>
                    
                    <div class="stats small">
                        <div class="d-flex text-muted">
                            <div class="me-3">
                                <i class="fas fa-download me-1"></i> 42 downloads
                            </div>
                            <div>
                                <i class="fas fa-star text-warning me-1"></i> 4.7/5
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                        <i class="fas fa-check-circle me-1"></i> Approved
                    </button>
                </div>
            </div>
        </div>

        <!-- Rejected Resource -->
        <div class="col-xl-4 col-lg-6 resource-card" data-status="rejected" data-category="multimedia" data-search="Photoshop Tutorial">
            <div class="card border-0 shadow-sm h-100 opacity-75">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-danger">Rejected</span>
                        <small class="text-muted">Nov 16, 2025</small>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-2">Photoshop Tutorial.psd</h5>
                    <p class="card-text text-muted small mb-3">
                        Layered Photoshop file for graphic design tutorial.
                    </p>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-1">Graphic & Multimedia</span>
                        <span class="badge bg-light text-dark">Year 2</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=6c757d&color=fff&rounded=true" 
                             class="rounded-circle me-2" width="30" height="30" alt="Uploader">
                        <div>
                            <small class="d-block"><strong>John Doe</strong></small>
                            <small class="text-muted">Contributor</small>
                        </div>
                    </div>
                    
                    <div class="alert alert-danger small mb-3">
                        <i class="fas fa-ban me-1"></i>
                        <strong>Removal Reason:</strong> Copyright violation - contains unlicensed stock images.
                    </div>
                    
                    <div class="file-info mb-3">
                        <small class="d-flex align-items-center text-muted">
                            <i class="fas fa-file-image text-info me-2"></i>
                            Photoshop • 48.5 MB • PSD file
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                        <i class="fas fa-times-circle me-1"></i> Rejected
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- No Results Message -->
    <div class="row d-none" id="noResults">
        <div class="col-12 text-center py-5">
            <div class="display-1 text-muted mb-3">
                <i class="fas fa-search"></i>
            </div>
            <h4 class="text-muted">No resources found</h4>
            <p class="text-muted">Try changing your search or filter criteria</p>
        </div>
    </div>

</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Content Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- PDF Preview -->
                        <div class="border rounded p-3 bg-light" style="height: 500px;">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                                    <h5>Database Design Notes.pdf</h5>
                                    <p class="text-muted">PDF Document - 2.4 MB</p>
                                    <a href="#" class="btn btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> Download Full File
                                    </a>
                                </div>
                            </div>
                            <!-- In production, you would embed a PDF viewer here -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>File Details</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Filename:</strong></td>
                                <td id="preview-filename">Database_Design_Notes.pdf</td>
                            </tr>
                            <tr>
                                <td><strong>Size:</strong></td>
                                <td>2.4 MB</td>
                            </tr>
                            <tr>
                                <td><strong>Pages:</strong></td>
                                <td>45</td>
                            </tr>
                            <tr>
                                <td><strong>Uploaded:</strong></td>
                                <td>2 hours ago</td>
                            </tr>
                            <tr>
                                <td><strong>Uploader:</strong></td>
                                <td>Ahmad Ali</td>
                            </tr>
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>Software Engineering</td>
                            </tr>
                        </table>

                        <h6 class="mt-4">Content Summary</h6>
                        <p class="small">
                            This document covers database design principles including:
                            • Entity-Relationship Diagrams
                            • Normalization (1NF, 2NF, 3NF)
                            • SQL optimization techniques
                            • Transaction management
                        </p>

                        <div class="alert alert-info small mt-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Preview limited to first few pages. Download full file for complete content.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="preview-approve-btn">Approve</button>
                <button type="button" class="btn btn-danger" id="preview-reject-btn">Remove Content</button>
            </div>
        </div>
    </div>
</div>

<!-- Remove Content Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeModalLabel">Remove Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="removeReason" class="form-label">Reason for Removal <span class="text-danger">*</span></label>
                    <select class="form-select" id="removeReason">
                        <option value="">Select a reason...</option>
                        <option value="inappropriate">Inappropriate content</option>
                        <option value="copyright">Copyright violation</option>
                        <option value="spam">Spam or advertising</option>
                        <option value="low_quality">Low quality or inaccurate</option>
                        <option value="duplicate">Duplicate content</option>
                        <option value="other">Other (specify below)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="removeNotes" class="form-label">Additional Notes <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="removeNotes" rows="3" 
                              placeholder="Provide detailed explanation for removal..."></textarea>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="notifyUploader">
                    <label class="form-check-label" for="notifyUploader">
                        Notify uploader about removal
                    </label>
                </div>
                <div class="alert alert-warning small">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    This action cannot be undone. The content will be removed from public viewing.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRemove">Confirm Removal</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Update count badges
    function updateCounts() {
        const pending = $('.resource-card[data-status="pending"]').length;
        const approved = $('.resource-card[data-status="approved"]').length;
        const rejected = $('.resource-card[data-status="rejected"]').length;
        
        $('#count-pending').text(pending);
        $('#count-approved').text(approved);
        $('#count-rejected').text(rejected);
    }
    
    // Filter functionality
    $('.filter-btn').on('click', function() {
        const filter = $(this).data('filter');
        
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        $('.resource-card').removeClass('d-none');
        
        if (filter !== 'all') {
            $(`.resource-card:not([data-status="${filter}"])`).addClass('d-none');
        }
        
        checkNoResults();
    });
    
    // Search functionality
    $('#searchResources').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.resource-card').each(function() {
            const searchData = $(this).data('search').toLowerCase();
            if (searchData.includes(searchTerm)) {
                $(this).removeClass('d-none');
            } else {
                $(this).addClass('d-none');
            }
        });
        
        checkNoResults();
    });
    
    function checkNoResults() {
        const visibleCards = $('.resource-card:not(.d-none)').length;
        if (visibleCards === 0) {
            $('#noResults').removeClass('d-none');
        } else {
            $('#noResults').addClass('d-none');
        }
    }
    
    // Preview content
    $('.preview-btn').on('click', function() {
        const resourceId = $(this).data('id');
        $('#previewModal').modal('show');
        
        // Set button data for actions from preview modal
        $('#preview-approve-btn').data('id', resourceId);
        $('#preview-reject-btn').data('id', resourceId);
    });
    
    // Approve resource
    let currentApproveId = null;
    $('.approve-btn, #preview-approve-btn').on('click', function(e) {
        e.preventDefault();
        currentApproveId = $(this).data('id');
        
        Swal.fire({
            title: 'Approve Content?',
            text: "This content will be available to all users.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX call to approve
                $.ajax({
                    url: `/admin/reviews/${currentApproveId}/approve`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Approved!',
                            'Content has been approved.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
    
    // Remove resource
    let currentRemoveId = null;
    $('.reject-btn, #preview-reject-btn').on('click', function(e) {
        e.preventDefault();
        currentRemoveId = $(this).data('id');
        $('#removeModal').modal('show');
    });
    
    $('#confirmRemove').on('click', function() {
        const reason = $('#removeReason').val();
        const notes = $('#removeNotes').val();
        const notify = $('#notifyUploader').is(':checked');
        
        if (!reason || !notes.trim()) {
            Swal.fire('Error', 'Please provide both reason and notes.', 'error');
            return;
        }
        
        $.ajax({
            url: `/admin/reviews/${currentRemoveId}/remove`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                reason: reason,
                notes: notes,
                notify: notify
            },
            success: function(response) {
                $('#removeModal').modal('hide');
                Swal.fire(
                    'Removed!',
                    'Content has been removed.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            }
        });
    });
    
    // Initialize counts
    updateCounts();
});
</script>
@endpush

@endsection