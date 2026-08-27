<?php

namespace App\Policies;

use App\Models\EntityClaim;
use App\Models\PlayerSession;
use App\Models\User;

class PlayerSessionPolicy
{
    public function create(User $user, EntityClaim $claim): bool
    {
        return $claim->user_id === $user->id && $claim->unclaimed_at === null;
    }

    public function view(User $user, PlayerSession $session): bool
    {
        return $session->created_by === $user->id;
    }

    public function update(User $user, PlayerSession $session): bool
    {
        return $session->created_by === $user->id;
    }

    public function delete(User $user, PlayerSession $session): bool
    {
        return $session->created_by === $user->id;
    }
}
