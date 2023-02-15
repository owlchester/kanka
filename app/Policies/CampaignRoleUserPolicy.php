<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignRoleUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRoleUserPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;


    /**
     * Determine whether the user can delete the campaignRoleUser.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRoleUser  $campaignRoleUser
     * @return mixed
     */
    public function delete(User $user, CampaignRoleUser $campaignRoleUser, CampaignRole $campaignRole)
    {
        // Only campaign admins can remove a user from a campaign role
        return $campaignRoleUser->campaign_role_id == $campaignRole->id && $user->isAdmin();
    }
}
