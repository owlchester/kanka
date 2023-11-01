<?php

namespace App\Models\Concerns;

trait Boosted
{
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
}
