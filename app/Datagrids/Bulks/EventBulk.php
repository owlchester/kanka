<?php

namespace App\Datagrids\Bulks;

class EventBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'entity_locations',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
