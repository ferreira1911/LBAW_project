<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use App\Models\Auction;

class ReviewPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user, Auction $auction): bool
    {
        if ($auction->status !== 'Ended') {
            return false;
        }

        $hasWon = $auction->transactions()
            ->where('buyer_id', $user->id)
            ->where('status', 'Completed')
            ->exists();

        if (!$hasWon) {
            return false;
        }

        $alreadyReviewed = Review::where('auction_id', $auction->id)
            ->where('user_id', $user->id)
            ->exists();

        return !$alreadyReviewed;
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->is_admin;
    }
}