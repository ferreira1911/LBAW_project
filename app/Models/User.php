<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    public $timestamps = false;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'description', 
        'url', 
        'is_deleted', 
        'is_admin',
        'credit',
        'held_credit',
        'is_blocked',
        'google_id',
        'stripe_id',
        'pm_type', 
        'pm_last_four', 
        'trial_ends_at'
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
        return $this->hasMany(Auction::class, 'owner_id');
    }


    public function getAverageRating(): float
    {
        $average = DB::table('review')
            ->join('auction', 'auction.id', '=', 'review.auction_id')
            ->where('auction.owner_id', $this->id)
            ->avg('review.rating');

        return $average ? round((float) $average, 1) : 0.0;
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

    public function wonAuctions(): HasManyThrough
    {
        return $this->hasManyThrough(Auction::class, Transaction::class, 'buyer_id', 'id','id','auction_id')->where('transactions.status', 'Completed')->where('transactions.type', 'auction-buy');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Checks if the user is currently the highest bidder on any Active/Ending auction.
     * Returns true if they are winning something.
     */
    public function isWinningAnyAuction(): bool
    {
        $activeAuctions = Auction::whereIn('status', ['Active', 'Ending'])
            ->whereHas('bids', function($q) {
                $q->where('user_id', $this->id);
            })
            ->with('highestBid')
            ->get();

        foreach ($activeAuctions as $auction) {
            if ($auction->highestBid && $auction->highestBid->user_id === $this->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validates if the account can be safely deleted.
     * Returns an error string if blocked, or NULL if safe.
     */
    public function canBeDeleted(): ?string
    {
        if ($this->credit > 0) {
            return 'You still have funds in your wallet. Please withdraw them before deleting your account.';
        }

        if ($this->isWinningAnyAuction()) {
            return 'You are currently the highest bidder on active auctions. You cannot delete your account until these auctions end.';
        }

        $hasActiveAuctions = $this->auctions()->whereIn('status', ['Active', 'Ending'])->exists();
        if ($hasActiveAuctions) {
             return 'You have active auctions running. Please cancel them or wait for them to end.';
        }

        return null;
    }
}