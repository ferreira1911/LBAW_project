@extends('layouts.app')

@section('title', 'Add Credit')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            {{-- Card Container --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-wallet2 me-2"></i> Add Credit
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('credit.store') }}" id="add-credit-form">
                        @csrf

                        {{-- Payment Method Selection --}}
                        <label class="form-label fw-bold mb-2">Select Payment Method</label>
                        <div class="btn-group w-100 mb-4" role="group" aria-label="Payment Method">
                            <input type="radio" class="btn-check" name="payment_method" id="method_bank" value="bank" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="method_bank">
                                <i class="bi bi-bank me-2"></i>Bank Transfer
                            </label>
                          
                            <input type="radio" class="btn-check" name="payment_method" id="method_card" value="card" autocomplete="off" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="method_card">
                                <i class="bi bi-credit-card me-2"></i>Credit Card
                            </label>
                        </div>

                        {{-- Amount Input --}}
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-bold">Amount to Add</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input 
                                    id="amount" 
                                    type="number" 
                                    class="form-control @error('amount') is-invalid @enderror" 
                                    name="amount" 
                                    value="{{ old('amount') }}" 
                                    min="5" 
                                    max="10000" 
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
                                Minimum deposit is €5.00.
                            </div>
                        </div>
                        
                        {{-- Bank Transfer Info (Default) --}}
                        <div id="bank-info-section" class="alert alert-light border mb-4">
                            <div class="d-flex">
                                <div class="fs-4 text-primary me-3"><i class="bi bi-info-circle-fill"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Instant Transfer</h6>
                                    <p class="text-muted small mb-0">
                                        The amount will be directly debited from your linked bank account ending in **88.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Credit Card Form (Hidden via JS) --}}
                        <div id="card-payment-section" class="bg-light p-3 rounded mb-4 border d-none">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">
                                <i class="bi bi-credit-card me-1"></i> Card Details
                            </h6>

                            <div class="mb-3">
                                <label for="card_name" class="form-label small text-muted text-uppercase fw-bold">Name on Card</label>
                                <input type="text" class="form-control @error('card_name') is-invalid @enderror" id="card_name" name="card_name" placeholder="JOHN DOE">
                                @error('card_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="card_number" class="form-label small text-muted text-uppercase fw-bold">Card Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror" id="card_number" name="card_number" placeholder="0000 0000 0000 0000" maxlength="19">
                                    <span class="input-group-text text-muted">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="card_expiry" class="form-label small text-muted text-uppercase fw-bold">Expiry Date</label>
                                    <input type="text" class="form-control @error('card_expiry') is-invalid @enderror" id="card_expiry" name="card_expiry" placeholder="MM/YY" maxlength="5">
                                    @error('card_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="card_cvc" class="form-label small text-muted text-uppercase fw-bold">CVC / CVV</label>
                                    <input type="text" class="form-control @error('card_cvc') is-invalid @enderror" id="card_cvc" name="card_cvc" placeholder="123" maxlength="4">
                                    @error('card_cvc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-plus-circle me-2"></i> Add Credit
                            </button>
                            <a href="{{ route('user.show', Auth::user()) }}" class="btn btn-link text-decoration-none text-muted">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
            
            {{-- Security Notice --}}
            <div class="text-center mt-3 text-muted small">
                <i class="bi bi-shield-lock-fill me-1"></i> Transactions are secure and encrypted.
            </div>

        </div>
    </div>
</div>

{{-- Transaction Scripts --}}
@push('scripts')
    <script src="{{ asset('js/transaction.js') }}" defer></script>
@endpush

@endsection