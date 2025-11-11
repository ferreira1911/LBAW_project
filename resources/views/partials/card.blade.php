<div class="auction-card {{ $auction->is_featured ? 'featured' : '' }}">
    
    @if ($auction->is_featured)
        <span class="badge featured-badge">Destaque</span>
    @endif

    {{-- Imagem --}}
    <a href="{{ route('auction.show', $auction) }}" class="auction-image-link">
        <div class="auction-image-placeholder">
            @if ($auction->picture)
                <img src="{{ asset('storage/' . $auction->picture) }}" alt="{{ $auction->title }}">
            @else
                <span>{{ $auction->category->name ?? 'Item' }}</span>
            @endif
        </div>
    </a>

    {{-- Conteúdo --}}
    <div class="auction-content">
        

        <h3 class="auction-title">
            <a href="{{ route('auction.show', $auction) }}">
                {{ Str::limit($auction->title, 40) }}
            </a>
        </h3>

        <div class="auction-stats">
            <div class="price-box">
                <span class="label">Preço Atual</span>
                <span class="price">{{ number_format($auction->current_price, 2) }} €</span>
            </div>
            <div class="bids-box">
                <span class="label">Licitações</span>
                <span class="value">{{ $auction->bids->count() }}</span>
            </div>
        </div>

        @php
            $isEndingSoon = $auction->end_date->diffInHours(now()) < 24;
        @endphp
        <div class="auction-timer {{ $isEndingSoon ? 'ending-soon' : '' }}">
            Termina em {{ $auction->end_date->diffForHumans(null, true, true) }}
        </div>
    </div>
</div>