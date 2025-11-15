@extends('layouts.app')

@section('title', 'Edit Resource')

@section('content')
<div class="container mt-5">
    <h2>Edit Resource</h2>
    <form action="{{ route('resource.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $resource->title }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $resource->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="{{ $resource->category }}" required>
        </div>

        <div class="mb-3">
            <label>Year</label>
            <input type="text" name="year" class="form-control" value="{{ $resource->year }}" required>
        </div>

        <div class="mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" value="{{ $resource->subject }}" required>
        </div>

        <div class="mb-3">
            <label>File (leave empty if not changing)</label>
            <input type="file" name="file1" class="form-control">
            <small>Current File: <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" target="_blank">{{ $resource->file_path }}</a></small>
        </div>

        <button type="submit" class="btn btn-success">Update Resource</button>
        <a href="{{ route('manageResource') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
