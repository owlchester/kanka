<?php

namespace App\Datagrids\Bulks;

class TimelineBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'timeline_id',
        'tags',
        'private_choice',
    ];
}
