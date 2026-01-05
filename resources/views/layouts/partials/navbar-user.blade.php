<!-- ============================
      NAVBAR
============================== -->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light show" id="ftco-navbar">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <span>Study</span>Buddy
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
            <span class="oi oi-menu"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">

                @auth
                <!-- Home -->
                <li class="nav-item @if(Request::routeIs('dashboard')) active @endif">
                    <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
                </li>

                <!-- Courses -->
                <li class="nav-item @if(Request::routeIs('course')) active @endif">
                    <a href="{{ route('course') }}" class="nav-link">Courses</a>
                </li>

                <!-- Search Resources -->
                <li class="nav-item @if(Request::routeIs('resource.search')) active @endif">
                    <a href="{{ route('resource.search') }}" class="nav-link">Search Resources</a>
                </li>

                <!-- Upload Resources -->
                <li class="nav-item @if(Request::routeIs('uploadResource')) active @endif">
                    <a href="{{ route('uploadResource') }}" class="nav-link">Upload</a>
                </li>

                <!-- Manage Resource -->
                <li class="nav-item @if(Request::routeIs('manageResource')) active @endif">
                    <a href="{{ route('manageResource') }}" class="nav-link">Manage</a>
                </li>

                <!-- Premium Badge/Button -->
                <li class="nav-item">
                @auth
                    @if(Auth::user()->account_type === 'premium' && Auth::user()->premium_expires_at > now())
                    <!-- Premium User Badge -->
                    <span class="nav-link text-warning fw-bold">
                        <i class="fas fa-crown me-1"></i>PREMIUM
                    </span>
                    @else
                    <!-- Upgrade Button -->
                    <a href="{{ route('premium.plans') }}" class="nav-link text-warning fw-bold">
                        <i class="fas fa-rocket me-1"></i>Go Premium
                    </a>
                    @endif
                @endauth
                </li>

                <!-- Profile Picture Dropdown -->
                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                       id="profileDropdown" role="button" data-bs-toggle="dropdown">

                        <img src="{{ auth()->user()->profile_picture 
                            ? asset('uploads/profile_pictures/' . basename(auth()->user()->profile_picture)) . '?t=' . time ()
                            : asset('default/default-profile.png') }}"
                            class="rounded-circle"
                            style="width: 35px; height: 35px; object-fit: cover; border:2px solid #007bff;"
                        >
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item @if(Request::routeIs('account')) active @endif" 
                               href="{{ route('account') }}">Profile</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>

                @else
                <li class="nav-item @if(Request::routeIs('home')) active @endif">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/course" class="nav-link">Courses</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About</a>
                </li>
                <li class="nav-item @if(Request::routeIs('register')) active @endif">
                    <a href="/register" class="nav-link">Register</a>
                </li>
                <li class="nav-item @if(Request::routeIs('login')) active @endif">
                    <a href="/login" class="nav-link">Login</a>
                </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
