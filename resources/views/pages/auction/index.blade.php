@extends('layouts.app')

@section('title', 'Leilões')

@section('content')

<div class="container-fluid py-4">

    <div class="row">

        {{-- Sidebar --}}
        <aside class="col-12 col-md-3 mb-4">
            <div class="card shadow-sm p-3">

                <h5 class="mb-3 d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="me-2">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                    </svg>
                    Filtros
                </h5>

                <form method="GET" action="{{ route('auctions.search') }}" id="filter-form">
                    @include('partials.filters', ['categories' => $categories])
                </form>
            </div>
        </aside>


        {{-- Main Content --}}
        <section class="col-12 col-md-9">

            {{-- Card grid --}}
            <div class="row g-3">
                @forelse($auctions as $auction)
                    <div class="col-12 col-sm-6 col-lg-4">
                        @include('partials.card', ['auction' => $auction])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-secondary text-center py-4">
                            <p class="mb-2">Não foram encontrados leilões que correspondam aos seus filtros.</p>
                            <a href="{{ route('auctions.index') }}" class="btn btn-outline-primary">
                                Limpar filtros
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $auctions->appends(request()->query())->links() }}
            </div>

        </section>
    </div>
</div>

@endsection
