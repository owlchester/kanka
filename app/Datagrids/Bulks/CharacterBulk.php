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
        'sex',
        'dead_choice',
        'age',
        'tags',
        'private_choice',
    ];

    protected $mappings = [
        'is_dead'
    ];

    protected $maths = [
        'age'
    ];
}
