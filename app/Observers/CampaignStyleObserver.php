<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignStyle;

class CampaignStyleObserver
{
    public function saving(CampaignStyle $campaignStyle)
    {
        $campaignStyle->content = str_replace(['&gt;', '{{', '}}'], ['>', '', ''], strip_tags($campaignStyle->content));
    }

    public function creating(CampaignStyle $campaignStyle)
    {
        $last = $campaignStyle->campaign->styles()->max('order');
        $campaignStyle->order = (int) $last + 1;
    }

    public function saved()
    {
        CampaignCache::clearTheme();
    }
}
