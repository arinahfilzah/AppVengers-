@extends('layouts.app')

@section('title', 'Premium Transactions')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-receipt me-2"></i>Premium Transactions
            </h1>
            <p class="text-muted mb-0">View and manage all premium transactions</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-receipt fa-2x text-primary"></i>
                    </div>
                    <h3 class="mb-1">{{ number_format($stats['total']) }}</h3>
                    <p class="text-muted mb-0 small">Total Transactions</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h3 class="mb-1">{{ number_format($stats['successful']) }}</h3>
                    <p class="text-muted mb-0 small">Successful</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                    <h3 class="mb-1">{{ number_format($stats['failed']) }}</h3>
                    <p class="text-muted mb-0 small">Failed</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-dollar-sign fa-2x text-success"></i>
                    </div>
                    <h3 class="mb-1">RM {{ number_format($stats['totalRevenue'], 2) }}</h3>
                    <p class="text-muted mb-0 small">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.premium.transactions') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Payment Method</label>
                    <select name="payment_method" class="form-select form-select-sm">
                        <option value="">All Methods</option>
                        <option value="wallet" {{ request('payment_method') === 'wallet' ? 'selected' : '' }}>Wallet</option>
                        <option value="credit_card" {{ request('payment_method') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="fpx" {{ request('payment_method') === 'fpx' ? 'selected' : '' }}>FPX</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Search</label>
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Transaction ID, User..." value="{{ request('search') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm me-2">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.premium.transactions') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">All Transactions</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                <code class="small">{{ $transaction->transaction_id }}</code>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $transaction->user->name ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $transaction->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $transaction->plan->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <strong class="text-success">RM {{ number_format($transaction->amount, 2) }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                </span>
                            </td>
                            <td>
                                @switch($transaction->status)
                                    @case('success')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Success
                                        </span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Failed
                                        </span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-undo me-1"></i>Refunded
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="small">
                                    {{ $transaction->created_at->format('d M Y') }}
                                    <br>
                                    <span class="text-muted">{{ $transaction->created_at->format('H:i:s') }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.premium.transaction', $transaction->id) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <p class="mb-0">No transactions found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($transactions->hasPages())
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} 
                    of {{ $transactions->total() }} transactions
                </div>
                <div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.table tbody tr {
    transition: background-color 0.2s;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}
</style>
@endpush
@endsection