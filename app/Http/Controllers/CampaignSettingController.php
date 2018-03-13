<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests\StoreCampaignInvite;
use App\Models\CampaignInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.owner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        $campaign->setting->update($request->all());

        return redirect()->route('campaigns.index', ['#setting'])
            ->with('success', trans('campaigns.settings.edit.success'));
    }
}
