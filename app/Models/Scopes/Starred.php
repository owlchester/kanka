<?php

namespace App\Models\Scopes;

trait Starred
{
     /**
     * @param $query
     * @param int $star
     * @return mixed
     */
    public function scopeStared($query, $star = 1)
    {
        return $query->where(['is_star' => $star]);
    }
}
