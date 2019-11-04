<?php


namespace App\Datagrids\Bulks;


class CharacterBulk extends Bulk
{
    protected $fields = [
        'name',
        'title',
        'family_id',
        'location_id',
        'race_id',
        'type',
        'dead_choice',
        'tags',
        'private_choice',
    ];

    protected $mappings = [
        'is_dead'
    ];
}
