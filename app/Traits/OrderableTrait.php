<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @method static self|Builder order(string|null $data, string $defaultField)
 */
trait OrderableTrait
{
    public function scopeOrdered(Builder $query, ?string $data, string $defaultField = 'name')
    {
        // No token? Next.
        if (! str_contains($data, $this->orderTrigger)) {
            return $this->handleNoToken($query, $defaultField);
        }

        $field = str_replace($this->orderTrigger, '', $data);
        $direction = 'ASC';

        if (! empty($field) && ! Str::contains($field, '/')) {
            $segments = explode('.', $field);
            if (count($segments) > 1) {
                $relationName = $segments[0];

                // Make sure the relationship exists
                if (method_exists($this, $relationName)) {
                    return $query;
                }

                $relation = $this->{$relationName}();
                $foreignName = $relation->getQuery()->getQuery()->from;

                return $query
                    ->select($this->getTable() . '.*')
                    ->with($relationName)
                    ->leftJoin($foreignName . ' as f', 'f.id', $this->getTable() . '.' . $relation->getForeignKeyName())
                    ->orderBy(str_replace($relationName, 'f', $field), $direction);
            } elseif ($data == 'events/date') {
                return $query
                    ->orderBy($this->getTable() . '.year', $direction)
                    ->orderBy($this->getTable() . '.month', $direction)
                    ->orderBy($this->getTable() . '.day', $direction);
            } else {
                return $query->orderBy($this->getTable() . '.' . $field, $direction);
            }
        }

        return $query;
    }

    protected function handleNoToken(Builder $query, string $defaultField): Builder
    {
        if ($defaultField == 'name' && isset($this->orderDefaultField)) {
            $defaultField = $this->orderDefaultField;
        }
        $defaultDir = $this->orderDefaultDir ?? 'asc';

        if ($defaultField == 'events/date') {
            return $query
                ->orderBy('year', $defaultDir)
                ->orderBy('month', $defaultDir)
                ->orderBy('day', $defaultDir);
        }

        return $query->orderBy($defaultField, $defaultDir);
    }
}
