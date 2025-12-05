<?php

namespace App\Policies;

use App\Models\User;
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

    public function create(User $user): bool
    {
        return Auth::check() && !$user->is_admin;
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
