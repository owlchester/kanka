<?php

namespace App\Datagrids\Bulks;

class ConversationBulk extends Bulk
{
    protected array $fields = [
        'name',
        'tags',
        'private_choice',
    ];
}
