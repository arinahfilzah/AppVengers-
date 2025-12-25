@extends('layouts.app')

@section('content')

<div class="container" style="max-width: 1200px; min-height: calc(100vh - 80px);">
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
            <select name="account_status" class="form-control" id="account_status">
                <option value="active" {{ $user->account_status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ $user->account_status == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>

        <div class="form-group" id="reason_box" style="{{ $user->account_status === 'suspended' ? '' : 'display:none;' }}">
            <label for="suspended_reason">Suspension Reason</label>
            <input type="text" name="suspended_reason" class="form-control"
                   value="{{ $user->suspended_reason ?? '' }}"
                   placeholder="Enter reason (required if suspended)">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.viewUsers') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
document.getElementById('account_status').addEventListener('change', function () {
    document.getElementById('reason_box').style.display = (this.value === 'suspended') ? '' : 'none';
});
</script>

@endsection
