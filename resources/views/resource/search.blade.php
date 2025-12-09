@extends('layouts.app')

@section('title', 'Smart Search & Filtering')

@section('content')
<div class="container py-5">

    <!-- Search Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-3 font-weight-bold">Smart Search</h4>

            <form method="GET" action="{{ route('resource.search') }}" id="searchForm">
                <div class="input-group">
                    <input 
                        id="searchInput" 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search courses, subjects, resources..."
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="font-weight-bold mb-3">Filter Results</h5>

            <form method="GET" action="{{ route('resource.search') }}" id="filterForm">
                <!-- Preserve search term -->
                <input type="hidden" name="search" value="{{ request('search') }}">

                <div class="row">

                    <!-- Course Category -->
                    <div class="col-md-4 mb-3">
                        <label>Course Category</label>
                        <select name="category" class="form-control" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Year -->
                    <div class="col-md-4 mb-3">
                        <label>Course Year</label>
                        <select name="year" class="form-control" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ request('year') === $yr ? 'selected' : '' }}>
                                    {{ $yr }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Name -->
                    <div class="col-md-4 mb-3">
                        <label>Subject / Course Name</label>
                        <select name="subject" class="form-control" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All</option>
                            @foreach($subjects as $subj)
                                <option value="{{ $subj }}" {{ request('subject') === $subj ? 'selected' : '' }}>
                                    {{ $subj }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="col-md-4 mb-3">
                        <label>Sort By</label>
                        <select name="sort" class="form-control" onchange="document.getElementById('filterForm').submit()">
                            <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>
                                Newest to Oldest
                            </option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                                Oldest to Newest
                            </option>
                        </select>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    @if($resources->count() > 0)
        <div class="row" id="resultsContainer">
            @foreach($resources as $resource)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $resource->title }}</h5>
                            
                            @if($resource->description)
                                <p class="card-text text-muted small">{{ Str::limit($resource->description, 80) }}</p>
                            @endif

                            <p class="mb-2">
                                <strong>Category:</strong> 
                                <span class="badge badge-info">{{ $resource->category }}</span>
                            </p>
                            <p class="mb-2">
                                <strong>Subject:</strong> 
                                <span class="badge badge-secondary">{{ $resource->subject }}</span>
                            </p>
                            <p class="mb-2">
                                <strong>Year:</strong> 
                                <span class="badge badge-warning">{{ $resource->year }}</span>
                            </p>
                            <p class="mb-3">
                                <small class="text-muted">
                                    Uploaded: {{ $resource->upload_date }}
                                </small>
                            </p>

                            <a href="{{ asset('storage/uploads/' . $resource->file_path) }}" 
                               class="btn btn-outline-primary btn-block btn-sm" 
                               target="_blank">
                                <i class="fa fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $resources->appends(request()->query())->links() }}
        </div>
    @else
        <!-- No Results Message -->
        <div id="noResults" class="text-center text-muted mt-5">
            <h5><i class="fa fa-info-circle"></i> No results found</h5>
            <p>Try adjusting your search or filter criteria.</p>
        </div>
    @endif

</div>

<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
    }
</style>

@endsection
