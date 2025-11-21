@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Search Results for "' . $searchQuery . '"')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="mb-5 border-bottom pb-3">
        <h1 class="h2 fw-bold text-dark mb-2">
            @if ($searchQuery)
                Results for "<span class="text-primary">{{ $searchQuery }}</span>"
            @else
                All Results
            @endif
        </h1>
        <p class="text-muted mb-0">
            We found {{ $auctions->total() }} {{ Str::plural('auction', $auctions->total()) }} matching your search.
        </p>
    </div>

    <div class="row">
        {{-- Sidebar (Filters) --}}
        <aside class="col-lg-3 mb-5 mb-lg-0">
            {{-- Reutilizamos o partial de filtros, que já deve ter a estrutura correta --}}
            @include('partials.filters', ['categories' => $categories])
        </aside>

        {{-- Results Grid --}}
        <section class="col-lg-9">
            <div class="row g-3">
                @forelse ($auctions as $auction)
                    <div class="col-12 col-sm-6 col-lg-4">
                        @include('partials.card', ['auction' => $auction])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 bg-white shadow-sm border rounded">
                            <i class="bi bi-search display-1 text-muted opacity-25 mb-3"></i>
                            <h3 class="fw-bold">No results found</h3>
                            <p class="text-muted col-md-8 mx-auto mb-4">
                                We couldn't find any auctions matching "<strong>{{ $searchQuery }}</strong>".<br>
                                Try checking for typos or using more general keywords.
                            </p>
                            <a href="{{ route('auctions.index') }}" class="btn btn-outline-primary px-4">
                                <i class="bi bi-arrow-left me-2"></i>Clear Search
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $auctions->appends(request()->query())->links() }}
            </div>
        </section>
    </div>
</div>
@endsection