<?php

namespace App\Datagrids\Bulks;

class JournalBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'author_id',
        'date',
        'locations',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
