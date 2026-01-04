@extends('layouts.app')

@section('title', 'Collaboration Requests')

@section('content')
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Collaboration Requests</h2>

                {{-- Success/Error Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show">
                        <i class="fa fa-info-circle"></i> {{ session('info') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show">
                        <i class="fa fa-exclamation-triangle"></i> {{ session('warning') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                {{-- NF9: Display pending requests --}}
                @forelse($requests as $request)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        <i class="fa fa-file"></i> {{ $request->resource->title }}
                                    </h5>
                                    <p class="card-text">
                                        <strong><i class="fa fa-user"></i> Requested by:</strong> {{ $request->requester->name }}
                                        <br>
                                        <strong><i class="fa fa-envelope"></i> Email:</strong> {{ $request->requester->email }}
                                        <br>
                                        <strong><i class="fa fa-clock-o"></i> Requested on:</strong> {{ $request->created_at->format('M d, Y h:i A') }}
                                    </p>
                                    @if($request->message)
                                        <p class="text-muted">
                                            <strong>Message:</strong> {{ $request->message }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-4 text-right">
                                    {{-- NF10-11: Approve Button --}}
                                    <form action="{{ route('collaboration.approve', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm mb-2" onclick="return confirm('Approve this collaboration request?')">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <br>
                                    {{-- AF2: Reject Button --}}
                                    <form action="{{ route('collaboration.reject', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject this collaboration request?')">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                        <p>No pending collaboration requests at the moment.</p>
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