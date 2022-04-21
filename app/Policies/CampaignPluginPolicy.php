<?php

namespace App\Policies;

use App\Models\CampaignPermission;
use App\Models\CampaignPlugin;
use App\Traits\AdminPolicyTrait;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPluginPolicy
{
    use HandlesAuthorization, AdminPolicyTrait;


    /**
     * Determine whether the user can delete the campaignPermission.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignPermission  $campaignPermission
     * @return mixed
     */
    public function enable(User $user, CampaignPlugin $campaignPlugin)
    {
        return $user->campaign->id == $campaignPlugin->campaign_id && $this->isAdmin($user);
    }
}
