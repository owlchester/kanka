<?php

namespace App\Datagrids\Bulks;

class FamilyBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'family_id',
        'location_id',
        'tags',
        'private_choice',
        'extinct_choice',
        'entity_image',
        'entity_header',
    ];

    protected $booleans = [
        'is_extinct',
    ];
}
