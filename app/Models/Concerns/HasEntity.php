<?php

namespace App\Models\Concerns;

use App\Observers\ChildEntityObserver;

trait HasEntity
{
    public static function bootHasEntity(): void
    {
        $observer = app(ChildEntityObserver::class);

        static::created([$observer, 'created']);
        static::deleted([$observer, 'deleted']);
        static::saved([$observer, 'saved']);
    }
}
