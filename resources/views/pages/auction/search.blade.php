@extends('layouts.app')
@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Resultados para "' . $searchQuery . '"')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 150px);">
    <div class="container py-4">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pesquisa</li>
            </ol>
        </nav>

        {{-- Cabeçalho --}}
        <div class="mb-5 border-bottom pb-3">
            <h1 class="h2 fw-bold text-dark mb-2">
                @if ($searchQuery)
                    Resultados para "<span class="text-primary">{{ $searchQuery }}</span>"
                @endif
            </h1>
            <p class="text-muted mb-0">
                Encontrámos {{ $auctions->total() }} {{ Str::plural('leilão', $auctions->total()) }} para a sua pesquisa.
            </p>
        </div>

        <div class="row">
            {{-- Filtros --}}
            <div class="col-lg-3 mb-5 mb-lg-0">
                @include('partials.filters', ['categories' => $categories])
            </div>

            {{-- Resultados --}}
            <div class="col-lg-9">
                <div class="auction-grid">
                    @forelse ($auctions as $auction)
                        @include('partials.card', ['auction' => $auction])
                    @empty
                        <div class="text-center py-5 bg-white shadow-sm rounded-0">
                            <i class="fas fa-search fa-4x text-muted opacity-25 mb-4"></i>
                            <h3 class="fw-bold">Ups, não encontrámos nada.</h3>
                            <p class="text-muted col-md-6 mx-auto mb-4">
                                Não existem resultados para "<strong>{{ $searchQuery }}</strong>".<br>
                                Tente verificar a ortografia ou usar termos mais genéricos.
                            </p>
                            <a href="{{ route('auctions.index') }}" class="btn btn-outline-primary rounded-0 px-4">
                                Voltar à Home Page
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Paginação --}}
                <div class="d-flex justify-content-center mt-5">
                    {{ $auctions->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
