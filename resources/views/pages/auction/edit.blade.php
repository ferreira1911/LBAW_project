@extends('layouts.app')

@section('title', 'Edit Auction')

@section('content')
<div class="container">
    <div class="page-header">
        <h2>Edit Auction</h2>
        <a href="{{ route('auction.show', $auction) }}" class="button button-secondary">Back to Auction</a>
    </div>

    @if ($auction->images->count())
        <div class="current-images" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1rem;">
            @foreach ($auction->images as $img)
                <div style="position: relative; display: inline-block; margin-right: 8px;">
                    <img src="{{ asset('images/auction/' . $img->path) }}" alt="Auction Image" height="100" style="border: 1px solid #ccc; border-radius: 4px; display:block;">
                    <form action="{{ route('auction.image.destroy', ['auction' => $auction->id, 'image' => $img->id]) }}" method="POST" style="margin-top:6px; text-align:center;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-danger" onclick="return confirm('Delete this image?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('auction.update', $auction) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $auction->title) }}" required>
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" required>{{ old('description', $auction->description) }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        

        {{-- Upload New Images --}}
        <div class="form-group">
            <label for="images">Upload New Images</label>
            <input type="file" name="images[]" id="images" multiple accept="image/*">
            <p><small>You can upload multiple images. Leave blank to keep existing ones.</small></p>
            @error('images.*')
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
