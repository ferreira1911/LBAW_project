<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function viewBalance(User $currentUser, User $userToView): bool
    {
        
        return $currentUser->id === $userToView->id || $currentUser->is_admin;
    }

    public function block(User $currentUser, User $targetUser): bool
    {
        if (! $currentUser->isAdmin()) {
            return false;
        }

        if ($targetUser->isAdmin()) {
            return false;
        }

        if ($currentUser->id === $targetUser->id) {
            return false;
        }

        return true;
    }

    public function unblock(User $currentUser, User $targetUser): bool
    {
        return $currentUser->isAdmin();
    }

}