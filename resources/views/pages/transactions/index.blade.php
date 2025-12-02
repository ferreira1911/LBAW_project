@extends('layouts.app')

@section('title', 'My Wallet')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h1 class="fw-bold text-dark mb-0">My Wallet</h1>
                <p class="text-muted mb-0">Manage your balance and view transaction history.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('credit.create') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Deposit
                </a>
                <a href="{{ route('withdrawal.create') }}" class="btn btn-outline-dark btn-lg rounded-pill px-4 shadow-sm">
                    <i class="fas fa-money-bill-wave me-2"></i> Withdraw
                </a>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden position-relative">
                    <div class="card-body p-4 position-relative z-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-white-50 text-uppercase fw-bold ls-1">Available Balance</small>
                                <div class="display-5 fw-bold my-2">{{ number_format(Auth::user()->credit, 2) }} €</div>
                            </div>
                        </div>
                        <div class="small text-white-50">
                            <i class="bi bi-check-circle-fill me-1"></i> Ready to use
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="me-4 p-4 rounded-circle bg-light text-secondary">
                            <i class="bi bi-piggy-bank fs-2"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold ls-1">Held Balance (Active Bids)</small>
                            <div class="fs-2 fw-bold text-dark">{{ number_format(Auth::user()->held_credit, 2) }} €</div>
                            <p class="mb-0 text-muted small">
                                This amount is temporarily locked in active auctions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-body p-4 bg-white border-bottom">
                <form action="{{ route('transactions.filter') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label for="type" class="form-label fw-bold text-secondary small text-uppercase ls-1">Filter by Type</label>
                        <select name="type" id="type" class="form-select rounded-3">
                            <option value="" {{ $currentType == '' ? 'selected' : '' }}>All Transactions</option>
                            <option value="add-credit" {{ $currentType == 'add-credit' ? 'selected' : '' }}>Deposits</option>
                            <option value="credit-withdrawal" {{ $currentType == 'credit-withdrawal' ? 'selected' : '' }}>Withdrawals</option>
                            <option value="auction-buy" {{ $currentType == 'auction-buy' ? 'selected' : '' }}>Auctions</option>
                            <option value="feature-payment" {{ $currentType == 'feature-payment' ? 'selected' : '' }}>Fees</option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">Apply Filter</button>
                        @if($currentType)
                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary px-4 fw-bold rounded-3 ms-2">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card-body p-0 bg-light">
                <div class="list-group list-group-flush">
                    @forelse ($transactions as $transaction)
                        <div class="p-3 bg-white border-bottom transaction-item">
                            @include('partials.transaction-card', ['transaction' => $transaction])
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted opacity-25">
                                <i class="fas fa-receipt fa-4x"></i>
                            </div>
                            <h5 class="fw-bold text-secondary">No transactions found</h5>
                            <p class="text-muted">There is no activity for this filter.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            @if($transactions->hasPages())
                <div class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection