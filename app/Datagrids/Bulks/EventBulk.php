<?php

namespace App\Datagrids\Bulks;

class EventBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_event_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
