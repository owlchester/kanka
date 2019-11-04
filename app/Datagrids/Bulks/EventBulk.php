<?php


namespace App\Datagrids\Bulks;


class EventBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'location_id',
        'tags',
        'private_choice',
    ];
}
