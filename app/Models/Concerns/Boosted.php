<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait Boosted
{
    /**
     * List of boosts the campaign is receiving
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignBoost, $this>
     */
    public function boosts(): HasMany
    {
        return $this->hasMany('App\Models\CampaignBoost', 'campaign_id', 'id');
    }

    /**
     * Determine if the campaign is boosted
     */
    public function boosted(bool $superboosted = false): bool
    {
        if (request()->get('_boosted') === '0') {
            return false;
        }

        return $this->boost_count > ($superboosted ? 2 : 0);
    }

    /**
     * Determine if a campaign is superboosted
     */
    public function superboosted(): bool
    {
        return $this->boosted(true);
    }

    public function legacyBoosted(): bool
    {
        return $this->boost_count > 0 && $this->boost_count < 4;
    }

    /**
     * Determine if a campaign is premium
     */
    public function premium(): bool
    {
        if (request()->get('_boosted') === '0') {
            return false;
        }

        return $this->boost_count >= 4;
    }

    /**
     * Determine if a campaign is boosted by a wyvern
     */
    public function isWyvern(): bool
    {
        $boost =  $this->boosts->first();
        return $boost?->user->isWyvern() ?? false;
    }

        /**
     * Determine if a campaign is boosted by an elemental
     */
    public function isElemental(): bool
    {
        $boost =  $this->boosts->first();
        return $boost?->user->isElemental() ?? false;
    }
}
