<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password', 'description', 'url', 'is_deleted', 'is_admin','credit','held_credit',
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

    public function reportsReceived(): HasMany
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function reportsHandled(): HasMany
    {
        return $this->hasMany(Report::class, 'admin_id');
    }

    public function followedAuctions(): BelongsToMany
    {
        return $this->belongsToMany(Auction::class, 'user_follows', 'follower_id', 'followed_auction');
    }

    public function featurePayments(): HasMany
    {
        return $this->hasMany(FeaturePayment::class, 'user_id');
    }

    public function isAdmin() : bool {
        return $this->is_admin;
    }

    public function deleteUser() : void {
        $this->is_deleted = true;
        $this->save();
    }

}