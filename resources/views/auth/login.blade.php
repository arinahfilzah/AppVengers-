@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="card w-100" style="max-width: 448px;">

        <div class="card-header bg-white text-center">
            <h4 class="card-title mb-1">Welcome Back</h4>
            <p class="card-text text-muted small">Log in to access your account</p>
        </div>

        <div class="card-body">

            {{-- ✅ Suspended / Invalid login message (from withErrors(['loginError' => ...])) --}}
            @if($errors->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ✅ Show other validation errors (optional but recommended) --}}
            @if($errors->any() && !$errors->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="student@university.edu"
                        required
                        value="{{ old('email') }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password *</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <a href="{{ url('/forgot-password') }}" class="text-primary text-decoration-none">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Log in
                </button>
            </form>
        </div>

        <div class="card-footer bg-white text-center">
            <span class="text-muted small">Don’t have an account?</span>
            <a href="{{ url('/register') }}" class="ms-1">Register</a>
        </div>

    </div>
</div>
@endsection
