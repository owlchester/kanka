<?php

namespace App\Services\Caches;

use App\Models\Campaign;

class FrontCacheService
{
    public function featured()
    {
        $key = 'front_featured_campaigns';
        if (cache()->has($key)) {
            return cache()->get($key);
        }

        $ids = config('front.featured_campaigns');
        if (empty($ids)) {
            return [];
        }
        $ids = explode(',', $ids);

        $campaigns = Campaign::front()
            ->whereIn('id', $ids)
            ->get();

        cache()->put($key, $campaigns, 3600 * 24);
        return $campaigns;
    }
}
