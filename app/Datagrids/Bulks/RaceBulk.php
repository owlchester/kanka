<?php

namespace App\Datagrids\Bulks;

class RaceBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'race_id',
        'locations',
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
