<?php

namespace App\Policies;

use App\Models\Feature;
use App\Models\User;
use Carbon\Carbon;

class FeaturePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    public function create(User $user): bool
    {
        // Admins can create unlimited ideas
        if ($user->hasRole('admin')) {
            return true;
        }
        return Feature::where('created_by', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->count() < 10;
    }

    public function vote(User $user): bool
    {
        return $user->isSubscriber();
    }
}
