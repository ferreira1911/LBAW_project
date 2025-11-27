@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    Notifications
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="badge bg-danger rounded-pill fs-6 ms-2">
                            {{ $unreadCount }} New
                        </span>
                    @endif
                </h2>
                
                @if(isset($unreadCount) && $unreadCount > 0)
                    <button onclick="markAllRead()" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-check2-all me-1"></i> Mark all as read
                    </button>
                @endif
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    @forelse ($notifications as $notification)
                        
                        @include('partials.notification', ['notification' => $notification])

                    @empty
                        
                        <div class="text-center py-5 px-3">
                            <div class="mb-3 text-muted opacity-25">
                                <i class="bi bi-bell-slash display-1"></i>
                            </div>
                            <h4 class="fw-bold text-secondary">All caught up!</h4>
                            <p class="text-muted mb-4">You have no new notifications at the moment.</p>
                            
                            <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-search me-2"></i>Explore Auctions
                            </a>
                        </div>

                    @endforelse
                </div>
            </div>

            @if($notifications->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection