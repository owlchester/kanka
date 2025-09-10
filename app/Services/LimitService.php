<?php

namespace App\Services;

use App\Traits\CampaignAware;
use App\Traits\UserAware;

class LimitService
{
    use CampaignAware;
    use UserAware;

    protected bool $readable = false;

    protected bool $map = false;

    public function map(): self
    {
        $this->map = true;

        return $this;
    }

    public function readable(): self
    {
        $this->readable = true;

        return $this;
    }

    public function upload(): int|string
    {
        // Default for Owlbears and legacy Goblins/Kobolds, or members of a campaign
        $size = $this->map ? 10240 : 8192;
        if (! $this->user->isSubscriber() && (! isset($this->campaign) || ! $this->campaign->boosted())) {
            $min = config('limits.filesize.image');
            if ($this->map) {
                $min = config('limits.filesize.map');
            }
            $size = ($min * 1024);
        } elseif ($this->user->isElemental()) {
            // Anders gets higher upload sizes until we handle this in the db.
            if ($this->user->id === 34122) {
                $size = 102400;
            } else {
                $size = $this->map ? 51200 : 25600;
            }
        } elseif ($this->user->isWyvern()) {
            $size = $this->map ? 20480 : 15360;
        }

        $this->map = false;

        return $this->finalize($size);
    }

    protected function finalize(int $size): string|int
    {
        if (! $this->readable) {
            return $size;
        }
        $this->readable = false;

        return ceil($size / 1024) . 'MiB';
    }

    public function entityFiles(): int
    {
        if ($this->campaign->boosted()) {
            return config('limits.campaigns.files.premium');
        }

        return config('limits.campaigns.files.standard');
    }
}
