<?php


namespace App\Services\Campaign;


use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\User;

class UserService
{
    /** @var Campaign */
    protected $campaign;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param $userId
     * @param $roleId
     * @return bool
     */
    public function update(CampaignUser $user, CampaignRole $campaignRole): bool
    {
        /** @var CampaignRoleUser $role */
        $role = CampaignRoleUser::where('user_id', $user->user_id)
            ->where('campaign_role_id', $campaignRole->id)
            ->first();

        // Admin role being switched? Forget the cache
        if ($campaignRole->isAdmin()) {
            CampaignCache::campaign($campaignRole->campaign)->clearAdmins();
        }
        // Delete existing role if not admin
        if ($role) {
            $role->delete();
            return false;
        }

        CampaignRoleUser::create([
            'campaign_role_id' => $campaignRole->id,
            'user_id' => $user->user_id
        ]);
        return true;
    }
}
