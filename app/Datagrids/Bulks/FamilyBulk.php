<?php


namespace App\Datagrids\Bulks;


class FamilyBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'family_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
