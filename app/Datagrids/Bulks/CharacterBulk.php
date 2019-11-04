<?php


namespace App\Datagrids\Bulks;


class CharacterBulk extends Bulk
{
    protected $fields = [
        'name',
        'title',
        'family_id',
        'location_id',
        'race_id',
        'type',
        'tags',
        'private_choice',
    ];
}
