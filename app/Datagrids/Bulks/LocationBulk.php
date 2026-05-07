<?php

namespace App\Datagrids\Bulks;

class LocationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'title',
        'type',
        'status_id',
        'parent_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
