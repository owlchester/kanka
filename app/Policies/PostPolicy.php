<?php

namespace App\Policies;

use App\Enums\Visibility;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function visibility(User $user, Post $post): bool
    {
        // If the post's visibility is set to admin, but the user is not an admin, don't allow changing
        // as it's a custom permission for the user to be able to edit this model.
        if (
            in_array($post->visibility_id, [Visibility::Admin, Visibility::AdminSelf])
            && !$user->isAdmin() && $post->created_by != $user->id
        ) {
            return false;
        } elseif ($post->visibility_id === Visibility::AdminSelf && $post->created_by !== $user->id) {
            // If the post has its visibility set to admin-self, but they didn't create it, they can't edit its visibility
            return false;
        }

        // In all other cases, a user who can edit the post can edit the visibility, probably.
        return true;
    }
}
