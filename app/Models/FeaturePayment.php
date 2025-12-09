<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeaturePayment extends Model
{
    use HasFactory;

    protected $table = 'feature_payment';

    public $timestamps = false;

    protected $fillable = [
        'auction_id',
        'user_id',
        'paid_date',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
