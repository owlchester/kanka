<?php

namespace App\Models\Concerns;

use App\Observers\ChildEntityObserver;

trait HasEntity
{
    public static function bootHasEntity(): void
    {
        static::observe(app(ChildEntityObserver::class));
    }
}
