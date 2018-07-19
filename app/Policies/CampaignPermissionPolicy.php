<?php

namespace App\Policies;


use App\Models\Campaign;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPermissionPolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

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
        return $user->campaign->id == $campaign->id && $this->isAdmin($user);
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
        return $user->campaign->id == $campaignPermission->campaign->id && $this->isAdmin($user);
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
        return $user->campaign->id == $campaignPermission->campaign->id && $this->isAdmin($user);
    }
}
