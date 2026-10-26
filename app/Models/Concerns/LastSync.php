<?php

namespace App\Models\Concerns;

use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static self|Builder lastSync(?string $lastSync = null)
 */
trait LastSync
{
    /**
     * Used by the API to get models updated since a previous date
     */
    public function scopeLastSync(Builder $query, ?string $lastSync = null): Builder
    {
        if (empty($lastSync)) {
            return $query;
        }
        if ($this instanceof MiscModel) {
            return $query->whereHas('entity', fn (Builder $entity) => $entity->where('entities.updated_at', '>', $lastSync));
        }
        // @phpstan-ignore-next-line
        $tableName = (with(new static))->getTable();

        return $query->where($tableName . '.updated_at', '>', $lastSync);
    }
}
