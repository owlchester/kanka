<?php

namespace App\Policies;


use App\Campaign;
use App\User;
use App\Models\CampaignPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaignPermission.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignPermission  $campaignPermission
     * @return mixed
     */
    public function view(User $user, CampaignPermission $campaignPermission)
    {
        //
    }

    /**
     * Determine whether the user can create campaignPermissions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Campaign $campaign)
    {
        return $user->campaign->id == $campaign->id && $user->owner();
    }

    /**
     * Determine whether the user can update the campaignPermission.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignPermission  $campaignPermission
     * @return mixed
     */
    public function update(User $user, CampaignPermission $campaignPermission)
    {
        return $user->campaign->id == $campaignPermission->campaign->id && $user->owner();
    }

    /**
     * Determine whether the user can delete the campaignPermission.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignPermission  $campaignPermission
     * @return mixed
     */
    public function delete(User $user, CampaignPermission $campaignPermission)
    {
        return $user->campaign->id == $campaignPermission->campaign->id && $user->owner();
    }
}
