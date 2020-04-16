<?php


namespace App\Datagrids\Bulks;


class AbilityBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'ability_id',
        'tags',
        'private_choice',
    ];
}
