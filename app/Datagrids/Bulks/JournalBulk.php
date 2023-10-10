<?php

namespace App\Datagrids\Bulks;

class JournalBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_journal_id',
        'author_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
