@extends('layouts.app')

@section('title', 'My Watchlist')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h1 class="fw-bold text-dark mb-0">
                    <i class="bi bi-heart-fill text-danger me-2"></i> My Watchlist
                </h1>
                <p class="text-muted mb-0">Keep track of the auctions you are interested in.</p>
            </div>
            <a href="{{ route('auctions.search') }}" class="btn btn-outline-primary rounded-pill px-4">
                Find More Auctions
            </a>
        </div>

        <div class="row">
            {{-- Filters Sidebar --}}
            <aside class="col-lg-3 mb-4">
                @include('partials.filters', ['categories' => $categories, 'actionRoute' => 'users.watchlist'])
            </aside>

            {{-- Reuse the grid layout --}}
            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @forelse ($auctions as $auction)
                        <div class="col">
                            {{-- Reuse your existing card partial --}}
                            @include('partials.card', ['auction' => $auction])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 bg-white shadow-sm rounded-4">
                                <div class="mb-3 text-muted opacity-25">
                                    <i class="bi bi-heartbreak fa-4x"></i>
                                </div>
                                <h4 class="fw-bold text-secondary">Your watchlist is empty.</h4>
                                <p class="text-muted mb-4">Start following auctions to track them here.</p>
                                <a href="{{ route('auctions.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold">
                                    Browse Auctions
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $auctions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection