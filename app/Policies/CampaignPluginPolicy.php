<?php

namespace App\Policies;

use App\Models\CampaignPlugin;
use App\Models\User;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPluginPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the campaignPermission.
     */
    public function enable(User $user, CampaignPlugin $campaignPlugin)
    {
        return $this->isAdmin($user);
    }
}
