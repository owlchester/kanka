<?php

namespace App\Datagrids\Bulks;

class CharacterBulk extends Bulk
{
    protected array $fields = [
        'name',
        'title',
        'families',
        'location_id',
        'races',
        'type',
        'sex',
        'dead_choice',
        'age',
        'organisations',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];

    protected array $booleans = [
        'is_dead',
    ];

    protected array $maths = [
        'age',
    ];

    protected array $foreignRelations = [
        'races',
        'families',
        'organisations',
    ];
}
