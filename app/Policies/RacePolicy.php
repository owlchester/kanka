<?php

namespace App\Policies;

use App\User;
use App\Models\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class RacePolicy extends MiscPolicy
{
    protected $model = 'race';
}
