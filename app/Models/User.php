<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'description', 'url', 'is_deleted', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Define all relationships
    public function auctions() {
        return $this->hasMany(Auction::class, 'owner_id');
    }

    public function bids() {
        return $this->hasMany(Bid::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function reportsMade() {
        return $this->hasMany(Report::class, 'user_id');
    }

    
}