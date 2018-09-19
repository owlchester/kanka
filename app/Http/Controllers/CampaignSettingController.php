<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Illuminate\Http\Request;

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
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        return view('campaigns.settings', compact('campaign'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('setting', $campaign);

        $campaign->setting->update($request->all());

        return redirect()->route('campaign_settings')
            ->with('success', trans('campaigns.settings.edit.success'));
    }
}
