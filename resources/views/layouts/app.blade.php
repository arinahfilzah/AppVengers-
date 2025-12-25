<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyBuddy</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('studylab/css/font-awesome.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('studylab/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('studylab/css/style.css') }}">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom right, #f0f4ff, #e0f2ff);
        margin: 0;
    }

    /* Hero Section */
    .hero-wrap {
        position: relative;
        width: 100%;
        min-height: 100vh;
        height: 100vh;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-wrap .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .hero-content {
        position: relative;
        color: #fff;
        z-index: 2;
        text-align: left;
    }

    .hero-content h1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .hero-content p {
        font-size: 1.2rem;
    }

    /* Optional: ensure navbar links are visible */
    .ftco_navbar .navbar-nav .nav-item {
        display: block !important;
    }

    /* Navbar link colors for light blue background */
    .navbar-nav .nav-link {
        color: #0d3b66 !important; /* dark blue for contrast */
        font-weight: 500;
        transition: color 0.3s;
    }

    /* Active link */
    .navbar-nav .nav-item.active .nav-link {
        color: #007bff !important; /* blue highlight */
        font-weight: 600;
    }

    /* Hover effect for links */
    .navbar-nav .nav-link:hover {
        color: #007bff !important; /* blue on hover */
    }

    /* Brand text */
    .navbar-brand {
        color: #0d3b66 !important; /* dark blue for visibility */
        font-weight: 700;
    }

    /* Make main content have padding and spacing from hero */
    main {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    /* ONLY admin pages: adjust spacing below navbar */
    .admin-page main {
        padding-top: 100px;   /* change this value to what you need */
    }

    /* Remove bottom padding only for home page */
    .home-main {
        padding-bottom: 0;
    }

    /* Optional: sections like features/cards */
    section {
        position: relative;
        z-index: 1;
    }

    /* Home page hero full viewport */
    .home-hero {
        min-height: calc(100vh - 56px); /* full screen minus navbar height */
        display: flex;
        align-items: center;
    }

    .home-hero .container {
        height: 100%;
        display: flex;
        align-items: center;
    }

    /* Only for home page */
    .home-page .navbar {
        min-height: 80px; /* taller navbar */
        background-color: #f0f4ff !important; /* match hero background */
        box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* subtle shadow */
    }

    .home-page .navbar-brand {
        font-size: 1.8rem; /* bigger logo text */
        color: #0d3b66 !important; /* dark blue for visibility */
    }

    .home-page .navbar-nav .nav-link {
        font-size: 1.1rem; /* bigger menu links */
        padding: 0.8rem 1rem; /* more spacing around links */
        color: #0d3b66 !important; /* dark blue for contrast */
    }

    .home-page .navbar-nav .nav-item.active .nav-link,
    .home-page .navbar-nav .nav-link:hover {
        color: #007bff !important; /* highlight hover/active links */
    }

    .navbar-nav .dropdown-toggle img {
        width: 35px;
        height: 35px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

</head>
<body class="@if(Request::routeIs('home')) home-page @endif
            @if(auth()->check() && auth()->user()->role === 'admin') admin-page @endif">

<!-- ============================
      NAVBAR
============================== -->
@if(auth()->check() && auth()->user()->role === 'admin')
    @include('layouts.partials.navbar-admin')
@else
    @include('layouts.partials.navbar-user')
@endif

    <!-- MAIN CONTENT -->
    <main class="@if(Request::routeIs('home')) home-main @endif">
        @yield('content')
    </main>

    <!-- ============================
               FOOTER
    ============================== -->
    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container text-center">
            <p class="mb-0 text-light">
                © {{ date('Y') }} StudyBuddy — Designed with ❤️
            </p>
        </div>
    </footer>

    <!-- ============================
               JAVASCRIPT FILES
    ============================== -->
    <script src="{{ asset('studylab/js/jquery.min.js') }}"></script>
    <script src="{{ asset('studylab/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('studylab/js/popper.min.js') }}"></script>
    <!-- Bootstrap 5 Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('studylab/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('studylab/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('studylab/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('studylab/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('studylab/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('studylab/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('studylab/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('studylab/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('studylab/js/main.js') }}"></script>

    <!-- Dashboard tabs & modals initialization -->
    <script>
        var triggerTabList = [].slice.call(document.querySelectorAll('.nav-tabs a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        });

        var deleteModal = document.getElementById('deleteModal')
        if (deleteModal) {
            var modal = new bootstrap.Modal(deleteModal)
        }
    </script>

    @yield('scripts')
    @stack('scripts')

</body>
</html>
