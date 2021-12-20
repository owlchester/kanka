<?php

namespace App\Facades;

use App\Models\Campaign;
use App\Models\CampaignSetting;
use App\Models\MiscModel;
use App\Models\Plugin;
use App\Models\PluginVersion;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\EntityCacheService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @see \App\Services\Caches\CampaignCacheService
 * @mixin \App\Services\Caches\CampaignCacheService
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
