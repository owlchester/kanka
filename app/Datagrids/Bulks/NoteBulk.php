<?php

namespace App\Datagrids\Bulks;

class NoteBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'note_id',
        'tags',
        'private_choice',
    ];
}
