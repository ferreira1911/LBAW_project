<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /** Get all auctions in this category */
    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class, 'category_id');
    }
}