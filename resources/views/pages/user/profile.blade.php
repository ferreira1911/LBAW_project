@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="container py-5">
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>

    <div class="row g-4">
        
        {{-- Left Column: User Info Card --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4 h-100">
                <div class="mb-3">
                    @if($user->url)
                        <img src="{{ $user->getProfileImage() }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle img-thumbnail object-fit-cover" 
                             style="width: 150px; height: 150px;">
                    @else
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 150px; height: 150px;">
                            <i class="bi bi-person-fill display-1 text-secondary"></i>
                        </div>
                    @endif
                </div>
                
                <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                {{-- Rating Badge --}}
                <div class="mb-4">
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="bi bi-star-fill me-1"></i>
                        {{ isset($user->average_rating) ? number_format($user->average_rating, 1) : 'N/A' }} / 5.0
                    </span>
                </div>

                {{-- Bio --}}
                <div class="text-start mb-4">
                    <h6 class="fw-bold text-uppercase small text-muted">About</h6>
                    <p class="small text-secondary">
                        {{ $user->description ?? 'This user has not added a bio yet.' }}
                    </p>
                </div>

                {{-- Owner Actions --}}
                @if (Auth::id() === $user->id)
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.edit', $user) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-bell me-2"></i>Notifications
                        </a>
                        <a href="{{ route('user.destroy', $user) }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete your profile?');">
                            <i class="bi bi-trash me-2"></i>Delete Profile
                        </a>
                    
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Details & Auctions --}}
        <div class="col-md-8">
            
            {{-- Wallet Section (Only visible to Owner or Admin) --}}
            @if (!empty($canViewBalance) && $canViewBalance)
                <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 opacity-75">Available Balance</h5>
                                <h2 class="fw-bold mb-0">€{{ number_format($user->credit, 2) }}</h2>
                                @if($user->held_credit > 0)
                                    <small class="text-white-50">
                                        <i class="bi bi-lock-fill me-1"></i>Held in active bids: €{{ number_format($user->held_credit, 2) }}
                                    </small>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('credit.create') }}" class="btn btn-light fw-bold text-primary">
                                    <i class="bi bi-plus-lg me-1"></i>Add Funds
                                </a>
                                <a href="{{ route('withdrawal.create') }}" class="btn btn-outline-light">
                                    <i class="bi bi-cash-stack me-1"></i>Withdraw
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Auctions Section --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-hammer me-2 text-primary"></i>User Auctions
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($auctions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($auctions as $auction)
                                <a href="{{ route('auction.show', $auction) }}" class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        {{-- Thumbnail (Fallback Logic) --}}
                                        <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-secondary" style="width: 60px; height: 60px;">
                                            @if(isset($auction->images) && $auction->images->count() > 0)
                                                <img src="{{ $auction->images->first()->getUrl() }}" class="w-100 h-100 object-fit-cover" alt="{{ $auction->title }}">
                                            @else
                                                <i class="bi bi-image fs-4"></i>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark">
                                                {{ $auction->title }}
                                                @if ($auction->is_featured)
                                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7em;">Featured</span>
                                                @endif
                                            </h6>
                                            <div class="small text-muted">
                                                Status: 
                                                <span class="fw-bold {{ $auction->status === 'Active' ? 'text-success' : 'text-secondary' }}">
                                                    {{ $auction->status }}
                                                </span>
                                                • Current Price: €{{ number_format($auction->current_price, 2) }}
                                            </div>
                                        </div>
                                    </div>

                                    @if(Auth::check() && Auth::id() === $user->id)
                                        <object> {{-- Object tag prevents nested link clicking issues --}}
                                            <a href="{{ route('auction.edit', $auction) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                        </object>
                                    @else
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-4 opacity-25 mb-2 d-block"></i>
                            <p class="mb-0">This user has no auctions yet.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection