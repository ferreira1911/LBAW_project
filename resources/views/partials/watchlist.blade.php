<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse ($auctions as $auction)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                <div class="position-relative bg-light" style="height: 220px;">
                    @if (($showFeatured ?? true) && $auction->is_featured)
                        <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2 shadow-sm z-2">
                            <i class="bi bi-star-fill me-1"></i> Featured
                        </span>
                    @endif

                    <a href="{{ route('auctions.show', $auction) }}" class="d-flex align-items-center justify-content-center h-100 text-decoration-none text-secondary">
                        @php
                            $firstImg = $auction->images->first(); 
                        @endphp

                        @if ($firstImg)
                            <img src="{{ asset('images/auction/' . $firstImg->path) }}" 
                                 alt="{{ $auction->title }}" 
                                 class="w-100 h-100 object-fit-cover rounded-top">
                        @else
                            <div class="text-center opacity-50">
                                <i class="bi bi-image display-4 mb-2"></i>
                                <div class="small fw-bold text-uppercase">{{ $auction->category->name ?? 'Item' }}</div>
                            </div>
                        @endif
                    </a>
                </div>

                <div class="card-body d-flex flex-column p-3">
                    <div class="mb-2">
                        <span class="badge bg-light text-secondary border">{{ $auction->category->name ?? 'General' }}</span>
                    </div>

                    <h5 class="card-title fw-bold mb-2 text-truncate">
                        <a href="{{ route('auctions.show', $auction) }}" class="text-dark text-decoration-none stretched-link">
                            {{ Str::limit($auction->title, 40) }}
                        </a>
                    </h5>

                    <p class="card-text text-muted small mb-3 flex-grow-1">
                        {{ Str::limit($auction->description, 80) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-end border-top pt-3 mt-auto">
                        <div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem;">CURRENT BID</small>
                            <div class="fs-5 fw-bold text-primary">
                                €{{ number_format($auction->current_price, 2) }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-primary-subtle text-primary mb-1">
                                {{ $auction->bids->count() }} <i class="bi bi-hammer ms-1"></i>
                            </div>
                            <div class="auction-timer small text-muted" 
                                data-end="{{ $auction->end_date->toIso8601String() }}">
                                <i class="far fa-clock me-1"></i>
                                <span class="timer-text">{{ $auction->end_date->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5 bg-white shadow-sm rounded-4">
                <div class="mb-3 text-muted opacity-25">
                    <i class="bi bi-heartbreak display-1"></i>
                </div>
                <h4 class="fw-bold text-secondary">Your watchlist is empty.</h4>
                <p class="text-muted mb-4">Start following auctions to track them here.</p>
                <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                    Browse Auctions
                </a>
            </div>
        </div>
    @endforelse
</div>

@if($auctions->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $auctions->links('pagination::bootstrap-5') }}
    </div>
@endif