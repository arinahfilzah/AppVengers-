@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="card w-100" style="max-width: 448px;">

        <div class="card-header bg-white text-center">
            <h4 class="card-title mb-1">Reset Password</h4>
            <p class="card-text text-muted small">Enter your new password</p>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/reset-password') }}">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">At least 8 chars with uppercase, lowercase, number</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Reset Password</button>
            </form>

        </div>

        <div class="card-footer bg-white text-center">
            <a href="{{ url('/login') }}">Back to Login</a>
        </div>

    </div>
</div>
@endsection
