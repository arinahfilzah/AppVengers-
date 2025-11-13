@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-3">Manage Account</h2>
    <form method="POST" action="#">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" value="John Doe">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="john@example.com">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
    <hr class="my-4">
    <button class="btn btn-danger">Delete Account</button>
</div>
@endsection
