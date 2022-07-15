<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Pinned
 * @package App\Models\Scopes
 *
 * @method static self|Builder pinned(bool $is_pinned = true)
 */
trait Pinned
{
     /**
     * @param Builder $query
     * @param int $pin
     * @return mixed
     */
    public function scopePinned(Builder $query, $pin = 1)
    {
        return $query->where(['is_pinned' => $pin]);
    }
}
