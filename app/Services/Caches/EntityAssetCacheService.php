<?php

namespace App\Services\Caches;

use App\Enums\EntityAssetType;
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

        return Cache::remember($key, 24 * 3600, function () {
            $default = [
                'fa-brands fa-d-and-d-beyond',
                'ra ra-aura',
            ];

            $data = [];

            $icons = EntityAsset::leftJoin('entities as e', 'e.id', 'entity_assets.entity_id')
                ->where('e.campaign_id', $this->campaign->id)
                ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.icon")) as icon
, MAX(entity_assets.created_at) as cmat'))
                ->groupBy('metadata')
                ->whereNotNull('metadata->icon')
                ->where('entity_assets.type_id', EntityAssetType::link)
                ->orderBy('cmat', 'DESC')
                ->take(10)
                ->pluck('icon')
                ->all();

            return array_slice(array_unique(array_merge($icons, $default)), 0, 10);
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
        return 'campaign_' . $this->campaign->id . '_entity_asset_suggestions';
    }
}
