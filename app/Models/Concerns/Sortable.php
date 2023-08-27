<?php

namespace App\Models\Concerns;

trait Sortable
{
    /**
     */
    public function sortableColumns(): array
    {
        return array_merge($this->customSortableColumns(), ['name', 'type', 'is_private']);
    }

    /**
     */
    protected function customSortableColumns(): array
    {
        if (property_exists($this, 'sortableColumns')) {
            return $this->sortableColumns;
        }

        return [];
    }
}
