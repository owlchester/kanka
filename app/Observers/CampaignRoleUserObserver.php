<?php

namespace App\Observers;

use App\Facades\UserCache;
use App\Jobs\CampaignRoleUserJob;
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
        CampaignRoleUserJob::dispatch($campaignRoleUser, true);
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
        CampaignRoleUserJob::dispatch($campaignRoleUser, false);
        UserCache::user($campaignRoleUser->user)->clearRoles();
    }
}
