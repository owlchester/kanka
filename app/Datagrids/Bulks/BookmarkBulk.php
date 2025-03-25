<?php

namespace App\Datagrids\Bulks;

class BookmarkBulk extends Bulk
{
    protected array $fields = [
        'name',
        'icon',
        // 'position',
        'private_choice',
        'is_active',
    ];
}
