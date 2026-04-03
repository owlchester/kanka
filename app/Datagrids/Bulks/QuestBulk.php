<?php

namespace App\Datagrids\Bulks;

class QuestBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'parent_id',
        'instigator_id',
        'date',
        'locations',
        'status_id',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];
}
