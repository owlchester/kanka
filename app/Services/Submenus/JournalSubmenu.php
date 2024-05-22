<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class JournalSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['journals'] = [
            'name' => Module::plural($this->model->entityTypeId(), 'entities.journals'),
            'route' => 'journals.journals',
            'count' => $this->model->descendants()->count()
        ];
        return $items;
    }
}
