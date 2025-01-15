<?php

namespace App\Services\Submenus;

use App\Models\Quest;

class QuestSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Quest $model */
        $model = $this->entity->child;
        $count = $model->elements()->with('entity')->has('entity')->count();
        $items['second']['elements'] = [
            'name' => 'quests.show.tabs.elements',
            'route' => 'quests.quest_elements.index',
            'count' => $count
        ];
        return $items;
    }
}
