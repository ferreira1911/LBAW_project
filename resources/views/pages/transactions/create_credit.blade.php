@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Credit to Your Wallet</h2>
    <div class="edit-form">
        <form method="POST" action="{{ route('credit.store') }}">
            @csrf

            <label for="amount">Amount to Add</label>
            <input
                id="amount"
                type="number"
                name="amount"
                value="{{ old('amount') }}"
                min="5"   {{-- Matches your validation rule --}}
                max="10000" {{-- Matches your validation rule --}}
                step="0.01"
                placeholder="e.g., 50.00"
                required
                autofocus
            >
            
            @error('amount')
                <span class="error" role="alert">{{ $message }}</span>
            @enderror
            
            <p><small>Minimum deposit is $5.00. The amount will be added to your available credit immediately.</small></p>

            <fieldset>

                <label for="card_name">Name on Card</label>
                <input type="text" id="card_name" name="card_name" placeholder="Your Name">
                @error('card_name')
                    <span class="error" role="alert">{{ $message }}</span>
                @enderror

                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" placeholder="0000 0000 0000 0000">
                @error('card_number')
                    <span class="error" role="alert">{{ $message }}</span>
                @enderror

                <div class="row">
                    <div class="column">
                        <label for="card_expiry">Expiry (MM/YY)</label>
                        <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY" >
                        @error('card_expiry')
                            <span class="error" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="column">
                        <label for="card_cvc">CVC</label>
                        <input type="text" id="card_cvc" name="card_cvc" placeholder="123" >
                        @error('card_cvc')
                            <span class="error" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <button type="submit" class="button-primary">Add Credit</button>
            <a href="{{ route('user.show',Auth::user()) }}" class="button button-outline">Cancel</a>
        </form>
    </div>
</div>
@endsection