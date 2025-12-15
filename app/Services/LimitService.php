<?php

namespace App\Services;

use App\Enums\UserFlags;
use App\Facades\UserCache;
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
        $min = config('limits.filesize.image.owlbear');
        if (! $this->user->isSubscriber() && (! isset($this->campaign) || ! $this->campaign->boosted())) {
            $min = config('limits.filesize.image.standard');
            if ($this->map) {
                $min = config('limits.filesize.map');
            }
        } elseif ($this->user->isElemental() || (isset($this->campaign) && $this->campaign->isElemental())) {
            $min = config('limits.filesize.image.elemental') * 1024;
        } elseif ($this->user->isWyvern() || (isset($this->campaign) && $this->campaign->isWyvern())) {
            $min = config('limits.filesize.image.wyvern');
        }

        $size = ($min * 1024);

        $this->map = false;

        return $this->finalize($size);
    }

    protected function finalize(int $size): string|int
    {
        if (isset($this->campaign)) {
            $flags = UserCache::user($this->user)->campaign($this->campaign)->flags();
        }

        if (isset($flags[UserFlags::uploadSize->value]) && $flags[UserFlags::uploadSize->value]['amount'] > ceil($size / 1024)) {
            $size = $flags[UserFlags::uploadSize->value]['amount'] * 1024;
        }

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
