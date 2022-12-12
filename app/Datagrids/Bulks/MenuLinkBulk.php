<?php

namespace App\Datagrids\Bulks;

class MenuLinkBulk extends Bulk
{
    protected array $fields = [
        'name',
        'icon',
        //'position',
        'private_choice',
        'is_active',
    ];
}
