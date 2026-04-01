<?php

namespace App\Datagrids\Bulks;

class CharacterBulk extends Bulk
{
    protected array $fields = [
        'name',
        'title',
        'families',
        'entity_locations',
        'races',
        'type',
        'sex',
        'status_id',
        'age',
        'organisations',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
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
