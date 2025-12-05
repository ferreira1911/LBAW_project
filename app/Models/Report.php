<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';

    
    const CREATED_AT = 'create_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'description',
        'status',
        'user_id',
        'admin_id',
        'reported_user_id',
        'auction_id',
    ];

    protected $casts = [
        'create_date' => 'datetime',
        'status' => ReportStatus::class,
    ];

    /** Get the user who filed the report */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Get the admin who handled the report */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /** Get the user who was reported */
    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    /** Get the auction the report is about */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}