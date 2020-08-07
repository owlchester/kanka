<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\CampaignUser;
use App\Http\Requests\StoreCampaignUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignUserController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('members', $campaign);
        return view('campaigns.users', ['campaign' => $campaign]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignUser  $campaignUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignUser $campaignUser)
    {
        $this->authorize('invite', $campaignUser->campaign);

        $campaignUser->delete();
        return redirect()->route('campaign_users.index');
    }
}
