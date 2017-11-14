<?php

namespace App\Traits;

use App\Scopes\CampaignScope;

trait CampaignTrait
{
    public static function bootCampaignTrait()
    {
        static::addGlobalScope(new CampaignScope());
    }
}
