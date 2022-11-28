<?php

namespace App\Policies;

use App\User;
use App\Models\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.item');
    }
}
