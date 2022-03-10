<?php


namespace App\Datagrids\Bulks;


class CharacterBulk extends Bulk
{
    protected $fields = [
        'name',
        'title',
        'families',
        'location_id',
        'races',
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

    protected $belongsTo = [
        'races',
        'families',
    ];
}
