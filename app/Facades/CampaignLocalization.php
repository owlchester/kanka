<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 *
 * @mixin \App\Services\Campaign\LocalisationService
 *
 * @see \App\Services\Campaign\LocalisationService
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
