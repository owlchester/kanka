<?php


namespace App\Datagrids\Bulks;


class FamilyBulk extends Bulk
{
    protected $fields = [
        'name',
        'family_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
