<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Services\CampaignService;
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
            $campaign->users()->attach(Auth::user()->id, ['role' => 'member']);
            $campaign->newToken();

            CampaignService::switchCampaign($campaign->id);

            return redirect()->to('/home');
        } else {
            return redirect()->to('/home');
        }
    }
}
