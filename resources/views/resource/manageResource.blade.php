@extends('layouts.app')

@section('title', 'Manage Resources')

@section('content')

<section class="page-header">
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <h1 class="mb-0 bread">Manage Uploaded Resources</h1>
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

        {{-- NO RESOURCE POPUP --}}
        @if($resources->isEmpty())
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'No Resources Found',
                    text: 'You have not uploaded any resources yet.'
                });
            </script>

            <div class="text-center mt-5">
                <a href="{{ route('uploadResource') }}" class="btn btn-primary">
                    Upload Your First Resource
                </a>
            </div>
        @else
            <div class="row">
                @foreach($resources as $resource)
                <div class="col-md-4 mb-4 ftco-animate">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $resource->title }}</h5>
                            <p class="card-text">{{ $resource->description }}</p>
                            <p class="card-text"><strong>Category:</strong> {{ $resource->category }}</p>
                            <p class="card-text"><strong>Year:</strong> {{ $resource->year }}</p>
                            <p class="card-text"><strong>Subject:</strong> {{ $resource->subject }}</p>

                            {{-- QR Code Section --}}
                            <div class="qr-section mt-3 p-3" style="background: #f9faff; border-radius: 8px;">
                                @if($resource->qr_code_path)
                                    <div class="text-center">
                                        <p class="mb-2"><strong>QR Code:</strong></p>
                                        <img src="{{ asset('storage/' . $resource->qr_code_path) }}" 
                                             alt="QR Code" 
                                             class="img-fluid mb-2" 
                                             style="max-width: 150px; border: 2px solid #4986fc; border-radius: 8px; cursor: pointer;"
                                             onclick="showQrModal('{{ asset('storage/' . $resource->qr_code_path) }}', '{{ $resource->title }}')">
                                        <br>
                                        <small class="text-muted">Scan to access resource</small>
                                        <div class="mt-2">
                                            <a href="{{ route('resource.downloadQr', $resource->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa fa-download"></i> Download QR
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p class="text-muted mb-2">No QR code yet</p>
                                        <a href="{{ route('resource.generateQr', $resource->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-qrcode"></i> Generate QR Code
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-3">
                                <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i> View File
                                </a>
                                <a href="{{ route('resource.edit', $resource->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

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
                <img id="qrModalImage" src="" alt="QR Code" class="img-fluid" style="max-width: 300px; border: 3px solid #4986fc; border-radius: 10px;">
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