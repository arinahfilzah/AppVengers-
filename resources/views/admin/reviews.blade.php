@extends('layouts.app')

@section('title', 'Content Review')

@section('content')
<div class="container py-4" style="max-width: 1200px; min-height: calc(100vh - 80px);">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">Content Review</h1>
                    <p class="text-muted mb-0">Review and moderate uploaded resources</p>
                </div>

                <div class="d-flex">
                    <form method="GET" action="{{ route('admin.reviews') }}" class="d-flex">
                        <div class="input-group me-3" style="width: 300px;">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="q"
                                   placeholder="Search resources..." value="{{ $search ?? '' }}">
                        </div>

                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.reviews', ['filter' => 'pending', 'q' => $search]) }}"
                               class="btn btn-outline-warning filter-btn {{ ($filter ?? 'pending') === 'pending' ? 'active' : '' }}">
                                Pending <span class="badge bg-warning ms-1" id="count-pending">{{ $counts['pending'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('admin.reviews', ['filter' => 'approved', 'q' => $search]) }}"
                               class="btn btn-outline-success filter-btn {{ ($filter ?? '') === 'approved' ? 'active' : '' }}">
                                Approved <span class="badge bg-success ms-1" id="count-approved">{{ $counts['approved'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('admin.reviews', ['filter' => 'rejected', 'q' => $search]) }}"
                               class="btn btn-outline-danger filter-btn {{ ($filter ?? '') === 'rejected' ? 'active' : '' }}">
                                Rejected <span class="badge bg-danger ms-1" id="count-rejected">{{ $counts['rejected'] ?? 0 }}</span>
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Content Review Cards -->
    <div class="row g-4" id="resourcesContainer">

        @forelse($resources as $r)
            @php
                $status = $r->review_status ?? 'pending';
                $badgeClass = $status === 'approved' ? 'bg-success' : ($status === 'rejected' ? 'bg-danger' : 'bg-warning');

                $title = $r->title;
                $uploaderName = optional($r->uploader)->name ?? 'Unknown';
                $uploaderEmail = optional($r->uploader)->email ?? '';
                $uploadedAt = $r->created_at ? $r->created_at->diffForHumans() : '-';

                $ext = strtolower(pathinfo($r->file_path ?? '', PATHINFO_EXTENSION));
                $fileIcon = 'fa-file';
                $fileIconColor = 'text-secondary';

                if (in_array($ext, ['pdf'])) { $fileIcon = 'fa-file-pdf'; $fileIconColor = 'text-danger'; }
                elseif (in_array($ext, ['ppt', 'pptx'])) { $fileIcon = 'fa-file-powerpoint'; $fileIconColor = 'text-warning'; }
                elseif (in_array($ext, ['zip', 'rar'])) { $fileIcon = 'fa-file-archive'; $fileIconColor = 'text-secondary'; }
                elseif (in_array($ext, ['png','jpg','jpeg','gif','webp'])) { $fileIcon = 'fa-file-image'; $fileIconColor = 'text-info'; }

                $desc = $r->description ?: 'No description provided.';
            @endphp

            <div class="col-xl-4 col-lg-6 resource-card"
                 data-status="{{ $status }}"
                 data-search="{{ $title }} {{ $r->category }} {{ $r->subject }} {{ $uploaderName }}">

                <div class="card border-0 shadow-sm h-100 {{ $status === 'rejected' ? 'opacity-75' : '' }}">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($status) }}{{ $status === 'pending' ? ' Review' : '' }}
                            </span>
                            <small class="text-muted">{{ $uploadedAt }}</small>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $title }}</h5>

                        <p class="card-text text-muted small mb-3">
                            {{ \Illuminate\Support\Str::limit($desc, 120) }}
                        </p>

                        <div class="mb-3">
                            <span class="badge bg-light text-dark me-1">{{ $r->subject ?? 'N/A' }}</span>
                            <span class="badge bg-light text-dark">Year {{ $r->year ?? 'N/A' }}</span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($uploaderName) }}&background=667eea&color=fff&rounded=true"
                                 class="rounded-circle me-2" width="30" height="30" alt="Uploader">
                            <div>
                                <small class="d-block"><strong>{{ $uploaderName }}</strong></small>
                                <small class="text-muted">{{ $uploaderEmail }}</small>
                            </div>
                        </div>

                        <div class="file-info mb-3">
                            <small class="d-flex align-items-center text-muted">
                                <i class="fas {{ $fileIcon }} {{ $fileIconColor }} me-2"></i>
                                {{ strtoupper($ext ?: 'FILE') }} • {{ $r->category ?? 'N/A' }}
                            </small>
                        </div>

                        @if(($status === 'rejected') && !empty($r->rejection_notes))
                            <div class="alert alert-danger small mb-3">
                                <i class="fas fa-ban me-1"></i>
                                <strong>Removal Notes:</strong> {{ $r->rejection_notes }}
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-white border-0 pt-0">
                        @if($status === 'pending')
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm preview-btn" data-id="{{ $r->id }}">
                                    <i class="fas fa-eye me-1"></i> Preview Content
                                </button>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-success btn-sm approve-btn" data-id="{{ $r->id }}">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm reject-btn" data-id="{{ $r->id }}">
                                        <i class="fas fa-times me-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                        @elseif($status === 'approved')
                            <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                <i class="fas fa-check-circle me-1"></i> Approved
                            </button>
                        @else
                            <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                                <i class="fas fa-times-circle me-1"></i> Rejected
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <div class="display-1 text-muted mb-3">
                    <i class="fas fa-search"></i>
                </div>
                <h4 class="text-muted">No resources found</h4>
                <p class="text-muted">Try changing your search or filter criteria</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $resources->links() }}
    </div>

</div>

<!-- Preview Modal (REAL preview + metadata) -->
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
                        <div class="border rounded p-3 bg-light" style="height: 520px; overflow: hidden;">
                            <div id="previewArea" class="h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center text-muted">
                                    <i class="fas fa-file fa-4x mb-3"></i>
                                    <div>Select a resource to preview.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h6>File Details</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Title:</strong></td><td id="pv-title">-</td></tr>
                            <tr><td><strong>Type:</strong></td><td id="pv-type">-</td></tr>
                            <tr><td><strong>Uploaded:</strong></td><td id="pv-uploaded">-</td></tr>
                            <tr><td><strong>Uploader:</strong></td><td id="pv-uploader">-</td></tr>
                            <tr><td><strong>Email:</strong></td><td id="pv-email">-</td></tr>
                            <tr><td><strong>Subject:</strong></td><td id="pv-subject">-</td></tr>
                            <tr><td><strong>Year:</strong></td><td id="pv-year">-</td></tr>
                            <tr><td><strong>Category:</strong></td><td id="pv-category">-</td></tr>
                            <tr><td><strong>Status:</strong></td><td id="pv-status">-</td></tr>
                        </table>

                        <div class="d-grid gap-2">
                            <a href="#" target="_blank" class="btn btn-outline-primary btn-sm" id="pv-open">
                                <i class="fas fa-external-link-alt me-1"></i> Open File
                            </a>
                        </div>

                        <h6 class="mt-4">Description</h6>
                        <p class="small text-muted mb-0" id="pv-desc">-</p>

                        <div class="alert alert-info small mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            If inline preview is not supported, use “Open File”.
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
                    <label class="form-check-label" for="notifyUploader">Notify uploader about removal</label>
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

    // =========================
    // PREVIEW (REAL)
    // Requires route: GET /admin/reviews/{id}/preview returning JSON:
    // {
    //   title, description, category, year, subject, status, uploaded_human,
    //   uploader: {name,email},
    //   file: { ext, preview_url }
    // }
    // =========================
    $('.preview-btn').on('click', function() {
        const resourceId = $(this).data('id');

        $('#previewModal').modal('show');
        $('#preview-approve-btn').data('id', resourceId);
        $('#preview-reject-btn').data('id', resourceId);

        // reset
        $('#previewArea').html(`
            <div class="text-center text-muted">
                <i class="fas fa-spinner fa-spin fa-3x mb-3"></i>
                <div>Loading preview...</div>
            </div>
        `);

        $('#pv-title,#pv-type,#pv-uploaded,#pv-uploader,#pv-email,#pv-subject,#pv-year,#pv-category,#pv-status').text('-');
        $('#pv-desc').text('-');
        $('#pv-open').attr('href', '#');

        $.ajax({
            url: `/admin/reviews/${resourceId}/preview`,
            method: 'GET',
            success: function(data) {
                $('#pv-title').text(data.title ?? '-');
                $('#pv-type').text(((data.file?.ext ?? 'file')).toUpperCase());
                $('#pv-uploaded').text(data.uploaded_human ?? '-');
                $('#pv-uploader').text(data.uploader?.name ?? '-');
                $('#pv-email').text(data.uploader?.email ?? '-');
                $('#pv-subject').text(data.subject ?? '-');
                $('#pv-year').text(data.year ?? '-');
                $('#pv-category').text(data.category ?? '-');
                $('#pv-status').text((data.status ?? 'pending').toUpperCase());
                $('#pv-desc').text(data.description ?? '-');

                const url = data.file?.preview_url;
                $('#pv-open').attr('href', url || '#');

                if (!url) {
                    $('#previewArea').html(`
                        <div class="text-center text-muted">
                            <i class="fas fa-file fa-4x mb-3"></i>
                            <div>No preview available (missing file path).</div>
                        </div>
                    `);
                    return;
                }

                const ext = (data.file?.ext ?? '').toLowerCase();

                if (ext === 'pdf') {
                    $('#previewArea').html(`
                        <object data="${url}" type="application/pdf" width="100%" height="100%">
                            <iframe src="${url}" width="100%" height="100%"></iframe>
                        </object>
                    `);
                } else if (['png','jpg','jpeg','gif','webp'].includes(ext)) {
                    $('#previewArea').html(`
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <img src="${url}" alt="Preview" style="max-width:100%; max-height:100%; object-fit:contain;">
                        </div>
                    `);
                } else {
                    $('#previewArea').html(`
                        <div class="text-center">
                            <i class="fas fa-file fa-5x text-secondary mb-3"></i>
                            <div class="fw-bold mb-2">Preview not supported for this file type.</div>
                            <a href="${url}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download me-1"></i> Download / Open File
                            </a>
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                $('#previewArea').html(`
                    <div class="text-center text-danger">
                        <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
                        <div>Failed to load preview.</div>
                    </div>
                `);
            }
        });
    });

    // =========================
    // APPROVE
    // =========================
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
                $.ajax({
                    url: `/admin/reviews/${currentApproveId}/approve`,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire('Approved!', 'Content has been approved.', 'success')
                        .then(() => location.reload());
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message ?? 'Approval failed.', 'error');
                    }
                });
            }
        });
    });

    // =========================
    // REMOVE
    // =========================
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
            success: function() {
                $('#removeModal').modal('hide');
                Swal.fire('Removed!', 'Content has been removed.', 'success')
                .then(() => location.reload());
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message ?? 'Removal failed.', 'error');
            }
        });
    });

});
</script>
@endpush

@endsection
