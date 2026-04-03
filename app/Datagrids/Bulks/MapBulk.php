<?php

namespace App\Datagrids\Bulks;

class MapBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'location_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
