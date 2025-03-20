<?php

namespace App\Models\Concerns;

trait Sortable
{
    /**
     * Get a list of sortable columns, based on some defaults and custom properties
     */
    public function sortableColumns(): array
    {
        $base = ['name', 'type', 'is_private'];
        // Nested models can sort by parent name
        if (method_exists($this, 'parent')) {
            $base[] = 'parent.name';
        }

        return array_merge($this->customSortableColumns(), $base);
    }

    protected function customSortableColumns(): array
    {
        if (! property_exists($this, 'sortableColumns')) {
            return [];
        }

        return $this->sortableColumns;
    }
}
