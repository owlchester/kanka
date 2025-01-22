<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Bookmark;
use App\Models\User;
use App\Facades\EntityPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookmarkPolicy
{
    use HandlesAuthorization;

    public function browse(?User $user, Bookmark $bookmark): bool
    {
        return $user->isAdmin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    public function view(User $user, Bookmark $bookmark): bool
    {
        return $user->isAdmin() || $this->checkPermission(Permission::Bookmarks->value, $user);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || EntityPermission::user($user)->hasPermission(0, Permission::Bookmarks->value);
    }

    public function update(User $user, Bookmark $bookmark): bool
    {
        return $this->view($user, $bookmark);
    }

    public function delete(User $user, Bookmark $bookmark): bool
    {
        return $this->view($user, $bookmark);
    }

    protected function checkPermission(int $action, User $user): bool
    {
        return EntityPermission::user($user)->hasPermission(0, $action);
    }
}
