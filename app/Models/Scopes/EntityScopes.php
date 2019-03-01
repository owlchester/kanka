<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

trait EntityScopes
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query
            ->select('*', DB::raw('count(id) as cpt'))
            ->groupBy('type')
            ->orderBy('cpt', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecentlyModified($query)
    {
        return $query
            ->orderBy('updated_at', 'desc');
    }


    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeType($query, $type)
    {
        if (empty($type)) {
            return $query;
        }
        return $query->where('type', $type);
    }
}
