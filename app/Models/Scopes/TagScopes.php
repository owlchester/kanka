<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static|self onlyVisible()
 * @method static|self autoApplied()
 */
trait TagScopes
{
    /**
     * Get tags that are auto applied to entities
     */
    public function scopeAutoApplied(Builder $query): Builder
    {
        return $query->where('is_auto_applied', true);
    }

    /**
     * Get tags that are not hidden
     */
    public function scopeOnlyVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', 0);
    }
}
