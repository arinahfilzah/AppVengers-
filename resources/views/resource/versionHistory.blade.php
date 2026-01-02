@extends('layouts.app')

@section('title', 'Version History')

@section('content')

<section class="page-header">
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <h1 class="mb-0 bread">Version History</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">

        {{-- Success Messages --}}
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif

        @if(session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Information',
                text: "{{ session('info') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif

        {{-- NF4: Resource Info --}}
        <div class="card mb-4 shadow-sm" style="border-left: 4px solid #4986fc;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 style="color: #4986fc;">
                            <i class="fa fa-file"></i> {{ $resource->title }}
                        </h4>
                        <p class="mb-2"><strong>Subject:</strong> {{ $resource->subject }}</p>
                        <p class="mb-2"><strong>Category:</strong> {{ $resource->category }}</p>
                        <p class="mb-2"><strong>Year:</strong> {{ $resource->year }}</p>
                        <p class="mb-2">
                            <strong>Owner:</strong>
                            {{ $resource->uploader->name }}
                            @if($resource->uploader_id === auth()->id())
                            <span class="badge bg-primary">You</span>
                            @endif
                        </p>
                    </div>
                    <div class="text-end">
                        <div class="mb-2">
                            <span class="badge bg-success" style="font-size: 14px; padding: 8px 12px;">
                                <i class="fa fa-code-branch"></i> Current: v{{ $resource->current_version }}
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-secondary" style="font-size: 14px; padding: 8px 12px;">
                                <i class="fa fa-history"></i> Total: {{ $resource->versions->count() }} Version(s)
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- NF7: Version Timeline --}}
        <div class="card shadow-sm">
            <div class="card-header" style="background: #4986fc; color: white;">
                <h5 class="mb-0">
                    <i class="fa fa-history"></i> Version Timeline
                </h5>
            </div>
            <div class="card-body">

                {{-- AF1: No Previous Versions --}}
                @if($resource->versions->isEmpty())
                <div class="alert alert-info text-center py-5">
                    <i class="fa fa-info-circle fa-3x mb-3" style="color: #17a2b8;"></i>
                    <h5>No previous versions available for this resource.</h5>
                    <p class="text-muted mb-0">Version history will appear here once you update the resource.</p>
                </div>
                @else
                <div class="timeline">
                    @foreach($resource->versions as $index => $version)
                    <div class="timeline-item mb-4 pb-4" style="border-bottom: {{ $loop->last ? 'none' : '1px solid #e0e0e0' }};">
                        <div class="row">

                            {{-- NF7: Version Badge --}}
                            <div class="col-md-2 text-center">
                                <div class="version-badge"
                                    style="background: {{ $version->version_number == $resource->current_version ? '#28a745' : '#6c757d' }};
                                           color: white;
                                           padding: 12px;
                                           border-radius: 50px;
                                           font-weight: bold;
                                           display: inline-block;
                                           min-width: 70px;
                                           font-size: 16px;">
                                    v{{ $version->version_number }}
                                </div>

                                @if($version->version_number == $resource->current_version)
                                <div class="mt-2">
                                    <span class="badge bg-success">
                                        <i class="fa fa-check-circle"></i> Current
                                    </span>
                                </div>
                                @endif
                            </div>

                            {{-- NF7: Version Details --}}
                            <div class="col-md-10">
                                <div class="card border-0 shadow-sm"
                                    style="background: {{ $version->version_number == $resource->current_version ? '#e8f5e9' : '#f8f9fa' }};">
                                    <div class="card-body">
                                        {{-- NF7: Change Notes --}}
                                        <h6 class="mb-2">
                                            <i class="fa fa-sticky-note text-primary"></i>
                                            <strong>{{ $version->change_notes ?? 'No notes provided' }}</strong>
                                        </h6>

                                        {{-- NF7: Contributor Name --}}
                                        <p class="mb-1 text-muted">
                                            <i class="fa fa-user"></i>
                                            <strong>Updated by:</strong>
                                            {{ optional($version->updater)->name ?? 'Unknown' }}
                                            @if($version->updated_by === auth()->id())
                                            <span class="badge bg-info">You</span>
                                            @endif
                                        </p>

                                        {{-- NF7: Update Date --}}
                                        <p class="mb-3 text-muted">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>Date:</strong>
                                            {{ \Carbon\Carbon::parse($version->created_at)->format('M d, Y h:i A') }}
                                            <small>({{ \Carbon\Carbon::parse($version->created_at)->diffForHumans() }})</small>
                                        </p>

                                        {{-- NF10: Action Buttons --}}
                                        <div class="btn-group gap-2" role="group">
                                            <a href="{{ route('resource.viewVersion', [$resource->id, $version->version_number]) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i> View
                                            </a>

                                            <a href="{{ route('resource.downloadVersion', [$resource->id, $version->version_number]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                            
                                        {{-- Restore Version (Owner Only, Not Current Version) --}}
                                        @if($resource->uploader_id === auth()->id() && $version->version_number != $resource->current_version)
                                        <button onclick="confirmRestore({{ $resource->id }}, {{ $version->version_number }})"
                                            class="btn btn-sm btn-warning"
                                            title="Restore this version as current">
                                            <i class="fa fa-undo"></i> Restore
                                        </button>
                                        @endif
                                    </div>

                                    {{-- File Info --}}
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fa fa-file"></i>
                                            File: {{ basename($version->file_path) }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>

    {{-- Back Button --}}
    <div class="text-center mt-4">
        <a href="{{ route('manageResource') }}" class="btn btn-secondary btn-lg">
            <i class="fa fa-arrow-left"></i> Back to Manage Resources
        </a>
    </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Restore Version Confirmation (Owner Only)
    function confirmRestore(resourceId, versionNumber) {
        Swal.fire({
            title: 'Restore Version?',
            html: `
                <div class="text-start p-3">
                    <p>Are you sure you want to restore <strong>version ${versionNumber}</strong>?</p>
                    <div class="alert alert-warning mt-3">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Note:</strong> This will create a new version with the content from v${versionNumber}. 
                        The current version will be preserved in history.
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-undo"></i> Yes, Restore It',
            cancelButtonText: '<i class="fa fa-times"></i> Cancel',
            width: '500px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Restoring...',
                    text: 'Please wait while we restore the version.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Create a form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/resource/${resourceId}/version/${versionNumber}/restore`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    //Handle file opening errors
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('a[href*="viewVersion"]');
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Add loading indicator
                const icon = this.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fa fa-spinner fa-spin';

                setTimeout(() => {
                    icon.className = originalClass;
                }, 2000);
            });
        });
    });
</script>

@endsection