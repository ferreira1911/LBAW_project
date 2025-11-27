<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     * This is called by the show() method.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        // Allow the user to see the transaction if...
        return $user->id === $transaction->buyer_id     // they are the buyer
            || $user->id === $transaction->seller_id  // or they are the seller
            || $user->is_admin;                       // or they are an admin
    }

    /**
     * Determine whether the user can create models.
     * This is called by the create() and store() methods.
     */
    public function create(User $user): bool
    {
        return !$user->is_admin;
    }
}