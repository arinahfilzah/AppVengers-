@extends('layouts.app')

@section('content')

{{-- Success Message --}}
@if(session('success'))
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<!-- Hero Section -->
<section class="hero-wrap home-hero d-flex align-items-center justify-content-center">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
            <!-- Left Text -->
            <div class="col-lg-6 py-5">
                <div class="inline-block px-3 py-1 bg-primary-light text-primary rounded-full text-sm mb-2">
                    🎓 Your Academic Success Partner
                </div>
                <h1 class="mb-4">Empowering Learning Through <span class="text-primary">Smart Collaboration</span></h1>
                <p class="mb-4">
                    StudyBuddy helps university students develop strong learning habits, improve collaboration, 
                    and gain access to helpful tools designed to support academic success.
                </p>

                <a href="/register" class="btn btn-primary px-4 py-2 me-2">Get Started</a>
                <a href="/login" class="btn btn-outline-primary px-4 py-2">Login</a>
            </div>

            <!-- Hero Image -->
            <div class="col-lg-6 d-flex justify-content-center">
                <img src="{{ asset('studylab/images/about-1.jpg') }}" alt="Landing image" class="img-fluid" style="max-width: 80%;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="ftco-section bg-white py-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Why StudyBuddy?</h2>
                <p>Designed to make learning easier, smarter, and more connected.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-4">
                <div class="p-4 bg-white shadow rounded text-center">
                    <h4 class="mb-3">Lecture Notes</h4>
                    <p>
                        Access organized lecture materials, slides, and recordings from all your courses.
                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="col-md-4">
                <div class="p-4 bg-white shadow rounded text-center">
                    <h4 class="mb-3">Past Papers</h4>
                    <p>
                        Browse an extensive collection of previous exam papers with solutions and marking schemes.
                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="col-md-4">
                <div class="p-4 bg-white shadow rounded text-center">
                    <h4 class="mb-3">Study Guides</h4>
                    <p>
                        Download comprehensive revision guides and summaries created by top students.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
