<?php


namespace App\Datagrids\Bulks;


class TimelineBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'timeline_id',
        'calendar_id',
        'tags',
        'private_choice',
    ];
}
