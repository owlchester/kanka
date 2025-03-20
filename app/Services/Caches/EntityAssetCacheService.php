<?php

namespace App\Services\Caches;

use App\Models\EntityAsset;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EntityAssetCacheService extends BaseCache
{
    use CampaignAware;

    public function iconSuggestion(): array
    {
        $key = $this->iconSuggestionKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $default = [
            'fa-brands fa-d-and-d-beyond',
            'ra ra-aura',
        ];

        $data = [];

        $settings = EntityAsset::leftJoin('entities as e', 'e.id', 'entity_assets.entity_id')
            ->where('e.campaign_id', $this->campaign->id)
            ->select(DB::raw('metadata, MAX(entity_assets.created_at) as cmat'))
            ->groupBy('metadata')
            ->whereNotNull('metadata->icon')
            ->where('entity_assets.type_id', EntityAsset::TYPE_LINK)
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('metadata')
            ->all();

        foreach ($settings as $setting) {
            $data[] = $setting['icon'];
        }

        foreach ($default as $value) {
            if (! in_array($value, $data)) {
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
        return 'campaign_' . $this->campaign->id . '_entity_asset_suggestions';
    }
}
