<?php

namespace App\Traits;

use App\User;

trait AdminPolicyTrait
{
    /**
     * Cached value of the check
     * @var null|boolean
     */
    protected $cachedAdminPolicy = null;

    /**
     * Determin if a user is admin of a campaign
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user)
    {
        if ($this->cachedAdminPolicy === null) {
            $this->cachedAdminPolicy = false;
            foreach ($user->roles as $role) {
                if ($role->is_admin) {
                    $this->cachedAdminPolicy = true;
                }
            }
        }

        return $this->cachedAdminPolicy;
    }
}
