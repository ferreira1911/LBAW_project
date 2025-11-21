@extends('layouts.app')

@section('title', $auction->title)

@section('content')
<div class="container py-4">
    
    {{-- Breadcrumb & Back Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Auctions</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($auction->title, 20) }}</li>
            </ol>
        </nav>
        
        {{-- Owner Edit Button --}}
        @can('update', $auction)
            <a href="{{ route('auction.edit', $auction) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit Auction
            </a>
        @endcan
    </div>

    <div class="row g-4">
        
        {{-- Left Column: Images --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                @if (isset($auction->images) && $auction->images->count())
                    <div id="auctionCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @foreach ($auction->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ $image->getUrl() }}" class="d-block w-100 object-fit-cover" style="height: 400px;" alt="{{ $auction->title }}">
                                </div>
                            @endforeach
                        </div>
                        @if($auction->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#auctionCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#auctionCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    {{-- Fallback for when there are no images OR the relation is null --}}
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-image display-1"></i>
                            <p class="mt-2">No images available</p>
                        </div>
                    </div>
                @endif
                
                <div class="card-body">
                    <h5 class="fw-bold">Description</h5>
                    <p class="card-text text-secondary">{{ $auction->description }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column: Details & Bidding --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="badge bg-secondary mb-2">{{ $auction->category->name }}</span>
                        <h1 class="h3 fw-bold mb-1">{{ $auction->title }}</h1>
                        <p class="text-muted small">
                            Hosted by <a href="{{ route('user.show', $auction->owner) }}" class="text-decoration-none fw-bold">{{ $auction->owner->name }}</a>
                        </p>
                    </div>

                    {{-- Price Section --}}
                    <div class="mb-4 p-3 bg-light rounded">
                        <p class="text-muted mb-1 text-uppercase small fw-bold">Current Price</p>
                        <h2 class="display-6 fw-bold text-primary mb-0">
                            €{{ number_format($auction->current_price ?? $auction->starting_price, 2) }}
                        </h2>
                    </div>

                    {{-- Dates --}}
                    <div class="row text-muted small mb-4">
                        <div class="col-6">
                            <i class="bi bi-calendar-check me-1"></i> Starts: <br>
                            <span class="fw-bold text-dark">{{ $auction->start_date->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="col-6">
                            <i class="bi bi-calendar-x me-1"></i> Ends: <br>
                            <span class="fw-bold text-dark">{{ $auction->end_date->format('M d, Y H:i') }}</span>
                        </div>
                    </div>

                    {{-- Bidding Form --}}
                    @auth
                        @if ($auction->status === 'Active' && $auction->owner_id !== Auth::id())
                            <hr>
                            <h5 class="fw-bold mb-3">Place Your Bid</h5>
                            
                            {{-- Success/Error Messages --}}
                            @if (session('success'))
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('bids.store', $auction) }}">
                                @csrf
                                
                                @php
                                    $highestBid = $bids->max('amount') ?? $auction->starting_price;
                                    $minIncrement = $auction->starting_price * 0.10; // 10% increment logic (adjust if needed)
                                    $requiredMinBid = $highestBid + $minIncrement;
                                @endphp

                                <label for="amount" class="form-label small text-muted">Minimum bid: €{{ number_format($requiredMinBid, 2) }}</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">€</span>
                                    <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                           min="{{ $requiredMinBid }}" step="0.01" 
                                           placeholder="{{ number_format($requiredMinBid, 2) }}" required>
                                    <button class="btn btn-primary px-4" type="submit">Bid</button>
                                </div>
                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>
                        @elseif($auction->owner_id === Auth::id())
                             <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> You are the owner of this auction.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-secondary text-center">
                            <p class="mb-2">Please login to place a bid.</p>
                            <a href="{{ route('login') }}" class="btn btn-sm btn-dark">Login</a>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Bidding History --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-clock-history me-2"></i> Bidding History
                </div>
                <div class="card-body p-0">
                    @if ($bids->isNotEmpty())
                        <ul class="list-group list-group-flush">
                            @foreach ($bids as $bid)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                    <div>
                                        <a href="{{ route('user.show', $bid->user) }}" class="fw-bold text-decoration-none text-dark">
                                            {{ $bid->user->name }}
                                        </a>
                                        <div class="text-muted small">{{ $bid->date->format('M d, H:i') }}</div>
                                    </div>
                                    <span class="badge bg-light text-dark border fs-6">
                                        €{{ number_format($bid->amount, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <p class="mb-0">No bids yet. Be the first!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection