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

        {{-- Resource Info --}}
        <div class="card mb-4 shadow-sm" style="border-left: 4px solid #4986fc;">
            <div class="card-body">
                <h4 style="color: #4986fc;">{{ $resource->title }}</h4>
                <p class="mb-2"><strong>Subject:</strong> {{ $resource->subject }}</p>
                <p class="mb-2"><strong>Category:</strong> {{ $resource->category }}</p>
                <p class="mb-2"><strong>Year:</strong> {{ $resource->year }}</p>
                <p class="mb-2"><strong>Current Version:</strong> v{{ $resource->current_version }}</p>
                <p class="mb-0"><strong>Total Versions:</strong> {{ $resource->versions->count() }}</p>
            </div>
        </div>

        {{-- Version Timeline --}}
        <div class="card shadow-sm">
            <div class="card-header" style="background: #4986fc; color: white;">
                <h5 class="mb-0"><i class="fa fa-history"></i> Version Timeline</h5>
            </div>
            <div class="card-body">

                @if($resource->versions->isEmpty())
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> No version history available yet.
                </div>
                @else
                <div class="timeline">
                    @foreach($resource->versions as $version)
                    <div class="timeline-item mb-4 pb-4" style="border-bottom: 1px solid #e0e0e0;">
                        <div class="row">

                            <div class="col-md-2 text-center">
                                <div class="version-badge"
                                    style="background: {{ $version->version_number == $resource->current_version ? '#28a745' : '#6c757d' }};
                        color: white;
                        padding: 10px;
                        border-radius: 50px;
                        font-weight: bold;
                        display: inline-block;
                        min-width: 60px;">
                                    v{{ $version->version_number }}
                                </div>

                                @if($version->version_number == $resource->current_version)
                                <div class="mt-2">
                                    <span class="badge bg-success">Current</span>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-10">
                                <h6 class="mb-1">
                                    <strong>{{ $version->change_notes ?? 'No notes provided' }}</strong>
                                </h6>

                              

                                <p class="mb-1 text-muted">
                                    <i class="fa fa-user"></i>
                                    Updated by: {{ optional($version->updater)->name ?? 'Unknown' }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <i class="fa fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($version->created_at)->format('M d, Y h:i A') }}
                                    <small>({{ \Carbon\Carbon::parse($version->created_at)->diffForHumans() }})</small>

                                </p>

                                <a href="{{ route('resource.downloadVersion', [$resource->id, $version->version_number]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i> Download
                                </a>

                                <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i> View File
                                </a>

                                @if($version->version_number != $resource->current_version)
                                <button onclick="confirmRestore({{ $resource->id }}, {{ $version->version_number }})"
                                    class="btn btn-sm btn-warning">
                                    <i class="fa fa-undo"></i> Restore This Version
                                </button>
                                @endif
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
            <a href="{{ route('manageResource') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Manage Resources
            </a>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmRestore(resourceId, versionNumber) {
        Swal.fire({
            title: 'Restore Version?',
            html: `Are you sure you want to restore <strong>version ${versionNumber}</strong>?<br><br>
               <small class="text-muted">This will create a new version with the content from v${versionNumber}</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Restore It',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
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
</script>

@endsection