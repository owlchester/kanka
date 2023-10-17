<?php

namespace App\Datagrids\Bulks;

class QuestBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'quest_id',
        'instigator_id',
        'completed_choice',
        'tags',
        'private_choice',
    ];

    protected array $booleans = [
        'is_completed'
    ];
}
