<div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
    
    <div class="position-relative bg-light" style="height: 220px;">
        @if ($auction->is_featured)
            <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2 shadow-sm z-2">
                <i class="bi bi-star-fill me-1"></i> Featured
            </span>
        @endif

        <a href="{{ route('auction.show', $auction) }}" class="d-flex align-items-center justify-content-center h-100 text-decoration-none text-secondary">
            @if ($auction->picture)
                <img src="{{ asset('storage/' . $auction->picture) }}" 
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
            <a href="{{ route('auction.show', $auction) }}" class="text-dark text-decoration-none stretched-link">
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
                @php
                    $isEndingSoon = $auction->end_date->diffInHours(now()) < 24;
                @endphp
                <div class="small {{ $isEndingSoon ? 'text-danger fw-bold' : 'text-muted' }}">
                    <i class="bi bi-clock me-1"></i> {{ $auction->end_date->diffForHumans(null, true, true) }}
                </div>
            </div>
        </div>
    </div>
</div>