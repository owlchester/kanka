<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignUser;
use App\Models\Entity;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

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
     *
     * @return RedirectResponse
     *
     * @throws AuthorizationException
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
     *
     * @return RedirectResponse
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
