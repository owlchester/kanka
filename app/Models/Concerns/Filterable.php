<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait Filterable
{
    /**
     * Filterable fields
     * @var array
     */
    protected $filterableColumns = [];

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
        if (!is_array($params) or empty($params) or empty($this->filterableColumns)) {
            return $query;
        }

        foreach ($params as $key => $value) {
            if (isset($value) && in_array($key, $this->filterableColumns)) {
                // It's possible to request "not" values

                $operator = 'like';
                $filterValue = $value;
                if (Str::startsWith($value, '!')) {
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

    /**
     * @return array
     */
    public function filterableColumns()
    {
        return $this->filterableColumns;
    }
}
