@extends('layouts.app')

@section('title', $user->name . "'s Bidding History")

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 900px;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="fw-bold text-dark mb-0">{{ $user->name }}'s Bidding History</h1>
                <p class="text-muted mb-0">Track all your bids</p>
            </div>
        </div>
        @php
            $groupedBids = $bids->groupBy('auction_id');
        @endphp

        @if($groupedBids->count() > 0)
            @foreach($groupedBids as $auctionId => $auctionBids)
                @php
                    $auction = $auctionBids->first()->auction;
                    $isActive = in_array($auction->status, ['Active', 'Ending']);
                    $highestBid = $auctionBids->sortByDesc('amount')->first();
                    $isWinning = $highestBid->amount == $auction->current_price && $isActive;
                @endphp
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                    {{-- Auction Info --}}
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center flex-grow-1">
                                <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-secondary" style="width: 60px; height: 60px; min-width: 60px;">
                                    @if(isset($auction->images) && $auction->images->count() > 0)
                                        <img src="{{ $auction->images->first()->getUrl() }}" 
                                             alt="{{ $auction->title }}" 
                                             class="w-100 h-100 object-fit-cover rounded">
                                    @elseif($auction->picture)
                                        <img src="{{ asset('storage/' . $auction->picture) }}" 
                                             alt="{{ $auction->title }}" 
                                             class="w-100 h-100 object-fit-cover rounded">
                                    @else
                                        <i class="bi bi-image fs-4"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1">{{ $auction->title }}</h5>
                                    <div class="small text-muted">
                                        Current Price: <span class="fw-bold text-dark">€{{ number_format($auction->current_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-3">
                                <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>View Auction
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($auctionBids->sortByDesc('date') as $bid)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <span class="fw-bold text-primary fs-5">€{{ number_format($bid->amount, 2) }}</span>
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-clock me-1"></i>{{ $bid->date->format('d M Y, H:i') }}
                                            <span class="text-muted">• {{ $bid->date->diffForHumans() }}</span>
                                        </small>
                                    </div>
                                    @if($bid->amount == $auction->current_price)
                                        @if($isActive)
                                            <span class="badge bg-success">Current Highest</span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bi bi-trophy-fill me-1"></i>Won
                                            </span>
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
            {{-- Pagination --}}
            @if($bids->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $bids->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            {{-- Empty --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted opacity-25 mb-3 d-block"></i>
                    <h5 class="fw-bold mb-2">No Bidding History</h5>
                    <p class="text-muted mb-4">You haven't placed any bids yet.</p>
                    <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                        Browse Auctions
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection