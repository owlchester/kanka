<?php

namespace App\Datagrids\Bulks;

class FamilyBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'location_id',
        'tags',
        'private_choice',
        'extinct_choice',
        'entity_image',
        'entity_header',
    ];

    protected array $booleans = [
        'is_extinct',
    ];
}
