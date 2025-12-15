@extends('layouts.app')

@section('title', $seller->name . "'s Reviews")

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 900px;">
        
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div class="mb-3 mb-md-0">
                <h1 class="fw-bold text-dark mb-1">{{ $seller->name }}'s Reviews</h1>
                <div class="d-flex flex-wrap align-items-center gap-2 small text-muted">
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-star-fill me-1"></i>
                        {{ number_format($averageRating, 1) }} / 5.0
                    </span>
                    <span>
                        {{ $reviews->total() }} {{ Str::plural('review', $reviews->total()) }}
                    </span>
                </div>
            </div>
        </div>
        @if($reviews->count() > 0)
            @foreach($reviews as $review)
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="text-warning fs-5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <span class="text-muted ms-2 fs-6">{{ number_format($review->rating, 1) }} / 5.0</span>
                            </div>
                        </div>
                        @if($review->description)
                            <p class="text-secondary mb-4">{{ $review->description }}</p>
                        @else
                            <p class="text-muted fst-italic mb-4">No review text provided.</p>
                        @endif
                        <div class="pb-3 mb-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-secondary" 
                                         style="width: 60px; height: 60px; min-width: 60px;">
                                        @if(isset($review->auction->images) && $review->auction->images->count() > 0)
                                            <img src="{{ $review->auction->images->first()->getUrl() }}" 
                                                 alt="{{ $review->auction->title }}" 
                                                 class="w-100 h-100 object-fit-cover rounded">
                                        @elseif($review->auction->picture)
                                            <img src="{{ asset('storage/' . $review->auction->picture) }}" 
                                                 alt="{{ $review->auction->title }}" 
                                                 class="w-100 h-100 object-fit-cover rounded">
                                        @else
                                            <i class="bi bi-image fs-4"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $review->auction->title }}</h6>
                                    </div>
                                </div>
                                <a href="{{ route('auctions.show', $review->auction) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                @if($review->user->url)
                                    <img src="{{ $review->user->getProfileImage() }}"
                                        alt="{{ $review->user->name }}"
                                        class="rounded-circle me-3 object-fit-cover"
                                        style="width: 40px; height: 40px;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('users.show', $review->user) }}" 
                                       class="fw-bold text-dark text-decoration-none hover-underline">
                                        {{ $review->user->name }}
                                    </a>
                                    <div class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $review->created_date->format('d M Y') }}
                                        <span class="text-muted">• {{ $review->created_date->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- Pagination --}}
            @if($reviews->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $reviews->appends(['seller_id' => $seller->id])->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body text-center py-5">
                    <i class="bi bi-star display-1 text-muted opacity-25 mb-3 d-block"></i>
                    <h5 class="fw-bold mb-2">No Reviews Yet</h5>
                    <p class="text-muted mb-4">{{ $seller->name }} hasn't received any reviews yet.</p>
                    <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                        Browse Auctions
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection