<?php

namespace App\Services\Caches;

use App\Models\Character;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CharacterCacheService extends BaseCache
{
    use CampaignAware;

    public function genderSuggestion(): array
    {
        $key = $this->genderSuggestionKey();

        return Cache::remember($key, 24 * 3600, function () {
            return Character::select(DB::raw('sex, MAX(e.created_at) as cmat'))
                ->join('entities as e', function ($join) {
                    $join->on('e.entity_id', '=', 'characters.id')
                        ->where('e.type_id', config('entities.ids.character'));
                })
                ->groupBy('sex')
                ->whereNotNull('sex')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('sex')
                ->toArray();
        });
    }

    public function pronounSuggestion(): array
    {
        $key = $this->pronounSuggestionKey();

        return Cache::remember($key, 24 * 3600, function () {
            return Character::select(DB::raw('pronouns, MAX(e.created_at) as cmat'))
                ->join('entities as e', function ($join) {
                    $join->on('e.entity_id', '=', 'characters.id')
                        ->where('e.type_id', config('entities.ids.character'));
                })
                ->groupBy('pronouns')
                ->whereNotNull('pronouns')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('pronouns')
                ->toArray();
        });
    }

    public function clearSuggestion(): self
    {
        $this->forget(
            $this->genderSuggestionKey()
        );

        $this->forget(
            $this->pronounSuggestionKey()
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

    /**
     * Type suggestion cache key
     */
    protected function pronounSuggestionKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_character_pronoun_suggestions';
    }
}
