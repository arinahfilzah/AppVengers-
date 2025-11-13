<!DOCTYPE html>
<html lang="en">
<head>
    <title>StudyLab - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
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
     <div class="hero-wrap js-fullheight" style="background-image: url('images/bg_1.jpg');">
  <div class="overlay"></div>
  <div class="container">
    
</div>
</div>
    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5 order-md-last">
                    <div class="login-wrap p-4 p-md-5">
                        <h3 class="mb-4">Upload Your Resource</h3>
                        <form action="#" class="upload-form">
                            <div class="form-group">
                                <label class="label" for="file">Upload File</label>
                                <input type="file" class="form-control" id="file" accept=".pdf,.docx,.pptx,.zip" required>
                            </div>
                            <div class="form-group">
                                <label class="label" for="title">Resource Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Enter resource title" required>
                            </div>
                            <div class="form-group">
                                <label class="label" for="description">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter resource description"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="label" for="category">Select Category</label>
                                <select class="form-control" id="category">
                                    <option>Software Engineering</option>
                                    <option>Data Engineering</option>
                                    <option>Computer Network & Security </option>
                                    <option>Bioinformatic</option>
                                    <option>Graphic & Multimedia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label" for="year">Select Year</label>
                                <select class="form-control" id="category">
                                    <option>Year 1</option>
                                    <option>Year 2</option>
                                    <option>Year 3</option>
                                    <option>Year 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label" for="subject">Select Subject</label>
                                <select class="form-control" id="category">
                                    <option>Discrete Structure</option>
                                    <option>Programming Technique i</option>
                                    <option>Technology & Information System</option>
                                    <option>Digital Logic</option>
                                    <option value="add_new">+ ADD NEW SUBJECT</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label" for="file">Upload File</label>
                                <input type="file" class="form-control" id="file" accept=".pdf,.docx,.pptx,.zip" required>
                            </div>
                        </form>

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
                    <h2 class="ftco-heading-2">About</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                        <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                    <h2 class="ftco-heading-2">Help Desk</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Customer Care</a></li>
                        <li><a href="#" class="py-2 d-block">Legal Help</a></li>
                        <li><a href="#" class="py-2 d-block">Services</a></li>
                        <li><a href="#" class="py-2 d-block">Privacy and Policy</a></li>
                        <li><a href="#" class="py-2 d-block">Refund Policy</a></li>
                        <li><a href="#" class="py-2 d-block">Call Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md pt-5">
                <div class="ftco-footer-widget pt-md-5 mb-4">
                    <h2 class="ftco-heading-2">Recent Courses</h2>
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
                    <h2 class="ftco-heading-2">Have a Questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon fa fa-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                            <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                            <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">info@yourdomain.com</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
            </div>
        </footer>
        
        
        
        <!-- loader -->
        <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-migrate-3.0.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.stellar.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/jquery.animateNumber.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/scrollax.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
        <script src="js/google-map.js"></script>
        <script src="js/main.js"></script>
</body>
</html>