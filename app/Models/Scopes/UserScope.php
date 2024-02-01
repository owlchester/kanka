<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait UserScope
 * @package App\Models\Scopes
 */
trait UserScope
{
    /**
     */
    public function scopeValid(Builder $query, bool $valid = true): Builder
    {
        return $query->where(['is_valid' => $valid]);
    }
}
