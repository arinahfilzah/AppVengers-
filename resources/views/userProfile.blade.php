@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="fw-semibold" style="font-size: 30px;">User Dashboard</h1>
            <p class="text-muted mb-0">Manage your account settings</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-secondary">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link @if(!session('active_tab') || session('active_tab')=='profile') active @endif"
               data-bs-toggle="tab" href="#profileTab">
                <i class="bi bi-person me-1"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('active_tab')=='settings') active @endif"
               data-bs-toggle="tab" href="#settingsTab">
                <i class="bi bi-gear me-1"></i> Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('active_tab')=='loginHistory') active @endif"
               data-bs-toggle="tab" href="#loginHistoryTab">
                <i class="bi bi-clock-history me-1"></i> Login Activity
            </a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- Profile Tab --}}
        <div class="tab-pane fade @if(!session('active_tab') || session('active_tab')=='profile') show active @endif"
             id="profileTab">

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Profile Information</h5>
                </div>

                <div class="card-body">

                    {{-- Profile Success --}}
                    @if(session('profile_success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            {{ session('profile_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{--Profile Validation Errors --}}
                    @if($errors->hasBag('profile') && $errors->profile->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->profile->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.update-profile') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="text-muted small">Full Name</label>
                                <input class="form-control" name="name" value="{{ auth()->user()->name }}">
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Email</label>
                                <input class="form-control" name="email" value="{{ auth()->user()->email }}">
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Phone Number</label>
                                <input class="form-control" name="phone_number" value="{{ auth()->user()->phone_number }}">
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Profile Picture</label>
                                <input type="file" class="form-control" name="profile_picture" id="profileInput">

                                <img id="previewImage"
                                     src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('default-avatar.png') }}"
                                     class="mt-2 rounded-circle"
                                     style="width:120px; height:120px; object-fit:cover;">
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Role</label>
                                <input class="form-control" value="{{ auth()->user()->role }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Last Login</label>
                                <input class="form-control"
                                        value="{{ auth()->user()->last_login ? \Carbon\Carbon::parse(auth()->user()->last_login)->format('d M Y H:i') : 'N/A' }}"
                                        readonly>
                            </div>

                        </div>

                        <button class="btn btn-primary mt-3">Save Changes</button>
                    </form>

                </div>
            </div>

        </div> <!-- End Profile Tab -->

        {{-- Settings Tab --}}
        <div class="tab-pane fade @if(session('active_tab')=='settings') show active @endif" id="settingsTab">

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Change Password</h5>
                </div>

                <div class="card-body">

                    {{-- Password Success --}}
                    @if(session('password_success'))
                        <div class="alert alert-success bm-3">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('password_success') }}
                        </div>
                    @endif

                    {{-- Password Validation Errors --}}
                    @if($errors->hasBag('password') && $errors->password->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->password->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.update-password') }}">
                        @csrf
                        <input type="hidden" name="tab" value="settingsTab">

                        <div class="mb-3">
                            <label class="form-label">New Password *</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password *</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Update Password</button>
                    </form>

                </div>
            </div>

            {{-- Security Preferences --}}
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Security Preferences</h5>
                </div>

                <div class="card-body">

                {{-- Security Success --}}
                @if(session('security_success'))
                    <div class="alert alert-success mb-3">
                        {{ session('security_success') }}
                    </div>
                @endif

                {{-- Security Validation Errors --}}
                @if($errors->hasBag('security') && $errors->security->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->security->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.update-security') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Session Timeout (minutes)</label>
                            <input type="number" name="session_timeout"
                                   value="{{ auth()->user()->session_timeout }}"
                                   class="form-control" min="5" max="120" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Recovery Email</label>
                            <input type="email" name="recovery_email"
                                   value="{{ auth()->user()->recovery_email }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Recovery Phone (10-12 digits)</label>
                            <input type="text" name="recovery_phone"
                                   value="{{ auth()->user()->recovery_phone }}"
                                   class="form-control">
                        </div>

                        <div class="form-check mt-3">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="security_notifications" 
                                name="security_notifications"
                                value="1"
                                {{ old('security_notifications', $user->security_notifications) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="security_notifications">
                                Receive security notifications
                            </label>
                        </div>

                        <h6 class="mt-4">Trusted Devices</h6>

                        @if(auth()->user()->trusted_devices)
                            <ul class="list-group mb-3">
                                @foreach(auth()->user()->trusted_devices as $index => $device)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $device }}
                                        <form method="POST" action="{{ route('account.update-security') }}">
                                        @csrf 
                                        <button type ="submit" name="remove_device" value="{{ $index }}"
                                                class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No trusted devices.</p>
                        @endif

                        <button class="btn btn-primary w-100">Save Security Preferences</button>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card border-danger">
                <div class="card-header bg-white text-danger fw-semibold">
                    Danger Zone
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Deleting your account is permanent.</p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i> Delete Account
                    </button>

                    <div class="modal fade" id="deleteModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Are you absolutely sure?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Deleting your account will:</p>
                                    <ul>
                                        <li>Erase all your data</li>
                                        <li>End your session</li>
                                        <li>Cannot be undone</li>
                                    </ul>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                    <form method="POST" action="{{ route('account.delete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Yes, delete my account
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div> <!-- End Settings Tab -->

        {{-- Login Activity Tab --}}
        <div class="tab-pane fade @if(session('active_tab')=='loginHistory') show active @endif"
             id="loginHistoryTab">

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Login Activity Chart</h5>
                </div>
                <div class="card-body">
                    <canvas id="loginChart" height="100"></canvas>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Login Activity</h5>
                </div>
                <div class="card-body">

                    @if(isset($loginHistory) && count($loginHistory) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>IP Address</th>
                                        <th>Device / Browser</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loginHistory as $log)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($log->logged_in_at)->format('d M Y, h:i A') }}</td>
                                            <td>{{ $log->ip_address }}</td>
                                            <td>{{ $log->user_agent }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No login history recorded.</p>
                    @endif

                </div>
            </div>

        </div> <!-- End Login Activity Tab -->

    </div> <!-- End tab-content -->

</div> <!-- End container -->

{{-- Tabs JS --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    let hash = window.location.hash;

    @if(session('active_tab') == 'profile')
        hash = '#profileTab';
    @endif

    @if(session('active_tab') == 'settings')
        hash = '#settingsTab';
    @endif

    @if(session('active_tab') == 'loginHistory')
        hash = '#loginHistoryTab';
    @endif

    if (hash) {
        const triggerEl = document.querySelector(`a.nav-link[href="${hash}"]`);
        if (triggerEl) new bootstrap.Tab(triggerEl).show();
    }
});
</script>

{{-- Profile Picture Preview JS --}}
<script>
document.getElementById('profileInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('previewImage').src = URL.createObjectURL(file);
    }
});
</script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("{{ route('account.login-history-data') }}")
        .then(res => res.json())
        .then(data => {
            const labels = Object.keys(data);
            const counts = Object.values(data);
            const ctx = document.getElementById('loginChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Logins per Day',
                        data: counts,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: { responsive: true }
            });
        });
});
</script>

@endsection
