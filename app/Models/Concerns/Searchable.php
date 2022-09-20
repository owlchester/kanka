<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static self|Builder search(string|null $term)
 */
trait Searchable
{
    /**
     * Scope a query to only include users of a given type.
     *
     * @param Builder $query
     * @param string|null $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $term = null): Builder
    {
        if (empty($term)) {
            return $query;
        }

        $searchFields = $this->searchableFields();
        return $query->where(function ($q) use ($term, $searchFields) {
            foreach ($searchFields as $field) {
                $q->orWhere($this->getTable() . '.' . $field, 'like', "%$term%");
            }
        });
    }

    /**
     * @return bool
     */
    public function hasSearchableFields(): bool
    {
        return !empty($this->searchableColumns);
    }

    /**
     * Available searchable fields. Defaults to name, type and type
     * @return string[]
     */
    protected function searchableFields(): array
    {
        if (property_exists($this, 'searchableColumns')) {
            return $this->searchableColumns;
        }

        return [
            'name',
            'type',
            'entry',
        ];
    }
}
