@extends('layouts.app')

@section('title', 'Edit Auction')

@section('content')
<div class="container">
    <div class="page-header">
        <h2>Edit Auction</h2>
        <a href="{{ route('auction.show', $auction) }}" class="button button-secondary">Back to Auction</a>
    </div>

    <form action="{{ route('auction.update', $auction) }}" method="POST" class="auction-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $auction->title) }}" required>
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" required>{{ old('description', $auction->description) }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="button button-primary">Update Auction</button>
    </form>

    <hr style="margin-top: 2rem; margin-bottom: 2rem;">

    @can('cancel', $auction)
        <div>
            <h3>Cancel Auction</h3>
            <p>This action cannot be undone. The auction will be permanently cancelled.</p>
            <form method="POST" action="{{ route('auction.cancel', $auction) }}">
                @csrf
                <button type="submit" class="button button-danger" 
                        onclick="return confirm('Are you sure you want to cancel this auction?')">
                    Cancel Auction
                </button>
            </form>
        </div>
    @endcan
</div>
@endsection
