<?php

namespace App\Facades;

use App\Models\Campaign;
use App\Models\MiscModel;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\EntityCacheService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @method static self campaign(Campaign $campaign)
 * @method static Collection members(string $type = 'all')
 * @method static self|CampaignCacheService clearMembers(string $type = 'all')
 * @method static int entityCount(string $type = null)
 * @method static int followerCount()
 * @method static self|CampaignCacheService clearFollowerCount()
 * @method static Collection roles()
 *
 * @see \App\Services\Caches\CampaignCacheService
 */
class CampaignCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'campaigncache';
    }
}
