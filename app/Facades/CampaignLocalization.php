<?php

namespace App\Facades;

use App\Models\Campaign;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @method static Campaign getCampaign()
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
