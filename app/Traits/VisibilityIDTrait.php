<?php

namespace App\Traits;

use App\Models\Scopes\VisibilityIDScope;

/**
 * Trait VisibilityTrait
 * @package App\Traits
 *
 * @property string $visibility
 * @property int $created_by
 */
trait VisibilityIDTrait
{
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootVisibilityIDTrait()
    {
        static::addGlobalScope(new VisibilityIDScope());
    }
}
