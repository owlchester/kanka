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
     * @return string
     */
    public function name(): string
    {
        return __('rpg_systems.systems.' . $this->code);
    }

    /**
     * Default query for list of rpg systems
     * @param $query
     * @return mixed
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->whereNull('deleted_at')
            ->orderBy('sort_order', 'ASC');
    }

    /**
     * @return mixed
     */
    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaigns');
    }
}
