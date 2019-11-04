<?php


namespace App\Datagrids\Bulks;


class RaceBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'race_id',
        'tags',
        'private_choice',
    ];
}
