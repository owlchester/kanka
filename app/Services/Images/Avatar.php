<?php

namespace App\Services\Images;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Avatar
{
    private ?Campaign $campaign = null;

    private ?User $user = null;

    private bool $fallback = false;

    private int $width = 0;

    private int $height = 0;

    private function __construct(
        private readonly Entity $entity,
    ) {}

    public static function for(Entity $entity): self
    {
        return new self($entity);
    }

    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function user(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function size(int $width, int $height = 0): self
    {
        $this->width = $width;
        $this->height = $height > 0 ? $height : $width;

        return $this;
    }

    public function fallback(bool $fallback = true): self
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function hasImage(): bool
    {
        return ! empty($this->entity->image) || ! empty($this->childThumbnailPath());
    }

    public function thumbnail(): string
    {
        if (! $this->hasImage()) {
            return $this->fallbackThumbnail();
        }

        if ($this->onEntity()) {
            return $this->entity->image->getUrl($this->width, $this->height);
        }

        return $this->childThumbnail();
    }

    /**
     * Get the full url of the original image
     */
    public function original(): string
    {
        if (! $this->hasImage()) {
            return '';
        }

        if ($this->onEntity()) {
            return $this->entity->image->url();
        }

        $path = $this->childThumbnailPath();
        $cdn = config('cdn.ugc');
        if ($cdn) {
            return $cdn . '/' . $path;
        }

        return Storage::url($path);
    }

    protected function onEntity(): bool
    {
        return ! empty($this->entity->image);
    }

    protected function childThumbnail(): string
    {
        $url = $this->childThumbnailPath();
        if (empty($url)) {
            return $this->fallbackThumbnail();
        }

        $img = Img::resetCrop()->crop($this->width, $this->height);

        if (! empty($this->width) && ! empty($this->entity->focus_x) && ! empty($this->entity->focus_y)) {
            $img = $img->focus($this->entity->focus_x, $this->entity->focus_y);
        }

        return $img->url($url);
    }

    protected function fallbackThumbnail(): string
    {
        if (! $this->fallback) {
            return '';
        }

        $campaign = $this->resolveCampaign();
        $entityType = $this->entity->entityType;
        $defaultImages = $campaign ? CampaignCache::campaign($campaign)->defaultImages() : [];

        if ($entityType && Arr::has($defaultImages, $entityType->code)) {
            return Img::crop($this->width, $this->height)
                ->url($defaultImages[$entityType->code]);
        }

        $user = $this->user ?? auth()->user();

        if ($entityType && $entityType->isStandard() && (($campaign && $campaign->premium()) || ($user instanceof User && $user->isGoblin()))) {
            return asset('/images/defaults/subscribers/' . $entityType->pluralCode() . '.jpeg');
        }

        return asset('/images/defaults/thumbnail.jpg');
    }

    protected function resolveCampaign(): ?Campaign
    {
        if ($this->campaign) {
            return $this->campaign;
        }

        if (CampaignLocalization::hasCampaign()) {
            return CampaignLocalization::getCampaign();
        }

        return $this->entity->campaign;
    }

    protected function childThumbnailPath(): ?string
    {
        return $this->entity->image_path;
    }
}
