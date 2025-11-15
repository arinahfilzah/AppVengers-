@extends('layouts.app')

@section('title', 'Upload Resource')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}"><span>Study</span>Buddy</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
            <span class="oi oi-menu"></span> Menu
        </button>

        
    </div>
</nav>

<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('studylab/images/softpurple.jpg') }}');">
    <div class="overlay"></div>
    <div class="container"></div>
</div>

<section class="ftco-section ftco-no-pb ftco-no-pt">
    <div class="container">
        <div class="row">

            <div class="col-md-7"></div>

            <div class="col-md-5 order-md-last">
                <div class="login-wrap p-4 p-md-5">
                    <h3 class="mb-4">Upload Your Resource</h3>

                   <form action="{{ route('uploadResource.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="file1">Upload File</label>
        <input type="file" class="form-control" name="file1" id="file1" required>
        @error('file1')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Resource Title</label>
        <input type="text" class="form-control" name="title" required>
        @error('title')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description"></textarea>
    </div>

    <div class="form-group">
        <label>Category</label>
        <select class="form-control" name="category">
            <option>Software Engineering</option>
            <option>Data Engineering</option>
            <option>Computer Network & Security</option>
            <option>Bioinformatic</option>
            <option>Graphic & Multimedia</option>
        </select>
    </div>

    <div class="form-group">
        <label>Year</label>
        <select class="form-control" name="year" required>
            <option>Year 1</option>
            <option>Year 2</option>
            <option>Year 3</option>
            <option>Year 4</option>
        </select>
    </div>

    <div class="form-group">
        <label>Subject</label>
        <select class="form-control" name="subject" required>
            <option>Discrete Structure</option>
            <option>Programming Technique I</option>
            <option>Technology & Information System</option>
            <option>Digital Logic</option>
            <option value="add_new">+ ADD NEW SUBJECT</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary submit">
        <span class="fa fa-upload"></span> Upload
    </button>
</form>

                    </form>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    @if(session('success'))
                    <script>
                    Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                    });
                    </script>
                    @endif


                </div>
            </div>

        </div>
    </div>
</section>

<footer class="ftco-footer ftco-no-pt">
    <div class="container">
        <div class="row mb-5">

            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2>About</h2>
                    <p>Far far away, behind the word mountains...</p>

                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                        <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                        <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                        <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                    </ul>

                </div>
            </div>

            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                    <h2>Help Desk</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Customer Care</a></li>
                        <li><a href="#" class="py-2 d-block">Legal Help</a></li>
                        <li><a href="#" class="py-2 d-block">Services</a></li>
                        <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
                        <li><a href="#" class="py-2 d-block">Refund Policy</a></li>
                        <li><a href="#" class="py-2 d-block">Call Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2>Recent Courses</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Computer Engineering</a></li>
                        <li><a href="#" class="py-2 d-block">Web Design</a></li>
                        <li><a href="#" class="py-2 d-block">Business Studies</a></li>
                        <li><a href="#" class="py-2 d-block">Civil Engineering</a></li>
                        <li><a href="#" class="py-2 d-block">Computer Technician</a></li>
                        <li><a href="#" class="py-2 d-block">Web Developer</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2>Have a Question?</h2>
                    <ul>
                        <li><span class="fa fa-map-marker"></span> 203 Fake St., San Francisco</li>
                        <li><span class="fa fa-phone"></span> +2 392 3929 210</li>
                        <li><span class="fa fa-paper-plane"></span> info@yourdomain.com</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <p>
                    Copyright &copy;
                    <script>document.write(new Date().getFullYear());</script> All rights reserved
                </p>
            </div>
        </div>

    </div>
</footer>

<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" />
    </svg>
</div>


@endsection