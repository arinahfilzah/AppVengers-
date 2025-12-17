@extends('layouts.app')

@section('title', 'StudyBuddy Premium Plans')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-crown me-2"></i>StudyBuddy Premium Plans</h3>
                </div>
                <div class="card-body">
                    <!-- Demo Notice -->
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Demo Mode:</strong> This is a simulation for testing purposes only. No real payments will be processed.
                    </div>

                    <div class="row">
                        @foreach($plans as $plan)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">{{ $plan->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <h2 class="card-title">{{ $plan->formatted_price }}</h2>
                                    <p class="text-muted">per {{ $plan->duration_days }} days</p>
                                    
                                    <ul class="list-unstyled">
                                        @foreach($plan->features as $feature)
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            {{ $feature }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('premium.checkout', $plan->id) }}" 
                                       class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-rocket me-2"></i>Get Premium
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection