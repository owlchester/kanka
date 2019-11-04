<?php


namespace App\Datagrids\Bulks;


class DiceRollBulk extends Bulk
{
    protected $fields = [
        'name',
        'character_id',
        'tags',
        'private_choice',
    ];
}
