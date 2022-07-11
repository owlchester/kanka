<?php

namespace App\Datagrids\Bulks;

class MenuLinkBulk extends Bulk
{
    protected array $fields = [
        'name',
        //'position',
        'private_choice',
    ];
}
