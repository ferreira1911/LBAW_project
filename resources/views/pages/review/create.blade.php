@extends('layouts.app')

@section('title', 'Leave a Review')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-dark">Leave a Review</h2>
                            <p class="text-muted">Share your experience with <strong>{{ $auction->title }}</strong></p>
                        </div>
                        <form action="{{ route('reviews.store', $auction) }}" method="POST" id="reviewForm">
                            @csrf
                            {{-- Rating --}}
                            <div class="mb-4 text-center">
                                <label class="form-label fw-bold text-dark small text-uppercase ls-1">
                                    Rating <span class="text-danger">*</span>
                                </label>
                                <div id="starRating" class="d-flex justify-content-center mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star fs-2 mx-1 star" data-value="{{ $i }}" style="cursor: pointer;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                                @error('rating')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @else
                                    <div id="ratingError" class="text-danger small mt-2" style="display: none;">
                                        Please select a rating
                                    </div>
                                @enderror
                            </div>
                            {{-- Description --}}
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold text-dark small text-uppercase ls-1">Review</label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="5" 
                                    class="form-control bg-white border-secondary-subtle rounded-3 @error('description') is-invalid @enderror" 
                                    placeholder="Share your experience with this auction..." 
                                    required 
                                    autofocus
                                >{{ old('description') }}</textarea>
                                
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                    Submit Review
                                </button>
                                <a href="{{ route('auctions.show', $auction) }}" class="btn btn-link text-muted text-decoration-none text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- Review Scripts --}}
@push('scripts')
    <script src="{{ asset('js/review.js') }}" defer></script>
@endpush
@endsection