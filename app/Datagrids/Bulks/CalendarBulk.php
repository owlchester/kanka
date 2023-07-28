<?php

namespace App\Datagrids\Bulks;

class CalendarBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'calendar_id',
        'tags',
        'private_choice',
        'format',
    ];
}
