@php
    $status = match($notification->type) {
        'new-bid' => ['icon' => 'bi-hammer',          'color' => 'primary',   'title' => 'New Bid!'],
        'winner'  => ['icon' => 'bi-trophy-fill',     'color' => 'success',   'title' => 'Congratulations! You Won!'],
        'ending'  => ['icon' => 'bi-alarm',           'color' => 'info',      'title' => 'Ending Soon'],
        'ended'   => ['icon' => 'bi-hourglass-bottom','color' => 'secondary', 'title' => 'Auction Ended'],
        'cancel'  => ['icon' => 'bi-x-circle-fill',   'color' => 'danger',    'title' => 'Cancelled'],
        'review'  => ['icon' => 'bi-star-fill',       'color' => 'warning',   'title' => 'New Review'],
        'auction-bought' => ['icon' => 'bi-bag-check-fill', 'color' => 'success', 'title' => 'Item Purchased!'],
        default   => ['icon' => 'bi-bell-fill',       'color' => 'dark',      'title' => 'Notification'],
    };

    $color = $status['color'];
    $icon  = $status['icon'];
    
    // Different style if already read
    $bgClass = $notification->is_read 
        ? 'bg-light text-muted opacity-75' 
        : 'bg-white shadow-sm border-start border-4 border-' . $color;

    // Check if owner (for custom messages)
    // Optional prevents errors if auction was physically deleted from DB
    $isOwner = optional($notification->auction)->owner_id === Auth::id();
    $auctionTitle = optional($notification->auction)->title ?? 'Unavailable Auction';
    $auctionRoute = $notification->auction ? route('auctions.show', $notification->auction) : '#';
@endphp

<div id="notification-{{ $notification->id }}" 
     class="card mb-3 border-0 {{ $bgClass }} position-relative" 
     style="transition: all 0.3s ease;">
    
    <div class="card-body p-3">
        <div class="d-flex align-items-start">
            
            {{-- Circular Icon --}}
            <div class="flex-shrink-0 me-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-{{ $color }} bg-opacity-10 text-{{ $color }}" 
                     style="width: 48px; height: 48px;">
                    <i class="bi {{ $icon }} fs-5"></i>
                </div>
            </div>

            {{-- Text and Content --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="fw-bold mb-0 {{ $notification->is_read ? 'text-secondary' : 'text-dark' }}">
                        {{ $status['title'] }}
                        @if(!$notification->is_read)
                            <span class="badge bg-{{ $color }} ms-2" style="font-size: 0.6rem;">NEW</span>
                        @endif
                    </h6>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        {{ $notification->created_date->diffForHumans() }}
                    </small>
                </div>

                <p class="mb-2 small {{ $notification->is_read ? 'text-muted' : 'text-secondary' }}" style="line-height: 1.4;">
                    @switch($notification->type)
                        @case('new-bid')
                            @if($isOwner)
                                Good news! A bid of <span class="fw-bold text-dark">€{{ number_format($notification->bid->amount ?? 0, 2) }}</span> 
                                was placed on your auction <a href="{{ $auctionRoute }}" class="fw-bold text-decoration-none">{{ $auctionTitle }}</a>.
                            @else
                                A new bid of <span class="fw-bold text-dark">€{{ number_format($notification->bid->amount ?? 0, 2) }}</span> 
                                was placed on the auction <a href="{{ $auctionRoute }}" class="fw-bold text-decoration-none">{{ $auctionTitle }}</a>.
                            @endif
                            @break

                        @case('ending')
                            @if($isOwner)
                                Attention! Your auction <a href="{{ $auctionRoute }}" class="fw-bold text-decoration-none">{{ $auctionTitle }}</a> ends in less than 15 minutes.
                            @else
                                Hurry up! The auction <a href="{{ $auctionRoute }}" class="fw-bold text-decoration-none">{{ $auctionTitle }}</a> is about to end.
                            @endif
                            @break

                        @case('winner')
                            Congratulations! You won the auction <a href="{{ $auctionRoute }}" class="text-success fw-bold text-decoration-none">{{ $auctionTitle }}</a>.
                            The item is yours.
                            @break

                        @case('ended')
                            The auction <a href="{{ $auctionRoute }}" class="fw-bold text-decoration-none">{{ $auctionTitle }}</a> has ended.
                            @break

                        @case('cancel')
                            The auction <strong>{{ $auctionTitle }}</strong> was cancelled. Any held funds have been refunded.
                            @break

                        @case('review')
                            You received a 
                            <strong>{{ $notification->review->rating ?? 5 }}-star</strong> 
                            review on your auction <strong>{{ $auctionTitle }}</strong>.
                            @break
                        @case('auction-bought')
                            @if($isOwner)
                                Great news! Your auction <a href="{{ $auctionRoute }}" class="fw-bold text-decoration-none text-dark">{{ $auctionTitle }}</a> was purchased instantly via "Buy Now".      
                            @endif
                            @break

                        @default
                            You have a new update on your account.
                    @endswitch
                </p>

                {{-- Mark as Read Button (JS) --}}
                @if(!$notification->is_read)
                    <div class="text-end" id="action-{{ $notification->id }}">
                        <button type="button" 
                                class="btn btn-link btn-sm p-0 text-decoration-none text-muted small"
                                onclick="markAsRead({{ $notification->id }})">
                            <i class="bi bi-check2-all me-1"></i> Mark as read
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>