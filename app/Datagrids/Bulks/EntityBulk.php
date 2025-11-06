<?php

namespace App\Datagrids\Bulks;

class EntityBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'locations',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
