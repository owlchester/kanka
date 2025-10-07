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
        $journal = $this->entity->child;
        $items['second']['journals'] = [
            'name' => $this->entity->entityType->plural(),
            'route' => 'journals.journals',
            'count' => $journal->descendants()->has('entity')->count(),
        ];

        return $items;
    }
}
