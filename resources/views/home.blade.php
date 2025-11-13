<!DOCTYPE html>
<html lang="en">
<head>
    <title>StudyBuddy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('studylab/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/style.css') }}">

    <style>
        /* Hero section form styling */
        .form-floating-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 2rem;
            margin-top: 70px; /* space from navbar */
            transition: margin-top 0.3s ease;
        }

        /* Adjust margins for responsiveness */
        @media (max-width: 992px) {
            .form-floating-box {
                margin-top: 100px;
            }
        }

        @media (max-width: 576px) {
            .form-floating-box {
                margin-top: 120px;
            }
        }

        /* Optional: reduce form width on small screens */
        @media (max-width: 768px) {
            .form-floating-box {
                width: 90%;
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* Make login/register link visible */
        .text-center {
            color: #004aad;
            font-weight: 500;
        }

        .text-center a {
            color: #007bff;
            font-weight: 600;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}"><span>Study</span>Buddy</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ url('uploadResource') }}" class="nav-link">Upload Resource</a></li>
                <li class="nav-item"><a href="{{ url('course') }}" class="nav-link">Course</a></li>
                <li class="nav-item"><a href="{{ url('search') }}" class="nav-link">Search</a></li>
                <li class="nav-item"><a href="{{ url('about') }}" class="nav-link">About</a></li>
                <li class="nav-item"><a href="{{ url('contact') }}" class="nav-link">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->

<!-- Hero Section with Registration/Login Form Side-by-Side -->
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('studylab/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
            <!-- Hero Text -->
            <div class="col-md-7 ftco-animate">
                <span class="subheading">Welcome to StudyBuddy</span>
                <h1 class="mb-4">Your digital study companion for sharing, learning, and growing.</h1>
                <p class="caps">Upload study notes, discover new resources, and collaborate with peers effortlessly.</p>
                <p class="mb-0">
                    <a href="#" class="btn btn-primary">Explore Resources</a>
                    <a href="#" class="btn btn-white">Learn More</a>
                </p>
            </div>

            <!-- Registration/Login Form -->
            <div class="col-md-5">
                <div class="form-floating-box">
                    <!-- Register Form -->
                    <div id="register-form">
                        <h3 class="mb-4 text-center">Register for StudyBuddy</h3>
                        <form action="#" class="signup-form">
                            <div class="form-group">
                                <label class="label" for="name">Full Name</label>
                                <input type="text" class="form-control" placeholder="John Doe">
                            </div>
                            <div class="form-group">
                                <label class="label" for="email">Email Address</label>
                                <input type="text" class="form-control" placeholder="johndoe@gmail.com">
                            </div>
                            <div class="form-group">
                                <label class="label" for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label class="label" for="password">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="form-group d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary submit">
                                    <span class="fa fa-paper-plane"></span> Register
                                </button>
                            </div>
                        </form>
                            <p class="text-center mt-3" style="color:#004aad; font-weight: 600;">
                            Already have an account? <a href="#" id="show-login" style="color:#007bff; font-weight:600;">Sign In</a>
                            </p>
                    </div>

                    <!-- Login Form -->
                    <div id="login-form" style="display:none;">
                        <h3 class="mb-4 text-center">Sign In to StudyBuddy</h3>
                        <form action="#" class="signin-form">
                            <div class="form-group">
                                <label class="label" for="email">Email Address</label>
                                <input type="text" class="form-control" placeholder="johndoe@gmail.com">
                            </div>
                            <div class="form-group">
                                <label class="label" for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary submit">
                                    <span class="fa fa-sign-in"></span> Login
                                </button>
                            </div>
                        </form>
                        <p class="text-center mt-3" style="color:#004aad; font-weight: 600;">
                            Don't have an account? <a href="#" id="show-register" style="color:#007bff; font-weight:600;">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Full-width Join Community Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 ftco-animate text-center mb-5">
                <span class="subheading">Join our StudyBuddy Community</span>
                <h2 class="mb-4">Collaborate, Share & Achieve Together</h2>
                <p>Join a growing network of learners. Share your knowledge, exchange resources, and grow together through StudyBuddy.</p>
                <a href="#" class="btn btn-primary">Join Now</a>
            </div>
        </div>
    </div>
</section>

<footer class="ftco-footer ftco-no-pt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center mb-4">
                <h2 class="ftco-heading-2" style="margin-bottom:10px; color:#004aad;">StudyBuddy</h2>
                <p style="color:#555;">Your go-to platform for academic collaboration and resource sharing.</p>
            </div>
        </div>
    </div>
</footer>

<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
    </svg>
</div>

<script src="{{ asset('studylab/js/jquery.min.js') }}"></script>
<script src="{{ asset('studylab/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('studylab/js/popper.min.js') }}"></script>
<script src="{{ asset('studylab/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('studylab/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('studylab/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('studylab/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('studylab/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('studylab/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('studylab/js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('studylab/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('studylab/js/scrollax.min.js') }}"></script>
<script src="{{ asset('studylab/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#show-login').click(function (e) {
            e.preventDefault();
            $('#register-form').hide();
            $('#login-form').show();
        });
        $('#show-register').click(function (e) {
            e.preventDefault();
            $('#login-form').hide();
            $('#register-form').show();
        });
    });
</script>

</body>
</html>
