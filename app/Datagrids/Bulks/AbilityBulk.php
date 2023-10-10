<?php

namespace App\Datagrids\Bulks;

class AbilityBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_ability_id',
        'tags',
        'private_choice',
    ];
}
