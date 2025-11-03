@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="container">
    
    
    <div class="page-header">
        <h2>Active Auctions</h2>
        @auth
            <a href="{{ route('auctions.create') }}" class="button button-primary">Create Auction</a>
        @endauth
    </div>

    
    <div class="auction-grid">
        @forelse ($auctions as $auction)
            {{-- This is the auction card component --}}
            <div class="auction-card {{ $auction->is_featured ? 'featured' : '' }}">
                
                @if ($auction->is_featured)
                    <span class="featured-badge">Featured</span>
                @endif
                
                <h3>
                    {{-- Link to the single auction page --}}
                    <a href="{{ route('auctions.show', $auction) }}">
                        {{ $auction->title }}
                    </a>
                </h3>
                
                <div class="auction-details">
                    <p class="price">
                        Current Price: <strong>${{ number_format($auction->current_price, 2) }}</strong>
                    </p>
                </div>
            </div>
        @empty
            <div class="no-auctions">
                <p>No active auctions right now. Check back soon!</p>
                @auth
                    <p>Why not <a href="{{ route('auctions.create') }}">create one</a>?</p>
                @endauth
            </div>
        @endforelse
    </div>
</div>
@endsection