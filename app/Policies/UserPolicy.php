<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function boost(?User $user)
    {
        if (empty($user) || request()->get('_boost') === '0') {
            return false;
        }

        return $user->isGoblin() || ! empty($user->booster_count);
    }
}
