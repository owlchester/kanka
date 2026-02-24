<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
// });

Broadcast::channel('whiteboard.{id}', function (User $user, $id) {
    $whiteboard = \App\Models\Whiteboard::withInvisible()->findOrFail($id);
    $entity = $whiteboard->entity()->withInvisible()->firstOrFail();

    \App\Facades\EntityPermission::campaign($entity->campaign);
    if ($user->can('member', $entity->campaign) && $user->can('view', $entity)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'image' => $user->hasAvatar() ? $user->getAvatarUrl() : null,
            'url' => route('users.profile', [$user]),
            'role' => $user->can('update', $entity) ? 'edit' : 'view',
        ];
    }

    return false;
});
