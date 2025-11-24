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
                    {{-- Single Image / Fallback Logic --}}
                    <div class="bg-light d-flex align-items-center justify-content-center rounded overflow-hidden" style="height: 400px;">
                        @if ($auction->picture)
                            <img src="{{ asset('storage/' . $auction->picture) }}" class="d-block w-100 h-100 object-fit-cover" alt="{{ $auction->title }}">
                        @else
                            <div class="text-center text-muted">
                                <i class="bi bi-image display-1"></i>
                                <p class="mt-2">No image available</p>
                            </div>
                        @endif
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
                            Hosted by <a href="{{ route('users.show', $auction->owner) }}" class="text-decoration-none fw-bold">{{ $auction->owner->name }}</a>
                        </p>
                    </div>

                    {{-- Price Section --}}
                    <div class="mb-4 p-3 bg-light rounded">
                        <p class="text-muted mb-1 text-uppercase small fw-bold">Current Price</p>
                        <h2 class="display-6 fw-bold text-primary mb-0">
                            €{{ number_format($auction->current_price ?? $auction->starting_price, 2) }}
                        </h2>
                    </div>´

                    <div class="text-end auction-timer" data-end="{{ $auction->end_date->toIso8601String() }}">
                        <p class="text-muted mb-0 text-uppercase small fw-bold">
                            <i class="bi bi-stopwatch"></i> Time Left
                        </p>
                        <div class="fs-5 fw-bold timer-text text-dark">
                            {{ $auction->end_date->diffForHumans() }}
                        </div>
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

                    {{-- Bidding Section --}}
                    @auth
                        {{-- Logic Variables --}}
                        @php
                            $highestBidRecord = $bids->first(); 
                            $highestBidAmount = $highestBidRecord ? $highestBidRecord->amount : $auction->starting_price;
                            
                            // Regra: 10% do valor INICIAL + Valor Atual (como pediste)
                            $fixedIncrement = $auction->starting_price * 0.10;
                            $requiredMinBid = $highestBidAmount + $fixedIncrement;
                            
                            // Verifica se é o vencedor atual
                            $isHighestBidder = $highestBidRecord && (int)$highestBidRecord->user_id === (int)Auth::id();
                        @endphp

                        @if ($auction->status === 'Active')
                            
                            @if($auction->owner_id === Auth::id())
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
                            @foreach ($bids as $bid)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 {{ $loop->first ? 'bg-success-subtle' : '' }}">
                                    <div class="d-flex align-items-center">
                                        @if($loop->first)
                                            <span class="badge bg-success me-2" title="Current Winner"><i class="bi bi-trophy-fill"></i></span>
                                        @endif
                                        <div>
                                            <a href="{{ route('users.show', $bid->user) }}" class="fw-bold text-decoration-none text-dark">
                                                {{ $bid->user->name }}
                                            </a>
                                            <div class="text-muted small" style="font-size: 0.75rem;">{{ $bid->date->format('M d, H:i') }}</div>
                                        </div>
                                    </div>
                                    <span class="fw-bold {{ $loop->first ? 'text-success' : 'text-dark' }}">
                                        €{{ number_format($bid->amount, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-hourglass-split display-6 opacity-25 mb-2 d-block"></i>
                            <p class="mb-0 small">No bids yet. Be the first!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection