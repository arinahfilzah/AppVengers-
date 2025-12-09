@extends('layouts.app')

@section('title', 'Resources - ' . $subject)

@section('content')

<section class="page-header">
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('dashboard') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('course') }}">Subjects <i class="fa fa-chevron-right"></i></a></span>
                    <span>{{ $subject }}</span>
                </p>
                <h1 class="mb-0 bread">{{ $subject }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">

        <!-- Subject Info Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-left: 4px solid #4986fc;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-2" style="color: #4986fc;">
                                    <i class="fa fa-book"></i> {{ $subject }}
                                </h3>
                                <p class="mb-2">
                                    <span class="badge badge-primary">{{ $resources->first()->category ?? 'N/A' }}</span>
                                    <span class="badge badge-secondary">{{ $resources->first()->year ?? 'N/A' }}</span>
                                </p>
                                <p class="mb-0 text-muted">
                                    <i class="fa fa-file"></i> {{ $resources->count() }} Resource(s) Available
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('course') }}" class="btn btn-outline-primary">
                                    <i class="fa fa-arrow-left"></i> Back to Subjects
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Resources Message -->
        @if($resources->isEmpty())
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning text-center p-5">
                        <i class="fa fa-folder-open fa-3x mb-3" style="color: #ffc107;"></i>
                        <h4>No Resources Available</h4>
                        <p>There are currently no resources uploaded for this subject.</p>
                        <p class="mb-0">Be the first to contribute!</p>
                        <a href="{{ route('uploadResource') }}" class="btn btn-primary mt-3">
                            <i class="fa fa-upload"></i> Upload Resource
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Resource Cards -->
            <div class="row">
                @foreach($resources as $resource)
                    <div class="col-md-6 mb-4 ftco-animate">
                        <div class="card h-100 shadow-sm resource-card" style="transition: all 0.3s;">
                            <div class="card-body">
                                <!-- Resource Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0" style="color: #4986fc;">
                                        <i class="fa fa-file-alt"></i> {{ $resource->title }}
                                    </h5>
                                    @if($resource->qr_code_path)
                                        <span class="badge badge-success">
                                            <i class="fa fa-qrcode"></i> QR
                                        </span>
                                    @endif
                                </div>

                                <!-- Resource Description -->
                                @if($resource->description)
                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($resource->description, 100) }}
                                    </p>
                                @endif

                                <!-- Resource Meta -->
                                <div class="resource-meta mb-3">
                                    <p class="mb-1">
                                        <strong><i class="fa fa-folder"></i> Category:</strong> 
                                        {{ $resource->category }}
                                    </p>
                                    <p class="mb-1">
                                        <strong><i class="fa fa-calendar"></i> Year:</strong> 
                                        {{ $resource->year }}
                                    </p>
                                    <p class="mb-1">
                                        <strong><i class="fa fa-clock"></i> Uploaded:</strong> 
                                        {{ $resource->upload_date->format('M d, Y') }}
                                    </p>
                                    @if($resource->uploader)
                                        <p class="mb-0">
                                            <strong><i class="fa fa-user"></i> By:</strong> 
                                            {{ $resource->uploader->name }}
                                        </p>
                                    @endif
                                </div>

                                <!-- QR Code Preview (if exists) -->
                                @if($resource->qr_code_path)
                                    <div class="text-center mb-3 p-2" style="background: #f9faff; border-radius: 8px;">
                                        <img src="{{ asset('storage/' . $resource->qr_code_path) }}" 
                                             alt="QR Code" 
                                             class="img-fluid" 
                                             style="max-width: 100px; cursor: pointer;"
                                             onclick="showQrModal('{{ asset('storage/' . $resource->qr_code_path) }}', '{{ $resource->title }}')">
                                        <p class="mb-0 mt-1 small text-muted">Scan to access</p>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" 
                                       target="_blank" 
                                       class="btn btn-primary btn-sm flex-fill"
                                       onclick="return checkFileOpen(this)">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('resource.download', $resource->id) }}" 
                                       class="btn btn-success btn-sm flex-fill">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($resources->hasPages())
                <div class="row mt-4">
                    <div class="col">
                        <div class="block-27">
                            <ul>
                                @if($resources->onFirstPage())
                                    <li class="disabled"><span>&lt;</span></li>
                                @else
                                    <li><a href="{{ $resources->previousPageUrl() }}">&lt;</a></li>
                                @endif

                                @foreach($resources->getUrlRange(1, $resources->lastPage()) as $page => $url)
                                    @if($page == $resources->currentPage())
                                        <li class="active"><span>{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                @if($resources->hasMorePages())
                                    <li><a href="{{ $resources->nextPageUrl() }}">&gt;</a></li>
                                @else
                                    <li class="disabled"><span>&gt;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>
</section>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="border-bottom: 2px solid #4986fc;">
                <h5 class="modal-title" id="qrModalLabel" style="color: #4986fc;">
                    <i class="fa fa-qrcode"></i> QR Code
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <h6 id="qrResourceTitle" class="mb-3" style="color: #4986fc;"></h6>
                <img id="qrModalImage" src="" alt="QR Code" class="img-fluid" style="max-width: 300px; border: 3px solid #4986fc; border-radius: 10px;">
                <p class="text-muted mt-3">Scan this QR code with your mobile device</p>
            </div>
            <div class="modal-footer" style="border-top: 2px solid #4986fc;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Show QR Modal
function showQrModal(qrUrl, title) {
    document.getElementById('qrModalImage').src = qrUrl;
    document.getElementById('qrResourceTitle').textContent = title;
    const modal = new bootstrap.Modal(document.getElementById('qrModal'));
    modal.show();
}

// Check if file can be opened (AF2: File Cannot Be Opened)
function checkFileOpen(element) {
    const fileExtension = element.href.split('.').pop().toLowerCase();
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile && (fileExtension === 'docx' || fileExtension === 'pdf')) {
        Swal.fire({
            title: 'File May Not Open',
            text: 'This file type may not open directly on your device. Would you like to download it instead?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Try Anyway',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get resource ID from the View button's parent container
                const card = element.closest('.card');
                const downloadBtn = card.querySelector('.btn-success');
                if (downloadBtn) {
                    window.location.href = downloadBtn.href;
                }
                return false;
            }
        });
    }
    return true;
}

// Hover effect for resource cards
document.querySelectorAll('.resource-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
        this.style.boxShadow = '0 4px 15px rgba(73, 134, 252, 0.3)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '';
    });
});
</script>

@endsection