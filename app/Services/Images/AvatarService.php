<?php

namespace App\Services\Images;

use App\Facades\CampaignCache;
use App\Facades\Img;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    use CampaignAware;
    use EntityAware;

    protected MiscModel $child;

    protected string $field = 'image';
    protected bool $fallback = false;

    protected int $width;
    protected int $height;

    protected bool $withCache = false;

    public function child(MiscModel $miscModel): self
    {
        $this->child = $miscModel;
        return $this;
    }

    public function field(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function cached(): self
    {
        $this->withCache = true;
        return $this;
    }

    public function size(int $width, int $height = 0): self
    {
        $this->width = $width;
        $this->height = !empty($height) ? $height : $width;
        return $this;
    }

    public function fallback(): self
    {
        $this->fallback = true;
        return $this;
    }

    public function reset(): self
    {
        $this->field = 'image';
        $this->fallback = false;
        $this->withCache = false;
        unset($this->entity, $this->child);

        return $this;
    }

    public function thumbnail(): string
    {
        if (!$this->hasImage()) {
            return $this->fallbackThumbnail();
        }

        if ($this->onEntity()) {
            return $this->entity->image->getUrl($this->width, $this->height);
        }
        return $this->childThumbnail();
    }

    /**
     * Get the full url of the original images
     */
    public function original(): string
    {
        if (!$this->hasImage()) {
            return '';
        }
        if ($this->onEntity()) {
            return $this->entity->image->url();
        }
        $path = $this->childThumbnailPath();
        $cloudfront = config('filesystems.disks.cloudfront.url');
        if ($cloudfront) {
            return Storage::disk('cloudfront')->url($path);
        }
        return Storage::url($path);
    }

    protected function onEntity(): bool
    {
        return !empty($this->entity->image);
    }

    protected function childThumbnail(): string
    {
        $url = $this->childThumbnailPath();
        if (empty($url)) {
            return $this->fallbackThumbnail();
        }

        $img = Img::resetCrop()->crop($this->width, $this->height);

        if (!empty($this->width)) {
            if (!empty($this->entity->focus_x) && !empty($this->entity->focus_y)) {
                $img = $img->focus($this->entity->focus_x, $this->entity->focus_y);
            }
        }
        return $this->return(
            $img->url($url)
        );
    }

    public function hasImage(): bool
    {
        return $this->entity->image || !empty($this->childThumbnailPath());
    }

    protected function fallbackThumbnail(): string
    {
        if (!$this->fallback) {
            return $this->return('');
        }

        $cloudfront = config('filesystems.disks.cloudfront.url');
        if ($this->campaign->boosted() && Arr::has(CampaignCache::defaultImages(), $this->entity->entityType->code)) {
            $url = Img::crop($this->width, $this->height)
                ->url(CampaignCache::defaultImages()[$this->entity->entityType->code]);
            return $this->return($url);
        } elseif ($this->campaign->premium() || (auth()->check() && auth()->user()->isGoblin())) {
            // Goblins and above have nicer icons
            return $this->return($cloudfront . '/images/defaults/subscribers/' . $this->entity->pluralType() . '.jpeg');
        }

        // Default fallback
        return $this->return($cloudfront . '/images/defaults/thumbnail.jpg');
    }

    protected function return(string $url): string
    {
        $this->reset();
        return $url;
    }

    protected function getChild(): MiscModel
    {
        if (isset($this->child)) {
            return $this->child;
        }
        return $this->child = $this->entity->child;
    }

    protected function childThumbnailPath(): string|null
    {
        return $this->entity->image_path;
    }

    public function forget(): void
    {
        Cache::forget($this->cacheKey());
    }

    protected function cacheKey(): string
    {
        return 'entity_' . $this->entity->id . '_avatar_v3';
    }
}
