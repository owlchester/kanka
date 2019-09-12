<?php

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy extends MiscPolicy
{
    protected $model = 'tag';
}
