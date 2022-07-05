<?php

namespace App\Datagrids\Bulks;

class LocationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_location_id',
        'tags',
        'private_choice',
    ];
}
