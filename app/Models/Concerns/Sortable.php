<?php

namespace App\Models\Concerns;

trait Sortable
{
    /**
     * @return array
     */
    public function sortableColumns(): array
    {
        return array_merge($this->customSortableColumns(), ['name', 'type', 'is_private']);
    }

    /**
     * @return array
     */
    protected function customSortableColumns(): array
    {
        if (property_exists($this, 'sortableColumns')) {
            return $this->sortableColumns;
        }

        return [];
    }
}
