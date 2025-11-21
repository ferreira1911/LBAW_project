<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionImage extends Model
{
    use HasFactory;

    protected $table = 'auction_images';
    protected $fillable = ['auction_id', 'path'];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function getUrl()
    {
        return asset('images/auction/' . $this->path);
    }
}

