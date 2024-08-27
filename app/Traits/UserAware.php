<?php

namespace App\Traits;

use App\Models\User;

/**
 * Trait for user aware services
 */
trait UserAware
{
    /**  */
    public User|null $user;

    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function hasUser(): bool
    {
        return !empty($this->user);
    }
}
