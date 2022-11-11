<?php

namespace App\Policies;

use App\User;
use App\Models\Family;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.family');
    }
}
