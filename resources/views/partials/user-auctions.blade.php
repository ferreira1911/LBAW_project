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
                            <h5 class="fw-bold mb-0 me-2 text-dark">
                                {{ $auction->title }}
                                @if ($auction->is_featured)
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7em;">Featured</span>
                                @endif
                            </h5>
                            
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
                            
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <small class="text-muted d-block">Current Price</small>
                                    <span class="fw-bold text-primary fs-5">€{{ number_format($auction->current_price, 2) }}</span>
                                </div>
                                <div class="vr" style="height: 30px;"></div>
                                <div>
                                    <small class="text-muted d-block">Bids</small>
                                    <span class="fw-bold text-dark">{{ $auction->bids->count() }}</span>
                                </div>
                                <div class="vr" style="height: 30px;"></div>
                                <div>
                                    <small class="text-muted d-block">Ends</small>
                                    <span class="fw-bold text-dark">{{ $auction->end_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ms-3 d-flex flex-column" style="min-width: 140px;">
                        <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-eye me-1"></i>View Details
                        </a>

                        @if(Auth::check() && Auth::id() === $auction->owner_id && $auction->status !== 'Ended')
                            <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                        @endif
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
    {{-- Empty State (Consistent Style) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox display-4 opacity-25 mb-3 d-block"></i>
            <h5 class="fw-bold mb-2">No Auctions Yet</h5>
            <p class="text-muted mb-4">You haven't created any auctions yet.</p>
            <a href="{{ route('auctions.create') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                Create Auction
            </a>
        </div>
    </div>
@endif