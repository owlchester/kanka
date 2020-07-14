<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignUser;

class CampaignUserObserver
{
    /**
     * @param CampaignUser $campaignUser
     */
    public function saving(CampaignUser $campaignUser)
    {
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function saved(CampaignUser $campaignUser)
    {
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function created(CampaignUser $campaignUser)
    {
        // Update the campaign members cache when a user was added to the campaign
        CampaignCache::campaign($campaignUser->campaign)->clearMembers();
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function creating(CampaignUser $campaignUser)
    {
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function deleted(CampaignUser $campaignUser)
    {
        // Update the campaign members cache when a user was deleted
        CampaignCache::campaign($campaignUser->campaign)->clearMembers();
    }
}
