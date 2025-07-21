<?php

namespace App\Policies;

use Laravel\Passport\Token;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TokenPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {}

    public function update(User $user, Token $token): bool
    {
        return $token->user_id === $user->id;
    }
}
