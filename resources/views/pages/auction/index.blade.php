@extends('layouts.app')

@section('title', 'Auctions')

@section('content')
<div class="container py-5">
    <div class="row">

        <aside class="col-12 col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">

                    <form method="GET" action="{{ route('auctions.search') }}" id="filter-form">
                        @include('partials.filters', ['categories' => $categories])
                    </form>
                </div>
            </div>
        </aside>

        <section class="col-12 col-md-9">

            <div class="row g-3">
                @forelse($auctions as $auction)
                    <div class="col-12 col-sm-6 col-lg-4">
                        @include('partials.card', ['auction' => $auction])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center py-5 shadow-sm border">
                            <h4 class="alert-heading fw-bold">No auctions found</h4>
                            <p class="text-muted mb-4">We couldn't find any auctions matching your current filters.</p>
                            <a href="{{ route('auctions.index') }}" class="btn btn-primary">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $auctions->appends(request()->query())->links() }} 
            </div>

        </section>
    </div>
</div>
@endsection