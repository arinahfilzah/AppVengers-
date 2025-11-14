@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="card w-100" style="max-width: 448px;">

        <div class="card-header bg-white text-center">
            <h4 class="card-title mb-1">Forgot Password</h4>
            <p class="card-text text-muted small">Enter your email and we'll send you a reset link</p>
        </div>

        <div class="card-body">

            {{-- Success --}}
            @if(session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/forgot-password') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" class="form-control" name="email" placeholder="student@university.edu" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Send Reset Link
                </button>
            </form>

        </div>

        <div class="card-footer text-center bg-white">
            <a href="{{ route('login') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to Login
            </a>
        </div>

    </div>
</div>
@endsection
