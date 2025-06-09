<?php

namespace App\Policies;

use App\Enums\UserFlags;
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
        return session()->get('kanka.freeTrial') && !$user->isSubscriber();
    }
}
