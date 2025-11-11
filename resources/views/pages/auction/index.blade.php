@extends('layouts.app')

@section('title', 'Leilões')

@section('content')
<div class="main-page">
    
    <aside class="sidebar">
        <form method="GET" action="{{ route('auctions.search') }}" id="filter-form">
            @include('partials.filters', ['categories' => $categories])
        </form>
    </aside>

    <a href="{{ route('auction.create') }}">Criar um Leilão</a>
    
    <section class="cards-container">
        {{-- Grelha de Cartões --}}
        <div class="all-cards">
            @forelse($auctions as $auction)
                @include('partials.card', ['auction' => $auction])
            @empty
                <div class="no-results">
                    <p>Não foram encontrados leilões que correspondam aos seus filtros.</p>
                    <a href="{{ route('auctions.index') }}" class="button">Limpar filtros</a>
                </div>
            @endforelse
        </div>

        {{-- Paginação --}}
        <div class="pagination-links">
            {{ $auctions->appends(request()->query())->links() }}
        </div>
    </section>

</div>
@endsection
