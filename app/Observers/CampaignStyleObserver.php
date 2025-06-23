<?php

namespace App\Observers;

use App\Events\Campaigns\Styles\StyleCreated;
use App\Events\Campaigns\Styles\StyleDeleted;
use App\Events\Campaigns\Styles\StyleUpdated;
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

    public function created(CampaignStyle $campaignStyle)
    {
        ThumbnailCreated::dispatch($campaignStyle, auth()->user());
    }

    public function updated(CampaignStyle $campaignStyle)
    {
        StyleUpdated::dispatch($campaignStyle, auth()->user());
    }

    public function deleted(CampaignStyle $campaignStyle)
    {
        StyleDeleted::dispatch($campaignStyle, auth()->user());
    }
}
