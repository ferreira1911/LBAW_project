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
                    Saldo disponível para levantamento:
                    <strong>${{ number_format(Auth::user()->credit, 2) }}</strong>
                </div>

                {{-- Valor a levantar --}}
                <label for="amount">Valor a Levantar ($)</label>
                <input
                    id="amount"
                    type="number"
                    name="amount"
                    value="{{ old('amount') }}"
                    max="{{ Auth::user()->credit }}"
                    step="0.01"
                    placeholder="e.g., 50.00"
                    required
                >
                @error('amount')
                    <span class="error">{{ $message }}</span>
                @enderror

                <hr>

                {{-- Método de levantamento --}}
                <div class="column">
                    <label class="radio-label">
                        <input type="radio"
                               id="method_mbway"
                               name="method"
                               value="mbway"
                               onchange="toggleMethod()"
                               {{ old('method', 'mbway') == 'mbway' ? 'checked' : '' }}>
                        MB WAY
                    </label>
                </div>
                <div class="column">
                    <label class="radio-label">
                        <input type="radio"
                               id="method_iban"
                               name="method"
                               value="iban"
                               onchange="toggleMethod()"
                               {{ old('method') == 'iban' ? 'checked' : '' }}>
                        Transferência Bancária (IBAN)
                    </label>
                </div>

                @error('method')
                    <span class="error">{{ $message }}</span>
                @enderror

                {{-- MB WAY --}}
                <div id="mbway-container" style="display: none;">
                    <label for="mbway_phone">Número de Telemóvel (MB WAY)</label>
                    <input
                        type="tel"
                        id="mbway_phone"
                        name="mbway_phone"
                        placeholder="9xxxxxxxx"
                        value="{{ old('mbway_phone') }}"
                        pattern="9[0-9]{8}">
                    @error('mbway_phone')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- IBAN --}}
                <div id="iban-container" style="display: none;">
                    <label for="iban">IBAN</label>
                    <input
                        type="text"
                        id="iban"
                        name="iban"
                        placeholder="PT50..."
                        value="{{ old('iban') }}">
                    @error('iban')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

            </fieldset>

            <button type="submit" class="button-primary">Submeter Pedido</button>
            <a href="{{ route('user.show', Auth::user()) }}" class="button button-outline">Cancelar</a>
        </form>
    </div>
</div>


<script>
    function toggleMethod() {
        const selectedMethod = document.querySelector('input[name="method"]:checked').value;
        const mbwayContainer = document.getElementById('mbway-container');
        const ibanContainer = document.getElementById('iban-container');
        const mbwayInput = document.getElementById('mbway_phone');
        const ibanInput = document.getElementById('iban');

        if (selectedMethod === 'mbway') {
            mbwayContainer.style.display = 'block';
            ibanContainer.style.display = 'none';
            mbwayInput.required = true;
            ibanInput.required = false;
        } else {
            mbwayContainer.style.display = 'none';
            ibanContainer.style.display = 'block';
            mbwayInput.required = false;
            ibanInput.required = true;
        }
    }

    document.addEventListener('DOMContentLoaded', toggleMethod);
</script>
@endsection
