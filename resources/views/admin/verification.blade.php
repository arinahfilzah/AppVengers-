@extends('layouts.app')

@section('title', 'Contributor Verification')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">Contributor Verification</h1>
                    <p class="text-muted mb-0">Review and verify contributor requests</p>
                </div>
                <div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active filter-btn" data-filter="all">
                            All <span class="badge bg-primary ms-1" id="count-all">0</span>
                        </button>
                        <button type="button" class="btn btn-outline-warning filter-btn" data-filter="pending">
                            Pending <span class="badge bg-warning ms-1" id="count-pending">0</span>
                        </button>
                        <button type="button" class="btn btn-outline-success filter-btn" data-filter="approved">
                            Approved <span class="badge bg-success ms-1" id="count-approved">0</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Requests Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="verificationTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Applicant</th>
                                    <th width="15%">Submitted</th>
                                    <th width="20%">Upload History</th>
                                    <th width="15%">Status</th>
                                    <th width="25%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Pending Request 1 -->
                                <tr class="request-row" data-status="pending">
                                    <td>#VR001</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Ali+Bakar&background=667eea&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Ali">
                                            <div>
                                                <strong>Ali Bakar</strong>
                                                <div class="text-muted small">ali.bakar@student.edu</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>Nov 18, 2025</div>
                                        <small class="text-muted">3 days ago</small>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <small>Uploads:</small>
                                                <div class="fw-bold">12</div>
                                            </div>
                                            <div class="me-3">
                                                <small>Downloads:</small>
                                                <div class="fw-bold">45</div>
                                            </div>
                                            <div>
                                                <small>Rating:</small>
                                                <div class="fw-bold">4.5/5</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary view-request" 
                                                    data-id="1" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button type="button" class="btn btn-outline-success approve-request" 
                                                    data-id="1">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-outline-danger reject-request" 
                                                    data-id="1">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Pending Request 2 -->
                                <tr class="request-row" data-status="pending">
                                    <td>#VR002</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=764ba2&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Siti">
                                            <div>
                                                <strong>Siti Nurhaliza</strong>
                                                <div class="text-muted small">siti.n@student.edu</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>Nov 17, 2025</div>
                                        <small class="text-muted">4 days ago</small>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <small>Uploads:</small>
                                                <div class="fw-bold">8</div>
                                            </div>
                                            <div class="me-3">
                                                <small>Downloads:</small>
                                                <div class="fw-bold">32</div>
                                            </div>
                                            <div>
                                                <small>Rating:</small>
                                                <div class="fw-bold">4.2/5</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary view-request" 
                                                    data-id="2" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button type="button" class="btn btn-outline-success approve-request" 
                                                    data-id="2">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-outline-danger reject-request" 
                                                    data-id="2">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Approved Request -->
                                <tr class="request-row" data-status="approved">
                                    <td>#VR003</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Ahmad+Zaki&background=10b981&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Ahmad">
                                            <div>
                                                <strong>Ahmad Zaki</strong>
                                                <div class="text-muted small">ahmad.z@student.edu</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>Nov 15, 2025</div>
                                        <small class="text-muted">6 days ago</small>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <small>Uploads:</small>
                                                <div class="fw-bold">25</div>
                                            </div>
                                            <div class="me-3">
                                                <small>Downloads:</small>
                                                <div class="fw-bold">120</div>
                                            </div>
                                            <div>
                                                <small>Rating:</small>
                                                <div class="fw-bold">4.8/5</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Approved</span>
                                        <div class="text-muted small">Nov 16, 2025</div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                            <i class="fas fa-check-circle"></i> Verified
                                        </button>
                                    </td>
                                </tr>

                                <!-- Request More Information -->
                                <tr class="request-row" data-status="pending">
                                    <td>#VR004</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Maria+Abdullah&background=f59e0b&color=fff&rounded=true" 
                                                 class="rounded-circle me-3" width="40" height="40" alt="Maria">
                                            <div>
                                                <strong>Maria Abdullah</strong>
                                                <div class="text-muted small">maria.a@student.edu</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>Nov 14, 2025</div>
                                        <small class="text-muted">7 days ago</small>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <small>Uploads:</small>
                                                <div class="fw-bold">3</div>
                                            </div>
                                            <div class="me-3">
                                                <small>Downloads:</small>
                                                <div class="fw-bold">8</div>
                                            </div>
                                            <div>
                                                <small>Rating:</small>
                                                <div class="fw-bold">3.5/5</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">More Info Needed</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary view-request" 
                                                    data-id="4" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button type="button" class="btn btn-outline-info request-info" 
                                                    data-id="4">
                                                <i class="fas fa-question-circle"></i> Request Info
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- View Request Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Applicant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="https://ui-avatars.com/api/?name=Ali+Bakar&background=667eea&color=fff&size=120" 
                             class="rounded-circle mb-3" alt="Profile">
                        <h5 id="modal-name">Ali Bakar</h5>
                        <p class="text-muted" id="modal-email">ali.bakar@student.edu</p>
                        <div class="badge bg-warning" id="modal-status">Pending</div>
                    </div>
                    <div class="col-md-8">
                        <h6>Application Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Application ID:</strong></td>
                                <td id="modal-app-id">#VR001</td>
                            </tr>
                            <tr>
                                <td><strong>Submitted:</strong></td>
                                <td id="modal-submitted">Nov 18, 2025 (3 days ago)</td>
                            </tr>
                            <tr>
                                <td><strong>Student ID:</strong></td>
                                <td>CB21001</td>
                            </tr>
                            <tr>
                                <td><strong>Course:</strong></td>
                                <td>Software Engineering</td>
                            </tr>
                        </table>

                        <h6 class="mt-4">Upload Statistics</h6>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center p-2 border rounded">
                                    <div class="fw-bold" id="modal-uploads">12</div>
                                    <small class="text-muted">Uploads</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center p-2 border rounded">
                                    <div class="fw-bold" id="modal-downloads">45</div>
                                    <small class="text-muted">Downloads</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center p-2 border rounded">
                                    <div class="fw-bold" id="modal-rating">4.5</div>
                                    <small class="text-muted">Rating</small>
                                </div>
                            </div>
                        </div>

                        <h6 class="mt-4">Recent Uploads</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Database Design Notes.pdf</span>
                                <small class="text-muted">Nov 15, 2025</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Algorithm Complexity.pptx</span>
                                <small class="text-muted">Nov 10, 2025</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Web Development Cheatsheet.pdf</span>
                                <small class="text-muted">Nov 5, 2025</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="modal-approve-btn">Approve</button>
                <button type="button" class="btn btn-danger" id="modal-reject-btn">Reject</button>
                <button type="button" class="btn btn-info" id="modal-info-btn">Request More Info</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Reason Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="rejectReason" class="form-label">Select Reason <span class="text-danger">*</span></label>
                    <select class="form-select" id="rejectReason">
                        <option value="">Choose a reason...</option>
                        <option value="insufficient_uploads">Insufficient upload history</option>
                        <option value="low_quality">Low quality of uploaded content</option>
                        <option value="previous_violations">Previous content violations</option>
                        <option value="incomplete_profile">Incomplete profile information</option>
                        <option value="other">Other (specify below)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="rejectNotes" class="form-label">Additional Notes</label>
                    <textarea class="form-control" id="rejectNotes" rows="3" 
                              placeholder="Provide detailed explanation for rejection..."></textarea>
                </div>
                <div class="form-text">
                    Applicant will receive notification with your feedback. They can reapply after 30 days.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmReject">Confirm Rejection</button>
            </div>
        </div>
    </div>
</div>

<!-- Request Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Request More Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="infoMessage" class="form-label">Message to Applicant <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="infoMessage" rows="4" 
                              placeholder="Specify what additional information you need from the applicant..."></textarea>
                </div>
                <div class="form-text">
                    Applicant will receive this message and can update their application.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" id="confirmInfoRequest">Send Request</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Update count badges
    function updateCounts() {
        const all = $('.request-row').length;
        const pending = $('.request-row[data-status="pending"]').length;
        const approved = $('.request-row[data-status="approved"]').length;
        
        $('#count-all').text(all);
        $('#count-pending').text(pending);
        $('#count-approved').text(approved);
    }
    
    // Filter functionality
    $('.filter-btn').on('click', function() {
        const filter = $(this).data('filter');
        
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        if (filter === 'all') {
            $('.request-row').show();
        } else {
            $('.request-row').hide();
            $(`.request-row[data-status="${filter}"]`).show();
        }
    });
    
    // View request modal
    $('.view-request').on('click', function() {
        const requestId = $(this).data('id');
        const row = $(this).closest('tr');
        
        // Populate modal with data from row
        $('#modal-name').text(row.find('strong').text());
        $('#modal-email').text(row.find('.text-muted.small').text());
        $('#modal-app-id').text(row.find('td:first').text());
        $('#modal-submitted').text(row.find('td:nth-child(3) div:first').text());
        
        // Get stats from the row
        const stats = row.find('td:nth-child(4)');
        $('#modal-uploads').text(stats.find('.fw-bold:first').text());
        $('#modal-downloads').text(stats.find('.fw-bold:eq(1)').text());
        $('#modal-rating').text(stats.find('.fw-bold:last').text());
        
        // Set button data
        $('#modal-approve-btn').data('id', requestId);
        $('#modal-reject-btn').data('id', requestId);
        $('#modal-info-btn').data('id', requestId);
    });
    
    // Approve request
    $('.approve-request, #modal-approve-btn').on('click', function(e) {
        e.preventDefault();
        const requestId = $(this).data('id');
        
        Swal.fire({
            title: 'Approve Application?',
            text: "This user will become a verified contributor.",
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
                    url: `/admin/verification/${requestId}/approve`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Approved!',
                            'User has been verified as contributor.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
    
    // Reject request
    let currentRejectId = null;
    $('.reject-request, #modal-reject-btn').on('click', function(e) {
        e.preventDefault();
        currentRejectId = $(this).data('id');
        $('#rejectModal').modal('show');
    });
    
    $('#confirmReject').on('click', function() {
        const reason = $('#rejectReason').val();
        const notes = $('#rejectNotes').val();
        
        if (!reason) {
            Swal.fire('Error', 'Please select a rejection reason.', 'error');
            return;
        }
        
        $.ajax({
            url: `/admin/verification/${currentRejectId}/reject`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                reason: reason,
                notes: notes
            },
            success: function(response) {
                $('#rejectModal').modal('hide');
                Swal.fire(
                    'Rejected!',
                    'Application has been rejected.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            }
        });
    });
    
    // Request more information
    let currentInfoId = null;
    $('.request-info, #modal-info-btn').on('click', function(e) {
        e.preventDefault();
        currentInfoId = $(this).data('id');
        $('#infoModal').modal('show');
    });
    
    $('#confirmInfoRequest').on('click', function() {
        const message = $('#infoMessage').val();
        
        if (!message.trim()) {
            Swal.fire('Error', 'Please enter a message for the applicant.', 'error');
            return;
        }
        
        $.ajax({
            url: `/admin/verification/${currentInfoId}/request-info`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: message
            },
            success: function(response) {
                $('#infoModal').modal('hide');
                Swal.fire(
                    'Request Sent!',
                    'Applicant has been notified.',
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