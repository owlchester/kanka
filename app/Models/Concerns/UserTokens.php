<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

trait UserTokens
{


    public function availableTokens(): int
    {
        return $this->maxTokens() - $this->usedTokens();
    }

    /**
     * Get the max amount of tokens for Bragi
     * @return int
     */
    public function maxTokens(): int
    {
        $key = 'all';
        if ($this->hasRole('admin')) {
            $key = 'admin';
        } elseif ($this->isElemental()) {
            $key = 'elemental';
        } elseif ($this->isWyvern()) {
            $key = 'wyvern';
        }
        return config('bragi.tokens.' . $key);
    }

    /**
     * Count the number of recently used tokens (calls to the API). These reset every month for the user
     * @return int
     */
    public function usedTokens(): int
    {
        $data = $this->subscription('kanka');
        $subDay = $data->created_at->format('d');
        $currentDay = date('d');

        $date = new Carbon();
        $date->setDay($subDay);

        // If the sub was on the 7th, and we're the 3rd, move the cutoff to a month ago
        if ($subDay >= $currentDay) {
            $date->subMonth();
        }
        return $this->bragiLogs()->recent($date->format('Y-m-d'))->count();
    }

    /**
     * Get the next date the token count resets
     * @return string
     */
    public function tokenRenewalDate(): string
    {
        $data = $this->subscription('kanka');
        $subDay = $data->created_at->format('d');
        $currentDay = date('d');

        $date = new Carbon();
        $date->setDay($subDay);

        // If the sub was on the 7th, and we're the 11th, move the next date to the following month
        if ($subDay < $currentDay) {
            $date->addMonth();
        }

        return $date->format('M d, Y');
    }
}
