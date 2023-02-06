<?php

namespace App\Policies;

class FamilyPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.family');
    }
}
