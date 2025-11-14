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
            <a class="nav-link @if(!session('active_tab') || session('active_tab')=='profile') active @endif" data-bs-toggle="tab" href="#profileTab">
                <i class="bi bi-person me-1"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(session('active_tab')=='settings') active @endif" data-bs-toggle="tab" href="#settingsTab">
                <i class="bi bi-gear me-1"></i> Settings
            </a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- Profile Tab --}}
        <div class="tab-pane fade @if(!session('active_tab') || session('active_tab')=='profile') show active @endif" id="profileTab">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small">Full Name</label>
                            <input class="form-control" value="{{ auth()->user()->name ?? 'Not provided' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">Email</label>
                            <input class="form-control" value="{{ auth()->user()->email ?? 'Not provided' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">Role</label>
                            <input class="form-control" value="{{ auth()->user()->role ?? 'Not provided' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">Last Login</label>
                            <input class="form-control" 
                                value="{{ auth()->user()->last_login ? auth()->user()->last_login->format('d M Y H:i') : 'N/A' }}" 
                                readonly>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Settings Tab --}}
        <div class="tab-pane fade @if(session('active_tab')=='settings') show active @endif" id="settingsTab">

            {{-- Change Password --}}
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">

                    {{-- Success Message --}}
                    @if(session('password_success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('password_success') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
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
                            <small class="text-muted">
                                At least 8 characters with uppercase, lowercase, and number.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password *</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Update Password</button>
                    </form>

                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card border-danger">
                <div class="card-header bg-white text-danger fw-semibold">
                    Danger Zone
                </div>
                <div class="card-body">

                    <p class="text-muted mb-3">Deleting your account is permanent and cannot be undone.</p>

                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>
                        Delete Account
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Are you absolutely sure?</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Deleting your account will:</p>
                                    <ul>
                                        <li>Erase all your data</li>
                                        <li>End your current session</li>
                                        <li>Cannot be undone</li>
                                    </ul>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

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

    </div> <!-- End Tab Content -->

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let hash = window.location.hash;

    @if($errors->any() || session('password_success'))
        hash = '#settings';
    @endif

    if (hash) {
        const tabTriggerEl = document.querySelector(`a.nav-link[href="${hash}"]`);
        if (tabTriggerEl) {
            const tab = new bootstrap.Tab(tabTriggerEl);
            tab.show();
        }
    }
});
</script>

@endsection
