<?php

namespace App\Datagrids\Bulks;

class FamilyBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_family_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
