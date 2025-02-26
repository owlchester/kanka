<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Event;

class EventSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Event $event */
        $event = $this->entity->child;
        $items['second']['events'] = [
            'name' => Module::plural($event->entityTypeId(), 'entities.events'),
            'route' => 'events.events',
            'count' => $event->descendants()->has('entity')->count()
        ];
        return $items;
    }
}
