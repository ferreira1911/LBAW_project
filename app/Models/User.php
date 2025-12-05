<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\FileController;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password', 'description', 'url', 'is_deleted', 'is_admin','credit','held_credit','is_blocked',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_deleted' => 'boolean',
        'is_blocked' => 'boolean',
        'credit' => 'decimal:2', 
        'held_credit' => 'decimal:2',
    ];

    // Define all relationships
    public function auctions() {
        return $this->hasMany(Auction::class, 'owner_id');
    }

    public function auctionsCreated(): HasMany
    {
        return $this->hasMany(Auction::class, 'owner_id')->where('status', 'Active');
    }

    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasManyThrough(
                Review::class,
                Auction::class,
                'owner_id',   // Foreign key on 'auction' table
                'auction_id'    // Foreign key on 'review' table
            )->avg('rating') 
        );
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

    public function getProfileImage() {
        return FileController::get('profile', $this->id);
    }

    public function isBlocked() : bool {
        return (bool) $this->is_blocked;
    }

}