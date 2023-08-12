<?php

namespace App\Traits;

use App\User;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Trait for user aware services
 */
trait UserAware
{
    public Authenticatable|User|null $user;

    public function user(Authenticatable|User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function hasUser(): bool
    {
        return !empty($this->user);
    }
}
