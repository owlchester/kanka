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
        'item_id',
        'location_id',
        'creators',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
