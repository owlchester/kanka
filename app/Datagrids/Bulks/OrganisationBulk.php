<?php

namespace App\Datagrids\Bulks;

class OrganisationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'locations',
        'organisation_id',
        'status_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
