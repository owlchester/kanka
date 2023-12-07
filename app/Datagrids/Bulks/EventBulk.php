<?php

namespace App\Datagrids\Bulks;

class EventBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'event_id',
        'location_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
