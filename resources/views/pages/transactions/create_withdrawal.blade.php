@extends('layouts.app')

@section('title', 'Levantar Crédito')

@section('content')
<div class="container">
    <h2>Levantar Crédito</h2>
    <p>Submeta um pedido para levantar fundos da sua carteira. Os pedidos são revistos por um administrador.</p>
    
    <div class="edit-form">
        <form method="POST" action="{{ route('withdrawal.store') }}">
            @csrf

            <fieldset>
                <legend>Detalhes do Levantamento</legend>

                <div class="current-balance">
                    Saldo disponível para levantamento: <strong>${{ number_format(Auth::user()->credit, 2) }}</strong>
                </div>

                <label for="amount">Valor a Levantar ($)</label>
                <input
                    id="amount"
                    type="number"
                    name="amount"
                    value="{{ old('amount') }}"
                    max="{{ Auth::user()->credit }}" {{-- Não pode inserir mais do que tem --}}
                    step="0.01"
                    placeholder="e.g., 50.00"
                    required
                >
                
                @error('amount')
                    <span class="error" role="alert">{{ $message }}</span>
                @enderror
                

            </fieldset>

            <button type="submit" class="button-primary">Submeter Pedido</button>
            <a href="{{ route('transactions.index') }}" class="button button-outline">Cancelar</a>
        </form>
    </div>
</div>
@endsection
