<?php

namespace App\Policies;

use App\User;
use App\Models\Journal;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy extends MiscPolicy
{
    protected $model = 'journal';
}
