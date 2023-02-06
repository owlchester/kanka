<?php

namespace App\Policies;

class CalendarPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.calendar');
    }
}
