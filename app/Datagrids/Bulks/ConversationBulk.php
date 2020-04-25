<?php


namespace App\Datagrids\Bulks;


class ConversationBulk extends Bulk
{
    public $bulkCopyToCampaign = false;

    protected $fields = [
        'name',
        'tags',
        'private_choice',
    ];
}
