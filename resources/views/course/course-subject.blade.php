@extends('layouts.app')

@section('title', 'Resources for ' . $subject)

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Resources for: {{ $subject }}</h2>

    @forelse($resources as $res)
        <div class="p-3 mb-3 border rounded">
            <h4>{{ $res->title }}</h4>
            <p>{{ $res->description }}</p>

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
            </div>
        </div>
    @empty
        <p>No resources available for this subject.</p>
    @endforelse

    {{ $resources->links() }}
</div>
@endsection
