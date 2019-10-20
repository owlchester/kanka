<?php


namespace App\Models\Concerns;


trait Sortable
{
    /**
     * @return mixed
     */
    public function sortableColumns(): array
    {
        return array_merge($this->sortableColumns, ['name', 'type', 'is_private']);
    }
}