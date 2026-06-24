<?php

namespace App\Models\Concerns;

use App\Observers\SlugObserver;

/**
 * @property string $slug
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        $observer = app(SlugObserver::class);
        static::saving([$observer, 'saving']);
    }
}
