@extends('layouts.app')

@section('title', 'Withdraw Funds')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            {{-- Card Container --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-cash-stack me-2"></i> Withdraw Funds
                    </h4>
                </div>

                <div class="card-body p-4">
                    
                    {{-- Available Balance Alert --}}
                    <div class="alert alert-info d-flex align-items-center mb-4 shadow-sm" role="alert">
                        <i class="bi bi-wallet-fill fs-2 me-3"></i>
                        <div>
                            <div class="small text-uppercase fw-bold opacity-75">Available Balance</div>
                            <div class="fs-4 fw-bold">€{{ number_format(Auth::user()->credit, 2) }}</div>
                        </div>
                    </div>

                    <p class="text-muted small mb-4">
                        Submit a request to withdraw funds. Requests are usually processed instantly.
                    </p>

                    <form method="POST" action="{{ route('withdrawal.store') }}">
                        @csrf

                        {{-- Amount Input --}}
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-bold">Amount to Withdraw</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input
                                    id="amount"
                                    type="number"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    name="amount"
                                    value="{{ old('amount') }}"
                                    max="{{ Auth::user()->credit }}"
                                    min="10"
                                    step="0.01"
                                    placeholder="50.00"
                                    required
                                    autofocus
                                >
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">
                                Minimum withdrawal: €10.00 | Max: €{{ number_format(Auth::user()->credit, 2) }}
                            </div>
                        </div>

                        {{-- IBAN Input (NOVO) --}}
                        <div class="mb-4">
                            <label for="iban" class="form-label fw-bold">IBAN</label>
                            <input 
                                id="iban" 
                                type="text" 
                                class="form-control @error('iban') is-invalid @enderror" 
                                name="iban" 
                                value="{{ old('iban') }}" 
                                placeholder="PT50..." 
                                required
                            >
                            @error('iban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-send me-2"></i> Submit Request
                            </button>
                            <a href="{{ route('users.show', Auth::user()) }}" class="btn btn-link text-decoration-none text-muted">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection