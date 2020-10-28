<?php

namespace App\Observers;

use App\Facades\UserCache;
use App\Jobs\Emails\GoodbyeEmailJob;
use App\Jobs\Emails\WelcomeEmailJob;
use App\Models\CampaignUser;
use App\Models\UserLog;
use App\Services\ImageService;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

        // Handle image. Let's use a service for this.
        ImageService::handle($user, $user->getTable(), 60, 'avatar');
    }

    /**
     * @param User $user
     */
    public function saved(User $user)
    {
        UserCache::user($user)->clearName();
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

    public function creating(User $user)
    {
        $user->locale = LaravelLocalization::getCurrentLocale();
    }

    /**
     * @param User $user
     */
    public function created(User $user)
    {
        WelcomeEmailJob::dispatch($user, app()->getLocale());
        session()->put('user_registered', true);
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
        //GoodbyeEmailJob::dispatch($user, app()->getLocale());

        UserCache::user($user)->clearName()->clearCampaigns()->clearRoles();
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
    }
}
