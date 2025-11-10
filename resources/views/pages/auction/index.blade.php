@extends('layouts.app')

@section('title', 'Leilões Ativos')

@section('content')
<div class="bg-light py-5">
    <div class="container py-4">

        {{-- Cabeçalho e Ações --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h1 class="fw-bold text-dark mb-0">Leilões Ativos</h1>
                <p class="text-muted mb-0">Explore e licite nos itens mais recentes.</p>
            </div>
            @auth
                <a href="{{ route('auction.create') }}" class="btn btn-primary btn-lg px-4 d-flex align-items-center gap-2 shadow-sm rounded-0">
                    <i class="fas fa-plus"></i>
                    <span>Criar Leilão</span>
                </a>
            @endauth
        </div>

        {{-- BARRA DE PESQUISA --}}
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <form action="{{ route('auctions.search') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm rounded-0 overflow-hidden">
                        <span class="input-group-text bg-white border-0 ps-4">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="query" class="form-control border-0 ps-3 py-3" 
                               placeholder="O que procura hoje?" 
                               aria-label="Pesquisar" required>
                        <button class="btn btn-primary px-4 fw-bold rounded-0" type="submit">
                            PESQUISAR
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Flexbox Grid de Leilões --}}
        <div class="d-flex flex-wrap gap-4 justify-content-center justify-content-md-start">
            @forelse ($auctions as $auction)
                <div class="flex-grow-1" style="flex-basis: 300px; max-width: 450px;">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden auction-card-hover rounded-0">
                        
                        <div class="position-relative" style="height: 250px; background-color: #f8f9fa;">
                            @if ($auction->is_featured)
                                <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-3 shadow-sm z-2 rounded-0">
                                    <i class="fas fa-star me-1"></i> Destaque
                                </span>
                            @endif

                            <a href="{{ route('auction.show', $auction) }}" class="d-flex align-items-center justify-content-center h-100 text-decoration-none text-muted">
                                @if ($auction->picture)
                                    <img src="{{ asset('storage/' . $auction->picture) }}" alt="{{ $auction->title }}" class="w-100 h-100 object-fit-cover">
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

                            <h4 class="card-title fw-bold mb-3 fs-5">
                                <a href="{{ route('auction.show', $auction) }}" class="text-dark text-decoration-none stretched-link">
                                    {{ Str::limit($auction->title, 45) }}
                                </a>
                            </h4>

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
                </div>
            @empty
                <div class="w-100">
                    <div class="text-center py-5 px-4 bg-white shadow-sm rounded-0">
                        <i class="fas fa-search fa-4x text-muted opacity-25 mb-4"></i>
                        <h3 class="fw-bold text-dark">Não encontrámos leilões ativos.</h3>
                        <p class="text-muted col-md-6 mx-auto mb-4">
                            Parece que não há nada a decorrer neste momento.
                        </p>
                        @auth
                            <a href="{{ route('auction.create') }}" class="btn btn-primary btn-lg px-5 rounded-0">
                                Criar o Primeiro Leilão
                            </a>
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .auction-card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .auction-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.15)!important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .ls-1 { letter-spacing: 1px; }
</style>
@endpush