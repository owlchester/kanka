<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignStyle;

class CampaignStyleObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     */
    public function saving(CampaignStyle $campaignStyle)
    {
        $campaignStyle->name = $this->purify($campaignStyle->name);
        $campaignStyle->content = str_replace(['&gt;', '{{', '}}'], ['>', '', ''], strip_tags($campaignStyle->content));
    }

    /**
     */
    public function creating(CampaignStyle $campaignStyle)
    {
        $campaignStyle->created_by = auth()->user()->id;

        $last = $campaignStyle->campaign->styles()->max('order');
        $campaignStyle->order = (int) $last + 1;
    }

    public function saved()
    {
        CampaignCache::clearTheme();
    }
}
