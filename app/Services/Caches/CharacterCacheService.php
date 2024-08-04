<?php

namespace App\Services\Caches;

use App\Models\Character;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CharacterCacheService extends BaseCache
{
    use CampaignAware;

    /**
     */
    public function genderSuggestion(): array
    {
        $key = $this->genderSuggestionKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $data = Character::select(DB::raw('sex, MAX(created_at) as cmat'))
            ->groupBy('sex')
            ->whereNotNull('sex')
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('sex')
            ->all();


        Cache::put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearSuggestion(): self
    {
        $this->forget(
            $this->genderSuggestionKey()
        );

        return $this;
    }


    /**
     * Type suggestion cache key
     */
    protected function genderSuggestionKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_character_gender_suggestions';
    }
}
