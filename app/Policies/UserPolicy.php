<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function admin(User $user)
    {
        return $user->isAdmin();
    }

    public function boost(?User $user)
    {
        if (empty($user) || request()->get('_boost') === '0') {
            return false;
        }

        return $user->isGoblin() || ! empty($user->booster_count);
    }

    public function freeTrial(User $user)
    {
        return session()->get('kanka.freeTrial') && ! $user->isSubscriber();
    }

    public function renewPaypalSubscription(User $user): bool
    {
        if (! $user->hasPayPal()) {
            return false;
        }

        $subscription = $user->subscription('kanka');
        if (! $subscription) {
            return false;
        }

        return $subscription->ends_at->lte(now()->addDays(15));
    }
}
