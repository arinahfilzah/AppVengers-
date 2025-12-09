@extends('layouts.app')

@section('title', $resource->title)

@section('content')

<section class="page-header">
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <h1 class="mb-0 bread">Resource Details</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg" style="border-radius: 15px; border: none;">
                    <div class="card-body p-5">
                        
                        {{-- Resource Icon --}}
                        <div class="text-center mb-4">
                            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #ce4be8 0%, #207ce5 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fa fa-file-alt" style="font-size: 50px; color: white;"></i>
                            </div>
                        </div>

                        {{-- Resource Title --}}
                        <h2 class="text-center mb-4" style="color: #4986fc; font-weight: 600;">{{ $resource->title }}</h2>

                        {{-- Resource Details --}}
                        <div class="resource-details mb-4">
                            <div class="detail-item mb-3 p-3" style="background: #f9faff; border-radius: 8px; border-left: 4px solid #4986fc;">
                                <strong style="color: #4986fc;"><i class="fa fa-folder"></i> Category:</strong>
                                <span class="ms-2">{{ $resource->category }}</span>
                            </div>

                            <div class="detail-item mb-3 p-3" style="background: #f9faff; border-radius: 8px; border-left: 4px solid #4986fc;">
                                <strong style="color: #4986fc;"><i class="fa fa-calendar"></i> Year:</strong>
                                <span class="ms-2">{{ $resource->year }}</span>
                            </div>

                            <div class="detail-item mb-3 p-3" style="background: #f9faff; border-radius: 8px; border-left: 4px solid #4986fc;">
                                <strong style="color: #4986fc;"><i class="fa fa-book"></i> Subject:</strong>
                                <span class="ms-2">{{ $resource->subject }}</span>
                            </div>

                            @if($resource->description)
                            <div class="detail-item mb-3 p-3" style="background: #f9faff; border-radius: 8px; border-left: 4px solid #4986fc;">
                                <strong style="color: #4986fc;"><i class="fa fa-info-circle"></i> Description:</strong>
                                <p class="mt-2 mb-0">{{ $resource->description }}</p>
                            </div>
                            @endif

                            <div class="detail-item mb-3 p-3" style="background: #f9faff; border-radius: 8px; border-left: 4px solid #4986fc;">
                                <strong style="color: #4986fc;"><i class="fa fa-clock"></i> Uploaded:</strong>
                                <span class="ms-2">{{ $resource->upload_date->format('M d, Y') }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-3">
                            <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" 
                               target="_blank" 
                               class="btn btn-primary btn-lg"
                               style="background: linear-gradient(135deg, #ce4be8 0%, #207ce5 100%); border: none;">
                                <i class="fa fa-eye"></i> View File
                            </a>

                            <a href="{{ route('resource.download', $resource->id) }}" 
                               class="btn btn-success btn-lg">
                                <i class="fa fa-download"></i> Download File
                            </a>
                        </div>

                        {{-- Info Message --}}
                        <div class="alert alert-info mt-4" role="alert" style="border-radius: 8px;">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Note:</strong> If the file doesn't open on your device, please try downloading it instead.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection