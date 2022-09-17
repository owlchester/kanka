<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static self|Builder lastSync($lastSync = null)
 */
trait LastSync
{
    /**
     * Used by the API to get models updated since a previous date
     * @param Builder $query
     * @param string $lastSync
     * @return Builder
     */
    public function scopeLastSync(Builder $query, $lastSync = null): Builder
    {
        if (empty($lastSync)) {
            return $query;
        }
        $tableName = with(new static)->getTable();
        return $query->where($tableName . '.updated_at', '>', $lastSync);
    }
}
