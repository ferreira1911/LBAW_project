@extends('layouts.app')

@section('title', 'Edit Auction')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            {{-- Header with Back Button --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Edit Auction</h2>
                <a href="{{ route('auction.show', $auction) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Auction
                </a>
            </div>

            {{-- Edit Form Card --}}
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4">
                    <form action="{{ route('auction.update', $auction) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="file" class="form-label fw-bold">Change Auction Image</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept="image/*">
                            <div class="form-text">Leave empty to keep the current image.</div>
                            @error('file')
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
                        
                        <form method="POST" action="{{ route('auction.cancel', $auction) }}">
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