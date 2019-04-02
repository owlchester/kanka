<?php

namespace App\Traits;

use App\Scopes\VisibleScope;

trait VisibleTrait
{
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootVisibleTrait()
    {
        static::addGlobalScope(new VisibleScope());
    }
}
