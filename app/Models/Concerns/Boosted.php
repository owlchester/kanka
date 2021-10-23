<?php

namespace App\Models\Concerns;

trait Boosted
{
    /**
     * Cached boost value
     * @var null
     */
    protected $cachedBoosted = null;

    /**
     * List of boosts the campaign is receiving
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boosts()
    {
        return $this->hasMany('App\Models\CampaignBoost', 'campaign_id', 'id');
    }

    /**
     * Determine if the campaign is boosted
     * @param bool $superboosted false
     * @return bool
     */
    public function boosted(bool $superboosted = false): bool
    {
        return $this->boost_count > ($superboosted ? 2 : 0);
    }

    /**
     * @return bool
     */
    public function superboosted(): bool
    {
        return $this->boosted(true);
    }
}
