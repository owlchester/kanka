<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Models\Entity;

class MemberController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function switch(Campaign $campaign, CampaignUser $campaignUser, ?Entity $entity = null)
    {
        $this->authorize('switch', $campaignUser);

        if (Identity::campaign($campaign)->switch($campaignUser)) {
            if ($entity) {
                return redirect()
                    ->to($entity->url());
            }
            return redirect()
                ->route('dashboard', $campaign);
        }
        return redirect()
            ->route('dashboard', $campaign);
    }

    /**
     * Switch back to the original user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back(Campaign $campaign)
    {
        if (Identity::back()) {
            return redirect()
                ->route('dashboard', $campaign)
                ->with('success', __('campaigns.members.switch_back_success'));
        }
        return redirect()
            ->route('dashboard', $campaign);
    }

    public function delete(Campaign $campaign, CampaignUser $campaignUser)
    {
        $this->authorize('delete', $campaignUser);

        return view('campaigns.members.delete', $campaign)
            ->with('campaign', $campaign)
            ->with('campaignUser', $campaignUser);
    }
}
