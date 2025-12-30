@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container py-4" style="max-width: 1200px; min-height: calc(100vh - 80px);">

    <!-- Page Header (same structure like verification) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">User Management</h1>
                    <p class="text-muted mb-0">View, search, and manage user roles and account status</p>
                </div>

                <div class="d-flex gap-2">
                    {{-- Optional: show quick count badges (similar vibe to verification) --}}
                    <span class="btn btn-outline-primary">
                        All <span class="badge bg-primary ms-1">{{ $users->count() }}</span>
                    </span>

                    <span class="btn btn-outline-success">
                        Active <span class="badge bg-success ms-1">{{ $users->where('account_status','active')->count() }}</span>
                    </span>

                    <span class="btn btn-outline-warning">
                        Suspended <span class="badge bg-warning ms-1">{{ $users->where('account_status','suspended')->count() }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search + Actions (same spacing style) -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.viewUsers') }}" class="d-flex gap-2 flex-wrap align-items-center">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            style="max-width: 420px;"
                            placeholder="Search users (name/email)"
                            value="{{ request('search') }}"
                        >

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Search
                        </button>

                        @if(request()->filled('search'))
                            <a href="{{ route('admin.viewUsers') }}" class="btn btn-outline-secondary">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card (same card/table style like verification) -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="20%">Name</th>
                                    <th width="22%">Email</th>
                                    <th width="10%">Role</th>
                                    <th width="23%">Status</th>
                                    <th width="15%">Last Login</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=667eea&color=fff&rounded=true"
                                                    class="rounded-circle me-3"
                                                    width="40"
                                                    height="40"
                                                    alt="Avatar"
                                                >
                                                <div>
                                                    <strong>{{ $user->name ?? '-' }}</strong>
                                                    <div class="text-muted small">ID: {{ $user->id }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $user->email }}</td>

                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-primary">Admin</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($user->account_status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Suspended</span>

                                                @if(!empty($user->suspended_reason))
                                                    <div class="text-muted small mt-1">
                                                        Reason: {{ $user->suspended_reason }}
                                                    </div>
                                                @endif
                                            @endif
                                        </td>

                                        <td>
                                            {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('M d, Y') : '-' }}
                                            @if($user->last_login)
                                                <div class="text-muted small">{{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }}</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.showUser', $user->id) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>

                                                <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                @if($user->account_status === 'active')
                                                    <form
                                                        action="{{ route('admin.suspendUser', $user->id) }}"
                                                        method="POST"
                                                        class="d-inline suspend-form"
                                                    >
                                                        @csrf
                                                        <input type="hidden" name="reason" value="">
                                                        <button type="submit" class="btn btn-outline-danger">
                                                            <i class="fas fa-ban"></i> Suspend
                                                        </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('admin.reactivateUser', $user->id) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reactivate this account?');"
                                                    >
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success">
                                                            <i class="fas fa-check"></i> Reactivate
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Same prompt logic, just nicer --}}
@push('scripts')
<script>
document.querySelectorAll('.suspend-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const reason = prompt("Enter suspension reason:");
        if (!reason || reason.trim() === "") {
            e.preventDefault();
            alert("Suspension reason is required.");
            return;
        }
        form.querySelector('input[name="reason"]').value = reason.trim();

        if (!confirm("Confirm suspend this user?")) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection
