<?php

namespace App\Observers;

use App\Facades\UserCache;
use App\Models\CampaignRoleUser;
use App\Notifications\Header;

class CampaignRoleUserObserver
{
    /**
     * @param CampaignRoleUser $campaignRoleUser
     */
    public function saving(CampaignRoleUser $campaignRoleUser)
    {
    }

    /**
     * @param CampaignRoleUser $campaignRoleUser
     */
    public function saved(CampaignRoleUser $campaignRoleUser)
    {
    }

    /**
     * @param CampaignRoleUser $campaignRoleUser
     */
    public function created(CampaignRoleUser $campaignRoleUser)
    {
        $notification = new Header(
            'campaign.role.add',
            'user',
            'green',
            [
                'role' => e($campaignRoleUser->campaignRole->name),
                'campaign' => e($campaignRoleUser->campaignRole->campaign->name)
            ]
        );
        $campaignRoleUser->user->notify($notification);

        UserCache::user($campaignRoleUser->user)->clearRoles();
    }

    /**
     * @param CampaignRoleUser $campaignRoleUser
     */
    public function creating(CampaignRoleUser $campaignRoleUser)
    {
    }

    /**
     * @param CampaignRoleUser $campaignRoleUser
     */
    public function deleted(CampaignRoleUser $campaignRoleUser)
    {
        $notification = new Header(
            'campaign.role.remove',
            'user',
            'green',
            [
                'role' => $campaignRoleUser->campaignRole->name,
                'campaign' => $campaignRoleUser->campaignRole->campaign->name
            ]
        );
        $campaignRoleUser->user->notify($notification);

        UserCache::user($campaignRoleUser->user)->clearRoles();
    }
}
