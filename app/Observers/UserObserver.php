<?php

namespace App\Observers;

use App\Campaign;
use App\Services\ImageService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class UserObserver
{
    /**
     * @param User $user
     */
    public function saving(User $user)
    {
        // Setting a new password
        $new = request()->post('password_new');
        if (!empty($new)) {
            $user->password = Hash::make(request()->post('password_new'));
        }

        // Uploading an avatar
        if (request()->has('avatar')) {
            $path = request()->file('avatar')->store('profiles', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $user->getOriginal('avatar');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
                $user->avatar = $path;
            }
        }
    }

    /**
     * @param User $user
     */
    public function saved(User $user)
    {
    }

    /**
     * @param User $user
     */
    public function created(User $user)
    {
    }

    /**
     * @param User $user
     */
    public function deleted(User $user)
    {
        if (!empty($user->image)) {
            // Delete
            Storage::disk('public')->delete($user->image);
        }
    }

    /**
     * @param User $user
     */
    public function deleting(User $user)
    {
    }
}
