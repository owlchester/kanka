<?php


namespace App\Datagrids\Bulks;


class TimelineBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'calendar_id',
        'tags',
        'private_choice',
    ];
}
