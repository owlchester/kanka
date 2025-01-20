<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Facades\UserCache;
use App\Models\User;
use App\Facades\EntityPermission;
use App\Models\Campaign;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookmarkPolicy
{
    use HandlesAuthorization;

    public function browse(User $user): bool
    {
        return UserCache::user($user)->admin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    public function view(User $user): bool
    {
        return UserCache::user($user)->admin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    public function create(User $user): bool
    {
        return UserCache::user($user)->admin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    public function update(User $user): bool
    {
        return UserCache::user($user)->admin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    public function delete(User $user): bool
    {
        return UserCache::user($user)->admin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    protected function checkPermission(int $action, User $user, ?Campaign $campaign = null): bool
    {
        return EntityPermission::hasPermission(0, $action, $user, null, $campaign);
    }
}
