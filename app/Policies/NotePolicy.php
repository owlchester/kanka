<?php

namespace App\Policies;

use App\User;
use App\Models\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy extends MiscPolicy
{
    protected $model = 'note';
}
