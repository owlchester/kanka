<?php

namespace App\Traits;

use App\Scopes\VisibleScope;

trait VisibleTrait
{
    public static function bootVisibleTrait()
    {
        static::addGlobalScope(new VisibleScope());
    }
}
