@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container text-center d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div>
        <h1 class="fw-bold mb-4">Welcome, {{ Auth::user()->name ?? 'User' }}!</h1>
        <p class="text-muted mb-4">This is your dashboard. Here you can navigate through your courses, upload resources, and manage your profile.</p>
        <p class="lead">Use the navigation bar above to access different sections.</p>
    </div>
</div>
@endsection

