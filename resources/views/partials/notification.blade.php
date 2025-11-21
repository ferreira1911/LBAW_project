@php
    // Configuração de Cores e Ícones
    $status = match($notification->type) {
        'new-bid' => ['icon' => 'fa-gavel',         'color' => 'primary',   'title' => 'Nova Licitação'],
        'winner'  => ['icon' => 'fa-trophy',        'color' => 'success',   'title' => 'Vencedor!'],
        'ended'   => ['icon' => 'fa-hourglass-end', 'color' => 'secondary', 'title' => 'Leilão Terminado'],
        'cancel'  => ['icon' => 'fa-ban',           'color' => 'danger',    'title' => 'Cancelado'],
        'review'  => ['icon' => 'fa-star',          'color' => 'warning',   'title' => 'Nova Avaliação'],
        default   => ['icon' => 'fa-bell',          'color' => 'info',      'title' => 'Notificação'],
    };

    $color = $status['color'];
    $icon  = $status['icon'];
    
    $cardClass = $notification->is_read 
        ? 'bg-light border-0 opacity-75' 
        : 'bg-white border-0 shadow-sm border-start border-4 border-' . $color;
        
    $isOwner = Auth::id() === $notification->auction->owner_id;
@endphp

<div class="card mb-3 overflow-hidden {{ $cardClass }} position-relative">
    <div class="card-body p-4">
        <div class="d-flex">
            
            {{-- 1. Coluna do Ícone --}}
            <div class="flex-shrink-0 me-4">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-{{ $color }} bg-opacity-10 text-{{ $color }}" 
                     style="width: 50px; height: 50px;">
                    <i class="fas {{ $icon }} fa-lg"></i>
                </div>
            </div>

            {{-- 2. Coluna do Conteúdo --}}
            <div class="flex-grow-1">
                
                {{-- Cabeçalho --}}
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        {{ $status['title'] }}
                        @if(!$notification->is_read)
                            <span class="badge bg-{{ $color }} ms-2" style="font-size: 0.6em; vertical-align: middle;">NOVA</span>
                        @endif
                    </h6>
                    <small class="text-muted ms-2 text-nowrap" style="font-size: 0.8rem;">
                        <i class="far fa-clock me-1"></i>{{ $notification->created_date->diffForHumans() }}
                    </small>
                </div>

                
                <div class="text-secondary mb-3 small" style="line-height: 1.6;">
                    @switch($notification->type)
                        
                        @case('new-bid')
                            @if($isOwner)
                                Boas notícias! Alguém ofereceu <span class="fw-bold text-dark">{{ number_format($notification->bid->amount ?? 0, 2) }} €</span> 
                                pelo teu leilão <a href="{{ route('auction.show', $notification->auction) }}" class="link-primary text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                            @else
                                Há atividade recente! Foi feita uma licitação de <span class="fw-bold text-dark">{{ number_format($notification->bid->amount ?? 0, 2) }} €</span> 
                                no leilão <a href="{{ route('auction.show', $notification->auction) }}" class="link-primary text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                            @endif
                            @break

                        @case('winner')
                            Parabéns! Ganhaste o leilão <a href="{{ route('auction.show', $notification->auction) }}" class="link-success text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                            O valor foi debitado da tua carteira.
                            @break

                        @case('ended')
                            @if($isOwner)
                                O teu leilão <a href="{{ route('auction.show', $notification->auction) }}" class="link-dark text-decoration-none fw-bold">{{ $notification->auction->title }}</a> chegou ao fim.
                                Verifica se foi vendido!
                            @else
                                O leilão <a href="{{ route('auction.show', $notification->auction) }}" class="link-dark text-decoration-none fw-bold">{{ $notification->auction->title }}</a> terminou.
                            @endif
                            @break

                        @case('cancel')
                            @if($isOwner)
                                O teu leilão <strong>{{ $notification->auction->title }}</strong> foi cancelado com sucesso.
                            @else
                                O leilão <strong>{{ $notification->auction->title }}</strong> (onde tinhas licitado) foi cancelado. 
                                O teu crédito retido foi devolvido.
                            @endif
                            @break

                        @case('review')
                            Recebeste uma avaliação de <strong>{{ $notification->rating ?? 5 }} estrelas</strong> numa venda recente.
                            @break

                        @default
                            Tens uma nova atualização na tua conta.
                    @endswitch
                </div>

                {{-- Ações --}}
                @if(!$notification->is_read)
                    <div class="d-flex justify-content-end mt-2">
                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Marcar como lida">
                                <i class="fas fa-check me-1"></i> Marcar como lida
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>