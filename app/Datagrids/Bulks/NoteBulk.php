<?php


namespace App\Datagrids\Bulks;


class NoteBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'note_id',
        'tags',
        'private_choice',
    ];
}
