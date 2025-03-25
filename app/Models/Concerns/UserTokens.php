<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

trait UserTokens
{
    public function hasTokens(): bool
    {
        return $this->isElemental() || $this->isWyvern() || $this->hasRole('admin') || $this->id === 158800;
    }

    public function availableTokens(): int
    {
        return max($this->maxTokens() - $this->usedTokens(), 0);
    }

    /**
     * Get the max amount of tokens for Bragi
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
        } elseif ($this->id === 158800) {
            return 20;
        }

        return config('bragi.tokens.' . $key);
    }

    /**
     * Count the number of recently used tokens (calls to the API). These reset every month for the user
     */
    public function usedTokens(): int
    {
        $subDay = $this->tokenRenewalDay();
        $currentDay = date('d');

        $date = new Carbon;
        $date->setDay($subDay);

        // If the sub was on the 7th, and we're the 3rd, move the cutoff to a month ago
        if ($subDay >= $currentDay) {
            $date->subMonth();
        }

        return $this->bragiLogs()->recent($date->format('Y-m-d'))->count();
    }

    /**
     * Get the next date the token count resets
     */
    public function tokenRenewalDate(): string
    {
        $subDay = $this->tokenRenewalDay();
        $currentDay = date('d');

        $date = new Carbon;
        $date->setDay($subDay);

        // If the sub was on the 7th, and we're the 11th, move the next date to the following month
        if ($subDay < $currentDay) {
            $date->addMonth();
        }

        return $date->format('M d, Y');
    }

    /**
     * Get the day the renewal of tokens is based on
     */
    protected function tokenRenewalDay(): int
    {
        // Admins aren't subbed, take their creation date for debugging
        if ($this->hasRole('admin')) {
            return $this->created_at->format('d');
        }
        $data = $this->subscription('kanka');

        return ! empty($data) ? $data->created_at->format('d') : 1;
    }
}
