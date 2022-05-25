<?php

namespace App\Traits;

use App\User;

/**
 * Trait for user aware services
 */
trait UserAware
{
    /** @var User user model */
    public $user;

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
