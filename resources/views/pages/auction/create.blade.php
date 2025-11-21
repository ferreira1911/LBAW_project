@extends('layouts.app')

@section('title', 'Create Auction')

@section('content')
<div class="container">
    <div class="page-header">
        <h2>Create a New Auction</h2>
        <a href="{{ route('auctions.index') }}" class="button button-secondary">Back to Auctions</a>
    </div>

    <form action="{{ route('auction.store') }}" method="POST" class="auction-form" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
            @error('start_date')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
            @error('end_date')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="starting_price">Starting Price</label>
            <input type="number" name="starting_price" id="starting_price" step="0.01" value="{{ old('starting_price') }}" required>
            @error('starting_price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="file">Auction Image</label>
            <input type="file" name="file" id="file" accept="image/*">
        </div>

        <button type="submit" class="button button-primary">Create Auction</button>
    </form>
</div>
@endsection
