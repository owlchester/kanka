<?php

namespace App\Datagrids\Bulks;

class TagBulk extends Bulk
{
    protected array $fields = [
        'name',
        'type',
        'colour',
        'parent_tag_id',
        'private_choice',
        'auto_applied_choice',
        'hide_choice',
    ];

    protected array $booleans = [
        'is_auto_applied',
        'is_hidden',
    ];
}
