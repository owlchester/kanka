<?php

namespace App\Services\Gallery;

use App\Facades\CampaignCache;
use App\Models\Image;
use App\Traits\CampaignAware;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class StorageService
{
    use CampaignAware;

    protected int $used;

    protected int $total;

    /**
     * Size in mb
     */
    public function usedSpace(): int
    {
        if (isset($this->used)) {
            return $this->used;
        }

        return $this->used = Cache::remember($this->cacheKey(), 24 * 3600, function () {
            return $this->campaignImages()->sum('size');
        });
    }

    public function uncachedUsedSpace(): int
    {
        return $this->campaignImages()->sum('size');
    }

    /**
     * Available space in KB
     */
    public function available(): int
    {
        return $this->totalSpace() - $this->usedSpace();
    }

    public function isUnlimited(): bool
    {
        $flags = CampaignCache::campaign($this->campaign)->flags();
        if ($flags->has('gallery') || $this->campaign->boosted()) {
            return false;
        }

        return empty(config('limits.gallery.standard'));
    }

    /**
     * Total size in mb
     */
    public function totalSpace(): int
    {
        $flags = CampaignCache::campaign($this->campaign)->flags();
        if ($flags->has('gallery')) {
            return $flags->get('gallery');
        }
        if ($this->campaign->boosted()) {
            if ($this->campaign->isWyvern()) {
                return config('limits.gallery.wyvern');
            } elseif ($this->campaign->isElemental()) {
                return config('limits.gallery.elemental');
            }

            return config('limits.gallery.premium');
        }

        $standard = config('limits.gallery.standard');
        if (empty($standard)) {
            return PHP_INT_MAX;
        }

        return $standard;
    }

    protected function cacheKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_gallery';
    }

    protected function campaignImages(): Builder
    {
        return Image::withoutGlobalScopes()->where('campaign_id', $this->campaign->id);
    }

    public function clearCache(): self
    {
        Cache::forget($this->cacheKey());
        unset($this->used);

        return $this;
    }
}
