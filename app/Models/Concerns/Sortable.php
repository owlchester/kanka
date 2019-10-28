<?php


namespace App\Models\Concerns;


trait Sortable
{
    /**
     * @return mixed
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
        if (isset($this->sortableColumns)) {
            return $this->sortableColumns;
        }

        return [];
    }
}