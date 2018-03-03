<?php

namespace App\Policies;

use App\Campaign;
use App\User;
use App\Models\CampaignRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaignRole.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return mixed
     */
    public function view(User $user, CampaignRole $campaignRole)
    {
        return $user->owner();
    }

    /**
     * Determine whether the user can create campaignRoles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->owner();
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
        return $user->campaign->id == $campaignRole->campaign->id && $user->owner();
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
        return $user->campaign->id == $campaignRole->campaign->id && $user->owner();
    }

    /**
     * @param User $user
     * @param CampaignRole $campaignRole
     * @return bool
     */
    public function user(User $user, CampaignRole $campaignRole)
    {
        return $user->campaign->id == $campaignRole->campaign->id && $user->owner();
    }


    /**
     * @param User $user
     * @param CampaignRole $campaignRole
     * @return bool
     */
    public function permission(User $user, CampaignRole $campaignRole)
    {
        return $user->campaign->id == $campaignRole->campaign->id && $user->owner();
    }


}
