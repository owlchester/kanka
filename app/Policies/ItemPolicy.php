<?php

namespace App\Policies;

use App\User;
use App\Models\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy extends MiscPolicy
{
    protected $model = 'item';
}
