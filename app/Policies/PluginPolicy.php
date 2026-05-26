<?php

namespace App\Policies;

use App\Facades\CampaignLocalization;
use App\Models\Plugin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization;

    public function delete(User $user): bool
    {
        $campaign = CampaignLocalization::getCampaign();

        return $user->can('admin', $campaign);
    }

    public function update(User $user, Plugin $plugin): bool
    {
        $campaign = CampaignLocalization::getCampaign();

        return $user->can('admin', $campaign) && $plugin->hasUpdate($plugin->created_by === $user->id);
    }

    public function changelog(User $user, Plugin $plugin): bool
    {
        $campaign = CampaignLocalization::getCampaign();

        return $user->can('admin', $campaign) && ! $plugin->hasUpdate($plugin->created_by === $user->id);
    }

    public function enable(User $user, Plugin $plugin): bool
    {
        $campaign = CampaignLocalization::getCampaign();

        // @phpstan-ignore-next-line
        return $user->can('admin', $campaign) && $plugin->isTheme() && ! $plugin->pivot->is_active;
    }

    public function disable(User $user, Plugin $plugin): bool
    {
        $campaign = CampaignLocalization::getCampaign();

        // @phpstan-ignore-next-line
        return $user->can('admin', $campaign) && $plugin->isTheme() && $plugin->pivot->is_active;
    }

    public function import(User $user, Plugin $plugin): bool
    {
        $campaign = CampaignLocalization::getCampaign();

        return $user->can('admin', $campaign) && $plugin->isContentPack();
    }
}
