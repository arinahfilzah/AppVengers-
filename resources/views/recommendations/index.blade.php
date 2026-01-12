@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-3 mt-4">
        🤖 AI Resource Recommendations
    </h3>

    <form method="GET" action="{{ route('recommendations.index') }}" class="mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Filter by Subject</label>
            <select name="subject" class="form-select">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject }}"
                        {{ request('subject') == $subject ? 'selected' : '' }}>
                        {{ $subject }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                Filter
            </button>
        </div>
    </div>
</form>


    @if($recommendations->isEmpty())
        <div class="alert alert-warning">
            No recommendations available yet. Start exploring resources to get better suggestions!
        </div>
    @else
        <div class="row">
            @foreach($recommendations as $resource)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $resource->title }}
                            </h5>

                            <span class="badge bg-primary mb-2">
                                {{ $resource->subject }}
                            </span>

                            <p class="card-text text-muted small">
                                {{ \Illuminate\Support\Str::limit($resource->description, 100) }}
                            </p>

                            {{-- AI Explanation --}}
                            @if(auth()->user()->isPremium())
                                <p class="text-success small">
                                    ✨ Recommended because you studied
                                    <strong>{{ $resource->subject }}</strong>
                                </p>
                            @else
                                <p class="text-secondary small">
                                    🔍 Popular among StudyBuddy users
                                </p>
                            @endif
                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            <small class="text-muted">
                                ⬇ {{ $resource->download_count }} downloads
                            </small>

                            {{-- Use correct route name --}}
                            <a href="{{ route('resource.download', $resource->id) }}"
                               class="btn btn-sm btn-outline-primary">
                               Download
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Premium Upsell --}}
        @if(!auth()->user()->isPremium())
            <div class="alert alert-info mt-4 text-center">
                🔓 Want personalized AI recommendations?
                <a href="{{ route('premium.plans') }}" class="fw-bold">
                    Upgrade to Premium
                </a>
            </div>
        @endif
    @endif
</div>
@endsection
