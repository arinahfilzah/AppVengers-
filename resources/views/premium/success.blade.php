@extends('layouts.app')

@section('title', 'Payment Successful - StudyBuddy Premium')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-success">
                <div class="card-body text-center py-5">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="success-circle d-inline-flex align-items-center justify-content-center">
                            <i class="fas fa-check fa-3x text-white"></i>
                        </div>
                    </div>

                    <h2 class="text-success mb-3">Payment Successful!</h2>
                    <p class="lead mb-4">Congratulations! Your account has been upgraded to <strong>StudyBuddy Premium</strong>.</p>
                    
                    <div class="alert alert-success">
                        <i class="fas fa-rocket me-2"></i>
                        <strong>Premium Features Unlocked:</strong> You now have access to AI recommendations, advanced search, and more!
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body">
                                    <i class="fas fa-robot fa-2x text-primary mb-3"></i>
                                    <h5>AI Recommendations</h5>
                                    <p class="small text-muted">Personalized study material suggestions</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body">
                                    <i class="fas fa-search fa-2x text-primary mb-3"></i>
                                    <h5>Advanced Search</h5>
                                    <p class="small text-muted">Filter and find resources faster</p>
                                </div>
                            </div>
                        </div>
                    </div>

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