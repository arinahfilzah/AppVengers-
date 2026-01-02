@extends('layouts.app')

@section('title', 'My Collaboration Requests')

@section('content')
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">My Collaboration Requests</h2>

                @forelse($requests as $request)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        <i class="fa fa-file"></i> {{ $request->resource->title }}
                                    </h5>
                                    <p class="card-text">
                                        <strong><i class="fa fa-calendar"></i> Requested on:</strong> {{ $request->created_at->format('M d, Y h:i A') }}
                                        <br>
                                        <strong><i class="fa fa-info-circle"></i> Status:</strong> 
                                        @if($request->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($request->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                        @if($request->responded_at)
                                            <br>
                                            <strong><i class="fa fa-clock-o"></i> Responded on:</strong> {{ $request->responded_at->format('M d, Y h:i A') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ route('subject.resources', ['subject' => urlencode($request->resource->subject)]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> View Resource
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p>You haven't made any collaboration requests yet.</p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if($requests->hasPages())
                    <div class="row mt-4">
                        <div class="col">
                            {{ $requests->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection