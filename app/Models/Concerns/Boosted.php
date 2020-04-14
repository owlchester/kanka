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
     * @return bool
     */
    public function boosted(): bool
    {
        return $this->boost_count > 0;
    }
}
