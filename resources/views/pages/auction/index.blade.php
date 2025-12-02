@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-light py-5">
    <div class="container">

        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 pb-4 border-bottom gap-3">
            <div>
                <h1 class="fw-bold text-dark mb-1">Welcome to AuctionEase</h1>
                <p class="text-muted mb-0">Discover unique items and place your bids today.</p>
            </div>
            
            <div class="d-flex gap-2">
                
                <a href="{{ route('auctions.search') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                    <i class="fas fa-th-large me-2"></i> Browse Auctions
                </a>
                
                @auth
                    <a href="{{ route('auctions.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus me-2"></i> Create Auction
                    </a>
                @endauth
            </div>
        </div>


        @auth
            @if($myActiveBids->isNotEmpty())
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <h3 class="fw-bold text-dark m-0">My Active Bids</h3>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach($myActiveBids as $auction)
                            <div class="col">
                                
                                @include('partials.card', ['auction' => $auction])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endauth

        
        <div class="mb-4">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="fw-bold text-dark m-0">Featured Auctions</h3>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @forelse($featuredAuctions as $auction)
                    <div class="col">
                        @include('partials.card', ['auction' => $auction])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                            <i class="fas fa-search fa-3x text-muted opacity-25 mb-3"></i>
                            <h5 class="fw-bold text-secondary">No featured auctions right now.</h5>
                            <p class="text-muted">Check back later or browse our full catalog.</p>
                            <a href="{{ route('auctions.search') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                                Browse All
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $featuredAuctions->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>
@endsection