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

        return Cache::remember($key, 24 * 3600, function () {
            return Bookmark::where('campaign_id', $this->campaign->id)
                ->whereNotNull('icon')
                ->select(DB::raw('icon, MAX(created_at) as cmat'))
                ->groupBy('icon')
                ->orderBy('cmat', 'DESC')
                ->take(10)
                ->pluck('icon')
                ->toArray();
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
        return 'campaign_' . $this->campaign->id . '_bookmark_suggestions';
    }
}
