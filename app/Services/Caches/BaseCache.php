<?php

namespace App\Services\Caches;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseCache
 * @package App\Services\Caches
 */
abstract class BaseCache
{
    use CacheAware;
    use CampaignAware;
    use UserAware;

    /**
     * EntityCacheService constructor.
     */
    public function __construct()
    {
        $this->campaign = CampaignLocalization::hasCampaign() ? CampaignLocalization::getCampaign() : null;
        $this->user = Auth::check() ? Auth::user() : null;
    }

}
