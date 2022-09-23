<?php

namespace App\Datagrids\Bulks;

class RelationBulk extends Bulk
{
    protected array $fields = [
        'owner_id',
        'target_id',
        'relation',
        'attitude',
        'colour_picker',
        'pinned_choice',
        'visibility_id',
        'update_mirrored',
        'unmirror',
    ];

    protected array $booleans = [
        'colour',
        'is_star',
    ];
}
