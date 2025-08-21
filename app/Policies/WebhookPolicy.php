<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Webhook;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebhookPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function enable(User $user, Webhook $webhook): bool
    {
        return $user->isAdmin() && ! $webhook->isActive();
    }

    public function disable(User $user, Webhook $webhook): bool
    {
        return $user->isAdmin() && $webhook->isActive();
    }

    public function delete(User $user, Webhook $webhook): bool
    {
        return $user->isAdmin();
    }
}
