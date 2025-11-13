<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyBuddy</title>

    <!-- Bootstrap CSS -->
    <link href="{{asset('studylab/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- StudyLab Template Styles (optional CDN if available) -->
    <link href="{{asset('studylab/css/style.css')}}" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                        url('{{ asset('studylab/images/bg_1.jpg') }}') center/cover no-repeat;
            color: white;
            padding: 100px 0;
        }
        .form-section {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .toggle-link {
            cursor: pointer;
            color: #0d6efd;
        }
        .toggle-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">StudyBuddy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navmenu" class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Courses</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="#register-form" class="nav-link">Register</a></li>
                    <li class="nav-item"><a href="#login-form" class="nav-link">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3 mt-5">
        <p class="mb-0">&copy; {{ date('Y') }} StudyBuddy | Designed with ❤️</p>
    </footer>

    <!-- JS -->
    <script src="{{ asset('studylab/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('studylab/js/main.js') }}"></script>

    @yield('scripts')
</body>
</html>
