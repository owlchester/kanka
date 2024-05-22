<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Journal;

class JournalSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Journal $journal */
        $journal = $this->model;
        $items['second']['journals'] = [
            'name' => Module::plural($journal->entityTypeId(), 'entities.journals'),
            'route' => 'journals.journals',
            'count' => $journal->descendants()->count()
        ];
        return $items;
    }
}
