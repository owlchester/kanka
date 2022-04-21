<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait SortableTrait
{
    public function scopeSort(Builder $query, array $filters)
    {
        if (empty($filters)) {
            return $query;
        }

        if (empty($this->sortable)) {
            return $query;
        }

        if (empty($filters['k'])) {
            return $query;
        }

        $key = Arr::get($filters, 'k');
        if (!in_array($key, $this->sortable)) {
            return $query;
        }

        // Force order to be valid
        $order = strtolower(Arr::get($filters, 'o', 'asc'));
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        return $query->orderBy($key, $order);

        //$key = Arr::get($filters)
    }
}
