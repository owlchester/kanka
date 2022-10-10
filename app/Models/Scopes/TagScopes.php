<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait TagScopes
{
    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return mixed
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity',
            'entity.tags',
            'tags',
            'tag',
            'tag.entity',
            'children',
        ]);
    }

    /**
     * Get tags that are auto applied to entities
     * @param Builder $query
     * @return mixed
     */
    public function scopeAutoApplied(Builder $query)
    {
        return $query->where('is_auto_applied', true);
    }
}
