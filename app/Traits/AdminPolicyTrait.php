<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;
use App\User;

trait AdminPolicyTrait
{
    /**
     * Cached value of the check
     * @var bool
     */
    protected bool $cachedAdminPolicy;

    /**
     * Determine if a user is admin of a campaign
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user)
    {
        if (isset($this->cachedAdminPolicy)) {
            return $this->cachedAdminPolicy;
        }
        $this->cachedAdminPolicy = false;
        $campaign = CampaignLocalization::getCampaign();
        /** @var CampaignRole[] $roles */
        $roles = $user->campaignRoles->where('campaign_id', $campaign->id);
        foreach ($roles as $role) {
            if ($role->is_admin) {
                $this->cachedAdminPolicy = true;
            }
        }

        return $this->cachedAdminPolicy;
    }
}
