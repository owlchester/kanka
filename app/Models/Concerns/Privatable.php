<?php

namespace App\Models\Concerns;

use App\Models\Scopes\PrivateScope;

/**
 * @property bool|int $is_private
 */
trait Privatable
{
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootPrivatable()
    {
        static::addGlobalScope(new PrivateScope());
    }
}
