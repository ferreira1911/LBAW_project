@extends('layouts.app')

@section('title', 'Add Credit')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-wallet2 me-2"></i> Add Credit
                    </h4>
                </div>

                <div class="card-body p-4">
                    @if (session('warning'))
                        <div class="alert alert-warning small">{{ session('warning') }}</div>
                    @endif

                    <p class="text-muted text-center mb-4 small">
                        Secure payment powered by <strong>Stripe</strong>. <br>
                        You will be redirected to complete the transaction.
                    </p>

                    <form method="POST" action="{{ route('credit.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="amount" class="form-label fw-bold">Amount to Deposit</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">€</span>
                                <input 
                                    id="amount" 
                                    type="number" 
                                    class="form-control fw-bold @error('amount') is-invalid @enderror" 
                                    name="amount" 
                                    value="{{ old('amount') }}" 
                                    min="5" 
                                    max="5000" 
                                    step="0.01" 
                                    placeholder="50.00" 
                                    required 
                                    autofocus
                                >
                            </div>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">Min: €5.00 | Max: €5,000.00</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold">
                                Proceed to Stripe <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                            <a href="{{ route('users.show', Auth::user()) }}" class="btn btn-link text-decoration-none text-muted">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3 text-muted small">
                <i class="bi bi-shield-lock-fill me-1"></i> Payments are encrypted and secure.
            </div>

        </div>
    </div>
</div>
@endsection