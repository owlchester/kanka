<?php

namespace App\Traits;

use App\Models\User;

/**
 * Trait for user aware services
 */
trait UserAware
{
    public User $user;

    public function user(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function userless(): self
    {
        // @phpstan-ignore-next-line
        unset($this->user);

        return $this;
    }

    public function hasUser(): bool
    {
        return isset($this->user);
    }
}
