@extends('layouts.app')

@section('content')
<section class="hero text-center">
    <div class="container">
        <h1 class="display-6 fw-bold">Welcome Back to StudyBuddy</h1>
        <p class="lead">Log in to continue your study journey.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 form-section">
            <h4 class="mb-3 text-primary fw-bold">Sign In</h4>
            <form method="POST" action="#">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>
            </form>
            <p class="mt-3 text-center">Don’t have an account? 
                <a href="{{ route('home') }}#register-form" class="text-success text-decoration-none">Register</a>
            </p>
        </div>
    </div>
</section>
@endsection
