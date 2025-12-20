@extends('layouts.app')

@section('content')

<div class="container">
    <h1>User Management</h1>
    <a href="{{ route('admin.createUser') }}" class="btn btn-primary">Add User</a>

    <form method="GET" action="{{ route('admin.viewUsers') }}">
        <input type="text" name="search" placeholder="Search users" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->account_status }}</td>
                <td>{{ $user->last_login }}</td>
                <td>
                    <a href="{{ route('admin.editUser', $user->id) }}">Edit</a>
                    @if($user->account_status == 'active')
                        <form action="{{ route('admin.suspendUser', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit">Suspend</button>
                        </form>
                    @else
                        <form action="{{ route('admin.reactivateUser', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit">Reactivate</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
