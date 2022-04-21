<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Plugin;
use App\Traits\AdminPolicyTrait;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization, AdminPolicyTrait;

    public function delete(User $user, Plugin $plugin)
    {
        return UserCache::user($user)->admin();
    }

    public function update(User $user, Plugin $plugin)
    {
        return UserCache::user($user)->admin() && $plugin->hasUpdate();
    }

    public function enable(User $user, Plugin $plugin)
    {
        return UserCache::user($user)->admin() && $plugin->isTheme() && !$plugin->pivot->is_active;
    }
    public function disable(User $user, Plugin $plugin)
    {
        return UserCache::user($user)->admin() && $plugin->isTheme() && $plugin->pivot->is_active;
    }

    public function import(User $user, Plugin $plugin)
    {
        return UserCache::user($user)->admin() && $plugin->isContentPack();
    }


}
