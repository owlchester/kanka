<?php

namespace App\Datagrids\Bulks;

class OrganisationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'locations',
        'organisation_id',
        'tags',
        'private_choice',
        'defunct_choice',
        'entity_image',
        'entity_header',
    ];

    protected array $booleans = [
        'is_defunct',
    ];
}
