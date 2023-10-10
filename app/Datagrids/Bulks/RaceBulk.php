<?php

namespace App\Datagrids\Bulks;

class RaceBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_race_id',
        'tags',
        'private_choice',
    ];
}
