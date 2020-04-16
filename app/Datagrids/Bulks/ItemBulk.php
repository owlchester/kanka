<?php


namespace App\Datagrids\Bulks;


class ItemBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'price',
        'size',
        'location_id',
        'character_id',
        'tags',
        'private_choice',
    ];
}
