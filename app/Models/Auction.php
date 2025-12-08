<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Exception;

class Auction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'auction';

    const FEATURE_COST = 100.00;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'starting_price',
        'owner_id',
        'category_id',
        'buy_now_price',
        'address',
        'latitude',
        'longitude',
        'picture',
        'is_buy_now_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'featured_until' => 'datetime',
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'buy_now_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_buy_now_active' => 'boolean',
    ];

    // --- Relationships ---

    /** Get the user who owns the auction */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /** Get the category of the auction */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /** Get all bids for this auction */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'auction_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(AuctionImage::class, 'auction_id');
    }   

    /** Get all reviews for this auction */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'auction_id');
    }

    /** Get all notifications related to this auction */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'auction_id');
    }

    /** Get the transaction for this auction (if it ended) */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'auction_id');
    }

    /** Get reports filed against this auction */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'auction_id');
    }

    /** Get the users who are following this auction */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'followed_auction', 'follower_id');
    }

    /** Get the feature payment record for this auction */
    public function featurePayments()
    {
        return $this->hasMany(FeaturePayment::class);
    }

    public function isFollowedBy(?User $user)
    {
        if (!$user) return false;
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    public function hasActiveFeature(): bool
    {
        return $this->is_featured && $this->featured_until && $this->featured_until->isFuture();
    }

    public function feature(User $user)
    {
        if ($user->credit < self::FEATURE_COST) {
            throw new Exception("Insufficient funds. You need " . self::FEATURE_COST . "€ to feature this auction.");
        }

        return DB::transaction(function () use ($user) {

            $user->decrement('credit', self::FEATURE_COST);

            $this->is_featured = true;
            $this->featured_until = now()->addDays(7);
            $this->save();

            FeaturePayment::create([
                'auction_id' => $this->id,
                'user_id' => $user->id,
                'paid_date' => now(),
            ]);

            Transaction::create([
                'amount' => self::FEATURE_COST,
                'type' => 'feature-payment',
                'status' => 'Completed',
                'auction_id' => $this->id,
                'buyer_id' => $user->id,
                'seller_id' => null, // Null because it's a payment to the platform
                'date' => now(),
            ]);
            
            return true;
        });
    }
}