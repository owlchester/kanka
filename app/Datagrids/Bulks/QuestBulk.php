<?php


namespace App\Datagrids\Bulks;


class QuestBulk extends Bulk
{
    protected $fields = [
        'name',
        'type',
        'character_id',
        'location_id',
        'completed_choice',
        'tags',
        'private_choice',
    ];
}
