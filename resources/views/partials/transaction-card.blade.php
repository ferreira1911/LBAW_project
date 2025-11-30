@php
    use App\Enums\TransactionType;
    use App\Enums\TransactionStatus;

    $isIncoming = match($transaction->type) {
        TransactionType::AddCredit => true,
        TransactionType::AuctionBuy => $transaction->seller_id === Auth::id(),
        default => false,
    };

    $config = match($transaction->type) {
        TransactionType::AddCredit => [
            'icon' => 'fa-wallet',
            'bg' => 'bg-success-subtle',
            'text' => 'text-success',
            'title' => 'Deposit'
        ],
        TransactionType::CreditWithdrawal => [
            'icon' => 'fa-money-bill-transfer',
            'bg' => 'bg-danger-subtle',
            'text' => 'text-danger',
            'title' => 'Withdrawal'
        ],
        TransactionType::AuctionBuy => [
            'icon' => 'fa-gavel',
            'bg' => $isIncoming ? 'bg-success-subtle' : 'bg-primary-subtle',
            'text' => $isIncoming ? 'text-success' : 'text-primary',
            'title' => $isIncoming ? 'Auction Sold' : 'Auction Won'
        ],
        TransactionType::FeaturePayment => [
            'icon' => 'fa-star',
            'bg' => 'bg-warning-subtle',
            'text' => 'text-warning',
            'title' => 'Feature Fee'
        ],
    };

    $statusColor = match($transaction->status) {
        TransactionStatus::Completed => 'success',
        TransactionStatus::Pending => 'warning',
        TransactionStatus::Cancelled => 'danger',
    };

    $amountClass = $isIncoming ? 'text-success' : 'text-dark';
    $sign = $isIncoming ? '+' : '-';
@endphp

<div class="card border-0 shadow-sm mb-3 overflow-hidden rounded-3">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
            
            <div class="d-flex align-items-center">
                <div class="rounded-circle p-3 d-flex align-items-center justify-content-center {{ $config['bg'] }} {{ $config['text'] }}" 
                     style="width: 56px; height: 56px;">
                    <i class="fas {{ $config['icon'] }} fa-lg"></i>
                </div>

                <div class="ms-3">
                    <h6 class="fw-bold mb-1 text-dark">{{ $config['title'] }}</h6>
                    <div class="text-muted small d-flex align-items-center">
                        <span class="me-2">{{ $transaction->date->format('M d, Y H:i') }}</span>
                        @if($transaction->auction)
                            <span class="badge bg-light text-secondary border">
                                {{ Str::limit($transaction->auction->title, 20) }}
                            </span>
                        @endif
                    </div>
                    @if($transaction->type === TransactionType::CreditWithdrawal && $transaction->status === TransactionStatus::Pending)
                        <small class="text-danger d-block mt-1 fst-italic">Processing request...</small>
                    @endif
                </div>
            </div>

            <div class="text-end">
                <div class="fs-5 fw-bolder {{ $amountClass }}">
                    {{ $sign }}{{ number_format($transaction->amount, 2) }} €
                </div>
                <span class="badge rounded-pill bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                    {{ $transaction->status->value }}
                </span>
            </div>

        </div>
    </div>
</div>