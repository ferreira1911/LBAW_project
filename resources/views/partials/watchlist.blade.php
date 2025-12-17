@if($auctions->isNotEmpty())
    @foreach($auctions as $auction)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    
                    {{-- Image / Thumbnail --}}
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-secondary" 
                             style="width: 80px; height: 80px; min-width: 80px;">
                            @php $firstImg = $auction->images->first(); @endphp
                            @if ($firstImg)
                                <img src="{{ asset('images/auction/' . $firstImg->path) }}" 
                                     alt="{{ $auction->title }}" 
                                     class="w-100 h-100 object-fit-cover rounded">
                            @else
                                <div class="text-center opacity-50">
                                    <i class="bi bi-image fs-4"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1">
                                <h5 class="fw-bold mb-0 me-2 text-dark">
                                    {{ Str::limit($auction->title, 40) }}
                                </h5>

                                <span class="badge bg-light text-secondary border">{{ $auction->category->name ?? 'General' }}</span>
                            </div>

                            <div class="small text-muted mb-2">
                                Status: 
                                @php
                                    $statusClass = match($auction->status) {
                                        'Active' => 'text-success',
                                        'Ending' => 'text-danger', 
                                        default => 'text-secondary',
                                    };
                                @endphp
                                <span class="fw-bold {{ $statusClass }}">
                                    {{ $auction->status === 'Ending' ? 'Ending Soon' : $auction->status }}
                                </span>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <div>
                                    <small class="text-muted fw-bold" style="font-size: 0.7rem;">CURRENT PRICE</small>
                                    <div class="fw-bold text-primary">
                                        €{{ number_format($auction->current_price, 2) }}
                                    </div>
                                </div>
                                
                                <div class="vr" style="height: 30px;"></div>
                                
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">BIDS</small>
                                    <span class="fw-bold text-dark">
                                        {{ $auction->bids->count() }} <i class="bi bi-hammer ms-1"></i>
                                    </span>
                                </div>

                                <div class="vr" style="height: 30px;"></div>

                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">ENDS IN</small>
                                    <div class="auction-timer small text-muted fw-bold" 
                                         data-end="{{ $auction->end_date->toIso8601String() }}">
                                        <i class="far fa-clock me-1"></i>
                                        <span class="timer-text">{{ $auction->end_date->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ms-3 d-flex flex-column justify-content-center" style="min-width: 120px;">
                        <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-primary w-100">
                            View
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body text-center py-5">
            <div class="mb-3 text-muted opacity-25">
                <i class="bi bi-heartbreak display-1"></i>
            </div>
            <h5 class="fw-bold text-secondary">Your watchlist is empty.</h5>
            <p class="text-muted mb-4">Start following auctions to track them here.</p>
            <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                Browse Auctions
            </a>
        </div>
    </div>
@endif