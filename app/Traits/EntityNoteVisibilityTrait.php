<?php

namespace App\Traits;

use App\Models\Scopes\EntityNoteVisibilityScope;

/**
 * Trait EntityNoteVisibilityTrait
 * @package App\Traits
 *
 * @property string $visibility
 */
trait EntityNoteVisibilityTrait
{
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootEntityNoteVisibilityTrait()
    {
        static::addGlobalScope(new EntityNoteVisibilityScope());
    }
}
