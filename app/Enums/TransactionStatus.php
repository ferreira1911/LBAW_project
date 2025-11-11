<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case Pending = 'Pending';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';
}