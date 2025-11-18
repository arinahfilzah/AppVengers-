@extends('layouts.app')

@section('title', 'Upload Resource')

@section('content')

    <div class="overlay"></div>
    <div class="container text-center">
        <h1 class="mt-5 text-dark purple">Manage Uploaded Resources</h1>
    </div>


<section class="ftco-section bg-light">
    <div class="container">

        {{-- SUCCESS MESSAGE (after upload/update) --}}
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
                {{-- Optional image preview --}}
                {{-- <img src="{{ asset('storage/uploads/' . $resource->file_path) }}" class="card-img-top" alt="Resource Image"> --}}
                
                <div class="card-body">
                    <h5 class="card-title">{{ $resource->title }}</h5>
                    <p class="card-text">{{ $resource->description }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $resource->category }}</p>
                    <p class="card-text"><strong>Year:</strong> {{ $resource->year }}</p>
                    <p class="card-text"><strong>Subject:</strong> {{ $resource->subject }}</p>

                    <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" target="_blank" class="btn btn-primary btn-sm">View File</a>
                    <a href="{{ route('resource.edit', $resource->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

    </div>
</section>



<script src="{{ asset('js/main.js') }}"></script>
@endsection
