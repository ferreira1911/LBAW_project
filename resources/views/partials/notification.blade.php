@php
    $status = match($notification->type) {
        'new-bid' => ['icon' => 'bi-hammer',        'color' => 'primary',   'title' => 'New Bid'],
        'winner'  => ['icon' => 'bi-trophy-fill',   'color' => 'success',   'title' => 'You Won!'],
        'ended'   => ['icon' => 'bi-hourglass-bottom', 'color' => 'secondary', 'title' => 'Auction Ended'],
        'cancel'  => ['icon' => 'bi-x-circle-fill', 'color' => 'danger',    'title' => 'Cancelled'],
        'review'  => ['icon' => 'bi-star-fill',     'color' => 'warning',   'title' => 'New Review'],
        default   => ['icon' => 'bi-bell-fill',     'color' => 'info',      'title' => 'Notification'],
    };

    $color = $status['color'];
    $icon  = $status['icon'];
    
    $bgClass = $notification->is_read ? 'bg-light text-muted' : 'bg-white shadow-sm border-start border-4 border-' . $color;
    $isOwner = Auth::id() === $notification->auction->owner_id;
@endphp

<div id = "notification-{{ $notification->id }}" class="card mb-3 border-0 {{ $bgClass }}">
    <div class="card-body p-3">
        <div class="d-flex align-items-start">
            
            <div class="flex-shrink-0 me-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-{{ $color }} bg-opacity-10 text-{{ $color }}" 
                     style="width: 40px; height: 40px;">
                    <i class="bi {{ $icon }} fs-5"></i>
                </div>
            </div>

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

                <p class="mb-2 small {{ $notification->is_read ? 'text-muted' : 'text-secondary' }}">
                    @switch($notification->type)
                        @case('new-bid')
                            @if($isOwner)
                                Good news! Someone placed a bid of <span class="fw-bold">€{{ number_format($notification->bid->amount ?? 0, 2) }}</span> 
                                on your auction <a href="{{ route('auctions.show', $notification->auction) }}" class="text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                            @else
                                Activity alert! A new bid of <span class="fw-bold">€{{ number_format($notification->bid->amount ?? 0, 2) }}</span> 
                                was placed on <a href="{{ route('auctions.show', $notification->auction) }}" class="text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                            @endif
                            @break

                        @case('winner')
                            Congratulations! You won the auction <a href="{{ route('auctions.show', $notification->auction) }}" class="text-success text-decoration-none fw-bold">{{ $notification->auction->title }}</a>.
                            The amount has been deducted from your wallet.
                            @break

                        @case('ended')
                            @if($isOwner)
                                Your auction <a href="{{ route('auctions.show', $notification->auction) }}" class="text-dark text-decoration-none fw-bold">{{ $notification->auction->title }}</a> has ended.
                                Check if it was sold!
                            @else
                                The auction <a href="{{ route('auctions.show', $notification->auction) }}" class="text-dark text-decoration-none fw-bold">{{ $notification->auction->title }}</a> has ended.
                            @endif
                            @break

                        @case('cancel')
                            @if($isOwner)
                                Your auction <strong>{{ $notification->auction->title }}</strong> was successfully cancelled.
                            @else
                                The auction <strong>{{ $notification->auction->title }}</strong> (which you bid on) was cancelled. 
                                Your held credit has been refunded.
                            @endif
                            @break

                        @case('review')
                            You received a <strong>{{ $notification->rating ?? 5 }}-star</strong> review on a recent sale.
                            @break

                        @default
                            You have a new update on your account.
                    @endswitch
                </p>

                @if(!$notification->is_read)
                    <div class="text-end">
                        <button class="btn btn-link btn-sm p-0 text-decoration-none text-muted small"
                            onclick="markAsRead({{ $notification->id }})">
                            <i class="bi bi-check2-all me-1"></i>Mark as read
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>