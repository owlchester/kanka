<?php

namespace App\Policies;

class JournalPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.journal');
    }
}
