<?php

namespace App\Datagrids\Bulks;

class CreatureBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_creature_id',
        'tags',
        'private_choice',
    ];
}
