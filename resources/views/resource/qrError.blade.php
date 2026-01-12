@extends('layouts.app')

@section('title', 'Invalid QR Code')

@section('content')

<section class="ftco-section" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg text-center" style="border-radius: 15px; border: none;">
                    <div class="card-body p-5">
                        
                        {{-- Error Icon --}}
                        <div class="mb-4">
                            <div style="width: 120px; height: 120px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fa fa-times" style="font-size: 60px; color: white;"></i>
                            </div>
                        </div>

                        {{-- Error Title --}}
                        <h2 class="mb-3" style="color: #dc3545; font-weight: 600;">Invalid or Expired QR Code</h2>
                        
                        {{-- Error Message --}}
                        <p class="text-muted mb-4" style="font-size: 16px;">
                            {{ $message ?? 'The QR code you scanned is not valid or has expired. Please check with the resource owner for a valid QR code.' }}
                        </p>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-2">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #ce4be8 0%, #207ce5 100%); border: none;">
                                <i class="fa fa-home"></i> Go to Homepage
                            </a>
                        </div>

                        {{-- Help Section --}}
                        <div class="mt-4 p-3" style="background: #f9faff; border-radius: 8px;">
                            <p class="small text-muted mb-0">
                                <i class="fa fa-question-circle" style="color: #4986fc;"></i> 
                                <strong>Need Help?</strong><br>
                                If you believe this is an error, please contact the resource uploader or try scanning the QR code again.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection