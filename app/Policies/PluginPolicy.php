<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Plugin;
use App\Traits\AdminPolicyTrait;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function delete(User $user): bool
    {
        return UserCache::user($user)->admin();
    }

    public function update(User $user, Plugin $plugin): bool
    {
        return UserCache::user($user)->admin() && $plugin->hasUpdate();
    }

    public function changelog(User $user, Plugin $plugin): bool
    {
        return UserCache::user($user)->admin() && !$plugin->hasUpdate();
    }

    public function enable(User $user, Plugin $plugin): bool
    {
        // @phpstan-ignore-next-line
        return UserCache::user($user)->admin() && $plugin->isTheme() && !$plugin->pivot->is_active;
    }

    public function disable(User $user, Plugin $plugin): bool
    {
        // @phpstan-ignore-next-line
        return UserCache::user($user)->admin() && $plugin->isTheme() && $plugin->pivot->is_active;
    }

    public function import(User $user, Plugin $plugin): bool
    {
        return UserCache::user($user)->admin() && $plugin->isContentPack();
    }
}
