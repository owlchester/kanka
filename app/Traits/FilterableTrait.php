<?php

namespace App\Traits;

trait FilterableTrait
{
    /**
     * Required properties
     */
//    protected $filterableColumns = [];
//    protected $explicitFilters = [];

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
                $like = (isset($value[0]) && $value[0] == '!' ? 'not like' : 'like');
                $filterValue = (isset($value[0]) && $value[0] == '!') ? ltrim($value, '!') : $value;

                $segments = explode('-', $key);
                if (count($segments) > 1) {
                    $relationName = $segments[0];

                    $relation = $this->{$relationName}();
                    $foreignName = $relation->getQuery()->getQuery()->from;
                    return $query
                        ->select($this->getTable() . '.*')
                        ->with($relationName)
                        ->leftJoin($foreignName . ' as f', 'f.id', $this->getTable() . '.' . $relation->getForeignKey())
                        ->where(str_replace($relationName, 'f', str_replace('-', '.', $key)), $like, "%$filterValue%");
                } else {
                    if (in_array($key, $this->explicitFilters)) {
                        $query->where($this->getTable() . '.' . $key, $like, "$filterValue");
                    } elseif ($key == 'tag_id') {
                        $query
                            ->select($this->getTable() . '.*')
                            ->leftJoin('entities as e', 'e.entity_id', $this->getTable() . '.id')
                            ->leftJoin('entity_tags as et', 'et.entity_id', 'e.id')
                            ->where('et.tag_id', $value);
                    } else {
                        $query->where($this->getTable() . '.' . $key, $like, "%$filterValue%");
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