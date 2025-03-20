<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Pinnable
 *
 * @property bool|int $is_pinned
 *
 * @method static self|Builder pinnable(bool $is_pinned = true)
 */
trait Pinnable
{
    /**
     * @param  int  $pin
     */
    public function scopePinned(Builder $query, $pin = 1)
    {
        return $query->where(['is_pinned' => $pin]);
    }

    public function isPinned(): bool
    {
        return (bool) $this->is_pinned;
    }
}
