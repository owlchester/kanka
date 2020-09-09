<?php

namespace App\Models\Concerns;

use App\Datagrids\Sorters\DatagridSorter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Trait SimpleSortableTrait
 * @package App\Models\Concerns
 */
trait SimpleSortableTrait
{
    /**
     * @param Builder $builder
     * @param DatagridSorter|string $datagridSorter
     * @return Builder
     */
    public function scopeSimpleSort(Builder $builder, $datagridSorter = null)
    {
        // DatagridSorter can be empty on exports
        if (empty($datagridSorter)) {
            return $builder;
        }
        if (is_string($datagridSorter)) {
            $datagridSorter = new $datagridSorter;
            $datagridSorter->request(request()->all());
        }

        $columns = $datagridSorter->column();
        if (!is_array($columns)) {
            $columns = array($columns);
        }
        $order = $datagridSorter->order();

        foreach ($columns as $column) {
            if (Str::contains($column, '.')) {
                $segments = explode('.', $column);
                if (count($segments) == 2) {
                    $relationName = $segments[0];

                    $relation = $this->{$relationName}();
                    $foreignName = $relation->getQuery()->getQuery()->from;
                    $builder
                        ->select($this->getTable() . '.*')
                        ->with($relationName)
                        ->leftJoin(
                            $foreignName . ' as f',
                            'f.id',
                            $this->getTable() . '.' . $relation->getForeignKeyName()
                        )
                        ->orderBy(str_replace($relationName, 'f', $column), $order);
                    continue;
                }
            }

            // If the field has a casting
            if ($datagridSorter->hasOrderCasting($column)) {
                $builder->orderByRaw(
                    'cast(' . $this->getTable() . '.' . $column . ' as ' . $datagridSorter->orderCasting($column) . ')'
                    . $order
                );
            } elseif ($datagridSorter->hasOrderRaw($column)) {
                $builder->orderByRaw(
                    $datagridSorter->orderRaw($column) . ' ' . $order
                );
            } elseif ($datagridSorter->hasMultipleOrder($column)) {
                foreach ($datagridSorter->orderMultiple($column) as $multiple) {
                    $builder->orderBy($this->getTable() . '.' . $multiple, $order);
                }
            } else {
                $builder->orderBy($this->getTable() . '.' . $column, $order);
            }
        }

        return $builder;
    }
}
