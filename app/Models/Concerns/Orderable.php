<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Orderable
{
    /**
     * Default ordering
     * @var string
     */
    protected $defaultOrderField = 'name';
    protected $defaultOrderDirection = 'asc';

    /**
     * @param $query
     * @param $field
     * @return mixed
     */
    public function scopeOrder(Builder $query, $data)
    {
        // Default
        $field = $this->defaultOrderField;
        $direction = $this->defaultOrderDirection;
        if (!empty($data) && auth()->check()) {
            foreach ($data as $key => $value) {
                $field = $key;
                $direction = $value;
            }
        }

        // Calendar dates are handled differently since we have free fields
        if ($field == 'calendar_date') {
            return $query
                ->orderBy($this->getTable() . '.calendar_year', $direction)
                ->orderBy($this->getTable() . '.calendar_month', $direction)
                ->orderBy($this->getTable() . '.calendar_day', $direction);
        }


        if (!empty($field)) {
            $segments = explode('.', $field);
            if (count($segments) > 1) {
                $relationName = $segments[0];

                /** @var BelongsTo $relation */
                $relation = $this->{$relationName}();
                $foreignName = $relation->getQuery()->getQuery()->from;
                return $query
                    ->select($this->getTable() . '.*')
                    ->with($relationName)
                    ->leftJoin(
                        $foreignName . ' as f',
                        'f.id',
                        $this->getTable() . '.' . $relation->getForeignKeyName()
                    )
                    ->orderBy(str_replace($relationName, 'f', $field), $direction);
            } else {
                // Order by related table? Yeah that's fun.
                // While this would be possible, this would mean injecting the acl/permission system
                // just for an order by, which seems quite overkill.
                // A better solution might present itself during a future rewrite of the acl engine.
//                if (substr($field, 0, 6) == 'count(') {
//                    $relationName = preg_replace('/count\((.*)\)/si', '$1', $field);
//                    $relation = $this->{$relationName}();
//                    $foreignName = $relation->getQuery()->getQuery()->from;
//
//                    return $query
//                        ->orderByRaw('(select count(*) from ' . $foreignName . ' where ' .
// $relation->getForeignKeyName() . ' = ' . $this->getTable() . '.' . $this->primaryKey . ') ' . $direction);
//                }

                // If the field has a casting
                if (!empty($this->orderCasting[$field])) {
                    return $query->orderByRaw(
                        'cast(' . $this->getTable() . '.' . $field . ' as ' . $this->orderCasting[$field] . ')'
                        . $direction
                    );
                }
                return $query->orderBy($this->getTable() . '.' . $field, $direction);
            }
        }
        return $query;
    }
}
