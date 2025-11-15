@extends('layouts.app')  <!-- links this page to app.blade.php -->

@section('title', 'Course Lists') 

@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('studylab/images/bg_2.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                        <span>Course Lists <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Course Lists</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-lg-3 sidebar">

                    <div class="sidebar-box bg-white ftco-animate">
                        <form class="search-form">
                            <div class="form-group">
                                <span class="icon fa fa-search"></span>
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                        </form>
                    </div>

                    <!-- Category -->
                    <div class="sidebar-box bg-white p-4 ftco-animate">
                        <h3 class="heading-sidebar">Course Category</h3>
                        <form>
                            <label><input type="checkbox" checked> Software Engineering</label><br>
                            <label><input type="checkbox"> Data Engineering</label><br>
                            <label><input type="checkbox"> Computer Network & Security</label><br>
                            <label><input type="checkbox"> Bioinformatics</label><br>
                            <label><input type="checkbox"> Graphic & Multimedia</label>
                        </form>
                    </div>

                    <!-- Year -->
                    <div class="sidebar-box bg-white p-4 ftco-animate">
                        <h3 class="heading-sidebar">Course Year</h3>
                        <form>
                            <label><input type="checkbox" checked> Year 1</label><br>
                            <label><input type="checkbox"> Year 2</label><br>
                            <label><input type="checkbox"> Year 3</label><br>
                            <label><input type="checkbox"> Year 4</label>
                        </form>
                    </div>

                    <!-- Course Name -->
                    <div class="sidebar-box bg-white p-4 ftco-animate">
                        <h3 class="heading-sidebar">Course Name</h3>
                        <form>
                            <label><input type="checkbox" checked> Discrete Structure</label><br>
                            <label><input type="checkbox"> Programming Technique</label><br>
                            <label><input type="checkbox"> Digital Logic</label><br>
                            <label><input type="checkbox"> Object-Oriented Programming</label>
                        </form>
                    </div>
                </div>

                <!-- Main: Course Cards -->
                <div class="col-lg-9">

                    <section class="ftco-section ftco-about img">
                        <div class="container">
                            <div class="row d-flex">
                                <div class="col-md-12 about-intro">
                                    <div class="row">

                                        <div class="col-md-6 d-flex">
                                            <div class="d-flex about-wrap">
                                                <div class="img d-flex align-items-center justify-content-center"
                                                     style="background-image:url('{{ asset('studylab/images/about-1.jpg') }}');"></div>

                                                <div class="img-2 d-flex align-items-center justify-content-center"
                                                     style="background-image:url('{{ asset('studylab/images/about.jpg') }}');"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 pl-md-5 py-5">
                                            <div class="heading-section ftco-animate">
                                                <h2 class="mb-4">Upload Your Resource and Share Knowledge</h2>
                                                <p>Beyond classroom walls, your notes and ideas can inspire others.</p>
                                                <p><a href="{{ url('/upload-resource') }}" class="btn btn-primary">Upload Resource</a></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Courses -->
                    <div class="row">
                        @foreach ([
                            ['image' => 'work-1.jpg', 'category' => 'Data', 'title' => 'Technology & Information System'],
                            ['image' => 'work-2.jpg', 'category' => 'Software', 'title' => 'Design for the Web with Adobe Photoshop'],
                            ['image' => 'work-3.jpg', 'category' => 'Bio', 'title' => 'Bioinformatics Concepts'],
                            ['image' => 'work-4.jpg', 'category' => 'Software', 'title' => 'Software Design Principles'],
                            ['image' => 'work-5.jpg', 'category' => 'Graphic', 'title' => 'Visual Design Fundamentals'],
                            ['image' => 'work-6.jpg', 'category' => 'Software', 'title' => 'Advanced Programming Concepts'],
                        ] as $course)
                            <div class="col-md-6 d-flex align-items-stretch ftco-animate">
                                <div class="project-wrap">
                                    <a href="#" class="img" style="background-image: url('{{ asset('studylab/images/' . $course['image']) }}');">
                                        <span class="price">{{ $course['category'] }}</span>
                                    </a>
                                    <div class="text p-4">
                                        <h3><a href="#">{{ $course['title'] }}</a></h3>
                                        <p class="advisor">Advisor <span>Tony Garret</span></p>
                                        <ul class="d-flex justify-content-between">
                                            <li><span class="flaticon-shower"></span>2300</li>
                                            <li class="price">$199</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-5">
                        <div class="col">
                            <div class="block-27">
                                <ul>
                                    <li><a href="#">&lt;</a></li>
                                    <li class="active"><span>1</span></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">&gt;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <footer class="ftco-footer ftco-no-pt ftco-section text-center">
        <h2 style="color:#004aad;">StudyBuddy</h2>
        <p>Your go-to platform for academic collaboration and resource sharing.</p>
    </footer>

@endsection