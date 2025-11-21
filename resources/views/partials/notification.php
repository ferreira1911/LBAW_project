@php
    // Define estilos e ícones baseados no tipo de notificação
    $typeConfig = match($notification->type) {
        'new-bid' => [
            'icon' => 'fa-gavel',
            'bg' => 'bg-primary-subtle',
            'text' => 'text-primary',
            'border' => 'border-primary',
            'title' => 'Nova Licitação!'
        ],
        'winner' => [
            'icon' => 'fa-trophy',
            'bg' => 'bg-success-subtle',
            'text' => 'text-success',
            'border' => 'border-success',
            'title' => 'Parabéns! Ganhaste!'
        ],
        'ended' => [
            'icon' => 'fa-hourglass-end',
            'bg' => 'bg-secondary-subtle',
            'text' => 'text-secondary',
            'border' => 'border-secondary',
            'title' => 'Leilão Terminado'
        ],
        'cancel' => [
            'icon' => 'fa-ban',
            'bg' => 'bg-danger-subtle',
            'text' => 'text-danger',
            'border' => 'border-danger',
            'title' => 'Leilão Cancelado'
        ],
        'review' => [
            'icon' => 'fa-star',
            'bg' => 'bg-warning-subtle',
            'text' => 'text-warning',
            'border' => 'border-warning',
            'title' => 'Nova Avaliação'
        ],
        default => [
            'icon' => 'fa-bell',
            'bg' => 'bg-light',
            'text' => 'text-dark',
            'border' => 'border-light',
            'title' => 'Notificação'
        ]
    };

    // Verifica se a notificação já foi lida para estilizar (opacidade)
    $isReadClass = $notification->is_read ? 'opacity-75' : 'shadow-sm border-start border-4 ' . $typeConfig['border'];
@endphp

<div class="card mb-3 {{ $isReadClass }} notification-card">
    <div class="card-body d-flex align-items-start p-3">
        
        {{-- Ícone --}}
        <div class="rounded-circle p-3 me-3 d-flex align-items-center justify-content-center {{ $typeConfig['bg'] }} {{ $typeConfig['text'] }}" 
             style="width: 50px; height: 50px; min-width: 50px;">
            <i class="fas {{ $typeConfig['icon'] }} fa-lg"></i>
        </div>

        {{-- Conteúdo --}}
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 {{ $notification->is_read ? 'text-muted' : 'text-dark' }}">
                    {{ $typeConfig['title'] }}
                </h6>
                <small class="text-muted" style="font-size: 0.75rem;">
                    {{ $notification->created_date->diffForHumans() }}
                </small>
            </div>

            <p class="mb-2 text-secondary small">
                @switch($notification->type)
                    @case('new-bid')
                        Alguém licitou <strong>{{ number_format($notification->bid->amount ?? 0, 2) }} €</strong> 
                        no leilão <a href="{{ route('auction.show', $notification->auction) }}" class="text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                        @break
                    @case('winner')
                        Foste o vencedor do leilão <a href="{{ route('auction.show', $notification->auction) }}" class="text-decoration-none fw-bold">{{ $notification->auction->title }}</a>!
                        <br>O pagamento foi processado automaticamente.
                        @break
                    @case('ended')
                        O leilão <a href="{{ route('auction.show', $notification->auction) }}" class="text-decoration-none fw-bold">{{ $notification->auction->title }}</a> terminou.
                        @break
                    @case('cancel')
                        O leilão <strong>{{ $notification->auction->title }}</strong> foi cancelado pelo proprietário ou administrador.
                        Os fundos retidos foram devolvidos.
                        @break
                    @case('review')
                        Recebeste uma nova avaliação numa venda recente.
                        @break
                    @default
                        Tens uma nova atualização na tua conta.
                @endswitch
            </p>

            {{-- Ações (opcional) --}}
            @if(!$notification->is_read)
                <div class="d-flex justify-content-end">
                    <form action="{{-- route('notifications.markAsRead', $notification) --}}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none text-muted" style="font-size: 0.8rem;">
                            Marcar como lida
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>