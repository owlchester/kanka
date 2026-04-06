<?php

namespace App\Datagrids\Bulks;

class FamilyBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'location_id',
        'status_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
