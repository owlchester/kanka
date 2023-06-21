<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Pinnable
 * @package App\Models\Scopes
 *
 * @method static self|Builder pinnable(bool $is_pinned = true)
 */
trait Pinnable
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
