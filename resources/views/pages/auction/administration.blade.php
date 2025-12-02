@extends('layouts.app')

@section('title', 'Auction Management')

@section('content')
<div class="container py-5">
    
    @include('partials.admin-tabs')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-0">Auction Management</h1>
            <p class="text-muted">Manage all auctions, monitor statuses and prices.</p>
        </div>
        {{-- Sinceridade: Removi o botão de Create aqui se o Admin não deve criar leilões.
             Se quiseres manter para debug, descomenta. --}}
        {{-- 
        <a href="{{ route('auctions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Create New Auction
        </a> 
        --}}
    </div>

    {{-- Search Bar --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-2">
            <form action="{{ route('auctions.admin') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 shadow-none" 
                               placeholder="Search auctions by title..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Auctions Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 60px;">ID</th>
                            <th class="py-3">Auction</th>
                            <th class="py-3">Owner</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Bids</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auctions as $auction)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $auction->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- Image Placeholder Logic --}}
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center me-3 border overflow-hidden" style="width: 50px; height: 50px; flex-shrink: 0;">
                                            @if($auction->picture)
                                                <img src="{{ asset($auction->picture) }}" alt="Auction" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <i class="bi bi-image text-secondary"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('auctions.show', $auction) }}" class="fw-bold text-dark text-decoration-none">
                                                {{ Str::limit($auction->title, 40) }}
                                            </a>
                                            <div class="small text-muted">Category: {{ $auction->category->name ?? 'None' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $auction->owner) }}" class="text-decoration-none text-secondary">
                                        {{ $auction->owner->name }}
                                    </a>
                                </td>
                                <td>
                                    @switch($auction->status)
                                        @case('Active')
                                            <span class="badge bg-success-subtle text-success rounded-pill">
                                                <i class="bi bi-lightning-charge me-1"></i>Active
                                            </span>
                                            @break
                                        @case('Pending')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i>Pending
                                            </span>
                                            @break
                                        @case('Ended')
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill">
                                                <i class="bi bi-check2-circle me-1"></i>Ended
                                            </span>
                                            @break
                                        @case('Cancelled')
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">
                                                <i class="bi bi-x-circle me-1"></i>Cancelled
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark border rounded-pill">
                                                {{ $auction->status }}
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ ($auction->bids_count ?? 0) > 0 ? 'bg-primary-subtle text-primary' : 'bg-light text-muted border' }}">
                                        {{ $auction->bids_count ?? 0 }} bids
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    {{ number_format($auction->current_price, 2) }} €
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('auctions.show', $auction) }}" class="btn btn-sm btn-outline-secondary" title="View Auction">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-sm btn-outline-primary" title="Edit Auction">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Cancel Action Logic (US503) --}}
                                        @if(in_array($auction->status, ['Active', 'Pending']))
                                            @if($auction->bids_count === 0)
                                                <form action="{{ route('auctions.cancel', $auction) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel Auction" onclick="return confirm('Are you sure you want to cancel this auction? This action is irreversible.')">
                                                        <i class="bi bi-slash-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-secondary disabled" title="Cannot cancel: Auction has bids" aria-disabled="true" style="opacity: 0.5; cursor: not-allowed;">
                                                    <i class="bi bi-slash-circle"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-hammer display-4 opacity-25 d-block mb-3"></i>
                                    No auctions found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($auctions->hasPages())
            <div class="card-footer bg-white py-3 border-top-0 d-flex justify-content-center">
                {{ $auctions->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection