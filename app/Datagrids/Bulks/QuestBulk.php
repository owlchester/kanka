<?php


namespace App\Datagrids\Bulks;


class QuestBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'character_id',
        'completed_choice',
        'tags',
        'private_choice',
    ];

    protected $mappings = [
        'is_completed'
    ];
}
