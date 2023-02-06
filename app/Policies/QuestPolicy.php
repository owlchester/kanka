<?php

namespace App\Policies;

class QuestPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.quest');
    }
}
