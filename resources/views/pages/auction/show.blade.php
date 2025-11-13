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

    @auth
        @if ($auction->status === 'Active' && $auction->owner_id !== Auth::id())
            <div class="mt-4 p-4 border rounded-lg shadow-sm">
                <h3 class="text-lg font-bold mb-3">Place Your Bid</h3>
                <form method="POST" action="{{ route('auction.bid', $auction) }}">
                    @csrf
                    <div class="form-group">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Bid Amount (€)</label>
                        @php
                            $highestBid = $bids->max('amount') ?? $auction->starting_price;
                            $minIncrement = $auction->starting_price * 0.10;
                            $requiredMinBid = $highestBid + $minIncrement;
                        @endphp
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm"> € </span>
                            </div>
                            <input type="number" name="amount" id="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" 
                                   min="{{ $requiredMinBid }}" step="0.01" 
                                   placeholder="{{ number_format($requiredMinBid, 2) }}" required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Minimum bid is €{{ number_format($requiredMinBid, 2) }}</p>
                    </div>
                    <button type="submit" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Place Bid
                    </button>
                </form>
                
                @if ($errors->any())
                    <div class="mt-3 text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="mt-3 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        @endif
    @endauth

    <div class="mt-6">
        <h3 class="text-xl font-bold mb-4">Bidding History</h3>

        @if ($bids->isNotEmpty())
            <ul class="space-y-4">
                @foreach ($bids as $bid)
                    <li class="flex justify-between items-center p-3 bg-gray-100 rounded-lg">
                        <div>
                            <p class="font-semibold text-gray-800">
                                <a href="{{ route('user.show', $bid->user) }}" class="hover:underline">{{ $bid->user->name }}</a>
                            </p>
                            <p class="text-sm text-gray-500">

                                {{ $bid->date->format('F j, Y \a\t H:i') }}
                            </p>
                        </div>
                        <div class="text-lg font-bold text-gray-900">
                            €{{ number_format($bid->amount, 2) }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="p-4 text-center bg-gray-50 rounded-lg">
                <p class="text-gray-600">No bids have been placed yet. Be the first to bid!</p>
            </div>
        @endif
    </div>

</div>
@endsection
