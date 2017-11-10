<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignUser;
use App\Services\CampaignService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InvitationController extends Controller
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
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join($token)
    {
        $campaign = Campaign::where('join_token', $token)->first();
        if (!empty($campaign) && !$campaign->member()) {

            $role = new CampaignUser([
                'user_id' => Auth::user()->id,
                'campaign_id' => $campaign->id,
                'role' => 'viewer'
            ]);
            $role->save();
            $campaign->newToken();

            CampaignService::switchCampaign($campaign->id);

            return redirect()->to('/');
        } else {
            return redirect()->to('/');
        }
    }
}
