<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    // Use specific table name
    protected $table = 'message';

    // Disable default timestamps (we use sent_date)
    public $timestamps = false;

    // Map 'sent_date' to 'created_at' behavior for convenience
    const CREATED_AT = 'sent_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'content',
        'is_read',
        'sent_date',
        'sender_id',
        'receiver_id',
        'auction_id',
    ];

    protected $casts = [
        'sent_date' => 'datetime',
        'is_read' => 'boolean',
    ];

    // --- Relationships ---

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}