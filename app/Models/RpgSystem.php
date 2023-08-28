<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RpgSystem
 * @package App\Models
 * @property int $id
 * @property string $code
 */
class RpgSystem extends Model
{
    use SoftDeletes;

    /**
     * Translatable name of the system
     */
    public function name(): string
    {
        return __('rpg_systems.systems.' . $this->code);
    }

    /**
     * Default query for list of rpg systems
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->whereNull('deleted_at')
            ->orderBy('sort_order', 'ASC');
    }

    /**
     */
    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaigns');
    }
}
