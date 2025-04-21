<?php

namespace App\Observers;

use App\Enums\UserAction;
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

    public function created(CampaignStyle $campaignStyle)
    {

        auth()->user()->campaignLog($campaignStyle->campaign_id, 'styles', 'created', ['id' => $campaignStyle->id]);
    }

    public function updated(CampaignStyle $campaignStyle)
    {
        auth()->user()->campaignLog($campaignStyle->campaign_id, 'styles', 'updated', ['id' => $campaignStyle->id]);
    }

    public function deleted(CampaignStyle $campaignStyle)
    {
        auth()->user()->campaignLog($campaignStyle->campaign_id, 'styles', 'deleted', ['id' => $campaignStyle->id]);
    }
}
