<?php

namespace App\Datagrids\Bulks;

class CreatureBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'locations',
        'tags',
        'private_choice',
        'extinct_choice',
        'dead_choice',
        'entity_image',
        'entity_header',
    ];

    protected $booleans = [
        'is_extinct',
        'is_dead',
    ];
}
