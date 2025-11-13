@extends('layouts.app')

@section('content')
<section class="hero text-center">
    <div class="container">
        <h1 class="display-6 fw-bold">Forgot Your Password?</h1>
        <p class="lead">Don’t worry — we’ll help you reset it.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 form-section">
            <h4 class="mb-3 text-warning fw-bold">Reset Link Request</h4>
            <p class="small text-muted">Enter your email address, and we’ll send you a password reset link.</p>
            <form method="POST" action="#">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Send Reset Link</button>
            </form>
            <p class="mt-3 text-center">
                <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
            </p>
        </div>
    </div>
</section>
@endsection
