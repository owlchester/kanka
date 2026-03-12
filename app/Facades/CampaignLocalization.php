<?php

namespace App\Facades;

use App\Services\Campaign\LocalisationService;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 *
 * @mixin LocalisationService
 *
 * @see LocalisationService
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
