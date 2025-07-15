<?php

namespace App\Policies;

use Laravel\Passport\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {}

    public function update(User $user, Client $client): bool
    {
        return $client->user_id === $user->id;
    }
}
