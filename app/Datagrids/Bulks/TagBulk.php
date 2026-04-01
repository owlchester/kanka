<?php

namespace App\Datagrids\Bulks;

class TagBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'colour_picker',
        'tag_id',
        'private_choice',
        'auto_applied_choice',
        'hide_choice',
        'tags',
        'entity_image',
        'entity_header',
    ];

    protected array $booleans = [
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];
}
