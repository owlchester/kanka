<?php

namespace App\Policies;

use App\Enums\FeatureStatus;
use App\Models\Feature;
use App\Models\User;
use Carbon\Carbon;

class FeaturePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

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

    public function champion(User $user, Feature $feature): bool
    {
        return $user->isElemental() && $feature->status_id === FeatureStatus::Approved;
    }

    public function unchampion(User $user, Feature $feature): bool
    {
        return $user->isElemental() && ! in_array($feature->status_id, [FeatureStatus::Done, FeatureStatus::Rejected], true);
    }
}
