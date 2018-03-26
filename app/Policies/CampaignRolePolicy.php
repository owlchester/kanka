<?php

namespace App\Policies;

use App\Campaign;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    /**
     * Determine whether the user can view the campaignRole.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return mixed
     */
    public function view(User $user, CampaignRole $campaignRole)
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create campaignRoles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the campaignRole.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return mixed
     */
    public function update(User $user, CampaignRole $campaignRole)
    {
        return $user->campaign->id == $campaignRole->campaign->id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the campaignRole.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return mixed
     */
    public function delete(User $user, CampaignRole $campaignRole)
    {
        return !$campaignRole->is_admin && $user->campaign->id == $campaignRole->campaign->id && $this->isAdmin($user);
    }

    /**
     * @param User $user
     * @param CampaignRole $campaignRole
     * @return bool
     */
    public function user(User $user, CampaignRole $campaignRole)
    {
        return $user->campaign->id == $campaignRole->campaign->id && $this->isAdmin($user);
    }

    /**
     * Only allow removing users from the admin role is there is more than one user in it
     * @param User $user
     * @param CampaignRole $campaignRole
     * @return bool
     */
    public function removeUser(User $user, CampaignRole $campaignRole)
    {
        return $this->user($user, $campaignRole) && ($campaignRole->is_admin ? $campaignRole->users()->count() > 1 : true);
    }


    /**
     * @param User $user
     * @param CampaignRole $campaignRole
     * @return bool
     */
    public function permission(User $user, CampaignRole $campaignRole)
    {
        return !$campaignRole->is_admin && $user->campaign->id == $campaignRole->campaign->id && $this->isAdmin($user);
    }
}
