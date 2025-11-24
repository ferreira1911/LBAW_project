@extends('layouts.app')

@section('title', 'Edit Auction')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            {{-- Header with Back Button --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Edit Auction</h2>
                <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Auction
                </a>
            </div>

            {{-- Edit Form Card --}}
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4">

                    @if ($auction->images->count())
                        <div class="mb-4">
                            <label class="form-label fw-bold">Current Images</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($auction->images as $img)
                                    <div class="card border shadow-sm" style="width: 120px;">
                                        <img src="{{ asset('images/auction/' . $img->path) }}" class="card-img-top object-fit-cover" height="100" alt="Auction Image">
                                        <div class="card-body p-2 text-center bg-light">
                                            <form action="{{ route('auctions.images.destroy', ['auction' => $auction->id, 'image' => $img->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Delete this image?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('auctions.update', $auction) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $auction->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $auction->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-4">
                            <label for="images" class="form-label fw-bold">Upload New Images</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                            <div class="form-text">You can select multiple images to add to the gallery.</div>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Update Auction
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone (Cancel Auction) --}}
            @can('cancel', $auction)
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Danger Zone
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title text-danger">Cancel Auction</h5>
                        <p class="card-text text-muted">
                            This action cannot be undone. The auction will be permanently cancelled.
                            <br>
                            <small class="text-dark fw-bold">Note: You can only perform this action because this auction has received no bids yet.</small>
                        </p>
                        
                        <form method="POST" action="{{ route('auctions.cancel', $auction) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to cancel this auction? This action is irreversible.')">
                                Cancel Auction
                            </button>
                        </form>
                    </div>
                </div>
            @endcan

        </div>
    </div>
</div>
@endsection