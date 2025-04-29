<?php

namespace App\Services\Caches;

use App\Models\QuestElement;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QuestCacheService extends BaseCache
{
    use CampaignAware;

    public function roleSuggestion(): array
    {
        $key = $this->roleSuggestionKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $data = QuestElement::select(DB::raw('role, MAX(created_at) as cmat'))
            ->groupBy('role')
            ->whereNotNull('role')
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('role')
            ->all();

        Cache::put($key, $data, 24 * 3600);

        return $data;
    }

    public function clearSuggestion(): self
    {
        $this->forget(
            $this->roleSuggestionKey()
        );

        return $this;
    }

    /**
     * Type suggestion cache key
     */
    protected function roleSuggestionKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_quest_element_role_suggestions';
    }
}
