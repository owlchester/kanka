<?php

namespace App\Datagrids\Bulks;

class RaceBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'race_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
