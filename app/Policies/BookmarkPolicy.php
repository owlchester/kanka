<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\User;
use App\Services\Permissions\EntityPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookmarkPolicy
{
    use HandlesAuthorization;

    public function browse(User $user, Bookmark $bookmark, Campaign $campaign): bool
    {
        return $user->can('admin', $campaign) || $this->checkPermission(Permission::Bookmarks->value, $user, $campaign);
    }

    public function view(User $user, Bookmark $bookmark): bool
    {
        return $user->can('admin', $bookmark->campaign) || $this->checkPermission(Permission::Bookmarks->value, $user, $bookmark->campaign);
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $user->can('admin', $campaign) || $this->checkPermission(Permission::Bookmarks->value, $user, $campaign);
    }

    public function update(User $user, Bookmark $bookmark): bool
    {
        return $this->view($user, $bookmark);
    }

    public function delete(User $user, Bookmark $bookmark): bool
    {
        return $this->view($user, $bookmark);
    }

    protected function checkPermission(int $action, User $user, ?Campaign $campaign = null): bool
    {
        return app(EntityPermission::class)->hasPermission(0, $action, null, $user, $campaign);
    }
}
