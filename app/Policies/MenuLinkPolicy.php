<?php

namespace App\Policies;

use App\Models\MenuLink;
use App\Traits\AdminPolicyTrait;
use App\Traits\EnvTrait;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuLinkPolicy
{
    use HandlesAuthorization, EnvTrait, AdminPolicyTrait;

    public function browse(User $user)
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can view the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MenuLink  $menuLink
     * @return mixed
     */
    public function view(User $user, MenuLink $menuLink)
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create campaigns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return !$this->shadow() &&
            $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MenuLink  $menuLink
     * @return mixed
     */
    public function update(User $user, MenuLink $menuLink)
    {
        return
            $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MenuLink  $menuLink
     * @return mixed
     */
    public function delete(User $user, MenuLink $menuLink)
    {
        return !$this->shadow() &&
            $this->isAdmin($user);
    }
}
