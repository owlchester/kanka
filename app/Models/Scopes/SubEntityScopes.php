<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;

trait SubEntityScopes
{
    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * Used by the API to get models updated since a previous date
     * @param $query
     * @param $lastSync
     * @return mixed
     */
    public function scopeLastSync(Builder $query, $lastSync)
    {
        if (empty($lastSync)) {
            return $query;
        }
        return $query->where('updated_at', '>', $lastSync);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStandardWith($query)
    {
        return $query->with('entity', 'entitiy.tags');
    }
}
