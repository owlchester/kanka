<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
    public function scopeFilter(Builder $query, $params)
    {
        $fields = $this->getFilterableColumns();
        if (!is_array($params) or empty($params) or empty($fields)) {
            return $query;
        }

        foreach ($params as $key => $value) {
            if (isset($value) && in_array($key, $fields)) {
                $filterOption = !empty($params[$key . '_option']) ? $params[$key . '_option'] : null;
                // It's possible to request "not" values
                $operator = 'like';
                $filterValue = $value;
                if ($key !== 'tags') {
                    if ($value == '!!') {
                        $operator = 'IS NULL';
                        $filterValue = null;
                    } elseif (Str::startsWith($value, '!')) {
                        $operator = 'not like';
                        $filterValue = ltrim($value, '!');
                    } elseif (Str::endsWith($value, '!')) {
                        $operator = '=';
                        $filterValue = rtrim($value, '!');
                    } elseif(Str::endsWith($key, '_id')) {
                        $operator = '=';
                    }
                }

                // Foreign key search
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
                    // Explicit filters (numbers typically, foreign ids)
                    if (in_array($key, $this->explicitFilters)) {
                        $query->where($this->getTable() . '.' . $key, $operator, "$filterValue");
                    } elseif ($key == 'tags') {
                        // "none" filter tags is handled later
                        if (!empty($filterOption) && $filterOption === 'none') {
                            continue;
                        }
                        $query
                            ->distinct()
                            ->select($this->getTable() . '.*')
                            ->leftJoin('entities as e', function ($join) {
                                $join->on('e.entity_id', '=', $this->getTable() . '.id');
                                $join->where('e.type', '=', $this->getEntityType())
                                    ->whereRaw('e.campaign_id = ' . $this->getTable() . '.campaign_id');
                            })
                        ;

                        // Make sure we always have an array
                        if (!is_array($value)) {
                            $value = [$value];
                        }

                        if (!empty($filterOption) && $filterOption == 'exclude') {
                            $tagIds = [];
                            foreach ($value as $v) {
                                $tagIds[] = (int) $v;
                            }
                            //$query->leftJoin('entity_tags as et_tags', "et_tags.entity_id", 'e.id')
                             $query->whereRaw('(select count(*) from entity_tags as et where et.entity_id = e.id and et.tag_id in (' . implode(', ', $tagIds) . ')) = 0');

                            continue;
                        }

                        foreach ($value as $v) {
                            $v = (int) $v;
                            $query
                                ->leftJoin('entity_tags as et' . $v, "et$v.entity_id", 'e.id')
                                ->where("et$v.tag_id", $v)
                            ;
                        }
                    } elseif ($key == 'tag_id') {
                        $query
                            ->select($this->getTable() . '.*')
                            ->leftJoin('entities as e', function ($join) {
                                $join->on('e.entity_id', '=', $this->getTable() . '.id');
                                $join->on('e.campaign_id', '=', $this->getTable() . '.campaign_id');
                            })
                            ->leftJoin('entity_tags as et', 'et.entity_id', 'e.id')
                            ->where('et.tag_id', $value);
                    } elseif ($key == 'organisation_member') {
                        if (!empty($filterOption) && $filterOption == 'none')  {$query
                            ->select($this->getTable() . '.*')
                            ->leftJoin('organisation_member as om', function ($join) {
                                $join->on('om.character_id', '=', $this->getTable() . '.id');
                            })
                            ->where('om.organisation_id', null);
                            continue;
                        }
                        $query
                            ->select($this->getTable() . '.*')
                            ->leftJoin('organisation_member as om', function ($join) {
                                $join->on('om.character_id', '=', $this->getTable() . '.id');
                            })
                            ->where('om.organisation_id', $value);
                    } elseif ($key == 'has_image') {
                        if ($value) {
                            $query->whereNotNull($this->getTable() . '.image');
                        } else {
                            $query->whereNull($this->getTable() . '.image');
                        }
                    } elseif ($operator == 'IS NULL') {
                        $query->where(function ($sub) use ($key) {
                            $sub->whereNull($this->getTable() . '.' . $key)
                                ->orWhere($this->getTable() . '.' . $key, '=', '');
                        });
                    } else {
                        // If we have an exclude option filter, change the operator
                        if (!empty($filterOption) && $filterOption == 'exclude') {
                            $query->where(function ($subquery) use ($key, $filterValue) {
                                return $subquery->where($this->getTable() . '.' . $key,
                                    '!=',
                                    $filterValue
                                )->orWhereNull($this->getTable() . '.' . $key);
                            });

                            continue;
                        }
                        $query->where(
                            $this->getTable() . '.' . $key,
                            $operator,
                            ($operator == '=' ? $filterValue : "%$filterValue%")
                        );
                    }
                }
            } elseif ($key == 'tags_option' && $value == 'none') {
                $query
                    ->distinct()
                    ->select($this->getTable() . '.*')
                    ->leftJoin('entities as e', function ($join) {
                        $join->on('e.entity_id', '=', $this->getTable() . '.id');
                        $join->where('e.type', '=', $this->getEntityType())
                            ->whereRaw('e.campaign_id = ' . $this->getTable() . '.campaign_id');
                    })
                    ->leftJoin('entity_tags as no_tags', 'no_tags.entity_id', 'e.id')
                    ->whereNull('no_tags.tag_id');
            } elseif (Str::endsWith($key, '_option') && $value == 'none') {
                $key = Str::beforeLast($key, '_option');
                // Validate the key is a filter
                if (in_array($key, $fields)) {
                    // Left join shenanigans
                    if ($key == 'organisation_member') {
                        continue;
                    }
                    $query->whereNull($this->getTable() . '.' . $key);
                }
            }
        }
        return $query;
    }
}
