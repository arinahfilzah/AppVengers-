@extends('layouts.app')

@section('title', 'Checkout - StudyBuddy Premium')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Complete Your Purchase</h3>
                </div>
                <div class="card-body">
                    <!-- Demo Notice -->
                    <div class="alert alert-info">
                        <i class="fas fa-credit-card me-2"></i>
                        <strong>Test Cards:</strong> Use <code>4242 4242 4242 4242</code> for success, 
                        <code>4000 0000 0000 0002</code> for failure
                    </div>

                    <div class="row">
                        <!-- Order Summary -->
                        <div class="col-md-5 mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <div class="card-body">
                                    <h6>{{ $plan->name }}</h6>
                                    <p class="text-muted">{{ $plan->description }}</p>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span>Amount:</span>
                                        <strong>{{ $plan->formatted_price }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Duration:</span>
                                        <span>{{ $plan->duration_days }} days</span>
                                    </div>
                                    
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <small class="text-muted">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            100% Demo Payment - No real money charged
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <div class="col-md-7">
                            <form method="POST" action="{{ route('premium.process') }}" id="paymentForm">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="cardholder_name" class="form-label">Cardholder Name</label>
                                    <input type="text" 
                                           class="form-control @error('cardholder_name') is-invalid @enderror" 
                                           id="cardholder_name" 
                                           name="cardholder_name"
                                           value="{{ old('cardholder_name', Auth::user()->name) }}"
                                           required>
                                    @error('cardholder_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" 
                                           class="form-control @error('card_number') is-invalid @enderror" 
                                           id="card_number" 
                                           name="card_number"
                                           value="{{ old('card_number', '4242424242424242') }}"
                                           placeholder="4242 4242 4242 4242"
                                           maxlength="16"
                                           required>
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Enter any 16-digit number for testing</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiry_month" class="form-label">Expiry Month</label>
                                        <select class="form-control @error('expiry_month') is-invalid @enderror" 
                                                id="expiry_month" 
                                                name="expiry_month"
                                                required>
                                            <option value="">Month</option>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                                                    {{ old('expiry_month') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('expiry_month')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="expiry_year" class="form-label">Expiry Year</label>
                                        <select class="form-control @error('expiry_year') is-invalid @enderror" 
                                                id="expiry_year" 
                                                name="expiry_year"
                                                required>
                                            <option value="">Year</option>
                                            @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                <option value="{{ $i }}" 
                                                    {{ old('expiry_year') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('expiry_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="cvc" class="form-label">CVC</label>
                                    <input type="text" 
                                           class="form-control @error('cvc') is-invalid @enderror" 
                                           id="cvc" 
                                           name="cvc"
                                           value="{{ old('cvc', '123') }}"
                                           placeholder="123"
                                           maxlength="3"
                                           required>
                                    @error('cvc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="fas fa-lock me-2"></i>Complete Purchase (Demo)
                                    </button>
                                    <a href="{{ route('premium.plans') }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add loading state to submit button
    document.getElementById('paymentForm').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    });

    // Format card number with spaces
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formatted = value.replace(/(\d{4})/g, '$1 ').trim();
        e.target.value = formatted.substring(0, 19); // 16 digits + 3 spaces
    });
</script>
@endpush
@endsection