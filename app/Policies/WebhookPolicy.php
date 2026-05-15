<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Webhook;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebhookPolicy
{
    use HandlesAuthorization;

    public function enable(User $user, Webhook $webhook): bool
    {
        return $user->can('admin', $webhook->campaign) && ! $webhook->isActive();
    }

    public function disable(User $user, Webhook $webhook): bool
    {
        return $user->can('admin', $webhook->campaign) && $webhook->isActive();
    }

    public function delete(User $user, Webhook $webhook): bool
    {
        return $user->can('admin', $webhook->campaign);
    }
}
