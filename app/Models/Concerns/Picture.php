<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Picture
{
    /**
     * @param bool $thumb
     * @param string $field
     * @return string
     */
    public function avatar(bool $thumb = false, string $field = 'image')
    {
        $avatar = Cache::get($this->avatarCacheKey($thumb, $field), false);
        if ($avatar !== false) {
            return $avatar;
        }
        return $this->cacheAvatar($thumb, $field);
    }

    /**
     * @param bool $thumb
     * @param string $field
     * @return string
     */
    protected function cacheAvatar(bool $thumb, string $field)
    {
        if (empty($this->child->$field)) {
            $avatar = asset('/images/defaults/' . $this->child->getTable() . ($thumb ? '_thumb' : null) . '.jpg');
        } else {
            $avatar = Storage::url(($thumb ? str_replace('.', '_thumb.', $this->child->$field) : $this->child->$field));
        }

        Cache::forever($this->avatarCacheKey($thumb, $field), $avatar);
        return $avatar;
    }

    /**
     * @param $avatar
     * @return string
     */
    protected function avatarUrl($avatar)
    {
        // If it's a default image, patreons have the nicer pictures
        if (Str::contains($avatar, '/images/defaults/')) {
            if (auth()->check() && auth()->user()->isGoblinPatron()) {
                return Str::replaceArray($avatar, [
                    'defaults/' => 'defaults/patreon',
                    '.jpg' => '.png'
                ]);
            }
        }

        return $avatar;
    }

    protected function avatarCacheKey(bool $thumb, string $field): string
    {
        return 'picture_' . $this->entity_id . '_' . $field . ($thumb ? '_thumb' : null);
    }
}
