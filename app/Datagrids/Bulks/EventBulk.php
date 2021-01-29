<?php


namespace App\Datagrids\Bulks;


class EventBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'event_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
