<?php

namespace App\Services;

use App\Enums\UserFlags;
use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\User;

class LimitService
{
    private ?Campaign $explicitCampaign = null;

    private ?User $explicitUser = null;

    protected bool $readable = false;

    protected bool $map = false;

    public function campaign(Campaign $campaign): self
    {
        $scoped = clone $this;
        $scoped->explicitCampaign = $campaign;

        return $scoped;
    }

    public function user(User $user): self
    {
        $scoped = clone $this;
        $scoped->explicitUser = $user;

        return $scoped;
    }

    public function map(): self
    {
        $scoped = clone $this;
        $scoped->map = true;

        return $scoped;
    }

    public function readable(): self
    {
        $scoped = clone $this;
        $scoped->readable = true;

        return $scoped;
    }

    public function upload(): int|string
    {
        $user = $this->activeUser();
        $campaign = $this->activeCampaign();

        // Default for Owlbears and legacy Goblins/Kobolds, or members of a campaign
        $min = config('limits.filesize.image.owlbear');
        if ((! $user || ! $user->isSubscriber()) && (! $campaign || ! $campaign->boosted())) {
            $min = config('limits.filesize.image.standard');
            if ($this->map) {
                $min = config('limits.filesize.map');
            }
        } elseif (($user && $user->isElemental()) || ($campaign && $campaign->isElemental())) {
            $min = config('limits.filesize.image.elemental');
        } elseif (($user && $user->isWyvern()) || ($campaign && $campaign->isWyvern())) {
            $min = config('limits.filesize.image.wyvern');
        }

        if ($user && $user->hasRole('admin') && $min < config('limits.filesize.image.admin')) {
            $min = config('limits.filesize.image.admin');
        }

        if (empty($min)) {
            return PHP_INT_MAX;
        }

        return $this->finalize($min * 1024, $user, $campaign);
    }

    protected function finalize(int $size, ?User $user, ?Campaign $campaign): string|int
    {
        if ($user && $campaign) {
            $flags = UserCache::user($user)->campaign($campaign)->flags();
        }

        if (isset($flags[UserFlags::uploadSize->value]) && $flags[UserFlags::uploadSize->value]['amount'] > ceil($size / 1024)) {
            $size = $flags[UserFlags::uploadSize->value]['amount'] * 1024;
        }

        if (! $this->readable) {
            return $size;
        }

        return ceil($size / 1024) . 'MiB';
    }

    public function entityFiles(): int
    {
        $campaign = $this->activeCampaign();
        if ($campaign && $campaign->boosted()) {
            return config('limits.campaigns.files.premium');
        }

        return config('limits.campaigns.files.standard');
    }

    protected function activeCampaign(): ?Campaign
    {
        if ($this->explicitCampaign) {
            return $this->explicitCampaign;
        }

        return CampaignLocalization::hasCampaign() ? CampaignLocalization::getCampaign() : null;
    }

    protected function activeUser(): ?User
    {
        return $this->explicitUser ?? auth()->user();
    }
}
