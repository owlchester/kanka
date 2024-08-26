<?php

namespace App\Services\Gallery;

use App\Enums\Visibility;
use App\Facades\Avatar;
use App\Http\Requests\Campaigns\GalleryImageStore;
use App\Http\Requests\StoreImageFocus;
use App\Models\Image;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        if ($this->campaign->boosted()) {
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
