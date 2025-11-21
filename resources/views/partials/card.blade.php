<div class="card h-100 shadow-sm border-0 rounded-0 auction-card-hover {{ $auction->is_featured ? 'border-warning' : '' }}">
    
    <div class="position-relative">
        @if (Auth::check() && Auth::id() === $auction->owner_id)
            <a href="{{ route('auction.edit', $auction) }}" 
            class="position-absolute top-0 end-0 btn btn-warning m-3"
            style="z-index: 10; font-size: 0.9rem; padding: 0.5rem 0.8rem;">
            Edit Auction
            </a>
        @elseif (($showFeatured ?? true) && $auction->is_featured)
            <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-3">
                <i class="fas fa-star"></i> Destaque
            </span>
        @endif


        <a href="{{ route('auction.show', $auction) }}" class="d-flex align-items-center justify-content-center h-100 text-decoration-none text-muted" style="height: 220px; background-color: #f8f9fa;">
            @php $firstImg = $auction->images->first(); @endphp
            @if ($firstImg)
                <img src="{{ asset('images/auction/' . $firstImg->path) }}" alt="{{ $auction->title }}" class="w-100 h-100 object-fit-cover">
            @else
                <div class="text-center opacity-50">
                    <i class="fas fa-image fa-3x mb-2"></i>
                    <div class="small fw-bold text-uppercase ls-1">{{ $auction->category->name ?? 'Item' }}</div>
                </div>
            @endif
        </a>
    </div>


    <div class="card-body d-flex flex-column p-4">
        
        <div class="mb-2">
            <span class="badge bg-light text-secondary border rounded-0">{{ $auction->category->name ?? 'Geral' }}</span>
        </div>

        <h5 class="card-title fw-bold mb-3 fs-5">
            <a href="{{ route('auction.show', $auction) }}" class="text-dark text-decoration-none stretched-link">
                {{ Str::limit($auction->title, 45) }}
            </a>
        </h5>

        <p class="card-text text-muted small mb-4 flex-grow-1">
            {{ Str::limit($auction->description, 80) }}
        </p>

        <div class="d-flex justify-content-between align-items-end border-top pt-3 mt-auto">
            <div>
                <small class="text-muted fw-bold" style="font-size: 0.75rem;">LICITAÇÃO ATUAL</small>
                <div class="fs-4 fw-bolder text-primary">
                    {{ number_format($auction->current_price, 2) }} €
                </div>
            </div>
            <div class="text-end">
                <div class="badge bg-primary-subtle text-primary mb-1 rounded-0">
                    {{ $auction->bids->count() }} <i class="fas fa-gavel ms-1"></i>
                </div>
                @php
                    $isEndingSoon = $auction->end_date->diffInHours(now()) < 24;
                @endphp
                <div class="small {{ $isEndingSoon ? 'text-danger fw-bold' : 'text-muted' }}">
                    <i class="far fa-clock me-1"></i> {{ $auction->end_date->diffForHumans(null, true, true) }}
                </div>
            </div>
        </div>
    </div>
</div>