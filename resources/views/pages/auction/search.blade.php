@extends('layouts.app')

@section('title', 'Resultados para "' . $searchQuery . '"')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 150px);"> {{-- Garante altura mínima --}}
    <div class="container py-4">

        {{-- Navegação Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pesquisa</li>
            </ol>
        </nav>

        {{-- Cabeçalho de Resultados --}}
        <div class="mb-5 border-bottom pb-3">
            <h1 class="h2 fw-bold text-dark mb-2">
                Resultados para "<span class="text-primary">{{ $searchQuery }}</span>"
            </h1>
            <p class="text-muted mb-0">
                Encontrámos {{ $auctions->total() }} {{ Str::plural('leilão', $auctions->total()) }} para a sua pesquisa.
            </p>
        </div>

        {{-- Grelha de Resultados (Mesmo estilo da Home para consistência) --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-5">
            @forelse ($auctions as $auction)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden auction-card-hover rounded-0">
                        {{-- Imagem --}}
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
                        {{-- Corpo --}}
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
                                    <div class="fs-4 fw-bolder text-primary">{{ number_format($auction->current_price, 2) }} €</div>
                                </div>
                                <div class="text-end">
                                    <div class="badge bg-primary-subtle text-primary mb-1 rounded-0">
                                        {{ $auction->bids->count() }} <i class="fas fa-gavel ms-1"></i>
                                    </div>
                                    <div class="small text-muted">
                                        <i class="far fa-clock me-1"></i> {{ $auction->end_date->diffForHumans(null, true, true) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Estado Vazio Específico para Pesquisa --}}
                <div class="col-12">
                    <div class="text-center py-5 bg-white shadow-sm rounded-0">
                        <i class="fas fa-search fa-4x text-muted opacity-25 mb-4"></i>
                        <h3 class="fw-bold">Ups, não encontrámos nada.</h3>
                        <p class="text-muted col-md-6 mx-auto mb-4">
                            Não existem resultados para "<strong>{{ $searchQuery }}</strong>".<br>
                            Tente verificar a ortografia ou usar termos mais genéricos.
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-0 px-4">
                            Voltar à Home Page
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginação --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
@endsection
