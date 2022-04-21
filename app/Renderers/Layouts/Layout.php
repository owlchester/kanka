<?php

namespace App\Renderers\Layouts;

abstract class Layout
{
    const ONLY_DESKTOP = 'hidden-xs hidden-sm';

    const ACTION_EDIT = 'edit';
    const ACTION_DELETE = 'delete';

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
}
