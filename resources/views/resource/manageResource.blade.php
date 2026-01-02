@extends('layouts.app')

@section('title', 'Manage Resources')

@section('content')

<section class="page-header">
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <h1 class="mb-0 bread">Manage Resources</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        @endif

        @if(session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Notice',
                text: "{{ session('warning') }}",
                timer: 2000,
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
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        @endif

        {{-- VERSION UPDATE SUCCESS --}}
        @if(session('version_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Version Updated!',
                html: `
                    <div style="padding: 20px;">
                        <i class="fa fa-code-branch" style="font-size: 60px; color: #28a745; margin-bottom: 15px;"></i>
                        <p style="font-size: 16px; margin-top: 10px; font-weight: 600;">{{ session('version_success') }}</p>
                        <p style="color: #666; font-size: 14px;">All previous versions are still accessible in version history.</p>
                    </div>
                `,
                confirmButtonText: 'Great!',
                confirmButtonColor: '#28a745',
                timer: 4000,
                timerProgressBar: true
            });
        </script>
        @endif

        {{-- QR CODE GENERATION SUCCESS --}}
        @if(session('qr_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'QR Code Generated!',
                html: `
                    <div style="padding: 20px;">
                        <i class="fa fa-qrcode" style="font-size: 60px; color: #4986fc; margin-bottom: 15px;"></i>
                        <p style="font-size: 16px; margin-top: 10px;">{{ session('qr_success') }}</p>
                        <p style="color: #666; font-size: 14px;">You can now download or share the QR code with students.</p>
                    </div>
                `,
                confirmButtonText: 'Great!',
                confirmButtonColor: '#4986fc',
                timer: 4000,
                timerProgressBar: true
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

        {{-- SECTION 1: PENDING COLLABORATION REQUESTS --}}
        @if($pendingRequests->count() > 0)
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-bell"></i> Pending Collaboration Requests
                            <span class="badge bg-danger">{{ $pendingRequests->count() }}</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        @foreach($pendingRequests as $request)
                        <div class="alert alert-light border mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-2">
                                        <i class="fa fa-file"></i> {{ $request->resource->title }}
                                    </h5>
                                    <p class="mb-1">
                                        <strong><i class="fa fa-user"></i> Requested by:</strong>
                                        {{ $request->requester->name }} ({{ $request->requester->email }})
                                    </p>
                                    <p class="mb-1">
                                        <strong><i class="fa fa-clock-o"></i> Date:</strong>
                                        {{ $request->created_at->format('M d, Y h:i A') }}
                                    </p>
                                    @if($request->message)
                                    <p class="mb-0 text-muted">
                                        <strong>Message:</strong> {{ $request->message }}
                                    </p>
                                    @endif
                                </div>
                                <div class="col-md-4 text-end">
                                    <form action="{{ route('collaboration.approve', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm mb-2"
                                            onclick="return confirm('Approve this collaboration request?')">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <br>
                                    <form action="{{ route('collaboration.reject', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Reject this collaboration request?')">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION 2: COLLABORATED RESOURCES --}}
        @if($collaboratedResources->count() > 0)
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-handshake-o"></i> Collaborated Resources
                            <span class="badge bg-light text-dark">{{ $collaboratedResources->count() }}</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($collaboratedResources as $resource)
                            <div class="col-md-4 mb-4 ftco-animate">
                                <div class="card h-100 shadow-sm border-info">
                                    <div class="card-body">
                                        {{-- Collaborator Badge --}}
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title">{{ $resource->title }}</h5>
                                            <div>
                                                <span class="badge bg-info" style="font-size: 12px;">
                                                    v{{ $resource->current_version }}
                                                </span>
                                                <br>
                                                <span class="badge bg-secondary mt-1" style="font-size: 10px;">
                                                    Collaborator
                                                </span>
                                            </div>
                                        </div>

                                        <p class="card-text">{{ $resource->description }}</p>
                                        <p class="card-text"><small class="text-muted"><strong>Owner:</strong> {{ $resource->uploader->name }}</small></p>
                                        <p class="card-text"><strong>Category:</strong> {{ $resource->category }}</p>
                                        <p class="card-text"><strong>Year:</strong> {{ $resource->year }}</p>
                                        <p class="card-text"><strong>Subject:</strong> {{ $resource->subject }}</p>

                                        {{-- Version Info --}}
                                        @if($resource->versions->count() > 1)
                                        <div class="alert alert-info p-2 mb-3" style="font-size: 13px;">
                                            <i class="fa fa-history"></i>
                                            <strong>{{ $resource->versions->count() }} versions</strong> available
                                        </div>
                                        @endif

                                        {{-- Action Buttons --}}
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/uploads/' . $resource->file_path) }}"
                                                target="_blank" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('resource.edit', $resource->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('resource.updateVersionForm', $resource->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-upload"></i> Update
                                            </a>
                                            @if($resource->versions->count() > 0)
                                            <a href="{{ route('resource.versionHistory', $resource->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-history"></i> Versions
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION 3: MY UPLOADED RESOURCES --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-upload"></i> My Uploaded Resources
                            <span class="badge bg-light text-dark">{{ $ownedResources->count() }}</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($ownedResources->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa fa-folder-open" style="font-size: 60px; color: #ccc;"></i>
                            <p class="text-muted mt-3">You have not uploaded any resources yet.</p>
                            <a href="{{ route('uploadResource') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Upload Your First Resource
                            </a>
                        </div>
                        @else
                        <div class="row">
                            @foreach($ownedResources as $resource)
                            <div class="col-md-4 mb-4 ftco-animate">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        {{-- Version Badge --}}
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ $resource->title }}</h5>

                                            <div class="d-flex flex-column gap-1 align-items-end">
                                                <span class="badge bg-dark text-white px-2 py-1" style="font-size: 11px;">
                                                    v{{ $resource->current_version }}
                                                </span>

                                                @if($resource->collaborators->count() > 0)
                                                <span class="badge bg-secondary text-white px-2 py-1"
                                                    style="font-size: 11px;"
                                                    title="{{ $resource->collaborators->count() }} collaborator(s)">
                                                    <i class="fa fa-users me-1"></i>
                                                    {{ $resource->collaborators->count() }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>


                                        <p class="card-text">{{ $resource->description }}</p>
                                        <p class="card-text"><strong>Category:</strong> {{ $resource->category }}</p>
                                        <p class="card-text"><strong>Year:</strong> {{ $resource->year }}</p>
                                        <p class="card-text"><strong>Subject:</strong> {{ $resource->subject }}</p>

                                        {{-- Version Info --}}
                                        @if($resource->versions->count() > 1)
                                        <div class="alert alert-info p-2 mb-3" style="font-size: 13px;">
                                            <i class="fa fa-history"></i>
                                            <strong>{{ $resource->versions->count() }} versions</strong> available
                                            <a href="{{ route('resource.versionHistory', $resource->id) }}"
                                                class="text-decoration-none">
                                                View History →
                                            </a>
                                        </div>
                                        @endif

                                        {{-- QR Code Section --}}
                                        <div class="qr-section mt-3 p-3" style="background: #f9faff; border-radius: 8px;">
                                            @if($resource->qr_code_path)
                                            <div class="text-center">
                                                <p class="mb-2"><strong>QR Code:</strong></p>
                                                <img src="{{ asset('storage/' . $resource->qr_code_path) }}"
                                                    alt="QR Code"
                                                    class="img-fluid mb-2"
                                                    style="max-width: 150px; border: 2px solid #4986fc; border-radius: 8px; cursor: pointer;"
                                                    onclick="showQrModal('{{ asset('storage/' . $resource->qr_code_path) }}', '{{ addslashes($resource->title) }}')">
                                                <br>
                                                <small class="text-muted">Scan to access resource</small>
                                                <div class="mt-2">
                                                    <a href="{{ route('resource.downloadQr', $resource->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fa fa-download"></i> Download QR
                                                    </a>
                                                </div>
                                            </div>
                                            @else
                                            <div class="text-center">
                                                <p class="text-muted mb-2">No QR code yet</p>
                                                <a href="{{ route('resource.generateQr', $resource->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fa fa-qrcode"></i> Generate QR Code
                                                </a>
                                            </div>
                                            @endif
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/uploads/' . $resource->file_path) }}"
                                                target="_blank" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> View File
                                            </a>
                                            <a href="{{ route('resource.edit', $resource->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('resource.updateVersionForm', $resource->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-upload"></i> Update
                                            </a>
                                            @if($resource->versions->count() > 0)
                                            <a href="{{ route('resource.versionHistory', $resource->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-history"></i> Versions
                                            </a>
                                            @endif

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- QR Code Modal --}}
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
                <img id="qrModalImage" src="" alt="QR Code" class="img-fluid"
                    style="max-width: 300px; border: 3px solid #4986fc; border-radius: 10px;">
                <p class="text-muted mt-3">Scan this QR code with your mobile device to access the resource</p>
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
    function showQrModal(qrUrl, title) {
        document.getElementById('qrModalImage').src = qrUrl;
        document.getElementById('qrResourceTitle').textContent = title;
        const modal = new bootstrap.Modal(document.getElementById('qrModal'));
        modal.show();
    }
</script>

<script src="{{ asset('js/main.js') }}"></script>
@endsection