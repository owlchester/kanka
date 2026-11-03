<?php

namespace App\Services\Submenus;

class EventSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['participants'] = [
            'name' => __('events.participants.title'),
            'route' => 'events.participants.index',
        ];

        return $items;
    }
}
