@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="account_status">Account Status</label>
            <select name="account_status" class="form-control">
                <option value="active" {{ $user->account_status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ $user->account_status == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

@endsection
