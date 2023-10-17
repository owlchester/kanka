<?php

namespace App\Datagrids\Bulks;

class FamilyBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'family_id',
        'location_id',
        'tags',
        'private_choice',
    ];
}
