<?php

namespace App\Services\Caches;

use App\Models\Bookmark;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookmarkCacheService extends BaseCache
{
    use CampaignAware;

    /**
     */
    public function iconSuggestion(): array
    {
        $key = $this->iconSuggestionKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $default = [
            'ra ra-tower',
            'fa-solid fa-home',
            'ra ra-capitol',
            'ra ra-skull',
            'fa-solid fa-coins',
            'ra ra-beer',
            'fa-solid fa-map-marker-alt',
            'fa-solid fa-thumbtack',
            'ra ra-wooden-sign',
            'fa-solid fa-map-pin'
        ];


        $data = Bookmark::where('campaign_id', $this->campaign->id)
            ->whereNotNull('icon')
            ->select(DB::raw('icon, MAX(created_at) as cmat'))
            ->groupBy('icon')
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('icon')
            ->all();


        foreach ($default as $value) {
            if (!in_array($value, $data)) {
                $data[] = $value;
            }
        }

        $data = array_slice($data, 0, 10);

        Cache::put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearSuggestion(): self
    {
        $this->forget(
            $this->iconSuggestionKey()
        );
        return $this;
    }


    /**
     * Type suggestion cache key
     */
    protected function iconSuggestionKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_bookmark_suggestions';
    }
}
