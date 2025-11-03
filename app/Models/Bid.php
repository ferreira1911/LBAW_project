<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'amount',
        'user_id',
        'auction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'datetime',
    ];

    /** Get the user who placed the bid */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Get the auction this bid was placed on */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}