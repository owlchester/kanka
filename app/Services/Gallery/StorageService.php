<?php

namespace App\Services\Gallery;

use App\Facades\CampaignCache;
use App\Models\Image;
use App\Traits\CampaignAware;
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
        $key = $this->cacheKey();
        if (Cache::has($key)) {
            return $this->used = Cache()->get($key);
        }
        $this->used = Image::sum('size');
        Cache::put($key, $this->used, 24 * 3600);

        return $this->used;
    }

    public function uncachedUsedSpace(): int
    {
        return Image::sum('size');
    }

    /**
     * Available space in KB
     */
    public function available(): int
    {
        return $this->totalSpace() - $this->usedSpace();
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

        return config('limits.gallery.standard');
    }

    protected function cacheKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_gallery';
    }

    public function clearCache(): self
    {
        Cache::forget($this->cacheKey());

        return $this;
    }
}
