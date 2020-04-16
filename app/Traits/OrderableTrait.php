<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait OrderableTrait
{
    /**
     * Trigger for filtering based on the order request.
     * Example: 'relations/'
     * @var string
     */
//    protected $orderTrigger = '';

    /**
     * @param $query
     * @param $data
     * @return mixed
     */
    public function scopeOrder($query, $data, $defaultField = 'name')
    {
        // No token? Next.
        if (strpos($data, $this->orderTrigger) === false) {
            if ($defaultField == 'name' && isset($this->orderDefaultField)) {
                $defaultField = $this->orderDefaultField;
            }
            $defaultDir = isset($this->orderDefaultDir) ? $this->orderDefaultDir : 'asc';

            if ($defaultField == 'events/date') {
                return $query
                    ->orderBy('year', $defaultDir)
                    ->orderBy('month', $defaultDir)
                    ->orderBy('day', $defaultDir);
            }
            return $query->orderBy($defaultField, $defaultDir);
        }

        $field = str_replace($this->orderTrigger, '', $data);
        $direction = 'ASC';

        if (!empty($field) && !Str::contains($field, '/')) {
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
}
