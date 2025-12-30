@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1200px; min-height: calc(100vh - 80px);">
    <h1>User Details</h1>

    <div class="card p-3">
        <p><strong>Name:</strong> {{ $user->name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
        <p><strong>Status:</strong> {{ $user->account_status }}</p>
        <p><strong>Last Login:</strong> {{ $user->last_login ?? '-' }}</p>

        @if($user->account_status === 'suspended')
            <p><strong>Suspended Reason:</strong> {{ $user->suspended_reason ?? '-' }}</p>
        @endif
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.viewUsers') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
