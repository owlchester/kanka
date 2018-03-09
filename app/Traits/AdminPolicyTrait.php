<?php

namespace App\Traits;

use App\User;

trait AdminPolicyTrait
{
    /**
     * Determin if a user is admin of a campaign
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user)
    {
        foreach ($user->roles as $role) {
            if ($role->is_admin) {
                return true;
            }
        }

        return false;
    }
}
