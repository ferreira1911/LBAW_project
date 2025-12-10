<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    // Map 'date' to 'created_at' and disable 'updated_at'
    const CREATED_AT = 'date';
    const UPDATED_AT = null;

    // Use 'transactions' table
    protected $table = 'transactions';

    protected $fillable = [
        'amount',
        'status',
        'type',
        'auction_id',
        'buyer_id',
        'seller_id',
        'payment_reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'datetime',
        'status' => TransactionStatus::class,
        'type' => TransactionType::class,
    ];

    /** Get the auction associated with this transaction */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    /** Get the user who bought the item */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /** Get the user who sold the item */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}