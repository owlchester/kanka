<?php

namespace App\Facades;

use App\Models\Campaign;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @mixin \App\Services\CampaignLocalization
 * @see \App\Services\CampaignLocalization
 */
class CampaignLocalization extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'campaignlocalization';
    }
}
