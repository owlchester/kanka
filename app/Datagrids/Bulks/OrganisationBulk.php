<?php

namespace App\Datagrids\Bulks;

class OrganisationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'location_id',
        'organisation_id',
        'tags',
        'private_choice',
        'defunct_choice'
    ];

    protected array $mappings = [
        'is_defunct'
    ];
}
