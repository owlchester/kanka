<?php

namespace App\Datagrids\Bulks;

class ItemBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'price',
        'size',
        'weight',
        'parent_id',
        'location_id',
        'creators',
        'status_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
