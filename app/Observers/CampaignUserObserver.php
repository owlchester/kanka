<?php

namespace App\Observers;

use App\CampaignUser;

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
    }
}
