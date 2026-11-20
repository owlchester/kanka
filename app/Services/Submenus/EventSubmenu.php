<?php

namespace App\Services\Submenus;

class EventSubmenu extends BaseSubmenu
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
