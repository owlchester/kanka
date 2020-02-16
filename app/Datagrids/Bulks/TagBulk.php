<?php


namespace App\Datagrids\Bulks;


class TagBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'colour',
        'tag_id',
        'private_choice',
    ];
}
