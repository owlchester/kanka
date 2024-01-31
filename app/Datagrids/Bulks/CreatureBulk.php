<?php

namespace App\Datagrids\Bulks;

class CreatureBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'creature_id',
        'tags',
        'private_choice',
        'extinct_choice',
        'entity_image',
        'entity_header',
    ];

    protected $booleans = [
        'is_extinct'
    ];
}
