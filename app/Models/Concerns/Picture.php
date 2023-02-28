<?php

namespace App\Models\Concerns;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Img;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait Picture
{
    private int $avatarSize = 40;

    /**
     * Set the avatar size (defaults to 40)
     */
    public function avatarSize(int $size): self
    {
        $this->avatarSize = $size;
        return $this;
    }

    /**
     * @param bool $thumb
     * @param string $field
     * @return string
     */
    public function avatar(bool $thumb = false, string $field = 'image')
    {
        $size = $thumb ? '_thumb' : ($this->avatarSize != 40 ? '_mid' : null);
        $avatar = Cache::get($this->avatarCacheKey($field, $size), false);
        $avatar = false;
        if ($avatar === false) {
            $avatar = $this->cacheAvatar($field, $size);
        }
        return $this->avatarUrl($avatar);
    }

    /**
     * @param bool $thumb
     * @param string $field
     * @return string
     */
    protected function cacheAvatar(string $field, string $size = null)
    {
        // Can't get the child? Something is weird, let's cache something empty rather than crash the user
        if (empty($this->child)) {
            return '';
        }
        // Todo: we are caching with the user's nicer image here
        $avatar = $this->child->withEntity($this)->thumbnail($this->avatarSize);
        Cache::forever($this->avatarCacheKey($field, $size), $avatar);
        return $avatar;
    }

    /**
     * @param string $avatar
     * @return string
     */
    protected function avatarUrl(string $avatar)
    {
        // If it's a default image, subscribers have the nicer pictures.
        // Why do we do this here? Because it's based on the user, so it can't go in cache
        if (Str::contains($avatar, '/images/defaults/') && !Str::contains($avatar, '/patreon/')) {
            // Check if the campaign has a default image first
            $campaign = CampaignLocalization::getCampaign();
            if ($campaign->boosted() && Arr::has(CampaignCache::defaultImages(), $this->type())) {
                return Img::crop($this->avatarSize, $this->avatarSize)
                    ->url(CampaignCache::defaultImages()[$this->type()]['path']);
            }

            if (auth()->check() && auth()->user()->isGoblin()) {
                return str_replace(['defaults/', '.jpg'], ['defaults/patreon/', '.png'], $avatar);
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

            // Thumb
            $image = $this->avatarCacheKey($field, '_thumb');
            $image = $this->avatarCacheKey($field, '_mid');
            Cache::forget($image);
        }
    }

    /**
     * @param bool $thumb
     * @param string $field
     * @return string
     */
    protected function avatarCacheKey(string $field, string $size = null): string
    {
        return 'entity_picture_' . $this->id . '_' . $field . $size;
    }
}
