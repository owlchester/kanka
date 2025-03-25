<?php

namespace App\Models\Concerns;

use App\Observers\NestedObserver;

trait Nested
{
    public static function bootNested()
    {
        static::observe(new NestedObserver);
    }
}
