<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function template(?User $user, Post $post): bool
    {
        if ($post->exists === false) {
            return true;
        }
        return !$post->layout_id && $user && UserCache::user($user)->admin();
    }
}
