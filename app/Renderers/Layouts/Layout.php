<?php

namespace App\Renderers\Layouts;

abstract class Layout
{
    public const ONLY_DESKTOP = 'hidden-xs hidden-sm';

    public const ACTION_EDIT = 'edit';
    public const ACTION_EDIT_AJAX = 'edit-ajax';
    public const ACTION_DELETE = 'delete';
    public const ACTION_COPY = 'copy';

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
