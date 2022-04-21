<?php

namespace App\Renderers\Layouts;

abstract class Layout
{
    const ONLY_DESKTOP = 'hidden-xs hidden-sm';

    const ACTION_EDIT = 'edit';
    const ACTION_DELETE = 'delete';

    /** @var bool|array */
    protected $visibleColumns = false;

    public function columns(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [];
    }

    public function bulks(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function visibleColumns(): array
    {
        if ($this->visibleColumns !== false) {
            return $this->visibleColumns;
        }

        $this->visibleColumns = [];
        foreach ($this->columns() as $key => $column) {
            if (!isset($column['visible'])) {
                $this->visibleColumns[] = $column;
                continue;
            }
            $condition = $column['visible']();
            if (!$condition) {
                continue;
            }
            $this->visibleColumns[] = $column;
        }

        return $this->visibleColumns;
    }
}
