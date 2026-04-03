<?php

namespace App\Datagrids\Bulks;

class LocationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'title',
        'type',
        'location_id',
        'status_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
