<?php

namespace App\Services\Users;

use App\Facades\Images;
use App\Facades\UserCache;
use App\Jobs\Users\UnsubscribeUser;
use App\Models\CampaignFollower;
use App\Models\CampaignUser;
use App\Models\CommunityEventEntry;
use App\Models\Feature;
use App\Services\Campaign\SearchCleanupService;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Log;

class CleanupService
{
    use UserAware;

    public function delete(): self
    {
        $this
            ->removeCampaigns()
            ->removeFollows()
            ->removeFeatureRequests()
            ->removeWorldbuilding()
            ->removeAvatar()
            ->cleanCache()
            ->removeNewsletter();

        return $this;
    }

    protected function removeCampaigns(): self
    {
        // Log::info('Services/Users/CleanupService', ['deleting', ['user' => $this->user->id]]);

        $members = CampaignUser::where('user_id', $this->user->id)
            ->with(['campaign', 'campaign.members'])
            ->has('campaign')
            ->get();
        foreach ($members as $member) {
            $member->delete();

            // Delete a campaign if no one is left in it. Since we did the "with", it's cached, hence checking on 1
            if ($member->campaign->members->count() <= 1) {
                SearchCleanupService::cleanup($member->campaign);
                Images::cleanup($member->campaign);
                $member->campaign->forceDelete();
            }
        }

        return $this;
    }

    protected function removeFollows(): self
    {
        $followers = CampaignFollower::where('user_id', $this->user->id)->with('campaign')->get();
        foreach ($followers as $follower) {
            // Log::info('Removing follower', ['follower' => $follower->id]);
            $follower->delete();
        }

        return $this;
    }

    protected function removeFeatureRequests(): self
    {
        Feature::where('created_by', $this->user->id)->where('upvote_count', '<', 10)->where('status_id', \App\Enums\FeatureStatus::Approved)->delete();

        return $this;
    }

    protected function removeWorldbuilding(): self
    {
        CommunityEventEntry::where('created_by', $this->user->id)->delete();

        return $this;
    }

    protected function removeAvatar(): self
    {
        if ($this->user->hasAvatar()) {
            Images::cleanup($this->user, 'avatar');
        }

        return $this;
    }

    protected function cleanCache(): self
    {
        UserCache::user($this->user)
            ->clearName()
            ->clear();

        return $this;
    }

    protected function removeNewsletter(): self
    {
        // If the user was subscribed to the newsletter, unsubscribe them
        if (app()->isProduction() && ! empty($this->user->hasNewsletter())) {
            UnsubscribeUser::dispatch($this->user->email);
        }

        return $this;
    }
}
