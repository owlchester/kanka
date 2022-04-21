<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * @method static self|Builder sort(array $filters)
 * @method static self|Builder defaultOrder()
 */
trait SortableTrait
{
    /**
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function scopeSort(Builder $query, array $filters)
    {
        if (empty($filters)) {
            return $query->defaultOrder();
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
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDefaultOrder(Builder $query)
    {
        if (!isset($this->defaultSort)) {
            return $query;
        }

        $defaults = is_array($this->defaultSort) ? $this->defaultSort : [$this->defaultSort];
        foreach ($defaults as $default) {
            $query->orderBy($default);
        }
        return $query;
    }
}
