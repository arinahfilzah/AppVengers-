@extends('layouts.app')

@section('title', 'Payment Successful - StudyBuddy Premium')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-success">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="success-circle d-inline-flex align-items-center justify-content-center">
                            <i class="fas fa-check fa-3x text-white"></i>
                        </div>
                    </div>

                    <h2 class="text-success mb-3">Payment Successful!</h2>
                    <p class="lead mb-4">Congratulations! Your account has been upgraded to <strong>StudyBuddy Premium</strong>.</p>

                    @if($payment)
                        <div class="card mb-3">
                            <div class="card-header bg-light">Transaction Receipt</div>
                            <div class="card-body text-start">
                                <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                                <p><strong>Plan:</strong> {{ $payment->plan->name }}</p>
                                <p><strong>Amount Paid:</strong> RM {{ number_format($payment->amount, 2) }}</p>
                                <p><strong>Balance Before:</strong> RM {{ number_format($payment->balance_before, 2) }}</p>
                                <p><strong>Balance After:</strong> RM {{ number_format($payment->balance_after, 2) }}</p>
                                <p><strong>Status:</strong> <span class="text-success">{{ ucfirst($payment->status) }}</span></p>
                                <p><strong>Processed At:</strong> {{ $payment->processed_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-5">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>Go to Dashboard
                        </a>
                        <a href="#" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-star me-2"></i>Explore Premium Features
                        </a>
                    </div>

                    <div class="mt-4 text-muted">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            This was a demo payment. No real money was charged.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}
</style>
@endsection
