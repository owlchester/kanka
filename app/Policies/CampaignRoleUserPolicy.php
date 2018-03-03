<?php

namespace App\Policies;

use App\Campaign;
use App\User;
use App\Models\CampaignRoleUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRoleUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function view(User $user, CampaignRoleUser $campaignRoleUser)
    {
        return $user->owner();
    }

    /**
     * Determine whether the user can create campaignRoleUsers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Campaign $campaign)
    {
        return $user->campaign->id == $campaign->id && $user->owner();
    }

    /**
     * Determine whether the user can update the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function update(User $user, CampaignRoleUser $campaignRoleUser)
    {
        return $user->campaign->id == $campaignRoleUser->campaign->id && $user->owner();
    }

    /**
     * Determine whether the user can delete the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function delete(User $user, CampaignRoleUser $campaignRoleUser)
    {
        return $user->campaign->id == $campaignRoleUser->campaign->id && $user->owner();
    }
}
