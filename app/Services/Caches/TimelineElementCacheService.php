<?php

namespace App\Services\Caches;

use App\Models\TimelineElement;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TimelineElementCacheService extends BaseCache
{
    use CampaignAware;

    public function iconSuggestion(): array
    {
        $key = $this->iconSuggestionKey();

        return Cache::remember($key, 24 * 3600, function () {
            $default = [
                'ra ra-tower',
                'fa-solid fa-home',
                'ra ra-capitol',
                'fa-solid fa-skull',
                'fa-regular fa-coins',
                'ra ra-beer',
                'fa-solid fa-map-marker-alt',
                'fa-solid fa-thumbtack',
                'ra ra-wooden-sign',
                'fa-solid fa-map-pin',
            ];

            $data = TimelineElement::leftJoin('timelines as t', 't.id', 'timeline_elements.timeline_id')
                ->where('t.campaign_id', $this->campaign->id)
                ->select(DB::raw('icon, MAX(timeline_elements.created_at) as cmat'))
                ->groupBy('icon')
                ->whereNotNull('icon')
                ->orderBy('cmat', 'DESC')
                ->take(10)
                ->pluck('icon')
                ->all();

            foreach ($default as $value) {
                if (! in_array($value, $data)) {
                    $data[] = $value;
                }
            }

            return array_slice($data, 0, 10);
        });
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
        return 'campaign_' . $this->campaign->id . '_timeline_element_suggestions';
    }
}
