<?php

namespace App\Datagrids\Bulks;

class QuestBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'quest_id',
        'instigator_id',
        'location_id',
        'completed_choice',
        'tags',
        'private_choice',
        'entity_image',
        'entity_header',
    ];

    protected array $booleans = [
        'is_completed'
    ];
}
