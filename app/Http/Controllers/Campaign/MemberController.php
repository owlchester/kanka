<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Facades\Identity;
use App\Http\Controllers\Controller;
use App\Models\CampaignUser;
use Illuminate\Support\Facades\Auth;

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
     * Switch to a member of the campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switch(CampaignUser $campaignUser)
    {
        $this->authorize('switch', $campaignUser);

        if (Identity::switch($campaignUser)) {
            return redirect()
                ->route('dashboard')
                ->with('success', __('campaigns.members.switch_success'));
        }
        return redirect()
            ->route('dashboard');
    }

    /**
     * Switch back to the original user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back()
    {
        if (Identity::back()) {
            return redirect()
                ->route('dashboard')
                ->with('success', __('campaigns.members.switch_back_success'));
        }
        return redirect()
            ->route('dashboard');
    }
}
