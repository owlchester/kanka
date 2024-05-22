<?php

namespace App\Services\Submenus;

class CalendarSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $count = $this->model->calendarEvents()->has('entity')->count();
        $items = [];
        if ($count > 0) {
            $items['second']['events'] = [
                'name' => 'crud.tabs.reminders',
                'route' => 'calendars.events',
                'count' => $count
            ];
        }
        return $items;
    }
}
