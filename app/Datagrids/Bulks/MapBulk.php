<?php

namespace App\Datagrids\Bulks;

class MapBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_map_id',
        'tags',
        'private_choice',
    ];
}
