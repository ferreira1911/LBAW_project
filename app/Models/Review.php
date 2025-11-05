<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    // Map 'created_date' to 'created_at' and disable 'updated_at'
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'description',
        'rating',
        'user_id',
        'auction_id',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'created_date' => 'datetime',
    ];

    /** Get the user who wrote the review */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Get the auction the review is for */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}