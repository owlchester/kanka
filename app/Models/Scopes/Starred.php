<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Starred
 * @package App\Models\Scopes
 *
 * @method static self|Builder stared(bool $star = true)
 */
trait Starred
{
     /**
     * @param Builder $query
     * @param int $star
     * @return mixed
     */
    public function scopeStared(Builder $query, $star = 1)
    {
        return $query->where(['is_star' => $star]);
    }
}
