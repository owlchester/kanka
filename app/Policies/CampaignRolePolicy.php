<?php

namespace App\Policies;

use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\CampaignRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignRolePolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the campaignRole.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CampaignRole  $campaignRole
     * @return mixed
     */
    public function update(User $user, CampaignRole $campaignRole)
    {
        return $this->isAdmin($user);
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
        return !$campaignRole->is_admin && !$campaignRole->is_public
            && $this->isAdmin($user);
    }
}
