<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light show" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <span>Study</span>Buddy <small class="text-primary">Admin</small>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item @if(Request::routeIs('admin.dashboard')) active @endif">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                </li>

                <li class="nav-item @if(Request::routeIs('admin.contributor-activities')) active @endif">
                    <a href="{{ route('admin.contributor-activities') }}" class="nav-link">Contributors</a>
                </li>

                <li class="nav-item dropdown @if(Request::routeIs('admin.viewUsers') || Request::routeIs('admin.editUser')) active @endif">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        User Management
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.viewUsers') }}">View Users</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if(Request::routeIs('admin.verification')) active @endif">
                    <a href="{{ route('admin.verification') }}" class="nav-link">Verification</a>
                </li>

                <li class="nav-item @if(Request::routeIs('admin.reviews')) active @endif">
                    <a href="{{ route('admin.reviews') }}" class="nav-link">Reviews</a>
                </li>

                <!-- Subject Reports -->
                <li class="nav-item @if(Request::routeIs('admin.analytics.subjectreport')) active @endif">
                    <a href="{{ route('admin.analytics.subjectreport') }}" class="nav-link">
                        <i class="fa fa-chart-bar me-1"></i> Subject Reports
                    </a>
                </li>

                <!-- Resource Analytics -->
                <li class="nav-item @if(Request::routeIs('admin.analytics.performance')) active @endif">
                    <a href="{{ route('admin.analytics.performance') }}" class="nav-link">
                        <i class="fa fa-tachometer-alt me-1"></i> Resource Analytics
                    </a>
                </li>

                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->profile_picture
                            ? asset(auth()->user()->profile_picture)
                            : asset('default/default-profile.png') }}">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('account') }}">Profile</a>
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

            </ul>
        </div>
    </div>
</nav>
