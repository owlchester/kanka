<?php

namespace App\Services\Submenus;

use App\Models\Calendar;

class CalendarSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        /** @var Calendar $calendar */
        $calendar = $this->entity->child;
        $count = $calendar->calendarEvents()->has('remindable')->count();
        $items = [];
        if ($count > 0) {
            $items['second']['events'] = [
                'name' => 'crud.tabs.reminders',
                'route' => 'calendars.events',
                'count' => $count,
            ];
        }

        return $items;
    }
}
