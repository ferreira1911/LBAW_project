<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;
use App\Models\Report;

use Illuminate\Support\Facades\Auth;

class ReportPolicy
{
    
    public function view(User $user): bool
    {
        return $user->is_admin;
    }

    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function create(User $user, $target = null)
    {
        return !$user->is_admin && !(
            ($target instanceof Auction && $user->id === $target->owner_id) ||
            ($target instanceof User && $user->id === $target->id)
        );
    }

    public function assign(User $user): bool
    {
        return $user->is_admin;
    }

    public function dismiss(User $user, Report $report)
    {
        return $user->is_admin && $user->id === $report->admin_id;
    }

    public function resolve(User $user, Report $report)
    {
        return $user->is_admin && $user->id === $report->admin_id;
    }
}
