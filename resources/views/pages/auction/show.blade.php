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
            <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit Auction
            </a>
        @endcan
    </div>

    <div class="row g-4">
        
        {{-- Left Column: Images --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                @if (isset($auction->images) && $auction->images->count())
                    <div id="auctionCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @foreach ($auction->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 500px; background-color: #f8f9fa;">
                                        <img src="{{ $image->getUrl() }}" class="d-block w-100 h-100 object-fit-contain" alt="{{ $auction->title }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($auction->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#auctionCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon p-3 bg-dark rounded-circle bg-opacity-25" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#auctionCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon p-3 bg-dark rounded-circle bg-opacity-25" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    {{-- Fallback Image --}}
                    <div class="d-flex align-items-center justify-content-center bg-light text-secondary" style="height: 500px;">
                        <div class="text-center">
                            @if ($auction->picture)
                                <img src="{{ asset('storage/' . $auction->picture) }}" class="img-fluid" style="max-height: 500px;" alt="{{ $auction->title }}">
                            @else
                                <i class="bi bi-image display-1 opacity-50"></i>
                                <p class="mt-2">No image available</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
                
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3 border-bottom pb-2">Description</h4>
                    <p class="card-text text-secondary" style="line-height: 1.6;">
                        {{ $auction->description }}
                    </p>
                </div>
            </div>

            @if($auction->latitude && $auction->longitude)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <h4 class="fw-bold mb-0">Location</h4>
                            @if($auction->address)
                                <span class="text-muted small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $auction->address }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="ratio ratio-16x9 rounded overflow-hidden border bg-light">
                            <iframe 
                                src="https://maps.google.com/maps?q={{ $auction->latitude }},{{ $auction->longitude }}&hl=en&z=15&output=embed"
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            @endif
        </div>


        {{-- Right Column: Details & Bidding --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary">{{ $auction->category->name }}</span>
                        @auth
                            @can('canFollow',$auction)
                                @php
                                    $isFollowing = $auction->isFollowedBy(Auth::user());
                                @endphp
                                
                                <button type="button" class="btn follow-btn border-0 p-0 d-flex align-items-center {{ $isFollowing ? 'btn-outline-danger' : 'btn-outline-secondary' }}" style="background: none;" data-following="{{ $isFollowing ? 'true' : 'false' }}" data-auction-id="{{ $auction->id }}" data-url="{{ route('auction.follow', $auction) }}"> 
                                    <i class="bi {{ $isFollowing ? 'bi-heart-fill' : 'bi-heart' }} fs-5"></i>
                                    <span class="btn-text ms-2 fw-bold small">
                                        {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                                    </span>
                                </button>
                            @endcan
                        @endauth
                    </div>

                    <h1 class="h3 fw-bold mb-3">{{ $auction->title }}</h1>

                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                        <p class="text-muted small mb-0">
                            Hosted by <a href="{{ route('users.show', $auction->owner) }}" class="text-decoration-none fw-bold text-primary">{{ $auction->owner->name }}</a>
                        </p>
                        
                        @auth
                            @can('message',$auction->owner)
                            @if(Auth::id() !== $auction->owner_id)
                                <a href="{{ route('messages.show', $auction->owner) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-chat-dots-fill me-1"></i> Message
                                </a>
                            @endif
                            @endcan
                        @endauth
                    </div>

                    {{-- Price Section --}}
                    <div class="mb-4 p-3 bg-light rounded">
                        <p class="text-muted mb-1 text-uppercase small fw-bold">Current Price</p>
                        <h2 class="display-6 fw-bold text-primary mb-0">
                            €{{ number_format($auction->current_price ?? $auction->starting_price, 2) }}
                        </h2>
                    </div>

                    {{-- Buy Now Price Section --}}
                    @if($auction->is_buy_now_active && $auction->buy_now_price)
                        <div class="mb-4 p-3 bg-light rounded d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Buy Now</p>
                                <h4 class="fw-bold text-dark mb-0">
                                    €{{ number_format($auction->buy_now_price, 2) }}
                                </h4>
                            </div>
                            @auth
                                @if(Auth::user()->id === $auction->owner_id)
                                    <button type="button" class="btn btn-primary btn-sm" disabled title="You are the owner">
                                        Buy Now
                                    </button>
                                @else
                                    <form action="{{ route('auctions.buyNow', $auction) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to buy this item for €' + {{ $auction->buy_now_price }} + '?');">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" {{ !in_array($auction->status, ['Active', 'Ending']) ? 'disabled' : '' }}>
                                             Buy Now
                                        </button>
                                        
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                    Buy Now
                                </a>
                            @endauth
                        </div>
                    @endif

                    <div class="text-end auction-timer" data-end="{{ $auction->end_date->toIso8601String() }}">
                        <p class="text-muted mb-0 text-uppercase small fw-bold">
                            <i class="bi bi-stopwatch"></i> Time Left
                        </p>
                        <div class="fs-5 fw-bold timer-text text-dark">
                            {{ $auction->end_date->diffForHumans() }}
                        </div>
                    </div>

                    
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

                    
                    @auth
                        
                        @php
                            $highestBidRecord = $highestBid; 
                            $highestBidAmount = $highestBidRecord ? $highestBidRecord->amount : $auction->starting_price;
                            
                            $fixedIncrement = $auction->starting_price * 0.10;
                            $requiredMinBid = $highestBidAmount + $fixedIncrement;
                            
                            $isHighestBidder = $highestBidRecord && (int)$highestBidRecord->user_id === (int)Auth::id();
                        @endphp

                        @if (in_array($auction->status, ['Active', 'Ending']))
                            
                            @if(Auth::user()->is_admin)
                                <div class="alert alert-warning border-0 d-flex align-items-center">
                                    <i class="bi bi-shield-lock-fill me-2"></i>
                                    <div>
                                        <strong>Administrator:</strong> You are in viewing mode. Admins cannot participate in auctions.
                                    </div>
                                </div>

                            @elseif($auction->owner_id === Auth::id())
                                <div class="alert alert-info border-0 d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <div>
                                        <strong>Owner:</strong> You cannot bid on your own auction.
                                    </div>
                                </div>

                            @elseif($isHighestBidder)
                                {{-- Vencedor Atual (Discreto) --}}
                                <hr>
                                <div class="text-center py-3">
                                    <h6 class="fw-bold text-success mb-1">
                                        <i class="bi bi-check-circle-fill me-1"></i> You are the highest bidder
                                    </h6>
                                    <p class="text-muted small mb-0">Current bid: €{{ number_format($highestBidAmount, 2) }}</p>
                                </div>

                            @else
                                {{-- Formulário de Licitação --}}
                                <hr>
                                <h5 class="fw-bold mb-3">Place Your Bid</h5>
                                
                                @if (session('success'))
                                    <div class="alert alert-success d-flex align-items-center small mb-2" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                {{-- Erro Genérico (se houver) --}}
                                @if ($errors->has('message'))
                                    <div class="alert alert-danger small mb-2">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('bids.store', $auction) }}">
                                    @csrf
                                    
                                    <label for="amount" class="form-label small text-muted">
                                        Minimum required: <span class="fw-bold text-dark">€{{ number_format($requiredMinBid, 2) }}</span>
                                    </label>
                                    
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">€</span>
                                        <input type="number" name="amount" id="amount" 
                                               class="form-control @error('amount') is-invalid @enderror" 
                                               min="{{ $requiredMinBid }}" step="0.01" 
                                               value="{{ old('amount') }}"
                                               placeholder="{{ number_format($requiredMinBid, 2) }}" required>
                                        <button class="btn btn-primary px-4 fw-bold" type="submit">Bid</button>
                                        
                                        {{-- Erro Específico do Input (ex: Saldo Insuficiente) --}}
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </form>
                            @endif

                        @else
                            <div class="alert alert-secondary text-center border-0">
                                <h6 class="fw-bold mb-1">Auction Closed</h6>
                                <span class="badge bg-secondary">{{ $auction->status }}</span>
                            </div>
                        @endif

                    @else
                        <div class="alert alert-light text-center border">
                            <p class="mb-2 small">Want to place a bid?</p>
                            <a href="{{ route('login') }}" class="btn btn-dark btn-sm px-4">Login Now</a>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Bidding History --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3 border-bottom">
                    <i class="bi bi-clock-history me-2"></i> Bidding History
                </div>
                <div class="card-body p-0">
                    @if ($bids->isNotEmpty())
                        <ul class="list-group list-group-flush">
                            @if($buyNow)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 bg-success-subtle">
                                    <div>
                                        <span class="fw-bold text-dark">
                                            {{ $buyNow->buyer->name }}
                                        </span>
                                        <div class="text-muted small" style="font-size: 0.75rem;">
                                            {{ $buyNow->date?->format('M d, H:i') }}
                                        </div>
                                        <span class="badge bg-success mt-1">Buy Now</span>
                                    </div>
                                    <span class="fw-bold text-success">
                                        €{{ number_format($buyNow->amount, 2) }}
                                    </span>
                                </li>
                            @endif
                            @foreach ($bids as $bid)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 {{ (!$buyNow && $bids->currentPage() == 1 && $loop->first) ? 'bg-success bg-opacity-10' : '' }}">
                                    <div>
                                        <span class="fw-bold text-dark">
                                            {{ $bid->user->name }}
                                        </span>
                                        <div class="text-muted small" style="font-size: 0.75rem;">
                                            {{ $bid->date->format('M d, H:i') }}
                                        </div>
                                    </div>
                                    <span class="fw-bold
                                        {{ (!$buyNow && $bids->currentPage() == 1 && $loop->first) ? 'text-success' : 'text-dark' }}">
                                        €{{ number_format($bid->amount, 2) }}
                                    </span>
                                </li>
                            @endforeach

                        </ul>

                        @if($bids->hasPages())
                            <div class="p-3 d-flex justify-content-center">
                                {{ $bids->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-hourglass-split display-6 opacity-25 mb-2 d-block"></i>
                            <p class="mb-0 small">No bids yet. Be the first!</p>
                        </div>
                    @endif
                </div>
            </div>
            @can('create', [App\Models\Report::class, $auction])
                <div class="mt-4 pt-3 border-top text-center">
                    <a href="{{ route('report.create', ['auction_id' => $auction->id]) }}" 
                    class="text-danger text-decoration-none small fw-bold opacity-75">
                        <i class="fas fa-flag me-1"></i> Report this Auction
                    </a>
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection