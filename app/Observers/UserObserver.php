<?php

namespace App\Observers;

use App\Facades\UserCache;
use App\Jobs\Emails\GoodbyeEmailJob;
use App\Jobs\Emails\WelcomeEmailJob;
use App\Models\CampaignUser;
use App\Models\CampaignFollower;
use App\Models\UserLog;
use App\Services\ImageService;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserObserver
{
    use PurifiableTrait;

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

        // Purify the bio
        if (!empty($user->profile['bio'])) {
            $profile = $user->profile;
            $profile['bio'] = substr(strip_tags($profile['bio']), 0, 301);
            $user->profile = $profile;
        }

        // Handle image. Let's use a service for this.
        if ($user->id) {
            $folderno = floor($user->id / 1000);
            ImageService::handle($user, $user->getTable() . '/' . $folderno, 60, 'avatar');
        }
    }

    /**
     * @param User $user
     */
    public function saved(User $user)
    {
        // Only clear the cache if the name changed
        if ($user->isDirty('name')) {
            UserCache::user($user)->clearName();
        }
    }

    /**
     * @param User $user
     */
    public function updated(User $user)
    {

    }

    public function creating(User $user)
    {
        $user->locale = LaravelLocalization::getCurrentLocale();
        if (session()->has('tracking')) {
            $user->settings = ['tracking' => session()->get('tracking')];
            session()->remove('tracking');
        }
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
            ImageService::cleanup($user, 'avatar');
        }

        UserCache::user($user)
            ->clearName()
            ->clearCampaigns()
            ->clearRoles()
        ;
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

            // Delete a campaign if no one is left in it
            if ($member->campaign->members()->count() == 0) {
                $member->campaign->delete();
            }
        }
        $followers = CampaignFollower::where('user_id', $user->id)->with('campaign')->get();
        foreach ($followers as $follower) {
            $follower->delete();
        }
    }
}
