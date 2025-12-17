@if($myActiveBids->isNotEmpty())
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($myActiveBids as $auction)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                    {{-- Image / Thumbnail --}}
                    <div class="position-relative bg-light" style="height: 220px;">
                        <a href="{{ route('auctions.show', $auction) }}" class="d-flex align-items-center justify-content-center h-100 text-decoration-none text-secondary">
                            @php $firstImg = $auction->images->first(); @endphp
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

                    {{-- Body --}}
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
                                <small class="text-muted fw-bold" style="font-size: 0.7rem;">CURRENT PRICE</small>
                                <div class="fs-5 fw-bold text-primary">
                                    €{{ number_format($auction->current_price, 2) }}
                                </div>
                                @php
                                    // Get the user's bid on this auction
                                    $userBid = $auction->bids->where('user_id', auth()->id())->max('amount');
                                @endphp
                                <small class="text-muted d-block mt-1">
                                    Your Bid: €{{ number_format($userBid ?? 0, 2) }}
                                    @if($userBid == $auction->current_price)
                                        <span class="text-success fw-bold">(Highest)</span>
                                    @else
                                        <span class="text-danger fw-bold">(Outbid)</span>
                                    @endif
                                </small>
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
        @endforeach
    </div>
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox display-4 opacity-25 mb-2 d-block"></i>
        <h5 class="fw-bold text-secondary">No Active Bids</h5>
        <p class="mb-0">You haven't placed any active bids yet.</p>
        <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold mt-3">
            Browse Auctions
        </a>
    </div>
@endif
