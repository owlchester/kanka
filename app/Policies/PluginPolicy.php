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
        return $user->isAdmin();
    }

    public function update(User $user, Plugin $plugin): bool
    {
        return $user->isAdmin() && $plugin->hasUpdate();
    }

    public function changelog(User $user, Plugin $plugin): bool
    {
        return $user->isAdmin() && !$plugin->hasUpdate();
    }

    public function enable(User $user, Plugin $plugin): bool
    {
        // @phpstan-ignore-next-line
        return $user->isAdmin() && $plugin->isTheme() && !$plugin->pivot->is_active;
    }

    public function disable(User $user, Plugin $plugin): bool
    {
        // @phpstan-ignore-next-line
        return $user->isAdmin() && $plugin->isTheme() && $plugin->pivot->is_active;
    }

    public function import(User $user, Plugin $plugin): bool
    {
        return $user->isAdmin() && $plugin->isContentPack();
    }
}
