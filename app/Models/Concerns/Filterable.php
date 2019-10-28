<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait Filterable
{
    /**
     * @return array
     */
    public function getFilterableColumns(): array
    {
        if (isset($this->filterableColumns)) {
            return $this->filterableColumns;
        }

        return [];
    }

    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     * @var array
     */
    protected $explicitFilters = [];

    /**
     * @param $query
     * @param $params
     * @return mixed
     */
    public function scopeFilter($query, $params)
    {
        $fields = $this->getFilterableColumns();
        if (!is_array($params) or empty($params) or empty($fields)) {
            return $query;
        }

        foreach ($params as $key => $value) {
            if (isset($value) && in_array($key, $fields)) {
                // It's possible to request "not" values

                $operator = 'like';
                $filterValue = $value;
                if ($value == '!!') {
                    $operator = 'IS NULL';
                    $filterValue = null;
                } elseif (Str::startsWith($value, '!')) {
                    $operator = 'not like';
                    $filterValue = ltrim($value, '!');
                } elseif (Str::endsWith($value, '!')) {
                    $operator = '=';
                    $filterValue = rtrim($value, '!');
                }

                $segments = explode('-', $key);
                if (count($segments) > 1) {
                    $relationName = $segments[0];

                    $relation = $this->{$relationName}();
                    $foreignName = $relation->getQuery()->getQuery()->from;
                    return $query
                        ->select($this->getTable() . '.*')
                        ->with($relationName)
                        ->leftJoin($foreignName . ' as f', 'f.id', $this->getTable() . '.' . $relation->getForeignKeyName())
                        ->where(
                            str_replace($relationName, 'f', str_replace('-', '.', $key)),
                            $operator,
                            ($operator == '=' ? $filterValue : "%$filterValue%")
                        );
                } else {
                    if (in_array($key, $this->explicitFilters)) {
                        $query->where($this->getTable() . '.' . $key, $operator, "$filterValue");
                    } elseif ($key == 'tag_id') {
                        $query
                            ->select($this->getTable() . '.*')
                            ->leftJoin('entities as e', 'e.entity_id', $this->getTable() . '.id')
                            ->leftJoin('entity_tags as et', 'et.entity_id', 'e.id')
                            ->where('et.tag_id', $value);
                    } elseif ($operator == 'IS NULL') {
                        $query->where(function ($sub) use ($key) {
                            $sub->whereNull($this->getTable() . '.' . $key)
                                ->orWhere($this->getTable() . '.' . $key, '=', '');
                        });
                    } else {
                        $query->where(
                            $this->getTable() . '.' . $key,
                            $operator,
                            ($operator == '=' ? $filterValue : "%$filterValue%")
                        );
                    }
                }
            }
        }
        return $query;
    }
}
