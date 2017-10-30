<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

abstract class MiscModel extends Model
{
    /**
     * Eloquence trait for easy search
     */
    //use Eloquence;

    /**
     * Create a short name for the interface
     * @return mixed|string
     */
    public function shortName()
    {
        if (strlen($this->name) > 30) {
            return '<span title="' . e($this->name) . '">' . substr(e($this->name), 0, 28) . '...</span>';
        }
        return $this->name;
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        $searchFields = $this->searchableColumns;

        return $query->where(function($q) use ($term, $searchFields) {
            foreach ($searchFields as $field) {
                $q->orWhere($field, 'like', "%$term%");
            }
        });
    }

    public function scopeOrder($query, $field)
    {
        if (!empty($field)) {
            $segments = explode('.', $field);
            if (count($segments) > 1) {
                $relation = $this->{$segments[0]}();
                //dd($relation->getForeignKey());
                $foreignName = $relation->getQuery()->getQuery()->from;
                return $query->join($foreignName . ' as f', 'f.id', $relation->getForeignKey())
                    ->orderBy('f.' . $field);
            } else {
                return $query->orderBy($field);
            }
        }
    }
}
