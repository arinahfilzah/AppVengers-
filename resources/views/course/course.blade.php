@extends('layouts.app')

@section('title', 'Subject Repository')

@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('studylab/images/bg_2.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/dashboard') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span>Subject Repository <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Browse Subject Repository</h1>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-3">

    <!-- Search -->
    <div class="sidebar-box bg-white p-4 ftco-animate">
        <h3 class="heading-sidebar">Search</h3>
        <form action="{{ route('course') }}" method="GET">
            <input type="text"
                   name="search"
                   class="form-control mb-2"
                   value="{{ request('search') }}"
                   placeholder="Search subject...">

            <!-- Keep other filters when searching -->
            @foreach(request('category', []) as $cat)
                <input type="hidden" name="category[]" value="{{ $cat }}">
            @endforeach
            <input type="hidden" name="year" value="{{ request('year') }}">
            <input type="hidden" name="subject" value="{{ request('subject') }}">
        </form>
    </div>


    <!-- Category Filter -->
    <div class="sidebar-box bg-white p-4 ftco-animate">
        <h3 class="heading-sidebar">Course Category</h3>
        <form action="{{ route('course') }}" method="GET" id="categoryForm">

            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="year" value="{{ request('year') }}">
            <input type="hidden" name="subject" value="{{ request('subject') }}">

            @foreach($categories as $cat)
                <label class="d-block">
                    <input type="checkbox"
                           name="category[]"
                           value="{{ $cat }}"
                           onchange="this.form.submit()"
                           {{ in_array($cat, request('category', [])) ? 'checked' : '' }}>
                    {{ $cat }}
                </label>
            @endforeach

        </form>
    </div>


    <!-- Year Filter -->
    <div class="sidebar-box bg-white p-4 ftco-animate">
        <h3 class="heading-sidebar">Course Year</h3>
        <form action="{{ route('course') }}" method="GET" id="yearForm">

            <input type="hidden" name="search" value="{{ request('search') }}">
            @foreach(request('category', []) as $cat)
                <input type="hidden" name="category[]" value="{{ $cat }}">
            @endforeach
            <input type="hidden" name="subject" value="{{ request('subject') }}">

            @foreach(['Year 1','Year 2','Year 3','Year 4'] as $y)
                <label class="d-block">
                    <input type="radio"
                           name="year"
                           value="{{ $y }}"
                           onchange="this.form.submit()"
                           {{ request('year') == $y ? 'checked' : '' }}>
                    {{ $y }}
                </label>
            @endforeach

            <label class="d-block">
                <input type="radio"
                       name="year"
                       value=""
                       onchange="this.form.submit()"
                       {{ !request('year') ? 'checked' : '' }}>
                All Years
            </label>

        </form>
    </div>


    <!-- Subject List -->
    <div class="sidebar-box bg-white p-4 ftco-animate">
        <h3 class="heading-sidebar">Subject</h3>
        <form action="{{ route('course') }}" method="GET" id="subjectFilterForm">

            <input type="hidden" name="search" value="{{ request('search') }}">
            @foreach(request('category', []) as $cat)
                <input type="hidden" name="category[]" value="{{ $cat }}">
            @endforeach
            <input type="hidden" name="year" value="{{ request('year') }}">

            @foreach($subjectList as $sub)
                <label class="d-block">
                    <input type="radio"
                           name="subject"
                           value="{{ $sub }}"
                           onchange="this.form.submit()"
                           {{ request('subject') == $sub ? 'checked' : '' }}>
                    {{ $sub }}
                </label>
            @endforeach

        </form>
    </div>


    <!-- Clear Filters -->
    @if(request('search') || request('category') || request('year') || request('subject'))
        <div class="sidebar-box bg-white p-4 ftco-animate">
            <a href="{{ route('course') }}" class="btn btn-secondary btn-block">
                <i class="fa fa-times"></i> Clear All Filters
            </a>
        </div>
    @endif

</div>


            <!-- Main: Subject List -->
            <div class="col-lg-9">

                <!-- Results Info -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <strong>{{ $subjects->count() }} Subject(s) Found</strong>
                            @if(request('search'))
                                <span> - Search: "{{ request('search') }}"</span>
                            @endif
                            @if(request('category'))
                                <span> - Categories: {{ implode(', ', request('category')) }}</span>
                            @endif
                            @if(request('year'))
                                <span> - Year: {{ request('year') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Subject Cards -->
                @if($subjects->isEmpty())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning text-center p-5">
                                <i class="fa fa-info-circle fa-3x mb-3" style="color: #ffc107;"></i>
                                <h4>No subjects found</h4>
                                <p>Try adjusting your search filters or check back later for new content.</p>
                                <a href="{{ route('course') }}" class="btn btn-primary mt-3">View All Subjects</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach($subjects as $subject)
                            <div class="col-md-6 d-flex align-items-stretch ftco-animate">
                                <div class="project-wrap w-100 mb-4">
                                    <a href="{{ route('subject.resources', ['subject' => urlencode($subject->subject)]) }}" 
                                       class="img d-flex align-items-center justify-content-center"
                                       style="background: linear-gradient(135deg, #ce4be8 0%, #207ce5 100%); height: 200px;">
                                        <div class="text-center">
                                            <i class="fa fa-book fa-3x mb-2" style="color: white;"></i>
                                            <h4 class="text-white">{{ $subject->subject }}</h4>
                                        </div>
                                    </a>
                                    <div class="text p-4">
                                        <h3>
                                            <a href="{{ route('subject.resources', ['subject' => urlencode($subject->subject)]) }}">
                                                {{ $subject->subject }}
                                            </a>
                                        </h3>
                                        <p class="advisor">
                                            <span class="badge badge-primary">{{ $subject->category }}</span>
                                            <span class="badge badge-secondary">{{ $subject->year }}</span>
                                        </p>
                                        <ul class="d-flex justify-content-between align-items-center">
                                            <li>
                                                <span class="fa fa-file"></span> 
                                                {{ $subject->resource_count }} Resource(s)
                                            </li>
                                            <li>
                                                <a href="{{ route('subject.resources', ['subject' => urlencode($subject->subject)]) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    View Resources <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($subjects->hasPages())
                        <div class="row mt-5">
                            <div class="col">
                                <div class="block-27">
                                    <ul>
                                        @if($subjects->onFirstPage())
                                            <li class="disabled"><span>&lt;</span></li>
                                        @else
                                            <li><a href="{{ $subjects->previousPageUrl() }}">&lt;</a></li>
                                        @endif

                                        @foreach($subjects->getUrlRange(1, $subjects->lastPage()) as $page => $url)
                                            @if($page == $subjects->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        @if($subjects->hasMorePages())
                                            <li><a href="{{ $subjects->nextPageUrl() }}">&gt;</a></li>
                                        @else
                                            <li class="disabled"><span>&gt;</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection