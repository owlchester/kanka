<?php


namespace App\Datagrids\Bulks;


class RelationBulk extends Bulk
{
    protected $fields = [
        'owner_id',
        'target_id',
        'relation',
        'attitude',
        'colour_picker',
        'pinned_choice',
    ];
    protected $mappings = [
        'colour',
        'is_star',
    ];
}
