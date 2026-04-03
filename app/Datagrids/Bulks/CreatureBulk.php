<?php

namespace App\Datagrids\Bulks;

class CreatureBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'creature_id',
        'locations',
        'status_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
