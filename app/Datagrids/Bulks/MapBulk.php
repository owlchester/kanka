<?php

namespace App\Datagrids\Bulks;

class MapBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'map_id',
        'tags',
        'private_choice',
    ];
}
