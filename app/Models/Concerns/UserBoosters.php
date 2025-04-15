<?php

namespace App\Models\Concerns;

use App\Models\Pledge;
use Illuminate\Support\Arr;

/**
 * @property
 * @property int $booster_count
 */
trait UserBoosters
{
    /**
     * Get available boosts for the user
     */
    public function availableBoosts(): int
    {
        return $this->maxBoosts() - $this->boosting();
    }

    /**
     * Get amount of campaigns the user is boosting
     */
    public function boosting(): int
    {
        if ($this->hasBoosterNomenclature()) {
            return $this->boosts->count();
        }

        return $this->boosts->groupBy('campaign_id')->count();
    }

    /**
     * Get max number of boosts a user can give
     */
    public function maxBoosts(): int
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
            return max(3, $base);
        }

        $levels = [
            Pledge::KOBOLD => 0,
            Pledge::GOBLIN => 0,
            Pledge::OWLBEAR => 1,
            Pledge::WYVERN => 3,
            Pledge::ELEMENTAL => 7,
        ];
        if ($this->hasBoosterNomenclature()) {
            $levels = [
                Pledge::KOBOLD => 0,
                Pledge::GOBLIN => 1,
                Pledge::OWLBEAR => 3,
                Pledge::WYVERN => 6,
                Pledge::ELEMENTAL => 10,
            ];
        }

        return Arr::get($levels, $this->pledge ?? 'unknown', 0) + $base;
    }
}
