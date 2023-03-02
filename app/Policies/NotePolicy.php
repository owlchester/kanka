<?php

namespace App\Policies;

class NotePolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.note');
    }
}
