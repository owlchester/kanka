<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookmarkPolicy
{
    use HandlesAuthorization;

    public function browse(User $user)
    {
        return UserCache::user($user)->admin();
    }

    public function view(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function create(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function update(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function delete(User $user): bool
    {
        return UserCache::user($user)->admin();
    }
}
