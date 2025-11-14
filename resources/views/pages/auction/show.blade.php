@extends('layouts.app')

@section('title', $auction->title)

@section('content')
<div class="container">
    <div class="page-header">
        <h2>{{ $auction->title }}</h2>
        <p>Category: {{ $auction->category->name }}</p>
        <p>Owner: {{ $auction->owner->name }}</p>
        <p>Start Date: {{ $auction->start_date->format('Y-m-d H:i') }}</p>
        <p>End Date: {{ $auction->end_date->format('Y-m-d H:i') }}</p>
    </div>

    <div class="auction-details">
        <p>{{ $auction->description }}</p>
        <p>
            Current Price: <strong>${{ number_format($auction->current_price ?? $auction->starting_price, 2) }}</strong>
        </p>
        @if($auction->is_buy_now_active && $auction->buy_now_price)
            <p>Buy Now Price: <strong>${{ number_format($auction->buy_now_price, 2) }}</strong></p>
        @endif
    </div>
    
    {{--
    @if ($auction->images->count())
    <div class="auction-gallery" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        @foreach ($auction->images as $image)
        <img src="{{ $image->getUrl() }}" 
            alt="{{ $auction->title }}" 
            style="width: 150px; border-radius: 8px; object-fit: cover;">
        @endforeach
    </div>
    @else
    <p>No images available.</p>
    @endif --}}

    <div class="bids-section">
        <h3>Bids</h3>
        @if($bids->count())
            <ul>
                @foreach($bids as $bid)
                    <li>{{ $bid->user->name }}: ${{ number_format($bid->amount, 2) }}</li>
                @endforeach
            </ul>
        @else
            <p>No bids yet. Be the first!</p>
        @endif
    </div>

</div>
@endsection
