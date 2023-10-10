<?php

namespace App\Datagrids\Bulks;

class NoteBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_note_id',
        'tags',
        'private_choice',
    ];
}
