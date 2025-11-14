@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="card w-100" style="max-width: 448px;">
        
        <div class="card-header bg-white text-center">
            <h4 class="card-title mb-1">Create Account</h4>
            <p class="card-text text-muted small">Register with your university email</p>
        </div>

        <div class="card-body">

            {{-- Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name (Optional)</label>
                    <input type="text" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">University Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="student@university.edu" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <small class="text-muted">
                        At least 8 characters with uppercase, lowercase, and number
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Create Account
                </button>
            </form>

        </div>

        <div class="card-footer bg-white text-center">
            <span class="text-muted small">Already have an account?</span>
            <a href="{{ route('login') }}" class="ms-1">Log in</a>
        </div>

    </div>
</div>
@endsection
