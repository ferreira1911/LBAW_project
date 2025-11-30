<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;

use Illuminate\Support\Facades\Auth;

class AuctionPolicy
{
    
    public function view(User $user, Auction $auction): bool
    {
        return Auth::check();
    }

    
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return !$user->is_admin;
    }

    public function delete(User $user, Auction $auction): bool
    {
      return $user->id === $auction->owner_id;
    }
    public function update(User $user, Auction $auction)
    {
        return $user->id === $auction->owner_id || $user->is_admin;
    }

    public function cancel(User $user, Auction $auction): bool
    {
        return $user->id === $auction->owner_id && in_array($auction->status, ['Active', 'Pending']) && !$auction->bids()->exists();
    }

    public function viewDashboard(User $user){
        return $user->isAdmin();
    }
}
