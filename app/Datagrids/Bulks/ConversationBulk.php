<?php


namespace App\Datagrids\Bulks;


class ConversationBulk extends Bulk
{
    protected $fields = [
        'name',
        'tags',
        'private_choice',
    ];
}
