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
        static::observe(app(SlugObserver::class));
    }
}
