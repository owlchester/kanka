<?php

namespace App\Observers;

use App\Campaign;
use App\CampaignUser;
use App\Mail\UserDeleted;
use App\Mail\UserRegistered;
use App\Mail\WelcomeEmail;
use App\Models\UserDashboardSetting;
use App\Models\UserLog;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

    public function updated(User $user)
    {
        $log = UserLog::create([
            'user_id' => $user->id,
            'action' => 'update',
            'ip' => request()->ip()
        ]);
        $log->save();
    }

    /**
     * @param User $user
     */
    public function created(User $user)
    {
        // Create dashboard settings
        $dashboard = new UserDashboardSetting();
        $dashboard->user_id = $user->id;
        $dashboard->save();

        // New user, send notification
        Mail::to('hello@kanka.io')->send(new UserRegistered($user));

        // Send email to the new user too
        Mail::to($user->email)->send(new WelcomeEmail($user));
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

        // New user, send notification
        Mail::to('hello@kanka.io')->send(new UserDeleted($user));
    }

    /**
     * @param User $user
     */
    public function deleting(User $user)
    {
        // Campaign user
        $members = CampaignUser::where('user_id', $user->id)->with('campaign')->get();
        foreach ($members as $member) {
            $member->delete();

            if ($member->campaign->members()->count() == 0) {
                $member->campaign->delete();
            }
        }

        // Remove logs
        foreach ($user->logs as $log) {
            $log->delete();
        }

        // Remove dashboard
        $user->dashboardSetting->delete();
    }
}
