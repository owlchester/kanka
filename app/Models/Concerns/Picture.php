<?php

namespace App\Models\Concerns;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Models\MiscModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait Picture
{
    private int $avatarWidth = 40;
    private int $avatarHeight = 40;
    private bool $cropped = true;

    private bool $hasNoImage;

    /**
     * Set the avatar size (defaults to 40)
     */
    public function avatarSize(int $width, int $height = null): self
    {
        $this->avatarWidth = $width;
        $this->avatarHeight = $height ?? $width;
        return $this;
    }

    public function fullsize(): self
    {
        $this->cropped = false;
        return $this;
    }

    /**
     * @return string
     */
    public function avatar(bool $thumb = false, string $field = 'image')
    {
        dd('deprecated Picture::avatar() call');
        $size = $thumb ? '_thumb' : ($this->avatarWidth != 40 ? '_mid' : null);
        $avatar = Cache::get($this->avatarCacheKey($field, $size), false);
        if ($avatar === false) {
            $avatar = $this->cacheAvatar($field, $size);
        }
        return $this->avatarUrl($avatar);
    }

    /**
     * @return string
     */
    protected function cacheAvatar(string $field, string $size = null)
    {
        // Can't get the child? Something is weird, let's cache something empty rather than crash the user
        if (empty($this->child)) {
            return '';
        }
        // Todo: we are caching with the user's nicer image here
        $avatar = $this->child->withEntity($this)->thumbnail($this->avatarWidth);
        Cache::forever($this->avatarCacheKey($field, $size), $avatar);
        return $avatar;
    }

    /**
     * @return string
     */
    protected function avatarUrl(string $avatar)
    {
        // If it's a default image, subscribers have the nicer pictures.
        // Why do we do this here? Because it's based on the user, so it can't go in cache
        if (Str::contains($avatar, '/images/defaults/') && !Str::contains($avatar, '/subscribers/')) {
            // Check if the campaign has a default image first
            $campaign = CampaignLocalization::getCampaign();
            if ($campaign->boosted() && Arr::has(CampaignCache::defaultImages(), $this->type())) {
                return Img::crop($this->avatarWidth, $this->avatarHeight)
                    ->url(CampaignCache::defaultImages());
            }

            if (auth()->check() && auth()->user()->isGoblin()) {
                $avatar = Str::before($avatar, '_thumb');
                return Str::replace(['defaults/', '.jpg'], ['defaults/subscribers/', '.jpeg'], $avatar);
            }
        }

        return $avatar;
    }

    /**
     * Clear cached images.
     */
    public function clearAvatarCache()
    {
        $fields = ['image'];
        foreach ($fields as $field) {
            // Ful image
            $image = $this->avatarCacheKey($field);
            Cache::forget($image);

            // Thumbs
            $image = $this->avatarCacheKey($field, '_thumb');
            Cache::forget($image);
            $image = $this->avatarCacheKey($field, '_mid');
            Cache::forget($image);

            // V2
            $image = $this->avatarCacheKey($field . '_v2');
            Cache::forget($image);
        }
    }

    /**
     */
    protected function avatarCacheKey(string $field, string $size = null): string
    {
        return 'entity_picture_' . $this->id . '_' . $field . $size;
    }

    /**
     * V2 of avatars, where instead of saving the full path, we only save the relative path, so that
     * we can get any image size
     */
    public function avatarV2(MiscModel $child = null): string
    {
        $key = $this->avatarCacheKey('image_v2');
        $cached = Cache::get($key, false);
        $campaign = CampaignLocalization::getCampaign();
        if ($cached === false) {
            $child = $child ?? $this->child;
            $avatar = '';
            $focus = null;
            // No valid attached child
            if (!$child) {
                //$avatar = '';
            } elseif ($this->image) {
                $avatar = $this->image->path;
                if (!empty($this->image->focus_x) && !empty($this->image->focus_y)) {
                    $focus = [$this->image->focus_x, $this->image->focus_y];
                }
            } elseif (!empty($child->image)) {
                $avatar = $child->image;

                if (!empty($this->focus_x) && !empty($this->focus_y)) {
                    $focus = [$this->focus_x, $this->focus_y];
                }
            }

            Cache::forever($key, ['url' => $avatar, 'focus' => $focus]);
        } else {
            $avatar = Arr::get($cached, 'url');
            $focus = Arr::get($cached, 'focus');
        }
        $this->hasNoImage = false;

        // If the image is empty, look if the user has a nice picture
        if (empty($avatar)) {
            // Superboosted and with image?
            if ($this->image) {
                return Img::crop($this->avatarWidth, $this->avatarHeight)->url($this->image->path);
            } elseif ($campaign->boosted() && Arr::has(CampaignCache::defaultImages(), $this->type())) {
                // Fallback, boosted default image?
                return Img::crop($this->avatarWidth, $this->avatarHeight)->url(CampaignCache::defaultImages()[$this->type()]);
            }

            if (auth()->check() && auth()->user()->isGoblin()) {
                // Goblins and above have nicer icons
                return '/images/defaults/subscribers/' . $this->pluralType() . '.jpeg';
            }
            $this->hasNoImage = true;
            return '/images/defaults/' . $this->pluralType() . '_thumb.jpg';
        }

        if (!empty($focus)) {
            Img::focus($focus[0], $focus[1]);
        }

        // Reset for next caller
        if (!$this->cropped) {
            $this->cropped = true;
            return Img::url($avatar);
        }

        return Img::crop($this->avatarWidth, $this->avatarHeight)->url($avatar);
    }

    public function hasNoImage(): bool
    {
        return $this->hasNoImage;
    }
}
