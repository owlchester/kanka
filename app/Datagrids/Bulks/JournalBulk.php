<?php


namespace App\Datagrids\Bulks;


class JournalBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'journal_id',
        'author_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
