@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-3">Dashboard</h2>
    <p>Welcome to your StudyBuddy dashboard! Manage your profile or explore new courses below.</p>
    <div class="mt-4">
        <a href="{{ route('account') }}" class="btn btn-primary me-2">Manage Account</a>
        <a href="#" class="btn btn-secondary">Logout</a>
    </div>
</div>
@endsection
