@extends('layouts.app')

@section('content')
<section class="hero text-center">
    <div class="container">
        <h1 class="display-6 fw-bold">Reset Your Password</h1>
        <p class="lead">Create a new password for your StudyBuddy account.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 form-section">
            <h4 class="mb-3 text-success fw-bold">Set New Password</h4>
            <form method="POST" action="#">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Update Password</button>
            </form>
            <p class="mt-3 text-center">
                <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
            </p>
        </div>
    </div>
</section>
@endsection
