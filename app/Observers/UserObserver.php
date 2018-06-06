<?php

namespace App\Observers;

use App\Campaign;
use App\CampaignUser;
use App\Mail\UserDeleted;
use App\Mail\UserRegistered;
use App\Mail\WelcomeEmail;
use App\Models\UserDashboardSetting;
use App\Models\UserLog;
use App\Services\ImageService;
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

        // Handle image. Let's use a service for this.
        ImageService::handle($user, $user->getTable(), 60, 'avatar');
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
        // If the user has an avatar, delete it from the disk to free up some space.
        if (!empty($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Send notification that an account has been removed
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
