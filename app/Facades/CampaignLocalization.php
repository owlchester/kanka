<?php

namespace App\Facades;

use App\Models\Campaign;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @method static Campaign getCampaign()
 * @method static int getConsoleCampaign()
 * @method static self setConsoleCampaign(int $campaignId)
 * @method static void forceCampaign(Campaign $campaign)
 *
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
