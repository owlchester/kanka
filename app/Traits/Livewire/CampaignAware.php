<?php

namespace App\Traits\Livewire;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use App\Facades\UserCache;

trait CampaignAware
{
    public function setCampaign()
    {
        CampaignLocalization::forceCampaign($this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);
        Permissions::campaign($this->campaign);
    }
}
