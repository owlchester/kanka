<?php

namespace App\Services\Caches;

use App\Models\MapMarker;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MapMarkerCacheService extends BaseCache
{
    use CampaignAware;

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
            'fa-solid fa-skull',
            'fa-solid fa-coins',
            'ra ra-beer',
            'fa-solid fa-map-marker-alt',
            'fa-solid fa-thumbtack',
            'ra ra-wooden-sign',
            'fa-solid fa-map-pin',
        ];

        $data = MapMarker::leftJoin('maps as m', 'm.id', 'map_markers.map_id')
            ->where('m.campaign_id', $this->campaign->id)
            ->select(DB::raw('custom_icon, MAX(map_markers.created_at) as cmat'))
            ->groupBy('custom_icon')
            ->whereNotNull('custom_icon')
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('custom_icon')
            ->all();

        foreach ($default as $value) {
            if (! in_array($value, $data)) {
                $data[] = $value;
            }
        }

        $data = array_slice($data, 0, 10);

        Cache::put($key, $data, 24 * 3600);

        return $data;
    }

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
        return 'campaign_' . $this->campaign->id . '_map_marker_suggestions';
    }
}
