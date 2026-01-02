@extends('layouts.app')

@section('title', 'Resources for ' . $subject)

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Resources for: {{ $subject }}</h2>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @forelse($resources as $res)
        <div class="p-3 mb-3 border rounded">
            <h4>{{ $res->title }}</h4>
            <p>{{ $res->description }}</p>
            <p class="text-muted">
                <small>
                    <i class="fa fa-user"></i> Uploaded by: {{ $res->uploader->name ?? 'Unknown' }}
                    | <i class="fa fa-calendar"></i> {{ $res->upload_date->format('M d, Y') }}
                </small>
            </p>

            {{-- Action Buttons --}}
            <div class="mt-2">
                {{-- View file in new tab --}}
                <a href="{{ asset('storage/uploads/' . $res->file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye"></i> View
                </a>

                {{-- Download file --}}
                <a href="{{ route('resource.download', $res->id) }}" class="btn btn-success btn-sm">
                    <i class="fa fa-download"></i> Download
                </a>

                {{-- Request Collaboration Button (AF1 handled in controller) --}}
                @if($res->uploader_id !== auth()->id())
                    <form action="{{ route('collaboration.request', $res->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fa fa-handshake-o"></i> Request Collaboration
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>No resources available for this subject.</p>
    @endforelse

    {{ $resources->links() }}
</div>
@endsection