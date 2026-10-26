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
     */
    public function scopeSearch(Builder $query, ?string $term = null): Builder
    {
        if (empty($term)) {
            return $query;
        }

        $searchFields = $this->searchableFields();
        $entityNameSearch = method_exists($this, 'hasEntity') && $this->hasEntity() && in_array('name', $searchFields, true);
        if ($entityNameSearch) {
            if ($query->getQuery()->columns === null) {
                $query->select($this->getTable() . '.*');
            }
            $query->joinEntity();
        }

        return $query->where(function ($q) use ($term, $searchFields, $entityNameSearch) {
            foreach ($searchFields as $field) {
                $column = $field === 'name' && $entityNameSearch ? 'e.name' : $this->getTable() . '.' . $field;
                $q->orWhere($column, 'like', "%{$term}%");
            }
        });
    }

    public function hasSearchableFields(): bool
    {
        return true;
    }

    /**
     * Available searchable fields. Defaults to name, type and type
     *
     * @return string[]
     */
    protected function searchableFields(): array
    {
        if (property_exists($this, 'searchableColumns')) {
            return $this->searchableColumns;
        }

        return [
            'name',
        ];
    }
}
