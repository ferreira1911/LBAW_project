@if($auctions->count() > 0)
    @foreach($auctions as $auction)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-secondary" 
                             style="width: 80px; height: 80px; min-width: 80px;">
                            @if(isset($auction->images) && $auction->images->count() > 0)
                                <img src="{{ asset('images/auction/' . $auction->images->first()->path) }}" 
                                     alt="{{ $auction->title }}" 
                                     class="w-100 h-100 object-fit-cover rounded">
                            @else
                                <i class="bi bi-image fs-3"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-0 me-2">{{ $auction->title }}</h5>
                            
                            <div class="small text-muted mb-2">
                                Sold by: <span class="fw-bold text-dark">{{ $auction->owner->name }}</span>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <small class="text-muted d-block">Winning Bid</small>
                                    <span class="fw-bold text-success fs-5">€{{ number_format($auction->current_price, 2) }}</span>
                                </div>
                                <div class="vr" style="height: 30px;"></div>
                                <div>
                                    <small class="text-muted d-block">Ended</small>
                                    <span class="fw-bold text-dark">{{ $auction->end_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ms-3 d-flex flex-column">
                        <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye me-1"></i>View Details
                        </a>
                        @can('create', [App\Models\Review::class, $auction])
                            <a href="{{ route('reviews.create', $auction) }}" class="btn btn-outline-warning mt-2">
                                <i class="bi bi-star me-1"></i>Leave a Review
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    @if($auctions->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>
    @endif
@else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body text-center py-5">
            <i class="bi bi-trophy display-1 text-muted opacity-25 mb-3 d-block"></i>
            <h5 class="fw-bold mb-2">No Won Auctions Yet</h5>
            <p class="text-muted mb-4">You haven't won any auctions yet. Keep bidding!</p>
            <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                Browse Auctions
            </a>
        </div>
    </div>
@endif