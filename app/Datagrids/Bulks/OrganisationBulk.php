<?php

namespace App\Datagrids\Bulks;

class OrganisationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'locations',
        'status_id',
        'parent_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
