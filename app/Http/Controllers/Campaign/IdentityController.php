<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\Services\Campaign\MemberService;

class IdentityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Switch to another member
     */
    public function switch(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('switch', [$campaignUser, $campaign]);

        if (Identity::campaign($campaign)->switch($campaignUser)) {
            return redirect()
                ->route('dashboard', [$campaign]);
        }
        return redirect()
            ->route('dashboard', [$campaign]);
    }

    /**
     * Switch to another member
     */
    public function switchEntity(Campaign $campaign, CampaignUser $campaignUser, Entity $entity = null)
    {
        $this->authorize('switch', [$campaignUser, $campaign]);

        if (Identity::campaign($campaign)->switch($campaignUser)) {
            return redirect()
                    ->to($entity->url());
        }
        return redirect()
            ->route('dashboard', [$campaign]);
    }

    /**
     * Switch back to the original user
     */
    public function back(Campaign $campaign)
    {
        if (Identity::back()) {
            return redirect()
                ->route('dashboard', [$campaign])
                ->with('success', __('campaigns.members.switch_back_success'));
        }
        return redirect()
            ->route('dashboard', [$campaign]);
    }
}
