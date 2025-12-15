<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - StudyBuddy Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: #e9ecef !important;
        }
        
        .login-wrap {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        
        .login-wrap:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            text-align: center;
            padding: 25px 15px;
        }
        
        .stat-card h3 {
            color: #667eea;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stat-card h6 {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .ftco_navbar .nav-link {
    color: #0d3b66 !important;
    font-weight: 500;
    padding: 0.7rem 1rem;
}

.ftco_navbar .nav-link:hover,
.ftco_navbar .nav-item.active .nav-link {
    color: #007bff !important;
    font-weight: 600;
}

.navbar-brand span {
    color: #007bff;
}

    </style>
</head>
<body>
    <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light show" id="ftco-navbar">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}"
           style="color:#0d3b66;">
            <span>StudyBuddy</span>

        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Dashboard -->
                <li class="nav-item @if(Request::routeIs('admin.dashboard')) active @endif">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <!-- Contributors -->
                <li class="nav-item @if(Request::routeIs('admin.contributor-activities')) active @endif">
                    <a class="nav-link" href="{{ route('admin.contributor-activities') }}">
                        Contributors
                    </a>
                </li>

                <!-- Verification -->
                <li class="nav-item @if(Request::routeIs('admin.verification')) active @endif">
                    <a class="nav-link" href="{{ route('admin.verification') }}">
                        Verification
                    </a>
                </li>

                 <!-- Reviews -->
                <li class="nav-item @if(Request::routeIs('admin.reviews')) active @endif">
                    <a class="nav-link" href="{{ route('admin.reviews') }}">
                        Reviews
                    </a>
                </li>

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                       href="#" role="button" data-bs-toggle="dropdown">

                        <img src="{{ auth()->user()->profile_picture
                            ? asset('uploads/profile_pictures/' . basename(auth()->user()->profile_picture))
                            : asset('default/default-profile.png') }}"
                            style="width:35px;height:35px;object-fit:cover;
                                   border-radius:50%;border:2px solid #007bff;">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text fw-semibold">
                                {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="#">
                                Profile
                            </a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>


    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Simple dashboard updates
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin dashboard loaded successfully');
        });
    </script>
    
    @stack('scripts')
</body>
</html>