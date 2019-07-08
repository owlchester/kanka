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
    public function scopePreparedWith($query)
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
}
