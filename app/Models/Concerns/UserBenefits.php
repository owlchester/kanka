<?php

namespace App\Models\Concerns;

use Illuminate\Support\Arr;

/**
 * @property
 * @property int $booster_count
 */
trait UserBenefits
{
    /**
     * Get available benefits for the user
     */
    public function availableBenefits(): int
    {
        return $this->maxBenefits() - $this->boosting();
    }

    /**
     * Get amount of campaigns the user is boosting
     */
    public function boosting(): int
    {
        if ($this->hasLegacyBoosterNomenclature()) {
            return $this->boosts->count();
        }

        return $this->boosts->groupBy('campaign_id')->count();
    }

    /**
     * Get max number of benefits a user can give
     */
    public function maxBenefits(): int
    {
        // Allows admins to give boosters to members of the community
        $base = 0;
        if (! empty($this->booster_count)) {
            $base += $this->booster_count;
        }

        if (! $this->isSubscriber()) {
            return $base;
        }

        if ($this->hasRole('admin')) {
            return max(config('limits.benefits.admin'), $base);
        }

        $levels = config('limits.benefits.standard');
        if ($this->hasLegacyBoosterNomenclature()) {
            $levels = config('limits.benefits.legacy');
        }

        return Arr::get($levels, $this->pledge ?? 'unknown', 0) + $base;
    }
}
