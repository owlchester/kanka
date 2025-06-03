<?php

namespace App\Services\Caches;

use App\Models\Bookmark;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookmarkCacheService extends BaseCache
{
    use CampaignAware;

    public function iconSuggestion(): array
    {
        $key = $this->iconSuggestionKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $data = Bookmark::where('campaign_id', $this->campaign->id)
            ->whereNotNull('icon')
            ->select(DB::raw('icon, MAX(created_at) as cmat'))
            ->groupBy('icon')
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('icon')
            ->all();

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
        return 'campaign_' . $this->campaign->id . '_bookmark_suggestions';
    }
}
