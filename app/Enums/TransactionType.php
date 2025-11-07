<?php

namespace App\Enums;

enum TransactionType: string
{
    case AuctionBuy = 'auction-buy';
    case AddCredit = 'add-credit';
    case FeaturePayment = 'feature-payment';
    case CreditWithdrawal = 'credit-withdrawal';
}