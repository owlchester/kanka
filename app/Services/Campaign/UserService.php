<?php


namespace App\Services\Campaign;


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
        $role = CampaignRoleUser::where('user_id', $user->user_id)
            ->where('campaign_role_id', $campaignRole->id)
            ->first();

        // Delete existing role if not admin
        if ($role) {
            // This check shouldn't happen since updating a campaign_role_user is forbidden if they
            // are an admin.
            if ($role->campaignRole->is_admin) {
                dd('admin role, no no');
            }
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
